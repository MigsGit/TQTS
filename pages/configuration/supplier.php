<div class="col-sm-12" id="container_supplier">
	<div class="panel panel-default">
		<div class="panel-heading">
			<i class="fa fa-shopping-cart fa-lg"></i> Supplier Category
		</div>
		<div class="panel-body">
			<div class="row">
				<div class="col-sm-6">
					<button class="btn btn-default fa fa-search"> Search</button>
				</div>
				<div class="col-sm-6">
					<button class="btn btn-primary fa fa-plus pull-right" id="btn_add_supplier"> New Supplier</button>
				</div>
			</div><br />
			<div class="row">
				<div class="col-sm-12" style="overflow:auto;">
					<table class="table table-hover table-striped table-bordered table-condensed" id="tbl_supplier">
						<thead>
							<tr>
								<th style="width:150px;"><i class="fa fa-cogs"></i></th>
								<th style="width:200px;">Supplier Group</th>
								<th>Supplier</th>
								<th>TO</th>
								<th>CC</th>
							</tr>
						</thead>
						<tbody>
						</tbody>
					</table>									
				</div>
			</div>
		</div>
	</div>
</div>

<!---------------
	Modals
----------------->
<div class="modal fade" tabindex="-1" role="dialog" id="modal_add_supplier">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
        <h4 class="modal-title"> <i class="fa fa-plus"></i> Add New Supplier</h4>
      </div>
      <div class="modal-body">
        <form id="frm_add_supplier">
			<div class="row">
				<div class="col-sm-4">
					<label class="control-label fa condensed"> Supplier Group</label>
				</div>
				<div class="col-sm-6">
					<select class="form-control" name="fksupplier_group" required>
						<option value="1">YEC</option>
						<option value="2">YEU</option>
					</select>
				</div>
			</div>
			<div class="row">
				<div class="col-sm-4">
					<label class="control-label fa condensed"> Supplier</label>
				</div>
				<div class="col-sm-8">
					<input type="text" class="form-control" name="supplier" required>
				</div>
			</div>
			<div class="row">
				<div class="col-sm-4">
					<label class="control-label fa condensed">Email To</label>
				</div>
				<div class="col-sm-8">
					<input type="text" class="form-control" name="recipients_to" placeholder="example@pricon.ph">
				</div>
			</div>
			<div class="row">
				<div class="col-sm-4">
					<label class="control-label fa condensed">Email CC</label>
				</div>
				<div class="col-sm-8">
					<input type="text" class="form-control" name="recipients_cc" placeholder="example@pricon.ph">
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

