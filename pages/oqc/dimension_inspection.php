<?php
/* get user role */
$user_oqc_dir_access 	    = array("create" => false, 
									"read" => false,
									"update" => false,
									"delete" => false
									);
$subsystem_code 			= "OQC";
$module 					= "Dimension Inspection Result";
foreach($user_role['subsystem_code'] as $key => $subsystem_code ){
	if($subsystem_code == $subsystem_code && $user_role['module'][$key] == $module){ 
		if ($user_role['create'][$key] == 1){
			$user_oqc_dir_access['create'] = true;
		}
		if ($user_role['read'][$key] == 1){
			$user_oqc_dir_access['read'] = true;
		}
		if ($user_role['update'][$key] == 1){
			$user_oqc_dir_access['update'] = true;
		}
		if ($user_role['delete'][$key] == 1){
			$user_oqc_dir_access['delete'] = true;
		}
	}
}
?>
<div class="col-sm-12">
	<div class="panel panel-info">
		<div class="panel-heading"><i class="fa fa-puzzle-piece fa-lg"> Dimension Inspection Result</i></div>
		<div class="panel-body">
			<div class="row">
				<div class="col-sm-6">
					<button class="btn btn-default fa" id="btn_oqc_dir_search_main"><i class="fa fa-search"></i> Search</button>
				</div>
				<div class="col-sm-6">
					<?php 
						if($user_oqc_dir_access['create']){
							echo '<button class="btn btn-primary fa pull-right" id="btn_upload_di"><i class="fa fa-plus"></i> NEW</button>';
						}
					?>
				</div>
			</div>
			<div class="row">
				<div class="col-sm-12"><br />
					<table class="table table-striped table-bordered table-condensed" id="tbl_oqc_dir">
						<thead>
							<th>Shipment Date</th>
							<th>PO Number</th>
							<th>Series Name</th>
							<th>Customer</th>
							<th>Remarks</th>
							<th>Uploaded File</th>
							<th>Action</th>
						</thead>
					</table>
				</div>
			</div>
		</div>
	</div>
</div>

<!---------------------
	Modals - Start 
---------------------->
<div class="modal fade" tabindex="-1" role="dialog" id="modal_dir_new">
  <div class="modal-dialog modal-lg" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
        <h4 class="modal-title"><i class="fa fa-upload"></i> New Dimension Inspection Result</h4>
      </div>
	  <div class="modal-body">
		<div class="profile-info-title h4">
			<span class="fa fa-upload"></span> Upload File
		</div>
		<hr class="graph-blue" style="margin-top:0px;">
		<div class="row">
			<form id="frm_upload_oqc_dir">
				<div class="col-sm-2">
					<label class="control-label condensed"> Upload Dimension Inspection: </label>
				</div>
				<div class="col-sm-4">
					<input type="file" class="form-control condensed" name="file_oqc_dir" required>
				</div>
				<button class="btn btn-primary fa fa-upload"> Upload</button>
			</form>
		</div>
		 <form id="frm_dimension_inspection_new">
			<!--<div class="row">
				<div class="col-sm-2 col-sm-offset-6">
					<label class="fa fa-md">Choose File: </label>
				</div>
				<div class="col-sm-4">
					<input type="file" class="" id="file_measdata" name="meas_file[]" multiple="multiple" accept=".csv, application/vnd.openxmlformats-officedocument.spreadsheetml.sheet, application/vnd.ms-excel" required>
				</div>
			</div>-->
			<div class="profile-info-title h4" >
				<span class="fa fa-info-circle"></span> Information
			</div>
			<hr class="graph-orange" style="margin-top:0px;">
			<div class="row" style="margin-top:5px;">
				<div class="col-sm-2">
					<label class="fa fa-md">PO Number: </label>
				</div>
				<div class="col-sm-4">
					<input type="text" class="form-control" id="po_number" list="list_po_number" autocomplete="on" name="po_number" required>
					<datalist id="list_po_number"></datalist>
				</div>
				<div class="col-sm-2">
					<label class="fa fa-md">Series Name: </label>
				</div>
				<div class="col-sm-4">
					<input type="text" class="form-control" id="series_name" name="series_name" required readOnly>
				</div>
			</div>
			<div class="row">
				<div class="col-sm-2">
					<label class="fa fa-md">Shipment Date: </label>
				</div>
				<div class="col-sm-4">
					<input type="text" class="form-control datepicker" id="datepicker_shipment_date_new" name="shipment_date" min="<?php echo date('Y-m-d'); ?>" required>
				</div>
				<div class="col-sm-2">
					<label class="fa fa-md">Customer: </label>
				</div>
				<div class="col-sm-4">
					<input type="text" class="form-control" id="customer" name="customer" required>
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
			<button type="submit" class="btn btn-primary fa fa-save"> Save</button>
			<button type="button" class="btn btn-default fa" data-dismiss="modal"> Close</button>
		  </div>
		</form><!-- /#frm_upload_measdata -->
    </div><!-- /.modal-content -->
  </div><!-- /.modal-dialog -->
</div><!-- /.modal -->

<div class="modal fade" tabindex="-1" role="dialog" id="modal_dir_edit">
  <div class="modal-dialog modal-lg" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
        <h4 class="modal-title"><i class="fa fa-upload"></i> View/Edit Dimension Inspection Result</h4>
      </div>
	  <div class="modal-body">
		<div class="row">
			<form id="frm_reupload_oqc_dir">
				<div class="col-sm-2">
					<label class="control-label condensed"> Upload Dimension Inspection: </label>
				</div>
				<div class="col-sm-4">
					<input type="file" class="form-control condensed" name="file_oqc_dir" required>
				</div>
				<button class="btn btn-primary fa fa-upload"> Re-Upload</button>
				<hr class="graph-blue">
			</form>
		</div>
		 <form id="frm_dimension_inspection_edit">
			<!--<div class="row">
				<div class="col-sm-2 col-sm-offset-6">
					<label class="fa fa-md">Choose File: </label>
				</div>
				<div class="col-sm-4">
					<input type="file" class="" id="file_measdata" name="meas_file[]" multiple="multiple" accept=".csv, application/vnd.openxmlformats-officedocument.spreadsheetml.sheet, application/vnd.ms-excel" required>
				</div>
			</div>-->
			<div class="row" style="margin-top:5px;">
				<div class="col-sm-2">
					<label class="fa fa-md">PO Number: </label>
				</div>
				<div class="col-sm-4">
					<input type="text" class="form-control" id="po_number" list="list_po_number" autocomplete="on" name="po_number" required readOnly>
					<datalist id="list_po_number"></datalist>
				</div>
				<div class="col-sm-2">
					<label class="fa fa-md">Series Name: </label>
				</div>
				<div class="col-sm-4">
					<input type="text" class="form-control" id="series_name" name="series_name" required readOnly>
				</div>
			</div>
			<div class="row">
				<div class="col-sm-2">
					<label class="fa fa-md">Shipment Date: </label>
				</div>
				<div class="col-sm-4">
					<input type="text" class="form-control datepicker" id="datepicker_shipment_date_edit" name="shipment_date" min="<?php echo date('Y-m-d'); ?>" required readOnly>
				</div>
				<div class="col-sm-2">
					<label class="fa fa-md">Customer: </label>
				</div>
				<div class="col-sm-4">
					<input type="text" class="form-control" id="customer" name="customer" required readOnly>
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
			<?php 
				if($user_oqc_dir_access['update']){
					echo '<button type="submit" class="btn btn-primary fa fa-save"> Save Changes</button>';
				}
			?>			
			<button type="button" class="btn btn-default fa" data-dismiss="modal"> Close</button>
		  </div>
		</form><!-- /#frm_upload_measdata -->
    </div><!-- /.modal-content -->
  </div><!-- /.modal-dialog -->
</div><!-- /.modal -->

<div class="modal fade" tabindex="-1" role="dialog" id="modal_reupload_file">
  <div class="modal-dialog modal-lg" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
        <h4 class="modal-title"><i class="fa fa-upload"></i> Update Record</h4>
      </div>
	  <form id="frm_update_measdata" method="post" enctype="multipart/form-data">
		  <div class="modal-body">
			<div class="row">
				<div class="col-sm-2">
					<label class="fa fa-md">Measurement Type: </label>
				</div>
				<div class="col-sm-4">
					<select class="form-control" name="measurement_type" id="measurement_type" required>
						<option value=""></option>
						<option value="1">MQ1</option>
						<option value="2">MQ2</option>
					</select>
				</div>
				<div class="col-sm-2">
					<label class="fa fa-md">File Type: </label>
				</div>
				<div class="col-sm-4">
					<select class="form-control" id="txt_file_type" name="file_type" required>
						<option>Measdata</option>
						<option>Machine Pre-production</option>
					</select>
				</div>
			</div>
			
			<!-- MQ1 -->
			<div id="container_mq1">
				<div class="row">
					<div class="col-sm-2">
						<label class="fa fa-md">Invoice #: </label>
					</div>
					<div class="col-sm-4">
						<input type="text" class="form-control" id="txt_invoice_number" list="list_invoice_number" autocomplete="on" name="invoice_number">
                        <datalist id="list_invoice_number"></datalist>
					</div>
					<div class="col-sm-2">
						<label class="fa fa-md">Lot #: </label>
					</div>
					<div class="col-sm-4">
						<input type="text" class="form-control" id="txt_lot_number" name="lot_number">
					</div>
				</div>
				<div class="row">
					<div class="col-sm-2">
						<label class="fa fa-md">Part Code: </label>
					</div>
					<div class="col-sm-4">
						<input type="text" class="form-control" id="txt_partcode" list="list_partcode_update" autocomplete="on" name="part_code">
                        <datalist id="list_partcode_update"></datalist>
					</div>
					<div class="col-sm-2">
						<label class="fa fa-md">Part Name: </label>
					</div>
					<div class="col-sm-4">
						<input type="text" class="form-control" id="txt_partname" name="part_name" readOnly>
					</div>
				</div>
			</div>
			
			<!-- MQ2 -->
			<div id="container_mq2">
				<div class="row">
					<div class="col-sm-2">
						<label class="fa fa-md">PO Number: </label>
					</div>
					<div class="col-sm-4">
						<input type="text" class="form-control" id="txt_po_number" list="list_po_number_update" autocomplete="on" name="po_number">
                        <datalist id="list_po_number_update"></datalist>
					</div>
				</div>
				<div class="row">
					<div class="col-sm-2">
						<label class="fa fa-md">Device Code: </label>
					</div>
					<div class="col-sm-4">
						<input type="text" class="form-control" id="txt_device_code" name="device_code" readOnly required>
					</div>
					<div class="col-sm-2">
						<label class="fa fa-md">Device Name: </label>
					</div>
					<div class="col-sm-4">
						<input type="text" class="form-control" id="txt_device_name" name="device_name" readOnly required>
					</div>
				</div>
			</div>
			
			<div class="row">
				<div class="col-sm-2">
					<label class="fa fa-md"><input type="checkbox" id="chk_reupload"> Re-upload: </label>
				</div>
				<div class="col-sm-4">
					<input type="file" id="file_measdata" name="meas_file[]" multiple="multiple" accept=".csv, application/vnd.openxmlformats-officedocument.spreadsheetml.sheet, application/vnd.ms-excel" style="width:54%;display:inline-block;" disabled>
					<button type="button" class="btn btn-link fa fa-paperclip" id="btn_view_attachments" style="width:10px;display:inline-block;"></button>
				</div>
				<div class="col-sm-2">
					<label class="fa fa-md">Drawing Number: </label>
				</div>
				<div class="col-sm-4">
					<input type="text" class="form-control" id="txt_drawing_number" name="drawing_number" required>
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

<!-- Modal for viewing attachment -->
<div class="modal fade" tabindex="-1" role="dialog" id="modal_attachment_viewer">
  <div class="modal-dialog modal-md" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
        <h4 class="modal-title"><i class="fa fa-files-o"></i> View / Download Attachment/s</h4>
      </div>
	  <div class="modal-body">
		<div class="row">
			<div class="col-sm-12" id="">
				<!-- Display attachment here in table format ;) -->
				<table class="table table-striped table-bordered table-condensed" id="tbl_view_attachments">
					<thead>
						<th>File Name (click to download the file)</th>
						<th><center>Remove</center></th>
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

<!-- Modal for system message -->
<div class="modal" tabindex="-1" role="dialog" id="modal_dir_cancel">
  <div class="modal-dialog modal-md" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
        <h4 class="modal-title fa fa-remove"> Cancel</h4>
      </div>
      <div class="modal-body">
		<form id="frm_dir_cancel">
			<div class="row">
				<div class="col-sm-12">
					<label class="control-label">Please state your reason for cancellation: </label>
				</div>
				<div class="col-sm-12">
					<textarea class="form-control" name="remarks" required></textarea>
				</div>
			</div>
      </div>
      <div class="modal-footer">
			<button type="submit" class="btn btn-danger fa fa-trash"> Cancel</button>
		</form>	
        <button type="button" class="btn btn-default fa fa-close" data-dismiss="modal"> Close</button>
      </div>
    </div><!-- /.modal-content -->
  </div><!-- /.modal-dialog -->
</div><!-- /.modal -->

<!-- Modal for system message -->
<div class="modal" tabindex="-1" role="dialog" id="modal_oqc_dir_system_message">
  <div class="modal-dialog modal-md" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
        <h4 class="modal-title fa fa-search"> System Message</h4>
      </div>
      <div class="modal-body">
		<div class="" id="div_system_message"></div>
      </div>
      <div class="modal-footer">
        <div id="div_countdown"></div>
		<!--<button type="submit" class="btn btn-primary fa fa-search"> Search</button>-->
        <button type="button" class="btn btn-default fa fa-close" data-dismiss="modal"> Close</button>
      </div>
    </div><!-- /.modal-content -->
  </div><!-- /.modal-dialog -->
</div><!-- /.modal -->

<div class="modal" tabindex="-1" role="dialog" id="modal_oqc_dir_advance_search">
  <div class="modal-dialog modal-lg" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
        <h4 class="modal-title fa fa-search"> Advance Search</h4>
      </div>
	  <form id="frm_oqc_dir_advance_search">
      <div class="modal-body">
		<button type="button" class="btn btn-default fa pull-left fa fa-eraser" id="btn_dir_as_reset"> Reset Search Value</button>
		<button type="button" class="btn btn-primary fa pull-right fa fa-plus" id="btn_dir_as_add"> Add</button><br /><br />
		<table class="table" id="tbl_oqc_dir_advance_search">
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

<script src="js/common_functions.js" type="text/javascript"></script>