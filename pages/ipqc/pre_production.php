<?php
/* get user role */
$ipqc_pp_access = array("create" => false, 
						"read" => false,
						"update" => false,
						"delete" => false
						);
$subsystem_code 			= "IPQC";
$module 					= "Preproduction";
foreach($user_role['subsystem_code'] as $key => $subsystem_code_value ){
	if($subsystem_code == $subsystem_code_value && $user_role['module'][$key] == $module && $user_role['role'][$key]=='SUPERVISOR'){ 
		if ($user_role['create'][$key] == 1){
			$ipqc_pp_access['create'] = true;
		}
		if ($user_role['read'][$key] == 1){
			$ipqc_pp_access['read'] = true;
		}
		if ($user_role['update'][$key] == 1){
			$ipqc_pp_access['update'] = true;
		}
		if ($user_role['delete'][$key] == 1){
			$ipqc_pp_access['delete'] = true;
		}
	}
}

?>

<div class="col-sm-12">
	<div class="panel panel-info">
		<div class="panel-heading"><i class="fa fa-puzzle-piece fa-lg"> Pre-production Result</i></div>
		<div class="panel-body">
			<div class="row">
				<div class="col-sm-8">
					<button type="button" class="btn btn-default fa" id="btn_pp_search_main"><i class="fa fa-search"></i> Search</button>
				</div>
				<div class="col-sm-4">									
					<?php
						if($ipqc_pp_access['create']){
							echo '<button type="button" class="btn btn-primary fa fa-plus pull-right" id="btn_pp_new_inspection_main" style="margin-right:3px;"> New Inspection</button>';
						}
					?>
					<!-- <button type="button" class="btn btn-success fa fa-file-excel-o pull-right" id="btn_pp_report_main" style="margin-right:3px;"> Report</button> -->
				</div><br><br>
				<div class="col-sm-12">
					<table class="table table-striped table-bordered table-condensed" id="tbl_pre_production">
						<thead>
							<th>Machine</th>
							<th>Machine #</th>
							<th>Month - Year</th>
							<th>Pre-production File</th>
							<th>Checked by</th>
							<th>Approved by</th>
							<!-- <th>Measurescope File</th> -->
							<th><center>Action</center></th>
						</thead>
						<tbody>							
						</tbody>
					</table>
				</div>
			</div>
		</div>
	</div>
</div>

<div class="modal fade" tabindex="-1" role="dialog" id="modal_pp_create_new_inspection">
  <div class="modal-dialog modal-lg" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
        <h4 class="modal-title fa fa-plus"> New Pre Production</h4>
      </div>
      <div class="modal-body" style="overflow:inherit;">	
		<form id="frm_pp_save_inspection_result">	  
		<div class="row">
			<div class="col-sm-12">
				<div class="alert alert-danger" style="display:none" role="alert" id="container_msg_create_new_inspection">			
                </div>		
			</div>
		</div>	
		<div class="row" id="">	
			<div class="col-sm-2">
				<label class="fa fa-md">Machine Type: </label>
			</div>
			<div class="col-sm-4">
				<select class="form-control" id="machine" name="machine" required>
				</select>
			</div>
			<div class="col-sm-2">
				<label class="fa fa-md">Measurescope File: </label>
			</div>
			<div class="col-sm-4">
				<input type="file" class="form-control" id="measurescope_file" name="measurescope_file" accept=".xlsx, .xls, .xlsm, .csv, application/vnd.openxmlformats-officedocument.spreadsheetml.sheet, application/vnd.ms-excel" required>
			</div>
		</div>		
		<div class="row">
			<div class="col-sm-2">
				<label class="fa fa-md">Machine #: </label>
			</div>
			<div class="col-sm-4">
				<input type="text" class="form-control" id="measurescope_no" name="measurescope_no" required>
			</div>
			<div class="col-sm-2">
				<label class="fa fa-md">Month / Year: </label>
			</div>
			<div class="col-sm-4">
				<input type="month" class="form-control" id="meas_year_month" name="meas_year_month" max="<?php echo date('Y-m'); ?>" required>
			</div>
		</div>
		<div class="row">
			<div class="col-sm-2">
				<label class="fa fa-md">Checked by: </label>
			</div>
			<div class="col-sm-4">
				<select class="" id="cmb_checked_by" name="checked_by[]" multiple="checked_by" style="width:100%;" required>
				</select>
			</div>
			<div class="col-sm-2">
				<label class="fa fa-md">Approved by: </label>
			</div>
			<div class="col-sm-4">
				<select class="" id="cmb_approved_by" name="approved_by[]" multiple="approved_by" style="width:100%;" required>
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

<div class="modal fade" tabindex="-1" role="dialog" id="modal_pp_edit_inspection">
  <div class="modal-dialog modal-lg" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
        <h4 class="modal-title fa fa-edit"> Edit Measurescope Inspection</h4>
      </div>
	  <form id="frm_pp_update_inspection_result">
      <div class="modal-body" style="overflow:inherit;">		
		<div class="row">
			<div class="col-sm-12">
				<div class="alert alert-danger" style="display:none" role="alert">			
                </div>		
			</div>
		</div>	
		<div class="row" id="">	
			<div class="col-sm-2">
				<label class="fa fa-md">Machine Type: </label>
			</div>
			<div class="col-sm-4">
				<select class="form-control" id="machine" name="machine" required>
				</select>
			</div>
			<div class="col-sm-2">
				<label class="fa fa-md"><input type="checkbox" id="chk_reselect_file"> Re-upload File: </label>
			</div>
			<div class="col-sm-4">
				<input type="file" id="measurescope_file" name="measurescope_file" style="width: 85%; display:inline-block;" accept=".xlsx, .xls, .xlsm, .csv, application/vnd.openxmlformats-officedocument.spreadsheetml.sheet, application/vnd.ms-excel">
				<a href="#" class="fa fa-file-excel-o" id="btn_dl_measurescope_file" style="display:inline-block;"> Download File</a>
			</div>
		</div>
		<div class="row">
			<div class="col-sm-2">
				<label class="fa fa-md">Machine #: </label>
			</div>
			<div class="col-sm-4">
				<input type="text" class="form-control" id="measurescope_no" name="measurescope_no" required>
			</div>
			<div class="col-sm-2">
				<label class="fa fa-md">Month / Year: </label>
			</div>
			<div class="col-sm-4">
				<input type="month" class="form-control" id="meas_year_month" name="meas_year_month" max="<?php echo date('Y-m'); ?>" required>
			</div>
		</div>
		<div class="row">
			<div class="col-sm-2">
				<label class="fa fa-md">Checked by: </label>
			</div>
			<div class="col-sm-4">
				<select class="" id="cmb_checked_by" name="checked_by[]" multiple="multiple" style="width:100%;" required>
				</select>
			</div>
			<div class="col-sm-2">
				<label class="fa fa-md">Approved by: </label>
			</div>
			<div class="col-sm-4">
				<select class="" id="cmb_approved_by" name="approved_by[]" multiple="multiple" style="width:100%;" required>
				</select>
			</div>
		</div>
      </div>
      <div class="modal-footer">
        <button type="submit" class="btn btn-primary fa fa-save"> Update</button>
        <button type="button" class="btn btn-default fa fa-close" data-dismiss="modal"> Close</button>
      </div>
	  </form>
    </div><!-- /.modal-content -->
  </div><!-- /.modal-dialog -->
</div><!-- /.modal -->

<div class="modal fade" tabindex="-1" role="dialog" id="modal_pp_view_inspection">
  <div class="modal-dialog modal-lg" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
        <h4 class="modal-title fa fa-eye"> View Measurescope Inspection</h4>
      </div>
	  <form id="frm_pp_view_inspection_result">
      <div class="modal-body" style="overflow:inherit;">		
		<div class="row" id="">	
			<div class="col-sm-2">
				<label class="fa fa-md">Machine Type: </label>
			</div>
			<div class="col-sm-4">
				<select class="form-control" id="machine" name="machine" required>
				</select>
			</div>
			<div class="col-sm-2">
				<label class="fa fa-md">Measurescope File: </label>
			</div>
			<div class="col-sm-4">
				<a href="#" class="fa fa-file-excel-o" id="btn_dl_measurescope_file" style="display:inline-block;"> Download File</a>
			</div>
		</div>
		<div class="row">
			<div class="col-sm-2">
				<label class="fa fa-md">Machine #: </label>
			</div>
			<div class="col-sm-4">
				<input type="text" class="form-control" id="measurescope_no" name="measurescope_no">
			</div>
			<div class="col-sm-2">
				<label class="fa fa-md">Month / Year: </label>
			</div>
			<div class="col-sm-4">
				<input type="month" class="form-control" id="meas_year_month" name="meas_year_month">
			</div>
		</div>
		<div class="row">
			<div class="col-sm-2">
				<label class="fa fa-md">Checked by: </label>
			</div>
			<div class="col-sm-4">
				<select class="chosen-select" multiple id="checked_by" name="checked_by">
				</select>
			</div>
			<div class="col-sm-2">
				<label class="fa fa-md">Approved by: </label>
			</div>
			<div class="col-sm-4">
				<select class="chosen-select" multiple id="approved_by" name="approved_by">
				</select>
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

<div class="modal fade" tabindex="-1" role="dialog" id="modal_pp_advance_search">
  <div class="modal-dialog modal-lg" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
        <h4 class="modal-title fa fa-search"> Advance Search</h4>
      </div>
	  <form id="frm_pp_advance_search">
      <div class="modal-body">
		<button type="button" class="btn btn-default fa pull-left fa fa-eraser" id="btn_pp_as_reset"> Reset Search Value</button>
		<button type="button" class="btn btn-primary fa pull-right fa fa-plus" id="btn_pp_as_add"> Add</button>
		<table class="table" id="tbl_pp_advance_search">
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


<div class="modal fade" tabindex="-1" role="dialog" id="modal_pp_delete">
  <div class="modal-dialog modal-md" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
        <h4 class="modal-title"><span class="fa fa-remove"></span> Delete Report</h4>
      </div>
      <div class="modal-body">
        <form id="form_pp_delete">
			<div class="row">
				<div class="col-sm-12">
					<label class="control-label">Are you sure you want to delete? </label>
					<label id="label_info"></label>
				</div>
				<div class="col-sm-12">
					<input type="hidden" class="form-control" id="pkid" name="pkid">
				</div>
				<div class="col-sm-12">
					<textarea type="text" class="form-control condensed" name="cancel_remarks" placeholder="Please state your reason for cancellation..."required></textarea>
				</div>
			</div>
      </div>
      <div class="modal-footer">
			<button type="submit" class="btn btn-danger"> Confirm</button>
			<button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
		</form>
      </div>
    </div><!-- /.modal-content -->
  </div><!-- /.modal-dialog -->
</div><!-- /.modal -->
