<?php
/*require('./../database/connection.php');*/
require('../login/login_session.php');
if (!isset($_SESSION["employeeid"])) {
    header('Location: ../login/login.php');
  # code...
}

?>

<!DOCTYPE html>
<html>
<head>
  <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
  <title>GSO Inventory System</title>
  <!-- Tell the browser to be responsive to screen width -->
  <meta content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no" name="viewport">
  <link rel="stylesheet" href="../bower_components/bootstrap/dist/css/bootstrap.min.css">
  <link rel="stylesheet" href="../bower_components/select2/dist/css/select2.min.css">
  <link rel="stylesheet" href="../bower_components/font-awesome/css/font-awesome.min.css">
  <link rel="stylesheet" href="../bower_components/Ionicons/css/ionicons.min.css">
  <link rel="stylesheet" href="../dist/css/AdminLTE.min.css">
  <link rel="stylesheet" href="../bower_components/bootstrap-colorpicker/dist/css/bootstrap-colorpicker.min.css">
  <link rel="stylesheet" href="../dist/css/fullcalendar.min.css">
  <link rel="stylesheet" href="../dist/css/skins/skin-blue-light.min.css">

<!-- Datatables -->
<link rel="stylesheet" href="https://cdn.datatables.net/1.13.6/css/jquery.dataTables.min.css">
  <!-- Favicons -->
  <link  href="img/baguiologo.png" rel="icon">
  <link rel="apple-touch-icon" href="img/baguiologo.png">

  <style>
    /* Style the modal background */
    .modal-background {
      display: none;
      position: fixed;
      top: 0;
      left: 0;
      width: 100%;
      height: 100%;
      background: rgba(0, 0, 0, 0.5); /* Semi-transparent black background */
      z-index: 1;
      display: flex;
      align-items: center;
      justify-content: center;
    }

    /* Style the modal content for both modals */
     .modal-content {
       background-color: #ffffff; /* White background */
       color: black;
       padding: 20px;
       border-radius: 5px;
       text-align: center;
       z-index: 2;
       position: absolute;
       top: 50%;
       left: 50%;
       transform: translate(-50%, -50%);
     }

    /* Style the OK button */
    .ok-button {
      background-color: #0074E4; /* Blue background color for OK button */
      color: white;
      padding: 10px 20px;
      border: none;
      border-radius: 5px;
      cursor: pointer;
      margin-top: 10px; /* Add margin to separate the message and the button */
    }
  </style>
  
</head>
<body class="hold-transition skin-blue-light sidebar-mini fixed">
  <div class="wrapper">
    <?php include_once("../admin_page/header/header.php");?>
    <div class="content-wrapper">
      <section class="content-header">
        <h1><i class="fa fa archive"></i> CLEARANCE MASTER LIST</h1>
        <ol class="breadcrumb">
          <li><a href="dashboard.php"><i class="fa fa-dashboard"> CLEARANCE MASTER LIST</i></a></li>
        </ol>
      </section>
      
      <section class="content container-fluid">
        <!-- Button for adding ARE in the table -->
        <a href="addClearance.php" class="btn btn-primary"><i class="fa fa-fw fa-plus"></i>&nbsp Add New Clearance</a><br>
        <!-- End of Button for adding ARE in the table -->
        <!-- Import file from your computer device and save it to the database -->
       <BR> <section class="">
            <form enctype="multipart/form-data" method="POST" action="importClearance.php">
              <input type="file" name="file" id="file" accept=".xlsx, .xls"><br>
              <button type="submit" name="importClearance" class="btn btn-primary" id="importClearance" name="importClearance">IMPORT</button>
            </form>
        </section>
        <!-- End of import button -->

        <div class="box">
          <div class="box-header bg-blue" align="center">
            <h4 class="box-title">CLEARANCE MASTER LIST</h4>
          </div><br>
            <div class="table-responsive">
              <table id="active_PPE" class="table table-hover responsive" cellspacing="0" width="100%">
                <thead>
                    <tr>
                      <th>DATE CLEARED BY GSO</th>
                      <th>CONTROL NO.</th>
                      <th>SCANNED COPY</th>
                      <th>NAME</th>
                      <th>POSITION</th>
                      <th>CLASSIFICATION</th>
                      <th>SPECIFIC LOCATION/ RESPONSIBILITY CENTER</th>
                      <th>PURPOSE</th>
                      <th>EFFECTIVITY DATE</th>
                      <th>REMARKS/ CONDITIONS</th>
                      <th>CLEARED BY</th>
                      <th>ACTION</th>          
                    </tr>
                </thead>
                <tbody>
                  <?php include_once("../admin_page/manageClearanceTable.php") ?>
                </tbody>
              </table>
           </div>
        </div><br>
      </section>
    </div>
  </div>
<!-- Required Scripts -->
  <!-- jQuery 3 -->
  <!-- jQuery 3 -->
  <script src="../bower_components/jquery/dist/jquery.min.js"></script>
  <!--  <script src="./js/add_college.js"></script>
  <script src="./js/add_course.js"></script>
  <script src="./js/add_office.js"></script> -->
  <script src="../bower_components/bootstrap/dist/js/bootstrap.min.js"></script>
  <!-- datatables -->
  <script type="text/javascript" src="https://code.jquery.com/jquery-3.7.0.js"></script>
  <script type="text/javascript" src="https://cdn.datatables.net/1.13.6/js/jquery.dataTables.min.js"></script>
  <!-- <script src="../bower_components/datatables.net/js/jquery.dataTables.min.js"></script>
  <script src="../bower_components/datatables.net-bs/js/dataTables.bootstrap.min.js"></script> -->
  <script src="../dist/js/moment.min.js"></script>
  <script src="../dist/js/fullcalendar.min.js"></script>
  <!-- ======================================================================================= -->
  <script src="../bower_components/select2/dist/js/select2.full.min.js"></script>
  <script src="../bower_components/jquery-slimscroll/jquery.slimscroll.min.js"></script>
  <script src="../bower_components/fastclick/lib/fastclick.js"></script>
  <script src="../dist/js/adminlte.min.js"></script>
  <script src="../bower_components/bootstrap-colorpicker/dist/js/bootstrap-colorpicker.min.js"></script>
  <script>
    $(document).ready(function() {
      // Initialize DataTable
      var table = $('#active_PPE').DataTable({
        responsive: true,
        scrollX: true,
        lengthMenu: [[25, 50, 100, 250, 500], [25, 50, 100, 250, 500]], // Customize the available options
      });

      // Hide the "Additional Details for Reconciliation" column by default
      /*table.column(19).visible(false);*/

      // Event handler for checkbox clicks
      $('#column-selector').on('change', '.column-toggle', function() {
        var columnIndex = $(this).data('column');
        var column = table.column(columnIndex);
        column.visible(!column.visible());
      });
    });
  </script>

</body>
</html>