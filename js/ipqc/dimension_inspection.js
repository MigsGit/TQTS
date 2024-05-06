/* **************************************************
	Dimension Inspection Functions - Start
/***************************************************/
/**
 * fn_dir_return_category_list
 * fn_dir_oo_return_dimension_inspection_fields
 * fn_dir_oo_as_draw_row
 * fn_dir_oo_advance_search
 * fn_return_dimension_record
 * 
 * 
 * 	dt_ipqc_dir = $('#tbl_dimension_inspection').DataTable
 *	$('#btn_dir_search_main').click
 *	$('#frm_dir_advance_search fa-eraser').click
 *	$('#frm_dir_advance_search .fa-plus').click
 *	$('#tbl_dir_advance_search tbody').on
 *	$('#frm_dir_advance_search').on
 *	$('#tbl_dimension_inspection tbody').on
 *	$('#btn_dir_new_main').click
 *	$('#frm_dir_save_new_inspection').on
 *	$('#modal_dir_edit_inspection #btn_dl_inspection_file').click
 *	$('#frm_dir_update_inspection #chk_reselect_file').click
 *	$('#frm_dir_update_inspection').on
 */

$.ajaxSetup({
	type: 'POST',
	dataType: 'json',
	url: handler_ipqc_dir
});
var global_as_where 	= '';
var dir_as_select_ctr 	= 0;
$(document).ready(function () {
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
/* NOTE : MODIFY(2022) - fedit */
$('#tbl_dimension_inspection tbody').on('click', '.fa-edit', function() {
	var pkid = $(this).val();
	$('#frm_dir_update_inspection #inspection_file').hide();
	$('#frm_dir_update_inspection #inspection_file').val('');
	$('#frm_dir_update_inspection #chk_reselect_file').attr('checked', false);
	$('#frm_dir_update_inspection #btn_dl_inspection_file').show();
/* NOTE : fedit get the seleted value of edit_category */

	fn_dir_return_category_list('frm_dir_update_inspection #category');
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
	$('#modal_dir_new_inspection').modal('show');
	fn_dir_return_category_list('frm_dir_save_new_inspection #category');
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

$('#modal_dir_edit_inspection #btn_dl_inspection_file').click(function() {
	window.location.href = 'pages/ipqc/dl_ipqc_report.php?id='+$(this).val();
});

$('#frm_dir_update_inspection #chk_reselect_file').click(function() {
	if($(this).is(':checked')) {
		
		$('#frm_dir_update_inspection #inspection_file').show();
		$('#frm_dir_update_inspection #btn_dl_inspection_file').hide();
	} else {
		$('#frm_dir_update_inspection #inspection_file').hide();
		$('#frm_dir_update_inspection #btn_dl_inspection_file').show();
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
			if(result['msg'] == "Record has been updated" || result['msg'] == "File was successfully uploaded!") {
				$('#modal_dir_edit_inspection').modal('hide');
				$('#container_message').attr( 'class', 'alert alert-success' );
				$('#frm_dir_update_inspection #chk_reselect_file').attr('checked', false);
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
//fdelete
$('#tbl_dimension_inspection tbody').on('click', '.fa-remove', function() {
	$('#modal_dir_delete').modal('show');
	var pkid = $(this).data('id');
	console.log(pkid);
	fn_return_dimension_record(pkid,function(){


	});
});

$('#form_dir_delete').submit(function (e) { 
	e.preventDefault();
	var serialized_data = $(this).serialize();
	fn_dir_delete_info(serialized_data);
});

function fn_dir_delete_info(serialized_data){
	var data = {'action' : 'dir_delete_info'}
	call_ajax_serialize(data,serialized_data, handler_ipqc_dir,function(result){
		$('#modal_dir_delete').modal('hide');
		dt_ipqc_dir.draw();
		// notif_success('Deleted Successfully');
	});
}

function fn_return_dimension_record(pkid, callback) {
	var data = {
		"action"	: "dir_get_dimension_record_by_pkid",
		"pkid"		: pkid
	}
	call_ajax(data, handler_ipqc_dir, function(result){
		console.log(result['category']);
		$('#form_dir_delete #pkid').val(result['pkid']);
		
		$('#frm_dir_update_inspection #ic').val( result['ic'] );
		$('#frm_dir_update_inspection #inspection_date').val( result['inspection_date'] );
		// $('#frm_dir_update_inspection #po_number').val( result['po_number'] );
		// $('#frm_dir_update_inspection #category').val( result['category'] );
		/* NOTE : fedit get the category by pkid */
		$('select[name="category"]').prepend(`<option value="${result['category']}" hidden selected>${result['category']}</option>`);
		// $('select[name="category"]').val(result['category']);
		// $('#frm_dir_update_inspection #btn_dl_inspection_file').text( result['inspection_file'] );
		$('#frm_dir_update_inspection #btn_dl_inspection_file').val( pkid );
		$('#frm_dir_update_inspection #po_number').val( result['po_number'] );
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

/*	NOTE : MODIFY(2022) - fetch the category list	*/
function fn_dir_return_category_list(selected_id) { 
	var data = {
		"action"		: "dir_return_category_list"
	}
	$.ajax({
		type: 'POST',
		dataType: 'json',
		url: handler_ipqc_dir,
		data: data,
		success: function (result) {
			let ctr = result['ctr'];
			let option = `<option value="" disabled selected>Please select category</option>`;
			$('#'+selected_id).empty().append(option);
			
			for (let i = 0; i< ctr;i++){
				let body = `<option value = "${result['category'][i]}" > ${result['category'][i]} </option>`;
				$('#'+selected_id).append(body);
			}
		}
	});
}

});

/* Advance search functions */

/* ************************************************** 
	Dimension Inspection Functions - End
/***************************************************/