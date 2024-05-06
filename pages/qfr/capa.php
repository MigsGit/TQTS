<?php
/* get user role for QS Inspector */
$capa_qs_inspector_access 	    = array("create" => false, 
									"read" => false,
									"update" => false,
									"delete" => false
									);
$subsystem_code 			= "QFR";
$module 					= "CAPA-QS Inspector";
foreach($user_role['subsystem_code'] as $key => $subsystem_code2 ){
	if($subsystem_code == $subsystem_code2 && $user_role['module'][$key] == $module){ 
		if ($user_role['create'][$key] == 1){
			$capa_qs_inspector_access['create'] = true;
		}
		if ($user_role['read'][$key] == 1){
			$capa_qs_inspector_access['read'] = true;
		}
		if ($user_role['update'][$key] == 1){
			$capa_qs_inspector_access['update'] = true;
		}
		if ($user_role['delete'][$key] == 1){
			$capa_qs_inspector_access['delete'] = true;
		}
	}
}
/* get user role for QS Supervisor */
$capa_ope_qs_sup_access 	    = array("create" => false, 
									"read" => false,
									"update" => false,
									"delete" => false
									);
$subsystem_code 			= "QFR";
$module 					= "CAPA-Operations QS Supervisor";
foreach($user_role['subsystem_code'] as $key => $subsystem_code2 ){
	if($subsystem_code == $subsystem_code2 && $user_role['module'][$key] == $module){ 
		if ($user_role['create'][$key] == 1){
			$capa_ope_qs_sup_access['create'] = true;
		}
		if ($user_role['read'][$key] == 1){
			$capa_ope_qs_sup_access['read'] = true;
		}
		if ($user_role['update'][$key] == 1){
			$capa_ope_qs_sup_access['update'] = true;
		}
		if ($user_role['delete'][$key] == 1){
			$capa_ope_qs_sup_access['delete'] = true;
		}
	}
}
/* get user role for QS Conformance */
$capa_ope_qs_conf_access 	    = array("create" => false, 
									"read" => false,
									"update" => false,
									"delete" => false
									);
$subsystem_code 			= "QFR";
$module 					= "CAPA-Operations QS Conformance";
foreach($user_role['subsystem_code'] as $key => $subsystem_code2 ){
	if($subsystem_code == $subsystem_code2 && $user_role['module'][$key] == $module){ 
		if ($user_role['create'][$key] == 1){
			$capa_ope_qs_conf_access['create'] = true;
		}
		if ($user_role['read'][$key] == 1){
			$capa_ope_qs_conf_access['read'] = true;
		}
		if ($user_role['update'][$key] == 1){
			$capa_ope_qs_conf_access['update'] = true;
		}
		if ($user_role['delete'][$key] == 1){
			$capa_ope_qs_conf_access['delete'] = true;
		}
	}
}
/* get user role for Operations QE and QAD QE */
$capa_ope_qe_qad_access 	    = array("create" => false, 
									"read" => false,
									"update" => false,
									"delete" => false
									);
$subsystem_code 			= "QFR";
$module 					= "CAPA-Operations QE and QAD QE";
foreach($user_role['subsystem_code'] as $key => $subsystem_code2 ){
	if($subsystem_code == $subsystem_code2 && $user_role['module'][$key] == $module){ 
		if ($user_role['create'][$key] == 1){
			$capa_ope_qe_qad_access['create'] = true;
		}
		if ($user_role['read'][$key] == 1){
			$capa_ope_qe_qad_access['read'] = true;
		}
		if ($user_role['update'][$key] == 1){
			$capa_ope_qe_qad_access['update'] = true;
		}
		if ($user_role['delete'][$key] == 1){
			$capa_ope_qe_qad_access['delete'] = true;
		}
	}
}
/* get user role for QC and QAD AM-up (Checked by) */
$capa_qc_qad_am_up 	    = array("create" => false, 
									"read" => false,
									"update" => false,
									"delete" => false
									);
$subsystem_code 			= "QFR";
$module 					= "CAPA-QC and QAD AM-up";
foreach($user_role['subsystem_code'] as $key => $subsystem_code2 ){
	if($subsystem_code == $subsystem_code2 && $user_role['module'][$key] == $module){ 
		if ($user_role['create'][$key] == 1){
			$capa_qc_qad_am_up['create'] = true;
		}
		if ($user_role['read'][$key] == 1){
			$capa_qc_qad_am_up['read'] = true;
		}
		if ($user_role['update'][$key] == 1){
			$capa_qc_qad_am_up['update'] = true;
		}
		if ($user_role['delete'][$key] == 1){
			$capa_qc_qad_am_up['delete'] = true;
		}
	}
}

/* get user role for QAD (final) */
$capa_qad_access 	    = array("create" => false, 
									"read" => false,
									"update" => false,
									"delete" => false
									);
$subsystem_code 			= "QFR";
$module 					= "CAPA-QAD";
foreach($user_role['subsystem_code'] as $key => $subsystem_code2 ){
	if($subsystem_code == $subsystem_code2 && $user_role['module'][$key] == $module){ 
		if ($user_role['create'][$key] == 1){
			$capa_qad_access['create'] = true;
		}
		if ($user_role['read'][$key] == 1){
			$capa_qad_access['read'] = true;
		}
		if ($user_role['update'][$key] == 1){
			$capa_qad_access['update'] = true;
		}
		if ($user_role['delete'][$key] == 1){
			$capa_qad_access['delete'] = true;
		}
	}
}

?>

<div class="col-sm-12">
	<!-- Nav tabs -->
	<div class="">
		<ul class="nav nav-tabs" role="tablist">
			<li role="presentation" class="active"><a href="#capa_dashboard" aria-controls="capa_dashboard" role="tab" data-toggle="tab">CAPA Dashboard</a></li>
			<?php 
				// $class_active = "active";
				if($capa_qs_inspector_access['read']){
					echo '<li role="presentation" class="'.$class_active.'"><a href="#capa_qs_inspector" aria-controls="capa_qs_inspector" role="tab" data-toggle="tab">QS Inspector</a></li>';
					$class_active = '';					
				}
				if($capa_ope_qs_sup_access['read']){
					echo '<li role="presentation" class="'.$class_active.'"><a href="#capa_ope_qs_sup_access" aria-controls="capa_ope_qs_sup_access" role="tab" data-toggle="tab">Operations QS Supervisor</a></li>';
					$class_active = '';
				}				
				if($capa_ope_qs_conf_access['read']){
					echo '<li role="presentation" class="'.$class_active.'"><a href="#capa_ope_qs_conf_access" aria-controls="capa_ope_qs_conf_access" role="tab" data-toggle="tab">Operations QS Conformance</a></li>';
					$class_active = '';
				}				
				if($capa_ope_qe_qad_access['read']){
					echo '<li role="presentation" class="'.$class_active.'"><a href="#capa_ope_qe_qad_access" aria-controls="capa_ope_qe_qad_access" role="tab" data-toggle="tab">Operations QE and QAD QE</a></li>';
					$class_active = '';
				}				
				if($capa_qc_qad_am_up['read']){
					echo '<li role="presentation" class="'.$class_active.'"><a href="#capa_qc_qad_am_up" aria-controls="capa_qc_qad_am_up" role="tab" data-toggle="tab">CAPA-QC and QAD AM-up</a></li>';
					$class_active = '';
				}				
				if($capa_qad_access['read']){
					echo '<li role="presentation" class="'.$class_active.'"><a href="#capa_qad_access" aria-controls="capa_qad_access" role="tab" data-toggle="tab">CAPA QAD</a></li>';
					$class_active = '';
				}				
				
			?>
			
		</ul>
	</div>
</div>

<!-- Tab panes -->
<div class="tab-content">
	<div role="tabpanel" class="tab-pane active" id="capa_dashboard">	
		<div class="col-sm-12">
			<div class="panel panel-info">
				<div class="panel-heading"><i class="fa fa-puzzle-piece fa-lg"> CAPA Dashboard</i></div>
				<div class="panel-body">
					<div class="row">
						<div class="col-sm-12"><br />
							<table class="table table-striped table-bordered table-condensed" id="tbl_capa_external">
								<thead>
									<tr>
										<th rowspan="3"><center>Received Date</center></th>
										<th rowspan="3"><center>Type</center></th>
										<th rowspan="3"><center>Product / Mode</center></th>
										<th rowspan="3"><center>Failure Mode</center></th>
										<th rowspan="3"><center>Correction</center></th>
										<th colspan="3"><center>CAPA Status</center></th>
									</tr>
									<tr>
										<th><center>LEVEL 1 -QS <br>(QC monitoring)</center></th>
										<th><center>LEVEL 2 -Qlty Engr. <br>(QC/QA Validation)</center></th>
										<th><center>LEVEL 3 (QAD) <br>(QAD Validation)</center></th>
									</tr>
									<tr>
										<th><center>1st ~ 12th day</center></th>
										<th><center>13th ~ 24th day</center></th>
										<th><center>3 months</center></th>
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
		// $class_active = "active";
		if($capa_qs_inspector_access['read']){
			echo '<div role="tabpanel" class="tab-pane '.$class_active.'" id="capa_qs_inspector">	
					<div class="col-sm-12">
						<div class="panel panel-info">
							<div class="panel-heading"><i class="fa fa-puzzle-piece fa-lg"> Operations QS Inspector</i></div>
							<div class="panel-body">
								<div class="row">
									<div class="col-sm-6">
										<!-- <button class="btn btn-default fa" id="btn_oqc_lon_search_main"><i class="fa fa-search"></i> Search</button> -->
									</div>
									<div class="col-sm-6">
										<div class="btn-group pull-right">
										  <button type="button" class="btn btn-primary fa dropdown-toggle" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
											<span class="fa fa-plus"> </span> New CAPA Report <span class="caret"></span>
										  </button>
										  <ul class="dropdown-menu">
											<li><a href="#" id="external"> External</a></li>
											<li role="separator" class="divider"></li>
											<li><a href="#" id="internal"> Internal</a></li>
										  </ul>
										</div>
									</div>
								</div>
								<div class="row">
									<div class="col-sm-12"><br />
										<table class="table table-striped table-bordered table-condensed" id="tbl_capa_qs_inspector">
											<thead>
												<th>Control No.</th>
												<th>Classification</th>
												<th>Section</th>
												<th>Product Mode</th>
												<th>Received Date</th>
												<th>Failure Mode</th>
												<th>Customer</th>
												<th>Assigned Line JS/SS</th>
												<th>CAPA Received</th>
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
		if($capa_ope_qs_sup_access['read']){
			echo '<div role="tabpanel" class="tab-pane '.$class_active.'" id="capa_ope_qs_sup_access">	
					<div class="col-sm-12">
						<div class="panel panel-info">
							<div class="panel-heading"><i class="fa fa-puzzle-piece fa-lg"> Operations QS Supervisor</i></div>
							<div class="panel-body">
								<div class="row">
									<div class="col-sm-6">
										<!-- <button class="btn btn-default fa" id="btn_oqc_lon_search_main"><i class="fa fa-search"></i> Search</button> -->
									</div>
								</div>
								<div class="row">
									<div class="col-sm-12"><br />
										<table class="table table-striped table-bordered table-condensed" id="tbl_capa_ope_qs_sup_access">
											<thead>
												<th>Status</th>
												<th>Control No.</th>
												<th>Classification</th>
												<th>Section</th>
												<th>Product Mode</th>
												<th>Received Date</th>
												<th>Failure Mode</th>
												<th>Customer</th>
												<th>Assigned Line JS/SS</th>
												<th>CAPA Received</th>
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
		if($capa_ope_qs_conf_access['read']){
			echo '<div role="tabpanel" class="tab-pane '.$class_active.'" id="capa_ope_qs_conf_access">	
					<div class="col-sm-12">
						<div class="panel panel-info">
							<div class="panel-heading"><i class="fa fa-puzzle-piece fa-lg"> Operations QS Conformance</i></div>
							<div class="panel-body">
								<div class="row">
									<div class="col-sm-6">
										<!-- <button class="btn btn-default fa" id="btn_oqc_lon_search_main"><i class="fa fa-search"></i> Search</button> -->
									</div>
								</div>
								<div class="row">
									<div class="col-sm-12"><br />
										<table class="table table-striped table-bordered table-condensed" id="tbl_capa_ope_qs_conf_access">
											<thead>
												<th>Control No.</th>
												<th>Classification</th>
												<th>Section</th>
												<th>Product Mode</th>
												<th>Received Date</th>
												<th>Failure Mode</th>
												<th>Customer</th>
												<th>Assigned Line JS/SS</th>
												<th>CAPA Received</th>
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
		if($capa_ope_qe_qad_access['read']){
			echo '<div role="tabpanel" class="tab-pane '.$class_active.'" id="capa_ope_qe_qad_access">	
					<div class="col-sm-12">
						<div class="panel panel-info">
							<div class="panel-heading"><i class="fa fa-puzzle-piece fa-lg"> Operations QS Conformance</i></div>
							<div class="panel-body">
								<div class="row">
									<div class="col-sm-6">
										<!-- <button class="btn btn-default fa" id="btn_oqc_lon_search_main"><i class="fa fa-search"></i> Search</button> -->
									</div>
								</div>
								<div class="row">
									<div class="col-sm-12"><br />
										<table class="table table-striped table-bordered table-condensed" id="tbl_capa_ope_qe_qad_access">
											<thead>
												<th>Control No.</th>
												<th>Classification</th>
												<th>Section</th>
												<th>Product Mode</th>
												<th>Received Date</th>
												<th>Failure Mode</th>
												<th>Customer</th>
												<th>Assigned Line JS/SS</th>
												<th>CAPA Received</th>
												<th>Action</th>
											</thead>
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
		if($capa_qc_qad_am_up['read']){
			echo '<div role="tabpanel" class="tab-pane '.$class_active.'" id="capa_qc_qad_am_up">	
					<div class="col-sm-12">
						<div class="panel panel-info">
							<div class="panel-heading"><i class="fa fa-puzzle-piece fa-lg"> CAPA-QC and QAD AM-up</i></div>
							<div class="panel-body">
								<div class="row">
									<div class="col-sm-6">
										<!-- <button class="btn btn-default fa" id="btn_oqc_lon_search_main"><i class="fa fa-search"></i> Search</button> -->
									</div>
								</div>
								<div class="row">
									<div class="col-sm-12"><br />
										<table class="table table-striped table-bordered table-condensed" id="tbl_capa_qc_qad_am_up">
											<thead>
												<th>Status</th>
												<th>Control No.</th>
												<th>Classification</th>
												<th>Section</th>
												<th>Product Mode</th>
												<th>Received Date</th>
												<th>Failure Mode</th>
												<th>Customer</th>
												<th>Assigned Line JS/SS</th>
												<th>CAPA Received</th>
												<th>Action</th>
											</thead>
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
		if($capa_qad_access['read']){
			echo '<div role="tabpanel" class="tab-pane '.$class_active.'" id="capa_qad_access">	
					<div class="col-sm-12">
						<div class="panel panel-info">
							<div class="panel-heading"><i class="fa fa-puzzle-piece fa-lg"> CAPA QAD</i></div>
							<div class="panel-body">
								<div class="row">
									<div class="col-sm-6">
										<!-- <button class="btn btn-default fa" id="btn_oqc_lon_search_main"><i class="fa fa-search"></i> Search</button> -->
									</div>
								</div>
								<div class="row">
									<div class="col-sm-12"><br />
										<table class="table table-striped table-bordered table-condensed" id="tbl_capa_qad_access">
											<thead>
												<th>Status</th>
												<th>Control No.</th>
												<th>Classification</th>
												<th>Section</th>
												<th>Product Mode</th>
												<th>Received Date</th>
												<th>Failure Mode</th>
												<th>Customer</th>
												<th>Assigned Line JS/SS</th>
												<th>CAPA Received</th>
												<th>Action</th>
											</thead>
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

<!---------------------
	Modals - Start 
---------------------->
<div class="modal fade" tabindex="-1" role="dialog" id="modal_capa_qs_inspector_internal_new">
  <div class="modal-dialog modal-lg" role="document" style="width:70%;">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
        <h4 class="modal-title"><i class="fa fa-upload"></i> New Corrective and Preventive Action Monitoring</h4>
      </div>
	  <div class="modal-body" style="overflow:inherit;">
		 <form id="frm_capa_qs_inspector_internal_new">
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
					<input type="text" class="form-control" id="control_no" name="control_no">
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
					<select class="chosen-select" id="checked_by" name="checked_by[]" multiple style="width:100%">
					</select>
				</div>
				<div class="col-sm-2">
					<label class="fa fa-md">Conformed by: </label>
				</div>
				<div class="col-sm-4">
					<select class="chosen-select" id="conformed_by" name="conformed_by[]" multiple style="width:100%">
					</select>
				</div>
			</div>
			<div class="row" style="margin-top:5px;">
				<div class="col-sm-2">
					<label class="fa fa-md">Attachment: </label>
				</div>
				<div class="col-sm-4">
					<input type="file" class="form-control" id="file_capa_attachment" name="file_capa_attachment">
				</div>
				<div class="col-sm-2">
					<label class="fa fa-md">Operations QE / QAD QE: </label>
				</div>
				<div class="col-sm-4">
					<select class="chosen-select" id="operations_qe" name="operations_qe[]" multiple="multiple" style="width:100%">
					</select>
				</div>
			</div>
			<div class="row" style="padding-top:5px;">
				<div class="col-sm-12">
					<div class="alert alert-danger" style="display:none;" role="alert" id="container_capa_production_new_message">					
					</div>
				</div>				
				<div class="col-sm-3 col-sm-offset-9">
                    <button type="button" class="btn btn-primary pull-right fa fa-plus" id="btn_add_correction"> Add</button>
                </div>
				<div class="col-sm-12" style="padding-top:5px;">
					<div class="profile-info-title h5" style="padding-bottom:5px;">
						<span class=""></span> <b>CORRECTION</b>
					</div>
					<table class="table table-bordered table-hover table-condensed table-striped" id="tbl_correction_list">
                        <thead>
                            <tr>
                                <th style="width:32%"><center>Correction</center></th>
                                <th style="width:18%"><center>In-charge Person</center></th>
                                <th style="width:18%"><center>Due Date</center></th>
                                <th style="width:7%"><center>Remove</center></th>
                            </tr>
                        </thead>
                        <tbody>
                        </tbody>
                    </table>
				</div>
				<div class="col-sm-12" style="padding-top:5px;">
					<div class="profile-info-title h5" style="padding-bottom:5px;">
						<span class=""></span> <b>CORRECTIVE ACTION</b>
					</div>
					<table class="table table-bordered table-hover table-condensed table-striped" id="tbl_corrective_action_list">
                        <thead>
                            <tr>
                                <th style="width:32%"><center>Corrective Action</center></th>
                                <th style="width:18%"><center>In-charge Person</center></th>
                                <th style="width:18%"><center>Due Date</center></th>
                                <th style="width:7%"><center>Remove</center></th>
                            </tr>
                        </thead>
                        <tbody>
                        </tbody>
                    </table>
				</div>
			</div>
			<hr class="graph-orange" style="margin-top:0px;">
			<div class="row" style="margin-top:5px;">
				<div class="col-sm-2">
					<label class="fa fa-md">Remarks: </label>
				</div>
			</div>
			<div class="row" style="margin-top:5px;">					
				<div class="col-sm-12">
					<textarea id="remarks" name="remarks" style="width:100%" rows="3">
					</textarea>
				</div>	
            </div>
		  </div>
		  <div class="modal-footer">
			<button type="submit" class="btn btn-primary fa fa-send-o"> Submit</button>
			<button type="button" class="btn btn-default fa fa-close" data-dismiss="modal"> Close</button>
		  </div>
		</form><!-- /#frm_upload_measdata -->
    </div><!-- /.modal-content -->
  </div><!-- /.modal-dialog -->
</div><!-- /.modal -->

<div class="modal fade" tabindex="-1" role="dialog" id="modal_capa_qs_inspector_external_new">
  <div class="modal-dialog modal-lg" role="document" style="width:70%;">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
        <h4 class="modal-title"><i class="fa fa-upload"></i> New Corrective and Preventive Action Monitoring</h4>
      </div>
	  <div class="modal-body" style="overflow:inherit;">
		 <form id="frm_capa_qs_inspector_external_new">
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
					<input type="text" class="form-control" id="control_no" name="control_no">
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
					<select class="chosen-select" id="checked_by" name="checked_by[]" multiple style="width:100%">
					</select>
				</div>
				<div class="col-sm-2">
					<label class="fa fa-md">Conformed by: </label>
				</div>
				<div class="col-sm-4">
					<select class="chosen-select" id="conformed_by" name="conformed_by[]" multiple style="width:100%">
					</select>
				</div>
			</div>
			<div class="row" style="margin-top:5px;">
				<div class="col-sm-2">
					<label class="fa fa-md">Attachment: </label>
				</div>
				<div class="col-sm-4">
					<input type="file" class="form-control" id="file_capa_attachment" name="file_capa_attachment">
				</div>
				<div class="col-sm-2">
					<label class="fa fa-md">Operations QE / QAD QE: </label>
				</div>
				<div class="col-sm-4">
					<select class="chosen-select" id="operations_qe" name="operations_qe[]" multiple="multiple" style="width:100%">
					</select>
				</div>
			</div>
			<div class="row" style="padding-top:5px;">
				<div class="col-sm-12">
					<div class="alert alert-danger" style="display:none;" role="alert" id="container_capa_production_new_message">					
					</div>
				</div>				
				<div class="col-sm-3 col-sm-offset-9">
                    <button type="button" class="btn btn-primary pull-right fa fa-plus" id="btn_add_correction"> Add</button>
                </div>
				<div class="col-sm-12" style="padding-top:5px;">
					<div class="profile-info-title h5" style="padding-bottom:5px;">
						<span class=""></span> <b>CORRECTION</b>
					</div>
					<table class="table table-bordered table-hover table-condensed table-striped" id="tbl_correction_list">
                        <thead>
                            <tr>
                                <th style="width:32%"><center>Correction</center></th>
                                <th style="width:18%"><center>In-charge Person</center></th>
                                <th style="width:18%"><center>Due Date</center></th>
                                <th style="width:7%"><center>Remove</center></th>
                            </tr>
                        </thead>
                        <tbody>
                        </tbody>
                    </table>
				</div>
				<div class="col-sm-12" style="padding-top:5px;">
					<div class="profile-info-title h5" style="padding-bottom:5px;">
						<span class=""></span> <b>CORRECTIVE ACTION</b>
					</div>
					<table class="table table-bordered table-hover table-condensed table-striped" id="tbl_corrective_action_list">
                        <thead>
                            <tr>
                                <th style="width:32%"><center>Corrective Action</center></th>
                                <th style="width:18%"><center>In-charge Person</center></th>
                                <th style="width:18%"><center>Due Date</center></th>
                                <th style="width:7%"><center>Remove</center></th>
                            </tr>
                        </thead>
                        <tbody>
                        </tbody>
                    </table>
				</div>
			</div>
			<hr class="graph-orange" style="margin-top:0px;">
			<div class="row" style="margin-top:5px;">
				<div class="col-sm-2">
					<label class="fa fa-md">Remarks: </label>
				</div>
			</div>
			<div class="row" style="margin-top:5px;">					
				<div class="col-sm-12">
					<textarea id="remarks" name="remarks" style="width:100%" rows="3">
					</textarea>
				</div>	
            </div>
		  </div>
		  <div class="modal-footer">
			<button type="submit" class="btn btn-primary fa fa-send-o"> Submit</button>
			<button type="button" class="btn btn-default fa fa-close" data-dismiss="modal"> Close</button>
		  </div>
		</form><!-- /#frm_upload_measdata -->
    </div><!-- /.modal-content -->
  </div><!-- /.modal-dialog -->
</div><!-- /.modal -->

<div class="modal fade" tabindex="-1" role="dialog" id="modal_capa_compliance_due_date">
  <div class="modal-dialog modal-lg" role="document" style="width:70%;">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
        <h4 class="modal-title"><i class="fa fa-upload"></i> Add Monitoring - Compliance to CAPA due date</h4>
      </div>
	  <div class="modal-body" style="overflow:inherit;">
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
					<input type="text" class="form-control" id="control_no" name="control_no">
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
					<select class="chosen-select" id="checked_by" name="checked_by[]" multiple style="width:100%">
					</select>
				</div>
				<div class="col-sm-2">
					<label class="fa fa-md">Conformed by: </label>
				</div>
				<div class="col-sm-4">
					<select class="chosen-select" id="conformed_by" name="conformed_by[]" multiple style="width:100%">
					</select>
				</div>
				<div class="col-sm-2">
					<label class="fa fa-md">Attachment: </label>
				</div>
				<div class="col-sm-4">
					<input type="file" class="form-control" id="file_capa_attachment" name="file_capa_attachment">
				</div>
			</div>
			<div class="row" style="padding-top:5px;">
				<div class="col-sm-12">
					<div class="alert alert-danger" style="display:none;" role="alert" id="container_capa_compliance_due_date_message">					
					</div>
				</div>		
				<div class="col-sm-12" style="padding-top:5px;">
					<table class="table table-bordered table-hover table-condensed table-striped" id="tbl_monitoring">
                        <thead>
                            <tr>
                                <th style="width:32%"><center>Correction</center></th>
                                <th style="width:18%"><center>In-charge Person</center></th>
                                <th style="width:18%"><center>Due Date</center></th>
                                <th style="width:7%"><center>Remove</center></th>
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
					<select class="chosen-select" id="operations_qe" name="operations_qe[]" multiple="multiple" style="width:100%">
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
		</form><!-- /#frm_upload_measdata -->
    </div><!-- /.modal-content -->
  </div><!-- /.modal-dialog -->
</div><!-- /.modal -->

<!-- Modal for Add Correction message -->
<div class="modal" tabindex="-1" role="dialog" id="modal_capa_add_correction">
  <div class="modal-dialog modal-lg" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
        <h4 class="modal-title fa fa-plus"> Add Correction / Corrective Action</h4>
      </div>
	  <form id="frm_capa_add_correction">
      <div class="modal-body">
		<div class="row" style="margin-top:5px;">
			<div class="col-sm-2">
				<label class="fa fa-md">Type: </label>
			</div>
			<div class="col-sm-4">
				<select class="form-control" id="monitoring_type" name="monitoring_type" required>
					<option> - </option>
					<option value="correction"> Correction</option>
					<option value="corrective_action"> Corrective Action</option>
				</select>
			</div>
			<div class="col-sm-2">
				<input type="hidden" id="mdl_id_append">
			</div>
		</div>
		<div class="row" style="margin-top:5px;">
			<div class="col-sm-2">
				<label class="fa fa-md">Action: </label>
			</div>
			<div class="col-sm-10">
				<textarea rows="4" style="width:100%" id="correction_action" name="correction_action" required></textarea>
			</div>
		</div>
		<div class="row" style="margin-top:5px;">
			<div class="col-sm-2">
				<label class="fa fa-md">In-charge Person: </label>
			</div>
			<div class="col-sm-4">
				<select class="chosen-select" id="incharge_person" name="incharge_person[]" multiple="multiple" style="width:100%" required>
				</select>
			</div>
			<div class="col-sm-2">
				<label class="fa fa-md">Due Date: </label>
			</div>
			<div class="col-sm-4">
				<input type="date" class="form-control" id="due_date" name="due_date" required>
			</div>
		</div>
      </div>
      <div class="modal-footer">
		<button type="submit" class="btn btn-primary fa fa-plus"> Add</button>
        <button type="button" class="btn btn-default fa fa-close" data-dismiss="modal"> Close</button>
      </div>
	  </form>
    </div><!-- /.modal-content -->
  </div><!-- /.modal-dialog -->
</div><!-- /.modal -->

<!-- Modal for Adding of QS Inspector Monitoring -->
<div class="modal" tabindex="-1" role="dialog" id="modal_capa_qs_inspector_external_1st_monitoring">
  <div class="modal-dialog modal-lg" role="document" style="width:98%">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
        <h4 class="modal-title fa fa-search"> Compliance to CAPA due date (Duration: 12 days or 2 weeks)</h4>
      </div>
	  <form id="frm_capa_qs_inspector_external_add_monitoring">
		  <div class="modal-body">
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
					<input type="text" class="form-control" id="control_no" name="control_no">
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
					<select class="chosen-select" id="checked_by" name="checked_by[]" multiple style="width:100%">
					</select>
				</div>
				<div class="col-sm-2">
					<label class="fa fa-md">Conformed by: </label>
				</div>
				<div class="col-sm-4">
					<select class="chosen-select" id="conformed_by" name="conformed_by[]" multiple style="width:100%">
					</select>
				</div>
			</div>
			<div class="row" style="margin-top:5px;">
				<div class="col-sm-2">
					<label class="fa fa-md">Attachment: </label>
				</div>
				<div class="col-sm-4">
					<button type="button" class="btn btn-default fa fa-paperclip" id="file_capa_attachment" name="file_capa_attachment"> Download File</button>
				</div>
				<div class="col-sm-2">
					<label class="fa fa-md">Operations QE / QAD QE: </label>
				</div>
				<div class="col-sm-4">
					<select class="chosen-select" id="operations_qe" name="operations_qe[]" multiple="multiple" style="width:100%">
					</select>
				</div>
			</div>
			<div class="row" style="padding-top:5px;">
				<div class="col-sm-12">
					<div class="alert alert-danger" style="display:none;" role="alert" id="container_capa_compliance_due_date_message">					
					</div>
				</div>		
				<div class="col-sm-12" style="padding-top:5px;">
					<button type="button" class="btn btn-primary pull-right fa fa-plus" id="btn_add_monitoring"> Add</button>					
					<table class="table table-bordered table-hover table-condensed table-striped" id="tbl_monitoring">
						<thead>
							<tr>
								<th rowspan="3"><center>Status</center></th>
								<th rowspan="3"><center>Correction</center></th>
								<th rowspan="3"><center>In-charge Person</center></th>
								<th rowspan="3"><center>Due Date</center></th>
								<th colspan="2" style="width:20%"><center>1st Monitoring</center></th>
								<th colspan="2" style="width:20%"><center>2nd Monitoring</center></th>
								<th colspan="2" style="width:20%"><center>3rd Monitoring</center></th>
								<th colspan="2" style="width:20%"><center>4th Monitoring</center></th>
								<th colspan="2" style="width:20%"><center>5th Monitoring</center></th>
								<th colspan="2" style="width:20%"><center>6th Monitoring</center></th>
								<th colspan="2" style="width:20%"><center>7th Monitoring</center></th>
								<th colspan="2" style="width:20%"><center>8th Monitoring</center></th>
								<th colspan="2" style="width:20%"><center>9th Monitoring</center></th>
								<th colspan="2" style="width:20%"><center>10th Monitoring</center></th>
								<th colspan="2" style="width:20%"><center>11th Monitoring</center></th>
								<th colspan="2" style="width:20%"><center>12th Monitoring</center></th>
							</tr>
						</thead>
						<tbody>
						</tbody>
					</table>
				</div>
			</div>
			<hr class="graph-orange" style="margin-top:0px;">
			<div class="row" style="margin-top:5px;">
				<div class="col-sm-2">
					<label class="fa fa-md">Remarks: </label>
				</div>
			</div>
			<div class="row" style="margin-top:5px;">					
				<div class="col-sm-12">
					<textarea id="remarks" name="remarks" style="width:100%" rows="3">
					</textarea>
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

<!-- Modal for Editing of QS Inspector Monitoring -->
<div class="modal" tabindex="-1" role="dialog" id="modal_capa_qs_inspector_external_1st_monitoring_edit">
  <div class="modal-dialog modal-lg" role="document" style="width:98%">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
        <h4 class="modal-title fa fa-search"> Compliance to CAPA due date (Duration: 12 days or 2 weeks)</h4>
      </div>
	  <form id="frm_capa_qs_inspector_external_edit_monitoring">
		  <div class="modal-body">
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
					<input type="text" class="form-control" id="control_no" name="control_no">
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
					<select class="chosen-select" id="checked_by" name="checked_by[]" multiple style="width:100%">
					</select>
				</div>
				<div class="col-sm-2">
					<label class="fa fa-md">Conformed by: </label>
				</div>
				<div class="col-sm-4">
					<select class="chosen-select" id="conformed_by" name="conformed_by[]" multiple style="width:100%">
					</select>
				</div>
			</div>
			<div class="row" style="margin-top:5px;">
				<div class="col-sm-2">
					<label class="fa fa-md">Attachment: </label>
				</div>
				<div class="col-sm-4">
					<button type="button" class="btn btn-default fa fa-paperclip" id="file_capa_attachment" name="file_capa_attachment"> Download File</button>
				</div>
				<div class="col-sm-2">
					<label class="fa fa-md">Operations QE / QAD QE: </label>
				</div>
				<div class="col-sm-4">
					<select class="chosen-select" id="operations_qe" name="operations_qe[]" multiple="multiple" style="width:100%">
					</select>
				</div>
			</div>
			<div class="row" style="padding-top:5px;">
				<div class="col-sm-12">
					<div class="alert alert-danger" style="display:none;" role="alert" id="container_capa_compliance_due_date_message">					
					</div>
				</div>		
				<div class="col-sm-12" style="padding-top:5px;">					
					<table class="table table-bordered table-hover table-condensed table-striped" id="tbl_monitoring">
						<thead>
							<tr>
								<th rowspan="3"><center>Status</center></th>
								<th rowspan="3"><center>Correction</center></th>
								<th rowspan="3"><center>In-charge Person</center></th>
								<th rowspan="3"><center>Due Date</center></th>
								<th colspan="2" style="width:20%"><center>1st Monitoring</center></th>
								<th colspan="2" style="width:20%"><center>2nd Monitoring</center></th>
								<th colspan="2" style="width:20%"><center>3rd Monitoring</center></th>
								<th colspan="2" style="width:20%"><center>4th Monitoring</center></th>
								<th colspan="2" style="width:20%"><center>5th Monitoring</center></th>
								<th colspan="2" style="width:20%"><center>6th Monitoring</center></th>
								<th colspan="2" style="width:20%"><center>7th Monitoring</center></th>
								<th colspan="2" style="width:20%"><center>8th Monitoring</center></th>
								<th colspan="2" style="width:20%"><center>9th Monitoring</center></th>
								<th colspan="2" style="width:20%"><center>10th Monitoring</center></th>
								<th colspan="2" style="width:20%"><center>11th Monitoring</center></th>
								<th colspan="2" style="width:20%"><center>12th Monitoring</center></th>
								<th colspan="2"><center>Action</center></th>
							</tr>
						</thead>
						<tbody>
						</tbody>
					</table>
				</div>
			</div>
			<hr class="graph-orange" style="margin-top:0px;">
			<div class="row" style="margin-top:5px;">
				<div class="col-sm-2">
					<label class="fa fa-md">Remarks: </label>
				</div>
			</div>
			<div class="row" style="margin-top:5px;">					
				<div class="col-sm-12">
					<textarea id="remarks" name="remarks" style="width:100%" rows="3">
					</textarea>
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

<!-- Modal for Viewing of QS Inspector Monitoring -->
<div class="modal" tabindex="-1" role="dialog" id="modal_capa_qs_inspector_external_1st_monitoring_view">
  <div class="modal-dialog modal-lg" role="document" style="width:98%">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
        <h4 class="modal-title fa fa-search"> Compliance to CAPA due date (Duration: 12 days or 2 weeks)</h4>
      </div>
	  <form id="frm_capa_qs_inspector_external_view_monitoring">
		  <div class="modal-body">
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
					<input type="text" class="form-control" id="control_no" name="control_no">
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
					<select class="chosen-select" id="checked_by" name="checked_by[]" multiple style="width:100%">
					</select>
				</div>
				<div class="col-sm-2">
					<label class="fa fa-md">Conformed by: </label>
				</div>
				<div class="col-sm-4">
					<select class="chosen-select" id="conformed_by" name="conformed_by[]" multiple style="width:100%">
					</select>
				</div>
			</div>
			<div class="row" style="margin-top:5px;">
				<div class="col-sm-2">
					<label class="fa fa-md">Attachment: </label>
				</div>
				<div class="col-sm-4">
					<button type="button" class="btn btn-default fa fa-paperclip" id="file_capa_attachment" name="file_capa_attachment"> Download File</button>
				</div>
				<div class="col-sm-2">
					<label class="fa fa-md">Operations QE / QAD QE: </label>
				</div>
				<div class="col-sm-4">
					<select class="chosen-select" id="operations_qe" name="operations_qe[]" multiple="multiple" style="width:100%">
					</select>
				</div>
			</div>
			<div class="row" style="padding-top:5px;">
				<div class="col-sm-12">
					<div class="alert alert-danger" style="display:none;" role="alert" id="container_capa_compliance_due_date_message">					
					</div>
				</div>		
				<div class="col-sm-12" style="padding-top:5px;">					
					<table class="table table-bordered table-hover table-condensed table-striped" id="tbl_monitoring">
						<thead>
							<tr>
								<th rowspan="3"><center>Status</center></th>
								<th rowspan="3"><center>Correction</center></th>
								<th rowspan="3"><center>In-charge Person</center></th>
								<th rowspan="3"><center>Due Date</center></th>
								<th colspan="2" style="width:20%"><center>1st Monitoring</center></th>
								<th colspan="2" style="width:20%"><center>2nd Monitoring</center></th>
								<th colspan="2" style="width:20%"><center>3rd Monitoring</center></th>
								<th colspan="2" style="width:20%"><center>4th Monitoring</center></th>
								<th colspan="2" style="width:20%"><center>5th Monitoring</center></th>
								<th colspan="2" style="width:20%"><center>6th Monitoring</center></th>
								<th colspan="2" style="width:20%"><center>7th Monitoring</center></th>
								<th colspan="2" style="width:20%"><center>8th Monitoring</center></th>
								<th colspan="2" style="width:20%"><center>9th Monitoring</center></th>
								<th colspan="2" style="width:20%"><center>10th Monitoring</center></th>
								<th colspan="2" style="width:20%"><center>11th Monitoring</center></th>
								<th colspan="2" style="width:20%"><center>12th Monitoring</center></th>							
							</tr>
						</thead>
						<tbody>
						</tbody>
					</table>
				</div>
			</div>
			<hr class="graph-orange" style="margin-top:0px;">
			<div class="row" style="margin-top:5px;">
				<div class="col-sm-2">
					<label class="fa fa-md">Remarks: </label>
				</div>
			</div>
			<div class="row" style="margin-top:5px;">					
				<div class="col-sm-12">
					<textarea id="remarks" name="remarks" style="width:100%" rows="3">
					</textarea>
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

<!-- Modal for Add Monitoring -->
<div class="modal" tabindex="-1" role="dialog" id="modal_capa_add_monitoring" style="z-index:1051">
  <div class="modal-dialog modal-lg" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
        <h4 class="modal-title fa fa-plus"> Add Monitoring</h4>
      </div>
	  <form id="frm_capa_add_monitoring">
      <div class="modal-body">
		<div class="row" style="margin-top:5px;">
			<div class="col-sm-2">
				<label class="fa fa-md">Correction: </label>
			</div>
			<div class="col-sm-10">
				<select class="form-control" style="width:100%" id="correction_list" name="fk_capa_correction" required>
				</select>
			</div>
			<div class="col-sm-2">
				<input type="hidden" id="mdl_id_append">
			</div>
		</div>
		<div class="row" style="margin-top:5px;">
			<div class="col-sm-2">
				<label class="fa fa-md">Monitoring Date: </label>
			</div>
			<div class="col-sm-4">
				<input type="date" class="form-control" id="monitoring_date" name="monitoring_date" required>
			</div>
			<div class="col-sm-2">
				<label class="fa fa-md">Monitored by: </label>
			</div>
			<div class="col-sm-4">
				<select class="chosen-select" id="monitoring_by" name="monitoring_by" style="width:100%" required>
				</select>
			</div>
		</div>
		<div class="row" style="margin-top:5px;">
			<div class="col-sm-2">
				<label class="fa fa-md">Result: </label>
			</div>
			<div class="col-sm-10">
				<textarea rows="4" style="width:100%" id="monitoring_result" name="monitoring_result" required></textarea>
				<input type="hidden" name="tbl_id" id="tbl_id">
				<input type="hidden" name="user" id="user">
				<input type="hidden" name="mdl" id="mdl">
				<input type="hidden" name="frm" id="frm">
			</div>
		</div>
		<div class="row" style="margin-top:5px;">
			<div class="col-sm-2">
				<label class="fa fa-md">Attachment: </label>
			</div>
			<div class="col-sm-10">
				<input type="file" id="file_capa_attachment" name="file_capa_attachment">
			</div>
		</div>
      </div>
      <div class="modal-footer">
		<button type="submit" class="btn btn-primary fa fa-plus"> Add</button>
        <button type="button" class="btn btn-default fa fa-close" data-dismiss="modal"> Close</button>
      </div>
	  </form>
    </div><!-- /.modal-content -->
  </div><!-- /.modal-dialog -->
</div><!-- /.modal -->

<!-- Modal for Edit Monitoring -->
<div class="modal" tabindex="-1" role="dialog" id="modal_capa_edit_correction_monitoring" style="z-index:1051">
  <div class="modal-dialog modal-lg" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
        <h4 class="modal-title fa fa-plus"> Edit Action / Monitoring</h4>
      </div>
	  
      <div class="modal-body">
		<div>
			<form id="frm_capa_edit_correction">
				<div class="row" style="margin-top:5px;">
					<div class="col-sm-12 profile-info-title h4" style="padding-top:5px;">
						<span class="fa fa-hand-rock-o"></span> Edit Correction / Corrective Action
					</div>
				</div>
				<div class="row" style="margin-top:5px;">
					<div class="col-sm-2">
						<label class="fa fa-md">Type: </label>
					</div>
					<div class="col-sm-4">
						<select class="form-control" id="monitoring_type" name="monitoring_type" required>
							<option> - </option>
							<option value="CORRECTION"> Correction</option>
							<option value="CORRECTIVE"> Corrective Action</option>
						</select>
					</div>
				</div>
				<div class="row" style="margin-top:5px;">
					<div class="col-sm-2">
						<label class="fa fa-md">Action: </label>
					</div>
					<div class="col-sm-10">
						<textarea rows="4" style="width:100%" id="correction_action" name="correction_action" required></textarea>
					</div>
				</div>
				<div class="row" style="margin-top:5px;">
					<div class="col-sm-2">
						<label class="fa fa-md">In-charge Person: </label>
					</div>
					<div class="col-sm-4">
						<select class="chosen-select" id="incharge_person" name="incharge_person[]" multiple="multiple" style="width:100%" required>
						</select>
					</div>
					<div class="col-sm-2">
						<label class="fa fa-md">Due Date: </label>
					</div>
					<div class="col-sm-4">
						<input type="date" class="form-control" id="due_date" name="due_date" required>
					</div>
				</div>
				<div class="row" style="margin-top:5px;">
					<div class="col-sm-12">
						<button type="submit" class="btn btn-primary pull-right fa fa-save"> Update</button>
					</div>
				</div>
			</form>
		</div>
		<hr class="graph-orange" style="margin-top:0px;">
		<div id="">
			<form id="frm_capa_edit_monitoring">
				<div class="row" style="margin-top:5px;">
					<div class="col-sm-12 profile-info-title h4" style="padding-top:5px;">
						<span class="fa fa-hand-rock-o"></span> Edit Monitoring
					</div>
				</div>
				<div class="row" style="margin-top:5px;">
					<div class="col-sm-12 profile-info-title h4" style="padding-top:5px;">
						<label class="fa fa-sm">*Only "PENDING" monitoring is editable. </label>
					</div>
				</div>
				<div class="row" style="margin-top:5px;">
					<div class="col-sm-2">
						<label class="fa fa-md">Monitoring #: </label>
					</div>
					<div class="col-sm-10">
						<select class="form-control" style="width:100%" id="monitoring_number" name="monitoring_number" required>
						</select>
					</div>
				</div>
				<div class="row" style="margin-top:5px;">
					<div class="col-sm-2">
						<label class="fa fa-md">Monitoring Date: </label>
					</div>
					<div class="col-sm-4">
						<input type="date" class="form-control" id="monitoring_date" name="monitoring_date" required>
					</div>
					<div class="col-sm-2">
						<label class="fa fa-md">Monitored by: </label>
					</div>
					<div class="col-sm-4">
						<select class="chosen-select" id="monitoring_by" name="monitoring_by" style="width:100%" required>
						</select>
					</div>
				</div>
				<div class="row" style="margin-top:5px;">
					<div class="col-sm-2">
						<label class="fa fa-md">Result: </label>
					</div>
					<div class="col-sm-10">
						<textarea rows="4" style="width:100%" id="monitoring_result" name="monitoring_result" required></textarea>
						<input type="hidden" name="tbl_id" id="tbl_id">
						<input type="hidden" name="user" id="user">
						<input type="hidden" name="mdl" id="mdl">
						<input type="hidden" name="frm" id="frm">
					</div>
				</div>
				<div class="row" style="margin-top:5px;">
					<div class="col-sm-2">
						<label class="fa fa-md">Attachment: </label>
					</div>
					<div class="col-sm-10">
						<input type="file" id="monitoring_attachment" name="monitoring_attachment" style="display:inline-block;">
						<a href="#" id="dl_capa_attachment" class="fa fa-file-o" style="display:inline-block;"> Download file</a>
					</div>
				</div>
				<div class="row" style="margin-top:5px;">
					<div class="col-sm-12">
						<button type="submit" class="btn btn-primary pull-right fa fa-save"> Update</button>
					</div>
				</div>
			</form>
		</div>
      </div>
      <div class="modal-footer">		
        <button type="button" class="btn btn-default fa fa-close" data-dismiss="modal"> Close</button>
      </div>
    </div><!-- /.modal-content -->
  </div><!-- /.modal-dialog -->
</div><!-- /.modal -->
<!-- Modal for Edit Validation -->
<div class="modal" tabindex="-1" role="dialog" id="modal_capa_edit_correction_validation" style="z-index:1051">
  <div class="modal-dialog modal-lg" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
        <h4 class="modal-title fa fa-plus"> Edit Monitoring</h4>
      </div>
	  
      <div class="modal-body">
		<div id="">
			<form id="frm_capa_edit_validation">
				<div class="row" style="margin-top:5px;">
					<div class="col-sm-12 profile-info-title h4" style="padding-top:5px;">
						<span class="fa fa-hand-rock-o"></span> Edit Monitoring
					</div>
				</div>
				<div class="row" style="margin-top:5px;">
					<div class="col-sm-12 profile-info-title h4" style="padding-top:5px;">
						<label class="fa fa-sm">*Only "PENDING" monitoring is editable. </label>
					</div>
				</div>
				<div class="row" style="margin-top:5px;">
					<div class="col-sm-2">
						<label class="fa fa-md">Monitoring #: </label>
					</div>
					<div class="col-sm-10">
						<select class="form-control" style="width:100%" id="monitoring_number" name="monitoring_number" required>
						</select>
					</div>
				</div>
				<div class="row" style="margin-top:5px;">
					<div class="col-sm-2">
						<label class="fa fa-md">Monitoring Date: </label>
					</div>
					<div class="col-sm-4">
						<input type="date" class="form-control" id="monitoring_date" name="monitoring_date" required>
					</div>
					<div class="col-sm-2">
						<label class="fa fa-md">Monitored by: </label>
					</div>
					<div class="col-sm-4">
						<select class="chosen-select" id="monitoring_by" name="monitoring_by" style="width:100%" required>
						</select>
					</div>
				</div>
				<div class="row" style="margin-top:5px;">
					<div class="col-sm-2">
						<label class="fa fa-md">Result: </label>
					</div>
					<div class="col-sm-10">
						<textarea rows="4" style="width:100%" id="monitoring_result" name="monitoring_result" required></textarea>
						<input type="hidden" name="tbl_id" id="tbl_id">
						<input type="hidden" name="user" id="user">
						<input type="hidden" name="mdl" id="mdl">
						<input type="hidden" name="frm" id="frm">
					</div>
				</div>
				<div class="row" style="margin-top:5px;">
					<div class="col-sm-2">
						<label class="fa fa-md">Attachment: </label>
					</div>
					<div class="col-sm-10">
						<input type="file" id="monitoring_attachment" name="monitoring_attachment" style="display:inline-block;">
						<a href="#" id="dl_capa_attachment" class="fa fa-file-o" style="display:inline-block;"> Download file</a>
					</div>
				</div>
				<div class="row" style="margin-top:5px;">
					<div class="col-sm-12">
						<button type="submit" class="btn btn-primary pull-right fa fa-save"> Update</button>
					</div>
				</div>
			</form>
		</div>
      </div>
      <div class="modal-footer">		
        <button type="button" class="btn btn-default fa fa-close" data-dismiss="modal"> Close</button>
      </div>
    </div><!-- /.modal-content -->
  </div><!-- /.modal-dialog -->
</div><!-- /.modal -->

<!-- Modal for Approval of QS Supervisor -->
<div class="modal" tabindex="-1" role="dialog" id="modal_capa_qs_supervisor">
  <div class="modal-dialog modal-lg" role="document" style="width:98%">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
        <h4 class="modal-title fa fa-list-alt"> Compliance to CAPA due date (Duration: 12 days or 2 weeks)</h4>
      </div>
	  <form id="frm_capa_qs_supervisor">
		  <div class="modal-body">
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
					<input type="text" class="form-control" id="control_no" name="control_no">
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
					<select class="chosen-select" id="checked_by" name="checked_by[]" multiple style="width:100%">
					</select>
				</div>
				<div class="col-sm-2">
					<label class="fa fa-md">Conformed by: </label>
				</div>
				<div class="col-sm-4">
					<select class="chosen-select" id="conformed_by" name="conformed_by[]" multiple style="width:100%">
					</select>
				</div>
			</div>
			<div class="row" style="margin-top:5px;">
				<div class="col-sm-2">
					<label class="fa fa-md">Attachment: </label>
				</div>
				<div class="col-sm-4">
					<button type="button" class="btn btn-default fa fa-paperclip" id="file_capa_attachment" name="file_capa_attachment"> Download File</button>
				</div>
				<div class="col-sm-2">
					<label class="fa fa-md">Operations QE / QAD QE: </label>
				</div>
				<div class="col-sm-4">
					<select class="chosen-select" id="operations_qe" name="operations_qe[]" multiple="multiple" style="width:100%">
					</select>
				</div>
			</div>
			<div class="row" style="padding-top:5px;">
				<div class="col-sm-12" style="padding-top:5px;">			
					<table class="table table-bordered table-hover table-condensed table-striped" id="tbl_monitoring">
						<thead>
							<tr>
								<th rowspan="3"><center>Status</center></th>
								<th rowspan="3"><center>Correction</center></th>
								<th rowspan="3"><center>In-charge Person</center></th>
								<th rowspan="3"><center>Due Date</center></th>
								<th colspan="2" style="width:20%"><center>1st Monitoring</center></th>
								<th colspan="2" style="width:20%"><center>2nd Monitoring</center></th>
								<th colspan="2" style="width:20%"><center>3rd Monitoring</center></th>
								<th colspan="2" style="width:20%"><center>4th Monitoring</center></th>
								<th colspan="2" style="width:20%"><center>5th Monitoring</center></th>
								<th colspan="2" style="width:20%"><center>6th Monitoring</center></th>
								<th colspan="2" style="width:20%"><center>7th Monitoring</center></th>
								<th colspan="2" style="width:20%"><center>8th Monitoring</center></th>
								<th colspan="2" style="width:20%"><center>9th Monitoring</center></th>
								<th colspan="2" style="width:20%"><center>10th Monitoring</center></th>
								<th colspan="2" style="width:20%"><center>11th Monitoring</center></th>
								<th colspan="2" style="width:20%"><center>12th Monitoring</center></th>
								<th colspan="2"><center>Posted Logs</center></th>
							</tr>
						</thead>
						<tbody>
						</tbody>
					</table>
				</div>
			</div>
			<hr class="graph-orange" style="margin-top:0px;">
			<div class="row" style="margin-top:5px;">
				<div class="col-sm-2">
					<label class="fa fa-md">Remarks: </label>
				</div>
			</div>
			<div class="row" style="margin-top:5px;">					
				<div class="col-sm-12">
					<textarea id="remarks" name="remarks" style="width:100%" rows="3">
					</textarea>
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

<!-- Modal for Approval of QS Supervisor - Confirmation -->
<div class="modal fade" tabindex="-1" role="dialog" id="modal_capa_qs_supervisor_confirmation" style="z-index:1051">
  <div class="modal-dialog modal-md" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
        <h4 class="modal-title"><i class="fa fa-question-circle-o"></i> System Confirmation</h4>
      </div>
	  <form id="frm_capa_qs_supervisor_confirmation">
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

<!-- Modal for Approval of QS Conformance -->
<div class="modal" tabindex="-1" role="dialog" id="modal_capa_qs_conformance">
  <div class="modal-dialog modal-lg" role="document" style="width:98%">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
        <h4 class="modal-title fa fa-list-alt"> Compliance to CAPA due date (Duration: 12 days or 2 weeks)</h4>
      </div>
	  <form id="frm_capa_qs_conformance">
		  <div class="modal-body">
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
					<input type="text" class="form-control" id="control_no" name="control_no">
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
					<select class="chosen-select" id="checked_by" name="checked_by[]" multiple style="width:100%">
					</select>
				</div>
				<div class="col-sm-2">
					<label class="fa fa-md">Conformed by: </label>
				</div>
				<div class="col-sm-4">
					<select class="chosen-select" id="conformed_by" name="conformed_by[]" multiple style="width:100%">
					</select>
				</div>
				<div class="col-sm-2">
					<label class="fa fa-md">Attachment: </label>
				</div>
				<div class="col-sm-4">
					<button type="button" class="btn btn-default fa fa-paperclip" id="file_capa_attachment" name="file_capa_attachment"> Download File</button>
				</div>
			</div>
			<div class="row" style="padding-top:5px;">
				<div class="col-sm-12" style="padding-top:5px;">			
					<table class="table table-bordered table-hover table-condensed table-striped" id="tbl_monitoring">
						<thead>
							<tr>
								<th rowspan="3"><center>Status</center></th>
								<th rowspan="3"><center>Correction</center></th>
								<th rowspan="3"><center>In-charge Person</center></th>
								<th rowspan="3"><center>Due Date</center></th>
								<th colspan="2" style="width:20%"><center>1st Monitoring</center></th>
								<th colspan="2" style="width:20%"><center>2nd Monitoring</center></th>
								<th colspan="2" style="width:20%"><center>3rd Monitoring</center></th>
								<th colspan="2" style="width:20%"><center>4th Monitoring</center></th>
								<th colspan="2" style="width:20%"><center>5th Monitoring</center></th>
								<th colspan="2" style="width:20%"><center>6th Monitoring</center></th>
								<th colspan="2" style="width:20%"><center>7th Monitoring</center></th>
								<th colspan="2" style="width:20%"><center>8th Monitoring</center></th>
								<th colspan="2" style="width:20%"><center>9th Monitoring</center></th>
								<th colspan="2" style="width:20%"><center>10th Monitoring</center></th>
								<th colspan="2" style="width:20%"><center>11th Monitoring</center></th>
								<th colspan="2" style="width:20%"><center>12th Monitoring</center></th>
								<th colspan="2"><center>Posted Logs</center></th>
							</tr>
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
	  </form>
    </div><!-- /.modal-content -->
  </div><!-- /.modal-dialog -->
</div><!-- /.modal -->

<!-- Modal for Approval of QS Conformance - Confirmation -->
<div class="modal fade" tabindex="-1" role="dialog" id="modal_capa_qs_conformance_confirmation" style="z-index:1051">
  <div class="modal-dialog modal-md" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
        <h4 class="modal-title"><i class="fa fa-question-circle-o"></i> System Confirmation</h4>
      </div>
	  <form id="frm_capa_qs_conformance_confirmation">
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

<!-- Modal for Adding of QC and QAD Monitoring -->
<div class="modal" tabindex="-1" role="dialog" id="modal_capa_qc_qad_external_2nd_monitoring">
  <div class="modal-dialog modal-lg" role="document" style="width:98%">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
        <h4 class="modal-title fa fa-search"> CAPA Validation  (Duration: 12 days or 2 weeks)   In-charge person: QC & QAD </h4>
      </div>
	  <form id="frm_capa_qc_qad_external_2nd_monitoring">
		  <div class="modal-body">
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
					<input type="text" class="form-control" id="control_no" name="control_no">
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
					<select class="chosen-select" id="checked_by" name="checked_by[]" multiple style="width:100%">
					</select>
				</div>
				<div class="col-sm-2">
					<label class="fa fa-md">Conformed by: </label>
				</div>
				<div class="col-sm-4">
					<select class="chosen-select" id="conformed_by" name="conformed_by[]" multiple style="width:100%">
					</select>
				</div>
				<div class="col-sm-2">
					<label class="fa fa-md">Attachment: </label>
				</div>
				<div class="col-sm-4">
					<button type="button" class="btn btn-default fa fa-paperclip" id="file_capa_attachment" name="file_capa_attachment"> Download File</button>
				</div>
			</div>
			<br>
			<div class="panel-group" id="accordion" role="tablist" aria-multiselectable="true">
			  <div class="panel panel-default">
				<div class="panel-heading" role="tab" id="headingOne1">
				  <h4 class="panel-title">
					<a role="button" data-toggle="collapse" data-parent="#accordion" href="#collapseOne1" aria-expanded="false" aria-controls="collapseOne1">
					  Compliance to CAPA due date (Duration: 12 days or 2 weeks)   In-charge person: QC
					</a>
				  </h4>
				</div>
				<div id="collapseOne1" class="panel-collapse collapse" role="tabpanel" aria-labelledby="headingOne1">
				  <div class="panel-body">
					<div class="row" style="padding-top:5px;">
						<div class="col-sm-12">
							<div class="alert alert-danger" style="display:none;" role="alert" id="container_capa_compliance_due_date_message">					
							</div>
						</div>		
						<div class="col-sm-12" style="padding-top:5px;">				
							<table class="table table-bordered table-hover table-condensed table-striped" id="tbl_monitoring">
								<thead>
									<tr>
										<th rowspan="3"><center>Status</center></th>
										<th rowspan="3"><center>Correction</center></th>
										<th rowspan="3"><center>In-charge Person</center></th>
										<th rowspan="3"><center>Due Date</center></th>
										<th colspan="2" style="width:20%"><center>1st Monitoring</center></th>
										<th colspan="2" style="width:20%"><center>2nd Monitoring</center></th>
										<th colspan="2" style="width:20%"><center>3rd Monitoring</center></th>
										<th colspan="2" style="width:20%"><center>4th Monitoring</center></th>
										<th colspan="2" style="width:20%"><center>5th Monitoring</center></th>
										<th colspan="2" style="width:20%"><center>6th Monitoring</center></th>
										<th colspan="2" style="width:20%"><center>7th Monitoring</center></th>
										<th colspan="2" style="width:20%"><center>8th Monitoring</center></th>
										<th colspan="2" style="width:20%"><center>9th Monitoring</center></th>
										<th colspan="2" style="width:20%"><center>10th Monitoring</center></th>
										<th colspan="2" style="width:20%"><center>11th Monitoring</center></th>
										<th colspan="2" style="width:20%"><center>12th Monitoring</center></th>
										<th colspan="2"><center>Posted Logs</center></th>		
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
			  <div class="panel panel-default">
				<div class="panel-heading" role="tab" id="headingTwo">
				  <h4 class="panel-title">
					<a class="collapsed" role="button" data-toggle="collapse" data-parent="#accordion" href="#collapseTwo" aria-expanded="true" aria-controls="collapseTwo">
					  CAPA Validation  (Duration: 12 days or 2 weeks)   In-charge person: QC &QAD
					</a>
				  </h4>
				</div>
				<div id="collapseTwo" class="panel-collapse collapse in" role="tabpanel" aria-labelledby="headingTwo">
				  <div class="panel-body">
					<div class="row" style="padding-top:5px;">
						<div class="col-sm-12">
							<div class="alert alert-danger" style="display:none;" role="alert" id="container_capa_compliance_due_date_message">					
							</div>
						</div>		
						<div class="col-sm-12" style="padding-top:5px;">
							<button type="button" class="btn btn-primary pull-right fa fa-plus" id="btn_add_validation"> Add</button>					
							<table class="table table-bordered table-hover table-condensed table-striped" id="tbl_monitoring2">
								<thead>
									<tr>
										<th rowspan="3"><center>Status</center></th>
										<th rowspan="3"><center>Correction</center></th>
										<th rowspan="3"><center>In-charge Person</center></th>
										<th rowspan="3"><center>Due Date</center></th>
										<th colspan="2" style="width:20%"><center>1st Monitoring</center></th>
										<th colspan="2" style="width:20%"><center>2nd Monitoring</center></th>
										<th colspan="2" style="width:20%"><center>3rd Monitoring</center></th>
										<th colspan="2" style="width:20%"><center>4th Monitoring</center></th>
										<th colspan="2" style="width:20%"><center>5th Monitoring</center></th>
										<th colspan="2" style="width:20%"><center>6th Monitoring</center></th>
										<th colspan="2" style="width:20%"><center>7th Monitoring</center></th>
										<th colspan="2" style="width:20%"><center>8th Monitoring</center></th>
										<th colspan="2" style="width:20%"><center>9th Monitoring</center></th>
										<th colspan="2" style="width:20%"><center>10th Monitoring</center></th>
										<th colspan="2" style="width:20%"><center>11th Monitoring</center></th>
										<th colspan="2" style="width:20%"><center>12th Monitoring</center></th>
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
			
						
			
		  </div>
		  <div class="modal-footer">
			<button type="button" class="btn btn-default fa fa-close" data-dismiss="modal"> Close</button>
		  </div>
	  </form>
    </div><!-- /.modal-content -->
  </div><!-- /.modal-dialog -->
</div><!-- /.modal -->

<!-- Modal for Edit of QC and QAD Monitoring -->
<div class="modal" tabindex="-1" role="dialog" id="modal_capa_qc_qad_external_2nd_monitoring_edit">
  <div class="modal-dialog modal-lg" role="document" style="width:98%">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
        <h4 class="modal-title fa fa-search"> CAPA Validation  (Duration: 12 days or 2 weeks)   In-charge person: QC & QAD </h4>
      </div>
	  <form id="frm_capa_qc_qad_external_2nd_monitoring_edit">
		  <div class="modal-body">
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
					<input type="text" class="form-control" id="control_no" name="control_no">
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
					<select class="chosen-select" id="checked_by" name="checked_by[]" multiple style="width:100%">
					</select>
				</div>
				<div class="col-sm-2">
					<label class="fa fa-md">Conformed by: </label>
				</div>
				<div class="col-sm-4">
					<select class="chosen-select" id="conformed_by" name="conformed_by[]" multiple style="width:100%">
					</select>
				</div>
				<div class="col-sm-2">
					<label class="fa fa-md">Attachment: </label>
				</div>
				<div class="col-sm-4">
					<button type="button" class="btn btn-default fa fa-paperclip" id="file_capa_attachment" name="file_capa_attachment"> Download File</button>
				</div>
			</div>
			<br>
			<div class="panel-group" id="accordion" role="tablist" aria-multiselectable="true">
			  <div class="panel panel-default">
				<div class="panel-heading" role="tab" id="headingOne11">
				  <h4 class="panel-title">
					<a role="button" data-toggle="collapse" data-parent="#accordion" href="#collapseOne11" aria-expanded="false" aria-controls="collapseOne11">
					  Compliance to CAPA due date (Duration: 12 days or 2 weeks)   In-charge person: QC
					</a>
				  </h4>
				</div>
				<div id="collapseOne11" class="panel-collapse collapse" role="tabpanel" aria-labelledby="headingOne11">
				  <div class="panel-body">
					<div class="row" style="padding-top:5px;">
						<div class="col-sm-12">
							<div class="alert alert-danger" style="display:none;" role="alert" id="container_capa_compliance_due_date_message">					
							</div>
						</div>		
						<div class="col-sm-12" style="padding-top:5px;">				
							<table class="table table-bordered table-hover table-condensed table-striped" id="tbl_monitoring">
								<thead>
									<tr>
										<th rowspan="3"><center>Status</center></th>
										<th rowspan="3"><center>Correction</center></th>
										<th rowspan="3"><center>In-charge Person</center></th>
										<th rowspan="3"><center>Due Date</center></th>
										<th colspan="2" style="width:20%"><center>1st Monitoring</center></th>
										<th colspan="2" style="width:20%"><center>2nd Monitoring</center></th>
										<th colspan="2" style="width:20%"><center>3rd Monitoring</center></th>
										<th colspan="2" style="width:20%"><center>4th Monitoring</center></th>
										<th colspan="2" style="width:20%"><center>5th Monitoring</center></th>
										<th colspan="2" style="width:20%"><center>6th Monitoring</center></th>
										<th colspan="2" style="width:20%"><center>7th Monitoring</center></th>
										<th colspan="2" style="width:20%"><center>8th Monitoring</center></th>
										<th colspan="2" style="width:20%"><center>9th Monitoring</center></th>
										<th colspan="2" style="width:20%"><center>10th Monitoring</center></th>
										<th colspan="2" style="width:20%"><center>11th Monitoring</center></th>
										<th colspan="2" style="width:20%"><center>12th Monitoring</center></th>
										<th colspan="2"><center>Posted Logs</center></th>		
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
			  <div class="panel panel-default">
				<div class="panel-heading" role="tab" id="headingTwo1">
				  <h4 class="panel-title">
					<a class="collapsed" role="button" data-toggle="collapse" data-parent="#accordion" href="#collapseTwo1" aria-expanded="true" aria-controls="collapseTwo1">
					  CAPA Validation  (Duration: 12 days or 2 weeks)   In-charge person: QC &QAD
					</a>
				  </h4>
				</div>
				<div id="collapseTwo1" class="panel-collapse collapse in" role="tabpanel" aria-labelledby="headingTwo1">
				  <div class="panel-body">
					<div class="row" style="padding-top:5px;">
						<div class="col-sm-12">
							<div class="alert alert-danger" style="display:none;" role="alert" id="container_capa_compliance_due_date_message">					
							</div>
						</div>		
						<div class="col-sm-12" style="padding-top:5px;">		
							<table class="table table-bordered table-hover table-condensed table-striped" id="tbl_monitoring2">
								<thead>
									<tr>
										<th rowspan="3"><center>Status</center></th>
										<th rowspan="3"><center>Correction</center></th>
										<th rowspan="3"><center>In-charge Person</center></th>
										<th rowspan="3"><center>Due Date</center></th>
										<th colspan="2" style="width:20%"><center>1st Monitoring</center></th>
										<th colspan="2" style="width:20%"><center>2nd Monitoring</center></th>
										<th colspan="2" style="width:20%"><center>3rd Monitoring</center></th>
										<th colspan="2" style="width:20%"><center>4th Monitoring</center></th>
										<th colspan="2" style="width:20%"><center>5th Monitoring</center></th>
										<th colspan="2" style="width:20%"><center>6th Monitoring</center></th>
										<th colspan="2" style="width:20%"><center>7th Monitoring</center></th>
										<th colspan="2" style="width:20%"><center>8th Monitoring</center></th>
										<th colspan="2" style="width:20%"><center>9th Monitoring</center></th>
										<th colspan="2" style="width:20%"><center>10th Monitoring</center></th>
										<th colspan="2" style="width:20%"><center>11th Monitoring</center></th>
										<th colspan="2" style="width:20%"><center>12th Monitoring</center></th>
										<th colspan="2"><center>Action</center></th>
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
		  </div>
		  <div class="modal-footer">
			<button type="button" class="btn btn-default fa fa-close" data-dismiss="modal"> Close</button>
		  </div>
	  </form>
    </div><!-- /.modal-content -->
  </div><!-- /.modal-dialog -->
</div><!-- /.modal -->

<!-- Modal for View of QC and QAD Monitoring -->
<div class="modal" tabindex="-1" role="dialog" id="modal_capa_qc_qad_external_2nd_monitoring_view">
  <div class="modal-dialog modal-lg" role="document" style="width:98%">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
        <h4 class="modal-title fa fa-search"> CAPA Validation  (Duration: 12 days or 2 weeks)   In-charge person: QC & QAD </h4>
      </div>
	  <form id="frm_capa_qc_qad_external_2nd_monitoring_view">
		  <div class="modal-body">
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
					<input type="text" class="form-control" id="control_no" name="control_no">
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
					<select class="chosen-select" id="checked_by" name="checked_by[]" multiple style="width:100%">
					</select>
				</div>
				<div class="col-sm-2">
					<label class="fa fa-md">Conformed by: </label>
				</div>
				<div class="col-sm-4">
					<select class="chosen-select" id="conformed_by" name="conformed_by[]" multiple style="width:100%">
					</select>
				</div>
				<div class="col-sm-2">
					<label class="fa fa-md">Attachment: </label>
				</div>
				<div class="col-sm-4">
					<button type="button" class="btn btn-default fa fa-paperclip" id="file_capa_attachment" name="file_capa_attachment"> Download File</button>
				</div>
			</div>
			<br>
			<div class="panel-group" id="accordion" role="tablist" aria-multiselectable="true">
			  <div class="panel panel-default">
				<div class="panel-heading" role="tab" id="headingOne111">
				  <h4 class="panel-title">
					<a role="button" data-toggle="collapse" data-parent="#accordion" href="#collapseOne111" aria-expanded="false" aria-controls="collapseOne111">
					  Compliance to CAPA due date (Duration: 12 days or 2 weeks)   In-charge person: QC
					</a>
				  </h4>
				</div>
				<div id="collapseOne111" class="panel-collapse collapse" role="tabpanel" aria-labelledby="headingOne111">
				  <div class="panel-body">
					<div class="row" style="padding-top:5px;">
						<div class="col-sm-12">
							<div class="alert alert-danger" style="display:none;" role="alert" id="container_capa_compliance_due_date_message">					
							</div>
						</div>		
						<div class="col-sm-12" style="padding-top:5px;">				
							<table class="table table-bordered table-hover table-condensed table-striped" id="tbl_monitoring">
								<thead>
									<tr>
										<th rowspan="3"><center>Status</center></th>
										<th rowspan="3"><center>Correction</center></th>
										<th rowspan="3"><center>In-charge Person</center></th>
										<th rowspan="3"><center>Due Date</center></th>
										<th colspan="2" style="width:20%"><center>1st Monitoring</center></th>
										<th colspan="2" style="width:20%"><center>2nd Monitoring</center></th>
										<th colspan="2" style="width:20%"><center>3rd Monitoring</center></th>
										<th colspan="2" style="width:20%"><center>4th Monitoring</center></th>
										<th colspan="2" style="width:20%"><center>5th Monitoring</center></th>
										<th colspan="2" style="width:20%"><center>6th Monitoring</center></th>
										<th colspan="2" style="width:20%"><center>7th Monitoring</center></th>
										<th colspan="2" style="width:20%"><center>8th Monitoring</center></th>
										<th colspan="2" style="width:20%"><center>9th Monitoring</center></th>
										<th colspan="2" style="width:20%"><center>10th Monitoring</center></th>
										<th colspan="2" style="width:20%"><center>11th Monitoring</center></th>
										<th colspan="2" style="width:20%"><center>12th Monitoring</center></th>
										<th colspan="2"><center>Posted Logs</center></th>
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
			  <div class="panel panel-default">
				<div class="panel-heading" role="tab" id="headingTwo11">
				  <h4 class="panel-title">
					<a class="collapsed" role="button" data-toggle="collapse" data-parent="#accordion" href="#collapseTwo11" aria-expanded="true" aria-controls="collapseTwo11">
					  CAPA Validation  (Duration: 12 days or 2 weeks)   In-charge person: QC &QAD
					</a>
				  </h4>
				</div>
				<div id="collapseTwo11" class="panel-collapse collapse in" role="tabpanel" aria-labelledby="headingTwo11">
				  <div class="panel-body">
					<div class="row" style="padding-top:5px;">
						<div class="col-sm-12">
							<div class="alert alert-danger" style="display:none;" role="alert" id="container_capa_compliance_due_date_message">					
							</div>
						</div>		
						<div class="col-sm-12" style="padding-top:5px;">		
							<table class="table table-bordered table-hover table-condensed table-striped" id="tbl_monitoring2">
								<thead>
									<tr>
										<th rowspan="3"><center>Status</center></th>
										<th rowspan="3"><center>Correction</center></th>
										<th rowspan="3"><center>In-charge Person</center></th>
										<th rowspan="3"><center>Due Date</center></th>
										<th colspan="2" style="width:20%"><center>1st Monitoring</center></th>
										<th colspan="2" style="width:20%"><center>2nd Monitoring</center></th>
										<th colspan="2" style="width:20%"><center>3rd Monitoring</center></th>
										<th colspan="2" style="width:20%"><center>4th Monitoring</center></th>
										<th colspan="2" style="width:20%"><center>5th Monitoring</center></th>
										<th colspan="2" style="width:20%"><center>6th Monitoring</center></th>
										<th colspan="2" style="width:20%"><center>7th Monitoring</center></th>
										<th colspan="2" style="width:20%"><center>8th Monitoring</center></th>
										<th colspan="2" style="width:20%"><center>9th Monitoring</center></th>
										<th colspan="2" style="width:20%"><center>10th Monitoring</center></th>
										<th colspan="2" style="width:20%"><center>11th Monitoring</center></th>
										<th colspan="2" style="width:20%"><center>12th Monitoring</center></th>
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
		  </div>
		  <div class="modal-footer">
			<button type="button" class="btn btn-default fa fa-close" data-dismiss="modal"> Close</button>
		  </div>
	  </form>
    </div><!-- /.modal-content -->
  </div><!-- /.modal-dialog -->
</div><!-- /.modal -->

<!-- Modal for Approval of QC/QAD AM-Up -->
<div class="modal" tabindex="-1" role="dialog" id="modal_capa_qc_qad_am_up">
  <div class="modal-dialog modal-lg" role="document" style="width:98%">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
        <h4 class="modal-title fa fa-list-alt"> CAPA Validation (Duration: 12 days or 2 weeks) In-charge person: QC &QAD </h4>
      </div>
	  <form id="frm_capa_qc_qad_am_up">
		  <div class="modal-body">
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
					<input type="text" class="form-control" id="control_no" name="control_no">
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
					<select class="chosen-select" id="checked_by" name="checked_by[]" multiple style="width:100%">
					</select>
				</div>
				<div class="col-sm-2">
					<label class="fa fa-md">Conformed by: </label>
				</div>
				<div class="col-sm-4">
					<select class="chosen-select" id="conformed_by" name="conformed_by[]" multiple style="width:100%">
					</select>
				</div>
				<div class="col-sm-2">
					<label class="fa fa-md">Attachment: </label>
				</div>
				<div class="col-sm-4">
					<button type="button" class="btn btn-default fa fa-paperclip" id="file_capa_attachment" name="file_capa_attachment"> Download File</button>
				</div>
			</div>
			<br>
			<div class="panel-group" id="accordion" role="tablist" aria-multiselectable="true">
			  <div class="panel panel-default">
				<div class="panel-heading" role="tab" id="monitoring_heading1">
				  <h4 class="panel-title">
					<a role="button" data-toggle="collapse" data-parent="#accordion" href="#monitoring_collapse1" aria-expanded="false" aria-controls="monitoring_collapse1">
					  Compliance to CAPA due date (Duration: 12 days or 2 weeks)   In-charge person: QC
					</a>
				  </h4>
				</div>
				<div id="monitoring_collapse1" class="panel-collapse collapse" role="tabpanel" aria-labelledby="monitoring_heading1">
				  <div class="panel-body">
					<div class="row" style="padding-top:5px;">
						<div class="col-sm-12">
							<div class="alert alert-danger" style="display:none;" role="alert" id="container_capa_compliance_due_date_message">					
							</div>
						</div>		
						<div class="col-sm-12" style="padding-top:5px;">				
							<table class="table table-bordered table-hover table-condensed table-striped" id="tbl_monitoring">
								<thead>
									<tr>
										<th rowspan="3"><center>Status</center></th>
										<th rowspan="3"><center>Correction</center></th>
										<th rowspan="3"><center>In-charge Person</center></th>
										<th rowspan="3"><center>Due Date</center></th>
										<th colspan="2" style="width:20%"><center>1st Monitoring</center></th>
										<th colspan="2" style="width:20%"><center>2nd Monitoring</center></th>
										<th colspan="2" style="width:20%"><center>3rd Monitoring</center></th>
										<th colspan="2" style="width:20%"><center>4th Monitoring</center></th>
										<th colspan="2" style="width:20%"><center>5th Monitoring</center></th>
										<th colspan="2" style="width:20%"><center>6th Monitoring</center></th>
										<th colspan="2" style="width:20%"><center>7th Monitoring</center></th>
										<th colspan="2" style="width:20%"><center>8th Monitoring</center></th>
										<th colspan="2" style="width:20%"><center>9th Monitoring</center></th>
										<th colspan="2" style="width:20%"><center>10th Monitoring</center></th>
										<th colspan="2" style="width:20%"><center>11th Monitoring</center></th>
										<th colspan="2" style="width:20%"><center>12th Monitoring</center></th>
										<th colspan="2"><center>Posted Logs</center></th>						
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
			  <div class="panel panel-default">
				<div class="panel-heading" role="tab" id="validation_heading2">
				  <h4 class="panel-title">
					<a class="collapsed" role="button" data-toggle="collapse" data-parent="#accordion" href="#validation_collapse" aria-expanded="true" aria-controls="validation_collapse2">
					  CAPA Validation  (Duration: 12 days or 2 weeks)   In-charge person: QC &QAD
					</a>
				  </h4>
				</div>
				<div id="validation_collapse2" class="panel-collapse collapse in" role="tabpanel" aria-labelledby="validation_heading2">
				  <div class="panel-body">
					<div class="row" style="padding-top:5px;">
						<div class="col-sm-12">
							<div class="alert alert-danger" style="display:none;" role="alert" id="container_capa_compliance_due_date_message">					
							</div>
						</div>		
						<div class="col-sm-12" style="padding-top:5px;">				
							<table class="table table-bordered table-hover table-condensed table-striped" id="tbl_monitoring2">
								<thead>
									<tr>
										<th rowspan="3"><center>Status</center></th>
										<th rowspan="3"><center>Correction</center></th>
										<th rowspan="3"><center>In-charge Person</center></th>
										<th rowspan="3"><center>Due Date</center></th>
										<th colspan="2" style="width:20%"><center>1st Monitoring</center></th>
										<th colspan="2" style="width:20%"><center>2nd Monitoring</center></th>
										<th colspan="2" style="width:20%"><center>3rd Monitoring</center></th>
										<th colspan="2" style="width:20%"><center>4th Monitoring</center></th>
										<th colspan="2" style="width:20%"><center>5th Monitoring</center></th>
										<th colspan="2" style="width:20%"><center>6th Monitoring</center></th>
										<th colspan="2" style="width:20%"><center>7th Monitoring</center></th>
										<th colspan="2" style="width:20%"><center>8th Monitoring</center></th>
										<th colspan="2" style="width:20%"><center>9th Monitoring</center></th>
										<th colspan="2" style="width:20%"><center>10th Monitoring</center></th>
										<th colspan="2" style="width:20%"><center>11th Monitoring</center></th>
										<th colspan="2" style="width:20%"><center>12th Monitoring</center></th>
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
		  </div>
		  <div class="modal-footer">
			<button type="button" class="btn btn-default fa fa-close" data-dismiss="modal"> Close</button>
		  </div>
	  </form>
    </div><!-- /.modal-content -->
  </div><!-- /.modal-dialog -->
</div><!-- /.modal -->

<!-- Modal for Approval of QC/QAD Supervisor -->
<div class="modal" tabindex="-1" role="dialog" id="modal_capa_qc_qad_supervisor_confirmation">
  <div class="modal-dialog modal-lg" role="document" style="width:98%">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
        <h4 class="modal-title fa fa-list-alt"> CAPA Validation (Duration: 12 days or 2 weeks) In-charge person: QC &QAD </h4>
      </div>
	  <form id="frm_capa_qc_qad_supervisor_confirmation">
		  <div class="modal-body">
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
					<input type="text" class="form-control" id="control_no" name="control_no">
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
					<select class="chosen-select" id="checked_by" name="checked_by[]" multiple style="width:100%">
					</select>
				</div>
				<div class="col-sm-2">
					<label class="fa fa-md">Conformed by: </label>
				</div>
				<div class="col-sm-4">
					<select class="chosen-select" id="conformed_by" name="conformed_by[]" multiple style="width:100%">
					</select>
				</div>
				<div class="col-sm-2">
					<label class="fa fa-md">Attachment: </label>
				</div>
				<div class="col-sm-4">
					<button type="button" class="btn btn-default fa fa-paperclip" id="file_capa_attachment" name="file_capa_attachment"> Download File</button>
				</div>
			</div>
			<br>
			<div class="panel-group" id="accordion" role="tablist" aria-multiselectable="true">
			  <div class="panel panel-default">
				<div class="panel-heading" role="tab" id="heading4">
				  <h4 class="panel-title">
					<a role="button" data-toggle="collapse" data-parent="#accordion" href="#monitoring_collapse4" aria-expanded="false" aria-controls="monitoring_collapse4">
					  Compliance to CAPA due date (Duration: 12 days or 2 weeks)   In-charge person: QC
					</a>
				  </h4>
				</div>
				<div id="monitoring_collapse4" class="panel-collapse collapse" role="tabpanel" aria-labelledby="heading4">
				  <div class="panel-body">
					<div class="row" style="padding-top:5px;">
						<div class="col-sm-12">
							<div class="alert alert-danger" style="display:none;" role="alert" id="container_capa_compliance_due_date_message">					
							</div>
						</div>		
						<div class="col-sm-12" style="padding-top:5px;">				
							<table class="table table-bordered table-hover table-condensed table-striped" id="tbl_monitoring">
								<thead>
									<tr>
										<th rowspan="3"><center>Status</center></th>
										<th rowspan="3"><center>Correction</center></th>
										<th rowspan="3"><center>In-charge Person</center></th>
										<th rowspan="3"><center>Due Date</center></th>
										<th colspan="2" style="width:20%"><center>1st Monitoring</center></th>
										<th colspan="2" style="width:20%"><center>2nd Monitoring</center></th>
										<th colspan="2" style="width:20%"><center>3rd Monitoring</center></th>
										<th colspan="2" style="width:20%"><center>4th Monitoring</center></th>
										<th colspan="2" style="width:20%"><center>5th Monitoring</center></th>
										<th colspan="2" style="width:20%"><center>6th Monitoring</center></th>
										<th colspan="2" style="width:20%"><center>7th Monitoring</center></th>
										<th colspan="2" style="width:20%"><center>8th Monitoring</center></th>
										<th colspan="2" style="width:20%"><center>9th Monitoring</center></th>
										<th colspan="2" style="width:20%"><center>10th Monitoring</center></th>
										<th colspan="2" style="width:20%"><center>11th Monitoring</center></th>
										<th colspan="2" style="width:20%"><center>12th Monitoring</center></th>
										<th colspan="2"><center>Posted Logs</center></th>
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
			  <div class="panel panel-default">
				<div class="panel-heading" role="tab" id="validation_heading4">
				  <h4 class="panel-title">
					<a class="collapsed" role="button" data-toggle="collapse" data-parent="#accordion" href="#validation_collapse4" aria-expanded="true" aria-controls="validation_collapse4">
					  CAPA Validation  (Duration: 12 days or 2 weeks)   In-charge person: QC &QAD
					</a>
				  </h4>
				</div>
				<div id="validation_collapse4" class="panel-collapse collapse in" role="tabpanel" aria-labelledby="validation_heading4">
				  <div class="panel-body">
					<div class="row" style="padding-top:5px;">
						<div class="col-sm-12">
							<div class="alert alert-danger" style="display:none;" role="alert" id="container_capa_compliance_due_date_message">					
							</div>
						</div>		
						<div class="col-sm-12" style="padding-top:5px;">				
							<table class="table table-bordered table-hover table-condensed table-striped" id="tbl_monitoring2">
								<thead>
									<tr>
										<th rowspan="3"><center>Status</center></th>
										<th rowspan="3"><center>Correction</center></th>
										<th rowspan="3"><center>In-charge Person</center></th>
										<th rowspan="3"><center>Due Date</center></th>
										<th colspan="2" style="width:20%"><center>1st Monitoring</center></th>
										<th colspan="2" style="width:20%"><center>2nd Monitoring</center></th>
										<th colspan="2" style="width:20%"><center>3rd Monitoring</center></th>
										<th colspan="2" style="width:20%"><center>4th Monitoring</center></th>
										<th colspan="2" style="width:20%"><center>5th Monitoring</center></th>
										<th colspan="2" style="width:20%"><center>6th Monitoring</center></th>
										<th colspan="2" style="width:20%"><center>7th Monitoring</center></th>
										<th colspan="2" style="width:20%"><center>8th Monitoring</center></th>
										<th colspan="2" style="width:20%"><center>9th Monitoring</center></th>
										<th colspan="2" style="width:20%"><center>10th Monitoring</center></th>
										<th colspan="2" style="width:20%"><center>11th Monitoring</center></th>
										<th colspan="2" style="width:20%"><center>12th Monitoring</center></th>
										<th colspan="2"><center>Posted Logs</center></th>
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
			  <div class="panel panel-default">
				<div class="panel-heading" role="tab" id="validation_heading41">
				  <h4 class="panel-title">
					<a class="collapsed" role="button" data-toggle="collapse" data-parent="#accordion3" href="#collapseThree4" aria-expanded="true" aria-controls="collapseThree4">
					  CAPA Validation (Duration:3 months) ICP: QAD
					</a>
				  </h4>
				</div>
				<div id="collapseThree4" class="panel-collapse collapse in" role="tabpanel" aria-labelledby="validation_heading41">
				  <div class="panel-body">
					<div class="row" style="padding-top:5px;">
						<div class="col-sm-12">
							<div class="alert alert-danger" style="display:none;" role="alert" id="container_capa_compliance_due_date_message">					
							</div>
						</div>		
						<div class="col-sm-12" style="padding-top:5px;">				
							<table class="table table-bordered table-hover table-condensed table-striped" id="tbl_monitoring3">
								<thead>
									<tr>
										<th rowspan="3" style="width:4%"><center>Status</center></th>
										<th rowspan="3" style="width:14%"><center>Correction</center></th>
										<th rowspan="3" style="width:6%"><center>In-charge Person</center></th>
										<th rowspan="3" style="width:5%"><center>Due Date</center></th>
										<th colspan="2" style="width:20%"><center>1st Monitoring</center></th>
										<th colspan="2" style="width:20%"><center>2nd Monitoring</center></th>
										<th colspan="2" style="width:20%"><center>3rd Monitoring</center></th>
										<th colspan="2" style="width:6%"><center>Posted Logs</center></th>
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
		  </div>
		  <div class="modal-footer">
			<button type="button" class="btn btn-default fa fa-close" data-dismiss="modal"> Close</button>
		  </div>
	  </form>
    </div><!-- /.modal-content -->
  </div><!-- /.modal-dialog -->
</div><!-- /.modal -->

<!-- Modal for Approval of QS Conformance -->
<div class="modal" tabindex="-1" role="dialog" id="modal_capa_qc_qad_conformance">
  <div class="modal-dialog modal-lg" role="document" style="width:98%">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
        <h4 class="modal-title fa fa-list-alt"> CAPA Validation (Duration: 12 days or 2 weeks) In-charge person: QC &QAD </h4>
      </div>
	  <form id="frm_capa_qc_qad_conformance">
		  <div class="modal-body">
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
					<input type="text" class="form-control" id="control_no" name="control_no">
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
					<select class="chosen-select" id="checked_by" name="checked_by[]" multiple style="width:100%">
					</select>
				</div>
				<div class="col-sm-2">
					<label class="fa fa-md">Conformed by: </label>
				</div>
				<div class="col-sm-4">
					<select class="chosen-select" id="conformed_by" name="conformed_by[]" multiple style="width:100%">
					</select>
				</div>
				<div class="col-sm-2">
					<label class="fa fa-md">Attachment: </label>
				</div>
				<div class="col-sm-4">
					<button type="button" class="btn btn-default fa fa-paperclip" id="file_capa_attachment" name="file_capa_attachment"> Download File</button>
				</div>
			</div>
			<br>
			<div class="panel-group" id="accordion" role="tablist" aria-multiselectable="true">
			  <div class="panel panel-default">
				<div class="panel-heading" role="tab" id="monitoring_heading3">
				  <h4 class="panel-title">
					<a role="button" data-toggle="collapse" data-parent="#accordion" href="#monitoring_collapse3" aria-expanded="false" aria-controls="monitoring_collapse3">
					  Compliance to CAPA due date (Duration: 12 days or 2 weeks)   In-charge person: QC
					</a>
				  </h4>
				</div>
				<div id="monitoring_collapse3" class="panel-collapse collapse" role="tabpanel" aria-labelledby="monitoring_heading3">
				  <div class="panel-body">
					<div class="row" style="padding-top:5px;">
						<div class="col-sm-12">
							<div class="alert alert-danger" style="display:none;" role="alert" id="container_capa_compliance_due_date_message">					
							</div>
						</div>		
						<div class="col-sm-12" style="padding-top:5px;">				
							<table class="table table-bordered table-hover table-condensed table-striped" id="tbl_monitoring">
								<thead>
									<tr>
										<th rowspan="3"><center>Status</center></th>
										<th rowspan="3"><center>Correction</center></th>
										<th rowspan="3"><center>In-charge Person</center></th>
										<th rowspan="3"><center>Due Date</center></th>
										<th colspan="2" style="width:20%"><center>1st Monitoring</center></th>
										<th colspan="2" style="width:20%"><center>2nd Monitoring</center></th>
										<th colspan="2" style="width:20%"><center>3rd Monitoring</center></th>
										<th colspan="2" style="width:20%"><center>4th Monitoring</center></th>
										<th colspan="2" style="width:20%"><center>5th Monitoring</center></th>
										<th colspan="2" style="width:20%"><center>6th Monitoring</center></th>
										<th colspan="2" style="width:20%"><center>7th Monitoring</center></th>
										<th colspan="2" style="width:20%"><center>8th Monitoring</center></th>
										<th colspan="2" style="width:20%"><center>9th Monitoring</center></th>
										<th colspan="2" style="width:20%"><center>10th Monitoring</center></th>
										<th colspan="2" style="width:20%"><center>11th Monitoring</center></th>
										<th colspan="2" style="width:20%"><center>12th Monitoring</center></th>
										<th colspan="2"><center>Posted Logs</center></th>	
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
			  <div class="panel panel-default">
				<div class="panel-heading" role="tab" id="validation_heading3">
				  <h4 class="panel-title">
					<a class="collapsed" role="button" data-toggle="collapse" data-parent="#accordion" href="#validation_collapse" aria-expanded="true" aria-controls="validation_collapse3">
					  CAPA Validation  (Duration: 12 days or 2 weeks)   In-charge person: QC &QAD
					</a>
				  </h4>
				</div>
				<div id="validation_collapse3" class="panel-collapse collapse in" role="tabpanel" aria-labelledby="validation_heading3">
				  <div class="panel-body">
					<div class="row" style="padding-top:5px;">
						<div class="col-sm-12">
							<div class="alert alert-danger" style="display:none;" role="alert" id="container_capa_compliance_due_date_message">					
							</div>
						</div>		
						<div class="col-sm-12" style="padding-top:5px;">				
							<table class="table table-bordered table-hover table-condensed table-striped" id="tbl_monitoring2">
								<thead>
									<tr>
										<th rowspan="3"><center>Status</center></th>
										<th rowspan="3"><center>Correction</center></th>
										<th rowspan="3"><center>In-charge Person</center></th>
										<th rowspan="3"><center>Due Date</center></th>
										<th colspan="2" style="width:20%"><center>1st Monitoring</center></th>
										<th colspan="2" style="width:20%"><center>2nd Monitoring</center></th>
										<th colspan="2" style="width:20%"><center>3rd Monitoring</center></th>
										<th colspan="2" style="width:20%"><center>4th Monitoring</center></th>
										<th colspan="2" style="width:20%"><center>5th Monitoring</center></th>
										<th colspan="2" style="width:20%"><center>6th Monitoring</center></th>
										<th colspan="2" style="width:20%"><center>7th Monitoring</center></th>
										<th colspan="2" style="width:20%"><center>8th Monitoring</center></th>
										<th colspan="2" style="width:20%"><center>9th Monitoring</center></th>
										<th colspan="2" style="width:20%"><center>10th Monitoring</center></th>
										<th colspan="2" style="width:20%"><center>11th Monitoring</center></th>
										<th colspan="2" style="width:20%"><center>12th Monitoring</center></th>
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
		  </div>
		  <div class="modal-footer">
			<button type="button" class="btn btn-default fa fa-close" data-dismiss="modal"> Close</button>
		  </div>
	  </form>
    </div><!-- /.modal-content -->
  </div><!-- /.modal-dialog -->
</div><!-- /.modal -->


<!-- Modal for Adding of QC and QAD Monitoring -->
<div class="modal" tabindex="-1" role="dialog" id="modal_capa_qad_external_3rd_monitoring">
  <div class="modal-dialog modal-lg" role="document" style="width:98%">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
        <h4 class="modal-title fa fa-search"> CAPA Validation (Duration:3 months) ICP: QAD </h4>
      </div>
	  <form id="frm_capa_qad_external_3rd_monitoring">
		  <div class="modal-body">
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
					<input type="text" class="form-control" id="control_no" name="control_no">
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
					<select class="chosen-select" id="checked_by" name="checked_by[]" multiple style="width:100%">
					</select>
				</div>
				<div class="col-sm-2">
					<label class="fa fa-md">Conformed by: </label>
				</div>
				<div class="col-sm-4">
					<select class="chosen-select" id="conformed_by" name="conformed_by[]" multiple style="width:100%">
					</select>
				</div>
				<div class="col-sm-2">
					<label class="fa fa-md">Attachment: </label>
				</div>
				<div class="col-sm-4">
					<button type="button" class="btn btn-default fa fa-paperclip" id="file_capa_attachment" name="file_capa_attachment"> Download File</button>
				</div>
			</div>
			<br>
			<div class="panel-group" id="accordion3" role="tablist" aria-multiselectable="true">
			  <div class="panel panel-default">
				<div class="panel-heading" role="tab" id="headingOne1">
				  <h4 class="panel-title">
					<a role="button" data-toggle="collapse" data-parent="#accordion3" href="#collapseOne3" aria-expanded="false" aria-controls="collapseOne3">
					  Compliance to CAPA due date (Duration: 12 days or 2 weeks)   In-charge person: QC
					</a>
				  </h4>
				</div>
				<div id="collapseOne3" class="panel-collapse collapse" role="tabpanel" aria-labelledby="headingOne1">
				  <div class="panel-body">
					<div class="row" style="padding-top:5px;">
						<div class="col-sm-12">
							<div class="alert alert-danger" style="display:none;" role="alert" id="container_capa_compliance_due_date_message">					
							</div>
						</div>		
						<div class="col-sm-12" style="padding-top:5px;">				
							<table class="table table-bordered table-hover table-condensed table-striped" id="tbl_monitoring">
								<thead>
									<tr>
										<th rowspan="3"><center>Status</center></th>
										<th rowspan="3"><center>Correction</center></th>
										<th rowspan="3"><center>In-charge Person</center></th>
										<th rowspan="3"><center>Due Date</center></th>
										<th colspan="2" style="width:20%"><center>1st Monitoring</center></th>
										<th colspan="2" style="width:20%"><center>2nd Monitoring</center></th>
										<th colspan="2" style="width:20%"><center>3rd Monitoring</center></th>
										<th colspan="2" style="width:20%"><center>4th Monitoring</center></th>
										<th colspan="2" style="width:20%"><center>5th Monitoring</center></th>
										<th colspan="2" style="width:20%"><center>6th Monitoring</center></th>
										<th colspan="2" style="width:20%"><center>7th Monitoring</center></th>
										<th colspan="2" style="width:20%"><center>8th Monitoring</center></th>
										<th colspan="2" style="width:20%"><center>9th Monitoring</center></th>
										<th colspan="2" style="width:20%"><center>10th Monitoring</center></th>
										<th colspan="2" style="width:20%"><center>11th Monitoring</center></th>
										<th colspan="2" style="width:20%"><center>12th Monitoring</center></th>
										<th colspan="2"><center>Action</center></th>
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
			  <div class="panel panel-default">
				<div class="panel-heading" role="tab" id="headingTwo">
				  <h4 class="panel-title">
					<a class="collapsed" role="button" data-toggle="collapse" data-parent="#accordion3" href="#collapseTwo3" aria-expanded="false" aria-controls="collapseTwo3">
					  CAPA Validation  (Duration: 12 days or 2 weeks)   In-charge person: QC &QAD
					</a>
				  </h4>
				</div>
				<div id="collapseTwo3" class="panel-collapse collapse" role="tabpanel" aria-labelledby="headingTwo">
				  <div class="panel-body">
					<div class="row" style="padding-top:5px;">
						<div class="col-sm-12" style="padding-top:5px;">			
							<table class="table table-bordered table-hover table-condensed table-striped" id="tbl_monitoring2">
								<thead>
									<tr>
										<th rowspan="3"><center>Status</center></th>
										<th rowspan="3"><center>Correction</center></th>
										<th rowspan="3"><center>In-charge Person</center></th>
										<th rowspan="3"><center>Due Date</center></th>
										<th colspan="2" style="width:20%"><center>1st Monitoring</center></th>
										<th colspan="2" style="width:20%"><center>2nd Monitoring</center></th>
										<th colspan="2" style="width:20%"><center>3rd Monitoring</center></th>
										<th colspan="2" style="width:20%"><center>4th Monitoring</center></th>
										<th colspan="2" style="width:20%"><center>5th Monitoring</center></th>
										<th colspan="2" style="width:20%"><center>6th Monitoring</center></th>
										<th colspan="2" style="width:20%"><center>7th Monitoring</center></th>
										<th colspan="2" style="width:20%"><center>8th Monitoring</center></th>
										<th colspan="2" style="width:20%"><center>9th Monitoring</center></th>
										<th colspan="2" style="width:20%"><center>10th Monitoring</center></th>
										<th colspan="2" style="width:20%"><center>11th Monitoring</center></th>
										<th colspan="2" style="width:20%"><center>12th Monitoring</center></th>
										<th colspan="2"><center>Action</center></th>
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
			  <div class="panel panel-default">
				<div class="panel-heading" role="tab" id="headingThree">
				  <h4 class="panel-title">
					<a class="collapsed" role="button" data-toggle="collapse" data-parent="#accordion3" href="#collapseThree3" aria-expanded="true" aria-controls="collapseThree3">
					  CAPA Validation (Duration:3 months) ICP: QAD
					</a>
				  </h4>
				</div>
				<div id="collapseThree3" class="panel-collapse collapse in" role="tabpanel" aria-labelledby="headingThree">
				  <div class="panel-body">
					<div class="row" style="padding-top:5px;">
						<div class="col-sm-12">
							<div class="alert alert-danger" style="display:none;" role="alert" id="container_capa_compliance_due_date_message">					
							</div>
						</div>		
						<div class="col-sm-12" style="padding-top:5px;">
							<button type="button" class="btn btn-primary pull-right fa fa-plus" id="btn_add_validation"> Add</button>					
							<table class="table table-bordered table-hover table-condensed table-striped" id="tbl_monitoring3">
								<thead>
									<tr>
										<th rowspan="3" style="width:4%"><center>Status</center></th>
										<th rowspan="3" style="width:14%"><center>Correction</center></th>
										<th rowspan="3" style="width:6%"><center>In-charge Person</center></th>
										<th rowspan="3" style="width:5%"><center>Due Date</center></th>
										<th colspan="2" style="width:6%"><center>1st Monitoring</center></th>
										<th colspan="2" style="width:6%"><center>2nd Monitoring</center></th>
										<th colspan="2" style="width:6%"><center>3rd Monitoring</center></th>
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
			
						
			
		  </div>
		  <div class="modal-footer">
			<button type="button" class="btn btn-default fa fa-close" data-dismiss="modal"> Close</button>
		  </div>
	  </form>
    </div><!-- /.modal-content -->
  </div><!-- /.modal-dialog -->
</div><!-- /.modal -->

<!-- Modal for Edit of QC and QAD Monitoring -->
<div class="modal" tabindex="-1" role="dialog" id="modal_capa_qad_external_3rd_monitoring_edit">
  <div class="modal-dialog modal-lg" role="document" style="width:98%">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
        <h4 class="modal-title fa fa-search"> CAPA Validation (Duration:3 months) ICP: QAD </h4>
      </div>
	  <form id="frm_capa_qad_external_3rd_monitoring_edit">
		  <div class="modal-body">
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
					<input type="text" class="form-control" id="control_no" name="control_no">
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
					<select class="chosen-select" id="checked_by" name="checked_by[]" multiple style="width:100%">
					</select>
				</div>
				<div class="col-sm-2">
					<label class="fa fa-md">Conformed by: </label>
				</div>
				<div class="col-sm-4">
					<select class="chosen-select" id="conformed_by" name="conformed_by[]" multiple style="width:100%">
					</select>
				</div>
				<div class="col-sm-2">
					<label class="fa fa-md">Attachment: </label>
				</div>
				<div class="col-sm-4">
					<button type="button" class="btn btn-default fa fa-paperclip" id="file_capa_attachment" name="file_capa_attachment"> Download File</button>
				</div>
			</div>
			<br>
			<div class="panel-group" id="accordion4" role="tablist" aria-multiselectable="true">
			  <div class="panel panel-default">
				<div class="panel-heading" role="tab" id="headingOne4">
				  <h4 class="panel-title">
					<a role="button" data-toggle="collapse" data-parent="#accordion4" href="#collapseOne4" aria-expanded="false" aria-controls="collapseOne4">
					  Compliance to CAPA due date (Duration: 12 days or 2 weeks)   In-charge person: QC
					</a>
				  </h4>
				</div>
				<div id="collapseOne4" class="panel-collapse collapse" role="tabpanel" aria-labelledby="headingOne4">
				  <div class="panel-body">
					<div class="row" style="padding-top:5px;">
						<div class="col-sm-12">
							<div class="alert alert-danger" style="display:none;" role="alert" id="container_capa_compliance_due_date_message">					
							</div>
						</div>		
						<div class="col-sm-12" style="padding-top:5px;">				
							<table class="table table-bordered table-hover table-condensed table-striped" id="tbl_monitoring">
								<thead>
									<tr>
										<th rowspan="3"><center>Status</center></th>
										<th rowspan="3"><center>Correction</center></th>
										<th rowspan="3"><center>In-charge Person</center></th>
										<th rowspan="3"><center>Due Date</center></th>
										<th colspan="2" style="width:20%"><center>1st Monitoring</center></th>
										<th colspan="2" style="width:20%"><center>2nd Monitoring</center></th>
										<th colspan="2" style="width:20%"><center>3rd Monitoring</center></th>
										<th colspan="2" style="width:20%"><center>4th Monitoring</center></th>
										<th colspan="2" style="width:20%"><center>5th Monitoring</center></th>
										<th colspan="2" style="width:20%"><center>6th Monitoring</center></th>
										<th colspan="2" style="width:20%"><center>7th Monitoring</center></th>
										<th colspan="2" style="width:20%"><center>8th Monitoring</center></th>
										<th colspan="2" style="width:20%"><center>9th Monitoring</center></th>
										<th colspan="2" style="width:20%"><center>10th Monitoring</center></th>
										<th colspan="2" style="width:20%"><center>11th Monitoring</center></th>
										<th colspan="2" style="width:20%"><center>12th Monitoring</center></th>
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
			  <div class="panel panel-default">
				<div class="panel-heading" role="tab" id="headingTwo4">
				  <h4 class="panel-title">
					<a class="collapsed" role="button" data-toggle="collapse" data-parent="#accordion3" href="#collapseTwo4" aria-expanded="false" aria-controls="collapseTwo4">
					  CAPA Validation  (Duration: 12 days or 2 weeks)   In-charge person: QC &QAD
					</a>
				  </h4>
				</div>
				<div id="collapseTwo4" class="panel-collapse collapse" role="tabpanel" aria-labelledby="headingTwo4">
				  <div class="panel-body">
					<div class="row" style="padding-top:5px;">
						<div class="col-sm-12" style="padding-top:5px;">			
							<table class="table table-bordered table-hover table-condensed table-striped" id="tbl_monitoring2">
								<thead>
									<tr>
										<th rowspan="3"><center>Status</center></th>
										<th rowspan="3"><center>Correction</center></th>
										<th rowspan="3"><center>In-charge Person</center></th>
										<th rowspan="3"><center>Due Date</center></th>
										<th colspan="2" style="width:20%"><center>1st Monitoring</center></th>
										<th colspan="2" style="width:20%"><center>2nd Monitoring</center></th>
										<th colspan="2" style="width:20%"><center>3rd Monitoring</center></th>
										<th colspan="2" style="width:20%"><center>4th Monitoring</center></th>
										<th colspan="2" style="width:20%"><center>5th Monitoring</center></th>
										<th colspan="2" style="width:20%"><center>6th Monitoring</center></th>
										<th colspan="2" style="width:20%"><center>7th Monitoring</center></th>
										<th colspan="2" style="width:20%"><center>8th Monitoring</center></th>
										<th colspan="2" style="width:20%"><center>9th Monitoring</center></th>
										<th colspan="2" style="width:20%"><center>10th Monitoring</center></th>
										<th colspan="2" style="width:20%"><center>11th Monitoring</center></th>
										<th colspan="2" style="width:20%"><center>12th Monitoring</center></th>
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
			  <div class="panel panel-default">
				<div class="panel-heading" role="tab" id="headingThree4">
				  <h4 class="panel-title">
					<a class="collapsed" role="button" data-toggle="collapse" data-parent="#accordion3" href="#collapseThree5" aria-expanded="true" aria-controls="collapseThree5">
					  CAPA Validation (Duration:3 months) ICP: QAD
					</a>
				  </h4>
				</div>
				<div id="collapseThree5" class="panel-collapse collapse in" role="tabpanel" aria-labelledby="headingThree4">
				  <div class="panel-body">
					<div class="row" style="padding-top:5px;">
						<div class="col-sm-12">
							<div class="alert alert-danger" style="display:none;" role="alert" id="container_capa_compliance_due_date_message">					
							</div>
						</div>		
						<div class="col-sm-12" style="padding-top:5px;">
							<table class="table table-bordered table-hover table-condensed table-striped" id="tbl_monitoring3">
								<thead>
									<tr>
										<th rowspan="3" style="width:4%"><center>Status</center></th>
										<th rowspan="3" style="width:14%"><center>Correction</center></th>
										<th rowspan="3" style="width:6%"><center>In-charge Person</center></th>
										<th rowspan="3" style="width:5%"><center>Due Date</center></th>
										<th colspan="2" style="width:20%"><center>1st Monitoring</center></th>
										<th colspan="2" style="width:20%"><center>2nd Monitoring</center></th>
										<th colspan="2" style="width:20%"><center>3rd Monitoring</center></th>
										<th colspan="2" style="width:6%"><center>Action</center></th>
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
			
						
			
		  </div>
		  <div class="modal-footer">
			<button type="button" class="btn btn-default fa fa-close" data-dismiss="modal"> Close</button>
		  </div>
	  </form>
    </div><!-- /.modal-content -->
  </div><!-- /.modal-dialog -->
</div><!-- /.modal -->

<!-- Modal for system message -->
<div class="modal" tabindex="-1" role="dialog" id="modal_capa_system_message">
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