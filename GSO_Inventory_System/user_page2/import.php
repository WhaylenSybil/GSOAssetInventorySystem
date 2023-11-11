<?php
var_dump($_POST);

// Include the database connection
$db_host = "localhost";
$db_username = "root";
$db_password = "";
$db_name = "db_gso";

$mysqli = new mysqli($db_host, $db_username, $db_password, $db_name);

// Include the PhpSpreadsheet library
require './../vendor/autoload.php';

use PhpOffice\PhpSpreadsheet\IOFactory;

if (isset($_POST['import_btn'])) {

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
                    'date_recorded',
                    'article',
                    'brand',
                    'serialno',
                    'particulars',
                    'AREno',
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
                    'currentconditionid',
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

                $sql = "INSERT INTO are_properties (";
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

                // Redirect after successful import
                echo '<script>alert("File is successfully imported and saved.");</script>';
                echo '<script>window.location.href = "active_PPE.php";</script>';
                exit;
            }//if move uploaded
            else {
                // Error moving the file
                echo '<script>alert("Error saving the uploaded file.");</script>';
                echo '<script>window.location.href = "active_PPE.php";</script>';
            }
        }//if file_ext
        else {
            echo '<script>alert("Invalid file format. Please upload an Excel file (xlsx or xls).");</script>';
            echo '<script>window.location.href = "active_PPE.php";</script>';
        }
    } else {
        echo '<script>alert("Please choose a file to upload.");</script>';
        echo '<script>window.location.href = "active_PPE.php";</script>';
    }
}
?>
