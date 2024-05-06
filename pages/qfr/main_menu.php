<?php
	/* Modified - 11/07/22
		*The NG Report will transfer to IQC Module
			*The programmer will not change the location of ff:
				\\rapid_test\www\TQTS_TS\pages\qfr\ng_report.php
				\\rapid_test\www\TQTS_TS\js\qfr\ng_report.js
				\\rapid_test\www\TQTS_TS\handler\handler_qfr_ng.php
				\\\rapid\www\TQTS_TS\server_side_scripts\qr\dt_ng.php
	*/

	/* Check if there is a read role on one NG Report */
	/*$user_qfr_ngr_read_access = false;
	foreach($user_role['subsystem_code'] as $key => $subsystem_code ){
		if($subsystem_code == "QFR" && $user_role['module'][$key] == "NG Report" && $user_role['read'][$key] == 1){ 
			$user_qfr_ngr_read_access = true;
		}
	}
	if( $user_qfr_ngr_read_access ){
		echo '<div class="col-xs-12 col-sm-6 col-lg-4 selection-tab">
				<a href="#" id="a_ng">
					<div class="panel panel-info" style="padding:0px;">
					  <div class="panel-heading">
						<div class="row">
						  <div class="col-xs-3">
							<i class="fa fa-file fa-5x"></i>
						  </div>
						  <div class="col-xs-9 text-right">
							<p class="announcement-heading"></p>
							<p class="announcement-text fa-lg"> NG Report</p>
							<p class="announcement-text fa-md"> 1 Pending Approval</p>
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
	} */
	
	/* Modified - 11/07/22
		*The SAR Report will transfer to IQC Module
			*The programmer will not change the location of ff:
				\\rapid_test\www\TQTS_TS\pages\qfr\special_acceptance.php
				\\rapid_test\www\TQTS_TS\js\qfr\special_acceptance.js
				\\rapid_test\www\TQTS_TS\handler\handler_qfr.php
				\\rapid\www\TQTS_TS\server_side_scripts\qr\sa.php
				\\\\rapid\www\TQTS_TS\reports\excel_qfr_sa_report_download.php
				\\\\rapid\www\TQTS_TS\reports\excel_qfr_sa_for_disposition_download.php
				\\\\rapid\www\TQTS_TS\reports\excel_qfr_sa_report_download.php

	*/
	/* Check if there is a read role on one Special Acceptance */
	// $user_qfr_sa_read_access = false;
	// foreach($user_role['subsystem_code'] as $key => $subsystem_code ){
	// 	if($subsystem_code == "QFR" && $user_role['module'][$key] == "Special Acceptance" && $user_role['read'][$key] == 1){ 
	// 		$user_qfr_sa_read_access = true;
	// 	}
	// }
	// if( $user_qfr_sa_read_access ){
	// 	echo '<div class="col-xs-12 col-sm-6 col-lg-4 selection-tab">
	// 			<a href="#" id="a_sa">
	// 				<div class="panel panel-info" style="padding:0px;">
	// 				  <div class="panel-heading">
	// 					<div class="row">
	// 					  <div class="col-xs-3">
	// 						<i class="fa fa-file fa-5x"></i>
	// 					  </div>
	// 					  <div class="col-xs-9 text-right">
	// 						<p class="announcement-heading"></p>
	// 						<p class="announcement-text fa-lg"> Special Acceptance</p>
	// 					  </div>
	// 					</div>
	// 				  </div>
	// 					<div class="panel-footer announcement-bottom">
	// 					  <div class="row">
	// 						<div class="col-xs-6">
	// 						  Open
	// 						</div>
	// 						<div class="col-xs-6 text-right">
	// 						  <i class="fa fa-arrow-circle-right"></i>
	// 						</div>
	// 					  </div>
	// 					</div>
	// 				</div>
	// 			</a>
	// 		</div>';
	// }
	/* Check if there is a read role on one AYE */
	/* AYE will remove to QFR because this module is excluded to the TQTS */
	// $user_aye_sa_read_access = false;
	// foreach($user_role['subsystem_code'] as $key => $subsystem_code ){
	// 	if($subsystem_code == "QFR" && $user_role['module'][$key] == "AYE Report" && $user_role['read'][$key] == 1){ 
	// 		$user_aye_sa_read_access = true;
	// 	}
	// }
	// if( $user_aye_sa_read_access ){
	// 	echo '<div class="col-xs-12 col-sm-6 col-lg-4 selection-tab">
	// 			<a href="#" id="a_aye">
	// 				<div class="panel panel-info" style="padding:0px;">
	// 				  <div class="panel-heading">
	// 					<div class="row">
	// 					  <div class="col-xs-3">
	// 						<i class="fa fa-file fa-5x"></i>
	// 					  </div>
	// 					  <div class="col-xs-9 text-right">
	// 						<p class="announcement-heading"></p>
	// 						<p class="announcement-text fa-lg"> AYE Report</p>
	// 					  </div>
	// 					</div>
	// 				  </div>
	// 					<div class="panel-footer announcement-bottom">
	// 					  <div class="row">
	// 						<div class="col-xs-6">
	// 						  Open
	// 						</div>
	// 						<div class="col-xs-6 text-right">
	// 						  <i class="fa fa-arrow-circle-right"></i>
	// 						</div>
	// 					  </div>
	// 					</div>
	// 				</div>
	// 			</a>
	// 		</div>';
	// }
	/* Check if there is a read role on one PTIS */
	$user_aye_sa_read_access = false;
	foreach($user_role['subsystem_code'] as $key => $subsystem_code ){
		if($subsystem_code == "QFR" && $user_role['module'][$key] == "PTIS" && $user_role['read'][$key] == 1){ 
			$user_aye_sa_read_access = true;
		}
	}
	if( $user_aye_sa_read_access ){
		echo '<div class="col-xs-12 col-sm-6 col-lg-4 selection-tab">
				<a href="#" id="a_ptis">
					<div class="panel panel-info" style="padding:0px;">
					  <div class="panel-heading">
						<div class="row">
						  <div class="col-xs-3">
							<i class="fa fa-file fa-5x"></i>
						  </div>
						  <div class="col-xs-9 text-right">
							<p class="announcement-heading"></p>
							<p class="announcement-text fa-lg"> PTIS</p>
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
	
	/* Check if there is a read role on one QCFR */
	$user_qar_qcfr_read_access = false;
	foreach($user_role['subsystem_code'] as $key => $subsystem_code ){
		if($subsystem_code == "QFR" && strstr($user_role['module'][$key], "QCFR") && $user_role['read'][$key] == 1){ 
			$user_qar_qcfr_read_access = true; break;
		}
	}
	if( $user_qar_qcfr_read_access ){
		echo '<div class="col-xs-12 col-sm-6 col-lg-4 selection-tab">
				<a href="#" id="a_qcfr">
					<div class="panel panel-info" style="padding:0px;">
					  <div class="panel-heading">
						<div class="row">
						  <div class="col-xs-3">
							<i class="fa fa-file fa-5x"></i>
						  </div>
						  <div class="col-xs-9 text-right">
							<p class="announcement-heading"></p>
							<p class="announcement-text fa-lg">  QCFR</p>
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
	
	/* Check if there is a read role on one QCFR */
	$user_qar_itn_read_access = false;
	foreach($user_role['subsystem_code'] as $key => $subsystem_code ){
		if($subsystem_code == "QFR" && $user_role['module'][$key] == "ITN" && $user_role['read'][$key] == 1){ 
			$user_qar_itn_read_access = true;
		}
	}
	if( $user_qar_itn_read_access ){
		echo '<div class="col-xs-12 col-sm-6 col-lg-4 selection-tab">
				<a href="#" id="a_itn">
					<div class="panel panel-info" style="padding:0px;">
					  <div class="panel-heading">
						<div class="row">
						  <div class="col-xs-3">
							<i class="fa fa-file fa-5x"></i>
						  </div>
						  <div class="col-xs-9 text-right">
							<p class="announcement-heading"></p>
							<p class="announcement-text fa-lg">  ITN</p>
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

	/* Check if there is a read role on one Attenton Tag Report */
	$user_qfr_at_read_access = false;
	foreach($user_role['subsystem_code'] as $key => $subsystem_code ){
		if($subsystem_code == "QFR" && $user_role['module'][$key] == "Attention Tag" && $user_role['read'][$key] == 1){ 
			$user_qfr_at_read_access = true;
		}
	}
	if( $user_qfr_at_read_access ){
		echo '<div class="col-xs-12 col-sm-6 col-lg-4 selection-tab">
					<a href="#" id="a_attention_tag">
						<div class="panel panel-info" style="padding:0px;">
						  <div class="panel-heading">
							<div class="row">
							  <div class="col-xs-3">
								<i class="fa fa-file fa-5x"></i>
							  </div>
							  <div class="col-xs-9 text-right">
								<p class="announcement-heading"></p>
								<p class="announcement-text fa-lg">  Attention Tag</p>
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
	/* Check if there is a read role on one 8D Report */
	$user_qfr_8d_read_access = false;
	foreach($user_role['subsystem_code'] as $key => $subsystem_code ){
		if($subsystem_code == "QFR" && $user_role['module'][$key] == "8D Module" && $user_role['read'][$key] == 1){ 
			$user_qfr_8d_read_access = true;
		}
	}
	if( $user_qfr_8d_read_access ){
		echo '<div class="col-xs-12 col-sm-6 col-lg-4 selection-tab">
				<a href="#" id="a_8d">
					<div class="panel panel-info" style="padding:0px;">
					  <div class="panel-heading">
						<div class="row">
						  <div class="col-xs-3">
							<i class="fa fa-file fa-5x"></i>
						  </div>
						  <div class="col-xs-9 text-right">
							<p class="announcement-heading"></p>
							<p class="announcement-text fa-lg"> 8D Report</p>
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
	/* Check if there is a read role on one CAPA Report */
	$user_qfr_capa_read_access = false;
	foreach($user_role['subsystem_code'] as $key => $subsystem_code ){
		if($subsystem_code == "QFR" && (strstr($user_role['module'][$key], "CAPA")) && $user_role['read'][$key] == 1){ 
			$user_qfr_capa_read_access = true;
		}
	}
	if( $user_qfr_capa_read_access ){
		echo '<div class="col-xs-12 col-sm-6 col-lg-4 selection-tab">
				<a href="#" id="a_capa">
					<div class="panel panel-info" style="padding:0px;">
					  <div class="panel-heading">
						<div class="row">
						  <div class="col-xs-3">
							<i class="fa fa-file fa-5x"></i>
						  </div>
						  <div class="col-xs-9 text-right">
							<p class="announcement-heading"></p>
							<p class="announcement-text fa-lg"> CAPA Monitoring Report</p>
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
	
	/* NOTE: MODIFIED 2023: The customer claim is not inluded to TQTS V2 */
	/* Check if there is a read role on one Customer Claim Response */
	// $user_qfr_ccr_read_access = false;
	// foreach($user_role['subsystem_code'] as $key => $subsystem_code ){
	// 	if($subsystem_code == "QFR" && $user_role['module'][$key] == "Customer Claim Response" && $user_role['read'][$key] == 1){ 
	// 		$user_qfr_ccr_read_access = true;
	// 	}
	// }
	// if( $user_qfr_ccr_read_access ){
	// 	echo '<div class="col-xs-12 col-sm-6 col-lg-4 selection-tab">
	// 			<a href="#" id="a_ccr">
	// 				<div class="panel panel-info" style="padding:0px;">
	// 				  <div class="panel-heading">
	// 					<div class="row">
	// 					  <div class="col-xs-3">
	// 						<i class="fa fa-file fa-5x"></i>
	// 					  </div>
	// 					  <div class="col-xs-9 text-right">
	// 						<p class="announcement-heading"></p>
	// 						<p class="announcement-text fa-lg"> Customer Claim Response</p>
	// 					  </div>
	// 					</div>
	// 				  </div>
					  
	// 					<div class="panel-footer announcement-bottom">
	// 					  <div class="row">
	// 						<div class="col-xs-6">
	// 						  Open
	// 						</div>
	// 						<div class="col-xs-6 text-right">
	// 						  <i class="fa fa-arrow-circle-right"></i>
	// 						</div>
	// 					  </div>
	// 					</div>
	// 				</div>
	// 			</a>
	// 		</div>';
	// }
	/* Check if there is a read role on one Loss cost data */
	$user_qfr_lcd_read_access = false;
	foreach($user_role['subsystem_code'] as $key => $subsystem_code ){
		if($subsystem_code == "QFR" && $user_role['module'][$key] == "Loss Cost Data" && $user_role['read'][$key] == 1){ 
			$user_qfr_lcd_read_access = true;
		}
	}
	if( $user_qfr_lcd_read_access ){
		echo '<div class="col-xs-12 col-sm-6 col-lg-4 selection-tab">
				<a href="#" id="a_lcd">
					<div class="panel panel-info" style="padding:0px;">
					  <div class="panel-heading">
						<div class="row">
						  <div class="col-xs-3">
							<i class="fa fa-file fa-5x"></i>
						  </div>
						  <div class="col-xs-9 text-right">
							<p class="announcement-heading"></p>
							<p class="announcement-text fa-lg"> Loss cost data</p>
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







