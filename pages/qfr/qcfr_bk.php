<div class="col-sm-12">
	<div class="panel panel-info">
		<div class="panel-heading"><i class="fa fa-file fa-lg"> Quality Complaint Feedback Report (QCFR)</i></div>
		<div class="panel-body">
			<div class="row">
				<div class="col-sm-9">
					<button class="btn btn-default fa fa-search" id="btn_qcfr_advanced_search"> Search</button>
				</div>
				<div class="col-sm-3">
					<button class="btn btn-default fa fa-plus pull-right" id="btn_add_qcfr"> New</button>
				</div>	
			</div><br />
			<div class="row">
				<div class="col-sm-12" style="overflow:auto;">
					<table class="table table-bordered table-condensed" id="tbl_qcfr">
						<thead>
							<tr>
								<th>QCFR No.</th>
								<th>Product Name</th>
								<th>Model No.</th>
								<th>Batch No./Lot No.</th>
								<th>P.O. No./ INV. No.</th>
								<th>Date Received</th>
								<th>Uploaded File</th>
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
</div>

<div class="modal" tabindex="-1" role="dialog" id="modal_qcfr">
  <div class="modal-dialog modal-lg" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
        <h4 class="modal-title fa fa-plus">Add Quality Complaint Feedback Report (QCFR)</h4>
      </div>
	  
      <div class="modal-body">
		<div class="row">
			<form id="frm_upload_qcfr">
				<div class="col-sm-2">
					<label class="control-label condensed"> Upload QCFR: </label>
				</div>
				<div class="col-sm-4">
					<input type="file" class="form-control condensed" name="file_qcfr" required>
				</div>
				<button class="btn btn-primary fa fa-upload"> Upload</button>
				<hr class="graph-blue">
			</form>
		</div>		
	  <form id="frm_qcfr">
		<div class="row" id="container_qcfr_upload_message">
			<div class="col-sm-12">
				<div class="alert alert-info">Data extracted from <span id="span_file_name"></span></div>
			</div>
		</div>
		<div class="row">
			<div class="col-sm-2 col-sm-offset-6">
				<label class="control-label condensed">QCFR No.:</label>
			</div>
			<div class="col-sm-4">
				<input type="text" class="form-control condensed" name="qcfr_no" readonly>
			</div>
		</div>
		<div class="row">
			<div class="col-sm-12">
				<div class="row">
					<div class="col-sm-2">
						<label class="control-label condensed"> Product Name</label>
					</div>
					<div class="col-sm-4">
						<input type="text" class="form-control condensed" name="product_name" readonly>
					</div>
					<div class="col-sm-2">
						<label class="control-label condensed"> Model No.</label>
					</div>
					<div class="col-sm-4">
						<input type="text" class="form-control condensed" name="model_no" readonly>
					</div>
				</div>
			</div>
		</div>
		<div class="row">
			<div class="col-sm-12">
				<div class="row">
					<div class="col-sm-2">
						<label class="control-label condensed"> Batch No./Lot No.</label>
					</div>
					<div class="col-sm-4">
						<input type="text" class="form-control condensed" name="batch_no_lot_no" readonly>
					</div>
					<div class="col-sm-2">
						<label class="control-label condensed"> P.O. No./ INV. No.</label>
					</div>
					<div class="col-sm-4">
						<input type="text" class="form-control condensed" name="po_no_inv_no" readonly>
					</div>
				</div>
			</div>
		</div>
		<div class="row">
			<div class="col-sm-2">
				<label class="control-label condensed"> Date Received</label>
			</div>
			<div class="col-sm-4">
				<input type="text" class="form-control condensed" name="date_received" readonly>
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

<div class="modal" tabindex="-1" role="dialog" id="modal_qcfr_edit">
  <div class="modal-dialog modal-lg" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
        <h4 class="modal-title fa fa-plus">View/Edit Quality Complaint Feedback Report (QCFR)</h4>
      </div>
	  
      <div class="modal-body">
		<div class="row">
			<form id="frm_upload_qcfr_edit">
				<div class="col-sm-2">
					<label class="control-label condensed"> Re-Upload QCFR: </label>
				</div>
				<div class="col-sm-4">
					<input type="file" class="form-control condensed" name="file_qcfr" required>
				</div>
				<button class="btn btn-primary fa fa-upload"> Re-Upload</button>
				 <hr class="graph-blue">
			</form>
		</div>
	  <form id="frm_qcfr_edit">
		<div class="row" id="container_qcfr_upload_message">
			<div class="col-sm-12">
				<div class="alert alert-info">Data extracted from <span id="span_file_name"></span></div>
			</div>
		</div>
		<div class="row">
			<div class="col-sm-2 col-sm-offset-6">
				<label class="control-label condensed">QCFR No.:</label>
			</div>
			<div class="col-sm-4">
				<input type="text" class="form-control condensed" name="qcfr_no" readonly>
			</div>
		</div>
		<div class="row">
			<div class="col-sm-12">
				<div class="row">
					<div class="col-sm-2">
						<label class="control-label condensed"> Product Name</label>
					</div>
					<div class="col-sm-4">
						<input type="text" class="form-control condensed" name="product_name" readonly>
					</div>
					<div class="col-sm-2">
						<label class="control-label condensed"> Model No.</label>
					</div>
					<div class="col-sm-4">
						<input type="text" class="form-control condensed" name="model_no" readonly>
					</div>
				</div>
			</div>
		</div>
		<div class="row">
			<div class="col-sm-12">
				<div class="row">
					<div class="col-sm-2">
						<label class="control-label condensed"> Batch No./Lot No.</label>
					</div>
					<div class="col-sm-4">
						<input type="text" class="form-control condensed" name="batch_no_lot_no" readonly>
					</div>
					<div class="col-sm-2">
						<label class="control-label condensed"> P.O. No./ INV. No.</label>
					</div>
					<div class="col-sm-4">
						<input type="text" class="form-control condensed" name="po_no_inv_no" readonly>
					</div>
				</div>
			</div>
		</div>
		<div class="row">
			<div class="col-sm-2">
				<label class="control-label condensed"> Date Received</label>
			</div>
			<div class="col-sm-4">
				<input type="text" class="form-control condensed" name="date_received" readonly>
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

<div class="modal" tabindex="-1" role="dialog" id="modal_qcfr_cancel">
  <div class="modal-dialog modal-lg" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
        <h4 class="modal-title fa fa-plus">Cancel Quality Complaint Feedback Report (QCFR)</h4>
      </div>
      <div class="modal-body">
		<form id="frm_qcfr_cancel">
			<div class="row" id="container_qcfr_upload_message">
				<div class="col-sm-12">
					<div class="alert alert-info">Data extracted from <span id="span_file_name"></span></div>
				</div>
			</div>
			<div class="row">
				<div class="col-sm-2 col-sm-offset-6">
					<label class="control-label condensed">QCFR No.:</label>
				</div>
				<div class="col-sm-4">
					<input type="text" class="form-control condensed" name="qcfr_no" readonly>
				</div>
			</div>
			<div class="row">
				<div class="col-sm-12">
					<div class="row">
						<div class="col-sm-2">
							<label class="control-label condensed"> Product Name</label>
						</div>
						<div class="col-sm-4">
							<input type="text" class="form-control condensed" name="product_name" readonly>
						</div>
						<div class="col-sm-2">
							<label class="control-label condensed"> Model No.</label>
						</div>
						<div class="col-sm-4">
							<input type="text" class="form-control condensed" name="model_no" readonly>
						</div>
					</div>
				</div>
			</div>
			<div class="row">
				<div class="col-sm-12">
					<div class="row">
						<div class="col-sm-2">
							<label class="control-label condensed"> Batch No./Lot No.</label>
						</div>
						<div class="col-sm-4">
							<input type="text" class="form-control condensed" name="batch_no_lot_no" readonly>
						</div>
						<div class="col-sm-2">
							<label class="control-label condensed"> P.O. No./ INV. No.</label>
						</div>
						<div class="col-sm-4">
							<input type="text" class="form-control condensed" name="po_no_inv_no" readonly>
						</div>
					</div>
				</div>
			</div>
			<div class="row">
				<div class="col-sm-2">
					<label class="control-label condensed"> Date Received</label>
				</div>
				<div class="col-sm-4">
					<input type="text" class="form-control condensed" name="date_received" readonly>
				</div>
			</div>
      </div>
	  <div class="modal-footer">
        <button type="submit" class="btn btn-danger fa fa-save"> Cancel</button>
        <button type="button" class="btn btn-default fa fa-close" data-dismiss="modal"> Close</button>
      </div>
		</form>
    </div><!-- /.modal-content -->
  </div><!-- /.modal-dialog -->
</div><!-- /.modal -->

<!-- Modal for system message -->
<div class="modal" tabindex="-1" role="dialog" id="modal_qcfr_system_message">
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

<!-- Modal for advanced search -->
<div class="modal" tabindex="-1" role="dialog" id="modal_qcfr_advance_search">
  <div class="modal-dialog modal-lg" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
        <h4 class="modal-title fa fa-search"> Advance Search</h4>
      </div>
	  <form id="frm_qcfr_advance_search">
      <div class="modal-body">
		
      </div>
      <div class="modal-footer">
        <button type="submit" class="btn btn-primary fa fa-search"> Search</button>
        <button type="button" class="btn btn-default fa fa-close" data-dismiss="modal"> Close</button>
      </div>
	  </form>
    </div><!-- /.modal-content -->
  </div><!-- /.modal-dialog -->
</div><!-- /.modal -->

<script>
var username = $('#hd_username').val();
/* Datatable initialization */
var dt_tbl_qcfr = $('#tbl_qcfr').DataTable({
	"aaSorting"	: [],
	"bProcessing": true,
	"bServerSide": true,
	"sAjaxSource": "server_side_scripts/qr/dt_qcfr.php?username="+username,
	"drawCallback": function() {
		$('#tbl_iqc_qar_requestor').attr('style','width:100%;');
	}
});

/* Download file */
$('#tbl_qcfr tbody').on('click','tr a', function(){
	alert('download file');	
});

/* QCFR Handler Link */
var handler_ts_qfr_qcfr 		= './handler/handler_ts_qfr_qcfr.php';
/* Event when the add new button has been clicked */
$('#btn_add_qcfr').click(function(){
	/* Assign the modal ID, disable the save button and open modal */
	var modal_id = 'modal_qcfr';
	$('#'+modal_id+' .fa-save').prop('disabled',true);
	$('#'+modal_id+' #container_qcfr_upload_message').hide();
	$('#'+modal_id).modal('show');
});

/* 
	Adding New QCFR
*/
/* Event when the upload button for adding new qcfr has been clicked */
$('#frm_upload_qcfr').submit(function(e){
	/* Prevent the page from submitting and reloading */
	e.preventDefault();
	/* Get the form data */
	var serialized_data = new FormData(this);
		serialized_data.append("action","upload_qcfr");
	/* Call function for uploading QCFR */
	fn_upload_qcfr(serialized_data);
});

/* Event when the submit button of saving the QCFR Details to database */
$('#frm_qcfr').submit(function(e){
	/* Prevent page from submitting and reloading */
	e.preventDefault();
	/* Get the form data */
	var serialized_data = $(this).serialize();
	/* Function for saving data to database */
	fn_save_qcfr(serialized_data);
});

function fn_upload_qcfr(serialized_data){
	/* Call ajax, simplified term for the ajax, function is located on common_functions.php */
	call_ajax_attachment(serialized_data, handler_ts_qfr_qcfr, function(result){
		/* Assign Modal Id and Form ID, Open modal and populate textfields */
		var modal_id = 'modal_qcfr';
		var frm_id   = 'frm_qcfr';
		$('#'+modal_id+' #container_qcfr_upload_message').show();
		$('#'+modal_id+' #container_qcfr_upload_message span').text(result['original_file_name']);
		$('#'+modal_id+' .fa-save').prop('disabled',false);
		$.each(result['excel_data'],function(key,value){
			/* Populate all input, Note: In any case you have a checkbox, textarea, etc copy the line below and replace the input */
			$('#'+frm_id+' input[name="'+key+'"]').val(value);
		});
	});
}

function fn_save_qcfr(serialized_data){
	var data = {
		"action"	: "save_qcfr",
		"excel_file": $('#frm_upload_qcfr input[type="file"]').val(),
		"username"	: username
	}
	call_ajax_serialize( data, serialized_data, handler_ts_qfr_qcfr, function(result){
		console.log(result);
		/* Change this to your desired system message modal ID */
		var modal_id 		= 'modal_qcfr_system_message';
		var form_id 		= 'frm_qcfr';
		var form_upload_id  = 'frm_upload_qcfr';
		/* Validate if error array is not empty */
		if(result['error'].length != 0){
			/* Empty the system message */
			$('#'+modal_id+' #div_system_message').empty();
			/* Add a an alert danger class */
			$('#'+modal_id+' #div_system_message').attr("class","alert alert-danger");
			/* Append system message */
			$('#'+modal_id+' #div_system_message').append("<p>Error Upload:</p>");
			$.each(result['error'],function(key,value){
				/* Append returned error messages */
				$('#'+modal_id+' #div_system_message').append("<li>"+value+"</li>");
			});			
			$('#'+modal_id+'').modal('show');
		}else{
			/* Update system message for success in saving data */
			$('.modal').modal('hide');
			$('#'+modal_id+' #div_system_message').empty();
			$('#'+modal_id+' #div_system_message').attr("class","alert alert-success");
			$('#'+modal_id+' #div_system_message').append("QCFR has been successfully uploaded!");
			$('#'+modal_id+'').modal('show');
			fn_system_message_timer(''+modal_id+'');
			$('#'+form_id+' input').val('');
			$('#'+form_upload_id+' input').val('');
			dt_tbl_qcfr.ajax.reload();
		}
	});
}

/* 
	View/Edit QCFR
*/
/* Event when the edit button on the table has been clicked */
$('#tbl_qcfr tbody').on('click','tr .fa-eye', function(){
	/* Assign the modal_id and pkid to variable */
	var modal_id = 'modal_qcfr_edit';
	var form_id  = 'frm_upload_qcfr_edit';
	var pkid = $(this).attr('id');
	/* Disable the update button and enable the button after the file has been re-uploaded */
	$('#'+modal_id+' .fa-save').prop('disabled',true);
	$('#'+modal_id+' .fa-save').hide();
	/* Function that fetches the details of the selected row */
	fn_load_qcfr_details(pkid,modal_id);
	$('#'+form_id).hide();
	/* Assign the pkid to the data id of the modal */
	$('#'+modal_id).data('id',pkid);
	$('#'+modal_id).modal('show');
});

$('#tbl_qcfr tbody').on('click','tr .fa-edit', function(){
	/* Assign the modal_id and pkid to variable */
	var modal_id = 'modal_qcfr_edit';
	var form_id  = 'frm_upload_qcfr_edit';
	var pkid = $(this).attr('id');
	/* Disable the update button and enable the button after the file has been re-uploaded */
	$('#'+modal_id+' .fa-save').prop('disabled',true);
	$('#'+modal_id+' .fa-save').show();
	/* Function that fetches the details of the selected row */
	fn_load_qcfr_details(pkid,modal_id);
	$('#'+form_id).show();
	/* Assign the pkid to the data id of the modal */
	$('#'+modal_id).data('id',pkid);
	$('#'+modal_id).modal('show');
});

/* Event when the re-upload button for replacing QCFR */
$('#frm_upload_qcfr_edit').submit(function(e){
	/* Prevent the page from submitting and reloading */
	e.preventDefault();
	var modal_id= 'modal_qcfr_edit';
	/* Get the form data */
	var serialized_data = new FormData(this);
		serialized_data.append("action", "re_upload_qcfr");
		serialized_data.append( "pkid", $('#'+modal_id).data('id') );
	/* Call function for re-uploading QCFR */
	fn_re_upload_qcfr(serialized_data);
});

$('#frm_qcfr_edit').submit(function(e){
	/* Prevent page from submitting */
	e.preventDefault();
	/* get the form data */
	var serialized_data = $(this).serialize();
	fn_edit_qcfr(serialized_data);
});

function fn_load_qcfr_details(pkid,modal_id){
	var data = {
		"action"	: "load_qcfr_data_details",
		"pkid"		: pkid
	}
	call_ajax( data, handler_ts_qfr_qcfr, function(result){
		console.log(result);
		/* append values on form elements */
		// var modal_id = 'modal_qcfr_edit';
		$.each(result['data'],function(key,value){
			$('#' + modal_id +' form input[name="'+key+'"]').val(value);
		});
	});
}


function fn_re_upload_qcfr(serialized_data){
	call_ajax_attachment(serialized_data, handler_ts_qfr_qcfr, function(result){
		console.log(result);
		var modal_id = 'modal_qcfr_edit';
		var form_id  = 'frm_qcfr_edit';
		$('#'+modal_id+' #container_qcfr_upload_message').show();
		$('#'+modal_id+' #container_qcfr_upload_message span').text(result['original_file_name']);
		$('#'+modal_id+' .fa-save').prop('disabled',false);
		$.each(result['excel_data'],function(key,value){
			$('#'+form_id+' input[name="'+key+'"]').val(value);
		});
	});
}

function fn_edit_qcfr(serialized_data){
	var data = {
		"action"	: "edit_qcfr",
		"excel_file": $('#frm_upload_qcfr_edit input[type="file"]').val(),
		"pkid"		: $('#modal_qcfr_edit').data('id'),
		"username"	: username
	}
	call_ajax_serialize( data, serialized_data, handler_ts_qfr_qcfr, function(result){
		console.log(result);
		/* Change this to your desired system message modal ID */
		var modal_id = 'modal_qcfr_system_message';
		var form_id  = 'frm_qcfr';
		var form_upload_id  = 'frm_upload_qcfr_edit';
		/* Validate if error array is not empty */
		if(result['error'].length != 0){
			/* Empty the system message */
			$('#'+modal_id+' #div_system_message').empty();
			/* Add a an alert danger class */
			$('#'+modal_id+' #div_system_message').attr("class","alert alert-danger");
			/* Append system message */
			$('#'+modal_id+' #div_system_message').append("<p>Error Upload:</p>");
			$.each(result['error'],function(key,value){
				/* Append returned error messages */
				$('#'+modal_id+' #div_system_message').append("<li>"+value+"</li>");
			});			
			$('#'+modal_id+'').modal('show');
		}else{
			/* Update system message for success in saving data */
			$('.modal').modal('hide');
			$('#'+modal_id+' #div_system_message').empty();
			$('#'+modal_id+' #div_system_message').attr("class","alert alert-success");
			$('#'+modal_id+' #div_system_message').append("QCFR has been successfully updated!");
			$('#'+modal_id).modal('show');
			fn_system_message_timer(''+modal_id+'');
			$('#'+form_id+' input').val('');
			$('#'+form_upload_id+' input').val('');
			dt_tbl_qcfr.ajax.reload();
		}
	});
}

/* 
	Cancel/Delete QCFR
*/
$('#tbl_qcfr tbody').on('click','tr .fa-remove', function(){
	/* Assign the modal_id and pkid to variable */
	var modal_id = 'modal_qcfr_cancel';
	var form_id  = 'frm_upload_qcfr_edit';
	var pkid = $(this).attr('id');
	/* Function that fetches the details of the selected row */
	fn_load_qcfr_details(pkid,modal_id);
	$('#'+form_id).hide();
	/* Assign the pkid to the data id of the modal */
	$('#'+modal_id).data('id',pkid);
	$('#'+modal_id).modal('show');
});

$('#frm_qcfr_cancel').submit(function(e){
	e.preventDefault();
	if(confirm("You are about to cancel this QCFR")){
		fn_cancel_qcfr();
	}
});

function fn_cancel_qcfr(){
	var modal_id = 'modal_qcfr_cancel';
	var data = {
		"action"	: "cancel_qcfr",
		"pkid"		: $('#'+modal_id).data('id')
	}
	call_ajax(data, handler_ts_qfr_qcfr, function(result){
		console.log(result);
		var modal_id = 'modal_qcfr_system_message';
		var form_id  = 'frm_qcfr_cancel';
		/* Update system message for success in saving data */
		$('.modal').modal('hide');
		$('#'+modal_id+' #div_system_message').empty();
		$('#'+modal_id+' #div_system_message').attr("class","alert alert-success");
		$('#'+modal_id+' #div_system_message').append("QCFR has been successfully removed!");
		$('#'+modal_id).modal('show');
		fn_system_message_timer(''+modal_id+'');
		dt_tbl_qcfr.ajax.reload();
	});
}

/* 
	Advanced Search 
*/



</script>
