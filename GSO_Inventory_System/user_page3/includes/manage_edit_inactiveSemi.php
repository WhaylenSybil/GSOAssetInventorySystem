<?php
require('./../database/connection.php');

if (isset($_GET['ICSequipmentid'])) {
    $ICSequipmentid = $_GET['ICSequipmentid'];

    $pre_stmt = $connect->prepare("SELECT * FROM ics_properties WHERE ICSequipmentid = ?");
    $pre_stmt->bind_param('i', $ICSequipmentid);
    $pre_stmt->execute();
    $result = $pre_stmt->get_result();

    if ($result->num_rows > 0) {
        $row = $result->fetch_assoc();
    } else {
        header("Location: active_PPE.php");
        exit();
    }
}

// Check if the form is submitted
if (isset($_POST['btn_inactiveICS_update'])) {

    // Handle file upload
    if (isset($_FILES['scanned_ics']) && $_FILES['scanned_ics']['name'] !== '') {
        $file_name = $_FILES['scanned_ics']['name'];
        $file_tmp = $_FILES['scanned_ics']['tmp_name'];
        $file_destination = './ICS Scans/' . $file_name; // Specify the destination directory

        // Move the uploaded file to the destination
        if (move_uploaded_file($file_tmp, $file_destination)) {
            $ICSfile_path = $file_destination; // Set the file path to be stored in the database
        } else {
            // Handle the file upload error, e.g., display an error message
            echo "File upload failed.";
            exit();
        }
    } else {
        // No new file uploaded, retain the existing file path
        $ICSfile_path = $row['scannedICS'];
    }

    // Get and sanitize form inputs
    $ICSequipmentid = $_GET['ICSequipmentid'];
    $ICSdateReturned = $_POST['date_returned'];
    $ICSresCenter = $_POST['rescenter'];
    $ICSacquisitionDate = $_POST['acquisition_date'];
    $PRSno = $_POST['PRS_WMR_no'];
    $ICSunitValue = $_POST['unit_value'];
    $ICSbalancePerCard = $_POST['balance_per_card'];
    $ICSacquisitionCost = $_POST['acquisition_cost'];
    $ICSarticle = strtoupper($_POST['article']);
    $ICSbrand = strtoupper($_POST['brand']);
    $ICSserialNo = $_POST['serial_no'];
    $ICSparticulars = $_POST['particulars'];
    $ICSengas = $_POST['engas'];
    $ICSpropertyNo = $_POST['property_no'];
    $ICSaccountNumber = $_POST['accountnumber'];
    $ICSestLife = $_POST['est_life'];
    $ICSunitMeasure = $_POST['unit_measure'];
    $ICSunitvalue = $_POST['unit_value'];
    $ICSbalancePerCard = $_POST['balance_per_card'];
    $ICSonhandPerCount = $_POST['onhand_per_count'];
    $ICSsoQty = $_POST['shortage_overage_qty'];
    $ICSsoValue = $_POST['shortage_overage_value'];
    $ICSaccountablePerson = $_POST['accountable_person'];
    $ICSpreviousCondition = $_POST['previous_condition'];
    $ICSlocation = $_POST['location'];
    $ICScurrentConditionSelect = $_POST['current_condition_input'];
    $ICSdateOfPhysicalInventory = $_POST['date_of_physical_inventory'];
    $ICSremarks = $_POST['remarks'];
    $ICSsupplier = $_POST['supplier'];
    $ICSPONo = $_POST['PO_no'];
    $ICSAIRRISNo = $_POST['AIR_RIS_no'];
    $ICSnotes = $_POST['notes'];
    $ICSjevNo = $_POST['jev'];

    // Check if "Other" condition is selected
    if ($ICScurrentConditionSelect === 'Other') {
        // Use the value from the "Other Condition" input
        $ICScurrentConditionInput = $_POST['other_condition_input'];

        // Insert the new condition into the 'conditions' table
        $ICSinsertConditionQuery = "INSERT INTO conditions (condition_name) VALUES (?)";
        $ICSinsertConditionStmt = $connect->prepare($ICSinsertConditionQuery);
        $ICSinsertConditionStmt->bind_param('s', $ICScurrentConditionInput);

        if ($ICSinsertConditionStmt->execute()) {

            // Set the newly inserted condition_name as the current condition
            $ICScurrentCondition = $ICScurrentConditionInput;

            // Close the prepared statement
            $ICSinsertConditionStmt->close();
        } else {
            // Error inserting data
            echo "Error: " . $ICSinsertConditionStmt->error;
        }
    } else {
        // Use the value from the dropdown
        $ICScurrentCondition = $ICScurrentConditionSelect;
    }

    // Update the database with the user's input
    $updateStmt = $connect->prepare("UPDATE ics_properties SET
        date_returned = ?,
        article = ?,
        brand = ?,
        serialno = ?,
        particulars = ?,
        PRS_WMR_no = ?,
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
        currentcondition = ?,
        date_of_physical_inventory = ?,
        remarks = ?,
        supplier = ?,
        PO_no = ?,
        AIR_RIS_no = ?,
        notes = ?,
        jevno = ?,
        scannedICS = ?
        WHERE ICSequipmentid = ?");

    $updateStmt->bind_param(
        "ssssssssssssssssssssssssssssssss",
        $ICSdateReturned, $ICSarticle, $ICSbrand, $ICSserialNo, $ICSparticulars, $PRSno, $ICSengas,
        $ICSacquisitionDate, $ICSacquisitionCost, $ICSpropertyNo, $ICSaccountNumber, $ICSestLife, $ICSunitMeasure,
        $ICSunitValue, $ICSbalancePerCard, $ICSonhandPerCount, $ICSsoQty, $ICSsoValue, $ICSresCenter,
        $ICSaccountablePerson, $ICSpreviousCondition, $ICSlocation, $ICScurrentCondition, $ICSdateOfPhysicalInventory,
        $ICSremarks, $ICSsupplier, $ICSPONo, $ICSAIRRISNo, $ICSnotes, $ICSjevNo, $ICSfile_path, $ICSequipmentid
    );

    if ($updateStmt->execute()) {
        // Insert activity log entry
        date_default_timezone_set('Asia/Manila');
        $date_now = date('Y-m-d');
        $time_now = date('H:i:s');
        $action = 'Updated the ICS properties';
        $employeeid = $_SESSION['employeeid'];

        $query = "INSERT INTO activity_log (employeeid, firstname, date_log, time_log, action) VALUES (?,?,?,?,?)";
        $stmt = $connect->prepare($query);
        $stmt->bind_param('issss', $employeeid, $_SESSION['firstname'], $date_now, $time_now, $action);

        if ($stmt->execute()) {
            echo '<div id="update-success-modal" class="modal-background">
                    <div class="modal-content">
                        <div class="message">ICS is updated successfully</div>
                        <button class="ok-button" onclick="redirectToPage(\'inactiveSemi.php\')">OK</button>
                    </div>
                </div>';
            echo '<script type="text/javascript">
                    function redirectToPage(page) {
                        window.location.href = page;
                    }
                  </script>';
        } else {
            // Handle the activity log insertion error
            echo "Activity log entry failed: " . $stmt->error;
        }
    } else {
        // Handle the update error, e.g., display an error message
        echo "Update failed: " . $updateStmt->error;
    }
}
?>