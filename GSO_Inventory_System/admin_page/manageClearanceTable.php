<?php
  require('./../database/connection.php');

  $sql = "SELECT
        c.*,
        cp.purposeName,
        UPPER(CASE
                WHEN c.classification IN ('City Office', 'National Office') THEN COALESCE(co.office_name, no.noffice_name)
                ELSE COALESCE(co.office_name, no.noffice_name, elem.elemName, high.highSchoolName, b.barangayName)
            END) AS responsibilityCenter,
        e.employeeName
        FROM
            clearance c
        LEFT JOIN
            clearancepurpose cp ON c.purpose = cp.purposeName
        LEFT JOIN
            city_offices co ON c.responsibilityCenter = co.office_name
        LEFT JOIN
            national_offices no ON c.responsibilityCenter = no.noffice_name
        LEFT JOIN
            barangay b ON c.responsibilityCenter = b.barangayName
        LEFT JOIN
            elementary elem ON c.responsibilityCenter = elem.elemName
        LEFT JOIN
            highschool high ON c.responsibilityCenter = high.highSchoolName
        LEFT JOIN
            employees e ON c.employeeName = e.employeeName
        ORDER BY
            SUBSTRING_INDEX(c.controlNo, '-', 1) ASC,
            CAST(SUBSTRING_INDEX(SUBSTRING_INDEX(c.controlNo, '-', -1), '-', 1) AS SIGNED) ASC";

  $pre_stmt = $connect->prepare($sql) or die(mysqli_error($connect));
  $pre_stmt->execute();
  $result = $pre_stmt->get_result();

  while ($rows = mysqli_fetch_array($result)) {
    $formattedDateCleared = (!empty($rows["dateCleared"]) && $rows["dateCleared"] != "0000-00-00") ? date("m-d-Y", strtotime($rows["dateCleared"])) : "00-00-0000";

    $scannedClearance = $rows["scannedCopy"]; // Path to the scanned ARE document

        // Conditionally create the "View Scanned Supporting document" link
        if (!empty($scannedClearance)) {
            $scannedClearanceLink = '<a href="' . $scannedClearance . '" target="_blank">View Scanned Document</a>';
        } else {
            $scannedClearanceLink = ''; // Empty link if scannedARE is null
        }
    ?>
    <tr>
      <td><?php echo $formattedDateCleared; ?></td>
      <td><?php echo $rows["controlNo"]; ?></td>
      <td><?php echo $scannedClearanceLink; ?></td>
      <td><?php echo $rows["employeeName"]; ?></td>
      <td><?php echo $rows["position"]; ?></td>
      <td><?php echo $rows["classification"]; ?></td>
      <td><?php echo $rows["responsibilityCenter"]; ?></td>
      <td><?php echo $rows["purpose"]; ?></td>
      <td><?php echo $rows["effectivityDate"]; ?></td>
      <td><?php echo $rows["remarks"]; ?></td>
      <td><?php echo $rows["clearedBy"]; ?></td>
      
      <td>
        <a href="manageClearanceEdit.php?clearanceID=<?php echo $rows['clearanceID']; ?>" class="btn btn-primary btn-sm"><i class="fa fa-edit"></i> Edit</a>
      </td>
    </tr>
    <?php
  }
?>