<?php
// Include the PhpSpreadsheet library
require './../vendor/autoload.php';

use PhpOffice\PhpSpreadsheet\IOFactory;

// Include the database connection
$db_host = "localhost";
$db_username = "root";
$db_password = "";
$db_name = "db_gso";

$mysqli = new mysqli($db_host, $db_username, $db_password, $db_name);

if (isset($_POST['importClearance'])) {
    // Function to display a modal dialog with a message and then redirect
    function displayModalWithRedirect($message, $redirectPage) {
        echo '<style>
              /* Style the modal background */
              .modal-background {
                display: none;
                position: fixed;
                top: 0;
                left: 0;
                width: 100%;
                height: 100%;
                background: rgba(0, 0, 0, 0.5); /* Semi-transparent black background */
                z-index: 1;
                display: flex;
                align-items: center;
                justify-content: center;
              }

              /* Style the modal content for both modals */
              .modal-content {
                background-color: #ffffff; /* White background */
                color: black;
                padding: 20px;
                border-radius: 5px;
                text-align: center;
                z-index: 2;
                position: absolute;
                top: 50%;
                left: 50%;
                transform: translate(-50%, -50%);
              }

              /* Style the OK button */
              .ok-button {
                background-color: #0074E4; /* Blue background color for OK button */
                color: white;
                padding: 10px 20px;
                border: none;
                border-radius: 5px;
                cursor: pointer;
                margin-top: 10px; /* Add margin to separate the message and the button */
              }
            </style>';

        echo '<div class="modal-background">';
        echo '<div class="modal-content">';
        echo '<div class="modal-message">' . $message . '</div>';
        echo '<button class="ok-button" onclick="redirectToPage(\'' . $redirectPage . '\')">OK</button>';
        echo '</div>';
        echo '</div>';
    }

    // Function to check if an employee exists in the database
    function doesEmployeeExist($employeeName, $mysqli) {
        $checkQuery = "SELECT COUNT(*) as count FROM employees WHERE employeeName = ?";
        if ($stmt = $mysqli->prepare($checkQuery)) {
            $stmt->bind_param("s", $employeeName);
            $stmt->execute();
            $stmt->bind_result($count);
            $stmt->fetch();
            $stmt->close();
            return $count > 0;
        }
        return false;
    }

    // Check if a file was uploaded
    if (isset($_FILES['file']['tmp_name']) && !empty($_FILES['file']['tmp_name'])) {
        $file_name = $_FILES['file']['name'];
        $file_tmp = $_FILES['file']['tmp_name'];

        // Validate file format (you can add more checks here)
        $file_ext = strtolower(pathinfo($file_name, PATHINFO_EXTENSION));
        if ($file_ext === 'xlsx' || $file_ext === 'xls') {
            // Specify the directory where you want to save the file
            $uploadDirectory = './uploads/Clearance'; // You can change this path

            // Check if the directory exists; if not, create it
            if (!file_exists($uploadDirectory)) {
                mkdir($uploadDirectory, 0777, true);
            }

            // Generate a unique file name to avoid overwriting existing files
            $uniqueFileName = uniqid() . '_' . $file_name;

            // Move the uploaded file to the specified directory
            $destinationPath = $uploadDirectory . $uniqueFileName;

            if (move_uploaded_file($file_tmp, $destinationPath)) {
                // File moved successfully
                // Load the Excel file using PhpSpreadsheet
                $spreadsheet = IOFactory::load($destinationPath);
                $worksheet = $spreadsheet->getActiveSheet();

                // Define the column names and data types based on your database schema
                $columnNames = [
                    'dateCleared',
                    'controlNo',
                    'scannedCopy',
                    'employeeName',
                    'position',
                    'classification',
                    'responsibilityCenter',
                    'purpose',
                    'effectivityDate',
                    'remarks',
                    'clearedBy'
                ];
                $numColumns = 11; // Columns A to K

                // Create placeholders string for the SQL query
                $placeholders = str_repeat("?, ", $numColumns - 1) . "?";

                // Create a type string for bind-param
                $typeString = str_repeat("s", $numColumns);

                $sql = "INSERT INTO clearance (";
                $sql .= implode(', ', $columnNames); // Include column names
                $sql .= ") VALUES ($placeholders)";

                // Prepare the SQL statement
                if ($stmt = $mysqli->prepare($sql)) {
                    // The statement is prepared successfully

                    // Create an array to store the values from the Excel file
                    $data = [];

                    // Iterate through the rows in the worksheet starting from row 8
                    $startRow = 8; // Adjust as needed
                    $highestRow = $worksheet->getHighestRow();

                    // Iterate through the rows in the worksheet starting from row 8
                    for ($row = $startRow; $row <= $highestRow; $row++) {
                        $rowData = [];

                        $employeeName = $worksheet->getCell('D' . $row)->getValue();
                        $classification = $worksheet->getCell('F' . $row)->getValue();
                        $content = $worksheet->getCell('G' . $row)->getValue();

                        // Check if the employee name exists, and if not, insert it
                        if (!empty($employeeName) && !doesEmployeeExist($employeeName, $mysqli)) {
                            // Insert the employee name
                            $insertEmployeeSQL = "INSERT INTO employees (employeeName) VALUES (?)";
                            if ($insertStmt = $mysqli->prepare($insertEmployeeSQL)) {
                                $insertStmt->bind_param("s", $employeeName);
                                $insertStmt->execute();
                                $insertStmt->close();
                            }
                        }

                        // Set a default value for 'classification' if it is null or empty
                        if (empty($classification)) {
                            $classification = null; // You can change this default value
                        }

                        if (($classification === "City Office" || $classification === "National Office") && !empty($content)) {
                            // Update the office field for this employee
                            $updateEmployeeSQL = "UPDATE employees SET office = ? WHERE employeeName = ?";
                            if ($updateStmt = $mysqli->prepare($updateEmployeeSQL)) {
                                $updateStmt->bind_param("ss", $content, $employeeName);
                                $updateStmt->execute();
                                $updateStmt->close();
                            }
                        }

                        // Retrieve and format the date from column A (mm/dd/yyyy to Y-m-d)
                        $rawDate = $worksheet->getCell('A' . $row)->getFormattedValue();
                        if (!empty($rawDate)) {
                            $dateCleared = DateTime::createFromFormat('m/d/Y', $rawDate);
                            $dateClearedFormatted = $dateCleared ? $dateCleared->format('Y-m-d') : null;
                        } else {
                            $dateClearedFormatted = null; // If the date cell is empty, set it as null
                        }

                        $rowData[] = $dateClearedFormatted;
                        $rowData[] = $worksheet->getCell('B' . $row)->getValue();
                        $rowData[] = $worksheet->getCell('C' . $row)->getValue();
                        $rowData[] = $employeeName;
                        $rowData[] = $worksheet->getCell('E' . $row)->getValue();
                        $rowData[] = $classification;
                        $rowData[] = $content;
                        $rowData[] = $worksheet->getCell('H' . $row)->getValue();
                        $rowData[] = $worksheet->getCell('I' . $row)->getValue();
                        $rowData[] = $worksheet->getCell('J' . $row)->getValue();
                        $rowData[] = $worksheet->getCell('K' . $row)->getValue();

                        $data[] = $rowData;
                    }

                    // Bind parameters and execute the query for each row
                    foreach ($data as $row) {
                        $stmt->bind_param($typeString, ...$row);

                        if ($stmt->execute()) {
                            // Data inserted successfully
                        } else {
                            // Handle the case where an insertion fails
                            displayModalWithRedirect("Error inserting data into the database.", "clearance.php");
                            // You may also log or display specific error details for debugging.
                        }
                    }

                    // Close the prepared statement
                    $stmt->close();

                    // Show a modal dialog with the message and redirect to clearance.php
                    displayModalWithRedirect("Data is imported successfully.", "clearance.php");
                } else {
                    // Handle the case where the SQL statement couldn't be prepared
                    displayModalWithRedirect("Error preparing the SQL statement.", "clearance.php");
                }
            } else {
                // Error moving the file
                displayModalWithRedirect("Error saving the uploaded file.", "clearance.php");
            }
        } else {
            displayModalWithRedirect("Invalid file format. Please upload an Excel file (xlsx or xls).", "clearance.php");
        }
    } else {
        displayModalWithRedirect("Please choose a file to upload.", "clearance.php");
    }
}

// JavaScript function to redirect to a page
echo '<script type="text/javascript">
    function redirectToPage(page) {
        window.location.href = page;
    }
</script>';
?>