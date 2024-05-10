<?php
/* Check if user is approver or a requestor NG Report */
$sa_report_manager	 			= false;
$sa_report_requestor 			= false;
$sa_report_disposition_admin 	= false;
$sa_user_access 	= false;
foreach($user_role['subsystem_code'] as $key => $subsystem_code ){
	if($subsystem_code == "IQC" && $user_role['module'][$key] == "Special Acceptance" && $user_role['role'][$key] == "APPROVER"){ 
		$sa_report_manager = true;
	}else if($subsystem_code == "IQC" && $user_role['module'][$key] == "Special Acceptance" && $user_role['role'][$key] == "REQUESTOR"){
		// $sa_report_requestor = true;
		$sa_report_disposition_admin = true;
	}else if($subsystem_code == "IQC" && $user_role['module'][$key] == "Special Acceptance" && $user_role['role'][$key] == "SUPERVISOR"){
		$sa_report_disposition_admin = true;
	}else if($subsystem_code == "IQC" && $user_role['module'][$key] == "Special Acceptance" && $user_role['role'][$key] == "QC STAFF"){
		$sa_report_requestor = true;
	}else if($subsystem_code == "IQC" && $user_role['module'][$key] == "Special Acceptance" && $user_role['role'][$key] == "OPERATOR"){
		$sa_report_requestor = true;
	}else if($subsystem_code == "IQC" && $user_role['module'][$key] == "Special Acceptance" && $user_role['role'][$key] == "INSPECTOR"){
		$sa_report_disposition_admin = true;
	}else if($subsystem_code == "IQC" && $user_role['module'][$key] == "Special Acceptance" && $user_role['read'][$key] == 1){
		$sa_report_disposition_admin = true;
	}
	if($subsystem_code == "IQC" && $user_role['module'][$key] == "Special Acceptance" && $user_role['create'][$key] == 1){
		$sa_user_access = true;
	}
}
// if((!$sa_report_manager) && (!$sa_report_requestor)){
// 	$sa_report_disposition_admin = true;
// }
?>


<div class="col-sm-12">
	<!-- Nav tabs -->
	<div class="">
		<ul class="nav nav-tabs" role="tablist">
		<?php 
			if($sa_report_disposition_admin){
				echo '
						<li class="nav-item">
							<a class="nav-link " data-toggle="tab" href="#home">Home</a>
						</li>
						<li class="nav-item active">
							<a class="nav-link " data-toggle="tab" href="#for_sar_disposition">For Disposition</a>
						</li>
						<li class="nav-item">
							<a class="nav-link " data-toggle="tab" href="#for_approval">For Approval</a>
						</li>
						<li class="nav-item">
							<a class="nav-link " data-toggle="tab" href="#with_treatment">With Treatment</a>
						</li>
					';
			}
			if($sa_report_manager){
				echo '
					<li class="nav-item active">
						<a class="nav-link " data-toggle="tab" href="#for_approval">For Approval</a>
					</li>
					<li class="nav-item">
						<a class="nav-link " data-toggle="tab" href="#with_treatment">With Treatment</a>
					</li>
					';
			}
		?>
		</ul>
	</div>
</div>	

<?php
$is_active = ($sa_report_disposition_admin || $sa_report_manager)?"active":"";
?>

  <!-- Tab panes -->
<div class="tab-content">
    <div role="tabpanel" id="home" class="tab-pane"><br>
		<div class="col-sm-12">
			<div class="panel panel-info">
				<div class="panel-heading"><i class="fa fa-file fa-lg"> Special Acceptance</i></div>
				<div class="panel-body">
					<div class="col-sm-12">
						<?php
							// if($sa_user_access){
							// 	echo '<button class="btn btn-success fa fa-plus pull-right" id="btn_sa"> New Special Acceptance</button>';
							// }
						?>
						<!-- <button class="btn btn-success fa fa-plus pull-right" id="btn_sa"> New Special Acceptance</button> -->
					</div><br><br>
					<div class="row">
						<div class="col-sm-12">
							<table class="table table-condensed table-bordered" id="tbl_special_acceptance">
								<thead>
									<tr>
										<th>Status</th>
										<th>Control Number</th>
										<th>Parts and Product Details</th>
										<th>Prepared by</th>
										<th>Customer</th>
										<th><span class="fa fa-cogs"></span></th>
									</tr>
								</thead>
							</table>
						</div>
					</div>
				</div>
			</div>
		</div>
	</div>

    <!-- <div id="menu2" class="tab-pane fade"><br> --> 
    <div id="for_sar_disposition" class="tab-pane <?php echo $is_active ?>"><br>
		<div class="col-sm-12">
			<div class="panel panel-info">
				<div class="panel-heading"><i class="fa fa-file fa-lg"> For Disposition</i></div>
				<div class="panel-body">
				<div class="col-sm-12">
						<?php
							if($sa_user_access){
								echo '<button class="btn btn-success fa fa-plus pull-right" id="btn_sa"> New Special Acceptance</button>';
							}
						?>
					</div><br><br>
					<div class="col-sm-12">
					</div><br><br>
					<div class="row">
						<div class="col-sm-12">
							<table class="table table-condensed table-bordered" id="tbl_special_acceptance_disposition">
								<thead>
									<tr>
										<th>Status</th>
										<th>Control Number</th>
										<th>Parts and Product Details</th>
										<th>Prepared by</th>
										<th>Customer</th>
										<th><span class="fa fa-cogs"></span></th>
									</tr>
								</thead>
							</table>
						</div>
					</div>
				</div>
			</div>
		</div>
	</div>
<?php
// $is_active = ($sa_report_disposition_admin || $sa_report_manager)?"active":'';
?>
    <div id="with_treatment" class="tab-pane"><br>
		<div class="col-sm-12">
			<div class="panel panel-info">
				<div class="panel-heading"><i class="fa fa-file fa-lg"> With Treatment/Disposition</i></div>
				<div class="panel-body">
					<div class="col-sm-3">
					</div><br><br>
					<div class="row">
						<div class="col-sm-12">
							<table class="table table-condensed table-bordered" id="tbl_special_acceptance_with_treatment">
								<thead>
									<tr>
										<th>Status</th>
										<th>Control Number</th>
										<th>Parts and Product Details</th>
										<th>Prepared by</th>
										<th>Customer</th>
										<th><span class="fa fa-attachment"></span>File Attachment</th>
										<th><span class="fa fa-cogs"></span></th>
									</tr>
								</thead>
							</table>
						</div>
					</div>
				</div>
			</div>
		</div>
	</div>
    <div id="for_approval" class="tab-pane"><br>
		<div class="col-sm-12">
			<div class="panel panel-info">
				<div class="panel-heading"><i class="fa fa-file fa-lg">For Approval</i></i></div>
				<div class="panel-body">
						<iframe src="../../edocapp_test/index.php?is_tqts_access=true" width="100%" height="100%" style="border:none;" title="Pending">
						</iframe>
				</div>
			</div>
		</div>
	</div>
</div>

<div class="container">
<div class="modal fade" tabindex="-1" role="dialog" id="modal_approver_messages">
  <div class="modal-dialog modal-md" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
        <h4 class="modal-title"><i class="fa fa-question-circle-o"></i> System Confirmation</h4>
      </div>
	  <form id="frm_sa_approvers_decisions">
	  <!-- <form id="frm_ng_approvers_decisions"> -->
		  <div class="modal-body">
			<div class="row">			
				<div class="col-sm-12" id="">				
					<div class="alert alert-success" role="alert" id="container_approver_messages">					
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
</div>

<div class="container">
<div class="modal fade" tabindex="-1" role="dialog" id="modal_main_approver_messages">
  <div class="modal-dialog modal-md" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
        <h4 class="modal-title"><i class="fa fa-question-circle-o"></i> System Confirmation</h4>
      </div>
	  <form id="frm_sa_main_approvers_decisions">
		  <div class="modal-body">
			<div class="row">			
				<div class="col-sm-12" id="">				
					<div class="alert alert-success" role="alert" id="container_approver_messages">					
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
</div>


<!-- NOTE : modal add special acceptance -->
<div class="modal fade" tabindex="-1" role="dialog" id="modal_sa">
  <div class="modal-dialog modal-lg" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
        <h4 class="modal-title"><i class="fa fa-plus"></i> New Special Acceptance</h4>
      </div>
	  <form id="frm_sa" method="post" enctype="multipart/form-data">
		  <div class="modal-body">
			<div class="row">
				<div class="col-sm-12">
					<div class="alert alert-danger" style="display:none;" role="alert" id="container_upload_sa_message">					
					</div>
				</div>
			</div>
			<div class="row">
				<div class="col-sm-2">
					<label class="fa fa-md">SpecialAcceptanceId</label>
				</div>
				<div class="col-sm-4">
					<input type="text" class="form-control" id="special_acceptance_id" name="special_acceptance_id" readonly>
				</div> 
				<div class="col-sm-2">
					<label class="fa fa-md">Status: </label>
				</div>
				<div class="col-sm-4">
					<div id="badge_status"></div>
				</div>
			</div>
			<div class="row">
				<div class="col-sm-2">
					<label class="fa fa-md">Category: </label>
				</div>
				<div class="col-sm-4">
					<select class="form-control" id="txt_category" name="category" required>
						<option value="" disabled>--Select--</option>
						<option value="Parts">Parts</option>
						<option value="Device">Device</option>
					</select>
				</div>
				<div class="col-sm-2">
					<label class="fa fa-md">Control No: </label>
				</div>
				<div class="col-sm-4">
					<input type="text" class="form-control" id="txt_control_number" name="control_number"required readonly>
				</div>
			</div>
			<div class="row">
				<div id="container_parts">
					<div class="col-sm-2">
						<label class="fa fa-md">Part Code: </label>
					</div>
					<div class="col-sm-4">
						<datalist id="list_sa_part_code"></datalist>
						<input list="list_sa_part_code" type="text" class="form-control" id="" name="part_code">
					</div>
					<div class="col-sm-2">
						<label class="fa fa-md">Parts Affected: </label>
					</div>
					<div class="col-sm-4">
						<input type="text" class="form-control" id="" name="parts_affected_parts" required>
					</div>
				</div>
				<div id="container_device">
					<div class="col-sm-2">
						<label class="fa fa-md">PO #: </label>
					</div>
					<div class="col-sm-4">
						<datalist id="list_sa_po"></datalist>
						<input list="list_sa_po" type="text" class="form-control" id="" name="po_number">
					</div>
					<div class="col-sm-2">
						<label class="fa fa-md">PO Qty: </label>
					</div>
					<div class="col-sm-4">
						<input type="text" class="form-control" id="" name="po_qty" required>
					</div>
					<div class="col-sm-2">
						<label class="fa fa-md">Device Name: </label>
					</div>
					<div class="col-sm-4">
						<input type="text" class="form-control" id="" name="device_name" required>
					</div>
					<div class="col-sm-2">
						<label class="fa fa-md">Parts Affected: </label>
					</div>
					<div class="col-sm-4">
						<input type="text" class="form-control" id="" name="parts_affected_device">
					</div>
				</div>
            </div>

			<!-- DELETED FIELDS -->
			<div class="col-sm-2 deletedField">
				<label class="fa fa-md">Choose File: </label>
			</div>
			<div class="col-sm-4 deletedField">
				<input type="file" class="form-control" id="file_sa" name="file_sa" accept=".csv, application/vnd.openxmlformats-officedocument.spreadsheetml.sheet, application/vnd.ms-excel">
			</div>
			<div class="row" id="global_input_field">
					<div class="col-sm-2">
						<label class="fa fa-md">Fail Mode: </label>
					</div>
					<div class="col-sm-4">
						<input type="text" class="form-control" id="problem" name="problem" list="">
					</div>
					<div class="col-sm-2">
						<label class="fa fa-md">Factory Location: </label>
					</div>
					<div class="col-sm-4">
						<select type="text" class="form-control" id="factory_location" name="factory_location">
							<option value="" disabled>--Select--</option>
							<option value="Cabuyao" >Cabuyao</option>
							<option value="Malvar" >Malvar</option>
						</select>
					</div>
					<div class="col-sm-2">
						<label class="fa fa-md">Date Issued: </label>
					</div> 
					<div class="col-sm-4">
						<input type="date" class="form-control" id="txt_date_issued" name="date_issued" >
					</div>
					<div class="col-sm-2">
							<label class="fa fa-md">Customer Name: </label>
					</div>
					<div class="col-sm-4" style="padding-top:5px;">
						<select class="" id="supplier" name="supplier" style="width:100%;" required>
						</select>
					</div>
					<div class="container_checked_by_qc" style = "display:none;">
						<div class="col-sm-2">
							<label class="fa fa-md">Checked by QC:</label>
						</div>
						<div class="col-sm-4" style="padding-top:5px;">
							<select class="form-control" id="txt_judged_by_qc" name="judged_by_qc[]" style="width:100%;" multiple = "multiple"></select>
						</div>
					</div>
			</div>
			<div class="row display-field-none deletedField">
				<div class="col-sm-2">
					<label class="fa fa-md">Drawing Number: </label>
				</div>
				<div class="col-sm-4">
					<input value="N/A" type="text" class="form-control" id="" name="drawing_number">
				</div>
				<div class="col-sm-2">
					<label class="fa fa-md">Quantity: </label>
				</div>
				<div class="col-sm-4">
					<input value="0" type="number" class="form-control" id="" name="quantity">
				</div>
				<div class="col-sm-2">
					<label class="fa fa-md">Product Supplier Name: </label>
				</div>
				<div class="col-sm-4">
					<input value="N/A" type="text" class="form-control" id="" name="customer_name">
				</div>
				<div class="col-sm-2">
					<label class="fa fa-md">Shipment Date: </label>
				</div>
				<div class="col-sm-4">
					<input type="date" class="form-control" id="" name="shipment_date">
				</div>
				<div class="col-sm-2">
					<label class="fa fa-md">Affected Qty: </label>
				</div>
				<div class="col-sm-4">
					<input type="number" class="form-control" id="" name="affected_quantity">
				</div>
				
			</div>
			<div class="row">
				<div id="container_approver_name" class="deletedField">
					<div class="col-sm-2">
							<label class="fa fa-md">Checked /Approved by: </label>
					</div>	
					<div class="col-sm-10" style="padding-top:5px;">
							<select class="form-control" name="judged_by_approver[]" id="judged_by_approver" style="width:100%;" multiple="multiple"> 
							</select>
					</div>
				</div>
				<div class="col-sm-12">
					<label class="fa fa-md">Immediate Action: </label>
				</div>
				<div class="col-sm-6" style="padding-top:5px;">
					<textarea class="form-control" id="txt_immediate_action" name="immediate_action"></textarea>
				</div>
				<div class="col-sm-2">
					<label class="fa fa-md">Due Date/ICP: </label>
				</div> 
				<div class="col-sm-4">
					<input type="date" class="form-control" id="txt_immediate_action_due_date" name="immediate_action_due_date" >
				</div>
				<div class="col-sm-12">
					<label class="fa fa-md">Permanent Action: </label>
				</div>
				<div class="col-sm-6" style="padding-top:5px;">
					<textarea class="form-control" id="txt_permanent_action" name="permanent_action"></textarea>
				</div>
				<div class="col-sm-2">
					<label class="fa fa-md">Due Date/ICP: </label>
				</div>
				<div class="col-sm-4">
					<input type="date" class="form-control" id="txt_permanent_action_due_date" name="permanent_action_due_date" >
				</div> 
				<div class="col-sm-12">
					<label class="fa fa-md">Other Details: </label>
				</div>
				<div class="col-sm-12" style="padding-top:5px;">
					<textarea class="form-control" name="other_details"></textarea>
				</div>
				<div id="container_main_approver_name" class="deletedField">
					<fieldset class="form-control" style="border-color: #D3D3D3;">
						<legend style="font-size: 15px; color: #FF8C00">
							<strong>APPROVAL</strong>
						</legend>
					</fieldset>
					<div class="col-sm-11 col-sm-offset-10 deletedField">
						<button class = "btn-success fa fa-plus" id="btn_add_approver" style = "padding:5px;">Add Approvers</button>
					</div>
					<table class="table table-condensed table-bordered dataTable no-footer" id = "tbl_approver">
						<thead>
							<tr>
								<th>Order No.</th>
								<th>Approver's Name</th>
								<th>Column</th>
								<th>Row</th>
								<th> <span class="fa fa-cogs"></span> </th>
							</tr>
						</thead>
						<tbody>
						</tbody>
						
					</table>
				</div>
			</div>
			<div class="row" id="container_disposition">
				<div class="col-sm-2">
					<label class="fa fa-md">Judgement Application: </label>
				</div>
				<div class="col-sm-4">
					<select class="form-control" name="judgement_application" >
						<option value=""></option>
						<option value="All incoming Parts">All incoming Parts</option>
						<option value="All incoming P.O.">All incoming P.O.</option>
						<option value="Specific Parts Lot no.">Specific Parts Lot no.</option>
						<option value="Specific Product P.O. no.">Specific Product P.O. no.</option>
						<option value="Others">Others, please specify</option>
					</select>
				</div>
				<div class="col-sm-2">
					<label class="fa fa-md">Remarks: </label>
				</div>
				<div class="col-sm-10">
					<textarea class="form-control" id="" name="notations_remarks"></textarea>
				</div>
			</div>
			<div class="row">
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

<div class="modal fade" tabindex="-1" role="dialog" id="modal_sa_cancel">
  <div class="modal-dialog modal-md" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
        <h4 class="modal-title"><span class="fa fa-remove"></span> Cancel Report</h4>
      </div>
      <div class="modal-body">
        <form id="frm_sa_cancel">
			<div class="row">
				<div class="col-sm-12">
					<label class="control-label">Are you sure you want to cancel </label>
					<label id="label_info"></label>
				</div>
				<div class="col-sm-12">
					<label class="control-label">Please state your reason for cancellation: </label>
				</div>
				<div class="col-sm-12">
					<textarea type="text" class="form-control condensed" name="cancel_remarks" required></textarea>
				</div>
			</div>
      </div>
      <div class="modal-footer">
			<button type="submit" class="btn btn-danger"> Cancel Request</button>
			<button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
		</form>
      </div>
    </div><!-- /.modal-content -->
  </div><!-- /.modal-dialog -->
</div><!-- /.modal -->

<div class="modal fade" tabindex="-1" role="dialog" id="modal_sa_replace_file">
  <div class="modal-dialog modal-sm" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
        <h4 class="modal-title"><span class="fa fa-file-excel-o"></span> Replace File</h4>
      </div>
      <div class="modal-body">
        <form id="frm_sa_replace_file">
			<div class="row">
				<div class="col-sm-4">
					Choose File 
				</div>
				<div class="col-sm-8">
					<input type="file" class="form-control" id="file_sa" name="file_sa" accept=".csv, application/vnd.openxmlformats-officedocument.spreadsheetml.sheet, application/vnd.ms-excel" required>
				</div>
			</div>
      </div>
      <div class="modal-footer">
			<button type="submit" class="btn btn-primary"> Replace</button>
			<button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
      </div>
	  </form>
    </div><!-- /.modal-content -->
  </div><!-- /.modal-dialog -->
</div><!-- /.modal -->

<!-- Modal -->
<div id="myModal" class="modal fade" tabindex="-1" role="dialog">
  <div class="modal-dialog modal-sm"  role="document">
    <!-- Modal content-->
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal">&times;</button>
        <h4 class="modal-title">Modal Header</h4>
      </div>
      <div class="modal-body">
        <p>Some text in the modal.</p>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
      </div>
    </div>
  </div>
</div>

<div class="modal" tabindex="-1" role="dialog" id="modal_sa_advance_search">
  <div class="modal-dialog modal-lg" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
        <h4 class="modal-title fa fa-search"> Advance Search</h4>
      </div>
	  <form id="frm_sa_advance_search">
      <div class="modal-body">
		<button type="button" class="btn btn-default fa pull-left fa fa-eraser" id="btn_sa_as_reset"> Reset Search Value</button>
		<button type="button" class="btn btn-primary fa pull-right fa fa-plus" id="btn_sa_as_add"> Add</button><br /><br />
		<table class="table" id="tbl_sa_advance_search">
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

<div class="modal" tabindex="-1" role="dialog" id="modal_sa_system_message">
  <div class="modal-dialog modal-md" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
        <h4 class="modal-title fa fa-search"> System Message</h4>
      </div>
      <div class="modal-body">
		<div class="" id="div_system_message"></div>
      </div>
      <div class="modal-footer">
        <div id="div_countdown"></div>
		<!--<button type="submit" class="btn btn-primary fa fa-search"> Search</button>-->
        <button type="button" class="btn btn-default fa fa-close" data-dismiss="modal"> Close</button>
      </div>
    </div><!-- /.modal-content -->
  </div><!-- /.modal-dialog -->
</div><!-- /.modal -->


<!-- NOTE : femail -->
<div class="container">
	<!-- <div class="modal fade" tabindex="-1" role="dialog" id="modal_ng_send_supplier">-->
	<div class="modal fade" tabindex="-1" role="dialog" id="modal_send_supplier_sa">
	<div class="modal-dialog modal-lg" role="document">
		<div class="modal-content">
		<div class="modal-header">
			<button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
			<h4 class="modal-title"><i class="fa fa-send-o"></i> Send Report Internal / External</h4>		
		</div>
		<form id="frm_send_report_internal_sa" method="post" enctype="multipart/form-data">	
		<div class="modal-body">			
			<div class="row">            		
				<div class="col-sm-12" id="">	
					<div class="alert alert-success" role="alert">				
						<b>*Once Send button was clicked, issuance status will be tagged as "WAITING DISPOSITION". System will automatically send email notification based on the selected recipients.</b>				
					</div>				
				</div>				
				<div class="col-sm-2" id="">	
					<label class="fa fa-md">Control No: </label>				
				</div>	
				<div class="col-sm-4" id="">	
					<input type="text" class="form-control" id="txt_control_number" name="control_number" required disabled>			
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
					<label class="fa fa-md">Upload File: </label>				
				</div>	
				<div class="col-sm-4" id="">	
					<!-- <input type="file" class="form-control" name="file_sa" id="file_sa" accept=".csv, application/vnd.openxmlformats-officedocument.spreadsheetml.sheet, application/vnd.ms-excel"  required>	 		 -->
					<input type="file" class="form-control" name="file_sa" id="file_sa" accept=".pdf"  required>	 		
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
					<select class="" id="cmb_sa_send_to" name="sa_send_to[]" multiple="multiple" style="width:100%;">
					</select>
				</div>	
			</div>		
			<div class="row" style="padding-top:3px;">         		
				<div class="col-sm-2" id="">	
					<label class="fa fa-md">To (External Recipients): </label>				
				</div>	
				<div class="col-sm-10" id="">	
					<select class="" id="cmb_sa_send_external_to" name="sa_send_external_to[]" multiple="multiple" style="width:100%;" required>
					</select>
				</div>	
			</div>		
			<div class="row" style="padding-top:3px;">     		
				<div class="col-sm-2" id="">	
					<label class="fa fa-md">Cc: </label>				
				</div>	
				<div class="col-sm-10" id="">	
					<select class="" id="cmb_sa_send_cc" name="sa_send_cc[]" multiple="multiple" style="width:100%;">
					</select>
				</div>	
			</div>	
			<div class="row" style="padding-top:3px;">   
				<div class="col-sm-10" id="container_cmb_sa_send_external_cc">	         		
				<div class="col-sm-2" id="">	
					<label class="fa fa-md">Cc (External Recipients): </label>				
				</div>	
					<select class="" id="cmb_sa_send_external_cc" name="sa_send_external_cc[]" multiple="multiple" style="width:100%;" disabled>
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
</div>

<div class="modal fade" tabindex="-1" role="dialog" id="modal_for_revision">
	<div class="modal-dialog modal-md" role="document">
		<div class="modal-content">
		<div class="modal-header">
			<button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
			<h4 class="modal-title"><i class="fa fa-question-circle-o"></i> System Confirmation</h4>
		</div>
		<form id="frm_sa_for_revision">
			<div class="modal-body">
				<div class="row">		
					<div class="col-sm-12">			
						<label for="">Please state your reason to revise this report.</label>
					</div>	
					<div class="col-sm-12">
						<input type="text" id="pkid" name = "pkid" style = "display:none">				
						<textarea class="form-control" style="min-width: 100%" id = "remarks" name = "remarks"></textarea>
					</div>
				</div>
			</div>
			<div class="modal-footer">
				<button type="submit" class="btn btn-primary fa fa-save">Confirm</button>
				<button type="button" class="btn btn-default fa fa-close" data-dismiss="modal" id="btn_close"> No</button>
			</div>
		</form>
		</div><!-- /.modal-content -->
	</div><!-- /.modal-dialog -->
</div><!-- /.modal -->

<div class="modal fade" tabindex="-1" role="dialog" id="modal_for_qc_checking">
	<div class="modal-dialog modal-md" role="document">
		<div class="modal-content">
		<div class="modal-header">
			<button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
			<h4 class="modal-title"><i class="fa fa-question-circle-o"></i> System Confirmation</h4>
		</div>
		<form id="frm_sa_for_qc_checking">
			<div class="modal-body">
				<div class="row">		
					<div class="col-sm-12">			
						<div class="funkyradio">
							<div class="funkyradio-primary">
								<input type="radio" name="status" id="checkbox1" value="APPROVED">
								<label for="checkbox1"> Approved</label>
							</div>
							<div class="funkyradio-primary">
								<input type="radio" name="status" id="checkbox2" value="DISAPPROVED">
								<label for="checkbox2"> Disapproved</label>
							</div>
						</div>
					</div>	
					<div class="col-sm-12">
						<input type="text" id="pkid" name = "pkid" style = "display:none">		
						<textarea class="form-control" style="min-width: 100%" 
						id = "remarks" name = "remarks" placeholder = "Please state your reason to approved/disapproved this report."
						required></textarea>
					</div>
				</div>
			</div>
			<div class="modal-footer">
				<button type="submit" class="btn btn-primary fa fa-save">Confirm</button>
				<button type="button" class="btn btn-default fa fa-close" data-dismiss="modal" id="btn_close"> No</button>
			</div>
		</form>
		</div><!-- /.modal-content -->
	</div><!-- /.modal-dialog -->
</div><!-- /.modal -->

<div class="modal fade" tabindex="-1" role="dialog" id="modal_sa_add_disposition">
  <div class="modal-dialog modal-md" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
        <h4 class="modal-title"><i class="fa fa-plus-circle"></i> Add Disposition</h4>
      </div>
      <form id="frm_sa_add_disposition" method="post" enctype="multipart/form-data">
        <input type="hidden" id="txt_hidden_disposition_type" name="disposition_status">
	    <div class="modal-body">
            <div class="panel panel-default">
                <div class="panel-heading">Sent Details:</div>
                <div class="panel-body">
					<div class="row">
						<div class="col-sm-12">
							<input class="form-control" type="text" id="pkid" name = "pkid" style = "display:none;">		
						</div>
					</div>
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
			<div class="panel panel-success" id="container_sa_disposition">
                <div class="panel-heading">YEC Disposition</div>
                <div class="panel-body">
                    <div class="row">        
                        <div class="col-sm-3">
                            <label class="fa fa-md">Status: </label>
                        </div>
                        <div class="col-sm-9">
                            <select class="form-control" id="status" name="status" required>
								<option value="" selected disabled>-Select Status-</option>
								<option value="APPROVED">APPROVED</option>
								<option value="DISAPPROVED">DISAPPROVED</option>
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
                            <input type="file" class="form-control" id="treatment_file" name="treatment_file" data="Click to choose file." style="width:100%;display:inline-block;" required>
						</div>
                    </div>
                    <div class="row">
                        <div class="col-sm-3">
                            <label class="fa fa-md">Disposition: </label>
                        </div>
                        <div class="col-sm-9">
							<select class="form-control"  name="disposition" id="disposition" required>
								<!-- 
								<option value="OK,PONO">OK,SPECIFIC PO# ONLY</option>
								<option value="OK,LOTQTY">OK, SPECIFIC LOT# OR QTY ONLY</option>
								<option value="OTHERS">OTHERS,PLEASE SPECIFY</option>
								<option value="OK,ALL INCOMING PO"></option>
								<option value="OK,SPECIFIC PO# ONLY"></option>
								<option value="OK, SPECIFIC LOT# OR QTY ONLY"></option>
								<option value="OTHERS,PLEASE SPECIFY"></option> -->
							</select>
                            <textarea class="form-control" style="width:100%; display:none;" rows="3" id="disposition_remarks" name="disposition_remarks" ></textarea>
                        </div>
                    </div>
                </div>
            </div>
       </div>
	   <div class="modal-footer">
	   	<button type="submit" class="btn btn-info fa fa-save" id="btn_sa_submit_disposition"> Save</button>
		<button type="button" class="btn btn-default fa fa-close" data-dismiss="modal" id="btn_close"> Close</button>
	   </div>
      </form>
    </div><!-- /.modal-content -->    
  </div><!-- /.modal-dialog -->
</div><!-- /.modal -->

<div class="modal fade" tabindex="-1" role="dialog" id="modal_sa_edit_disposition">
  <div class="modal-dialog modal-md" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
        <h4 class="modal-title"><i class="fa fa-plus-circle"></i> Edit Disposition</h4>
      </div>
      <form id="frm_sa_edit_disposition" method="post" enctype="multipart/form-data">
        <input type="hidden" id="txt_hidden_disposition_type" name="disposition_status">
	    <div class="modal-body">
            <div class="panel panel-default">
                <div class="panel-heading">Sent Details:</div>
                <div class="panel-body">
					<div class="row">
						<div class="col-sm-12">
							<input class="form-control" type="text" id="pkid" name = "pkid" style = "display:none;">		
						</div>
					</div>
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
			<div class="panel panel-success" id="container_sa_disposition">
                <div class="panel-heading">YEC Disposition</div>
                <div class="panel-body">
                    <div class="row">        
                        <div class="col-sm-3">
                            <label class="fa fa-md">Status: </label>
                        </div>
                        <div class="col-sm-9">
                            <select class="form-control" id="status" name="status" required>
								<option value="" selected disabled>-Select Status-</option>
								<option value="APPROVED">APPROVED</option>
								<option value="DISAPPROVED">DISAPPROVED</option>
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
                            <input type="file" class="form-control" id="treatment_file" name="treatment_file" data="Click to choose file." style="width:85%;display:inline-block;">
							<a class = "fa fa-paperclip" href="#" id = "fa_paperclip" style="width:13%;display:inline-block;"></a>
						</div>
					
                    </div>
                    <div class="row">
                        <div class="col-sm-3">
                            <label class="fa fa-md">Disposition: </label>
                        </div>
                        <div class="col-sm-9">
							<select class="form-control"  name="disposition" id="disposition" required>
							</select>
                            <textarea class="form-control" style="width:100%; display:none;" rows="3" id="disposition_remarks" name="disposition_remarks" ></textarea>
                        </div>
                    </div>
                </div>
            </div>
       </div>
	   <div class="modal-footer">
        <button type="submit" class="btn btn-info fa fa-save" id="btn_sa_submit_disposition"> Save</button>
		<button type="button" class="btn btn-default fa fa-close" data-dismiss="modal" id="btn_close"> Close</button>
	   </div>
      </form>
    </div><!-- /.modal-content -->    
  </div><!-- /.modal-dialog -->
</div><!-- /.modal -->

<!-- Modal for viewing attachment -->
<div class="modal fade" tabindex="-1" role="dialog" id="modal_attachment_viewer_sa">
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
				<table class="table table-striped table-bordered table-condensed" id="tbl_view_attachments_sa">
					<thead>
						<th>SAR Attachment (click to download the file)</th>
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
