<?php
require('./../database/connection.php');

if (isset($_GET['equipmentid'])) {
    $equipmentid = $_GET['equipmentid'];

    $pre_stmt = $connect->prepare("SELECT * FROM are_properties WHERE equipmentid = ?");
    $pre_stmt->bind_param('i', $equipmentid);
    $pre_stmt->execute();
    $result = $pre_stmt->get_result();

    if ($result->num_rows >0) {
        $row = $result->fetch_assoc();
    }else{
        header("Location: active_PPE.php");
        exit();
    }
}

// Check if the form is submitted
if (isset($_POST['btn_ARE_update'])) {
    // Get and sanitize form inputs
    $equipmentid = $_GET['equipmentid'];
    $dateRecorded = $_POST['date_recorded'];
    $resCenter = $_POST['rescenter'];
    $acquisitionDate = $_POST['acquisition_date'];
    $AREno = $_POST['ARE_no'];
    $unitValue = $_POST['unit_value'];
    $balancePerCard = $_POST['balance_per_card'];
    $acquisitionCost = $_POST['acquisition_cost'];
    $article = strtoupper($_POST['article']);
    $brand = strtoupper($_POST['brand']);
    $serialNo = $_POST['serial_no'];
    $particulars = $_POST['particulars'];
    $engas = $_POST['engas'];
    $propertyNo = $_POST['property_no'];
    $accountNumber = $_POST['accountnumber'];
    $estLife = $_POST['est_life'];
    $unitMeasure = $_POST['unit_measure'];
    $unitvalue = $_POST['unit_value'];
    $balancePerCard = $_POST['balance_per_card'];
    $onhandPerCount = $_POST['onhand_per_count'];
    $soQty = $_POST['shortage_overage_qty'];
    $soValue = $_POST['shortage_overage_value'];
    $accountablePerson = $_POST['accountable_person'];
    $previousCondition = $_POST['previous_condition'];
    $location = $_POST['location'];
    $currentConditionSelect = $_POST['current_condition_input'];
    $dateOfPhysicalInventory = $_POST['date_of_physical_inventory'];
    $remarks = $_POST['remarks'];
    $supplier = $_POST['supplier'];
    $PONo = $_POST['PO_no'];
    $AIRRISNo = $_POST['AIR_RIS_no'];
    $notes = $_POST['notes'];
    $jevNo = $_POST['jev'];
    $scannedARE = $_POST['scanned_docs'];

    // Check if "Other" condition is selected
    if ($currentConditionSelect === 'Other') {
        // Use the value from the "Other Condition" input
        $currentConditionInput = $_POST['other_condition_input'];

        // Insert the new condition into the 'conditions' table
        $insertConditionQuery = "INSERT INTO conditions (condition_name) VALUES (?)";
        $insertConditionStmt = $connect->prepare($insertConditionQuery);
        $insertConditionStmt->bind_param('s', $currentConditionInput);

        if ($insertConditionStmt->execute()) {
            // Retrieve the condition ID of the newly inserted condition
            //$conditionId = $insertConditionStmt->insert_id;

            // Set the newly inserted condition_name as the current condition
            $currentCondition = $currentConditionInput;

            // Close the prepared statement
            $insertConditionStmt->close();
        } else {
            // Error inserting data
            echo "Error: " . $insertConditionStmt->error;
        }
    } else {
        // Use the value from the dropdown
        $currentCondition = $currentConditionSelect;
    }

    // Update the database with the user's input
    $updateStmt = $connect->prepare("UPDATE are_properties SET
        date_recorded = ?,
        article = ?,
        brand = ?,
        serialno = ?,
        particulars = ?,
        AREno = ?,
        eNGAS = ?,
        acquisitiondate = ?,
        acquisitioncost =?,
        propertyno = ?,
        classification_id = ?,
        estimatedlife = ?,
        unitofmeasure = ?,
        unitvalue = ?,
        balance_per_card = ?,
        onhand_per_count = ?,
        so_qty = ?,
        so_value = ?,
        responsibilitycenter_id = ?,
        accountable_person = ?,
        previouscondition = ?,
        location = ?,
        currentconditionid = ?,
        date_of_physical_inventory = ?,
        remarks = ?,
        supplier = ?,
        PO_no = ?,
        AIR_RIS_no = ?,
        notes = ?,
        jevno = ?,
        scannedARE = ?
        WHERE equipmentid = ?");

    $updateStmt->bind_param(
        "sssssssssssssssssssssssssssssssi",
        $dateRecorded, $article, $brand, $serialNo, $particulars, $AREno, $engas, $acquisitionDate, $acquisitionCost, $propertyNo, $accountNumber, $estLife, $unitMeasure, $unitValue, $balancePerCard, $onhandPerCount, $soQty, $soValue, $resCenter, $accountablePerson, $previousCondition, $location, $currentCondition, $dateOfPhysicalInventory, $remarks, $supplier, $PONo, $AIRRISNo, $notes, $jevNo, $scannedARE, $equipmentid
    );

    if ($updateStmt->execute()) {
        echo '<script>alert("Updated Successfully"); window.location.href="active_PPE.php";</script>';
        exit();
    } else {
        // Handle the update error, e.g., display an error message
        echo "Update failed: " . $updateStmt->error;
    }
}

?>