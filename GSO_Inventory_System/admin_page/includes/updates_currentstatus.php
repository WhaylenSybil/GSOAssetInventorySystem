<style>
	/* Initially, hide the additional information form */
	.addditional_inputs {
	    display: none;
	}
</style>
<div class="col-md-12"><!-- ADDITIONAL INFORMATION -->
	<div class="form-group">
		<h4><b>Updates/Current Status</b></h4>
	</div>
</div><!-- End ADDITIONAL INFORMATION -->
<div class="col-md-12">
	<div class="form-group">
		<select id="updates_currentstatus" onchange="showAdditionalInputs()" class="form-control">
			<option value="none">---Select Update/Current Status---</option>
			<option value="dropped_record"> Dropped in Both Records</option>
			<option value="existing_record">Existing in Inventory Report(For Further Monitoring)</option>
		</select>
		<!-- ============================================================= -->
		<!-- Form for dropped in both records -->
		<div  id="additional_inputs" class="form-group" style="display:none;">
			<form>
				<div class="col-md-3">
					<label for="JEV_no">JEV Number</label>
					<input type="text" name="JEV_no" id="JEV_no" placeholder="JEV Number" class="form-control" autocomplete="off">
				</div>
				<div class="col-md-3">
					<label for="date_dropped">Date</label>
					<input type="date" name="date_dropped" id="date_dropped" placeholder="Date" class="form-control" autocomplete="off">
				</div>
			</form>	
		</div><!-- End of Form for dropped in both records -->
	</div>
</div>
<!-- Script for the function to show the selected additional information form -->
<script>
    // Function to show the selected additional information form
    function showAdditionalInputs() {
        var updates_currentstatus = document.getElementById('updates_currentstatus');
        var additional_inputs = document.getElementById('additional_inputs');

        if (updates_currentstatus.value === 'dropped_record') {
        	additional_inputs.style.display = 'block';
        }else{
        	additional_inputs.style.display = 'none';
        }
    }
</script>
<!-- END of Script for function to show the selected additional information form-->