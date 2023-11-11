<?php
require('./../database/connection.php');

$sql = "SELECT
    p.*,
    ac.account_number AS classification,
    COALESCE(co.office_name, no.noffice_name) AS responsibility_center,
    e.employeeName AS accountableEmployee,
    md.modeOfDisposal,
    md.dateOfSale,
    md.ORDateNegotiation,
    md.ORNumberNegotiation,
    md.amountNegotiation,
    md.notesNegotiation,
    md.dateOfAuction,
    md.ORDateAuction,
    md.ORNumberAuction,
    md.amountAuction,
    md.notesAuction,
    md.transferDateWithoutCost,
    md.recipientTransferred,
    md.notesTransferred,
    md.transferDateContinued,
    md.recipientContinued,
    md.notesContinued,
    md.partDestroyedOrThrown,
    md.notesDestroyed,
    ucs.currentStatus,
    ucs.jevNo,
    ucs.dateDropped,
    ucs.actionsToBeTakenDropped,
    ucs.actionsTobeTakenExisting
FROM
    prs_properties p
LEFT JOIN
    account_codes ac ON p.classification = ac.account_number
LEFT JOIN
    city_offices co ON p.responsibilityCenter = co.office_name
LEFT JOIN
    national_offices no ON p.responsibilityCenter = no.noffice_name
LEFT JOIN
    employees e ON p.accountableEmployee = e.employeeName
LEFT JOIN
    modeofdisposaltable md ON p.prsID = md.prsID
LEFT JOIN
    updatesorcurrentstatus ucs ON p.prsID = ucs.prsID
WHERE
    p.type = 'WMR'
ORDER BY
    p.dateReturnedRecorded DESC";

$pre_stmt = $connect->prepare($sql) or die(mysqli_error($connect));
$pre_stmt->execute();
$result = $pre_stmt->get_result();

while ($rows = mysqli_fetch_array($result)) {
    $formattedDate = ($rows["dateReturnedRecorded"] != "0000-00-00" && !is_null($rows["dateReturnedRecorded"])) ? date("m-d-Y", strtotime($rows["dateReturnedRecorded"])) : " ";
       $formattedAcDate = ($rows["acquisitionDate"] != "0000-00-00" && !is_null($rows["acquisitionDate"])) ? date("m-d-Y", strtotime($rows["acquisitionDate"])) : " ";

    $formattedDateOfSale = ($rows["dateOfSale"] != "0000-00-00") ? date("m-d-Y", strtotime($rows["dateOfSale"])) : "00-00-0000";
    $formattedDateOfAuction = ($rows["dateOfAuction"] != "0000-00-00") ? date("m-d-Y", strtotime($rows["dateOfAuction"])) : " ";
    $formattedORDateNegotiation = ($rows["ORDateNegotiation"] && $rows["ORDateNegotiation"] !== "0000-00-00") ? date("m-d-Y", strtotime($rows["ORDateNegotiation"])) : "";
    $formattedORDateAuction = ($rows["ORDateAuction"] && $rows["ORDateAuction"] !== "0000-00-00") ? date("m-d-Y", strtotime($rows["ORDateAuction"])) : "";
    $formattediirupDate = ($rows["iirupDate"] && $rows["iirupDate"] !== "0000-00-00") ? date("m-d-Y", strtotime($rows["iirupDate"])) : "";

    $scannedPRS = $rows["scannedPRS"]; // Path to the scanned ARE document

        // Conditionally create the "View Scanned Supporting document" link
        if (!empty($scannedPRS)) {
            $scannedPRS = '<a href="' . $scannedPRS . '" target="_blank">View Scanned Supporting document</a>';
        } else {
            $scannedPRS = ''; // Empty link if scannedARE is null
        }

    $disposalRemarks = '';

    if ($rows['modeOfDisposal'] === "Destroyed Or Condemned") {
            $disposalRemarks = ($rows['notesDestroyed'] !== null) ? $rows['notesDestroyed'] : '';
        } elseif ($rows['modeOfDisposal'] === 'Transferred Without Cost') {
            $disposalRemarks .= "Date of Transfer: " . date("m-d-Y", strtotime($rows['transferDateWithoutCost'])) . " ; Recipient: " . $rows['recipientTransferred'];
        
            // Check if notesTransferred is not empty and include it
            if (!empty($rows['notesTransferred'])) {
                $disposalRemarks .= " ; Notes: " . $rows['notesTransferred'];
                }
        } elseif ($rows['modeOfDisposal'] === 'Continued In Service') {
            $disposalRemarks .= "Date of Transfer: " . date("m-d-Y", strtotime($rows['transferDateContinued'])) . " ; Recipient: " . $rows['recipientContinued'];
        
            // Check if notesContinued is not empty and include it
            if (!empty($rows['notesContinued'])) {
                $disposalRemarks .= " ; Notes: " . $rows['notesContinued'];
            }
        } elseif ($rows['modeOfDisposal'] === "Sold Through Negotiation") {
            $disposalRemarks = ($rows['notesNegotiation'] !== null) ? $rows['notesNegotiation'] : '';
        } elseif ($rows['modeOfDisposal'] === "Sold Through Public Auction") {
            $disposalRemarks = ($rows['notesAuction'] !== null) ? $rows['notesAuction'] : '';
        }
    
    $statusRemarks = '';

    if ($rows['currentStatus'] === "Dropped In Both Records") {
        $statusRemarks = "JEV Number: " . $rows['jevNo'] . " ; JEV Dated: " . date("m-d-Y", strtotime($rows['dateDropped']));
    } elseif ($rows['currentStatus'] === "Existing In Inventory Report") {
        $statusRemarks = $rows['actionsTobeTakenExisting'];
    }

        $editLink = "prsTableEdit.php?prsID=".$rows['prsID'];

    ?>
    <tr>
      <td style="display:none;"><?php echo $rows["type"]; ?></td>
      <td><?php echo $scannedPRS; ?></td>
      <td><?php echo $formattedDate; ?></td>
      <td><?php echo $rows["ItemNo"]; ?></td>
      <td><?php echo $rows["prsNumber"]; ?></td>
      <td><?php echo $rows["article"]; ?></td>
      <td><?php echo $rows["brand"]; ?></td>
      <td><?php echo $rows["serialNumber"]; ?></td>
      <td><?php echo $rows["particulars"]; ?></td>
      <td><?php echo $rows["areNumber"]; ?></td>
      <td><?php echo $rows["engasNumber"]; ?></td>
      <td><?php echo $formattedAcDate; ?></td>
      <td><?php echo $rows["acquisitionCost"]; ?></td>
      <td><?php echo $rows["propertyNumber"]; ?></td>
      <td><?php echo $rows["classification"]; ?></td>
      <td><?php echo $rows["estLife"]; ?></td>
      <td><?php echo $rows["unitOfMeasure"]; ?></td>
      <td><?php echo $rows["unitValue"]; ?></td>
      <td><?php echo $rows["balancePerCard"]; ?></td>
      <td><?php echo $rows["responsibility_center"]; ?></td>
      <td><?php echo $rows["accountableEmployee"]; ?></td>
      <td><?php echo $rows["remarks"]; ?></td>
      <td><?php echo $rows["iirup"]; ?></td>
      <td><?php echo $formattediirupDate; ?></td>
      <td><?php echo $rows["modeOfDisposal"]; ?></td>
      <td>
          <?php
          if ($rows["modeOfDisposal"] === "Sold Through Negotiation") {
              echo isset($rows["dateOfSale"]) ? date("m-d-Y", strtotime($rows["dateOfSale"])) : "";
          } elseif ($rows["modeOfDisposal"] === "Sold Through Public Auction") {
              echo isset($rows["dateOfAuction"]) ? date("m-d-Y", strtotime($rows["dateOfAuction"])) : "";
          }
          ?>
      </td>
      <td>
          <?php
          if ($rows["modeOfDisposal"] === "Sold Through Negotiation" || $rows["modeOfDisposal"] === "Sold Through Public Auction") {
              echo isset($rows["ORDateNegotiation"]) ? date("m-d-Y", strtotime($rows["ORDateNegotiation"])) : "";
          }
          ?>
      </td>
      <td>
          <?php
          if ($rows["modeOfDisposal"] === "Sold Through Negotiation" || $rows["modeOfDisposal"] === "Sold Through Public Auction") {
              echo isset($rows["ORNumberNegotiation"]) ? $rows["ORNumberNegotiation"] : "";
          }
          ?>
      </td>
      <td>
          <?php
          if ($rows["modeOfDisposal"] === "Sold Through Negotiation" || $rows["modeOfDisposal"] === "Sold Through Public Auction") {
              echo isset($rows["amountNegotiation"]) ? $rows["amountNegotiation"] : "";
          }
          ?>
      </td>

      <td><?php echo $rows["partDestroyedOrThrown"]; ?></td>
      <td><?php echo $disposalRemarks; ?></td>
      <td><?php echo $rows["currentStatus"]; ?></td>
      <td><?php echo $statusRemarks; ?></td>
      <!-- <td>
        <a href="<?php echo $editLink; ?>" class="btn btn-primary btn-sm"><i class="fa fa-edit"></i> Edit</a>
      </td> -->
    </tr>
    <?php
  }
?>