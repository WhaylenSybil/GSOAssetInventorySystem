<?php

// Include the database connection
$db_host = "localhost";
$db_username = "root";
$db_password = "";
$db_name = "db_gso";

$mysqli = new mysqli($db_host, $db_username, $db_password, $db_name);

// Include the PhpSpreadsheet library
require './../vendor/autoload.php';

use PhpOffice\PhpSpreadsheet\IOFactory;

if (isset($_POST['import_ics'])) {

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
        echo '<button class="ok-button" onclick="redirectToPage(\'active_semi_expendable.php\')">OK</button>';
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
            $uploadDirectory = './uploads/'; // You can change this path

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
                    'date_returned',
                    'article',
                    'brand',
                    'serialno',
                    'particulars',
                    'PRS_WMR_no',
                    'eNGAS',
                    'acquisitiondate',
                    'acquisitioncost',
                    'propertyno',
                    'classification_id',
                    'estimatedlife',
                    'unitofmeasure',
                    'unitvalue',
                    'balance_per_card',
                    'onhand_per_count',
                    'so_qty',
                    'so_value',
                    'responsibilitycenter_id',
                    'accountable_person',
                    'previouscondition',
                    'location',
                    'currentcondition',
                    'date_of_physical_inventory',
                    'remarks',
                    'supplier',
                    'PO_no',
                    'AIR_RIS_no',
                    'notes',
                    'jevno'
                ];

                // Adjust this variable to match the number of columns
                $numColumns = count($columnNames);

                // Create a placeholders string for the SQL query
                $placeholders = str_repeat("?,", $numColumns - 1) . "?";

                // Create a type string for bind_param
                $typeString = str_repeat("s", $numColumns);

                $sql = "INSERT INTO ics_properties (";
                $sql .= implode(', ', $columnNames); // Include column names
                $sql .= ") VALUES ($placeholders)";

                $stmt = $mysqli->prepare($sql);

                if ($stmt) {
                    $isFirstRow = true;
                    $rowCount = 0;
                    foreach ($worksheet->getRowIterator() as $row) {
                        if ($isFirstRow || $rowCount < 8) {
                            $isFirstRow = false;
                            $rowCount++;
                            continue;
                        }
                        $cellIterator = $row->getCellIterator();
                        $cellIterator->setIterateOnlyExistingCells(false);

                        //Check if the row has any non-empty cell
                        $rowHasData = false;
                        foreach ($cellIterator as $cell) {
                            $cellValue = $cell->getFormattedValue();
                            if (!empty($cellValue) && $cellValue!=='0.00') {
                                $rowHasData =true;
                                break;
                            }
                        }
                        if ($rowHasData) {
                            $data = [];
                            $types = ''; // Initialize a string to store data types

                            foreach ($cellIterator as $cell) {
                                $cellValue = $cell->getFormattedValue();

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


                                // Determine the data type and add it to the types string
                                if (is_numeric($data[count($data) - 1])) {
                                    // Use 'd' for double/numeric values
                                    $types .= 'd';
                                } else {
                                    // Use 's' for strings or other data types
                                    $types .= 's';
                                }
                            }
                        }

                        // Create an array of references for bind_param
                        $bindParameters = [$types];
                        foreach ($data as $key => &$value) {
                            $bindParameters[] = &$value;
                        }

                        // Bind parameters using call_user_func_array
                        call_user_func_array(array($stmt, 'bind_param'), $bindParameters);

                        $stmt->execute();
                    }//foreach worksheet

                    // Close the prepared statement
                    $stmt->close();

                }//if stmt
                else {
                    echo 'Error in preparing the SQL statement: ' . $mysqli->error;
                }

                // Close the database connection
                $mysqli->close();

                //Show a modal dialog with the messsage and redirect to PRS.php
                displayModalWithRedirect("Data is imported successfully.", "active_semi_expendable.php");

            }//if move uploaded
            else {
                // Error moving the file
                displayModalWithRedirect("Error saving the uploaded file.", "active_semi_expendable.php");
            }
        }//if file_ext
        else {
            displayModalWithRedirect("Invalid file format. Please upload an Excel file (xlsx or xls).", "active_semi_expendable.php");
        }
    } else {
        displayModalWithRedirect("Please choose a file to upload.", "active_semi_expendable.php");
    }
}
// JavaScript function to redirect to a page
echo '<script type="text/javascript">
    function redirectToPage(page) {
        window.location.href = page;
    }
</script>';
?>
