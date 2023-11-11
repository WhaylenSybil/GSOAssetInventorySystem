<style>
	/* Initially, hide the additional information form */
	#additional-info {
	    display: none;
	}
</style>
<div class="col-md-12"><!-- ADDITIONAL INFORMATION -->
	<div class="form-group">
		<h4 class="box-title" align="center"><b>Additional Details for Reconciliation Purposes</b></h4>
	</div>
</div><!-- End ADDITIONAL INFORMATION -->
<div class="col-md-12">
	<div class="form-group">
		<select id="modeofdisposal_options" onchange="showSelectedForm(1)" class="form-control">
			<option value="none">---Select a mode of disposal---</option>
			<option value="destroyed"> By Destruction or Condemnation</option>
			<option value="soldthrunegotiation">Sold through Negotiation</option>
			<option value="soldthruauction">Sold through Public Auction</option>
			<option value="transferred">Transferred without Cost to Other Offices/Departments, and to Other Agencies</option>
			<option value="continuedinservice">Continued in Service</option>
		</select>
		<!-- ============================================================= -->
		<!-- Form for Destroyed and Thrown -->
		<div  id="form-destroyed" class="additional-info">
			<form>
				<div class="col-md-3">
					<label for="supplier">Supplier</label>
					<input type="text" name="supplier" id="supplier" placeholder="Supplier" class="form-control" autocomplete="off">
				</div>
				<div class="col-md-3">
					<label for="PO_no">PO No.</label>
					<input type="text" name="PO_no" id="PO_no" placeholder="PO No." class="form-control" autocomplete="off">
				</div>
				<div class="col-md-3">
					<label for="AIR_RIS_no">AIR/RIS No</label>
					<input type="text" name="AIR_RIS_no" id="AIR_RIS_no" placeholder="AIR/RIS No." class="form-control" autocomplete="off">
				</div>
				<div class="col-md-3">
					<label for="JEV">JEV Number</label>
					<input type="text" name="JEV" id="JEV" placeholder="JEV Number" class="form-control" autocomplete="off">
				</div>
				<div class="col-md-3">
					<label for="part_destroyed_thrown">Parts Destroyed or Thrown</label>
					<textarea type="text" name="part_destroyed_thrown" id="part_destroyed_thrown" placeholder="Part Destroyed or Thrown" class="form-control" autocomplete="off"></textarea>
				</div>
				<div class="col-md-3">
					<label for="notes">Notes</label>
					<textarea type="text" name="notes" id="notes" class="form-control" autocomplete="off"></textarea>
				</div>
			</form>	
		</div><!-- End of Form for Destroyed and Thrown -->
		<!-- ============================================================================================== -->
		<!-- Form for Sold Through Negotiation -->
		<div id="form-soldthrunegotiation" class="additional-info">
			<form>
				<div class="col-md-3">
					<div class="form-group">
						<label for="date_of_sale">Date of Sale</label>
						<input type="date" name="date_of_sale" id="date_of_sale" placeholder="Date of Sale" class="form-control" autocomplete="off">
					</div>
				</div>
				<div class="col-md-3">
					<label for="date_of_OR">Date of OR</label>
					<input class="form-control" type="date" name="date_of_OR" id="date_of_OR" placeholder="Date of OR" autocomplete="off">
				</div>
				<div class="col-md-3">
					<label for="OR_no">OR Number</label>
					<input class="form-control" type="text" name="OR_no" id="OR_no" placeholder="OR Number" autocomplete="off">
				</div>
				<div class="col-md-3">
					<label for="amount">Amount</label>
					<input class="form-control" type="text" name="amount" id="amount" placeholder="Amount" autocomplete="off">
				</div>
				<div class="col-md-3">
					<label for="notes">Notes</label>
					<textarea type="text" name="notes" id="notes" class="form-control" autocomplete="off"></textarea>
				</div>
			</form>
		</div><!-- End of Form for Sold Through Negotiation -->
		<!-- ============================================================================================= -->
		<!-- Form for Sold Through Auction -->
		<div id="form-soldthruauction" class="additional-info">
			<form>
				<div class="col-md-3">
					<div class="form-group">
						<label for="date_of_auction">Date of Auction</label>
						<input type="date" name="date_of_auction" id="date_of_auction" placeholder="Date of Auction" class="form-control" autocomplete="off">
					</div>
				</div>
				<div class="col-md-3">
					<label for="date_of_OR">Date of OR</label>
					<input class="form-control" type="date" name="date_of_OR" id="date_of_OR" placeholder="Date of OR" autocomplete="off">
				</div>
				<div class="col-md-3">
					<label for="OR_no">OR Number</label>
					<input class="form-control" type="text" name="OR_no" id="OR_no" placeholder="OR Number" autocomplete="off">
				</div>
				<div class="col-md-3">
					<label for="amount">Amount</label>
					<input class="form-control" type="text" name="amount" id="amount" placeholder="Amount" autocomplete="off">
				</div>
				<div class="col-md-3">
					<label for="notes">Notes</label>
					<textarea type="text" name="notes" id="notes" class="form-control" autocomplete="off"></textarea>
				</div>
			</form>
		</div><!-- End of Form for Sold Through Negotiation -->
		<!-- ============================================================================================= -->
		<!-- Form for Transferred without cost -->
		<div id="form-transferred" class="additional-info">
			<form>
				<div class="col-md-3">
					<div class="form-group">
						<label for="date_of_transfer">Date of Transfer(Without Cost)</label>
						<input type="date" name="date_of_transfer" id="date_of_transfer" placeholder="Date of Transfer" class="form-control" autocomplete="off">
					</div>
				</div>
				<div class="col-md-6">
					<div class="form-group">
						<label for="recipient_tranferred">Recipient(Name of Agency/Institution)</label>
						<input type="text" name="recipient_tranferred" id="recipient_tranferred" placeholder="Recipient(Name of Agency/Institution)" class="form-control" autocomplete="off">
					</div>
				</div>
				<div class="col-md-3">
					<label for="notes">Notes</label>
					<textarea type="text" name="notes" id="notes" class="form-control" autocomplete="off"></textarea>
				</div>
			</form>
		</div><!-- End of Form for Transferred without cost -->
		<!-- ============================================================================================= -->
		<!-- Form for Constinued in Service -->
		<div id="form-continuedinservice" class="additional-info">
			<form>
				<div class="col-md-3">
					<div class="form-group">
						<label for="date_of_transfer_continued">Date of Transfer(Continued Service)</label>
						<input type="date" name="date_of_transfer_continued" id="date_of_transfer_continued" placeholder="Date of Transfer" class="form-control" autocomplete="off">
					</div>
				</div>
				<div class="col-md-6">
					<div class="form-group">
						<label for="recipient_continued">Recipient(Name of Agency/Institution)</label>
						<input type="text" name="recipient_continued" id="recipient_continued" placeholder="Recipient(Name of Agency/Institution)" class="form-control" autocomplete="off">
					</div>
				</div>
				<div class="col-md-3">
					<label for="notes">Notes</label>
					<textarea type="text" name="notes" id="notes" class="form-control" autocomplete="off"></textarea>
				</div>
			</form>
		</div><!-- End of Form for Transferred without cost -->
		<!-- ============================================================================================= -->
	</div>
</div>
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
        const selectedForm = document.getElementById('form-' + modeofdisposal_options.value);
        if (selectedForm) {
            selectedForm.style.display = 'block';
        }
    }
</script>
<!-- END of Script for function to show the selected additional information form-->