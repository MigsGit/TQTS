/* **************************************************
	IPQC Pre-production - Start
/***************************************************/

var global_as_where 	= '';
var pp_as_select_ctr 	= 0;
var dt_ipqc_pp 			= '';

dt_ipqc_pp = $('#tbl_pre_production').DataTable({
	"aaSorting"	 : [],	
	"bProcessing": true,
	"bServerSide": true,
	"sAjaxSource": "server_side_scripts/ipqc/dt_pre_production.php?username="+username+"&wh="+global_as_where,
	"drawCallback": function( settings ) {
		$('#tbl_pre_production').attr('style','width:100%;');
	}
});
/* Main Table - Start */
$('#tbl_pre_production tbody').on('click', '.fa-edit', function() {
	var pkid = $(this).val();
	$('#modal_pp_edit_inspection').data('id', pkid);
	$('#frm_pp_update_inspection_result #measurescope_file').attr('name', "");
	$('#frm_pp_update_inspection_result #measurescope_file').prop('required', false);
	
	fn_pp_return_machine_list('frm_pp_update_inspection_result #machine', function() {
		fn_get_machine_inspection_record('modal_pp_edit_inspection', 'frm_pp_update_inspection_result', pkid, '');
		$('#frm_pp_update_inspection_result #measurescope_file').hide();
		$('#modal_pp_edit_inspection').modal();
	});		
});

$('#tbl_pre_production tbody').on('click', '.fa-file-excel-o', function() {
	var pkid = $(this).val();
	window.location.href = "./reports/ipqc/excel_ipqc_measurescope_file.php?id="+pkid;
});

$('#tbl_pre_production tbody').on('click', '.fa-eye', function() {
	var pkid = $(this).val();
	$('#modal_pp_edit_inspection').data('id', pkid);
	$('#frm_pp_view_inspection_result input[type="submit"]').hide();
	$('#frm_pp_view_inspection_result #measurescope_file').attr('name', "");
	$('#frm_pp_view_inspection_result #measurescope_file').prop('required', false);
	
	fn_return_report_approvers('frm_pp_view_inspection_result #checked_by', ['11'], function() {
		$('.chosen-select#checked_by').chosen({width:"100%", height: "100%"});
		fn_return_report_approvers_dept('frm_pp_view_inspection_result #approved_by', ['11'], function() {
			$('.chosen-select#approved_by').chosen({width:"100%", height: "100%"});
			fn_pp_return_machine_list('frm_pp_view_inspection_result #machine', function() {
				fn_get_machine_inspection_record('frm_pp_view_inspection_result', pkid, '');
				$('#frm_pp_view_inspection_result #measurescope_file').hide();
				$('#modal_pp_view_inspection').modal();
			});
			
		});	

	});
});


$('#frm_pp_update_inspection_result #btn_dl_measurescope_file').click( function() {
	var pkid = $(this).val();
	window.location.href = "./reports/ipqc/excel_ipqc_measurescope_file.php?id="+pkid;
});

$('#frm_pp_view_inspection_result #btn_dl_measurescope_file').click( function() {
	var pkid = $(this).val();
	window.location.href = "./reports/ipqc/excel_ipqc_measurescope_file.php?id="+pkid;
});

/* Main Table - End */

/* New - Start */

$('#btn_pp_new_inspection_main').click(function() {
	fn_pp_return_machine_list('frm_pp_save_inspection_result #machine', function(){});
	var mdl_id = 'modal_pp_create_new_inspection';
	var frm_id = 'frm_pp_save_inspection_result';
	re_initialize_select2_server_side('#'+mdl_id+' #cmb_checked_by','#'+mdl_id+' #'+frm_id,[],"server_side_scripts/dropdown/common/dd_hris_above_ss_list.php");
	re_initialize_select2_server_side('#'+mdl_id+' #cmb_approved_by','#'+mdl_id+' #'+frm_id,[],"server_side_scripts/dropdown/common/dd_hris_above_ss_list.php");
	$('#modal_pp_create_new_inspection input').val('');
	$('#modal_pp_create_new_inspection').modal();
});


$('#frm_pp_save_inspection_result').on('submit', function(e) {
	e.preventDefault();
	$('.btn').prop("disabled",true);
	$('#modal_pp_create_new_inspection #container_msg_create_new_inspection').hide();		
	
	var form_data = new FormData(this);
		form_data.append("action","pp_save_new_measurement_inspection");
		form_data.append("username",username);
		
		call_ajax_attachment(form_data, handler_ipqc_pp, function(result){
			console.log(result);
			if(result['msg'] == 'Record already exists!') {
				$('#container_message').attr('class', 'alert alert-danger');
			} else {
				$('#modal_pp_create_new_inspection').modal('hide');
				$('#container_message').attr('class', 'alert alert-success');
				dt_ipqc_pp.ajax.reload();
			}				
			$('#container_message').html( '<h4>'+result['msg']+'</h4>' );				
			$('#modal_system_message').modal();
			$('.btn').prop("disabled",false);
			$('#modal_pp_create_new_inspection #cmb_checked_by').val(null).trigger('change');
			$('#modal_pp_create_new_inspection #cmb_approved_by').val(null).trigger('change');
		});
});

/* New - End */

/* Edit - Start */
$('#frm_pp_update_inspection_result #chk_reselect_file').click(function() {
	if($(this).is(':checked')) {
		$('#frm_pp_update_inspection_result #measurescope_file').attr('name', "measurescope_file");
		$('#frm_pp_update_inspection_result #btn_dl_measurescope_file').text('');
		$('#frm_pp_update_inspection_result #measurescope_file').show();
		$('#frm_pp_update_inspection_result #measurescope_file').prop('required', true);
	} else {
		$('#frm_pp_update_inspection_result #measurescope_file').attr('name', "");
		$('#frm_pp_update_inspection_result #btn_dl_measurescope_file').text(' Download File');
		$('#frm_pp_update_inspection_result #measurescope_file').hide();
		$('#frm_pp_update_inspection_result #measurescope_file').prop('required', false);
	}
});

$('#frm_pp_update_inspection_result').on('submit', function(e) {
	e.preventDefault();
	$('.btn').prop("disabled",true);
	$('#frm_pp_update_inspection_result .alert-danger').hide();
	var form_data = new FormData(this);
		form_data.append("action","pp_update_inspection_result");
		form_data.append("pkid",$('#modal_pp_edit_inspection').data('id'));
		form_data.append("username",username);
		
		call_ajax_attachment(form_data, handler_ipqc_pp, function(result){
			console.log(result);
			$('#modal_pp_edit_inspection').modal('hide');
			$('#container_message').html( '<h4>'+result['msg']+'</h4>' );
			$('#modal_system_message').modal();
			dt_ipqc_pp.ajax.reload();
			$('.btn').prop("disabled",false);
		});
});

/* Edit -End */

/* Advance Search - Start */
$('#btn_pp_search_main').click(function() {
	if( global_as_where == ""){
		$('#tbl_pp_advance_search tbody').empty();
		fn_pp_oo_as_draw_row('cmb_pp_as_field0');
		fn_pp_oo_return_visual_inspection_fields('cmb_pp_as_field0');
	}
	$('#modal_pp_advance_search').modal();
});

$('#frm_pp_advance_search #btn_pp_as_reset').click(function() {
	global_as_where = '';
	dt_ipqc_pp.ajax.url("server_side_scripts/ipqc/dt_pre_production.php?username="+username+"&wh="+global_as_where).load();
});

$('#frm_pp_advance_search #btn_pp_as_add').click(function() {
	pp_as_select_ctr++;
	var select_id = 'cmb_pp_as_field'+pp_as_select_ctr;
	fn_pp_oo_as_draw_row(select_id);
	fn_pp_oo_return_visual_inspection_fields(select_id);
});

/* change the input type once date is selected */
$('#tbl_pp_advance_search tbody').on('change', 'tr td:eq(0) select', function(){
	var select_value = $(this).val();
	var selected_row = $(this).closest('tr');
	var row_index 	= selected_row.index();
	if(select_value == "meas_year_month"){
		selected_row.find('td:eq(2)').html('<input type="text" class="form-control ui-datepicker" name="val[]" id="txt_date_range" placeholder="Click to add date" required readonly>');
		selected_row.find('td:eq(1) select').empty();
		selected_row.find('td:eq(1) select').append('<option value="BETWEEN">BETWEEN</option>');
		date_time_picker('tbl_pp_advance_search tr:eq('+row_index+') #txt_date_range');
	}else{
		selected_row.find('td:eq(2)').html('<input type="text" id="cmb_pp_as_value" name="val[]" class="form-control condensed" required>');
		selected_row.find('td:eq(1) select').empty();
		selected_row.find('td:eq(1) select').append('<option value="EQUALS"> EQUALS </option>');
		selected_row.find('td:eq(1) select').append('<option value="LIKE"> CONTAINS </option>');
	}
});

$('#tbl_pp_advance_search tbody').on('click', 'button[type="button"]', function() {
	$(this).closest('tr').remove();
	return false;
});

$('#frm_pp_advance_search').on('submit', function(e) {
	e.preventDefault();
	var serialized_data = $(this).serialize();
	// $('.btn').prop("disabled",true);
	fn_pp_oo_advance_search(serialized_data);
	$('#modal_pp_advance_search').modal('hide');
	$('#tbl_pp_advance_search tbody').empty();
	pp_as_select_ctr = 0;
});

/* Advance Search - End */

/* Report - Start */

$('#btn_pp_report_main').click(function() {
	if(global_as_where == '') {
		alert('Please select search keywords from Advance Search portion.');
	} else {
		window.location.href = "./reports/ipqc/excel_ipqc_pre_production_summary.php?username="+username+"&wh="+global_as_where;
	}
});

/* Report - End */


function fn_get_machine_inspection_record(mdl_id, frm_id, pkid, mode) {
	var data = {
		"action"	: "pp_get_machine_inspection_record_by_pkid",
		"pkid"		: pkid
	}
	call_ajax(data, handler_ipqc_pp, function(result){
		$('#'+ frm_id +' #btn_dl_measurescope_file').val(pkid);
		$('#'+ frm_id +' #btn_dl_measurescope_file').text(' Download File');
		$('#'+ frm_id +' #machine').val(result['fkmachine']);
		$('#'+ frm_id +' #measurescope_no').val(result['measurescope_no']);
		$('#'+ frm_id +' #meas_year_month').val(result['meas_year_month']);
		
		assign_value_select2('#'+frm_id+' #cmb_checked_by',result['checked_by']);
		assign_value_select2('#'+frm_id+' #cmb_approved_by',result['approved_by']);
		
		re_initialize_select2_server_side('#'+mdl_id+' #cmb_checked_by','#'+mdl_id+' #'+frm_id,[],"server_side_scripts/dropdown/common/dd_hris_above_ss_list.php");
		re_initialize_select2_server_side('#'+mdl_id+' #cmb_approved_by','#'+mdl_id+' #'+frm_id,[],"server_side_scripts/dropdown/common/dd_hris_above_ss_list.php");
	});
}

function fn_pp_oo_as_draw_row(select_id) {
		var row  = '<tr>';
			row += '	<td style="width:30%;">';
			row += '		<select id="'+select_id+'" name="field_name[]" class="form-control condensed" required>';
			row += '		</select>';
			row += '	</td>';
			row += '	<td style="width:20%;">';
			row += '		<select id="cmb_pp_as_condition" name="condition[]" class="form-control condensed" required>';
			row += '			<option value="EQUALS"> EQUALS </option>';
			row += '			<option value="LIKE"> CONTAINS </option>';
			row += '		</select>';
			row += '	</td>';
			row += '	<td style="width:40%;">';
			row += '		<input type="text" id="cmb_pp_as_value" name="val[]" class="form-control condensed" required>';
			row += '	</td>';
			row += '	<td style="width:10%;">';
			row += '		<button type="button" id="btn_pp_as_remove" class="btn btn-default fa fa-trash"> Remove</button>';
			row += '	</td>';
			row += '</tr>';
		$('#tbl_pp_advance_search tbody').append(row);
	}

function fn_pp_oo_return_visual_inspection_fields(select_id) {
	var data = {
		"action"	: "pp_return_visual_inspection_fields"
	}
	call_ajax(data, handler_ipqc_pp, function(result){	
		for(var i=0; i < result['ctr']; i++) {
			$('#'+select_id).append(result['option'][i]);
		}
	});
}
	
function fn_pp_oo_advance_search(serialized_data) {
	var data = {
		"action"	: "pp_advance_search"
	}
	call_ajax_serialize(data, serialized_data, handler_ipqc_pp, function(result){	
		$('.btn').prop("disabled",false);
		global_as_where = encodeURIComponent(result['sql_where']);
		dt_ipqc_pp.ajax.url("server_side_scripts/ipqc/dt_pre_production.php?username="+username+"&wh="+global_as_where).load();
	});
}	

function fn_pp_return_machine_list(cmb_id, callback) {
	$('#'+cmb_id).empty();
	var data = {
		"action"		: "pp_return_machine_list"
	}
	call_ajax(data, handler_ipqc_pp, function(result){
		$('#'+cmb_id).append(result['html_select']);
		callback();
	});
}

// $('.modal').on("hidden.bs.modal", function (e) { //fire on closing modal box
	// if ($('.modal:visible').length) { // check whether parent modal is opend after child modal close
		// $('body').addClass('modal-open'); // if open mean length is 1 then add a bootstrap css class to body of the page
	// }
// });
/* **************************************************
	IPQC Pre-production - End
/***************************************************/