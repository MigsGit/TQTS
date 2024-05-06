<?php
/* get user role for Production - MH*/
$etr_production_mh_access 	    = array("create" => false, 
									"read" => false,
									"update" => false,
									"delete" => false
									);
$subsystem_code 			= "ETR";
$module 					= "ETR-Production(MH) Section";
foreach($user_role['subsystem_code'] as $key => $subsystem_code2 ){
	if($subsystem_code == $subsystem_code2 && $user_role['module'][$key] == $module){ 
		if ($user_role['create'][$key] == 1){
			$etr_production_mh_access['create'] = true;
		}
		if ($user_role['read'][$key] == 1){
			$etr_production_mh_access['read'] = true;
		}
		if ($user_role['update'][$key] == 1){
			$etr_production_mh_access['update'] = true;
		}
		if ($user_role['delete'][$key] == 1){
			$etr_production_mh_access['delete'] = true;
		}
	}
}
/* get user role for Production - Approver */
$etr_production_app_access 	    = array("create" => false, 
									"read" => false,
									"update" => false,
									"delete" => false
									);
$subsystem_code 			= "ETR";
$module 					= "ETR-Production(App) Section";
foreach($user_role['subsystem_code'] as $key => $subsystem_code2 ){
	if($subsystem_code == $subsystem_code2 && $user_role['module'][$key] == $module){ 
		if ($user_role['create'][$key] == 1){
			$etr_production_app_access['create'] = true;
		}
		if ($user_role['read'][$key] == 1){
			$etr_production_app_access['read'] = true;
		}
		if ($user_role['update'][$key] == 1){
			$etr_production_app_access['update'] = true;
		}
		if ($user_role['delete'][$key] == 1){
			$etr_production_app_access['delete'] = true;
		}
	}
}

/* get user role for Engineering */
$etr_engineering_access 	    = array("create" => false, 
									"read" => false,
									"update" => false,
									"delete" => false
									);
$subsystem_code 			= "ETR";
$module 					= "ETR-Engineering Section";
foreach($user_role['subsystem_code'] as $key => $subsystem_code2 ){
	if($subsystem_code == $subsystem_code2 && $user_role['module'][$key] == $module){ 
		if ($user_role['create'][$key] == 1){
			$etr_engineering_access['create'] = true;
		}
		if ($user_role['read'][$key] == 1){
			$etr_engineering_access['read'] = true;
		}
		if ($user_role['update'][$key] == 1){
			$etr_engineering_access['update'] = true;
		}
		if ($user_role['delete'][$key] == 1){
			$etr_engineering_access['delete'] = true;
		}
	}
}

/* get user role for Engineering Approver*/
$etr_engineering_app_access = array("create" => false, 
									"read" => false,
									"update" => false,
									"delete" => false
									);
$subsystem_code 			= "ETR";
$module 					= "ETR-Engineering Approver";
foreach($user_role['subsystem_code'] as $key => $subsystem_code2 ){
	if($subsystem_code == $subsystem_code2 && $user_role['module'][$key] == $module){ 
		if ($user_role['create'][$key] == 1){
			$etr_engineering_app_access['create'] = true;
		}
		if ($user_role['read'][$key] == 1){
			$etr_engineering_app_access['read'] = true;
		}
		if ($user_role['update'][$key] == 1){
			$etr_engineering_app_access['update'] = true;
		}
		if ($user_role['delete'][$key] == 1){
			$etr_engineering_app_access['delete'] = true;
		}
	}
}

/* get user role for QC */
$etr_qc_access 	    = array("create" => false, 
									"read" => false,
									"update" => false,
									"delete" => false
									);
$subsystem_code 			= "ETR";
$module 					= "ETR-QC Section";
foreach($user_role['subsystem_code'] as $key => $subsystem_code2 ){
	if($subsystem_code == $subsystem_code2 && $user_role['module'][$key] == $module){ 
		if ($user_role['create'][$key] == 1){
			$etr_qc_access['create'] = true;
		}
		if ($user_role['read'][$key] == 1){
			$etr_qc_access['read'] = true;
		}
		if ($user_role['update'][$key] == 1){
			$etr_qc_access['update'] = true;
		}
		if ($user_role['delete'][$key] == 1){
			$etr_qc_access['delete'] = true;
		}
	}
}

/* get user role for QC Approver*/
$etr_qc_app_access 	    = array("create" => false, 
									"read" => false,
									"update" => false,
									"delete" => false
									);
$subsystem_code 			= "ETR";
$module 					= "ETR-QC Approver";
foreach($user_role['subsystem_code'] as $key => $subsystem_code2 ){
	if($subsystem_code == $subsystem_code2 && $user_role['module'][$key] == $module){ 
		if ($user_role['create'][$key] == 1){
			$etr_qc_app_access['create'] = true;
		}
		if ($user_role['read'][$key] == 1){
			$etr_qc_app_access['read'] = true;
		}
		if ($user_role['update'][$key] == 1){
			$etr_qc_app_access['update'] = true;
		}
		if ($user_role['delete'][$key] == 1){
			$etr_qc_app_access['delete'] = true;
		}
	}
}

/* get user role for Training Unit */
$etr_training_head_access 	    = array("create" => false, 
									"read" => false,
									"update" => false,
									"delete" => false
									);
$subsystem_code 			= "ETR";
$module 					= "ETR-Training Unit";
foreach($user_role['subsystem_code'] as $key => $subsystem_code2 ){
	if($subsystem_code == $subsystem_code2 && $user_role['module'][$key] == $module){ 
		if ($user_role['create'][$key] == 1){
			$etr_training_head_access['create'] = true;
		}
		if ($user_role['read'][$key] == 1){
			$etr_training_head_access['read'] = true;
		}
		if ($user_role['update'][$key] == 1){
			$etr_training_head_access['update'] = true;
		}
		if ($user_role['delete'][$key] == 1){
			$etr_training_head_access['delete'] = true;
		}
	}
}

/* get user role for Training Record */
$etr_tr_access 	    = array("create" => false, 
									"read" => false,
									"update" => false,
									"delete" => false
									);
$subsystem_code 			= "ETR";
$module 					= "ETR Records";
foreach($user_role['subsystem_code'] as $key => $subsystem_code2 ){
	if($subsystem_code == $subsystem_code2 && $user_role['module'][$key] == $module){ 
		if ($user_role['create'][$key] == 1){
			$etr_tr_access['create'] = true;
		}
		if ($user_role['read'][$key] == 1){
			$etr_tr_access['read'] = true;
		}
		if ($user_role['update'][$key] == 1){
			$etr_tr_access['update'] = true;
		}
		if ($user_role['delete'][$key] == 1){
			$etr_tr_access['delete'] = true;
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
				if($etr_production_mh_access['read']){
					echo '<li role="presentation" class="'.$class_active.'"><a href="#etr_production" aria-controls="etr_production" role="tab" data-toggle="tab">Production(MH) Section</a></li>';
					$class_active = '';
				}
				if($etr_production_app_access['read']){
					echo '<li role="presentation" class="'.$class_active.'"><a href="#etr_production_app" aria-controls="etr_production_app" role="tab" data-toggle="tab">Production(Approver) Section</a></li>';
					$class_active = '';
				}
				if($etr_engineering_access['read']){
					echo '<li role="presentation" class="'.$class_active.'"><a href="#etr_engineering" aria-controls="etr_engineering" role="tab" data-toggle="tab">Engineering Section</a></li>';
					$class_active = '';
				}
				if($etr_engineering_app_access['read']){
					echo '<li role="presentation" class="'.$class_active.'"><a href="#etr_engineering_app" aria-controls="etr_engineering_app" role="tab" data-toggle="tab">Engr (Approver) Section</a></li>';
					$class_active = '';
				}
				if($etr_qc_access['read']){
					echo '<li role="presentation" class="'.$class_active.'"><a href="#etr_qc" aria-controls="etr_qc" role="tab" data-toggle="tab">Quality Control Section</a></li>';
					$class_active = '';
				}
				if($etr_qc_app_access['read']){
					echo '<li role="presentation" class="'.$class_active.'"><a href="#etr_qc_app" aria-controls="etr_qc_app" role="tab" data-toggle="tab">QC (Approver) Section</a></li>';
					$class_active = '';
				}
				if($etr_training_head_access['read']){
					echo '<li role="presentation" class="'.$class_active.'"><a href="#etr_th" aria-controls="etr_th" role="tab" data-toggle="tab">Training Unit</a></li>';
					$class_active = '';
				}
				if($etr_tr_access['read']){
					echo '<li role="presentation" class="'.$class_active.'"><a href="#etr_er" aria-controls="etr_er" role="tab" data-toggle="tab">Employee Records</a></li>';
					echo '<li role="presentation" class=""><a href="#etr_tr" aria-controls="etr_tr" role="tab" data-toggle="tab">Training Records</a></li>';
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
		if($etr_production_mh_access['read']){
			echo '<div role="tabpanel" class="tab-pane '.$class_active.'" id="etr_production">	
					<div class="col-sm-12">
						<div class="panel panel-info">
							<div class="panel-heading"><i class="fa fa-puzzle-piece fa-lg"> Material Handler</i></div>
							<div class="panel-body">
								<div class="row">
									<div class="col-sm-6">
										<!-- <button class="btn btn-default fa" id="btn_oqc_lon_search_main"><i class="fa fa-search"></i> Search</button> -->
									</div>
									<div class="col-sm-6">';
										if($etr_production_mh_access['create']){
											echo '<button class="btn btn-primary fa pull-right" id="btn_etr_new"><i class="fa fa-plus"></i> NEW</button>';
										}
									echo '</div>
								</div>
								<div class="row">
									<div class="col-sm-12"><br />
										<table class="table table-striped table-bordered table-condensed" id="tbl_etr_production">
											<thead>
												<th>Status</th>
												<th>Control No.</th>
												<th>Title</th>
												<th>Line</th>
												<th>Series Name</th>
												<!--<th>Reason Certification</th>-->
												<th>Training Date</th>
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
		if($etr_production_app_access['read']){
			echo '<div role="tabpanel" class="tab-pane '.$class_active.'" id="etr_production_app">	
					<div class="col-sm-12">
						<div class="panel panel-info">
							<div class="panel-heading"><i class="fa fa-puzzle-piece fa-lg"> Production Approver</i></div>
							<div class="panel-body">
								<div class="row">
									<div class="col-sm-12"><br />
										<table class="table table-striped table-bordered table-condensed" id="tbl_etr_production_app">
											<thead>
												<th>Status</th>
												<th>Control No.</th>
												<th>Title</th>
												<th>Line</th>
												<th>Series Name</th>
												<!--<th>Reason Certification</th>-->
												<th>Training Date</th>
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
		
		if($etr_engineering_access['read']){
			echo '<div role="tabpanel" class="tab-pane '.$class_active.'" id="etr_engineering">	
					<div class="col-sm-12">
						<div class="panel panel-info">
							<div class="panel-heading"><i class="fa fa-puzzle-piece fa-lg"> Engineering Section</i></div>
							<div class="panel-body">
								<div class="row">
									<div class="col-sm-6">
										<!-- <button class="btn btn-default fa" id="btn_oqc_lon_search_main"><i class="fa fa-search"></i> Search</button> -->
									</div>
								</div>
								<div class="row">
									<div class="col-sm-12"><br />
										<table class="table table-striped table-bordered table-condensed" id="tbl_etr_engineering">
											<thead>
												<th>Status</th>
												<th>Control No.</th>
												<th>Title</th>
												<th>Line</th>
												<th>Series Name</th>
												<!--<th>Reason Certification</th>-->
												<th>Training Date</th>
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
		if($etr_engineering_app_access['read']){
			echo '<div role="tabpanel" class="tab-pane '.$class_active.'" id="etr_engineering_app">	
					<div class="col-sm-12">
						<div class="panel panel-info">
							<div class="panel-heading"><i class="fa fa-puzzle-piece fa-lg"> Engineering Approver</i></div>
							<div class="panel-body">
								<div class="row">
									<div class="col-sm-6">
										<!-- <button class="btn btn-default fa" id="btn_oqc_lon_search_main"><i class="fa fa-search"></i> Search</button> -->
									</div>
								</div>
								<div class="row">
									<div class="col-sm-12"><br />
										<table class="table table-striped table-bordered table-condensed" id="tbl_etr_engineering_app">
											<thead>
												<th>Status</th>
												<th>Control No.</th>
												<th>Title</th>
												<th>Line</th>
												<th>Series Name</th>
												<!--<th>Reason Certification</th>-->
												<th>Training Date</th>
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
				
		if($etr_qc_access['read']){
			echo '<div role="tabpanel" class="tab-pane '.$class_active.'" id="etr_qc">	
					<div class="col-sm-12">
						<div class="panel panel-info">
							<div class="panel-heading"><i class="fa fa-puzzle-piece fa-lg"> Quality Control Section</i></div>
							<div class="panel-body">
								<div class="row">
									<div class="col-sm-6">
										<!-- <button class="btn btn-default fa" id="btn_oqc_lon_search_main"><i class="fa fa-search"></i> Search</button> -->
									</div>
								</div>
								<div class="row">
									<div class="col-sm-12"><br />
										<table class="table table-striped table-bordered table-condensed" id="tbl_etr_qc">
											<thead>
												<th>Status</th>
												<th>Control No.</th>
												<th>Title</th>
												<th>Line</th>
												<th>Series Name</th>
												<!--<th>Reason Certification</th>-->
												<th>Training Date</th>
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
				
		if($etr_qc_app_access['read']){
			echo '<div role="tabpanel" class="tab-pane '.$class_active.'" id="etr_qc_app">	
					<div class="col-sm-12">
						<div class="panel panel-info">
							<div class="panel-heading"><i class="fa fa-puzzle-piece fa-lg"> Quality Control Approver</i></div>
							<div class="panel-body">
								<div class="row">
									<div class="col-sm-6">
										<!-- <button class="btn btn-default fa" id="btn_oqc_lon_search_main"><i class="fa fa-search"></i> Search</button> -->
									</div>
								</div>
								<div class="row">
									<div class="col-sm-12"><br />
										<table class="table table-striped table-bordered table-condensed" id="tbl_etr_qc_app">
											<thead>
												<th>Status</th>
												<th>Control No.</th>
												<th>Title</th>
												<th>Line</th>
												<th>Series Name</th>
												<!--<th>Reason Certification</th>-->
												<th>Training Date</th>
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
			
		if($etr_training_head_access['read']){
			echo '<div role="tabpanel" class="tab-pane '.$class_active.'" id="etr_th">	
					<div class="col-sm-12">
						<div class="panel panel-info">
							<div class="panel-heading"><i class="fa fa-puzzle-piece fa-lg"> Training Unit</i></div>
							<div class="panel-body">
								<div class="row">
									<div class="col-sm-6">
										<!-- <button class="btn btn-default fa" id="btn_oqc_lon_search_main"><i class="fa fa-search"></i> Search</button> -->
									</div>
								</div>
								<div class="row">
									<div class="col-sm-12"><br />
										<table class="table table-striped table-bordered table-condensed" id="tbl_etr_th">
											<thead>
												<th>Status</th>
												<th>Control No.</th>
												<th>Title</th>
												<th>Line</th>
												<th>Series Name</th>
												<th>Period</th>
												<th>Instructor</th>
												<th>Venue</th>
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
		
		if($etr_tr_access['read']){
			echo '<div role="tabpanel" class="tab-pane '.$class_active.'" id="etr_er">	
					<div class="col-sm-12" id="container_emp_records">
						<div class="panel panel-info">
							<!-- <div class="panel-heading"><i class="fa fa-puzzle-piece fa-lg"> Employee Records</i></div> -->
							<div class="panel-body">
								<div class="row">									
									<div class="col-sm-8">
										<label class="fa fa-md" style="padding-right:3px;display:inline-block;" >Search by: </label>	
										<select class="form-control" id="search_by" name="search_by" style="width:20%;display:inline-block;">
											<option value="EmpNo">Emp. No.</option>
											<option value="EmpName">Employee Name</option>
											<option value="FirstName">First Name</option>
											<option value="LastName">Last Name</option>
											<option value="MiddleName">Middle Name</option>
											<option value="Position">Position</option>
											<option value="Department">Department</option>
											<option value="Section">Section</option>
										</select>
										<label class="fa fa-md" style="padding-right:3px;display:inline-block;"> for </label>
										<datalist id="dl_search_for">
										</datalist>
										<input type="text" class="form-control" id="search_for" name="search_for" list="dl_search_for" style="width:30%;display:inline-block;" list="dl_search_for">
									</div>
									<div class="col-sm-4">
										<div class="funkyradio">
											<div class="funkyradio-success" style="display: inline-block;padding-right:10px;width:45%;">
												<input type="radio" name="emp_type" id="rbtn_pmi" value="db_hris." checked>
												<label for="rbtn_pmi"> Pricon Hired </label>
											</div>
											<div class="funkyradio-success" style="display: inline-block;padding-right:10px;width:45%;">
												<input type="radio" name="emp_type" id="rbtn_sub" value="db_subcon.">
												<label for="rbtn_sub"> Subcon Hired </label>
											</div>
										</div>
									</div>
									<div class="col-sm-12"><br />
										<table class="table table-striped table-bordered table-condensed" id="tbl_etr_er">
											<thead>
												<th style="10%">Employee #</th>
												<th style="20%">Last Name</th>
												<th style="20%">First Name</th>
												<th style="10%">Middle Name</th>
												<th style="15%">Position</th>
												<th style="15%">Department</th>
												<th style="15%">Action</th>
											</thead>
										</table>
									</div>
									<div class="col-sm-12">
										<label class="fa fa-md" style="padding-right:3px;display:inline-block;" >**Resigned employees </label>
									</div>									
								</div>
							</div>
						</div>
					</div>
					<div class="col-sm-12" style="display:none;" id="container_emp_data">
						<div class="panel panel-default">
							<div class="panel-heading">
								<label> Employee Training Records</label>
							</div>
							<div class="panel-body">
								<div class="row">					
									<div class="col-sm-12">
										<button type="button" class="btn btn-default fa fa-home"> Back</button>
									</div>
								</div>
								<div class="row" style="margin-top:5px;">
									<div class="col-sm-12">
										<form id="frm_emp_info">
										<div class="panel panel-default">
											<div class="panel-heading">
												<label> Employee Information</label>
											</div>
											<div class="panel-body form-inline">
												<div class="row ">	
													<div class="col-sm-2">
														<label class="control-label condensed"> Name: </label>
													</div>
													<div class="col-sm-4">
														<input type="text" class="form-control" name="EmpName" id="EmpName" style="width:100%" readonly>
													</div>
													<div class="col-sm-2">
														<label class="control-label condensed"> Emp No.: </label>
													</div>
													<div class="col-sm-4">
														<input type="text" class="form-control" name="EmpNo" id="EmpNo" style="width:100%" readonly>
													</div>
												</div>
												<div class="row">	
													<div class="col-sm-2">
														<label class="control-label condensed"> Division: </label>
													</div>
													<div class="col-sm-4">
														<input type="text" class="form-control" name="Division" id="Division" style="width:100%" readonly>
													</div>
													<div class="col-sm-2">
														<label class="control-label condensed"> Department: </label>
													</div>
													<div class="col-sm-4">
														<input type="text" class="form-control" name="Department" id="Department" style="width:100%" readonly>
													</div>
												</div>
												<div class="row">	
													<div class="col-sm-2">
														<label class="control-label condensed"> Section: </label>
													</div>
													<div class="col-sm-4">
														<input type="text" class="form-control" name="Section" id="Section" style="width:100%" readonly>
													</div>
													<div class="col-sm-2">								
														<label class="control-label condensed"> Position: </label>
													</div>
													<div class="col-sm-4">
														<input type="text" class="form-control" name="Position" id="Position" style="width:100%" readonly>
													</div>
												</div>
												<div class="row">	
													<div class="col-sm-2">
														<label class="control-label condensed"> Employment Status: </label>
													</div>
													<div class="col-sm-4">
														<input type="text" class="form-control" name="EmpStatus" id="EmpStatus" style="width:100%" readonly>
													</div>	
												</div>
												<div class="row">	
													<div class="col-sm-2">
														<label class="control-label condensed"> Date Hired: </label>
													</div>
													<div class="col-sm-4">
														<input type="text" class="form-control" name="DateHired" id="DateHired" style="width:100%" readonly>
													</div>
													<div class="col-sm-2">
														<label class="control-label condensed"> Hiring Status: </label>
													</div>
													<div class="col-sm-4">
														<input type="text" class="form-control" name="HiringStatus" id="HiringStatus" style="width:100%" readonly>
													</div>
												</div>
											</div>
										</form>
										</div>
									</div>
								</div>
								
								<div class="block-content-inner">
									<div class="panel-group" id="accordion">
										<div class="panel panel-default">
											<div class="panel-heading">
												<h4 class="panel-title">
													<a data-toggle="collapse" data-parent="#accordion" href="#collapseTwo" class="collapsed" aria-expanded="false">
														Training/s Attended
													</a>
												</h4>
											</div>
											<div id="collapseTwo" class="panel-collapse collapse in" aria-expanded="false" style="height: 0px;">
												<div class="panel-body">
													<div class="row">
														<div class="col-sm-12">
															<table class="table table-bordered table-condensed" id="tbl_emp_trainings">
																<thead>
																	<th><center>Date</center></th>
																	<th><center>Title</center></th>
																	<th><center>Objective</center></th>
																	<th><center>Trainor</center></th>
																	<th><center>Results</center></th>
																	<th><center>Venue</center></th>
																	<th><center>Mechanics</center></th>
																	<th><center>Type of Training</center></th>
																	<th><center>Remarks</center></th>
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
							</div>
						</div>
					</div>
				</div>';
			
			echo '<div role="tabpanel" class="tab-pane '.$class_active.'" id="etr_tr">	
					<div class="col-sm-12">
						<div class="panel panel-info">
							<div class="panel-heading"><i class="fa fa-puzzle-piece fa-lg"> TQTS Training Records</i></div>
							<div class="panel-body">
								<div class="row">									
									<div class="col-sm-12">
										<label class="fa fa-md" style="padding-right:3px;display:inline-block;" >Group by: </label>	
										<select class="form-control" id="group_by" name="group_by" style="width:15%;display:inline-block;">
											<option value="line">Line</option>
											<option value="series_name">Series Name</option>
										</select>										
										<label class="fa fa-md" style="padding-right:3px;display:inline-block;"> of </label>
										<datalist id="dl_group_by_val">
										</datalist>
										<input type="text" class="form-control" id="group_by_val" name="group_by_val" style="width:20%;display:inline-block;" list="dl_group_by_val">
										<label class="fa fa-md" style="padding-right:3px;display:inline-block;" >Date from: </label>	
										<input type="date" class="form-control" id="date_from" name="date_from" style="width:20%;display:inline-block;">
										<label class="fa fa-md" style="padding-right:3px;display:inline-block;"> to </label>
										<input type="date" class="form-control" id="date_to" name="date_to" style="width:20%;display:inline-block;">
										<button class="btn btn-success fa fa-file-excel-o" id="btn_export_training_records"> Export</button>
									</div>
								</div>
								<div class="row">
									<div class="col-sm-12"><br />
										<table class="table table-striped table-bordered table-condensed" id="tbl_etr_tr">
											<thead>
												<th>Status</th>
												<th>Title</th>
												<th>Period</th>
												<th>Instructor</th>
												<th>Series Name</th>
												<th>Line</th>
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
<div class="modal fade" tabindex="-1" role="dialog" id="modal_etr_production_new">
  <div class="modal-dialog modal-lg" role="document" style="width:70%;">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
        <h4 class="modal-title"><i class="fa fa-upload"></i> New Training / Qualification / Certification</h4>
      </div>
	  <div class="modal-body" style="overflow:inherit;">
		 <form id="frm_etr_production_new">
			<div class="profile-info-title h4" style="padding-bottom:5px;">
				<span class="fa fa-plus-circle"></span> Production Section (Training and Orientation)
			</div>
			<div class="row" style="margin-top:5px;">
				<div class="col-sm-2">
					<label class="fa fa-md">Training Title: </label>
				</div>
				<div class="col-sm-4">
					<datalist id="dl_training_title">
					</datalist>
					<input type="text" class="form-control" id="training_title" name="training_title" list="dl_training_title">
				</div>
				<div class="col-sm-2">
					<label class="fa fa-md">Control No.: </label>
				</div>
				<div class="col-sm-4">
					<input type="text" class="form-control" id="control_no" name="control_no" readonly>
				</div>
			</div>
			<div class="row">
				<div class="col-sm-2">
					<label class="fa fa-md">Objective: </label>
				</div>
				<div class="col-sm-10">
					<textarea class="form-control" id="training_objective" name="training_objective"></textarea>
				</div>
			</div>
			<div class="row" style="margin-top:5px;">
				<div class="col-sm-2">
					<label class="fa fa-md">Mechanics: </label>
				</div>
				<div class="col-sm-4">
					<datalist id="dl_training_mechanics">
					</datalist>
					<input type="text" class="form-control" id="mechanics" name="mechanics" list="dl_training_mechanics">
				</div>
				<div class="col-sm-2">
					<label class="fa fa-md">Type of Training: </label>
				</div>
				<div class="col-sm-4">
					<datalist id="dl_type_of_training">
					</datalist>
					<input type="text" class="form-control" id="type_of_training" name="type_of_training" list="dl_type_of_training">
				</div>
				<div class="col-sm-2">
					<label class="fa fa-md">Venue: </label>
				</div>
				<div class="col-sm-4">
					<datalist id="dl_training_venue">
					</datalist>
					<input type="text" class="form-control" id="venue" name="venue" list="dl_training_venue">
				</div>
				<div class="col-sm-2">
					<label class="fa fa-md">Line: </label>
				</div>
				<div class="col-sm-4">
					<input type="text" class="form-control" id="line" name="line">
				</div>
			</div>
			<div class="row">
				<div class="col-sm-2">
					<label class="fa fa-md">Series Name: </label>
				</div>
				<div class="col-sm-4">
					<input type="text" class="form-control" id="series_name" name="series_name">
				</div>
			</div>
			<div class="row">
				<div class="col-sm-2">
					<label class="fa fa-md">Reason for Certification: </label>
				</div>
				<div class="col-sm-10" id="container_reason_certification">
				</div>
			</div>
			<div class="row" id="container_reason_certification_others">
				<div class="col-sm-2 col-sm-offset-2">
					<label class="fa fa-md">Others (please specify): </label>
				</div>
				<div class="col-sm-8" id="container_reason_certification_others">
                    <input type="text" class="form-control" id="reason_certification_others" name="reason_certification_others">
				</div>
			</div>
			<div class="row" style="padding-top:5px;">
				<div class="col-sm-2">
					<label class="fa fa-md">Training Category: </label>
				</div>
				<div class="col-sm-10" id="container_training_category">
				</div>
			</div><br>
			<hr class="graph-orange" style="margin-top:0px;">
			<div class="profile-info-title h4" style="padding-top:5px;">
				<span class="fa fa-th-list"></span> Operator List
			</div>
			<div class="row">
				<div class="col-sm-12">
					<div class="alert alert-danger" style="display:none;" role="alert" id="container_etr_production_new_message">					
					</div>
				</div>				
				<div class="col-sm-3 col-sm-offset-9">
                    <button type="button" class="btn btn-primary fa pull-right fa fa-plus"> Add</button>
                </div>
				<div class="col-sm-12" style="padding-top:5px;">
					<table class="table table-bordered table-hover table-condensed table-striped" id="tbl_operator_list">
                        <thead>
                            <tr>
                                <th rowspan="2" style="width:25%"><center>Operator Name</center></th>
                                <th rowspan="2" style="width:14%"><center>Emp No.</center></th>
                                <th rowspan="2" style="width:18%"><center>Station From</center></th>
                                <th rowspan="2" style="width:18%"><center>Station To</center></th>
                                <th colspan="2" style="width:18%"><center>Result</center></th>
                                <th rowspan="2" style="width:7%"><center>Remove</center></th>
                            </tr>
                            <tr>
                                <th><center>1st Take</center></th>
                                <th><center>2nd Take</center></th>
                            </tr>
                        </thead>
                        <tbody>
                        </tbody>
                    </table>
				</div>
			</div>
			<hr class="graph-orange" style="margin-top:0px;">
			<div class="profile-info-title h4" style="padding-bottom:5px;">
				<span class="fa fa-pencil-square-o"></span> Trainer/s
			</div>
			<div class="row" style="margin-top:5px;">
				<div class="col-sm-2">
					<label class="fa fa-md">Trained by: (1st Take) </label>
				</div>
				<div class="col-sm-4">
					<select class="" id="prdn_first_take_trained_by" name="prdn_first_take_trained_by" style="width:100%;">
					</select>
				</div>
				<div class="col-sm-2">
					<label class="fa fa-md">Date / Time: </label>
				</div>
				<div class="col-sm-4">
					<input type="datetime-local" class="form-control" id="prdn_first_take_date_time" name="prdn_first_take_date_time" min="<?php echo date('Y-m-d'); ?>" style="100%">
				</div>
             </div>
			 <div id="div_prdn_second_take">
				<div class="row" style="margin-top:5px;">
					<div class="col-sm-2">
						<label class="fa fa-md">Trained by: (2nd Take) </label>
					</div>
					<div class="col-sm-4">
						<select class="" id="prdn_second_take_trained_by" name="prdn_second_take_trained_by" style="width:100%;">
						</select>
					</div>
					<div class="col-sm-2">
						<label class="fa fa-md">Date / Time: </label>
					</div>
					<div class="col-sm-4">
						<input type="datetime-local" class="form-control" id="prdn_second_take_date_time" name="prdn_second_take_date_time" min="<?php echo date('Y-m-d'); ?>" style="100%">
					</div>
				 </div>
			 </div>
			<div class="row" style="margin-top:5px;">
				<div class="col-sm-2">
					<label class="fa fa-md">Engineering Section: </label>
				</div>
				<div class="col-sm-4">
					<select class="" id="eng_first_take_qualified_by" name="eng_first_take_qualified_by[]" multiple="multiple" style="width:100%;">
					</select>
				</div>
				<div class="col-sm-2">
					<label class="fa fa-md">Quality Control Section: </label>
				</div>
				<div class="col-sm-4">
					<select class="" id="qc_first_take_certified_by" name="qc_first_take_certified_by[]" multiple="multiple" style="width:100%;">
					</select>
				</div>
			</div>
			<hr class="graph-orange" style="margin-top:5px;">
			<div class="row" style="margin-top:5px;">
				<div class="col-sm-2">
					<label class="fa fa-md">For checking of: </label>
				</div>
				<div class="col-sm-4">
					<select class="" id="prdn_checked_by" name="prdn_checked_by" style="width:100%;">
					</select>
				</div>
			</div>
		  </div>
		  <div class="modal-footer">
			<button type="button" class="btn btn-primary fa fa-save"> Save as Draft</button>
			<button type="submit" class="btn btn-primary fa fa-send-o"> Submit</button>
			<button type="button" class="btn btn-default fa fa-close" data-dismiss="modal"> Close</button>
		  </div>
		</form>
    </div><!-- /.modal-content -->
  </div><!-- /.modal-dialog -->
</div><!-- /.modal -->

<div class="modal fade" tabindex="-1" role="dialog" id="modal_etr_production_edit">
  <div class="modal-dialog modal-lg" role="document" style="width:70%;">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
        <h4 class="modal-title"><i class="fa fa-edit"></i> Edit Training / Qualification / Certification</h4>
      </div>
	  <div class="modal-body" style="overflow:inherit;">
		 <form id="frm_etr_production_edit">
			<div class="profile-info-title h4" style="padding-bottom:5px;">
				<span class="fa fa-plus-circle"></span> Production Section (Training and Orientation)
			</div>
			<div class="row" style="margin-top:5px;">
				<div class="col-sm-2">
					<label class="fa fa-md">Training Title: </label>
				</div>
				<div class="col-sm-4">
					<datalist id="dl_training_title">
					</datalist>
					<input type="text" class="form-control" id="training_title" name="training_title" list="dl_training_title">
				</div>
				<div class="col-sm-2">
					<label class="fa fa-md">Control No.: </label>
				</div>
				<div class="col-sm-4">
					<input type="text" class="form-control" id="control_no" name="control_no" readonly>
				</div>
			</div>
			<div class="row">
				<div class="col-sm-2">
					<label class="fa fa-md">Objective: </label>
				</div>
				<div class="col-sm-10">
					<textarea class="form-control" id="training_objective" name="training_objective"></textarea>
				</div>
			</div>
			<div class="row" style="margin-top:5px;">
				<div class="col-sm-2">
					<label class="fa fa-md">Mechanics: </label>
				</div>
				<div class="col-sm-4">
					<datalist id="dl_training_mechanics">
					</datalist>
					<input type="text" class="form-control" id="mechanics" name="mechanics" list="dl_training_mechanics">
				</div>
				<div class="col-sm-2">
					<label class="fa fa-md">Type of Training: </label>
				</div>
				<div class="col-sm-4">
					<datalist id="dl_type_of_training">
					</datalist>
					<input type="text" class="form-control" id="type_of_training" name="type_of_training" list="dl_type_of_training">
				</div>
				<div class="col-sm-2">
					<label class="fa fa-md">Venue: </label>
				</div>
				<div class="col-sm-4">
					<datalist id="dl_training_venue">
					</datalist>
					<input type="text" class="form-control" id="venue" name="venue" list="dl_training_venue">
				</div>
				<div class="col-sm-2">
					<label class="fa fa-md">Line: </label>
				</div>
				<div class="col-sm-4">
					<input type="text" class="form-control" id="line" name="line">
				</div>
			</div>
			<div class="row">
				<div class="col-sm-2">
					<label class="fa fa-md">Series Name: </label>
				</div>
				<div class="col-sm-4">
					<input type="text" class="form-control" id="series_name" name="series_name">
				</div>
			</div>
			<div class="row">
				<div class="col-sm-2">
					<label class="fa fa-md">Reason for Certification: </label>
				</div>
				<div class="col-sm-10" id="container_reason_certification">
				</div>
			</div>
			<div class="row" id="container_reason_certification_others">
				<div class="col-sm-2 col-sm-offset-2">
					<label class="fa fa-md">Others (please specify): </label>
				</div>
				<div class="col-sm-8" id="container_reason_certification_others">
                    <input type="text" class="form-control" id="reason_certification_others" name="reason_certification_others">
				</div>
			</div>
			<div class="row" style="padding-top:5px;">
				<div class="col-sm-2">
					<label class="fa fa-md">Training Category: </label>
				</div>
				<div class="col-sm-10" id="container_training_category">
				</div>
			</div><br>
			<hr class="graph-orange" style="margin-top:0px;">
			<div class="profile-info-title h4" style="padding-top:5px;">
				<span class="fa fa-th-list"></span> Operator List
			</div>
			<div class="row">
				<div class="col-sm-12">
					<div class="alert alert-danger" style="display:none;" role="alert" id="container_etr_production_new_message">					
					</div>
				</div>				
				<div class="col-sm-3 col-sm-offset-9">
                    <button type="button" class="btn btn-primary fa pull-right fa fa-plus"> Add</button>
                </div>
				<div class="col-sm-12" style="padding-top:5px;">
					<table class="table table-bordered table-hover table-condensed table-striped" id="tbl_operator_list">
                       <thead>
                            <tr>
                                <th rowspan="2" style="width:25%"><center>Operator Name</center></th>
                                <th rowspan="2" style="width:14%"><center>Emp No.</center></th>
                                <th rowspan="2" style="width:18%"><center>Station From</center></th>
                                <th rowspan="2" style="width:18%"><center>Station To</center></th>
                                <th colspan="2" style="width:18%"><center>Result</center></th>
                                <th rowspan="2" style="width:7%"><center>Remove</center></th>
                            </tr>
                            <tr>
                                <th><center>1st Take</center></th>
                                <th><center>2nd Take</center></th>
                            </tr>
                        </thead>
                        <tbody>
                        </tbody>
                    </table>
				</div>
			</div>
			<hr class="graph-orange" style="margin-top:0px;">
			<div class="profile-info-title h4" style="padding-bottom:5px;">
				<span class="fa fa-pencil-square-o"></span> Trainer/s
			</div>
			<div class="row" style="margin-top:5px;">
				<div class="col-sm-2">
					<label class="fa fa-md">Trained by: (1st Take) </label>
				</div>
				<div class="col-sm-4">
					<select class="" id="prdn_first_take_trained_by" name="prdn_first_take_trained_by" style="width:100%;">
					</select>
				</div>
				<div class="col-sm-2">
					<label class="fa fa-md">Date / Time: </label>
				</div>
				<div class="col-sm-4">
					<input type="datetime-local" class="form-control" id="prdn_first_take_date_time" name="prdn_first_take_date_time" min="<?php echo date('Y-m-d'); ?>" style="100%">
				</div>
             </div>
			 <div id="div_prdn_second_take">
				<div class="row" style="margin-top:5px;">
					<div class="col-sm-2">
						<label class="fa fa-md">Trained by: (2nd Take) </label>
					</div>
					<div class="col-sm-4">
						<select class="" id="prdn_second_take_trained_by" name="prdn_second_take_trained_by" style="width:100%;">
						</select>
					</div>
					<div class="col-sm-2">
						<label class="fa fa-md">Date / Time: </label>
					</div>
					<div class="col-sm-4">
						<input type="datetime-local" class="form-control" id="prdn_second_take_date_time" name="prdn_second_take_date_time" min="<?php echo date('Y-m-d'); ?>" style="100%">
					</div>
				 </div>
			 </div>
			<div class="row" style="margin-top:5px;">
				<div class="col-sm-2">
					<label class="fa fa-md">Engineering Section: </label>
				</div>
				<div class="col-sm-4">
					<select class="" id="eng_first_take_qualified_by" name="eng_first_take_qualified_by[]" multiple="multiple" style="width:100%;">
					</select>
				</div>
				<div class="col-sm-2">
					<label class="fa fa-md">Quality Control Section: </label>
				</div>
				<div class="col-sm-4">
					<select class="" id="qc_first_take_certified_by" name="qc_first_take_certified_by[]" multiple="multiple" style="width:100%;">
					</select>
				</div>
			</div>
			<hr class="graph-orange" style="margin-top:5px;">
			<div class="row" style="margin-top:5px;">
				<div class="col-sm-2">
					<label class="fa fa-md">For checking of: </label>
				</div>
				<div class="col-sm-4">
					<select class="" id="prdn_checked_by" name="prdn_checked_by" style="width:100%;">
					</select>
				</div>
			</div>
		  </div>
		  <div class="modal-footer">
			<button type="button" class="btn btn-primary fa fa-save"> Save as Draft</button>
			<button type="submit" class="btn btn-primary fa fa-send-o"> Submit</button>
			<button type="button" class="btn btn-danger fa fa-remove"> Cancel</button>
			<button type="button" class="btn btn-default fa fa-close" data-dismiss="modal"> Close</button>
		  </div>
		</form>
    </div><!-- /.modal-content -->
  </div><!-- /.modal-dialog -->
</div><!-- /.modal -->

<div class="modal fade" tabindex="-1" role="dialog" id="modal_etr_production_view">
  <div class="modal-dialog modal-lg" role="document" style="width:70%;">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
        <h4 class="modal-title"><i class="fa fa-eye"></i> View Training / Qualification / Certification</h4>
      </div>
	  <div class="modal-body" style="overflow:inherit;">
		 <form id="frm_etr_production_view">
			<div class="profile-info-title h4" style="padding-bottom:5px;">
				<span class="fa fa-plus-circle"></span> Production Section (Training and Orientation)
			</div>
			<div class="row" style="margin-top:5px;">
				<div class="col-sm-2">
					<label class="fa fa-md">Training Title: </label>
				</div>
				<div class="col-sm-4">
					<datalist id="dl_training_title">
					</datalist>
					<input type="text" class="form-control" id="training_title" name="training_title" list="dl_training_title">
				</div>
				<div class="col-sm-2">
					<label class="fa fa-md">Control No.: </label>
				</div>
				<div class="col-sm-4">
					<input type="text" class="form-control" id="control_no" name="control_no" readonly>
				</div>
			</div>
			<div class="row">
				<div class="col-sm-2">
					<label class="fa fa-md">Objective: </label>
				</div>
				<div class="col-sm-10">
					<textarea class="form-control" id="training_objective" name="training_objective"></textarea>
				</div>
			</div>
			<div class="row" style="margin-top:5px;">
				<div class="col-sm-2">
					<label class="fa fa-md">Mechanics: </label>
				</div>
				<div class="col-sm-4">
					<datalist id="dl_training_mechanics">
					</datalist>
					<input type="text" class="form-control" id="mechanics" name="mechanics" list="dl_training_mechanics">
				</div>
				<div class="col-sm-2">
					<label class="fa fa-md">Type of Training: </label>
				</div>
				<div class="col-sm-4">
					<datalist id="dl_type_of_training">
					</datalist>
					<input type="text" class="form-control" id="type_of_training" name="type_of_training" list="dl_type_of_training">
				</div>
				<div class="col-sm-2">
					<label class="fa fa-md">Venue: </label>
				</div>
				<div class="col-sm-4">
					<datalist id="dl_training_venue">
					</datalist>
					<input type="text" class="form-control" id="venue" name="venue" list="dl_training_venue">
				</div>
				<div class="col-sm-2">
					<label class="fa fa-md">Line: </label>
				</div>
				<div class="col-sm-4">
					<input type="text" class="form-control" id="line" name="line">
				</div>
			</div>
			<div class="row">
				<div class="col-sm-2">
					<label class="fa fa-md">Series Name: </label>
				</div>
				<div class="col-sm-4">
					<input type="text" class="form-control" id="series_name" name="series_name">
				</div>
			</div>
			<div class="row">
				<div class="col-sm-2">
					<label class="fa fa-md">Reason for Certification: </label>
				</div>
				<div class="col-sm-10" id="container_reason_certification">
				</div>
			</div>
			<div class="row" id="container_reason_certification_others">
				<div class="col-sm-2 col-sm-offset-2">
					<label class="fa fa-md">Others (please specify): </label>
				</div>
				<div class="col-sm-8" id="container_reason_certification_others">
                    <input type="text" class="form-control" id="reason_certification_others" name="reason_certification_others">
				</div>
			</div>
			<div class="row" style="padding-top:5px;">
				<div class="col-sm-2">
					<label class="fa fa-md">Training Category: </label>
				</div>
				<div class="col-sm-10" id="container_training_category">
				</div>
			</div><br>
			<hr class="graph-orange" style="margin-top:0px;">
			<div class="profile-info-title h4" style="padding-top:5px;">
				<span class="fa fa-th-list"></span> Operator List
			</div>
			<div class="row">
				<div class="col-sm-3 col-sm-offset-9">
                    <button type="button" class="btn btn-default fa pull-right fa fa-eye"> View Operator Lists</button>
                </div>	
				<div class="col-sm-12" style="padding-top:5px;">
					<table class="table table-bordered table-hover table-condensed table-striped" id="tbl_operator_list">
                       <thead>
                            <tr>
                                <th rowspan="2" style="width:25%"><center>Operator Name</center></th>
                                <th rowspan="2" style="width:14%"><center>Emp No.</center></th>
                                <th rowspan="2" style="width:18%"><center>Station From</center></th>
                                <th rowspan="2" style="width:18%"><center>Station To</center></th>
                                <th colspan="2" style="width:18%"><center>Result</center></th>
                                <th rowspan="2" style="width:7%"><center>Remove</center></th>
                            </tr>
                            <tr>
                                <th><center>1st Take</center></th>
                                <th><center>2nd Take</center></th>
                            </tr>
                        </thead>
                        <tbody>
                        </tbody>
                    </table>
				</div>
			</div>
			<hr class="graph-orange" style="margin-top:0px;">
			<div class="profile-info-title h4" style="padding-bottom:5px;">
				<span class="fa fa-pencil-square-o"></span> Trainer/s
			</div>
			<div class="row" style="margin-top:5px;">
				<div class="col-sm-2">
					<label class="fa fa-md">Trained by: (1st Take) </label>
				</div>
				<div class="col-sm-4">
					<select class="" id="prdn_first_take_trained_by" name="prdn_first_take_trained_by" style="width:100%;">
					</select>
				</div>
				<div class="col-sm-2">
					<label class="fa fa-md">Date / Time: </label>
				</div>
				<div class="col-sm-4">
					<input type="datetime-local" class="form-control" id="prdn_first_take_date_time" name="prdn_first_take_date_time" min="<?php echo date('Y-m-d'); ?>" style="100%">
				</div>
             </div>
			 <div id="div_prdn_second_take">
				<div class="row" style="margin-top:5px;">
					<div class="col-sm-2">
						<label class="fa fa-md">Trained by: (2nd Take) </label>
					</div>
					<div class="col-sm-4">
						<select class="" id="prdn_second_take_trained_by" name="prdn_second_take_trained_by" style="width:100%;">
						</select>
					</div>
					<div class="col-sm-2">
						<label class="fa fa-md">Date / Time: </label>
					</div>
					<div class="col-sm-4">
						<input type="datetime-local" class="form-control" id="prdn_second_take_date_time" name="prdn_second_take_date_time" min="<?php echo date('Y-m-d'); ?>" style="100%">
					</div>
				 </div>
			 </div>
			<div class="row" style="margin-top:5px;">
				<div class="col-sm-2">
					<label class="fa fa-md">Engineering Section: </label>
				</div>
				<div class="col-sm-4">
					<select class="" id="eng_first_take_qualified_by" name="eng_first_take_qualified_by[]" multiple="multiple" style="width:100%;">
					</select>
				</div>
				<div class="col-sm-2">
					<label class="fa fa-md">Quality Control Section: </label>
				</div>
				<div class="col-sm-4">
					<select class="" id="qc_first_take_certified_by" name="qc_first_take_certified_by[]" multiple="multiple" style="width:100%;">
					</select>
				</div>
			</div>
			<hr class="graph-orange" style="margin-top:5px;">
			<div class="row" style="margin-top:5px;">
				<div class="col-sm-2">
					<label class="fa fa-md">For checking of: </label>
				</div>
				<div class="col-sm-4">
					<select class="" id="prdn_checked_by" name="prdn_checked_by" style="width:100%;">
					</select>
				</div>
			</div>
		  </div>
		  <div class="modal-footer">
			<button type="button" class="btn btn-success fa fa-thumbs-up approver"> Approved</button>
			<button type="button" class="btn btn-danger fa fa-thumbs-down approver"> Disapproved</button>
			<button type="button" class="btn btn-default fa fa-close" data-dismiss="modal"> Close</button>
		  </div>
		</form>
    </div><!-- /.modal-content -->
  </div><!-- /.modal-dialog -->
</div><!-- /.modal -->

<!-- Module for Production Approver  -->
<div class="modal fade" tabindex="-1" role="dialog" id="modal_etr_production_submit">
  <div class="modal-dialog modal-lg" role="document" style="width:70%;">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
        <h4 class="modal-title"><i class="fa fa-edit"></i> Edit Training / Qualification / Certification</h4>
      </div>
	  <div class="modal-body" style="overflow:inherit;">
		 <form id="frm_etr_production_submit">
			<div class="profile-info-title h4" style="padding-bottom:5px;">
				<span class="fa fa-plus-circle"></span> Production Section (Training and Orientation)
			</div>
			<div class="row" style="margin-top:5px;">
				<div class="col-sm-2">
					<label class="fa fa-md">Training Title: </label>
				</div>
				<div class="col-sm-4">
					<datalist id="dl_training_title">
					</datalist>
					<input type="text" class="form-control" id="training_title" name="training_title" list="dl_training_title">
				</div>
				<div class="col-sm-2">
					<label class="fa fa-md">Control No.: </label>
				</div>
				<div class="col-sm-4">
					<input type="text" class="form-control" id="control_no" name="control_no" readonly>
				</div>
			</div>
			<div class="row">
				<div class="col-sm-2">
					<label class="fa fa-md">Objective: </label>
				</div>
				<div class="col-sm-10">
					<textarea class="form-control" id="training_objective" name="training_objective"></textarea>
				</div>
			</div>
			<div class="row" style="margin-top:5px;">
				<div class="col-sm-2">
					<label class="fa fa-md">Mechanics: </label>
				</div>
				<div class="col-sm-4">
					<datalist id="dl_training_mechanics">
					</datalist>
					<input type="text" class="form-control" id="mechanics" name="mechanics" list="dl_training_mechanics">
				</div>
				<div class="col-sm-2">
					<label class="fa fa-md">Type of Training: </label>
				</div>
				<div class="col-sm-4">
					<datalist id="dl_type_of_training">
					</datalist>
					<input type="text" class="form-control" id="type_of_training" name="type_of_training" list="dl_type_of_training">
				</div>
				<div class="col-sm-2">
					<label class="fa fa-md">Venue: </label>
				</div>
				<div class="col-sm-4">
					<datalist id="dl_training_venue">
					</datalist>
					<input type="text" class="form-control" id="venue" name="venue" list="dl_training_venue">
				</div>
				<div class="col-sm-2">
					<label class="fa fa-md">Line: </label>
				</div>
				<div class="col-sm-4">
					<input type="text" class="form-control" id="line" name="line">
				</div>
			</div>
			<div class="row">
				<div class="col-sm-2">
					<label class="fa fa-md">Series Name: </label>
				</div>
				<div class="col-sm-4">
					<input type="text" class="form-control" id="series_name" name="series_name">
				</div>
			</div>
			<div class="row">
				<div class="col-sm-2">
					<label class="fa fa-md">Reason for Certification: </label>
				</div>
				<div class="col-sm-10" id="container_reason_certification">
				</div>
			</div>
			<div class="row" id="container_reason_certification_others">
				<div class="col-sm-2 col-sm-offset-2">
					<label class="fa fa-md">Others (please specify): </label>
				</div>
				<div class="col-sm-8" id="container_reason_certification_others">
                    <input type="text" class="form-control" id="reason_certification_others" name="reason_certification_others">
				</div>
			</div>
			<div class="row" style="padding-top:5px;">
				<div class="col-sm-2">
					<label class="fa fa-md">Training Category: </label>
				</div>
				<div class="col-sm-10" id="container_training_category">
				</div>
			</div><br>
			<hr class="graph-orange" style="margin-top:0px;">
			<div class="profile-info-title h4" style="padding-top:5px;">
				<span class="fa fa-th-list"></span> Operator List
			</div>
			<div class="row">
				<div class="col-sm-12">
					<div class="alert alert-danger" style="display:none;" role="alert" id="container_etr_production_new_message">					
					</div>
				</div>				
				<div class="col-sm-3 col-sm-offset-9">
                    <button type="button" class="btn btn-primary fa pull-right fa fa-plus"> Add</button>
                </div>
				<div class="col-sm-12" style="padding-top:5px;">
					<table class="table table-bordered table-hover table-condensed table-striped" id="tbl_operator_list">
                       <thead>
                            <tr>
                                <th rowspan="2" style="width:25%"><center>Operator Name</center></th>
                                <th rowspan="2" style="width:14%"><center>Emp No.</center></th>
                                <th rowspan="2" style="width:18%"><center>Station From</center></th>
                                <th rowspan="2" style="width:18%"><center>Station To</center></th>
                                <th colspan="2" style="width:18%"><center>Result</center></th>
                                <th rowspan="2" style="width:7%"><center>Remove</center></th>
                            </tr>
                            <tr>
                                <th><center>1st Take</center></th>
                                <th><center>2nd Take</center></th>
                            </tr>
                        </thead>
                        <tbody>
                        </tbody>
                    </table>
				</div>
			</div>
			<hr class="graph-orange" style="margin-top:0px;">
			<div class="profile-info-title h4" style="padding-bottom:5px;">
				<span class="fa fa-pencil-square-o"></span> Trainer/s
			</div>
			<div class="row" style="margin-top:5px;">
				<div class="col-sm-2">
					<label class="fa fa-md">Trained by: (1st Take) </label>
				</div>
				<div class="col-sm-4">
					<select class="" id="prdn_first_take_trained_by" name="prdn_first_take_trained_by" style="width:100%;">
					</select>
				</div>
				<div class="col-sm-2">
					<label class="fa fa-md">Date / Time: </label>
				</div>
				<div class="col-sm-4">
					<input type="datetime-local" class="form-control" id="prdn_first_take_date_time" name="prdn_first_take_date_time" min="<?php echo date('Y-m-d'); ?>" style="100%">
				</div>
             </div>
			 <div id="div_prdn_second_take">
				<div class="row" style="margin-top:5px;">
					<div class="col-sm-2">
						<label class="fa fa-md">Trained by: (2nd Take) </label>
					</div>
					<div class="col-sm-4">
						<select class="" id="prdn_second_take_trained_by" name="prdn_second_take_trained_by" style="width:100%;">
						</select>
					</div>
					<div class="col-sm-2">
						<label class="fa fa-md">Date / Time: </label>
					</div>
					<div class="col-sm-4">
						<input type="datetime-local" class="form-control" id="prdn_second_take_date_time" name="prdn_second_take_date_time" min="<?php echo date('Y-m-d'); ?>" style="100%">
					</div>
				 </div>
			 </div>
			<div class="row" style="margin-top:5px;">
				<div class="col-sm-2">
					<label class="fa fa-md">Engineering Section: </label>
				</div>
				<div class="col-sm-4">
					<select class="" id="eng_first_take_qualified_by" name="eng_first_take_qualified_by[]" multiple="multiple" style="width:100%;">
					</select>
				</div>
				<div class="col-sm-2">
					<label class="fa fa-md">Quality Control Section: </label>
				</div>
				<div class="col-sm-4">
					<select class="" id="qc_first_take_certified_by" name="qc_first_take_certified_by[]" multiple="multiple" style="width:100%;">
					</select>
				</div>
			</div>
		  </div>
		  <div class="modal-footer">
			<button type="submit" class="btn btn-primary fa fa-send-o"> Submit as Approved</button>
			<button type="button" class="btn btn-danger fa fa-remove"> Cancel</button>
			<button type="button" class="btn btn-default fa fa-close" data-dismiss="modal"> Close</button>
		  </div>
		</form>
    </div><!-- /.modal-content -->
  </div><!-- /.modal-dialog -->
</div><!-- /.modal -->

<div class="modal fade" tabindex="-1" role="dialog" id="modal_etr_engineering_add">
  <div class="modal-dialog modal-lg" role="document" style="width:70%;">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
        <h4 class="modal-title"><i class="fa fa-edit"></i> Add Training / Qualification / Certification</h4>
      </div>
	  <div class="modal-body" style="overflow:inherit;">
		 <form id="frm_etr_engineering_add">
			<div class="profile-info-title h4" style="padding-bottom:5px;">
				<span class="fa fa-plus-circle"></span> Production Section (Training and Orientation)
			</div>
			<div class="row" style="margin-top:5px;">
				<div class="col-sm-2">
					<label class="fa fa-md">Training Title: </label>
				</div>
				<div class="col-sm-4">
					<datalist id="dl_training_title">
					</datalist>
					<input type="text" class="form-control" id="training_title" name="training_title" list="dl_training_title">
				</div>
				<div class="col-sm-2">
					<label class="fa fa-md">Control No.: </label>
				</div>
				<div class="col-sm-4">
					<input type="text" class="form-control" id="control_no" name="control_no" readonly>
				</div>
			</div>
			<div class="row">
				<div class="col-sm-2">
					<label class="fa fa-md">Objective: </label>
				</div>
				<div class="col-sm-10">
					<textarea class="form-control" id="training_objective" name="training_objective"></textarea>
				</div>
			</div>
			<div class="row" style="margin-top:5px;">
				<div class="col-sm-2">
					<label class="fa fa-md">Mechanics: </label>
				</div>
				<div class="col-sm-4">
					<datalist id="dl_training_mechanics">
					</datalist>
					<input type="text" class="form-control" id="mechanics" name="mechanics" list="dl_training_mechanics">
				</div>
				<div class="col-sm-2">
					<label class="fa fa-md">Type of Training: </label>
				</div>
				<div class="col-sm-4">
					<datalist id="dl_type_of_training">
					</datalist>
					<input type="text" class="form-control" id="type_of_training" name="type_of_training" list="dl_type_of_training">
				</div>
				<div class="col-sm-2">
					<label class="fa fa-md">Venue: </label>
				</div>
				<div class="col-sm-4">
					<datalist id="dl_training_venue">
					</datalist>
					<input type="text" class="form-control" id="venue" name="venue" list="dl_training_venue">
				</div>
				<div class="col-sm-2">
					<label class="fa fa-md">Line: </label>
				</div>
				<div class="col-sm-4">
					<input type="text" class="form-control" id="line" name="line">
				</div>
			</div>
			<div class="row">
				<div class="col-sm-2">
					<label class="fa fa-md">Series Name: </label>
				</div>
				<div class="col-sm-4">
					<input type="text" class="form-control" id="series_name" name="series_name">
				</div>
			</div>
			<div class="row" style="margin-top:5px;">
				<div class="col-sm-2">
					<label class="fa fa-md">Trained by: </label>
				</div>
				<div class="col-sm-4">
					<select class="" id="prdn_first_take_trained_by" name="prdn_first_take_trained_by" style="width:100%;">
					</select>
				</div>
				<div class="col-sm-2">
					<label class="fa fa-md">Date / Time: </label>
				</div>
				<div class="col-sm-4">
					<input type="datetime-local" class="form-control" id="prdn_first_take_date_time" name="prdn_first_take_date_time" min="<?php echo date('Y-m-d'); ?>" style="100%">
				</div>
             </div>
			<div class="row">
				<div class="col-sm-2">
					<label class="fa fa-md">Reason for Certification: </label>
				</div>
				<div class="col-sm-10" id="container_reason_certification">
				</div>
			</div>
			<div class="row" id="container_reason_certification_others">
				<div class="col-sm-2 col-sm-offset-2">
					<label class="fa fa-md">Others (please specify): </label>
				</div>
				<div class="col-sm-8" id="container_reason_certification_others">
                    <input type="text" class="form-control" id="reason_certification_others" name="reason_certification_others">
				</div>
			</div>
			<div class="row" style="padding-top:5px;">
				<div class="col-sm-2">
					<label class="fa fa-md">Training Category: </label>
				</div>
				<div class="col-sm-10" id="container_training_category">
				</div>
			</div><br>
			<hr class="graph-orange" style="margin-top:0px;">	
			<div class="profile-info-title h4" style="padding-top:5px;">
				<span class="fa fa-user-secret"></span> Engineering Section (Training and Orientation)
			</div>
			<div class="row">
				<div class="col-sm-12">
					<div class="alert alert-danger" style="display:none;" role="alert" id="container_etr_engineering_new_message">					
					</div>
				</div>	
				<div class="col-sm-3 col-sm-offset-9">
                    <button type="button" class="btn btn-default fa pull-right fa fa-eye"> View Operator Lists</button>
                </div>								
				<div class="col-sm-12" style="padding-top:5px;">
					<table class="table table-bordered table-hover table-condensed table-striped" id="tbl_operator_list">
                        <thead>
                            <tr>
                                <th rowspan="3" style="width:20%"><center>Operator Name</center></th>
                                <th rowspan="3" style="width:10%"><center>Emp No.</center></th>
                                <th colspan="2" style="width:20%"><center>Observation/Interview result</center></th>
                                <th colspan="4" style="width:20%"><center>Sample Checking</center></th>
                                <th colspan="2" style="width:20%"><center>Overall Assessment</center></th>
								<th rowspan="3" style="width:10%"><center>Reason for Disqualification</center></th>
                            </tr>
                            <tr>
                                <th rowspan="2"><center>1st Take</center></th>
                                <th rowspan="2"><center>2nd Take</center></th>
                                <th colspan="2"><center>1st Take</center></th>
                                <th colspan="2"><center>2nd Take</center></th>
                                <th rowspan="2"><center>1st Take</center></th>
                                <th rowspan="2"><center>2nd Take</center></th>
                            </tr>
                            <tr>
                                <th><center>OK</center></th>
                                <th><center>NG</center></th>
                                <th><center>OK</center></th>
                                <th><center>NG</center></th>
                            </tr>
                        </thead>
                        <tbody>
                        </tbody>
                    </table>
				</div>
			</div>					
			<div class="row" style="padding-top:5px;">
				<div class="col-sm-2">
					<label class="fa fa-md">CHECK ITEMS: </label>
				</div>
				<div class="col-sm-10" id="container_check_items">
				</div>
			</div>
			<hr class="graph-orange" style="margin-top:5px;">
			<div class="profile-info-title h4" style="padding-bottom:5px;">
				<span class="fa fa-pencil-square-o"></span> Trainer/s
			</div>
			<div class="row" style="margin-top:5px;">
				<div class="col-sm-2">
					<label class="fa fa-md">Qualified by: (1st Take)</label>
				</div>
				<div class="col-sm-4">
					<select class="" id="eng_first_take_qualified_by" name="eng_first_take_qualified_by" style="width:100%;">
					</select>
				</div>
				<div class="col-sm-2">
					<label class="fa fa-md">Date / Time: </label>
				</div>
				<div class="col-sm-4">
					<input type="datetime-local" class="form-control" id="eng_first_take_date_time" name="eng_first_take_date_time" min="<?php echo date('Y-m-d'); ?>" style="100%">
				</div>
             </div>
			<div id="div_engr_second_take">
				<div class="row" style="margin-top:5px;">
					<div class="col-sm-2">
						<label class="fa fa-md">Qualified by: (2nd Take) </label>
					</div>
					<div class="col-sm-4">
						<select class="" id="eng_second_take_qualified_by" name="eng_second_take_qualified_by" style="width:100%;">
						</select>
					</div>
					<div class="col-sm-2">
						<label class="fa fa-md">Date / Time: </label>
					</div>
					<div class="col-sm-4">
						<input type="datetime-local" class="form-control" id="eng_second_take_date_time" name="eng_second_take_date_time" min="<?php echo date('Y-m-d'); ?>" style="100%">
					</div>
				 </div>
			</div>
			<hr class="graph-orange" style="margin-top:5px;">
			<div class="row" style="margin-top:5px;" hidden>
				<div class="col-sm-2">
					<label class="fa fa-md">For checking of:</label>
				</div>
				<div class="col-sm-4">
					<select class="" id="engr_checked_by" name="engr_checked_by" style="width:100%;">
					</select>
				</div>
			</div>
		  </div>
		  <div class="modal-footer">
			<button type="button" class="btn btn-primary fa fa-save"> Save as Draft</button>
			<button type="submit" class="btn btn-primary fa fa-send-o"> Submit</button>
			<button type="button" class="btn btn-default fa fa-close" data-dismiss="modal"> Close</button>
		  </div>
		</form>
    </div><!-- /.modal-content -->
  </div><!-- /.modal-dialog -->
</div><!-- /.modal -->

<div class="modal fade" tabindex="-1" role="dialog" id="modal_etr_engineering_edit">
  <div class="modal-dialog modal-lg" role="document" style="width:70%;">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
        <h4 class="modal-title"><i class="fa fa-edit"></i> Edit Training / Qualification / Certification</h4>
      </div>
	  <div class="modal-body" style="overflow:inherit;">
		 <form id="frm_etr_engineering_edit">
			<div class="profile-info-title h4" style="padding-bottom:5px;">
				<span class="fa fa-plus-circle"></span> Production Section (Training and Orientation)
			</div>
			<div class="row" style="margin-top:5px;">
				<div class="col-sm-2">
					<label class="fa fa-md">Training Title: </label>
				</div>
				<div class="col-sm-4">
					<datalist id="dl_training_title">
					</datalist>
					<input type="text" class="form-control" id="training_title" name="training_title" list="dl_training_title">
				</div>
				<div class="col-sm-2">
					<label class="fa fa-md">Control No.: </label>
				</div>
				<div class="col-sm-4">
					<input type="text" class="form-control" id="control_no" name="control_no" readonly>
				</div>
			</div>
			<div class="row">
				<div class="col-sm-2">
					<label class="fa fa-md">Objective: </label>
				</div>
				<div class="col-sm-10">
					<textarea class="form-control" id="training_objective" name="training_objective"></textarea>
				</div>
			</div>
			<div class="row" style="margin-top:5px;">
				<div class="col-sm-2">
					<label class="fa fa-md">Mechanics: </label>
				</div>
				<div class="col-sm-4">
					<datalist id="dl_training_mechanics">
					</datalist>
					<input type="text" class="form-control" id="mechanics" name="mechanics" list="dl_training_mechanics">
				</div>
				<div class="col-sm-2">
					<label class="fa fa-md">Type of Training: </label>
				</div>
				<div class="col-sm-4">
					<datalist id="dl_type_of_training">
					</datalist>
					<input type="text" class="form-control" id="type_of_training" name="type_of_training" list="dl_type_of_training">
				</div>
				<div class="col-sm-2">
					<label class="fa fa-md">Venue: </label>
				</div>
				<div class="col-sm-4">
					<datalist id="dl_training_venue">
					</datalist>
					<input type="text" class="form-control" id="venue" name="venue" list="dl_training_venue">
				</div>
				<div class="col-sm-2">
					<label class="fa fa-md">Line: </label>
				</div>
				<div class="col-sm-4">
					<input type="text" class="form-control" id="line" name="line">
				</div>
			</div>
			<div class="row">
				<div class="col-sm-2">
					<label class="fa fa-md">Series Name: </label>
				</div>
				<div class="col-sm-4">
					<input type="text" class="form-control" id="series_name" name="series_name">
				</div>
			</div>
			<div class="row">
				<div class="col-sm-2">
					<label class="fa fa-md">Reason for Certification: </label>
				</div>
				<div class="col-sm-10" id="container_reason_certification">
				</div>
			</div>
			<div class="row" id="container_reason_certification_others">
				<div class="col-sm-2 col-sm-offset-2">
					<label class="fa fa-md">Others (please specify): </label>
				</div>
				<div class="col-sm-8" id="container_reason_certification_others">
                    <input type="text" class="form-control" id="reason_certification_others" name="reason_certification_others">
				</div>
			</div>
			<div class="row" style="padding-top:5px;">
				<div class="col-sm-2">
					<label class="fa fa-md">Training Category: </label>
				</div>
				<div class="col-sm-10" id="container_training_category">
				</div>
			</div><br>
			<div class="row" style="margin-top:5px;">
				<div class="col-sm-2">
					<label class="fa fa-md">Trained by: </label>
				</div>
				<div class="col-sm-4">
					<select class="" id="prdn_first_take_trained_by" name="prdn_first_take_trained_by" style="width:100%;">
					</select>
				</div>
				<div class="col-sm-2">
					<label class="fa fa-md">Date / Time: </label>
				</div>
				<div class="col-sm-4">
					<input type="datetime-local" class="form-control" id="prdn_first_take_date_time" name="prdn_first_take_date_time" min="<?php echo date('Y-m-d'); ?>" style="100%">
				</div>
             </div><br>
			<hr class="graph-orange" style="margin-top:0px;">	
			<div class="profile-info-title h4" style="padding-top:5px;">
				<span class="fa fa-user-secret"></span> Engineering Section (Training and Orientation)
			</div>	
			<div class="row">
				<div class="col-sm-12">
					<div class="alert alert-danger" style="display:none;" role="alert" id="container_etr_engineering_new_message">					
					</div>
				</div>	
				<div class="col-sm-3 col-sm-offset-9">
                    <button type="button" class="btn btn-default fa pull-right fa fa-eye"> View Operator Lists</button>
                </div>								
				<div class="col-sm-12" style="padding-top:5px;">
					<table class="table table-bordered table-hover table-condensed table-striped" id="tbl_operator_list">
                        <thead>
                            <tr>
                                <th rowspan="3" style="width:20%"><center>Operator Name</center></th>
                                <th rowspan="3" style="width:10%"><center>Emp No.</center></th>
                                <th colspan="2" style="width:20%"><center>Observation/Interview result</center></th>
                                <th colspan="4" style="width:20%"><center>Sample Checking</center></th>
                                <th colspan="2" style="width:20%"><center>Overall Assessment</center></th>
								<th rowspan="3" style="width:10%"><center>Reason for Disqualification</center></th>
                            </tr>
                            <tr>
                                <th rowspan="2"><center>1st Take</center></th>
                                <th rowspan="2"><center>2nd Take</center></th>
                                <th colspan="2"><center>1st Take</center></th>
                                <th colspan="2"><center>2nd Take</center></th>
                                <th rowspan="2"><center>1st Take</center></th>
                                <th rowspan="2"><center>2nd Take</center></th>
                            </tr>
                            <tr>
                                <th><center>OK</center></th>
                                <th><center>NG</center></th>
                                <th><center>OK</center></th>
                                <th><center>NG</center></th>
                            </tr>
                        </thead>
                        <tbody>
                        </tbody>
                    </table>
				</div>
			</div>				
			<div class="row" style="padding-top:5px;">
				<div class="col-sm-2">
					<label class="fa fa-md">CHECK ITEMS: </label>
				</div>
				<div class="col-sm-10" id="container_check_items">
				</div>
			</div>
			<hr class="graph-orange" style="margin-top:5px;">
			<div class="profile-info-title h4" style="padding-bottom:5px;">
				<span class="fa fa-pencil-square-o"></span> Trainer/s
			</div>
			<div class="row" style="margin-top:5px;">
				<div class="col-sm-2">
					<label class="fa fa-md">Qualified by: (1st Take)</label>
				</div>
				<div class="col-sm-4">
					<select class="" id="eng_first_take_qualified_by" name="eng_first_take_qualified_by" style="width:100%;">
					</select>
				</div>
				<div class="col-sm-2">
					<label class="fa fa-md">Date / Time: </label>
				</div>
				<div class="col-sm-4">
					<input type="datetime-local" class="form-control" id="eng_first_take_date_time" name="eng_first_take_date_time" min="<?php echo date('Y-m-d'); ?>" style="100%">
				</div>
             </div>
			<div id="div_engr_second_take">				
				<div class="row" style="margin-top:5px;">
					<div class="col-sm-2">
						<label class="fa fa-md">Qualified by: (2nd Take) </label>
					</div>
					<div class="col-sm-4">
						<select class="" id="eng_second_take_qualified_by" name="eng_second_take_qualified_by" style="width:100%;">
						</select>
					</div>
					<div class="col-sm-2">
						<label class="fa fa-md">Date / Time: </label>
					</div>
					<div class="col-sm-4">
						<input type="datetime-local" class="form-control" id="eng_second_take_date_time" name="eng_second_take_date_time" min="<?php echo date('Y-m-d'); ?>" style="100%">
					</div>
				 </div>
			</div>
			<hr class="graph-orange" style="margin-top:5px;">
			<div class="row" style="margin-top:5px;">
				<div class="col-sm-2">
					<label class="fa fa-md">For checking of:</label>
				</div>
				<div class="col-sm-4">
					<select class="" id="engr_checked_by" name="engr_checked_by" style="width:100%;">
					</select>
				</div>
			</div>
		  </div>
		  <div class="modal-footer">
			<button type="button" class="btn btn-primary fa fa-save"> Save as Draft</button>
			<button type="submit" class="btn btn-primary fa fa-send-o"> Submit</button>
			<button type="button" class="btn btn-danger fa fa-remove"> Cancel</button>
			<button type="button" class="btn btn-default fa fa-close" data-dismiss="modal"> Close</button>
		  </div>
		</form>
    </div><!-- /.modal-content -->
  </div><!-- /.modal-dialog -->
</div><!-- /.modal -->

<div class="modal fade" tabindex="-1" role="dialog" id="modal_etr_engineering_view">
  <div class="modal-dialog modal-lg" role="document" style="width:70%;">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
        <h4 class="modal-title"><i class="fa fa-eye"></i> View Training / Qualification / Certification</h4>
      </div>
	  <div class="modal-body" style="overflow:inherit;">
		 <form id="frm_etr_engineering_view">
			<div class="profile-info-title h4" style="padding-bottom:5px;">
				<span class="fa fa-plus-circle"></span> Production Section (Training and Orientation)
			</div>
			<div class="row" style="margin-top:5px;">
				<div class="col-sm-2">
					<label class="fa fa-md">Training Title: </label>
				</div>
				<div class="col-sm-4">
					<datalist id="dl_training_title">
					</datalist>
					<input type="text" class="form-control" id="training_title" name="training_title" list="dl_training_title">
				</div>
				<div class="col-sm-2">
					<label class="fa fa-md">Control No.: </label>
				</div>
				<div class="col-sm-4">
					<input type="text" class="form-control" id="control_no" name="control_no" readonly>
				</div>
			</div>
			<div class="row">
				<div class="col-sm-2">
					<label class="fa fa-md">Objective: </label>
				</div>
				<div class="col-sm-10">
					<textarea class="form-control" id="training_objective" name="training_objective"></textarea>
				</div>
			</div>
			<div class="row" style="margin-top:5px;">
				<div class="col-sm-2">
					<label class="fa fa-md">Mechanics: </label>
				</div>
				<div class="col-sm-4">
					<datalist id="dl_training_mechanics">
					</datalist>
					<input type="text" class="form-control" id="mechanics" name="mechanics" list="dl_training_mechanics">
				</div>
				<div class="col-sm-2">
					<label class="fa fa-md">Type of Training: </label>
				</div>
				<div class="col-sm-4">
					<datalist id="dl_type_of_training">
					</datalist>
					<input type="text" class="form-control" id="type_of_training" name="type_of_training" list="dl_type_of_training">
				</div>
				<div class="col-sm-2">
					<label class="fa fa-md">Venue: </label>
				</div>
				<div class="col-sm-4">
					<datalist id="dl_training_venue">
					</datalist>
					<input type="text" class="form-control" id="venue" name="venue" list="dl_training_venue">
				</div>
				<div class="col-sm-2">
					<label class="fa fa-md">Line: </label>
				</div>
				<div class="col-sm-4">
					<input type="text" class="form-control" id="line" name="line">
				</div>
			</div>
			<div class="row">
				<div class="col-sm-2">
					<label class="fa fa-md">Series Name: </label>
				</div>
				<div class="col-sm-4">
					<input type="text" class="form-control" id="series_name" name="series_name">
				</div>
			</div>
			<div class="row">
				<div class="col-sm-2">
					<label class="fa fa-md">Reason for Certification: </label>
				</div>
				<div class="col-sm-10" id="container_reason_certification">
				</div>
			</div>
			<div class="row" id="container_reason_certification_others">
				<div class="col-sm-2 col-sm-offset-2">
					<label class="fa fa-md">Others (please specify): </label>
				</div>
				<div class="col-sm-8" id="container_reason_certification_others">
                    <input type="text" class="form-control" id="reason_certification_others" name="reason_certification_others">
				</div>
			</div>
			<div class="row" style="padding-top:5px;">
				<div class="col-sm-2">
					<label class="fa fa-md">Training Category: </label>
				</div>
				<div class="col-sm-10" id="container_training_category">
				</div>
			</div><br>
			<div class="row" style="margin-top:5px;">
				<div class="col-sm-2">
					<label class="fa fa-md">Trained by: </label>
				</div>
				<div class="col-sm-4">
					<select class="" id="prdn_first_take_trained_by" name="prdn_first_take_trained_by" style="width:100%;">
					</select>
				</div>
				<div class="col-sm-2">
					<label class="fa fa-md">Date / Time: </label>
				</div>
				<div class="col-sm-4">
					<input type="datetime-local" class="form-control" id="prdn_first_take_date_time" name="prdn_first_take_date_time" min="<?php echo date('Y-m-d'); ?>" style="100%">
				</div>
             </div><br>
			<hr class="graph-orange" style="margin-top:0px;">	
			<div class="profile-info-title h4" style="padding-top:5px;">
				<span class="fa fa-user-secret"></span> Engineering Section (Training and Orientation)
			</div>
			<div class="row">
				<div class="col-sm-3 col-sm-offset-9">
                    <button type="button" class="btn btn-default fa pull-right fa fa-eye"> View Operator Lists</button>
                </div>								
				<div class="col-sm-12" style="padding-top:5px;">
					<table class="table table-bordered table-hover table-condensed table-striped" id="tbl_operator_list">
                        <thead>
                            <tr>
                                <th rowspan="3" style="width:20%"><center>Operator Name</center></th>
                                <th rowspan="3" style="width:10%"><center>Emp No.</center></th>
                                <th colspan="2" style="width:20%"><center>Observation/Interview result</center></th>
                                <th colspan="4" style="width:20%"><center>Sample Checking</center></th>
                                <th colspan="2" style="width:20%"><center>Overall Assessment</center></th>
								<th rowspan="3" style="width:10%"><center>Reason for Disqualification</center></th>
                            </tr>
                            <tr>
                                <th rowspan="2"><center>1st Take</center></th>
                                <th rowspan="2"><center>2nd Take</center></th>
                                <th colspan="2"><center>1st Take</center></th>
                                <th colspan="2"><center>2nd Take</center></th>
                                <th rowspan="2"><center>1st Take</center></th>
                                <th rowspan="2"><center>2nd Take</center></th>
                            </tr>
                            <tr>
                                <th><center>OK</center></th>
                                <th><center>NG</center></th>
                                <th><center>OK</center></th>
                                <th><center>NG</center></th>
                            </tr>
                        </thead>
                        <tbody>
                        </tbody>
                    </table>
				</div>
			</div>		
			<div class="row" style="padding-top:5px;">
				<div class="col-sm-2">
					<label class="fa fa-md">CHECK ITEMS: </label>
				</div>
				<div class="col-sm-10" id="container_check_items">
				</div>
			</div>
			<hr class="graph-orange" style="margin-top:5px;">
			<div class="profile-info-title h4" style="padding-bottom:5px;">
				<span class="fa fa-pencil-square-o"></span> Trainer/s
			</div>
			<div class="row" style="margin-top:5px;">
				<div class="col-sm-2">
					<label class="fa fa-md">Qualified by: (1st Take)</label>
				</div>
				<div class="col-sm-4">
					<select class="" id="eng_first_take_qualified_by" name="eng_first_take_qualified_by" style="width:100%;">
					</select>
				</div>
				<div class="col-sm-2">
					<label class="fa fa-md">Date / Time: </label>
				</div>
				<div class="col-sm-4">
					<input type="datetime-local" class="form-control" id="eng_first_take_date_time" name="eng_first_take_date_time" min="<?php echo date('Y-m-d'); ?>" style="100%">
				</div>
             </div>
			 <div id="div_engr_second_take">
				<div class="row" style="margin-top:5px;">
					<div class="col-sm-2">
						<label class="fa fa-md">Qualified by: (2nd Take) </label>
					</div>
					<div class="col-sm-4">
						<select class="" id="eng_second_take_qualified_by" name="eng_second_take_qualified_by" style="width:100%;">
						</select>
					</div>
					<div class="col-sm-2">
						<label class="fa fa-md">Date / Time: </label>
					</div>
					<div class="col-sm-4">
						<input type="datetime-local" class="form-control" id="eng_second_take_date_time" name="eng_second_take_date_time" min="<?php echo date('Y-m-d'); ?>" style="100%">
					</div>
				 </div>
			 </div>
		  </div>
		  <div class="modal-footer">
			<button type="button" class="btn btn-success fa fa-thumbs-up approver"> Approved</button>
			<button type="button" class="btn btn-danger fa fa-thumbs-down approver"> Disapproved</button>
			<button type="button" class="btn btn-default fa fa-close" data-dismiss="modal"> Close</button>
		  </div>
		</form>
    </div><!-- /.modal-content -->
  </div><!-- /.modal-dialog -->
</div><!-- /.modal -->

<div class="modal fade" tabindex="-1" role="dialog" id="modal_etr_engineering_app_view">
  <div class="modal-dialog modal-lg" role="document" style="width:70%;">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
        <h4 class="modal-title"><i class="fa fa-eye"></i> View Training / Qualification / Certification</h4>
      </div>
	  <div class="modal-body" style="overflow:inherit;">
		 <form id="frm_etr_engineering_app_view">
			<div class="profile-info-title h4" style="padding-bottom:5px;">
				<span class="fa fa-plus-circle"></span> Production Section (Training and Orientation)
			</div>
			<div class="row" style="margin-top:5px;">
				<div class="col-sm-2">
					<label class="fa fa-md">Training Title: </label>
				</div>
				<div class="col-sm-4">
					<datalist id="dl_training_title">
					</datalist>
					<input type="text" class="form-control" id="training_title" name="training_title" list="dl_training_title">
				</div>
				<div class="col-sm-2">
					<label class="fa fa-md">Control No.: </label>
				</div>
				<div class="col-sm-4">
					<input type="text" class="form-control" id="control_no" name="control_no" readonly>
				</div>
			</div>
			<div class="row">
				<div class="col-sm-2">
					<label class="fa fa-md">Objective: </label>
				</div>
				<div class="col-sm-10">
					<textarea class="form-control" id="training_objective" name="training_objective"></textarea>
				</div>
			</div>
			<div class="row" style="margin-top:5px;">
				<div class="col-sm-2">
					<label class="fa fa-md">Mechanics: </label>
				</div>
				<div class="col-sm-4">
					<datalist id="dl_training_mechanics">
					</datalist>
					<input type="text" class="form-control" id="mechanics" name="mechanics" list="dl_training_mechanics">
				</div>
				<div class="col-sm-2">
					<label class="fa fa-md">Type of Training: </label>
				</div>
				<div class="col-sm-4">
					<datalist id="dl_type_of_training">
					</datalist>
					<input type="text" class="form-control" id="type_of_training" name="type_of_training" list="dl_type_of_training">
				</div>
				<div class="col-sm-2">
					<label class="fa fa-md">Venue: </label>
				</div>
				<div class="col-sm-4">
					<datalist id="dl_training_venue">
					</datalist>
					<input type="text" class="form-control" id="venue" name="venue" list="dl_training_venue">
				</div>
				<div class="col-sm-2">
					<label class="fa fa-md">Line: </label>
				</div>
				<div class="col-sm-4">
					<input type="text" class="form-control" id="line" name="line">
				</div>
			</div>
			<div class="row">
				<div class="col-sm-2">
					<label class="fa fa-md">Series Name: </label>
				</div>
				<div class="col-sm-4">
					<input type="text" class="form-control" id="series_name" name="series_name">
				</div>
			</div>
			<div class="row">
				<div class="col-sm-2">
					<label class="fa fa-md">Reason for Certification: </label>
				</div>
				<div class="col-sm-10" id="container_reason_certification">
				</div>
			</div>
			<div class="row" id="container_reason_certification_others">
				<div class="col-sm-2 col-sm-offset-2">
					<label class="fa fa-md">Others (please specify): </label>
				</div>
				<div class="col-sm-8" id="container_reason_certification_others">
                    <input type="text" class="form-control" id="reason_certification_others" name="reason_certification_others">
				</div>
			</div>
			<div class="row" style="padding-top:5px;">
				<div class="col-sm-2">
					<label class="fa fa-md">Training Category: </label>
				</div>
				<div class="col-sm-10" id="container_training_category">
				</div>
			</div><br>
			<div class="row" style="margin-top:5px;">
				<div class="col-sm-2">
					<label class="fa fa-md">Trained by: </label>
				</div>
				<div class="col-sm-4">
					<select class="" id="prdn_first_take_trained_by" name="prdn_first_take_trained_by" style="width:100%;">
					</select>
				</div>
				<div class="col-sm-2">
					<label class="fa fa-md">Date / Time: </label>
				</div>
				<div class="col-sm-4">
					<input type="datetime-local" class="form-control" id="prdn_first_take_date_time" name="prdn_first_take_date_time" min="<?php echo date('Y-m-d'); ?>" style="100%">
				</div>
             </div><br>
			<hr class="graph-orange" style="margin-top:0px;">	
			<div class="profile-info-title h4" style="padding-top:5px;">
				<span class="fa fa-user-secret"></span> Engineering Section (Training and Orientation)
			</div>
			<div class="row">
				<div class="col-sm-3 col-sm-offset-9">
                    <button type="button" class="btn btn-default fa pull-right fa fa-eye"> View Operator Lists</button>
                </div>								
				<div class="col-sm-12" style="padding-top:5px;">
					<table class="table table-bordered table-hover table-condensed table-striped" id="tbl_operator_list">
                        <thead>
                            <tr>
                                <th rowspan="3" style="width:20%"><center>Operator Name</center></th>
                                <th rowspan="3" style="width:10%"><center>Emp No.</center></th>
                                <th colspan="2" style="width:20%"><center>Observation/Interview result</center></th>
                                <th colspan="4" style="width:20%"><center>Sample Checking</center></th>
                                <th colspan="2" style="width:20%"><center>Overall Assessment</center></th>
								<th rowspan="3" style="width:10%"><center>Reason for Disqualification</center></th>
                            </tr>
                            <tr>
                                <th rowspan="2"><center>1st Take</center></th>
                                <th rowspan="2"><center>2nd Take</center></th>
                                <th colspan="2"><center>1st Take</center></th>
                                <th colspan="2"><center>2nd Take</center></th>
                                <th rowspan="2"><center>1st Take</center></th>
                                <th rowspan="2"><center>2nd Take</center></th>
                            </tr>
                            <tr>
                                <th><center>OK</center></th>
                                <th><center>NG</center></th>
                                <th><center>OK</center></th>
                                <th><center>NG</center></th>
                            </tr>
                        </thead>
                        <tbody>
                        </tbody>
                    </table>
				</div>
			</div>		
			<div class="row" style="padding-top:5px;">
				<div class="col-sm-2">
					<label class="fa fa-md">CHECK ITEMS: </label>
				</div>
				<div class="col-sm-10" id="container_check_items">
				</div>
			</div>
			<hr class="graph-orange" style="margin-top:5px;">
			<div class="profile-info-title h4" style="padding-bottom:5px;">
				<span class="fa fa-pencil-square-o"></span> Trainer/s
			</div>
			<div class="row" style="margin-top:5px;">
				<div class="col-sm-2">
					<label class="fa fa-md">Qualified by: (1st Take)</label>
				</div>
				<div class="col-sm-4">
					<select class="" id="eng_first_take_qualified_by" name="eng_first_take_qualified_by" style="width:100%;">
					</select>
				</div>
				<div class="col-sm-2">
					<label class="fa fa-md">Date / Time: </label>
				</div>
				<div class="col-sm-4">
					<input type="datetime-local" class="form-control" id="eng_first_take_date_time" name="eng_first_take_date_time" min="<?php echo date('Y-m-d'); ?>" style="100%">
				</div>
             </div>
			 <div id="div_engr_second_take">
				<div class="row" style="margin-top:5px;">
					<div class="col-sm-2">
						<label class="fa fa-md">Qualified by: (2nd Take) </label>
					</div>
					<div class="col-sm-4">
						<select class="" id="eng_second_take_qualified_by" name="eng_second_take_qualified_by" style="width:100%;">
						</select>
					</div>
					<div class="col-sm-2">
						<label class="fa fa-md">Date / Time: </label>
					</div>
					<div class="col-sm-4">
						<input type="datetime-local" class="form-control" id="eng_second_take_date_time" name="eng_second_take_date_time" min="<?php echo date('Y-m-d'); ?>" style="100%">
					</div>
				 </div>
			 </div>
			 <hr class="graph-orange" style="margin-top:5px;">
			 <div class="row" style="margin-top:5px;">
				<div class="col-sm-2">
					<label class="fa fa-md">For checking of:</label>
				</div>
				<div class="col-sm-4">
					<select class="" id="engr_checked_by" name="engr_checked_by" style="width:100%;">
					</select>
				</div>
             </div>
		  </div>
		  <div class="modal-footer">
			<button type="button" class="btn btn-success fa fa-thumbs-o-up" id=""> Approved</button>
			<button type="button" class="btn btn-danger fa fa-thumbs-o-down" id=""> Disapproved</button>
			<button type="button" class="btn btn-default fa fa-close" data-dismiss="modal"> Close</button>
		  </div>
		</form>
    </div><!-- /.modal-content -->
  </div><!-- /.modal-dialog -->
</div><!-- /.modal -->

<div class="modal fade" tabindex="-1" role="dialog" id="modal_etr_approver_message" style="z-index:1051">
  <div class="modal-dialog modal-md" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
        <h4 class="modal-title"><i class="fa fa-question-circle-o"></i> System Confirmation</h4>
      </div>
	  <form id="frm_etr_approvers_decision">
		  <div class="modal-body">
			<div class="row">			
				<div class="col-sm-12" id="">				
					<div class="alert alert-success" role="alert" id="container_approver_message">					
					</div>
				</div>
			</div>
			<input type="hidden" id="approver">
		  </div>
		  <div class="modal-footer">
			<button type="submit" class="btn btn-primary fa fa-save"> Yes</button>
			<button type="button" class="btn btn-default fa fa-close" data-dismiss="modal" id="btn_close"> No</button>
		  </div>
	  </form>
    </div><!-- /.modal-content -->
  </div><!-- /.modal-dialog -->
</div><!-- /.modal -->

<div class="modal" tabindex="-1" role="dialog" id="modal_etr_cancel">
  <div class="modal-dialog modal-lg" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
        <h4 class="modal-title fa fa-close"> Cancel Training/Qualification/Certification</h4>
      </div>
      <div class="modal-body">
		<form id="frm_etr_cancel">
			<div class="row">
				<div class="col-sm-12">
					<div class="row">
						<div class="col-sm-12">
							<div class="alert alert-danger" role="alert">			
								Are you sure you want to cancel the training?
							</div>
							<input type="hidden" name="status">
						</div>
						<div class="col-sm-12">
							<label class="control-label condensed"> Reason of cancellation:</label>
						</div>
						<div class="col-sm-12">
							<textarea class="" id="cancelled_remarks" name="cancelled_remarks" style="width:100%" rows="4" name="" required></textarea>
						</div>
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

<div class="modal fade" tabindex="-1" role="dialog" id="modal_etr_qc_add">
  <div class="modal-dialog modal-lg" role="document" style="width:70%;">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
        <h4 class="modal-title"><i class="fa fa-edit"></i> Add Training / Qualification / Certification</h4>
      </div>
	  <div class="modal-body" style="overflow:inherit;">
		 <form id="frm_etr_qc_add">
			<div class="profile-info-title h4" style="padding-bottom:5px;">
				<span class="fa fa-plus-circle"></span> Production Section (Training and Orientation)
			</div>
			<div class="row" style="margin-top:5px;">
				<div class="col-sm-2">
					<label class="fa fa-md">Training Title: </label>
				</div>
				<div class="col-sm-4">
					<datalist id="dl_training_title">
					</datalist>
					<input type="text" class="form-control" id="training_title" name="training_title" list="dl_training_title">
				</div>
				<div class="col-sm-2">
					<label class="fa fa-md">Control No.: </label>
				</div>
				<div class="col-sm-4">
					<input type="text" class="form-control" id="control_no" name="control_no" readonly>
				</div>
			</div>
			<div class="row">
				<div class="col-sm-2">
					<label class="fa fa-md">Objective: </label>
				</div>
				<div class="col-sm-10">
					<textarea class="form-control" id="training_objective" name="training_objective"></textarea>
				</div>
			</div>
			<div class="row" style="margin-top:5px;">
				<div class="col-sm-2">
					<label class="fa fa-md">Mechanics: </label>
				</div>
				<div class="col-sm-4">
					<datalist id="dl_training_mechanics">
					</datalist>
					<input type="text" class="form-control" id="mechanics" name="mechanics" list="dl_training_mechanics">
				</div>
				<div class="col-sm-2">
					<label class="fa fa-md">Type of Training: </label>
				</div>
				<div class="col-sm-4">
					<datalist id="dl_type_of_training">
					</datalist>
					<input type="text" class="form-control" id="type_of_training" name="type_of_training" list="dl_type_of_training">
				</div>
				<div class="col-sm-2">
					<label class="fa fa-md">Venue: </label>
				</div>
				<div class="col-sm-4">
					<datalist id="dl_training_venue">
					</datalist>
					<input type="text" class="form-control" id="venue" name="venue" list="dl_training_venue">
				</div>
				<div class="col-sm-2">
					<label class="fa fa-md">Line: </label>
				</div>
				<div class="col-sm-4">
					<input type="text" class="form-control" id="line" name="line">
				</div>
			</div>
			<div class="row">
				<div class="col-sm-2">
					<label class="fa fa-md">Series Name: </label>
				</div>
				<div class="col-sm-4">
					<input type="text" class="form-control" id="series_name" name="series_name">
				</div>
			</div>
			<div class="row">
				<div class="col-sm-2">
					<label class="fa fa-md">Reason for Certification: </label>
				</div>
				<div class="col-sm-10" id="container_reason_certification">
				</div>
			</div>
			<div class="row" id="container_reason_certification_others">
				<div class="col-sm-2 col-sm-offset-2">
					<label class="fa fa-md">Others (please specify): </label>
				</div>
				<div class="col-sm-8" id="container_reason_certification_others">
                    <input type="text" class="form-control" id="reason_certification_others" name="reason_certification_others">
				</div>
			</div>
			<div class="row" style="padding-top:5px;">
				<div class="col-sm-2">
					<label class="fa fa-md">Training Category: </label>
				</div>
				<div class="col-sm-10" id="container_training_category">
				</div>
			</div><br>
			<div class="row" style="margin-top:5px;">
				<div class="col-sm-2">
					<label class="fa fa-md">Trained by: </label>
				</div>
				<div class="col-sm-4">
					<select class="" id="prdn_first_take_trained_by" name="prdn_first_take_trained_by" style="width:100%;">
					</select>
				</div>
				<div class="col-sm-2">
					<label class="fa fa-md">Date / Time: </label>
				</div>
				<div class="col-sm-4">
					<input type="datetime-local" class="form-control" id="prdn_first_take_date_time" name="prdn_first_take_date_time" min="<?php echo date('Y-m-d'); ?>" style="100%">
				</div>
             </div>					
			<div class="row" style="padding-top:5px;">
				<div class="col-sm-2">
					<label class="fa fa-md">CHECK ITEMS: </label>
				</div>
				<div class="col-sm-10" id="container_check_items">
				</div>
			</div><br>
			<hr class="graph-orange" style="margin-top:0px;">	
			<div class="profile-info-title h4" style="padding-top:5px;">
				<span class="fa fa-search-plus"></span> Certification by Quality Control Section
			</div>	
			<div class="row" style="padding-top:5px;">
				<div class="col-sm-12">
					<label class="fa fa-md">Let the operator discuss the details of training/orientation conducted by concerned JS and Eng'r as per check items specified.: </label>
				</div>
			</div><br>
			<div class="row">
				<div class="col-sm-12">
					<div class="alert alert-danger" style="display:none;" role="alert" id="container_etr_qc_new_message">					
					</div>
				</div>	
				<div class="col-sm-3 col-sm-offset-9">
                    <button type="button" class="btn btn-default fa pull-right fa fa-eye"> View Operator Lists</button>
                </div>								
				<div class="col-sm-12" style="padding-top:5px;">
					<table class="table table-bordered table-hover table-condensed table-striped" id="tbl_operator_list">
                        <thead>
                            <tr>
                                <th rowspan="3" style="width:20%"><center>Operator Name</center></th>
                                <th rowspan="3" style="width:10%"><center>Emp No.</center></th>
                                <th colspan="2" style="width:20%"><center>Observation/Interview result</center></th>
                                <th colspan="4" style="width:20%"><center>Sample Checking</center></th>
                                <th colspan="2" style="width:20%"><center>Overall Assessment</center></th>
								<th rowspan="3" style="width:10%"><center>Reason for Disqualification</center></th>
                            </tr>
                            <tr>
                                <th rowspan="2"><center>1st Take</center></th>
                                <th rowspan="2"><center>2nd Take</center></th>
                                <th colspan="2"><center>1st Take</center></th>
                                <th colspan="2"><center>2nd Take</center></th>
                                <th rowspan="2"><center>1st Take</center></th>
                                <th rowspan="2"><center>2nd Take</center></th>
                            </tr>
                            <tr>
                                <th><center>OK</center></th>
                                <th><center>NG</center></th>
                                <th><center>OK</center></th>
                                <th><center>NG</center></th>
                            </tr>
                        </thead>
                        <tbody>
                        </tbody>
                    </table>
				</div>
			</div>
			<hr class="graph-orange" style="margin-top:5px;">
			<div class="profile-info-title h4" style="padding-bottom:5px;">
				<span class="fa fa-pencil-square-o"></span> Trainer/s
			</div>
			<div class="row" style="margin-top:5px;">
				<div class="col-sm-2">
					<label class="fa fa-md">Certified by: (1st Take)</label>
				</div>
				<div class="col-sm-4">
					<select class="" id="qc_first_take_certified_by" name="qc_first_take_certified_by" style="width:100%;">
					</select>
				</div>
				<div class="col-sm-2">
					<label class="fa fa-md">Date / Time: </label>
				</div>
				<div class="col-sm-4">
					<input type="datetime-local" class="form-control" id="qc_first_take_date_time" name="qc_first_take_date_time" min="<?php echo date('Y-m-d'); ?>" style="100%">
				</div>
             </div>
			 <div id="div_qc_second_take">
				<div class="row" style="margin-top:5px;">
					<div class="col-sm-2">
						<label class="fa fa-md">Certified by: (2nd Take)</label>
					</div>
					<div class="col-sm-4">
						<select class="" id="qc_second_take_certified_by" name="qc_second_take_certified_by" style="width:100%;">
						</select>
					</div>
					<div class="col-sm-2">
						<label class="fa fa-md">Date / Time: </label>
					</div>
					<div class="col-sm-4">
						<input type="datetime-local" class="form-control" id="qc_second_take_date_time" name="qc_second_take_date_time" min="<?php echo date('Y-m-d'); ?>" style="100%">
					</div>
				 </div>
			 </div>
			<hr class="graph-orange" style="margin-top:5px;">
			<div class="row" style="margin-top:5px;" hidden>
				<div class="col-sm-2">
					<label class="fa fa-md">For checking of:</label>
				</div>
				<div class="col-sm-4">
					<select class="" id="qc_checked_by" name="qc_checked_by" style="width:100%;">
					</select>
				</div>
			</div>
		  </div>
		  <div class="modal-footer">
			<button type="button" class="btn btn-primary fa fa-save"> Save as Draft</button>
			<button type="submit" class="btn btn-primary fa fa-send-o"> Submit</button>
			<button type="button" class="btn btn-default fa fa-close" data-dismiss="modal"> Close</button>
		  </div>
		</form>
    </div><!-- /.modal-content -->
  </div><!-- /.modal-dialog -->
</div><!-- /.modal -->

<div class="modal fade" tabindex="-1" role="dialog" id="modal_etr_qc_edit">
  <div class="modal-dialog modal-lg" role="document" style="width:70%;">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
        <h4 class="modal-title"><i class="fa fa-edit"></i> Edit Training / Qualification / Certification</h4>
      </div>
	  <div class="modal-body" style="overflow:inherit;">
		 <form id="frm_etr_qc_edit">
			<div class="profile-info-title h4" >
				<span class="fa fa-list-alt"></span> Production Section (Training and Orientation)
			</div>
			<hr class="graph-orange" style="margin-top:0px;">
			<div class="row" style="margin-top:5px;">
				<div class="col-sm-2">
					<label class="fa fa-md">Training Title: </label>
				</div>
				<div class="col-sm-4">
					<datalist id="dl_training_title">
					</datalist>
					<input type="text" class="form-control" id="training_title" name="training_title" list="dl_training_title">
				</div>
				<div class="col-sm-2">
					<label class="fa fa-md">Control No.: </label>
				</div>
				<div class="col-sm-4">
					<input type="text" class="form-control" id="control_no" name="control_no" readonly>
				</div>
			</div>
			<div class="row">
				<div class="col-sm-2">
					<label class="fa fa-md">Objective: </label>
				</div>
				<div class="col-sm-10">
					<textarea class="form-control" id="training_objective" name="training_objective"></textarea>
				</div>
			</div>
			<div class="row" style="margin-top:5px;">
				<div class="col-sm-2">
					<label class="fa fa-md">Mechanics: </label>
				</div>
				<div class="col-sm-4">
					<datalist id="dl_training_mechanics">
					</datalist>
					<input type="text" class="form-control" id="mechanics" name="mechanics" list="dl_training_mechanics">
				</div>
				<div class="col-sm-2">
					<label class="fa fa-md">Type of Training: </label>
				</div>
				<div class="col-sm-4">
					<datalist id="dl_type_of_training">
					</datalist>
					<input type="text" class="form-control" id="type_of_training" name="type_of_training" list="dl_type_of_training">
				</div>
				<div class="col-sm-2">
					<label class="fa fa-md">Venue: </label>
				</div>
				<div class="col-sm-4">
					<datalist id="dl_training_venue">
					</datalist>
					<input type="text" class="form-control" id="venue" name="venue" list="dl_training_venue">
				</div>
				<div class="col-sm-2">
					<label class="fa fa-md">Line: </label>
				</div>
				<div class="col-sm-4">
					<input type="text" class="form-control" id="line" name="line">
				</div>
			</div>
			<div class="row">
				<div class="col-sm-2">
					<label class="fa fa-md">Series Name: </label>
				</div>
				<div class="col-sm-4">
					<input type="text" class="form-control" id="series_name" name="series_name">
				</div>
			</div>
			<div class="row">
				<div class="col-sm-2">
					<label class="fa fa-md">Reason for Certification: </label>
				</div>
				<div class="col-sm-10" id="container_reason_certification">
				</div>
			</div>
			<div class="row" id="container_reason_certification_others">
				<div class="col-sm-2 col-sm-offset-2">
					<label class="fa fa-md">Others (please specify): </label>
				</div>
				<div class="col-sm-8" id="container_reason_certification_others">
                    <input type="text" class="form-control" id="reason_certification_others" name="reason_certification_others">
				</div>
			</div>
			<div class="row" style="padding-top:5px;">
				<div class="col-sm-2">
					<label class="fa fa-md">Training Category: </label>
				</div>
				<div class="col-sm-10" id="container_training_category">
				</div>
			</div><br>
			<div class="row" style="margin-top:5px;">
				<div class="col-sm-2">
					<label class="fa fa-md">Trained by: </label>
				</div>
				<div class="col-sm-4">
					<select class="" id="prdn_first_take_trained_by" name="prdn_first_take_trained_by" style="width:100%;">
					</select>
				</div>
				<div class="col-sm-2">
					<label class="fa fa-md">Date / Time: </label>
				</div>
				<div class="col-sm-4">
					<input type="datetime-local" class="form-control" id="prdn_first_take_date_time" name="prdn_first_take_date_time" min="<?php echo date('Y-m-d'); ?>" style="100%">
				</div>
             </div>				
			<div class="row" style="padding-top:5px;">
				<div class="col-sm-2">
					<label class="fa fa-md">CHECK ITEMS: </label>
				</div>
				<div class="col-sm-10" id="container_check_items">
				</div>
			</div><br>
			<div class="profile-info-title h4" >
				<span class="fa fa-list-alt"></span> Certification by Quality Control Section
			</div>
			<hr class="graph-orange" style="margin-top:0px;">			
			<div class="row" style="padding-top:5px;">
				<div class="col-sm-12">
					<label class="fa fa-md">Let the operator discuss the details of training/orientation conducted by concerned JS and Eng'r as per check items specified.: </label>
				</div>
			</div><br>
			<div class="row">
				<div class="col-sm-12">
					<div class="alert alert-danger" style="display:none;" role="alert" id="container_etr_qc_new_message">					
					</div>
				</div>	
				<div class="col-sm-3 col-sm-offset-9">
                    <button type="button" class="btn btn-default fa pull-right fa fa-eye"> View Operator Lists</button>
                </div>								
				<div class="col-sm-12" style="padding-top:5px;">
					<table class="table table-bordered table-hover table-condensed table-striped" id="tbl_operator_list">
                        <thead>
                            <tr>
                                <th rowspan="3" style="width:20%"><center>Operator Name</center></th>
                                <th rowspan="3" style="width:10%"><center>Emp No.</center></th>
                                <th colspan="2" style="width:20%"><center>Observation/Interview result</center></th>
                                <th colspan="4" style="width:20%"><center>Sample Checking</center></th>
                                <th colspan="2" style="width:20%"><center>Overall Assessment</center></th>
								<th rowspan="3" style="width:10%"><center>Reason for Disqualification</center></th>
                            </tr>
                            <tr>
                                <th rowspan="2"><center>1st Take</center></th>
                                <th rowspan="2"><center>2nd Take</center></th>
                                <th colspan="2"><center>1st Take</center></th>
                                <th colspan="2"><center>2nd Take</center></th>
                                <th rowspan="2"><center>1st Take</center></th>
                                <th rowspan="2"><center>2nd Take</center></th>
                            </tr>
                            <tr>
                                <th><center>OK</center></th>
                                <th><center>NG</center></th>
                                <th><center>OK</center></th>
                                <th><center>NG</center></th>
                            </tr>
                        </thead>
                        <tbody>
                        </tbody>
                    </table>
				</div>
			</div>
			<div class="profile-info-title h4" style="padding-top:5px;">
				<span class="fa fa-circle-plus"></span> First Take
			</div>
			<hr class="graph-orange" style="margin-top:0px;">
			<div class="row" style="margin-top:5px;">
				<div class="col-sm-2">
					<label class="fa fa-md">Certified by: </label>
				</div>
				<div class="col-sm-4">
					<select class="" id="qc_first_take_certified_by" name="qc_first_take_certified_by" style="width:100%;">
					</select>
				</div>
				<div class="col-sm-2">
					<label class="fa fa-md">Date / Time: </label>
				</div>
				<div class="col-sm-4">
					<input type="datetime-local" class="form-control" id="qc_first_take_date_time" name="qc_first_take_date_time" min="<?php echo date('Y-m-d'); ?>" style="100%">
				</div>
             </div>
			 <div id="div_qc_second_take">
				<div class="profile-info-title h4" style="padding-top:5px;">
					<span class="fa fa-circle-plus"></span> Second Take
				</div>
				<hr class="graph-blue" style="margin-top:0px;">
				<div class="row" style="margin-top:5px;">
					<div class="col-sm-2">
						<label class="fa fa-md">Certified by: </label>
					</div>
					<div class="col-sm-4">
						<select class="" id="qc_second_take_certified_by" name="qc_second_take_certified_by" style="width:100%;">
						</select>
					</div>
					<div class="col-sm-2">
						<label class="fa fa-md">Date / Time: </label>
					</div>
					<div class="col-sm-4">
						<input type="datetime-local" class="form-control" id="qc_second_take_date_time" name="qc_second_take_date_time" min="<?php echo date('Y-m-d'); ?>" style="100%">
					</div>
				 </div>
			 </div>
		  </div>
		  <div class="modal-footer">
			<button type="button" class="btn btn-primary fa fa-save"> Save as Draft</button>
			<button type="submit" class="btn btn-primary fa fa-send-o"> Submit</button>
			<button type="button" class="btn btn-default fa fa-close" data-dismiss="modal"> Close</button>
		  </div>
		</form>
    </div><!-- /.modal-content -->
  </div><!-- /.modal-dialog -->
</div><!-- /.modal -->

<div class="modal fade" tabindex="-1" role="dialog" id="modal_etr_qc_view">
  <div class="modal-dialog modal-lg" role="document" style="width:70%;">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
        <h4 class="modal-title"><i class="fa fa-eye"></i> View Training / Qualification / Certification</h4>
      </div>
	  <div class="modal-body" style="overflow:inherit;">
		 <form id="frm_etr_qc_view">
			<div class="profile-info-title h4" >
				<span class="fa fa-list-alt"></span> Production Section (Training and Orientation)
			</div>
			<hr class="graph-orange" style="margin-top:0px;">
			<div class="row" style="margin-top:5px;">
				<div class="col-sm-2">
					<label class="fa fa-md">Training Title: </label>
				</div>
				<div class="col-sm-4">
					<datalist id="dl_training_title">
					</datalist>
					<input type="text" class="form-control" id="training_title" name="training_title" list="dl_training_title">
				</div>
				<div class="col-sm-2">
					<label class="fa fa-md">Control No.: </label>
				</div>
				<div class="col-sm-4">
					<input type="text" class="form-control" id="control_no" name="control_no" readonly>
				</div>
			</div>
			<div class="row">
				<div class="col-sm-2">
					<label class="fa fa-md">Objective: </label>
				</div>
				<div class="col-sm-10">
					<textarea class="form-control" id="training_objective" name="training_objective"></textarea>
				</div>
			</div>
			<div class="row" style="margin-top:5px;">
				<div class="col-sm-2">
					<label class="fa fa-md">Mechanics: </label>
				</div>
				<div class="col-sm-4">
					<datalist id="dl_training_mechanics">
					</datalist>
					<input type="text" class="form-control" id="mechanics" name="mechanics" list="dl_training_mechanics">
				</div>
				<div class="col-sm-2">
					<label class="fa fa-md">Type of Training: </label>
				</div>
				<div class="col-sm-4">
					<datalist id="dl_type_of_training">
					</datalist>
					<input type="text" class="form-control" id="type_of_training" name="type_of_training" list="dl_type_of_training">
				</div>
				<div class="col-sm-2">
					<label class="fa fa-md">Venue: </label>
				</div>
				<div class="col-sm-4">
					<datalist id="dl_training_venue">
					</datalist>
					<input type="text" class="form-control" id="venue" name="venue" list="dl_training_venue">
				</div>
				<div class="col-sm-2">
					<label class="fa fa-md">Line: </label>
				</div>
				<div class="col-sm-4">
					<input type="text" class="form-control" id="line" name="line">
				</div>
			</div>
			<div class="row">
				<div class="col-sm-2">
					<label class="fa fa-md">Series Name: </label>
				</div>
				<div class="col-sm-4">
					<input type="text" class="form-control" id="series_name" name="series_name">
				</div>
			</div>
			<div class="row">
				<div class="col-sm-2">
					<label class="fa fa-md">Reason for Certification: </label>
				</div>
				<div class="col-sm-10" id="container_reason_certification">
				</div>
			</div>
			<div class="row" id="container_reason_certification_others">
				<div class="col-sm-2 col-sm-offset-2">
					<label class="fa fa-md">Others (please specify): </label>
				</div>
				<div class="col-sm-8" id="container_reason_certification_others">
                    <input type="text" class="form-control" id="reason_certification_others" name="reason_certification_others">
				</div>
			</div>
			<div class="row" style="padding-top:5px;">
				<div class="col-sm-2">
					<label class="fa fa-md">Training Category: </label>
				</div>
				<div class="col-sm-10" id="container_training_category">
				</div>
			</div><br>
			<div class="row" style="margin-top:5px;">
				<div class="col-sm-2">
					<label class="fa fa-md">Trained by: </label>
				</div>
				<div class="col-sm-4">
					<select class="" id="prdn_first_take_trained_by" name="prdn_first_take_trained_by" style="width:100%;">
					</select>
				</div>
				<div class="col-sm-2">
					<label class="fa fa-md">Date / Time: </label>
				</div>
				<div class="col-sm-4">
					<input type="datetime-local" class="form-control" id="prdn_first_take_date_time" name="prdn_first_take_date_time" min="<?php echo date('Y-m-d'); ?>" style="100%">
				</div>
             </div>				
			<div class="row" style="padding-top:5px;">
				<div class="col-sm-2">
					<label class="fa fa-md">CHECK ITEMS: </label>
				</div>
				<div class="col-sm-10" id="container_check_items">
				</div>
			</div><br>
			<div class="profile-info-title h4" >
				<span class="fa fa-list-alt"></span> Certification by Quality Control Section
			</div>
			<hr class="graph-orange" style="margin-top:0px;">			
			<div class="row" style="padding-top:5px;">
				<div class="col-sm-12">
					<label class="fa fa-md">Let the operator discuss the details of training/orientation conducted by concerned JS and Eng'r as per check items specified.: </label>
				</div>
			</div><br>
			<div class="row">
				<div class="col-sm-12">
					<div class="alert alert-danger" style="display:none;" role="alert" id="container_etr_qc_new_message">					
					</div>
				</div>	
				<div class="col-sm-3 col-sm-offset-9">
                    <button type="button" class="btn btn-default fa pull-right fa fa-eye"> View Operator Lists</button>
                </div>								
				<div class="col-sm-12" style="padding-top:5px;">
					<table class="table table-bordered table-hover table-condensed table-striped" id="tbl_operator_list">
                        <thead>
                            <tr>
                                <th rowspan="3" style="width:20%"><center>Operator Name</center></th>
                                <th rowspan="3" style="width:10%"><center>Emp No.</center></th>
                                <th colspan="2" style="width:20%"><center>Observation/Interview result</center></th>
                                <th colspan="4" style="width:20%"><center>Sample Checking</center></th>
                                <th colspan="2" style="width:20%"><center>Overall Assessment</center></th>
								<th rowspan="3" style="width:10%"><center>Reason for Disqualification</center></th>
                            </tr>
                            <tr>
                                <th rowspan="2"><center>1st Take</center></th>
                                <th rowspan="2"><center>2nd Take</center></th>
                                <th colspan="2"><center>1st Take</center></th>
                                <th colspan="2"><center>2nd Take</center></th>
                                <th rowspan="2"><center>1st Take</center></th>
                                <th rowspan="2"><center>2nd Take</center></th>
                            </tr>
                            <tr>
                                <th><center>OK</center></th>
                                <th><center>NG</center></th>
                                <th><center>OK</center></th>
                                <th><center>NG</center></th>
                            </tr>
                        </thead>
                        <tbody>
                        </tbody>
                    </table>
				</div>
			</div>
			<div class="profile-info-title h4" style="padding-top:5px;">
				<span class="fa fa-circle-plus"></span> First Take
			</div>
			<hr class="graph-orange" style="margin-top:0px;">
			<div class="row" style="margin-top:5px;">
				<div class="col-sm-2">
					<label class="fa fa-md">Certified by: </label>
				</div>
				<div class="col-sm-4">
					<select class="" id="qc_first_take_certified_by" name="qc_first_take_certified_by" style="width:100%;">
					</select>
				</div>
				<div class="col-sm-2">
					<label class="fa fa-md">Date / Time: </label>
				</div>
				<div class="col-sm-4">
					<input type="datetime-local" class="form-control" id="qc_first_take_date_time" name="qc_first_take_date_time" min="<?php echo date('Y-m-d'); ?>" style="100%">
				</div>
             </div>
			 <div id="div_qc_second_take">
				<div class="profile-info-title h4" style="padding-top:5px;">
					<span class="fa fa-circle-plus"></span> Second Take
				</div>
				<hr class="graph-blue" style="margin-top:0px;">
				<div class="row" style="margin-top:5px;">
					<div class="col-sm-2">
						<label class="fa fa-md">Certified by: </label>
					</div>
					<div class="col-sm-4">
						<select class="" id="qc_second_take_certified_by" name="qc_second_take_certified_by" style="width:100%;">
						</select>
					</div>
					<div class="col-sm-2">
						<label class="fa fa-md">Date / Time: </label>
					</div>
					<div class="col-sm-4">
						<input type="datetime-local" class="form-control" id="qc_second_take_date_time" name="qc_second_take_date_time" min="<?php echo date('Y-m-d'); ?>" style="100%">
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

<div class="modal fade" tabindex="-1" role="dialog" id="modal_etr_qc_app_view">
   <div class="modal-dialog modal-lg" role="document" style="width:70%;">
      <div class="modal-content">
         <div class="modal-header">
            <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
            <h4 class="modal-title"><i class="fa fa-eye"></i> View Training / Qualification / Certification</h4>
         </div>
         <div class="modal-body" style="overflow:inherit;">
            <form id="frm_etr_qc_app_view">
               <div class="profile-info-title h4" >
                  <span class="fa fa-list-alt"></span> Production Section (Training and Orientation)
               </div>
               <hr class="graph-orange" style="margin-top:0px;">
               <div class="row" style="margin-top:5px;">
                  <div class="col-sm-2">
                     <label class="fa fa-md">Training Title: </label>
                  </div>
                  <div class="col-sm-4">
                     <datalist id="dl_training_title">
                     </datalist>
                     <input type="text" class="form-control" id="training_title" name="training_title" list="dl_training_title">
                  </div>
                  <div class="col-sm-2">
                     <label class="fa fa-md">Control No.: </label>
                  </div>
                  <div class="col-sm-4">
                     <input type="text" class="form-control" id="control_no" name="control_no" readonly>
                  </div>
               </div>
               <div class="row">
                  <div class="col-sm-2">
                     <label class="fa fa-md">Objective: </label>
                  </div>
                  <div class="col-sm-10">
                     <textarea class="form-control" id="training_objective" name="training_objective"></textarea>
                  </div>
               </div>
               <div class="row" style="margin-top:5px;">
                  <div class="col-sm-2">
                     <label class="fa fa-md">Mechanics: </label>
                  </div>
                  <div class="col-sm-4">
                     <datalist id="dl_training_mechanics">
                     </datalist>
                     <input type="text" class="form-control" id="mechanics" name="mechanics" list="dl_training_mechanics">
                  </div>
                  <div class="col-sm-2">
                     <label class="fa fa-md">Type of Training: </label>
                  </div>
                  <div class="col-sm-4">
                     <datalist id="dl_type_of_training">
                     </datalist>
                     <input type="text" class="form-control" id="type_of_training" name="type_of_training" list="dl_type_of_training">
                  </div>
                  <div class="col-sm-2">
                     <label class="fa fa-md">Venue: </label>
                  </div>
                  <div class="col-sm-4">
                     <datalist id="dl_training_venue">
                     </datalist>
                     <input type="text" class="form-control" id="venue" name="venue" list="dl_training_venue">
                  </div>
                  <div class="col-sm-2">
                     <label class="fa fa-md">Line: </label>
                  </div>
                  <div class="col-sm-4">
                     <input type="text" class="form-control" id="line" name="line">
                  </div>
               </div>
               <div class="row">
                  <div class="col-sm-2">
                     <label class="fa fa-md">Series Name: </label>
                  </div>
                  <div class="col-sm-4">
                     <input type="text" class="form-control" id="series_name" name="series_name">
                  </div>
               </div>
               <div class="row">
                  <div class="col-sm-2">
                     <label class="fa fa-md">Reason for Certification: </label>
                  </div>
                  <div class="col-sm-10" id="container_reason_certification">
                  </div>
               </div>
               <div class="row" id="container_reason_certification_others">
                  <div class="col-sm-2 col-sm-offset-2">
                     <label class="fa fa-md">Others (please specify): </label>
                  </div>
                  <div class="col-sm-8" id="container_reason_certification_others">
                     <input type="text" class="form-control" id="reason_certification_others" name="reason_certification_others">
                  </div>
               </div>
               <div class="row" style="padding-top:5px;">
                  <div class="col-sm-2">
                     <label class="fa fa-md">Training Category: </label>
                  </div>
                  <div class="col-sm-10" id="container_training_category">
                  </div>
               </div>
               <br>
               <div class="row" style="margin-top:5px;">
                  <div class="col-sm-2">
                     <label class="fa fa-md">Trained by: </label>
                  </div>
                  <div class="col-sm-4">
                     <select class="" id="prdn_first_take_trained_by" name="prdn_first_take_trained_by" style="width:100%;">
                     </select>
                  </div>
                  <div class="col-sm-2">
                     <label class="fa fa-md">Date / Time: </label>
                  </div>
                  <div class="col-sm-4">
                     <input type="datetime-local" class="form-control" id="prdn_first_take_date_time" name="prdn_first_take_date_time" min="<?php echo date('Y-m-d'); ?>" style="100%">
                  </div>
               </div>
               <div class="profile-info-title h4" >
                  <span class="fa fa-list-alt"></span> Certification by Quality Control Section
               </div>
               <hr class="graph-orange" style="margin-top:0px;">
               <div class="row" style="padding-top:5px;">
                  <div class="col-sm-12">
                     <label class="fa fa-md">Let the operator discuss the details of training/orientation conducted by concerned JS and Eng'r as per check items specified.: </label>
                  </div>
               </div>
               <br>
               <div class="row">
                  <div class="col-sm-12">
                     <div class="alert alert-danger" style="display:none;" role="alert" id="container_etr_qc_new_message">					
                     </div>
                  </div>
                  <div class="col-sm-3 col-sm-offset-9">
                     <button type="button" class="btn btn-default fa pull-right fa fa-eye"> View Operator Lists</button>
                  </div>
                  <div class="col-sm-12" style="padding-top:5px;">
                     <table class="table table-bordered table-hover table-condensed table-striped" id="tbl_operator_list">
                        <thead>
                           <tr>
                              <th rowspan="3" style="width:20%">
                                 <center>Operator Name</center>
                              </th>
                              <th rowspan="3" style="width:10%">
                                 <center>Emp No.</center>
                              </th>
                              <th colspan="2" style="width:20%">
                                 <center>Observation/Interview result</center>
                              </th>
                              <th colspan="4" style="width:20%">
                                 <center>Sample Checking</center>
                              </th>
                              <th colspan="2" style="width:20%">
                                 <center>Overall Assessment</center>
                              </th>
                              <th rowspan="3" style="width:10%">
                                 <center>Reason for Disqualification</center>
                              </th>
                           </tr>
                           <tr>
                              <th rowspan="2">
                                 <center>1st Take</center>
                              </th>
                              <th rowspan="2">
                                 <center>2nd Take</center>
                              </th>
                              <th colspan="2">
                                 <center>1st Take</center>
                              </th>
                              <th colspan="2">
                                 <center>2nd Take</center>
                              </th>
                              <th rowspan="2">
                                 <center>1st Take</center>
                              </th>
                              <th rowspan="2">
                                 <center>2nd Take</center>
                              </th>
                           </tr>
                           <tr>
                              <th>
                                 <center>OK</center>
                              </th>
                              <th>
                                 <center>NG</center>
                              </th>
                              <th>
                                 <center>OK</center>
                              </th>
                              <th>
                                 <center>NG</center>
                              </th>
                           </tr>
                        </thead>
                        <tbody>
                        </tbody>
                     </table>
                  </div>
               </div>
               <div class="profile-info-title h4" style="padding-top:5px;">
                  <span class="fa fa-circle-plus"></span> First Take
               </div>
               <hr class="graph-orange" style="margin-top:0px;">
               <div class="row" style="margin-top:5px;">
                  <div class="col-sm-2">
                     <label class="fa fa-md">Certified by: </label>
                  </div>
                  <div class="col-sm-4">
                     <select class="" id="qc_first_take_certified_by" name="qc_first_take_certified_by" style="width:100%;">
                     </select>
                  </div>
                  <div class="col-sm-2">
                     <label class="fa fa-md">Date / Time: </label>
                  </div>
                  <div class="col-sm-4">
                     <input type="datetime-local" class="form-control" id="qc_first_take_date_time" name="qc_first_take_date_time" min="<?php echo date('Y-m-d'); ?>" style="100%">
                  </div>
               </div>
               <div id="div_qc_second_take">
                  <div class="profile-info-title h4" style="padding-top:5px;">
                     <span class="fa fa-circle-plus"></span> Second Take
                  </div>
                  <hr class="graph-blue" style="margin-top:0px;">
                  <div class="row" style="margin-top:5px;">
                     <div class="col-sm-2">
                        <label class="fa fa-md">Certified by: </label>
                     </div>
                     <div class="col-sm-4">
                        <select class="" id="qc_second_take_certified_by" name="qc_second_take_certified_by" style="width:100%;">
                        </select>
                     </div>
                     <div class="col-sm-2">
                        <label class="fa fa-md">Date / Time: </label>
                     </div>
                     <div class="col-sm-4">
                        <input type="datetime-local" class="form-control" id="qc_second_take_date_time" name="qc_second_take_date_time" min="<?php echo date('Y-m-d'); ?>" style="100%">
                     </div>
                  </div>
               </div>			   
				<hr class="graph-orange" style="margin-top:5px;">
				<div class="row" style="margin-top:5px;">
					<div class="col-sm-2">
						<label class="fa fa-md">For checking of:</label>
					</div>
					<div class="col-sm-4">
						<select class="" id="qc_checked_by" name="qc_checked_by" style="width:100%;" required>
						</select>
					</div>
				</div>
         </div>
         <div class="modal-footer">
         <button type="button" class="btn btn-success fa fa-thumbs-o-up approver" id=""> Approved</button>
         <button type="button" class="btn btn-danger fa fa-thumbs-o-down approver" id=""> Disapproved</button>
         <button type="button" class="btn btn-default fa fa-close" data-dismiss="modal"> Close</button>
         </div>
         </form>
      </div>
      <!-- /.modal-content -->
   </div>
   <!-- /.modal-dialog -->
</div>
<!-- /.modal -->

<div class="modal fade" tabindex="-1" role="dialog" id="modal_etr_th_acknowledge">
  <div class="modal-dialog modal-lg" role="document" style="width:70%;">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
        <h4 class="modal-title"><i class="fa fa-handshake-o"></i> Acknowledgement of Training / Qualification / Certification</h4>
      </div>
	  <div class="modal-body" style="overflow:inherit;">
		 <form id="frm_etr_th_acknowledge">
			<div class="profile-info-title h4" >
				<span class="fa fa-list-alt"></span> Production Section (Training and Orientation)
			</div>
			<hr class="graph-orange" style="margin-top:0px;">
			<div class="row" style="margin-top:5px;">
				<div class="col-sm-2">
					<label class="fa fa-md">Training Title: </label>
				</div>
				<div class="col-sm-4">
					<datalist id="dl_training_title">
					</datalist>
					<input type="text" class="form-control" id="training_title" name="training_title" list="dl_training_title">
				</div>
				<div class="col-sm-2">
					<label class="fa fa-md">Control No.: </label>
				</div>
				<div class="col-sm-4">
					<input type="text" class="form-control" id="control_no" name="control_no" readonly>
				</div>
			</div>
			<div class="row">
				<div class="col-sm-2">
					<label class="fa fa-md">Objective: </label>
				</div>
				<div class="col-sm-10">
					<textarea class="form-control" id="training_objective" name="training_objective"></textarea>
				</div>
			</div>
			<div class="row" style="margin-top:5px;">
				<div class="col-sm-2">
					<label class="fa fa-md">Mechanics: </label>
				</div>
				<div class="col-sm-4">
					<datalist id="dl_training_mechanics">
					</datalist>
					<input type="text" class="form-control" id="mechanics" name="mechanics" list="dl_training_mechanics">
				</div>
				<div class="col-sm-2">
					<label class="fa fa-md">Type of Training: </label>
				</div>
				<div class="col-sm-4">
					<datalist id="dl_type_of_training">
					</datalist>
					<input type="text" class="form-control" id="type_of_training" name="type_of_training" list="dl_type_of_training">
				</div>
				<div class="col-sm-2">
					<label class="fa fa-md">Venue: </label>
				</div>
				<div class="col-sm-4">
					<datalist id="dl_training_venue">
					</datalist>
					<input type="text" class="form-control" id="venue" name="venue" list="dl_training_venue">
				</div>
				<div class="col-sm-2">
					<label class="fa fa-md">Line: </label>
				</div>
				<div class="col-sm-4">
					<input type="text" class="form-control" id="line" name="line">
				</div>
			</div>
			<div class="row">
				<div class="col-sm-2">
					<label class="fa fa-md">Series Name: </label>
				</div>
				<div class="col-sm-4">
					<input type="text" class="form-control" id="series_name" name="series_name">
				</div>
			</div>
			<div class="row">
				<div class="col-sm-2">
					<label class="fa fa-md">Reason for Certification: </label>
				</div>
				<div class="col-sm-10" id="container_reason_certification">
				</div>
			</div>
			<div class="row" id="container_reason_certification_others">
				<div class="col-sm-2 col-sm-offset-2">
					<label class="fa fa-md">Others (please specify): </label>
				</div>
				<div class="col-sm-8" id="container_reason_certification_others">
                    <input type="text" class="form-control" id="reason_certification_others" name="reason_certification_others">
				</div>
			</div>
			<div class="row" style="padding-top:5px;">
				<div class="col-sm-2">
					<label class="fa fa-md">Training Category: </label>
				</div>
				<div class="col-sm-10" id="container_training_category">
				</div>
			</div><br>
			<div class="profile-info-title h4" >
				<span class="fa fa-list-alt"></span> Certified Operators List
			</div>
			<hr class="graph-blue" style="margin-top:0px;">
			<div class="row">				
				<div class="col-sm-12" style="padding-top:5px;">
					<table class="table table-bordered table-hover table-condensed table-striped" id="tbl_operator_list">
                        <thead>
                            <tr>
                                <th style="width:5%"><center>No.</center></th>
                                <th style="width:16%"><center>Operator's Name</center></th>
                                <th style="width:7%"><center>Emp. No.</center></th>
                                <th style="width:8%"><center>Station From</center></th>
                                <th style="width:8%"><center>Station To</center></th>
                                <th style="width:5%"><center>Date Trained</center></th>
                                <th style="width:14%"><center>Production In-charge</center></th>
                                <th style="width:5%"><center>Date Qualified</center></th>
                                <th style="width:14%"><center>Engineering In-charge</center></th>
                                <th style="width:5%"><center>Date Certified</center></th>
                                <th style="width:14%"><center>QC In-charge</center></th>
                            </tr>
                        </thead>
                        <tbody>
                        </tbody>
                    </table>
				</div>
			</div>
		  </div>
		  <div class="modal-footer">
			<button type="button" class="btn btn-primary fa fa-handshake-o"> Acknowledge</button>
			<button type="button" class="btn btn-default fa fa-close" data-dismiss="modal"> Close</button>
		  </div>
		</form>
    </div><!-- /.modal-content -->
  </div><!-- /.modal-dialog -->
</div><!-- /.modal -->

<div class="modal" tabindex="-1" role="dialog" id="modal_etr_th_confirmation">
  <div class="modal-dialog modal-lg" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
        <h4 class="modal-title fa fa-handshake-o"> Acknowledge Training/Qualification/Certification</h4>
      </div>
      <div class="modal-body">
		<form id="frm_etr_th_confirm">
			<div class="row">
				<div class="col-sm-12">
					<div class="row">
						<div class="col-sm-12">
							<div class="alert alert-success" role="alert">			
								Are you sure you want to acknowledge the training?<br>Record will be saved to SystemOne Employee Training Record (ETR).
							</div>
						</div>
					</div>
				</div>
			</div>
      </div>
	  <div class="modal-footer">
        <button type="submit" class="btn btn-primary fa fa-check"> Yes</button>
		<button type="button" class="btn btn-default fa fa-close" data-dismiss="modal" id="btn_close"> No</button>
      </div>
		</form>
    </div><!-- /.modal-content -->
  </div><!-- /.modal-dialog -->
</div><!-- /.modal -->

<div class="modal" tabindex="-1" role="dialog" id="modal_view_operator_list">
  <div class="modal-dialog modal-lg" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
        <h4 class="modal-title fa fa-list"> Certified Operator Lists</h4>
      </div>
      <div class="modal-body">
		<div class="" id="div_view_operator_list"></div>
      </div>
      <div class="modal-footer">
        <div id="div_countdown"></div>
		<!--<button type="submit" class="btn btn-primary fa fa-search"> Search</button>-->
        <button type="button" class="btn btn-default fa fa-close" data-dismiss="modal"> Close</button>
      </div>
    </div><!-- /.modal-content -->
  </div><!-- /.modal-dialog -->
</div><!-- /.modal -->

<div class="modal fade" tabindex="-1" role="dialog" id="modal_etr_indi_training">
  <div class="modal-dialog modal-lg" role="document" style="width:70%;">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
        <h4 class="modal-title"><i class="fa fa-list-alt"></i> Certified Operators List</h4>
      </div>
	  <div class="modal-body" style="overflow:inherit;">
		 <form id="frm_etr_indi_training">
			<hr class="graph-orange" style="margin-top:0px;">
			<div class="row" style="margin-top:5px;">
				<div class="col-sm-2">
					<label class="fa fa-md">Product Line: </label>
				</div>
				<div class="col-sm-4">
					<input type="text" class="form-control" id="series_name" name="series_name">
				</div>
				<div class="col-sm-2">
					<label class="fa fa-md">Station: </label>
				</div>
				<div class="col-sm-4">
					<input type="text" class="form-control" id="station_to" name="station_to">
				</div>
			</div>
			<hr class="graph-blue" style="margin-top:0px;">
			<div class="row">				
				<div class="col-sm-12" style="padding-top:5px;">
					<table class="table table-bordered table-hover table-condensed table-striped" id="tbl_operator_list">
                        <thead>
                            <tr>
                                <th style="width:5%"><center>No.</center></th>
                                <th style="width:16%"><center>Operator's Name</center></th>
                                <th style="width:7%"><center>Emp. No.</center></th>
                                <th style="width:5%"><center>Date Trained</center></th>
                                <th style="width:5%"><center>Date Certified</center></th>
                                <th style="width:14%"><center>Production In-charge</center></th>
                                <th style="width:14%"><center>Engineering In-charge</center></th>
                                <th style="width:14%"><center>QC In-charge</center></th>
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

<div class="modal fade" tabindex="-1" role="dialog" id="modal_etr_certified_operators">
  <div class="modal-dialog modal-lg" role="document" style="width:70%;">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
        <h4 class="modal-title"><i class="fa fa-list-alt"></i> Certified Operators List</h4>
      </div>
	  <div class="modal-body" style="overflow:inherit;">
		 <form id="frm_etr_certified_operators">
			<hr class="graph-orange" style="margin-top:0px;">
			<div class="row" style="margin-top:5px;">
				<div class="col-sm-2">
					<label class="fa fa-md">Product Line: </label>
				</div>
				<div class="col-sm-4">
					<input type="text" class="form-control" id="series_name" name="series_name">
				</div>
				<div class="col-sm-2">
					<label class="fa fa-md">Station: </label>
				</div>
				<div class="col-sm-4">
					<input type="text" class="form-control" id="station_to" name="station_to">
				</div>
			</div>
			<hr class="graph-blue" style="margin-top:0px;">
			<div class="row">				
				<div class="col-sm-12" style="padding-top:5px;">
					<table class="table table-bordered table-hover table-condensed table-striped" id="tbl_operator_list">
                        <thead>
                            <tr>
                                <th style="width:5%"><center>No.</center></th>
                                <th style="width:16%"><center>Operator's Name</center></th>
                                <th style="width:7%"><center>Emp. No.</center></th>
                                <th style="width:5%"><center>Date Trained</center></th>
                                <th style="width:5%"><center>Date Certified</center></th>
                                <th style="width:14%"><center>Production In-charge</center></th>
                                <th style="width:14%"><center>Engineering In-charge</center></th>
                                <th style="width:14%"><center>QC In-charge</center></th>
                            </tr>
                        </thead>
                        <tbody>
                        </tbody>
                    </table>
				</div>
			</div>
		  </div>
		  <div class="modal-footer">
			<button type="button" class="btn btn-success fa fa-file-excel-o" id="btn_export_cert_operators"> Export</button>
			<button type="button" class="btn btn-default fa fa-close" data-dismiss="modal"> Close</button>
		  </div>
		</form>
    </div><!-- /.modal-content -->
  </div><!-- /.modal-dialog -->
</div><!-- /.modal -->


<!-- Modal for system message -->
<div class="modal" tabindex="-1" role="dialog" id="modal_etr_system_message">
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

<div class="modal" tabindex="-1" role="dialog" id="modal_etr_advance_search">
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
		<table class="table table-bordered table-hover table-condensed table-striped" id="tbl_oqc_lon_advance_search">
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