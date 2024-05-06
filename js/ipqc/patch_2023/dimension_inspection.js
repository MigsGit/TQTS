/* **************************************************
	Dimension Inspection Functions - Start
/***************************************************/

var global_as_where 	= '';
var dir_as_select_ctr 	= 0;

dt_ipqc_dir = $('#tbl_dimension_inspection').DataTable({
	"aaSorting"	 : [],	
	"bProcessing": true,
	"bServerSide": true,
	"sAjaxSource": "server_side_scripts/ipqc/dt_dimension_inspection.php?username="+username+"&wh="+global_as_where,
	"drawCallback": function( settings ) {
		$('#tbl_dimension_inspection').attr('style','width:100%;');
	}
});

/* Advance Search - Start */
$('#btn_dir_search_main').click(function() {
	if( global_as_where == ""){
		$('#tbl_dir_advance_search tbody').empty();
		fn_dir_oo_as_draw_row('cmb_dir_as_field0');
		fn_dir_oo_return_dimension_inspection_fields('cmb_dir_as_field0');
	}
	$('#modal_dir_advance_search').modal();
});

$('#frm_dir_advance_search fa-eraser').click(function() {
	global_as_where = '';
	dt_ipqc_dir.ajax.url("server_side_scripts/ipqc/dt_dimension_inspection.php?username="+username+"&wh="+global_as_where).load();
});

$('#frm_dir_advance_search .fa-plus').click(function() {
	dir_as_select_ctr++;
	var select_id = 'cmb_dir_as_field'+dir_as_select_ctr;
	fn_dir_oo_as_draw_row(select_id);
	fn_dir_oo_return_dimension_inspection_fields(select_id);
});

/* change the input type once date is selected */
$('#tbl_dir_advance_search tbody').on('change', 'tr td:eq(0) select', function(){
	var select_value = $(this).val();
	var selected_row = $(this).closest('tr');
	var row_index 	= selected_row.index();
	if(select_value == "inspection_date"){
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

$('#frm_dir_advance_search').on('submit', function(e) {
	e.preventDefault();
	var serialized_data = $(this).serialize();
	// $('.btn').prop("disabled",true);
	fn_dir_oo_advance_search(serialized_data);
	$('#modal_dir_advance_search').modal('hide');
	$('#tbl_dir_advance_search tbody').empty();
	dir_as_select_ctr = 0;
});

/* Advance Search - End */

$('#tbl_dimension_inspection tbody').on('click', '.fa-edit', function() {
	var pkid = $(this).val();
	fn_return_dimension_record(pkid, function() {
		$('#div_edit_label').show();
		$('#div_edit_file').show();
		$('#modal_dir_edit_inspection #lbl_header').attr('class', 'fa fa-edit');
		$('#modal_dir_edit_inspection #lbl_header').html(' Edit Dimension Inspection');
		$('#modal_dir_edit_inspection').modal();
		$('#modal_dir_edit_inspection').data('id', pkid);
		$('#modal_dir_edit_inspection button[type="submit"]').show();
	});
});

$('#tbl_dimension_inspection tbody').on('click', '.fa-eye', function() {
	var pkid = $(this).val();
	fn_return_dimension_record(pkid, function() {
		$('#div_edit_label').hide();
		$('#div_edit_file').hide();
		$('#div_view_label').show();
		$('#div_view_file').show();
		$('#modal_dir_edit_inspection #lbl_header').attr('class', 'fa fa-eye');
		$('#modal_dir_edit_inspection #lbl_header').html(' View Dimension Inspection');
		$('#modal_dir_edit_inspection').modal();
		$('#modal_dir_edit_inspection').data('id', pkid);
		$('#modal_dir_edit_inspection button[type="submit"]').hide();
	});
});

$('#tbl_dimension_inspection tbody').on('click', '.fa-paperclip', function() {
	window.location.href = 'pages/ipqc/dl_ipqc_report.php?id='+$(this).val();
});

$('#btn_dir_new_main').click(function() {
	$('#modal_dir_new_inspection').modal();
});

$('#frm_dir_save_new_inspection input[name="po_number"]').keyup(function(e){
	var key = e.which;
	if(key == 38 || key == 40){
		return false;
	}
	var pattern = $(this).val();
	fn_get_po_number_list(pattern,'frm_dir_save_new_inspection #list_po_number');
});

$('#frm_dir_save_new_inspection').on('submit', function(e) {
	e.preventDefault();
	$('.btn').prop("disabled",true);
	var form_data = new FormData(this);
		form_data.append("action","dir_save_new_dimension_report");
		form_data.append("username",username);
		
		call_ajax_attachment(form_data, handler_ipqc_dir, function(result){
			if(result['msg'] == "New record has been saved") {
				$('#modal_dir_new_inspection').modal('hide');
				$('#frm_dir_save_new_inspection input').val('');
				$('#frm_dir_save_new_inspection textarea').val('');
				$('#container_message').attr( 'class', 'alert alert-success' );
			} else {
				$('#container_message').attr( 'class', 'alert alert-danger' );
			}			
			$('#container_message').html( result['msg'] );
			$('#modal_system_message').modal();
			$('.btn').prop("disabled",false);
			dt_ipqc_dir.ajax.url("server_side_scripts/ipqc/dt_dimension_inspection.php?username="+username+"&wh="+global_as_where).load();
		});
});

$('#frm_dir_save_new_inspection input[name="po_number"]').keyup(function(e){
	var key = e.which;
	if(key == 38 || key == 40){
		return false;
	}
	var pattern = $(this).val();
	fn_get_po_number_list(pattern,'frm_dir_save_new_inspection #list_po_number');
});

$('#modal_dir_edit_inspection #btn_dl_inspection_file').click(function() {
	window.location.href = 'pages/ipqc/dl_ipqc_report.php?id='+$(this).val();
});

$('#frm_dir_update_inspection input[name="po_number"]').keyup(function(e){
	var key = e.which;
	if(key == 38 || key == 40){
		return false;
	}
	var pattern = $(this).val();
	fn_get_po_number_list(pattern,'frm_dir_update_inspection #list_po_number2');
});

$('#frm_dir_update_inspection #chk_reselect_file').click(function() {
	if($(this).is(':checked')) {
		$('#frm_dir_update_inspection #inspection_file').attr('required', true);
		$('#frm_dir_update_inspection #inspection_file').attr('readOnly', false);
	} else {
		$('#frm_dir_update_inspection #inspection_file').attr('required', false);
		$('#frm_dir_update_inspection #inspection_file').attr('readOnly', true);
		$('#frm_dir_update_inspection #inspection_file').val('');
	}
});

$('#frm_dir_update_inspection').on('submit', function(e) {
	e.preventDefault();
	$('.btn').prop("disabled",true);
	var form_data = new FormData(this);
		form_data.append("action","dir_update_dimension_report");
		form_data.append("pkid",$('#modal_dir_edit_inspection').data('id'));
		form_data.append("username",username);
		
		call_ajax_attachment(form_data, handler_ipqc_dir, function(result){
			if(result['msg'] == "Record has been updated" || result['msg'] == "File was successfully uploaded! Record has been updated") {
				$('#modal_dir_edit_inspection').modal('hide');
				$('#container_message').attr( 'class', 'alert alert-success' );
				$('#frm_dir_update_inspection #chk_reselect_file').attr('checked', false);
				$('#frm_dir_update_inspection #inspection_file').attr('required', false);
				$('#frm_dir_update_inspection #inspection_file').attr('readOnly', true);
				$('#frm_dir_update_inspection #inspection_file').val('');
			} else {
				$('#container_message').attr( 'class', 'alert alert-danger' );
			}			
			$('#container_message').html( result['msg'] );
			$('#modal_system_message').modal();
			$('.btn').prop("disabled",false);
			dt_ipqc_dir.ajax.url("server_side_scripts/ipqc/dt_dimension_inspection.php?username="+username+"&wh="+global_as_where).load();
		});
});

function fn_return_dimension_record(pkid, callback) {
	var data = {
		"action"	: "dir_get_dimension_record_by_pkid",
		"pkid"		: pkid
	}
	call_ajax(data, handler_ipqc_dir, function(result){
		// console.log(result)
		$('#frm_dir_update_inspection #ic').val( result['ic'] );
		$('#frm_dir_update_inspection #inspection_date').val( result['inspection_date'] );
		$('#frm_dir_update_inspection #po_number').val( result['po_number'] );
		$('#frm_dir_update_inspection #category').val( result['category'] );
		$('#frm_dir_update_inspection #btn_dl_inspection_file').text( result['inspection_file'] );
		$('#frm_dir_update_inspection #btn_dl_inspection_file').val( pkid );
		$('#frm_dir_update_inspection #remarks').val( result['remarks'] );
		callback();
	});
}

function fn_dir_oo_advance_search(serialized_data) {
	var data = {
		"action"	: "dir_advance_search"
	}
	call_ajax_serialize(data, serialized_data, handler_ipqc_dir, function(result){	
		$('.btn').prop("disabled",false);
		global_as_where = encodeURIComponent(result['sql_where']);
		// console.log(global_as_where);
		dt_ipqc_dir.ajax.url("server_side_scripts/ipqc/dt_dimension_inspection.php?username="+username+"&wh="+global_as_where).load();
	});
}	
/* Advance search functions */
function fn_dir_oo_as_draw_row(select_id) {
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

function fn_dir_oo_return_dimension_inspection_fields(select_id) {
	var data = {
		"action"	: "dir_return_dimension_inspection_fields"
	}
	call_ajax(data, handler_ipqc_dir, function(result){	
		for(var i=0; i < result['ctr']; i++) {
			$('#'+select_id).append(result['option'][i]);
		}
	});
}

/* Advance search functions */

/* **************************************************
	Dimension Inspection Functions - End
/***************************************************/