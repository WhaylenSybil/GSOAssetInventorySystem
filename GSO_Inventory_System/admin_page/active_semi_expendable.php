<?php
require('./../database/connection.php');
require('../login/login_session.php');

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
  
</head>
<body class="hold-transition skin-blue-light sidebar-mini">
  <div class="wrapper">
    <?php include_once("../admin_page/header/header.php");?>
    <div class="content-wrapper">
      <section class="content-header">
        <h1><i class="fa fa archive"></i>Active Semi-Expendable</h1>
        <ol class="breadcrumb">
          <li><a href="dashboard.php"><i class="fa fa-dashboard">Active Semi-Expendable Property</i></a></li>
        </ol>
      </section>
      
      <section class="content container-fluid">
        <!-- Button for adding ARE in the table -->
        <a href="registry_of_ICS_properties.php" class="btn btn-primary"><i class="fa fa-fw fa-plus"></i>&nbsp Add ICS Registry</a><br>
        <!-- End of Button for adding ARE in the table -->
        <!-- Import file from your computer device and save it to the database -->
       <BR> <section class="">
            <form enctype="multipart/form-data" method="POST" action="importICS.php">
              <input type="file" name="file" id="file" accept=".xlsx, .xls"><br>
              <button type="submit" name="import_ics" class="btn btn-primary">IMPORT</button>
            </form>
        </section>
        <!-- End of import button -->

        <div class="box">
          <div class="box-header bg-blue" align="center">
            <h4 class="box-title">List of Active Semi-Expendable Properties (Items costing below ₱50,000)</h4>
          </div><br>
            <div class="table-responsive">
              <table id="active_Semi" class="table table-hover responsive" cellspacing="0" width="100%">
                <thead>
                    <tr>
                        <th rowspan="2">SCANNED ICS DOCUMENTS</th>
                        <th rowspan="2">DATE RETURNED</th>
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
                        <th rowspan="2">Action</th>
                    </tr>
                    <tr>
                        <th class="subcolumn">BRAND</th>
                        <th class="subcolumn">SERIAL NUMBER</th>
                        <th class="subcolumn">PARTICULARS</th>
                        <th class="subcolumn">PRS/WMR NUMBER</th>
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
                  <?php include_once("../admin_page/manage_active_semi_table.php") ?>
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
      var table = $('#active_Semi').DataTable({
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
  <script>
    // Function to calculate and update acquisition cost, shortage/overage qty, and shortage/overage value
    function updateCalculations() {
        var unitValue = parseFloat(document.getElementById("unit_value").value.replace(/,/g, '')) || 0;
        var balancePerCard = parseFloat(document.getElementById("balance_per_card").value) || 0;
        var onHandPerCount = parseFloat(document.getElementById("onhand_per_count").value) || 0;

        // Calculate acquisition cost: unit value * balance per card
        var acquisitionCost = unitValue * balancePerCard;

        // Calculate shortage/overage qty: balance per card - on hand per count
        var shortageOverageQty = balancePerCard - onHandPerCount;

        // Calculate shortage/overage value: unit value * shortage/overage qty
        var shortageOverageValue = unitValue * shortageOverageQty;

        // Format the acquisition cost with commas
        var formattedAcquisitionCost = acquisitionCost.toLocaleString(undefined, {});
        var formattedShortageOverageValue = shortageOverageValue.toLocaleString(undefined, {});

        // Format the shortage/overage qty and shortage/overage value as strings with two decimal places
        var formattedShortageOverageQty = shortageOverageQty;

        // Update the acquisition cost, shortage/overage qty, and shortage/overage value inputs
        document.getElementById("acquisition_cost").value = formattedAcquisitionCost;
        document.getElementById("shortage_overage_qty").value = formattedShortageOverageQty;
        document.getElementById("shortage_overage_value").value = formattedShortageOverageValue;
    }

    // Add event listeners to unit value, balance per card, and on hand per count inputs
    document.getElementById("unit_value").addEventListener("input", updateCalculations);
    document.getElementById("balance_per_card").addEventListener("input", updateCalculations);
    document.getElementById("onhand_per_count").addEventListener("input", updateCalculations);

    // Initial calculation when the page loads (optional)
    updateCalculations();
</script>
</body>
</html>