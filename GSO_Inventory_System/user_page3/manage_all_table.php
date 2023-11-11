<?php
require('./../database/connection.php');

$sql = "SELECT
            a.equipmentid AS eqID,
            a.date_recorded AS date,
            a.article,
            a.brand,
            a.serialno,
            a.particulars,
            a.AREno AS ARE_PRS_number,
            a.eNGAS,
            a.acquisitiondate,
            a.acquisitioncost,
            a.propertyno,
            ac.account_number AS classification,
            a.estimatedlife,
            a.unitofmeasure,
            a.unitvalue,
            a.balance_per_card,
            a.onhand_per_count,
            a.so_qty,
            a.so_value,
            COALESCE(co.office_name, no.noffice_name) AS responsibility_center,
            a.accountable_person,
            a.previouscondition,
            a.location,
            c.condition_name AS current_condition,
            a.date_of_physical_inventory,
            a.remarks,
            a.supplier,
            a.PO_no,
            a.AIR_RIS_no,
            a.notes,
            a.jevno,
            a.scannedARE AS scannedDocs
        FROM
            are_properties a
        LEFT JOIN
            account_codes ac ON a.classification_id = ac.account_number
        LEFT JOIN
            city_offices co ON a.responsibilitycenter_id = co.office_name
        LEFT JOIN
            national_offices no ON a.responsibilitycenter_id = no.noffice_name
        LEFT JOIN
            conditions c ON a.currentconditionid = c.condition_name
        UNION
        SELECT
            i.ICSequipmentid AS eqID,
            i.date_returned AS date,
            i.article,
            i.brand,
            i.serialno,
            i.particulars,
            i.eNGAS,
            i.PRS_WMR_no AS ARE_PRS_number,
            i.acquisitiondate,
            i.acquisitioncost,
            i.propertyno,
            ac.account_number AS classification,
            i.estimatedlife,
            i.unitofmeasure,
            i.unitvalue,
            i.balance_per_card,
            i.onhand_per_count,
            i.so_qty,
            i.so_value,
            COALESCE(co.office_name, no.noffice_name) AS responsibility_center,
            i.accountable_person,
            i.previouscondition,
            i.location,
            c.condition_name AS current_condition,
            i.date_of_physical_inventory,
            i.remarks,
            i.supplier,
            i.PO_no,
            i.AIR_RIS_no,
            i.notes,
            i.jevno,
            i.scannedICS AS scannedDocs
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
            date DESC";

$pre_stmt = $connect->prepare($sql) or die(mysqli_error());
$pre_stmt->execute();
$result = $pre_stmt->get_result();


while ($rows = mysqli_fetch_array($result)) {
    $formattedDate =(!empty($rows["date"]) && $rows["date"] != "0000-00-00") ? date("m-d-Y", strtotime($rows["date"])) : "00-00-0000";
    $formattedAcDate = (!empty($rows["acquisitiondate"]) && $rows["acquisitiondate"] != "0000-00-00") ? date("m-d-Y", strtotime($rows["acquisitiondate"])) : "00-00-0000";
    $scannedDocsPath = $rows["scannedDocs"]; // Path to the scanned ARE document

        // Conditionally create the "View Scanned Supporting document" link
        if (!empty($scannedDocsPath)) {
            $scannedDocsLink = '<a href="' . $scannedDocsPath . '" target="_blank">View Scanned Supporting Document</a>';
        } else {
            $scannedDocsLink = ''; // Empty link if scannedARE is null
        }
    ?>
    <tr>
      <td><?php echo $scannedDocsLink; ?></td>
      <td><?php echo $formattedDate; ?></td>
      <td><?php echo $rows["article"]; ?></td>
      <td><?php echo $rows["brand"]; ?></td>
      <td><?php echo $rows["serialno"]; ?></td>
      <td><?php echo $rows["particulars"]; ?></td>
      <td><?php echo $rows["ARE_PRS_number"]; ?></td>
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
        <a href="manage_allcategories_edit.php?eqID=<?php echo $rows['eqID']; ?>" class="btn btn-primary btn-sm"><i class="fa fa-edit"></i> Edit</a>
      </td> -->
    </tr>
    <?php
  }
?>