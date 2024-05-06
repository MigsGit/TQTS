<div class="col-sm-12">
	<div class="panel panel-info">
		<div class="panel-heading"><i class="fa fa-puzzle-piece fa-lg"> Dimension Inspection Result</i></div>
		<div class="panel-body">
			<div class="row">
				<div class="col-sm-6">
					<button class="btn btn-default fa" id="btn_dir_search_main"><i class="fa fa-search"></i> Search</button>
				</div>
				<div class="col-sm-6">
					<button class="btn btn-primary fa pull-right" id="btn_upload_di"><i class="fa fa-plus"></i> Create New</button>
				</div>
			</div>
			<div class="row">
				<div class="col-sm-12"><br />
					<table class="table table-striped table-bordered table-condensed" id="tbl_iqc_dimension">
						<thead>
							<th>Meas Type</th>
							<th>Details</th>
							<th>Drawing Number</th>
							<th>Documents</th>
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
<div class="modal fade" tabindex="-1" role="dialog" id="modal_upload_file">
  <div class="modal-dialog modal-lg" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
        <h4 class="modal-title"><i class="fa fa-upload"></i> Upload File</h4>
      </div>
	  <form id="frm_upload_measdata" method="post" enctype="multipart/form-data">
		  <div class="modal-body">
			<div class="row">
				<div class="col-sm-2">
					<label class="fa fa-md">Measurement Type: </label>
				</div>
				<div class="col-sm-4">
					<select class="form-control" name="measurement_type" id="cmb_measurement_type" required>
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
						<input type="text" class="form-control" id="txt_partcode" list="list_partcode" autocomplete="on" name="part_code">
                        <datalist id="list_partcode"></datalist>
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
						<input type="text" class="form-control" id="txt_po_number" list="list_po_number" autocomplete="on" name="po_number">
                        <datalist id="list_po_number"></datalist>
					</div>
				</div>
				<div class="row">
					<div class="col-sm-2">
						<label class="fa fa-md">Device Code: </label>
					</div>
					<div class="col-sm-4">
						<input type="text" class="form-control" id="txt_device_code" name="device_code" disabled required>
					</div>
					<div class="col-sm-2">
						<label class="fa fa-md">Device Name: </label>
					</div>
					<div class="col-sm-4">
						<input type="text" class="form-control" id="txt_device_name" name="device_name" readonly required>
					</div>
				</div>
			</div>
			
			<div class="row">
				<div class="col-sm-2">
					<label class="fa fa-md">Choose File: </label>
				</div>
				<div class="col-sm-4">
					<input type="file" class="" id="file_measdata" name="meas_file[]" multiple="multiple" accept=".csv, application/vnd.openxmlformats-officedocument.spreadsheetml.sheet, application/vnd.ms-excel" required>
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
					<input type="file" id="file_measdata" name="meas_file[]" multiple="multiple" accept=".csv, application/vnd.openxmlformats-officedocument.spreadsheetml.sheet, application/vnd.ms-excel" style="width:85%;display:inline-block;" disabled>
					<!-- <button type="button" class="btn btn-link fa fa-paperclip" id="btn_view_attachments" style="width:10px;display:inline-block;"></button> -->
					<a href="#" class="fa fa-paperclip" id="btn_view_attachments" style="display:inline-block;"> </a>
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


<div class="modal" tabindex="-1" role="dialog" id="modal_dir_advance_search">
  <div class="modal-dialog modal-lg" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
        <h4 class="modal-title fa fa-search"> Advance Search</h4>
      </div>
	  <form id="frm_dir_advance_search">
      <div class="modal-body">
		<button type="button" class="btn btn-default fa pull-left fa fa-eraser" id="btn_dir_as_reset"> Reset Search Value</button>
		<button type="button" class="btn btn-primary fa pull-right fa fa-plus" id="btn_dir_as_add"> Add</button><br /><br />
		<table class="table" id="tbl_dir_advance_search">
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