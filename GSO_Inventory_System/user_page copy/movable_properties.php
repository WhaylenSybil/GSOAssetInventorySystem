<?php
require('./../database/connection.php');
require('../login/login_session.php');
?>
<!DOCTYPE html>
<html>
<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
  <title>GSO Asset Inventory System</title>
  <meta content="width-device-width, initial-scale=1, maximum-scale=1, user-scalable=no" name="viewport">
  <link rel="stylesheet" href="../bower_components/bootstrap/dist/css/bootstrap.min.css">
  <link rel="stylesheet" type="text/css" href="../bower_components/font-awesome/css/font-awesome.min.css">
  <link rel="stylesheet" type="text/css" href="bower_components/Ionicons/css/ionicons.min.css">
  <link rel="stylesheet" type="text/css" href="../dist/css/AdminLTE.min.css">
  <link rel="stylesheet" type="text/css" href="../bower_components/datatables.net-bs/css/dataTables.bootstrap.min.css">
  <link rel="stylesheet" type="text/css" href="../dist/css/skins/skin-blue-light.min.css">

  <!-- Favicons -->
  <link  href="img/baguiologo.png" rel="icon">
  <link rel="apple-touch-icon" href="img/baguiologo.png">
</head>
<body class="hold-transition skin-blue-light sidebar-mini fixed">
  <div class="wrapper">
    <?php include_once("../admin_page/header/header.php");
    include_once("../admin_page/header/sidebar.php")?>
    <div class="content-wrapper">
      <section class="content-header">
        <h1><i class="fa fa archive"></i>Movable Properties</h1>
        <ol class="breadcrumb">
          <li><a href="dashboard.php"><i class="fa fa-dashboard"> Movable Properties</i></a></li>
        </ol>
      </section>
      <section class="content container-fluid">
        <div class="box">
          <div class="box-header bg-blue" align="center">
            <h4 class="box-title">List of Movable Properties</h4>
          </div><br>
          <table id="active_semi" class="table table-hover" cellspacing="0" width="100%">
            <thead>
              <tr>
                <th scope="col">Date Returned/Recorded</th>
                <th scope="col">Article</th>
                <th scope="col">Brand/Model</th>
                <th scope="col">Serial Number</th>
                <th scope="col">Particulars</th>
                <th scope="col">ARE/MR Number</th>
                <th scope="col">eNGAS Property Number</th>
                <th scope="col">Acquisition Date</th>
                <th scope="col">Acquisition Cost</th>
                <th scope="col">Property Number</th>
                <th scope="col">Est. Useful Life</th>
                <th scope="col">Unit of Measure</th>
                <th scope="col">Unit Value</th>
                <th scope="col">Quantity Returned</th>
                <th scope="col">Responsibility Center</th>
                <th scope="col">Accountable Person</th>
                <th scope="col">Remarks</th>
                <th scope="col">Supplier</th>
                <th scope="col">P.O. No.</th>
                <th scope="col">AIR/RIS No.</th>
                <th scope="col">JEV Number</th>
              </tr>
            </thead>
          </table>
        </div><br>
      </section>
    </div>
  </div>
<!-- Required Scripts -->
  <!-- jQuery 3 -->
  <script src="../bower_components/jquery/dist/jquery.min.js"></script>
  <!-- Bootstrap 3.3.7 -->
  <script src="../bower_components/bootstrap/dist/js/bootstrap.min.js"></script>
  <!-- DataTables -->
  <script src="../bower_components/datatables.net/js/jquery.dataTables.min.js"></script>
  <script src="../bower_components/datatables.net-bs/js/dataTables.bootstrap.min.js"></script>
  <!-- SlimScroll -->
  <script src="../bower_components/jquery-slimscroll/jquery.slimscroll.min.js"></script>
  <!-- FastClick -->
  <script src="../bower_components/fastclick/lib/fastclick.js"></script>
  <!-- AdminLTE App -->
  <script src="../dist/js/adminlte.min.js"></script>
  <script src="./js/notification.js"></script>
  <!-- page script -->
  <script>
    $(function () {
      $('#active_semi').DataTable({responsive:true})
      $('#additional_info_for_reconciliation').DataTable({responsive:true})
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