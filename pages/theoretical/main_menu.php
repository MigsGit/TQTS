<?php
	/* Check if there is a read role on one CCTE modules */
	$user_ccte_read_access = false;
	foreach($user_role['subsystem_code'] as $key => $subsystem_code ){
		if($subsystem_code == "CCTE" && $user_role['module'][$key] == "Customer Claim Theoretical Examination" && $user_role['read'][$key] == 1){ 
			$user_ccte_read_access = true;
		}
	}
	if( $user_ccte_read_access ){
		echo '<div class="col-xs-12 col-sm-6 col-lg-4 selection-tab">
				<a href="#" id="a_yp">
					<div class="panel panel-info" style="padding:0px;">
					  <div class="panel-heading">
						<div class="row">
						  <div class="col-xs-3">
							<i class="fa fa-file fa-5x"></i>
						  </div>
						  <div class="col-xs-9 text-right">
							<p class="announcement-heading"></p>
							<p class="announcement-text fa-lg"> Theoretical Exam</p>
							<p class="announcement-text fa"> Theoretical Exam</p>
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


