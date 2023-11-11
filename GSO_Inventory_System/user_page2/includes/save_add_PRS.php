<?php
$connect = mysqli_connect('localhost', 'root', '', 'db_gso') or die(mysqli_error($connect));

// Validate and sanitize user input (you may need more validation)
function sanitizeInput($input)
{
    return htmlspecialchars(trim($input));
}

if (isset($_POST['btn_PRS_save'])) {

    // Check if the uploaded file is not empty and there are no errors
    if (isset($_FILES['scannedPRS']) && $_FILES['scannedPRS']['error'] == 0) {
        $targetDirectory = './PRS Scans/';
        $targetFile = $targetDirectory . basename($_FILES['scannedPRS']['name']);

        // Check if the file already exists in the target directory
        if (file_exists($targetFile)) {
            echo "The file already exists. Please rename the file and try again.";
        } else {
            // Attempt to move the uploaded file to the target directory
            if (move_uploaded_file($_FILES['scannedPRS']['tmp_name'], $targetFile)) {
                echo "The scanned document has been uploaded successfully.";
                // Store the file path in the database
                $scannedPRS = $targetFile;
            } else {
                echo "Error in uploading the scanned document.";
            }
        }
    }

    $type = sanitizeInput($_POST['type']);
    $dateReturnedRecorded = sanitizeInput($_POST['dateReturnedRecorded']);
    $ItemNo = sanitizeInput($_POST['ItemNo']);
    $prsNumber = sanitizeInput($_POST['prsNumber']);
    $article = strtoupper(sanitizeInput($_POST['article']));
    $brand = strtoupper(sanitizeInput($_POST['brand']));
    $serialNumber = sanitizeInput($_POST['serialNumber']);
    $particulars = sanitizeInput($_POST['particulars']);
    $areNumber = sanitizeInput($_POST['areNumber']);
    $engasNumber = sanitizeInput($_POST['engasNumber']);
    $acquisitionDate = sanitizeInput($_POST['acquisitionDate']);
    $acquisitionCost = sanitizeInput($_POST['acquisitionCost']);
    $propertyNumber = sanitizeInput($_POST['propertyNumber']);
    $classification = sanitizeInput($_POST['accountnumber']);
    $estLife = sanitizeInput($_POST['estLife']);
    $unitOfMeasure = sanitizeInput($_POST['unitOfMeasure']);
    $unitValue = sanitizeInput($_POST['unitValue']);
    $unitValueFormatted = number_format((float) str_replace(',', '', $unitValue), 2, '.', ',');
    $balancePerCard = sanitizeInput($_POST['balancePerCard']);
    $responsibilityCenter = sanitizeInput($_POST['rescenter']);
    $accountableEmployee = sanitizeInput($_POST['accountable_person']);
    $remarks = sanitizeInput($_POST['remarks']);
    $iirup = isset($_POST['iirup']) ? sanitizeInput($_POST['iirup']) : '';
    
    // Check if the value is empty, and set it to NULL in that case
    if (empty($iirup)) {
        $iirup = null;
    }
    
    $iirupDate = sanitizeInput($_POST['iirupDate']);
    
    $modeOfDisposal = isset($_POST['modeofdisposal_options']) ? sanitizeInput($_POST['modeofdisposal_options']) : null;

    // Check if Mode of Disposal is empty, and set it to NULL in that case
    if (empty($modeOfDisposal)) {
        $modeOfDisposal = null;

        // Set additional inputs for each mode of disposal to NULL
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
    } else {
        // Set additional inputs based on the selected mode of disposal
        if ($modeOfDisposal === 'Destroyed Or Condemned') {
            $partDestroyedOrThrown = sanitizeInput($_POST['part_destroyed_thrown']);
            $notesDestroyed = sanitizeInput($_POST['notesDestroyed']);

            // Set additional inputs for other modes to NULL
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
        } elseif ($modeOfDisposal === 'Sold Through Negotiation') {
            $dateOfSale = sanitizeInput($_POST['date_of_sale']);
            $ORDateNegotiation = sanitizeInput($_POST['date_of_OR_Negotiation']);
            $ORNumberNegotiation = sanitizeInput($_POST['OR_no_Negotiation']);
            $amountNegotiation = sanitizeInput($_POST['amountNegotiation']);
            $notesNegotiation = sanitizeInput($_POST['notesNegotiation']);

            // Set additional inputs for other modes to NULL
            $partDestroyedOrThrown = null;
            $notesDestroyed = null;
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
        } elseif ($modeOfDisposal === 'Sold Through Public Auction') {
            $dateOfAuction = sanitizeInput($_POST['date_of_auction']);
            $ORDateAuction = sanitizeInput($_POST['date_of_OR_Auction']);
            $ORNumberAuction = sanitizeInput($_POST['OR_no_Auction']);
            $amountAuction = sanitizeInput($_POST['amountAuction']);
            $notesAuction = sanitizeInput($_POST['notesAuction']);

            // Set additional inputs for other modes to NULL
            $partDestroyedOrThrown = null;
            $notesDestroyed = null;
            $dateOfSale = null;
            $ORDateAuction = null;
            $ORNumberAuction = null;
            $amountAuction = null;
            $notesAuction = null;
            $dateOfSale = null;
            $ORDateNegotiation = null;
            $ORNumberNegotiation = null;
            $amountNegotiation = null;
            $notesNegotiation = null;
            $transferDateWithoutCost = null;
            $recipientTransferred = null;
            $notesTransferred = null;
            $transferDateContinued = null;
            $recipientContinued = null;
            $notesContinued = null;
        } elseif ($modeOfDisposal === 'Transferred Without Cost') {
            $transferDateWithoutCost = sanitizeInput($_POST['date_of_transfer']);
            $recipientTransferred = sanitizeInput($_POST['recipient_transferred']);
            $notesTransferred = sanitizeInput($_POST['notesTransferred']);

            // Set additional inputs for other modes to NULL
            $partDestroyedOrThrown = null;
            $notesDestroyed = null;
            $dateOfSale = null;
            $ORDateAuction = null;
            $ORNumberAuction = null;
            $amountAuction = null;
            $notesAuction = null;
            $dateOfSale = null;
            $ORDateNegotiation = null;
            $ORNumberNegotiation = null;
            $amountNegotiation = null;
            $notesNegotiation = null;
            $transferDateContinued = null;
            $recipientContinued = null;
            $notesContinued = null;
        } elseif ($modeOfDisposal === 'Continued In Service') {
            $transferDateContinued = sanitizeInput($_POST['date_of_transfer_continued']);
            $recipientContinued = sanitizeInput($_POST['recipient_continued']);
            $notesContinued = sanitizeInput($_POST['notesContinued']);

            // Set additional inputs for other modes to NULL
            $partDestroyedOrThrown = null;
            $notesDestroyed = null;
            $dateOfSale = null;
            $ORDateAuction = null;
            $ORNumberAuction = null;
            $amountAuction = null;
            $notesAuction = null;
            $dateOfSale = null;
            $ORDateNegotiation = null;
            $ORNumberNegotiation = null;
            $amountNegotiation = null;
            $notesNegotiation = null;
            $transferDateWithoutCost = null;
            $recipientTransferred = null;
            $notesTransferred = null;
        }
    }

    // Check if Updates/Current Status is empty, and set it to NULL in that case
    $updatesOrCurrentStatus = isset($_POST['updates_currentstatus']) ? sanitizeInput($_POST['updates_currentstatus']) : null;
    if (empty($updatesOrCurrentStatus)) {
        $updatesOrCurrentStatus = null;

        // Set additional inputs for updates or current status to NULL
        $jevNoCurrentStatus = null;
        $dateDropped = null;
        $actionsToBeTakenDropped = null;
        $actionsToBeTakenExisting = null;
    } else {
        if ($updatesOrCurrentStatus === 'Dropped In Both Records') {
            $jevNoCurrentStatus = sanitizeInput($_POST['JEV_no']);
            $dateDropped = sanitizeInput($_POST['date_dropped']);
            $actionsToBeTakenDropped = sanitizeInput($_POST['actions_to_be_taken_Dropped']);
        } elseif ($updatesOrCurrentStatus === 'Existing In Inventory Report') {
            $actionsToBeTakenExisting = sanitizeInput($_POST['actions_to_be_taken_Existing']);
        }
    }

    $check = "SELECT COUNT(*) as ID FROM prs_properties WHERE prsID=?";
    $pre_stmt = $connect->prepare($check) or die(mysqli_error($connect));
    $pre_stmt->bind_param('i', $_POST['prsID']);
    $pre_stmt->execute();
    $result = $pre_stmt->get_result();
    $row = mysqli_fetch_array($result);

    if ($row['ID'] == 0) {
        $sql = "INSERT INTO `prs_properties` (
            `type`,
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
            `classification`,
            `estLife`,
            `unitOfMeasure`,
            `unitValue`,
            `balancePerCard`,
            `responsibilityCenter`,
            `accountableEmployee`,
            `remarks`,
            `iirup`,
            `iirupDate`,
            `scannedPRS`
        ) VALUES (?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?)";

        $pre_stmt = $connect->prepare($sql) or die(mysqli_error($connect));

        $pre_stmt->bind_param('ssssssssssssssssssssssss',
            $type,
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
            $classification,
            $estLife,
            $unitOfMeasure,
            $unitValueFormatted,
            $balancePerCard,
            $responsibilityCenter,
            $accountableEmployee,
            $remarks,
            $iirup,
            $iirupDate,
            $scannedPRS
        );

        if ($pre_stmt->execute()) {
            $prsID = $pre_stmt->insert_id;
            $pre_stmt->close();

            // Set all fields in modeofdisposaltable to NULL
            $modeOfDisposalQuery = "INSERT INTO modeofdisposaltable (
                prsID,
                modeOfDisposal,
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
            ) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)";

            $modeOfDisposalStmt = $connect->prepare($modeOfDisposalQuery);
            $modeOfDisposalStmt->bind_param('isssssssssssssssssss',
                $prsID,
                $modeOfDisposal,
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
                $notesDestroyed
            );

            if ($modeOfDisposalStmt->execute()) {
                // Set all fields in updatesorcurrentstatus to NULL
                $updatesOrCurrentStatusQuery = "INSERT INTO updatesorcurrentstatus (
                    prsID,
                    currentStatus,
                    jevNo,
                    dateDropped,
                    actionsToBeTakenDropped,
                    actionsToBeTakenExisting
                ) VALUES (?, ?, ?, ?, ?, ?)";

                $updatesOrCurrentStatusStmt = $connect->prepare($updatesOrCurrentStatusQuery);
                $updatesOrCurrentStatusStmt->bind_param('ssssss',
                    $prsID,
                    $updatesOrCurrentStatus,
                    $jevNoCurrentStatus,
                    $dateDropped,
                    $actionsToBeTakenDropped,
                    $actionsToBeTakenExisting
                );

                if ($updatesOrCurrentStatusStmt->execute()) {

                    // Activity log entry
                    date_default_timezone_set('Asia/Manila');
                    $date_now = date('Y-m-d');
                    $time_now = date('H:i:s');
                    $action = 'Added a PRS';
                    $employeeid = $_SESSION['employeeid'];

                    $log_query = "INSERT INTO activity_log (employeeid, firstname, date_log, time_log, action) VALUES (?,?,?,?,?)";
                    $log_stmt = $connect->prepare($log_query);
                    $log_stmt->bind_param('issss', $employeeid, $_SESSION['firstname'], $date_now, $time_now, $action);
                    $log_stmt->execute();
                    $log_stmt->close();

                    // Function to display a modal dialog with a message and then redirect
                    function displayModalWithRedirect($message, $redirectPage) {
                        echo '<div class="modal-background">';
                        echo '<div class="modal-content">';
                        echo '<div class="modal-message">' . $message . '</div>';
                        echo '<button class="ok-button" onclick="redirectToPage(\'PRS.php\')">OK</button>';
                        echo '</div>';
                        echo '</div>';
                    }
                    //Show a modal dialog with the messsage and redirect to PRS.php
                    displayModalWithRedirect("Added PRS", "PRS.php");
                } else {
                    echo "Error: " . $updatesOrCurrentStatusStmt->error;
                }
            } else {
                echo "Error: " . $modeOfDisposalStmt->error;
            }
        } else {
            echo "Error:" . $pre_stmt->error;
        }
    } else {
        // Property already exists
        displayModalWithRedirect("PRS already exists", "PRS.php");
    }
}
// JavaScript function to redirect to a page
echo '<script type="text/javascript">
    function redirectToPage(page) {
        window.location.href = page;
    }
</script>';
?>