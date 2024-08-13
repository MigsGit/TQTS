<?php
/* Check if user is approver or a requestor NG Report */
$ng_report_approver	 			= false;
$ng_report_requestor 			= false;
$ng_report_disposition_admin 	= false;
foreach($user_role['subsystem_code'] as $key => $subsystem_code ){
	if($subsystem_code == "IQC" && $user_role['module'][$key] == "NG Report" && $user_role['role'][$key] == "APPROVER"){ 
		$ng_report_approver = true;
	} else if($subsystem_code == "IQC" && $user_role['module'][$key] == "NG Report" && $user_role['role'][$key] == "REQUESTOR"){
		$ng_report_requestor = true;
	} if($subsystem_code == "IQC" && $user_role['module'][$key] == "NG Report - Disposition Admin" && $user_role['read'][$key] == 1){
		$ng_report_disposition_admin = true;
	}
}

if((!$ng_report_approver) && (!$ng_report_requestor)){
	$ng_report_requestor = true;
}

?>
<div class="col-sm-12">
	<!-- Nav tabs -->
	<div class="">
		<ul class="nav nav-tabs" role="tablist">
			<?php 
				if($ng_report_requestor){
					echo '<li role="presentation" class="active"><a href="#pending" aria-controls="pending" role="tab" data-toggle="tab">Pending NG Reports</a></li>
						  <li role="presentation" class=""><a href="#ng_report" aria-controls="ng_report" role="tab" data-toggle="tab">NG Report</a></li>';
				}
				if($ng_report_approver){
					echo '<li role="presentation" class="active"><a href="#ng_report" aria-controls="ng_report" role="tab" data-toggle="tab">NG Report</a></li>';
				}
				if($ng_report_disposition_admin){
					echo '<li role="presentation" class=""><a href="#for_disposition" aria-controls="ng_report" role="tab" data-toggle="tab">For Disposition</a></li>';
				}				
			?>
			
		</ul>
	</div>
</div>

<!-- Tab panes -->
<div class="tab-content">
	<?php
		if($ng_report_requestor){
			$active_class = "active";
		}
		if($ng_report_approver){
			$active_class = "";
		}
	?>
	<div role="tabpanel" class="tab-pane <?php echo $active_class; ?>" id="pending">
		<div class="col-sm-12">
			<div class="panel panel-info">
				<div class="panel-heading"><i class="fa fa-file fa-lg"> For Filling NG Report</i></div>
				<div class="panel-body">
						<div class="row">
							<div class="col-sm-3-offset-9">
								<button class="btn btn-info fa pull-right" id="btn_reload_wbs_record"><i class="fa fa-refresh"></i> Reload WBS Record</button>
							</div>
						</div>
					<div class="row">
						<div class="col-sm-12"><br />
							<table class="table table-bordered table-condensed" id="tbl_ng_for_filling">
								<thead>
									<th>Inspection Date</th>
									<th>Inspection Time</th>
									<th>Sub</th>
									<th><center>Invoice #</center></th>
									<th><center>Part Code</center></th>
									<th><center>Part Name</center></th>
									<th><center>Lot Number</center></th>
									<th><center>Quantity</center></th>
									<th><center>Supplier</center></th>
									<th><center>Action</center></th>
								</thead>
							</table>
						</div>
					</div>
				</div>
			</div>
		</div>
	</div>
	<?php
		if($ng_report_requestor){
			$active_class = "";
		}
		if($ng_report_approver){
			$active_class = "active";
		}
	?>	
	<div role="tabpanel" class="tab-pane <?php echo $active_class; ?>" id="ng_report">
		<div class="col-sm-12">
			<div class="panel panel-info">
				<div class="panel-heading"><i class="fa fa-file fa-lg"> NG Report</i></div>
				<div class="panel-body">
					<div class="row">
						<div class="row">
							<div class="col-sm-9">
								<!--<button class="btn btn-default fa fa-search" id="btn_ng_advanced_search"> Search</button>-->
							</div>
							<div class="col-sm-3">
								<button class="btn btn-info fa pull-right" id="btn_report_ng"><i class="fa fa-files-o"></i> Report</button>
								<button class="btn btn-success fa pull-right" id="btn_upload_ng"><i class="fa fa-plus"></i> New</button>
							</div>
						</div>
						<div class="row">
							<div class="col-sm-12"><br />
								<table class="table table-bordered table-condensed" id="tbl_ng">
									<thead>
										<th><center>Status</center></th>
										<th><center>Invoice #</center></th>
										<th><center>Part Details</center></th>
										<th><center>Treatment</center></th>
										<th><center>Final Disposition</center></th>
										<th><center>NG Report</center></th>
										<th><center>Supplier</center></th>
										<th><center>Approvers</center></th>
										<th><center>Action</center></th>
									</thead>
								</table>
							</div>
						</div>
					</div>
				</div>
			</div>
		</div>
	</div>

	<div role="tabpanel" class="tab-pane <?php echo $active_class; ?>" id="for_disposition">	
		<div class="col-sm-12">
			<div class="panel panel-info">
				<div class="panel-heading"><i class="fa fa-file fa-lg"> NG Report for Disposition</i></div>
				<div class="panel-body">
					<div class="row">
						<div class="col-sm-12"><br />
							<table class="table table-bordered table-condensed" id="tbl_ng_for_disposition">
								<thead>
									<th><center>Status</center></th>
									<th><center>Invoice #</center></th>
									<th><center>Part Details</center></th>
									<th><center>NG Report</center></th>
									<th><center>Supplier</center></th>
									<th><center>Approvers</center></th>
									<th><center>Action</center></th>
								</thead>
							</table>
						</div>
					</div>
				</div>
			</div>
		</div>
	</div>
</div>


<!---------------------
	Modals - Start 
---------------------->
<div class="modal fade" tabindex="-1" role="dialog" id="modal_upload_ng">
  <div class="modal-dialog modal-lg" role="document">
    <div class="modal-content">
      <div class="modal-header">                    
        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
        <h4 class="modal-title"><i class="fa fa-upload"></i> Create New</h4>
      </div>
	  <form id="frm_upload_ng" method="post" enctype="multipart/form-data">
		  <div class="modal-body" style="overflow:inherit;">
			<div class="row">
				<div class="col-sm-12">
					<div class="alert alert-danger" style="display:none;" role="alert" id="container_upload_ng_message">					
					</div>
				</div>	
				<div class="col-sm-2">
					<label class="fa fa-md">Issuance Date: </label>
				</div>
				<div class="col-sm-4">
					<input type="date" class="form-control" id="issuance_date" name="issuance_date" required>
				</div>
				<div class="col-sm-2">
					<label class="fa fa-md">Failed Mode</label>
				</div>
				<div class="col-sm-4">
					<input type="input" class="form-control" id="fail_mode" name="fail_mode" required>
				</div>
				<div class="col-sm-2">
					<label class="fa fa-md">Supplier: </label>
				</div>
				<div class="col-sm-4">				
					<select class="" id="supplier" name="supplier" style="width:100%;" required>
					</select>
				</div>
				<div class="col-sm-2">
					<label class="fa fa-md">Invoice Number: </label>
				</div>
				<div class="col-sm-4">
					<input type="text" class="form-control" id="invoice_no" name="invoice_no" list="list_invoice_no">
					<datalist id="list_invoice_no"></datalist>
				</div>
				<div class="col-sm-2">
				  <label class="fa fa-md">Part Code: </label>
				</div>
				<div class="col-sm-4">
					<input type="text" class="form-control" id="part_code" name="part_code" style="text-transform:uppercase" list="list_part_code">
                    <datalist id="list_part_code"></datalist>
				</div>
				<div class="col-sm-2">
					<label class="fa fa-md">Part Name: </label>
				</div>
				<div class="col-sm-4">
					<input type="text" class="form-control" id="parts_affected_parts" name="parts_affected_parts" readonly >
				</div>
			</div>
			<div class="row">
				<div class="col-sm-2">
				  <label class="fa fa-md">PO #: </label>
				</div>
				<div class="col-sm-4">
					<input type="text" class="form-control" id="po_number" name="po_number" list="list_po_number">
                    <datalist id="list_po_number"></datalist>
				</div>
				<div class="col-sm-2">
					<label class="fa fa-md">Device Name: </label>
				</div>
				<div class="col-sm-4">
					<input type="text" class="form-control" id="device_name" name="device_name" readonly >
				</div>
			</div>
			<div class="row">
				<div class="col-sm-2">
					<label class="fa fa-md">Lot No: </label>
				</div>
				<div class="col-sm-4">
					<button type="button" name="add_lot_number" class="btn btn-primary fa fa-plus" style="width:100%; margin-bottom:2%"> Lot Number</button>
				</div>
				<div class="col-sm-2">
					<label class="fa fa-md">Choose File: </label>
				</div>
				<div class="col-sm-4">
					<input type="file" class="form-control" id="file_ng" name="file_ng[]" accept=".csv, application/vnd.openxmlformats-officedocument.spreadsheetml.sheet, application/vnd.ms-excel" multiple required>
				</div>
			</div>
			<div class="row">
				<div class="col-sm-2">
					<label class="fa fa-md">Drawing Number: </label>
				</div>
				<div class="col-sm-4">
					<input type="text" class="form-control" id="drawing_number" name="drawing_number" required>
				</div>
				<div class="col-sm-2">
					<label class="fa fa-md">Material Type: </label>
				</div>
				<div class="col-sm-4">
					<select class="form-control" id="material_type" name="material_type">
					</select>
				</div>
              </div>
              <div class="row">
				<div class="col-sm-2" style="padding-top:5px;">
					<label class="fa fa-md">Report Approvers: </label>
				</div>
				<div class="col-sm-10" style="padding-top:5px;">
					<select class="" id="cmb_approver_username" name="approvers[]" multiple="multiple" style="width:100%;" required>
					</select>
				</div>
              </div>
              <div class="row">
				<div class="col-sm-2" style="padding-top:5px;">
					<label class="fa fa-md">Remarks: </label>
				</div>
				<div class="col-sm-10" style="padding-top:5px;">
					<textarea class="form-control" id="remarks" name="remarks"></textarea>
				</div>
			</div>
		  </div>
		  <div class="modal-footer">
			<button type="submit" class="btn btn-primary fa fa-save"> Save</button>
			<button type="button" class="btn btn-default fa" data-dismiss="modal"> Close</button>
		  </div>
		</form><!-- /#frm_upload_measdata -->
    </div><!-- /.modal-content -->
  </div><!-- /.modal-dialog -->
</div><!-- /.modal -->

<div class="modal fade" tabindex="-1" role="dialog" id="modal_upload_ng_edit">
  <div class="modal-dialog modal-lg" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
        <h4 class="modal-title"><i class="fa fa-upload"></i> Edit / View NG Report</h4>
      </div>
	  <form id="frm_upload_ng_update" method="post" enctype="multipart/form-data">
		  <div class="modal-body" style="overflow:inherit;">
			<div class="row">
				<div class="col-sm-12">
					<div class="alert alert-danger" style="display:none;" role="alert" id="container_upload_ng_message_edit">					
					</div>
				</div>
			</div>
			<div class="row" style="margin-top:5px;">
				<div class="col-sm-12">
					<div class="alert alert-danger" style="display:none;" role="alert" id="container_upload_ng_message">					
					</div>
				</div>				
				<div class="col-sm-12">
					<label class="fa fa-md" id="lbl_ng_status"></label>
				</div>	
				<div class="col-sm-2">
					<label class="fa fa-md">Issuance Date: </label>
				</div>
				<div class="col-sm-4">
					<input type="date" class="form-control" id="issuance_date" name="issuance_date" required>
				</div>
				<div class="col-sm-2">
					<label class="fa fa-md">Failed Mode</label>
				</div>
				<div class="col-sm-4">
					<input type="input" class="form-control" id="fail_mode" name="fail_mode" required>
				</div>
				<div class="col-sm-2">
					<label class="fa fa-md">Supplier: </label>
				</div>
				<div class="col-sm-4">
					<select class="" id="supplier" name="supplier" style="width:100%;" required>
					</select>
				</div>
				<div class="col-sm-2">
					<label class="fa fa-md">Invoice Number: </label>
				</div>
				<div class="col-sm-4">
					<input type="text" class="form-control" id="invoice_no" name="invoice_no" list="list_invoice_no2">
					<datalist id="list_invoice_no2"></datalist>
				</div>
				<div class="col-sm-2">
				  <label class="fa fa-md">Part Code: </label>
				</div>
				<div class="col-sm-4">
					<input type="text" class="form-control" id="part_code" name="part_code" style="text-transform:uppercase" list="list_part_code2" required>
                    <datalist id="list_part_code2"></datalist>
				</div>
				<div class="col-sm-2">
					<label class="fa fa-md">Part Name: </label>
				</div>
				<div class="col-sm-4">
					<input type="text" class="form-control" id="parts_affected_parts" name="parts_affected_parts" readOnly required>
				</div>
			</div>
			<div class="row">
				<div class="col-sm-2">
				  <label class="fa fa-md">PO #: </label>
				</div>
				<div class="col-sm-4">
					<input type="text" class="form-control" id="po_number" name="po_number" list="list_po_number2">
                    <datalist id="list_po_number2"></datalist>
				</div>
				<div class="col-sm-2">
					<label class="fa fa-md">Device Name: </label>
				</div>
				<div class="col-sm-4">
					<input type="text" class="form-control" id="device_name" name="device_name" readonly >
				</div>
			</div>
			<div class="row">
				<div class="col-sm-2">
					<label class="fa fa-md">Lot No: </label>
				</div>
				<div class="col-sm-4">
					<button type="button" name="add_lot_number" class="btn btn-primary fa fa-plus" style="width:100%; margin-bottom:2%"> Lot Number</button>
				</div>
				<div class="col-sm-2">
					<label class="fa fa-md"><input type="checkbox" id="chk_reupload"> Re-upload: </label>
				</div>
				<div class="col-sm-4">
					<input type="file" id="file_ng_edit" name="" style="width:85%;display:inline-block;" accept=".csv, application/vnd.openxmlformats-officedocument.spreadsheetml.sheet, application/vnd.ms-excel" multiple>
					<a href="#" class="fa fa-paperclip" id="btn_attachment" style="display:inline-block;"> </a>
				</div>
              </div>
			  <div class="row">
				<div class="col-sm-2">
					<label class="fa fa-md">Drawing Number: </label>
				</div>
				<div class="col-sm-4">
					<input type="text" class="form-control" id="drawing_number" name="drawing_number" required>
				</div>
				<div class="col-sm-2">
					<label class="fa fa-md">Material Type: </label>
				</div>
				<div class="col-sm-4">
					<select class="form-control" id="material_type" name="material_type">
					</select>
				</div>
              </div>
              <div class="row">
				<div class="col-sm-2" style="padding-top:5px;">
					<label class="fa fa-md">Report Approvers: </label>
				</div>
				<div class="col-sm-10" style="padding-top:5px;">
					<select class="" id="cmb_approved_by" name="approvers[]" multiple="multiple" style="width:100%;" required>
					</select>
				</div>
              </div>
              <div class="row">
				<div class="col-sm-2" style="padding-top:5px;">
					<label class="fa fa-md">Remarks: </label>
				</div>
				<div class="col-sm-10" style="padding-top:5px;">
					<textarea class="form-control" id="remarks" name="remarks"></textarea>
				</div>
			</div>
		  </div>
		  <div class="modal-footer">
			<button type="submit" class="btn btn-primary fa fa-save" id="btn_ng_report_edit"> Update</button>
			<button type="button" class="btn btn-default fa fa-close" data-dismiss="modal"> Close</button>
		  </div>
		</form><!-- /#frm_upload_measdata -->
    </div><!-- /.modal-content -->
  </div><!-- /.modal-dialog -->
</div><!-- /.modal -->

<div class="modal fade" tabindex="-1" role="dialog" id="modal_approver_ng_view">
  <div class="modal-dialog modal-lg" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
        <h4 class="modal-title"><i class="fa fa-upload"></i> View NG Report Request</h4>
      </div>
	  <form id="frm_upload_ng_view" method="post">
		  <div class="modal-body">
			<div class="row">
				<div class="col-sm-2">
					<label class="fa fa-md">Issuance Date: </label>
				</div>
				<div class="col-sm-4">
					<input type="date" class="form-control" id="issuance_date" name="issuance_date" required>
				</div>
				<div class="col-sm-2">
					<label class="fa fa-md">Failed Mode</label>
				</div>
				<div class="col-sm-4">
					<input type="input" class="form-control" id="fail_mode" name="fail_mode" required>
				</div>
				<div class="col-sm-2">
					<label class="fa fa-md">Supplier: </label>
				</div>
				<div class="col-sm-4">
					<select class="" id="supplier" name="supplier" style="width:100%;" required>
					</select>
				</div>
				<div class="col-sm-2">
					<label class="fa fa-md">Invoice Number: </label>
				</div>
				<div class="col-sm-4">
					<input type="text" class="form-control" id="invoice_no" name="invoice_no" list="list_invoice_no">
					<datalist id="list_invoice_no"></datalist>
				</div>
				<div class="col-sm-2">
					<label class="fa fa-md">Part Code: </label>
				</div>
				<div class="col-sm-4">
					<input type="text" class="form-control" id="part_code" name="part_code" style="text-transform:uppercase" list="list_part_code" required>
                    <datalist id="list_part_code"></datalist>
				</div>
				<div class="col-sm-2">
					<label class="fa fa-md">Part Name: </label>
				</div>
				<div class="col-sm-4">
					<input type="text" class="form-control" id="parts_affected_parts" name="parts_affected_parts" readOnly required>
				</div>
			</div>
			<div class="row">
				<div class="col-sm-2">
					<label class="fa fa-md">PO #: </label>
				</div>
				<div class="col-sm-4">
					<input type="text" class="form-control" id="po_number" name="po_number" list="list_po_number2">
                    <datalist id="list_po_number2"></datalist>
				</div>
				<div class="col-sm-2">
					<label class="fa fa-md">Device Name: </label>
				</div>
				<div class="col-sm-4">
					<input type="text" class="form-control" id="device_name" name="device_name" readonly >
				</div>
			</div>
			<div class="row">
				<div class="col-sm-2">
					<label class="fa fa-md">Lot No: </label>
				</div>
				<div class="col-sm-4">
					<button type="button" name="view_lot_number" class="btn btn-primary fa fa-eye" style="width:100%; margin-bottom:2%"> Lot Number</button>
				</div>
				<div class="col-sm-2">
					<label class="fa fa-md"> Report: </label>
				</div>
				<div class="col-sm-4">
					<button type="button" class="btn btn-link fa fa-paperclip" id=""> Attachment</button>
				</div>
			</div>
			<div class="row">
				<div class="col-sm-2">
					<label class="fa fa-md">Drawing Number: </label>
				</div>
				<div class="col-sm-4">
					<input type="text" class="form-control" id="drawing_number" name="drawing_number" required>
				</div>
				<div class="col-sm-2">
					<label class="fa fa-md">Material Type: </label>
				</div>
				<div class="col-sm-4">
					<select class="form-control" id="material_type" name="material_type">
					</select>
				</div>
            </div>
			<div class="row">
				<div class="col-sm-2">
					<label class="fa fa-md">Remarks: </label>
				</div>
				<div class="col-sm-10">
					<textarea class="form-control" id="remarks_ng_view" name="remarks_ng_view" ></textarea>
				</div>
				<div class="col-sm-12" style="padding-top:5px;">
					<table class="table table-striped table-bordered table-condensed" id="tbl_approver_ng_view">
						<thead>
							<th style="width:10%"><center>Status</center></th>
							<th style="width:30%"><center>Approver Name</center></th>
							<th style="width:40%"><center>Approver's Remarks</center></th>
							<th style="width:40%"><center>Approver's Log</center></th>
						</thead>
						<tbody>
						</tbody>
					</table>
				</div>
			</div>
		  </div>
		  <div class="modal-footer">
			<button type="button" class="btn btn-success fa fa-thumbs-o-up" id="btn_ng_approve"> Approve</button>
			<button type="button" class="btn btn-danger fa fa-thumbs-o-down" id="btn_ng_disapprove"> Disapprove</button>
			<button type="button" class="btn btn-success fa fa-eye" id="btn_ng_view_disposition"> View Disposition</button>
			<button type="button" class="btn btn-default fa fa-close" data-dismiss="modal"> Close</button>
		  </div>
	  </form>
    </div><!-- /.modal-content -->
  </div><!-- /.modal-dialog -->
</div><!-- /.modal -->

<div class="modal fade" tabindex="-1" role="dialog" id="modal_approver_message">
  <div class="modal-dialog modal-md" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
        <h4 class="modal-title"><i class="fa fa-question-circle-o"></i> System Confirmation</h4>
      </div>
	  <form id="frm_ng_approvers_decision">
		  <div class="modal-body">
			<div class="row">			
				<div class="col-sm-12" id="">				
					<div class="alert alert-success" role="alert" id="container_approver_message">					
					</div>
				</div>
			</div>
		  </div>
		  <div class="modal-footer">
			<button type="submit" class="btn btn-primary fa fa-save"> Yes</button>
			<button type="button" class="btn btn-default fa fa-close" data-dismiss="modal" id="btn_close"> No</button>
		  </div>
	  </form>
    </div><!-- /.modal-content -->
  </div><!-- /.modal-dialog -->
</div><!-- /.modal -->

<div class="modal fade" tabindex="-1" role="dialog" id="modal_cancel_message">
  <div class="modal-dialog modal-md" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
        <h4 class="modal-title"><i class="fa fa-question-circle-o"></i> System Confirmation</h4>
      </div>
	  <form id="frm_ng_cancel">
		  <div class="modal-body">
			<div class="row">			
				<div class="col-sm-12" id="">				
					<div class="alert alert-danger" role="alert" id="">		
						Are you sure you want to cancel the request?<br><br>
						Remarks:<textarea name="remarks" style="width:100%;" rows="4" required></textarea>
					</div>
				</div>
			</div>
		  </div>
		  <div class="modal-footer">
			<button type="submit" class="btn btn-primary fa fa-save"> Yes</button>
			<button type="button" class="btn btn-default fa fa-close" data-dismiss="modal" id="btn_close"> No</button>
		  </div>
	  </form>
    </div><!-- /.modal-content -->
  </div><!-- /.modal-dialog -->
</div><!-- /.modal -->

<div class="modal fade" tabindex="-1" role="dialog" id="modal_ng_report">
  <div class="modal-dialog modal-lg" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
        <h4 class="modal-title"><i class="fa fa-files-o"></i> Extract NG Report</h4>
      </div>
	  <form id="frm_export_ng_report" method="post">
		  <div class="modal-body">
			<div class="row">
				<div class="col-sm-4">
					<label class="fa fa-md">NG Report Type: </label>
				</div>
				<div class="col-sm-8">
					<select class="form-control" id="cmb_ng_report_type" name="ng_report_type" required>
						<option value="dispo_summary">Disposition Summary</option>
						<option value="dispo_leadtime_first">Disposition Leadtime Monitoring (First Response)</option>
						<option value="dispo_leadtime_final">Disposition Leadtime Monitoring (Final Response)</option>
						<option value="ng_report_issuance_per_supplier">NG Report Issuance per Supplier</option>
						<option value="ng_report_per_material_type">NG Report per Material Type</option>
					</select>
				</div>
				<div class="col-sm-4">
					<label class="fa fa-md">Section: </label>
				</div>
				<div class="col-sm-8">
					<select class="chosen-select" multiple id="cmb_ng_section" name="ng_section">
						<option value="IQC">IQC</option>
						<option value="PRDN">PRDN</option>
						<option value="ENGR">ENGR</option>
					</select>
				</div>
            </div>
			<div class="row" id="container_ng_supplier" style="margin-top:5px;">
				<div class="col-sm-4">
					<label class="fa fa-md">Supplier: </label>
				</div>
				<div class="col-sm-8">
					<select class="" id="supplier" name="supplier" style="width:100%;" multiple="multiple" required>
					</select>
				</div>
            </div>
			<div class="row" style="margin-top:5px;">
				<div class="col-sm-4">
					<label class="fa fa-md">Fiscal Year Start: </label>
				</div>
				<div class="col-sm-8">
					<select class="form-control" id="cmb_ng_fy_start" name="ng_fy_start" required>
					</select>
				</div>
				<div class="col-sm-4">
					<label class="fa fa-md">Fiscal Year End: </label>
				</div>
				<div class="col-sm-8">
					<select class="form-control" id="cmb_ng_fy_end" name="ng_fy_end" required>
					</select>
				</div>
            </div>
		  </div>
		  <div class="modal-footer">
			<button type="submit" class="btn btn-success fa fa-file-excel-o"> Export</button>
			<button type="button" class="btn btn-default fa" data-dismiss="modal"> Close</button>
		  </div>
		</form>
    </div>
  </div>
</div>

<div class="modal fade" tabindex="-1" role="dialog" id="modal_ng_send_supplier">
  <div class="modal-dialog modal-lg" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
        <h4 class="modal-title"><i class="fa fa-send-o"></i> Send Report Internal / External</h4>		
      </div>
	<form id="frm_send_report_internal" method="post" enctype="multipart/form-data">	
	  <div class="modal-body">			
		<div class="row">            		
			<div class="col-sm-12" id="">	
                <div class="alert alert-success" role="alert">				
                    <b>*Once Send button was clicked, issuance status will be tagged as "WAITING DISPOSITION". System will automatically send email notification based on the selected recipients.</b>				
                </div>				
            </div>				
			<div class="col-sm-2" id="">	
                <label class="fa fa-md">NG Report #: </label>				
			</div>	
			<div class="col-sm-4" id="">	
                <input type="text" class="form-control" id="ng_report_no" name="ng_report_no" required>			
			</div>				
			<div class="col-sm-2" id="">	
                <label class="fa fa-md">Attachment: </label>				
			</div>	
			<div class="col-sm-4" id="">	
                <button type="button" class="btn btn-link fa fa-paperclip"> Download File</button>
			</div>		
		</div>		
		<div class="row" style="padding-top:3px;">    		
			<div class="col-sm-2" id="">	
                <label class="fa fa-md">Additional Message: </label>				
			</div>	
			<div class="col-sm-10" id="">	
                <input type="text" class="form-control" id="message" name="message" placeholder="Ex. To: Mr. Kase / Mr. YEC" required>			
			</div>				
			<div class="col-sm-2" id="">	
                <label class="fa fa-md">Fail Mode: </label>				
			</div>	
			<div class="col-sm-10" id="">	
                <input type="text" class="form-control" id="fail_mode" name="fail_mode" required>			
			</div>			
		</div>		
		<div class="row" style="padding-top:3px;">    	
			<div class="col-sm-2" id="">	
                <label class="fa fa-md">NG Report with Control #: </label>				
			</div>	
			<div class="col-sm-4" id="">	
                <input type="file" class="form-control" name="file_ng[]" id="file_ng" required multiple>			
			</div>		
			<div class="col-sm-2">
				<label class="fa fa-md">Supplier: </label>
			</div>
			<div class="col-sm-4">
				<select class="" id="supplier" name="supplier" style="width:100%;" required>
				</select>
			</div>
		</div>		
		<div class="row" style="padding-top:3px;">    
			<div class="col-sm-2" id="">	
                <label class="fa fa-md">To (Internal Recipients): </label>				
			</div>	
			<div class="col-sm-10" id="">	
				<select class="" id="cmb_ng_send_to" name="ng_send_to[]" multiple="multiple" style="width:100%;">
				</select>
			</div>	
		</div>		
		<div class="row" style="padding-top:3px;">         		
			<div class="col-sm-2" id="">	
                <label class="fa fa-md">To (External Recipients): </label>				
			</div>	
			<div class="col-sm-10" id="">	
				<select class="" id="cmb_ng_send_external_to" name="ng_send_external_to[]" multiple="multiple" style="width:100%;" disabled required>
				</select>
			</div>	
		</div>		
		<div class="row" style="padding-top:3px;">     		
			<div class="col-sm-2" id="">	
                <label class="fa fa-md">Cc: </label>				
			</div>	
			<div class="col-sm-10" id="">	
				<select class="" id="cmb_ng_send_cc" name="ng_send_cc[]" multiple="multiple" style="width:100%;">
				</select>
			</div>	
		</div>	
		<div class="row" style="padding-top:3px;">            		
			<div class="col-sm-2" id="">	
                <label class="fa fa-md">Cc (External Recipients): </label>				
			</div>	
			<div class="col-sm-10" id="">	
				<select class="" id="cmb_ng_send_external_cc" name="ng_send_external_cc[]" multiple="multiple" style="width:100%;" disabled required>
				</select>
			</div>	
		</div>		
		<div class="row" style="padding-top:3px;">       		
			<div class="col-sm-2" id="">	
                <label class="fa fa-md">Remarks: </label>				
			</div>	
			<div class="col-sm-10" id="">	
                <textarea class="form-control" id="txt_ng_send_remarks" name="remarks"></textarea>				
			</div>	
		</div>		
	  </div>			
	  <div class="modal-footer">			
        <button type="submit" class="btn btn-info fa fa-send-o" id="btn_ng_send_internal"> Send</button>				
		<button type="button" class="btn btn-default fa fa-close" data-dismiss="modal" id="btn_close"> Close</button>		
	  </div>			
	</div><!-- /.modal-content -->				
    </div>				
    </form>				
  </div><!-- /.modal-dialog -->				
</div>

<div class="modal fade" tabindex="-1" role="dialog" id="modal_ng_add_disposition">
  <div class="modal-dialog modal-md" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
        <h4 class="modal-title"><i class="fa fa-plus-circle"></i> Add Disposition</h4>
      </div>
      <form id="frm_ng_add_disposition" method="post" enctype="multipart/form-data">
        <input type="hidden" id="txt_hidden_disposition_type" name="disposition_status">
	    <div class="modal-body">
            <div class="panel panel-default">
                <div class="panel-heading">Sent Details:</div>
                <div class="panel-body">
                    <div class="row">        
                        <div class="col-sm-3">
                            <label class="fa fa-md">Sent By: </label>
                        </div>
                        <div class="col-sm-9">
                            <input type="text" class="form-control" id="disposition_sent_by" name="disposition_sent_by" disabled>
                        </div>
                    </div>
                    <div class="row">        
                        <div class="col-sm-3">
                            <label class="fa fa-md">Date/Time Sent: </label>
                        </div>
                        <div class="col-sm-9">
                            <input type="text" class="form-control" id="disposition_sent_date" name="disposition_sent_date" disabled>
                        </div>
                    </div>
                    <div class="row">        
                        <div class="col-sm-3">
                            <label class="fa fa-md">Remarks: </label>
                        </div>
                        <div class="col-sm-9">
                            <textarea class="form-control" style="width:100%;" rows="3" id="disposition_sent_remarks" name="disposition_sent_remarks" disabled></textarea>
                        </div>
                    </div>
                </div>
            </div>
			<div class="panel panel-success" id="container_ng_disposition">
                <div class="panel-heading">Treatment</div>
                <div class="panel-body">
                    <div class="row">        
                        <div class="col-sm-3">
                            <label class="fa fa-md">Disposition: </label>
                        </div>
                        <div class="col-sm-9">
                            <select class="form-control" id="disposition" name="disposition" required>
                            </select>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-sm-3">
                            <label class="fa fa-md">Disposition By: </label>
                        </div>
                        <div class="col-sm-9">
                            <input type="text" class="form-control" id="disposition_by" name="disposition_by" required>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-sm-3">
                            <label class="fa fa-md">Disposition Date: </label>
                        </div>
                        <div class="col-sm-9">
                            <input type="date" class="form-control" id="disposition_date" max="<?php echo date('Y-m-d'); ?>" name="disposition_date" required>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-sm-3">
                            <label class="fa fa-md">Disposition Time: </label>
                        </div>
                        <div class="col-sm-9">
                            <input type="time" class="form-control" id="disposition_time" name="disposition_time" required>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-sm-3">
                            <label class="fa fa-md" id="lbl_ng_initial_dispo"> Disposition File: </label>
                        </div>
                        <div class="col-sm-9">
                            <input type="file" class="form-control" id="treatment_file" name="treatment_file[]" multiple="multiple" data="Click to choose file." style="width:100%;display:inline-block;" required>
						</div>
                    </div>
                    <div class="row">
                        <div class="col-sm-3">
                            <label class="fa fa-md">Remarks: </label>
                        </div>
                        <div class="col-sm-9">
                            <textarea class="form-control" style="width:100%;" rows="3" id="disposition_remarks" name="disposition_remarks"></textarea>
                        </div>
                    </div>
                </div>
            </div>
			<div class="panel panel-primary" id="container_ng_final_reply">
                <div class="panel-heading">Final Reply (Corrective Action)</div>
                <div class="panel-body">
                    <input type="hidden" id="final_reply_status" name="final_reply_status">
                    <div class="row">
                        <div class="col-sm-3">
                            <label class="fa fa-md">Reply Date: </label>
                        </div>
                        <div class="col-sm-9">
                            <input type="date" class="form-control" id="final_reply_date" max="<?php echo date('Y-m-d'); ?>" name="final_reply_date">
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-sm-3">
                            <label class="fa fa-md">Reply Time: </label>
                        </div>
                        <div class="col-sm-9">
                            <input type="time" class="form-control" id="final_reply_time" name="final_reply_time">
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-sm-3">
                            <label class="fa fa-md">File: </label>
                        </div>
                        <div class="col-sm-9">
                            <input type="file" class="form-control" id="final_reply_file" name="final_reply_file[]" multiple="multiple" style="width:100%;display:inline-block;" required>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-sm-3">
                            <label class="fa fa-md">Remarks: </label>
                        </div>
                        <div class="col-sm-9">
                            <textarea class="form-control" style="width:100%;" rows="3" id="final_reply_remarks" name="final_reply_remarks"></textarea>
                        </div>
                    </div>
                </div>
            </div>
       </div>
	   <div class="modal-footer">
        <button type="submit" class="btn btn-info fa fa-plus-circle" id="btn_ng_submit_disposition"> Add</button>
		<button type="button" class="btn btn-default fa fa-close" data-dismiss="modal" id="btn_close"> Close</button>
	   </div>
      </form>
    </div><!-- /.modal-content -->    
  </div><!-- /.modal-dialog -->
</div><!-- /.modal -->

<div class="modal fade" tabindex="-1" role="dialog" id="modal_ng_edit_disposition">
  <div class="modal-dialog modal-md" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
        <h4 class="modal-title"><i class="fa fa-edit"></i> Edit Disposition</h4>
      </div>
      <form id="frm_ng_edit_disposition" method="post" enctype="multipart/form-data">
        <input type="hidden" id="txt_hidden_disposition_type" name="disposition_status">
	    <div class="modal-body">
            <div class="panel panel-default">
                <div class="panel-heading">Sent Details:</div>
                <div class="panel-body">
                    <div class="row">        
                        <div class="col-sm-3">
                            <label class="fa fa-md">Sent By: </label>
                        </div>
                        <div class="col-sm-9">
                            <input type="text" class="form-control" id="disposition_sent_by" name="disposition_sent_by" disabled>
                        </div>
                    </div>
                    <div class="row">        
                        <div class="col-sm-3">
                            <label class="fa fa-md">Date/Time Sent: </label>
                        </div>
                        <div class="col-sm-9">
                            <input type="text" class="form-control" id="disposition_sent_date" name="disposition_sent_date" disabled>
                        </div>
                    </div>
                    <div class="row">        
                        <div class="col-sm-3">
                            <label class="fa fa-md">Remarks: </label>
                        </div>
                        <div class="col-sm-9">
                            <textarea class="form-control" style="width:100%;" rows="3" id="disposition_sent_remarks" name="disposition_sent_remarks" disabled></textarea>
                        </div>
                    </div>
                </div>
            </div>
			<div class="panel panel-success" id="container_ng_disposition">
                <div class="panel-heading">Treatment</div>
                <div class="panel-body">
                    <div class="row">        
                        <div class="col-sm-3">
                            <label class="fa fa-md">Disposition: </label>
                        </div>
                        <div class="col-sm-9">
                            <select class="form-control" id="disposition" name="disposition" required>
                            </select>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-sm-3">
                            <label class="fa fa-md">Disposition By: </label>
                        </div>
                        <div class="col-sm-9">
                            <input type="text" class="form-control" id="disposition_by" name="disposition_by" required>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-sm-3">
                            <label class="fa fa-md">Disposition Date: </label>
                        </div>
                        <div class="col-sm-9">
                            <input type="date" class="form-control" id="disposition_date" max="<?php echo date('Y-m-d'); ?>" name="disposition_date" required>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-sm-3">
                            <label class="fa fa-md">Disposition Time: </label>
                        </div>
                        <div class="col-sm-9">
                            <input type="time" class="form-control" id="disposition_time" name="disposition_time" required>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-sm-3">
                            <label class="fa fa-md" id="lbl_ng_reupload_initial_dispo" style=""><input type="checkbox" id="chk_reupload_treatment"> Re-upload File: </label>
                        </div>
                        <div class="col-sm-9">
                            <input type="file" class="form-control" id="treatment_file" name="" data="Click to choose file." style="width:85%;display:inline-block;" accept=".csv, application/vnd.openxmlformats-officedocument.spreadsheetml.sheet, application/vnd.ms-excel" disabled>
							<a href="#" class="fa fa-paperclip" id="btn_ng_initial_dispo" style="width:13%;display:inline-block;"> </a>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-sm-3">
                            <label class="fa fa-md">Remarks: </label>
                        </div>
                        <div class="col-sm-9">
                            <textarea class="form-control" style="width:100%;" rows="3" id="disposition_remarks" name="disposition_remarks"></textarea>
                        </div>
                    </div>
                </div>
            </div>
			<div class="panel panel-primary" id="container_ng_final_reply">
                <div class="panel-heading">Final Reply (Corrective Action)</div>
                <div class="panel-body">
                    <input type="hidden" id="final_reply_status" name="final_reply_status">
                    <div class="row">
                        <div class="col-sm-3">
                            <label class="fa fa-md">Reply Date: </label>
                        </div>
                        <div class="col-sm-9">
                            <input type="date" class="form-control" id="final_reply_date" max="<?php echo date('Y-m-d'); ?>" name="final_reply_date">
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-sm-3">
                            <label class="fa fa-md">Reply Time: </label>
                        </div>
                        <div class="col-sm-9">
                            <input type="time" class="form-control" id="final_reply_time" name="final_reply_time">
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-sm-3">
                            <label class="fa fa-md" id="lbl_ng_reupload_final_dispo" style=""><input type="checkbox" id="chk_reupload_final_reply"> Re-upload File: </label>
                        </div>
                        <div class="col-sm-9">
                            <input type="file" class="form-control" id="final_reply_file" style="width:85%;display:inline-block;" name="final_reply_file" accept=".csv, application/vnd.openxmlformats-officedocument.spreadsheetml.sheet, application/vnd.ms-excel" disabled>
                        	<a href="#" class="fa fa-paperclip" id="btn_ng_final_dispo" style="width:13%;display:inline-block;"> </a>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-sm-3">
                            <label class="fa fa-md">Remarks: </label>
                        </div>
                        <div class="col-sm-9">
                            <textarea class="form-control" style="width:100%;" rows="3" id="final_reply_remarks" name="final_reply_remarks"></textarea>
                        </div>
                    </div>
                </div>
            </div>
       </div>
	   <div class="modal-footer">
        <button type="submit" class="btn btn-info fa fa-edit" id="btn_ng_submit_disposition"> Update</button>
		<button type="button" class="btn btn-default fa fa-close" data-dismiss="modal" id="btn_close"> Close</button>
	   </div>
      </form>
    </div><!-- /.modal-content -->    
  </div><!-- /.modal-dialog -->
</div><!-- /.modal -->

<div class="modal fade" tabindex="-1" role="dialog" id="modal_ng_view_disposition">
  <div class="modal-dialog modal-md" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
        <h4 class="modal-title"><i class="fa fa-eye"></i> View Disposition</h4>
      </div>
      <form id="frm_ng_view_disposition" method="post">
        <input type="hidden" id="txt_hidden_disposition_type" name="disposition_status">
	    <div class="modal-body">
            <div class="panel panel-default">
                <div class="panel-heading">Sent Details:</div>
                <div class="panel-body">
                    <div class="row">        
                        <div class="col-sm-3">
                            <label class="fa fa-md">Sent By: </label>
                        </div>
                        <div class="col-sm-9">
                            <input type="text" class="form-control" id="disposition_sent_by" name="disposition_sent_by" disabled>
                        </div>
                    </div>
                    <div class="row">        
                        <div class="col-sm-3">
                            <label class="fa fa-md">Date/Time Sent: </label>
                        </div>
                        <div class="col-sm-9">
                            <input type="text" class="form-control" id="disposition_sent_date" name="disposition_sent_date" disabled>
                        </div>
                    </div>
                    <div class="row">        
                        <div class="col-sm-3">
                            <label class="fa fa-md">Remarks: </label>
                        </div>
                        <div class="col-sm-9">
                            <textarea class="form-control" style="width:100%;" rows="3" id="disposition_sent_remarks" name="disposition_sent_remarks" disabled></textarea>
                        </div>
                    </div>
                </div>
            </div>
			<div class="panel panel-success" id="container_ng_disposition">
                <div class="panel-heading">Treatment</div>
                <div class="panel-body">
                    <div class="row">        
                        <div class="col-sm-3">
                            <label class="fa fa-md">Disposition: </label>
                        </div>
                        <div class="col-sm-9">
                            <select class="form-control" id="disposition" name="disposition" required>
                            </select>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-sm-3">
                            <label class="fa fa-md">Disposition By: </label>
                        </div>
                        <div class="col-sm-9">
                            <input type="text" class="form-control" id="disposition_by" name="disposition_by" required>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-sm-3">
                            <label class="fa fa-md">Disposition Date: </label>
                        </div>
                        <div class="col-sm-9">
                            <input type="date" class="form-control" id="disposition_date" max="<?php echo date('Y-m-d'); ?>" name="disposition_date" required>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-sm-3">
                            <label class="fa fa-md">Disposition Time: </label>
                        </div>
                        <div class="col-sm-9">
                            <input type="time" class="form-control" id="disposition_time" name="disposition_time" required>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-sm-3">
                            <label class="fa fa-md"> File: </label>
                        </div>
                        <div class="col-sm-9">
                            <a href="#" class="fa fa-paperclip" id="btn_ng_initial_dispo"> DOWNLOAD FILE</a>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-sm-3">
                            <label class="fa fa-md">Remarks: </label>
                        </div>
                        <div class="col-sm-9">
                            <textarea class="form-control" style="width:100%;" rows="3" id="disposition_remarks" name="disposition_remarks"></textarea>
                        </div>
                    </div>
                </div>
            </div>
			<div class="panel panel-primary" id="container_ng_final_reply">
                <div class="panel-heading">Final Reply (Corrective Action)</div>
                <div class="panel-body">
                    <input type="hidden" id="final_reply_status" name="final_reply_status">
                    <div class="row">
                        <div class="col-sm-3">
                            <label class="fa fa-md">Reply Date: </label>
                        </div>
                        <div class="col-sm-9">
                            <input type="date" class="form-control" id="final_reply_date" max="<?php echo date('Y-m-d'); ?>" name="final_reply_date">
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-sm-3">
                            <label class="fa fa-md">Reply Time: </label>
                        </div>
                        <div class="col-sm-9">
                            <input type="time" class="form-control" id="final_reply_time" name="final_reply_time">
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-sm-3">
                            <label class="fa fa-md"> File: </label>
                        </div>
                        <div class="col-sm-9">
                            <a href="#" class="fa fa-paperclip" id="btn_ng_final_dispo"> DOWNLOAD FILE</a>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-sm-3">
                            <label class="fa fa-md">Remarks: </label>
                        </div>
                        <div class="col-sm-9">
                            <textarea class="form-control" style="width:100%;" rows="3" id="final_reply_remarks" name="final_reply_remarks"></textarea>
                        </div>
                    </div>
                </div>
            </div>
       </div>
	   <div class="modal-footer">
		<button type="button" class="btn btn-default fa fa-close" data-dismiss="modal" id="btn_close"> Close</button>
	   </div>
      </form>
    </div><!-- /.modal-content -->    
  </div><!-- /.modal-dialog -->
</div><!-- /.modal -->

<div class="modal fade" tabindex="-1" role="dialog" id="modal_ng_add_lot_number">
  <div class="modal-dialog modal-lg" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
        <h4 class="modal-title" ><i class="fa fa-plus"></i> Add Lot Number</h4>
      </div>		
	  <div class="modal-body">
		<form id="frm_ng_add_lot_number" method="post">
		<div class="row">
			<div class="col-sm-12">
				<div class="alert alert-success" style="" role="alert" id="">					
					<b>Click the "SAVE" button to record the selected Lot Number/s</b>				
				</div>
			</div>
			<div class="col-sm-12">
				<div class="alert alert-danger" role="alert" style="display:none;">					
					<b>Lot Number already exists!</b>				
				</div>
			</div>
			<div class="col-sm-2">
				<label class="fa fa-md">Lot Number: </label>
			</div>
			<div class="col-sm-4">
				<datalist id="list_ng_lot_number_add"></datalist>
				<input type="text" class="form-control" list="list_ng_lot_number_add" id="lot_number" autocomplete="off" name="lot_number" required>
			</div>
			<div class="col-sm-2">
				<label class="fa fa-md">Quantity: </label>
			</div>
			<div class="col-sm-4">
				<input type="number" class="form-control" id="quantity" name="quantity" min=0 required>
			</div>
			<div class="col-sm-4 col-sm-offset-8">
				<button type="submit" class="btn btn-primary fa fa-plus" style="width:100%; margin-bottom:2%"> Add Lot Number</button>
			</div>
		</div>		
		<div class="row">
			<div class="col-sm-12">
				<table class="table table-striped table-bordered table-condensed" id="tbl_lot_details" style="width:100%;">
					<thead>
						<th style="width:45%">Lot Number</th>
						<th style="width:45%">Quantity</th>
						<th style="width:10%">Remove</th>
					</thead>
					<tbody>
					</tbody>
				</table>
			</div>
		</div>
		</form>
	  </div>	  
	  <div class="modal-footer">
        <button type="button" class="btn btn-primary fa fa-save" id="btn_save_lot_number_details"> Save</button>
        <button type="button" class="btn btn-default fa fa-close" data-dismiss="modal"> Close</button>
      </div>
    </div><!-- /.modal-content -->
  </div><!-- /.modal-dialog -->
</div><!-- /.modal -->

<div class="modal fade" tabindex="-1" role="dialog" id="modal_ng_view_lot_number">
  <div class="modal-dialog modal-lg" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
        <h4 class="modal-title" ><i class="fa fa-eye"></i> View Lot Number</h4>
      </div>		
	  <div class="modal-body">
		<form id="frm_ng_view_lot_number" method="post">
		<div class="row">
			<div class="col-sm-12">
				<table class="table table-striped table-bordered table-condensed" id="tbl_lot_details" style="width:100%;">
					<thead>
						<th style="width:45%">Lot Number</th>
						<th style="width:45%">Quantity</th>
					</thead>
					<tbody>
					</tbody>
				</table>
			</div>
		</div>
		</form>
	  </div>	  
	  <div class="modal-footer">
        <button type="button" class="btn btn-default fa fa-close" data-dismiss="modal"> Close</button>
      </div>
    </div><!-- /.modal-content -->
  </div><!-- /.modal-dialog -->
</div><!-- /.modal -->

<!-- Modal for viewing attachment -->
<div class="modal fade" tabindex="-1" role="dialog" id="modal_sa_attachment_viewer">
  <div class="modal-dialog modal-md" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
        <h4 class="modal-title"><i class="fa fa-files-o"></i> View / Download Attachment/s</h4>
      </div>
	  <div class="modal-body">
		<div class="row">
			<div class="col-sm-12" id="">
				<!-- Display attachment here in table format ;) -->
				<table class="table table-striped table-bordered table-condensed" id="tbl_view_attachments_ng">
					<thead>
						<th>File Name (click to download the file)</th>
					</thead>
					<tbody>
					</tbody>
				</table>
			</div>
		</div>
	  </div>
	  <div class="modal-footer">
		<button type="button" class="btn btn-default fa fa-close" data-dismiss="modal"> Close</button>
	  </div>
    </div><!-- /.modal-content -->
  </div><!-- /.modal-dialog -->
</div><!-- /.modal -->


<div class="modal" tabindex="-1" role="dialog" id="modal_ng_advance_search">
  <div class="modal-dialog modal-lg" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
        <h4 class="modal-title fa fa-search"> Advance Search</h4>
      </div>
	  <form id="frm_ng_advance_search">
      <div class="modal-body">
		<button type="button" class="btn btn-default fa pull-left fa fa-eraser" id="btn_ng_as_reset"> Reset Search Value</button>
		<button type="button" class="btn btn-primary fa pull-right fa fa-plus" id="btn_ng_as_add"> Add</button><br /><br />
		<table class="table" id="tbl_ng_advance_search">
			<tbody>
			</tbody>
		</table>
      </div>
      <div class="modal-footer">
        <button type="submit" class="btn btn-primary fa fa-search"> Search</button>
        <button type="button" class="btn btn-default fa fa-close" data-dismiss="modal"> Close</button>
      </div>
	  </form>
    </div><!-- /.modal-content -->
  </div><!-- /.modal-dialog -->
</div><!-- /.modal -->