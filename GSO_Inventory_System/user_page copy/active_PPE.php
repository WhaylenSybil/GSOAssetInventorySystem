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
        /* Loading modal styles */
        .loading-modal {
            display: none;
            position: fixed;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            background: rgba(0, 0, 0, 0.5);
            z-index: 1000;
        }

        .loading-spinner {
            position: absolute;
            top: 50%;
            left: 50%;
            transform: translate(-50%, -50%);
            background-color: #fff;
            padding: 20px;
            border-radius: 5px;
        }
    </style>
  
</head>
<body class="hold-transition skin-blue-light layout-top-nav">
  <div class="loading-modal" id="loadingModal">
          <div class="loading-spinner">
              <!-- You can add loading animation or text here -->
              <p>Importing...</p>
          </div>
      </div>
      <!-- End of loading modal -->
  <div class="wrapper">
    <?php include_once("../user_page/header/header.php");?>
    <div class="content-wrapper">
      <section class="content-header">
        <h1><i class="fa fa archive"></i>Active Property, Plant, and Equipments(PPE)</h1>
        <ol class="breadcrumb">
          <li><a href="dashboard.php"><i class="fa fa-dashboard">Active PPE</i></a></li>
        </ol>
      </section>
      
      <section class="content container-fluid">
        <!-- Button for adding ARE in the table -->
        <!-- <a href="registry_of_ARE_properties.php" class="btn btn-primary"><i class="fa fa-fw fa-plus"></i>&nbsp Add ARE Registry</a><br> -->
        <!-- End of Button for adding ARE in the table -->
        <!-- Import file from your computer device and save it to the database -->
       <!-- <BR> <section class="">
            <form enctype="multipart/form-data" method="POST" action="import.php">
              <input type="file" name="file" id="file" accept=".xlsx, .xls"><br>
              <button type="submit" name="import_btn" class="btn btn-primary" id="importActivePPE" name="importActivePPE">IMPORT</button>
            </form>
        </section> -->
        <!-- End of import button -->

        <div class="box">
          <div class="box-header bg-blue" align="center">
            <h4 class="box-title">List of Active Property, Plant, and Equipment(Items costing ₱50,000 and above)</h4>
          </div><br>
            <div class="table-responsive">
              <table id="active_PPE" class="table table-hover responsive" cellspacing="0" width="100%">
                <thead>
                    <tr>
                        <th rowspan="2">SCANNED ARE DOCUMENTS</th>
                        <th rowspan="2">DATE RECORDED</th>
                        <th rowspan="2">ARTICLE</th>
                        <th colspan="4">DESCRIPTION</th>
                        <th rowspan="2">eNGAS PROPERTY NUMBER</th>
                        <th rowspan="2">ACQUISITION DATE</th>
                        <th rowspan="2">ACQUISITION COST</th>
                        <th rowspan="2">PROPERTY NO.</th>
                        <th rowspan="2">CLASSIFICATION</th>
                        <th rowspan="2">EST. USEFUL LIFE</th>
                        <th rowspan="2">UNIT OF MEASURE</th>
                        <th rowspan="2">UNIT VALUE</th>
                        <th colspan="1">BALANCE PER CARD</th>
                        <th colspan="1">ON HAND PER COUNT</th>
                        <th colspan="2">SHORTAGE/OVERAGE</th>
                        <th rowspan="2">RESPONSIBILITY CENTER</th>
                        <th rowspan="2">ACCOUNTABLE PERSON</th>
                        <th rowspan="2">PREVIOUS CONDITION</th>
                        <th rowspan="2">LOCATION</th>
                        <th rowspan="2">CURRENT CONDITION</th>
                        <th rowspan="2">DATE OF PHYSICAL INVENTORY</th>
                        <th rowspan="2">REMARKS</th>
                        <th colspan="5">ADDITIONAL DETAILS FOR RECONCILIATION</th>
                        <!-- <th rowspan="2">Action</th> -->
                    </tr>
                    <tr>
                        <th class="subcolumn">BRAND</th>
                        <th class="subcolumn">SERIAL NUMBER</th>
                        <th class="subcolumn">PARTICULARS</th>
                        <th class="subcolumn">ARE NUMBER</th>
                        <th class="subcolumn">(Qty)</th>
                        <th class="subcolumn">(Qty)</th>
                        <th class="subcolumn">(Qty)</th>
                        <th class="subcolumn">Value</th>
                        <th class="subcolumn">SUPPLIER</th>
                        <th class="subcolumn">PO NO.</th>
                        <th class="subcolumn">AIR/RIS NO.</th>
                        <th class="subcolumn">NOTES</th>
                        <th class="subcolumn">JEV NUMBER</th>           
                    </tr>
                </thead>
                <tbody>
                  <?php include_once("../user_page/manage_active_PPE_table.php") ?>
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
        lengthMenu: [[10, 25, 50, 100, 250, 500], [10, 25, 50, 100, 250, 500]], // Customize the available options
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

  //Script for Loader
  <script>
      function showLoadingModal() {
          document.getElementById("loadingModal").style.display = "block";
      }

      function hideLoadingModal() {
          document.getElementById("loadingModal").style.display = "none";
      }
  </script>


</body>
</html>