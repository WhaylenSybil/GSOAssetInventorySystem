<?php
  require('./../database/connection.php');
    $sql = "SELECT * FROM city_offices";
    $pre_stmt = $connect->prepare($sql) or die (msqli_error());
    $pre_stmt->execute();
    $result = $pre_stmt->get_result();

    while ($row = mysqli_fetch_array($result)) {
      echo'
        <tr>
          <td>'.$row["office_name"].'</td>
          <td>'.$row["ocode_number"].'</td>
      ';
      ?>
      <td>
        <a href="cityoffice_edit.php?office_id=<?php echo $row["office_id"]; ?>" class="btn btn-primary btn-sm"><i class="fa fa-edit">&nbsp</i>Edit</a>
      </td>
      <?php
    }
    ?>