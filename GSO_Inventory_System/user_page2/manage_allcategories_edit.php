<?php
require('./../database/connection.php');
require('../login/login_session.php');
include ('../admin_page/includes/manage_edit_all_categories.php');
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
    	<?php include("../admin_page/header/header.php");
    	include("../admin_page/header/sidebar.php");?>
    	<div class="content-wrapper">
    		<section class="content-header">
    			<h1>ALL CATEGORIES</h1>
    			<ol class="breadcrumb">
    				<li><a href="dashboard.php"><i class="fa fa-dashboard"></i>ALL CATEGORIES</a></li>
    				<li class="active">ALL CATEGORIES</li>
    			</ol>
    		</section>
    		<section class="content container-fluid">
    			<div class="box">
    				<div class="box-header bg-blue" align="center">
    					<h4 class="box-title">ALL CATEGORIES</h4>
    				</div><br>
    				<div class="row">
    					<div class="col-md-12">
	    					<form action="" method="post" enctype="multipart/form-data">
	    						<div class="form-group">
	    							<div class="col-md-3">
		    						    <label for="date_recorded_recorded">Date Returned/Recorded</label>
		    						    <input type="date" class="form-control" id="date_recorded_returned" name="date_recorded_returned" value="<?php echo $editRow['dateRecordedReturned']; ?>">
	    						    </div>
	    						</div>
	    						<div class="form-group">
	    							<div class="col-md-3">
		    						    <label for="rescenter">Responsibility Center</label>
    						            <input list="rescenter_options" class="form-control" id="rescenter" placeholder="Responsibility Center" name="rescenter" value="<?php echo $editRow['rescenter']; ?>" autocomplete="off">
    						            <datalist id="rescenter_options">
    						                <?php
    						                $rescenter_query = $connect->query("SELECT co.office_id, co.office_name, co.ocode_number FROM city_offices co UNION ALL SELECT no.noffice_id, no.noffice_name, no.ncode_number FROM national_offices no");
    						                while ($rescenter_row = $rescenter_query->fetch_assoc()) {
    						                    $selected = ($rescenter_row['office_name'] === $editRow['rescenter']) ? 'selected' : '';
    						                    echo '<option value="' . $rescenter_row['office_name'] . '" ' . $selected . '>' . $rescenter_row['office_name'] . '</option>';
    						                }
    						                ?>
    						            </datalist>
	    						    </div>
	    						</div>
	    						<div class="form-group">
	    							<div class="col-md-3">
		    						    <label for="acquisition_cost"> Acquisition Date</label>
		    						    <input type="date" class="form-control" id="acquisition_date" placeholder="Acquisition Date" name="acquisition_date" autocomplete="off" value="<?php echo $editRow['acquisitiondate']; ?>">
	    						    </div>
	    						</div>
	    						<div class="form-group">
	    							<div class="col-md-3">
		    						    <label for="ARE_no"> ARE/MR OR PRS/WMR Number</label>
		    						    <input type="text" class="form-control" id="ARE_no" placeholder="ARE/ICS Number" name="ARE_no" value="<?php echo $editRow['ARE_PRS']; ?>" autocomplete="off">
	    						    </div>
	    						</div>
	    						<div class="form-group">
	    							<div class="col-md-3">
		    						    <label for="unit_value"> Unit Value</label>
		    						    <input type="text" class="form-control" id="unit_value" placeholder="Unit Value" name="unit_value" onblur="validateUnitValue(this)" value="<?php echo $editRow['unitvalue']; ?>" autocomplete="off">
	    						    </div>
	    						</div>
	    						<div class="form-group">
	    							<div class="col-md-3">
		    						    <label for="balance_per_card"> Balance per Card Qty</label>
		    						    <input type="number" class="form-control" id="balance_per_card" placeholder="Balance per card Qty" name="balance_per_card" value="<?php echo $editRow['balance_per_card']; ?>">
	    						    </div>
	    						</div>
	    						<div class="form-group">
	    							<div class="col-md-3">
		    						    <label for="acquisition_cost"> Acquisition Cost</label>
		    						    <input type="text" class="form-control" id="acquisition_cost" placeholder="Acquisition Cost" name="acquisition_cost" value="<?php echo $editRow['acquisitioncost']; ?>">
	    						    </div>
	    						</div>
	    						<div class="form-group">
	    							<div class="col-md-3">
		    						    <label for="article"> Article</label>
		    						    <input type="text" class="form-control" id="article" placeholder="Article" name="article" style="text-transform: uppercase;" value="<?php echo $editRow['article']; ?>">
	    						    </div>
	    						</div>
	    						<div class="form-group">
	    							<div class="col-md-3">
		    						    <label for="brand"> Brand/Model</label>
		    						    <input type="text" class="form-control" id="brand" placeholder="Brand/Model" name="brand" style="text-transform: uppercase;" value="<?php echo $editRow['brand']; ?>">
	    						    </div>
	    						</div>
	    						<div class="form-group">
	    							<div class="col-md-3">
		    						    <label for="serialno"> Serial Number</label>
		    						    <input type="text" class="form-control" id="serial_no" placeholder="Serial Number" name="serial_no" value="<?php echo $editRow['serialno']; ?>">
	    						    </div>
	    						</div>
	    						<div class="form-group">
	    							<div class="col-md-3">
		    						    <label for="particulars"> Particulars</label>
		    						    <input type="text" class="form-control" id="particulars" placeholder="Particulars" name="particulars" value="<?php echo $editRow['particulars']; ?>">
	    						    </div>
	    						</div>
	    						<div class="form-group">
	    							<div class="col-md-3">
		    						    <label for="engas"> eNGAS Property Number</label>
		    						    <input type="text" class="form-control" id="engas" placeholder="enGAS Property Number" name="engas" value="<?php echo $editRow['eNGAS']; ?>">
	    						    </div>
	    						</div>
	    						<div class="form-group">
	    							<div class="col-md-3">
		    						    <label for="property_no"> Property Number</label>
		    						    <input type="text" class="form-control" id="property_no" placeholder="Property Number" name="property_no" value="<?php echo $editRow['propertyno']; ?>">
	    						    </div>
	    						</div>
	    						<div class="form-group">
	    							<div class="col-md-3">
		    						    <label for="accountnumber"> Classification</label>
    						            <input list="classification_options" class="form-control" id="accountnumber" placeholder="Classification" name="accountnumber" value="<?php echo $editRow['classification_id']; ?>">
    						            <datalist id="classification_options">
    						                <?php
    						                $classification_query = $connect->query("SELECT account_code_id, account_number FROM account_codes");
    						                while ($classification_row = $classification_query->fetch_assoc()) {
    						                    $selected = ($classification_row['account_number'] === $editRow['account_number']) ? 'selected' : '';
    						                    echo '<option value="' . $classification_row['account_number'] . '" ' . $selected . '>' . $classification_row['account_number'] . '</option>';
    						                }
    						                ?>
    						            </datalist>
	    						    </div>
	    						</div>
	    						<div class="form-group">
	    							<div class="col-md-3">
		    						    <label for="est_life"> Estimated Useful Life</label>
		    						    <input list="est_life_options" class="form-control" id="est_life" placeholder="Estimated Useful Life" name="est_life" style="width:100%;" value="<?php echo $editRow['estimatedlife']; ?>">
		    						    <datalist id="est_life_options">
		    						        <option value="1 yr" <?php if ($editRow['estimatedlife'] === '1 yr') echo 'selected'; ?>>1 yr</option>
						                    <option value="2 yrs" <?php if ($editRow['estimatedlife'] === '2 yrs') echo 'selected'; ?>>2 yrs</option>
						                    <option value="3 yrs" <?php if ($editRow['estimatedlife'] === '3 yrs') echo 'selected'; ?>>3 yrs</option>
						                    <option value="4 yrs" <?php if ($editRow['estimatedlife'] === '4 yrs') echo 'selected'; ?>>4 yrs</option>
						                    <option value="5 yrs" <?php if ($editRow['estimatedlife'] === '5 yrs') echo 'selected'; ?>>5 yrs</option>
						                    <option value="6 yrs" <?php if ($editRow['estimatedlife'] === '6 yrs') echo 'selected'; ?>>6 yrs</option>
						                    <option value="7 yrs" <?php if ($editRow['estimatedlife'] === '7 yrs') echo 'selected'; ?>>7 yrs</option>
						                    <option value="8 yrs" <?php if ($editRow['estimatedlife'] === '8 yrs') echo 'selected'; ?>>8 yrs</option>
						                    <option value="9 yrs" <?php if ($editRow['estimatedlife'] === '9 yrs') echo 'selected'; ?>>9 yrs</option>
						                    <option value="10 yrs" <?php if ($editRow['estimatedlife'] === '10 yrs') echo 'selected'; ?>>10 yrs</option>
						                    <option value="11 yrs" <?php if ($editRow['estimatedlife'] === '11 yrs') echo 'selected'; ?>>11 yrs</option>
						                    <option value="12 yrs" <?php if ($editRow['estimatedlife'] === '12 yrs') echo 'selected'; ?>>12 yrs</option>
						                    <option value="13 yrs" <?php if ($editRow['estimatedlife'] === '13 yrs') echo 'selected'; ?>>13 yrs</option>
						                    <option value="14 yrs" <?php if ($editRow['estimatedlife'] === '14 yrs') echo 'selected'; ?>>14 yrs</option>
						                    <option value="15 yrs" <?php if ($editRow['estimatedlife'] === '15 yrs') echo 'selected'; ?>>15 yrs</option>
		    						    </datalist>
	    						    </div>
	    						</div>
	    						<div class="form-group">
	    							<div class="col-md-3">
		    						    <label for="unit_measure"> Unit of Measure</label>
		    						    <input type="text" class="form-control" id="unit_measure" placeholder="Unit of Measure" name="unit_measure" value="<?php echo $editRow['unitofmeasure']; ?>">
	    						    </div>
	    						</div>
	    						<div class="form-group">
	    							<div class="col-md-3">
		    						    <label for="onhand_per_count"> On-hand per Count Qty</label>
		    						    <input type="number" class="form-control" id="onhand_per_count" placeholder="On-hand per Count Qty" name="onhand_per_count" value="<?php echo $editRow['onhand_per_count']; ?>">
	    						    </div>
	    						</div>
	    						<div class="form-group">
	    							<div class="col-md-3">
		    						    <label for="shortage_overage_qty"> Shortage/Overage Qty</label>
		    						    <input type="text" class="form-control" id="shortage_overage_qty" placeholder="Shortage/Overage Qty" name="shortage_overage_qty" value="<?php echo $editRow['so_qty']; ?>">
	    						    </div>
	    						</div>
	    						<div class="form-group">
	    							<div class="col-md-3">
		    						    <label for="shortage_overage_value"> Shortage/Overage Value</label>
		    						    <input type="text" class="form-control" id="shortage_overage_value" placeholder="Shortage/Overage Value" name="shortage_overage_value" value="<?php echo $editRow['so_value']; ?>">
	    						    </div>
	    						</div>
	    						<div class="form-group">
	    						    <div class="col-md-3">
	    						        <label for="accountable_person"> Accountable Employee</label>
	    						        <input list="accountable_options" class="form-control" id="accountable_person" placeholder="LAST NAME, First Name MI." name="accountable_person" autocomplete="off" value="<?php echo $editRow['accountable_person'] ?>">
	    						        <datalist id="accountable_options">
	    						            <?php
	    						            $accountable_query = $connect->query("SELECT * FROM employees");
	    						            while ($accountable_row = $accountable_query->fetch_assoc()) {
	    						                $selected = ($accountable_row['accountable_person'] === $editRow['accountable_person']) ? 'selected' : '';
	    						                echo '<option value="' . $accountable_row['employeeName'] . '" ' . $selected . '>' . $accountable_row['employeeName'] . '</option>';
	    						            }
	    						            ?>
	    						        </datalist>
	    						    </div>
    						    </div>
	    						<div class="form-group">
	    							<div class="col-md-3">
		    						    <label for="previous_condition"> Previous Condition</label>
		    						    <input type="text" class="form-control" id="previous_condition" placeholder="Previous Condition" name="previous_condition" value="<?php echo $editRow['previouscondition']; ?>">
	    						    </div>
	    						</div>
	    						<div class="form-group">
	    							<div class="col-md-3">
		    						    <label for="location"> Location</label>
		    						    <input type="text" class="form-control" id="location" placeholder="Location/Whereabouts" name="location" value="<?php echo $editRow['location']; ?>">
	    						    </div>
	    						</div>
	    						<div class="col-md-3"><!-- Current Condition -->
	    							<div class="form-group">
	    								<label for="current_condition"> Current Condition</label>
	    						        <input list="current_condition_options" class="form-control" id="current_condition_input" placeholder="Enter or select Current Condition" name="current_condition_input" value="<?php echo $editRow['curCondition']; ?>">
	    						        <datalist id="current_condition_options">
	    						            <?php
						                        $conditions_query = $connect->query("SELECT condition_id, condition_name FROM conditions");
						                        while ($condition_row = $conditions_query->fetch_assoc()) {
						                            $selected = ($condition_row['condition_name'] === $editRow['condition_name']) ? 'selected' : '';
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
		    						    <input type="text" name="date_of_physical_inventory" id="date_of_physical_inventory" class="form-control" placeholder="Date of Physical Inventory" value="<?php echo $editRow['date_of_physical_inventory']; ?>">
	    						    </div>
	    						</div>
	    						<div class="form-group">
	    							<div class="col-md-3">
		    						    <label for="remarks"> Remarks</label>
		    						    <input type="text" class="form-control" id="remarks" placeholder="Remarks"name="remarks" value="<?php echo $editRow['remarks']; ?>">
	    						    </div>
	    						</div>

	    						<div class="form-group">
	    							<div class="col-md-3">
		    						    <label for="scanned_docs">Scanned Supporting Documents</label>
		    						    <input type="file" class="form-control" id="scanned_docs" name="scanned_docs" accept=".pdf">
	    						    </div>
								</div>
								<div class="form-group">
								    <div class="col-md-3">
								        <label for="saved_scanned_file">Saved Scanned Document</label>
								        <input type="text" class="form-control" id="saved_scanned_file" name="saved_scanned_file" value="<?php echo $editRow['scannedDocs']; ?>" readonly>
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
				    						    <input type="text" name="supplier" class="form-control" placeholder="Supplier" id="supplier" value="<?php echo $editRow['supplier']; ?>">
			    						    </div>
			    						</div>
			    						<div class="form-group">
			    							<div class="col-md-2">
				    						    <label for="PO_no">PO No.</label>
				    						    <input type="text" name="PO_no" class="form-control" placeholder="PO No." id="PO_no" value="<?php echo $editRow['PO_no']; ?>">
			    						    </div>
			    						</div>
			    						<div class="form-group">
			    							<div class="col-md-2">
				    						    <label for="AIR_RIS_no">AIR/RIS No.</label>
				    						    <input type="text" name="AIR_RIS_no" class="form-control" placeholder="AIR/RIS No"id="AIR_RIS_no" value="<?php echo $editRow['AIR_RIS_no']; ?>">
			    						    </div>
			    						</div>
			    						<div class="form-group">
			    							<div class="col-md-3">
				    						    <label for="notes">Notes</label>
				    						    <input type="text" name="notes" class="form-control" placeholder="Notes" id="notes" value="<?php echo $editRow['notes']; ?>">
			    						    </div>
			    						</div>
			    						<div class="form-group">
			    							<div class="col-md-2">
				    						    <label for="jev">JEV Number</label>
				    						    <input type="text" name="jev" id="jev" class="form-control" placeholder="JEV Number" value="<?php echo $editRow['jevno']; ?>">
			    						    </div>
			    						</div>
	    							</div>
	    						</div>
	    						<br><br><br>
	    						<div class="col-md-2"><!-- Save Button Registry -->
	    							<div class="form-group">
	    								<button type="submit" class="btn btn-success" name="btn_allcategories_update" onClick="">UPDATE</button>
	    							</div>
	    						</div><!-- End of Save Button Registry -->
	    						<div class="col-md-2"><!-- Cancel Button Registry -->
	    							<div class="form-group">
	    								<a href="all_categories.php" class="btn btn-danger">Cancel</a>
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

    if (unitValue < 50000) {
        alert("Unit Value must be 50,000 or higher.");
        input.value = ''; // Clear the field
        input.focus(); // Set focus back to the field
    }
}
</script>
</body>
</html>


?>

