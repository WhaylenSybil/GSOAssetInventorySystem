<?php
require('./../database/connection.php');
require('../login/login_session.php');
include ('../admin_page/includes/manageEditPRS.php');
?>
<!DOCTYPE html>
<html>
<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no, maximum-scale =1, user-scalable=no" name="viewport">
  <title>GSO Asset Inventory System</title>
  <link rel="stylesheet" href="../bower_components/bootstrap/dist/css/bootstrap.min.css">
  <link rel="stylesheet" type="text/css" href="../bower_components/font-awesome/css/font-awesome.min.css">
  <link rel="stylesheet" type="text/css" href="../dist/css/AdminLTE.min.css">
  <link rel="stylesheet" type="text/css" href="../bower_components/datatables.net-bs/css/dataTables.bootstrap.min.css">
  <link rel="stylesheet" type="text/css" href="../dist/css/skins/skin-blue-light.min.css">

  <!-- Favicons -->
  <link  href="img/baguiologo.png" rel="icon">
  <link rel="apple-touch-icon" href="img/baguiologo.png">

  <style>
         /* Initially, hide all additional information forms */
         .additional-info {
             display: none;
         }

         /* Add CSS to make the form responsive */
         .form-container {
             max-width: 100%;
             padding: 15px;
             margin: 0 auto;
         }

         /* Add some spacing between form elements */
         .form-group {
             margin-bottom: 15px;
         }

         /* Style the labels and input elements */
         label {
             font-weight: bold;
         }

         /* Center the submit buttons */
         .btn-container {
             text-align: center;
         }

         /* Style the checkboxes and labels */
         input[type="checkbox"] {
             margin-right: 5px;
         }

         /* Center the checkbox label vertically */
         label[for="with_attachment"], label[for="coverpage"] {
             display: flex;
             align-items: center;
         }

         /* Add spacing between checkbox and label */
         label[for="with_attachment"]::before, label[for="coverpage"]::before {
             content: "";
             margin-right: 5px;
         }

         /* Initially, hide the additional information form */
         .addditional_inputs {
             display: none;
         }

         /* Initially, hide the additional information form */
         #additional-info {
             display: none;
         }

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
    <?php include_once("../admin_page/header/header.php");
    include("../admin_page/header/sidebar.php")?>
    <div class="content-wrapper">
      <section class="content-header">
        <h1>Property Return Slip</h1>
        <ol class="breadcrumb">
          <li><a href="dashboard.html"><i class="fa fa-dashboard"></i>Property Return Slip</a></li>
          <li class="active">Add Property Return Slip</li>
        </ol>
      </section>     

    <!-- Main Content -->
    <section class="content container-fluid">
      <div class="box">
        <div class="box-header bg-blue" align="center">
          <h4 class="box-title">Property Return Slip Master List</h4>
        </div><br>
        <div class="row">
          <div class="col-md-12">
            <form method="POST" action="" enctype="multipart/form-data">
              <div class="col-md-3" style="display: none;"><!-- Type, Either PRS or WMR -->
                <div class="form-group">
                  <label for="type"> Type</label>
                  <input type="text" class="form-control" id="type" placeholder="PRS" name="type" autocomplete="off" value="<?php echo $row['type']; ?>">
                </div>
              </div><!-- End Type, Either PRS or WMR -->
              <div class="col-md-3"><!-- Date ReturnedRecorded -->
                <div class="form-group">
                  <label for="dateReturnedRecorded"> Date Returned/Recorded</label>
                  <input type="date" class="form-control" id="dateReturnedRecorded" placeholder="Date Returned/Recorded" name="dateReturnedRecorded" autocomplete="off" value="<?php echo $row['dateReturnedRecorded']; ?>">
                </div>
              </div><!-- End Date Recorded -->
              <div class="col-md-3"><!-- Item No. -->
                <div class="form-group">
                  <label for="ItemNo"> Item No.</label>
                  <input type="text" class="form-control" id="ItemNo" placeholder="Item No." name="ItemNo" autocomplete="off" value="<?php echo $row['ItemNo']; ?>">
                </div>
              </div><!-- End Item No. -->
              <div class="col-md-3"><!--PRS/WMR Number -->
                <div class="form-group">
                  <label for="prsNumber"> PRS/WMR Number</label>
                  <input type="text" class="form-control" id="prsNumber" placeholder="PRS/WMR Number" name="prsNumber" autocomplete="off" value="<?php echo $row['prsNumber']; ?>">
                </div>
              </div><!-- End ARE/MR Number -->
              <div class="col-md-3"><!-- Article -->
                <div class="form-group">
                  <label for="article"> Article</label>
                  <input type="text" class="form-control" id="article" placeholder="Article" name="article" autocomplete="off" style="text-transform: uppercase;" value="<?php echo $row['article']; ?>">
                </div>
              </div><!-- End Article -->
              <div class="col-md-3"><!-- Brand/Model -->
                <div class="form-group">
                  <label for="brand"> Brand/Model</label>
                  <input type="text" class="form-control" id="brand" placeholder="Brand/Model" name="brand" autocomplete="off"style="text-transform: uppercase;" value="<?php echo $row['brand']; ?>">
                </div>
              </div><!-- End Brand/Model -->
              <div class="col-md-3"><!-- Serial Number -->
                <div class="form-group">
                  <label for="serialNumber"> Serial Number/s</label>
                  <input type="text" class="form-control" id="serialNumber" placeholder="Serial Number" name="serialNumber" autocomplete="off" value="<?php echo $row['serialNumber']; ?>">
                </div>
              </div><!-- End Serial Number -->
              <div class="col-md-6"><!-- Particulars -->
                <div class="form-group">
                  <label for="particulars"> Particulars</label>
                  <!-- <input type="text" class="form-control" id="particulars" placeholder="Particulars" name="particulars" autocomplete="off" value="<?php echo $row['particulars']; ?>"> -->
                  <textarea type="text" name="particulars" id="particulars" placeholder="Particulars" class="form-control" autocomplete="off" ><?php echo $row['particulars']; ?></textarea>
                </div><!-- End Particulars -->
              </div>
              <div class="col-md-3"><!--ARE/MR Number -->
                <div class="form-group">
                  <label for="areNumber"> ARE/MR Number</label>
                  <input type="text" class="form-control" id="areNumber" placeholder="ARE/MR Number" name="areNumber" autocomplete="off" value="<?php echo $row['areNumber']; ?>">
                </div>
              </div><!-- End ARE/MR Number -->
              <div class="col-md-3"><!-- enGAS Property Number  -->
                <div class="form-group">
                  <label for="engasNumber"> eNGAS Property Number</label>
                  <input type="text" class="form-control" id="engasNumber" placeholder="enGAS Property Number" name="engasNumber" autocomplete="off" value="<?php echo $row['engasNumber']; ?>">
                </div>
              </div><!-- End eNGAS Property Number   -->
              <div class="col-md-3"><!-- Acquisition Date -->
                <div class="form-group">
                  <label for="acquisitionDate"> Acquisition Date</label>
                  <input type="date" class="form-control" id="acquisitionDate" placeholder="Acquisition Date" name="acquisitionDate" autocomplete="off" value="<?php echo $row['acquisitionDate']; ?>">
                </div>
              </div><!-- End Acquisition Date -->
              <div class="col-md-3"><!-- Unit Value -->
                <div class="form-group">
                  <label for="unitValue"> Unit Value</label>
                  <input type="text" class="form-control" id="unitValue" placeholder="Unit Value" name="unitValue" autocomplete="off" value="<?php echo $row['unitValue']; ?>">
                </div>
              </div><!-- End Unit Value -->
              <div><!-- Balance per Card -->
                <div class="col-md-3">
                  <div class="form-group">
                    <label for="balancePerCard">Onhand Per Count Qty</label>
                    <input type="text" class="form-control" id="balancePerCard" placeholder="Balance per Card" name="balancePerCard" autocomplete="off" value="<?php echo $row['balancePerCard']; ?>">
                  </div>
                </div>
              </div><!-- End of Balance per card -->
              <div class="col-md-3"><!-- Acquisition Cost -->
                <div class="form-group">
                  <label for="acquisitionCost"> Acquisition Cost</label>
                  <input type="text" class="form-control" id="acquisitionCost" placeholder="Acquisition Cost" name="acquisitionCost" autocomplete="off" readonly value="<?php echo $row['acquisitionCost']; ?>">
                </div>
              </div><!-- End Acquisition Cost -->
              <div class="col-md-3"><!-- Property Number -->
                <div class="form-group">
                  <label for="propertyNumber"> Property Number</label>
                  <input type="text" class="form-control" id="propertyNumber" placeholder="Property Number" name="propertyNumber" autocomplete="off" value="<?php echo $row['propertyNumber']; ?>">
                </div>
              </div><!-- End Property Number -->
              <div class="col-md-3"><!-- Classification -->
                  <div class="form-group">
                      <label for="accountnumber"> Classification</label>
                      <input list="classification_options" class="form-control" id="accountnumber" placeholder="Classification" name="accountnumber" autocomplete="off" value="<?php echo $row['classification'] ?>">
                      <datalist id="classification_options">
                          <?php
                          $classification_query = $connect->query("SELECT account_code_id, account_number FROM account_codes");
                          while ($classification_row = $classification_query->fetch_assoc()) {
                              $selected = ($classification_row['account_number'] === $row['classification']) ? 'selected' : '';
                              echo '<option value="' . $classification_row['account_number'] . '" ' . $selected . '>' . $classification_row['account_number'] . '</option>';
                          }
                          ?>
                      </datalist>
                  </div>
              </div><!-- End of Classification -->
              <div class="col-md-3"><!-- Estimated Useful Life -->
                  <div class="form-group">
                      <label for="estLife"> Estimated Useful Life</label>
                      <input list="est_life_options" class="form-control" id="estLife" placeholder="Estimated Useful Life" name="estLife" style="width:100%;" value="<?php echo $row['estLife']; ?>">
                      <datalist id="est_life_options">
                          <option value="1 yr" <?php if ($row['estLife'] === '1 yr') echo 'selected'; ?>>1 yr</option>
                          <option value="2 yrs" <?php if ($row['estLife'] === '2 yrs') echo 'selected'; ?>>2 yrs</option>
                          <option value="3 yrs" <?php if ($row['estLife'] === '3 yrs') echo 'selected'; ?>>3 yrs</option>
                          <option value="4 yrs" <?php if ($row['estLife'] === '4 yrs') echo 'selected'; ?>>4 yrs</option>
                          <option value="5 yrs" <?php if ($row['estLife'] === '5 yrs') echo 'selected'; ?>>5 yrs</option>
                          <option value="6 yrs" <?php if ($row['estLife'] === '6 yrs') echo 'selected'; ?>>6 yrs</option>
                          <option value="7 yrs" <?php if ($row['estLife'] === '7 yrs') echo 'selected'; ?>>7 yrs</option>
                          <option value="8 yrs" <?php if ($row['estLife'] === '8 yrs') echo 'selected'; ?>>8 yrs</option>
                          <option value="9 yrs" <?php if ($row['estLife'] === '9 yrs') echo 'selected'; ?>>9 yrs</option>
                          <option value="10 yrs" <?php if ($row['estLife'] === '10 yrs') echo 'selected'; ?>>10 yrs</option>
                          <option value="11 yrs" <?php if ($row['estLife'] === '11 yrs') echo 'selected'; ?>>11 yrs</option>
                          <option value="12 yrs" <?php if ($row['estLife'] === '12 yrs') echo 'selected'; ?>>12 yrs</option>
                          <option value="13 yrs" <?php if ($row['estLife'] === '13 yrs') echo 'selected'; ?>>13 yrs</option>
                          <option value="14 yrs" <?php if ($row['estLife'] === '14 yrs') echo 'selected'; ?>>14 yrs</option>
                          <option value="15 yrs" <?php if ($row['estLife'] === '15 yrs') echo 'selected'; ?>>15 yrs</option>
                      </datalist>
                  </div>
              </div><!-- End Estimated Useful Life -->
              <div class="col-md-3"><!-- Unit of Measure -->
                <div class="form-group">
                  <label for="unitOfMeasure"> Unit of Measure</label>
                  <input type="text" class="form-control" id="unitOfMeasure" placeholder="Unit of Measure" name="unitOfMeasure" autocomplete="off" value="<?php echo $row['unitOfMeasure']; ?>">
                </div>
              </div><!-- End Unit of Measure -->
              <div class="col-md-3"><!-- Responsibility Center -->
                  <div class="form-group">
                      <label for="rescenter"> Responsibility Center (Offices and Departments)</label>
                      <input list="rescenter_options" class="form-control" id="rescenter" placeholder="Responsibility Center" name="rescenter" autocomplete="off" value="<?php echo $row['responsibilityCenter'] ?>" onchange="fetchEmployeesByCenter()">
                      <datalist id="rescenter_options">
                          <?php
                          $rescenter_query =$connect->query("SELECT co.office_id, co.office_name AS office_name, co.ocode_number FROM city_offices co UNION ALL SELECT no.noffice_id, no.noffice_name AS office_name, no.ncode_number FROM national_offices no ORDER BY office_name");
                          while ($rescenter_row = $rescenter_query->fetch_assoc()) {
                              $selected = ($rescenter_row['office_name'] === $row['responsibilityCenter']) ? 'selected' : '';
                              echo '<option value="' . $rescenter_row['office_name'] . '" ' . $selected . '>' . $rescenter_row['office_name'] . '</option>';
                          }
                          ?>
                      </datalist>
                  </div>
              </div><!-- End Responsibility Center -->
              <div class="col-md-3"><!-- Accountable Person  -->
                  <div class="form-group">
                      <label for="accountable_person"> Accountable Employee</label>
                      <input list="accountable_options" class="form-control" id="accountable_person" placeholder="LAST NAME, First Name MI." name="accountable_person" autocomplete="off" value="<?php echo $row['accountableEmployee'] ?>" oninput="showEmployeesByCenter()">
                      <datalist id="accountable_options">
                          
                      </datalist>
                  </div>
              </div><!-- End Accountable Person -->
              <div class="col-md-3"><!-- Remarks -->
                <div class="form-group">
                  <label for="remarks"> Remarks</label>
                  <textarea type="text" class="form-control" id="remarks" placeholder="Remarks" autocomplete="off"  name="remarks"><?php echo $row['remarks'] ?></textarea>
                </div>
              </div><!-- End Remarks -->
              
              <div class="col-md-2"><!-- IIRUP -->
                <div class="form-group">
                    <label for="iirup">WITH IIRUP</label>
                    <select class="form-control" name="iirup" id="iirup">
                        <option value="">---Select IIRUP---</option>
                        <option value="YES"<?php if ($row['iirup'] === 'YES') echo ' selected'; ?>>YES</option>
                        <option value="NO"<?php if ($row['iirup'] === 'NO') echo ' selected'; ?>>NO</option>
                    </select>
                </div>
              </div><!-- End IIRUP -->
              <div class="col-md-2"><!-- IIRUP Date -->
                <div class="form-group">
                  <label for="iirupDate"> Date of IIRUP</label>
                  <input type="date" class="form-control" name="iirupDate" id="iirupDate" placeholder="Date of IIRUP" autocomplete="off" value="<?php echo $row['iirupDate'] ?>">
                </div>
              </div><!-- End of IIRUP Date -->
              <div class="form-group">
                    <div class="col-md-3">
                        <label for="scannedPRS">Scanned Supporting Documents</label>
                        <input type="file" class="form-control" id="scannedPRS" name="scannedPRS" accept=".pdf">
                      </div>
                </div>
                <div class="form-group">
                    <div class="col-md-2">
                        <label for="saved_scanned_file">Saved Scanned Document</label>
                        <input type="text" class="form-control" id="saved_scanned_file" name="saved_scanned_file" value="<?php echo $row['scannedPRS']; ?>" readonly>
                    </div>
                </div><!-- End of Scanned Docs -->

              <br><br>
<!-- ==================================Mode of Disposal================================================ -->
              <div class="col-md-12"><!-- ADDITIONAL INFORMATION -->
                <div class="form-group">
                  <h4 class="box-title" align="center"><b>Additional Details for Reconciliation Purposes</b></h4>
                </div>
              </div><!-- End ADDITIONAL INFORMATION -->
              <div class="col-md-12">
                <div class="form-group">
                  <select id="modeofdisposal_options" onchange="showSelectedForm(1)" class="form-control" name="modeofdisposal_options">
                      <option value="">---Select a mode of disposal---</option>
                      <option value="Destroyed Or Condemned"<?php if ($row['modeOfDisposal'] === 'Destroyed Or Condemned') echo ' selected'; ?>>By Destruction or Condemnation</option>
                      <option value="Sold Through Negotiation"<?php if ($row['modeOfDisposal'] === 'Sold Through Negotiation') echo ' selected'; ?>>Sold through Negotiation</option>
                      <option value="Sold Through Public Auction"<?php if ($row['modeOfDisposal'] === 'Sold Through Public Auction') echo ' selected'; ?>>Sold through Public Auction</option>
                      <option value="Transferred Without Cost"<?php if ($row['modeOfDisposal'] === 'Transferred Without Cost') echo ' selected'; ?>>Transferred without Cost to Other Offices/Departments, and to Other Agencies</option>
                      <option value="Continued In Service"<?php if ($row['modeOfDisposal'] === 'Continued In Service') echo ' selected'; ?>>Continued in Service</option>
                  </select>
                  <!-- ============================================================= -->
                  <!-- Form for Destroyed and Thrown -->
                  <div  id="form-DestroyedOrCondemned" class="additional-info">
                    <div class="col-md-6">
                      <label for="part_destroyed_thrown">Parts Destroyed or Thrown</label>
                      <textarea type="text" name="part_destroyed_thrown" id="part_destroyed_thrown" placeholder="Part Destroyed or Thrown" class="form-control" autocomplete="off" ><?php echo $row['partDestroyedOrThrown']; ?></textarea>
                    </div>
                    <div class="col-md-6">
                      <label for="notesDestroyed">Remarks</label>
                      <textarea type="text" name="notesDestroyed" id="notesDestroyed" class="form-control" autocomplete="off"><?php echo $row['notesDestroyed']; ?></textarea>
                    </div>
                  </div><!-- End of Form for Destroyed and Thrown -->
                  <!-- ============================================================================================== -->
                  <!-- Form for Sold Through Negotiation -->
                  <div id="form-SoldThroughNegotiation" class="additional-info">
                    <div class="col-md-3">
                      <div class="form-group">
                        <label for="date_of_sale">Date of Sale</label>
                        <input type="date" name="date_of_sale" id="date_of_sale" placeholder="Date of Sale" class="form-control" autocomplete="off" value="<?php echo $row['dateOfSale'] ?>">
                      </div>
                    </div>
                    <div class="col-md-3">
                      <label for="date_of_OR_Negotiation">Date of OR</label>
                      <input class="form-control" type="date" name="date_of_OR_Negotiation" id="date_of_OR_Negotiation" placeholder="Date of OR" autocomplete="off" value="<?php echo $row['ORDateNegotiation'] ?>">
                    </div>
                    <div class="col-md-3">
                      <label for="OR_no_Negotiation">OR Number</label>
                      <input class="form-control" type="text" name="OR_no_Negotiation" id="OR_no_Negotiation" placeholder="OR Number" autocomplete="off" value="<?php echo $row['ORNumberNegotiation'] ?>">
                    </div>
                    <div class="col-md-3">
                      <label for="amountNegotiation">Amount</label>
                      <input class="form-control" type="text" name="amountNegotiation" id="amountNegotiation" placeholder="Amount" autocomplete="off" value="<?php echo $row['amountNegotiation'] ?>"><br>
                    </div>
                    <div class="col-md-6">
                      <label for="notesNegotiation">Notes</label>
                      <textarea type="text" name="notesNegotiation" id="notesNegotiation" class="form-control" autocomplete="off" value="<?php echo $row['notesNegotiation'] ?>"></textarea>
                    </div>
                  </div><!-- End of Form for Sold Through Negotiation -->
                  <!-- ============================================================================================= -->
                  <!-- Form for Sold Through Auction -->
                  <div id="form-SoldThroughPublicAuction" class="additional-info">
                    <div class="col-md-3">
                      <div class="form-group">
                        <label for="date_of_auction">Date of Auction</label>
                        <input type="date" name="date_of_auction" id="date_of_auction" placeholder="Date of Auction" class="form-control" autocomplete="off" value="<?php echo $row['dateOfAuction'] ?>">
                      </div>
                    </div>
                    <div class="col-md-3">
                      <div class="form-group">
                        <label for="date_of_OR_Auction">Date of OR</label>
                        <input class="form-control" type="date" name="date_of_OR_Auction" id="date_of_OR_Auction" placeholder="Date of OR" autocomplete="off" value="<?php echo $row['ORDateAuction'] ?>">
                      </div>
                    </div>
                    <div class="col-md-3">
                      <div class="form-group">
                        <label for="OR_no_Auction">OR Number</label>
                        <input class="form-control" type="text" name="OR_no_Auction" id="OR_no_Auction" placeholder="OR Number" autocomplete="off" value="<?php echo $row['ORNumberAuction'] ?>">
                      </div>
                    </div>
                    <div class="col-md-3">
                      <div class="form-group">
                        <label for="Auction">Amount</label>
                        <input class="form-control" type="text" name="amountAuction" id="amountAuction" placeholder="Amount" autocomplete="off" value="<?php echo $row['amountAuction'] ?>">
                      </div>
                    </div><br>
                    <div class="col-md-6">
                      <label for="notesAuction">Notes</label>
                      <textarea type="text" name="notesAuction" id="notesAuction" class="form-control" autocomplete="off"><?php echo $row['notesAuction']; ?></textarea>
                    </div>
                  </div><!-- End of Form for Sold Through Negotiation -->
                  <!-- ============================================================================================= -->
                  <!-- Form for Transferred without cost -->
                  <div id="form-TransferredWithoutCost" class="additional-info">
                    <div class="col-md-3">
                      <div class="form-group">
                        <label for="date_of_transfer">Date of Transfer(Without Cost)</label>
                        <input type="date" name="date_of_transfer" id="date_of_transfer" placeholder="Date of Transfer" class="form-control" autocomplete="off" value="<?php echo $row['transferDateWithoutCost'] ?>">
                      </div>
                    </div>
                    <div class="col-md-4">
                      <div class="form-group">
                        <label for="recipient_transferred">Recipient(Name of Agency/Institution)</label>
                        <input type="text" name="recipient_transferred" id="recipient_transferred" placeholder="Recipient(Name of Agency/Institution)" class="form-control" autocomplete="off" value="<?php echo $row['recipientTransferred'] ?>">
                      </div>
                    </div>
                    <div class="col-md-5">
                      <label for="notesTransferred">Notes</label>
                      <textarea type="text" name="notesTransferred" id="notesTransferred" class="form-control" autocomplete="off"><?php echo $row['notesTransferred']; ?></textarea>
                    </div>
                  </div><!-- End of Form for Transferred without cost -->
                  <!-- ============================================================================================= -->
                  <!-- Form for Constinued in Service -->
                  <div id="form-ContinuedInService" class="additional-info">
                    <div class="col-md-3">
                      <div class="form-group">
                        <label for="date_of_transfer_continued">Date of Transfer(Continued Service)</label>
                        <input type="date" name="date_of_transfer_continued" id="date_of_transfer_continued" placeholder="Date of Transfer" class="form-control" autocomplete="off" value="<?php echo $row['transferDateContinued'] ?>" >
                      </div>
                    </div>
                    <div class="col-md-4">
                      <div class="form-group">
                        <label for="recipient_continued">Recipient(Name of Agency/Institution)</label>
                        <input type="text" name="recipient_continued" id="recipient_continued" placeholder="Recipient(Name of Agency/Institution)" class="form-control" autocomplete="off" value="<?php echo $row['recipientContinued'] ?>">
                      </div>
                    </div>
                    <div class="col-md-5">
                      <div class="form-group">
                        <label for="notesContinued">Notes</label>
                        <textarea type="text" name="notesContinued" id="notesContinued" class="form-control" autocomplete="off"><?php echo $row['notesContinued']; ?></textarea>
                      </div>
                    </div>
                  </div><!-- End of Form for Transferred without cost -->
                  <!-- ============================================================================================= -->
                </div>
              </div>
<!-- =================================Current Updates======================================================== -->
              <div class="col-md-12"><!-- ADDITIONAL INFORMATION -->
                <div class="form-group">
                  <h4><b>Updates/Current Status</b></h4>
                </div>
              </div><!-- End ADDITIONAL INFORMATION -->
              <div class="col-md-12">
                  <div class="form-group">
                      <select id="updates_currentstatus" onchange="showAdditionalInputs()" class="form-control" name="updates_currentstatus">
                          <option value="">---Select Update/Current Status---</option>
                          <option value="Dropped In Both Records" <?php if ($row['currentStatus'] === 'Dropped In Both Records') echo 'selected'; ?>>Dropped in Both Records</option>
                          <option value="Existing In Inventory Report" <?php if ($row['currentStatus'] === 'Existing In Inventory Report') echo 'selected'; ?>>Existing in Inventory Report (For Further Monitoring)</option>
                      </select>
                      <!-- Form for dropped in both records -->
                      <div id="additional_inputs" class="form-group" style="display: none;">
                          <div class="col-md-3">
                              <label for="JEV_no">JEV Number</label>
                              <input type="text" name="JEV_no" id="JEV_no" placeholder="JEV Number" class="form-control" autocomplete="off" value="<?php echo $row['jevNo']; ?>">
                          </div>
                          <div class="col-md-3">
                              <label for="date_dropped">Date</label>
                              <input type="date" name="date_dropped" id="date_dropped" placeholder="Date" class="form-control" autocomplete="off" value="<?php echo $row['dateDropped']; ?>">
                          </div>
                          <div class="col-md-6">
                              <label for="actions_to_be_taken_Dropped">Notes</label>
                              <textarea type="text" name="actions_to_be_taken_Dropped" id="actions_to_be_taken_Dropped" placeholder="Actions to be Taken" class="form-control" autocomplete="off"><?php echo $row['actionsToBeTakenDropped']; ?></textarea>
                          </div>
                      </div><!-- End of Form for dropped in both records -->
                      <!-- Form for Existing in Both Records -->
                      <div id="additional_inputs_existing" class="form-group" style="display: none;">
                          <div class="col-md-3">
                              <label for="actions_to_be_taken_Existing">Remarks</label>
                              <input type="text" name="actions_to_be_taken_Existing" id="actions_to_be_taken_Existing" placeholder="Actions to be Taken" class="form-control" autocomplete="off" value="<?php echo $row['actionsToBeTakenExisting']; ?>">
                          </div>
                      </div>
                  </div>
              </div>
              
              <br><br><br>
              <div class="col-md-2"><!-- Save Button PRS -->
                <div class="form-group">
                  <button type="submit" class="btn btn-success" name="btn_updatePRS" onClick="">UPDATE</button>
                </div>
              </div><!-- End of Save Button PRS -->
              <div class="col-md-2"><!-- Cancel Button Registry -->
                <div class="form-group">
                  <a href="<?php echo ($row['type'] == 'PRS') ? 'PRS.php' : ($row['type'] == 'WMR' ? 'WMR.php' : ''); ?>" class="btn btn-danger">Cancel</a>
                </div>
              </div><!-- End of Cancel Button Registry -->
            </form>          
          </div>
      </div>  
    </div><!-- Div box -->
  </section>
  </div><!-- div content wrapper -->
</div>


<!-- Scripts Required -->

<script src="../bower_components/jquery/dist/jquery.min.js"></script>
<script src="../bower_components/bootstrap/dist/js/bootstrap.min.js"></script>
<script src="../bower_components/datatables.net/js/jquery.dataTables.min.js"></script>
<script src="../bower_components/datatables.net-bs/js/dataTables.bootstrap.min.js"></script>
<script src="../bower_components/select2/dist/js/select2.full.min.js"></script>
<script src="../bower_components/jquery-slimscroll/jquery.slimscroll.min.js"></script>
<script src="../bower_components/fastclick/lib/fastclick.js"></script>
<script src="../dist/js/adminlte.min.js"></script>

<!-- The script below is for the dropdown with manual type-->

<script>
    // Function to calculate and update acquisition cost, shortage/overage qty, and shortage/overage value
    function updateCalculations() {
        var unitValue = parseFloat(document.getElementById("unitValue").value.replace(/,/g, '')) || 0;
        var balancePerCard = parseFloat(document.getElementById("balancePerCard").value) || 0;

        // Calculate acquisition cost: unit value * balance per card
        var acquisitionCost = unitValue * balancePerCard;

        // Calculate shortage/overage qty: balance per card - on hand per count
        /*var shortageOverageQty = balancePerCard - onHandPerCount;*/

        // Calculate shortage/overage value: unit value * shortage/overage qty
       /* var shortageOverageValue = unitValue * shortageOverageQty;*/

        // Format the acquisition cost with commas
        var formattedAcquisitionCost = acquisitionCost.toLocaleString(undefined, { minimumFractionDigits: 2, maximumFractionDigits: 2 });
        /*var formattedShortageOverageValue = shortageOverageValue.toLocaleString(undefined, { minimumFractionDigits: 2, maximumFractionDigits: 2 });*/

        // Format the shortage/overage qty and shortage/overage value as strings with two decimal places
        /*var formattedShortageOverageQty = shortageOverageQty;*/

        // Update the acquisition cost, shortage/overage qty, and shortage/overage value inputs
        document.getElementById("acquisitionCost").value = formattedAcquisitionCost;
        /*document.getElementById("soQty").value = formattedShortageOverageQty;
        document.getElementById("soValue").value = formattedShortageOverageValue;*/
    }

    // Add event listeners to unitValue, balancePerCard, and onHandPerCount inputs
    document.getElementById("unitValue").addEventListener("input", updateCalculations);
    document.getElementById("balancePerCard").addEventListener("input", updateCalculations);
    /*document.getElementById("onhandPerCount").addEventListener("input", updateCalculations);*/

    // Initial calculation when the page loads (optional)
    updateCalculations();
</script>

<script>
    // Get the select element by its ID
    var resCenterSelect = document.getElementById("rescenter");

    // Add an event listener to listen for changes in the select element
    resCenterSelect.addEventListener("change", function() {
        // Get the selected value
        var resCenterValue = resCenterSelect.value;

        // You can now use the 'selectedValue' variable as needed
        console.log("Selected Value: " + resCenterValue);
    });
</script>

<script>
    // Get the select element by its ID
    var accountableSelect = document.getElementById("accountable_person");

    // Add an event listener to listen for changes in the select element
    accountableSelect.addEventListener("change", function() {
        // Get the selected value
        var accountableValue = accountableSelect.value;

        // You can now use the 'selectedValue' variable as needed
        console.log("Selected Value: " + accountableValue);
    });
</script>

<script>
    // Get the select element by its ID
    var estLifeSelect = document.getElementById("estLife");

    // Add an event listener to listen for changes in the select element
    estLifeSelect.addEventListener("change", function() {
        // Get the selected value
        var estLifeValue = estLifeSelect.value;

        // You can now use the 'selectedValue' variable as needed
        console.log("Selected Value: " + estLifeValue);
    });
</script>
<script>
    function showSelectedForm() {
        var modeOfDisposalSelect = document.getElementById("modeofdisposal_options");
        var selectedModeOfDisposal = modeOfDisposalSelect.value;

        // Hide all additional information forms
        var additionalForms = document.querySelectorAll('.additional-info');
        additionalForms.forEach(function(form) {
            form.style.display = 'none';
        });

        // Show the selected additional information form if it exists
        var selectedForm = document.getElementById("form-" + selectedModeOfDisposal.replace(/ /g, ''));
        if (selectedForm) {
            selectedForm.style.display = 'block';
        }
    }

    // Call the showSelectedForm function when the page loads to initialize the form display
    showSelectedForm();
</script>
<script>
    // Function to show the selected additional information form
    function showAdditionalInputs() {
        var updates_currentstatus = document.getElementById('updates_currentstatus');
        var additional_inputs = document.getElementById('additional_inputs');
        var additional_inputs_existing = document.getElementById('additional_inputs_existing');

        // Hide all additional input forms
        additional_inputs.style.display = 'none';
        additional_inputs_existing.style.display = 'none';

        // Determine which option is selected and show the corresponding additional input form
        if (updates_currentstatus.value === 'Dropped In Both Records') {
            additional_inputs.style.display = 'block';
        } else if (updates_currentstatus.value === 'Existing In Inventory Report') {
            additional_inputs_existing.style.display = 'block';
        }
    }

    // Add an event listener to listen for changes in the select element
    var updates_currentstatus = document.getElementById('updates_currentstatus');
    updates_currentstatus.addEventListener('change', showAdditionalInputs);

    // Call the function initially to set the initial state
    showAdditionalInputs();
</script>
<script>
    function fetchEmployeesByCenter() {
        var selectedCenter = document.getElementById("rescenter").value;
        var dataList = document.getElementById("accountable_options");
        var xhr = new XMLHttpRequest();

        // Encode the selectedCenter value
        var encodedCenter = encodeURIComponent(selectedCenter);

        xhr.onreadystatechange = function() {
            if (xhr.readyState == 4 && xhr.status == 200) {
                var employees = JSON.parse(xhr.responseText);

                // Clear the existing datalist options
                while (dataList.firstChild) {
                    dataList.removeChild(dataList.firstChild);
                }

                // Populate the datalist with employees from the selected center
                employees.forEach(function(employee) {
                    var option = document.createElement("option");
                    option.value = employee.employeeName;
                    dataList.appendChild(option);
                });
            }
        };

        // Use the encoded value in the URL
        xhr.open("GET", "fetch_employees.php?center=" + encodedCenter, true);
        xhr.send();
    }
</script>
<script>
function showEmployeesByCenter() {
    var accountableInput = document.getElementById("accountable_person");
    var selectedCenter = document.getElementById("rescenter").value; // Retrieve the selected Responsibility Center.

    // Check if the input field is empty
    if (accountableInput.value.trim() === "") {
        // Encode the selectedCenter value
        var encodedCenter = encodeURIComponent(selectedCenter);

        // Send an AJAX request to retrieve employees for the selected center
        var xhr = new XMLHttpRequest();
        xhr.onreadystatechange = function() {
            if (xhr.readyState === 4 && xhr.status === 200) {
                // Clear the existing options in the datalist
                var accountableDatalist = document.getElementById("accountable_options");
                while (accountableDatalist.firstChild) {
                    accountableDatalist.removeChild(accountableDatalist.firstChild);
                }
                
                // Parse the response and populate the datalist with new options
                var employees = JSON.parse(xhr.responseText);
                employees.forEach(function(employee) {
                    var option = document.createElement("option");
                    option.value = employee.employeeName;
                    accountableDatalist.appendChild(option);
                });
            }
        };
        
        // Use the encoded value in the URL
        xhr.open("GET", "fetch_employees.php?center=" + encodedCenter, true);
        xhr.send();
    }
}
</script>
</body>
</html>