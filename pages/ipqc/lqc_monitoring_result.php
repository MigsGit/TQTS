<?
$user_access = array(	'create'=>false,
						'read'=>false,
						'update'=>false,
						'delete'=>false
						);

	$current_subsystem = 'IPQC';
	$current_module = 'LQC Monitoring Result';
	foreach($user_role['subsystem_code'] as $key => $subsystem){
		if ($subsystem == $current_subsystem && $user_role['module'][$key] == $current_module && $user_role['role'][$key]=='SUPERVISOR'){
			if($user_role['create'][$key]==1){
				$user_access['create']=true;
			}
		}
	}
?>

<div class="col-sm-12">
	<div class="panel panel-info">
		<div class="panel-heading"><i class="fa fa-puzzle-piece fa-lg">LQC Monitoring Result</i></div>
		<div class="panel-body">
            <div class="row">
                <div class="col-sm-8" >
                    <button type="button" class="btn btn-default fa">
                        Search
                    </button>
                </div>
                <div class="col-sm-4">
					<?php
						if($user_access['create']){
							echo '<button type="button" id="add_lqc_monitoring" class="btn btn-primary fa fa-plus pull-right">Add</button>';
						}
					?>
                </div>
            
            </div><br>
            <div class="row">
                <div class="col-sm-12">
                    <table class="table table-striped table-bordered table-condensed" id="tbl_lqc_monitoring">
                        <thead>
                                <th>Status</th>
                                <th>Details</th>
                                <th>Month - Year</th>
                                <th>File</th>
                                <th>Checked by</th>
                                <th>Approved by</th>
                                <th><center>Action</center></th>
                        </thead>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>


<!-- Modal Create -->
<div class="modal fade" tabindex="-1" role="dialog" id="modal_lqc_monitoring">
  <div class="modal-dialog modal-lg" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
        <h4 class="modal-title fa fa-plus"> New LQC Monitoring Result</h4>
      </div>
      <div class="modal-body" style="overflow:inherit;">	
		<form id="form_lqc_monitoring">	  
		<div class="row">
		</div>	
		<div class="row" id="">	
            <div class="col-sm-3">
				<input class="fa fa-md" type = "radio" name = "radio_type" value ="Machine" required> Machine #
				<input class="fa fa-md" type = "radio" name = "radio_type" value ="Area" required> Area :
			</div>
			<div class="col-sm-3">
				<input type="text" class="form-control" id="monitoring_no" name="monitoring_no" required>
			</div>
			
			<div class="col-sm-2">
				<label class="fa fa-md">Monitoring File: </label>
			</div>
			<div class="col-sm-4">
				<input type="file" class="form-control" id="monitoring_file" name="monitoring_file" 
                 accept=".xlsx, .xls, .xlsm, .csv, application/vnd.openxmlformats-officedocument.spreadsheetml.sheet, application/vnd.ms-excel" required>
			</div>
		</div>		
		<div class="row">
			<div class="col-sm-2">
				<label class="fa fa-md">Monitoring Type: </label>
			</div>
			<div class="col-sm-4">
				<select class="form-control" id="monitoring_type" name="monitoring_type" required>
                     <option value="" selected disabled>-Select Monitoring Type-</option>
				</select>
			</div>
			<div class="col-sm-2">
				<label class="fa fa-md">Month / Year: </label>
			</div>
			<div class="col-sm-4">
				<input type="month" class="form-control" id="monitoring_year_month" name="monitoring_year_month" max="<?php echo date('Y-m'); ?>" required>
			</div>
		</div>
		<div class="row">
			<div class="col-sm-2">
				<label class="fa fa-md">Checked by: </label>
			</div>
			<div class="col-sm-4">
				<select class="" id="cmb_checked_by" name="checked_by" multiple="checked_by" style="width:100%;" required>
				</select>
			</div>
			<div class="col-sm-2">
				<label class="fa fa-md">Approved by: </label>
			</div>
			<div class="col-sm-4">
				<select class="" id="cmb_approved_by" name="approved_by" multiple="approved_by" style="width:100%;" required>
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


<!-- Modal Update -->
<div class="modal fade" tabindex="-1" role="dialog" id="modal_update_lqc_monitoring">
  <div class="modal-dialog modal-lg" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
        <h4 class="modal-title fa fa-plus">View/Edit LQC Monitoring Result</h4>
      </div>
      <div class="modal-body" style="overflow:inherit;">	
		<form id="form_update_lqc_monitoring">	  
		<div class="row">
			<div class="col-sm-3">
				<input class="form-control" type="hidden" name="pkid" id="pkid" required>
			</div>
		</div>	
		<div class="row" id="">	
            <div class="col-sm-3">
				<input class="fa fa-md" type = "radio" name = "radio_type" id="machine" value ="Machine" required> Machine # 
				<input class="fa fa-md" type = "radio" name = "radio_type" id="area" value ="Area" required> Area :
			</div>
			<div class="col-sm-3">
				<input type="text" class="form-control" id="monitoring_no" name="monitoring_no" required>
			</div>
			
			<div class="col-sm-3">
				<input type="checkbox" id="checkbox_file" class="fa fa-md"> Monitoring File:
			</div>
			<div class="col-sm-3">
				<input class="form-control" type="hidden" id="input_selected_file" name="txt_selected_file">
				<input  class="form-control" type="file" id="monitoring_file" name="monitoring_file" 
                 accept=".xlsx, .xls, .xlsm, .csv, application/vnd.openxmlformats-officedocument.spreadsheetml.sheet, application/vnd.ms-excel">
				 <a class ="fa fa-file-excel-o" href="#" id="btn_selected_file"> Download Attachment</a>

			</div>
		</div>		
		<div class="row">
			<div class="col-sm-2">
				<label class="fa fa-md">Monitoring Type: </label>
			</div>
			<div class="col-sm-4">
				<select class="form-control" id="monitoring_type" name="monitoring_type" required>
                     <option value="" selected disabled>-Select Monitoring Type-</option>
				</select>
			</div>
			<div class="col-sm-2">
				<label class="fa fa-md">Month / Year: </label>
			</div>
			<div class="col-sm-4">
				<input type="month" class="form-control" id="monitoring_year_month" name="monitoring_year_month" max="<?php echo date('Y-m'); ?>" required>
			</div>
		</div>
		<div class="row">
			<div class="col-sm-2">
				<label class="fa fa-md">Checked by: </label>
			</div>
			<div class="col-sm-4">
				<select class="" id="cmb_checked_by" name="checked_by" multiple="checked_by" style="width:100%;" required>
				</select>
			</div>
			<div class="col-sm-2">
				<label class="fa fa-md">Approved by: </label>
			</div>
			<div class="col-sm-4">
				<select class="" id="cmb_approved_by" name="approved_by" multiple="approved_by" style="width:100%;" required>
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

<!-- Modal - View-AttentionTag -->
<div class="modal fade" tabindex="-1" role="dialog" id="modal_remove_lqc_monitoring">
  <div class="modal-dialog modal-md" role="document">
	  <!-- Modal content-->
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
        <h4 class="modal-title"><span class="fa fa-remove"></span> Delete Report</h4>
      </div>
      <div class="modal-body">
        <form id="form_remove_lqc_monitoring">
			<div class="row">
				<div class="col-sm-12">
					<label class="control-label">Are you sure you want to delete? </label>
					<label id="label_info"></label>
				</div>
				<div class="col-sm-12">
					<input type="hidden" name="pkid">
					<textarea type="text" class="form-control condensed" name="deleted_remarks" placeholder="Please state your reason for cancellation" required></textarea>
				</div>
			</div>
      </div>
      <div class="modal-footer">
			<button type="submit" class="btn btn-danger fa fa-check"> Confirm</button>
			<button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
		</form>
      </div>
    </div><!-- /.modal-content -->
  </div><!-- /.modal-dialog -->
</div><!-- /.modal -->