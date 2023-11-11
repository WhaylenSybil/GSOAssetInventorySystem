<?php
if (isset($_GET['prsID'])) {
    $prsID = $_GET['prsID'];

    $pre_stmt = $connect->prepare("SELECT * FROM prs_properties
      JOIN modeofdisposaltable ON prs_properties.prsID = modeofdisposaltable.prsID
      JOIN updatesorcurrentstatus ON prs_properties.prsID = updatesorcurrentstatus.prsID
      WHERE prs_properties.prsID = ?");
    $pre_stmt->bind_param('i', $prsID);
    $pre_stmt->execute();
    $result = $pre_stmt->get_result();

    if ($result->num_rows >0) {
        $row = $result->fetch_assoc();
    }else{
        header("Location: PRS.php");
        exit();
    }
}

// Check if the Save button is clicked
if (isset($_POST['btn_updatePRS'])) {

    // Handle file upload
    if (isset($_FILES['scannedPRS']) && $_FILES['scannedPRS']['name'] !== '') {
        $file_name = $_FILES['scannedPRS']['name'];
        $file_tmp = $_FILES['scannedPRS']['tmp_name'];
        $file_destination = './PRS Scans/' . $file_name; // Specify the destination directory

        // Move the uploaded file to the destination
        if (move_uploaded_file($file_tmp, $file_destination)) {
            $PRSfile_path = $file_destination; // Set the file path to be stored in the database
        } else {
            // Handle the file upload error, e.g., display an error message
            echo "File upload failed.";
            exit();
        }
    } else {
        // No new file uploaded, retain the existing file path
        $PRSfile_path = $row['scannedPRS'];
    }

    // Retrieve the prsID from the form data
    $prsID = $_GET['prsID'];

    // Retrieve the edited data from the form for WMR properties
    $dateReturnedRecorded = $_POST['dateReturnedRecorded'];
    $ItemNo = $_POST['ItemNo'];
    $prsNumber = $_POST['prsNumber'];
    $article = $_POST['article'];
    $brand = $_POST['brand'];
    $serialNumber = $_POST['serialNumber'];
    $particulars = $_POST['particulars'];
    $areNumber = $_POST['areNumber'];
    $engasNumber = $_POST['engasNumber'];
    $acquisitionDate = $_POST['acquisitionDate'];
    $unitValue = $_POST['unitValue'];
    $balancePerCard = $_POST['balancePerCard'];
    $acquisitionCost = $_POST['acquisitionCost'];
    $propertyNumber = $_POST['propertyNumber'];
    $classification = $_POST['accountnumber'];
    $estLife = $_POST['estLife'];
    $unitOfMeasure = $_POST['unitOfMeasure'];
    $rescenter = $_POST['rescenter'];
    $accountableEmployee = $_POST['accountable_person'];
    $remarks = $_POST['remarks'];
    $iirup = $_POST['iirup'];
    $iirupDate = $_POST['iirupDate'];
    $withAttachment = isset($_POST['withAttachment']) ? "YES" : "NO";
    $withCoverPage = isset($_POST['withCoverPage']) ? "YES" : "NO";

    // Update the database with the edited data for WMR properties
    $update_prs_stmt = $connect->prepare("UPDATE prs_properties SET
        dateReturnedRecorded = ?,
        ItemNo = ?,
        prsNumber = ?,
        article = ?,
        brand = ?,
        serialNumber = ?,
        particulars = ?,
        areNumber = ?,
        engasNumber = ?,
        acquisitionDate = ?,
        unitValue = ?,
        balancePerCard = ?,
        acquisitionCost = ?,
        propertyNumber = ?,
        classification = ?,
        estLife = ?,
        unitOfMeasure = ?,
        responsibilityCenter = ?,
        accountableEmployee = ?,
        remarks = ?,
        withAttachment = ?,
        withCoverPage = ?,
        iirup = ?,
        iirupDate = ?,
        scannedPRS = ?
        WHERE prsID = ?");

    $update_prs_stmt->bind_param('sssssssssssssssssssssssssi',
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
        $unitValue,
        $balancePerCard,
        $acquisitionCost,
        $propertyNumber,
        $classification,
        $estLife,
        $unitOfMeasure,
        $rescenter,
        $accountableEmployee,
        $remarks,
        $withAttachment,
        $withCoverPage,
        $iirup,
        $iirupDate,
        $PRSfile_path,
        $prsID
    );

    if ($update_prs_stmt->execute()) {
        // WMR table updated successfully

        // Check if the user made changes to the mode of disposal or updates current status
        $modeOfDisposal = $_POST['modeofdisposal_options'];
        /*$dateOfSale = $_POST['dateOfSale'];
        $dateOfAuction = $_POST['dateOfAuction'];
        $ORDate = $_POST['ORDate'];
        $ORNumber = $_POST['ORNumber'];
        $amount = $_POST['amount'];
        $transferDate = $_POST['transferDate'];
        $recipient = $_POST['recipient'];
        $partDestroyedOrThrown = $_POST['partDestroyedOrThrown'];
        $notes = $_POST['notes'];*/
        

        // Initialize variables for modeofdisposaltable fields
        $modeOfDisposalValue = null;
        $dateOfSale = null;
        $ORDateNegotiation = null;
        $ORNumberNegotiation = null;
        $amountNegotiation = null;
        $notesNegotiation = null;
        $dateOfAuction = null;
        $ORDateAuction = null;
        $ORNumberAuction = null;
        $amountAuction = null;
        $notesAuction = null;
        $transferDateWithoutCost = null;
        $recipientTransferred = null;
        $notesTransferred = null;
        $transferDateContinued = null;
        $recipientContinued = null;
        $notesContinued = null;
        $partDestroyedOrThrown = null;
        $notesDestroyed = null;

        // Determine which mode of disposal is selected
        if ($modeOfDisposal === 'Destroyed Or Condemned') {
            $modeOfDisposalValue = 'Destroyed Or Condemned';
            $partDestroyedOrThrown = $_POST['part_destroyed_thrown'];
            $notes = $_POST['notesDestroyed'];
        } elseif ($modeOfDisposal === 'Sold Through Negotiation') {
            $modeOfDisposalValue = 'Sold Through Negotiation';
            $dateofSale = $_POST['date_of_sale'];
            $ORDateNegotiation = $_POST['date_of_OR_Negotiation'];
            $ORNumberNegotiation = $_POST['OR_no_Negotiation'];
            $amountNegotiation = $_POST['amountNegotiation'];
            $notesNegotiation = $_POST['notesNegotiation'];
        } elseif ($modeOfDisposal === 'Sold Through Public Auction') {
            $modeOfDisposalValue = 'Sold Through Public Auction';
            $dateOfAuction = $_POST['date_of_auction'];
            $ORDateAuction = $_POST['date_of_OR_Auction'];
            $ORNumberAuction = $_POST['OR_no_Auction'];
            $amountAuction = $_POST['amountAuction'];
            $notesAuction = $_POST['notesAuction'];
        } elseif ($modeOfDisposal === 'Transferred Without Cost') {
            // These two modes share the same fields
            $modeOfDisposalValue = 'Transferred Without Cost';
            $transferDateWithoutCost = $_POST['date_of_transfer'];
            $recipientTransferred = $_POST['recipient_transferred'];
            $notesTransferred = $_POST['notesTransferred'];
        } elseif ($modeOfDisposal === 'Continued In Service') {
            // These two modes share the same fields
            $modeOfDisposalValue = 'Continued In Service';
            $transferDateContinued = $_POST['date_of_transfer_continued'];
            $recipientContinued = $_POST['recipient_transferred'];
            $notesContinued = $_POST['notesContinued'];
        }

        // Check if changes were made to mode of disposal
        if ($modeOfDisposalValue !== null) {
            // Update the modeofdisposaltable
            $update_mode_of_disposal_stmt = $connect->prepare("UPDATE modeofdisposaltable SET
                modeOfDisposal = ?,
                dateOfSale = ?,
                ORDateNegotiation = ?,
                ORNumberNegotiation = ?,
                amountNegotiation = ?,
                notesNegotiation = ?,
                dateOfAuction = ?,
                ORDateAuction = ?,
                ORNumberAuction = ?,
                amountAuction = ?,
                notesAuction = ?,
                transferDateWithoutCost = ?,
                recipientTransferred = ?,
                notesTransferred = ?,
                transferDateContinued = ?,
                recipientContinued = ?,
                notesContinued = ?,
                partDestroyedOrThrown = ?,
                notesDestroyed = ?
                WHERE prsID = ?");
            $update_mode_of_disposal_stmt->bind_param('sssssssssssssssssssi',
                $modeOfDisposalValue,
                $dateOfSale,
                $ORDateNegotiation,
                $ORNumberNegotiation,
                $amountNegotiation,
                $notesNegotiation,
                $dateOfAuction,
                $ORDateAuction,
                $ORNumberAuction,
                $amountAuction,
                $notesAuction,
                $transferDateWithoutCost,
                $recipientTransferred,
                $notesTransferred,
                $transferDateContinued,
                $recipientContinued,
                $notesContinued,
                $partDestroyedOrThrown,
                $notesDestroyed,
                $prsID
            );

            if ($update_mode_of_disposal_stmt->execute()) {
                // Mode of Disposal table updated successfully
            } else {
                // Handle the update error for the modeofdisposaltable
                echo "Error updating modeofdisposaltable: " . $connect->error;
            }
        }

        $currentStatus = $_POST['updates_currentstatus'];

        // Check if changes were made to updates current status
        $currentStatusValue = null;
        $jevNo = null;
        $jevDate = null;
        $actionsToBeTakenDropped = null;
        $actionsToBeTakenExisting = null;

        if ($currentStatus === 'Dropped In Both Records') {
	        $currentStatusValue = 'Dropped In Both Records';
	        $jevNo = $_POST['JEV_no'];
	        $jevDate = $_POST['date_dropped'];
	        $actionsToBeTakenDropped = $_POST['actions_to_be_taken_Dropped'];
	    } elseif ($currentStatus === 'Existing In Inventory Report') {
	        $currentStatusValue = 'Existing In Inventory Report';
	        $actionsToBeTakenExisting = $_GET['actions_to_be_taken_Existing'];
	    }

	    // Update the updatesorcurrentstatus table if changes were made
       if ($currentStatusValue !== null) {
           $update_current_status_stmt = $connect->prepare("UPDATE updatesorcurrentstatus SET
               currentStatus = ?,
               jevNo = ?,
               dateDropped = ?,
               actionsToBeTakenDropped = ?
               WHERE prsID = ?");
           $update_current_status_stmt->bind_param('ssssi',
               $currentStatusValue,
               $jevNo,
               $jevDate,
               $actionsToBeTakenDropped,
               $prsID
           );

           if ($update_current_status_stmt->execute()) {
               // updatesorcurrentstatus table updated successfully
           } else {
               // Handle the update error for the updatesorcurrentstatus table
               echo "Error updating updatesorcurrentstatus: " . $connect->error;
           }
       }

        // Add an activity log entry
            date_default_timezone_set('Asia/Manila');
            $date_now = date('Y-m-d');
            $time_now = date('H:i:s');
            $action = 'Updated an item information in the PRS/WMR table'; // Change the action description as needed
            $employeeid = $_SESSION['employeeid'];

            $log_query = "INSERT INTO activity_log (employeeid, firstname, date_log, time_log, action) VALUES (?,?,?,?,?)";
            $log_stmt = $connect->prepare($log_query);
            $log_stmt->bind_param('issss', $employeeid, $_SESSION['firstname'], $date_now, $time_now, $action);
            
            if ($log_stmt->execute()) {
                // Activity log entry added successfully

                // Redirect to the updated WMR page or display a success message
                $type = $_POST['type'];
                if ($type == 'WMR') {
                    $message = "WMR Updated Successfully";
                    $redirectPage = "WMR.php";
                } elseif ($type == 'PRS') {
                    $message = "PRS Updated Successfully";
                    $redirectPage = "PRS.php";
                } else {
                    $message = "Updated Successfully";
                    $redirectPage = ""; // Redirect to a default page or set it to an empty string if needed
                }

                // Display the modal dialog based on 'type'
                echo '<div id="update-success-modal" class="modal-background">
                    <div class="modal-content">
                        <div class="message">' . $message . '</div>
                        <button class="ok-button" onclick="redirectToPage(\'' . $redirectPage . '\')">OK</button>
                    </div>
                </div>';

                echo '<script type="text/javascript">
                    function redirectToPage(page) {
                        window.location.href = page;
                    }
                </script>';
            } else {
                // Handle the error if adding the activity log entry fails
                echo "Error adding activity log entry: " . $log_stmt->error;
            }
            $log_stmt->close();
        }
    }
?>