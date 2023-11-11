<?php
require('../login/login_session.php');
include_once('../admin_page/includes/manage_edit_employee.php');

?>

<!DOCTYPE html>
<html>
<head>
  <meta charset="utf-8">
  <title>GSO Assets Inventory System</title>
  <meta content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no" name="viewport">
  <link rel="stylesheet" href="../bower_components/bootstrap/dist/css/bootstrap.min.css">
  <link rel="stylesheet" type="text/css" href="../bower_components/font-awesome/css/font-awesome.min.css">
  <link rel="stylesheet" type="text/css" href="../bower_components/Ionicons/css/ionicons.min.css">
  <link rel="stylesheet" type="text/css" href="../dist/css/AdminLTE.min.css">
  <link rel="stylesheet" href="../bower_components/bootstrap-colorpicker/dist/css/bootstrap-colorpicker.min.css">
  <link rel="stylesheet" type="text/css" href="../bower_components/datatables.net-bs/css/dataTables.bootstrap.min.css">
  <link rel="stylesheet" type="text/css" href="../dist/css/skins/skin-blue-light.min.css">

  <!-- Favicons -->
  <link href="img/baguiologo.png" rel="icon">
  <link rel="apple-touch-icon" href="img/baguiologo.png">

  <style>
      /* Modal background overlay */
      .modal-background {
          display: flex;
          justify-content: center;
          align-items: center;
          position: fixed;
          top: 0;
          left: 0;
          width: 100%;
          height: 100%;
          background: rgba(0, 0, 0, 0.7);
          z-index: 999;
      }

      /* Modal content */
      .modal-content {
          background: #fff;
          border: 1px solid #ccc;
          border-radius: 5px;
          padding: 20px;
          box-shadow: 0 0 10px rgba(0, 0, 0, 0.5);
          text-align: center;
      }

      /* Modal message text */
      .modal-message {
          font-size: 18px;
          margin-bottom: 20px;
      }

      /* OK button */
      .ok-button {
          background: #007bff;
          color: #fff;
          border: none;
          padding: 10px 20px;
          border-radius: 5px;
          cursor: pointer;
          font-size: 16px;
      }

      .ok-button:hover {
          background: #0056b3;
      }
  </style>

</head>
<body class="hold-transition skin-blue-light sidebar-mini fixed">
    <div class="wrapper">
        <?php
        include_once("../admin_page/header/header.php");
        include_once("../admin_page/header/sidebar.php")?>

        <div class="content-wrapper">
            <section class="content-header">
                <h1><i class="fa fa-plus"></i> Employees</h1>
                <ol class="breadcrumb">
                    <li><a href="dashboard.php"><i class="fa fa-dashboard"> Employees</i></a></li>
                    <li class="active"> Employees</li>
                </ol>
            </section>
            <section class="content container-fluid">
                <div class="box">
                    <div class="box-header bg-blue" align="center">
                        <h4 class="box-title">List of Employees</h4>
                    </div><br>
                    <div class="card-body">
                        <form id="update_employee" method="post">
                            <div class="col-md-12">
                                <div class="form-group">
                                    <label>Employee Name</label>
                                    <input type="text" class="form-control" id="employeeName" name="employeeName" value="<?php echo $row['employeeName']?>" >
                                </div>
                            </div>
                            <div class="col-md-12">
                                <div class="form-group">
                                    <label>TIN Number</label>
                                    <input type="text" class="form-control" id="tinNo" name="tinNo" value="<?php echo $row['tinNo']?>" >
                                </div>
                            </div>
                            <div class="col-md-12">
                                <div class="form-group">
                                    <label>Employee ID</label>
                                    <input type="text" class="form-control" id="employeeID" name="employeeID" value="<?php echo $row['employeeID'] ?>" >
                                </div>
                            </div>
                            <div class="col-md-12">
                                <div class="form-group">
                                    <label for="rescenter">Responsibility Center</label>
                                    <input list="rescenter_options" class="form-control" id="rescenter" placeholder="Responsibility Center" name="rescenter" value="<?php echo $row['office']; ?>" autocomplete="off">
                                    <datalist id="rescenter_options">
                                        <?php
                                        $rescenter_query = $connect->query("SELECT co.office_id, co.office_name, co.ocode_number FROM city_offices co UNION ALL SELECT no.noffice_id, no.noffice_name, no.ncode_number FROM national_offices no");
                                        while ($rescenter_row = $rescenter_query->fetch_assoc()) {
                                            $selected = ($rescenter_row['office_name'] === $row['office']) ? 'selected' : '';
                                            echo '<option value="' . $rescenter_row['office_name'] . '" ' . $selected . '>' . $rescenter_row['office_name'] . '</option>';
                                        }
                                        ?>
                                    </datalist>
                                </div>
                            </div>
                            <div class="col-md-12">
                                <div class="form-group">
                                    <label>Remarks</label>
                                    <textarea type="text" class="form-control" id="remarks" name="remarks"><?php echo $row['remarks'] ? $row['remarks'] : ''; ?></textarea>
                                </div>
                            </div>
                                <button type="btn-submit" class="btn btn-success" name="btn-employeeupdate" id="btn-employeeupdate">Update</button>
                                <a href="others.php" class="btn btn-primary">Back</a>
                        </form>
                    </div>
                </div>
            </section>
        </div>
    </div>
    <!-- Required JavaScripts -->
    <script src="../bower_components/jquery/dist/jquery.min.js"></script>
     <script src="./js/add_cat.js"></script>
    <!-- Bootstrap 3.3.7 -->
    <script src="../bower_components/bootstrap/dist/js/bootstrap.min.js"></script>
    <!-- DataTables -->
    <script src="../bower_components/datatables.net/js/jquery.dataTables.min.js"></script>
    <script src="../bower_components/datatables.net-bs/js/dataTables.bootstrap.min.js"></script>
    <!-- calendar -->
    <script src="../dist/js/moment.min.js"></script>

    <script src="../dist/js/fullcalendar.min.js"></script>
    <!-- ======================================================================================= -->
    <!-- SlimScroll -->
    <script src="../bower_components/jquery-slimscroll/jquery.slimscroll.min.js"></script>
    <!-- FastClick -->
    <script src="../bower_components/fastclick/lib/fastclick.js"></script>
    <!-- AdminLTE App -->
    <script src="../dist/js/adminlte.min.js"></script>
    <!-- bootstrap color picker -->
    <script src="../bower_components/bootstrap-colorpicker/dist/js/bootstrap-colorpicker.min.js"></script>

    <!-- page script -->
    <script>
      $(function () {
        $('#example1').DataTable({responsive:true})
        $('#example2').DataTable({
          'paging'      : true,
          'lengthChange': false,
          'searching'   : false,
          'ordering'    : true,
          'info'        : true,
          'autoWidth'   : false
        })
      })
    </script>
</body>
</html>