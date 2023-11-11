<?php
require('./../database/connection.php');
require('../login/login_session.php');
include ('../admin_page/includes/save_add_PRS.php');
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
            <form method="POST" action="">
              <div class="col-md-3" style="display: none;"><!-- Type, Either PRS or WMR -->
                <div class="form-group">
                  <label for="type"> Type</label>
                  <input type="text" class="form-control" id="type" placeholder="PRS" name="type" autocomplete="off" value="PRS">
                </div>
              </div><!-- End Type, Either PRS or WMR -->
              <div class="col-md-3"><!-- Date ReturnedRecorded -->
                <div class="form-group">
                  <label for="dateReturnedRecorded"> Date Returned/Recorded</label>
                  <input type="date" class="form-control" id="dateReturnedRecorded" placeholder="Date Returned/Recorded" name="dateReturnedRecorded" autocomplete="off" value="<?php echo date('Y-m-d'); ?>">
                </div>
              </div><!-- End Date Recorded -->
              <div class="col-md-3"><!-- Item No. -->
                <div class="form-group">
                  <label for="ItemNo"> Item No.</label>
                  <input type="text" class="form-control" id="ItemNo" placeholder="Item No." name="ItemNo" autocomplete="off">
                </div>
              </div><!-- End Item No. -->
              <div class="col-md-3"><!--PRS/WMR Number -->
                <div class="form-group">
                  <label for="prsNumber"> PRS/WMR Number</label>
                  <input type="text" class="form-control" id="prsNumber" placeholder="PRS/WMR Number" name="prsNumber" autocomplete="off">
                </div>
              </div><!-- End ARE/MR Number -->
              <div class="col-md-3"><!-- Article -->
                <div class="form-group">
                  <label for="article"> Article</label>
                  <input type="text" class="form-control" id="article" placeholder="Article" name="article" autocomplete="off" style="text-transform: uppercase;">
                </div>
              </div><!-- End Article -->
              <div class="col-md-3"><!-- Brand/Model -->
                <div class="form-group">
                  <label for="brand"> Brand/Model</label>
                  <input type="text" class="form-control" id="brand" placeholder="Brand/Model" name="brand" autocomplete="off"style="text-transform: uppercase;">
                </div>
              </div><!-- End Brand/Model -->
              <div class="col-md-3"><!-- Serial Number -->
                <div class="form-group">
                  <label for="serialNumber"> Serial Number/s</label>
                  <input type="text" class="form-control" id="serialNumber" placeholder="Serial Number" name="serialNumber" autocomplete="off">
                </div>
              </div><!-- End Serial Number -->
              <div class="col-md-3"><!-- Particulars -->
                <div class="form-group">
                  <label for="particulars"> Particulars</label>
                  <input type="text" class="form-control" id="particulars" placeholder="Particulars" name="particulars" autocomplete="off">
                </div><!-- End Particulars -->
              </div>
              <div class="col-md-3"><!--ARE/MR Number -->
                <div class="form-group">
                  <label for="areNumber"> ARE/MR Number</label>
                  <input type="text" class="form-control" id="areNumber" placeholder="ARE/MR Number" name="areNumber" autocomplete="off">
                </div>
              </div><!-- End ARE/MR Number -->
              <div class="col-md-3"><!-- enGAS Property Number  -->
                <div class="form-group">
                  <label for="engasNumber"> eNGAS Property Number</label>
                  <input type="text" class="form-control" id="engasNumber" placeholder="enGAS Property Number" name="engasNumber" autocomplete="off">
                </div>
              </div><!-- End eNGAS Property Number   -->
              <div class="col-md-3"><!-- Acquisition Date -->
                <div class="form-group">
                  <label for="acquisitionDate"> Acquisition Date</label>
                  <input type="date" class="form-control" id="acquisitionDate" placeholder="Acquisition Date" name="acquisitionDate" autocomplete="off">
                </div>
              </div><!-- End Acquisition Date -->
              <div class="col-md-3"><!-- Unit Value -->
                <div class="form-group">
                  <label for="unitValue"> Unit Value</label>
                  <input type="text" class="form-control" id="unitValue" placeholder="Unit Value" name="unitValue" autocomplete="off">
                </div>
              </div><!-- End Unit Value -->
              <div><!-- Balance per Card -->
                <div class="col-md-3">
                  <div class="form-group">
                    <label for="balancePerCard">Balance per Card</label>
                    <input type="text" class="form-control" id="balancePerCard" placeholder="Balance per Card" name="balancePerCard" autocomplete="off">
                  </div>
                </div>
              </div><!-- End of Balance per card -->
              <div class="col-md-3"><!-- Acquisition Cost -->
                <div class="form-group">
                  <label for="acquisitionCost"> Acquisition Cost</label>
                  <input type="text" class="form-control" id="acquisitionCost" placeholder="Acquisition Cost" name="acquisitionCost" autocomplete="off" readonly>
                </div>
              </div><!-- End Acquisition Cost -->
              <div class="col-md-3"><!-- Property Number -->
                <div class="form-group">
                  <label for="propertyNumber"> Property Number</label>
                  <input type="text" class="form-control" id="propertyNumber" placeholder="Property Number" name="propertyNumber" autocomplete="off">
                </div>
              </div><!-- End Property Number -->
              <div class="col-md-3"><!-- Classification -->
                  <div class="form-group">
                      <label for="accountnumber"> Classification</label>
                      <input list="classification_options" class="form-control" id="accountnumber" placeholder="Classification" name="accountnumber" autocomplete="off">
                      <datalist id="classification_options">
                          <?php
                          $query1 = $connect->query("SELECT * FROM account_codes");
                          $rowCount = $query1->num_rows;
                          if ($rowCount > 0) {
                              while ($row = $query1->fetch_assoc()) {
                                  echo '<option value="' . $row['account_number'] . '">' . $row['account_number'] . '</option>';
                              }
                          } else {
                              echo '<option value="">No Classifications available</option>';
                          }
                          ?>
                      </datalist>
                  </div>
              </div><!-- End of Classification -->
              <div class="col-md-3"><!-- Estimated Useful Life -->
                  <div class="form-group">
                      <label for="estLife"> Estimated Useful Life</label>
                      <input list="est_life_options" class="form-control" id="estLife" placeholder="Estimated Useful Life" name="estLife" style="width:100%;">
                      <datalist id="est_life_options">
                          <option value="1 yr">
                          <option value="2 yrs">
                          <option value="3 yrs">
                          <option value="4 yrs">
                          <option value="5 yrs">
                          <option value="6 yrs">
                          <option value="7 yrs">
                          <option value="8 yrs">
                          <option value="9 yrs">
                          <option value="10 yrs">
                          <option value="11 yrs">
                          <option value="12 yrs">
                          <option value="13 yrs">
                          <option value="14 yrs">
                          <option value="15 yrs">
                      </datalist>
                  </div>
              </div><!-- End Estimated Useful Life -->
              <div class="col-md-3"><!-- Unit of Measure -->
                <div class="form-group">
                  <label for="unitOfMeasure"> Unit of Measure</label>
                  <input type="text" class="form-control" id="unitOfMeasure" placeholder="Unit of Measure" name="unitOfMeasure" autocomplete="off">
                </div>
              </div><!-- End Unit of Measure -->
              <div class="col-md-3"><!-- On hand per count qty -->
                <div class="form-group">
                  <label for="onhandPerCount"> On-hand per Count Qty</label>
                  <input type="text" class="form-control" id="onhandPerCount" placeholder="On-hand per Count Qty" name="onhandPerCount" autocomplete="off">
                </div>
              </div><!-- End On hand per count qty-->
              <div class="col-md-3"><!-- Shortage/Overage qty -->
                <div class="form-group">
                  <label for="soQty"> Shortage/Overage Qty</label>
                  <input type="text" class="form-control" id="soQty" placeholder="Shortage/Overage Qty" name="soQty" readonly>
                </div>
              </div><!-- End Shortage/Overage qty -->
              <div class="col-md-3"><!-- Shortage/Overage value -->
                <div class="form-group">
                  <label for="soValue"> Shortage/Overage Value</label>
                  <input type="text" class="form-control" id="soValue" placeholder="Shortage/Overage Value" name="soValue" readonly>
                </div>
              </div><!-- End Shortage/Overage value -->
              <div class="col-md-3"><!-- Responsibility Center -->
                  <div class="form-group">
                      <label for="rescenter"> Responsibility Center (Offices and Departments)</label>
                      <input list="rescenter_options" class="form-control" id="rescenter" placeholder="Responsibility Center" name="rescenter" autocomplete="off">
                      <datalist id="rescenter_options">
                          <?php
                          $query1 = $connect->query("SELECT co.office_id, co.office_name, co.ocode_number FROM city_offices co UNION ALL SELECT no.noffice_id, no.noffice_name, no.ncode_number FROM national_offices no");
                          $rowCount = $query1->num_rows;
                          if ($rowCount > 0) {
                              while ($row = $query1->fetch_assoc()) {
                                  echo '<option value="'.$row['office_name'].'">'.$row['office_name'].'</option>';
                              }
                          } else {
                              echo '<option value="">No Responsibility Center available</option>';
                          }
                          ?>
                      </datalist>
                  </div>
              </div><!-- End Responsibility Center -->
              <div class="col-md-3"><!-- Accountable Person -->
                <div class="form-group">
                  <label for="accountableEmployee"> Accountable Employee</label>
                  <input type="text" id="accountableEmployee" name="accountableEmployee" placeholder="LAST NAME, First Name, MI." class="form-control">
                </div>
              </div><!-- End Accountable Person -->
              <div class="col-md-3"><!-- Remarks -->
                <div class="form-group">
                  <label for="remarks"> Remarks</label>
                  <input type="text" class="form-control" id="remarks" placeholder="Remarks" autocomplete="off"  name="remarks">
                </div>
              </div><!-- End Remarks -->
              
              <div class="col-md-3"><!-- IIRUP -->
                <div class="form-group">
                  <label for="iirup"> IIRUP</label>
                  <input type="text" class="form-control" id="iirup" placeholder="IIRUP" autocomplete="off"  name="iirup">
                </div>
              </div><!-- End IIRUP -->
              <div class="col-md-3"><!-- IIRUP Date -->
                <div class="form-group">
                  <label for="iirupDate"> Date of IIRUP</label>
                  <input type="text" class="form-control" name="iirupDate" id="iirupDate" placeholder="Date of IIRUP" autocomplete="off">
                </div>
              </div><!-- End of IIRUP Date --><br><br>
              <div class="col-md-3"><!-- W/ MR/ARE Attachment -->
                <div class="form-group">
                  <input type="checkbox" id="withAttachment" placeholder="W/ MR/ARE Attachment" autocomplete="off"  name="withAttachment">
                  <label for="withAttachment" style="font-weight: bold;">With MR/ARE Attachment</label>
                </div>
              </div><!-- End W/ MR/ARE Attachment -->
              <div class="col-md-3"><!-- PRS Cover Page -->
                <div class="form-group">
                  <input type="checkbox" id="prsCoverPage" placeholder="PRS Cover Page" autocomplete="off"  name="prsCoverPage">
                  <label for="prsCoverPage" style="font-weight: bold;">PRS Cover Page</label>
                </div>
              </div><!-- End PRS Cover Page -->
<!-- ==================================Mode of Disposal================================================ -->
              <div class="col-md-12"><!-- ADDITIONAL INFORMATION -->
                <div class="form-group">
                  <h4 class="box-title" align="center"><b>Additional Details for Reconciliation Purposes</b></h4>
                </div>
              </div><!-- End ADDITIONAL INFORMATION -->
              <div class="col-md-12">
                <div class="form-group">
                  <select id="modeofdisposal_options" onchange="showSelectedForm(1)" class="form-control" name="modeofdisposal_options" id="modeofdisposal_options">
                    <option value="">---Select a mode of disposal---</option>
                    <option value="Destroyed Or Condemned"> By Destruction or Condemnation</option>
                    <option value="Sold Through Negotiation">Sold through Negotiation</option>
                    <option value="Sold Through Public Auction">Sold through Public Auction</option>
                    <option value="Transferred Without Cost">Transferred without Cost to Other Offices/Departments, and to Other Agencies</option>
                    <option value="Continued In Service">Continued in Service</option>
                  </select>
                  <!-- ============================================================= -->
                  <!-- Form for Destroyed and Thrown -->
                  <div  id="form-DestroyedOrCondemned" class="additional-info">
                    <div class="col-md-6">
                      <label for="part_destroyed_thrown">Parts Destroyed or Thrown</label>
                      <textarea type="text" name="part_destroyed_thrown" id="part_destroyed_thrown" placeholder="Part Destroyed or Thrown" class="form-control" autocomplete="off"></textarea>
                    </div>
                    <div class="col-md-6">
                      <label for="notesDestroyed">Remarks</label>
                      <textarea type="text" name="notesDestroyed" id="notesDestroyed" class="form-control" autocomplete="off"></textarea>
                    </div>
                  </div><!-- End of Form for Destroyed and Thrown -->
                  <!-- ============================================================================================== -->
                  <!-- Form for Sold Through Negotiation -->
                  <div id="form-SoldThroughNegotiation" class="additional-info">
                    <div class="col-md-3">
                      <div class="form-group">
                        <label for="date_of_sale">Date of Sale</label>
                        <input type="date" name="date_of_sale" id="date_of_sale" placeholder="Date of Sale" class="form-control" autocomplete="off">
                      </div>
                    </div>
                    <div class="col-md-3">
                      <label for="date_of_OR_Negotiation">Date of OR</label>
                      <input class="form-control" type="date" name="date_of_OR_Negotiation" id="date_of_OR_Negotiation" placeholder="Date of OR" autocomplete="off">
                    </div>
                    <div class="col-md-3">
                      <label for="OR_no_Negotiation">OR Number</label>
                      <input class="form-control" type="text" name="OR_no_Negotiation" id="OR_no_Negotiation" placeholder="OR Number" autocomplete="off">
                    </div>
                    <div class="col-md-3">
                      <label for="amountNegotiation">Amount</label>
                      <input class="form-control" type="text" name="amountNegotiation" id="amountNegotiation" placeholder="Amount" autocomplete="off"><br>
                    </div>
                    <div class="col-md-6">
                      <label for="notesNegotiation">Notes</label>
                      <textarea type="text" name="notesNegotiation" id="notesNegotiation" class="form-control" autocomplete="off"></textarea>
                    </div>
                  </div><!-- End of Form for Sold Through Negotiation -->
                  <!-- ============================================================================================= -->
                  <!-- Form for Sold Through Auction -->
                  <div id="form-SoldThroughPublicAuction" class="additional-info">
                    <div class="col-md-3">
                      <div class="form-group">
                        <label for="date_of_auction">Date of Auction</label>
                        <input type="date" name="date_of_auction" id="date_of_auction" placeholder="Date of Auction" class="form-control" autocomplete="off">
                      </div>
                    </div>
                    <div class="col-md-3">
                      <div class="form-group">
                        <label for="date_of_OR_Auction">Date of OR</label>
                        <input class="form-control" type="date" name="date_of_OR_Auction" id="date_of_OR_Auction" placeholder="Date of OR" autocomplete="off">
                      </div>
                    </div>
                    <div class="col-md-3">
                      <div class="form-group">
                        <label for="OR_no_Auction">OR Number</label>
                        <input class="form-control" type="text" name="OR_no_Auction" id="OR_no_Auction" placeholder="OR Number" autocomplete="off">
                      </div>
                    </div>
                    <div class="col-md-3">
                      <div class="form-group">
                        <label for="Auction">Amount</label>
                        <input class="form-control" type="text" name="amountAuction" id="amountAuction" placeholder="Amount" autocomplete="off">
                      </div>
                    </div><br>
                    <div class="col-md-6">
                      <label for="notesAuction">Notes</label>
                      <textarea type="text" name="notesAuction" id="notesAuction" class="form-control" autocomplete="off"></textarea>
                    </div>
                  </div><!-- End of Form for Sold Through Negotiation -->
                  <!-- ============================================================================================= -->
                  <!-- Form for Transferred without cost -->
                  <div id="form-TransferredWithoutCost" class="additional-info">
                    <div class="col-md-3">
                      <div class="form-group">
                        <label for="date_of_transfer">Date of Transfer(Without Cost)</label>
                        <input type="date" name="date_of_transfer" id="date_of_transfer" placeholder="Date of Transfer" class="form-control" autocomplete="off">
                      </div>
                    </div>
                    <div class="col-md-4">
                      <div class="form-group">
                        <label for="recipient_transferred">Recipient(Name of Agency/Institution)</label>
                        <input type="text" name="recipient_transferred" id="recipient_transferred" placeholder="Recipient(Name of Agency/Institution)" class="form-control" autocomplete="off">
                      </div>
                    </div>
                    <div class="col-md-5">
                      <label for="notesTransferred">Notes</label>
                      <textarea type="text" name="notesTransferred" id="notesTransferred" class="form-control" autocomplete="off"></textarea>
                    </div>
                  </div><!-- End of Form for Transferred without cost -->
                  <!-- ============================================================================================= -->
                  <!-- Form for Constinued in Service -->
                  <div id="form-ContinuedInService" class="additional-info">
                    <div class="col-md-3">
                      <div class="form-group">
                        <label for="date_of_transfer_continued">Date of Transfer(Continued Service)</label>
                        <input type="date" name="date_of_transfer_continued" id="date_of_transfer_continued" placeholder="Date of Transfer" class="form-control" autocomplete="off">
                      </div>
                    </div>
                    <div class="col-md-4">
                      <div class="form-group">
                        <label for="recipient_continued">Recipient(Name of Agency/Institution)</label>
                        <input type="text" name="recipient_continued" id="recipient_continued" placeholder="Recipient(Name of Agency/Institution)" class="form-control" autocomplete="off">
                      </div>
                    </div>
                    <div class="col-md-5">
                      <div class="form-group">
                        <label for="notesContinued">Notes</label>
                        <textarea type="text" name="notesContinued" id="notesContinued" class="form-control" autocomplete="off"></textarea>
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
                    <option value="Dropped In Both Records"> Dropped in Both Records</option>
                    <option value="Existing In Inventory Report">Existing in Inventory Report(For Further Monitoring)</option>
                  </select>
                  <!-- ============================================================= -->
                  <!-- Form for dropped in both records -->
                  <div  id="additional_inputs" class="form-group" style="display:none;">
                      <div class="col-md-3">
                        <label for="JEV_no">JEV Number</label>
                        <input type="text" name="JEV_no" id="JEV_no" placeholder="JEV Number" class="form-control" autocomplete="off">
                      </div>
                      <div class="col-md-3">
                        <label for="date_dropped">Date</label>
                        <input type="date" name="date_dropped" id="date_dropped" placeholder="Date" class="form-control" autocomplete="off">
                      </div>
                      <div class="col-md-3">
                        <label for="actions_to_be_taken_Dropped">Notes</label>
                        <input type="text" name="actions_to_be_taken_Dropped" id="actions_to_be_taken_Dropped" placeholder="Actions to be Taken" class="form-control" autocomplete="off">
                      </div>
                  </div><!-- End of Form for dropped in both records -->
                  <!-- Form for Existing in Both Records -->
                  <div id="additional_inputs_existing" class="form-group" style="display:none;">
                    <div class="col-md-3">
                        <label for="actions_to_be_taken_Existing">Remarks</label>
                        <input type="text" name="actions_to_be_taken_Existing" id="actions_to_be_taken_Existing" placeholder="Actions to be Taken" class="form-control" autocomplete="off" value="For further monitoring;">
                    </div>
                  </div>
                </div>
              </div>
              
              <br><br><br>
              <div class="col-md-12"><!-- Save Button PRS -->
                <div class="form-group">
                  <button type="submit" class="btn btn-success" name="btn_PRS_save" onClick="">Add PRS</button>
                </div>
              </div><!-- End of Save Button PRS -->
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
        var onHandPerCount = parseFloat(document.getElementById("onhandPerCount").value) || 0;

        // Calculate acquisition cost: unit value * balance per card
        var acquisitionCost = unitValue * balancePerCard;

        // Calculate shortage/overage qty: balance per card - on hand per count
        var shortageOverageQty = balancePerCard - onHandPerCount;

        // Calculate shortage/overage value: unit value * shortage/overage qty
        var shortageOverageValue = unitValue * shortageOverageQty;

        // Format the acquisition cost with commas
        var formattedAcquisitionCost = acquisitionCost.toLocaleString(undefined, { minimumFractionDigits: 2, maximumFractionDigits: 2 });
        var formattedShortageOverageValue = shortageOverageValue.toLocaleString(undefined, { minimumFractionDigits: 2, maximumFractionDigits: 2 });

        // Format the shortage/overage qty and shortage/overage value as strings with two decimal places
        var formattedShortageOverageQty = shortageOverageQty;

        // Update the acquisition cost, shortage/overage qty, and shortage/overage value inputs
        document.getElementById("acquisitionCost").value = formattedAcquisitionCost;
        document.getElementById("soQty").value = formattedShortageOverageQty;
        document.getElementById("soValue").value = formattedShortageOverageValue;
    }

    // Add event listeners to unitValue, balancePerCard, and onHandPerCount inputs
    document.getElementById("unitValue").addEventListener("input", updateCalculations);
    document.getElementById("balancePerCard").addEventListener("input", updateCalculations);
    document.getElementById("onhandPerCount").addEventListener("input", updateCalculations);

    // Initial calculation when the page loads (optional)
    updateCalculations();
</script>

<script type="text/javascript">
    // Get references to the select and input elements
    var currentConditionSelect = document.getElementById("current_condition_input");
    var currentConditionInput = document.getElementById("other_condition_input");

    // Add an event listener to the select element
    currentConditionSelect.addEventListener("change", function() {
        if (currentConditionSelect.value === "Other") {
            // If "Other" is selected, enable the input field
            currentConditionInput.disabled = false;
        } else {
            // If any other option is selected, disable and clear the input field
            currentConditionInput.disabled = true;
            currentConditionInput.value = "";
        }
    });
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
    var estLifeSelect = document.getElementById("estLife");

    // Add an event listener to listen for changes in the select element
    estLifeSelect.addEventListener("change", function() {
        // Get the selected value
        var estLifeValue = estLifeSelect.value;

        // You can now use the 'selectedValue' variable as needed
        console.log("Selected Value: " + estLifeValue);
    });
</script>

<!-- Script for the function to show the selected additional information form -->
<script>
    // Function to show the selected additional information form
    function showSelectedForm() {
        const modeofdisposal_options = document.getElementById('modeofdisposal_options');
        
        // Hide all additional information forms
        const additionalForms = document.querySelectorAll('.additional-info');
        additionalForms.forEach(form => {
            form.style.display = 'none';
        });
        
        // Show the selected additional information form
        const selectedForm = document.getElementById('form-' + modeofdisposal_options.value.replace(/ /g, ''));
        if (selectedForm) {
            selectedForm.style.display = 'block';
        }
    }
</script>
<!-- END of Script for function to show the selected additional information form-->

<!-- Script for the function to show the selected additional information form -->
<script>
    // Function to show the selected additional information form
    function showAdditionalInputs() {
        var updates_currentstatus = document.getElementById('updates_currentstatus');
        var additional_inputs = document.getElementById('additional_inputs');
        var additional_inputs_existing = document.getElementById('additional_inputs_existing');

        if (updates_currentstatus.value === 'Dropped In Both Records') {
            additional_inputs.style.display = 'block';
            additional_inputs_existing.style.display = 'none';
        } else if (updates_currentstatus.value === 'Existing In Inventory Report') {
            additional_inputs.style.display = 'none';
            additional_inputs_existing.style.display = 'block';
        } else {
            additional_inputs.style.display = 'none';
            additional_inputs_existing.style.display = 'none';
        }
    }
</script>
<!-- END of Script for function to show the selected additional information form-->

</body>
</html>