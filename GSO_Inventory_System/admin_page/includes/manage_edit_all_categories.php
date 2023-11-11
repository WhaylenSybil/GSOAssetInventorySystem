<?php
require('./../database/connection.php');

if(isset($_GET['eqID'])) {
    $eqID = $_GET['eqID'];

    // Query to fetch equipment details for editing
    $editSql = "SELECT * FROM (SELECT equipmentid AS eqID, date_recorded as dateRecordedReturned, article, brand, serialno, particulars, AREno AS ARE_PRS, eNGAS, acquisitiondate, acquisitioncost, propertyno, classification_id, estimatedlife, unitofmeasure, unitvalue, balance_per_card, onhand_per_count, so_qty, so_value, responsibilitycenter_id as rescenter, accountable_person, previouscondition, location, currentconditionid AS curCondition, date_of_physical_inventory, remarks, supplier, PO_no, AIR_RIS_no, notes, jevno, scannedARE AS scannedDocs FROM are_properties
                UNION
                SELECT ICSequipmentid AS eqID, date_returned as dateRecordedReturned, article, brand, serialno, particulars, PRS_WMR_no AS ARE_PRS, eNGAS, acquisitiondate, acquisitioncost, propertyno, classification_id, estimatedlife, unitofmeasure, unitvalue, balance_per_card, onhand_per_count, so_qty, so_value, responsibilitycenter_id as rescenter, accountable_person, previouscondition, location, currentcondition AS curCondition, date_of_physical_inventory, remarks, supplier, PO_no, AIR_RIS_no, notes, jevno, scannedICS AS scannedDocs FROM ics_properties) AS combined_properties
                WHERE eqID = ?";
    $editPreStmt = $connect->prepare($editSql) or die(mysqli_error());
    $editPreStmt->bind_param("i", $eqID);
    $editPreStmt->execute();
    $editResult = $editPreStmt->get_result();

    if ($editResult->num_rows == 1) {
        $editRow = $editResult->fetch_assoc();
    } else {
        // Equipment with the given eqID not found
        // Handle the error or redirect as needed
        die("Equipment not found");
    }
} else {
    // eqID parameter not provided in the URL
    // Handle the error or redirect as needed
    die("Equipment ID not provided");
}

// Check if the form is submitted
if (isset($_POST['btn_allcategories_update'])) {

  if (isset($_FILES['scanned_docs']) && $_FILES['scanned_docs']['name'] !== '') {
      $file_name = $_FILES['scanned_docs']['name'];
      $file_tmp = $_FILES['scanned_docs']['tmp_name'];

      // Check the current scannedDocs path to determine which folder it belongs to
      if (strpos($file_path, './ARE Scans') !== false) {
          $current_folder = './ARE Scans/';
      } elseif (strpos($file_path, './ICS Scans/') !== false) {
          $current_folder = './ICS Scans/';
      } else {
          // Handle cases where the folder is not recognized
          echo "Invalid folder for scannedDocs.";
          exit();
      }

      // Specify the destination directory based on the current folder
      $file_destination = $current_folder . $file_name;

      // Move the uploaded file to the destination
      if (move_uploaded_file($file_tmp, $file_destination)) {
          $file_path = $file_destination; // Set the file path to be stored in the database
      } else {
          // Handle the file upload error, e.g., display an error message
          echo "File upload failed.";
          exit();
      }
  } else {
      // No new file uploaded, retain the existing file path
      // $file_path already contains the correct path, no need to change anything
  }


    // Get and sanitize form inputs
    $eqID = $_GET['eqID'];

    // Check if 'dateRecordedReturned' exists in $_POST
    $dateRecordedReturned = isset($_POST['dateRecordedReturned']) ? $_POST['dateRecordedReturned'] : null;
    $resCenter = isset($_POST['rescenter']) ? $_POST['rescenter'] : null;
    $acquisitionDate = isset($_POST['acquisition_date']) ? $_POST['acquisition_date'] : null;
    $ARE_PRS = isset($_POST['ARE_PRS']) ? $_POST['ARE_PRS'] : null;
    $unitValue = isset($_POST['unit_value']) ? $_POST['unit_value'] : null;
    $balancePerCard = isset($_POST['balance_per_card']) ? $_POST['balance_per_card'] : null;
    $acquisitionCost = isset($_POST['acquisition_cost']) ? $_POST['acquisition_cost'] : null;
    $article = isset($_POST['article']) ? strtoupper($_POST['article']) : null;
    $brand = isset($_POST['brand']) ? strtoupper($_POST['brand']) : null;
    $serialNo = isset($_POST['serial_no']) ? $_POST['serial_no'] : null;
    $particulars = isset($_POST['particulars']) ? $_POST['particulars'] : null;
    $engas = isset($_POST['engas']) ? $_POST['engas'] : null;
    $propertyNo = isset($_POST['property_no']) ? $_POST['property_no'] : null;
    $accountNumber = isset($_POST['accountnumber']) ? $_POST['accountnumber'] : null;
    $estLife = isset($_POST['est_life']) ? $_POST['est_life'] : null;
    $unitMeasure = isset($_POST['unit_measure']) ? $_POST['unit_measure'] : null;
    $unitvalue = isset($_POST['unit_value']) ? $_POST['unit_value'] : null;
    $balancePerCard = isset($_POST['balance_per_card']) ? $_POST['balance_per_card'] : null;
    $onhandPerCount = isset($_POST['onhand_per_count']) ? $_POST['onhand_per_count'] : null;
    $soQty = isset($_POST['shortage_overage_qty']) ? $_POST['shortage_overage_qty'] : null;
    $soValue = isset($_POST['shortage_overage_value']) ? $_POST['shortage_overage_value'] : null;
    $accountablePerson = isset($_POST['accountable_person']) ? $_POST['accountable_person'] : null;
    $previousCondition = isset($_POST['previous_condition']) ? $_POST['previous_condition'] : null;
    $location = isset($_POST['location']) ? $_POST['location'] : null;
    $currentConditionSelect = isset($_POST['current_condition_input']) ? $_POST['current_condition_input'] : null;
    $dateOfPhysicalInventory = isset($_POST['date_of_physical_inventory']) ? $_POST['date_of_physical_inventory'] : null;
    $remarks = isset($_POST['remarks']) ? $_POST['remarks'] : null;
    $supplier = isset($_POST['supplier']) ? $_POST['supplier'] : null;
    $PONo = isset($_POST['PO_no']) ? $_POST['PO_no'] : null;
    $AIRRISNo = isset($_POST['AIR_RIS_no']) ? $_POST['AIR_RIS_no'] : null;
    $notes = isset($_POST['notes']) ? $_POST['notes'] : null;
    $jevNo = isset($_POST['jev']) ? $_POST['jev'] : null;

    // Check if "Other" condition is selected
    if ($currentConditionSelect === 'Other') {
        // Use the value from the "Other Condition" input
        $currentConditionInput = isset($_POST['other_condition_input']) ? $_POST['other_condition_input'] : null;

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

   // Check if acquisition cost is less than 50,000
   if ($acquisitionCost >= 50000) {
       // Insert data into ics_properties table
       $insertSql = "INSERT INTO ics_properties (date_returned, article, brand, serialno, particulars, PRS_WMR_no, eNGAS, acquisitiondate, acquisitioncost, propertyno, classification_id, estimatedlife, unitofmeasure, unitvalue, balance_per_card, onhand_per_count, so_qty, so_value, responsibilitycenter_id, accountable_person, previouscondition, location, currentcondition, date_of_physical_inventory, remarks, supplier, PO_no, AIR_RIS_no, notes, jevno) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)";
       $insertPreStmt = $connect->prepare($insertSql) or die(mysqli_error());
       $insertPreStmt->bind_param("ssssssssssssssssssssssssssssss", $dateRecordedReturned, $article, $brand, $serialNo, $particulars, $ARE_PRS, $eNGAS, $acquisitionDate, $acquisitionCost, $propertyNo, $classification, $estimatedLife, $unitOfMeasure, $unitValue, $balancePerCard, $onHandPerCount, $shortageOverageQty, $shortageOverageValue, $resCenter, $accountablePerson, $previousCondition, $location, $curCondition, $dateOfPhysicalInventory, $remarks, $supplier, $PO_no, $AIR_RIS_no, $notes, $jevno);

       if ($insertPreStmt->execute()) {
           // Success message or redirection
           echo "Data saved to ics_properties table successfully.";
       } else {
           // Error handling
           echo "Error: " . $insertPreStmt->error;
       }
   } elseif($acquisitionCost<=50000) {
       // Insert data into are_properties table
       $insertSql = "INSERT INTO are_properties (date_recorded, article, brand, serialno, particulars, AREno, eNGAS, acquisitiondate, acquisitioncost, propertyno, classification_id, estimatedlife, unitofmeasure, unitvalue, balance_per_card, onhand_per_count, so_qty, so_value, responsibilitycenter_id, accountable_person, previouscondition, location, currentconditionid, date_of_physical_inventory, remarks, supplier, PO_no, AIR_RIS_no, notes, jevno) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)";
       $insertPreStmt = $connect->prepare($insertSql) or die(mysqli_error());
       $insertPreStmt->bind_param("ssssssssssssssssssssssssssssss", $dateRecordedReturned, $article, $brand, $serialNo, $particulars, $ARE_PRS, $eNGAS, $acquisitionDate, $acquisitionCost, $propertyNo, $classification, $estimatedLife, $unitOfMeasure, $unitValue, $balancePerCard, $onHandPerCount, $shortageOverageQty, $shortageOverageValue, $resCenter, $accountablePerson, $previousCondition, $location, $curCondition, $dateOfPhysicalInventory, $remarks, $supplier, $PO_no, $AIR_RIS_no, $notes, $jevno);

       if ($insertPreStmt->execute()) {
           // Success message or redirection
           echo "Data saved to are_properties table successfully.";
       } else {
           // Error handling
           echo "Error: " . $insertPreStmt->error;
       }
   }
}

// Rest of your HTML and form
?>