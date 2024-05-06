<div class="container-fluid">
	<div class="panel panel-primary">
		<div class="panel-heading"> 
			<div class="row">
				<div class="col-sm-6">
					<span class="fa fa-users"></span> User Roles
				</div>
				<div class="col-sm-6">
				
				</div>
			</div>
		</div>
		<div class="panel-body" style="overflow:auto;">
			<table class="table table-hover table-striped table-bordered" id="tbl_user_main">
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

<!-- Start Modals -->

<div class="modal fade" tabindex="-1" role="dialog" id="modal_edit_user_crud">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
        <h4 class="modal-title"><span class="fa fa-edit"></span> Edit User Role</h4>
      </div>
      <div class="modal-body">
		<form id="frm_user_roles">
			<table class="table table-hover table-striped table-bordered" id="tbl_user_crud">
				<thead>
					<tr>
						<th>Module</th>
						<th><input type="checkbox" value="1"> Create</th>
						<th><input type="checkbox" value="2"> Read</th>
						<th><input type="checkbox" value="3"> Update</th>
						<th><input type="checkbox" value="4"> Delete</th>
					</tr>
				</thead>
				<tbody>
				</tbody>
			</table>
      </div>
      <div class="modal-footer">
			<button type="submit" class="btn btn-primary fa fa-save" id="btn_update_role"> Update Role</button>
			<button type="button" class="btn btn-default fa fa-remove" data-dismiss="modal">Close</button>
		</form>
	  </div>
    </div><!-- /.modal-content -->
  </div><!-- /.modal-dialog -->
</div><!-- /.modal -->
<!-- End Modals -->



<script type="text/javascript" src="js/user_roles.js"></script>