<?php
/* get user role */
$qcfr_lqc_access 	    = array("create" => false, 
									"read" => false,
									"update" => false,
									"delete" => false
									);
$subsystem_code 			= "QFR";
$module 					= "QCFR - LQC";
foreach($user_role['subsystem_code'] as $key => $subsystem_code ){
	if($subsystem_code == $subsystem_code && $user_role['module'][$key] == $module){ 
		if ($user_role['create'][$key] == 1){
			$qcfr_lqc_access['create'] = true;
		}
		if ($user_role['read'][$key] == 1){
			$qcfr_lqc_access['read'] = true;
		}
		if ($user_role['update'][$key] == 1){
			$qcfr_lqc_access['update'] = true;
		}
		if ($user_role['delete'][$key] == 1){
			$qcfr_lqc_access['delete'] = true;
		}
	}
}

$qcfr_lqc_supervisor_access 	= array("create" => false, 
									"read" => false,
									"update" => false,
									"delete" => false
									);
$subsystem_code 			= "QFR";
$module 					= "QCFR - LQC SUP";
foreach($user_role['subsystem_code'] as $key => $subsystem_code ){
	if($subsystem_code == $subsystem_code && $user_role['module'][$key] == $module){ 
		if ($user_role['create'][$key] == 1){
			$qcfr_lqc_supervisor_access['create'] = true;
		}
		if ($user_role['read'][$key] == 1){
			$qcfr_lqc_supervisor_access['read'] = true;
		}
		if ($user_role['update'][$key] == 1){
			$qcfr_lqc_supervisor_access['update'] = true;
		}
		if ($user_role['delete'][$key] == 1){
			$qcfr_lqc_supervisor_access['delete'] = true;
		}
	}
}

$qcfr_prdn_access 	= array("create" => false, 
									"read" => false,
									"update" => false,
									"delete" => false
									);
$subsystem_code 			= "QFR";
$module 					= "QCFR - PRDN";
foreach($user_role['subsystem_code'] as $key => $subsystem_code ){
	if($subsystem_code == $subsystem_code && $user_role['module'][$key] == $module){ 
		if ($user_role['create'][$key] == 1){
			$qcfr_prdn_access['create'] = true;
		}
		if ($user_role['read'][$key] == 1){
			$qcfr_prdn_access['read'] = true;
		}
		if ($user_role['update'][$key] == 1){
			$qcfr_prdn_access['update'] = true;
		}
		if ($user_role['delete'][$key] == 1){
			$qcfr_prdn_access['delete'] = true;
		}
	}
}
$qcfr_engr_access 	= array("create" => false, 
									"read" => false,
									"update" => false,
									"delete" => false
									);
$subsystem_code 			= "QFR";
$module 					= "QCFR - ENGR";
foreach($user_role['subsystem_code'] as $key => $subsystem_code ){
	if($subsystem_code == $subsystem_code && $user_role['module'][$key] == $module){ 
		if ($user_role['create'][$key] == 1){
			$qcfr_engr_access['create'] = true;
		}
		if ($user_role['read'][$key] == 1){
			$qcfr_engr_access['read'] = true;
		}
		if ($user_role['update'][$key] == 1){
			$qcfr_engr_access['update'] = true;
		}
		if ($user_role['delete'][$key] == 1){
			$qcfr_engr_access['delete'] = true;
		}
	}
}
$qcfr_secthead_access 	= array("create" => false, 
									"read" => false,
									"update" => false,
									"delete" => false
									);
$subsystem_code 			= "QFR";
$module 					= "QCFR - SECT HEAD";
foreach($user_role['subsystem_code'] as $key => $subsystem_code ){
	if($subsystem_code == $subsystem_code && $user_role['module'][$key] == $module){ 
		if ($user_role['create'][$key] == 1){
			$qcfr_secthead_access['create'] = true;
		}
		if ($user_role['read'][$key] == 1){
			$qcfr_secthead_access['read'] = true;
		}
		if ($user_role['update'][$key] == 1){
			$qcfr_secthead_access['update'] = true;
		}
		if ($user_role['delete'][$key] == 1){
			$qcfr_secthead_access['delete'] = true;
		}
	}
}

$qcfr_depthead_access 	= array("create" => false, 
									"read" => false,
									"update" => false,
									"delete" => false
									);
$subsystem_code 			= "QFR";
$module 					= "QCFR - DEPT HEAD";
foreach($user_role['subsystem_code'] as $key => $subsystem_code ){
	if($subsystem_code == $subsystem_code && $user_role['module'][$key] == $module){ 
		if ($user_role['create'][$key] == 1){
			$qcfr_depthead_access['create'] = true;
		}
		if ($user_role['read'][$key] == 1){
			$qcfr_depthead_access['read'] = true;
		}
		if ($user_role['update'][$key] == 1){
			$qcfr_depthead_access['update'] = true;
		}
		if ($user_role['delete'][$key] == 1){
			$qcfr_depthead_access['delete'] = true;
		}
	}
}

$qcfr_recipient_access 	= array("create" => false, 
									"read" => false,
									"update" => false,
									"delete" => false
									);
$subsystem_code 			= "QFR";
$module 					= "QCFR - RECIPIENT";
foreach($user_role['subsystem_code'] as $key => $subsystem_code ){
	if($subsystem_code == $subsystem_code && $user_role['module'][$key] == $module){ 
		if ($user_role['create'][$key] == 1){
			$qcfr_recipient_access['create'] = true;
		}
		if ($user_role['read'][$key] == 1){
			$qcfr_recipient_access['read'] = true;
		}
		if ($user_role['update'][$key] == 1){
			$qcfr_recipient_access['update'] = true;
		}
		if ($user_role['delete'][$key] == 1){
			$qcfr_recipient_access['delete'] = true;
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
				if($qcfr_lqc_access['read']){
					echo '<li role="presentation" class="'.$class_active.'"><a href="#qcfr_lqc_access" aria-controls="qcfr_lqc_access" role="tab" data-toggle="tab">LQC Inspector</a></li>';
					$class_active = '';
				}
				if($qcfr_lqc_supervisor_access['read']){
					echo '<li role="presentation" class="'.$class_active.'"><a href="#qcfr_lqc_supervisor_access" aria-controls="qcfr_lqc_supervisor_access role="tab" data-toggle="tab">LQC Supervisor</a></li>';
					$class_active = '';
				}
				if($qcfr_prdn_access['read']){
					echo '<li role="presentation" class="'.$class_active.'"><a href="#qcfr_prdn_access" aria-controls="qcfr_prdn_access" role="tab" data-toggle="tab">Production</a></li>';
					$class_active = '';
				}
				if($qcfr_engr_access['read']){
					echo '<li role="presentation" class="'.$class_active.'"><a href="#qcfr_engr_access" aria-controls="qcfr_engr_access" role="tab" data-toggle="tab">Engineering</a></li>';
					$class_active = '';
				}
				if($qcfr_secthead_access['read']){
					echo '<li role="presentation" class="'.$class_active.'"><a href="#qcfr_secthead_access" aria-controls="qcfr_secthead_access" role="tab" data-toggle="tab">Section Head</a></li>';
					$class_active = '';
				}
				if($qcfr_depthead_access['read']){
					echo '<li role="presentation" class="'.$class_active.'"><a href="#qcfr_depthead_access" aria-controls="qcfr_depthead_access" role="tab" data-toggle="tab">Department Head</a></li>';
					$class_active = '';
				}
				if($qcfr_recipient_access['read']){
					echo '<li role="presentation" class="'.$class_active.'"><a href="#qcfr_recipient_access" aria-controls="qcfr_recipient_access" role="tab" data-toggle="tab">Recipient</a></li>';
					$class_active = '';
				}
			?>
			
		</ul>
	</div>
</div>

<!-- Tab panes -->
<div class="tab-content">
	<?php
		$class_active = "active";
		if($qcfr_lqc_access['read']){
			echo '<div role="tabpanel" class="tab-pane '.$class_active.'" id="qcfr_lqc_access">	
					<div class="col-sm-12">
						<div class="panel panel-info">
							<div class="panel-heading"><i class="fa fa-file fa-lg"> Quality Complaint Feedback Report</i></div>
							<div class="panel-body">
								<div class="row">
									<div class="col-sm-9">
										<button class="btn btn-default fa fa-search" id="btn_qcfr_advanced_search"> Search</button>
									</div>
									<div class="col-sm-3">
										<button class="btn btn-default fa fa-plus pull-right" id="btn_add_qcfr"> New</button>
									</div>	
								</div><br />
								<div class="row">
									<div class="col-sm-12" style="overflow:auto;">
										<table class="table table-bordered table-condensed" id="tbl_qcfr">
											<thead>
												<tr>
													<th>Status</th>
													<th>QCFR No.</th>
													<th>Type</th>
													<th>Date Issued</th>
													<th>Product Details</th>
													<th>Disposition</th>
													<th>Date Answer Required</th>
													<th>Reported by</th>
													<th>Verified & Conformed by</th>
													<th>Approved by</th>
													<th>Checked by</th>
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
		if($qcfr_lqc_supervisor_access['read']){
			echo '<div role="tabpanel" class="tab-pane '.$class_active.'" id="qcfr_lqc_supervisor_access">	
					<div class="col-sm-12">
						<div class="panel panel-info">
							<div class="panel-heading"><i class="fa fa-file fa-lg"> Quality Complaint Feedback Report</i></div>
							<div class="panel-body">
								<div class="row">
									<div class="col-sm-9">
										<button class="btn btn-default fa fa-search" id="btn_qcfr_advanced_search"> Search</button>
									</div>
								</div><br />
								<div class="row">
									<div class="col-sm-12" style="overflow:auto;">
										<table class="table table-bordered table-condensed" id="tbl_qcfr_supervisor">
											<thead>
												<tr>
													<th>Status</th>
													<th>QCFR No.</th>
													<th>Type</th>
													<th>Date Issued</th>
													<th>Product Details</th>
													<th>Disposition</th>
													<th>Date Answer Required</th>
													<th>Reported by</th>
													<th>Verified & Conformed by</th>
													<th>Approved by</th>
													<th>Checked by</th>
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
		if($qcfr_prdn_access['read']){
			echo '<div role="tabpanel" class="tab-pane '.$class_active.'" id="qcfr_prdn_access">	
					<div class="col-sm-12">
						<div class="panel panel-info">
							<div class="panel-heading"><i class="fa fa-file fa-lg"> Quality Complaint Feedback Report</i></div>
							<div class="panel-body">
								<div class="row">
									<div class="col-sm-9">
										<button class="btn btn-default fa fa-search" id="btn_qcfr_advanced_search"> Search</button>
									</div>
								</div><br />
								<div class="row">
									<div class="col-sm-12" style="overflow:auto;">
										<table class="table table-bordered table-condensed" id="tbl_qcfr_production">
											<thead>
												<tr>
													<th>Status</th>
													<th>QCFR No.</th>
													<th>Type</th>
													<th>Date Issued</th>
													<th>Product Details</th>
													<th>Disposition</th>
													<th>Date Answer Required</th>
													<th>Reported by</th>
													<th>Verified & Conformed by</th>
													<th>Approved by</th>
													<th>Checked by</th>
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
		if($qcfr_engr_access['read']){
			echo '<div role="tabpanel" class="tab-pane '.$class_active.'" id="qcfr_engr_access">	
					<div class="col-sm-12">
						<div class="panel panel-info">
							<div class="panel-heading"><i class="fa fa-file fa-lg"> Quality Complaint Feedback Report</i></div>
							<div class="panel-body">
								<div class="row">
									<div class="col-sm-9">
										<button class="btn btn-default fa fa-search" id="btn_qcfr_advanced_search"> Search</button>
									</div>
								</div><br />
								<div class="row">
									<div class="col-sm-12" style="overflow:auto;">
										<table class="table table-bordered table-condensed" id="tbl_qcfr_engineering">
											<thead>
												<tr>
													<th>Status</th>
													<th>QCFR No.</th>
													<th>Type</th>
													<th>Date Issued</th>
													<th>Product Details</th>
													<th>Disposition</th>
													<th>Date Answer Required</th>
													<th>Reported by</th>
													<th>Verified & Conformed by</th>
													<th>Approved by</th>
													<th>Checked by</th>
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
		if($qcfr_secthead_access['read']){
			echo '<div role="tabpanel" class="tab-pane '.$class_active.'" id="qcfr_secthead_access">	
					<div class="col-sm-12">
						<div class="panel panel-info">
							<div class="panel-heading"><i class="fa fa-file fa-lg"> Quality Complaint Feedback Report</i></div>
							<div class="panel-body">
								<div class="row">
									<div class="col-sm-9">
										<button class="btn btn-default fa fa-search" id="btn_qcfr_advanced_search"> Search</button>
									</div>
								</div><br />
								<div class="row">
									<div class="col-sm-12" style="overflow:auto;">
										<table class="table table-bordered table-condensed" id="tbl_qcfr_secthead">
											<thead>
												<tr>
													<th>Status</th>
													<th>QCFR No.</th>
													<th>Type</th>
													<th>Date Issued</th>
													<th>Product Details</th>
													<th>Disposition</th>
													<th>Date Answer Required</th>
													<th>Reported by</th>
													<th>Verified & Conformed by</th>
													<th>Approved by</th>
													<th>Checked by</th>
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
		if($qcfr_depthead_access['read']){
			echo '<div role="tabpanel" class="tab-pane '.$class_active.'" id="qcfr_depthead_access">	
					<div class="col-sm-12">
						<div class="panel panel-info">
							<div class="panel-heading"><i class="fa fa-file fa-lg"> Quality Complaint Feedback Report</i></div>
							<div class="panel-body">
								<div class="row">
									<div class="col-sm-9">
										<button class="btn btn-default fa fa-search" id="btn_qcfr_advanced_search"> Search</button>
									</div>
								</div><br />
								<div class="row">
									<div class="col-sm-12" style="overflow:auto;">
										<table class="table table-bordered table-condensed" id="tbl_qcfr_depthead">
											<thead>
												<tr>
													<th>Status</th>
													<th>QCFR No.</th>
													<th>Type</th>
													<th>Date Issued</th>
													<th>Product Details</th>
													<th>Disposition</th>
													<th>Date Answer Required</th>
													<th>Reported by</th>
													<th>Verified & Conformed by</th>
													<th>Approved by</th>
													<th>Checked by</th>
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
		if($qcfr_recipient_access['read']){
			echo '<div role="tabpanel" class="tab-pane '.$class_active.'" id="qcfr_recipient_access">	
					<div class="col-sm-12">
						<div class="panel panel-info">
							<div class="panel-heading"><i class="fa fa-file fa-lg"> Quality Complaint Feedback Report</i></div>
							<div class="panel-body">
								<div class="row">
									<div class="col-sm-9">
										<button class="btn btn-default fa fa-search" id="btn_qcfr_advanced_search"> Search</button>
									</div>
								</div><br />
								<div class="row">
									<div class="col-sm-12" style="overflow:auto;">
										<table class="table table-bordered table-condensed" id="tbl_qcfr_recipient">
											<thead>
												<tr>
													<th>Status</th>
													<th>QCFR No.</th>
													<th>Type</th>
													<th>Date Issued</th>
													<th>Product Details</th>
													<th>Disposition</th>
													<th>Date Answer Required</th>
													<th>Reported by</th>
													<th>Verified & Conformed by</th>
													<th>Approved by</th>
													<th>Checked by</th>
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
		
	?>
</div>

<div class="modal" tabindex="-1" role="dialog" id="mdl_new_qcfr">
 <div class="modal-dialog modal-lg" role="document" style="width:80%;">
  <div class="modal-content">
   <div class="modal-header">
    <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
    <h4 class="modal-title fa fa-plus">Add Quality Complaint Feedback Report (QCFR)</h4>
   </div>
   <form id="frm_new_qcfr">
   <div class="modal-body">
		<div class="row">
			<div class="col-sm-6">
				<div class="row">
					<div class="col-sm-6">
						<div class="funkyradio" style="padding-bottom:5px;">
							<div class="funkyradio-primary">
								<input type="radio" name="subcon_pmi[]" id="chk_supplier_subcon" value="Supplier/Subcon">
								<label for="chk_supplier_subcon"> <b>Supplier/Subcon</b></label>
							</div>
						</div>
					</div>
					<div class="col-sm-6">
						<div class="funkyradio" style="padding-bottom:5px;">
							<div class="funkyradio-primary">
								<input type="radio" name="subcon_pmi[]" id="chk_assy" value="PMI Assy">
								<label for="chk_assy"> <b>PMI Assy</b></label>
							</div>
						</div>
					</div>
				</div>
				<div class="row">
					<div class="col-sm-4">
						<label class="control-label condensed">TO:</label>
					</div>
					<div class="col-sm-8">
						<select class="" id="cmb_to" name="to" style="width:100%;" required>
						</select>
					</div>
				</div>
				<div class="row" style="padding-top:5px;">
					<div class="col-sm-4">
						<label class="control-label condensed">ATTN:</label>
					</div>
					<div class="col-sm-8">
						<select class="" id="cmb_attn" name="attn[]" multiple="multiple" style="width:100%;" required>
						</select>
					</div>
				</div>
				<div class="row" style="padding-top:5px;">
					<div class="col-sm-4">
						<label class="control-label condensed">CC:</label>
					</div>
					<div class="col-sm-8">
						<div id="div_cc_supplier">
							<input type="text" class="form-control condensed" name="cc_supplier">
						</div>
						<div id="div_cc_pmi">
							<select class="" id="cmb_cc" name="cc_pmi[]" multiple="multiple" style="width:100%;">
							</select>
						</div>
					</div>
				</div>
				<div class="row" style="padding-top:5px;">
					<div class="col-sm-4">
						<label class="control-label condensed">FROM:</label>
					</div>
					<div class="col-sm-8">
						<select id="cmb_from" name="from" style="width:100%;" required>
						</select>
					</div>
				</div>
				<div class="row">
					<div class="col-sm-4">
						<label class="control-label condensed">DATE ISSUED:</label>
					</div>
					<div class="col-sm-8">
						<input type="date" max="<?php echo date('Y-m-d'); ?>" name="date_issued" class="form-control condensed" name="date_issued" required>
					</div>
				</div>
			</div>
			<div class="col-sm-6">
				<div class="row">
					<div class="col-sm-3" style="padding-right:0px;">
						<label class="control-label condensed"><b>Found During</b></label>
					</div>
					<div class="col-sm-9" style="">
						<div class="funkyradio">
							<div class="funkyradio-primary" >
								<input type="checkbox" name="found_during[]" id="chk_fd_outgoing_inspection" value="Outgoing Inspection">
								<label for="chk_fd_outgoing_inspection"> Outgoing Inspection</label>
							</div>
							<div class="funkyradio-primary">
								<input type="checkbox" name="found_during[]" id="chk_fd_incoming_inspection" value="Incoming Inspection">
								<label for="chk_fd_incoming_inspection"> Incoming Inspection</label>
							</div>
							<div class="funkyradio-primary">
								<input type="checkbox" name="found_during[]" id="chk_fd_in_process_inspection" value="In-Process Inspection">
								<label for="chk_fd_in_process_inspection"> In-Process Inspection</label>
							</div>
							<div class="funkyradio-primary">
								<input type="checkbox" name="found_during[]" id="chk_fd_quality_system_check" value="Quality System Check">
								<label for="chk_fd_quality_system_check"> Quality System Check</label>
							</div>
							<div class="funkyradio-primary">
								<input type="checkbox" name="found_during[]" id="chk_fd_others" value="Others. Please Specify">
								<label for="chk_fd_others"> Others. Please Specify</label>
							</div>
						</div>
						<input type="text" class="form-control condensed" name="found_during_others" placeholder="Others. Please Specify" disabled>
					</div>
				</div>
				<div class="row">
					<div class="col-sm-3" style="padding-right:0px;">
						<label class="control-label condensed"><b>Product Family</b></label>
					</div>
					<div class="col-sm-9" style="">
						<select class="form-control condensed" name="prod_family" style="width:100%;" required>
						</select>
					</div>
				</div>
			</div>
		</div>
		<hr class="graph-orange">
		<div class="row">
			<div class="col-sm-4">
				<label class="control-label condensed"> Reported by: </label>
			</div>
			<div class="col-sm-4">
				<label class="control-label condensed"> Verified & Conformed by: </label>
			</div>
			<div class="col-sm-4">
				<label class="control-label condensed"> Approved by: </label>
			</div>
		</div>
		<div class="row">
			<div class="col-sm-1">
				<label class="control-label condensed"> LQC </label>
			</div>
			<div class="col-sm-3">
				<input type="text" class="form-control condensed" name="reported_by" readonly>
			</div>
			<div class="col-sm-1">
				<label class="control-label condensed"> LQC Supervisor</label>
			</div>
			<div class="col-sm-3">
				<select class="" id="verified_conformed_by_lqc" name="verified_conformed_by_lqc[]" style="width:100%;" required>
				</select>
			</div>
			<div class="col-sm-1">
				<label class="control-label condensed"> Section Head</label>
			</div>
			<div class="col-sm-3">
				<select class="" id="approved_by_sh" name="approved_by_sh[]" style="width:100%;" required>
				</select>
			</div>
		</div>
		<div class="row" id="div_supplier_approvers">
			<div class="col-sm-1 col-sm-offset-4">
				<label class="control-label condensed"> Engineering </label>
			</div>
			<div class="col-sm-3">
				<select class="" id="verified_conformed_by_eng" name="verified_conformed_by_eng[]" multiple="multiple" style="width:100%;">
				</select>
			</div>
			<div class="col-sm-1">
				<label class="control-label condensed"> Dept. Head </label>
			</div>
			<div class="col-sm-3">
				<select class="" id="approved_by_dh" name="approved_by_dh[]" style="width:100%;">
				</select>
			</div>
		</div>
		<div class="row" id="div_supplier_approvers2">
			<div class="col-sm-1 col-sm-offset-4">
				<label class="control-label condensed"> Production </label>
			</div>
			<div class="col-sm-3">
				<select class="" id="verified_conformed_by_prdn" name="verified_conformed_by_prdn[]" multiple="multiple" style="width:100%;">
				</select>
			</div>
		</div>
		<hr class="graph-blue">
		<div class="row">
			<div class="col-sm-5">
				<div class="row">
					<div class="col-sm-4">
						<label class="control-label condensed"> Product Name</label>
					</div>
					<div class="col-sm-8">
						<select class="form-control condensed" name="product_name" style="width:100%;" required>
						</select>
					</div>
				</div>
				<div class="row">
					<div class="col-sm-4">
						<label class="control-label condensed"> Model No.</label>
					</div>
					<div class="col-sm-8">
						<input type="text" class="form-control condensed" name="model_no" readonly>
					</div>
				</div>
				<div class="row">
					<div class="col-sm-4">
						<label class="control-label condensed"> Batch No./Lot No.</label>
					</div>
					<div class="col-sm-8">
						<select class="" id="batch_no_lot_no" name="batch_no_lot_no[]" multiple="multiple" style="width:100%;" required>
						</select>
					</div>
				</div>
				<div class="row">
					<div class="col-sm-4">
						<label class="control-label condensed"> P.O. No./ INV. No.</label>
					</div>
					<div class="col-sm-8">
						<input type="text" class="form-control" id="po_no_invoice_no" list="list_po_no_invoice_no" autocomplete="on" name="po_no_invoice_no" required>
						<datalist id="list_po_no_invoice_no"></datalist>
					</div>
				</div>
				<div class="row">
					<div class="col-sm-4">
						<label class="control-label condensed"> Date Received</label>
					</div>
					<div class="col-sm-8">
						<input type="date" class="form-control condensed" name="date_received" required>
					</div>
				</div>
			</div>
			<div class="col-sm-7">
				<div class="row">
					<div class="col-sm-3">
							<label class="control-label condensed"> Inspection Method</label>
					</div>
					<div class="col-sm-5">
						<div class="funkyradio">
							<div class="funkyradio-primary">
								<input type="radio" name="inspection_method[]" id="chk_sampling" value="Sampling">
								<label for="chk_sampling"> Sampling</label>
							</div>
						</div>
					</div>
					<div class="col-sm-4">
						<div class="funkyradio">
							<div class="funkyradio-primary">
								<input type="radio" name="inspection_method[]" id="chk_hundred_percent" value="100%">
								<label for="chk_hundred_percent"> 100%</label>
							</div>
						</div>
					</div>
				</div>
				<div class="row">
					<div class="col-sm-3">
						<label class="control-label condensed"> Sampling Plan</label>
					</div>
					<div class="col-sm-1">
						<label class="control-label condensed"> AQL=</label>
					</div>
					<div class="col-sm-2">
						<input type="number" class="form-control condensed" name="sampling_plan_aql" min="0">
					</div>
					<div class="col-sm-2">
						<label class="control-label condensed"> n=</label>						
						<input type="number" class="form-control condensed" name="sampling_plan_n" style="width:65%; display: inline-block" min="0" maxlength="5">
					</div>
					<div class="col-sm-2">
						<label class="control-label condensed"> Ac=</label>
						<input type="number" class="form-control condensed" name="sampling_plan_ac" style="width:65%; display: inline-block" min="0">
					</div>
					<div class="col-sm-2">
						<label class="control-label condensed"> Re=</label>
						<input type="number" class="form-control condensed" name="sampling_plan_re" style="width:65%; display: inline-block" min="0">
					</div>
				</div>
				<div class="row">
					<div class="col-sm-3">
						<label class="control-label condensed"> Affected Qty.</label>
					</div>
					<div class="col-sm-3">
						<input type="number" class="form-control condensed" name="affected_qty">
					</div>
					<div class="col-sm-3">
						<label class="control-label condensed"> % Defective</label>
					</div>
					<div class="col-sm-3">
						<input type="number" class="form-control condensed" name="defective_percentage" readonly>
					</div>
				</div>
				<div class="row">
					<div class="col-sm-3">
						<label class="control-label condensed"> Defective Qty.</label>
					</div>
					<div class="col-sm-3">
						<input type="number" class="form-control condensed" name="defective_qty" maxlength="5">
					</div>
					<div class="col-sm-3">
						<label class="control-label condensed"> No. of Occurrence</label>
					</div>
					<div class="col-sm-3">
						<select class="form-control condensed" name="no_of_occurence" style="width:100%;" required>
							<option value="">-</option>
							<option value="1st Occurrence">1st Occurrence</option>
							<option value="2nd Occurrence">2nd Occurrence</option>
							<option value="3rd Occurrence">3rd Occurrence</option>
							<option value="4th Occurrence">4th Occurrence</option>
							<option value="5th Occurrence">5th Occurrence</option>
							<option value="6th Occurrence">6th Occurrence</option>
							<option value="7th Occurrence">7th Occurrence</option>
							<option value="8th Occurrence">8th Occurrence</option>
							<option value="9th Occurrence">9th Occurrence</option>
							<option value="10th Occurrence">10th Occurrence</option>
						</select>
					</div>
				</div>
				<div class="row">
					<div class="col-sm-3">
						<label class="control-label condensed"> Date Encountered</label>
					</div>
					<div class="col-sm-3">
						<input type="date" class="form-control condensed" name="date_encountered" required>
					</div>
					<div class="col-sm-3">
						<label class="control-label condensed"> Ref. QCFR No.</label>
					</div>
					<div class="col-sm-3">
						<input type="text" class="form-control condensed" name="reference_qcfr_no">
					</div>
				</div>
			</div>
		</div>
		<hr class="graph-orange">	
		<div class="row">
			<div class="col-sm-12">
				<label class="control-label condensed"> <b> [ FAILURE / DEFECT DESCRIPTION ] NOTE: Use additional attachment if necessary </b></label>
			</div>
			<div class="col-sm-12">
				<textarea type="text" class="form-control condensed" name="failure_defect_description" required></textarea>
			</div>
			<div class="col-sm-2">
				<label class="control-label condensed"> File Attachment</label>
			</div>
			<div class="col-sm-10">
				<input type="file" class="form-control condensed" name="file_failure_defect_filename[]" multiple>
			</div>
		</div>	
		<hr class="graph-blue">
		<div class="row">
			<div class="col-sm-4">
				<div class="row">
					<div class="col-sm-12">
						<label class="control-label condensed"> <b>Disposition</b> </label>
					</div>
					<div class="col-sm-6">
						<div class="funkyradio">
							<div class="funkyradio-primary" >
								<input type="checkbox" name="disposition[]" id="chk_dispo_rework_repair" value="Rework/Repair">
								<label for="chk_dispo_rework_repair"> Rework/Repair</label>
							</div>
							<div class="funkyradio-primary">
								<input type="checkbox" name="disposition[]" id="chk_dispo_useasis" value="Use as is">
								<label for="chk_dispo_useasis"> Use as is</label>
							</div>
							<div class="funkyradio-primary">
								<input type="checkbox" name="disposition[]" id="chk_dispo_replace" value="Replace">
								<label for="chk_dispo_replace"> Replace</label>
							</div>
						</div>
					</div>
					<div class="col-sm-6">
						<div class="funkyradio">
							<div class="funkyradio-primary" >
								<input type="checkbox" name="disposition[]" id="chk_dispo_return" value="Return">
								<label for="chk_dispo_return"> Return</label>
							</div>
							<div class="funkyradio-primary">
								<input type="checkbox" name="disposition[]" id="chk_dispo_sorting" value="100% sorting">
								<label for="chk_dispo_sorting"> 100% sorting</label>
							</div>
							<div class="funkyradio-primary">
								<input type="checkbox" name="disposition[]" id="chk_dispo_others" value="Others (specify)">
								<label for="chk_dispo_others"> Others (specify)</label>
							</div>
							<input type="text" class="form-control condensed" name="disposition_others" placeholder="Others. Please Specify" disabled>
						</div>
					</div>
				</div>
			</div>		
			<div class="col-sm-4">
				<div class="row">
					<div class="col-sm-12">
						<label class="control-label condensed"> <b>Nature of Request</b> </label>
					</div>
					<div class="col-sm-12">
						<div class="funkyradio">
							<div class="funkyradio-primary" >
								<input type="radio" name="nature_of_request[]" id="chk_nor_info_only" value="For Information only">
								<label for="chk_nor_info_only"> For Information only</label>
							</div>
							<div class="funkyradio-primary">
								<input type="radio" name="nature_of_request[]" id="chk_nor_submit_8d" value="Submit 8D report">
								<label for="chk_nor_submit_8d"> Submit 8D report</label>
							</div>
							<div class="funkyradio-primary">
								<input type="radio" name="nature_of_request[]" id="chk_nor_capa" value="Corrective & Preventive Action Report">
								<label for="chk_nor_capa"> Corrective & Preventive Action Report</label>
							</div>
						</div>
					</div>
				</div>
			</div>	
			<div class="col-sm-4">
				<div class="row">
					<div class="col-sm-12">
						<label class="control-label condensed"> <b>Answer</b> </label>
					</div>
					<div class="col-sm-12">
						<div class="funkyradio">
							<div class="funkyradio-primary" >
								<input type="radio" name="answer[]" id="chk_ans_need" value="Need">
								<label for="chk_ans_need"> Need</label>
							</div>
							<div class="funkyradio-primary">
								<input type="radio" name="answer[]" id="chk_ans_no_need" value="No Need">
								<label for="chk_ans_no_need"> No Need</label>
							</div>
						</div>
					</div>
					<div class="col-sm-5" id="div_date_answer_label">
						<label class="control-label condensed"> <b>Date Answer Required</b> </label>
					</div>
					<div class="col-sm-7" id="div_date_answer_input">
						<input type="date" max="<?php echo date('Y-m-d'); ?>" class="form-control condensed" name="date_answer_required" required>
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

<div class="modal" tabindex="-1" role="dialog" id="mdl_edit_qcfr">
 <div class="modal-dialog modal-lg" role="document" style="width:80%;">
  <div class="modal-content">
   <div class="modal-header">
    <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
    <h4 class="modal-title fa fa-edit">Edit Quality Complaint Feedback Report (QCFR)</h4>
   </div>
   <form id="frm_edit_qcfr">
   <div class="modal-body">
		<div class="row">
			<div class="col-sm-6">
				<div class="row">
					<div class="col-sm-6">
						<div class="funkyradio" style="padding-bottom:5px;">
							<div class="funkyradio-primary">
								<input type="radio" name="subcon_pmi[]" id="chk_supplier_subcon2" value="Supplier/Subcon">
								<label for="chk_supplier_subcon2"> <b>Supplier/Subcon</b></label>
							</div>
						</div>
					</div>
					<div class="col-sm-6">
						<div class="funkyradio" style="padding-bottom:5px;">
							<div class="funkyradio-primary">
								<input type="radio" name="subcon_pmi[]" id="chk_assy2" value="PMI Assy">
								<label for="chk_assy2"> <b>PMI Assy</b></label>
							</div>
						</div>
					</div>
				</div>
				<div class="row">
					<div class="col-sm-4">
						<label class="control-label condensed">TO:</label>
					</div>
					<div class="col-sm-8">
						<select class="" id="cmb_to" name="to" style="width:100%;" required>
						</select>
					</div>
				</div>
				<div class="row" style="padding-top:5px;">
					<div class="col-sm-4">
						<label class="control-label condensed">ATTN:</label>
					</div>
					<div class="col-sm-8">
						<select class="" id="cmb_attn" name="attn[]" multiple="multiple" style="width:100%;" required>
						</select>
					</div>
				</div>
				<div class="row" style="padding-top:5px;">
					<div class="col-sm-4">
						<label class="control-label condensed">CC:</label>
					</div>
					<div class="col-sm-8">
						<div id="div_cc_supplier">
							<input type="text" class="form-control condensed" name="cc_supplier">
						</div>
						<div id="div_cc_pmi">
							<select class="" id="cmb_cc" name="cc_pmi[]" multiple="multiple" style="width:100%;">
							</select>
						</div>
					</div>
				</div>
				<div class="row" style="padding-top:5px;">
					<div class="col-sm-4">
						<label class="control-label condensed">FROM:</label>
					</div>
					<div class="col-sm-8">
						<select id="cmb_from" name="from" style="width:100%;" required>
						</select>
					</div>
				</div>
				<div class="row">
					<div class="col-sm-4">
						<label class="control-label condensed">DATE ISSUED:</label>
					</div>
					<div class="col-sm-8">
						<input type="date" max="<?php echo date('Y-m-d'); ?>" name="date_issued" class="form-control condensed" name="date_issued" required>
					</div>
				</div>
			</div>
			<div class="col-sm-6">
				<div class="row">
					<div class="col-sm-3" style="padding-right:0px;">
						<label class="control-label condensed"><b>Found During</b></label>
					</div>
					<div class="col-sm-9" style="">
						<div class="funkyradio">
							<div class="funkyradio-primary" >
								<input type="checkbox" name="found_during[]" id="chk_fd_outgoing_inspection2" value="Outgoing Inspection">
								<label for="chk_fd_outgoing_inspection2"> Outgoing Inspection</label>
							</div>
							<div class="funkyradio-primary">
								<input type="checkbox" name="found_during[]" id="chk_fd_incoming_inspection2" value="Incoming Inspection">
								<label for="chk_fd_incoming_inspection2"> Incoming Inspection</label>
							</div>
							<div class="funkyradio-primary">
								<input type="checkbox" name="found_during[]" id="chk_fd_in_process_inspection2" value="In-Process Inspection">
								<label for="chk_fd_in_process_inspection2"> In-Process Inspection</label>
							</div>
							<div class="funkyradio-primary">
								<input type="checkbox" name="found_during[]" id="chk_fd_quality_system_check2" value="Quality System Check">
								<label for="chk_fd_quality_system_check2"> Quality System Check</label>
							</div>
							<div class="funkyradio-primary">
								<input type="checkbox" name="found_during[]" id="chk_fd_others2" value="Others. Please Specify">
								<label for="chk_fd_others2"> Others. Please Specify</label>
							</div>
						</div>
						<input type="text" class="form-control condensed" name="found_during_others" placeholder="Others. Please Specify" disabled>
					</div>
				</div>
				<div class="row">
					<div class="col-sm-3" style="padding-right:0px;">
						<label class="control-label condensed"><b>Product Family</b></label>
					</div>
					<div class="col-sm-9" style="">
						<select class="form-control condensed" name="prod_family" style="width:100%;" required>
						</select>
					</div>
				</div>
			</div>
		</div>
		<hr class="graph-orange">
		<div class="row">
			<div class="col-sm-4">
				<label class="control-label condensed"> Reported by: </label>
			</div>
			<div class="col-sm-4">
				<label class="control-label condensed"> Verified & Conformed by: </label>
			</div>
			<div class="col-sm-4">
				<label class="control-label condensed"> Approved by: </label>
			</div>
		</div>
		<div class="row">
			<div class="col-sm-1">
				<label class="control-label condensed"> LQC </label>
			</div>
			<div class="col-sm-3">
				<input type="text" class="form-control condensed" name="reported_by" readonly>
			</div>
			<div class="col-sm-1">
				<label class="control-label condensed"> LQC Supervisor</label>
			</div>
			<div class="col-sm-3">
				<select class="" id="verified_conformed_by_lqc" name="verified_conformed_by_lqc[]" style="width:100%;" required>
				</select>
			</div>
			<div class="col-sm-1">
				<label class="control-label condensed"> Section Head</label>
			</div>
			<div class="col-sm-3">
				<select class="" id="approved_by_sh" name="approved_by_sh[]" style="width:100%;" required>
				</select>
			</div>
		</div>
		<div class="row" id="div_supplier_approvers">
			<div class="col-sm-1 col-sm-offset-4">
				<label class="control-label condensed"> Engineering </label>
			</div>
			<div class="col-sm-3">
				<select class="" id="verified_conformed_by_eng" name="verified_conformed_by_eng[]" multiple="multiple" style="width:100%;">
				</select>
			</div>
			<div class="col-sm-1">
				<label class="control-label condensed"> Dept. Head </label>
			</div>
			<div class="col-sm-3">
				<select class="" id="approved_by_dh" name="approved_by_dh[]" style="width:100%;">
				</select>
			</div>
		</div>
		<div class="row" id="div_supplier_approvers2">
			<div class="col-sm-1 col-sm-offset-4">
				<label class="control-label condensed"> Production </label>
			</div>
			<div class="col-sm-3">
				<select class="" id="verified_conformed_by_prdn" name="verified_conformed_by_prdn[]" multiple="multiple" style="width:100%;">
				</select>
			</div>
		</div>
		<hr class="graph-blue">
		<div class="row">
			<div class="col-sm-5">
				<div class="row">
					<div class="col-sm-4">
						<label class="control-label condensed"> Product Name</label>
					</div>
					<div class="col-sm-8">
						<select class="form-control condensed" name="product_name" style="width:100%;" required>
						</select>
					</div>
				</div>
				<div class="row">
					<div class="col-sm-4">
						<label class="control-label condensed"> Model No.</label>
					</div>
					<div class="col-sm-8">
						<input type="text" class="form-control condensed" name="model_no" readonly>
					</div>
				</div>
				<div class="row">
					<div class="col-sm-4">
						<label class="control-label condensed"> Batch No./Lot No.</label>
					</div>
					<div class="col-sm-8">
						<select class="" id="batch_no_lot_no" name="batch_no_lot_no[]" multiple="multiple" style="width:100%;" required>
						</select>
					</div>
				</div>
				<div class="row">
					<div class="col-sm-4">
						<label class="control-label condensed"> P.O. No./ INV. No.</label>
					</div>
					<div class="col-sm-8">
						<input type="text" class="form-control" id="po_no_invoice_no" list="list_po_no_invoice_no2" autocomplete="on" name="po_no_invoice_no" required>
						<datalist id="list_po_no_invoice_no2"></datalist>
					</div>
				</div>
				<div class="row">
					<div class="col-sm-4">
						<label class="control-label condensed"> Date Received</label>
					</div>
					<div class="col-sm-8">
						<input type="date" class="form-control condensed" name="date_received" required>
					</div>
				</div>
			</div>
			<div class="col-sm-7">
				<div class="row">
					<div class="col-sm-3">
							<label class="control-label condensed"> Inspection Method</label>
					</div>
					<div class="col-sm-5">
						<div class="funkyradio">
							<div class="funkyradio-primary">
								<input type="radio" name="inspection_method[]" id="chk_sampling2" value="Sampling">
								<label for="chk_sampling2"> Sampling</label>
							</div>
						</div>
					</div>
					<div class="col-sm-4">
						<div class="funkyradio">
							<div class="funkyradio-primary">
								<input type="radio" name="inspection_method[]" id="chk_hundred_percent2" value="100%">
								<label for="chk_hundred_percent2"> 100%</label>
							</div>
						</div>
					</div>
				</div>
				<div class="row">
					<div class="col-sm-3">
						<label class="control-label condensed"> Sampling Plan</label>
					</div>
					<div class="col-sm-1">
						<label class="control-label condensed"> AQL=</label>
					</div>
					<div class="col-sm-2">
						<input type="number" class="form-control condensed" name="sampling_plan_aql" min="0">
					</div>
					<div class="col-sm-2">
						<label class="control-label condensed"> n=</label>						
						<input type="number" class="form-control condensed" name="sampling_plan_n" style="width:65%; display: inline-block" min="0" maxlength="5">
					</div>
					<div class="col-sm-2">
						<label class="control-label condensed"> Ac=</label>
						<input type="number" class="form-control condensed" name="sampling_plan_ac" style="width:65%; display: inline-block" min="0">
					</div>
					<div class="col-sm-2">
						<label class="control-label condensed"> Re=</label>
						<input type="number" class="form-control condensed" name="sampling_plan_re" style="width:65%; display: inline-block" min="0">
					</div>
				</div>
				<div class="row">
					<div class="col-sm-3">
						<label class="control-label condensed"> Affected Qty.</label>
					</div>
					<div class="col-sm-3">
						<input type="number" class="form-control condensed" name="affected_qty">
					</div>
					<div class="col-sm-3">
						<label class="control-label condensed"> % Defective</label>
					</div>
					<div class="col-sm-3">
						<input type="number" class="form-control condensed" name="defective_percentage" readonly>
					</div>
				</div>
				<div class="row">
					<div class="col-sm-3">
						<label class="control-label condensed"> Defective Qty.</label>
					</div>
					<div class="col-sm-3">
						<input type="number" class="form-control condensed" name="defective_qty" maxlength="5">
					</div>
					<div class="col-sm-3">
						<label class="control-label condensed"> No. of Occurrence</label>
					</div>
					<div class="col-sm-3">
						<select class="form-control condensed" name="no_of_occurence" style="width:100%;" required>
							<option value="">-</option>
							<option value="1st Occurrence">1st Occurrence</option>
							<option value="2nd Occurrence">2nd Occurrence</option>
							<option value="3rd Occurrence">3rd Occurrence</option>
							<option value="4th Occurrence">4th Occurrence</option>
							<option value="5th Occurrence">5th Occurrence</option>
							<option value="6th Occurrence">6th Occurrence</option>
							<option value="7th Occurrence">7th Occurrence</option>
							<option value="8th Occurrence">8th Occurrence</option>
							<option value="9th Occurrence">9th Occurrence</option>
							<option value="10th Occurrence">10th Occurrence</option>
						</select>
					</div>
				</div>
				<div class="row">
					<div class="col-sm-3">
						<label class="control-label condensed"> Date Encountered</label>
					</div>
					<div class="col-sm-3">
						<input type="date" class="form-control condensed" name="date_encountered" required>
					</div>
					<div class="col-sm-3">
						<label class="control-label condensed"> Ref. QCFR No.</label>
					</div>
					<div class="col-sm-3">
						<input type="text" class="form-control condensed" name="reference_qcfr_no">
					</div>
				</div>
			</div>
		</div>
		<hr class="graph-orange">	
		<div class="row">
			<div class="col-sm-12">
				<label class="control-label condensed"> <b> [ FAILURE / DEFECT DESCRIPTION ] NOTE: Use additional attachment if necessary </b></label>
			</div>
			<div class="col-sm-12">
				<textarea type="text" class="form-control condensed" name="failure_defect_description" required></textarea>
			</div>
			<div class="col-sm-2">
				<label class="control-label condensed"> File Attachment</label>
			</div>
			<div class="col-sm-5">
				<input type="file" class="form-control condensed" name="file_failure_defect_filename[]" multiple>
			</div>
			<div class="col-sm-5">
				<button type="button" class="btn btn-default btn-link" id="btn_fkfailure_file" name="fkfailure_file_path"> Download attachment</button>
			</div>
		</div>	
		<hr class="graph-blue">
		<div class="row">
			<div class="col-sm-4">
				<div class="row">
					<div class="col-sm-12">
						<label class="control-label condensed"> <b>Disposition</b> </label>
					</div>
					<div class="col-sm-6">
						<div class="funkyradio">
							<div class="funkyradio-primary" >
								<input type="checkbox" name="disposition[]" id="chk_dispo_rework_repair2" value="Rework/Repair">
								<label for="chk_dispo_rework_repair2"> Rework/Repair</label>
							</div>
							<div class="funkyradio-primary">
								<input type="checkbox" name="disposition[]" id="chk_dispo_useasis2" value="Use as is">
								<label for="chk_dispo_useasis2"> Use as is</label>
							</div>
							<div class="funkyradio-primary">
								<input type="checkbox" name="disposition[]" id="chk_dispo_replace2" value="Replace">
								<label for="chk_dispo_replace2"> Replace</label>
							</div>
						</div>
					</div>
					<div class="col-sm-6">
						<div class="funkyradio">
							<div class="funkyradio-primary" >
								<input type="checkbox" name="disposition[]" id="chk_dispo_return2" value="Return">
								<label for="chk_dispo_return2"> Return</label>
							</div>
							<div class="funkyradio-primary">
								<input type="checkbox" name="disposition[]" id="chk_dispo_sorting2" value="100% sorting">
								<label for="chk_dispo_sorting2"> 100% sorting</label>
							</div>
							<div class="funkyradio-primary">
								<input type="checkbox" name="disposition[]" id="chk_dispo_others2" value="Others (specify)">
								<label for="chk_dispo_others2"> Others (specify)</label>
							</div>
							<input type="text" class="form-control condensed" name="disposition_others" placeholder="Others. Please Specify" disabled>
						</div>
					</div>
				</div>
			</div>		
			<div class="col-sm-4">
				<div class="row">
					<div class="col-sm-12">
						<label class="control-label condensed"> <b>Nature of Request</b> </label>
					</div>
					<div class="col-sm-12">
						<div class="funkyradio">
							<div class="funkyradio-primary" >
								<input type="radio" name="nature_of_request[]" id="chk_nor_info_only2" value="For Information only">
								<label for="chk_nor_info_only2"> For Information only</label>
							</div>
							<div class="funkyradio-primary">
								<input type="radio" name="nature_of_request[]" id="chk_nor_submit_8d2" value="Submit 8D report">
								<label for="chk_nor_submit_8d2"> Submit 8D report</label>
							</div>
							<div class="funkyradio-primary">
								<input type="radio" name="nature_of_request[]" id="chk_nor_capa2" value="Corrective & Preventive Action Report">
								<label for="chk_nor_capa2"> Corrective & Preventive Action Report</label>
							</div>
						</div>
					</div>
				</div>
			</div>	
			<div class="col-sm-4">
				<div class="row">
					<div class="col-sm-12">
						<label class="control-label condensed"> <b>Answer</b> </label>
					</div>
					<div class="col-sm-12">
						<div class="funkyradio">
							<div class="funkyradio-primary" >
								<input type="radio" name="answer[]" id="chk_ans_need2" value="Need">
								<label for="chk_ans_need2"> Need</label>
							</div>
							<div class="funkyradio-primary">
								<input type="radio" name="answer[]" id="chk_ans_no_need2" value="No Need">
								<label for="chk_ans_no_need2"> No Need</label>
							</div>
						</div>
					</div>
					<div class="col-sm-5" id="div_date_answer_label">
						<label class="control-label condensed"> <b>Date Answer Required</b> </label>
					</div>
					<div class="col-sm-7" id="div_date_answer_input">
						<input type="date" max="<?php echo date('Y-m-d'); ?>" class="form-control condensed" name="date_answer_required">
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

<div class="modal" tabindex="-1" role="dialog" id="mdl_lqc_verified_conformed_qcfr">
 <div class="modal-dialog modal-lg" role="document" style="width:80%;">
  <div class="modal-content">
   <div class="modal-header">
    <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
    <h4 class="modal-title fa fa-eye">View Quality Complaint Feedback Report (QCFR)</h4>
   </div>
   <form id="frm_mdl_lqc_verified_conformed_qcfr">   
   <div class="modal-body">
		<div class="row">
			<div class="col-sm-6">
				<div class="row">
					<div class="col-sm-6">
						<div class="funkyradio" style="padding-bottom:5px;">
							<div class="funkyradio-primary">
								<input type="radio" name="subcon_pmi[]" id="chk_supplier_subcon" value="Supplier/Subcon">
								<label for="chk_supplier_subcon"> <b>Supplier/Subcon</b></label>
							</div>
						</div>
					</div>
					<div class="col-sm-6">
						<div class="funkyradio" style="padding-bottom:5px;">
							<div class="funkyradio-primary">
								<input type="radio" name="subcon_pmi[]" id="chk_assy" value="PMI Assy">
								<label for="chk_assy"> <b>PMI Assy</b></label>
							</div>
						</div>
					</div>
				</div>
				<div class="row">
					<div class="col-sm-4">
						<label class="control-label condensed">TO:</label>
					</div>
					<div class="col-sm-8">
						<input type="text" class="form-control condensed" name="to">
					</div>
				</div>
				<div class="row">
					<div class="col-sm-4">
						<label class="control-label condensed">ATTN:</label>
					</div>
					<div class="col-sm-8">
						<input type="text" class="form-control condensed" name="attn">
					</div>
				</div>
				<div class="row">
					<div class="col-sm-4">
						<label class="control-label condensed">CC:</label>
					</div>
					<div class="col-sm-8">
						<input type="text" class="form-control condensed" name="cc">
					</div>
				</div>
				<div class="row">
					<div class="col-sm-4">
						<label class="control-label condensed">FROM:</label>
					</div>
					<div class="col-sm-8">
						<input type="text" class="form-control condensed" name="from">
					</div>
				</div>
				<div class="row">
					<div class="col-sm-4">
						<label class="control-label condensed">DATE ISSUED:</label>
					</div>
					<div class="col-sm-8">
						<input type="date" class="form-control condensed" name="date_issued">
					</div>
				</div>
			</div>
			<div class="col-sm-6">
				<div class="row">
					<div class="col-sm-3" style="padding-right:0px;">
						<label class="control-label condensed"><b>Found During</b></label>
					</div>
					<div class="col-sm-9" style="">
						<div class="funkyradio">
							<div class="funkyradio-primary" >
								<input type="checkbox" name="found_during[]" id="chk_fd_outgoing_inspection" value="Outgoing Inspection">
								<label for="chk_fd_outgoing_inspection"> Outgoing Inspection</label>
							</div>
							<div class="funkyradio-primary">
								<input type="checkbox" name="found_during[]" id="chk_fd_incoming_inspection" value="Incoming Inspection">
								<label for="chk_fd_incoming_inspection"> Incoming Inspection</label>
							</div>
							<div class="funkyradio-primary">
								<input type="checkbox" name="found_during[]" id="chk_fd_in_process_inspection" value="In-Process Inspection">
								<label for="chk_fd_in_process_inspection"> In-Process Inspection</label>
							</div>
							<div class="funkyradio-primary">
								<input type="checkbox" name="found_during[]" id="chk_fd_quality_system_check" value="Quality System Check">
								<label for="chk_fd_quality_system_check"> Quality System Check</label>
							</div>
							<div class="funkyradio-primary">
								<input type="checkbox" name="found_during[]" id="chk_fd_others" value="Others. Please Specify">
								<label for="chk_fd_others"> Others. Please Specify</label>
							</div>
						</div>
						<input type="text" class="form-control condensed" name="found_during_others" placeholder="Others. Please Specify" disabled>
					</div>
				</div>				
				<div class="row">
					<div class="col-sm-3" style="padding-right:0px;">
						<label class="control-label condensed"><b>Product Family</b></label>
					</div>
					<div class="col-sm-9" style="">
						<input type="text" class="form-control condensed" name="prod_family" required>
					</div>
				</div>
			</div>
		</div>
		<hr class="graph-orange">
		<div class="row">
			<div class="col-sm-4">
				<label class="control-label condensed"> Reported by: </label>
			</div>
			<div class="col-sm-4">
				<label class="control-label condensed"> Verified & Conformed by: </label>
			</div>
			<div class="col-sm-4">
				<label class="control-label condensed"> Approved by: </label>
			</div>
		</div>
		<div class="row">
			<div class="col-sm-1">
				<label class="control-label condensed"> LQC </label>
			</div>
			<div class="col-sm-3">
				<input type="text" class="form-control condensed" name="reported_by">
			</div>
			<div class="col-sm-1">
				<label class="control-label condensed"> LQC </label>
			</div>
			<div class="col-sm-3">
				<input type="text" class="form-control condensed" name="verified_conformed_by_lqc">
			</div>
			<div class="col-sm-1">
				<label class="control-label condensed"> Section Head</label>
			</div>
			<div class="col-sm-3">
				<input type="text" class="form-control condensed" name="approved_by_sh">
			</div>
		</div>
		<div class="row" id="div_supplier_approvers">
			<div class="col-sm-1 col-sm-offset-4">
				<label class="control-label condensed"> Engineering </label>
			</div>
			<div class="col-sm-3">
				<input type="text" class="form-control condensed" name="verified_conformed_by_eng">
			</div>
			<div class="col-sm-1">
				<label class="control-label condensed"> Dept. Head </label>
			</div>
			<div class="col-sm-3">
				<input type="text" class="form-control condensed" name="approved_by_dh">
			</div>
		</div>
		<div class="row" id="div_supplier_approvers2">
			<div class="col-sm-1 col-sm-offset-4">
				<label class="control-label condensed"> Production </label>
			</div>
			<div class="col-sm-3">
				<input type="text" class="form-control condensed" name="verified_conformed_by_prdn">
			</div>
		</div>
		<hr class="graph-blue">
		<div class="row">
			<div class="col-sm-5">
				<div class="row">
					<div class="col-sm-4">
						<label class="control-label condensed"> Product Name</label>
					</div>
					<div class="col-sm-8">
						<input type="text" class="form-control condensed" name="product_name">
					</div>
				</div>
				<div class="row">
					<div class="col-sm-4">
						<label class="control-label condensed"> Model No.</label>
					</div>
					<div class="col-sm-8">
						<input type="text" class="form-control condensed" name="model_no">
					</div>
				</div>
				<div class="row">
					<div class="col-sm-4">
						<label class="control-label condensed"> Batch No./Lot No.</label>
					</div>
					<div class="col-sm-8">
						<input type="text" class="form-control condensed" name="batch_no_lot_no">
					</div>
				</div>
				<div class="row">
					<div class="col-sm-4">
						<label class="control-label condensed"> P.O. No./ INV. No.</label>
					</div>
					<div class="col-sm-8">
						<input type="text" class="form-control condensed" name="po_no_invoice_no">
					</div>
				</div>
				<div class="row">
					<div class="col-sm-4">
						<label class="control-label condensed"> Date Received</label>
					</div>
					<div class="col-sm-8">
						<input type="date" class="form-control condensed" name="date_received">
					</div>
				</div>
			</div>
			<div class="col-sm-7">
				<div class="row">
					<div class="col-sm-3">
							<label class="control-label condensed"> Inspection Method</label>
					</div>
					<div class="col-sm-5">
						<div class="funkyradio">
							<div class="funkyradio-primary">
								<input type="checkbox" name="inspection_method[]" id="chk_sampling" value="Sampling">
								<label for="chk_sampling"> Sampling</label>
							</div>
						</div>
					</div>
					<div class="col-sm-4">
						<div class="funkyradio">
							<div class="funkyradio-primary">
								<input type="checkbox" name="inspection_method[]" id="chk_hundred_percent" value="100%">
								<label for="chk_hundred_percent"> 100%</label>
							</div>
						</div>
					</div>
				</div>
				<div class="row">
					<div class="col-sm-3">
						<label class="control-label condensed"> Sampling Plan</label>
					</div>
					<div class="col-sm-1">
						<label class="control-label condensed"> AQL=</label>
					</div>
					<div class="col-sm-2">
						<input type="text" class="form-control condensed" name="sampling_plan_aql">
					</div>
					<div class="col-sm-2">
						<label class="control-label condensed"> n=</label>						
						<input type="text" class="form-control condensed" name="sampling_plan_n" style="width:65%; display: inline-block">
					</div>
					<div class="col-sm-2">
						<label class="control-label condensed"> Ac=</label>
						<input type="text" class="form-control condensed" name="sampling_plan_ac" style="width:65%; display: inline-block">
					</div>
					<div class="col-sm-2">
						<label class="control-label condensed"> Re=</label>
						<input type="text" class="form-control condensed" name="sampling_plan_re" style="width:65%; display: inline-block">
					</div>
				</div>
				<div class="row">
					<div class="col-sm-3">
						<label class="control-label condensed"> Affected Qty.</label>
					</div>
					<div class="col-sm-3">
						<input type="number" class="form-control condensed" name="affected_qty">
					</div>
					<div class="col-sm-3">
						<label class="control-label condensed"> % Defective</label>
					</div>
					<div class="col-sm-3">
						<input type="number" class="form-control condensed" name="defective_percentage">
					</div>
				</div>
				<div class="row">
					<div class="col-sm-3">
						<label class="control-label condensed"> Defective Qty.</label>
					</div>
					<div class="col-sm-3">
						<input type="number" class="form-control condensed" name="defective_qty">
					</div>
					<div class="col-sm-3">
						<label class="control-label condensed"> No. of Occurrence</label>
					</div>
					<div class="col-sm-3">
						<input type="text" class="form-control condensed" name="no_of_occurence">
					</div>
				</div>
				<div class="row">
					<div class="col-sm-3">
						<label class="control-label condensed"> Date Encountered</label>
					</div>
					<div class="col-sm-3">
						<input type="date" class="form-control condensed" name="date_encountered">
					</div>
					<div class="col-sm-3">
						<label class="control-label condensed"> Ref. QCFR No.</label>
					</div>
					<div class="col-sm-3">
						<input type="text" class="form-control condensed" name="reference_qcfr_no">
					</div>
				</div>
			</div>
		</div>
		<hr class="graph-orange">	
		<div class="row">
			<div class="col-sm-12">
				<label class="control-label condensed"> <b> [ FAILURE / DEFECT DESCRIPTION ] NOTE: Use additional attachment if necessary </b></label>
			</div>
			<div class="col-sm-12">
				<textarea type="text" class="form-control condensed" name="failure_defect_description"></textarea>
			</div>
			<div class="col-sm-2">
				<label class="control-label condensed"> File Attachment</label>
			</div>
			<div class="col-sm-10">
				<button type="button" class="btn btn-default btn-link" id="btn_fkfailure_file" name="fkfailure_file_path"> Download attachment</button>
			</div>
		</div>	
		<hr class="graph-blue">
		<div class="row">
			<div class="col-sm-4">
				<div class="row">
					<div class="col-sm-12">
						<label class="control-label condensed"> <b>Disposition</b> </label>
					</div>
					<div class="col-sm-6">
						<div class="funkyradio">
							<div class="funkyradio-primary" >
								<input type="checkbox" name="disposition[]" id="chk_dispo_rework_repair" value="Rework/Repair">
								<label for="chk_dispo_rework_repair"> Rework/Repair</label>
							</div>
							<div class="funkyradio-primary">
								<input type="checkbox" name="disposition[]" id="chk_dispo_useasis" value="Use as is">
								<label for="chk_dispo_useasis"> Use as is</label>
							</div>
							<div class="funkyradio-primary">
								<input type="checkbox" name="disposition[]" id="chk_dispo_replace" value="Replace">
								<label for="chk_dispo_replace"> Replace</label>
							</div>
						</div>
					</div>
					<div class="col-sm-6">
						<div class="funkyradio">
							<div class="funkyradio-primary" >
								<input type="checkbox" name="disposition[]" id="chk_dispo_return" value="Return">
								<label for="chk_dispo_return"> Return</label>
							</div>
							<div class="funkyradio-primary">
								<input type="checkbox" name="disposition[]" id="chk_dispo_sorting" value="100% sorting">
								<label for="chk_dispo_sorting"> 100% sorting</label>
							</div>
							<div class="funkyradio-primary">
								<input type="checkbox" name="disposition[]" id="chk_dispo_others" value="Others (specify)">
								<label for="chk_dispo_others"> Others (specify)</label>
							</div>
							<input type="text" class="form-control condensed" name="disposition_others" placeholder="Others. Please Specify" disabled>
						</div>
					</div>
				</div>
			</div>		
			<div class="col-sm-4">
				<div class="row">
					<div class="col-sm-12">
						<label class="control-label condensed"> <b>Nature of Request</b> </label>
					</div>
					<div class="col-sm-12">
						<div class="funkyradio">
							<div class="funkyradio-primary" >
								<input type="radio" name="nature_of_request[]" id="chk_nor_info_only" value="For Information only">
								<label for="chk_nor_info_only"> For Information only</label>
							</div>
							<div class="funkyradio-primary">
								<input type="radio" name="nature_of_request[]" id="chk_nor_submit_8d" value="Submit 8D report">
								<label for="chk_nor_submit_8d"> Submit 8D report</label>
							</div>
							<div class="funkyradio-primary">
								<input type="radio" name="nature_of_request[]" id="chk_nor_capa" value="Corrective & Preventive Action Report">
								<label for="chk_nor_capa"> Corrective & Preventive Action Report</label>
							</div>
						</div>
					</div>
				</div>
			</div>	
			<div class="col-sm-4">
				<div class="row">
					<div class="col-sm-12">
						<label class="control-label condensed"> <b>Answer</b> </label>
					</div>
					<div class="col-sm-12">
						<div class="funkyradio">
							<div class="funkyradio-primary" >
								<input type="radio" name="answer[]" id="chk_ans_need" value="Need">
								<label for="chk_ans_need"> Need</label>
							</div>
							<div class="funkyradio-primary">
								<input type="radio" name="answer[]" id="chk_ans_no_need" value="No Need">
								<label for="chk_ans_no_need"> No Need</label>
							</div>
						</div>
					</div>
					<div class="col-sm-5" id="div_date_answer_label">
						<label class="control-label condensed"> <b>Date Answer Required</b> </label>
					</div>
					<div class="col-sm-7" id="div_date_answer_input">
						<input type="date" class="form-control condensed" name="date_answer_required">
					</div>
				</div>
			</div>		
		</div>		
		<hr class="graph-orange">		
   </div>
   <div class="modal-footer">
	<button type="button" class="btn btn-success fa fa-thumbs-o-up" id=""> Accept</button>
	<button type="button" class="btn btn-danger fa fa-thumbs-o-down" id=""> Reject</button>
    <button type="button" class="btn btn-default fa fa-close" data-dismiss="modal"> Close</button>
   </div>
   </form>
  </div><!-- /.modal-content -->
 </div><!-- /.modal-dialog -->
</div><!-- /.modal -->

<div class="modal" tabindex="-1" role="dialog" id="mdl_lqc_verified_conformed_qcfr2">
 <div class="modal-dialog modal-lg" role="document" style="width:80%;">
  <div class="modal-content">
   <div class="modal-header">
    <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
    <h4 class="modal-title fa fa-eye">View Quality Complaint Feedback Report (QCFR)</h4>
   </div>
   <form id="frm_mdl_lqc_verified_conformed_qcfr2">   
   <div class="modal-body">
		<div class="row">
			<div class="col-sm-6">
				<div class="row">
					<div class="col-sm-6">
						<div class="funkyradio" style="padding-bottom:5px;">
							<div class="funkyradio-primary">
								<input type="radio" name="subcon_pmi[]" id="chk_supplier_subcon" value="Supplier/Subcon">
								<label for="chk_supplier_subcon"> <b>Supplier/Subcon</b></label>
							</div>
						</div>
						<div class="funkyradio" style="padding-top:5px;">
							<div class="funkyradio-primary">
								<input type="radio" name="subcon_pmi[]" id="chk_assy" value="PMI Assy">
								<label for="chk_assy"> <b>PMI Assy</b></label>
							</div>
						</div>
					</div>
					<div class="col-sm-6">						
						<input type="text" class="form-control condensed" name="supplier_subcon">
						<input type="text" class="form-control condensed" name="pmi_assy">
					</div>
				</div>
				<div class="row">
					<div class="col-sm-4">
						<label class="control-label condensed">TO:</label>
					</div>
					<div class="col-sm-8">
						<input type="text" class="form-control condensed" name="to">
					</div>
				</div>
				<div class="row">
					<div class="col-sm-4">
						<label class="control-label condensed">ATTN:</label>
					</div>
					<div class="col-sm-8">
						<input type="text" class="form-control condensed" name="attn">
					</div>
				</div>
				<div class="row">
					<div class="col-sm-4">
						<label class="control-label condensed">CC:</label>
					</div>
					<div class="col-sm-8">
						<input type="text" class="form-control condensed" name="cc">
					</div>
				</div>
				<div class="row">
					<div class="col-sm-4">
						<label class="control-label condensed">FROM:</label>
					</div>
					<div class="col-sm-8">
						<input type="text" class="form-control condensed" name="from">
					</div>
				</div>
				<div class="row">
					<div class="col-sm-4">
						<label class="control-label condensed">DATE ISSUED:</label>
					</div>
					<div class="col-sm-8">
						<input type="date" class="form-control condensed" name="date_issued">
					</div>
				</div>
			</div>
			<div class="col-sm-6">
				<div class="row">
					<div class="col-sm-3">
						<label class="control-label condensed"><b>QCFR No.:</b></label>
					</div>
					<div class="col-sm-9">
						<input type="text" class="form-control condensed" name="qcfr_no">
					</div>
				</div>
				<div class="row">
					<div class="col-sm-3" style="padding-right:0px;">
						<label class="control-label condensed"><b>Found During</b></label>
					</div>
					<div class="col-sm-9" style="">
						<div class="funkyradio">
							<div class="funkyradio-primary" >
								<input type="checkbox" name="found_during[]" id="chk_fd_outgoing_inspection" value="Outgoing Inspection">
								<label for="chk_fd_outgoing_inspection"> Outgoing Inspection</label>
							</div>
							<div class="funkyradio-primary">
								<input type="checkbox" name="found_during[]" id="chk_fd_incoming_inspection" value="Incoming Inspection">
								<label for="chk_fd_incoming_inspection"> Incoming Inspection</label>
							</div>
							<div class="funkyradio-primary">
								<input type="checkbox" name="found_during[]" id="chk_fd_in_process_inspection" value="In-Process Inspection">
								<label for="chk_fd_in_process_inspection"> In-Process Inspection</label>
							</div>
							<div class="funkyradio-primary">
								<input type="checkbox" name="found_during[]" id="chk_fd_quality_system_check" value="Quality System Check">
								<label for="chk_fd_quality_system_check"> Quality System Check</label>
							</div>
							<div class="funkyradio-primary">
								<input type="checkbox" name="found_during[]" id="chk_fd_others" value="Others. Please Specify">
								<label for="chk_fd_others"> Others. Please Specify</label>
							</div>
						</div>
						<input type="text" class="form-control condensed" name="found_during_others" placeholder="Others. Please Specify" disabled>
					</div>
				</div>
				<div class="row">
					<div class="col-sm-3" style="padding-right:0px;">
						<label class="control-label condensed"><b>Product Family</b></label>
					</div>
					<div class="col-sm-9" style="">
						<input type="text" class="form-control condensed" name="prod_family" required>
					</div>
				</div>
			</div>
		</div>
		<hr class="graph-orange">
		<div class="row">
			<div class="col-sm-4">
				<label class="control-label condensed"> Reported by: </label>
			</div>
			<div class="col-sm-4">
				<label class="control-label condensed"> Verified & Conformed by: </label>
			</div>
			<div class="col-sm-4">
				<label class="control-label condensed"> Approved by: </label>
			</div>
		</div>
		<div class="row">
			<div class="col-sm-1">
				<label class="control-label condensed"> LQC </label>
			</div>
			<div class="col-sm-3">
				<input type="text" class="form-control condensed" name="reported_by">
			</div>
			<div class="col-sm-1">
				<label class="control-label condensed"> LQC </label>
			</div>
			<div class="col-sm-3">
				<input type="text" class="form-control condensed" name="verified_conformed_by_lqc">
			</div>
			<div class="col-sm-1">
				<label class="control-label condensed"> Section Head</label>
			</div>
			<div class="col-sm-3">
				<input type="text" class="form-control condensed" name="approved_by_sh">
			</div>
		</div>
		<div class="row">
			<div class="col-sm-1 col-sm-offset-4">
				<label class="control-label condensed"> Engineering </label>
			</div>
			<div class="col-sm-3">
				<input type="text" class="form-control condensed" name="verified_conformed_by_eng">
			</div>
			<div class="col-sm-1">
				<label class="control-label condensed"> Dept. Head </label>
			</div>
			<div class="col-sm-3">
				<input type="text" class="form-control condensed" name="approved_by_dh">
			</div>
		</div>
		<div class="row">
			<div class="col-sm-1 col-sm-offset-4">
				<label class="control-label condensed"> Production </label>
			</div>
			<div class="col-sm-3">
				<input type="text" class="form-control condensed" name="verified_conformed_by_prdn">
			</div>
		</div>
		<hr class="graph-blue">
		<div class="row">
			<div class="col-sm-5">
				<div class="row">
					<div class="col-sm-4">
						<label class="control-label condensed"> Product Name</label>
					</div>
					<div class="col-sm-8">
						<input type="text" class="form-control condensed" name="product_name">
					</div>
				</div>
				<div class="row">
					<div class="col-sm-4">
						<label class="control-label condensed"> Model No.</label>
					</div>
					<div class="col-sm-8">
						<input type="text" class="form-control condensed" name="model_no">
					</div>
				</div>
				<div class="row">
					<div class="col-sm-4">
						<label class="control-label condensed"> Batch No./Lot No.</label>
					</div>
					<div class="col-sm-8">
						<input type="text" class="form-control condensed" name="batch_no_lot_no">
					</div>
				</div>
				<div class="row">
					<div class="col-sm-4">
						<label class="control-label condensed"> P.O. No./ INV. No.</label>
					</div>
					<div class="col-sm-8">
						<input type="text" class="form-control condensed" name="po_no_invoice_no">
					</div>
				</div>
				<div class="row">
					<div class="col-sm-4">
						<label class="control-label condensed"> Date Received</label>
					</div>
					<div class="col-sm-8">
						<input type="date" class="form-control condensed" name="date_received">
					</div>
				</div>
			</div>
			<div class="col-sm-7">
				<div class="row">
					<div class="col-sm-3">
							<label class="control-label condensed"> Inspection Method</label>
					</div>
					<div class="col-sm-5">
						<div class="funkyradio">
							<div class="funkyradio-primary">
								<input type="checkbox" name="inspection_method[]" id="chk_sampling" value="Sampling">
								<label for="chk_sampling"> Sampling</label>
							</div>
						</div>
					</div>
					<div class="col-sm-4">
						<div class="funkyradio">
							<div class="funkyradio-primary">
								<input type="checkbox" name="inspection_method[]" id="chk_hundred_percent" value="100%">
								<label for="chk_hundred_percent"> 100%</label>
							</div>
						</div>
					</div>
				</div>
				<div class="row">
					<div class="col-sm-3">
						<label class="control-label condensed"> Sampling Plan</label>
					</div>
					<div class="col-sm-1">
						<label class="control-label condensed"> AQL=</label>
					</div>
					<div class="col-sm-2">
						<input type="text" class="form-control condensed" name="sampling_plan_aql">
					</div>
					<div class="col-sm-2">
						<label class="control-label condensed"> n=</label>						
						<input type="text" class="form-control condensed" name="sampling_plan_n" style="width:65%; display: inline-block">
					</div>
					<div class="col-sm-2">
						<label class="control-label condensed"> Ac=</label>
						<input type="text" class="form-control condensed" name="sampling_plan_ac" style="width:65%; display: inline-block">
					</div>
					<div class="col-sm-2">
						<label class="control-label condensed"> Re=</label>
						<input type="text" class="form-control condensed" name="sampling_plan_re" style="width:65%; display: inline-block">
					</div>
				</div>
				<div class="row">
					<div class="col-sm-3">
						<label class="control-label condensed"> Affected Qty.</label>
					</div>
					<div class="col-sm-3">
						<input type="number" class="form-control condensed" name="affected_qty">
					</div>
					<div class="col-sm-3">
						<label class="control-label condensed"> % Defective</label>
					</div>
					<div class="col-sm-3">
						<input type="number" class="form-control condensed" name="defective_percentage">
					</div>
				</div>
				<div class="row">
					<div class="col-sm-3">
						<label class="control-label condensed"> Defective Qty.</label>
					</div>
					<div class="col-sm-3">
						<input type="number" class="form-control condensed" name="defective_qty">
					</div>
					<div class="col-sm-3">
						<label class="control-label condensed"> No. of Occurrence</label>
					</div>
					<div class="col-sm-3">
						<input type="text" class="form-control condensed" name="no_of_occurence">
					</div>
				</div>
				<div class="row">
					<div class="col-sm-3">
						<label class="control-label condensed"> Date Encountered</label>
					</div>
					<div class="col-sm-3">
						<input type="date" class="form-control condensed" name="date_encountered">
					</div>
					<div class="col-sm-3">
						<label class="control-label condensed"> Ref. QCFR No.</label>
					</div>
					<div class="col-sm-3">
						<input type="text" class="form-control condensed" name="reference_qcfr_no">
					</div>
				</div>
			</div>
		</div>
		<hr class="graph-orange">	
		<div class="row">
			<div class="col-sm-12">
				<label class="control-label condensed"> <b> [ FAILURE / DEFECT DESCRIPTION ] NOTE: Use additional attachment if necessary </b></label>
			</div>
			<div class="col-sm-12">
				<textarea type="text" class="form-control condensed" name="failure_defect_description"></textarea>
			</div>
			<div class="col-sm-2">
				<label class="control-label condensed"> File Attachment</label>
			</div>
			<div class="col-sm-10">
				
			</div>
		</div>	
		<hr class="graph-blue">
		<div class="row">
			<div class="col-sm-4">
				<div class="row">
					<div class="col-sm-12">
						<label class="control-label condensed"> <b>Disposition</b> </label>
					</div>
					<div class="col-sm-6">
						<div class="funkyradio">
							<div class="funkyradio-primary" >
								<input type="checkbox" name="disposition[]" id="chk_dispo_rework_repair" value="Rework/Repair">
								<label for="chk_dispo_rework_repair"> Rework/Repair</label>
							</div>
							<div class="funkyradio-primary">
								<input type="checkbox" name="disposition[]" id="chk_dispo_useasis" value="Use as is">
								<label for="chk_dispo_useasis"> Use as is</label>
							</div>
							<div class="funkyradio-primary">
								<input type="checkbox" name="disposition[]" id="chk_dispo_replace" value="Replace">
								<label for="chk_dispo_replace"> Replace</label>
							</div>
						</div>
					</div>
					<div class="col-sm-6">
						<div class="funkyradio">
							<div class="funkyradio-primary" >
								<input type="checkbox" name="disposition[]" id="chk_dispo_return" value="Return">
								<label for="chk_dispo_return"> Return</label>
							</div>
							<div class="funkyradio-primary">
								<input type="checkbox" name="disposition[]" id="chk_dispo_sorting" value="100% sorting">
								<label for="chk_dispo_sorting"> 100% sorting</label>
							</div>
							<div class="funkyradio-primary">
								<input type="checkbox" name="disposition[]" id="chk_dispo_others" value="Others (specify)">
								<label for="chk_dispo_others"> Others (specify)</label>
							</div>
							<input type="text" class="form-control condensed" name="disposition_others" placeholder="Others. Please Specify" disabled>
						</div>
					</div>
				</div>
			</div>		
			<div class="col-sm-4">
				<div class="row">
					<div class="col-sm-12">
						<label class="control-label condensed"> <b>Nature of Request</b> </label>
					</div>
					<div class="col-sm-12">
						<div class="funkyradio">
							<div class="funkyradio-primary" >
								<input type="radio" name="nature_of_request[]" id="chk_nor_info_only" value="For Information only">
								<label for="chk_nor_info_only"> For Information only</label>
							</div>
							<div class="funkyradio-primary">
								<input type="radio" name="nature_of_request[]" id="chk_nor_submit_8d" value="Submit 8D report">
								<label for="chk_nor_submit_8d"> Submit 8D report</label>
							</div>
							<div class="funkyradio-primary">
								<input type="radio" name="nature_of_request[]" id="chk_nor_capa" value="Corrective & Preventive Action Report">
								<label for="chk_nor_capa"> Corrective & Preventive Action Report</label>
							</div>
						</div>
					</div>
				</div>
			</div>	
			<div class="col-sm-4">
				<div class="row">
					<div class="col-sm-12">
						<label class="control-label condensed"> <b>Answer</b> </label>
					</div>
					<div class="col-sm-12">
						<div class="funkyradio">
							<div class="funkyradio-primary" >
								<input type="radio" name="answer[]" id="chk_ans_need" value="Need">
								<label for="chk_ans_need"> Need</label>
							</div>
							<div class="funkyradio-primary">
								<input type="radio" name="answer[]" id="chk_ans_no_need" value="No Need">
								<label for="chk_ans_no_need"> No Need</label>
							</div>
						</div>
					</div>
					<div class="col-sm-5" id="div_date_answer_label">
						<label class="control-label condensed"> <b>Date Answer Required</b> </label>
					</div>
					<div class="col-sm-7" id="div_date_answer_input">
						<input type="date" class="form-control condensed" name="date_answer_required">
					</div>
				</div>
			</div>		
		</div>		
		<hr class="graph-orange">		
		
   </div>
   <div class="modal-footer">
	<button type="button" class="btn btn-success fa fa-thumbs-o-up" id=""> Accept</button>
	<button type="button" class="btn btn-danger fa fa-thumbs-o-down" id=""> Reject</button>
    <button type="button" class="btn btn-default fa fa-close" data-dismiss="modal"> Close</button>
   </div>
   </form>
  </div><!-- /.modal-content -->
 </div><!-- /.modal-dialog -->
</div><!-- /.modal -->

<div class="modal fade" tabindex="-1" role="dialog" id="modal_qcfr_approver_message">
  <div class="modal-dialog modal-md" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
        <h4 class="modal-title"><i class="fa fa-question-circle-o"></i> System Confirmation</h4>
      </div>
	  <form id="frm_qcfr_approvers_decision">
		  <div class="modal-body">
			<input type="hidden" id="status">
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

<div class="modal" tabindex="-1" role="dialog" id="mdl_recipient_fillin">
 <div class="modal-dialog modal-lg" role="document" style="width:80%;">
  <div class="modal-content">
   <div class="modal-header">
    <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
    <h4 class="modal-title fa fa-eye">View Quality Complaint Feedback Report (QCFR)</h4>
   </div>
   <form id="frm_recipient_fillin">
   <div class="modal-body">
		<div class="row">
			<div class="col-sm-6">
				<div class="row">
					<div class="col-sm-6">
						<div class="funkyradio" style="padding-bottom:5px;">
							<div class="funkyradio-primary">
								<input type="radio" name="subcon_pmi[]" id="chk_supplier_subcon" value="Supplier/Subcon">
								<label for="chk_supplier_subcon"> <b>Supplier/Subcon</b></label>
							</div>
						</div>
					</div>
					<div class="col-sm-6">
						<div class="funkyradio" style="padding-bottom:5px;">
							<div class="funkyradio-primary">
								<input type="radio" name="subcon_pmi[]" id="chk_assy" value="PMI Assy">
								<label for="chk_assy"> <b>PMI Assy</b></label>
							</div>
						</div>
					</div>
				</div>
				<div class="row">
					<div class="col-sm-4">
						<label class="control-label condensed">TO:</label>
					</div>
					<div class="col-sm-8">
						<input type="text" class="form-control condensed" name="to">
					</div>
				</div>
				<div class="row">
					<div class="col-sm-4">
						<label class="control-label condensed">ATTN:</label>
					</div>
					<div class="col-sm-8">
						<input type="text" class="form-control condensed" name="attn">
					</div>
				</div>
				<div class="row">
					<div class="col-sm-4">
						<label class="control-label condensed">CC:</label>
					</div>
					<div class="col-sm-8">
						<input type="text" class="form-control condensed" name="cc">
					</div>
				</div>
				<div class="row">
					<div class="col-sm-4">
						<label class="control-label condensed">FROM:</label>
					</div>
					<div class="col-sm-8">
						<input type="text" class="form-control condensed" name="from">
					</div>
				</div>
				<div class="row">
					<div class="col-sm-4">
						<label class="control-label condensed">DATE ISSUED:</label>
					</div>
					<div class="col-sm-8">
						<input type="date" class="form-control condensed" name="date_issued">
					</div>
				</div>
			</div>
			<div class="col-sm-6">
				<div class="row">
					<div class="col-sm-3" style="padding-right:0px;">
						<label class="control-label condensed"><b>Found During</b></label>
					</div>
					<div class="col-sm-9" style="">
						<div class="funkyradio">
							<div class="funkyradio-primary" >
								<input type="checkbox" name="found_during[]" id="chk_fd_outgoing_inspection" value="Outgoing Inspection">
								<label for="chk_fd_outgoing_inspection"> Outgoing Inspection</label>
							</div>
							<div class="funkyradio-primary">
								<input type="checkbox" name="found_during[]" id="chk_fd_incoming_inspection" value="Incoming Inspection">
								<label for="chk_fd_incoming_inspection"> Incoming Inspection</label>
							</div>
							<div class="funkyradio-primary">
								<input type="checkbox" name="found_during[]" id="chk_fd_in_process_inspection" value="In-Process Inspection">
								<label for="chk_fd_in_process_inspection"> In-Process Inspection</label>
							</div>
							<div class="funkyradio-primary">
								<input type="checkbox" name="found_during[]" id="chk_fd_quality_system_check" value="Quality System Check">
								<label for="chk_fd_quality_system_check"> Quality System Check</label>
							</div>
							<div class="funkyradio-primary">
								<input type="checkbox" name="found_during[]" id="chk_fd_others" value="Others. Please Specify">
								<label for="chk_fd_others"> Others. Please Specify</label>
							</div>
						</div>
						<input type="text" class="form-control condensed" name="found_during_others" placeholder="Others. Please Specify" disabled>
					</div>
				</div>
				<div class="row">
					<div class="col-sm-3" style="padding-right:0px;">
						<label class="control-label condensed"><b>Product Family</b></label>
					</div>
					<div class="col-sm-9" style="">
						<select class="form-control condensed" name="prod_family" style="width:100%;" required>
						</select>
					</div>
				</div>
			</div>
		</div>
		<hr class="graph-orange">
		<div class="row">
			<div class="col-sm-4">
				<label class="control-label condensed"> Reported by: </label>
			</div>
			<div class="col-sm-4">
				<label class="control-label condensed"> Verified & Conformed by: </label>
			</div>
			<div class="col-sm-4">
				<label class="control-label condensed"> Approved by: </label>
			</div>
		</div>
		<div class="row">
			<div class="col-sm-1">
				<label class="control-label condensed"> LQC </label>
			</div>
			<div class="col-sm-3">
				<input type="text" class="form-control condensed" name="reported_by">
			</div>
			<div class="col-sm-1">
				<label class="control-label condensed"> LQC </label>
			</div>
			<div class="col-sm-3">
				<input type="text" class="form-control condensed" name="verified_conformed_by_lqc">
			</div>
			<div class="col-sm-1">
				<label class="control-label condensed"> Section Head</label>
			</div>
			<div class="col-sm-3">
				<input type="text" class="form-control condensed" name="approved_by_sh">
			</div>
		</div>
		<div class="row" id="div_supplier_approvers">
			<div class="col-sm-1 col-sm-offset-4">
				<label class="control-label condensed"> Engineering </label>
			</div>
			<div class="col-sm-3">
				<input type="text" class="form-control condensed" name="verified_conformed_by_eng">
			</div>
			<div class="col-sm-1">
				<label class="control-label condensed"> Dept. Head </label>
			</div>
			<div class="col-sm-3">
				<input type="text" class="form-control condensed" name="approved_by_dh">
			</div>
		</div>
		<div class="row" id="div_supplier_approvers2">
			<div class="col-sm-1 col-sm-offset-4">
				<label class="control-label condensed"> Production </label>
			</div>
			<div class="col-sm-3">
				<input type="text" class="form-control condensed" name="verified_conformed_by_prdn">
			</div>
		</div>		
		<hr class="graph-blue">
		<div class="row">
			<div class="col-sm-5">
				<div class="row">
					<div class="col-sm-4">
						<label class="control-label condensed"> Product Name</label>
					</div>
					<div class="col-sm-8">
						<input type="text" class="form-control condensed" name="product_name">
					</div>
				</div>
				<div class="row">
					<div class="col-sm-4">
						<label class="control-label condensed"> Model No.</label>
					</div>
					<div class="col-sm-8">
						<input type="text" class="form-control condensed" name="model_no">
					</div>
				</div>
				<div class="row">
					<div class="col-sm-4">
						<label class="control-label condensed"> Batch No./Lot No.</label>
					</div>
					<div class="col-sm-8">
						<input type="text" class="form-control condensed" name="batch_no_lot_no">
					</div>
				</div>
				<div class="row">
					<div class="col-sm-4">
						<label class="control-label condensed"> P.O. No./ INV. No.</label>
					</div>
					<div class="col-sm-8">
						<input type="text" class="form-control condensed" name="po_no_invoice_no">
					</div>
				</div>
				<div class="row">
					<div class="col-sm-4">
						<label class="control-label condensed"> Date Received</label>
					</div>
					<div class="col-sm-8">
						<input type="date" class="form-control condensed" name="date_received">
					</div>
				</div>
			</div>
			<div class="col-sm-7">
				<div class="row">
					<div class="col-sm-3">
							<label class="control-label condensed"> Inspection Method</label>
					</div>
					<div class="col-sm-5">
						<div class="funkyradio">
							<div class="funkyradio-primary">
								<input type="checkbox" name="inspection_method[]" id="chk_sampling" value="Sampling">
								<label for="chk_sampling"> Sampling</label>
							</div>
						</div>
					</div>
					<div class="col-sm-4">
						<div class="funkyradio">
							<div class="funkyradio-primary">
								<input type="checkbox" name="inspection_method[]" id="chk_hundred_percent" value="100%">
								<label for="chk_hundred_percent"> 100%</label>
							</div>
						</div>
					</div>
				</div>
				<div class="row">
					<div class="col-sm-3">
						<label class="control-label condensed"> Sampling Plan</label>
					</div>
					<div class="col-sm-1">
						<label class="control-label condensed"> AQL=</label>
					</div>
					<div class="col-sm-2">
						<input type="text" class="form-control condensed" name="sampling_plan_aql">
					</div>
					<div class="col-sm-2">
						<label class="control-label condensed"> n=</label>						
						<input type="text" class="form-control condensed" name="sampling_plan_n" style="width:65%; display: inline-block">
					</div>
					<div class="col-sm-2">
						<label class="control-label condensed"> Ac=</label>
						<input type="text" class="form-control condensed" name="sampling_plan_ac" style="width:65%; display: inline-block">
					</div>
					<div class="col-sm-2">
						<label class="control-label condensed"> Re=</label>
						<input type="text" class="form-control condensed" name="sampling_plan_re" style="width:65%; display: inline-block">
					</div>
				</div>
				<div class="row">
					<div class="col-sm-3">
						<label class="control-label condensed"> Affected Qty.</label>
					</div>
					<div class="col-sm-3">
						<input type="number" class="form-control condensed" name="affected_qty">
					</div>
					<div class="col-sm-3">
						<label class="control-label condensed"> % Defective</label>
					</div>
					<div class="col-sm-3">
						<input type="number" class="form-control condensed" name="defective_percentage">
					</div>
				</div>
				<div class="row">
					<div class="col-sm-3">
						<label class="control-label condensed"> Defective Qty.</label>
					</div>
					<div class="col-sm-3">
						<input type="number" class="form-control condensed" name="defective_qty">
					</div>
					<div class="col-sm-3">
						<label class="control-label condensed"> No. of Occurrence</label>
					</div>
					<div class="col-sm-3">
						<input type="text" class="form-control condensed" name="no_of_occurence">
					</div>
				</div>
				<div class="row">
					<div class="col-sm-3">
						<label class="control-label condensed"> Date Encountered</label>
					</div>
					<div class="col-sm-3">
						<input type="date" class="form-control condensed" name="date_encountered">
					</div>
					<div class="col-sm-3">
						<label class="control-label condensed"> Ref. QCFR No.</label>
					</div>
					<div class="col-sm-3">
						<input type="text" class="form-control condensed" name="reference_qcfr_no">
					</div>
				</div>
			</div>
		</div>
		<hr class="graph-orange">	
		<div class="row">
			<div class="col-sm-12">
				<label class="control-label condensed"> <b> [ FAILURE / DEFECT DESCRIPTION ] NOTE: Use additional attachment if necessary </b></label>
			</div>
			<div class="col-sm-12">
				<textarea type="text" class="form-control condensed" name="failure_defect_description"></textarea>
			</div>
			<div class="col-sm-2">
				<label class="control-label condensed"> File Attachment</label>
			</div>
			<div class="col-sm-10">
				
			</div>
		</div>	
		<hr class="graph-blue">
		<div class="row">
			<div class="col-sm-4">
				<div class="row">
					<div class="col-sm-12">
						<label class="control-label condensed"> <b>Disposition</b> </label>
					</div>
					<div class="col-sm-6">
						<div class="funkyradio">
							<div class="funkyradio-primary" >
								<input type="checkbox" name="disposition[]" id="chk_dispo_rework_repair" value="Rework/Repair">
								<label for="chk_dispo_rework_repair"> Rework/Repair</label>
							</div>
							<div class="funkyradio-primary">
								<input type="checkbox" name="disposition[]" id="chk_dispo_useasis" value="Use as is">
								<label for="chk_dispo_useasis"> Use as is</label>
							</div>
							<div class="funkyradio-primary">
								<input type="checkbox" name="disposition[]" id="chk_dispo_replace" value="Replace">
								<label for="chk_dispo_replace"> Replace</label>
							</div>
						</div>
					</div>
					<div class="col-sm-6">
						<div class="funkyradio">
							<div class="funkyradio-primary" >
								<input type="checkbox" name="disposition[]" id="chk_dispo_return" value="Return">
								<label for="chk_dispo_return"> Return</label>
							</div>
							<div class="funkyradio-primary">
								<input type="checkbox" name="disposition[]" id="chk_dispo_sorting" value="100% sorting">
								<label for="chk_dispo_sorting"> 100% sorting</label>
							</div>
							<div class="funkyradio-primary">
								<input type="checkbox" name="disposition[]" id="chk_dispo_others" value="Others (specify)">
								<label for="chk_dispo_others"> Others (specify)</label>
							</div>
							<input type="text" class="form-control condensed" name="disposition_others" placeholder="Others. Please Specify" disabled>
						</div>
					</div>
				</div>
			</div>		
			<div class="col-sm-4">
				<div class="row">
					<div class="col-sm-12">
						<label class="control-label condensed"> <b>Nature of Request</b> </label>
					</div>
					<div class="col-sm-12">
						<div class="funkyradio">
							<div class="funkyradio-primary" >
								<input type="radio" name="nature_of_request[]" id="chk_nor_info_only" value="For Information only">
								<label for="chk_nor_info_only"> For Information only</label>
							</div>
							<div class="funkyradio-primary">
								<input type="radio" name="nature_of_request[]" id="chk_nor_submit_8d" value="Submit 8D report">
								<label for="chk_nor_submit_8d"> Submit 8D report</label>
							</div>
							<div class="funkyradio-primary">
								<input type="radio" name="nature_of_request[]" id="chk_nor_capa" value="Corrective & Preventive Action Report">
								<label for="chk_nor_capa"> Corrective & Preventive Action Report</label>
							</div>
						</div>
					</div>
				</div>
			</div>	
			<div class="col-sm-4">
				<div class="row">
					<div class="col-sm-12">
						<label class="control-label condensed"> <b>Answer</b> </label>
					</div>
					<div class="col-sm-12">
						<div class="funkyradio">
							<div class="funkyradio-primary" >
								<input type="radio" name="answer[]" id="chk_ans_need" value="Need">
								<label for="chk_ans_need"> Need</label>
							</div>
							<div class="funkyradio-primary">
								<input type="radio" name="answer[]" id="chk_ans_no_need" value="No Need">
								<label for="chk_ans_no_need"> No Need</label>
							</div>
						</div>
					</div>
					<div class="col-sm-5" id="div_date_answer_label">
						<label class="control-label condensed"> <b>Date Answer Required</b> </label>
					</div>
					<div class="col-sm-7" id="div_date_answer_input">
						<input type="date" class="form-control condensed" name="date_answer_required">
					</div>
				</div>
			</div>		
		</div>		
		<hr class="graph-orange">		
		<div class="row">
			<div class="col-sm-12">
				<div class="row">
					<div class="col-sm-12">
						<label class="control-label condensed"> <b>Recipient Fill-in</b> </label>
					</div>
					<div class="col-sm-2" id="div_recipient_8d_label">
						<label class="control-label condensed">8D Report:</label>
					</div>
					<div class="col-sm-4" id="div_recipient_8d_input">
						<input type="file" class="form-control condensed" name="file_name_8d_report[]" multiple>
					</div>
					<div class="col-sm-2" id="div_recipient_capa_label">
						<label class="control-label condensed">CAPA Report:</label>
					</div>
					<div class="col-sm-4" id="div_recipient_capa_input">
						<input type="file" class="form-control condensed" name="file_name_capa[]" multiple>
					</div>
				</div>
			</div>
		</div>
	</div>
   <div class="modal-footer">
    <button type="submit" class="btn btn-primary fa fa-save"> Submit</button>
    <button type="button" class="btn btn-default fa fa-close" data-dismiss="modal"> Close</button>
   </div>
   </form>
  </div><!-- /.modal-content -->
 </div><!-- /.modal-dialog -->
</div><!-- /.modal -->

<div class="modal" tabindex="-1" role="dialog" id="mdl_add_answer_qcfr">
 <div class="modal-dialog modal-lg" role="document" style="width:80%;">
  <div class="modal-content">
   <div class="modal-header">
    <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
    <h4 class="modal-title fa fa-eye">View Quality Complaint Feedback Report (QCFR)</h4>
   </div>   
   <div class="modal-body">
     <form id="frm_add_answer_qcfr_view">
		<div class="row">
			<div class="col-sm-6">
				<div class="row">
					<div class="col-sm-6">
						<div class="funkyradio" style="padding-bottom:5px;">
							<div class="funkyradio-primary">
								<input type="radio" name="subcon_pmi[]" id="chk_supplier_subcon" value="Supplier/Subcon">
								<label for="chk_supplier_subcon"> <b>Supplier/Subcon</b></label>
							</div>
						</div>
					</div>
					<div class="col-sm-6">
						<div class="funkyradio" style="padding-bottom:5px;">
							<div class="funkyradio-primary">
								<input type="radio" name="subcon_pmi[]" id="chk_assy" value="PMI Assy">
								<label for="chk_assy"> <b>PMI Assy</b></label>
							</div>
						</div>
					</div>
				</div>
				<div class="row">
					<div class="col-sm-4">
						<label class="control-label condensed">TO:</label>
					</div>
					<div class="col-sm-8">
						<input type="text" class="form-control condensed" name="to">
					</div>
				</div>
				<div class="row">
					<div class="col-sm-4">
						<label class="control-label condensed">ATTN:</label>
					</div>
					<div class="col-sm-8">
						<input type="text" class="form-control condensed" name="attn">
					</div>
				</div>
				<div class="row">
					<div class="col-sm-4">
						<label class="control-label condensed">CC:</label>
					</div>
					<div class="col-sm-8">
						<input type="text" class="form-control condensed" name="cc">
					</div>
				</div>
				<div class="row">
					<div class="col-sm-4">
						<label class="control-label condensed">FROM:</label>
					</div>
					<div class="col-sm-8">
						<input type="text" class="form-control condensed" name="from">
					</div>
				</div>
				<div class="row">
					<div class="col-sm-4">
						<label class="control-label condensed">DATE ISSUED:</label>
					</div>
					<div class="col-sm-8">
						<input type="date" class="form-control condensed" name="date_issued">
					</div>
				</div>
			</div>
			<div class="col-sm-6">
				<div class="row">
					<div class="col-sm-3" style="padding-right:0px;">
						<label class="control-label condensed"><b>Found During</b></label>
					</div>
					<div class="col-sm-9" style="">
						<div class="funkyradio">
							<div class="funkyradio-primary" >
								<input type="checkbox" name="found_during[]" id="chk_fd_outgoing_inspection" value="Outgoing Inspection">
								<label for="chk_fd_outgoing_inspection"> Outgoing Inspection</label>
							</div>
							<div class="funkyradio-primary">
								<input type="checkbox" name="found_during[]" id="chk_fd_incoming_inspection" value="Incoming Inspection">
								<label for="chk_fd_incoming_inspection"> Incoming Inspection</label>
							</div>
							<div class="funkyradio-primary">
								<input type="checkbox" name="found_during[]" id="chk_fd_in_process_inspection" value="In-Process Inspection">
								<label for="chk_fd_in_process_inspection"> In-Process Inspection</label>
							</div>
							<div class="funkyradio-primary">
								<input type="checkbox" name="found_during[]" id="chk_fd_quality_system_check" value="Quality System Check">
								<label for="chk_fd_quality_system_check"> Quality System Check</label>
							</div>
							<div class="funkyradio-primary">
								<input type="checkbox" name="found_during[]" id="chk_fd_others" value="Others. Please Specify">
								<label for="chk_fd_others"> Others. Please Specify</label>
							</div>
						</div>
						<input type="text" class="form-control condensed" name="found_during_others" placeholder="Others. Please Specify" disabled>
					</div>
				</div>
				<div class="row">
					<div class="col-sm-3" style="padding-right:0px;">
						<label class="control-label condensed"><b>Product Family</b></label>
					</div>
					<div class="col-sm-9" style="">
						<input type="text" class="form-control condensed" name="prod_family" required>						
					</div>
				</div>
			</div>
		</div>
		<hr class="graph-orange">
		<div class="row">
			<div class="col-sm-4">
				<label class="control-label condensed"> Reported by: </label>
			</div>
			<div class="col-sm-4">
				<label class="control-label condensed"> Verified & Conformed by: </label>
			</div>
			<div class="col-sm-4">
				<label class="control-label condensed"> Approved by: </label>
			</div>
		</div>
		<div class="row">
			<div class="col-sm-1">
				<label class="control-label condensed"> LQC </label>
			</div>
			<div class="col-sm-3">
				<input type="text" class="form-control condensed" name="reported_by">
			</div>
			<div class="col-sm-1">
				<label class="control-label condensed"> LQC </label>
			</div>
			<div class="col-sm-3">
				<input type="text" class="form-control condensed" name="verified_conformed_by_lqc">
			</div>
			<div class="col-sm-1">
				<label class="control-label condensed"> Section Head</label>
			</div>
			<div class="col-sm-3">
				<input type="text" class="form-control condensed" name="approved_by_sh">
			</div>
		</div>
		<div class="row" id="div_supplier_approvers">
			<div class="col-sm-1 col-sm-offset-4">
				<label class="control-label condensed"> Engineering </label>
			</div>
			<div class="col-sm-3">
				<input type="text" class="form-control condensed" name="verified_conformed_by_eng">
			</div>
			<div class="col-sm-1">
				<label class="control-label condensed"> Dept. Head </label>
			</div>
			<div class="col-sm-3">
				<input type="text" class="form-control condensed" name="approved_by_dh">
			</div>
		</div>
		<div class="row" id="div_supplier_approvers2">
			<div class="col-sm-1 col-sm-offset-4">
				<label class="control-label condensed"> Production </label>
			</div>
			<div class="col-sm-3">
				<input type="text" class="form-control condensed" name="verified_conformed_by_prdn">
			</div>
		</div>		
		<hr class="graph-blue">
		<div class="row">
			<div class="col-sm-5">
				<div class="row">
					<div class="col-sm-4">
						<label class="control-label condensed"> Product Name</label>
					</div>
					<div class="col-sm-8">
						<input type="text" class="form-control condensed" name="product_name">
					</div>
				</div>
				<div class="row">
					<div class="col-sm-4">
						<label class="control-label condensed"> Model No.</label>
					</div>
					<div class="col-sm-8">
						<input type="text" class="form-control condensed" name="model_no">
					</div>
				</div>
				<div class="row">
					<div class="col-sm-4">
						<label class="control-label condensed"> Batch No./Lot No.</label>
					</div>
					<div class="col-sm-8">
						<input type="text" class="form-control condensed" name="batch_no_lot_no">
					</div>
				</div>
				<div class="row">
					<div class="col-sm-4">
						<label class="control-label condensed"> P.O. No./ INV. No.</label>
					</div>
					<div class="col-sm-8">
						<input type="text" class="form-control condensed" name="po_no_invoice_no">
					</div>
				</div>
				<div class="row">
					<div class="col-sm-4">
						<label class="control-label condensed"> Date Received</label>
					</div>
					<div class="col-sm-8">
						<input type="date" class="form-control condensed" name="date_received">
					</div>
				</div>
			</div>
			<div class="col-sm-7">
				<div class="row">
					<div class="col-sm-3">
							<label class="control-label condensed"> Inspection Method</label>
					</div>
					<div class="col-sm-5">
						<div class="funkyradio">
							<div class="funkyradio-primary">
								<input type="checkbox" name="inspection_method[]" id="chk_sampling" value="Sampling">
								<label for="chk_sampling"> Sampling</label>
							</div>
						</div>
					</div>
					<div class="col-sm-4">
						<div class="funkyradio">
							<div class="funkyradio-primary">
								<input type="checkbox" name="inspection_method[]" id="chk_hundred_percent" value="100%">
								<label for="chk_hundred_percent"> 100%</label>
							</div>
						</div>
					</div>
				</div>
				<div class="row">
					<div class="col-sm-3">
						<label class="control-label condensed"> Sampling Plan</label>
					</div>
					<div class="col-sm-1">
						<label class="control-label condensed"> AQL=</label>
					</div>
					<div class="col-sm-2">
						<input type="text" class="form-control condensed" name="sampling_plan_aql">
					</div>
					<div class="col-sm-2">
						<label class="control-label condensed"> n=</label>						
						<input type="text" class="form-control condensed" name="sampling_plan_n" style="width:65%; display: inline-block">
					</div>
					<div class="col-sm-2">
						<label class="control-label condensed"> Ac=</label>
						<input type="text" class="form-control condensed" name="sampling_plan_ac" style="width:65%; display: inline-block">
					</div>
					<div class="col-sm-2">
						<label class="control-label condensed"> Re=</label>
						<input type="text" class="form-control condensed" name="sampling_plan_re" style="width:65%; display: inline-block">
					</div>
				</div>
				<div class="row">
					<div class="col-sm-3">
						<label class="control-label condensed"> Affected Qty.</label>
					</div>
					<div class="col-sm-3">
						<input type="number" class="form-control condensed" name="affected_qty">
					</div>
					<div class="col-sm-3">
						<label class="control-label condensed"> % Defective</label>
					</div>
					<div class="col-sm-3">
						<input type="number" class="form-control condensed" name="defective_percentage">
					</div>
				</div>
				<div class="row">
					<div class="col-sm-3">
						<label class="control-label condensed"> Defective Qty.</label>
					</div>
					<div class="col-sm-3">
						<input type="number" class="form-control condensed" name="defective_qty">
					</div>
					<div class="col-sm-3">
						<label class="control-label condensed"> No. of Occurrence</label>
					</div>
					<div class="col-sm-3">
						<input type="text" class="form-control condensed" name="no_of_occurence">
					</div>
				</div>
				<div class="row">
					<div class="col-sm-3">
						<label class="control-label condensed"> Date Encountered</label>
					</div>
					<div class="col-sm-3">
						<input type="date" class="form-control condensed" name="date_encountered">
					</div>
					<div class="col-sm-3">
						<label class="control-label condensed"> Ref. QCFR No.</label>
					</div>
					<div class="col-sm-3">
						<input type="text" class="form-control condensed" name="reference_qcfr_no">
					</div>
				</div>
			</div>
		</div>
		<hr class="graph-orange">	
		<div class="row">
			<div class="col-sm-12">
				<label class="control-label condensed"> <b> [ FAILURE / DEFECT DESCRIPTION ] NOTE: Use additional attachment if necessary </b></label>
			</div>
			<div class="col-sm-12">
				<textarea type="text" class="form-control condensed" name="failure_defect_description"></textarea>
			</div>
			<div class="col-sm-2">
				<label class="control-label condensed"> File Attachment</label>
			</div>
			<div class="col-sm-10">
				
			</div>
		</div>	
		<hr class="graph-blue">
		<div class="row">
			<div class="col-sm-4">
				<div class="row">
					<div class="col-sm-12">
						<label class="control-label condensed"> <b>Disposition</b> </label>
					</div>
					<div class="col-sm-6">
						<div class="funkyradio">
							<div class="funkyradio-primary" >
								<input type="checkbox" name="disposition[]" id="chk_dispo_rework_repair" value="Rework/Repair">
								<label for="chk_dispo_rework_repair"> Rework/Repair</label>
							</div>
							<div class="funkyradio-primary">
								<input type="checkbox" name="disposition[]" id="chk_dispo_useasis" value="Use as is">
								<label for="chk_dispo_useasis"> Use as is</label>
							</div>
							<div class="funkyradio-primary">
								<input type="checkbox" name="disposition[]" id="chk_dispo_replace" value="Replace">
								<label for="chk_dispo_replace"> Replace</label>
							</div>
						</div>
					</div>
					<div class="col-sm-6">
						<div class="funkyradio">
							<div class="funkyradio-primary" >
								<input type="checkbox" name="disposition[]" id="chk_dispo_return" value="Return">
								<label for="chk_dispo_return"> Return</label>
							</div>
							<div class="funkyradio-primary">
								<input type="checkbox" name="disposition[]" id="chk_dispo_sorting" value="100% sorting">
								<label for="chk_dispo_sorting"> 100% sorting</label>
							</div>
							<div class="funkyradio-primary">
								<input type="checkbox" name="disposition[]" id="chk_dispo_others" value="Others (specify)">
								<label for="chk_dispo_others"> Others (specify)</label>
							</div>
							<input type="text" class="form-control condensed" name="disposition_others" placeholder="Others. Please Specify" disabled>
						</div>
					</div>
				</div>
			</div>		
			<div class="col-sm-4">
				<div class="row">
					<div class="col-sm-12">
						<label class="control-label condensed"> <b>Nature of Request</b> </label>
					</div>
					<div class="col-sm-12">
						<div class="funkyradio">
							<div class="funkyradio-primary" >
								<input type="radio" name="nature_of_request[]" id="chk_nor_info_only" value="For Information only">
								<label for="chk_nor_info_only"> For Information only</label>
							</div>
							<div class="funkyradio-primary">
								<input type="radio" name="nature_of_request[]" id="chk_nor_submit_8d" value="Submit 8D report">
								<label for="chk_nor_submit_8d"> Submit 8D report</label>
							</div>
							<div class="funkyradio-primary">
								<input type="radio" name="nature_of_request[]" id="chk_nor_capa" value="Corrective & Preventive Action Report">
								<label for="chk_nor_capa"> Corrective & Preventive Action Report</label>
							</div>
						</div>
					</div>
				</div>
			</div>	
			<div class="col-sm-4">
				<div class="row">
					<div class="col-sm-12">
						<label class="control-label condensed"> <b>Answer</b> </label>
					</div>
					<div class="col-sm-12">
						<div class="funkyradio">
							<div class="funkyradio-primary" >
								<input type="radio" name="answer[]" id="chk_ans_need" value="Need">
								<label for="chk_ans_need"> Need</label>
							</div>
							<div class="funkyradio-primary">
								<input type="radio" name="answer[]" id="chk_ans_no_need" value="No Need">
								<label for="chk_ans_no_need"> No Need</label>
							</div>
						</div>
					</div>
					<div class="col-sm-5" id="div_date_answer_label">
						<label class="control-label condensed"> <b>Date Answer Required</b> </label>
					</div>
					<div class="col-sm-7" id="div_date_answer_input">
						<input type="date" class="form-control condensed" name="date_answer_required">
					</div>
				</div>
			</div>		
		</div>		
		<div class="row" id="div_recipient_fillin">
		<hr class="graph-orange">	
			<div class="col-sm-12">
				<div class="row">
					<div class="col-sm-12">
						<label class="control-label condensed"> <b>Recipient Fill-in</b> </label>
					</div>
					<div class="col-sm-2" id="div_recipient_8d_label">
						<label class="control-label condensed">8D Report:</label>
					</div>
					<div class="col-sm-4" id="div_recipient_8d_input">
						<button type="button" class="btn btn-default btn-link" id="btn_view_attachment_8d" name="pkid"> Download attachment</button>
					</div>
					<div class="col-sm-2" id="div_recipient_capa_label">
						<label class="control-label condensed">CAPA Report:</label>
					</div>
					<div class="col-sm-4" id="div_recipient_capa_input">
						<button type="button" class="btn btn-default btn-link" id="btn_view_attachment_capa" name="pkid"> Download attachment</button>
					</div>
				</div>
			</div>
		</div>
     </form>
	 <form id="frm_add_answer_qcfr_edit">	
		<hr class="graph-blue">		
		<div class="row">
			<div class="col-sm-4">
				<div class="row">
					<div class="col-sm-12">
						<label class="control-label condensed"> <b>PMI/Originator Fill-in</b> </label>
					</div>
					<div class="col-sm-4">
						<label class="control-label condensed">Factory Line Audit?:</label>
					</div>
					<div class="col-sm-8">
						<div class="funkyradio" style="padding-bottom:5px;">
							<div class="funkyradio-primary">
								<input type="radio" name="factory_line_audit[]" id="chk_yes" value="Yes">
								<label for="chk_yes"> <b>Yes</b></label>
							</div>
							<div class="funkyradio-primary">
								<input type="radio" name="factory_line_audit[]" id="chk_no" value="No">
								<label for="chk_no"> <b>No</b></label>
							</div>
						</div>
					</div>
				</div>
			</div>
		</div>
		<div class="row">
			<div class="col-sm-12">
				<label class="control-label condensed"> [ Result of Confirmation ]</label>
			</div>
			<div class="col-sm-12">
				<label class="control-label condensed"> 1. Treatment for affected lot:</label>
			</div>
			<div class="col-sm-12">
				<textarea type="text" class="form-control condensed" name="treatment_affected_lot"></textarea>
			</div>
			<div class="col-sm-12">
				<label class="control-label condensed"> 2. Verification result for corrective and preventive action:</label>
			</div>
			<div class="col-sm-12">
				<textarea type="text" class="form-control condensed" name="verification_result"></textarea>
			</div>
		</div>	
		<div class="row">
			<div class="col-sm-4">
				<label class="control-label condensed">Prepared by:</label>
			</div>
			<div class="col-sm-4">
				<label class="control-label condensed"> Checked by:</label>
			</div>
			<div class="col-sm-4">
				<label class="control-label condensed"> Approved by:</label>
			</div>
		</div>	
		<div class="row">
			<div class="col-sm-4">
				<select class="" id="created_by" name="created_by[]" style="width:100%;" required disabled>
				</select>
			</div>
			<div class="col-sm-4">
				<select class="" id="pmi_orginator_fill_in_checked_by" name="pmi_orginator_fill_in_checked_by" style="width:100%;" required>
				</select>
			</div>
			<div class="col-sm-4">
				<select class="" id="pmi_orginator_fill_in_approved_by" name="pmi_orginator_fill_in_approved_by" style="width:100%;" required>
				</select>
			</div>
		</div>	
	</div>
   <div class="modal-footer">
    <button type="submit" class="btn btn-primary fa fa-save"> Submit</button>
    <button type="button" class="btn btn-default fa fa-close" data-dismiss="modal"> Close</button>
   </div>
   </form>
  </div><!-- /.modal-content -->
 </div><!-- /.modal-dialog -->
</div><!-- /.modal -->

<div class="modal" tabindex="-1" role="dialog" id="mdl_edit_qcfr---">
 <div class="modal-dialog modal-lg" role="document" style="width:80%;">
  <div class="modal-content">
   <div class="modal-header">
    <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
    <h4 class="modal-title fa fa-edit">Edit Quality Complaint Feedback Report (QCFR)</h4>
   </div>
   <form id="frm_edit_qcfr---">
   <div class="modal-body">
		<div class="row">
			<div class="col-sm-6">
				<div class="row">
					<div class="col-sm-6">
						<div class="funkyradio" style="padding-bottom:5px;">
							<div class="funkyradio-primary">
								<input type="radio" name="subcon_pmi[]" id="chk_supplier_subcon" value="Supplier/Subcon">
								<label for="chk_supplier_subcon"> <b>Supplier/Subcon</b></label>
							</div>
						</div>
					</div>
					<div class="col-sm-6">
						<div class="funkyradio" style="padding-bottom:5px;">
							<div class="funkyradio-primary">
								<input type="radio" name="subcon_pmi[]" id="chk_assy" value="PMI Assy">
								<label for="chk_assy"> <b>PMI Assy</b></label>
							</div>
						</div>
					</div>
				</div>
				<div class="row">
					<div class="col-sm-4">
						<label class="control-label condensed">TO:</label>
					</div>
					<div class="col-sm-8">
						<select class="" id="cmb_to" name="to" style="width:100%;" required>
						</select>
					</div>
				</div>
				<div class="row" style="padding-top:5px;">
					<div class="col-sm-4">
						<label class="control-label condensed">ATTN:</label>
					</div>
					<div class="col-sm-8">
						<select class="" id="cmb_attn" name="attn[]" multiple="multiple" style="width:100%;" required>
						</select>
					</div>
				</div>
				<div class="row" style="padding-top:5px;">
					<div class="col-sm-4">
						<label class="control-label condensed">CC:</label>
					</div>
					<div class="col-sm-8">
						<div id="div_cc_supplier">
							<input type="text" class="form-control condensed" name="cc_supplier">
						</div>
						<div id="div_cc_pmi">
							<select class="" id="cmb_cc" name="cc_pmi[]" multiple="multiple" style="width:100%;">
							</select>
						</div>
					</div>
				</div>
				<div class="row" style="padding-top:5px;">
					<div class="col-sm-4">
						<label class="control-label condensed">FROM:</label>
					</div>
					<div class="col-sm-8">
						<select id="cmb_from" name="from" style="width:100%;" required>
						</select>
					</div>
				</div>
				<div class="row">
					<div class="col-sm-4">
						<label class="control-label condensed">DATE ISSUED:</label>
					</div>
					<div class="col-sm-8">
						<input type="date" max="<?php echo date('Y-m-d'); ?>" name="date_issued" class="form-control condensed" name="date_issued" required>
					</div>
				</div>
			</div>
			<div class="col-sm-6">
				<div class="row">
					<div class="col-sm-3" style="padding-right:0px;">
						<label class="control-label condensed"><b>Found During</b></label>
					</div>
					<div class="col-sm-9" style="">
						<div class="funkyradio">
							<div class="funkyradio-primary" >
								<input type="checkbox" name="found_during[]" id="chk_fd_outgoing_inspection" value="Outgoing Inspection">
								<label for="chk_fd_outgoing_inspection"> Outgoing Inspection</label>
							</div>
							<div class="funkyradio-primary">
								<input type="checkbox" name="found_during[]" id="chk_fd_incoming_inspection" value="Incoming Inspection">
								<label for="chk_fd_incoming_inspection"> Incoming Inspection</label>
							</div>
							<div class="funkyradio-primary">
								<input type="checkbox" name="found_during[]" id="chk_fd_in_process_inspection" value="In-Process Inspection">
								<label for="chk_fd_in_process_inspection"> In-Process Inspection</label>
							</div>
							<div class="funkyradio-primary">
								<input type="checkbox" name="found_during[]" id="chk_fd_quality_system_check" value="Quality System Check">
								<label for="chk_fd_quality_system_check"> Quality System Check</label>
							</div>
							<div class="funkyradio-primary">
								<input type="checkbox" name="found_during[]" id="chk_fd_others" value="Others. Please Specify">
								<label for="chk_fd_others"> Others. Please Specify</label>
							</div>
						</div>
						<input type="text" class="form-control condensed" name="found_during_others" placeholder="Others. Please Specify" disabled>
					</div>
				</div>
				<div class="row">
					<div class="col-sm-3" style="padding-right:0px;">
						<label class="control-label condensed"><b>Product Family</b></label>
					</div>
					<div class="col-sm-9" style="">
						<select class="form-control condensed" name="prod_family" style="width:100%;" required>
						</select>
					</div>
				</div>
			</div>
		</div>
		<hr class="graph-orange">
		<div class="row">
			<div class="col-sm-4">
				<label class="control-label condensed"> Reported by: </label>
			</div>
			<div class="col-sm-4">
				<label class="control-label condensed"> Verified & Conformed by: </label>
			</div>
			<div class="col-sm-4">
				<label class="control-label condensed"> Approved by: </label>
			</div>
		</div>
		<div class="row">
			<div class="col-sm-1">
				<label class="control-label condensed"> LQC </label>
			</div>
			<div class="col-sm-3">
				<select class="" id="cmb_reported_by" name="reported_by[]" style="width:100%;" required>
				</select>
			</div>
			<div class="col-sm-1">
				<label class="control-label condensed"> LQC Supervisor</label>
			</div>
			<div class="col-sm-3">
				<select class="" id="verified_conformed_by_lqc" name="verified_conformed_by_lqc[]" style="width:100%;" required>
				</select>
			</div>
			<div class="col-sm-1">
				<label class="control-label condensed"> Section Head</label>
			</div>
			<div class="col-sm-3">
				<select class="" id="approved_by_sh" name="approved_by_sh[]" style="width:100%;" required>
				</select>
			</div>
		</div>
		<div class="row" id="div_supplier_approvers">
			<div class="col-sm-1 col-sm-offset-4">
				<label class="control-label condensed"> Engineering </label>
			</div>
			<div class="col-sm-3">
				<select class="" id="verified_conformed_by_eng" name="verified_conformed_by_eng[]" multiple="multiple" style="width:100%;">
				</select>
			</div>
			<div class="col-sm-1">
				<label class="control-label condensed"> Dept. Head </label>
			</div>
			<div class="col-sm-3">
				<select class="" id="approved_by_dh" name="approved_by_dh[]" style="width:100%;">
				</select>
			</div>
		</div>
		<div class="row" id="div_supplier_approvers2">
			<div class="col-sm-1 col-sm-offset-4">
				<label class="control-label condensed"> Production </label>
			</div>
			<div class="col-sm-3">
				<select class="" id="verified_conformed_by_prdn" name="verified_conformed_by_prdn[]" multiple="multiple" style="width:100%;">
				</select>
			</div>
		</div>
		<hr class="graph-blue">
		<div class="row">
			<div class="col-sm-5">
				<div class="row">
					<div class="col-sm-4">
						<label class="control-label condensed"> Product Name</label>
					</div>
					<div class="col-sm-8">
						<select class="form-control condensed" name="product_name" style="width:100%;" required>
						</select>
					</div>
				</div>
				<div class="row">
					<div class="col-sm-4">
						<label class="control-label condensed"> Model No.</label>
					</div>
					<div class="col-sm-8">
						<input type="text" class="form-control condensed" name="model_no" readonly>
					</div>
				</div>
				<div class="row">
					<div class="col-sm-4">
						<label class="control-label condensed"> Batch No./Lot No.</label>
					</div>
					<div class="col-sm-8">
						<select class="" id="batch_no_lot_no" name="batch_no_lot_no[]" multiple="multiple" style="width:100%;" required>
						</select>
					</div>
				</div>
				<div class="row">
					<div class="col-sm-4">
						<label class="control-label condensed"> P.O. No./ INV. No.</label>
					</div>
					<div class="col-sm-8">
						<input type="text" class="form-control" id="po_no_invoice_no" list="list_po_no_invoice_no" autocomplete="on" name="po_no_invoice_no" required>
						<datalist id="list_po_no_invoice_no"></datalist>
					</div>
				</div>
				<div class="row">
					<div class="col-sm-4">
						<label class="control-label condensed"> Date Received</label>
					</div>
					<div class="col-sm-8">
						<input type="date" class="form-control condensed" name="date_received" required>
					</div>
				</div>
			</div>
			<div class="col-sm-7">
				<div class="row">
					<div class="col-sm-3">
							<label class="control-label condensed"> Inspection Method</label>
					</div>
					<div class="col-sm-5">
						<div class="funkyradio">
							<div class="funkyradio-primary">
								<input type="radio" name="inspection_method[]" id="chk_sampling" value="Sampling">
								<label for="chk_sampling"> Sampling</label>
							</div>
						</div>
					</div>
					<div class="col-sm-4">
						<div class="funkyradio">
							<div class="funkyradio-primary">
								<input type="radio" name="inspection_method[]" id="chk_hundred_percent" value="100%">
								<label for="chk_hundred_percent"> 100%</label>
							</div>
						</div>
					</div>
				</div>
				<div class="row">
					<div class="col-sm-3">
						<label class="control-label condensed"> Sampling Plan</label>
					</div>
					<div class="col-sm-1">
						<label class="control-label condensed"> AQL=</label>
					</div>
					<div class="col-sm-2">
						<input type="number" class="form-control condensed" name="sampling_plan_aql" min="0">
					</div>
					<div class="col-sm-2">
						<label class="control-label condensed"> n=</label>						
						<input type="number" class="form-control condensed" name="sampling_plan_n" style="width:65%; display: inline-block" min="0" maxlength="5">
					</div>
					<div class="col-sm-2">
						<label class="control-label condensed"> Ac=</label>
						<input type="number" class="form-control condensed" name="sampling_plan_ac" style="width:65%; display: inline-block" min="0">
					</div>
					<div class="col-sm-2">
						<label class="control-label condensed"> Re=</label>
						<input type="number" class="form-control condensed" name="sampling_plan_re" style="width:65%; display: inline-block" min="0">
					</div>
				</div>
				<div class="row">
					<div class="col-sm-3">
						<label class="control-label condensed"> Affected Qty.</label>
					</div>
					<div class="col-sm-3">
						<input type="number" class="form-control condensed" name="affected_qty">
					</div>
					<div class="col-sm-3">
						<label class="control-label condensed"> % Defective</label>
					</div>
					<div class="col-sm-3">
						<input type="number" class="form-control condensed" name="defective_percentage" readonly>
					</div>
				</div>
				<div class="row">
					<div class="col-sm-3">
						<label class="control-label condensed"> Defective Qty.</label>
					</div>
					<div class="col-sm-3">
						<input type="number" class="form-control condensed" name="defective_qty" maxlength="5">
					</div>
					<div class="col-sm-3">
						<label class="control-label condensed"> No. of Occurrence</label>
					</div>
					<div class="col-sm-3">
						<select class="form-control condensed" name="no_of_occurence" style="width:100%;" required>
							<option value="">-</option>
							<option value="1st Occurrence">1st Occurrence</option>
							<option value="2nd Occurrence">2nd Occurrence</option>
							<option value="3rd Occurrence">3rd Occurrence</option>
							<option value="4th Occurrence">4th Occurrence</option>
							<option value="5th Occurrence">5th Occurrence</option>
							<option value="6th Occurrence">6th Occurrence</option>
							<option value="7th Occurrence">7th Occurrence</option>
							<option value="8th Occurrence">8th Occurrence</option>
							<option value="9th Occurrence">9th Occurrence</option>
							<option value="10th Occurrence">10th Occurrence</option>
						</select>
					</div>
				</div>
				<div class="row">
					<div class="col-sm-3">
						<label class="control-label condensed"> Date Encountered</label>
					</div>
					<div class="col-sm-3">
						<input type="date" class="form-control condensed" name="date_encountered" required>
					</div>
					<div class="col-sm-3">
						<label class="control-label condensed"> Ref. QCFR No.</label>
					</div>
					<div class="col-sm-3">
						<input type="text" class="form-control condensed" name="reference_qcfr_no">
					</div>
				</div>
			</div>
		</div>
		<hr class="graph-orange">	
		<div class="row">
			<div class="col-sm-12">
				<label class="control-label condensed"> <b> [ FAILURE / DEFECT DESCRIPTION ] NOTE: Use additional attachment if necessary </b></label>
			</div>
			<div class="col-sm-12">
				<textarea type="text" class="form-control condensed" name="failure_defect_description" required></textarea>
			</div>
			<div class="col-sm-2">
				<label class="control-label condensed"> File Attachment</label>
			</div>
			<div class="col-sm-10">
				<input type="file" class="form-control condensed" name="file_failure_defect_filename[]" multiple>
			</div>
		</div>	
		<hr class="graph-blue">
		<div class="row">
			<div class="col-sm-4">
				<div class="row">
					<div class="col-sm-12">
						<label class="control-label condensed"> <b>Disposition</b> </label>
					</div>
					<div class="col-sm-6">
						<div class="funkyradio">
							<div class="funkyradio-primary" >
								<input type="checkbox" name="disposition[]" id="chk_dispo_rework_repair" value="Rework/Repair">
								<label for="chk_dispo_rework_repair"> Rework/Repair</label>
							</div>
							<div class="funkyradio-primary">
								<input type="checkbox" name="disposition[]" id="chk_dispo_useasis" value="Use as is">
								<label for="chk_dispo_useasis"> Use as is</label>
							</div>
							<div class="funkyradio-primary">
								<input type="checkbox" name="disposition[]" id="chk_dispo_replace" value="Replace">
								<label for="chk_dispo_replace"> Replace</label>
							</div>
						</div>
					</div>
					<div class="col-sm-6">
						<div class="funkyradio">
							<div class="funkyradio-primary" >
								<input type="checkbox" name="disposition[]" id="chk_dispo_return" value="Return">
								<label for="chk_dispo_return"> Return</label>
							</div>
							<div class="funkyradio-primary">
								<input type="checkbox" name="disposition[]" id="chk_dispo_sorting" value="100% sorting">
								<label for="chk_dispo_sorting"> 100% sorting</label>
							</div>
							<div class="funkyradio-primary">
								<input type="checkbox" name="disposition[]" id="chk_dispo_others" value="Others (specify)">
								<label for="chk_dispo_others"> Others (specify)</label>
							</div>
							<input type="text" class="form-control condensed" name="disposition_others" placeholder="Others. Please Specify" disabled>
						</div>
					</div>
				</div>
			</div>		
			<div class="col-sm-4">
				<div class="row">
					<div class="col-sm-12">
						<label class="control-label condensed"> <b>Nature of Request</b> </label>
					</div>
					<div class="col-sm-12">
						<div class="funkyradio">
							<div class="funkyradio-primary" >
								<input type="radio" name="nature_of_request[]" id="chk_nor_info_only" value="For Information only">
								<label for="chk_nor_info_only"> For Information only</label>
							</div>
							<div class="funkyradio-primary">
								<input type="radio" name="nature_of_request[]" id="chk_nor_submit_8d" value="Submit 8D report">
								<label for="chk_nor_submit_8d"> Submit 8D report</label>
							</div>
							<div class="funkyradio-primary">
								<input type="radio" name="nature_of_request[]" id="chk_nor_capa" value="Corrective & Preventive Action Report">
								<label for="chk_nor_capa"> Corrective & Preventive Action Report</label>
							</div>
						</div>
					</div>
				</div>
			</div>	
			<div class="col-sm-4">
				<div class="row">
					<div class="col-sm-12">
						<label class="control-label condensed"> <b>Answer</b> </label>
					</div>
					<div class="col-sm-12">
						<div class="funkyradio">
							<div class="funkyradio-primary" >
								<input type="radio" name="answer[]" id="chk_ans_need" value="Need">
								<label for="chk_ans_need"> Need</label>
							</div>
							<div class="funkyradio-primary">
								<input type="radio" name="answer[]" id="chk_ans_no_need" value="No Need">
								<label for="chk_ans_no_need"> No Need</label>
							</div>
						</div>
					</div>
					<div class="col-sm-5" id="div_date_answer_label">
						<label class="control-label condensed"> <b>Date Answer Required</b> </label>
					</div>
					<div class="col-sm-7" id="div_date_answer_input">
						<input type="date" max="<?php echo date('Y-m-d'); ?>" class="form-control condensed" name="date_answer_required" required>
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

<div class="modal" tabindex="-1" role="dialog" id="mdl_edit_qcfr-bk">
 <div class="modal-dialog modal-lg" role="document" style="width:80%;">
  <div class="modal-content">
   <div class="modal-header">
    <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
    <h4 class="modal-title fa fa-plus">Add Quality Complaint Feedback Report (QCFR)</h4>
   </div>
   <form id="frm_edit_qcfr-bk">
   <div class="modal-body">
		<div class="row">
			<div class="col-sm-6">
				<div class="row">
					<div class="col-sm-6">
						<div class="funkyradio" style="padding-bottom:5px;">
							<div class="funkyradio-primary">
								<input type="radio" name="subcon_pmi[]" id="chk_supplier_subcon" value="Supplier/Subcon">
								<label for="chk_supplier_subcon"> <b>Supplier/Subcon</b></label>
							</div>
						</div>
						<div class="funkyradio" style="padding-top:5px;">
							<div class="funkyradio-primary">
								<input type="radio" name="subcon_pmi[]" id="chk_assy" value="PMI Assy">
								<label for="chk_assy"> <b>PMI Assy</b></label>
							</div>
						</div>
					</div>
					<div class="col-sm-6">						
						<input type="text" class="form-control condensed" name="supplier_subcon">
						<input type="text" class="form-control condensed" name="pmi_assy">
					</div>
				</div>
				<div class="row">
					<div class="col-sm-4">
						<label class="control-label condensed">TO:</label>
					</div>
					<div class="col-sm-8">
						<!-- <input type="text" class="form-control condensed" name="to"> -->
						<select class="" id="cmb_to" name="to" style="width:100%;" required>
						</select>
					</div>
				</div>
				<div class="row">
					<div class="col-sm-4">
						<label class="control-label condensed">ATTN:</label>
					</div>
					<div class="col-sm-8">
						<input type="text" class="form-control condensed" name="attn">
						<!-- <select class="" id="cmb_attn" name="attn[]" multiple="multiple" style="width:100%;" required>
						</select> -->
					</div>
				</div>
				<div class="row">
					<div class="col-sm-4">
						<label class="control-label condensed">CC:</label>
					</div>
					<div class="col-sm-8">
						<input type="text" class="form-control condensed" name="cc">
					</div>
				</div>
				<div class="row">
					<div class="col-sm-4">
						<label class="control-label condensed">FROM:</label>
					</div>
					<div class="col-sm-8">
						<select id="cmb_from" name="from" style="width:100%;" required>
						</select>
					</div>
				</div>
				<div class="row">
					<div class="col-sm-4">
						<label class="control-label condensed">DATE ISSUED:</label>
					</div>
					<div class="col-sm-8">
						<input type="date" max="<?php echo date('Y-m-d'); ?>" class="form-control condensed" name="date_issued">
					</div>
				</div>
			</div>
			<div class="col-sm-6">
				<div class="row">
					<div class="col-sm-3">
						<label class="control-label condensed"><b>QCFR No.:</b></label>
					</div>
					<div class="col-sm-9">
						<input type="text" class="form-control condensed" name="qcfr_no">
					</div>
				</div>
				<div class="row">
					<div class="col-sm-3" style="padding-right:0px;">
						<label class="control-label condensed"><b>Found During</b></label>
					</div>
					<div class="col-sm-9" style="">
						<div class="funkyradio">
							<div class="funkyradio-primary" >
								<input type="checkbox" name="found_during[]" id="chk_fd_outgoing_inspection" value="Outgoing Inspection">
								<label for="chk_fd_outgoing_inspection"> Outgoing Inspection</label>
							</div>
							<div class="funkyradio-primary">
								<input type="checkbox" name="found_during[]" id="chk_fd_incoming_inspection" value="Incoming Inspection">
								<label for="chk_fd_incoming_inspection"> Incoming Inspection</label>
							</div>
							<div class="funkyradio-primary">
								<input type="checkbox" name="found_during[]" id="chk_fd_in_process_inspection" value="In-Process Inspection">
								<label for="chk_fd_in_process_inspection"> In-Process Inspection</label>
							</div>
							<div class="funkyradio-primary">
								<input type="checkbox" name="found_during[]" id="chk_fd_quality_system_check" value="Quality System Check">
								<label for="chk_fd_quality_system_check"> Quality System Check</label>
							</div>
							<div class="funkyradio-primary">
								<input type="checkbox" name="found_during[]" id="chk_fd_others" value="Others. Please Specify">
								<label for="chk_fd_others"> Others. Please Specify</label>
							</div>
						</div>
						<input type="text" class="form-control condensed" name="found_during_others" placeholder="Others. Please Specify" disabled>
					</div>
				</div>
				<div class="row">
					<div class="col-sm-3" style="padding-right:0px;">
						<label class="control-label condensed"><b>Product Family</b></label>
					</div>
					<div class="col-sm-9" style="">
						<select class="form-control condensed" name="prod_family" style="width:100%;" required>
						</select>
					</div>
				</div>
			</div>
		</div>
		<hr class="graph-orange">
		<div class="row">
			<div class="col-sm-4">
				<label class="control-label condensed"> Reported by: </label>
			</div>
			<div class="col-sm-4">
				<label class="control-label condensed"> Verified & Conformed by: </label>
			</div>
			<div class="col-sm-4">
				<label class="control-label condensed"> Approved by: </label>
			</div>
		</div>
		<div class="row">
			<div class="col-sm-1">
				<label class="control-label condensed"> LQC </label>
			</div>
			<div class="col-sm-3">
				<select class="" id="cmb_reported_by" name="reported_by[]" style="width:100%;" required>
				</select>
			</div>
			<div class="col-sm-1">
				<label class="control-label condensed"> LQC </label>
			</div>
			<div class="col-sm-3">
				<select class="" id="verified_conformed_by_lqc" name="verified_conformed_by_lqc[]" style="width:100%;" required>
				</select>
			</div>
			<div class="col-sm-1">
				<label class="control-label condensed"> Section Head</label>
			</div>
			<div class="col-sm-3">
				<select class="" id="approved_by_sh" name="approved_by_sh[]" style="width:100%;" required>
				</select>
			</div>
		</div>
		<div class="row">
			<div class="col-sm-1 col-sm-offset-4">
				<label class="control-label condensed"> Engineering </label>
			</div>
			<div class="col-sm-3">
				<select class="" id="verified_conformed_by_eng" name="verified_conformed_by_eng[]" style="width:100%;" required>
				</select>
			</div>
			<div class="col-sm-1">
				<label class="control-label condensed"> Dept. Head </label>
			</div>
			<div class="col-sm-3">
				<select class="" id="approved_by_dh" name="approved_by_dh[]" style="width:100%;" required>
				</select>
			</div>
		</div>
		<div class="row">
			<div class="col-sm-1 col-sm-offset-4">
				<label class="control-label condensed"> Production </label>
			</div>
			<div class="col-sm-3">
				<select class="" id="verified_conformed_by_prdn" name="verified_conformed_by_prdn[]" style="width:100%;" required>
				</select>
			</div>
		</div>
		<hr class="graph-blue">
		<div class="row">
			<div class="col-sm-5">
				<div class="row">
					<div class="col-sm-4">
						<label class="control-label condensed"> Product Name</label>
					</div>
					<div class="col-sm-8">
						<input type="text" class="form-control condensed" name="product_name">
					</div>
				</div>
				<div class="row">
					<div class="col-sm-4">
						<label class="control-label condensed"> Model No.</label>
					</div>
					<div class="col-sm-8">
						<input type="text" class="form-control condensed" name="model_no">
					</div>
				</div>
				<div class="row">
					<div class="col-sm-4">
						<label class="control-label condensed"> Batch No./Lot No.</label>
					</div>
					<div class="col-sm-8">
						<input type="text" class="form-control condensed" name="batch_no_lot_no">
					</div>
				</div>
				<div class="row">
					<div class="col-sm-4">
						<label class="control-label condensed"> P.O. No./ INV. No.</label>
					</div>
					<div class="col-sm-8">
						<input type="text" class="form-control condensed" name="po_no_invoice_no">
					</div>
				</div>
				<div class="row">
					<div class="col-sm-4">
						<label class="control-label condensed"> Date Received</label>
					</div>
					<div class="col-sm-8">
						<input type="date" class="form-control condensed" name="date_received">
					</div>
				</div>
			</div>
			<div class="col-sm-7">
				<div class="row">
					<div class="col-sm-3">
							<label class="control-label condensed"> Inspection Method</label>
					</div>
					<div class="col-sm-5">
						<div class="funkyradio">
							<div class="funkyradio-primary">
								<input type="checkbox" name="inspection_method[]" id="chk_sampling" value="Sampling">
								<label for="chk_sampling"> Sampling</label>
							</div>
						</div>
					</div>
					<div class="col-sm-4">
						<div class="funkyradio">
							<div class="funkyradio-primary">
								<input type="checkbox" name="inspection_method[]" id="chk_hundred_percent" value="100%">
								<label for="chk_hundred_percent"> 100%</label>
							</div>
						</div>
					</div>
				</div>
				<div class="row">
					<div class="col-sm-3">
						<label class="control-label condensed"> Sampling Plan</label>
					</div>
					<div class="col-sm-1">
						<label class="control-label condensed"> AQL=</label>
					</div>
					<div class="col-sm-2">
						<input type="text" class="form-control condensed" name="sampling_plan_aql">
					</div>
					<div class="col-sm-2">
						<label class="control-label condensed"> n=</label>						
						<input type="text" class="form-control condensed" name="sampling_plan_n" style="width:65%; display: inline-block">
					</div>
					<div class="col-sm-2">
						<label class="control-label condensed"> Ac=</label>
						<input type="text" class="form-control condensed" name="sampling_plan_ac" style="width:65%; display: inline-block">
					</div>
					<div class="col-sm-2">
						<label class="control-label condensed"> Re=</label>
						<input type="text" class="form-control condensed" name="sampling_plan_re" style="width:65%; display: inline-block">
					</div>
				</div>
				<div class="row">
					<div class="col-sm-3">
						<label class="control-label condensed"> Affected Qty.</label>
					</div>
					<div class="col-sm-3">
						<input type="number" class="form-control condensed" name="affected_qty">
					</div>
					<div class="col-sm-3">
						<label class="control-label condensed"> % Defective</label>
					</div>
					<div class="col-sm-3">
						<input type="number" class="form-control condensed" name="defective_percentage">
					</div>
				</div>
				<div class="row">
					<div class="col-sm-3">
						<label class="control-label condensed"> Defective Qty.</label>
					</div>
					<div class="col-sm-3">
						<input type="number" class="form-control condensed" name="defective_qty">
					</div>
					<div class="col-sm-3">
						<label class="control-label condensed"> No. of Occurrence</label>
					</div>
					<div class="col-sm-3">
						<input type="text" class="form-control condensed" name="no_of_occurence">
					</div>
				</div>
				<div class="row">
					<div class="col-sm-3">
						<label class="control-label condensed"> Date Encountered</label>
					</div>
					<div class="col-sm-3">
						<input type="date" class="form-control condensed" name="date_encountered">
					</div>
					<div class="col-sm-3">
						<label class="control-label condensed"> Ref. QCFR No.</label>
					</div>
					<div class="col-sm-3">
						<input type="text" class="form-control condensed" name="reference_qcfr_no">
					</div>
				</div>
			</div>
		</div>
		<hr class="graph-orange">	
		<div class="row">
			<div class="col-sm-12">
				<label class="control-label condensed"> <b> [ FAILURE / DEFECT DESCRIPTION ] NOTE: Use additional attachment if necessary </b></label>
			</div>
			<div class="col-sm-12">
				<textarea type="text" class="form-control condensed" name="failure_defect_description"></textarea>
			</div>
			<div class="col-sm-2">
				<label class="control-label condensed"> File Attachment</label>
			</div>
			<div class="col-sm-10">
				<input type="file" class="form-control condensed" name="file_failure_defect_filename[]" multiple>
			</div>
		</div>	
		<hr class="graph-blue">
		<div class="row">
			<div class="col-sm-4">
				<div class="row">
					<div class="col-sm-12">
						<label class="control-label condensed"> <b>Disposition</b> </label>
					</div>
					<div class="col-sm-6">
						<div class="funkyradio">
							<div class="funkyradio-primary" >
								<input type="checkbox" name="disposition[]" id="chk_dispo_rework_repair" value="Rework/Repair">
								<label for="chk_dispo_rework_repair"> Rework/Repair</label>
							</div>
							<div class="funkyradio-primary">
								<input type="checkbox" name="disposition[]" id="chk_dispo_useasis" value="Use as is">
								<label for="chk_dispo_useasis"> Use as is</label>
							</div>
							<div class="funkyradio-primary">
								<input type="checkbox" name="disposition[]" id="chk_dispo_replace" value="Replace">
								<label for="chk_dispo_replace"> Replace</label>
							</div>
						</div>
					</div>
					<div class="col-sm-6">
						<div class="funkyradio">
							<div class="funkyradio-primary" >
								<input type="checkbox" name="disposition[]" id="chk_dispo_return" value="Return">
								<label for="chk_dispo_return"> Return</label>
							</div>
							<div class="funkyradio-primary">
								<input type="checkbox" name="disposition[]" id="chk_dispo_sorting" value="100% sorting">
								<label for="chk_dispo_sorting"> 100% sorting</label>
							</div>
							<div class="funkyradio-primary">
								<input type="checkbox" name="disposition[]" id="chk_dispo_others" value="Others (specify)">
								<label for="chk_dispo_others"> Others (specify)</label>
							</div>
							<input type="text" class="form-control condensed" name="disposition_others" placeholder="Others. Please Specify" disabled>
						</div>
					</div>
				</div>
			</div>		
			<div class="col-sm-4">
				<div class="row">
					<div class="col-sm-12">
						<label class="control-label condensed"> <b>Nature of Request</b> </label>
					</div>
					<div class="col-sm-12">
						<div class="funkyradio">
							<div class="funkyradio-primary" >
								<input type="radio" name="nature_of_request[]" id="chk_nor_info_only" value="For Information only">
								<label for="chk_nor_info_only"> For Information only</label>
							</div>
							<div class="funkyradio-primary">
								<input type="radio" name="nature_of_request[]" id="chk_nor_submit_8d" value="Submit 8D report">
								<label for="chk_nor_submit_8d"> Submit 8D report</label>
							</div>
							<div class="funkyradio-primary">
								<input type="radio" name="nature_of_request[]" id="chk_nor_capa" value="Corrective & Preventive Action Report">
								<label for="chk_nor_capa"> Corrective & Preventive Action Report</label>
							</div>
						</div>
					</div>
				</div>
			</div>	
			<div class="col-sm-4">
				<div class="row">
					<div class="col-sm-12">
						<label class="control-label condensed"> <b>Answer</b> </label>
					</div>
					<div class="col-sm-12">
						<div class="funkyradio">
							<div class="funkyradio-primary" >
								<input type="radio" name="answer[]" id="chk_ans_need" value="Need">
								<label for="chk_ans_need"> Need</label>
							</div>
							<div class="funkyradio-primary">
								<input type="radio" name="answer[]" id="chk_ans_no_need" value="No Need">
								<label for="chk_ans_no_need"> No Need</label>
							</div>
						</div>
					</div>
					<div class="col-sm-5" id="div_date_answer_label">
						<label class="control-label condensed"> <b>Date Answer Required</b> </label>
					</div>
					<div class="col-sm-7" id="div_date_answer_input">
						<input type="date" max="<?php echo date('Y-m-d'); ?>" class="form-control condensed" name="date_answer_required">
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

<div class="modal" tabindex="-1" role="dialog" id="mdl_view_qcfr">
 <div class="modal-dialog modal-lg" role="document" style="width:80%;">
  <div class="modal-content">
   <div class="modal-header">
    <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
    <h4 class="modal-title fa fa-eye">View Quality Complaint Feedback Report (QCFR)</h4>
   </div>
   <form id="frm_view_qcfr">
   <div class="modal-body">
		<div class="row">
			<div class="col-sm-6">
				<div class="row">
					<div class="col-sm-6">
						<div class="funkyradio" style="padding-bottom:5px;">
							<div class="funkyradio-primary">
								<input type="radio" name="subcon_pmi[]" id="chk_supplier_subcon" value="Supplier/Subcon">
								<label for="chk_supplier_subcon"> <b>Supplier/Subcon</b></label>
							</div>
						</div>
					</div>
					<div class="col-sm-6">
						<div class="funkyradio" style="padding-bottom:5px;">
							<div class="funkyradio-primary">
								<input type="radio" name="subcon_pmi[]" id="chk_assy" value="PMI Assy">
								<label for="chk_assy"> <b>PMI Assy</b></label>
							</div>
						</div>
					</div>
				</div>
				<div class="row">
					<div class="col-sm-4">
						<label class="control-label condensed">TO:</label>
					</div>
					<div class="col-sm-8">
						<input type="text" class="form-control condensed" name="to">
					</div>
				</div>
				<div class="row">
					<div class="col-sm-4">
						<label class="control-label condensed">ATTN:</label>
					</div>
					<div class="col-sm-8">
						<input type="text" class="form-control condensed" name="attn">
					</div>
				</div>
				<div class="row">
					<div class="col-sm-4">
						<label class="control-label condensed">CC:</label>
					</div>
					<div class="col-sm-8">
						<input type="text" class="form-control condensed" name="cc">
					</div>
				</div>
				<div class="row">
					<div class="col-sm-4">
						<label class="control-label condensed">FROM:</label>
					</div>
					<div class="col-sm-8">
						<input type="text" class="form-control condensed" name="from">
					</div>
				</div>
				<div class="row">
					<div class="col-sm-4">
						<label class="control-label condensed">DATE ISSUED:</label>
					</div>
					<div class="col-sm-8">
						<input type="date" class="form-control condensed" name="date_issued">
					</div>
				</div>
			</div>
			<div class="col-sm-6">
				<div class="row">
					<div class="col-sm-3" style="padding-right:0px;">
						<label class="control-label condensed"><b>Found During</b></label>
					</div>
					<div class="col-sm-9" style="">
						<div class="funkyradio">
							<div class="funkyradio-primary" >
								<input type="checkbox" name="found_during[]" id="chk_fd_outgoing_inspection" value="Outgoing Inspection">
								<label for="chk_fd_outgoing_inspection"> Outgoing Inspection</label>
							</div>
							<div class="funkyradio-primary">
								<input type="checkbox" name="found_during[]" id="chk_fd_incoming_inspection" value="Incoming Inspection">
								<label for="chk_fd_incoming_inspection"> Incoming Inspection</label>
							</div>
							<div class="funkyradio-primary">
								<input type="checkbox" name="found_during[]" id="chk_fd_in_process_inspection" value="In-Process Inspection">
								<label for="chk_fd_in_process_inspection"> In-Process Inspection</label>
							</div>
							<div class="funkyradio-primary">
								<input type="checkbox" name="found_during[]" id="chk_fd_quality_system_check" value="Quality System Check">
								<label for="chk_fd_quality_system_check"> Quality System Check</label>
							</div>
							<div class="funkyradio-primary">
								<input type="checkbox" name="found_during[]" id="chk_fd_others" value="Others. Please Specify">
								<label for="chk_fd_others"> Others. Please Specify</label>
							</div>
						</div>
						<input type="text" class="form-control condensed" name="found_during_others" placeholder="Others. Please Specify" disabled>
					</div>
				</div>
				<div class="row">
					<div class="col-sm-3" style="padding-right:0px;">
						<label class="control-label condensed"><b>Product Family</b></label>
					</div>
					<div class="col-sm-9" style="">
						<select class="form-control condensed" name="prod_family" style="width:100%;" required>
						</select>
					</div>
				</div>
			</div>
		</div>
		<hr class="graph-orange">
		<div class="row">
			<div class="col-sm-4">
				<label class="control-label condensed"> Reported by: </label>
			</div>
			<div class="col-sm-4">
				<label class="control-label condensed"> Verified & Conformed by: </label>
			</div>
			<div class="col-sm-4">
				<label class="control-label condensed"> Approved by: </label>
			</div>
		</div>
		<div class="row">
			<div class="col-sm-1">
				<label class="control-label condensed"> LQC </label>
			</div>
			<div class="col-sm-3">
				<input type="text" class="form-control condensed" name="reported_by">
			</div>
			<div class="col-sm-1">
				<label class="control-label condensed"> LQC </label>
			</div>
			<div class="col-sm-3">
				<input type="text" class="form-control condensed" name="verified_conformed_by_lqc">
			</div>
			<div class="col-sm-1">
				<label class="control-label condensed"> Section Head</label>
			</div>
			<div class="col-sm-3">
				<input type="text" class="form-control condensed" name="approved_by_sh">
			</div>
		</div>
		<div class="row" id="div_supplier_approvers">
			<div class="col-sm-1 col-sm-offset-4">
				<label class="control-label condensed"> Engineering </label>
			</div>
			<div class="col-sm-3">
				<input type="text" class="form-control condensed" name="verified_conformed_by_eng">
			</div>
			<div class="col-sm-1">
				<label class="control-label condensed"> Dept. Head </label>
			</div>
			<div class="col-sm-3">
				<input type="text" class="form-control condensed" name="approved_by_dh">
			</div>
		</div>
		<div class="row" id="div_supplier_approvers2">
			<div class="col-sm-1 col-sm-offset-4">
				<label class="control-label condensed"> Production </label>
			</div>
			<div class="col-sm-3">
				<input type="text" class="form-control condensed" name="verified_conformed_by_prdn">
			</div>
		</div>
		<hr class="graph-blue">
		<div class="row">
			<div class="col-sm-5">
				<div class="row">
					<div class="col-sm-4">
						<label class="control-label condensed"> Product Name</label>
					</div>
					<div class="col-sm-8">
						<input type="text" class="form-control condensed" name="product_name">
					</div>
				</div>
				<div class="row">
					<div class="col-sm-4">
						<label class="control-label condensed"> Model No.</label>
					</div>
					<div class="col-sm-8">
						<input type="text" class="form-control condensed" name="model_no">
					</div>
				</div>
				<div class="row">
					<div class="col-sm-4">
						<label class="control-label condensed"> Batch No./Lot No.</label>
					</div>
					<div class="col-sm-8">
						<input type="text" class="form-control condensed" name="batch_no_lot_no">
					</div>
				</div>
				<div class="row">
					<div class="col-sm-4">
						<label class="control-label condensed"> P.O. No./ INV. No.</label>
					</div>
					<div class="col-sm-8">
						<input type="text" class="form-control condensed" name="po_no_invoice_no">
					</div>
				</div>
				<div class="row">
					<div class="col-sm-4">
						<label class="control-label condensed"> Date Received</label>
					</div>
					<div class="col-sm-8">
						<input type="date" class="form-control condensed" name="date_received">
					</div>
				</div>
			</div>
			<div class="col-sm-7">
				<div class="row">
					<div class="col-sm-3">
							<label class="control-label condensed"> Inspection Method</label>
					</div>
					<div class="col-sm-5">
						<div class="funkyradio">
							<div class="funkyradio-primary">
								<input type="checkbox" name="inspection_method[]" id="chk_sampling" value="Sampling">
								<label for="chk_sampling"> Sampling</label>
							</div>
						</div>
					</div>
					<div class="col-sm-4">
						<div class="funkyradio">
							<div class="funkyradio-primary">
								<input type="checkbox" name="inspection_method[]" id="chk_hundred_percent" value="100%">
								<label for="chk_hundred_percent"> 100%</label>
							</div>
						</div>
					</div>
				</div>
				<div class="row">
					<div class="col-sm-3">
						<label class="control-label condensed"> Sampling Plan</label>
					</div>
					<div class="col-sm-1">
						<label class="control-label condensed"> AQL=</label>
					</div>
					<div class="col-sm-2">
						<input type="text" class="form-control condensed" name="sampling_plan_aql">
					</div>
					<div class="col-sm-2">
						<label class="control-label condensed"> n=</label>						
						<input type="text" class="form-control condensed" name="sampling_plan_n" style="width:65%; display: inline-block">
					</div>
					<div class="col-sm-2">
						<label class="control-label condensed"> Ac=</label>
						<input type="text" class="form-control condensed" name="sampling_plan_ac" style="width:65%; display: inline-block">
					</div>
					<div class="col-sm-2">
						<label class="control-label condensed"> Re=</label>
						<input type="text" class="form-control condensed" name="sampling_plan_re" style="width:65%; display: inline-block">
					</div>
				</div>
				<div class="row">
					<div class="col-sm-3">
						<label class="control-label condensed"> Affected Qty.</label>
					</div>
					<div class="col-sm-3">
						<input type="number" class="form-control condensed" name="affected_qty">
					</div>
					<div class="col-sm-3">
						<label class="control-label condensed"> % Defective</label>
					</div>
					<div class="col-sm-3">
						<input type="number" class="form-control condensed" name="defective_percentage">
					</div>
				</div>
				<div class="row">
					<div class="col-sm-3">
						<label class="control-label condensed"> Defective Qty.</label>
					</div>
					<div class="col-sm-3">
						<input type="number" class="form-control condensed" name="defective_qty">
					</div>
					<div class="col-sm-3">
						<label class="control-label condensed"> No. of Occurrence</label>
					</div>
					<div class="col-sm-3">
						<input type="text" class="form-control condensed" name="no_of_occurence">
					</div>
				</div>
				<div class="row">
					<div class="col-sm-3">
						<label class="control-label condensed"> Date Encountered</label>
					</div>
					<div class="col-sm-3">
						<input type="date" class="form-control condensed" name="date_encountered">
					</div>
					<div class="col-sm-3">
						<label class="control-label condensed"> Ref. QCFR No.</label>
					</div>
					<div class="col-sm-3">
						<input type="text" class="form-control condensed" name="reference_qcfr_no">
					</div>
				</div>
			</div>
		</div>
		<hr class="graph-orange">	
		<div class="row">
			<div class="col-sm-12">
				<label class="control-label condensed"> <b> [ FAILURE / DEFECT DESCRIPTION ] NOTE: Use additional attachment if necessary </b></label>
			</div>
			<div class="col-sm-12">
				<textarea type="text" class="form-control condensed" name="failure_defect_description"></textarea>
			</div>
			<div class="col-sm-2">
				<label class="control-label condensed"> File Attachment</label>
			</div>
			<div class="col-sm-10">
				
			</div>
		</div>	
		<hr class="graph-blue">
		<div class="row">
			<div class="col-sm-4">
				<div class="row">
					<div class="col-sm-12">
						<label class="control-label condensed"> <b>Disposition</b> </label>
					</div>
					<div class="col-sm-6">
						<div class="funkyradio">
							<div class="funkyradio-primary" >
								<input type="checkbox" name="disposition[]" id="chk_dispo_rework_repair" value="Rework/Repair">
								<label for="chk_dispo_rework_repair"> Rework/Repair</label>
							</div>
							<div class="funkyradio-primary">
								<input type="checkbox" name="disposition[]" id="chk_dispo_useasis" value="Use as is">
								<label for="chk_dispo_useasis"> Use as is</label>
							</div>
							<div class="funkyradio-primary">
								<input type="checkbox" name="disposition[]" id="chk_dispo_replace" value="Replace">
								<label for="chk_dispo_replace"> Replace</label>
							</div>
						</div>
					</div>
					<div class="col-sm-6">
						<div class="funkyradio">
							<div class="funkyradio-primary" >
								<input type="checkbox" name="disposition[]" id="chk_dispo_return" value="Return">
								<label for="chk_dispo_return"> Return</label>
							</div>
							<div class="funkyradio-primary">
								<input type="checkbox" name="disposition[]" id="chk_dispo_sorting" value="100% sorting">
								<label for="chk_dispo_sorting"> 100% sorting</label>
							</div>
							<div class="funkyradio-primary">
								<input type="checkbox" name="disposition[]" id="chk_dispo_others" value="Others (specify)">
								<label for="chk_dispo_others"> Others (specify)</label>
							</div>
							<input type="text" class="form-control condensed" name="disposition_others" placeholder="Others. Please Specify" disabled>
						</div>
					</div>
				</div>
			</div>		
			<div class="col-sm-4">
				<div class="row">
					<div class="col-sm-12">
						<label class="control-label condensed"> <b>Nature of Request</b> </label>
					</div>
					<div class="col-sm-12">
						<div class="funkyradio">
							<div class="funkyradio-primary" >
								<input type="radio" name="nature_of_request[]" id="chk_nor_info_only" value="For Information only">
								<label for="chk_nor_info_only"> For Information only</label>
							</div>
							<div class="funkyradio-primary">
								<input type="radio" name="nature_of_request[]" id="chk_nor_submit_8d" value="Submit 8D report">
								<label for="chk_nor_submit_8d"> Submit 8D report</label>
							</div>
							<div class="funkyradio-primary">
								<input type="radio" name="nature_of_request[]" id="chk_nor_capa" value="Corrective & Preventive Action Report">
								<label for="chk_nor_capa"> Corrective & Preventive Action Report</label>
							</div>
						</div>
					</div>
				</div>
			</div>	
			<div class="col-sm-4">
				<div class="row">
					<div class="col-sm-12">
						<label class="control-label condensed"> <b>Answer</b> </label>
					</div>
					<div class="col-sm-12">
						<div class="funkyradio">
							<div class="funkyradio-primary" >
								<input type="radio" name="answer[]" id="chk_ans_need" value="Need">
								<label for="chk_ans_need"> Need</label>
							</div>
							<div class="funkyradio-primary">
								<input type="radio" name="answer[]" id="chk_ans_no_need" value="No Need">
								<label for="chk_ans_no_need"> No Need</label>
							</div>
						</div>
					</div>
					<div class="col-sm-5" id="div_date_answer_label">
						<label class="control-label condensed"> <b>Date Answer Required</b> </label>
					</div>
					<div class="col-sm-7" id="div_date_answer_input">
						<input type="date" class="form-control condensed" name="date_answer_required">
					</div>
				</div>
			</div>		
		</div>		
		<hr class="graph-orange">		
		
   </div>
   <div class="modal-footer">
    <button type="button" class="btn btn-default fa fa-close" data-dismiss="modal"> Close</button>
   </div>
   </form>
  </div><!-- /.modal-content -->
 </div><!-- /.modal-dialog -->
</div><!-- /.modal -->

<div class="modal" tabindex="-1" role="dialog" id="mdl_view_with_answer_qcfr2">
 <div class="modal-dialog modal-lg" role="document" style="width:80%;">
  <div class="modal-content">
   <div class="modal-header">
    <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
    <h4 class="modal-title fa fa-eye">View Quality Complaint Feedback Report (QCFR)</h4>
   </div>
   <form id="frm_view_with_answer_qcfr2">
   <div class="modal-body">
		<div class="row">
			<div class="col-sm-6">
				<div class="row">
					<div class="col-sm-6">
						<div class="funkyradio" style="padding-bottom:5px;">
							<div class="funkyradio-primary">
								<input type="radio" name="subcon_pmi[]" id="chk_supplier_subcon" value="Supplier/Subcon">
								<label for="chk_supplier_subcon"> <b>Supplier/Subcon</b></label>
							</div>
						</div>
						<div class="funkyradio" style="padding-top:5px;">
							<div class="funkyradio-primary">
								<input type="radio" name="subcon_pmi[]" id="chk_assy" value="PMI Assy">
								<label for="chk_assy"> <b>PMI Assy</b></label>
							</div>
						</div>
					</div>
					<div class="col-sm-6">						
						<input type="text" class="form-control condensed" name="supplier_subcon">
						<input type="text" class="form-control condensed" name="pmi_assy">
					</div>
				</div>
				<div class="row">
					<div class="col-sm-4">
						<label class="control-label condensed">TO:</label>
					</div>
					<div class="col-sm-8">
						<input type="text" class="form-control condensed" name="to">
					</div>
				</div>
				<div class="row">
					<div class="col-sm-4">
						<label class="control-label condensed">ATTN:</label>
					</div>
					<div class="col-sm-8">
						<input type="text" class="form-control condensed" name="attn">
					</div>
				</div>
				<div class="row">
					<div class="col-sm-4">
						<label class="control-label condensed">CC:</label>
					</div>
					<div class="col-sm-8">
						<input type="text" class="form-control condensed" name="cc">
					</div>
				</div>
				<div class="row">
					<div class="col-sm-4">
						<label class="control-label condensed">FROM:</label>
					</div>
					<div class="col-sm-8">
						<input type="text" class="form-control condensed" name="from">
					</div>
				</div>
				<div class="row">
					<div class="col-sm-4">
						<label class="control-label condensed">DATE ISSUED:</label>
					</div>
					<div class="col-sm-8">
						<input type="date" class="form-control condensed" name="date_issued">
					</div>
				</div>
			</div>
			<div class="col-sm-6">
				<div class="row">
					<div class="col-sm-3">
						<label class="control-label condensed"><b>QCFR No.:</b></label>
					</div>
					<div class="col-sm-9">
						<input type="text" class="form-control condensed" name="qcfr_no">
					</div>
				</div>
				<div class="row">
					<div class="col-sm-3" style="padding-right:0px;">
						<label class="control-label condensed"><b>Found During</b></label>
					</div>
					<div class="col-sm-9" style="">
						<div class="funkyradio">
							<div class="funkyradio-primary" >
								<input type="checkbox" name="found_during[]" id="chk_fd_outgoing_inspection" value="Outgoing Inspection">
								<label for="chk_fd_outgoing_inspection"> Outgoing Inspection</label>
							</div>
							<div class="funkyradio-primary">
								<input type="checkbox" name="found_during[]" id="chk_fd_incoming_inspection" value="Incoming Inspection">
								<label for="chk_fd_incoming_inspection"> Incoming Inspection</label>
							</div>
							<div class="funkyradio-primary">
								<input type="checkbox" name="found_during[]" id="chk_fd_in_process_inspection" value="In-Process Inspection">
								<label for="chk_fd_in_process_inspection"> In-Process Inspection</label>
							</div>
							<div class="funkyradio-primary">
								<input type="checkbox" name="found_during[]" id="chk_fd_quality_system_check" value="Quality System Check">
								<label for="chk_fd_quality_system_check"> Quality System Check</label>
							</div>
							<div class="funkyradio-primary">
								<input type="checkbox" name="found_during[]" id="chk_fd_others" value="Others. Please Specify">
								<label for="chk_fd_others"> Others. Please Specify</label>
							</div>
						</div>
						<input type="text" class="form-control condensed" name="found_during_others" placeholder="Others. Please Specify" disabled>
					</div>
				</div>
				<div class="row">
					<div class="col-sm-3" style="padding-right:0px;">
						<label class="control-label condensed"><b>Product Family</b></label>
					</div>
					<div class="col-sm-9" style="">
						<select class="form-control condensed" name="prod_family" style="width:100%;" required>
						</select>
					</div>
				</div>
			</div>
		</div>
		<hr class="graph-orange">
		<div class="row">
			<div class="col-sm-4">
				<label class="control-label condensed"> Reported by: </label>
			</div>
			<div class="col-sm-4">
				<label class="control-label condensed"> Verified & Conformed by: </label>
			</div>
			<div class="col-sm-4">
				<label class="control-label condensed"> Approved by: </label>
			</div>
		</div>
		<div class="row">
			<div class="col-sm-1">
				<label class="control-label condensed"> LQC </label>
			</div>
			<div class="col-sm-3">
				<input type="text" class="form-control condensed" name="reported_by">
			</div>
			<div class="col-sm-1">
				<label class="control-label condensed"> LQC </label>
			</div>
			<div class="col-sm-3">
				<input type="text" class="form-control condensed" name="verified_conformed_by_lqc">
			</div>
			<div class="col-sm-1">
				<label class="control-label condensed"> Section Head</label>
			</div>
			<div class="col-sm-3">
				<input type="text" class="form-control condensed" name="approved_by_sh">
			</div>
		</div>
		<div class="row">
			<div class="col-sm-1 col-sm-offset-4">
				<label class="control-label condensed"> Engineering </label>
			</div>
			<div class="col-sm-3">
				<input type="text" class="form-control condensed" name="verified_conformed_by_eng">
			</div>
			<div class="col-sm-1">
				<label class="control-label condensed"> Dept. Head </label>
			</div>
			<div class="col-sm-3">
				<input type="text" class="form-control condensed" name="approved_by_dh">
			</div>
		</div>
		<div class="row">
			<div class="col-sm-1 col-sm-offset-4">
				<label class="control-label condensed"> Production </label>
			</div>
			<div class="col-sm-3">
				<input type="text" class="form-control condensed" name="verified_conformed_by_prdn">
			</div>
		</div>
		<hr class="graph-blue">
		<div class="row">
			<div class="col-sm-5">
				<div class="row">
					<div class="col-sm-4">
						<label class="control-label condensed"> Product Name</label>
					</div>
					<div class="col-sm-8">
						<input type="text" class="form-control condensed" name="product_name">
					</div>
				</div>
				<div class="row">
					<div class="col-sm-4">
						<label class="control-label condensed"> Model No.</label>
					</div>
					<div class="col-sm-8">
						<input type="text" class="form-control condensed" name="model_no">
					</div>
				</div>
				<div class="row">
					<div class="col-sm-4">
						<label class="control-label condensed"> Batch No./Lot No.</label>
					</div>
					<div class="col-sm-8">
						<input type="text" class="form-control condensed" name="batch_no_lot_no">
					</div>
				</div>
				<div class="row">
					<div class="col-sm-4">
						<label class="control-label condensed"> P.O. No./ INV. No.</label>
					</div>
					<div class="col-sm-8">
						<input type="text" class="form-control condensed" name="po_no_invoice_no">
					</div>
				</div>
				<div class="row">
					<div class="col-sm-4">
						<label class="control-label condensed"> Date Received</label>
					</div>
					<div class="col-sm-8">
						<input type="date" class="form-control condensed" name="date_received">
					</div>
				</div>
			</div>
			<div class="col-sm-7">
				<div class="row">
					<div class="col-sm-3">
							<label class="control-label condensed"> Inspection Method</label>
					</div>
					<div class="col-sm-5">
						<div class="funkyradio">
							<div class="funkyradio-primary">
								<input type="checkbox" name="inspection_method[]" id="chk_sampling" value="Sampling">
								<label for="chk_sampling"> Sampling</label>
							</div>
						</div>
					</div>
					<div class="col-sm-4">
						<div class="funkyradio">
							<div class="funkyradio-primary">
								<input type="checkbox" name="inspection_method[]" id="chk_hundred_percent" value="100%">
								<label for="chk_hundred_percent"> 100%</label>
							</div>
						</div>
					</div>
				</div>
				<div class="row">
					<div class="col-sm-3">
						<label class="control-label condensed"> Sampling Plan</label>
					</div>
					<div class="col-sm-1">
						<label class="control-label condensed"> AQL=</label>
					</div>
					<div class="col-sm-2">
						<input type="text" class="form-control condensed" name="sampling_plan_aql">
					</div>
					<div class="col-sm-2">
						<label class="control-label condensed"> n=</label>						
						<input type="text" class="form-control condensed" name="sampling_plan_n" style="width:65%; display: inline-block">
					</div>
					<div class="col-sm-2">
						<label class="control-label condensed"> Ac=</label>
						<input type="text" class="form-control condensed" name="sampling_plan_ac" style="width:65%; display: inline-block">
					</div>
					<div class="col-sm-2">
						<label class="control-label condensed"> Re=</label>
						<input type="text" class="form-control condensed" name="sampling_plan_re" style="width:65%; display: inline-block">
					</div>
				</div>
				<div class="row">
					<div class="col-sm-3">
						<label class="control-label condensed"> Affected Qty.</label>
					</div>
					<div class="col-sm-3">
						<input type="number" class="form-control condensed" name="affected_qty">
					</div>
					<div class="col-sm-3">
						<label class="control-label condensed"> % Defective</label>
					</div>
					<div class="col-sm-3">
						<input type="number" class="form-control condensed" name="defective_percentage">
					</div>
				</div>
				<div class="row">
					<div class="col-sm-3">
						<label class="control-label condensed"> Defective Qty.</label>
					</div>
					<div class="col-sm-3">
						<input type="number" class="form-control condensed" name="defective_qty">
					</div>
					<div class="col-sm-3">
						<label class="control-label condensed"> No. of Occurrence</label>
					</div>
					<div class="col-sm-3">
						<input type="text" class="form-control condensed" name="no_of_occurence">
					</div>
				</div>
				<div class="row">
					<div class="col-sm-3">
						<label class="control-label condensed"> Date Encountered</label>
					</div>
					<div class="col-sm-3">
						<input type="date" class="form-control condensed" name="date_encountered">
					</div>
					<div class="col-sm-3">
						<label class="control-label condensed"> Ref. QCFR No.</label>
					</div>
					<div class="col-sm-3">
						<input type="text" class="form-control condensed" name="reference_qcfr_no">
					</div>
				</div>
			</div>
		</div>
		<hr class="graph-orange">	
		<div class="row">
			<div class="col-sm-12">
				<label class="control-label condensed"> <b> [ FAILURE / DEFECT DESCRIPTION ] NOTE: Use additional attachment if necessary </b></label>
			</div>
			<div class="col-sm-12">
				<textarea type="text" class="form-control condensed" name="failure_defect_description"></textarea>
			</div>
			<div class="col-sm-2">
				<label class="control-label condensed"> File Attachment</label>
			</div>
			<div class="col-sm-10">
				
			</div>
		</div>	
		<hr class="graph-blue">
		<div class="row">
			<div class="col-sm-4">
				<div class="row">
					<div class="col-sm-12">
						<label class="control-label condensed"> <b>Disposition</b> </label>
					</div>
					<div class="col-sm-6">
						<div class="funkyradio">
							<div class="funkyradio-primary" >
								<input type="checkbox" name="disposition[]" id="chk_dispo_rework_repair" value="Rework/Repair">
								<label for="chk_dispo_rework_repair"> Rework/Repair</label>
							</div>
							<div class="funkyradio-primary">
								<input type="checkbox" name="disposition[]" id="chk_dispo_useasis" value="Use as is">
								<label for="chk_dispo_useasis"> Use as is</label>
							</div>
							<div class="funkyradio-primary">
								<input type="checkbox" name="disposition[]" id="chk_dispo_replace" value="Replace">
								<label for="chk_dispo_replace"> Replace</label>
							</div>
						</div>
					</div>
					<div class="col-sm-6">
						<div class="funkyradio">
							<div class="funkyradio-primary" >
								<input type="checkbox" name="disposition[]" id="chk_dispo_return" value="Return">
								<label for="chk_dispo_return"> Return</label>
							</div>
							<div class="funkyradio-primary">
								<input type="checkbox" name="disposition[]" id="chk_dispo_sorting" value="100% sorting">
								<label for="chk_dispo_sorting"> 100% sorting</label>
							</div>
							<div class="funkyradio-primary">
								<input type="checkbox" name="disposition[]" id="chk_dispo_others" value="Others (specify)">
								<label for="chk_dispo_others"> Others (specify)</label>
							</div>
							<input type="text" class="form-control condensed" name="disposition_others" placeholder="Others. Please Specify" disabled>
						</div>
					</div>
				</div>
			</div>		
			<div class="col-sm-4">
				<div class="row">
					<div class="col-sm-12">
						<label class="control-label condensed"> <b>Nature of Request</b> </label>
					</div>
					<div class="col-sm-12">
						<div class="funkyradio">
							<div class="funkyradio-primary" >
								<input type="radio" name="nature_of_request[]" id="chk_nor_info_only" value="For Information only">
								<label for="chk_nor_info_only"> For Information only</label>
							</div>
							<div class="funkyradio-primary">
								<input type="radio" name="nature_of_request[]" id="chk_nor_submit_8d" value="Submit 8D report">
								<label for="chk_nor_submit_8d"> Submit 8D report</label>
							</div>
							<div class="funkyradio-primary">
								<input type="radio" name="nature_of_request[]" id="chk_nor_capa" value="Corrective & Preventive Action Report">
								<label for="chk_nor_capa"> Corrective & Preventive Action Report</label>
							</div>
						</div>
					</div>
				</div>
			</div>	
			<div class="col-sm-4">
				<div class="row">
					<div class="col-sm-12">
						<label class="control-label condensed"> <b>Answer</b> </label>
					</div>
					<div class="col-sm-12">
						<div class="funkyradio">
							<div class="funkyradio-primary" >
								<input type="radio" name="answer[]" id="chk_ans_need" value="Need">
								<label for="chk_ans_need"> Need</label>
							</div>
							<div class="funkyradio-primary">
								<input type="radio" name="answer[]" id="chk_ans_no_need" value="No Need">
								<label for="chk_ans_no_need"> No Need</label>
							</div>
						</div>
					</div>
					<div class="col-sm-5" id="div_date_answer_label">
						<label class="control-label condensed"> <b>Date Answer Required</b> </label>
					</div>
					<div class="col-sm-7" id="div_date_answer_input">
						<input type="date" class="form-control condensed" name="date_answer_required">
					</div>
				</div>
			</div>		
		</div>		
		
		<hr class="graph-orange">		
		<div class="row">
			<div class="col-sm-12">
				<div class="row">
					<div class="col-sm-12">
						<label class="control-label condensed"> <b>Recipient Fill-in</b> </label>
					</div>
					<div class="col-sm-2">
						<label class="control-label condensed">8D Report:</label>
					</div>
					<div class="col-sm-4">
						<button type="button" class="btn btn-default btn-link" id="btn_view_attachment_8d" name="pkid"> Download attachment</button>
					</div>
					<div class="col-sm-2">
						<label class="control-label condensed">CAPA Report:</label>
					</div>
					<div class="col-sm-4">
						<button type="button" class="btn btn-default btn-link" id="btn_view_attachment_capa" name="pkid"> Download attachment</button>
					</div>
				</div>
			</div>
		</div>
		<hr class="graph-blue">		
		<div class="row">
			<div class="col-sm-4">
				<div class="row">
					<div class="col-sm-12">
						<label class="control-label condensed"> <b>PMI/Originator Fill-in</b> </label>
					</div>
					<div class="col-sm-4">
						<label class="control-label condensed">Factory Line Audit?:</label>
					</div>
					<div class="col-sm-8">
						<div class="funkyradio" style="padding-bottom:5px;">
							<div class="funkyradio-primary">
								<input type="radio" name="factory_line_audit[]" id="chk_yes" value="Yes">
								<label for="chk_yes"> <b>Yes</b></label>
							</div>
							<div class="funkyradio-primary">
								<input type="radio" name="factory_line_audit[]" id="chk_no" value="No">
								<label for="chk_no"> <b>No</b></label>
							</div>
						</div>
					</div>
				</div>
			</div>
		</div>
		<div class="row">
			<div class="col-sm-12">
				<label class="control-label condensed"> [ Result of Confirmation ]</label>
			</div>
			<div class="col-sm-12">
				<label class="control-label condensed"> 1. Treatment for affected lot:</label>
			</div>
			<div class="col-sm-12">
				<textarea type="text" class="form-control condensed" name="treatment_affected_lot"></textarea>
			</div>
			<div class="col-sm-12">
				<label class="control-label condensed"> 2. Verification result for corrective and preventive action:</label>
			</div>
			<div class="col-sm-12">
				<textarea type="text" class="form-control condensed" name="verification_result"></textarea>
			</div>
		</div>	
		<div class="row">
			<div class="col-sm-4">
				<label class="control-label condensed">Prepared by:</label>
			</div>
			<div class="col-sm-4">
				<label class="control-label condensed"> Checked by:</label>
			</div>
			<div class="col-sm-4">
				<label class="control-label condensed"> Approved by:</label>
			</div>
		</div>	
		<div class="row">
			<div class="col-sm-4">
				<input type="text" class="form-control condensed" name="created_by">
			</div>
			<div class="col-sm-4">
				<input type="text" class="form-control condensed" name="pmi_orginator_fill_in_checked_by">
			</div>
			<div class="col-sm-4">
				<input type="text" class="form-control condensed" name="pmi_orginator_fill_in_approved_by">
			</div>
		</div>	
   </div>
   <div class="modal-footer">
    <button type="button" class="btn btn-default fa fa-close" data-dismiss="modal"> Close</button>
   </div>
   </form>
  </div><!-- /.modal-content -->
 </div><!-- /.modal-dialog -->
</div><!-- /.modal -->


<div class="modal" tabindex="-1" role="dialog" id="mdl_view_with_answer_qcfr">
 <div class="modal-dialog modal-lg" role="document" style="width:80%;">
  <div class="modal-content">
   <div class="modal-header">
    <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
    <h4 class="modal-title fa fa-eye">View Quality Complaint Feedback Report (QCFR)</h4>
   </div>
   <form id="frm_view_with_answer_qcfr">
   <div class="modal-body">
		<div class="row">
			<div class="col-sm-6">
				<div class="row">
					<div class="col-sm-6">
						<div class="funkyradio" style="padding-bottom:5px;">
							<div class="funkyradio-primary">
								<input type="radio" name="subcon_pmi[]" id="chk_supplier_subcon" value="Supplier/Subcon">
								<label for="chk_supplier_subcon"> <b>Supplier/Subcon</b></label>
							</div>
						</div>
					</div>
					<div class="col-sm-6">
						<div class="funkyradio" style="padding-bottom:5px;">
							<div class="funkyradio-primary">
								<input type="radio" name="subcon_pmi[]" id="chk_assy" value="PMI Assy">
								<label for="chk_assy"> <b>PMI Assy</b></label>
							</div>
						</div>
					</div>
				</div>
				<div class="row">
					<div class="col-sm-4">
						<label class="control-label condensed">TO:</label>
					</div>
					<div class="col-sm-8">
						<input type="text" class="form-control condensed" name="to">
					</div>
				</div>
				<div class="row">
					<div class="col-sm-4">
						<label class="control-label condensed">ATTN:</label>
					</div>
					<div class="col-sm-8">
						<input type="text" class="form-control condensed" name="attn">
					</div>
				</div>
				<div class="row">
					<div class="col-sm-4">
						<label class="control-label condensed">CC:</label>
					</div>
					<div class="col-sm-8">
						<input type="text" class="form-control condensed" name="cc">
					</div>
				</div>
				<div class="row">
					<div class="col-sm-4">
						<label class="control-label condensed">FROM:</label>
					</div>
					<div class="col-sm-8">
						<input type="text" class="form-control condensed" name="from">
					</div>
				</div>
				<div class="row">
					<div class="col-sm-4">
						<label class="control-label condensed">DATE ISSUED:</label>
					</div>
					<div class="col-sm-8">
						<input type="date" class="form-control condensed" name="date_issued">
					</div>
				</div>
			</div>
			<div class="col-sm-6">
				<div class="row">
					<div class="col-sm-3" style="padding-right:0px;">
						<label class="control-label condensed"><b>Found During</b></label>
					</div>
					<div class="col-sm-9" style="">
						<div class="funkyradio">
							<div class="funkyradio-primary" >
								<input type="checkbox" name="found_during[]" id="chk_fd_outgoing_inspection" value="Outgoing Inspection">
								<label for="chk_fd_outgoing_inspection"> Outgoing Inspection</label>
							</div>
							<div class="funkyradio-primary">
								<input type="checkbox" name="found_during[]" id="chk_fd_incoming_inspection" value="Incoming Inspection">
								<label for="chk_fd_incoming_inspection"> Incoming Inspection</label>
							</div>
							<div class="funkyradio-primary">
								<input type="checkbox" name="found_during[]" id="chk_fd_in_process_inspection" value="In-Process Inspection">
								<label for="chk_fd_in_process_inspection"> In-Process Inspection</label>
							</div>
							<div class="funkyradio-primary">
								<input type="checkbox" name="found_during[]" id="chk_fd_quality_system_check" value="Quality System Check">
								<label for="chk_fd_quality_system_check"> Quality System Check</label>
							</div>
							<div class="funkyradio-primary">
								<input type="checkbox" name="found_during[]" id="chk_fd_others" value="Others. Please Specify">
								<label for="chk_fd_others"> Others. Please Specify</label>
							</div>
						</div>
						<input type="text" class="form-control condensed" name="found_during_others" placeholder="Others. Please Specify" disabled>
					</div>
				</div>
				<div class="row">
					<div class="col-sm-3" style="padding-right:0px;">
						<label class="control-label condensed"><b>Product Family</b></label>
					</div>
					<div class="col-sm-9" style="">
						<select class="form-control condensed" name="prod_family" style="width:100%;" required>
						</select>
					</div>
				</div>
			</div>
		</div>
		<hr class="graph-orange">
		<div class="row">
			<div class="col-sm-4">
				<label class="control-label condensed"> Reported by: </label>
			</div>
			<div class="col-sm-4">
				<label class="control-label condensed"> Verified & Conformed by: </label>
			</div>
			<div class="col-sm-4">
				<label class="control-label condensed"> Approved by: </label>
			</div>
		</div>
		<div class="row">
			<div class="col-sm-1">
				<label class="control-label condensed"> LQC </label>
			</div>
			<div class="col-sm-3">
				<input type="text" class="form-control condensed" name="reported_by">
			</div>
			<div class="col-sm-1">
				<label class="control-label condensed"> LQC </label>
			</div>
			<div class="col-sm-3">
				<input type="text" class="form-control condensed" name="verified_conformed_by_lqc">
			</div>
			<div class="col-sm-1">
				<label class="control-label condensed"> Section Head</label>
			</div>
			<div class="col-sm-3">
				<input type="text" class="form-control condensed" name="approved_by_sh">
			</div>
		</div>
		<div class="row" id="div_supplier_approvers">
			<div class="col-sm-1 col-sm-offset-4">
				<label class="control-label condensed"> Engineering </label>
			</div>
			<div class="col-sm-3">
				<input type="text" class="form-control condensed" name="verified_conformed_by_eng">
			</div>
			<div class="col-sm-1">
				<label class="control-label condensed"> Dept. Head </label>
			</div>
			<div class="col-sm-3">
				<input type="text" class="form-control condensed" name="approved_by_dh">
			</div>
		</div>
		<div class="row" id="div_supplier_approvers2">
			<div class="col-sm-1 col-sm-offset-4">
				<label class="control-label condensed"> Production </label>
			</div>
			<div class="col-sm-3">
				<input type="text" class="form-control condensed" name="verified_conformed_by_prdn">
			</div>
		</div>
		<hr class="graph-blue">
		<div class="row">
			<div class="col-sm-5">
				<div class="row">
					<div class="col-sm-4">
						<label class="control-label condensed"> Product Name</label>
					</div>
					<div class="col-sm-8">
						<input type="text" class="form-control condensed" name="product_name">
					</div>
				</div>
				<div class="row">
					<div class="col-sm-4">
						<label class="control-label condensed"> Model No.</label>
					</div>
					<div class="col-sm-8">
						<input type="text" class="form-control condensed" name="model_no">
					</div>
				</div>
				<div class="row">
					<div class="col-sm-4">
						<label class="control-label condensed"> Batch No./Lot No.</label>
					</div>
					<div class="col-sm-8">
						<input type="text" class="form-control condensed" name="batch_no_lot_no">
					</div>
				</div>
				<div class="row">
					<div class="col-sm-4">
						<label class="control-label condensed"> P.O. No./ INV. No.</label>
					</div>
					<div class="col-sm-8">
						<input type="text" class="form-control condensed" name="po_no_invoice_no">
					</div>
				</div>
				<div class="row">
					<div class="col-sm-4">
						<label class="control-label condensed"> Date Received</label>
					</div>
					<div class="col-sm-8">
						<input type="date" class="form-control condensed" name="date_received">
					</div>
				</div>
			</div>
			<div class="col-sm-7">
				<div class="row">
					<div class="col-sm-3">
							<label class="control-label condensed"> Inspection Method</label>
					</div>
					<div class="col-sm-5">
						<div class="funkyradio">
							<div class="funkyradio-primary">
								<input type="checkbox" name="inspection_method[]" id="chk_sampling" value="Sampling">
								<label for="chk_sampling"> Sampling</label>
							</div>
						</div>
					</div>
					<div class="col-sm-4">
						<div class="funkyradio">
							<div class="funkyradio-primary">
								<input type="checkbox" name="inspection_method[]" id="chk_hundred_percent" value="100%">
								<label for="chk_hundred_percent"> 100%</label>
							</div>
						</div>
					</div>
				</div>
				<div class="row">
					<div class="col-sm-3">
						<label class="control-label condensed"> Sampling Plan</label>
					</div>
					<div class="col-sm-1">
						<label class="control-label condensed"> AQL=</label>
					</div>
					<div class="col-sm-2">
						<input type="text" class="form-control condensed" name="sampling_plan_aql">
					</div>
					<div class="col-sm-2">
						<label class="control-label condensed"> n=</label>						
						<input type="text" class="form-control condensed" name="sampling_plan_n" style="width:65%; display: inline-block">
					</div>
					<div class="col-sm-2">
						<label class="control-label condensed"> Ac=</label>
						<input type="text" class="form-control condensed" name="sampling_plan_ac" style="width:65%; display: inline-block">
					</div>
					<div class="col-sm-2">
						<label class="control-label condensed"> Re=</label>
						<input type="text" class="form-control condensed" name="sampling_plan_re" style="width:65%; display: inline-block">
					</div>
				</div>
				<div class="row">
					<div class="col-sm-3">
						<label class="control-label condensed"> Affected Qty.</label>
					</div>
					<div class="col-sm-3">
						<input type="number" class="form-control condensed" name="affected_qty">
					</div>
					<div class="col-sm-3">
						<label class="control-label condensed"> % Defective</label>
					</div>
					<div class="col-sm-3">
						<input type="number" class="form-control condensed" name="defective_percentage">
					</div>
				</div>
				<div class="row">
					<div class="col-sm-3">
						<label class="control-label condensed"> Defective Qty.</label>
					</div>
					<div class="col-sm-3">
						<input type="number" class="form-control condensed" name="defective_qty">
					</div>
					<div class="col-sm-3">
						<label class="control-label condensed"> No. of Occurrence</label>
					</div>
					<div class="col-sm-3">
						<input type="text" class="form-control condensed" name="no_of_occurence">
					</div>
				</div>
				<div class="row">
					<div class="col-sm-3">
						<label class="control-label condensed"> Date Encountered</label>
					</div>
					<div class="col-sm-3">
						<input type="date" class="form-control condensed" name="date_encountered">
					</div>
					<div class="col-sm-3">
						<label class="control-label condensed"> Ref. QCFR No.</label>
					</div>
					<div class="col-sm-3">
						<input type="text" class="form-control condensed" name="reference_qcfr_no">
					</div>
				</div>
			</div>
		</div>
		<hr class="graph-orange">	
		<div class="row">
			<div class="col-sm-12">
				<label class="control-label condensed"> <b> [ FAILURE / DEFECT DESCRIPTION ] NOTE: Use additional attachment if necessary </b></label>
			</div>
			<div class="col-sm-12">
				<textarea type="text" class="form-control condensed" name="failure_defect_description"></textarea>
			</div>
			<div class="col-sm-2">
				<label class="control-label condensed"> File Attachment</label>
			</div>
			<div class="col-sm-10">
				
			</div>
		</div>	
		<hr class="graph-blue">
		<div class="row">
			<div class="col-sm-4">
				<div class="row">
					<div class="col-sm-12">
						<label class="control-label condensed"> <b>Disposition</b> </label>
					</div>
					<div class="col-sm-6">
						<div class="funkyradio">
							<div class="funkyradio-primary" >
								<input type="checkbox" name="disposition[]" id="chk_dispo_rework_repair" value="Rework/Repair">
								<label for="chk_dispo_rework_repair"> Rework/Repair</label>
							</div>
							<div class="funkyradio-primary">
								<input type="checkbox" name="disposition[]" id="chk_dispo_useasis" value="Use as is">
								<label for="chk_dispo_useasis"> Use as is</label>
							</div>
							<div class="funkyradio-primary">
								<input type="checkbox" name="disposition[]" id="chk_dispo_replace" value="Replace">
								<label for="chk_dispo_replace"> Replace</label>
							</div>
						</div>
					</div>
					<div class="col-sm-6">
						<div class="funkyradio">
							<div class="funkyradio-primary" >
								<input type="checkbox" name="disposition[]" id="chk_dispo_return" value="Return">
								<label for="chk_dispo_return"> Return</label>
							</div>
							<div class="funkyradio-primary">
								<input type="checkbox" name="disposition[]" id="chk_dispo_sorting" value="100% sorting">
								<label for="chk_dispo_sorting"> 100% sorting</label>
							</div>
							<div class="funkyradio-primary">
								<input type="checkbox" name="disposition[]" id="chk_dispo_others" value="Others (specify)">
								<label for="chk_dispo_others"> Others (specify)</label>
							</div>
							<input type="text" class="form-control condensed" name="disposition_others" placeholder="Others. Please Specify" disabled>
						</div>
					</div>
				</div>
			</div>		
			<div class="col-sm-4">
				<div class="row">
					<div class="col-sm-12">
						<label class="control-label condensed"> <b>Nature of Request</b> </label>
					</div>
					<div class="col-sm-12">
						<div class="funkyradio">
							<div class="funkyradio-primary" >
								<input type="radio" name="nature_of_request[]" id="chk_nor_info_only" value="For Information only">
								<label for="chk_nor_info_only"> For Information only</label>
							</div>
							<div class="funkyradio-primary">
								<input type="radio" name="nature_of_request[]" id="chk_nor_submit_8d" value="Submit 8D report">
								<label for="chk_nor_submit_8d"> Submit 8D report</label>
							</div>
							<div class="funkyradio-primary">
								<input type="radio" name="nature_of_request[]" id="chk_nor_capa" value="Corrective & Preventive Action Report">
								<label for="chk_nor_capa"> Corrective & Preventive Action Report</label>
							</div>
						</div>
					</div>
				</div>
			</div>	
			<div class="col-sm-4">
				<div class="row">
					<div class="col-sm-12">
						<label class="control-label condensed"> <b>Answer</b> </label>
					</div>
					<div class="col-sm-12">
						<div class="funkyradio">
							<div class="funkyradio-primary" >
								<input type="radio" name="answer[]" id="chk_ans_need" value="Need">
								<label for="chk_ans_need"> Need</label>
							</div>
							<div class="funkyradio-primary">
								<input type="radio" name="answer[]" id="chk_ans_no_need" value="No Need">
								<label for="chk_ans_no_need"> No Need</label>
							</div>
						</div>
					</div>
					<div class="col-sm-5" id="div_date_answer_label">
						<label class="control-label condensed"> <b>Date Answer Required</b> </label>
					</div>
					<div class="col-sm-7" id="div_date_answer_input">
						<input type="date" class="form-control condensed" name="date_answer_required">
					</div>
				</div>
			</div>		
		</div>		
		<hr class="graph-orange">		
		<div class="row">
			<div class="col-sm-12">
				<div class="row">
					<div class="col-sm-12">
						<label class="control-label condensed"> <b>Recipient Fill-in</b> </label>
					</div>
					<div class="col-sm-2">
						<label class="control-label condensed">8D Report:</label>
					</div>
					<div class="col-sm-4">
						<button type="button" class="btn btn-default btn-link" id="btn_view_attachment_8d" name="pkid"> Download attachment</button>
					</div>
					<div class="col-sm-2">
						<label class="control-label condensed">CAPA Report:</label>
					</div>
					<div class="col-sm-4">
						<button type="button" class="btn btn-default btn-link" id="btn_view_attachment_capa" name="pkid"> Download attachment</button>
					</div>
				</div>
			</div>
		</div>
		<hr class="graph-blue">		
		<div class="row">
			<div class="col-sm-4">
				<div class="row">
					<div class="col-sm-12">
						<label class="control-label condensed"> <b>PMI/Originator Fill-in</b> </label>
					</div>
					<div class="col-sm-4">
						<label class="control-label condensed">Factory Line Audit?:</label>
					</div>
					<div class="col-sm-8">
						<div class="funkyradio" style="padding-bottom:5px;">
							<div class="funkyradio-primary">
								<input type="radio" name="factory_line_audit[]" id="chk_yes" value="Yes">
								<label for="chk_yes"> <b>Yes</b></label>
							</div>
							<div class="funkyradio-primary">
								<input type="radio" name="factory_line_audit[]" id="chk_no" value="No">
								<label for="chk_no"> <b>No</b></label>
							</div>
						</div>
					</div>
				</div>
			</div>
		</div>
		<div class="row">
			<div class="col-sm-12">
				<label class="control-label condensed"> [ Result of Confirmation ]</label>
			</div>
			<div class="col-sm-12">
				<label class="control-label condensed"> 1. Treatment for affected lot:</label>
			</div>
			<div class="col-sm-12">
				<textarea type="text" class="form-control condensed" name="treatment_affected_lot"></textarea>
			</div>
			<div class="col-sm-12">
				<label class="control-label condensed"> 2. Verification result for corrective and preventive action:</label>
			</div>
			<div class="col-sm-12">
				<textarea type="text" class="form-control condensed" name="verification_result"></textarea>
			</div>
		</div>	
		<div class="row">
			<div class="col-sm-4">
				<label class="control-label condensed">Prepared by:</label>
			</div>
			<div class="col-sm-4">
				<label class="control-label condensed"> Checked by:</label>
			</div>
			<div class="col-sm-4">
				<label class="control-label condensed"> Approved by:</label>
			</div>
		</div>	
		<div class="row">
			<div class="col-sm-4">
				<input type="text" class="form-control condensed" name="created_by">
			</div>
			<div class="col-sm-4">
				<input type="text" class="form-control condensed" name="pmi_orginator_fill_in_checked_by">
			</div>
			<div class="col-sm-4">
				<input type="text" class="form-control condensed" name="pmi_orginator_fill_in_approved_by">
			</div>
		</div>	
   </div>
   <div class="modal-footer">
    <button type="button" class="btn btn-default fa fa-close" data-dismiss="modal"> Close</button>
   </div>
   </form>
  </div><!-- /.modal-content -->
 </div><!-- /.modal-dialog -->
</div><!-- /.modal -->


<div class="modal" tabindex="-1" role="dialog" id="mdl_edit_with_answer_qcfr">
 <div class="modal-dialog modal-lg" role="document" style="width:80%;">
  <div class="modal-content">
   <div class="modal-header">
    <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
    <h4 class="modal-title fa fa-edit">Edit Quality Complaint Feedback Report (QCFR)</h4>
   </div>
   <form id="frm_edit_with_answer_qcfr">
   <div class="modal-body">
		<div class="row">
			<div class="col-sm-6">
				<div class="row">
					<div class="col-sm-6">
						<div class="funkyradio" style="padding-bottom:5px;">
							<div class="funkyradio-primary">
								<input type="radio" name="subcon_pmi[]" id="chk_supplier_subcon" value="Supplier/Subcon">
								<label for="chk_supplier_subcon"> <b>Supplier/Subcon</b></label>
							</div>
						</div>
						<div class="funkyradio" style="padding-top:5px;">
							<div class="funkyradio-primary">
								<input type="radio" name="subcon_pmi[]" id="chk_assy" value="PMI Assy">
								<label for="chk_assy"> <b>PMI Assy</b></label>
							</div>
						</div>
					</div>
					<div class="col-sm-6">						
						<input type="text" class="form-control condensed" name="supplier_subcon">
						<input type="text" class="form-control condensed" name="pmi_assy">
					</div>
				</div>
				<div class="row">
					<div class="col-sm-4">
						<label class="control-label condensed">TO:</label>
					</div>
					<div class="col-sm-8">
						<input type="text" class="form-control condensed" name="to">
					</div>
				</div>
				<div class="row">
					<div class="col-sm-4">
						<label class="control-label condensed">ATTN:</label>
					</div>
					<div class="col-sm-8">
						<input type="text" class="form-control condensed" name="attn">
					</div>
				</div>
				<div class="row">
					<div class="col-sm-4">
						<label class="control-label condensed">CC:</label>
					</div>
					<div class="col-sm-8">
						<input type="text" class="form-control condensed" name="cc">
					</div>
				</div>
				<div class="row">
					<div class="col-sm-4">
						<label class="control-label condensed">FROM:</label>
					</div>
					<div class="col-sm-8">
						<input type="text" class="form-control condensed" name="from">
					</div>
				</div>
				<div class="row">
					<div class="col-sm-4">
						<label class="control-label condensed">DATE ISSUED:</label>
					</div>
					<div class="col-sm-8">
						<input type="date" class="form-control condensed" name="date_issued">
					</div>
				</div>
			</div>
			<div class="col-sm-6">
				<div class="row">
					<div class="col-sm-3">
						<label class="control-label condensed"><b>QCFR No.:</b></label>
					</div>
					<div class="col-sm-9">
						<input type="text" class="form-control condensed" name="qcfr_no">
					</div>
				</div>
				<div class="row">
					<div class="col-sm-3" style="padding-right:0px;">
						<label class="control-label condensed"><b>Found During</b></label>
					</div>
					<div class="col-sm-9" style="">
						<div class="funkyradio">
							<div class="funkyradio-primary" >
								<input type="checkbox" name="found_during[]" id="chk_fd_outgoing_inspection" value="Outgoing Inspection">
								<label for="chk_fd_outgoing_inspection"> Outgoing Inspection</label>
							</div>
							<div class="funkyradio-primary">
								<input type="checkbox" name="found_during[]" id="chk_fd_incoming_inspection" value="Incoming Inspection">
								<label for="chk_fd_incoming_inspection"> Incoming Inspection</label>
							</div>
							<div class="funkyradio-primary">
								<input type="checkbox" name="found_during[]" id="chk_fd_in_process_inspection" value="In-Process Inspection">
								<label for="chk_fd_in_process_inspection"> In-Process Inspection</label>
							</div>
							<div class="funkyradio-primary">
								<input type="checkbox" name="found_during[]" id="chk_fd_quality_system_check" value="Quality System Check">
								<label for="chk_fd_quality_system_check"> Quality System Check</label>
							</div>
							<div class="funkyradio-primary">
								<input type="checkbox" name="found_during[]" id="chk_fd_others" value="Others. Please Specify">
								<label for="chk_fd_others"> Others. Please Specify</label>
							</div>
						</div>
						<input type="text" class="form-control condensed" name="found_during_others" placeholder="Others. Please Specify" disabled>
					</div>
				</div>
				<div class="row">
					<div class="col-sm-3" style="padding-right:0px;">
						<label class="control-label condensed"><b>Product Family</b></label>
					</div>
					<div class="col-sm-9" style="">
						<select class="form-control condensed" name="prod_family" style="width:100%;" required>
						</select>
					</div>
				</div>
			</div>
		</div>
		<hr class="graph-orange">
		<div class="row">
			<div class="col-sm-4">
				<label class="control-label condensed"> Reported by: </label>
			</div>
			<div class="col-sm-4">
				<label class="control-label condensed"> Verified & Conformed by: </label>
			</div>
			<div class="col-sm-4">
				<label class="control-label condensed"> Approved by: </label>
			</div>
		</div>
		<div class="row">
			<div class="col-sm-1">
				<label class="control-label condensed"> LQC </label>
			</div>
			<div class="col-sm-3">
				<input type="text" class="form-control condensed" name="reported_by">
			</div>
			<div class="col-sm-1">
				<label class="control-label condensed"> LQC </label>
			</div>
			<div class="col-sm-3">
				<input type="text" class="form-control condensed" name="verified_conformed_by_lqc">
			</div>
			<div class="col-sm-1">
				<label class="control-label condensed"> Section Head</label>
			</div>
			<div class="col-sm-3">
				<input type="text" class="form-control condensed" name="approved_by_sh">
			</div>
		</div>
		<div class="row">
			<div class="col-sm-1 col-sm-offset-4">
				<label class="control-label condensed"> Engineering </label>
			</div>
			<div class="col-sm-3">
				<input type="text" class="form-control condensed" name="verified_conformed_by_eng">
			</div>
			<div class="col-sm-1">
				<label class="control-label condensed"> Dept. Head </label>
			</div>
			<div class="col-sm-3">
				<input type="text" class="form-control condensed" name="approved_by_dh">
			</div>
		</div>
		<div class="row">
			<div class="col-sm-1 col-sm-offset-4">
				<label class="control-label condensed"> Production </label>
			</div>
			<div class="col-sm-3">
				<input type="text" class="form-control condensed" name="verified_conformed_by_prdn">
			</div>
		</div>
		<hr class="graph-blue">
		<div class="row">
			<div class="col-sm-5">
				<div class="row">
					<div class="col-sm-4">
						<label class="control-label condensed"> Product Name</label>
					</div>
					<div class="col-sm-8">
						<input type="text" class="form-control condensed" name="product_name">
					</div>
				</div>
				<div class="row">
					<div class="col-sm-4">
						<label class="control-label condensed"> Model No.</label>
					</div>
					<div class="col-sm-8">
						<input type="text" class="form-control condensed" name="model_no">
					</div>
				</div>
				<div class="row">
					<div class="col-sm-4">
						<label class="control-label condensed"> Batch No./Lot No.</label>
					</div>
					<div class="col-sm-8">
						<input type="text" class="form-control condensed" name="batch_no_lot_no">
					</div>
				</div>
				<div class="row">
					<div class="col-sm-4">
						<label class="control-label condensed"> P.O. No./ INV. No.</label>
					</div>
					<div class="col-sm-8">
						<input type="text" class="form-control condensed" name="po_no_invoice_no">
					</div>
				</div>
				<div class="row">
					<div class="col-sm-4">
						<label class="control-label condensed"> Date Received</label>
					</div>
					<div class="col-sm-8">
						<input type="date" class="form-control condensed" name="date_received">
					</div>
				</div>
			</div>
			<div class="col-sm-7">
				<div class="row">
					<div class="col-sm-3">
							<label class="control-label condensed"> Inspection Method</label>
					</div>
					<div class="col-sm-5">
						<div class="funkyradio">
							<div class="funkyradio-primary">
								<input type="checkbox" name="inspection_method[]" id="chk_sampling" value="Sampling">
								<label for="chk_sampling"> Sampling</label>
							</div>
						</div>
					</div>
					<div class="col-sm-4">
						<div class="funkyradio">
							<div class="funkyradio-primary">
								<input type="checkbox" name="inspection_method[]" id="chk_hundred_percent" value="100%">
								<label for="chk_hundred_percent"> 100%</label>
							</div>
						</div>
					</div>
				</div>
				<div class="row">
					<div class="col-sm-3">
						<label class="control-label condensed"> Sampling Plan</label>
					</div>
					<div class="col-sm-1">
						<label class="control-label condensed"> AQL=</label>
					</div>
					<div class="col-sm-2">
						<input type="text" class="form-control condensed" name="sampling_plan_aql">
					</div>
					<div class="col-sm-2">
						<label class="control-label condensed"> n=</label>						
						<input type="text" class="form-control condensed" name="sampling_plan_n" style="width:65%; display: inline-block">
					</div>
					<div class="col-sm-2">
						<label class="control-label condensed"> Ac=</label>
						<input type="text" class="form-control condensed" name="sampling_plan_ac" style="width:65%; display: inline-block">
					</div>
					<div class="col-sm-2">
						<label class="control-label condensed"> Re=</label>
						<input type="text" class="form-control condensed" name="sampling_plan_re" style="width:65%; display: inline-block">
					</div>
				</div>
				<div class="row">
					<div class="col-sm-3">
						<label class="control-label condensed"> Affected Qty.</label>
					</div>
					<div class="col-sm-3">
						<input type="number" class="form-control condensed" name="affected_qty">
					</div>
					<div class="col-sm-3">
						<label class="control-label condensed"> % Defective</label>
					</div>
					<div class="col-sm-3">
						<input type="number" class="form-control condensed" name="defective_percentage">
					</div>
				</div>
				<div class="row">
					<div class="col-sm-3">
						<label class="control-label condensed"> Defective Qty.</label>
					</div>
					<div class="col-sm-3">
						<input type="number" class="form-control condensed" name="defective_qty">
					</div>
					<div class="col-sm-3">
						<label class="control-label condensed"> No. of Occurrence</label>
					</div>
					<div class="col-sm-3">
						<input type="text" class="form-control condensed" name="no_of_occurence">
					</div>
				</div>
				<div class="row">
					<div class="col-sm-3">
						<label class="control-label condensed"> Date Encountered</label>
					</div>
					<div class="col-sm-3">
						<input type="date" class="form-control condensed" name="date_encountered">
					</div>
					<div class="col-sm-3">
						<label class="control-label condensed"> Ref. QCFR No.</label>
					</div>
					<div class="col-sm-3">
						<input type="text" class="form-control condensed" name="reference_qcfr_no">
					</div>
				</div>
			</div>
		</div>
		<hr class="graph-orange">	
		<div class="row">
			<div class="col-sm-12">
				<label class="control-label condensed"> <b> [ FAILURE / DEFECT DESCRIPTION ] NOTE: Use additional attachment if necessary </b></label>
			</div>
			<div class="col-sm-12">
				<textarea type="text" class="form-control condensed" name="failure_defect_description"></textarea>
			</div>
			<div class="col-sm-2">
				<label class="control-label condensed"> File Attachment</label>
			</div>
			<div class="col-sm-10">
				
			</div>
		</div>	
		<hr class="graph-blue">
		<div class="row">
			<div class="col-sm-4">
				<div class="row">
					<div class="col-sm-12">
						<label class="control-label condensed"> <b>Disposition</b> </label>
					</div>
					<div class="col-sm-6">
						<div class="funkyradio">
							<div class="funkyradio-primary" >
								<input type="checkbox" name="disposition[]" id="chk_dispo_rework_repair" value="Rework/Repair">
								<label for="chk_dispo_rework_repair"> Rework/Repair</label>
							</div>
							<div class="funkyradio-primary">
								<input type="checkbox" name="disposition[]" id="chk_dispo_useasis" value="Use as is">
								<label for="chk_dispo_useasis"> Use as is</label>
							</div>
							<div class="funkyradio-primary">
								<input type="checkbox" name="disposition[]" id="chk_dispo_replace" value="Replace">
								<label for="chk_dispo_replace"> Replace</label>
							</div>
						</div>
					</div>
					<div class="col-sm-6">
						<div class="funkyradio">
							<div class="funkyradio-primary" >
								<input type="checkbox" name="disposition[]" id="chk_dispo_return" value="Return">
								<label for="chk_dispo_return"> Return</label>
							</div>
							<div class="funkyradio-primary">
								<input type="checkbox" name="disposition[]" id="chk_dispo_sorting" value="100% sorting">
								<label for="chk_dispo_sorting"> 100% sorting</label>
							</div>
							<div class="funkyradio-primary">
								<input type="checkbox" name="disposition[]" id="chk_dispo_others" value="Others (specify)">
								<label for="chk_dispo_others"> Others (specify)</label>
							</div>
							<input type="text" class="form-control condensed" name="disposition_others" placeholder="Others. Please Specify" disabled>
						</div>
					</div>
				</div>
			</div>		
			<div class="col-sm-4">
				<div class="row">
					<div class="col-sm-12">
						<label class="control-label condensed"> <b>Nature of Request</b> </label>
					</div>
					<div class="col-sm-12">
						<div class="funkyradio">
							<div class="funkyradio-primary" >
								<input type="radio" name="nature_of_request[]" id="chk_nor_info_only" value="For Information only">
								<label for="chk_nor_info_only"> For Information only</label>
							</div>
							<div class="funkyradio-primary">
								<input type="radio" name="nature_of_request[]" id="chk_nor_submit_8d" value="Submit 8D report">
								<label for="chk_nor_submit_8d"> Submit 8D report</label>
							</div>
							<div class="funkyradio-primary">
								<input type="radio" name="nature_of_request[]" id="chk_nor_capa" value="Corrective & Preventive Action Report">
								<label for="chk_nor_capa"> Corrective & Preventive Action Report</label>
							</div>
						</div>
					</div>
				</div>
			</div>	
			<div class="col-sm-4">
				<div class="row">
					<div class="col-sm-12">
						<label class="control-label condensed"> <b>Answer</b> </label>
					</div>
					<div class="col-sm-12">
						<div class="funkyradio">
							<div class="funkyradio-primary" >
								<input type="radio" name="answer[]" id="chk_ans_need" value="Need">
								<label for="chk_ans_need"> Need</label>
							</div>
							<div class="funkyradio-primary">
								<input type="radio" name="answer[]" id="chk_ans_no_need" value="No Need">
								<label for="chk_ans_no_need"> No Need</label>
							</div>
						</div>
					</div>
					<div class="col-sm-5" id="div_date_answer_label">
						<label class="control-label condensed"> <b>Date Answer Required</b> </label>
					</div>
					<div class="col-sm-7" id="div_date_answer_input">
						<input type="date" class="form-control condensed" name="date_answer_required">
					</div>
				</div>
			</div>		
		</div>		
		
		<hr class="graph-orange">		
		<div class="row">
			<div class="col-sm-12">
				<div class="row">
					<div class="col-sm-12">
						<label class="control-label condensed"> <b>Recipient Fill-in</b> </label>
					</div>
					<div class="col-sm-2">
						<label class="control-label condensed">8D Report:</label>
					</div>
					<div class="col-sm-4">
						<button type="button" class="btn btn-default btn-link" id="btn_view_attachment_8d" name="pkid"> Download attachment</button>
					</div>
					<div class="col-sm-2">
						<label class="control-label condensed">CAPA Report:</label>
					</div>
					<div class="col-sm-4">
						<button type="button" class="btn btn-default btn-link" id="btn_view_attachment_capa" name="pkid"> Download attachment</button>
					</div>
				</div>
			</div>
		</div>
		<hr class="graph-blue">		
		<div class="row">
			<div class="col-sm-4">
				<div class="row">
					<div class="col-sm-12">
						<label class="control-label condensed"> <b>PMI/Originator Fill-in</b> </label>
					</div>
					<div class="col-sm-4">
						<label class="control-label condensed">Factory Line Audit?:</label>
					</div>
					<div class="col-sm-8">
						<div class="funkyradio" style="padding-bottom:5px;">
							<div class="funkyradio-primary">
								<input type="radio" name="factory_line_audit[]" id="chk_yes" value="Yes">
								<label for="chk_yes"> <b>Yes</b></label>
							</div>
							<div class="funkyradio-primary">
								<input type="radio" name="factory_line_audit[]" id="chk_no" value="No">
								<label for="chk_no"> <b>No</b></label>
							</div>
						</div>
					</div>
				</div>
			</div>
		</div>
		<div class="row">
			<div class="col-sm-12">
				<label class="control-label condensed"> [ Result of Confirmation ]</label>
			</div>
			<div class="col-sm-12">
				<label class="control-label condensed"> 1. Treatment for affected lot:</label>
			</div>
			<div class="col-sm-12">
				<textarea type="text" class="form-control condensed" name="treatment_affected_lot"></textarea>
			</div>
			<div class="col-sm-12">
				<label class="control-label condensed"> 2. Verification result for corrective and preventive action:</label>
			</div>
			<div class="col-sm-12">
				<textarea type="text" class="form-control condensed" name="verification_result"></textarea>
			</div>
		</div>	
		<div class="row">
			<div class="col-sm-4">
				<label class="control-label condensed">Prepared by:</label>
			</div>
			<div class="col-sm-4">
				<label class="control-label condensed"> Checked by:</label>
			</div>
			<div class="col-sm-4">
				<label class="control-label condensed"> Approved by:</label>
			</div>
		</div>	
		<div class="row">
			<div class="col-sm-4">
				<input type="text" class="form-control condensed" name="created_by">
			</div>
			<div class="col-sm-4">
				<input type="text" class="form-control condensed" name="pmi_orginator_fill_in_checked_by">
			</div>
			<div class="col-sm-4">
				<input type="text" class="form-control condensed" name="pmi_orginator_fill_in_approved_by">
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

<!-- Modal for viewing attachment -->
<div class="modal fade" tabindex="-1" role="dialog" id="modal_qcfr_attachment_viewer" style="z-index:1051">
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
						<th>File Name (click to download the file)</th>
					</thead>
					<tbody>
					</tbody>
				</table>
			</div>
		</div>
	  <div class="modal-footer">
		<button type="button" class="btn btn-default fa fa-close" data-dismiss="modal"> Close</button>
	  </div>
    </div><!-- /.modal-content -->
  </div><!-- /.modal-dialog -->
  </div>
</div><!-- /.modal -->
