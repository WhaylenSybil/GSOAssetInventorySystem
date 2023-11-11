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

  <style>
    /* Style for the progress bar container */
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

    /* Style for the progress bar itself */
    .loading-spinner {
      position: absolute;
      top: 50%;
      left: 50%;
      transform: translate(-50%, -50%);
      background: #fff;
      padding: 20px;
      border-radius: 5px;
      text-align: center;
    }

    /* Style for the progress text */
    #progressText {
      font-weight: bold;
      margin-bottom: 10px;
    }

    /* Style for the progress bar */
    #progressBar {
      width: 100%;
      height: 20px;
      background: #3498db; /* Change this color as desired */
      border-radius: 5px;
    }

    /* Style for the progress bar animation */
    #progressBar::before {
      content: "";
      position: absolute;
      width: 100%;
      height: 100%;
      background: linear-gradient(45deg, transparent, rgba(255, 255, 255, 0.5), transparent);
      background-size: 200% 100%;
      animation: progressAnimation 2s linear infinite;
    }

    /* Keyframes for the progress bar animation */
    @keyframes progressAnimation {
      0% {
        background-position: 200% 0;
      }
      100% {
        background-position: -200% 0;
      }
    }
  </style>
  
</head>
<body class="hold-transition skin-blue-light sidebar-mini">
  <div class="loading-modal" id="loadingModal">
      <!-- <div class="loading-spinner">
          <p id="progressText">Importing... 0%</p>
          <div class="progress">
              <div id="progressBar" class="progress-bar" role="progressbar" aria-valuenow="0" aria-valuemin="0" aria-valuemax="100"></div>
          </div>
      </div> -->
  </div>
      <!-- End of loading modal -->
  <div class="wrapper">
    <?php include_once("../admin_page/header/header.php");?>
    <div class="content-wrapper">
      <section class="content-header">
        <h1><i class="fa fa archive"></i>Waster Material Report(WMR) Master List</h1>
        <ol class="breadcrumb">
          <li><a href="dashboard.php"><i class="fa fa-minus-circle"> WMR</i></a></li>
        </ol>
      </section>
      
      <section class="content container-fluid">
        <!-- Button for adding ARE in the table -->
        <a href="add_WMR.php" class="btn btn-primary"><i class="fa fa-fw fa-plus"></i>&nbsp Add WMR</a><br>
        <!-- End of Button for adding ARE in the table -->
        <!-- Import file from your computer device and save it to the database -->
       <BR> <section class="">
            <form enctype="multipart/form-data" method="POST" action="importWMR.php">
              <input type="file" name="file" id="file" accept=".xlsx, .xls"><br>
              <button type="submit" name="importWMR" class="btn btn-primary">IMPORT</button>
            </form>
        </section>
        <!-- End of import button -->

        <div class="box">
          <div class="box-header bg-blue" align="center">
            <h4 class="box-title">Waster Material Report(WMR) Master List</h4>
          </div><br>
            <div class="table-responsive">
              <table id="PRStable" class="table table-hover responsive" cellspacing="0" width="100%">
                <thead>
                    <tr>
                        <th rowspan="2" style="display: none;">TYPE</th>
                        <th rowspan="2">SCANNED WMR DOCUMENTS</th>
                        <th rowspan="2">DATE RECORDED/RETURNED</th>
                        <th rowspan="2">ITEM NO.</th>
                        <th rowspan="2">PRS NUMBER</th>
                        <th rowspan="2">ARTICLE</th>
                        <th colspan="4" class="center-text">DESCRIPTION</th>
                        <th rowspan="2">eNGAS PROPERTY NUMBER</th>
                        <th rowspan="2">ACQUISITION DATE</th>
                        <th rowspan="2">ACQUISITION COST/TOTAL COST</th>
                        <th rowspan="2">PROPERTY NO.</th>
                        <th rowspan="2">CLASSIFICATION</th>
                        <th rowspan="2">ESTIMATED USEFUL LIFE</th>
                        <th rowspan="2">UNIT OF MEASURE</th>
                        <th rowspan="2">UNIT VALUE</th>
                        <!-- <th rowspan="2">BALANCE PER CARD QTY</th> -->
                        <th rowspan="2">ON HAND PER COUNT QTY</th>
                        <!-- <th colspan="2">SHORTAGE/OVERAGE</th> -->
                        <th rowspan="2">RESPONSIBILITY CENTER</th>
                        <th rowspan="2">ACCOUNTABLE EMPLOYEE</th>
                        <th rowspan="2">REMARKS</th>
                        <th rowspan="2">WITH ATTACHMENT</th>
                        <th rowspan="2">WITH COVER PAGE</th>
                        <th rowspan="2">IIRUP</th>
                        <th rowspan="2">DATE OF IIRUP</th>
                        <th colspan="7" class="center-text">MODE OF DISPOSAL</th>
                        <th colspan="2" class="center-text">UPDATES/CURRENT STATUS</th>
                        <th rowspan="2">ACTIONS</th>
                    </tr>
                    <tr>
                        <th class="subcolumn">BRAND</th>
                        <th class="subcolumn">SERIAL NUMBER</th>
                        <th class="subcolumn">PARTICULARS</th>
                        <th class="subcolumn">ARE/MR NUMBER</th>
                        <!-- <th class="subcolumn">(Qty)</th>
                        <th class="subcolumn">Value</th> -->
                        <th class="subcolumn">DISPOSAL TYPE</th>
                        <th class="subcolumn">DATE OF AUCTION/SALE</th>
                        <th class="subcolumn">DATE OF OR</th>
                        <th class="subcolumn">OR NUMBER</th>
                        <th class="subcolumn">AMOUNT</th>
                        <th class="subcolumn">PART DESTROYED & THROWN ITEM</th>
                        <th class="subcolumn">REMARKS</th> 
                        <th class="subcolumn">DROPPED IN BOTH RECORDS/EXISTING IN INVENTORY REPORT</th>
                        <th class="subcolumn">REMARKS</th>          
                    </tr>
                </thead>
                <tbody>
                  <?php include_once("../admin_page/manage_WMR_table.php") ?>
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
      var table = $('#PRStable').DataTable({
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
  <!-- Script for the progress bar -->
  <!-- <script>
  // Function to update the progress bar
  function updateProgressBar(percentage) {
    const progressBar = document.getElementById('progressBar');
    const progressText = document.getElementById('progressText');
    
    // Update the progress bar width and text
    progressBar.style.width = percentage + '%';
    progressText.textContent = 'Importing... ' + percentage + '%';
  }

  // Function to display the loading modal
  function showLoadingModal() {
    const loadingModal = document.getElementById('loadingModal');
    loadingModal.style.display = 'block';
  }

  // Function to hide the loading modal
  function hideLoadingModal() {
    const loadingModal = document.getElementById('loadingModal');
    loadingModal.style.display = 'none';
  }

  // Submit form and handle the response
  $('form').on('submit', function(e) {
    e.preventDefault();
    const formData = new FormData(this);

    // Show loading modal
    showLoadingModal();

    $.ajax({
      url: 'importWMR.php',
      type: 'POST',
      data: formData,
      cache: false,
      contentType: false,
      processData: false,
      xhr: function() {
        const xhr = new window.XMLHttpRequest();
        xhr.upload.addEventListener("progress", function(e) {
          if (e.lengthComputable) {
            const percentage = Math.round((e.loaded / e.total) * 100);
            updateProgressBar(percentage);
          }
        }, false);
        return xhr;
      },
      success: function(response) {
        // Hide loading modal after success or failure
        hideLoadingModal();
        
        // Handle the response here (e.g., success message or error)
        // You can display the response message to the user or redirect to another page
        console.log(response);
      },
      error: function() {
        // Hide loading modal after success or failure
        hideLoadingModal();

        // Handle the error here (e.g., display an error message)
      }
    });
  });
  </script> -->

</body>
</html>