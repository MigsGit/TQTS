<?php
/* Check if user access */
$qfr_8d_requestor_access 	    = array("create" => false, 
									"read" => false,
									"update" => false,
									"delete" => false
									);
$subsystem_code 			= "QFR";
$module 					= "8D Module";
foreach($user_role['subsystem_code'] as $key => $subsystem_code ){
	if($subsystem_code == $subsystem_code && $user_role['module'][$key] == $module){ 
		if ($user_role['create'][$key] == 1){
			$qfr_8d_requestor_access['create'] = true;
		}
		if ($user_role['read'][$key] == 1){
			$qfr_8d_requestor_access['read'] = true;
		}
		if ($user_role['update'][$key] == 1){
			$qfr_8d_requestor_access['update'] = true;
		}
		if ($user_role['delete'][$key] == 1){
			$qfr_8d_requestor_access['delete'] = true;
		}
	}
}

$qfr_8d_admin_access 	= array("create" => false, 
									"read" => false,
									"update" => false,
									"delete" => false
									);
$subsystem_code 			= "QFR";
$module 					= "8D Module (Admin)";
foreach($user_role['subsystem_code'] as $key => $subsystem_code ){
	if($subsystem_code == $subsystem_code && $user_role['module'][$key] == $module){ 
		if ($user_role['create'][$key] == 1){
			$qfr_8d_admin_access['create'] = true;
		}
		if ($user_role['read'][$key] == 1){
			$qfr_8d_admin_access['read'] = true;
		}
		if ($user_role['update'][$key] == 1){
			$qfr_8d_admin_access['update'] = true;
		}
		if ($user_role['delete'][$key] == 1){
			$qfr_8d_admin_access['delete'] = true;
		}
	}
}

?>

<div class="col-sm-12">
	<!-- Nav tabs -->
	<div class="">
		<ul class="nav nav-tabs" role="tablist">
			<?php 
				$class_active = "active";
				if($qfr_8d_requestor_access['read']){
					echo '<li role="presentation" class="'.$class_active.'"><a href="#raw_report" aria-controls="8d_report" role="tab" data-toggle="tab">8D Report</a></li>';
					$class_active = '';
				}
				if($qfr_8d_admin_access['read']){
					echo '<li role="presentation" class="'.$class_active.'"><a href="#final_report" aria-controls="8d_report" role="tab" data-toggle="tab">8D Report Final</a></li>';
					$class_active = '';
				}				
			?>
			
		</ul>
	</div>
</div>

<div class="tab-content">
	<?php
		$class_active = "active";
		if($qfr_8d_requestor_access['read']){
			echo '
				<div role="tabpanel" class="tab-pane '.$class_active.'" id="raw_report">
					<div class="col-sm-12">
						<div class="panel panel-info">
							<div class="panel-heading"><i class="fa fa-file fa-lg"> 8D</i></div>
							<div class="panel-body">
								<div class="row">
									<div class="col-sm-9">
										<!-- <button class="btn btn-default fa fa-search" id="btn_qfr_8d_search_main_raw"> Search</button> -->
									</div>';
									if($qfr_8d_requestor_access['create']) {
										echo
										'<div class="col-sm-3">
											<button class="btn btn-primary fa fa-plus pull-right" id="btn_add_8d"> New</button>
										</div>';
									}
								echo '
								</div><br />
								<div class="row">
									<div class="col-sm-12" style="overflow:auto;">
										<table class="table table-bordered table-condensed" id="tbl_8d">
											<thead>
												<tr>
													<th>Status</th>
													<th>PO Number</th>
													<th>Customer Name</th>
													<th>Defect Phenomenon</th>
													<th>Due Date</th>
													<th>8D Report File</th>
													<th>Rev #</th>
													<th>Approver</th>
													<th><span class="fa fa-cogs"></span></th>
												</tr>
											</thead>
											<tbody>
											</tbody>
										</table>
									</div>
								</div>
							</div>
						</div>
					</div>
				</div>';
				$class_active = '';
		}
		if($qfr_8d_admin_access['read']){
			echo '
				<div role="tabpanel" class="tab-pane '.$class_active.'" id="final_report">
					<div class="col-sm-12">
						<div class="panel panel-info">
							<div class="panel-heading"><i class="fa fa-file fa-lg"> 8D</i></div>
							<div class="panel-body">
								<div class="row">
									<div class="col-sm-9">
										<button class="btn btn-default fa fa-search" id="btn_qfr_8d_search_main_final"> Search</button>
									</div>
								</div><br />
								<div class="row">
									<div class="col-sm-12" style="overflow:auto;">
										<table class="table table-bordered table-condensed" id="tbl_8d_final">
											<thead>
												<tr>
													<th>Status</th>
													<th>PO Number</th>
													<th>Customer Name</th>
													<th>Defect Phenomenon</th>
													<th>Due Date</th>
													<th>8D Report File</th>
													<th>Rev #</th>
													<th>Approver</th>
													<th><span class="fa fa-cogs"></span></th>
												</tr>
											</thead>
											<tbody>
											</tbody>
										</table>
									</div>
								</div>
							</div>
						</div>
					</div>
				</div>
			';
			$class_active = '';
		}
	?>
</div>

<div class="modal" tabindex="-1" role="dialog" id="modal_8d" >
  <div class="modal-dialog modal-lg" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
        <h4 class="modal-title fa fa-plus">ADD 8D</h4>
      </div>
	  
      <div class="modal-body" style="overflow:inherit;">
	  <form id="frm_8d">
		<div class="profile-info-title h4">
			<span class="fa fa-info-circle"></span> 8D Information
		</div><br />		
		<div class="row">
			<div class="col-sm-12">
				<div class="alert alert-danger" style="display:none;" role="alert" id="container_message_8d">					
				</div>
			</div>	
		</div>
		<div class="row">
			<div class="col-sm-12">
				<div class="row">
					<div class="col-sm-2 col-sm-offset-6">
						<label class="control-label condensed"> Due Date: </label>
					</div>
					<div class="col-sm-4">
						<input type="date" class="form-control condensed" name="due_date" min="<?php echo date('Y-m-d'); ?>" autocomplete="off" required>
					</div>
				</div>
				<div class="row">
					<div class="col-sm-2">
						<label class="control-label condensed"> PO Number: </label>
					</div>
					<div class="col-sm-4">
						<input type="text" class="form-control condensed" name="po_number" list="list_po_num" autocomplete="off" required>
						<datalist id="list_po_num"></datalist>
					</div>
					<div class="col-sm-2">
						<label class="control-label condensed"> NG Quantity: </label>
					</div>
					<div class="col-sm-4">
						<input type="number" class="form-control condensed" name="ng_qty" autocomplete="off" required>
					</div>
					<div class="col-sm-2">
						<label class="control-label condensed"> Device Name: </label>
					</div>
					<div class="col-sm-4">
						<input type="text" class="form-control condensed" name="device_name" readonly autocomplete="off" required>
					</div>
					<div class="col-sm-2">
						<label class="control-label condensed"> Customer Name: </label>
					</div>
					<div class="col-sm-4">
						<input type="text" class="form-control condensed" name="customer_name" autocomplete="off" required>
					</div>
					<div class="col-sm-2">
						<label class="control-label condensed"> PO Quantity: </label>
					</div>
					<div class="col-sm-4">
						<input type="number" class="form-control condensed" name="po_qty" autocomplete="off" readonly required>
					</div>
					<div class="col-sm-2">
						<label class="control-label"> Defect Phenomenon: </label>
					</div>
					<div class="col-sm-4">
						<input type="text" class="form-control condensed" name="defect_phenomenon" autocomplete="off" required>
					</div>
				</div>
			</div>
		</div>
		<div class="row">
			<div class="col-sm-12">
				<div class="row">
					<div class="col-sm-2">
						<label class="control-label condensed"> Remarks: </label>
					</div>
					<div class="col-sm-10">
						<textarea class="form-control condensed" name="remarks"></textarea>
					</div>
				</div>
			</div>
		</div>
		<hr class="graph-orange" style="margin-top:0px;">
		<div class="profile-info-title h4">
			<span class="fa fa-upload"></span> Upload 8D File
		</div><br />
		<div class="row">
			<div class="col-sm-2">
				<label class="control-label condensed"> 8D report file</label>
			</div>
			<div class="col-sm-4">
				<!-- <input type="file" class="form-control condensed" name="file_8d[]" multiple="multiple" autocomplete="off" required> -->
				<input type="file" class="form-control condensed" name="file_8d" autocomplete="off" required>
			</div>
		</div>
		<hr class="graph-blue">
		<div class="profile-info-title h4">
			<span class="fa fa-users"></span> Approvers
		</div><br />
		<div class="row">
			<div class="col-sm-2">
				<label class="control-label condensed"> Approver</label>
			</div>
			<div class="col-sm-10">
				<select class="chosen-select" multiple name="approver" id="approver_new">
				</select>
			</div>
		</div>
      </div>
      <div class="modal-footer">
        <button type="submit" class="btn btn-primary fa fa-save"> Save</button>
        <button type="button" class="btn btn-default fa fa-close" data-dismiss="modal"> Close</button>
      </div>
	  </form>
    </div><!-- /.modal-content -->
  </div><!-- /.modal-dialog -->
</div><!-- /.modal -->

<div class="modal" tabindex="-1" role="dialog" id="modal_8d_edit">
  <div class="modal-dialog modal-lg" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
        <h4 class="modal-title fa fa-edit"> EDIT 8D</h4>
      </div>
	  
      <div class="modal-body" style="overflow:inherit;">
	  <form id="frm_8d_edit">
		<div class="profile-info-title h4">
			<span class="fa fa-info-circle"></span> 8D Information
		</div><br />		
		<div class="row">
			<div class="col-sm-12">
				<div class="alert alert-danger" style="display:none;" role="alert" id="container_message_8d">					
				</div>
			</div>	
		</div>
		<div class="row">
			<div class="col-sm-12">
				<div class="row">
					<div class="col-sm-2 col-sm-offset-6">
						<label class="control-label condensed"> Due Date: </label>
					</div>
					<div class="col-sm-4">
						<input type="date" class="form-control condensed" name="due_date" autocomplete="off" required>
					</div>
				</div>
				<div class="row">
					<div class="col-sm-2">
						<label class="control-label condensed"> PO Number: </label>
					</div>
					<div class="col-sm-4">
						<input type="text" class="form-control condensed" name="po_number" list="list_po_num" autocomplete="off">
						<datalist id="list_po_num"></datalist>
					</div>
					<div class="col-sm-2">
						<label class="control-label condensed"> NG Quantity: </label>
					</div>
					<div class="col-sm-4">
						<input type="number" class="form-control condensed" name="ng_qty" autocomplete="off" required>
					</div>
					<div class="col-sm-2">
						<label class="control-label condensed"> Device Name: </label>
					</div>
					<div class="col-sm-4">
						<input type="text" class="form-control condensed" name="device_name" readonly autocomplete="off" required>
					</div>
					<div class="col-sm-2">
						<label class="control-label condensed"> Customer Name: </label>
					</div>
					<div class="col-sm-4">
						<input type="text" class="form-control condensed" name="customer_name" autocomplete="off" required>
					</div>
					<div class="col-sm-2">
						<label class="control-label condensed"> PO Quantity: </label>
					</div>
					<div class="col-sm-4">
						<input type="number" class="form-control condensed" name="po_qty" autocomplete="off" readonly required>
					</div>
					<div class="col-sm-2">
						<label class="control-label"> Defect Phenomenon: </label>
					</div>
					<div class="col-sm-4">
						<input type="text" class="form-control condensed" name="defect_phenomenon" autocomplete="off" required>
					</div>
				</div>
			</div>
		</div>
		<div class="row">
			<div class="col-sm-12">
				<div class="row">
					<div class="col-sm-2">
						<label class="control-label condensed"> Remarks: </label>
					</div>
					<div class="col-sm-10">
						<textarea class="form-control condensed" name="remarks"></textarea>
					</div>
				</div>
				<div class="row">
					<div class="col-sm-2">
						<label class="control-label condensed"> 8D report file</label>
					</div>
					<div class="col-sm-4">
						<button type="button" class="btn btn-link fa fa-paperclip"> View Attachment/s</button>
					</div>
					<div class="col-sm-2">
						<label class="control-label condensed"> Current Rev. #:</label>
					</div>
					<div class="col-sm-4">
						<input type="text" class="form-control condensed" name="rev_no" readonly>
					</div>
				</div>
			</div>
		</div>
		<hr class="graph-orange" style="margin-top:0px;">
		<div class="profile-info-title h4">
			<span class="fa fa-upload"></span> Re-upload 8D File
		</div><br />
		<div class="row">
			<div class="col-sm-12">
				<label class="control-label condensed" style="color:red;"> *Note: Re-uploading of file will reset the approval process.</label>
			</div>
			<div class="col-sm-2">
				<label class="control-label condensed"> 8D report file</label>
			</div>
			<div class="col-sm-4">
				<!-- <input type="file" class="form-control condensed" name="file_8d[]" multiple="multiple" autocomplete="off"> -->
				<input type="file" class="form-control condensed" name="file_8d" autocomplete="off">
			</div>
		</div>
		<hr class="graph-blue">
		<div class="profile-info-title h4">
			<span class="fa fa-users"></span> Approvers
		</div><br />
		<div class="row">
			<div class="col-sm-2">
				<label class="control-label condensed"> Approver</label>
			</div>
			<div class="col-sm-10">
				<select class="chosen-select" multiple name="approver" id="approver_edit">
				</select>
			</div>
		</div>
      </div>
      <div class="modal-footer">
        <button type="submit" class="btn btn-primary fa fa-save"> Save</button>
	  </form>
        <button type="button" class="btn btn-default fa fa-close" data-dismiss="modal"> Close</button>
      </div>
    </div><!-- /.modal-content -->
  </div><!-- /.modal-dialog -->
</div><!-- /.modal -->

<div class="modal" tabindex="-1" role="dialog" id="modal_8d_edit_approver">
  <div class="modal-dialog modal-lg" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
        <h4 class="modal-title fa fa-commenting-o"> ADD 8D REPORT COMMENT</h4>
      </div>
	  
      <div class="modal-body" style="">
	  <form id="frm_8d_edit_approver">
		<div class="profile-info-title h4">
			<span class="fa fa-info-circle"></span> 8D Information
		</div><br />		
		<div class="row">
			<div class="col-sm-12">
				<div class="alert alert-danger" style="display:none;" role="alert" id="container_message_8d">					
				</div>
			</div>	
		</div>
		<div class="row">
			<div class="col-sm-12">
				<div class="row">
					<div class="col-sm-2">
						<label class="control-label condensed"> PO Number: </label>
					</div>
					<div class="col-sm-4">
						<input type="text" class="form-control condensed" name="po_number" list="list_po_num" autocomplete="off">
						<datalist id="list_po_num"></datalist>
					</div>
					<div class="col-sm-2">
						<label class="control-label condensed"> Customer Name: </label>
					</div>
					<div class="col-sm-4">
						<input type="text" class="form-control condensed" name="customer_name" autocomplete="off">
					</div>
				</div>
			</div>
		</div>
		<div class="row">
			<div class="col-sm-12">
				<div class="row">
					<div class="col-sm-2">
						<label class="control-label"> Defect Phenomenon: </label>
					</div>
					<div class="col-sm-4">
						<input type="text" class="form-control condensed" name="defect_phenomenon" autocomplete="off">
					</div>
					<div class="col-sm-2">
						<label class="control-label condensed"> Due Date: </label>
					</div>
					<div class="col-sm-4">
						<input type="date" class="form-control condensed" name="due_date" autocomplete="off">
					</div>
				</div>
				<div class="row">
					<div class="col-sm-2">
						<label class="control-label condensed"> Remarks: </label>
					</div>
					<div class="col-sm-10">
						<textarea class="form-control condensed" name="remarks"></textarea>
					</div>
				</div>
				<div class="row">
					<div class="col-sm-2">
						<label class="control-label condensed"> 8D report file</label>
					</div>
					<div class="col-sm-4">
						<button type="button" class="btn btn-link fa fa-paperclip"> View Attachment/s</button>
					</div>
				</div>
			</div>
		</div>
		<hr class="graph-blue">
		<div class="profile-info-title h4">
			<span class="fa fa-users"></span> Approvers
		</div><br />
		<div class="row">
			<div class="col-sm-12" style="padding-top:5px;">
				<table class="table table-striped table-bordered table-condensed" id="tbl_approver_8d_edit_approver">
					<thead>
						<th style="width:10%"><center>Status</center></th>
						<th style="width:10%"><center>Rev #</center></th>
						<th style="width:30%"><center>Approver Name</center></th>
						<th style="width:40%"><center>Approver's Comment/s</center></th>
						<th style="width:40%"><center>Approver's Log</center></th>
					</thead>
					<tbody>
					</tbody>
				</table>
			</div>
		</div>	
		<div id="container_approver_section" >
			<hr class="graph-orange" style="margin-top:0px;">
			<div class="row" id="container_as_chk">
				<div class="col-sm-9">
					<label class="fa fa-md"><input type="checkbox" id="chk_recomment"> Resend comment: </label>
				</div>
				<div class="col-sm-3">
					<button type="button" class="btn btn-danger fa fa-remove"> Remove Attachment</button>
				</div>
			</div>
			<div class="profile-info-title h4">
				<span class="fa fa-upload"></span> Approver Comment/s
			</div><br />
			<div class="row">
				<div class="col-sm-2">
					<label class="control-label condensed"> 8D report file with Correction</label>
				</div>
				<div class="col-sm-4">
					<input type="file" class="form-control condensed" name="file_8d" id="file_8d" autocomplete="off">
				</div>
			</div>		
			<div class="row">
				<div class="col-sm-2">
					<label class="control-label condensed"> Comment/s: </label>
				</div>
				<div class="col-sm-10">
					<textarea class="form-control condensed" name="approver_comment"></textarea>
				</div>
			</div>	
		</div>	
		<div class="modal-footer">
			<button type="submit" class="btn btn-info fa fa-send-o"> Send Comment</button>
			<button type="button" class="btn btn-default fa fa-close" data-dismiss="modal"> Close</button>
		</div>
	  </form>
      </div>
    </div><!-- /.modal-content -->
  </div><!-- /.modal-dialog -->
</div><!-- /.modal -->

<div class="modal" tabindex="-1" role="dialog" id="modal_8d_edit_requestor">
  <div class="modal-dialog modal-lg" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
        <h4 class="modal-title fa fa-upload"> UPLOAD FINAL 8D REPORT</h4>
      </div>
	  
      <div class="modal-body" style="">
	  <form id="frm_8d_edit_requestor">
		<div class="profile-info-title h4">
			<span class="fa fa-info-circle"></span> 8D Information
		</div><br />		
		<div class="row">
			<div class="col-sm-12">
				<div class="alert alert-danger" style="display:none;" role="alert" id="container_message_8d">					
				</div>
			</div>	
		</div>
		<div class="row">
			<div class="col-sm-12">
				<div class="row">
					<div class="col-sm-2">
						<label class="control-label condensed"> PO Number: </label>
					</div>
					<div class="col-sm-4">
						<input type="text" class="form-control condensed" name="po_number" list="list_po_num" autocomplete="off">
						<datalist id="list_po_num"></datalist>
					</div>
					<div class="col-sm-2">
						<label class="control-label condensed"> Customer Name: </label>
					</div>
					<div class="col-sm-4">
						<input type="text" class="form-control condensed" name="customer_name" autocomplete="off">
					</div>
				</div>
			</div>
		</div>
		<div class="row">
			<div class="col-sm-12">
				<div class="row">
					<div class="col-sm-2">
						<label class="control-label"> Defect Phenomenon: </label>
					</div>
					<div class="col-sm-4">
						<input type="text" class="form-control condensed" name="defect_phenomenon" autocomplete="off">
					</div>
					<div class="col-sm-2">
						<label class="control-label condensed"> Due Date: </label>
					</div>
					<div class="col-sm-4">
						<input type="date" class="form-control condensed" name="due_date" autocomplete="off">
					</div>
				</div>
				<div class="row">
					<div class="col-sm-2">
						<label class="control-label condensed"> Remarks: </label>
					</div>
					<div class="col-sm-10">
						<textarea class="form-control condensed" name="remarks"></textarea>
					</div>
				</div>
				<div class="row">
					<div class="col-sm-2">
						<label class="control-label condensed"> 8D report file</label>
					</div>
					<div class="col-sm-4">
						<button type="button" class="btn btn-link fa fa-paperclip"> View Attachment/s</button>
					</div>
				</div>
			</div>
		</div>
		<hr class="graph-blue">
		<div class="profile-info-title h4">
			<span class="fa fa-users"></span> Approvers
		</div><br />
		<div class="row">
			<div class="col-sm-12" style="padding-top:5px;">
				<table class="table table-striped table-bordered table-condensed" id="tbl_approver_8d_edit_requestor">
					<thead>
						<th style="width:10%"><center>Status</center></th>
						<th style="width:10%"><center>Rev #</center></th>
						<th style="width:30%"><center>Approver Name</center></th>
						<th style="width:40%"><center>Approver's Comment/s</center></th>
						<th style="width:40%"><center>Approver's Log</center></th>
					</thead>
					<tbody>
					</tbody>
				</table>
			</div>
		</div>	
		<div>
			<hr class="graph-orange" style="margin-top:0px;">
			<div class="row" id="container_as_chk">
				<div class="col-sm-12">
					<label class="fa fa-md"><input type="checkbox" id="chk_recomment"> Resend Final 8D Attachment: </label>
				</div>
			</div>
			<div class="profile-info-title h4">
				<span class="fa fa-upload"></span> Final 8D Attachment
			</div><br />
			<div class="row">
				<div class="col-sm-2">
					<label class="control-label condensed"> 8D report file</label>
				</div>
				<div class="col-sm-4">
					<input type="file" class="form-control condensed" name="file_8d" accept="" autocomplete="off" required>
				</div>
			</div>		
			<div class="row">
				<div class="col-sm-2">
					<label class="control-label condensed"> Remarks: </label>
				</div>
				<div class="col-sm-10">
					<textarea class="form-control condensed" name="final_remarks"></textarea>
				</div>
			</div>	
		</div>	
		<div class="modal-footer">
			<button type="submit" class="btn btn-info fa fa-upload"> Upload Final Report</button>
			<button type="button" class="btn btn-default fa fa-close" data-dismiss="modal"> Close</button>
		</div>
	  </form>
      </div>
    </div><!-- /.modal-content -->
  </div><!-- /.modal-dialog -->
</div><!-- /.modal -->

<div class="modal" tabindex="-1" role="dialog" id="modal_8d_view">
  <div class="modal-dialog modal-lg" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
        <h4 class="modal-title fa fa-eye"> VIEW 8D</h4>
      </div>
	  
      <div class="modal-body" style="">
	  <form id="frm_8d_view">
		<div class="profile-info-title h4">
			<span class="fa fa-info-circle"></span> 8D Information
		</div><br />		
		<div class="row">
			<div class="col-sm-12">
				<div class="alert alert-danger" style="display:none;" role="alert" id="container_message_8d">					
				</div>
			</div>	
		</div>
		<div class="row">
			<div class="col-sm-12">
				<div class="row">
					<div class="col-sm-2 col-sm-offset-6">
						<label class="control-label condensed"> Due Date: </label>
					</div>
					<div class="col-sm-4">
						<input type="date" class="form-control condensed" name="due_date" autocomplete="off" required>
					</div>
				</div>
				<div class="row">
					<div class="col-sm-2">
						<label class="control-label condensed"> PO Number: </label>
					</div>
					<div class="col-sm-4">
						<input type="text" class="form-control condensed" name="po_number" list="list_po_num" autocomplete="off">
						<datalist id="list_po_num"></datalist>
					</div>
					<div class="col-sm-2">
						<label class="control-label condensed"> NG Quantity: </label>
					</div>
					<div class="col-sm-4">
						<input type="number" class="form-control condensed" name="ng_qty" autocomplete="off" required>
					</div>
					<div class="col-sm-2">
						<label class="control-label condensed"> Device Name: </label>
					</div>
					<div class="col-sm-4">
						<input type="text" class="form-control condensed" name="device_name" readonly autocomplete="off" required>
					</div>
					<div class="col-sm-2">
						<label class="control-label condensed"> Customer Name: </label>
					</div>
					<div class="col-sm-4">
						<input type="text" class="form-control condensed" name="customer_name" autocomplete="off" required>
					</div>
					<div class="col-sm-2">
						<label class="control-label condensed"> PO Quantity: </label>
					</div>
					<div class="col-sm-4">
						<input type="number" class="form-control condensed" name="po_qty" autocomplete="off" readonly required>
					</div>
					<div class="col-sm-2">
						<label class="control-label"> Defect Phenomenon: </label>
					</div>
					<div class="col-sm-4">
						<input type="text" class="form-control condensed" name="defect_phenomenon" autocomplete="off" required>
					</div>
				</div>
			</div>
		</div>
		<div class="row">
			<div class="col-sm-12">
				<div class="row">
					<div class="col-sm-2">
						<label class="control-label condensed"> Remarks: </label>
					</div>
					<div class="col-sm-10">
						<textarea class="form-control condensed" name="remarks"></textarea>
					</div>
				</div>
				<div class="row">
					<div class="col-sm-2">
						<label class="control-label condensed"> 8D report file</label>
					</div>
					<div class="col-sm-4">
						<button type="button" class="btn btn-link fa fa-paperclip"> View Attachment/s</button>
					</div>
					<div class="col-sm-2">
						<label class="control-label condensed"> Current Rev. #:</label>
					</div>
					<div class="col-sm-4">
						<input type="text" class="form-control condensed" name="rev_no" readonly>
					</div>
				</div>
			</div>
		</div>
		<hr class="graph-blue">
		<div class="profile-info-title h4">
			<span class="fa fa-users"></span> Approvers
		</div><br />
		<div class="row">
			<div class="col-sm-12" style="padding-top:5px;">
				<table class="table table-striped table-bordered table-condensed" id="tbl_approver_8d_view">
					<thead>
						<th style="width:10%"><center>Status</center></th>
						<th style="width:10%"><center>Rev #</center></th>
						<th style="width:30%"><center>Approver Name</center></th>
						<th style="width:40%"><center>Approver's Comment/s</center></th>
						<th style="width:40%"><center>Approver's Log</center></th>
					</thead>
					<tbody>
					</tbody>
				</table>
			</div>
		</div>	
		
		<div class="modal-footer">
			<!-- <button type="submit" class="btn btn-info fa fa-send-o"> Send Comment</button> -->
			<button type="button" class="btn btn-default fa fa-close" data-dismiss="modal"> Close</button>
		</div>
	  </form>
      </div>
    </div><!-- /.modal-content -->
  </div><!-- /.modal-dialog -->
</div><!-- /.modal -->

<div class="modal" tabindex="-1" role="dialog" id="modal_8d_admin_email_edit">
  <div class="modal-dialog modal-lg" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
        <h4 class="modal-title fa fa-edit"> CLOSE FINAL 8D REPORT</h4>
      </div>
	  
      <div class="modal-body" style="">
	  <form id="frm_8d_admin_email_edit">
		<div class="profile-info-title h4">
			<span class="fa fa-info-circle"></span> 8D Information
		</div><br />		
		<div class="row">
			<div class="col-sm-12">
				<div class="alert alert-danger" style="display:none;" role="alert" id="container_message_8d">					
				</div>
			</div>	
		</div>
		<div class="row">
			<div class="col-sm-12">
				<div class="row">
					<div class="col-sm-2">
						<label class="control-label condensed"> PO Number: </label>
					</div>
					<div class="col-sm-4">
						<input type="text" class="form-control condensed" name="po_number" list="list_po_num" autocomplete="off">
						<datalist id="list_po_num"></datalist>
					</div>
					<div class="col-sm-2">
						<label class="control-label condensed"> Customer Name: </label>
					</div>
					<div class="col-sm-4">
						<input type="text" class="form-control condensed" name="customer_name" autocomplete="off">
					</div>
				</div>
			</div>
		</div>
		<div class="row">
			<div class="col-sm-12">
				<div class="row">
					<div class="col-sm-2">
						<label class="control-label"> Defect Phenomenon: </label>
					</div>
					<div class="col-sm-4">
						<input type="text" class="form-control condensed" name="defect_phenomenon" autocomplete="off">
					</div>
					<div class="col-sm-2">
						<label class="control-label condensed"> Due Date: </label>
					</div>
					<div class="col-sm-4">
						<input type="date" class="form-control condensed" name="due_date" autocomplete="off">
					</div>
				</div>
				<div class="row">
					<div class="col-sm-2">
						<label class="control-label condensed"> Remarks: </label>
					</div>
					<div class="col-sm-10">
						<textarea class="form-control condensed" name="remarks"></textarea>
					</div>
				</div>
				<div class="row">
					<div class="col-sm-2">
						<label class="control-label condensed"> 8D report file</label>
					</div>
					<div class="col-sm-4">
						<button type="button" class="btn btn-link fa fa-paperclip"> Download Attachment</button>
					</div>
				</div>
			</div>
		</div>
		<hr class="graph-blue">
		<div class="profile-info-title h4">
			<span class="fa fa-users"></span> Email Content
		</div><br />	
		<div class="row">
			<div class="col-sm-2">
				<label class="control-label condensed"> To: </label>
			</div>
			<div class="col-sm-10">
				<select class="chosen-select" multiple name="to_recipient" id="cmb_8d_send_to"></select>
			</div>
		</div>
		<div class="row" style="margin-top:3px;">
			<div class="col-sm-2">
				<label class="control-label condensed"> Cc: </label>
			</div>
			<div class="col-sm-10">
				<select class="chosen-select" multiple name="to_recipient" id="cmb_8d_send_cc"></select>
			</div>
		</div>
		<div class="row" style="margin-top:3px;">
			<div class="col-sm-2">
				<label class="control-label condensed"> Subject: </label>
			</div>
			<div class="col-sm-10">
				<input type="text" class="form-control condensed" name="subject" autocomplete="off" required>
			</div>
			<div class="col-sm-2">
				<label class="control-label condensed"> Body: </label>
			</div>
			<div class="col-sm-10">
				<textarea class="form-control condensed" name="body" required></textarea>
			</div>
		</div>
		<div id="div_admin_reupload">
			<hr class="graph-orange" style="margin-top:0px;">
			<div class="row">
				<div class="col-sm-12">
					<label class="fa fa-md"><input type="checkbox" id="chk_replace"> Replace Final 8D Attachment: </label>
				</div>
			</div>
			<div class="profile-info-title h4">
				<span class="fa fa-upload"></span> Final 8D Attachment
			</div><br />
			<div class="row">
				<div class="col-sm-2">
					<label class="control-label condensed"> 8D report file</label>
				</div>
				<div class="col-sm-4">
					<input type="file" class="form-control condensed" name="file_8d" accept="" autocomplete="off">
				</div>
			</div>		
		</div>	
		<div class="modal-footer">
			<button type="submit" class="btn btn-info fa fa-send-o"> Send Final Report</button>
			<button type="button" class="btn btn-default fa fa-close" data-dismiss="modal"> Close</button>
		</div>
	  </form>
      </div>
    </div><!-- /.modal-content -->
  </div><!-- /.modal-dialog -->
</div><!-- /.modal -->

<div class="modal" tabindex="-1" role="dialog" id="modal_8d_admin_edit">
  <div class="modal-dialog modal-lg" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
        <h4 class="modal-title fa fa-window-restore"> CLOSE FINAL 8D REPORT</h4>
      </div>
	  
      <div class="modal-body" style="">
	  <form id="frm_8d_admin_edit">
		<div class="profile-info-title h4">
			<span class="fa fa-info-circle"></span> 8D Information
		</div><br />		
		<div class="row">
			<div class="col-sm-12">
				<div class="alert alert-danger" style="display:none;" role="alert" id="container_message_8d">					
				</div>
			</div>	
		</div>
		<div class="row">
			<div class="col-sm-12">
				<div class="row">
					<div class="col-sm-2">
						<label class="control-label condensed"> PO Number: </label>
					</div>
					<div class="col-sm-4">
						<input type="text" class="form-control condensed" name="po_number" list="list_po_num" autocomplete="off">
						<datalist id="list_po_num"></datalist>
					</div>
					<div class="col-sm-2">
						<label class="control-label condensed"> Customer Name: </label>
					</div>
					<div class="col-sm-4">
						<input type="text" class="form-control condensed" name="customer_name" autocomplete="off">
					</div>
				</div>
			</div>
		</div>
		<div class="row">
			<div class="col-sm-12">
				<div class="row">
					<div class="col-sm-2">
						<label class="control-label"> Defect Phenomenon: </label>
					</div>
					<div class="col-sm-4">
						<input type="text" class="form-control condensed" name="defect_phenomenon" autocomplete="off">
					</div>
					<div class="col-sm-2">
						<label class="control-label condensed"> Due Date: </label>
					</div>
					<div class="col-sm-4">
						<input type="date" class="form-control condensed" name="due_date" autocomplete="off">
					</div>
				</div>
				<div class="row">
					<div class="col-sm-2">
						<label class="control-label condensed"> Remarks: </label>
					</div>
					<div class="col-sm-10">
						<textarea class="form-control condensed" name="remarks"></textarea>
					</div>
				</div>
				<div class="row">
					<div class="col-sm-2">
						<label class="control-label condensed"> 8D report file</label>
					</div>
					<div class="col-sm-4">
						<button type="button" class="btn btn-link fa fa-paperclip"> Download Attachment</button>
					</div>
				</div>
			</div>
		</div>
		<div id="div_admin_reupload2">
			<hr class="graph-orange" style="margin-top:0px;">
			<div class="row">
				<div class="col-sm-12">
					<label class="fa fa-md"><input type="checkbox" id="chk_replace"> Replace Final 8D Attachment: </label>
				</div>
			</div>
			<div class="profile-info-title h4">
				<span class="fa fa-upload"></span> Final 8D Attachment
			</div><br />
			<div class="row">
				<div class="col-sm-2">
					<label class="control-label condensed"> 8D report file</label>
				</div>
				<div class="col-sm-4">
					<input type="file" class="form-control condensed" name="file_8d" accept="" autocomplete="off">
				</div>
			</div>		
		</div>	
		<div class="modal-footer">
			<button type="submit" class="btn btn-info fa fa-save"> Save</button>
			<button type="button" class="btn btn-default fa fa-close" data-dismiss="modal"> Close</button>
		</div>
	  </form>
      </div>
    </div><!-- /.modal-content -->
  </div><!-- /.modal-dialog -->
</div><!-- /.modal -->

<div class="modal" tabindex="-1" role="dialog" id="modal_8d_admin_view">
  <div class="modal-dialog modal-lg" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
        <h4 class="modal-title fa fa-eye"> VIEW FINAL 8D REPORT</h4>
      </div>
	  
      <div class="modal-body" style="">
	  <form id="frm_8d_admin_view">
		<div class="profile-info-title h4">
			<span class="fa fa-info-circle"></span> 8D Information
		</div><br />		
		<div class="row">
			<div class="col-sm-12">
				<div class="alert alert-danger" style="display:none;" role="alert" id="container_message_8d">					
				</div>
			</div>	
		</div>
		<div class="row">
			<div class="col-sm-12">
				<div class="row">
					<div class="col-sm-2">
						<label class="control-label condensed"> PO Number: </label>
					</div>
					<div class="col-sm-4">
						<input type="text" class="form-control condensed" name="po_number" list="list_po_num" autocomplete="off">
						<datalist id="list_po_num"></datalist>
					</div>
					<div class="col-sm-2">
						<label class="control-label condensed"> Customer Name: </label>
					</div>
					<div class="col-sm-4">
						<input type="text" class="form-control condensed" name="customer_name" autocomplete="off">
					</div>
				</div>
			</div>
		</div>
		<div class="row">
			<div class="col-sm-12">
				<div class="row">
					<div class="col-sm-2">
						<label class="control-label"> Defect Phenomenon: </label>
					</div>
					<div class="col-sm-4">
						<input type="text" class="form-control condensed" name="defect_phenomenon" autocomplete="off">
					</div>
					<div class="col-sm-2">
						<label class="control-label condensed"> Due Date: </label>
					</div>
					<div class="col-sm-4">
						<input type="date" class="form-control condensed" name="due_date" autocomplete="off">
					</div>
				</div>
				<div class="row">
					<div class="col-sm-2">
						<label class="control-label condensed"> Remarks: </label>
					</div>
					<div class="col-sm-10">
						<textarea class="form-control condensed" name="remarks"></textarea>
					</div>
				</div>
				<div class="row">
					<div class="col-sm-2">
						<label class="control-label condensed"> 8D report file</label>
					</div>
					<div class="col-sm-4">
						<button type="button" class="btn btn-link fa fa-paperclip"> Download Attachment</button>
					</div>
				</div>
			</div>
		</div>
		<hr class="graph-blue">
		<div class="profile-info-title h4">
			<span class="fa fa-users"></span> Approvers
		</div><br />
		<div class="row">
			<div class="col-sm-12" style="padding-top:5px;">
				<table class="table table-striped table-bordered table-condensed" id="tbl_approver_8d_admin_view">
					<thead>
						<th style="width:10%"><center>Status</center></th>
						<th style="width:10%"><center>Rev #</center></th>
						<th style="width:30%"><center>Approver Name</center></th>
						<th style="width:40%"><center>Approver's Comment/s</center></th>
						<th style="width:40%"><center>Approver's Log</center></th>
					</thead>
					<tbody>
					</tbody>
				</table>
			</div>
		</div>	
		<div class="modal-footer">
			<button type="button" class="btn btn-default fa fa-close" data-dismiss="modal"> Close</button>
		</div>
	  </form>
      </div>
    </div><!-- /.modal-content -->
  </div><!-- /.modal-dialog -->
</div><!-- /.modal -->

<div class="modal" tabindex="-1" role="dialog" id="modal_8d_cancel">
  <div class="modal-dialog modal-lg" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
        <h4 class="modal-title fa fa-plus">Cancel Quality Complaint Feedback Report (8D)</h4>
      </div>
      <div class="modal-body">
		<form id="frm_8d_cancel">
			<div class="row" id="container_8d_upload_message">
				<div class="col-sm-12">
					<div class="alert alert-info">Data extracted from <span id="span_file_name"></span></div>
				</div>
			</div>
			<div class="row">
				<div class="col-sm-2 col-sm-offset-6">
					<label class="control-label condensed">8D No.:</label>
				</div>
				<div class="col-sm-4">
					<input type="text" class="form-control condensed" name="8D_no" readonly>
				</div>
			</div>
			<div class="row">
				<div class="col-sm-12">
					<div class="row">
						<div class="col-sm-2">
							<label class="control-label condensed"> Product Name</label>
						</div>
						<div class="col-sm-4">
							<input type="text" class="form-control condensed" name="product_name" readonly>
						</div>
						<div class="col-sm-2">
							<label class="control-label condensed"> Model No.</label>
						</div>
						<div class="col-sm-4">
							<input type="text" class="form-control condensed" name="model_no" readonly>
						</div>
					</div>
				</div>
			</div>
			<div class="row">
				<div class="col-sm-12">
					<div class="row">
						<div class="col-sm-2">
							<label class="control-label condensed"> Batch No./Lot No.</label>
						</div>
						<div class="col-sm-4">
							<input type="text" class="form-control condensed" name="batch_no_lot_no" readonly>
						</div>
						<div class="col-sm-2">
							<label class="control-label condensed"> P.O. No./ INV. No.</label>
						</div>
						<div class="col-sm-4">
							<input type="text" class="form-control condensed" name="po_no_inv_no" readonly>
						</div>
					</div>
				</div>
			</div>
			<div class="row">
				<div class="col-sm-2">
					<label class="control-label condensed"> Date Received</label>
				</div>
				<div class="col-sm-4">
					<input type="text" class="form-control condensed" name="date_received" readonly>
				</div>
			</div>
      </div>
	  <div class="modal-footer">
        <button type="submit" class="btn btn-danger fa fa-save"> Cancel</button>
        <button type="button" class="btn btn-default fa fa-close" data-dismiss="modal"> Close</button>
      </div>
		</form>
    </div><!-- /.modal-content -->
  </div><!-- /.modal-dialog -->
</div><!-- /.modal -->

<div class="modal fade" tabindex="-1" role="dialog" id="modal_approver_8d_message">
  <div class="modal-dialog modal-md" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
        <h4 class="modal-title"><i class="fa fa-question-circle-o"></i> System Confirmation</h4>
      </div>
	  <form id="frm_8d_approvers_decision">
		  <div class="modal-body">
			<div class="row">			
				<div class="col-sm-12" id="">				
					<div class="alert alert-success" role="alert" id="container_8d_approver_message">					
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

<!-- Modal for viewing attachment -->
<div class="modal fade" tabindex="-1" role="dialog" id="modal_8d_attachment_viewer" style="z-index:1051">
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
				<table class="table table-striped table-bordered table-condensed" id="tbl_view_attachments">
					<thead>
						<th>Rev #</th>
						<th>File Name (click to download the file)</th>
						<th>Remarks</th>
						<th><center>Remove</center></th>
					</thead>
					<tbody>
					</tbody>
				</table>
			</div>
		</div>
		<div class="row" id="container_final_attachment">
			<div class="col-sm-4">
				<label class="control-label condensed"> Final Attachment</label>
			</div>
			<div class="col-sm-8">
				<button type="button" class="btn btn-link fa fa-download"> Download attachment</button>
			</div>
		</div>
	  </div>
	  <div class="modal-footer">
		<button type="button" class="btn btn-default fa fa-close" data-dismiss="modal"> Close</button>
	  </div>
    </div><!-- /.modal-content -->
  </div><!-- /.modal-dialog -->
</div><!-- /.modal -->

<!-- Modal for system message -->
<div class="modal fade" tabindex="-1" role="dialog" id="modal_remove_attachment_confirmation">
  <div class="modal-dialog modal-md" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
        <h4 class="modal-title"><i class="fa fa-question-circle-o"></i> System Confirmation</h4>
      </div>
	  <form id="frm_remove_attachment">
		  <div class="modal-body">
			<div class="row">
				<div class="col-sm-12" id="">				
					<div class="alert alert-danger" role="alert" id="">
						<h4>Are you sure you want to delete the document? <br> *Document will permanently be deleted to server.</h4>
					</div>
				</div>
			</div>
			<div class="row" id="">
				<div class="col-sm-12" id="">				
					<label>If yes, please write the reason:</label>
				</div>
				<div class="col-sm-12">				
					<textarea id="reason" name="reason" style="width:100%;" required></textarea>
				</div>
			</div>
		  </div>
		  <div class="modal-footer">
			<button type="submit" class="btn btn-primary fa fa-trash" id="btn_yes_remove_attachment"> Yes</button>
			<button type="button" class="btn btn-default fa fa-close" data-dismiss="modal" id="btn_close"> Close</button>
		  </div>
		</form>
    </div><!-- /.modal-content -->
  </div><!-- /.modal-dialog -->
</div><!-- /.modal -->

<!-- Modal for system message -->
<div class="modal" tabindex="-1" role="dialog" id="modal_8d_system_message">
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


<!-- Modal for advanced search -->
<div class="modal" tabindex="-1" role="dialog" id="modal_qfr_8d_advance_search">
  <div class="modal-dialog modal-lg" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
        <h4 class="modal-title fa fa-search"> Advance Search</h4>
      </div>
	  <form id="frm_qfr_8d_advance_search">
      <div class="modal-body">
		<button type="button" class="btn btn-default fa pull-left fa fa-eraser" id="btn_dir_as_reset"> Reset Search Value</button>
		<button type="button" class="btn btn-primary fa pull-right fa fa-plus" id="btn_dir_as_add"> Add</button><br /><br />
		<table class="table" id="tbl_qfr_8d_advance_search">
			<tbody>
			</tbody>
		</table>
      </div>
      <div class="modal-footer">
        <button type="submit" class="btn btn-default fa fa-search"> Search</button>
        <button type="button" class="btn btn-default fa fa-close" data-dismiss="modal"> Close</button>
      </div>
	  </form>
    </div><!-- /.modal-content -->
  </div><!-- /.modal-dialog -->
</div><!-- /.modal -->
