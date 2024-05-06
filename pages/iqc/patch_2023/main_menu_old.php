<?php
	/* Check if there is a read role on one IQC modules */
	$user_iqc_vic_read_access = false;
	foreach($user_role['subsystem_code'] as $key => $subsystem_code ){
		if($subsystem_code == "IQC" && $user_role['module'][$key] == "Visual Inspection Result" && $user_role['read'][$key] == 1){ 
			$user_iqc_vic_read_access = true;
		}
	}
	if( $user_iqc_vic_read_access ){
		echo '<div class="col-xs-12 col-sm-6 col-lg-4 selection-tab">
				<a href="#" id="a_vi">
					<div class="panel panel-info" style="padding:0px;">
					  <div class="panel-heading">
						<div class="row">
						  <div class="col-xs-3">
							<i class="fa fa-file fa-5x"></i>
						  </div>
						  <div class="col-xs-9 text-right">
							<p class="announcement-heading"></p>
							<p class="announcement-text fa-lg"> Visual Inspection Result</p>
							<p class="announcement-text fa"> In-line monitoring/ machine records / 4M voluntary / product  visual result</p>
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
	/* Check if there is a read role on one IQC modules */
	$user_iqc_dic_read_access = false;
	foreach($user_role['subsystem_code'] as $key => $subsystem_code ){
		if($subsystem_code == "IQC" && $user_role['module'][$key] == "Dimension Inspection Result" && $user_role['read'][$key] == 1){ 
			$user_iqc_dic_read_access = true;
		}
	}
	if( $user_iqc_dic_read_access ){
		echo '<div class="col-xs-12 col-sm-6 col-lg-4 selection-tab">
				<a href="#" id="a_di">
					<div class="panel panel-info" style="padding:0px;">
					  <div class="panel-heading">
						<div class="row">
						  <div class="col-xs-3">
							<i class="fa fa-file fa-5x"></i>
						  </div>
						  <div class="col-xs-9 text-right">
							<p class="announcement-heading"></p>
							<p class="announcement-text fa-lg"> Dimension Inspection Result</p>
							<p class="announcement-text fa"> Product Measurement - Measdata</p>
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
	/* check qar read access */
	$user_iqc_qar_read_access = false;
	foreach($user_role['subsystem_code'] as $key => $subsystem_code ){
		if( ($subsystem_code == "IQC" && $user_role['module'][$key] == "Quality Alert Report (QAR) - Requestor" && $user_role['read'][$key] == 1) ||
			 ($subsystem_code == "IQC" && $user_role['module'][$key] == "Quality Alert Report (QAR) - Conformance" && $user_role['read'][$key] == 1) ||
			 ($subsystem_code == "IQC" && $user_role['module'][$key] == "Quality Alert Report (QAR) - Recipient" && $user_role['read'][$key] == 1)
			){ 
			$user_iqc_qar_read_access = true;
		}
	}
	if( $user_iqc_qar_read_access ){
		echo '<div class="col-xs-12 col-sm-6 col-lg-4 selection-tab">
				<a href="#" id="a_qar">
					<div class="panel panel-info" style="padding:0px;">
					  <div class="panel-heading">
						<div class="row">
						  <div class="col-xs-3">
							<i class="fa fa-file fa-5x"></i>
						  </div>
						  <div class="col-xs-9 text-right">
							<p class="announcement-heading"></p>
							<p class="announcement-text fa-lg"> Quality Alert Report</p>
							<p class="announcement-text fa"> QAR</p>
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


