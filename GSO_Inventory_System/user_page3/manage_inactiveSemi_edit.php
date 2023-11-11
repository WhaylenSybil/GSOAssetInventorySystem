<?php
require('./../database/connection.php');
require('../login/login_session.php');
include ('../admin_page/includes/manage_edit_inactiveSemi.php');

if (isset($_GET['ICSequipmentid'])) {
	$ICSequipmentid = $_GET['ICSequipmentid'];

	$pre_stmt = $connect->prepare("SELECT * FROM ics_properties WHERE ICSequipmentid = ?");
	$pre_stmt->bind_param('i', $ICSequipmentid);
	$pre_stmt->execute();
	$result = $pre_stmt->get_result();

	if ($result->num_rows >0) {
		$row = $result->fetch_assoc();
	}else{
		header("Location: inactiveSemi.php");
		exit();
	}
}
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
<body class="hold-transition skin-blue-light layout-top-nav fixed">
    <div class="wrapper">
    	<?php include("../user_page3/header/header.php");?>
    	<div class="content-wrapper">
    		<section class="content-header">
    			<h1>Edit Inactive Semi-Expendable Properties</h1>
    			<ol class="breadcrumb">
    				<li><a href="dashboard.php"><i class="fa fa-dashboard"></i>Edit Inactive Semi-Expendable Properties</a></li>
    				<li class="active">Edit Inactive Semi-Expendable Properties</li>
    			</ol>
    		</section>
    		<section class="content container-fluid">
    			<div class="box">
    				<div class="box-header bg-blue" align="center">
    					<h4 class="box-title">Edit Inactive Semi-Expendable Properties</h4>
    				</div><br>
    				<div class="row">
    					<div class="col-md-12">
	    					<form action="" method="post" enctype="multipart/form-data">
	    						<div class="form-group">
	    							<div class="col-md-3">
		    						    <label for="date_returned">Date Returned</label>
		    						    <input type="date" class="form-control" id="date_returned" name="date_returned" value="<?php echo $row['date_returned']; ?>">
	    						    </div>
	    						</div>
	    						<div class="form-group">
	    							<div class="col-md-3">
		    						    <label for="rescenter">Responsibility Center</label>
    						            <input list="rescenter_options" class="form-control" id="rescenter" placeholder="Responsibility Center" name="rescenter" value="<?php echo $row['responsibilitycenter_id']; ?>" autocomplete="off" onchange= "fetchEmployeesByCenter()">
    						            <datalist id="rescenter_options">
    						                <datalist id="rescenter_options">
    						                    <?php
    						                    $rescenter_query = $connect->query("SELECT co.office_id, co.office_name AS office_name, co.ocode_number FROM city_offices co UNION ALL SELECT no.noffice_id, no.noffice_name AS office_name, no.ncode_number FROM national_offices no ORDER BY office_name");
    						                    while ($rescenter_row = $rescenter_query->fetch_assoc()) {
    						                        $selected = ($rescenter_row['office_name'] === $row['responsibilitycenter_id']) ? 'selected' : '';
    						                        echo '<option value="' . $rescenter_row['office_name'] . '" ' . $selected . '>' . $rescenter_row['office_name'] . '</option>';
    						                    }
    						                    ?>
    						                </datalist>
    						            </datalist>
	    						    </div>
	    						</div>
	    						<div class="form-group">
	    							<div class="col-md-3">
		    						    <label for="acquisition_cost"> Acquisition Date</label>
		    						    <input type="date" class="form-control" id="acquisition_date" placeholder="Acquisition Date" name="acquisition_date" autocomplete="off" value="<?php echo $row['acquisitiondate']; ?>">
	    						    </div>
	    						</div>
	    						<div class="form-group">
	    							<div class="col-md-3">
		    						    <label for="PRS_WMR_no"> PRS/WMR Number</label>
		    						    <input type="text" class="form-control" id="PRS_WMR_no" placeholder="PRS/WMR Number" name="PRS_WMR_no" value="<?php echo $row['PRS_WMR_no']; ?>">
	    						    </div>
	    						</div>
	    						<div class="form-group">
	    							<div class="col-md-3">
		    						    <label for="unit_value"> Unit Value</label>
		    						    <input type="text" class="form-control" id="unit_value" placeholder="Unit Value" name="unit_value" oninput="formatUnitValue(this)" onblur="validateUnitValue(this)" value="<?php echo $row['unitvalue']; ?>" autocomplete="off">
	    						    </div>
	    						</div>
	    						<div class="form-group">
	    							<div class="col-md-3">
		    						    <label for="balance_per_card"> Balance per Card Qty</label>
		    						    <input type="number" class="form-control" id="balance_per_card" placeholder="Balance per card Qty" name="balance_per_card" value="<?php echo $row['balance_per_card']; ?>">
	    						    </div>
	    						</div>
	    						<div class="form-group">
	    							<div class="col-md-3">
		    						    <label for="acquisition_cost"> Acquisition Cost</label>
		    						    <input type="text" class="form-control" id="acquisition_cost" placeholder="Acquisition Cost" name="acquisition_cost" value="<?php echo $row['acquisitioncost']; ?>">
	    						    </div>
	    						</div>
	    						<div class="form-group">
	    							<div class="col-md-3">
		    						    <label for="article"> Article</label>
		    						    <input type="text" class="form-control" id="article" placeholder="Article" name="article" style="text-transform: uppercase;" value="<?php echo $row['article']; ?>" autocomplete="off">
	    						    </div>
	    						</div>
	    						<div class="form-group">
	    							<div class="col-md-3">
		    						    <label for="brand"> Brand/Model</label>
		    						    <input type="text" class="form-control" id="brand" placeholder="Brand/Model" name="brand" style="text-transform: uppercase;" value="<?php echo $row['brand']; ?>" autocomplete="off">
	    						    </div>
	    						</div>
	    						<div class="form-group">
	    							<div class="col-md-3">
		    						    <label for="serialno"> Serial Number</label>
		    						    <input type="text" class="form-control" id="serial_no" placeholder="Serial Number" name="serial_no" value="<?php echo $row['serialno']; ?>" autocomplete="off">
	    						    </div>
	    						</div>
	    						<div class="form-group">
	    							<div class="col-md-3">
		    						    <label for="particulars"> Particulars</label>
		    						    <input type="text" class="form-control" id="particulars" placeholder="Particulars" name="particulars" value="<?php echo $row['particulars']; ?>" autocomplete="off">
	    						    </div>
	    						</div>
	    						<div class="form-group">
	    							<div class="col-md-3">
		    						    <label for="engas"> eNGAS Property Number</label>
		    						    <input type="text" class="form-control" id="engas" placeholder="enGAS Property Number" name="engas" value="<?php echo $row['eNGAS']; ?>"autocomplete="off">
	    						    </div>
	    						</div>
	    						<div class="form-group">
	    							<div class="col-md-3">
		    						    <label for="property_no"> Property Number</label>
		    						    <input type="text" class="form-control" id="property_no" placeholder="Property Number" name="property_no" value="<?php echo $row['propertyno']; ?>" autocomplete="off">
	    						    </div>
	    						</div>
	    						<div class="form-group">
	    							<div class="col-md-3">
		    						    <label for="accountnumber"> Classification</label>
    						            <input list="classification_options" class="form-control" id="accountnumber" placeholder="Classification" name="accountnumber" value="<?php echo $row['classification_id']; ?>" autocomplete="off">
    						            <datalist id="classification_options">
    						                <?php
    						                $classification_query = $connect->query("SELECT account_code_id, account_number FROM account_codes");
    						                while ($classification_row = $classification_query->fetch_assoc()) {
    						                    $selected = ($classification_row['account_number'] === $row['account_number']) ? 'selected' : '';
    						                    echo '<option value="' . $classification_row['account_number'] . '" ' . $selected . '>' . $classification_row['account_number'] . '</option>';
    						                }
    						                ?>
    						            </datalist>
	    						    </div>
	    						</div>
	    						<div class="form-group">
	    							<div class="col-md-3">
		    						    <label for="est_life"> Estimated Useful Life</label>
		    						    <input list="est_life_options" class="form-control" id="est_life" placeholder="Estimated Useful Life" name="est_life" style="width:100%;" value="<?php echo $row['estimatedlife']; ?>">
		    						    <datalist id="est_life_options">
		    						        <option value="1 yr" <?php if ($row['estimatedlife'] === '1 yr') echo 'selected'; ?>>1 yr</option>
						                    <option value="2 yrs" <?php if ($row['estimatedlife'] === '2 yrs') echo 'selected'; ?>>2 yrs</option>
						                    <option value="3 yrs" <?php if ($row['estimatedlife'] === '3 yrs') echo 'selected'; ?>>3 yrs</option>
						                    <option value="4 yrs" <?php if ($row['estimatedlife'] === '4 yrs') echo 'selected'; ?>>4 yrs</option>
						                    <option value="5 yrs" <?php if ($row['estimatedlife'] === '5 yrs') echo 'selected'; ?>>5 yrs</option>
						                    <option value="6 yrs" <?php if ($row['estimatedlife'] === '6 yrs') echo 'selected'; ?>>6 yrs</option>
						                    <option value="7 yrs" <?php if ($row['estimatedlife'] === '7 yrs') echo 'selected'; ?>>7 yrs</option>
						                    <option value="8 yrs" <?php if ($row['estimatedlife'] === '8 yrs') echo 'selected'; ?>>8 yrs</option>
						                    <option value="9 yrs" <?php if ($row['estimatedlife'] === '9 yrs') echo 'selected'; ?>>9 yrs</option>
						                    <option value="10 yrs" <?php if ($row['estimatedlife'] === '10 yrs') echo 'selected'; ?>>10 yrs</option>
						                    <option value="11 yrs" <?php if ($row['estimatedlife'] === '11 yrs') echo 'selected'; ?>>11 yrs</option>
						                    <option value="12 yrs" <?php if ($row['estimatedlife'] === '12 yrs') echo 'selected'; ?>>12 yrs</option>
						                    <option value="13 yrs" <?php if ($row['estimatedlife'] === '13 yrs') echo 'selected'; ?>>13 yrs</option>
						                    <option value="14 yrs" <?php if ($row['estimatedlife'] === '14 yrs') echo 'selected'; ?>>14 yrs</option>
						                    <option value="15 yrs" <?php if ($row['estimatedlife'] === '15 yrs') echo 'selected'; ?>>15 yrs</option>
		    						    </datalist>
	    						    </div>
	    						</div>
	    						<div class="form-group">
	    							<div class="col-md-3">
		    						    <label for="unit_measure"> Unit of Measure</label>
		    						    <input type="text" class="form-control" id="unit_measure" placeholder="Unit of Measure" name="unit_measure" value="<?php echo $row['unitofmeasure']; ?>">
	    						    </div>
	    						</div>
	    						<div class="form-group">
	    							<div class="col-md-3">
		    						    <label for="onhand_per_count"> On-hand per Count Qty</label>
		    						    <input type="number" class="form-control" id="onhand_per_count" placeholder="On-hand per Count Qty" name="onhand_per_count" value="<?php echo $row['onhand_per_count']; ?>">
	    						    </div>
	    						</div>
	    						<div class="form-group">
	    							<div class="col-md-3">
		    						    <label for="shortage_overage_qty"> Shortage/Overage Qty</label>
		    						    <input type="text" class="form-control" id="shortage_overage_qty" placeholder="Shortage/Overage Qty" name="shortage_overage_qty" value="<?php echo $row['so_qty']; ?>">
	    						    </div>
	    						</div>
	    						<div class="form-group">
	    							<div class="col-md-3">
		    						    <label for="shortage_overage_value"> Shortage/Overage Value</label>
		    						    <input type="text" class="form-control" id="shortage_overage_value" placeholder="Shortage/Overage Value" name="shortage_overage_value" value="<?php echo $row['so_value']; ?>">
	    						    </div>
	    						</div>
	    						<div class="form-group"><!-- Accountable Person  -->
	    						    <div class="col-md-3">
	    						        <label for="accountable_person"> Accountable Employee</label>
	    						        <input list="accountable_options" class="form-control" id="accountable_person" placeholder="LAST NAME, First Name MI." name="accountable_person" autocomplete="off" value="<?php echo $row['accountable_person'] ?>" oninput="showEmployeesByCenter()">
	    						        <datalist id="accountable_options">
	    						            
	    						        </datalist>
	    						    </div>
    						    </div>
	    						<div class="form-group">
	    							<div class="col-md-3">
		    						    <label for="previous_condition"> Previous Condition</label>
		    						    <input type="text" class="form-control" id="previous_condition" placeholder="Previous Condition" name="previous_condition" value="<?php echo $row['previouscondition']; ?>"autocomplete="off">
	    						    </div>
	    						</div>
	    						<div class="form-group">
	    							<div class="col-md-3">
		    						    <label for="location"> Location</label>
		    						    <input type="text" class="form-control" id="location" placeholder="Location/Whereabouts" name="location" value="<?php echo $row['location']; ?>">
	    						    </div>
	    						</div>
	    						<div class="col-md-3"><!-- Current Condition -->
	    							<div class="form-group">
	    								<label for="current_condition"> Current Condition</label>
	    						        <input list="current_condition_options" class="form-control" id="current_condition_input" placeholder="Enter or select Current Condition" name="current_condition_input" value="<?php echo $row['currentcondition']; ?>">
	    						        <datalist id="current_condition_options">
	    						            <?php
						                        $conditions_query = $connect->query("SELECT condition_id, condition_name FROM conditions");
						                        while ($condition_row = $conditions_query->fetch_assoc()) {
						                            $selected = ($condition_row['condition_name'] === $row['condition_name']) ? 'selected' : '';
						                            echo '<option value="' . $condition_row['condition_name'] . '" ' . $selected . '>' . $condition_row['condition_name'] . '</option>';
						                        }
						                        ?>
	    						            <option value="Other"></option>
	    						        </datalist>
	    							</div>
	    						</div><!-- End Current Condition -->
	    						<div class="col-md-3"><!-- Current Condition Input -->
	    						    <div class="form-group">
	    						    	<label for="other_condition"> Other Condition</label>
	    						        <input type="text" class="form-control" id="other_condition_input" placeholder="Enter Other Condition" name="other_condition_input" disabled>
	    						    </div>
	    						</div><!-- End Current Condition Input -->
	    						<div class="form-group">
	    							<div class="col-md-3">
		    						    <label for="date_of_physical_inventory">Date of Physical Inventory</label>
		    						    <input type="text" name="date_of_physical_inventory" id="date_of_physical_inventory" class="form-control" placeholder="Date of Physical Inventory" value="<?php echo $row['date_of_physical_inventory']; ?>" autocomplete="off">
	    						    </div>
	    						</div>
	    						<div class="form-group">
	    							<div class="col-md-3">
		    						    <label for="remarks"> Remarks</label>
		    						    <input type="text" class="form-control" id="remarks" placeholder="Remarks"name="remarks" value="<?php echo $row['remarks']; ?>" autocomplete="off">
	    						    </div>
	    						</div>
	    						<div class="form-group">
	    							<div class="col-md-3">
		    						    <label for="scanned_ics">Scanned Supporting Documents</label>
		    						    <input type="file" class="form-control" id="scanned_ics" name="scanned_ics" accept=".pdf">
	    						    </div>
								</div>
								<div class="form-group">
								    <div class="col-md-3">
								        <label for="saved_scanned_file">Saved Scanned Document</label>
								        <input type="text" class="form-control" id="saved_scanned_file" name="saved_scanned_file" value="<?php echo $row['scannedICS']; ?>" readonly>
								    </div>
								</div>
	    						<br><br>
	    						<div class="row">
	    							<div class="col-md-12">
		    							<div class="form-group">
		    								<h4 class="box-title" align="center"><b>Additional Details for Reconciliation Purposes</b></h4>
		    							</div>
			    						<div class="form-group">
			    							<div class="col-md-3">
				    						    <label for="supplier">Supplier</label>
				    						    <input type="text" name="supplier" class="form-control" placeholder="Supplier" id="supplier" value="<?php echo $row['supplier']; ?>" autocomplete="off">
			    						    </div>
			    						</div>
			    						<div class="form-group">
			    							<div class="col-md-2">
				    						    <label for="PO_no">PO No.</label>
				    						    <input type="text" name="PO_no" class="form-control" placeholder="PO No." id="PO_no" value="<?php echo $row['PO_no']; ?>" autocomplete="off">
			    						    </div>
			    						</div>
			    						<div class="form-group">
			    							<div class="col-md-2">
				    						    <label for="AIR_RIS_no">AIR/RIS No.</label>
				    						    <input type="text" name="AIR_RIS_no" class="form-control" placeholder="AIR/RIS No"id="AIR_RIS_no" value="<?php echo $row['AIR_RIS_no']; ?>"autocomplete="off">
			    						    </div>
			    						</div>
			    						<div class="form-group">
			    							<div class="col-md-3">
				    						    <label for="notes">Notes</label>
				    						    <input type="text" name="notes" class="form-control" placeholder="Notes" id="notes" value="<?php echo $row['notes']; ?>" autocomplete="off">
			    						    </div>
			    						</div>
			    						<div class="form-group">
			    							<div class="col-md-2">
				    						    <label for="jev">JEV Number</label>
				    						    <input type="text" name="jev" id="jev" class="form-control" placeholder="JEV Number" value="<?php echo $row['jevno']; ?>" autocomplete="off">
			    						    </div>
			    						</div>
	    							</div>
	    						</div>
	    						<br><br><br>
	    						<div class="col-md-2"><!-- Save Button Registry -->
	    							<div class="form-group">
	    								<button type="submit" class="btn btn-success" name="btn_inactiveICS_update" onClick="">UPDATE</button>
	    							</div>
	    						</div><!-- End of Save Button Registry -->
	    						<div class="col-md-2"><!-- Cancel Button Registry -->
	    							<div class="form-group">
	    								<a href="inactiveSemi.php" class="btn btn-danger">Cancel</a>
	    							</div>
	    						</div><!-- End of Cancel Button Registry -->
	    					</form>
	    				</div>
    				</div>
    			</div>
    		</section>

    	</div>
    </div>
<!-- Scripts -->

<script type="text/javascript">
$(document).ready(function(){
    $('#accountnumber').on('change',function(){
        var classificationID = $(this).val();
        if(classificationID){
            $.ajax({
                type:'POST',
                url:'data.php',
                data:'classification_id='+classificationID,
                success:function(html){
                    $('#classification').html(html);
                 
                }
            }); 
        }else{
          
        }
    });
 
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
    var estLifeSelect = document.getElementById("est_life");

    // Add an event listener to listen for changes in the select element
    estLifeSelect.addEventListener("change", function() {
        // Get the selected value
        var estLifeValue = estLifeSelect.value;

        // You can now use the 'selectedValue' variable as needed
        console.log("Selected Value: " + estLifeValue);
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
        var formattedAcquisitionCost = acquisitionCost.toLocaleString(undefined, { minimumFractionDigits: 2, maximumFractionDigits: 2});
        var formattedShortageOverageValue = shortageOverageValue.toLocaleString(undefined, { minimumFractionDigits: 2, maximumFractionDigits: 2});

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
  function validateUnitValue(input) {
    var unitValue = parseFloat(input.value.replace(/,/g, ''));

    if (unitValue >= 50000) {
      // Create the modal background
      var modalBackground = document.createElement("div");
      modalBackground.className = "modal-background";
      document.body.appendChild(modalBackground);

      // Create the modal content
      var modalContent = document.createElement("div");
      modalContent.className = "modal-content";
      modalBackground.appendChild(modalContent);

      // Create the message
      var message = document.createElement("div");
      message.innerHTML = "Unit Value must be less than 50,000.";
      modalContent.appendChild(message);

      // Create the OK button
      var okButton = document.createElement("button");
      okButton.className = "ok-button";
      okButton.innerHTML = "OK";
      modalContent.appendChild(okButton);

      // Show the modal
      modalBackground.style.display = "flex";

      // Clear the field
      input.value = '';

      // Add a click event listener to the OK button
      okButton.addEventListener("click", function() {
        // Hide the modal
        modalBackground.style.display = "none";
        input.focus(); // Set focus back to the field
      });
    }
  }
</script>
<script>
  document.getElementById("accountable_person").addEventListener("blur", function() {
    var input = this.value;
    var datalist = document.getElementById("accountable_options");
    var options = datalist.options;
    var found = false;

    for (var i = 0; i < options.length; i++) {
      if (input === options[i].value) {
        found = true;
        break;
      }
    }

    if (!found) {
      // Create the modal background
      var modalBackground = document.createElement("div");
      modalBackground.className = "modal-background";
      document.body.appendChild(modalBackground);

      // Create the modal content
      var modalContent = document.createElement("div");
      modalContent.className = "modal-content";
      modalBackground.appendChild(modalContent);

      // Create the message
      var message = document.createElement("div");
      message.innerHTML = "Please add '" + input + "' to the Data List > Add Employee first along with its associated office/department, TIN Number, and employee Number.";

      // Create the OK button
      var okButton = document.createElement("button");
      okButton.className = "ok-button";
      okButton.innerHTML = "OK";

      // Append the modal content and the OK button to the modal background
      modalBackground.appendChild(modalContent);
      modalContent.appendChild(message);
      modalContent.appendChild(okButton);

      // Show the modal
      modalBackground.style.display = "flex";

      // Clear the input
      this.value = "";

      // Add a click event listener to the OK button
      okButton.addEventListener("click", function() {
        // Hide the modal
        modalBackground.style.display = "none";
      });
    }
  });
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
?>

