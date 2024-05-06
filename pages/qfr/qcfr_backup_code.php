<div class="modal" tabindex="-1" role="dialog" id="modal_qcfr">
  <div class="modal-dialog modal-lg" role="document" style="width:80%;">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
        <h4 class="modal-title fa fa-plus">Add Quality Complaint Feedback Report (QCFR)</h4>
      </div>
	  <form id="frm_qcfr_advance_search">
      <div class="modal-body">
		<div class="row">
			<div class="col-sm-6">
				<div class="row">
					<div class="col-sm-6">
						<div class="funkyradio">
							<div class="funkyradio-primary">
								<input type="checkbox" name="supplier_subcon" id="chk_supplier_subcon" value="1">
								<label for="chk_supplier_subcon"> Supplier/Subcon</label>
							</div>
						</div>
					</div>
					<div class="col-sm-6">
						<div class="funkyradio">
							<div class="funkyradio-primary">
								<input type="checkbox" name="assy" id="chk_assy" value="1">
								<label for="chk_assy"> PMI Assy</label>
							</div>
						</div>
					</div>
				</div>
				<div class="row">
					<div class="col-sm-4">
						<label class="control-label condensed">TO:</label>
					</div>
					<div class="col-sm-8">
						<input type="text" class="form-control condensed" name="">
					</div>
				</div>
				<div class="row">
					<div class="col-sm-4">
						<label class="control-label condensed">ATTN:</label>
					</div>
					<div class="col-sm-8">
						<input type="text" class="form-control condensed" name="">
					</div>
				</div>
				<div class="row">
					<div class="col-sm-4">
						<label class="control-label condensed">CC:</label>
					</div>
					<div class="col-sm-8">
						<input type="text" class="form-control condensed" name="">
					</div>
				</div>
				<div class="row">
					<div class="col-sm-4">
						<label class="control-label condensed">FROM:</label>
					</div>
					<div class="col-sm-8">
						<input type="text" class="form-control condensed" name="">
					</div>
				</div>
				<div class="row">
					<div class="col-sm-4">
						<label class="control-label condensed">DATE ISSUED:</label>
					</div>
					<div class="col-sm-8">
						<input type="text" class="form-control condensed" name="">
					</div>
				</div>
			</div>
			<div class="col-sm-6">
				<div class="row">
					<div class="col-sm-3">
						<label class="control-label condensed">QCFR No.:</label>
					</div>
					<div class="col-sm-9">
						<input type="text" class="form-control condensed" name="">
					</div>
				</div>
				<div class="row">
					<div class="col-sm-3" style="padding-right:0px;">
						<label class="control-label condensed"><b>Found During</b></label>
					</div>
					<div class="col-sm-9" style="">
						<div class="funkyradio">
							<div class="funkyradio-primary" >
								<input type="checkbox" name="fd_outgoing_inspection" id="chk_fd_outgoing_inspection" value="1">
								<label for="chk_fd_outgoing_inspection"> Outgoing Inspection</label>
							</div>
							<div class="funkyradio-primary">
								<input type="checkbox" name="fd_incoming_inspection" id="chk_fd_incoming_inspection" value="1">
								<label for="chk_fd_incoming_inspection"> Incoming Inspection</label>
							</div>
							<div class="funkyradio-primary">
								<input type="checkbox" name="fd_in_process_inspection" id="chk_fd_in_process_inspection" value="1">
								<label for="chk_fd_in_process_inspection"> In-Process Inspection</label>
							</div>
							<div class="funkyradio-primary">
								<input type="checkbox" name="fd_quality_system_check" id="chk_fd_quality_system_check" value="1">
								<label for="chk_fd_quality_system_check"> Quality System Check</label>
							</div>
							<div class="funkyradio-primary">
								<input type="checkbox" name="fd_others" id="chk_fd_others" value="1">
								<label for="chk_fd_others"> Others. Please Specify</label>
							</div>
						</div>
						<input type="text" class="form-control condensed" name="" placeholder="Others. Please Specify" disabled>
					</div>
				</div>
			</div>
		</div>
		<hr class="graph-orange">
		<div class="row">
			<div class="col-sm-4">
				<label class="control-label condensed"> Reported by:
			</div>
			<div class="col-sm-4">
				<label class="control-label condensed"> Verified & Conformed by:
			</div>
			<div class="col-sm-4">
				<label class="control-label condensed">  Approved by:
			</div>
		</div>
		<div class="row">
			<div class="col-sm-3">
				<input type="text" class="form-control condensed" name="">
			</div>
			<div class="col-sm-1" style="padding-left:0px;">
				LQC
			</div>
			<div class="col-sm-3">
				<input type="text" class="form-control condensed" name="">
			</div>
			<div class="col-sm-1" style="padding-left:0px;">
				LQC
			</div>
			<div class="col-sm-3">
				<input type="text" class="form-control condensed" name="">
			</div>
			<div class="col-sm-1" style="padding-left:0px;">
				TS LQC Head
			</div>
		</div>
		<div class="row">
			<div class="col-sm-3 col-sm-offset-4">
				<input type="text" class="form-control condensed" name="">
			</div>
			<div class="col-sm-1" style="padding-left:0px;">
				Engineering
			</div>
			<div class="col-sm-3">
				<input type="text" class="form-control condensed" name="">
			</div>
			<div class="col-sm-1" style="padding-left:0px;">
				Vice President
			</div>
		</div>
		<div class="row">
			<div class="col-sm-3 col-sm-offset-4">
				<input type="text" class="form-control condensed" name="">
			</div>
			<div class="col-sm-1" style="padding-left:0px;">
				Production
			</div>
		</div>
		<hr class="graph-blue">
		<div class="row">
			<div class="col-sm-4">
				<div class="row">
					<div class="col-sm-4">
						<label class="control-label condensed"> Product Name</label>
					</div>
					<div class="col-sm-8">
						<input type="text" class="form-control condensed" name="">
					</div>
				</div>
				<div class="row">
					<div class="col-sm-4">
						<label class="control-label condensed"> Model No.</label>
					</div>
					<div class="col-sm-8">
						<input type="text" class="form-control condensed" name="">
					</div>
				</div>
				<div class="row">
					<div class="col-sm-4">
						<label class="control-label condensed"> Batch No./Lot No.</label>
					</div>
					<div class="col-sm-8">
						<input type="text" class="form-control condensed" name="">
					</div>
				</div>
				<div class="row">
					<div class="col-sm-4">
						<label class="control-label condensed"> P.O. No./ INV. No.</label>
					</div>
					<div class="col-sm-8">
						<input type="text" class="form-control condensed" name="">
					</div>
				</div>
				<div class="row">
					<div class="col-sm-4">
						<label class="control-label condensed"> Date Received</label>
					</div>
					<div class="col-sm-8">
						<input type="text" class="form-control condensed" name="">
					</div>
				</div>
			</div>
			<div class="col-sm-8">
				<div class="col-sm-4">
						<label class="control-label condensed"> Inspection Method</label>
				</div>
				<div class="col-sm-5">
					<input type="text" class="form-control condensed" name="">
				</div>
				<div class="col-sm-3">
					<div class="funkyradio">
						<div class="funkyradio-primary">
							<input type="checkbox" name="hundred_percent" id="chk_hundred_percent" value="1">
							<label for="chk_hundred_percent"> 100%</label>
						</div>
					</div>
				</div>
				<div class="col-sm-4">
						<label class="control-label condensed"> Sampling Plan</label>
				</div>
				<div class="col-sm-5">
					<input type="text" class="form-control condensed" name="">
				</div>
				<div class="col-sm-3">
					<div class="funkyradio">
						<div class="funkyradio-primary">
							<input type="checkbox" name="hundred_percent" id="chk_hundred_percent" value="1">
							<label for="chk_hundred_percent"> 100%</label>
						</div>
					</div>
				</div>
			</div>
		</div>
		<hr class="graph-orange">
      </div>
	  
	  
      <div class="modal-footer">
        <button type="submit" class="btn btn-primary fa fa-save"> Save</button>
        <button type="button" class="btn btn-default fa fa-close" data-dismiss="modal"> Close</button>
      </div>
	  </form>
    </div><!-- /.modal-content -->
  </div><!-- /.modal-dialog -->
</div><!-- /.modal -->