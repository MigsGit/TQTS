<?php
/* get user role */
$ipqc_vi_access 	    = array("create" => false, 
									"read" => false,
									"update" => false,
									"delete" => false
									);
$subsystem_code 			= "IPQC";
$module 					= "Visual Inspection Result";
foreach($user_role['subsystem_code'] as $key => $subsystem_code_value ){
	if($subsystem_code == $subsystem_code_value && $user_role['module'][$key] == $module && $user_role['role'][$key]=='SUPERVISOR'){ 
		if ($user_role['create'][$key] == 1){
			$ipqc_vi_access['create'] = true;
		}
		if ($user_role['read'][$key] == 1){
			$ipqc_vi_access['read'] = true;
		}
		if ($user_role['update'][$key] == 1){
			$ipqc_vi_access['update'] = true;
		}
		if ($user_role['delete'][$key] == 1){
			$ipqc_vi_access['delete'] = true;
		}
	}
}

?>

<div class="col-sm-12">
	<div class="panel panel-info">
		<div class="panel-heading"><i class="fa fa-puzzle-piece fa-lg">In-line Quality Control Monitoring</i></div>
		<div class="panel-body">
			<div class="row">
				<div class="col-sm-8">
					<button type="button" class="btn btn-default fa" id="btn_vi_search_main"><i class="fa fa-search"></i> Search</button>
				</div>
				<div class="col-sm-4">									
					<?php
						if($ipqc_vi_access['create']){
							echo '<button type="button" class="btn btn-primary fa fa-plus pull-right" id="btn_vi_new_inspection_main" style="margin-right:3px;"> New Monitoring</button>';
						}
					?>
					<!--<button type="button" class="btn btn-success fa fa-file-excel-o pull-right" id="btn_vi_report_main" style="margin-right:3px;"> Report</button>-->
				</div><br><br>
				<div class="col-sm-12">
					<table class="table table-striped table-bordered table-condensed" id="tbl_visual_inspection" style="">
						<thead>
							<th>FY</th>
							<th>Line</th>
							<th>WW #</th>
							<th>Shift</th>
							<th>QC Inspector</th> 
							<th>Checked by</th>
							<th>Monitoring File</th>
							<th>Action</th>
						</thead>
						<tbody>
						</tbody>
					</table>
				</div>
			</div>
		</div>
	</div>
</div>

<div class="modal fade" tabindex="-1" role="dialog" id="modal_vi_new_monitoring">
  <div class="modal-dialog modal-lg" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
        <h4 class="modal-title fa fa-plus">New In-Line Quality Control Monitoring</h4>
      </div>
      <div class="modal-body" style="overflow:inherit;">	
		<form id="form_vi_new_monitoring">	  
		<div class="row">
			<div class="col-sm-12">
				<div class="alert alert-danger" style="display:none" role="alert" id="container_msg_create_new_inspection">			
                </div>		
			</div>
		</div>	
		<div class="row">
			<div class="col-sm-2 col-sm-offset-6">
				<label class="fa fa-md">FY: </label>
			</div>
			<div class="col-sm-4">
				<input type="text" class="form-control condensed" id="fiscal_year" name="fiscal_year" maxlength="6" style="text-transform:uppercase" >
			</div>
		</div>
		<div class="row">
			<div class="col-sm-2">
				<label class="fa fa-md">Line: </label>
			</div>
			<div class="col-sm-4">
				<input type="text" class="form-control condensed" id="line_name" name="line_name" required style="text-transform:uppercase" >
			</div>
			<div class="col-sm-2">
				<label class="fa fa-md">Workweek: </label>
			</div>
			<div class="col-sm-4">
				<input type="text" class="form-control condensed" id="workweek" name="workweek">
			</div>
		</div>
		<div class="row">
			<div class="col-sm-2">
				<label class="fa fa-md">Shift: </label>
			</div>
			<div class="col-sm-4">
				<input type="text" class="form-control condensed" maxlength="1" id="shift" name="shift" required style="text-transform:uppercase" >
			</div>
			<div class="col-sm-2">
				<label class="fa fa-md">Monitoring File: </label>
			</div>
			<div class="col-sm-2">
				<input type="file" id="monitoring_file" name="monitoring_file" accept=".xlsx, .xls, .xlsm, .csv, application/vnd.openxmlformats-officedocument.spreadsheetml.sheet, application/vnd.ms-excel" required>
			</div>
		</div>
		<div class="row">
			<div class="col-sm-2">
				<label class="fa fa-md">QC Inspector: </label>
			</div>
			<div class="col-sm-4">
				<select class="" id="inspected_by" name="inspected_by" style="width:100%;" required>
				</select>
			</div>
			<div class="col-sm-2">
				<label class="fa fa-md">Checked by: </label>
			</div>
			<div class="col-sm-4">
				<select class="" id="checked_by" name="checked_by" style="width:100%;" required>
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

<div class="modal fade" tabindex="-1" role="dialog" id="modal_vi_edit_monitoring">
  <div class="modal-dialog modal-lg" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
        <h4 class="modal-title fa fa-edit"> Edit In-Line Quality Control Monitoring</h4>
      </div>
      <div class="modal-body" style="overflow:inherit;">	
		<form id="form_vi_edit_monitoring">	  
		<div class="row">
			<div class="col-sm-12">
				<div class="alert alert-danger" style="display:none" role="alert" id="container_msg_create_new_inspection">			
                </div>		
			</div>
		</div>	
		<div class="row">
			<div class="col-sm-2 col-sm-offset-6">
				<label class="fa fa-md">FY: </label>
			</div>
			<div class="col-sm-4">
				<input type="text" class="form-control condensed" id="fiscal_year" name="fiscal_year" maxlength="6" style="text-transform:uppercase" >
			</div>
		</div>
		<div class="row">
			<div class="col-sm-2">
				<label class="fa fa-md">Line: </label>
			</div>
			<div class="col-sm-4">
				<input type="text" class="form-control condensed" id="line_name" name="line_name" required style="text-transform:uppercase" >
			</div>
			<div class="col-sm-2">
				<label class="fa fa-md">Workweek: </label>
			</div>
			<div class="col-sm-4">
				<input type="text" class="form-control condensed" id="workweek" name="workweek">
			</div>
		</div>
		<div class="row">
			<div class="col-sm-2">
				<label class="fa fa-md">Shift: </label>
			</div>
			<div class="col-sm-4">
				<input type="text" class="form-control condensed" maxlength="1" id="shift" name="shift" required style="text-transform:uppercase" >
			</div>
			<div class="col-sm-2">
				<label class="fa fa-md"><input type="checkbox" id="chk_reselect_file"> Re-upload File: </label>
			</div>
			<div class="col-sm-4">
				<input type="file" id="monitoring_file" name="monitoring_file" style="width: 85%; display:inline-block;" accept=".xlsx, .xls, .xlsm, .csv, application/vnd.openxmlformats-officedocument.spreadsheetml.sheet, application/vnd.ms-excel">
				<a href="#" class="fa fa-file-excel-o" id="pkid" name="pkid" style="display:inline-block;"> Download File</a>
			</div>
		</div>
		<div class="row">
			<div class="col-sm-2">
				<label class="fa fa-md">QC Inspector: </label>
			</div>
			<div class="col-sm-4">
				<select class="" id="inspected_by" name="inspected_by" style="width:100%;" required>
				</select>
			</div>
			<div class="col-sm-2">
				<label class="fa fa-md">Checked by: </label>
			</div>
			<div class="col-sm-4">
				<select class="" id="checked_by" name="checked_by" style="width:100%;" required>
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

<div class="modal fade" tabindex="-1" role="dialog" id="modal_vi_view_monitoring">
  <div class="modal-dialog modal-lg" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
        <h4 class="modal-title fa fa-eye"> View In-Line Quality Control Monitoring</h4>
      </div>
      <div class="modal-body" style="overflow:inherit;">	
		<form id="form_vi_view_monitoring">	  
		<div class="row">
			<div class="col-sm-12">
				<div class="alert alert-danger" style="display:none" role="alert" id="container_msg_create_new_inspection">			
                </div>		
			</div>
		</div>	
		<div class="row">
			<div class="col-sm-2 col-sm-offset-6">
				<label class="fa fa-md">FY: </label>
			</div>
			<div class="col-sm-4">
				<input type="text" class="form-control condensed" id="fiscal_year" name="fiscal_year" maxlength="6" style="text-transform:uppercase" >
			</div>
		</div>
		<div class="row">
			<div class="col-sm-2">
				<label class="fa fa-md">Line: </label>
			</div>
			<div class="col-sm-4">
				<input type="text" class="form-control condensed" id="line_name" name="line_name" required>
			</div>
			<div class="col-sm-2">
				<label class="fa fa-md">Workweek: </label>
			</div>
			<div class="col-sm-4">
				<input type="text" class="form-control condensed" id="workweek" name="workweek">
			</div>
		</div>
		<div class="row">
			<div class="col-sm-2">
				<label class="fa fa-md">Shift: </label>
			</div>
			<div class="col-sm-4">
				<input type="text" class="form-control condensed" maxlength="1" id="shift" name="shift" required>
			</div>
			<div class="col-sm-2">
				<label class="fa fa-md">Monitoring File: </label>
			</div>
			<div class="col-sm-4">
				<a href="#" class="fa fa-file-excel-o" id="pkid" name="pkid" style="display:inline-block;"> Download File</a>
			</div>
		</div>
		<div class="row">
			<div class="col-sm-2">
				<label class="fa fa-md">QC Inspector: </label>
			</div>
			<div class="col-sm-4">
				<select class="" id="inspected_by" name="inspected_by" style="width:100%;" required>
				</select>
			</div>
			<div class="col-sm-2">
				<label class="fa fa-md">Checked by: </label>
			</div>
			<div class="col-sm-4">
				<select class="" id="checked_by" name="checked_by" style="width:100%;" required>
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


<div class="modal fade" tabindex="-1" role="dialog" id="modal_vi_advance_search">
  <div class="modal-dialog modal-lg" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
        <h4 class="modal-title fa fa-search"> Advance Search</h4>
      </div>
	  <form id="frm_vi_advance_search">
      <div class="modal-body">
		<button type="button" class="btn btn-default fa pull-left fa fa-eraser" id="btn_vi_as_reset"> Reset Search Value</button>
		<button type="button" class="btn btn-primary fa pull-right fa fa-plus" id="btn_vi_as_add"> Add</button>
		<table class="table" id="tbl_vi_advance_search">
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

<div class="modal fade" tabindex="-1" role="dialog" id="modal_vir_delete">
  <div class="modal-dialog modal-md" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
        <h4 class="modal-title"><span class="fa fa-remove"></span> Delete Report</h4>
      </div>
      <div class="modal-body">
        <form id="form_vir_delete">
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