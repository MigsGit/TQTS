<div class="col-xs-12 col-sm-8 col-md-9" id="container_user_crud">
	<div class="panel panel-default">
		<div class="panel-heading">
			<i class="fa fa-users fa-lg"></i> Users CRUD
		</div>
		<div class="panel-body">
			<table class="table table-hover table-striped table-bordered table-condensed" id="tbl_user_main">
				<thead>
					<tr>
						<th>Fullname</th>
						<th>Position</th>
						<th>Department</th>
						<th>Section</th>
						<th>Division</th>
						<th>Username</th>
						<th><i class="fa fa-cogs"></i></th>
					</tr>
				</thead>
				<tbody>
				</tbody>
			</table>									
		</div>
	</div>
</div>
<div class="hidden-xs col-sm-4 col-md-3">
	<div class="panel panel-info">
		<div class="panel-heading">
			<i class="fa fa-book fa-lg"></i> Didn't Find Employee from list?
		</div>
		<div class="panel-body">
			<p>To add employee to the CRUD list, please assign the system to this employee using Rapid.</p>
		</div>
	</div>
</div>

<div class="hidden-xs col-sm-4 col-md-3">
	<div class="panel panel-info">
		<div class="panel-heading">
			<i class="fa fa-book fa-lg"></i> Note: NG Report
		</div>
		<div class="panel-body">
			<p>In the NG Report Role Cell Please see the following: </p>
			<p>1. Approver - will show the approval only </p>
			<p>2. Requestor - will show the pending items and approval </p>
			<p>3. Other Role - will display nothing </p>
		</div>
	</div>
</div>

<div class="hidden-xs col-sm-4 col-md-3">
	<div class="panel panel-info">
		<div class="panel-heading">
			<i class="fa fa-book fa-lg"></i> Note: Special Acceptance
		</div>
		<div class="panel-body">
			<p>In the Special Acceptance Role Cell Please see the following: </p>
			<p>1. Supervisor - will allow user to add/update disposition </p>
			<p>2. Requestor - users can only create special acceptance, cannot update disposition </p>
			<p>3. Other Role - will display nothing </p>
		</div>
	</div>
</div>

<!---------------------
		Modals
---------------------->
<div class="modal fade" tabindex="-1" role="dialog" id="modal_edit_user_roles">
  <div class="modal-dialog modal-lg" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
        <h4 class="modal-title"> <i class="fa fa-edit"></i> Edit User Roles</h4>
      </div>
      <div class="modal-body">
        <form id="frm_edit_user_roles">
			<div class="row">
				<div class="col-sm-12">
					<table class="table table-condensed table-bordered" id="tbl_user_role">
						<thead>
							<tr>
								<th>Sub-System</th>
								<th>Module</th>
								<th>Section</th>
								<th>Role</th>
								<th>Create</th>
								<th>Read</th>
								<th>Update</th>
								<th>Delete</th>
							</tr>
						</thead>
						<tbody>
						</tbody>
					</table>
				</div>
				<!--<div class="col-sm-2">
					<label class="control-label fa condensed"> Section</label>
				</div>
				<div class="col-sm-4">
					<select class="form-control" name="section" required>
						<option value=""></option>
						<option value="IQC">IQC</option>
						<option value="PRDN">PRDN</option>
						<option value="ENGR">ENGR</option>
						<option value="IPQC">IPQC</option>
					</select>
				</div>
				<div class="col-sm-2">
					<label class="control-label fa condensed"> Role</label>
				</div>
				<div class="col-sm-4">
					<select class="form-control" name="role" required>
						<option value=""></option>
						<option value="OPERATOR">OPERATOR</option>
						<option value="QC STAFF">QC STAFF</option>
					</select>
				</div>-->
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