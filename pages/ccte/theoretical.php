<?php 

$ccte_examinee_access 	    = array("create" => false, 
									"read" => false,
									"update" => false,
									"delete" => false
									);
$subsystem_code 			= "CCTE";
$module 					= "Customer Claim Theoretical Exam";
foreach($user_role['subsystem_code'] as $key => $subsystem_code2 ){
	if($subsystem_code == $subsystem_code2 && $user_role['module'][$key] == $module){ 
		if ($user_role['create'][$key] == 1){
			$ccte_examinee_access['create'] = true;
		}
		if ($user_role['read'][$key] == 1){
			$ccte_examinee_access['read'] = true;
		}
		if ($user_role['update'][$key] == 1){
			$ccte_examinee_access['update'] = true;
		}
		if ($user_role['delete'][$key] == 1){
			$ccte_examinee_access['delete'] = true;
		}
	}
}
$ccte_admin_access 	    = array("create" => false, 
									"read" => false,
									"update" => false,
									"delete" => false
									);
$subsystem_code 			= "CCTE";
$module 					= "Customer Claim Theoretical Exam - Admin";
foreach($user_role['subsystem_code'] as $key => $subsystem_code2 ){
	if($subsystem_code == $subsystem_code2 && $user_role['module'][$key] == $module){ 
		if ($user_role['create'][$key] == 1){
			$ccte_admin_access['create'] = true;
		}
		if ($user_role['read'][$key] == 1){
			$ccte_admin_access['read'] = true;
		}
		if ($user_role['update'][$key] == 1){
			$ccte_admin_access['update'] = true;
		}
		if ($user_role['delete'][$key] == 1){
			$ccte_admin_access['delete'] = true;
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
				if($ccte_examinee_access['read']){
					echo '<li role="presentation" class="'.$class_active.'"><a href="#ccte_examinee" aria-controls="ccte_examinee" role="tab" data-toggle="tab">Exam Page</a></li>';
					$class_active = '';
				}
				if($ccte_admin_access['read']){
					echo '<li role="presentation" class="'.$class_active.'"><a href="#ccte_admin" aria-controls="ccte_admin" role="tab" data-toggle="tab">LQC Supervisor</a></li>';
					$class_active = '';
				}
				
			?>
			
		</ul>
	</div>
</div>





<div class="tab-content">
	<?php
		$class_active = "active";
		if($ccte_examinee_access['read']){
			echo '<div role="tabpanel" class="tab-pane '.$class_active.'" id="ccte_examinee">	
					<div class="col-sm-12">
						<div class="panel panel-info">
							<div class="panel-heading"><i class="fa fa-puzzle-piece fa-lg"> Theoretical Exam</i></div>
							<div class="panel-body">
								<div class="row">
									<div class="col-sm-6">
										<!-- <button class="btn btn-default fa" id="btn_oqc_lon_search_main"><i class="fa fa-search"></i> Search</button> -->
									</div>
									<div class="col-sm-6">';
										if($ccte_examinee_access['create']){
											echo '<button class="btn btn-primary fa pull-right" id="btn_new_exam"><i class="fa fa-plus"></i> NEW</button>';
										}
									echo '</div>
								</div>
								<div class="row">
									<div class="col-sm-12"><br />
										<table class="table table-striped table-bordered table-condensed" id="tbl_examinee">
											<thead>
												<th>Status</th>
												<th>Date Exam</th>
												<th>Series Name</th>
												<th>Score</th>
												<th>Result</th>
												<th>Checked Logs</th>
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
	
		if($ccte_admin_access['read']){
			echo '<div role="tabpanel" class="tab-pane '.$class_active.'" id="ccte_admin">	
					<div class="col-sm-12">
						<div class="panel panel-info">
							<div class="panel-heading"><i class="fa fa-puzzle-piece fa-lg"> Theoretical Exam</i></div>
							<div class="panel-body">
								<div class="row">
									<div class="col-sm-6">
										<!-- <button class="btn btn-default fa" id="btn_oqc_lon_search_main"><i class="fa fa-search"></i> Search</button> -->
									</div>
									<div class="col-sm-6"></div>
								</div>
								<div class="row">
									<div class="col-sm-12"><br />
										<table class="table table-striped table-bordered table-condensed" id="tbl_admin">
											<thead>
												<th>Status</th>
												<th>Employee #</th>
												<th>Employee Name</th>
												<th>Date Exam</th>
												<th>Series Name</th>
												<th>Score</th>
												<th>Result</th>
												<th>Checked by</th>
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

<div class="modal fade" tabindex="-1" role="dialog" id="mdl_new_exam">
  <div class="modal-dialog modal-lg" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
        <h4 class="modal-title"><i class="fa fa-edit"></i> Theoretical Exam</h4>
      </div>
	  <form id="frm_new_exam" method="post">
		  <div class="modal-body">
			<div class="row">
				<div class="col-sm-2">
					<label class="fa fa-md">Emp #: </label>
				</div>
				<div class="col-sm-4">
					<input type="text" class="form-control" id="empno" name="empno" readonly>
				</div>
				<div class="col-sm-2">
					<label class="fa fa-md">Date: </label>
				</div>
				<div class="col-sm-4">
					<input type="text" class="form-control" value="<?php echo date('M d, Y'); ?>" id="date_exam" name="date_exam" readonly>
				</div>
			</div>
			<div class="row">
				<div class="col-sm-12">
					<label class="fa fa-md">Series Name: </label>
				</div>
				<div class="col-sm-12">
					<input type="text" class="form-control" id="series_name" name="series_name">
				</div>
			</div>
			<div class="row">
				<div class="col-sm-12">
					<label class="fa fa-md">Defect Phenomenon: </label>
				</div>
				<div class="col-sm-12">
					<input type="text" class="form-control" id="defect" name="defect">
				</div>
			</div>
			<div class="row">
				<div class="col-sm-12">
					<label class="fa fa-md">Brief Description of Analysis: </label>
				</div>
				<div class="col-sm-12">
					<textarea class="form-control" id="brief_desc" name="brief_desc" rows="10"></textarea>
				</div>
			</div>
			<div class="row">
				<div class="col-sm-12">
					<label class="fa fa-md">State of Corrective and Preventive Measures: </label>
				</div>
				<div class="col-sm-12">
					<textarea class="form-control" id="state" name="state" rows="10"></textarea>
				</div>
			</div>
		  </div>
		  <div class="modal-footer">
			<button type="button" class="btn btn-default fa fa-save"> Save as Draft</button>
			<button type="submit" class="btn btn-primary fa fa-envelope-o"> Submit</button>
			<button type="button" class="btn btn-default fa fa-close" data-dismiss="modal"> Close</button>
		  </div>
		</form><!-- /#frm_upload_measdata -->
    </div><!-- /.modal-content -->
  </div><!-- /.modal-dialog -->
</div><!-- /.modal -->

<div class="modal fade" tabindex="-1" role="dialog" id="mdl_edit_exam">
  <div class="modal-dialog modal-lg" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
        <h4 class="modal-title"><i class="fa fa-edit"></i> Theoretical Exam</h4>
      </div>
	  <form id="frm_edit_exam" method="post">
		  <div class="modal-body">
			<div class="row">
				<div class="col-sm-2">
					<label class="fa fa-md">Emp #: </label>
				</div>
				<div class="col-sm-4">
					<input type="text" class="form-control" id="empno" name="empno" readonly>
				</div>
				<div class="col-sm-2">
					<label class="fa fa-md">Date: </label>
				</div>
				<div class="col-sm-4">
					<input type="text" class="form-control" value="<?php echo date('M d, Y'); ?>" id="date_exam" name="date_exam" readonly>
				</div>
			</div>
			<div class="row">
				<div class="col-sm-12">
					<label class="fa fa-md">Series Name: </label>
				</div>
				<div class="col-sm-12">
					<input type="text" class="form-control" id="series_name" name="series_name">
				</div>
			</div>
			<div class="row">
				<div class="col-sm-12">
					<label class="fa fa-md">Defect Phenomenon: </label>
				</div>
				<div class="col-sm-12">
					<input type="text" class="form-control" id="defect" name="defect">
				</div>
			</div>
			<div class="row">
				<div class="col-sm-12">
					<label class="fa fa-md">Brief Description of Analysis: </label>
				</div>
				<div class="col-sm-12">
					<textarea class="form-control" id="brief_desc" name="brief_desc" rows="10"></textarea>
				</div>
			</div>
			<div class="row">
				<div class="col-sm-12">
					<label class="fa fa-md">State of Corrective and Preventive Measures: </label>
				</div>
				<div class="col-sm-12">
					<textarea class="form-control" id="state" name="state" rows="10"></textarea>
				</div>
			</div>
		  </div>
		  <div class="modal-footer">
			<button type="button" class="btn btn-default fa fa-save"> Save as Draft</button>
			<button type="submit" class="btn btn-primary fa fa-envelope-o"> Submit</button>
			<button type="button" class="btn btn-default fa fa-close" data-dismiss="modal"> Close</button>
		  </div>
		</form><!-- /#frm_upload_measdata -->
    </div><!-- /.modal-content -->
  </div><!-- /.modal-dialog -->
</div><!-- /.modal -->

<div class="modal fade" tabindex="-1" role="dialog" id="mdl_view_exam">
  <div class="modal-dialog modal-lg" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
        <h4 class="modal-title"><i class="fa fa-eye"></i> Theoretical Exam</h4>
      </div>
	  <form id="frm_view_exam" method="post">
		  <div class="modal-body">
			<div class="row">
				<div class="col-sm-2">
					<label class="fa fa-md">Emp #: </label>
				</div>
				<div class="col-sm-4">
					<input type="text" class="form-control" id="empno" name="empno" readonly>
				</div>
				<div class="col-sm-2">
					<label class="fa fa-md">Date: </label>
				</div>
				<div class="col-sm-4">
					<input type="text" class="form-control" value="<?php echo date('M d, Y'); ?>" id="date_exam" name="date_exam" readonly>
				</div>
			</div>
			<div class="row">
				<div class="col-sm-12">
					<label class="fa fa-md">Series Name: </label>
				</div>
				<div class="col-sm-12">
					<input type="text" class="form-control" id="series_name" name="series_name" readonly>
				</div>
			</div>
			<div class="row">
				<div class="col-sm-12">
					<label class="fa fa-md">Defect Phenomenon: </label>
				</div>
				<div class="col-sm-12">
					<input type="text" class="form-control" id="defect" name="defect" readonly>
				</div>
			</div>
			<div class="row">
				<div class="col-sm-12">
					<label class="fa fa-md">Brief Description of Analysis: </label>
				</div>
				<div class="col-sm-12">
					<textarea class="form-control" id="brief_desc" name="brief_desc" rows="10" readonly></textarea>
				</div>
			</div>
			<div class="row">
				<div class="col-sm-12">
					<label class="fa fa-md">State of Corrective and Preventive Measures: </label>
				</div>
				<div class="col-sm-12">
					<textarea class="form-control" id="state" name="state" rows="10" readonly></textarea>
				</div>
			</div>
		  </div>
		  <div class="modal-footer">
			<button type="button" class="btn btn-default fa fa-close" data-dismiss="modal"> Close</button>
		  </div>
		</form><!-- /#frm_upload_measdata -->
    </div><!-- /.modal-content -->
  </div><!-- /.modal-dialog -->
</div><!-- /.modal -->

<div class="modal fade" tabindex="-1" role="dialog" id="mdl_exam_confirmation">
  <div class="modal-dialog modal-md" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
        <h4 class="modal-title"><i class="fa fa-question-circle-o"></i> System Confirmation</h4>
      </div>
	  <form id="frm_exam_confirmation">
		  <div class="modal-body">
			<div class="row">			
				<div class="col-sm-12" id="">				
					<div class="alert alert-warning" role="alert">			
						<h4> Are you sure you want to submit the exam? </h4>
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

<div class="modal fade" tabindex="-1" role="dialog" id="mdl_admin_checking">
  <div class="modal-dialog modal-lg" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
        <h4 class="modal-title"><i class="fa fa-edit"></i> Theoretical Exam</h4>
      </div>
	  <form id="frm_admin_checking" method="post">
		  <div class="modal-body">
			<div class="row">
				<div class="col-sm-2">
					<label class="fa fa-md">Emp #: </label>
				</div>
				<div class="col-sm-4">
					<input type="text" class="form-control" id="empno" name="empno" readonly>
				</div>
				<div class="col-sm-2">
					<label class="fa fa-md">Date: </label>
				</div>
				<div class="col-sm-4">
					<input type="text" class="form-control" id="date_exam" name="date_exam" readonly>
				</div>
			</div><br>
			<div class="row">
				<div class="col-sm-2 col-sm-offset-8">
					<center><label class="fa fa-md">Score</label></center>
				</div>
				<div class="col-sm-2">
					<center><label class="fa fa-md">Points</label></center>
				</div>
			</div>
			<div class="row">
				<div class="col-sm-8">
					<label class="fa fa-md">Series Name: </label>
				</div>
				<div class="col-sm-2">
					<input type="number" class="form-control" id="series_name_score" name="series_name_score">
				</div>
				<div class="col-sm-2">
					<input type="number" class="form-control" id="series_name_points" name="series_name_points" readonly>
				</div>
				<div class="col-sm-12">
					<input type="text" class="form-control" id="series_name" name="series_name" readonly>
				</div>
			</div>
			<div class="row">
				<div class="col-sm-8">
					<label class="fa fa-md">Defect Phenomenon: </label>
				</div>
				<div class="col-sm-2">
					<input type="number" class="form-control" id="defect_score" name="defect_score">
				</div>
				<div class="col-sm-2">
					<input type="number" class="form-control" id="defect_points" name="defect_points" readonly>
				</div>
				<div class="col-sm-12">
					<input type="text" class="form-control" id="defect" name="defect" readonly>
				</div>
			</div>
			<div class="row">
				<div class="col-sm-8">
					<label class="fa fa-md">Brief Description of Analysis: </label>
				</div>
				<div class="col-sm-2">
					<input type="number" class="form-control" id="brief_desc_score" name="brief_desc_score">
				</div>
				<div class="col-sm-2">
					<input type="number" class="form-control" id="brief_desc_points" name="brief_desc_points" readonly>
				</div>
				<div class="col-sm-12">
					<textarea class="form-control" id="brief_desc" name="brief_desc" rows="10" readonly></textarea>
				</div>
			</div>
			<div class="row">
				<div class="col-sm-8">
					<label class="fa fa-md">State of Corrective and Preventive Measures: </label>
				</div>
				<div class="col-sm-2">
					<input type="number" class="form-control" id="state_score" name="state_score">
				</div>
				<div class="col-sm-2">
					<input type="number" class="form-control" id="state_points" name="state_points" readonly>
				</div>
				<div class="col-sm-12">
					<textarea class="form-control" id="state" name="state" rows="10" readonly></textarea>
				</div>
			</div>
			<div class="row">
				<div class="col-sm-8">
					<label class="fa fa-md" style="text-align:right;">Total</label>
				</div>
				<div class="col-sm-2">
					<input type="number" class="form-control" id="total_score" readonly>
				</div>
				<div class="col-sm-2">
					<input type="number" class="form-control" id="total_points" readonly>
				</div>
			</div>
		  </div>
		  <div class="modal-footer">
			<button type="submit" class="btn btn-primary fa"><i class="fa fa-save"></i> Submit</button>
			<button type="button" class="btn btn-default fa" data-dismiss="modal"> Close</button>
		  </div>
		</form><!-- /#frm_upload_measdata -->
    </div><!-- /.modal-content -->
  </div><!-- /.modal-dialog -->
</div><!-- /.modal -->

<div class="modal fade" tabindex="-1" role="dialog" id="mdl_admin_view">
  <div class="modal-dialog modal-lg" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
        <h4 class="modal-title"><i class="fa fa-eye"></i> Theoretical Exam</h4>
      </div>
	  <form id="frm_admin_view" method="post">
		  <div class="modal-body">
			<div class="row">
				<div class="col-sm-2">
					<label class="fa fa-md">Emp #: </label>
				</div>
				<div class="col-sm-4">
					<input type="text" class="form-control" id="empno" name="empno" readonly>
				</div>
				<div class="col-sm-2">
					<label class="fa fa-md">Date: </label>
				</div>
				<div class="col-sm-4">
					<input type="text" class="form-control" id="date_exam" name="date_exam" readonly>
				</div>
			</div>
			<div class="row">
				<div class="col-sm-2">
					<label class="fa fa-md">Take: </label>
				</div>
				<div class="col-sm-4">
					<input type="text" class="form-control" id="take_type" name="take_type" readonly>
				</div>
				<div class="col-sm-2">
					<label class="fa fa-md">Result: </label>
				</div>
				<div class="col-sm-4">
					<input type="text" class="form-control" id="exam_result" name="exam_result" readonly>
				</div>
			</div><br>
			<div class="row">
				<div class="col-sm-2 col-sm-offset-8">
					<center><label class="fa fa-md">Score</label></center>
				</div>
				<div class="col-sm-2">
					<center><label class="fa fa-md">Points</label></center>
				</div>
			</div>
			<div class="row">
				<div class="col-sm-8">
					<label class="fa fa-md">Series Name: </label>
				</div>
				<div class="col-sm-2">
					<input type="number" class="form-control" id="series_name_points" name="series_name_points" readonly>
				</div>
				<div class="col-sm-2">
					<input type="number" class="form-control" id="series_name_score" name="series_name_score" readonly>
				</div>
				<div class="col-sm-12">
					<input type="text" class="form-control" id="series_name" name="series_name" readonly>
				</div>
			</div>
			<div class="row">
				<div class="col-sm-8">
					<label class="fa fa-md">Defect Phenomenon: </label>
				</div>
				<div class="col-sm-2">
					<input type="number" class="form-control" id="defect_points" name="defect_points" readonly>
				</div>
				<div class="col-sm-2">
					<input type="number" class="form-control" id="defect_score" name="defect_score" readonly>
				</div>
				<div class="col-sm-12">
					<input type="text" class="form-control" id="defect" name="defect" readonly>
				</div>
			</div>
			<div class="row">
				<div class="col-sm-8">
					<label class="fa fa-md">Brief Description of Analysis: </label>
				</div>
				<div class="col-sm-2">
					<input type="number" class="form-control" id="brief_desc_points" name="brief_desc_points" readonly>
				</div>
				<div class="col-sm-2">
					<input type="number" class="form-control" id="brief_desc_score" name="brief_desc_score" readonly>
				</div>
				<div class="col-sm-12">
					<textarea class="form-control" id="brief_desc" name="brief_desc" rows="10" readonly></textarea>
				</div>
			</div>
			<div class="row">
				<div class="col-sm-8">
					<label class="fa fa-md">State of Corrective and Preventive Measures: </label>
				</div>
				<div class="col-sm-2">
					<input type="number" class="form-control" id="state_points" name="state_points" readonly>
				</div>
				<div class="col-sm-2">
					<input type="number" class="form-control" id="state_score" name="state_score" readonly>
				</div>
				<div class="col-sm-12">
					<textarea class="form-control" id="state" name="state" rows="10" readonly></textarea>
				</div>
			</div>
			<div class="row">
				<div class="col-sm-8">
					<label class="fa fa-md" style="text-align:right;">Total</label>
				</div>
				<div class="col-sm-2">
					<input type="number" class="form-control" id="total_score" readonly>
				</div>
				<div class="col-sm-2">
					<input type="number" class="form-control" id="total_points" readonly>
				</div>
			</div>
		  </div>
		  <div class="modal-footer">
			<button type="button" class="btn btn-default fa" data-dismiss="modal"> Close</button>
		  </div>
		</form><!-- /#frm_upload_measdata -->
    </div><!-- /.modal-content -->
  </div><!-- /.modal-dialog -->
</div><!-- /.modal -->


<div class="modal fade" tabindex="-1" role="dialog" id="mdl_check_confirmation">
  <div class="modal-dialog modal-md" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
        <h4 class="modal-title"><i class="fa fa-question-circle-o"></i> System Confirmation</h4>
      </div>
	  <form id="frm_check_confirmation">
		  <div class="modal-body">
			<div class="row">			
				<div class="col-sm-12" id="">				
					<div class="alert alert-warning" role="alert">			
						<h4> Are you sure you want to submit the exam? </h4>
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