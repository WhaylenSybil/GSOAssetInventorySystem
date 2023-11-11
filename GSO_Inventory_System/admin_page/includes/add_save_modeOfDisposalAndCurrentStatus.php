<?php
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // ... your existing code ...

    if (isset($_POST['btn_PRS_save'])) {
        // ... your existing code ...

        // Get the selected mode of disposal
        $modeOfDisposal = isset($_POST['modeofdisposal']) ? $_POST['modeofdisposal'] : '';

        // Get the selected current status
        $currentStatus = isset($_POST['updates_currentstatus']) ? $_POST['updates_currentstatus'] : '';

        // Save the mode of disposal and current status to prs_properties table
        $sql = "INSERT INTO prs_properties (modeofDisposal, currentStatus) VALUES (?, ?)";
        $stmt = $connect->prepare($sql);
        $stmt->bind_param('ss', $modeOfDisposal, $currentStatus);

        if ($stmt->execute()) {
            // Retrieve the prsID of the newly inserted PRS property
            $prsID = $stmt->insert_id;

            // Close the prepared statement
            $stmt->close();

            // ... your existing code ...

            // Insert data into the mode of disposal table (modeofdisposaltable)
            if ($modeOfDisposal === 'By Destructoin or Condemnation') {
                $supplier = isset($_POST['supplier']) ? $_POST['supplier'] : '';
                $poNo = isset($_POST['PO_no']) ? $_POST['PO_no'] : '';
                $airRisNo = isset($_POST['AIR_RIS_no']) ? $_POST['AIR_RIS_no'] : '';
                $jevNo = isset($_POST['JEV']) ? $_POST['JEV'] : '';
                $partDestroyedThrown = isset($_POST['part_destroyed_thrown']) ? $_POST['part_destroyed_thrown'] : '';
                $notes = isset($_POST['notes']) ? $_POST['notes'] : '';

                $modeOfDisposalQuery = "INSERT INTO modeofdisposaltable (prsID, supplier, poNo, airRisNo, jevNo, partDestroyedThrown, notes) VALUES (?, ?, ?, ?, ?, ?, ?)";
                $modeOfDisposalStmt = $connect->prepare($modeOfDisposalQuery);
                $modeOfDisposalStmt->bind_param('issssss', $prsID, $supplier, $poNo, $airRisNo, $jevNo, $partDestroyedThrown, $notes);

                if ($modeOfDisposalStmt->execute()) {
                    // Mode of Disposal data successfully inserted
                } else {
                    // Error inserting Mode of Disposal data
                    echo "Error: " . $modeOfDisposalStmt->error;
                }
            }elseif ($modeOfDisposal === 'Sold Through Negotiation') {
                $dateOfSale = isset($_POST['dateOfSale']) ? $_POST['dateOfSale']:'';
                $ORDate = isset($_POST['ORDate']) ? $_POST['ORDate']:'';
                $ORNumber = isset($_POST['ORNumber']) ? $_POST['ORNumber'] : '';
                $amount = isset($_POST['amount']) ? $_POST['amount'] : '';
                $partDestroyedThrown = isset($_POST['part_destroyed_thrown']) ? $_POST['part_destroyed_thrown'] : '';
                $notes = isset($_POST['notes']) ? $_POST['notes'] : '';

                $modeOfDisposalQuery = "INSERT INTO modeofdisposaltable (prsID, dateOfSale, ORDate, ORNumber, amount,partDestroyedThrown, notes) VALUES (?, ?, ?, ?, ?, ?, ?)";
                $modeOfDisposalStmt = $connect->prepare($modeOfDisposalQuery);
                $modeOfDisposalStmt->bind_param('issssss', $prsID, $supplier, $poNo, $airRisNo, $jevNo, $partDestroyedThrown, $notes);

                if ($modeOfDisposalStmt->execute()) {
                    echo "Data successfully inserted.";
                } else {
                    // Error inserting Mode of Disposal data
                    echo "Error: " . $modeOfDisposalStmt->error;
                }
            }elseif ($modeOfDisposal === 'Sold Thrugh Public Auction') {
                $dateOfAuction = isset($_POST['dateOfAuction']) ? $_POST['dateOfAuction']:'';
                $ORDate = isset($_POST['ORDate']) ? $_POST['ORDate']:'';
                $ORNumber = isset($_POST['ORNumber']) ? $_POST['ORNumber'] : '';
                $amount = isset($_POST['amount']) ? $_POST['amount'] : '';
                $partDestroyedThrown = isset($_POST['part_destroyed_thrown']) ? $_POST['part_destroyed_thrown'] : '';
                $notes = isset($_POST['notes']) ? $_POST['notes'] : '';

                $modeOfDisposalQuery = "INSERT INTO modeofdisposaltable (prsID, dateOfAuction, ORDate, ORNumber, amount,partDestroyedThrown, notes) VALUES (?, ?, ?, ?, ?, ?, ?)";
                $modeOfDisposalStmt = $connect->prepare($modeOfDisposalQuery);
                $modeOfDisposalStmt->bind_param('issssss', $prsID, $supplier, $poNo, $airRisNo, $jevNo, $partDestroyedThrown, $notes);

                if ($modeOfDisposalStmt->execute()) {
                    echo "Data successfully inserted.";
                } else {
                    // Error inserting Mode of Disposal data
                    echo "Error: " . $modeOfDisposalStmt->error;
                }
            }elseif($modeOfDisposal === 'Transfer without Cost to Other Offices/Departments, and to Other Agencies'){
                $dateOfTransferWithoutCost = isset($_POST['dateOfTransferWithoutCost']) ? $_POST['dateOfTransferWithoutCost']:'';
                $recipient = isset($_POST['recipient']) ? $_POST['recipient']:'';

                $modeOfDisposalQuery = "INSERT INTO modeofdisposaltable (prsID, dateOfTransferWithoutCost, recipient) VALUES (?, ?, ?)";
                $modeOfDisposalStmt = $connect->prepare($modeOfDisposalQuery);
                $modeOfDisposalStmt->bind_param('iss', $prsID, $dateOfTransferWithoutCost, $recipient);

                if ($modeOfDisposalStmt->execute()) {
                    echo "Data successfully inserted.";
                } else {
                    // Error inserting Mode of Disposal data
                    echo "Error: " . $modeOfDisposalStmt->error;
                }
            }elseif ($modeOfDisposal === 'Continued in Service') {
               $transferredDateContinued = isset($_POST['transferredDateContinued']) ? $_POST['transferredDateContinued']:'';
               $recipient = isset($_POST['recipient']) ? $_POST['recipient']:'';

               $modeOfDisposalQuery = "INSERT INTO modeofdisposaltable (prsID, transferredDateContinued, recipient) VALUES (?, ?, ?)";
               $modeOfDisposalStmt = $connect->prepare($modeOfDisposalQuery);
               $modeOfDisposalStmt->bind_param('iss', $prsID, $transferredDateContinued, $recipient);

               if ($modeOfDisposalStmt->execute()) {
                   echo "Data successfully inserted.";
               } else {
                   // Error inserting Mode of Disposal data
                   echo "Error: " . $modeOfDisposalStmt->error;
               } 
            }

            // ... your existing code ...

            // Insert data into the updates or current status table (updatesorcurrentstatus)
            if ($currentStatus === 'dropped_record') {
                $jevNo = isset($_POST['JEV_no']) ? $_POST['JEV_no'] : '';
                $dateDropped = isset($_POST['date_dropped']) ? $_POST['date_dropped'] : '';

                $currentUpdatesQuery = "INSERT INTO updatesorcurrentstatus (prsID, droppedInBothRecords, existingInInventoryReports, actionToBeTaken, jevNo, dateDropped) VALUES (?, ?, ?, ?, ?, ?)";
                $currentUpdatesStmt = $connect->prepare($currentUpdatesQuery);
                $currentUpdatesStmt->bind_param('isssss', $prsID, $currentStatus, '', '', $jevNo, $dateDropped);

                if ($currentUpdatesStmt->execute()) {
                    echo "Data successfully inserted.";
                } else {
                    // Error inserting Current Updates data
                    echo "Error: " . $currentUpdatesStmt->error;
                }
            } elseif ($currentStatus === 'existing_record') {
                echo "Data successfully inserted.";
                // Handle existing_record case if needed
                // You can add code to insert data for this case here
            }

            // ... your existing code ...
        } else {
            // Error inserting data into prs_properties table
            echo "Error: " . $stmt->error;
        }

        // Close prepared statement
        $stmt->close();
    }
}
?>