 <?php
 $connect = mysqli_connect('localhost', 'root', '', 'db_gso') or die(mysqli_error($connect));
    
    // Initialize variables
    $currentConditionInput = isset($_POST['other_condition_input']) ? $_POST['other_condition_input'] : '';
    $currentConditionSelect = isset($_POST['current_condition_input']) ? $_POST['current_condition_input'] : '';

    $currentConditionId = null;

    // Determine the current condition_id to be saved
    if (!empty($currentConditionInput)) {
        // User entered a new condition in the "Other Condition" input field
        // Insert the new condition into the 'conditions' table
        $currentCondition = $currentConditionInput;

        $insertConditionQuery = "INSERT INTO conditions (condition_name) VALUES (?)";
        $insertConditionStmt = $connect->prepare($insertConditionQuery);
        $insertConditionStmt->bind_param('s', $currentConditionInput);

        if ($insertConditionStmt->execute()) {
            // Retrieve the condition_id of the newly inserted condition
            $currentConditionId = $insertConditionStmt->insert_id;

            // Close the prepared statement
            $insertConditionStmt->close();
        } else {
            // Error inserting data
            echo "Error: " . $insertConditionStmt->error;
        }
    } elseif (!empty($currentConditionSelect)) {
        // User selected an existing condition
        // Retrieve the condition_id of the selected condition
        $conditionIdQuery = "SELECT condition_id, condition_name FROM conditions WHERE condition_name = ?";
        $conditionIdStmt = $connect->prepare($conditionIdQuery);
        $conditionIdStmt->bind_param('s', $currentConditionSelect);
        $conditionIdStmt->execute();
        $conditionIdResult = $conditionIdStmt->get_result();

        if ($conditionIdResult->num_rows > 0) {
            $conditionIdRow = $conditionIdResult->fetch_assoc();
            $currentCondition = $conditionIdRow['condition_name'];
        }

        // Close the prepared statement
        $conditionIdStmt->close();
    }

    if (isset($_POST['btn_PRS_save'])) {
        $dateReturnedRecorded = $_POST['dateReturnedRecorded'];
        $ItemNo = $_POST['ItemNo'];
        $prsNumber = $_POST['prsNumber'];
        $article = strtoupper($_POST['article']);
        $brand = strtoupper($_POST['brand']);
        $serialNumber = $_POST['serialNumber'];
        $particulars = $_POST['particulars'];
        $areNumber = $_POST['areNumber'];
        $engasNumber = $_POST['engasNumber'];
        $acquisitionDate = $_POST['acquisitionDate'];
        $acquisitionCost = $_POST['acquisitionCost'];
        $propertyNumber = $_POST['propertyNumber'];
        /*$classification = $_POST['classification'];*/
        $unitOfMeasure = $_POST['unitOfMeasure'];
        $unitValue = $_POST['unitValue'];
        $unitValueFormatted = number_format((float)str_replace(',', '', $unitValue), 2, '.', ',');
        $balancePerCard = $_POST['balancePerCard'];
        $onhandPerCount = $_POST['onhandPerCount'];
        $soQty = $_POST['soQty'];
        $soValue = $_POST['soValue'];
        $responsibilityCenter = $_POST['rescenter'];
        $accountableEmployee= $_POST['accountableEmployee'];
        $remarks = $_POST['remarks'];
        $iirup = $_POST['iirup'];
        $iirupDate = $_POST['iirupDate'];
        $withAttachment = isset($_POST['withAttachment']) ? 'With MR/ARE Attachment' : '';
        $prsCoverPage = isset($_POST['prsCoverPage']) ? 'With Cover Page' : '';


        $check = "SELECT COUNT(*) as ID FROM prs_properties WHERE prsID=?";
        $pre_stmt = $connect->prepare($check) or die(mysqli_error($connect)); 
        $pre_stmt->bind_param('i', $_POST['prsID']);
        $pre_stmt->execute();
        $result = $pre_stmt->get_result();
        $row = mysqli_fetch_array($result);
        
        if ($row['ID'] == 0) {
            $sql = "INSERT INTO `prs_properties` (
                `dateReturnedRecorded`,
                `itemNo`,
                `prsNumber`,
                `article`,
                `brand`,
                `serialNumber`,
                `particulars`,
                `areNumber`,
                `engasNumber`,
                `acquisitionDate`,
                `acquisitionCost`,
                `propertyNumber`,
                `unitOfMeasure`,
                `unitValue`,
                `balancePerCard`,
                `onhandPerCount`,
                `soQty`,
                `soValue`,
                `responsibilityCenter`,
                `accountableEmployee`,
                `remarks`,
                `withAttachment`,
                `prsCoverPage`,
                `iirup`,
                `iirupDate`
            ) VALUES (?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?)";

            $pre_stmt = $connect->prepare($sql) or die(mysqli_error($connect));

            // Update the bind_param function to match the number of placeholders
            $pre_stmt->bind_param('sssssssssssssssssssssssss',
                $dateReturnedRecorded,
                $ItemNo,
                $prsNumber,
                $article,
                $brand,
                $serialNumber,
                $particulars,
                $areNumber,
                $engasNumber,
                $acquisitionDate,
                $acquisitionCost,
                $propertyNumber,
                $unitOfMeasure,
                $unitValueFormatted,
                $balancePerCard,
                $onHandPerCount,
                $soQty,
                $soValue,
                $responsibilityCenter,
                $accountableEmployee,
                $remarks,
                $withAttachment,
                $prsCoverPage,
                $iirup,
                $iirupDate
            );
            
            if ($pre_stmt->execute()) {
                // Data inserted successfully
                date_default_timezone_set('Asia/Manila');
                $date_now = date('M-d-y');
                $time_now = date('H:i:s');
                $action = 'Added a PRS';
                
                $query = "INSERT INTO activity_log (employeeid, firstname, date_log, time_log, action) VALUES(?,?,?,?,?)";
                $stmt = $connect->prepare($query);
                $stmt->bind_param('issss', $_SESSION['employeeid'], $_SESSION['firstname'], $date_now, $time_now, $action);
                $stmt->execute();
                
                function alert($msg) {
                    echo "<script type='text/javascript'>alert('$msg')</script>";
                }
                
                echo '<script type="text/javascript">';
                echo 'alert("Added a PRS");';
                echo 'window.location = "PRS.php";';
                echo '</script>';
            } else {
                // Error inserting data
                echo "Error: " . $pre_stmt->error;
            }
        } else {
            // Property already exists
            echo '<script type="text/javascript">';
            echo 'alert("PRS property already exists");';
            echo 'window.location = "add_PRS.php";';
            echo '</script>';
        }
        
        // Close prepared statement
        $pre_stmt->close();
    }
?>