/* ***************************
    Declare Date Picker 
**************************** */
$('#modal_dir_new input').each(function(){
	if( $(this).attr("class") == "form-control datepicker" ){
		var date_id = this.id;
		$('#' + date_id).datepicker();
	}
});

$('#modal_dir_edit input').each(function(){
	if( $(this).attr("class") == "form-control datepicker" ){
		var date_id = this.id;
		$('#' + date_id).datepicker();
	}
});

/* *************************************************
	Dimension Inspection Result Functions - Start
************************************************** */

var handler_oqc_dir	= './handler/handler_oqc_dir.php';
var username 			= $('#hd_username').val();
var tbl_oqc_dimension 	= 'tbl_oqc_dir';
var tbl_attachments 	= 'tbl_view_attachments';
var dt_oqc_dimension	= '';
var search_keyword 		= '';
var search_value 		= '';
var var_pkid_meas 		= '';

var modal_id = 'modal_dir_new';

fn_get_po_number_datalist(modal_id+' #list_po_number','');

$('#'+modal_id+' #po_number').keyup(function(e){
	var modal_id = 'modal_dir_new';
	var key 	= e.which;
	if(key == 38 || key == 40){
		return false;
	}
	var pattern = $(this).val();
	fn_get_po_number_datalist(modal_id+' #list_po_number',pattern);
});

$('#modal_dir_new #po_number').keyup(function(e){
	var modal_id = 'modal_dir_new';
	var key 	= e.which;
	if(key == 38 || key == 40){
		return false;
	}
	var pattern = $(this).val();
	fn_get_po_number_datalist(modal_id+' #list_po_number',pattern);
});

$('#modal_dir_new #po_number').change(function(e){
	var modal_id = 'modal_dir_new';
	var po_number = $(this).val();
	get_po_details(modal_id+' #list_po_number',po_number,function(result){
		console.log(result);
		$('#'+modal_id+' #series_name').val(result['device_name']);
		// $('#'+modal_id+' input[name="shipment_date"]').val(result['shipment_date']);
		$('#'+modal_id+' #customer').val(result['customer']);
		$('#'+modal_id+' .fa-save').prop('disabled',false);
	});
});

dt_oqc_dimension = $('#'+tbl_oqc_dimension).DataTable({
	"aaSorting"	 : [],
	"bProcessing": true,
	"bServerSide": true,
	"sAjaxSource": "server_side_scripts/oqc/dt_dimension_inspection_result.php?username="+username,
	"drawCallback": function( settings ) {
		$('#'+tbl_oqc_dimension).attr('style','width:100%;');
	}
});

$('#btn_upload_di').click(function(){
	var modal_id = 'modal_dir_new';
	$('#'+modal_id+' .fa-save').prop('disabled',true);
	$('#'+modal_id).modal('show');
});

$('#frm_upload_oqc_dir').submit(function(e){
	e.preventDefault();
	var serialized_data = new FormData(this);
		serialized_data.append("action","upload_oqc_dir");
	fn_upload_oqc_dir(serialized_data);
});

$('#frm_dimension_inspection_new').submit(function(e){
	e.preventDefault();
	var serialized_data = $(this).serialize();
	fn_save_oqc_dir(serialized_data);
});

$('#tbl_oqc_dir tbody').on('click','tr .fa-eye',function(){
	var frm_id 			= 'frm_dimension_inspection_edit';
	var frm_reupload_id = 'frm_reupload_oqc_dir';
	var modal_id 		= "modal_dir_edit";
	$('#'+frm_id+' input,#'+frm_id+' textarea').prop("readonly",true);
	$('#'+frm_reupload_id).hide();
	var id 				= $(this).attr("id");	
	fn_get_oqc_dir_details(id,frm_id);
	$('#'+modal_id).data('id',id);
	$('#'+modal_id).modal('show');
	$('#'+modal_id+' .fa-save').hide();
});

$('#tbl_oqc_dir tbody').on('click','tr .fa-edit',function(){
	var frm_id 			= 'frm_dimension_inspection_edit';
	var frm_reupload_id = 'frm_reupload_oqc_dir';
	var modal_id 		= "modal_dir_edit";
	$('#'+frm_id+' input,#'+frm_id+' textarea').prop("readonly",false);
	$('#'+frm_reupload_id).show();
	var id 				= $(this).attr("id");
	fn_get_oqc_dir_details(id,frm_id);
	$('#'+modal_id+' .fa-save').prop('disabled',true);
	$('#'+modal_id).data('id',id);
	$('#'+modal_id).modal('show');
	$('#'+modal_id+' .fa-save').show();
});

$('#tbl_oqc_dir tbody').on('click','tr .fa-remove',function(){
	var frm_id 		= 'frm_dir_cancel';
	var modal_id 	= "modal_dir_cancel";
	var id 			= $(this).attr("id");
	$('#'+modal_id).data('id',id);
	$('#'+modal_id).modal('show');
});

$('#frm_reupload_oqc_dir').submit(function(e){
	e.preventDefault();
	var serialized_data = new FormData(this);
		serialized_data.append("action","reupload_oqc_dir");
	fn_reupload_oqc_dir(serialized_data);
});

$('#frm_dimension_inspection_edit').submit(function(e){
	e.preventDefault();
	var serialized_data = $(this).serialize();
	var modal_id 		= "modal_dir_edit";
	var id 				= $("#"+modal_id).data("id");
	fn_edit_oqc_dir(id,serialized_data);
});

$('#frm_dir_cancel').submit(function(e){
	e.preventDefault();
	var serialized_data = $(this).serialize();
	var modal_id 		= "modal_dir_cancel";
	var id 				= $("#"+modal_id).data("id");
	fn_cancel_oqc_dir(serialized_data);
});

function fn_upload_oqc_dir(serialized_data){
	call_ajax_attachment_2(serialized_data,handler_oqc_dir,function(result){
		console.log(result);
		/* error in excel file */
		if(result['upload_error']){
			var error_message = "This excel file may contain shapes or objects that cannot be read by the system. <br><br> How to upload this file: <br> Open the excel file and merge all shapes and pictures into one picture. <br> Note: If it is not possible to merge the contents please enter the details below manually then save.";
			/* Change this to your desired system message modal ID */
			var modal_id 		= 'modal_oqc_dir_system_message';
			/* Empty the system message */
			$('#'+modal_id+' #div_system_message').empty();
			/* Add a an alert danger class */
			$('#'+modal_id+' #div_system_message').attr("class","alert alert-danger");
			/* Append system message */
			$('#'+modal_id+' #div_system_message').append("<p>Error Upload:</p>");
			/* Append returned error messages */
			$('#'+modal_id+' #div_system_message').append("<p style='text-align:left;'>"+error_message+"</p>");
			$('#'+modal_id+'').modal('show');
			$('#'+modal_id+' .fa-save').prop('disabled',false);
			return false;
		}
		/* Validate if error array is not empty */
		if(result['error'].length != 0){
			/* Change this to your desired system message modal ID */
			var modal_id 		= 'modal_oqc_dir_system_message';
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
			var modal_id 	= 'modal_dir_new';
			var form_id		= 'frm_dimension_inspection_new';
			$.each(result['data'],function(key,value){
				$('#'+modal_id+' input[name="'+key+'"]').val(value.trim());
			});
			$('#'+modal_id+' .fa-save').prop('disabled',false);
		}
	});
}

function fn_save_oqc_dir(serialized_data){
	var frm_id = 'frm_upload_oqc_dir';
	var data = {
		"action"	: "save_oqc_dir",
		"file"		: $('#'+frm_id+' input[type="file"]').val(), //Get the filename from the file in frm_upload_oqc_dir
		"username"	: username
	}
	call_ajax_serialize(data,serialized_data,handler_oqc_dir,function(result){
		console.log(result);
		/* Change this to your desired system message modal ID */
		var modal_id 		= 'modal_oqc_dir_system_message';
		var form_id 		= 'frm_dimension_inspection_new';
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
			$('#'+modal_id+' #div_system_message').append("Dimension inspection result has been successfully uploaded!");
			$('#'+modal_id+'').modal('show');
			fn_system_message_timer(''+modal_id+'');
			$('#'+form_id+' input').val('');
			$('#'+form_upload_id+' input').val('');
			dt_oqc_dimension.ajax.reload();
		}		
	});
}

function fn_get_oqc_dir_details(id,frm_id){
	var data = {
		"action"	: "get_oqc_dir_details",
		"id"		: id
	}
	call_ajax(data, handler_oqc_dir, function(result){
		console.log(result);
		$.each(result['data'],function(key, value){
			$('#'+frm_id+' input[name="'+key+'"]').val(value);
			$('#'+frm_id+' textarea[name="'+key+'"]').val(value);
		});
	});
}

function fn_reupload_oqc_dir(serialized_data){
	call_ajax_attachment(serialized_data,handler_oqc_dir,function(result){
		console.log(result);
		/* Validate if error array is not empty */
		if(result['error'].length != 0){
			/* Change this to your desired system message modal ID */
			var modal_id 		= 'modal_oqc_dir_system_message';
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
			var modal_id 	= 'modal_dir_edit';
			var form_id		= 'frm_dimension_inspection_edit';
			$.each(result['data'],function(key,value){
				$('#'+modal_id+' input[name="'+key+'"]').val(value.trim());
			});
			$('#'+modal_id+' .fa-save').prop('disabled',false);
		}
	});
}

function fn_edit_oqc_dir(id,serialized_data){
	var frm_id = 'frm_reupload_oqc_dir';
	var data = {
		"action"	: "edit_oqc_dir",
		"file"		: $('#'+frm_id+' input[type="file"]').val(), //Get the filename from the file in frm_upload_oqc_dir
		"id"		: id,
		"username"	: username
	}
	call_ajax_serialize(data,serialized_data,handler_oqc_dir,function(result){
		console.log(result);
		/* Change this to your desired system message modal ID */
		var modal_id 		= 'modal_oqc_dir_system_message';
		var form_id 		= 'frm_dimension_inspection_edit';
		var form_upload_id  = 'frm_reupload_qcfr';
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
			$('#'+modal_id+' #div_system_message').append("Dimension inspection result has been successfully re-uploaded!");
			$('#'+modal_id+' .fa-save').prop('disabled',false);
			$('#'+modal_id+'').modal('show');
			fn_system_message_timer(''+modal_id+'');
			$('#'+form_id+' input').val('');
			$('#'+form_upload_id+' input').val('');
			dt_oqc_dimension.ajax.reload();
		}		
	});
}

function fn_cancel_oqc_dir(serialized_data){
	var modal_id = "modal_dir_cancel";
	var data = {
		"action"	: "cancel_oqc_dir",
		"id"		: $('#'+modal_id).data("id")
	}
	call_ajax_serialize(data, serialized_data, handler_oqc_dir,function(result){
		console.log(result);
		var modal_id 		= "modal_oqc_dir_system_message";
		var form_id 		= 'frm_dir_cancel';
		$('.modal').modal('hide');
		$('#'+modal_id+' #div_system_message').empty();
		$('#'+modal_id+' #div_system_message').attr("class","alert alert-success");
		$('#'+modal_id+' #div_system_message').append("Dimension inspection result has been cancelled!");
		$('#'+modal_id+' .fa-save').prop('disabled',false);
		$('#'+modal_id+'').modal('show');
		fn_system_message_timer(''+modal_id+'');
		$('#'+form_id+' input').val('');
		dt_oqc_dimension.ajax.reload();
	});
}

// $(window).keydown(function(event){
	// alert(event.keyCode);
	// if(event.keyCode == 13) {
	   // event.preventDefault();
	  // return false;
	// }
// });

/* ***************************
	Dimension Inspection Result Functions - End
*************************** */

/* **************************** 
	Start - Advanced Search 
**************************** */
var global_oqc_dir_as_where		 	= '';
var dir_as_select_ctr				= 1;

$('#btn_oqc_dir_search_main').click(function(){
	if( global_oqc_dir_as_where == ""){
		$('#tbl_oqc_dir_advance_search tbody').empty();
		fn_oqc_dir_as_draw_row('cmb_oqc_dir_as_field0');
		fn_oqc_dir_return_visual_inspection_fields('cmb_oqc_dir_as_field0');
	}
	$('#modal_oqc_dir_advance_search').modal('show');
});

$('#frm_oqc_dir_advance_search #btn_dir_as_add').click(function() {
	dir_as_select_ctr++;
	var select_id = 'cmb_oqc_dir_as_field0'+dir_as_select_ctr;
	fn_oqc_dir_as_draw_row(select_id);
	fn_oqc_dir_return_visual_inspection_fields(select_id);
});

$('#frm_oqc_dir_advance_search #btn_dir_as_reset').click(function() {
	global_oqc_dir_as_where = '';
	$('#tbl_oqc_dir_advance_search tbody').empty();
	fn_oqc_dir_as_draw_row('cmb_oqc_dir_as_field0');
	fn_oqc_dir_return_visual_inspection_fields('cmb_oqc_dir_as_field0');
	dt_oqc_dimension.ajax.url("server_side_scripts/oqc/dt_dimension_inspection_result.php?username="+username+"&wh="+global_oqc_dir_as_where).load();
});

$('#frm_oqc_dir_advance_search').on('submit', function(e) {
	e.preventDefault();
	var serialized_data = $(this).serialize();
	fn_oqc_dir_advance_search(serialized_data);
	$('#modal_oqc_dir_advance_search').modal('hide');
	// $('#tbl_oqc_dir_advance_search tbody').empty();
	vir_as_select_ctr = 0;
});

/* change the input type once date is selected */
$('#tbl_oqc_dir_advance_search tbody').on('change', 'select[name="field_name[]"]', function(){
	var select_value = $(this).val();
	var selected_row = $(this).closest('tr');
	var row_index 	= selected_row.index();
	if(select_value == "shipment_date"){
		selected_row.find('td:eq(2)').html('<input type="text" class="form-control ui-datepicker" name="val[]" id="txt_date_range" placeholder="Click to add date" required readonly>');
		selected_row.find('td:eq(1) select').empty();
		selected_row.find('td:eq(1) select').append('<option value="BETWEEN">BETWEEN</option>');
		date_time_picker('tbl_oqc_dir_advance_search tr:eq('+row_index+') #txt_date_range');
	}else{
		selected_row.find('td:eq(2)').html('<input type="text" id="cmb_oqc_dir_as_value" name="val[]" class="form-control condensed" required>');
		selected_row.find('td:eq(1) select').empty();
		selected_row.find('td:eq(1) select').append('<option value="EQUALS"> EQUALS </option>');
		selected_row.find('td:eq(1) select').append('<option value="LIKE"> CONTAINS </option>');
	}
});

$('#tbl_oqc_dir_advance_search tbody').on('click', 'button[type="button"]', function() {
	$(this).closest('tr').remove();
	return false;
});

function fn_oqc_dir_as_draw_row(select_id){
	var row  = '<tr>';
		row += '	<td style="width:30%;">';
		row += '		<select id="'+select_id+'" name="field_name[]" class="form-control condensed" required>';
		row += '		</select>';
		row += '	</td>';
		row += '	<td style="width:20%;">';
		row += '		<select id="cmb_dir_as_condition" name="condition[]" class="form-control condensed" required>';
		row += '			<option value="EQUALS"> EQUALS </option>';
		row += '			<option value="LIKE"> CONTAINS </option>';
		row += '		</select>';
		row += '	</td>';
		row += '	<td style="width:40%;">';
		row += '		<input type="text" id="cmb_oqc_dir_as_value" name="val[]" class="form-control condensed" required>';
		row += '	</td>';
		row += '	<td style="width:10%;">';
		row += '		<button type="button" id="btn_dir_as_remove" class="btn btn-default fa fa-trash"> Remove</button>';
		row += '	</td>';
		row += '</tr>';
	$('#tbl_oqc_dir_advance_search tbody').append(row);
}

function fn_oqc_dir_return_visual_inspection_fields(select_id){
	var data = {
		"action"	: "oqc_dir_return_dir_fields"
	}
	call_ajax(data, handler_oqc_dir, function(result){	
		for(var i=0; i < result['ctr']; i++) {
			$('#'+select_id).append(result['option'][i]);
		}
	});
}

function fn_oqc_dir_advance_search(serialized_data) {
	var data = {
		"action"	: "oqc_dir_advance_search"
	}
	call_ajax_serialize(data, serialized_data, handler_oqc_dir, function(result){	
		console.log(result);
		global_oqc_dir_as_where = encodeURIComponent(result['sql_where']);
		dt_oqc_dimension.ajax.url("server_side_scripts/oqc/dt_dimension_inspection_result.php?username="+username+"&wh="+global_oqc_dir_as_where).load(); //check this
	});
}
/* ****************************
	End - Advanced Search 
**************************** */