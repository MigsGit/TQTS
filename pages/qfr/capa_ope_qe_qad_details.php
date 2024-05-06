<?php
error_reporting(E_ALL);
ini_set('display_errors', 1);
$libraries = '../../libraries/includes_direct_page.php';
if(!file_exists($libraries)){
	echo 'NO LIB';
}else{
	require_once($libraries);
}

?>
<div class="panel panel-info">
	<div class="panel-heading"><i class="fa fa-puzzle-piece fa-lg"> CAPA (Corrective and Preventive Action) IMPLEMENTATION MONITORING & VALIDATION REPORT</i></div>
	<div class="panel-body">
		<form id="frm_capa_compliance_due_date">
			<div class="row" style="margin-top:5px;">
				<div class="col-sm-2">
					<label class="fa fa-md">Section: </label>
				</div>
				<div class="col-sm-4">
					<select class="form-control" id="section" name="section">
					</select>
				</div>
				<div class="col-sm-2">
					<label class="fa fa-md">Control No.: </label>
				</div>
				<div class="col-sm-4">
					<input type="text" class="form-control" id="control_no" name="control_no" readonly>
				</div>
			</div>
			<div class="row" style="margin-top:5px;">
				<div class="col-sm-2">
					<label class="fa fa-md">Reference Subsystem: </label>
				</div>
				<div class="col-sm-4">
					<select class="form-control" id="fklink_subsystem" name="fklink_subsystem">
						<option> -</option>
						<option value="tbl_qfr_8d"> 8D Module</option>
					</select>
				</div>
				<div class="col-sm-2">
					<label class="fa fa-md">Reference PO: </label>
				</div>
				<div class="col-sm-4">
					<datalist id="list_reference_po"></datalist>
					<input type="text" class="form-control" id="fklink_id" name="fklink_id" list="list_reference_po" autocomplete="off">
				</div>
				<div class="col-sm-2">
					<label class="fa fa-md">Product/Mode: </label>
				</div>
				<div class="col-sm-4">
					<input type="text" class="form-control" id="product_mode" name="product_mode">
				</div>
				<div class="col-sm-2">
					<label class="fa fa-md">Received Date: </label>
				</div>
				<div class="col-sm-4">
					<input type="date" class="form-control" id="received_date" name="received_date">
				</div>
				<div class="col-sm-2">
					<label class="fa fa-md">Failure Mode: </label>
				</div>
				<div class="col-sm-4">
					<input type="text" class="form-control" id="failure_mode" name="failure_mode">
				</div>
				<div class="col-sm-2">
					<label class="fa fa-md">Customer: </label>
				</div>
				<div class="col-sm-4">
					<input type="text" class="form-control" id="customer" name="customer">
				</div>
				<div class="col-sm-2">
					<label class="fa fa-md">Assigned Line JS/SS: </label>
				</div>
				<div class="col-sm-4">
					<select class="chosen-select" id="assigned_line" name="assigned_line" style="width:100%">
					</select>
				</div>
				<div class="col-sm-2">
					<label class="fa fa-md">CAPA Received: </label>
				</div>
				<div class="col-sm-4">
					<input type="date" class="form-control" id="capa_received" name="capa_received">
				</div>
				<div class="col-sm-2">
					<label class="fa fa-md">Checked by: </label>
				</div>
				<div class="col-sm-4">
					<select class="chosen-select" id="checked_by" name="checked_by" style="width:100%">
					</select>
				</div>
				<div class="col-sm-2">
					<label class="fa fa-md">Conformed by: </label>
				</div>
				<div class="col-sm-4">
					<select class="chosen-select" id="conformed_by" multiple name="conformed_by" style="width:100%">
					</select>
				</div>
				<div class="col-sm-2">
					<label class="fa fa-md">Attachment: </label>
				</div>
				<div class="col-sm-4">
					<button type="button" class="btn btn-default fa fa-download" id="file_capa_attachment" name="file_capa_attachment"></button>
				</div>
			</div>
			<div class="row" style="padding-top:5px;">
				<div class="col-sm-12">
					<div class="alert alert-danger" style="display:none;" role="alert" id="container_capa_compliance_due_date_message">					
					</div>
				</div>		
				<div class="col-sm-12" style="padding-top:5px;">
					<button type="button" class="btn btn-primary pull-right fa fa-plus"> Add</button>
					<h5>Click the row to select monitoring then press "Add" button</h5>
					<table class="table table-bordered table-hover table-condensed table-striped" id="tbl_monitoring">
						<thead>
							<tr>
								<th style="width:4%"><center>Status</center></th>
								<th style="width:14%"><center>Correction</center></th>
								<th style="width:6%"><center>In-charge Person</center></th>
								<th style="width:5%"><center>Due Date</center></th>
								<th style="width:6%"><center>1st Monitoring</center></th>
								<th style="width:6%"><center>2nd Monitoring</center></th>
								<th style="width:6%"><center>3rd Monitoring</center></th>
								<th style="width:6%"><center>4th Monitoring</center></th>
								<th style="width:6%"><center>5th Monitoring</center></th>
								<th style="width:6%"><center>6th Monitoring</center></th>
								<th style="width:6%"><center>7th Monitoring</center></th>
								<th style="width:6%"><center>8th Monitoring</center></th>
								<th style="width:6%"><center>9th Monitoring</center></th>
								<th style="width:6%"><center>10th Monitoring</center></th>
								<th style="width:6%"><center>11th Monitoring</center></th>
								<th style="width:6%"><center>12th Monitoring</center></th>
							</tr>
						</thead>
						<tbody>
						</tbody>
					</table>
				</div>
			</div>
			<hr class="graph-orange" style="margin-top:0px;">
			<div class="profile-info-title h4" style="padding-bottom:5px;">
				<span class="fa fa-plus"></span> Signatories
			</div>
			<div class="row" style="margin-top:5px;">				
				<div class="col-sm-2">
					<label class="fa fa-md">Operations QE / QAD QE: </label>
				</div>
				<div class="col-sm-4">
					<select class="chosen-select" id="operations_qe" name="operations_qe" style="width:100%">
					</select>
				</div>
				<div class="col-sm-2">
					<label class="fa fa-md">QC/QAD Manager: </label>
				</div>
				<div class="col-sm-4">
					<select class="chosen-select" id="qc_qad_manager" name="qc_qad_manager" style="width:100%">
					</select>
				</div>		
			</div>
			<div class="row" style="margin-top:5px;">					
				<div class="col-sm-2">
					<label class="fa fa-md">QAD Auditor: </label>
				</div>
				<div class="col-sm-4">
					<select class="chosen-select" id="qad_auditor" name="qad_auditor" style="width:100%">
					</select>
				</div>
				<div class="col-sm-2">
					<label class="fa fa-md">Conformance: </label>
				</div>
				<div class="col-sm-4">
					<select class="chosen-select" id="conformance" name="conformance" style="width:100%">
					</select>
				</div>
			 </div>
		  </div>
		  <div class="modal-footer">
			<button type="submit" class="btn btn-primary fa fa-send-o"> Submit</button>
			<button type="button" class="btn btn-default fa fa-close" data-dismiss="modal"> Close</button>
		  </div>
		</form>
	</div>
</div>


<script src="../../js/qfr/capa_iframe.js" type="text/javascript"></script>
<script>
	/* Onload functions */
	fn_get_capa_main_details(frm_1st_monitoring, <?php echo $_GET['pkid']; ?>);
	// fn_get_capa_main_details('frm_capa_compliance_due_date', <?php echo $_GET['pkid']; ?>);
</script>
