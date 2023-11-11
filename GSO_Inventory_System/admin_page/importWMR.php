<?php

// Include the PhpSpreadsheet library
require './../vendor/autoload.php';

use PhpOffice\PhpSpreadsheet\IOFactory;

// Create a connection to your database
$db_host = "localhost";
$db_username = "root";
$db_password = "";
$db_name = "db_gso";
$mysqli = new mysqli($db_host, $db_username, $db_password, $db_name);

if ($mysqli->connect_error) {
    die("Connection failed: " . $mysqli->connect_error);
}

if (isset($_POST['importWMR'])) {

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
        echo '<button class="ok-button" onclick="redirectToPage(\'WMR.php\')">OK</button>';
        echo '</div>';
        echo '</div>';
    }

    // Check if a file was uploaded
    if (isset($_FILES['file']['tmp_name']) && !empty($_FILES['file']['tmp_name'])) {
        $file_name = $_FILES['file']['name'];
        $file_tmp = $_FILES['file']['tmp_name'];

        // Validate file format (you can add more checks here)
        $file_ext = strtolower(pathinfo($file_name, PATHINFO_EXTENSION));
        if ($file_ext === 'xlsx' || $file_ext === 'xls') {
            // Specify the directory where you want to save the file
            $uploadDirectory = './uploads/WMR/'; // You can change this path

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
                    'type',
                    'dateReturnedRecorded',
                    'ItemNo',
                    'prsNumber',
                    'article',
                    'brand',
                    'serialnumber',
                    'particulars',
                    'areNumber',
                    'engasNumber',
                    'acquisitionDate',
                    'acquisitionCost',
                    'propertyNumber',
                    'classification',
                    'estLife',
                    'unitOfMeasure',
                    'unitValue',
                    'balancePerCard',
                    'responsibilityCenter',
                    'accountableEmployee',
                    'remarks',
                    'withAttachment',
                    'withCoverPage',
                    'iirup',
                    'iirupDate'
                ];

                // Adjust this variable to match the number of columns
                $numColumns = 25; // Columns A to Y

                // Create a placeholders string for the SQL query
                $placeholders = str_repeat("?,", $numColumns - 1) . "?";

                // Create a type string for bind_param
                $typeString = str_repeat("s", $numColumns);

                $sql = "INSERT INTO prs_properties (";
                $sql .= implode(', ', $columnNames); // Include column names
                $sql .= ") VALUES ($placeholders)";

                // Set the batch size
                $batchSize = 100; // You can adjust this based on your needs
                $totalRows = $worksheet->getHighestRow();

                // Process the data in batches
                for ($startRow = 8; $startRow <= $totalRows; $startRow += $batchSize) {
                    $endRow = min($startRow + $batchSize - 1, $totalRows);

                    // Create a new statement for each batch
                    $stmt = $mysqli->prepare($sql);

                    if ($stmt) {
                        for ($currentRow = $startRow; $currentRow <= $endRow; $currentRow++) {
                            // Get all cells in the current row
                            $row = $worksheet->rangeToArray("A$currentRow:Y$currentRow")[0];

                            // Process data for columns A to Y
                            $data = [];
                            $types = '';
                            $columnCounter = 0;
                            $isEmptyRow = true;

                            foreach ($row as $cellValue) {
                                if ($columnCounter >= $numColumns) {
                                    break; // Stop processing cells after column W
                                }

                                // Check if the cell contains a date in "mm/dd/yyyy" format
                                $datePattern = "/^(0[1-9]|1[0-2])\/(0[1-9]|[12][0-9]|3[01])\/\d{4}$/";
                                if (preg_match($datePattern, $cellValue)) {
                                    // Convert the date to a timestamp
                                    $timestamp = strtotime($cellValue);
                                    if ($timestamp !== false) {
                                        // Format the timestamp as "Y-m-d" for MySQL
                                        $formattedDate = date("Y-m-d", $timestamp);
                                        $data[] = $formattedDate;
                                    } else {
                                        $data[] = null; // Invalid date, set it as null in the database
                                    }
                                } else {
                                    $data[] = $cellValue;
                                }

                                $types .= 's'; // Assuming all data is treated as strings
                                $columnCounter++;

                                // Check if the cell is not empty
                                if (!empty($cellValue)) {
                                    $isEmptyRow = false;
                                }
                            }

                            if ($isEmptyRow) {
                                // If the row is empty, stop processing
                                break;
                            }

                            if ($columnCounter === $numColumns) {
                                $stmt->bind_param($types, ...$data);
                                $stmt->execute();

                                // After inserting data, save null values in modeofdisposaltable fields and updatesorcurrentstatus fields
                                $lastInsertID = $stmt->insert_id;

                                // Insert null values into the associated tables
                                $modeofdisposalSQL = "INSERT INTO modeofdisposaltable (
                                    prsID,
                                    modeofdisposal,
                                    dateOfSale,
                                    ORDateNegotiation,
                                    ORNumberNegotiation,
                                    amountNegotiation,
                                    notesNegotiation,
                                    dateOfAuction,
                                    ORDateAuction,
                                    ORNumberAuction,
                                    amountAuction,
                                    notesAuction,
                                    transferDateWithoutCost,
                                    recipientTransferred,
                                    notesTransferred,
                                    transferDateContinued,
                                    recipientContinued,
                                    notesContinued,
                                    partDestroyedOrThrown,
                                    notesDestroyed
                                ) VALUES (?, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL)";
                                $updatesorcurrentstatusSQL = "INSERT INTO updatesorcurrentstatus (
                                    prsID,
                                    currentStatus,
                                    jevNo,
                                    dateDropped,
                                    actionsToBeTakenDropped,
                                    actionsToBeTakenExisting
                                ) VALUES (?, NULL, NULL, NULL, NULL, NULL)";

                                // Prepare and execute the statements
                                $modeofdisposalStmt = $mysqli->prepare($modeofdisposalSQL);
                                $updatesorcurrentstatusStmt = $mysqli->prepare($updatesorcurrentstatusSQL);

                                if ($modeofdisposalStmt && $updatesorcurrentstatusStmt) {
                                    $modeofdisposalStmt->bind_param('i', $lastInsertID);
                                    $updatesorcurrentstatusStmt->bind_param('i', $lastInsertID);

                                    $modeofdisposalStmt->execute();
                                    $updatesorcurrentstatusStmt->execute();

                                    $modeofdisposalStmt->close();
                                    $updatesorcurrentstatusStmt->close();
                                }
                            }
                        }
                        // Close the statement to free up resources
                        $stmt->close();
                        
                    } else {
                        echo 'Error in preparing the SQL statement: ' . $mysqli->error;
                    }
                }

                // Close the database connection
                $mysqli->close();

            
                //Show a modal dialog with the messsage and redirect to WMR.php
                displayModalWithRedirect("Data is imported successfully.", "WMR.php");
                
                // Success message and redirect to "WMR.php"
                /*echo '<script>alert("Data imported successfully."); window.location.href = "WMR.php";</script>';*/
            } else {
                // Error moving the file
                displayModalWithRedirect("Error saving the uploaded file.", "WMR.php");
                /*echo '<script>alert("Error saving the uploaded file."); window.location.href = "WMR.php";</script>';*/
            }
        } else {
            
            displayModalWithRedirect("Invalid file format. Please upload an Excel file (xlsx or xls).", "WMR.php");
            /*echo '<script>alert("Invalid file format. Please upload an Excel file (xlsx or xls)."); window.location.href = "WMR.php";</script>';*/
        }
    } else {
        displayModalWithRedirect("Please choose a file to upload.", "WMR.php");
        /*echo '<script>alert("Please choose a file to upload."); window.location.href = "WMR.php";</script>';*/
    }
}
// JavaScript function to redirect to a page
echo '<script type="text/javascript">
    function redirectToPage(page) {
        window.location.href = page;
    }
</script>';
?>