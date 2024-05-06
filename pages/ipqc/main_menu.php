<?php
	/* Check if there is a read role on one IPQC modules */
	/* Preproduction */
	$user_ipqc_pp_read_access = false;
	foreach($user_role['subsystem_code'] as $key => $subsystem_code ){
		if($subsystem_code == "IPQC" && $user_role['module'][$key] == "Preproduction" && $user_role['read'][$key] == 1){ 
			$user_ipqc_pp_read_access = true;
		}
	}
	if( $user_ipqc_pp_read_access ){
		echo '<div class="col-xs-12 col-sm-6 col-lg-4 selection-tab">
				<a href="#" id="a_pp">
					<div class="panel panel-info" style="padding:0px;">
					  <div class="panel-heading">
						<div class="row">
						  <div class="col-xs-3">
							<i class="fa fa-american-sign-language-interpreting fa-5x"></i>
						  </div>
						  <div class="col-xs-9 text-right">
							<p class="announcement-heading"></p>
							<p class="announcement-text fa-lg"> Pre-production</p>
						  </div>
						</div>
					  </div>
						<div class="panel-footer announcement-bottom">
						  <div class="row">
							<div class="col-xs-6">
							  Open
							</div>
							<div class="col-xs-6 text-right">
							  <i class="fa fa-arrow-circle-right"></i>
							</div>
						  </div>
						</div>
					</div>
				</a>
			</div>';
	}
	
	/* Check if there is a read role on one IPQC modules */
	/* Visual Inspection Result */
	$user_ipqc_vi_read_access = false;
	foreach($user_role['subsystem_code'] as $key => $subsystem_code ){
		if($subsystem_code == "IPQC" && $user_role['module'][$key] == "Visual Inspection Result" && $user_role['read'][$key] == 1){ 
			$user_ipqc_vi_read_access = true;
		}
	}
	/* Rename Module 2023
		<p class="announcement-text fa-lg"> Visual Inspection Result</p>
	*/ 

	if( $user_ipqc_vi_read_access ){
		echo '<div class="col-xs-12 col-sm-6 col-lg-4 selection-tab">
				<a href="#" id="a_vir">
					<div class="panel panel-info" style="padding:0px;">
					  <div class="panel-heading">
						<div class="row">
						  <div class="col-xs-3">
							<i class="fa fa-file fa-5x"></i>
						  </div>
						  <div class="col-xs-9 text-right">
							<p class="announcement-heading"></p>
							<p class="announcement-text fa-lg"> In-line Quality Control Monitoring</p>
						  </div>
						</div>
					  </div>
					  
						<div class="panel-footer announcement-bottom">
						  <div class="row">
							<div class="col-xs-6">
							  Open
							</div>
							<div class="col-xs-6 text-right">
							  <i class="fa fa-arrow-circle-right"></i>
							</div>
						  </div>
						</div>
					</div>
				</a>
			</div>';
	}	
	
	/* Check if there is a read role on one IPQC modules */
	/* Dimension Inspection Result */
	$user_ipqc_vi_read_access = false;
	foreach($user_role['subsystem_code'] as $key => $subsystem_code ){
		if($subsystem_code == "IPQC" && $user_role['module'][$key] == "Dimension Inspection Result" && $user_role['read'][$key] == 1){ 
			$user_ipqc_vi_read_access = true;
		}
	}
	if( $user_ipqc_vi_read_access ){
		echo '<div class="col-xs-12 col-sm-6 col-lg-4 selection-tab">
				<a href="#" id="a_dir">
					<div class="panel panel-info" style="padding:0px;">
					  <div class="panel-heading">
						<div class="row">
						  <div class="col-xs-3">
							<i class="fa fa-file fa-5x"></i>
						  </div>
						  <div class="col-xs-9 text-right">
							<p class="announcement-heading"></p>
							<p class="announcement-text fa-lg"> Dimension Inspection Result</p>
						  </div>
						</div>
					  </div>
						<div class="panel-footer announcement-bottom">
						  <div class="row">
							<div class="col-xs-6">
							  Open
							</div>
							<div class="col-xs-6 text-right">
							  <i class="fa fa-arrow-circle-right"></i>
							</div>
						  </div>
						</div>
					</div>
				</a>
			</div>';
	}
	$user_ipqc_lmr_read_access = false;
	foreach($user_role['subsystem_code'] as $key => $subsystem_code ){
		if($subsystem_code == "IPQC" && $user_role['module'][$key] == "LQC Monitoring Result" && $user_role['read'][$key] == 1){ 
			$user_ipqc_lmr_read_access = true;
		}
	}
	if($user_ipqc_lmr_read_access){
		echo '<div class="col-xs-12 col-sm-6 col-lg-4 selection-tab">
				<a href="#" id="a_lmr">
					<div class="panel panel-info" style="padding:0px;">
					  <div class="panel-heading">
						<div class="row">
						  <div class="col-xs-3">
							<i class="fa fa-file fa-5x"></i>
						  </div>
						  <div class="col-xs-9 text-right">
							<p class="announcement-heading"></p>
							<p class="announcement-text fa-lg"> LQC Monitoring Result</p>
						  </div>
						</div>
					  </div>
						<div class="panel-footer announcement-bottom">
						  <div class="row">
							<div class="col-xs-6">
							  Open
							</div>
							<div class="col-xs-6 text-right">
							  <i class="fa fa-arrow-circle-right"></i>
							</div>
						  </div>
						</div>
					</div>
				</a>
			</div>';
	}
	
	?>