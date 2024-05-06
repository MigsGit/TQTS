<?php
/* get user role */
$loss_cost_access 	    = array("create" => false, 
									"read" => false,
									"update" => false,
									"delete" => false
									);
$subsystem_code 			= "QFR";
$module 					= "Loss Cost Data";
foreach($user_role['subsystem_code'] as $key => $subsystem_code ){
	if($subsystem_code == $subsystem_code && $user_role['module'][$key] == $module){ 
		if ($user_role['create'][$key] == 1){
			$loss_cost_access['create'] = true;
		}
		if ($user_role['read'][$key] == 1){
			$loss_cost_access['read'] = true;
		}
		if ($user_role['update'][$key] == 1){
			$loss_cost_access['update'] = true;
		}
		if ($user_role['delete'][$key] == 1){
			$loss_cost_access['delete'] = true;
		}
	}
}

?>

<div class="col-sm-12">
	<div class="panel panel-info">
		<div class="panel-heading"><i class="fa fa-file fa-lg"> Loss Cost Data</i></div>
		<div class="panel-body">
			<div class="row">
				<div class="col-sm-9">
					<!--<button class="btn btn-default fa fa-search" id="btn_qcfr_advanced_search"> Search</button>-->
				</div>
				<div class="col-sm-3">
					<?php
						if($loss_cost_access['create']) {
							echo '<button class="btn btn-default fa fa-plus pull-right" id="btn_new_loss_cost"> New</button>';
						}
					?>
					
				</div>	
			</div><br />
			<div class="row">
				<table class="table table-bordered table-condensed" id="tbl_loss_cost">
					<thead>
						<tr>
							<th>Month/Year</th>
							<th>Attachments</th>
							<th>Remarks</th>
							<th><span class="fa fa-cogs"></span></th>
						</tr>
					</thead>
					<tbody>
					</tbody>
				</table>
			</div>
		</div>
	</div>
</div>

<div class="modal fade" tabindex="-1" role="dialog" id="mdl_new_loss_cost">
  <div class="modal-dialog modal-lg" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
        <h4 class="modal-title"><i class="fa fa-plus"></i> New Loss Cost Record</h4>
      </div>
	  <form id="frm_new_loss_cost" method="post">
		  <div class="modal-body">
			<div class="row">
				<div class="col-sm-2">
					<label class="fa fa-md">Month/Year: </label>
				</div>
				<div class="col-sm-4">
					<input type="month" class="form-control" id="txt_lot_number" name="month_year">    
				</div>
				<div class="col-sm-2">
					<label class="fa fa-md">Choose File: </label>
				</div>
				<div class="col-sm-4">
					<input type="file" class="" id="file_name" name="file_name[]" multiple="multiple" accept="application/pdf" required>
				</div>
			</div>
			<div class="row">
				<div class="col-sm-2">
					<label class="fa fa-md">Remarks: </label>
				</div>
				<div class="col-sm-10">
					<textarea class="form-control" id="txt_remarks" name="remarks"></textarea>
				</div>
			</div>
		  </div>
		  <div class="modal-footer">
			<button type="submit" class="btn btn-primary fa"><i class="fa fa-save"></i> Save</button>
			<button type="button" class="btn btn-default fa" data-dismiss="modal"> Close</button>
		  </div>
		</form><!-- /#frm_upload_measdata -->
    </div><!-- /.modal-content -->
  </div><!-- /.modal-dialog -->
</div><!-- /.modal -->

<div class="modal fade" tabindex="-1" role="dialog" id="mdl_edit_loss_cost">
  <div class="modal-dialog modal-lg" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
        <h4 class="modal-title"><i class="fa fa-edit"></i> Edit Loss Cost Record</h4>
      </div>
	  <form id="frm_edit_loss_cost" method="post">
		  <div class="modal-body">
			<div class="row">
				<div class="col-sm-2">
					<label class="fa fa-md">Month/Year: </label>
				</div>
				<div class="col-sm-4">
					<input type="month" class="form-control" id="txt_lot_number" name="month_year">    
				</div>
				<div class="col-sm-2">
					<label class="fa fa-md">Choose File: </label>
				</div>
				<div class="col-sm-4">
					<input type="file" class="" id="file_name" name="file_name[]" multiple="multiple" accept="application/pdf">
				</div>
			</div>
			<div class="row">
				<div class="col-sm-12">
					<label class="fa fa-md">Attachment/s: </label>
				</div>
				<div class="col-sm-12">
					<table class="table table-striped table-bordered table-condensed">
						<thead>
							<th>File Name (click to download the file)</th>
							<th><center>Remove</center></th>
						</thead>
						<tbody>
						</tbody>
					</table>
				</div>
			</div>
			<div class="row">
				<div class="col-sm-2">
					<label class="fa fa-md">Remarks: </label>
				</div>
				<div class="col-sm-10">
					<textarea class="form-control" id="txt_remarks" name="remarks"></textarea>
				</div>
			</div>
		  </div>
		  <div class="modal-footer">
			<button type="submit" class="btn btn-primary fa"><i class="fa fa-save"></i> Save</button>
			<button type="button" class="btn btn-default fa" data-dismiss="modal"> Close</button>
		  </div>
		</form><!-- /#frm_upload_measdata -->
    </div><!-- /.modal-content -->
  </div><!-- /.modal-dialog -->
</div><!-- /.modal -->

<div class="modal fade" tabindex="-1" role="dialog" id="mdl_view_loss_cost">
  <div class="modal-dialog modal-lg" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
        <h4 class="modal-title"><i class="fa fa-plus"></i> View Loss Cost Record</h4>
      </div>
	  <form id="frm_view_loss_cost" method="post">
		  <div class="modal-body">
			<div class="row">
				<div class="col-sm-2">
					<label class="fa fa-md">Month/Year: </label>
				</div>
				<div class="col-sm-4">
					<input type="month" class="form-control" id="txt_lot_number" name="month_year">    
				</div>
				<div class="col-sm-2">
					<label class="fa fa-md">Attachment/s: </label>
				</div>
				<div class="col-sm-4">
					<button type="button" name="pkid" class="btn btn-default fa fa-paperclip"> View Attachment/s</button>
				</div>
			</div>
			<div class="row">
				<div class="col-sm-2">
					<label class="fa fa-md">Remarks: </label>
				</div>
				<div class="col-sm-10">
					<textarea class="form-control" id="txt_remarks" name="remarks"></textarea>
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

<!-- Modal for viewing attachment -->
<div class="modal fade" tabindex="-1" role="dialog" id="mdl_lc_attachment_viewer">
  <div class="modal-dialog modal-lg" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
        <h4 class="modal-title"><i class="fa fa-files-o"></i> View / Download Attachment/s</h4>
      </div>
	  <div class="modal-body">
		<div class="row">
			<div class="col-sm-12" id="">
				<!-- Display attachment here in table format ;) -->
				<table class="table table-striped table-bordered table-condensed">
					<thead>
						<th>File Name (click to download the file)</th>
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
    </div><!-- /.modal-content -->
  </div><!-- /.modal-dialog -->
</div><!-- /.modal -->