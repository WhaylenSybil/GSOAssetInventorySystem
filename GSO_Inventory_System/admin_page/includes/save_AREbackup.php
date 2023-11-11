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

    if (isset($_POST['btn_ARE_save'])) {
        $daterecorded = $_POST['date_recorded'];
        $article = strtoupper($_POST['article']);
        $brand = strtoupper($_POST['brand']);
        $serialno = $_POST['serial_no'];
        $particulars = $_POST['particulars'];
        $AREnumber = $_POST['ARE_no'];
        $eNGAS = $_POST['engas'];
        $acquisitiondate = $_POST['acquisition_date'];
        $acquisitioncost = $_POST['acquisition_cost'];
        $propertyno = $_POST['property_no'];
        $accountnumber = $_POST['accountnumber'];
        $estLifeValue = $_POST['est_life'];
        $unitofmeasure = $_POST['unit_measure'];
        $unitvalue = $_POST['unit_value'];
        $unitvalueFormatted = number_format((float)str_replace(',', '', $unitvalue), 2, '.', ',');
        $balancepercard = $_POST['balance_per_card'];
        $onhandpercount = $_POST['onhand_per_count'];
        $so_qty = $_POST['shortage_overage_qty'];
        $so_value = $_POST['shortage_overage_value'];
        $resCenterValue = $_POST['rescenter'];
       	$accountableperson= $_POST['accountable_person'];
        $previouscondition = $_POST['previous_condition'];
        $location = $_POST['location'];
        $currentconditionid = $currentCondition;
        $physicalinventory = $_POST['date_of_physical_inventory'];
        $remarks = $_POST['remarks'];
        $supplier = $_POST['supplier'];
        $PO_no = $_POST['PO_no'];
        $AIR_RIS_no = $_POST['AIR_RIS_no'];
        $notes = $_POST['notes'];
        $JEV = $_POST['jev'];


        $check = "SELECT COUNT(*) as ID FROM ARE_properties WHERE equipmentid=?";
        $pre_stmt = $connect->prepare($check) or die(mysqli_error($connect)); 
        $pre_stmt->bind_param('i', $_POST['equipmentid']);
        $pre_stmt->execute();
        $result = $pre_stmt->get_result();
        $row = mysqli_fetch_array($result);
        
        if ($row['ID'] == 0) {
            $sql = "INSERT INTO `ARE_properties`(
            	`date_recorded`,
            	`article`,
            	`brand`,
            	`serialno`,
            	`particulars`,
            	`AREno`,
            	`eNGAS`,
            	`acquisitiondate`,
            	`acquisitioncost`,
            	`propertyno`,
            	`classification_id`,
            	`estimatedlife`,
            	`unitofmeasure`,
            	`unitvalue`,
            	`balance_per_card`,
            	`onhand_per_count`,
            	`so_qty`,
            	`so_value`,
            	`responsibilitycenter_id`,
            	`accountable_person`,
            	`previouscondition`,
            	`location`,
            	`currentconditionid`,
                `date_of_physical_inventory`,
            	`remarks`,
            	`supplier`,
            	`PO_no`,
            	`AIR_RIS_no`,
            	`notes`,
            	`jevno`)
            VALUES (?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?)";
            
            $pre_stmt = $connect->prepare($sql) or die(mysqli_error($connect));
            $pre_stmt->bind_param('ssssssssssssssssssssssssssssss',
                $daterecorded,
                $article,
                $brand,
                $serialno,
                $particulars,
                $AREnumber,
                $eNGAS,
                $acquisitiondate,
                $acquisitioncost,
                $propertyno,
                $accountnumber,
                $estLifeValue,
                $unitofmeasure,
                $unitvalueFormatted,
                $balancepercard,
                $onhandpercount,
                $so_qty,
                $so_value,
                $resCenterValue,
                $accountableperson,
                $previouscondition,
                $location,
                $currentconditionid,
                $physicalinventory,
                $remarks,
                $supplier,
                $PO_no,
                $AIR_RIS_no,
                $notes,
                $JEV);
            
            if ($pre_stmt->execute()) {
                // Data inserted successfully
                date_default_timezone_set('Asia/Manila');
                $date_now = date('M-d-y');
                $time_now = date('H:i:s');
                $action = 'Added ARE Properties';
                
                $query = "INSERT INTO activity_log (employeeid, firstname, date_log, time_log, action) VALUES(?,?,?,?,?)";
                $stmt = $connect->prepare($query);
                $stmt->bind_param('issss', $_SESSION['employeeid'], $_SESSION['firstname'], $date_now, $time_now, $action);
                $stmt->execute();
                
                function alert($msg) {
                    echo "<script type='text/javascript'>alert('$msg')</script>";
                }
                
                alert("Added an ARE Property");
                echo '<script type="text/javascript">window.location = "active_PPE.php"</script>';
            } else {
                // Error inserting data
                echo "Error: " . $pre_stmt->error;
            }
        } else {
            // Property already exists
            alert("ARE property already exists");
            echo '<script type="text/javascript">window.location = "add_ARE_Registy.php"</script>';
        }
        
        // Close prepared statement
        $pre_stmt->close();
    }
?>