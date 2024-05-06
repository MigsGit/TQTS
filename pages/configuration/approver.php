<div class="col-xs-12 col-sm-8 col-md-9" id="container_supplier">
	<div class="panel panel-default">
		<div class="panel-heading">
			<i class="fa fa-shopping-cart fa-lg"></i> Approver Masterlist
		</div>
		<div class="panel-body">
			<div class="row">
				<div class="col-sm-6">
					<button class="btn btn-default fa fa-search"> Search</button>
				</div>
				<div class="col-sm-6">
					<button class="btn btn-primary fa fa-plus pull-right" id="btn_add_approver"> Add Approver</button>
				</div>
			</div><br />
			<table class="table table-hover table-striped table-bordered table-condensed" id="tbl_approver">
				<thead>
					<tr>
						<th>Sub-System</th>
						<th>Module</th>
						<th>Approver Type</th>
						<th>EmpNo</th>
						<th>Name</th>
						<th style="width:150px;"><i class="fa fa-cogs"></i></th>
					</tr>
				</thead>
				<tbody>
				</tbody>
			</table>									
		</div>
	</div>
</div>

<!---------------
	Modals
----------------->
<div class="modal fade" tabindex="-1" role="dialog" id="modal_add_approver">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
        <h4 class="modal-title"> <i class="fa fa-plus"></i> Add Approver</h4>
      </div>
      <div class="modal-body">
        <form id="frm_add_approver">
			<div class="row">
				<div class="col-sm-4">
					<label class="control-label fa condensed"> Sub-System</label>
				</div>
				<div class="col-sm-8">
					<select class="form-control" name="subsystem_name" required>
						<option value=""></option>
					</select>
				</div>
			</div>
			<div class="row">
				<div class="col-sm-4">
					<label class="control-label fa condensed"> Module</label>
				</div>
				<div class="col-sm-8">
					<select class="form-control" name="fk_module" required>
						<option value=""></option>
					</select>
				</div>
			</div>
			<div class="row">
				<div class="col-sm-4">
					<label class="control-label fa condensed"> Approver Type</label>
				</div>
				<div class="col-sm-8">
					<input type="text" name="approver_type" class="form-control" list="list_approver_type" autocomplete="off" required>
					<datalist id="list_approver_type"></datalist>
					<!--<select class="form-control" name="approver_type" required>
						<option value=""></option>
					</select>-->
				</div>
			</div>
			<div class="row">
				<div class="col-sm-4">
					<label class="control-label fa condensed"> Approver Name</label>
				</div>
				<div class="col-sm-8">
					<input type="text" name="approver_username" class="form-control" list="list_approver_username_list" autocomplete="off" required>
					<datalist id="list_approver_username_list"></datalist>
					<!--<select class="form-control" name="" required>
						<option value=""></option>
					</select>-->
				</div>
			</div>
      </div>
      <div class="modal-footer">
		 <button type="submit" class="btn btn-primary">Save</button> 
		 <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
		</form>
      </div>
    </div><!-- /.modal-content -->
  </div><!-- /.modal-dialog -->
</div><!-- /.modal -->

<div class="modal fade" tabindex="-1" role="dialog" id="modal_delete_supplier">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
        <h4 class="modal-title"> <i class="fa fa-trash"></i> Delete Supplier</h4>
      </div>
      <div class="modal-body">
        <form id="frm_delete_supplier">
			<p id="delete_message"></p>
      </div>
      <div class="modal-footer">
		 <button type="submit" class="btn btn-danger">Delete</button> 
		 <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
		</form>
      </div>
    </div><!-- /.modal-content -->
  </div><!-- /.modal-dialog -->
</div><!-- /.modal -->

