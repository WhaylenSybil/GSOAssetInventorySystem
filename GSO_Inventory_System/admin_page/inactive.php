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
  <meta content="" name="keywords">
  <meta content="" name="description">

  <!-- Favicons -->
  <link  href="img/baguiologo.png" rel="icon">
  <link rel="apple-touch-icon" href="img/baguiologo.png">
  
  <meta content="width-device-width, initial-scale=1, maximum-scale=1, user-scalable=no" name="viewport">
  <link rel="stylesheet" href="../bower_components/bootstrap/dist/css/bootstrap.min.css">
  <link rel="stylesheet" type="text/css" href="../bower_components/font-awesome/css/font-awesome.min.css">
  <link rel="stylesheet" type="text/css" href="bower_components/Ionicons/css/ionicons.min.css">
  <link rel="stylesheet" type="text/css" href="../dist/css/AdminLTE.min.css">
  <link rel="stylesheet" type="text/css" href="../bower_components/datatables.net-bs/css/dataTables.bootstrap.min.css">
  <link rel="stylesheet" type="text/css" href="../dist/css/skins/skin-blue-light.min.css">
  
</head>
<body class="hold-transition skin-blue-light sidebar-mini fixed">
  <div class="wrapper">
    <?php include_once("../admin_page/header/header.php");
    ?>
    <div class="content-wrapper">
      <section class="content-header">
        <h1><i class="fa fa fa-minus-circle"></i>
        INACTIVE PROPERTIES</h1>
        <ol class="breadcrumb">
          <li><a href="#"><i class="fa fa-minus-circle"> Inactive PPE & Semi-Expendable Properties</i></a></li>
        </ol>
      </section>
      <section class="content container-fluid">
        <!-- <div class="box">
          <div class="box-header bg-black">
            <h4 class="box-title">All Categories</h4>
          </div>
        </div> -->
        <div class="box box-primary">
          <div class="box-header with-border bg-blue text-center">
            <h3 class="box-title">Inactive PPE & Semi-Expendable Properties</h3>
          </div>
          <div class="box-body">
          <div class="row">
      <!-- Start of Registry of ARE properties -->
            <!-- for full screen -->
            <div class="col-lg-12">
              <!-- for small screen -->
              <a href="inactivePPE.php" class="box-link">
                <div class="small-box bg-orange">
                  <div class="inner">
                    <h3 align="center">Inactive PPE</h3>
                  </div>
                </div>
              </a>
            </div><!-- End of Registry of ARE Properties -->
      
      <!-- Start of Registry of ICS Properties -->
            <!-- for full screen -->
            <div class="col-lg-12">
              <a href="inactiveSemi.php" class="box-link">
                <div class="small-box bg-red">
                  <div class="inner">
                    <h3 align="center">Inactive Semi-Expendable</h3>
                  </div>
                </div>
              </a>
            </div><!-- End of Registy of ICS Properties -->
      <!-- Start of Monitoring of Fuel Consumption -->
      <!-- End of Monitoring of Fuel Consumption -->    
          </div>
        </div>
        </div>
        
      </section>
    </div>
  </div>
  <script src="../bower_components/jquery/dist/jquery.min.js"></script>
  <script src="../bower_components/bootstrap/dist/js/bootstrap.min.js"></script>
  <script src="../bower_components/datatables.net/js/jquery.dataTables.min.js"></script>
  <script src="../bower_components/datatables.net-bs/js/dataTables.bootstrap.min.js"></script>
  <script src="../bower_components/jquery-slimscroll/jquery.slimscroll.min.js"></script>
  <script src="../bower_components/fastclick/lib/fastclick.js"></script>
  <script src="../dist/js/adminlte.min.js"></script>

</body>
</html>