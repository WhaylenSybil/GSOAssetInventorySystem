<?php
require('./../database/connection.php');
require('../login/login_session.php');
include ('../admin_page/includes/save_add_ICS_registry.php');
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
<body class="hold-transition skin-blue-light sidebar-mini fixed">
	<div class="wrapper">
		<?php include("../admin_page/header/header.php");
		include("../admin_page/header/sidebar.php");?>
		<div class="content-wrapper">
			<section class="content-header">
				<h1>ICS REGISTRY</h1>
				<ol class="breadcrumb">
					<li><a href="dashboard.html"><i class="fa fa-dashboard"></i>Registry</a></li>
					<li class="active">Add ICS Registry</li>
				</ol>
			</section>

		<!-- Main Content -->
		<section class="content container-fluid">
			<div class="box">
				<div class="box-header bg-blue" align="center">
					<h4 class="box-title">Registry of ICS-Issued</h4>
				</div><br>
				<div class="row">
					<form action="save_add_ICS_registry.php" id="ICS_issued_form"></form>
					<!-- <div class="form-group">
						<div class="col-md-1">
							<input type="file" id="myAreFiles" name="filename">
						</div>
					</div> --><br>
					<div class="col-md-12">
						<form method="post" action="" enctype="multipart/form-data">
							<div class="col-md-2"><!-- Date Returned -->
								<div class="form-group">
									<label for="date_returned"> Date Returned</label>
									<input type="date" class="form-control" id="date_returned" placeholder="Date Returned" name="date_returned" autocomplete="off" required max="<?php echo date('Y-m-d'); ?>" value="<?php echo date('Y-m-d'); ?>">
								</div>
							</div><!-- End Date Returned -->

							<div class="col-md-4"><!-- Responsibility Center -->
							    <div class="form-group">
							        <label for="rescenter"> Responsibility Center (Offices and Departments)</label>
							        <input list="rescenter_options" class="form-control" id="rescenter" placeholder="Responsibility Center" name="rescenter" autocomplete="off" onchange="fetchEmployeesByCenter()">
							        <datalist id="rescenter_options">
							            <?php
							            $query1 = $connect->query("SELECT co.office_id, co.office_name AS office_name, co.ocode_number FROM city_offices co UNION ALL SELECT no.noffice_id, no.noffice_name AS office_name, no.ncode_number FROM national_offices no ORDER BY office_name");
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

							<div class="col-md-3"><!-- Acquisition Date -->
								<div class="form-group">
									<label for="acquisition_cost"> Acquisition Date</label>
									<input type="date" class="form-control" id="acquisition_date" placeholder="Acquisition Date" name="acquisition_date" autocomplete="off">
								</div>
							</div><!-- End Acquisition Date -->

							<div class="col-md-3"><!--PRS/WMR Number -->
								<div class="form-group">
									<label for="PRS_WMR_no"> PRS/WMR Number</label>
									<input type="text" class="form-control" id="PRS_WMR_no" placeholder="PRS/WMR Number" name="PRS_WMR_no" autocomplete="off">
								</div>
							</div><!-- End PRS/WMR Number -->

							<div class="col-md-3"><!-- Unit Value -->
								<div class="form-group">
									<label for="unit_value"> Unit Value</label>
									<input type="text" class="form-control" id="unit_value" placeholder="Unit Value" name="unit_value" autocomplete="off"onblur="validateUnitValue(this)">
								</div>
							</div><!-- End Unit Value -->

							<div class="col-md-3"><!-- Balance per card qty -->
								<div class="form-group">
									<label for="balance_per_card"> Balance per Card Qty</label>
									<input type="number" class="form-control" id="balance_per_card" placeholder="Balance per card Qty" name="balance_per_card" autocomplete="off">
								</div>
							</div><!-- End Balance Per Card Qty -->

							<div class="col-md-3"><!-- Acquisition Cost -->
								<div class="form-group">
									<label for="acquisition_cost"> Acquisition Cost</label>
									<input type="text" class="form-control" id="acquisition_cost" placeholder="Acquisition Cost" name="acquisition_cost" autocomplete="off">
								</div>
							</div><!-- End Acquisition Cost -->

							<div class="col-md-3"><!-- Article -->
								<div class="form-group">
									<label for="article"> Article</label>
									<input type="text" class="form-control" id="article" placeholder="Article" name="article" autocomplete="off" style="text-transform: uppercase;">
								</div>
							</div><!-- End Article -->
							<div class="col-md-4"><!-- Brand/Model -->
								<div class="form-group">
									<label for="brand"> Brand/Model</label>
									<textarea type="text" class="form-control" id="brand" placeholder="Brand/Model" name="brand" autocomplete="off" style="text-transform: uppercase;"></textarea>
								</div>
							</div><!-- End Brand/Model -->
							<div class="col-md-4"><!-- Serial Number -->
								<div class="form-group">
									<label for="serialno"> Serial Number</label>
									<textarea type="text" class="form-control" id="serial_no" placeholder="Serial Number" name="serial_no" autocomplete="off"></textarea>
								</div>
							</div><!-- End Serial Number -->
							<div class="col-md-4"><!-- Particulars -->
								<div class="form-group">
									<label for="particulars"> Particulars</label>
									<textarea type="text" class="form-control" id="particulars" placeholder="Particulars" name="particulars" autocomplete="off"></textarea>
								</div><!-- End Particulars -->
							</div>
							
							<div class="col-md-3"><!-- enGAS Property Number  -->
								<div class="form-group">
									<label for="engas"> eNGAS Property Number</label>
									<input type="text" class="form-control" id="engas" placeholder="enGAS Property Number" name="engas" autocomplete="off">
								</div>
							</div><!-- End eNGAS Property Number   -->
							
							<div class="col-md-3"><!-- Property Number -->
								<div class="form-group">
									<label for="property_no"> Property Number</label>
									<input type="text" class="form-control" id="property_no" placeholder="Property Number" name="property_no" autocomplete="off">
								</div>
							</div><!-- End Property Number -->

							<div class="col-md-3"><!-- Classification -->
							    <div class="form-group">
							        <label for="accountnumber"> Classification</label>
							        <input list="classification_options" class="form-control" id="accountnumber" placeholder="Classification" name="accountnumber">
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
							        <label for="est_life"> Estimated Useful Life</label>
							        <input list="est_life_options" class="form-control" id="est_life" placeholder="Estimated Useful Life" name="est_life" style="width:100%;">
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
									<label for="unit_measure"> Unit of Measure</label>
									<input type="text" class="form-control" id="unit_measure" placeholder="Unit of Measure" name="unit_measure" autocomplete="off">
								</div>
							</div><!-- End Unit of Measure -->
							
							<div class="col-md-3"><!-- On hand per count qty -->
								<div class="form-group">
									<label for="onhand_per_count"> On-hand per Count Qty</label>
									<input type="number" class="form-control" id="onhand_per_count" placeholder="On-hand per Count Qty" name="onhand_per_count" autocomplete="off">
								</div>
							</div><!-- End On hand per count qty-->
							<div class="col-md-3"><!-- Shortage/Overage qty -->
								<div class="form-group">
									<label for="shortage_overage_qty"> Shortage/Overage Qty</label>
									<input type="text" class="form-control" id="shortage_overage_qty" placeholder="Shortage/Overage Qty" name="shortage_overage_qty" autocomplete="off">
								</div>
							</div><!-- End Shortage/Overage qty -->
							<div class="col-md-3"><!-- Shortage/Overage value -->
								<div class="form-group">
									<label for="shortage_overage_value"> Shortage/Overage Value</label>
									<input type="text" class="form-control" id="shortage_overage_value" placeholder="Shortage/Overage Value" name="shortage_overage_value" autocomplete="off">
								</div>
							</div><!-- End Shortage/Overage value -->
							<div class="col-md-3"><!-- Accountable Person  -->
							    <div class="form-group">
							        <label for="accountable_person"> Accountable Employee</label>
							        <input list="accountable_options" class="form-control" id="accountable_person" placeholder="LAST NAME, First Name MI." name="accountable_person" autocomplete="off">
							        <datalist id="accountable_options">
							        	<!-- this will be populated using the script and AJAX -->
							        </datalist>
							    </div>
							</div><!-- End Accountable Person -->
							<div class="col-md-3"><!-- Previous Condition -->
								<div class="form-group">
									<label for="previous_condition"> Previous Condition</label>
									<input type="text" class="form-control" id="previous_condition" placeholder="Previous Condition" autocomplete="off"  name="previous_condition">
								</div>
							</div><!-- End Previous Condition -->
							<div class="col-md-3"><!-- Location/Whereabouts -->
								<div class="form-group">
									<label for="location"> Location</label>
									<input type="text" class="form-control" id="location" placeholder="Location/Whereabouts" autocomplete="off"  name="location">
								</div>
							</div><!-- End Location/Whereabouts -->

							<div class="col-md-3"><!-- Current Condition -->
								<div class="form-group">
									<label for="current_condition"> Current Condition</label>
							        <input list="current_condition_options" class="form-control" id="current_condition_input" placeholder="Enter or select Current Condition" name="current_condition_input" autocomplete="off">
							        <datalist id="current_condition_options">
							            <?php
							            // Query the database to fetch condition data from conditions table
							            $conditions_query = $connect->query("SELECT condition_id, condition_name FROM conditions");
							            
							            while ($conditions_row = $conditions_query->fetch_assoc()) {
							                echo '<option value="' . $conditions_row['condition_name'] . '">' . $conditions_row['condition_name'] . '</option>';
							            }
							            ?>
							            <option value="Other"></option>
							        </datalist>
								</div>
							</div><!-- End Current Condition -->
							<div class="col-md-3"><!-- Current Condition Input -->
							    <div class="form-group">
							    	<label for="other_condition"> Other Condition</label>
							        <input type="text" class="form-control" id="other_condition_input" placeholder="Enter Other Condition" name="other_condition_input" autocomplete="off" disabled>
							    </div>
							</div><!-- End Current Condition Input -->

							<div class="col-md-3"><!-- Date of Physical Inventory -->
								<div class="form-group">
									<label for="date_of_physical_inventory">Date of Physical Inventory</label>
									<input type="text" name="date_of_physical_inventory" id="date_of_physical_inventory" class="form-control" placeholder="Date of Physical Inventory" autocomplete="off">
								</div>
							</div>
							<div class="col-md-3"><!-- Remarks -->
								<div class="form-group">
									<label for="remarks"> Remarks</label>
									<textarea type="text" class="form-control" id="remarks" placeholder="Remarks" autocomplete="off"  name="remarks"></textarea>
								</div>
							</div><!-- End Remarks -->
							<div class="col-md-3"><!-- Scanned Documents -->
						        <div class="form-group">
						            <label for="scanned_docs">Scanned Supporting Documents</label>
						            <input type="file" class="form-control" id="scanned_ics" name="scanned_ics" accept=".pdf">
						        </div>
						    </div><!-- End Scanned Documents -->
							<br><!-- Additional Details for Reconciliation Purposes -->
							<div class="col-md-12"><!-- ADDITIONAL INFORMATION Title-->
								<div class="form-group">
									<h4 class="box-title" align="center"><b>Additional Details for Reconciliation Purposes</b></h4>
								</div>
							</div><!-- End ADDITIONAL INFORMATION -->
							<div class="col-md-3"><!-- Supplier -->
								<div class="form-group">
									<label for="supplier">Supplier</label>
									<input type="text" name="supplier" class="form-control" placeholder="Supplier" id="supplier" autocomplete="off">
								</div>
							</div><!-- End of Supplier -->
							<div class="col-md-2"><!-- PO No. -->
								<div class="form-group">
									<label for="PO_no">PO No.</label>
									<input type="text" name="PO_no" class="form-control" placeholder="PO No." autocomplete="off"  id="PO_no">
								</div>
							</div><!-- End of PO No. -->
							<div class="col-md-2"><!-- AIR/RIS No -->
								<div class="form-group">
									<label for="AIR_RIS_no">AIR/RIS No.</label>
									<input type="text" name="AIR_RIS_no" class="form-control" placeholder="AIR/RIS No" autocomplete="off" id="AIR_RIS_no">
								</div>
							</div><!-- End of AIR/RIS No. -->
							<div class="col-md-3"><!-- Notes -->
								<div class="form-group">
									<label for="notes">Notes</label>
									<input type="text" name="notes" class="form-control" placeholder="Notes" id="notes" autocomplete="off"><!-- </textarea> -->
								</div>
							</div><!-- End of Notes -->
							<div class="col-md-2"><!-- JEV No -->
								<div class="form-group">
									<label for="jev">JEV Number</label>
									<input type="text" name="jev" id="jev" class="form-control" placeholder="JEV Number" autocomplete="off">
								</div>
							</div><!-- End of JEV No. -->
							<!-- End of Additional Details for Reconciliation Purposes -->
							<br><br><br>
							<div class="col-md-2"><!-- Save Button Registry -->
								<div class="form-group">
									<button type="submit" class="btn btn-success" name="btn_ICS_save" onClick="">Add ICS Registry</button>
								</div>
							</div><!-- End of Save Button Registry -->
							<div class="col-md-2"><!-- Cancel Button Registry -->
								<div class="form-group">
									<a href="dashboard.php" class="btn btn-danger">Cancel</a>
								</div>
							</div><!-- End of Cancel Button Registry -->
						</form>

						
					</div>
					
				</div>
			
			</div><!-- Div box -->
		</section>
		</div>
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
<script src="./js/notification.js"></script>

<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
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
<!-- FORMULA FOR ACQUISITION DATE -->
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

    if (unitValue > 50000) {
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
        modalContent.innerHTML = "Please add '" + input + "' to the Data List > Add Employee first along with its associated office/department, TIN Number, and employee Number.";

        // Create the OK button
        var okButton = document.createElement("button");
        okButton.className = "ok-button";
        okButton.innerHTML = "OK";

        // Append the modal content and the OK button to the modal background
        modalBackground.appendChild(modalContent);
        modalContent.appendChild(okButton);

        // Show the modal
        modalBackground.style.display = "block";

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
</body>
</html>