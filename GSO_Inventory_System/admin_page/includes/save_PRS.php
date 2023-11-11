<?php
$connect = mysqli_connect('localhost', 'root', '', 'db_gso') or die(mysqli_error($connect));

// Validate and sanitize user input (you may need more validation)
function sanitizeInput($input)
{
    return htmlspecialchars(trim($input));
}

/*if ($_SERVER['REQUEST_METHOD'] === 'POST') {*/
   if (isset($_POST['btn_PRS_save'])) {
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
    /*$onhandPerCount = sanitizeInput($_POST['onhandPerCount']);
    $soQty = sanitizeInput($_POST['soQty']);
    $soValue = sanitizeInput($_POST['soValue']);*/
    $responsibilityCenter = sanitizeInput($_POST['rescenter']);
    /*$accountableEmployee = isset($_POST['accountable_options']) ? sanitizeInput($_POST['accountable_options']) : '';*/
    $accountableEmployee = sanitizeInput($_POST['accountable_person']);
    $remarks = sanitizeInput($_POST['remarks']);
    $iirup = isset($_POST['iirup']) ? sanitizeInput($_POST['iirup']) : ''; // Capture the selected value
        // Check if the value is empty, and set it to NULL in that case
            if (empty($iirup)) {
                $iirup = null;
            }
    $iirupDate = sanitizeInput($_POST['iirupDate']);
    /*$withAttachment = isset($_POST['withAttachment']) ? 'With MR/ARE Attachment' : 'NO MR/ARE Attachment';
    $prsCoverPage = isset($_POST['prsCoverPage']) ? 'With PRS Cover Page' : 'NO PRS Cover Page';*/
    $modeOfDisposal = isset($_POST['modeofdisposal_options']) ? sanitizeInput($_POST['modeofdisposal_options']) : '';
    $updatesOrCurrentStatus = isset($_POST['updates_currentstatus']) ? sanitizeInput($_POST['updates_currentstatus']) : '';

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
            /*`onhandPerCount`,
            `soQty`,
            `soValue`,*/
            `responsibilityCenter`,
            `accountableEmployee`,
            `remarks`,
            /*`withAttachment`,
            `prsCoverPage`,*/
            `iirup`,
            `iirupDate`
        ) VALUES (?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?)";

        $pre_stmt = $connect->prepare($sql) or die(mysqli_error($connect));

        $pre_stmt->bind_param('sssssssssssssssssssssss',
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
            /*$onhandPerCount,
            $soQty,
            $soValue,*/
            $responsibilityCenter,
            $accountableEmployee,
            $remarks,
            /*$withAttachment,
            $prsCoverPage,*/
            $iirup,
            $iirupDate
        );

        if ($pre_stmt->execute()) {
            $prsID = $pre_stmt->insert_id;
            $pre_stmt->close();

            // Encapsulate disposal method logic into a function
            function insertDisposalMethod($connect, $prsID, $modeOfDisposal)
            {
                if ($modeOfDisposal === 'Destroyed Or Condemned') {
                    $partDestroyedOrThrown = sanitizeInput($_POST['part_destroyed_thrown']);
                    $notesDestroyed = sanitizeInput($_POST['notesDestroyed']);

                    $modeOfDisposalQuery = "INSERT INTO modeofdisposaltable (
                        prsID,
                        modeOfDisposal,
                        partDestroyedOrThrown,
                        notes)
                        VALUES (?, ?, ?, ?)";
                    $modeOfDisposalStmt = $connect->prepare($modeOfDisposalQuery);
                    $modeOfDisposalStmt->bind_param('isss',
                        $prsID,
                        $modeOfDisposal,
                        $partDestroyedOrThrown,
                        $notesDestroyed);
                    if ($modeOfDisposalStmt->execute()) {
                        echo '<script type="text/javascript">alert("Added a PRS"); window.location = "PRS.php";</script>';
                    } else {
                        echo "Error: " . $modeOfDisposalStmt->error;
                    }
                } elseif ($modeOfDisposal === 'Sold Through Negotiation') {
                    $dateOfSale = sanitizeInput($_POST['date_of_sale']);
                    $ORDate = sanitizeInput($_POST['date_of_OR_Negotiation']);
                    $ORNumber = sanitizeInput($_POST['OR_no_Negotiation']);
                    $amount = sanitizeInput($_POST['amountNegotiation']);
                    $notesNegotiation = sanitizeInput($_POST['notesNegotiation']);

                    $modeOfDisposalQuery = "INSERT INTO modeofdisposaltable (
                        prsID,
                        modeOfDisposal,
                        dateOfSale,
                        ORDate,
                        ORNumber,
                        amount,
                        notes)
                        VALUES (?, ?, ?, ?, ?, ?,?)";
                    $modeOfDisposalStmt = $connect->prepare($modeOfDisposalQuery);
                    $modeOfDisposalStmt->bind_param('issssss',
                        $prsID,
                        $modeOfDisposal,
                        $dateOfSale,
                        $ORDate,
                        $ORNumber,
                        $amount,
                        $notesNegotiation);
                    if ($modeOfDisposalStmt->execute()) {
                        echo '<script type="text/javascript">alert("Added a PRS"); window.location = "PRS.php";</script>';
                    } else {
                        echo "Error: " . $modeOfDisposalStmt->error;
                    }
                } elseif ($modeOfDisposal === 'Sold Through Public Auction') {
                    $dateOfAuction = sanitizeInput($_POST['date_of_auction']);
                    $ORDate = sanitizeInput($_POST['date_of_OR_Auction']);
                    $ORNumber = sanitizeInput($_POST['OR_no_Auction']);
                    $amount = sanitizeInput($_POST['amountAuction']);
                    $notesAuction = sanitizeInput($_POST['notesAuction']);

                    $modeOfDisposalQuery = "INSERT INTO modeofdisposaltable (
                        prsID,
                        modeOfDisposal,
                        dateOfAuction,
                        ORDate,
                        ORNumber,
                        amount,
                        notes)
                        VALUES (?, ?, ?, ?, ?, ?,?)";
                    $modeOfDisposalStmt = $connect->prepare($modeOfDisposalQuery);
                    $modeOfDisposalStmt->bind_param('issssss',
                        $prsID,
                        $modeOfDisposal,
                        $dateOfAuction,
                        $ORDate,
                        $ORNumber,
                        $amount,
                        $notesAuction);
                    if ($modeOfDisposalStmt->execute()) {
                        echo '<script type="text/javascript">alert("Added a PRS"); window.location = "PRS.php";</script>';
                    } else {
                        echo "Error: " . $modeOfDisposalStmt->error;
                    }
                } elseif ($modeOfDisposal === 'Transferred Without Cost') {
                    $dateOfTransferWithoutCost = sanitizeInput($_POST['date_of_transfer']);
                    $recipientTransferred = sanitizeInput($_POST['recipient_transferred']);
                    $notesTransferred = sanitizeInput($_POST['notesTransferred']);

                    $modeOfDisposalQuery = "INSERT INTO modeofdisposaltable (
                        prsID,
                        modeOfDisposal,
                        transferDate,
                        recipient,
                        notes)
                        VALUES (?, ?, ?, ?,?)";
                    $modeOfDisposalStmt = $connect->prepare($modeOfDisposalQuery);
                    $modeOfDisposalStmt->bind_param('issss',
                        $prsID,
                        $modeOfDisposal,
                        $dateOfTransferWithoutCost,
                        $recipientTransferred,
                        $notesTransferred);

                    if ($modeOfDisposalStmt->execute()) {
                        echo '<script type="text/javascript">alert("Added a PRS"); window.location = "PRS.php";</script>';
                    } else {
                        echo "Error: " . $modeOfDisposalStmt->error;
                    }
                } elseif ($modeOfDisposal === 'Continued In Service') {
                    $transferredDateContinued = sanitizeInput($_POST['date_of_transfer_continued']);
                    $recipientContinued = sanitizeInput($_POST['recipient_continued']);
                    $notesContinued = sanitizeInput($_POST['notesContinued']);

                    $modeOfDisposalQuery = "INSERT INTO modeofdisposaltable (
                        prsID,
                        modeOfDisposal,
                        transferDate,
                        recipient,
                        notes)
                        VALUES (?, ?, ?, ?,?)";
                    $modeOfDisposalStmt = $connect->prepare($modeOfDisposalQuery);
                    $modeOfDisposalStmt->bind_param('issss',
                        $prsID,
                        $modeOfDisposal,
                        $transferredDateContinued,
                        $recipientContinued,
                        $notesContinued);

                    if ($modeOfDisposalStmt->execute()) {
                        echo '<script type="text/javascript">alert("Added a PRS"); window.location = "PRS.php";</script>';
                    } else {
                        echo "Error: " . $modeOfDisposalStmt->error;
                    }
                }
            }

            // Call the function to insert disposal method data
            insertDisposalMethod($connect, $prsID, $modeOfDisposal);

            // Insert updates or current status data
            if ($updatesOrCurrentStatus === 'Dropped In Both Records') {
                $jevNoCurrentStatus = sanitizeInput($_POST['JEV_no']);
                $dateDropped = sanitizeInput($_POST['date_dropped']);
                $actionsToBeTaken = sanitizeInput($_POST['actions_to_be_taken_Dropped']);
                $dateDropped = sanitizeInput($_POST['date_dropped']);

                $currentStatusQuery = "INSERT INTO updatesorcurrentstatus (
                    prsID,
                    currentStatus,
                    jevNo,
                    dateDropped,
                    actionsToBeTaken
                    )
                    VALUES (?, ?, ?,?,?)";
                $currentStatusStmt = $connect->prepare($currentStatusQuery);
                $currentStatusStmt->bind_param('issss',
                    $prsID,
                    $updatesOrCurrentStatus,
                    $jevNoCurrentStatus,
                    $dateDropped,
                    $actionsToBeTaken);

                if ($currentStatusStmt->execute()) {
                    echo '<script type="text/javascript">alert("Added a PRS"); window.location = "PRS.php";</script>';
                } else {
                    echo "Error: " . $currentStatusStmt->error;
                }
            } elseif ($updatesOrCurrentStatus === 'Existing In Inventory Report') {
                $actionsToBeTakenExisting = sanitizeInput($_POST['actions_to_be_taken_Existing']);

                $currentStatusQuery = "INSERT INTO updatesorcurrentstatus (
                    prsID,
                    currentStatus,
                    actionsToBeTaken
                    )
                    VALUES (?, ?,?)";
                $currentStatusStmt = $connect->prepare($currentStatusQuery);
                $currentStatusStmt->bind_param('iss',
                    $prsID,
                    $updatesOrCurrentStatus,
                    $actionsToBeTakenExisting);

                if ($currentStatusStmt->execute()) {
                    echo '<script type="text/javascript">alert("Added a PRS"); window.location = "PRS.php";</script>';
                } else {
                    echo "Error: " . $currentStatusStmt->error;
                }
            }
        } else {
            echo "Error:" . $pre_stmt->error;
        }
    }else{
       echo '<script type="text/javascript">alert("Added a PRS"); window.location = "PRS.php";</script>'; 
    }
}
/*}*/
?>