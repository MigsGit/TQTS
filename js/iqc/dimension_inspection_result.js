/* ***************************
	Dimension Inspection Result Functions - Start
*************************** */

$('#btn_upload_di').click(function(){
	$('#modal_upload_file').modal('show');
});

var handler_iqc 		= './handler/handler_iqc.php';
var username 			= $('#hd_username').val();
var tbl_iqc_dimension 	= 'tbl_iqc_dimension';
var tbl_attachments 	= 'tbl_view_attachments';
var dt_iqc_dimension	= '';
var search_keyword 		= '';
var search_value 		= '';
var var_pkid_meas 		= '';

$(window).keydown(function(event){
	if(event.keyCode == 13) {
	  event.preventDefault();
	  return false;
	}
  });

dt_iqc_dimension = $('#'+tbl_iqc_dimension).DataTable({
	"aaSorting"	 : [],
	"bProcessing": true,
	"bServerSide": true,
	"sAjaxSource": "server_side_scripts/iqc/dt_dimension.php",
	"drawCallback": function( settings ) {
		$('#'+tbl_iqc_dimension).attr('style','width:100%;');
	}
});

$('#frm_upload_measdata').on('submit', function(e) {
	e.preventDefault();
	var serialized_data = new FormData(this);
		serialized_data.append("action","upload_meas_data");
		serialized_data.append("username",username);

	call_ajax_attachment(serialized_data, handler_iqc, function(result){
		$('#modal_upload_file').modal('hide');
		empty_form_fields('modal_upload_file');
		$('#modal_system_message').modal();
		$('#container_message').html( '<h4>'+result['msg']+'</h4>' );
		dt_iqc_dimension.ajax.reload();
	});
});

$('#'+tbl_iqc_dimension+' tbody').on('click','#btn_attachment', function() {
	var_pkid_meas = $(this).val();
	fn_display_attachment(var_pkid_meas, function() {
		$('#modal_attachment_viewer').modal();
	});
});

$('#'+tbl_attachments+' tbody').on('click','#btn_dl_attachment', function() {
	var pkid = $(this).val();
	fn_download_attachment(pkid);
});

$('#'+tbl_attachments+' tbody').on('click','#btn_remove_attachment', function() {
	var pkid = $(this).val();
	$('#btn_yes_remove_attachment').val(pkid);
	$('#modal_remove_attachment_confirmation').modal();
});

$('#frm_remove_attachment').on('submit', function(e) {
	e.preventDefault();
	fn_remove_attachment();
});

$('#'+tbl_iqc_dimension+' tbody').on('click','#btn_edit', function() {
	var pkid_meas = $(this).val();
	fn_return_measdata_attachments(pkid_meas, function() {
		$('#btn_view_attachments').val(pkid_meas);
		$('#modal_reupload_file').modal();
	});        
});

$('#frm_upload_measdata select[name="measurement_type"]').change(function(){
	var measurement_type = $(this).val();
	fn_display_measurement_type('frm_upload_measdata', measurement_type);
});

$('#frm_update_measdata #chk_reupload').click(function() {		
	if($(this).is(':checked')) {
		$('#frm_update_measdata #file_measdata').attr('required', true);
		$('#frm_update_measdata #file_measdata').attr('disabled', false);
	} else {
		$('#frm_update_measdata #file_measdata').attr('required', true);
		$('#frm_update_measdata #file_measdata').attr('disabled', true);
	}
});

$('#frm_update_measdata #btn_view_attachments').click(function() {
	var_pkid_meas = $(this).val();
	fn_display_attachment(var_pkid_meas, function() {
		$('#modal_attachment_viewer').modal();
	});
});

$('#frm_update_measdata select[name="measurement_type"]').change(function(){
	var measurement_type = $(this).val();
	fn_display_measurement_type('frm_update_measdata',measurement_type);
});

$('#frm_update_measdata').on('submit', function(e) {
	e.preventDefault(); 
	var serialized_data = new FormData(this);
		serialized_data.append("action","re_upload_meas_data");
		serialized_data.append("pkid",$('#btn_view_attachments').val());
		serialized_data.append("username",username);
		
	call_ajax_attachment(serialized_data, handler_iqc, function(result){
		$('#modal_upload_file').modal('hide');
		$('#modal_system_message').modal();
		$('#container_message').html( '<h4>'+result['msg']+'</h4>' );
		dt_iqc_dimension.ajax.reload();
	});
});

$('#frm_upload_measdata #txt_partcode').change(function() {
	console.log('change txt_partcode');
	if($(this).val() != '') {
		// fn_get_partname_by_partcode($(this).val(), 'frm_upload_measdata #txt_partname');
		fn_get_partname_by_partcode('frm_upload_measdata #txt_partname', $(this).val());
	}
}); 

$('#frm_upload_measdata #txt_invoice_number').keyup(function(e) {
	fn_update_invoice_number_datalist($(this).val(),'frm_upload_measdata #list_invoice_number');
});

$('#frm_upload_measdata #txt_invoice_number').change(function(e) {
	if($(this).val() != '' || e.keyCode == 13) {
		fn_get_partcode_datalist_by_invoice_num($(this).val(), 'frm_upload_measdata #list_partcode');
	} 
});

$('#frm_upload_measdata #txt_po_number').change(function(e) {
	if($(this).val() != '' || e.keyCode == 13) {
		fn_get_partdetails_by_po_num($(this).val(), 'frm_upload_measdata #txt_device_code', 'frm_upload_measdata #txt_device_name');
	} 
});

$('#frm_upload_measdata #txt_po_number').keyup(function(e){
	 var key = e.which;
	 if(key == '38' || key == '40'){
	  return false;
	 }
	 var pattern = $(this).val();
	 fn_update_po_number_datalist(pattern,'frm_upload_measdata #list_po_number');
	
});

$('#frm_update_measdata #txt_partcode').change(function() {
	if($(this).val() != '') {
		// fn_get_partname_by_partcode($(this).val(), 'frm_update_measdata #txt_partname');
		fn_get_partname_by_partcode('frm_update_measdata #txt_partname', $(this).val());
	}
});

$('#frm_update_measdata #txt_invoice_number').keyup(function(e) {
	fn_update_invoice_number_datalist($(this).val(),'frm_update_measdata #list_invoice_number');
});

$('#frm_update_measdata #txt_invoice_number').keyup(function(e){
	 var key = e.which;
	 if(key == '38' || key == '40'){
	  return false;
	 }
	 var pattern = $(this).val();
	 fn_get_partcode_datalist_by_invoice_num(pattern, 'frm_update_measdata #list_partcode_update');
});

$('#frm_update_measdata #txt_po_number').change(function(e) {
	if($(this).val() != '' || e.keyCode == 13) {
		fn_get_partdetails_by_po_num($(this).val(), 'frm_update_measdata #txt_device_code', 'frm_update_measdata #txt_device_name');
	}
});

$('#frm_update_measdata #txt_po_number').keyup(function(e){
	 var key = e.which;
	 if(key == '38' || key == '40'){
	  return false;
	 }
	 var pattern = $(this).val();
	 fn_update_po_number_datalist(pattern,'frm_update_measdata #list_po_number_update');
});

fn_display_measurement_type('frm_upload_measdata','');
	
function fn_display_attachment(pkid, callback) {
	$('#'+tbl_attachments+' tbody').empty();
	var data = {
		"action" 		: "get_measdata_attachments",
		"pkid"			: pkid
	} 
	call_ajax(data, handler_iqc, function(result){
		$('#'+tbl_attachments+' tbody').append( result['table_body'] );
		callback();
	});
}

function fn_download_attachment(pkid) {
	window.location.href = "./reports/excel_iqc_measdata_attachments.php?id="+pkid;
}

function fn_remove_attachment() {
	var data = {
		"action" 		: "remove_measdata_attachment",
		"pkid"			: $('#btn_yes_remove_attachment').val(),
		"reason"		: $('#reason').val(),
		"username"		: username
	} 
	call_ajax(data, handler_iqc, function(result){
		$('#modal_remove_attachment_confirmation').modal('hide');
		fn_display_attachment(var_pkid_meas, function() {
		});
	});
}

function fn_display_measurement_type(frm_id, measurement_type){
	$('#'+ frm_id +' #container_mq1').hide();
	$('#'+ frm_id +' #container_mq1 input').val('');
	$('#'+ frm_id +' #container_mq2').hide();
	$('#'+ frm_id +' #container_mq2 input').val('');
	if(measurement_type == "1"){
		var list_id = '' + frm_id + ' #list_invoice_number';
		fn_update_invoice_number_datalist('',list_id);
		$('#'+ frm_id +' #container_mq1').toggle(100);
		$('#'+ frm_id +' #container_mq2 input').val('N/A');
		$('#'+ frm_id +' #txt_invoice_number').attr('required',true);
		$('#'+ frm_id +' #txt_partcode').attr('required',true);
		$('#'+ frm_id +' #txt_partname').attr('required',true);
		$('#'+ frm_id +' #txt_lot_number').attr('required',true);
		$('#'+ frm_id +' #txt_po_number').attr('required',false);
	} else if(measurement_type == "2"){
		var list_id = '' + frm_id + ' #list_po_number';
		fn_update_po_number_datalist('',list_id);
		$('#'+ frm_id +' #container_mq2').toggle(100);
		$('#'+ frm_id +' #container_mq1 input').val('N/A');
		$('#'+ frm_id +' #txt_invoice_number').attr('required',false);
		$('#'+ frm_id +' #txt_partcode').attr('required',false);
		$('#'+ frm_id +' #txt_partname').attr('required',false);
		$('#'+ frm_id +' #txt_lot_number').attr('required',false);
		$('#'+ frm_id +' #txt_po_number').attr('required',true);
	}
}

function fn_return_measdata_attachments(pkid, callback) {
	var data = {
		"action" 		: "return_meas_data_details_by_id",
		"pkid"			: pkid
	} 
	call_ajax(data, handler_iqc, function(result){
		fn_get_partdetails_by_po_num(result['po_number'], 'frm_update_measdata #txt_device_code', 'frm_update_measdata #txt_device_name');
		fn_display_measurement_type('frm_update_measdata',result['meas_type']);
		$('#frm_update_measdata #measurement_type').val(result['meas_type']);
		$('#frm_update_measdata #txt_invoice_number').val(result['invoice_number']);
		$('#frm_update_measdata #txt_lot_number').val(result['lot_number']);
		$('#frm_update_measdata #txt_partcode').val(result['part_code']);
		$('#frm_update_measdata #txt_partname').val(result['part_name']);
		$('#frm_update_measdata #txt_file_type').val(result['file_type']);
		$('#frm_update_measdata #txt_po_number').val(result['po_number']);
		$('#frm_update_measdata #txt_device_code').val(result['device_code']);
		$('#frm_update_measdata #txt_drawing_number').val(result['drawing_number']);
		$('#frm_update_measdata #txt_remarks').val(result['remarks']);
	   if(result['meas_type'] == 1) {
		   fn_update_invoice_number_datalist(result['invoice_number'],'frm_update_measdata #list_invoice_number');
	   }
		callback();
	});
}

function fn_get_partcode_datalist_by_invoice_num(invoice_num, cmb_id) {
	$('#'+cmb_id).empty();
	var data = {
		"action" 		: "get_partcode_datalist_by_invoice_num",
		"invoice_num"	: invoice_num
	} 
	call_ajax(data, handler_iqc, function(result){
		$('#'+cmb_id).append( '<option value="">-</option>' );
		$('#'+cmb_id).append( result['html_select'] );
	});
}

// function fn_get_partname_by_partcode(part_code, txt_id) {
// 	var data = {
// 		"action" 		: "get_partname_by_partcode",
// 		"part_code"		: part_code
// 	} 
// 	call_ajax(data, handler_iqc, function(result){
// 		$('#'+txt_id).val(result['part_name']);
// 	});
// }
	
function fn_get_partdetails_by_po_num(po_number, txt_id_device_code, txt_id_device_name) {
	var data = {
		"action" 		: "get_partdetails_by_po_num",
		"po_number"		: po_number
	} 
	call_ajax(data, handler_iqc, function(result){
		$('#'+txt_id_device_code).val(result['device_code']);
		$('#'+txt_id_device_name).val(result['device_name']);
	});
}

function fn_update_invoice_number_datalist(pattern,list_id){
	$('#'+list_id).empty();
	var data = {
		"action" : "get_invoice_num_datalist",
		"pattern" : pattern
	}
	call_ajax(data, handler_iqc, function(result){			
		$('#'+list_id).append(result['html']);
	});
}

function fn_update_po_number_datalist(pattern,list_id){
	$('#'+list_id).empty();
	var data = {
		"action" : "get_po_datalist",
		"pattern" : pattern
	}
	call_ajax(data, handler_iqc, function(result){			
		$('#'+list_id).append(result['html']);
	});
}
/* ***************************
	Dimension Inspection Result Functions - End
*************************** */

/* **************************** 
	Start - Advanced Search 
**************************** */
var global_dir_as_where		 		= '';
var dir_as_select_ctr				= 1;

$('#btn_dir_search_main').click(function(){
	if( global_dir_as_where == ""){
		$('#tbl_dir_advance_search tbody').empty();
		fn_dir_as_draw_row('cmb_dir_as_field0');
		fn_dir_return_visual_inspection_fields('cmb_dir_as_field0');
	}
	$('#modal_dir_advance_search').modal('show');
});

$('#frm_dir_advance_search #btn_dir_as_add').click(function() {
	dir_as_select_ctr++;
	var select_id = 'cmb_dir_as_field'+dir_as_select_ctr;
	fn_dir_as_draw_row(select_id);
	fn_dir_return_visual_inspection_fields(select_id);
});

$('#frm_dir_advance_search #btn_dir_as_reset').click(function() {
	global_dir_as_where = '';
	$('#tbl_dir_advance_search tbody').empty();
	fn_dir_as_draw_row('cmb_dir_as_field0');
	fn_dir_return_visual_inspection_fields('cmb_dir_as_field0');
	dt_iqc_dimension.ajax.url("server_side_scripts/iqc/dt_dimension.php?username="+username+"&wh="+global_dir_as_where).load();
});

$('#frm_dir_advance_search').on('submit', function(e) {
	e.preventDefault();
	var serialized_data = $(this).serialize();
	fn_dir_advance_search(serialized_data);
	$('#modal_dir_advance_search').modal('hide');
	// $('#tbl_dir_advance_search tbody').empty();
	vir_as_select_ctr = 0;
});

/* change the input type once date is selected */
$('#tbl_dir_advance_search tbody').on('change', 'select[name="field_name[]"]', function(){
	var select_value = $(this).val();
	var selected_row = $(this).closest('tr');
	var row_index 	= selected_row.index();
	if(select_value == "date_time_created"){
		selected_row.find('td:eq(2)').html('<input type="text" class="form-control ui-datepicker" name="val[]" id="txt_date_range" placeholder="Click to add date" required readonly>');
		selected_row.find('td:eq(1) select').empty();
		selected_row.find('td:eq(1) select').append('<option value="BETWEEN">BETWEEN</option>');
		date_time_picker('tbl_dir_advance_search tr:eq('+row_index+') #txt_date_range');
	}else{
		selected_row.find('td:eq(2)').html('<input type="text" id="cmb_dir_as_value" name="val[]" class="form-control condensed" required>');
		selected_row.find('td:eq(1) select').empty();
		selected_row.find('td:eq(1) select').append('<option value="EQUALS"> EQUALS </option>');
		selected_row.find('td:eq(1) select').append('<option value="LIKE"> CONTAINS </option>');
	}
});

$('#tbl_dir_advance_search tbody').on('click', 'button[type="button"]', function() {
	$(this).closest('tr').remove();
	return false;
});

function fn_dir_as_draw_row(select_id){
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
		row += '		<input type="text" id="cmb_dir_as_value" name="val[]" class="form-control condensed" required>';
		row += '	</td>';
		row += '	<td style="width:10%;">';
		row += '		<button type="button" id="btn_dir_as_remove" class="btn btn-default fa fa-trash"> Remove</button>';
		row += '	</td>';
		row += '</tr>';
	$('#tbl_dir_advance_search tbody').append(row);
}

function fn_dir_return_visual_inspection_fields(select_id){
	var data = {
		"action"	: "iqc_return_dir_fields"
	}
	call_ajax(data, handler_iqc, function(result){	
		for(var i=0; i < result['ctr']; i++) {
			$('#'+select_id).append(result['option'][i]);
		}
	});
}

function fn_dir_advance_search(serialized_data) {
	var data = {
		"action"	: "dir_advance_search"
	}
	call_ajax_serialize(data, serialized_data, handler_iqc, function(result){	
		console.log(result);
		global_dir_as_where = encodeURIComponent(result['sql_where']);
		dt_iqc_dimension.ajax.url("server_side_scripts/iqc/dt_dimension.php?username="+username+"&wh="+global_dir_as_where).load(); //check this
	});
}
/* ****************************
	End - Advanced Search 
**************************** */