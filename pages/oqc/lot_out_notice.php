<?php
/* get user role */
$lqc_inspector_oqc_lon_access 	    = array("create" => false, 
									"read" => false,
									"update" => false,
									"delete" => false
									);
$subsystem_code 			= "OQC";
$module 					= "Lot-out Notice-LQC Inspector";
foreach($user_role['subsystem_code'] as $key => $subsystem_code ){
	if($subsystem_code == $subsystem_code && $user_role['module'][$key] == $module){ 
		if ($user_role['create'][$key] == 1){
			$lqc_inspector_oqc_lon_access['create'] = true;
		}
		if ($user_role['read'][$key] == 1){
			$lqc_inspector_oqc_lon_access['read'] = true;
		}
		if ($user_role['update'][$key] == 1){
			$lqc_inspector_oqc_lon_access['update'] = true;
		}
		if ($user_role['delete'][$key] == 1){
			$lqc_inspector_oqc_lon_access['delete'] = true;
		}
	}
}

$lqc_supervisor_oqc_lon_access 	= array("create" => false, 
									"read" => false,
									"update" => false,
									"delete" => false
									);
$subsystem_code 			= "OQC";
$module 					= "Lot-out Notice-LQC Supervisor";
foreach($user_role['subsystem_code'] as $key => $subsystem_code ){
	if($subsystem_code == $subsystem_code && $user_role['module'][$key] == $module){ 
		if ($user_role['create'][$key] == 1){
			$lqc_supervisor_oqc_lon_access['create'] = true;
		}
		if ($user_role['read'][$key] == 1){
			$lqc_supervisor_oqc_lon_access['read'] = true;
		}
		if ($user_role['update'][$key] == 1){
			$lqc_supervisor_oqc_lon_access['update'] = true;
		}
		if ($user_role['delete'][$key] == 1){
			$lqc_supervisor_oqc_lon_access['delete'] = true;
		}
	}
}
$lqc_manager_oqc_lon_access 	= array("create" => false, 
									"read" => false,
									"update" => false,
									"delete" => false
									);
$subsystem_code 			= "OQC";
$module 					= "Lot-out Notice-LQC Asst. Manager/Manager";
foreach($user_role['subsystem_code'] as $key => $subsystem_code ){
	if($subsystem_code == $subsystem_code && $user_role['module'][$key] == $module){ 
		if ($user_role['create'][$key] == 1){
			$lqc_manager_oqc_lon_access['create'] = true;
		}
		if ($user_role['read'][$key] == 1){
			$lqc_manager_oqc_lon_access['read'] = true;
		}
		if ($user_role['update'][$key] == 1){
			$lqc_manager_oqc_lon_access['update'] = true;
		}
		if ($user_role['delete'][$key] == 1){
			$lqc_manager_oqc_lon_access['delete'] = true;
		}
	}
}
$subsystem_code 			= "OQC";
$module 					= "Lot-out Notice-Production";
foreach($user_role['subsystem_code'] as $key => $subsystem_code ){
	if($subsystem_code == $subsystem_code && $user_role['module'][$key] == $module){ 
		if ($user_role['create'][$key] == 1){
			$lqc_production_oqc_lon_access['create'] = true;
		}
		if ($user_role['read'][$key] == 1){
			$lqc_production_oqc_lon_access['read'] = true;
		}
		if ($user_role['update'][$key] == 1){
			$lqc_production_oqc_lon_access['update'] = true;
		}
		if ($user_role['delete'][$key] == 1){
			$lqc_production_oqc_lon_access['delete'] = true;
		}
	}
}
?>

<div class="col-sm-12">
	<!-- Nav tabs -->
	<div class="">
		<ul class="nav nav-tabs" role="tablist">
			<?php 
				// if($ng_report_approver){
					// echo '<li role="presentation" class="active"><a href="#ng_report" aria-controls="ng_report" role="tab" data-toggle="tab">NG Report</a></li>';
				// }
				// if($ng_report_disposition_admin){
					// echo '<li role="presentation" class=""><a href="#for_disposition" aria-controls="ng_report" role="tab" data-toggle="tab">For Disposition</a></li>';
				// }	
				$class_active = "active";
				if($lqc_inspector_oqc_lon_access['read']){
					echo '<li role="presentation" class="'.$class_active.'"><a href="#lqc_inspector" aria-controls="lqc_inspector" role="tab" data-toggle="tab">LQC Inspector</a></li>';
					$class_active = '';
				}
				if($lqc_supervisor_oqc_lon_access['read']){
					echo '<li role="presentation" class="'.$class_active.'"><a href="#lqc_supervisor" aria-controls="lqc_supervisor" role="tab" data-toggle="tab">LQC Supervisor</a></li>';
					$class_active = '';
				}
				if($lqc_manager_oqc_lon_access['read']){
					echo '<li role="presentation" class="'.$class_active.'"><a href="#lqc_manager" aria-controls="lqc_manager" role="tab" data-toggle="tab">LQC Asst. Manager/Manager</a></li>';
					$class_active = '';
				}
				if($lqc_production_oqc_lon_access['read']){
					echo '<li role="presentation" class="'.$class_active.'"><a href="#lqc_production" aria-controls="lqc_production" role="tab" data-toggle="tab">Production</a></li>';
					$class_active = '';
				}
				// if($user_iqc_qar_recipient_access['read']){
					// echo '<li role="presentation" class="'.$class_active.'"><a href="#recipient" aria-controls="recipient" role="tab" data-toggle="tab">Recipient Page</a></li>';
					// $class_active = '';
				// }
			?>
			
		</ul>
	</div>
</div>

<!-- Tab panes -->
<div class="tab-content">
	<?php
		$class_active = "active";
				if($lqc_inspector_oqc_lon_access['read']){
					echo '<div role="tabpanel" class="tab-pane '.$class_active.'" id="lqc_inspector">	
							<div class="col-sm-12">
								<div class="panel panel-info">
									<div class="panel-heading"><i class="fa fa-puzzle-piece fa-lg"> Lot-out Notice (LQC Inspector)s</i></div>
									<div class="panel-body">
										<div class="row">
											<div class="col-sm-6">
												<!-- <button class="btn btn-default fa" id="btn_oqc_lon_search_main"><i class="fa fa-search"></i> Search</button> -->
											</div>
											<div class="col-sm-6">
												<button class="btn btn-success fa pull-right" id="btn_lon_report_ins"><i class="fa fa-file-excel-o"></i> REPORT</button>';											
												if($lqc_inspector_oqc_lon_access['create']){
													echo '<button class="btn btn-primary fa pull-right" id="btn_lon_new"><i class="fa fa-plus"></i> NEW</button>';
												}
											echo '</div>
										</div>
										<div class="row">
											<div class="col-sm-12"><br />
												<table class="table table-striped table-bordered table-condensed" id="tbl_oqc_lon_lqc_inspector">
													<thead>
														<th>Status</th>
														<th>LON No.</th>
														<th>Attention</th>
														<th>Defect Mode</th>
														<th>Lot Details</th>
														<th>PO Details</th>
														<th>CAPA Due Date</th>
														<th>Signatories Logs</th>
														<th>Action</th>
													</thead>
												</table>
											</div>
										</div>
									</div>
								</div>
							</div>
						</div>';
						
					$class_active = '';
				}
				if($lqc_supervisor_oqc_lon_access['read']){
					echo '<div role="tabpanel" class="tab-pane '.$class_active.'" id="lqc_supervisor">
							<div class="col-sm-12">
								<div class="panel panel-info">
									<div class="panel-heading"><i class="fa fa-puzzle-piece fa-lg"> Lot-out Notice (LQC Supervisor)</i></div>
									<div class="panel-body">
										<div class="row">
											<div class="col-sm-6">
												<!-- <button class="btn btn-default fa" id="btn_oqc_lon_search_main"><i class="fa fa-search"></i> Search</button> -->
											</div>
											<div class="col-sm-6">
												<button class="btn btn-success fa pull-right" id="btn_lon_report_sup"><i class="fa fa-file-excel-o"></i> REPORT</button>
											</div>
										</div>
										<div class="row">
											<div class="col-sm-12"><br />
												<table class="table table-striped table-bordered table-condensed" id="tbl_oqc_lon_lqc_supervisor">
													<thead>
														<th>Status</th>
														<th>LON No.</th>
														<th>Attention</th>
														<th>Defect Mode</th>
														<th>Lot Details</th>
														<th>PO Details</th>
														<th>CAPA Due Date</th>
														<th>Signatories Logs</th>
														<th>Action</th>
													</thead>
												</table>
											</div>
										</div>
									</div>
								</div>
							</div>
						</div>';
						
					$class_active = '';
				}
				if($lqc_manager_oqc_lon_access['read']){
					
					echo '<div role="tabpanel" class="tab-pane '.$class_active.'" id="lqc_manager">
							<div class="col-sm-12">
								<div class="panel panel-info">
									<div class="panel-heading"><i class="fa fa-puzzle-piece fa-lg"> Lot-out Notice-LQC Asst. Manager/Manager</i></div>
									<div class="panel-body">
										<div class="row">
											<div class="col-sm-6">
												<!-- <button class="btn btn-default fa" id="btn_oqc_lon_search_main"><i class="fa fa-search"></i> Search</button> -->
											</div>
											<div class="col-sm-6">
												<button class="btn btn-success fa pull-right" id="btn_lon_report_man"><i class="fa fa-file-excel-o"></i> REPORT</button>
											</div>
										</div>
										<div class="row">
											<div class="col-sm-12"><br />
												<table class="table table-striped table-bordered table-condensed" id="tbl_oqc_lon_lqc_manager">
													<thead>
														<th>Status</th>
														<th>LON No.</th>
														<th>Attention</th>
														<th>Defect Mode</th>
														<th>Lot Details</th>
														<th>PO Details</th>
														<th>CAPA Due Date</th>
														<th>Signatories Logs</th>
														<th>Action</th>
													</thead>
												</table>
											</div>
										</div>
									</div>
								</div>
							</div>
						</div>';
						
					$class_active = '';
				}
				if($lqc_production_oqc_lon_access['read']){
					echo '<div role="tabpanel" class="tab-pane '.$class_active.'" id="lqc_production">
							<div class="col-sm-12">
								<div class="panel panel-info">
									<div class="panel-heading"><i class="fa fa-puzzle-piece fa-lg"> Lot-out Notice-Production</i></div>
									<div class="panel-body">
										<div class="row">
											<div class="col-sm-6">
												<!-- <button class="btn btn-default fa" id="btn_oqc_lon_search_main"><i class="fa fa-search"></i> Search</button> -->
											</div>
											<div class="col-sm-6">
												<button class="btn btn-success fa pull-right" id="btn_lon_report_prod"><i class="fa fa-file-excel-o"></i> REPORT</button>
											</div>
										</div>
										<div class="row">
											<div class="col-sm-12"><br />
												<table class="table table-striped table-bordered table-condensed" id="tbl_oqc_lon_production">
													<thead>
														<th>Status</th>
														<th>LON No.</th>
														<th>Attention</th>
														<th>Defect Mode</th>
														<th>Lot Details</th>
														<th>PO Details</th>
														<th>CAPA Due Date</th>
														<th>Signatories Logs</th>
														<th>Action</th>
													</thead>
												</table>
											</div>
										</div>
									</div>
								</div>
							</div>
						</div>';
						
					$class_active = '';
				}
						
	?>
</div>

<!---------------------
	Modals - Start 
---------------------->
<div class="modal fade" tabindex="-1" role="dialog" id="modal_lon_lqc_inspector_new">
  <div class="modal-dialog modal-lg" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
        <h4 class="modal-title"><i class="fa fa-upload"></i> New Lot-out Notice</h4>
      </div>
	  <div class="modal-body" style="overflow:inherit;">
		 <form id="frm_lqc_inspector_new">
			<div class="profile-info-title h4" >
				<span class="fa fa-plus-circle"></span> OQC Fill-in
			</div>
			<hr class="graph-orange" style="margin-top:0px;">
			<div class="row" style="margin-top:5px;">
				<div class="col-sm-12">
					<div class="alert alert-danger" style="display:none;" role="alert" id="container_lqc_inspector_new_message">					
					</div>
				</div>				
				<div class="col-sm-2">
					<label class="fa fa-md">Section: </label>
				</div>
				<div class="col-sm-4">
					<input type="text" class="form-control" id="section" name="section" readonly required>
				</div>
				<div class="col-sm-2">
					<label class="fa fa-md">LON No.: </label>
				</div>
				<div class="col-sm-4">
					<input type="text" class="form-control" id="lon_no" name="lon_no" readonly required>
				</div>
			</div>
			<div class="row">
				<div class="col-sm-2">
					<!-- <label class="fa fa-md">Attention: </label> -->
					<label class="fa fa-md text-danger"> In-charge Supervisor </label>
				</div>
				<div class="col-sm-10">
					<select class="" id="cmb_attention" name="attention[]" multiple="multiple" style="width:100%;" required>
					</select>
				</div>
			</div>
			<div class="row" style="margin-top:5px;">
				<div class="col-sm-2">
					<label class="fa fa-md text-danger">Mode of Defects: </label>
				</div>
				<div class="col-sm-4">
					<input type="text" class="form-control" id="defect_mode" name="defect_mode" required>
				</div>
				<div class="col-sm-2">
					<label class="fa fa-md">Defect Qty.: </label>
				</div>
				<div class="col-sm-4">
					<input type="number" class="form-control" id="defect_qty" min="0" name="defect_qty" required>
				</div>
				
				<div class="col-sm-2">
					<label class="fa fa-md">Line: </label>
				</div>
				<div class="col-sm-4">
					<input type="text" class="form-control" id="line" name="line" required>
				</div>
			</div>
			<div class="row">
				<div class="col-sm-2">
					<label class="fa fa-md">PO Number: </label>
				</div>
				<div class="col-sm-4">
					<input type="text" class="form-control" id="po_number" list="list_po_num" autocomplete="on" name="po_number" required>
					<datalist id="list_po_num"></datalist>
				</div>
				<div class="col-sm-2">
					<label class="fa fa-md">Series Name: </label>
				</div>
				<div class="col-sm-4">
					<input type="text" class="form-control" id="device_name" name="device_name" required>
				</div>
				<div class="col-sm-2">
					<label class="fa fa-md">Lot Number: </label>
				</div>
				<div class="col-sm-4">
					<input type="text" class="form-control" id="lot_number" name="lot_number" required>
				</div>
				<div class="col-sm-2">
					<label class="fa fa-md">Lot Qty.: </label>
				</div>
				<div class="col-sm-4">
					<input type="number" class="form-control" id="lot_qty" name="lot_qty" required>
				</div>
				<div class="col-sm-2">
					<label class="fa fa-md">AQL: </label>
				</div>
				<div class="col-sm-4">
					<input type="number" class="form-control" id="aql" name="aql" value="1" step="0.01" required>
				</div>
				<div class="col-sm-2">
					<label class="fa fa-md">Sample Size: </label>
				</div>
				<div class="col-sm-4">
					<input type="number" class="form-control" id="sample_size" min="0" name="sample_size" required>
				</div>
				<div class="col-sm-2">
					<label class="fa fa-md">Date Inspected: </label>
				</div>
				<div class="col-sm-4">
					<input type="date" class="form-control" id="date_inspected" max="<?php echo date('Y-m-d'); ?>" name="date_inspected" required>
				</div>
				<div class="col-sm-2">
					<label class="fa fa-md">Lot Submission: </label>
				</div>
				<div class="col-sm-4">
					<select class="form-control" id="lot_submission" name="lot_submission" required>
						<option value="1st Sub">1st Sub</option>
						<option value="2nd Sub">2nd Sub</option>
						<option value="3rd Sub">3rd Sub</option>
					</select>
				</div>
			</div>
			<div class="row">
				<div class="col-sm-2">
					<label class="fa fa-md">Reel/Batch #: </label>
				</div>
				<div class="col-sm-4">
					<input type="text" class="form-control" id="reel_batch_no" name="reel_batch_no" required>
				</div>
				<div class="col-sm-2">
					<!-- <label class="fa fa-md">Concern Operator: </label> -->
					<label class="fa fa-md text-danger">Contributor: </label>
				</div>
				<div class="col-sm-4">
					<select class="" id="cmb_operator" name="operator[]" multiple="multiple" style="width:100%;" required>
					</select>
				</div>
			</div>
			<div class="row" style="margin-top:5px;">
				<div class="col-sm-2">
					<label class="fa fa-md">Verified By: </label>
				</div>
				<div class="col-sm-4">
					<select class="" id="cmb_verified_by" name="verified_by[]" multiple="multiple" style="width:100%;" required>
					</select>
				</div>
				<div class="col-sm-2">
					<label class="fa fa-md">Disposition on Affected Lot: </label>
				</div>
				<div class="col-sm-4">
					<select class="form-control" id="disposition" name="disposition" required>
					</select>
				</div>
			</div>
			<div class="row" style="margin-top:5px;">
				<div class="col-sm-2">
					<label class="fa fa-md">Attachment: </label>
				</div>
				<div class="col-sm-4">
					<input type="file" id="file_lon" name="file_lon">
				</div>
				<div class="col-sm-2">
					<label class="fa fa-md" for="text_factory_location">Location </label>
				</div>
				<div class="col-sm-4">
					<select class="form-control" id="text_factory_location" name="factory_location" required>
						<option value="" selected disabled>-Select-</option>
						<option value="Cabuyao">Cabuyao</option>
						<option value="Malvar">Malvar</option>
					</select>
				</div>
			</div>
			<div class="row" style="margin-top:5px;">
				<div class="col-sm-2">
					<label class="fa fa-md">Remarks: </label>
				</div>
				<div class="col-sm-10">
					<textarea class="form-control" id="txt_remarks" name="remarks"></textarea>
				</div>
			</div>
			<hr class="graph-blue" style="margin-top:0px;">
			<div class="row" style="margin-top:5px;">
				<div class="col-sm-2">
					<label class="fa fa-md">Checked By:<br>(LQC Supervisor)</label>
				</div>
				<div class="col-sm-4">
					<select class="" id="cmb_checked_by" name="checked_by" style="width:100%;" required>
					</select>
				</div>
				<div class="col-sm-2">
					<label class="fa fa-md">Approved By: <br>(LQC Asst. Manager or Manager)</label>
				</div>
				<div class="col-sm-4">
					<select class="" id="cmb_approved_by" name="approved_by" style="width:100%;" required>
					</select>
				</div>
			</div>
		  </div>
		  <div class="modal-footer">
			<button type="submit" class="btn btn-primary fa fa-save"> Save</button>
			<button type="button" class="btn btn-default fa fa-close" data-dismiss="modal"> Close</button>
		  </div>
		</form><!-- /#frm_upload_measdata -->
    </div><!-- /.modal-content -->
  </div><!-- /.modal-dialog -->
</div><!-- /.modal -->

<div class="modal fade" tabindex="-1" role="dialog" id="modal_lon_lqc_inspector_edit">
  <div class="modal-dialog modal-lg" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
        <h4 class="modal-title"><i class="fa fa-edit"></i> Edit Lot-out Notice</h4>
      </div>
	  <div class="modal-body" style="overflow:inherit;">
		 <form id="frm_lqc_inspector_edit">
			<div class="profile-info-title h4" >
				<span class="fa fa-edit"></span> OQC Fill-in
			</div>
			<hr class="graph-orange" style="margin-top:0px;">
			<div class="row" style="margin-top:5px;">
				<div class="col-sm-12">
					<div class="alert alert-danger" style="display:none;" role="alert" id="container_lqc_inspector_new_message">					
					</div>
				</div>				
				<div class="col-sm-2">
					<label class="fa fa-md">Section: </label>
				</div>
				<div class="col-sm-4">
					<input type="text" class="form-control" id="section" name="section" readonly required>
				</div>
				<div class="col-sm-2">
					<label class="fa fa-md">LON No.: </label>
				</div>
				<div class="col-sm-4">
					<input type="text" class="form-control" id="lon_no" name="lon_no" readonly required>
				</div>
			</div>
			<div class="row">
				<div class="col-sm-2">
					<label class="fa fa-md">Attention: </label>
				</div>
				<div class="col-sm-10">
					<select class="" id="cmb_attention" name="attention[]" multiple="multiple" style="width:100%;" required>
					</select>
				</div>
			</div>
			<div class="row" style="margin-top:5px;">
				<div class="col-sm-2">
					<label class="fa fa-md">Defect Mode: </label>
				</div>
				<div class="col-sm-4">
					<input type="text" class="form-control" id="defect_mode" name="defect_mode" required>
				</div>
				<div class="col-sm-2">
					<label class="fa fa-md">Lot Submission: </label>
				</div>
				<div class="col-sm-4">
					<select class="form-control" id="lot_submission" name="lot_submission" required>
						<option value="1st Sub">1st Sub</option>
						<option value="2nd Sub">2nd Sub</option>
						<option value="3rd Sub">3rd Sub</option>
					</select>
				</div>
				<div class="col-sm-2">
					<label class="fa fa-md">Line: </label>
				</div>
				<div class="col-sm-4">
					<input type="text" class="form-control" id="line" name="line" required>
				</div>
			</div>
			<div class="row">
				<div class="col-sm-2">
					<label class="fa fa-md">PO Number: </label>
				</div>
				<div class="col-sm-4">
					<input type="text" class="form-control" id="po_number" list="list_po_num" autocomplete="on" name="po_number" required>
					<datalist id="list_po_num"></datalist>
				</div>
				<div class="col-sm-2">
					<label class="fa fa-md">Series Name: </label>
				</div>
				<div class="col-sm-4">
					<input type="text" class="form-control" id="device_name" name="device_name" required>
				</div>
				<div class="col-sm-2">
					<label class="fa fa-md">Lot Number: </label>
				</div>
				<div class="col-sm-4">
					<input type="text" class="form-control" id="lot_number" name="lot_number" required>
				</div>
				<div class="col-sm-2">
					<label class="fa fa-md">Lot Qty.: </label>
				</div>
				<div class="col-sm-4">
					<input type="number" class="form-control" id="lot_qty" name="lot_qty" required>
				</div>
				<div class="col-sm-2">
					<label class="fa fa-md">AQL: </label>
				</div>
				<div class="col-sm-4">
					<input type="number" class="form-control" id="aql" name="aql" value="1" step="0.01" required>
				</div>
				<div class="col-sm-2">
					<label class="fa fa-md">Sample Size: </label>
				</div>
				<div class="col-sm-4">
					<input type="number" class="form-control" id="sample_size" min="0" name="sample_size" required>
				</div>
				<div class="col-sm-2">
					<label class="fa fa-md">Date Inspected: </label>
				</div>
				<div class="col-sm-4">
					<input type="date" class="form-control" id="date_inspected" max="<?php echo date('Y-m-d'); ?>" name="date_inspected" required>
				</div>
				<div class="col-sm-2">
					<label class="fa fa-md">Defect Qty.: </label>
				</div>
				<div class="col-sm-4">
					<input type="number" class="form-control" id="defect_qty" min="0" name="defect_qty" required>
				</div>
			</div>
			<div class="row">
				<div class="col-sm-2">
					<label class="fa fa-md">Reel/Batch #: </label>
				</div>
				<div class="col-sm-4">
					<input type="text" class="form-control" id="reel_batch_no" name="reel_batch_no" required>
				</div>
				<div class="col-sm-2">
					<label class="fa fa-md">Concern Operator: </label>
				</div>
				<div class="col-sm-4">
					<select class="" id="cmb_operator" name="operator[]" multiple="multiple" style="width:100%;" required>
					</select>
				</div>
			</div>
			<div class="row" style="margin-top:5px;">
				<div class="col-sm-2">
					<label class="fa fa-md">Verified By: </label>
				</div>
				<div class="col-sm-4">
					<select class="" id="cmb_verified_by" name="verified_by[]" multiple="multiple" style="width:100%;" required>
					</select>
				</div>
				<div class="col-sm-2">
					<label class="fa fa-md">Disposition on Affected Lot: </label>
				</div>
				<div class="col-sm-4">
					<select class="form-control" id="disposition" name="disposition" required>
					</select>
				</div>
			</div>
			<div class="row" style="margin-top:5px;">
				<div class="col-sm-2">
					<label class="fa fa-md">Attachment: </label>
				</div>
				<div class="col-sm-4">
					<input type="file" id="file_lon" name="file_lon">
					<button type="button" class="btn btn-link fa fa-paperclip" id="pkid" name="pkid"> Attachment</button>
				</div>
			</div>
			<div class="row" style="margin-top:5px;">
				<div class="col-sm-2">
					<label class="fa fa-md">Remarks: </label>
				</div>
				<div class="col-sm-10">
					<textarea class="form-control" id="txt_remarks" name="remarks"></textarea>
				</div>
			</div>
			<hr class="graph-blue" style="margin-top:0px;">
			<div class="row" style="margin-top:5px;">
				<div class="col-sm-2">
					<label class="fa fa-md">Checked By:<br>(LQC Supervisor)</label>
				</div>
				<div class="col-sm-4">
					<select class="" id="cmb_checked_by" name="checked_by" style="width:100%;" required>
					</select>
				</div>
				<div class="col-sm-2">
					<label class="fa fa-md">Approved By: <br>(LQC Asst. Manager or Manager)</label>
				</div>
				<div class="col-sm-4">
					<select class="" id="cmb_approved_by" name="approved_by" style="width:100%;" required>
					</select>
				</div>
			</div>
		  </div>
		  <div class="modal-footer">
			<button type="submit" class="btn btn-primary fa fa-save"> Save</button>
			<button type="button" class="btn btn-default fa fa-close" data-dismiss="modal"> Close</button>
		  </div>
		</form><!-- /#frm_upload_measdata -->
    </div><!-- /.modal-content -->
  </div><!-- /.modal-dialog -->
</div><!-- /.modal -->

<div class="modal fade" tabindex="-1" role="dialog" id="modal_lon_lqc_supervisor_edit">
  <div class="modal-dialog modal-lg" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
        <h4 class="modal-title"><i class="fa fa-edit"></i> Edit Lot-out Notice</h4>
      </div>
	  <div class="modal-body" style="overflow:inherit;">
		 <form id="frm_lqc_supervisor_edit">
			<div class="profile-info-title h4" >
				<span class="fa fa-edit"></span> OQC Fill-in
			</div>
			<hr class="graph-orange" style="margin-top:0px;">
			<div class="row" style="margin-top:5px;">
				<div class="col-sm-12">
					<div class="alert alert-danger" style="display:none;" role="alert" id="container_lqc_supervisor_new_message">					
					</div>
				</div>				
				<div class="col-sm-2">
					<label class="fa fa-md">Section: </label>
				</div>
				<div class="col-sm-4">
					<input type="text" class="form-control" id="section" name="section" readonly required>
				</div>
				<div class="col-sm-2">
					<label class="fa fa-md">LON No.: </label>
				</div>
				<div class="col-sm-4">
					<input type="text" class="form-control" id="lon_no" name="lon_no" readonly required>
				</div>
			</div>
			<div class="row">
				<div class="col-sm-2">
					<label class="fa fa-md">Attention: </label>
				</div>
				<div class="col-sm-10">
					<select class="" id="cmb_attention" name="attention[]" multiple="multiple" style="width:100%;" required>
					</select>
				</div>
			</div>
			<div class="row" style="margin-top:5px;">
				<div class="col-sm-2">
					<label class="fa fa-md">Defect Mode: </label>
				</div>
				<div class="col-sm-4">
					<input type="text" class="form-control" id="defect_mode" name="defect_mode" required>
				</div>
				<div class="col-sm-2">
					<label class="fa fa-md">Lot Submission: </label>
				</div>
				<div class="col-sm-4">
					<select class="form-control" id="lot_submission" name="lot_submission" required>
						<option value="1st Sub">1st Sub</option>
						<option value="2nd Sub">2nd Sub</option>
						<option value="3rd Sub">3rd Sub</option>
					</select>
				</div>
				<div class="col-sm-2">
					<label class="fa fa-md">Line: </label>
				</div>
				<div class="col-sm-4">
					<input type="text" class="form-control" id="line" name="line" required>
				</div>
			</div>
			<div class="row">
				<div class="col-sm-2">
					<label class="fa fa-md">PO Number: </label>
				</div>
				<div class="col-sm-4">
					<input type="text" class="form-control" id="po_number" list="list_po_num" autocomplete="on" name="po_number" required>
					<datalist id="list_po_num"></datalist>
				</div>
				<div class="col-sm-2">
					<label class="fa fa-md">Series Name: </label>
				</div>
				<div class="col-sm-4">
					<input type="text" class="form-control" id="device_name" name="device_name" required>
				</div>
				<div class="col-sm-2">
					<label class="fa fa-md">Lot Number: </label>
				</div>
				<div class="col-sm-4">
					<input type="text" class="form-control" id="lot_number" name="lot_number" required>
				</div>
				<div class="col-sm-2">
					<label class="fa fa-md">Lot Qty.: </label>
				</div>
				<div class="col-sm-4">
					<input type="number" class="form-control" id="lot_qty" name="lot_qty" required>
				</div>
				<div class="col-sm-2">
					<label class="fa fa-md">AQL: </label>
				</div>
				<div class="col-sm-4">
					<input type="number" class="form-control" id="aql" name="aql" value="1" step="0.01" required>
				</div>
				<div class="col-sm-2">
					<label class="fa fa-md">Sample Size: </label>
				</div>
				<div class="col-sm-4">
					<input type="number" class="form-control" id="sample_size" min="0" name="sample_size" required>
				</div>
				<div class="col-sm-2">
					<label class="fa fa-md">Date Inspected: </label>
				</div>
				<div class="col-sm-4">
					<input type="date" class="form-control" id="date_inspected" max="<?php echo date('Y-m-d'); ?>" name="date_inspected" required>
				</div>
				<div class="col-sm-2">
					<label class="fa fa-md">Defect Qty.: </label>
				</div>
				<div class="col-sm-4">
					<input type="number" class="form-control" id="defect_qty" min="0" name="defect_qty" required>
				</div>
			</div>
			<div class="row">
				<div class="col-sm-2">
					<label class="fa fa-md">Reel/Batch #: </label>
				</div>
				<div class="col-sm-4">
					<input type="text" class="form-control" id="reel_batch_no" name="reel_batch_no" required>
				</div>
				<div class="col-sm-2">
					<label class="fa fa-md">Concern Operator: </label>
				</div>
				<div class="col-sm-4">
					<select class="" id="cmb_operator" name="operator[]" multiple="multiple" style="width:100%;" required>
					</select>
				</div>
			</div>
			<div class="row" style="margin-top:5px;">
				<div class="col-sm-2">
					<label class="fa fa-md">Verified By: </label>
				</div>
				<div class="col-sm-4">
					<select class="" id="cmb_verified_by" name="verified_by[]" multiple="multiple" style="width:100%;" required>
					</select>
				</div>
				<div class="col-sm-2">
					<label class="fa fa-md">Disposition on Affected Lot: </label>
				</div>
				<div class="col-sm-4">
					<select class="form-control" id="disposition" name="disposition" required>
					</select>
				</div>
			</div>
			<div class="row" style="margin-top:5px;">
				<div class="col-sm-2">
					<label class="fa fa-md">Attachment: </label>
				</div>
				<div class="col-sm-4">
					<input type="file" id="file_lon" name="file_lon">
				</div>
				<div class="col-sm-6">
					<button type="button" class="btn btn-link fa fa-paperclip" id="pkid" name="pkid"> Attachment</button>
				</div>
			</div>
			<div class="row" style="margin-top:5px;">
				<div class="col-sm-2">
					<label class="fa fa-md">Remarks: </label>
				</div>
				<div class="col-sm-10">
					<textarea class="form-control" id="txt_remarks" name="remarks"></textarea>
				</div>
			</div>
			<hr class="graph-blue" style="margin-top:0px;">
			<div class="row" style="margin-top:5px;">
				<div class="col-sm-2">
					<label class="fa fa-md">Checked By:<br>(LQC Supervisor)</label>
				</div>
				<div class="col-sm-4">
					<select class="" id="cmb_checked_by" name="checked_by" style="width:100%;" required>
					</select>
				</div>
				<div class="col-sm-2">
					<label class="fa fa-md">Approved By: <br>(LQC Asst. Manager or Manager)</label>
				</div>
				<div class="col-sm-4">
					<select class="" id="cmb_approved_by" name="approved_by" style="width:100%;" required>
					</select>
				</div>
			</div>
			<div class="profile-info-title h4" >
				<span class="fa fa-plus-circle"></span> LQC Supervisor Fill-in
			</div>
			<hr class="graph-green" style="margin-top:0px;">
			<div class="row" style="margin-top:5px;">
				<div class="col-sm-12">
					<div class="alert alert-danger" style="display:none;" role="alert" id="lon_container_message">					
					</div>
				</div>		
				<div class="col-sm-2">
					<label class="fa fa-md">CAPA Due Date: </label>
				</div>
				<div class="col-sm-4">
					<input type="date" class="form-control" id="capa_due_date" name="capa_due_date" min="<?php echo date('Y-m-d'); ?>" required>
				</div>
			</div>
			<div class="row" style="margin-top:5px;">
				<div class="col-sm-2">
					<label class="fa fa-md">Carbon copy: </label>
				</div>
				<div class="col-sm-10">
					<select class="" id="cmb_cc" name="cc[]" multiple="multiple"style="width:100%;">
					</select>
				</div>
			</div>
			<div class="row" style="margin-top:5px;">
				<div class="col-sm-2">
					<label class="fa fa-md">Remarks: </label>
				</div>
				<div class="col-sm-10">
					<textarea class="form-control" id="checked_by_remarks" name="checked_by_remarks"></textarea>
				</div>
			</div>
		  </div>
		  <div class="modal-footer">
			<button type="submit" class="btn btn-primary fa fa-save"> Save</button>
			<button type="button" class="btn btn-default fa fa-close" data-dismiss="modal"> Close</button>
		  </div>
		</form><!-- /#frm_upload_measdata -->
    </div><!-- /.modal-content -->
  </div><!-- /.modal-dialog -->
</div><!-- /.modal -->

<div class="modal fade" tabindex="-1" role="dialog" id="modal_lon_lqc_supervisor_view">
  <div class="modal-dialog modal-lg" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
        <h4 class="modal-title"><i class="fa fa-upload"></i> View Lot-out Notice</h4>
      </div>
	  <div class="modal-body" style="overflow:inherit;">
		<form id="frm_lqc_supervisor_view">
			<div class="profile-info-title h4" >
				<span class="fa fa-plus-circle"></span> OQC Fill-in
			</div>
			<hr class="graph-orange" style="margin-top:0px;">
			<div class="row" style="margin-top:5px;">		
				<div class="col-sm-2">
					<label class="fa fa-md">Section: </label>
				</div>
				<div class="col-sm-4">
					<input type="text" class="form-control" id="section" name="section" required>
				</div>
				<div class="col-sm-2">
					<label class="fa fa-md">LON No.: </label>
				</div>
				<div class="col-sm-4">
					<input type="text" class="form-control" id="lon_no" name="lon_no" required>
				</div>
			</div>
			<div class="row">
				<div class="col-sm-2">
					<label class="fa fa-md">Attention: </label>
				</div>
				<div class="col-sm-10">
					<input type="text" class="form-control" id="attention" name="attention" required>
				</div>
			</div>
			<div class="row" style="margin-top:5px;">
				<div class="col-sm-2">
					<label class="fa fa-md">Defect Mode: </label>
				</div>
				<div class="col-sm-4">
					<input type="text" class="form-control" id="defect_mode" name="defect_mode" required>
				</div>
				<div class="col-sm-2">
					<label class="fa fa-md">Lot Submission: </label>
				</div>
				<div class="col-sm-4">
					<input type="text" class="form-control" id="lot_submission" name="lot_submission" required>
				</div>
				<div class="col-sm-2">
					<label class="fa fa-md">Line: </label>
				</div>
				<div class="col-sm-4">
					<input type="text" class="form-control" id="line" name="line" required>
				</div>
			</div>
			<div class="row">
				<div class="col-sm-2">
					<label class="fa fa-md">PO Number: </label>
				</div>
				<div class="col-sm-4">
					<input type="text" class="form-control" id="po_number" name="po_number" required>
				</div>
				<div class="col-sm-2">
					<label class="fa fa-md">Series Name: </label>
				</div>
				<div class="col-sm-4">
					<input type="text" class="form-control" id="device_name" name="device_name" required>
				</div>
				<div class="col-sm-2">
					<label class="fa fa-md">Lot Number: </label>
				</div>
				<div class="col-sm-4">
					<input type="text" class="form-control" id="lot_number" name="lot_number" required>
				</div>
				<div class="col-sm-2">
					<label class="fa fa-md">Lot Qty.: </label>
				</div>
				<div class="col-sm-4">
					<input type="number" class="form-control" id="lot_qty" name="lot_qty" required>
				</div>
				<div class="col-sm-2">
					<label class="fa fa-md">AQL: </label>
				</div>
				<div class="col-sm-4">
					<input type="number" class="form-control" id="aql" name="aql" value="1" step="0.01" required>
				</div>
				<div class="col-sm-2">
					<label class="fa fa-md">Sample Size: </label>
				</div>
				<div class="col-sm-4">
					<input type="text" class="form-control" id="sample_size" name="sample_size" required>
				</div>
				<div class="col-sm-2">
					<label class="fa fa-md">Date Inspected: </label>
				</div>
				<div class="col-sm-4">
					<input type="date" class="form-control" id="date_inspected" max="<?php echo date('Y-m-d'); ?>" name="date_inspected" required>
				</div>
				<div class="col-sm-2">
					<label class="fa fa-md">Defect Qty.: </label>
				</div>
				<div class="col-sm-4">
					<input type="number" class="form-control" id="defect_qty" min="0" name="defect_qty" required>
				</div>
			</div>
			<div class="row">
				<div class="col-sm-2">
					<label class="fa fa-md">Reel/Batch #: </label>
				</div>
				<div class="col-sm-4">
					<input type="text" class="form-control" id="reel_batch_no" name="reel_batch_no" required>
				</div>
				<div class="col-sm-2">
					<label class="fa fa-md">Concern Operator: </label>
				</div>
				<div class="col-sm-4">
					<input type="text" class="form-control" id="operator" name="operator" required>
				</div>
			</div>
			<div class="row" style="margin-top:5px;">
				<div class="col-sm-2">
					<label class="fa fa-md">Verified By: </label>
				</div>
				<div class="col-sm-4">
					<input type="text" class="form-control" id="verified_by" name="verified_by" required>
				</div>
				<div class="col-sm-2">
					<label class="fa fa-md">Disposition on Affected Lot: </label>
				</div>
				<div class="col-sm-4">
					<input type="text" class="form-control" id="disposition" name="disposition" required>
				</div>
			</div>			
			<div class="row" style="margin-top:5px;">
				<div class="col-sm-2">
					<label class="fa fa-md">Attachment: </label>
				</div>
				<div class="col-sm-4">
					<button type="button" class="btn btn-link fa fa-paperclip" id="pkid" name="pkid"> Attachment</button>
				</div>
			</div>
			<div class="row" style="margin-top:5px;">
				<div class="col-sm-2">
					<label class="fa fa-md">Remarks: </label>
				</div>
				<div class="col-sm-10">
					<textarea class="form-control" id="remarks" name="remarks"></textarea>
				</div>
			</div>
			<hr class="graph-blue" style="margin-top:0px;">
			<div class="row" style="margin-top:5px;">
				<div class="col-sm-2">
					<label class="fa fa-md">Prepared By (LQC Inspector):</label>
				</div>
				<div class="col-sm-4">
					<input type="text" class="form-control" id="created_by" name="created_by" required>
				</div>
				<div class="col-sm-2">
					<label class="fa fa-md">Approved By: <br>(LQC Asst. Manager or Manager)</label>
				</div>
				<div class="col-sm-4">
					<input type="text" class="form-control" id="approved_by" name="approved_by" required>
				</div>
			</div>
			<div class="profile-info-title h4" >
				<span class="fa fa-plus-circle"></span> LQC Supervisor Fill-in
			</div>
			<hr class="graph-green" style="margin-top:0px;">
			<div class="row" style="margin-top:5px;">
				<div class="col-sm-12">
					<div class="alert alert-danger" style="display:none;" role="alert" id="lon_container_message">					
					</div>
				</div>		
				<div class="col-sm-2">
					<label class="fa fa-md">CAPA Due Date: </label>
				</div>
				<div class="col-sm-4">
					<input type="date" class="form-control" id="capa_due_date" name="capa_due_date" min="<?php echo date('Y-m-d'); ?>" required>
				</div>
			</div>
			<div class="row" style="margin-top:5px;">
				<div class="col-sm-2">
					<label class="fa fa-md">Carbon copy: </label>
				</div>
				<div class="col-sm-10">
					<select class="" id="cmb_cc" name="cc[]" multiple="multiple" style="width:100%;">
					</select>
				</div>
			</div>
			<div class="row" style="margin-top:5px;">
				<div class="col-sm-2">
					<label class="fa fa-md">Remarks: </label>
				</div>
				<div class="col-sm-10">
					<textarea class="form-control" id="checked_by_remarks" name="checked_by_remarks"></textarea>
				</div>
			</div>
		  </div>
		  <div class="modal-footer">
			<button type="button" class="btn btn-success fa fa-thumbs-o-up" id=""> Accept</button>
			<button type="button" class="btn btn-danger fa fa-thumbs-o-down" id=""> Reject</button>
			<button type="button" class="btn btn-default fa fa-close" data-dismiss="modal"> Close</button>
		  </div>
		</form><!-- /#frm_upload_measdata -->
    </div><!-- /.modal-content -->
  </div><!-- /.modal-dialog -->
</div><!-- /.modal -->

<div class="modal fade" tabindex="-1" role="dialog" id="modal_lon_lqc_manager_view">
  <div class="modal-dialog modal-lg" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
        <h4 class="modal-title"><i class="fa fa-upload"></i> View Lot-out Notice</h4>
      </div>
	  <div class="modal-body" style="overflow:inherit;">
		<form id="frm_lqc_manager_view">
			<div class="profile-info-title h4" >
				OQC Fill-in
			</div>
			<hr class="graph-orange" style="margin-top:0px;">
			<div class="row" style="margin-top:5px;">		
				<div class="col-sm-2">
					<label class="fa fa-md">Section: </label>
				</div>
				<div class="col-sm-4">
					<input type="text" class="form-control" id="section" name="section" required>
				</div>
				<div class="col-sm-2">
					<label class="fa fa-md">LON No.: </label>
				</div>
				<div class="col-sm-4">
					<input type="text" class="form-control" id="lon_no" name="lon_no" required>
				</div>
			</div>
			<div class="row">
				<div class="col-sm-2">
					<label class="fa fa-md">Attention: </label>
				</div>
				<div class="col-sm-10">
					<input type="text" class="form-control" id="attention" name="attention" required>
				</div>
			</div>
			<div class="row" style="margin-top:5px;">
				<div class="col-sm-2">
					<label class="fa fa-md">Defect Mode: </label>
				</div>
				<div class="col-sm-4">
					<input type="text" class="form-control" id="defect_mode" name="defect_mode" required>
				</div>
				<div class="col-sm-2">
					<label class="fa fa-md">Lot Submission: </label>
				</div>
				<div class="col-sm-4">
					<input type="text" class="form-control" id="lot_submission" name="lot_submission" required>
				</div>
				<div class="col-sm-2">
					<label class="fa fa-md">Line: </label>
				</div>
				<div class="col-sm-4">
					<input type="text" class="form-control" id="line" name="line" required>
				</div>
				<div class="col-sm-2">
					<label class="fa fa-md"><b>CAPA Due Date: </b></label>
				</div>
				<div class="col-sm-4">
					<input type="date" class="form-control" id="capa_due_date" name="capa_due_date" min="<?php echo date('Y-m-d'); ?>" required>
				</div>
			</div>
			<div class="row">
				<div class="col-sm-2">
					<label class="fa fa-md">PO Number: </label>
				</div>
				<div class="col-sm-4">
					<input type="text" class="form-control" id="po_number" name="po_number" required>
				</div>
				<div class="col-sm-2">
					<label class="fa fa-md">Series Name: </label>
				</div>
				<div class="col-sm-4">
					<input type="text" class="form-control" id="device_name" name="device_name" required>
				</div>
				<div class="col-sm-2">
					<label class="fa fa-md">Lot Number: </label>
				</div>
				<div class="col-sm-4">
					<input type="text" class="form-control" id="lot_number" name="lot_number" required>
				</div>
				<div class="col-sm-2">
					<label class="fa fa-md">Lot Qty.: </label>
				</div>
				<div class="col-sm-4">
					<input type="number" class="form-control" id="lot_qty" name="lot_qty" required>
				</div>
				<div class="col-sm-2">
					<label class="fa fa-md">AQL: </label>
				</div>
				<div class="col-sm-4">
					<input type="number" class="form-control" id="aql" name="aql" value="1" step="0.01" required>
				</div>
				<div class="col-sm-2">
					<label class="fa fa-md">Sample Size: </label>
				</div>
				<div class="col-sm-4">
					<input type="text" class="form-control" id="sample_size" name="sample_size" required>
				</div>
				<div class="col-sm-2">
					<label class="fa fa-md">Date Inspected: </label>
				</div>
				<div class="col-sm-4">
					<input type="date" class="form-control" id="date_inspected" max="<?php echo date('Y-m-d'); ?>" name="date_inspected" required>
				</div>
				<div class="col-sm-2">
					<label class="fa fa-md">Defect Qty.: </label>
				</div>
				<div class="col-sm-4">
					<input type="number" class="form-control" id="defect_qty" min="0" name="defect_qty" required>
				</div>
			</div>
			<div class="row">
				<div class="col-sm-2">
					<label class="fa fa-md">Reel/Batch #: </label>
				</div>
				<div class="col-sm-4">
					<input type="text" class="form-control" id="reel_batch_no" name="reel_batch_no" required>
				</div>
				<div class="col-sm-2">
					<label class="fa fa-md">Concern Operator: </label>
				</div>
				<div class="col-sm-4">
					<input type="text" class="form-control" id="operator" name="operator" required>
				</div>
			</div>
			<div class="row" style="margin-top:5px;">
				<div class="col-sm-2">
					<label class="fa fa-md">Verified By: </label>
				</div>
				<div class="col-sm-4">
					<input type="text" class="form-control" id="verified_by" name="verified_by" required>
				</div>
				<div class="col-sm-2">
					<label class="fa fa-md">Disposition on Affected Lot: </label>
				</div>
				<div class="col-sm-4">
					<input type="text" class="form-control" id="disposition" name="disposition" required>
				</div>
			</div>
			<div class="row" style="margin-top:5px;">
				<div class="col-sm-2">
					<label class="fa fa-md">Remarks: </label>
				</div>
				<div class="col-sm-10">
					<textarea class="form-control" id="remarks" name="remarks"></textarea>
				</div>
			</div>					
			<div class="row" style="margin-top:5px;">
				<div class="col-sm-2">
					<label class="fa fa-md">Attachment: </label>
				</div>
				<div class="col-sm-4">
					<button type="button" class="btn btn-link fa fa-paperclip" id="pkid" name="pkid"> Attachment</button>
				</div>
			</div>
			<hr class="graph-blue" style="margin-top:0px;">
			<div class="row" style="margin-top:5px;">
				<div class="col-sm-3">
					<label class="fa fa-md">Prepared By (LQC Inspector):</label>
				</div>
				<div class="col-sm-9">
					<input type="text" class="form-control" id="created_by" name="created_by" required>
				</div>
			</div>
			<div class="row" style="margin-top:5px;">
				<div class="col-sm-3">
					<label class="fa fa-md">Checked By (LQC Supervisor):</label>
				</div>
				<div class="col-sm-9">
					<input type="text" class="form-control" id="checked_by" name="checked_by" required>
				</div>
			</div>
			<div class="row" style="margin-top:5px;">
				<div class="col-sm-3">
					<label class="fa fa-md">Remarks: </label>
				</div>
				<div class="col-sm-9">
					<textarea class="form-control" id="checked_by_remarks" name="checked_by_remarks"></textarea>
				</div>
			</div>
			<div class="row" style="margin-top:5px;">
				<div class="col-sm-3">
					<label class="fa fa-md">Approved By (LQC Asst. Manager or Manager):</label>
				</div>
				<div class="col-sm-9">
					<input type="text" class="form-control" id="approved_by" name="approved_by" required>
				</div>
			</div>
			<div class="row" style="margin-top:5px;">
				<div class="col-sm-3">
					<label class="fa fa-md">Remarks: </label>
				</div>
				<div class="col-sm-9">
					<textarea class="form-control" id="approved_by_remarks" name="approved_by_remarks"></textarea>
				</div>
			</div>
		  </div>
		  <div class="modal-footer">
			<button type="button" class="btn btn-success fa fa-thumbs-o-up" id=""> Approve</button>
			<button type="button" class="btn btn-danger fa fa-thumbs-o-down" id=""> Disapprove</button>
			<button type="button" class="btn btn-default fa fa-close" data-dismiss="modal"> Close</button>
		  </div>
		</form><!-- /#frm_upload_measdata -->
    </div><!-- /.modal-content -->
  </div><!-- /.modal-dialog -->
</div><!-- /.modal -->

<div class="modal fade" tabindex="-1" role="dialog" id="modal_lon_approver_message">
  <div class="modal-dialog modal-md" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
        <h4 class="modal-title"><i class="fa fa-question-circle-o"></i> System Confirmation</h4>
      </div>
	  <form id="frm_lon_approvers_decision">
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

<div class="modal fade" tabindex="-1" role="dialog" id="modal_lon_production_add">
  <div class="modal-dialog modal-lg" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
        <h4 class="modal-title"><i class="fa fa-upload"></i> View Lot-out Notice</h4>
      </div>
	  <div class="modal-body" style="overflow:inherit;">
		<form id="frm_lqc_production_add" method="post" enctype="multipart/form-data">
			<div class="profile-info-title h4" >
				OQC Fill-in
			</div>
			<hr class="graph-orange" style="margin-top:0px;">
			<div class="row" style="margin-top:5px;">		
				<div class="col-sm-2">
					<label class="fa fa-md">Section: </label>
				</div>
				<div class="col-sm-4">
					<input type="text" class="form-control" id="section" name="section" required>
				</div>
				<div class="col-sm-2">
					<label class="fa fa-md">LON No.: </label>
				</div>
				<div class="col-sm-4">
					<input type="text" class="form-control" id="lon_no" name="lon_no" required>
				</div>
			</div>
			<div class="row">
				<div class="col-sm-2">
					<label class="fa fa-md">Attention: </label>
				</div>
				<div class="col-sm-10">
					<input type="text" class="form-control" id="attention" name="attention" required>
				</div>
			</div>
			<div class="row" style="margin-top:5px;">
				<div class="col-sm-2">
					<label class="fa fa-md">Defect Mode: </label>
				</div>
				<div class="col-sm-4">
					<input type="text" class="form-control" id="defect_mode" name="defect_mode" required>
				</div>
				<div class="col-sm-2">
					<label class="fa fa-md">Lot Submission: </label>
				</div>
				<div class="col-sm-4">
					<input type="text" class="form-control" id="lot_submission" name="lot_submission" required>
				</div>
				<div class="col-sm-2">
					<label class="fa fa-md">Line: </label>
				</div>
				<div class="col-sm-4">
					<input type="text" class="form-control" id="line" name="line" required>
				</div>
				<div class="col-sm-2">
					<label class="fa fa-md"><b>CAPA Due Date: </b></label>
				</div>
				<div class="col-sm-4">
					<input type="date" class="form-control" id="capa_due_date" name="capa_due_date" required>
				</div>
			</div>
			<div class="row">
				<div class="col-sm-2">
					<label class="fa fa-md">PO Number: </label>
				</div>
				<div class="col-sm-4">
					<input type="text" class="form-control" id="po_number" name="po_number" required>
				</div>
				<div class="col-sm-2">
					<label class="fa fa-md">Series Name: </label>
				</div>
				<div class="col-sm-4">
					<input type="text" class="form-control" id="device_name" name="device_name" required>
				</div>
				<div class="col-sm-2">
					<label class="fa fa-md">Lot Number: </label>
				</div>
				<div class="col-sm-4">
					<input type="text" class="form-control" id="lot_number" name="lot_number" required>
				</div>
				<div class="col-sm-2">
					<label class="fa fa-md">Lot Qty.: </label>
				</div>
				<div class="col-sm-4">
					<input type="number" class="form-control" id="lot_qty" name="lot_qty" required>
				</div>
				<div class="col-sm-2">
					<label class="fa fa-md">AQL: </label>
				</div>
				<div class="col-sm-4">
					<input type="number" class="form-control" id="aql" name="aql" value="1" step="0.01" required>
				</div>
				<div class="col-sm-2">
					<label class="fa fa-md">Sample Size: </label>
				</div>
				<div class="col-sm-4">
					<input type="text" class="form-control" id="sample_size" name="sample_size" required>
				</div>
				<div class="col-sm-2">
					<label class="fa fa-md">Date Inspected: </label>
				</div>
				<div class="col-sm-4">
					<input type="date" class="form-control" id="date_inspected" max="<?php echo date('Y-m-d'); ?>" name="date_inspected" required>
				</div>
				<div class="col-sm-2">
					<label class="fa fa-md">Defect Qty.: </label>
				</div>
				<div class="col-sm-4">
					<input type="number" class="form-control" id="defect_qty" min="0" name="defect_qty" required>
				</div>
			</div>
			<div class="row">
				<div class="col-sm-2">
					<label class="fa fa-md">Reel/Batch #: </label>
				</div>
				<div class="col-sm-4">
					<input type="text" class="form-control" id="reel_batch_no" name="reel_batch_no" required>
				</div>
				<div class="col-sm-2">
					<label class="fa fa-md">Concern Operator: </label>
				</div>
				<div class="col-sm-4">
					<input type="text" class="form-control" id="operator" name="operator" required>
				</div>
			</div>
			<div class="row" style="margin-top:5px;">
				<div class="col-sm-2">
					<label class="fa fa-md">Verified By: </label>
				</div>
				<div class="col-sm-4">
					<input type="text" class="form-control" id="verified_by" name="verified_by" required>
				</div>
				<div class="col-sm-2">
					<label class="fa fa-md">Disposition on Affected Lot: </label>
				</div>
				<div class="col-sm-4">
					<input type="text" class="form-control" id="disposition" name="disposition" required>
				</div>
			</div>
			<div class="row" style="margin-top:5px;">
				<div class="col-sm-2">
					<label class="fa fa-md">Remarks: </label>
				</div>
				<div class="col-sm-10">
					<textarea class="form-control" id="remarks" name="remarks"></textarea>
				</div>
			</div>			
			<div class="row" style="margin-top:5px;">
				<div class="col-sm-2">
					<label class="fa fa-md">Attachment: </label>
				</div>
				<div class="col-sm-4">
					<button type="button" class="btn btn-link fa fa-paperclip" id="pkid" name="pkid"> Attachment</button>
				</div>
			</div>
			<hr class="graph-blue" style="margin-top:0px;">
			<div class="row" style="margin-top:5px;">
				<div class="col-sm-3">
					<label class="fa fa-md">Prepared By (LQC Inspector):</label>
				</div>
				<div class="col-sm-9">
					<input type="text" class="form-control" id="created_by" name="created_by" required>
				</div>
			</div>
			<div class="row" style="margin-top:5px;">
				<div class="col-sm-3">
					<label class="fa fa-md">Checked By (LQC Supervisor):</label>
				</div>
				<div class="col-sm-9">
					<input type="text" class="form-control" id="checked_by" name="checked_by" required>
				</div>
			</div>
			<div class="row" style="margin-top:5px;">
				<div class="col-sm-3">
					<label class="fa fa-md">Remarks: </label>
				</div>
				<div class="col-sm-9">
					<textarea class="form-control" id="checked_by_remarks" name="checked_by_remarks"></textarea>
				</div>
			</div>
			<div class="row" style="margin-top:5px;">
				<div class="col-sm-3">
					<label class="fa fa-md">Approved By (LQC Asst. Manager or Manager):</label>
				</div>
				<div class="col-sm-9">
					<input type="text" class="form-control" id="approved_by" name="approved_by" required>
				</div>
			</div>
			<div class="row" style="margin-top:5px;">
				<div class="col-sm-3">
					<label class="fa fa-md">Remarks: </label>
				</div>
				<div class="col-sm-9">
					<textarea class="form-control" id="approved_by_remarks" name="approved_by_remarks"></textarea>
				</div>
			</div>
			<div class="profile-info-title h4" >
				Production Fill-in
			</div>
			<hr class="graph-green" style="margin-top:0px;">
			<div class="row" style="margin-top:5px;">
				<div class="col-sm-2">
					<label class="fa fa-md">Sorted Qty.: </label>
				</div>
				<div class="col-sm-2">
					<input type="number" class="form-control" id="sorted_qty" name="sorted_qty" min="0" required>
				</div>
				<div class="col-sm-2">
					<label class="fa fa-md">OK: </label>
					<input type="number" style="width:74%;display:inline-block;" class="form-control" id="ok_qty" name="ok_qty" min="0" required>
				</div>
				<div class="col-sm-2">
					<label class="fa fa-md">NG: </label>
					<input type="number" style="width:74%;display:inline-block;" class="form-control" id="ng_qty" name="ng_qty" min="0" required>
				</div>
				<div class="col-sm-4">
					<button type="button" name="add_mode_defect" class="btn btn-primary fa fa-plus" style="width:100%; margin-bottom:2%" disabled> Mode of Defect</button>
				</div>
			</div>			
			<div class="row" style="margin-top:5px;">
				<div class="col-sm-2">
					<label class="fa fa-md">Guaranteed Lot: </label>
				</div>
				<div class="col-sm-10">
					<textarea class="form-control" id="guaranteed_lot" name="guaranteed_lot" required></textarea>
				</div>
			</div>				
			<div class="row" style="margin-top:5px;">
				<div class="col-sm-2">
					<label class="fa fa-md">Remarks: </label>
				</div>
				<div class="col-sm-10">
					<textarea class="form-control" id="production_remarks" name="production_remarks"></textarea>
				</div>
			</div>			
			<div class="row" style="margin-top:5px;">
				<div class="col-sm-2">
					<label class="fa fa-md">Attachment: </label>
				</div>
				<div class="col-sm-10">
					<input type="file" class="form-control" name="file_lon" id="file_lon" required>		
				</div>
			</div>			
		  </div>
		  <div class="modal-footer">
			<button type="submit" class="btn btn-primary fa fa-save" id=""> Save</button>
			<button type="button" class="btn btn-default fa fa-close" data-dismiss="modal"> Close</button>
		  </div>
		</form><!-- /#frm_upload_measdata -->
    </div><!-- /.modal-content -->
  </div><!-- /.modal-dialog -->
</div><!-- /.modal -->

<div class="modal fade" tabindex="-1" role="dialog" id="modal_lon_production_edit">
  <div class="modal-dialog modal-lg" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
        <h4 class="modal-title"><i class="fa fa-upload"></i> View Lot-out Notice</h4>
      </div>
	  <div class="modal-body" style="overflow:inherit;">
		<form id="frm_lqc_production_edit" method="post" enctype="multipart/form-data">
			<div class="profile-info-title h4" >
				OQC Fill-in
			</div>
			<hr class="graph-orange" style="margin-top:0px;">
			<div class="row" style="margin-top:5px;">		
				<div class="col-sm-2">
					<label class="fa fa-md">Section: </label>
				</div>
				<div class="col-sm-4">
					<input type="text" class="form-control" id="section" name="section" readonly required>
				</div>
				<div class="col-sm-2">
					<label class="fa fa-md">LON No.: </label>
				</div>
				<div class="col-sm-4">
					<input type="text" class="form-control" id="lon_no" name="lon_no" readonly required>
				</div>
			</div>
			<div class="row">
				<div class="col-sm-2">
					<label class="fa fa-md">Attention: </label>
				</div>
				<div class="col-sm-10">
					<input type="text" class="form-control" id="attention" name="attention" readonly required>
				</div>
			</div>
			<div class="row" style="margin-top:5px;">
				<div class="col-sm-2">
					<label class="fa fa-md">Defect Mode: </label>
				</div>
				<div class="col-sm-4">
					<input type="text" class="form-control" id="defect_mode" name="defect_mode" readonly required>
				</div>
				<div class="col-sm-2">
					<label class="fa fa-md">Lot Submission: </label>
				</div>
				<div class="col-sm-4">
					<input type="text" class="form-control" id="lot_submission" name="lot_submission" readonly required>
				</div>
				<div class="col-sm-2">
					<label class="fa fa-md">Line: </label>
				</div>
				<div class="col-sm-4">
					<input type="text" class="form-control" id="line" name="line" readonly required>
				</div>
				<div class="col-sm-2">
					<label class="fa fa-md"><b>CAPA Due Date: </b></label>
				</div>
				<div class="col-sm-4">
					<input type="date" class="form-control" id="capa_due_date" name="capa_due_date" min="<?php echo date('Y-m-d'); ?>" readonly required>
				</div>
			</div>
			<div class="row">
				<div class="col-sm-2">
					<label class="fa fa-md">PO Number: </label>
				</div>
				<div class="col-sm-4">
					<input type="text" class="form-control" id="po_number" name="po_number" readonly required>
				</div>
				<div class="col-sm-2">
					<label class="fa fa-md">Series Name: </label>
				</div>
				<div class="col-sm-4">
					<input type="text" class="form-control" id="device_name" name="device_name" readonly required>
				</div>
				<div class="col-sm-2">
					<label class="fa fa-md">Lot Number: </label>
				</div>
				<div class="col-sm-4">
					<input type="text" class="form-control" id="lot_number" name="lot_number" readonly required>
				</div>
				<div class="col-sm-2">
					<label class="fa fa-md">Lot Qty.: </label>
				</div>
				<div class="col-sm-4">
					<input type="number" class="form-control" id="lot_qty" name="lot_qty" readonly required>
				</div>
				<div class="col-sm-2">
					<label class="fa fa-md">AQL: </label>
				</div>
				<div class="col-sm-4">
					<input type="number" class="form-control" id="aql" name="aql" value="1" step="0.01" readonly required>
				</div>
				<div class="col-sm-2">
					<label class="fa fa-md">Sample Size: </label>
				</div>
				<div class="col-sm-4">
					<input type="text" class="form-control" id="sample_size" name="sample_size" readonly required>
				</div>
				<div class="col-sm-2">
					<label class="fa fa-md">Date Inspected: </label>
				</div>
				<div class="col-sm-4">
					<input type="date" class="form-control" id="date_inspected" max="<?php echo date('Y-m-d'); ?>" name="date_inspected" readonly required>
				</div>
				<div class="col-sm-2">
					<label class="fa fa-md">Defect Qty.: </label>
				</div>
				<div class="col-sm-4">
					<input type="number" class="form-control" id="defect_qty" min="0" name="defect_qty" readonly required>
				</div>
			</div>
			<div class="row">
				<div class="col-sm-2">
					<label class="fa fa-md">Reel/Batch #: </label>
				</div>
				<div class="col-sm-4">
					<input type="text" class="form-control" id="reel_batch_no" name="reel_batch_no" readonly required>
				</div>
				<div class="col-sm-2">
					<label class="fa fa-md">Concern Operator: </label>
				</div>
				<div class="col-sm-4">
					<input type="text" class="form-control" id="operator" name="operator" readonly required>
				</div>
			</div>
			<div class="row" style="margin-top:5px;">
				<div class="col-sm-2">
					<label class="fa fa-md">Verified By: </label>
				</div>
				<div class="col-sm-4">
					<input type="text" class="form-control" id="verified_by" name="verified_by" readonly required>
				</div>
				<div class="col-sm-2">
					<label class="fa fa-md">Disposition on Affected Lot: </label>
				</div>
				<div class="col-sm-4">
					<input type="text" class="form-control" id="disposition" name="disposition" readonly required>
				</div>
			</div>
			<div class="row" style="margin-top:5px;">
				<div class="col-sm-2">
					<label class="fa fa-md">Remarks: </label>
				</div>
				<div class="col-sm-10">
					<textarea class="form-control" id="remarks" name="remarks" readonly></textarea>
				</div>
			</div>	
			<div class="row" style="margin-top:5px;">
				<div class="col-sm-2">
					<label class="fa fa-md">Attachment: </label>
				</div>
				<div class="col-sm-4">
					<button type="button" class="btn btn-link fa fa-paperclip" id="pkid" name="pkid" data-id="inspector"> Attachment</button>
				</div>
			</div>
			<hr class="graph-blue" style="margin-top:0px;">
			<div class="row" style="margin-top:5px;">
				<div class="col-sm-3">
					<label class="fa fa-md">Prepared By (LQC Inspector):</label>
				</div>
				<div class="col-sm-9">
					<input type="text" class="form-control" id="created_by" name="created_by" readonly required>
				</div>
			</div>
			<div class="row" style="margin-top:5px;">
				<div class="col-sm-3">
					<label class="fa fa-md">Checked By (LQC Supervisor):</label>
				</div>
				<div class="col-sm-9">
					<input type="text" class="form-control" id="checked_by" name="checked_by" readonly required>
				</div>
			</div>
			<div class="row" style="margin-top:5px;">
				<div class="col-sm-3">
					<label class="fa fa-md">Remarks: </label>
				</div>
				<div class="col-sm-9">
					<textarea class="form-control" id="checked_by_remarks" name="checked_by_remarks" readonly></textarea>
				</div>
			</div>
			<div class="row" style="margin-top:5px;">
				<div class="col-sm-3">
					<label class="fa fa-md">Approved By (LQC Asst. Manager or Manager):</label>
				</div>
				<div class="col-sm-9">
					<input type="text" class="form-control" id="approved_by" name="approved_by" readonly required>
				</div>
			</div>
			<div class="row" style="margin-top:5px;">
				<div class="col-sm-3">
					<label class="fa fa-md">Remarks: </label>
				</div>
				<div class="col-sm-9">
					<textarea class="form-control" id="approved_by_remarks" name="approved_by_remarks" readonly></textarea>
				</div>
			</div>
			<div class="profile-info-title h4" >
				Production Fill-in
			</div>
			<hr class="graph-green" style="margin-top:0px;">
			<div class="row" style="margin-top:5px;">
				<div class="col-sm-2">
					<label class="fa fa-md">Sorted Qty.: </label>
				</div>
				<div class="col-sm-2">
					<input type="number" class="form-control" id="sorted_qty" name="sorted_qty" min="0" required>
				</div>
				<div class="col-sm-2">
					<label class="fa fa-md">OK: </label>
					<input type="number" style="width:74%;display:inline-block;" class="form-control" id="ok_qty" name="ok_qty" min="0" required>
				</div>
				<div class="col-sm-2">
					<label class="fa fa-md">NG: </label>
					<input type="number" style="width:74%;display:inline-block;" class="form-control" id="ng_qty" name="ng_qty" min="0" required>
				</div>
				<div class="col-sm-4">
					<button type="button" name="add_mode_defect" class="btn btn-primary fa fa-plus" style="width:100%; margin-bottom:2%" disabled> Mode of Defect</button>
				</div>
			</div>		
			<div class="row" style="margin-top:5px;">
				<div class="col-sm-2">
					<label class="fa fa-md">Guaranteed Lot: </label>
				</div>
				<div class="col-sm-10">
					<textarea class="form-control" id="guaranteed_lot" name="guaranteed_lot" required></textarea>
				</div>
			</div>				
			<div class="row" style="margin-top:5px;">
				<div class="col-sm-2">
					<label class="fa fa-md">Remarks: </label>
				</div>
				<div class="col-sm-10">
					<textarea class="form-control" id="production_remarks" name="production_remarks"></textarea>
				</div>
			</div>			
			<div class="row" style="margin-top:5px;">
				<div class="col-sm-2">
					<label class="fa fa-md">Attachment: </label>
				</div>
				<div class="col-sm-4">
					<input type="file" class="form-control" name="file_lon" id="file_lon" required>			
				</div>
				<div class="col-sm-6">
					<button type="button" class="btn btn-link fa fa-paperclip" id="pkid" name="pkid" data-id="production"> Attachments</button>		
				</div>
			</div>			
		  </div>
		  <div class="modal-footer">
			<button type="submit" class="btn btn-primary fa fa-save" id=""> Save</button>
			<button type="button" class="btn btn-default fa fa-close" data-dismiss="modal"> Close</button>
		  </div>
		</form><!-- /#frm_upload_measdata -->
    </div><!-- /.modal-content -->
  </div><!-- /.modal-dialog -->
</div><!-- /.modal -->

<div class="modal fade" tabindex="-1" role="dialog" id="modal_lon_production_mode_defect_add">
  <div class="modal-dialog modal-md" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
        <h4 class="modal-title"><i class="fa fa-plus"></i> Add Mode of Defect</h4>
      </div>
	  <form id="frm_lqc_production_mode_defect_add">
		  <div class="modal-body">
			<div class="row">
				<div class="col-sm-3">
					<label class="fa fa-md">Mode of Defect: </label>
				</div>
				<div class="col-sm-5">
					<input type="text" class="form-control" id="mode_defect" name="mode_defect" required>
				</div>
				<div class="col-sm-4">
					<button type="submit" class="btn btn-primary fa fa-plus" style="width:100%; margin-bottom:2%"> Add Mode of Defect</button>
				</div>
			</div>
			
			<div class="row">
				<div class="col-sm-12">
					<table class="table table-striped table-bordered table-condensed" id="tbl_mode_defect" style="width:100%;">
						<thead>
							<th style="width:45%">Mode of Defect</th>
							<th style="width:10%">Remove</th>
						</thead>
						<tbody>
						</tbody>
					</table>
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

<div class="modal fade" tabindex="-1" role="dialog" id="modal_lon_production_mode_defect_edit" style="z-index:1051">
  <div class="modal-dialog modal-md" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
        <h4 class="modal-title"><i class="fa fa-eye"></i> View Mode of Defect</h4>
      </div>
	  <form id="frm_lqc_production_mode_defect_edit">
		  <div class="modal-body">
			<div class="col-sm-12">
				<div class="alert alert-success" style="" role="alert" id="">					
					<b>Click the "SAVE" button to save the changes</b>				
				</div>
			</div>
			<div class="row">
				<div class="col-sm-3">
					<label class="fa fa-md">Mode of Defect: </label>
				</div>
				<div class="col-sm-5">
					<input type="text" class="form-control" id="mode_defect" name="mode_defect" required>
				</div>
				<div class="col-sm-4">
					<button type="submit" class="btn btn-primary fa fa-plus" style="width:100%; margin-bottom:2%"> Add Mode of Defect</button>
				</div>
			</div>
			
			<div class="row">
				<div class="col-sm-12">
					<table class="table table-striped table-bordered table-condensed" id="tbl_mode_defect" style="width:100%;">
						<thead>
							<th style="width:45%">Mode of Defect</th>
							<th style="width:10%">Remove</th>
						</thead>
						<tbody>
						</tbody>
					</table>
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

<div class="modal fade" tabindex="-1" role="dialog" id="modal_lon_production_mode_defect_view" style="z-index:1051">
  <div class="modal-dialog modal-md" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
        <h4 class="modal-title"><i class="fa fa-eye"></i> View Mode of Defect</h4>
      </div>
	  <form id="frm_lqc_production_mode_defect_view">
		  <div class="modal-body">
			<div class="row">
				<div class="col-sm-12">
					<table class="table table-striped table-bordered table-condensed" id="tbl_mode_defect" style="width:100%;">
						<thead>
							<th style="width:45%">Mode of Defect</th>
						</thead>
						<tbody>
						</tbody>
					</table>
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

<div class="modal fade" tabindex="-1" role="dialog" id="modal_lon_lqc_inspector_production_view">
  <div class="modal-dialog modal-lg" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
        <h4 class="modal-title"><i class="fa fa-upload"></i> View Lot-out Notice</h4>
      </div>
	  <div class="modal-body" style="overflow:inherit;">
		<form id="frm_lqc_inspector_production" method="post" enctype="multipart/form-data">
			<div class="profile-info-title h4" >
				OQC Fill-in
			</div>
			<hr class="graph-orange" style="margin-top:0px;">
			<div class="row" style="margin-top:5px;">		
				<div class="col-sm-2">
					<label class="fa fa-md">Section: </label>
				</div>
				<div class="col-sm-4">
					<input type="text" class="form-control" id="section" name="section" required readonly>
				</div>
				<div class="col-sm-2">
					<label class="fa fa-md">LON No.: </label>
				</div>
				<div class="col-sm-4">
					<input type="text" class="form-control" id="lon_no" name="lon_no" required readonly>
				</div>
			</div>
			<div class="row">
				<div class="col-sm-2">
					<label class="fa fa-md">Attention: </label>
				</div>
				<div class="col-sm-10">
					<input type="text" class="form-control" id="attention" name="attention" required readonly>
				</div>
			</div>
			<div class="row" style="margin-top:5px;">
				<div class="col-sm-2">
					<label class="fa fa-md">Defect Mode: </label>
				</div>
				<div class="col-sm-4">
					<input type="text" class="form-control" id="defect_mode" name="defect_mode" required readonly>
				</div>
				<div class="col-sm-2">
					<label class="fa fa-md">Lot Submission: </label>
				</div>
				<div class="col-sm-4">
					<input type="text" class="form-control" id="lot_submission" name="lot_submission" required readonly>
				</div>
				<div class="col-sm-2">
					<label class="fa fa-md">Line: </label>
				</div>
				<div class="col-sm-4">
					<input type="text" class="form-control" id="line" name="line" required readonly>
				</div>
			</div>
			<div class="row">
				<div class="col-sm-2">
					<label class="fa fa-md">PO Number: </label>
				</div>
				<div class="col-sm-4">
					<input type="text" class="form-control" id="po_number" name="po_number" required readonly>
				</div>
				<div class="col-sm-2">
					<label class="fa fa-md">Series Name: </label>
				</div>
				<div class="col-sm-4">
					<input type="text" class="form-control" id="device_name" name="device_name" required readonly>
				</div>
				<div class="col-sm-2">
					<label class="fa fa-md">Lot Number: </label>
				</div>
				<div class="col-sm-4">
					<input type="text" class="form-control" id="lot_number" name="lot_number" required readonly>
				</div>
				<div class="col-sm-2">
					<label class="fa fa-md">Lot Qty.: </label>
				</div>
				<div class="col-sm-4">
					<input type="number" class="form-control" id="lot_qty" name="lot_qty" required readonly>
				</div>
				<div class="col-sm-2">
					<label class="fa fa-md">AQL: </label>
				</div>
				<div class="col-sm-4">
					<input type="number" class="form-control" id="aql" name="aql" value="1" step="0.01" readonly required>
				</div>
				<div class="col-sm-2">
					<label class="fa fa-md">Sample Size: </label>
				</div>
				<div class="col-sm-4">
					<input type="text" class="form-control" id="sample_size" name="sample_size" required readonly>
				</div>
				<div class="col-sm-2">
					<label class="fa fa-md">Date Inspected: </label>
				</div>
				<div class="col-sm-4">
					<input type="date" class="form-control" id="date_inspected" max="<?php echo date('Y-m-d'); ?>" name="date_inspected" required readonly>				</div>
				<div class="col-sm-2">
					<label class="fa fa-md">Concern Operator: </label>
				</div>
				<div class="col-sm-4">
					<input type="text" class="form-control" id="operator" name="operator" required readonly>
				</div>
			</div>
			<div class="row">
				<div class="col-sm-2">
					<label class="fa fa-md">Reel/Batch #: </label>
				</div>
				<div class="col-sm-4">
					<input type="text" class="form-control" id="reel_batch_no" name="reel_batch_no" required readonly>
				</div>
				<div class="col-sm-2">
					<label class="fa fa-md">Disposition on Affected Lot: </label>
				</div>
				<div class="col-sm-4">
					<input type="text" class="form-control" id="disposition" name="disposition" required readonly>
				</div>
			</div>
			<div class="row" style="margin-top:5px;">
				<div class="col-sm-2">
					<label class="fa fa-md">Verified By: </label>
				</div>
				<div class="col-sm-4">
					<input type="text" class="form-control" id="verified_by" name="verified_by" required readonly>
				</div>
				<div class="col-sm-2">
					<label class="fa fa-md">CAPA Due Date: </label>
				</div>
				<div class="col-sm-4">
					<input type="date" class="form-control" id="capa_due_date" name="capa_due_date" min="<?php echo date('Y-m-d'); ?>" required readonly>
				</div>
			</div>
			<div class="row" style="margin-top:5px;">
				<div class="col-sm-2">
					<label class="fa fa-md">Remarks: </label>
				</div>
				<div class="col-sm-10">
					<textarea class="form-control" id="remarks" name="remarks" readonly></textarea>
				</div>
			</div>
			<div class="profile-info-title h4" >
				Signatories
			</div>
			<hr class="graph-blue" style="margin-top:0px;">
			<div class="row" style="margin-top:5px;">
				<div class="col-sm-3">
					<label class="fa fa-md">Prepared By (LQC Inspector):</label>
				</div>
				<div class="col-sm-9">
					<input type="text" class="form-control" id="created_by" name="created_by" required readonly>
				</div>
			</div>
			<div class="row" style="margin-top:5px;">
				<div class="col-sm-3">
					<label class="fa fa-md">Checked By (LQC Supervisor):</label>
				</div>
				<div class="col-sm-9">
					<input type="text" class="form-control" id="checked_by" name="checked_by" required readonly>
				</div>
			</div>
			<div class="row" style="margin-top:5px;">
				<div class="col-sm-3">
					<label class="fa fa-md">Remarks: </label>
				</div>
				<div class="col-sm-9">
					<textarea class="form-control" id="checked_by_remarks" name="checked_by_remarks" readonly></textarea>
				</div>
			</div>
			<div class="row" style="margin-top:5px;">
				<div class="col-sm-3">
					<label class="fa fa-md">Approved By (LQC Asst. production or production):</label>
				</div>
				<div class="col-sm-9">
					<input type="text" class="form-control" id="approved_by" name="approved_by" required readonly>
				</div>
			</div>
			<div class="row" style="margin-top:5px;">
				<div class="col-sm-3">
					<label class="fa fa-md">Remarks: </label>
				</div>
				<div class="col-sm-9">
					<textarea class="form-control" id="approved_by_remarks" name="approved_by_remarks" readonly></textarea>
				</div>
			</div>
			<div class="profile-info-title h4" >
				Production Fill-in
			</div>
			<hr class="graph-green" style="margin-top:0px;">
			<div class="row" style="margin-top:5px;">
				<div class="col-sm-2">
					<label class="fa fa-md">Sorted Qty.: </label>
				</div>
				<div class="col-sm-2">
					<input type="number" class="form-control" id="sorted_qty" name="sorted_qty" min="0" required>
				</div>
				<div class="col-sm-2">
					<label class="fa fa-md">OK: </label>
					<input type="number" style="width:74%;display:inline-block;" class="form-control" id="ok_qty" name="ok_qty" min="0" required>
				</div>
				<div class="col-sm-2">
					<label class="fa fa-md">NG: </label>
					<input type="number" style="width:74%;display:inline-block;" class="form-control" id="ng_qty" name="ng_qty" min="0" required>
				</div>
				<div class="col-sm-4">
					<button type="button" name="add_mode_defect" class="btn btn-default fa fa-eye" style="width:100%; margin-bottom:2%" disabled> Mode of Defect</button>
				</div>
			</div>		
			<div class="row" style="margin-top:5px;">
				<div class="col-sm-2">
					<label class="fa fa-md">Guaranteed Lot: </label>
				</div>
				<div class="col-sm-10">
					<textarea class="form-control" id="guaranteed_lot" name="guaranteed_lot" required></textarea>
				</div>
			</div>				
			<div class="row" style="margin-top:5px;">
				<div class="col-sm-2">
					<label class="fa fa-md">Remarks: </label>
				</div>
				<div class="col-sm-10">
					<textarea class="form-control" id="production_remarks" name="production_remarks"></textarea>
				</div>
			</div>			
			<div class="row" style="margin-top:5px;">
				<div class="col-sm-2">
					<label class="fa fa-md">Attachment: </label>
				</div>
				<div class="col-sm-10">
					<button type="button" class="btn btn-link fa fa-paperclip" id="pkid" name="pkid"> Attachments</button>
				</div>
			</div>	
			<div class="profile-info-title h4" >
				OQC Fill-in (Result of Confirmation)
			</div>
			<hr class="graph-orange" style="margin-top:0px;">	
			<div class="row" style="margin-top:5px;">				
				<div class="col-sm-12">
					<div class="alert alert-danger" style="display:none;" role="alert" id="container_inspector_message">
						Please complete the data below
					</div>
				</div>	
				<div class="col-sm-2">
					<label class="fa fa-md">Treatment for affected lot: </label>
				</div>
				<div class="col-sm-10">
					<textarea class="form-control" id="treatment" name="treatment" required></textarea>
				</div>
			</div>
			<div class="row" style="margin-top:5px;">
				<div class="col-sm-2">
					<label class="fa fa-md">Verification result for corrective and preventive action: </label>
				</div>
				<div class="col-sm-10">
					<textarea class="form-control" id="verification_result" name="verification_result" required></textarea>
				</div>
			</div>	
			<div class="row" style="margin-top:5px;">	
				<div class="col-sm-12">
					<button type="button" class="btn btn-success fa fa-plus pull-right" id="add_capa_monitoring"> Add </button>
				</div>
			</div>
			<div class="row" style="margin-top:5px;">	
				<div class="col-sm-12">
					<table class="table table-condensed table-bordered" id="tbl_oqc_lon_capa_monitoring">
						<thead>
							<tr>
								<th><span class="fa fa-cogs"></span></th>
								<th>Status</th>
								<th>Corrective / Preventive Action</th>
								<th>In-charge</th>
								<th>Due Date</th>
								<th>Required Sumission Date</th>
								<th>Actual Sumission Date</th>
								<th>Remarks</th>
							</tr>
						</thead>
					</table>
				</div>
			</div>
		  </div>
		  <div class="modal-footer">
			<button type="button" class="btn btn-success fa fa-thumbs-o-up" id=""> Verify & Conform</button>
			<button type="button" class="btn btn-danger fa fa-thumbs-o-down" id=""> Not Acceptable</button>
			<button type="button" class="btn btn-default fa fa-close" data-dismiss="modal"> Close</button>
		  </div>
		</form><!-- /#frm_upload_measdata -->
    </div><!-- /.modal-content -->
  </div><!-- /.modal-dialog -->
</div><!-- /.modal -->

<div class="modal fade" tabindex="-1" role="dialog" id="modal_oqc_capa_monitoring">
  <div class="modal-dialog modal-md" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
        <h4 class="modal-title"><i class="fa fa-question-circle-o"></i>Capa Monitoring</h4>
      </div>
	  <form id="frm_oqc_capa_monitoring">
		  <!-- CORRECTIVE / PREVENTIVE ACTION -->
		  <div class="modal-body">
			<div class="row" style="margin-top:5px;">
				<div class="col-sm-2">
					<label class="fa fa-md">Oqc Lon Id: </label>
				</div>
				<div class="col-sm-10">
					<input type="number" class="form-control" id="oqc_lon_id" name="oqc_lon_id">
				</div>
			</div>	
			<div class="row" style="margin-top:5px;">
				<div class="col-sm-2">
					<label class="fa fa-md">Oqc Lon CapaMonitoring Id: </label>
				</div>
				<div class="col-sm-10">
					<input type="number" class="form-control" id="oqc_lon_capa_monitoring_id" name="oqc_lon_capa_monitoring_id">
				</div>
			</div>	
			<div class="row" style="margin-top:5px;">
				<div class="col-sm-2">
					<label class="fa fa-md">Corrective Preventive Action: </label>
				</div>
				<div class="col-sm-10">
					<textarea class="form-control" id="oqc_capa_action" name="oqc_capa_action" required></textarea>
				</div>
			</div>	
			<div class="row" style="margin-top:5px;">
				<div class="col-sm-2">
					<label class="fa fa-md">In charge: </label>
				</div>
				<div class="col-sm-10">
					<select class="form-control" id="oqc_capa_action_incharge" name="oqc_capa_action_incharge[]" style="width:100%;" multiple="multiple" required>
					</select>
				</div>
			</div>	
			<div class="row" style="margin-top:5px;">
				<div class="col-sm-2">
					<label class="fa fa-md">Due Date: </label>
				</div>
				<div class="col-sm-10">
					<input type="date" class="form-control" id="oqc_capa_due_date" name="oqc_capa_due_date" required>
				</div>
			</div>	
			<div class="row" style="margin-top:5px;">
				<div class="col-sm-2">
					<label class="fa fa-md">Status: </label>
				</div>
				<div class="col-sm-10">
					<select class="form-control" id="oqc_capa_Status" name="oqc_capa_status" required>
						<option value="N/A" disabled selected>-Select-</option>
						<option value="Open">Open</option>
						<option value="Closed">Closed</option>
					</select>
				</div>
			</div>	
			<div class="row" style="margin-top:5px;">
				<div class="col-sm-2">
					<label class="fa fa-md">Required Submission Date: </label>
				</div>
				<div class="col-sm-10">
					<input type="date" class="form-control" id="oqc_capa_req_sub_date" name="oqc_capa_req_sub_date" required>
				</div>
			</div>	
			<div class="row" style="margin-top:5px;">
				<div class="col-sm-2">
					<label class="fa fa-md">Actual Submission Date: </label>
				</div>
				<div class="col-sm-10">
					<input type="date" class="form-control" id="oqc_capa_actual_sub_date" name="oqc_capa_actual_sub_date" required>
				</div>
			</div>	
			<div class="row" style="margin-top:5px;">
				<div class="col-sm-2">
					<label class="fa fa-md">Remarks: </label>
				</div>
				<div class="col-sm-10">
					<input type="text" class="form-control" id="oqc_capa_remarks" name="oqc_capa_remarks" required>
				</div>
			</div>	
		  </div>
		  <div class="modal-footer">
			<button type="submit" class="btn btn-primary fa fa-save"> Save</button>
			<button type="button" class="btn btn-default fa fa-close" data-dismiss="modal" id="btn_close"> Close</button>
		  </div>
	  </form>
    </div><!-- /.modal-content -->
  </div><!-- /.modal-dialog -->
</div><!-- /.modal -->

<div class="modal fade" tabindex="-1" role="dialog" id="modal_lon_inspector_conformance_message">
  <div class="modal-dialog modal-md" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
        <h4 class="modal-title"><i class="fa fa-question-circle-o"></i> System Confirmation</h4>
      </div>
	  <form id="frm_lon_inspector_conformance_decision">
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

<div class="modal fade" tabindex="-1" role="dialog" id="modal_lon_cancel_message">
  <div class="modal-dialog modal-md" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
        <h4 class="modal-title"><i class="fa fa-question-circle-o"></i> System Confirmation</h4>
      </div>
	  <form id="frm_lon_cancel">
		  <div class="modal-body">
			<div class="row">			
				<div class="col-sm-12" id="">				
					<div class="alert alert-danger" role="alert">			
						<h4> Are you sure you want to cancel the report? </h4>
						<br>Reason:
						<textarea name="cancel_remarks" style="width:100%;" rows="4" required> </textarea>
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

<!-- Modal for system message -->
<div class="modal" tabindex="-1" role="dialog" id="modal_oqc_lon_system_message">
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

<!-- Modal for report generation -->
<div class="modal" tabindex="-1" role="dialog" id="modal_lon_report">
  <div class="modal-dialog modal-md" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
        <h4 class="modal-title fa fa-file-excel-o"> Generate Report</h4>
      </div>
      <form id="frm_lon_report">
      <div class="modal-body">
		<div class="row">
			<div class="col-sm-4">
				<label class="fa fa-md">Date from: </label>
			</div>
			<div class="col-sm-8">
				<input type="month" class="form-control" pattern="[0-9]*" id="date_from" required>
			</div>
		</div>
		<div class="row" style="padding-top:3px;">
			<div class="col-sm-4">
				<label class="fa fa-md">Date to: </label>
			</div>
			<div class="col-sm-8">
				<input type="month" class="form-control" pattern="[0-9]*" id="date_to" required>
			</div>
		</div>
      </div>
      <div class="modal-footer">
        <div id="div_countdown"></div>
		<button type="submit" class="btn btn-success fa fa-file-excel-o"> Export</button>
        <button type="button" class="btn btn-default fa fa-close" data-dismiss="modal"> Close</button>
      </div>
      </form>
    </div><!-- /.modal-content -->
  </div><!-- /.modal-dialog -->
</div><!-- /.modal -->

<div class="modal" tabindex="-1" role="dialog" id="modal_oqc_lon_advance_search">
  <div class="modal-dialog modal-lg" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
        <h4 class="modal-title fa fa-search"> Advance Search</h4>
      </div>
	  <form id="frm_oqc_lon_advance_search">
      <div class="modal-body">
		<button type="button" class="btn btn-default fa pull-left fa fa-eraser" id="btn_dir_as_reset"> Reset Search Value</button>
		<button type="button" class="btn btn-primary fa pull-right fa fa-plus" id="btn_dir_as_add"> Add</button><br /><br />
		<table class="table" id="tbl_oqc_lon_advance_search">
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

<script>
	
</script>