<?php
  require('./../database/connection.php');

  $sql = "SELECT
    i.*,
    ac.account_number AS classification,
    COALESCE(co.office_name, no.noffice_name) AS responsibility_center,
    c.condition_name AS current_condition
    FROM
        ics_properties i
    LEFT JOIN
        account_codes ac ON i.classification_id = ac.account_number
    LEFT JOIN
        city_offices co ON i.responsibilitycenter_id = co.office_name
    LEFT JOIN
        national_offices no ON i.responsibilitycenter_id = no.noffice_name
    LEFT JOIN
        conditions c ON i.currentcondition = c.condition_name
    ORDER BY
        i.date_returned DESC";

  $pre_stmt = $connect->prepare($sql) or die(mysqli_error($connect));
  $pre_stmt->execute();
  $result = $pre_stmt->get_result();

  while ($rows = mysqli_fetch_array($result)) {
    $formattedDate = !empty($rows["date_returned"]) ? date("m-d-Y", strtotime($rows["date_returned"])) : "00-00-0000";
    $formattedAcDate = (!empty($rows["acquisitiondate"]) && $rows["acquisitiondate"] != "0000-00-00") ? date("m-d-Y", strtotime($rows["acquisitiondate"])) : "00-00-0000";

    $scannedICSPath = $rows["scannedICS"]; // Path to the scanned ARE document

        // Conditionally create the "View Scanned Supporting document" link
        if (!empty($scannedICSPath)) {
            $scannedICSLink = '<a href="' . $scannedICSPath . '" target="_blank">View Scanned Supporting Document</a>';
        } else {
            $scannedICSLink = ''; // Empty link if scannedARE is null
        }
    ?>
    <tr>
      <td><?php echo $scannedICSLink; ?></td>
      <td><?php echo $formattedDate; ?></td>
      <td><?php echo $rows["article"]; ?></td>
      <td><?php echo $rows["brand"]; ?></td>
      <td><?php echo $rows["serialno"]; ?></td>
      <td><?php echo $rows["particulars"]; ?></td>
      <td><?php echo $rows["PRS_WMR_no"]; ?></td>
      <td><?php echo $rows["eNGAS"]; ?></td>
      <td><?php echo $formattedAcDate; ?></td>
      <td><?php echo $rows["acquisitioncost"]; ?></td>
      <td><?php echo $rows["propertyno"]; ?></td>
      <td><?php echo $rows["classification"]; ?></td>
      <td><?php echo $rows["estimatedlife"]; ?></td>
      <td><?php echo $rows["unitofmeasure"]; ?></td>
      <td><?php echo $rows["unitvalue"]; ?></td>
      <td><?php echo $rows["balance_per_card"]; ?></td>
      <td><?php echo $rows["onhand_per_count"]; ?></td>
      <td><?php echo $rows["so_qty"]; ?></td>
      <td><?php echo $rows["so_value"]; ?></td>
      <td><?php echo $rows["responsibility_center"]; ?></td>
      <td><?php echo $rows["accountable_person"]; ?></td>
      <td><?php echo $rows["previouscondition"]; ?></td>
      <td><?php echo $rows["location"]; ?></td>
      <td><?php echo $rows["current_condition"]; ?></td>
      <td><?php echo $rows["date_of_physical_inventory"]; ?></td>
      <td><?php echo $rows["remarks"]; ?></td>
      <td><?php echo $rows["supplier"]; ?></td>
      <td><?php echo $rows["PO_no"]; ?></td>
      <td><?php echo $rows["AIR_RIS_no"]; ?></td>
      <td><?php echo $rows["notes"]; ?></td>
      <td><?php echo $rows["jevno"]; ?></td>
      <!-- <td>
        <a href="manageactiveSemi_edit.php?ICSequipmentid=<?php echo $rows['ICSequipmentid']; ?>" class="btn btn-primary btn-sm"><i class="fa fa-edit"></i> Edit</a>
      </td> -->
    </tr>
    <?php
  }
?>