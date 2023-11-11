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

if (isset($_POST['importPRS'])) {
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
                    'iirup',
                    'iirupDate'
                ];

                // Adjust this variable to match the number of columns
                $numColumns = 23; // Columns A to W

                // Create a placeholders string for the SQL query
                $placeholders = str_repeat("?,", $numColumns - 1) . "?";

                // Create a type string for bind_param
                $typeString = str_repeat("s", $numColumns);

                $sql = "INSERT INTO prs_properties (";
                $sql .= implode(', ', $columnNames); // Include column names
                $sql .= ") VALUES ($placeholders)";

                $stmt = $mysqli->prepare($sql);
                
                if ($stmt) {
                    $rowCount = 0;

                    foreach ($worksheet->getRowIterator() as $row) {
                        if ($rowCount < 7) {
                            // Skip the first 7 rows
                            $rowCount++;
                            continue;
                        }

                        $cellIterator = $row->getCellIterator();
                        $cellIterator->setIterateOnlyExistingCells(false);
                        
                        // Process data for columns A to W
                        $data = [];
                        $types = '';
                        $columnCounter = 0;
                        $isEmptyRow = true;
                        
                        foreach ($cellIterator as $cell) {
                            if ($columnCounter >= $numColumns) {
                                break; // Stop processing cells after column W
                            }

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
                        }

                        $rowCount++;
                    }
                    
                    // Close the statement
                    $stmt->close();
                } else {
                    echo 'Error in preparing the SQL statement: ' . $mysqli->error;
                }

                // Close the database connection
                $mysqli->close();
                
                // Success message and redirect to "PRS.php"
                echo '<script>alert("Data imported successfully."); window.location.href = "PRS.php";</script>';
            } else {
                // Error moving the file
                echo '<script>alert("Error saving the uploaded file."); window.location.href = "PRS.php";</script>';
            }
        } else {
            echo '<script>alert("Invalid file format. Please upload an Excel file (xlsx or xls)."); window.location.href = "PRS.php";</script>';
        }
    } else {
        echo '<script>alert("Please choose a file to upload."); window.location.href = "PRS.php";</script>';
    }
}
?>