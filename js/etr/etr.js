/* ***************************
	ETR Production Main Table - Start
*************************** */
var tbl_etr_prdn    	= 'tbl_etr_production';
var dt_etr_prdn 		= '';

dt_etr_prdn = $('#'+tbl_etr_prdn).DataTable({
	"aaSorting"	 : [],	
	"bProcessing": true,
	"bServerSide": true,
	"sAjaxSource": "server_side_scripts/etr/dt_etr_production.php?un="+username,
	"drawCallback": function( settings ) {
		$('#'+tbl_etr_prdn).attr('style','width:100%;');
	}
});

$('#btn_etr_new').click(function() {	
	$('input[type="text"],input[type="datetime-local"],select').prop('required', true);
	$('#'+frm_prdn_new+' #prdn_second_take_trained_by').prop('required', false);
	$('#'+frm_prdn_new+' #prdn_second_take_date_time').prop('required', false);
	$('#'+frm_prdn_new+' #reason_certification_others').prop('required', false);
	$('#'+frm_prdn_new+' #div_prdn_second_take').hide();
	$('#'+frm_prdn_new+' #tbl_operator_list tbody').empty();
	
	fn_generate_etr_no(frm_prdn_new);
	fn_return_etr_training_title_lists(frm_prdn_new+' #dl_training_title', '');
	fn_return_etr_training_mechanics_lists(frm_prdn_new+' #dl_training_mechanics', '');
	fn_return_etr_venue_lists(frm_prdn_new+' #dl_training_venue', '');
	fn_return_reason_certification_lists(frm_prdn_new+' #container_reason_certification');
	fn_return_training_category_lists(frm_prdn_new+' #container_training_category');
    re_initialize_select2_server_side('#'+mdl_prdn_new+' #prdn_first_take_trained_by','#'+mdl_prdn_new+' #'+frm_prdn_new,[],"server_side_scripts/dropdown/common/dd_hris_all_list.php");
    re_initialize_select2_server_side('#'+mdl_prdn_new+' #prdn_checked_by','#'+mdl_prdn_new+' #'+frm_prdn_new,[],"server_side_scripts/dropdown/common/dd_hris_all_list.php");
    re_initialize_select2_server_side('#'+mdl_prdn_new+' #prdn_second_take_trained_by','#'+mdl_prdn_new+' #'+frm_prdn_new,[],"server_side_scripts/dropdown/common/dd_hris_all_list.php");
    re_initialize_select2_server_side('#'+mdl_prdn_new+' #eng_first_take_qualified_by','#'+mdl_prdn_new+' #'+frm_prdn_new,[],"server_side_scripts/dropdown/etr/dd_etr_engr_list.php");
    re_initialize_select2_server_side('#'+mdl_prdn_new+' #qc_first_take_certified_by','#'+mdl_prdn_new+' #'+frm_prdn_new,[],"server_side_scripts/dropdown/etr/dd_etr_qc_list.php");
	$('#'+mdl_prdn_new).modal();
});

/* ***************************
	ETR Production Main Table - End
*************************** */
/* ***************************
	ETR Production Add Functions - Start
*************************** */

var mdl_prdn_new 		= 'modal_etr_production_new';
var frm_prdn_new 		= 'frm_etr_production_new';

$('#'+frm_prdn_new+' input[name="training_title"]').keyup(function(e){
	var pattern = $(this).val();
	fn_return_etr_training_title_lists(frm_prdn_new+' #dl_training_title', pattern);
});

$('#'+frm_prdn_new+' input[name="training_title"]').change(function(e){
	var title_val = $(this).val();
	var title_id  = $('#'+frm_prdn_new+' option[value="'+title_val+'"]').attr('data-id');
	fn_return_etr_training_objective_by_title(frm_prdn_new, title_id);
});

$('#'+frm_prdn_new+' input[name="mechanics"]').keyup(function(e){
	var pattern = $(this).val();
	fn_return_etr_training_mechanics_lists(frm_prdn_new+' #dl_training_mechanics', pattern);
});

$('#'+frm_prdn_new+' input[name="type_of_training"]').keyup(function(e){
	var pattern = $(this).val();
	fn_return_etr_type_training_lists(frm_prdn_new+' #dl_type_of_training', pattern);
});

$('#'+frm_prdn_new+' input[name="venue"]').keyup(function(e){
	var pattern = $(this).val();
	fn_return_etr_venue_lists(frm_prdn_new+' #dl_training_venue', pattern);
});

$('#'+frm_prdn_new+' .fa-plus').click(function() {
	var disabled_second_take = '';
	if($('#'+frm_prdn_new+' #prdn_second_take_trained_by').val() === null || $('#'+frm_prdn_new+' #prdn_second_take_trained_by').val() == '') {
		disabled_second_take = 'disabled';
	}
	
    var table_tr  = '<tr>';
        table_tr += '    <td><select class="" id="operator_name" name="operator_name[]"  style="width:100%;" required></select></td>';
        table_tr += '    <td><select class="" id="operator_en" name="operator_en[]"  style="width:100%;" required></select></td>';
        table_tr += '    <td><input type="text" class="form-control" id="station_from" name="station_from[]"  style="width:100%;" required></td>';
        table_tr += '    <td><input type="text" class="form-control" id="station_to" name="station_to[]"  style="width:100%;" required></td>';
        table_tr += '    <td>';
        table_tr += '       <select class="form-control" id="prdn_first_take_result" name="prdn_first_take_result[]"  style="width:100%;" required>';
        table_tr += '           <option value="">-</option>';
        table_tr += '           <option value="PASSED">PASSED</option>';
        table_tr += '           <option value="FAILED">FAILED</option>';
        table_tr += '       </select>';
        table_tr += '    </td>';
        table_tr += '    <td>';
        table_tr += '       <select class="form-control" id="prdn_second_take_result" name="prdn_second_take_result[]"  style="width:100%;" required '+disabled_second_take+'>';
        table_tr += '           <option value="">-</option>';
        table_tr += '           <option value="PASSED">PASSED</option>';
        table_tr += '           <option value="FAILED">FAILED</option>';
        table_tr += '       </select>';
        table_tr += '    </td>';
        table_tr += '    <td><input type="hidden" name="details_pkid[]" value="0"><a href="#" class="fa fa-remove"> Remove</a></td>';
        table_tr += '</tr>';
    
    $('#'+mdl_prdn_new+' #tbl_operator_list tbody').append(table_tr);
    re_initialize_select2_server_side('#'+mdl_prdn_new+' #tbl_operator_list #operator_name','#'+mdl_prdn_new+' #'+frm_prdn_new,[],"server_side_scripts/dropdown/common/dd_operator_list.php");
    re_initialize_select2_server_side('#'+mdl_prdn_new+' #tbl_operator_list #operator_en','#'+mdl_prdn_new+' #'+frm_prdn_new,[],"server_side_scripts/dropdown/common/dd_operator_en_list.php");
});

$('#'+mdl_prdn_new+' #tbl_operator_list tbody').on('click' , 'a', function(){
    $(this).closest('tr').remove();
    return false;
});

/* Kelangan isa lang sa kanila ung naka-enable. Event by Emp. Name or Emp. No. :) START */
$('#'+mdl_prdn_new+' #tbl_operator_list tbody').on('change', 'tr #operator_name', function() {
    var emp_name = $(this).val();
    var row_index = $(this).closest('tr').index();
    fn_get_emp_no_by_operator_name(emp_name, mdl_prdn_new, frm_prdn_new+' #tbl_operator_list tbody tr:eq('+row_index+')');
});

//$('#'+mdl_prdn_new+' #tbl_operator_list tbody').on('change', 'tr #operator_en', function() {
//    var empno = $(this).val();
//    var row_index = $(this).closest('tr').index();
//    fn_get_emp_name_by_operator_empno(empno, mdl_prdn_new, frm_prdn_new+ ' #tbl_operator_list tbody tr:eq('+row_index+')');
//});
/* Kelangan isa lang sa kanila ung naka-enable. Event by Emp. Name or Emp. No. :) END */

$('#'+mdl_prdn_new+' #tbl_operator_list tbody').on('change', 'tr #prdn_first_take_result', function() {
    var first_result = $(this).val();/*alert($('#'+frm_prdn_new+' #tbl_operator_list tbody td:eq(3)').html());*/
    var row_index = $(this).closest('tr').index();
    if(first_result == 'FAILED') {
        $('#'+frm_prdn_new+' #tbl_operator_list tbody tr:eq('+row_index+') td:eq(5) select').prop('disabled', false);
    } else {
		$('#'+frm_prdn_new+' #tbl_operator_list tbody tr:eq('+row_index+') td:eq(5) select').prop('disabled', true);
		$('#'+frm_prdn_new+' #tbl_operator_list tbody tr:eq('+row_index+') td:eq(5) select').val('');
    }
	fn_prdn_check_first_take_result(mdl_prdn_new+' #tbl_operator_list', frm_prdn_new);
});

function fn_prdn_check_first_take_result(tbl_id, frm_id) {
	var show_second_take = false;
	
	$('#'+tbl_id+' tbody tr').each(function() {
		if($(this).find('td:eq(4) select').val() == 'FAILED') {
			$('#'+frm_id+' #prdn_second_take_trained_by').prop('required', true);
			$('#'+frm_id+' #prdn_second_take_date_time').prop('required', true);
			$('#'+frm_id+' #div_prdn_second_take').show();
			show_second_take = true;
		}
	});
	if(!show_second_take) {
		$('#'+frm_id+' #prdn_second_take_trained_by').prop('required', false);
		$('#'+frm_id+' #prdn_second_take_date_time').prop('required', false);
		$('#'+frm_id+' #div_prdn_second_take').hide();
	}
}

$('#'+mdl_prdn_new+' .fa-save').click(function(){
    var serialized_data = $('#'+frm_prdn_new).serialize();
    fn_save_prdn_training(serialized_data, 'DRAFT');
});

$('#'+frm_prdn_new).submit(function(e){
    e.preventDefault();
	var serialized_data = $(this).serialize();
	if($('#'+frm_prdn_new+' #tbl_operator_list tbody tr').length == 0) {
		$('#'+frm_prdn_new+' #container_etr_production_new_message').html('Please select operator names');
		$('#'+frm_prdn_new+' #container_etr_production_new_message').show();
	} else {	
		$('#'+frm_prdn_new+' #container_etr_production_new_message').hide();		
		fn_save_prdn_training(serialized_data, 'FOR PRDN CHECKING');
	}
});

function fn_generate_etr_no(frm_id) {
	var data = {
		"action"	: "generate_etr_no"
	}
	call_ajax(data, handler_etr, function(result){	
		$('#'+frm_id+' input[name="control_no"]').val(result['control_no']);
	});
}

function fn_save_prdn_training(serialized_data, status) {	 
	var prdn_second_take_result = new Array();
	$('#'+frm_prdn_new+' #tbl_operator_list tbody tr').each(function() {
		if($(this).find('td select').prop('disabled')) {
			prdn_second_take_result.push("");
			$(this).find('td select').prop('disabled', false);
		} else {
			prdn_second_take_result.push($(this).find('td:eq(5) select').val());
		}
	});
	
    var chk_reason_certification_id  = new Array();
    var chk_reason_certification_val = new Array();
    $('#'+mdl_prdn_new+' #container_reason_certification input[type="checkbox"]').each(function() {
		chk_reason_certification_id.push($(this).data('id'));
        chk_reason_certification_val.push($(this).prop('checked'));
    });
    
    var chk_training_category_id  = new Array();
    var chk_training_category_val = new Array();
    $('#'+mdl_prdn_new+' #container_training_category input[type="checkbox"]').each(function() {
        chk_training_category_id.push($(this).data('id'));
        chk_training_category_val.push($(this).prop('checked'));
    });
	$('.btn').prop("disabled",false);
	var data = {
		"action" 	                       : "save_prdn_training",
		"reason_for_certification" 	       : chk_reason_certification_id,
		"reason_for_certification_value"   : chk_reason_certification_val,
		"training_category" 	           : chk_training_category_id,
		"training_category_value" 	       : chk_training_category_val,
		"prdn_second_take_result2" 	       : prdn_second_take_result,
		"status" 			               : status,
		"username" 			               : username,
	}
	call_ajax_serialize(data,serialized_data,handler_etr,function(result){
		console.log(result);
		$('#'+mdl_prdn_new).modal('hide');
		$('#modal_system_message').modal();
		$('#container_message').attr('class','alert alert-success');
		$('#container_message').html( '<h4>'+result['msg']+'</h4>' );
		$('.btn').prop("disabled",false);
		fn_etr_reload_datatables();
		$('input, select').val('');
	});
}
/* ***************************
	ETR Production Add Functions - End
*************************** */
/* ***************************
	ETR Production Edit Functions - Start
*************************** */

var mdl_prdn_edit 		= 'modal_etr_production_edit';
var frm_prdn_edit 		= 'frm_etr_production_edit';

$('#' + tbl_etr_prdn + ' tbody').on('click', 'tr .fa-edit', function() {
	var pkid 	= $(this).attr('id');
	var row 	= $(this).closest('tr');
	var status	= row.find('td:eq(0)').text();
	
	$('#'+mdl_prdn_edit+' .fa-send-o').show();
	if(status == ' DRAFT') {
		$('#'+mdl_prdn_edit+' .fa-save').show();
	} else {
		$('#'+mdl_prdn_edit+' .fa-save').hide();
	}
	$('#'+mdl_prdn_edit+' .fa-remove').hide();
	$('input[type="text"],input[name="reason_certification"], select').prop('required', true);
	$('#'+frm_prdn_edit+' #prdn_second_take_trained_by').prop('required', false);
	$('#'+frm_prdn_edit+' #reason_certification_others').prop('required', false);
	fn_get_etr_details_by_pkid(pkid, mdl_prdn_edit, frm_prdn_edit, 'PRDN');
	$('#'+mdl_prdn_edit).data('id', pkid);
	$('#'+mdl_prdn_edit).modal();
});

$('#'+frm_prdn_edit+' .fa-plus').click(function() {
	var disabled_second_take = '';
	if($('#'+frm_prdn_edit+' #prdn_second_take_trained_by').val() === null || $('#'+frm_prdn_edit+' #prdn_second_take_trained_by').val() == '') {
		disabled_second_take = 'disabled';
	}
	
    var table_tr  = '<tr>';
        table_tr += '    <td><select class="" id="operator_name" name="operator_name[]"  style="width:100%;" required></select></td>';
        table_tr += '    <td><select class="" id="operator_en" name="operator_en[]"  style="width:100%;" required></select></td>';
        table_tr += '    <td><input type="text" class="form-control" id="station_from" name="station_from[]"  style="width:100%;" required></td>';
        table_tr += '    <td><input type="text" class="form-control" id="station_to" name="station_to[]"  style="width:100%;" required></td>';
        table_tr += '    <td>';
        table_tr += '       <select class="form-control" id="prdn_first_take_result" name="prdn_first_take_result[]"  style="width:100%;" required>';
        table_tr += '           <option value="">-</option>';
        table_tr += '           <option value="PASSED">PASSED</option>';
        table_tr += '           <option value="FAILED">FAILED</option>';
        table_tr += '       </select>';
        table_tr += '    </td>';
        table_tr += '    <td>';
        table_tr += '       <select class="form-control" id="prdn_second_take_result" name="prdn_second_take_result[]"  style="width:100%;" required '+disabled_second_take+'>';
        table_tr += '           <option value="">-</option>';
        table_tr += '           <option value="PASSED">PASSED</option>';
        table_tr += '           <option value="FAILED">FAILED</option>';
        table_tr += '       </select>';
        table_tr += '    </td>';
        table_tr += '    <td><input type="hidden" name="details_pkid[]" value="0"><a href="#" class="fa fa-remove"> Remove</a></td>';
        table_tr += '</tr>';
    
    $('#'+mdl_prdn_edit+' #tbl_operator_list tbody').append(table_tr);
    re_initialize_select2_server_side('#'+mdl_prdn_edit+' #tbl_operator_list #operator_name','#'+mdl_prdn_edit+' #'+frm_prdn_edit,[],"server_side_scripts/dropdown/common/dd_operator_list.php");
    re_initialize_select2_server_side('#'+mdl_prdn_edit+' #tbl_operator_list #operator_en','#'+mdl_prdn_edit+' #'+frm_prdn_edit,[],"server_side_scripts/dropdown/common/dd_operator_en_list.php");
});

$('#'+mdl_prdn_edit+' #tbl_operator_list tbody').on('click' , 'a', function(){
    $(this).closest('tr').remove();
    return false;
});

/* Kelangan isa lang sa kanila ung naka-enable. Event by Emp. Name or Emp. No. :) START */
$('#'+mdl_prdn_edit+' #tbl_operator_list tbody').on('change', 'tr #operator_name', function() {
    var emp_name = $(this).val();
    var row_index = $(this).closest('tr').index();
    fn_get_emp_no_by_operator_name(emp_name, mdl_prdn_edit, frm_prdn_edit+' #tbl_operator_list tbody tr:eq('+row_index+')');
});

//$('#'+mdl_prdn_edit+' #tbl_operator_list tbody').on('change', 'tr #operator_en', function() {
//    var empno = $(this).val();
//    var row_index = $(this).closest('tr').index();
//    fn_get_emp_name_by_operator_empno(empno, mdl_prdn_edit, frm_prdn_edit+ ' #tbl_operator_list tbody tr:eq('+row_index+')');
//});
/* Kelangan isa lang sa kanila ung naka-enable. Event by Emp. Name or Emp. No. :) END */

$('#'+mdl_prdn_edit+' #tbl_operator_list tbody').on('change', 'tr #prdn_first_take_result', function() {
    var first_result = $(this).val();
    var row_index = $(this).closest('tr').index();
    if(first_result == 'FAILED') {
        $('#'+frm_prdn_edit+' #tbl_operator_list tbody tr:eq('+row_index+') td:eq(5) select').prop('disabled', false);
    } else {
		$('#'+frm_prdn_edit+' #tbl_operator_list tbody tr:eq('+row_index+') td:eq(5) select').prop('disabled', true);
		$('#'+frm_prdn_edit+' #tbl_operator_list tbody tr:eq('+row_index+') td:eq(5) select').val('');
    }
	fn_prdn_check_first_take_result(mdl_prdn_edit+' #tbl_operator_list', frm_prdn_edit);
});

$('#'+mdl_prdn_edit+' .fa-save').click(function(){
    var serialized_data = $('#'+frm_prdn_edit).serialize();
    fn_edit_prdn_training(mdl_prdn_edit, frm_prdn_edit, serialized_data, 'DRAFT');
});

$('#'+frm_prdn_edit).submit(function(e){
    e.preventDefault(); 
	if($('#'+frm_prdn_edit+' #tbl_operator_list tbody tr').length == 0) {
		$('#'+frm_prdn_edit+' #container_etr_production_new_message').html('Please select operator names');
		$('#'+frm_prdn_edit+' #container_etr_production_new_message').show();
	} else {
		$('#'+frm_prdn_edit+' #container_etr_production_new_message').hide();
		var serialized_data = $(this).serialize();
		fn_edit_prdn_training(mdl_prdn_edit, frm_prdn_edit, serialized_data, 'FOR PRDN CHECKING');
	}
});

function fn_edit_prdn_training(mdl_id, frm_id, serialized_data, status) {		
	var prdn_second_take_result = new Array();
	$('#'+frm_id+' #tbl_operator_list tbody tr').each(function() {
		if($(this).find('td select').prop('disabled')) {
			prdn_second_take_result.push("");
			$(this).find('td select').prop('disabled', false);
		} else {
			prdn_second_take_result.push($(this).find('td:eq(5) select').val());
		}
	});
	
	
    var chk_reason_certification_id  = new Array();
    var chk_reason_certification_val = new Array();
    $('#'+mdl_id+' #container_reason_certification input[type="checkbox"]').each(function() {
        chk_reason_certification_id.push($(this).data('id'));
        chk_reason_certification_val.push($(this).prop('checked'));
    });
    
    var chk_training_category_id  = new Array();
    var chk_training_category_val = new Array();
    $('#'+mdl_id+' #container_training_category input[type="checkbox"]').each(function() {
        chk_training_category_id.push($(this).data('id'));
        chk_training_category_val.push($(this).prop('checked'));
    });
	$('.btn').prop("disabled",false);
	var data = {
		"action" 	                       : "edit_prdn_training",
		"reason_for_certification" 	       : chk_reason_certification_id,
		"reason_for_certification_value"   : chk_reason_certification_val,
		"training_category" 	           : chk_training_category_id,
		"training_category_value" 	       : chk_training_category_val,
		"prdn_second_take_result2" 	       : prdn_second_take_result,
		"pkid" 			               	   : $('#'+mdl_id).data('id'),
		"status" 			               : status,
		"username" 			               : username,
	}
	call_ajax_serialize(data,serialized_data,handler_etr,function(result){
		$('#'+mdl_id).modal('hide');
		$('#modal_system_message').modal();
		$('#container_message').attr('class','alert alert-success');
		$('#container_message').html( '<h4>'+result['msg']+'</h4>' );
		$('.btn').prop("disabled",false);
		fn_etr_reload_datatables();
		$('input, select').val('');
	});
}

/* ***************************
	ETR Production Edit Functions - End
*************************** */

/* ***************************
	ETR Production Cancel Functions - Start
*************************** */

$('#' + tbl_etr_prdn + ' tbody').on('click', 'tr .fa-remove', function() {
	var pkid 	= $(this).attr('id');
	var row 	= $(this).closest('tr');
	var status	= row.find('td:eq(0)').text();
	if(status.match("CANCEL")){
		$('#'+mdl_prdn_edit+' .fa-remove').hide();
	} else {
		$('#'+mdl_prdn_edit+' .fa-remove').show();
	}
	$('#'+mdl_prdn_edit+' .fa-save').hide();
	$('#'+mdl_prdn_edit+' .fa-send-o').hide();
	$('#'+frm_cancel+' input[name="status"]').val('CANCELLED BY PRODUCTION');
	fn_get_etr_details_by_pkid(pkid, mdl_prdn_edit, frm_prdn_edit, 'PRDN');
	$('#'+mdl_prdn_edit).data('id', pkid);
	$('#'+mdl_prdn_edit).modal();
});

$('#'+mdl_prdn_edit+' .fa-remove').click(function(){
	$('#'+mdl_cancel).data('id', $('#'+mdl_prdn_edit).data('id'));
    $('#'+mdl_cancel).modal();
});
/* ***************************
	ETR Production Cancel Functions - End
*************************** */

/* ***************************
	ETR Production - Approver Main Table - Start
*************************** */
var tbl_etr_production_app    	= 'tbl_etr_production_app';
var dt_etr_prdn_app 			= '';

dt_etr_prdn_app = $('#'+tbl_etr_production_app).DataTable({
	"aaSorting"	 : [],	
	"bProcessing": true,
	"bServerSide": true,
	"sAjaxSource": "server_side_scripts/etr/dt_etr_production_approver.php?un="+username,
	"drawCallback": function( settings ) {
		$('#'+tbl_etr_production_app).attr('style','width:100%;');
	}
});

var mdl_prdn_app_edit 		= 'modal_etr_production_submit';
var frm_prdn_app_edit 		= 'frm_etr_production_submit';

$('#' + tbl_etr_production_app + ' tbody').on('click', 'tr .fa-edit', function() {
	var pkid 	= $(this).attr('id');
	var row 	= $(this).closest('tr');
	var status	= row.find('td:eq(0)').text();
	
	$('#'+mdl_prdn_app_edit+' .fa-send-o').show();
	if(status == ' DRAFT') {
		$('#'+mdl_prdn_app_edit+' .fa-save').show();
	} else {
		$('#'+mdl_prdn_app_edit+' .fa-save').hide();
	}
	$('#'+mdl_prdn_app_edit+' .fa-remove').hide();
	$('input[type="text"],input[name="reason_certification"], select').prop('required', true);
	$('#'+frm_prdn_app_edit+' #prdn_second_take_trained_by').prop('required', false);
	$('#'+frm_prdn_app_edit+' #reason_certification_others').prop('required', false);
	fn_get_etr_details_by_pkid(pkid, mdl_prdn_app_edit, frm_prdn_app_edit, 'PRDN');
	$('#'+mdl_prdn_app_edit).data('id', pkid);
	$('#'+mdl_prdn_app_edit).modal();
});

$('#'+frm_prdn_app_edit+' .fa-plus').click(function() {
	var disabled_second_take = '';
	if($('#'+frm_prdn_app_edit+' #prdn_second_take_trained_by').val() === null || $('#'+frm_prdn_app_edit+' #prdn_second_take_trained_by').val() == '') {
		disabled_second_take = 'disabled';
	}
	
    var table_tr  = '<tr>';
        table_tr += '    <td><select class="" id="operator_name" name="operator_name[]"  style="width:100%;" required></select></td>';
        table_tr += '    <td><select class="" id="operator_en" name="operator_en[]"  style="width:100%;" required></select></td>';
        table_tr += '    <td><input type="text" class="form-control" id="station_from" name="station_from[]"  style="width:100%;" required></td>';
        table_tr += '    <td><input type="text" class="form-control" id="station_to" name="station_to[]"  style="width:100%;" required></td>';
        table_tr += '    <td>';
        table_tr += '       <select class="form-control" id="prdn_first_take_result" name="prdn_first_take_result[]"  style="width:100%;" required>';
        table_tr += '           <option value="">-</option>';
        table_tr += '           <option value="PASSED">PASSED</option>';
        table_tr += '           <option value="FAILED">FAILED</option>';
        table_tr += '       </select>';
        table_tr += '    </td>';
        table_tr += '    <td>';
        table_tr += '       <select class="form-control" id="prdn_second_take_result" name="prdn_second_take_result[]"  style="width:100%;" required '+disabled_second_take+'>';
        table_tr += '           <option value="">-</option>';
        table_tr += '           <option value="PASSED">PASSED</option>';
        table_tr += '           <option value="FAILED">FAILED</option>';
        table_tr += '       </select>';
        table_tr += '    </td>';
        table_tr += '    <td><input type="hidden" name="details_pkid[]" value="0"><a href="#" class="fa fa-remove"> Remove</a></td>';
        table_tr += '</tr>';
    
    $('#'+mdl_prdn_app_edit+' #tbl_operator_list tbody').append(table_tr);
    re_initialize_select2_server_side('#'+mdl_prdn_app_edit+' #tbl_operator_list #operator_name','#'+mdl_prdn_app_edit+' #'+frm_prdn_app_edit,[],"server_side_scripts/dropdown/common/dd_operator_list.php");
    re_initialize_select2_server_side('#'+mdl_prdn_app_edit+' #tbl_operator_list #operator_en','#'+mdl_prdn_app_edit+' #'+frm_prdn_app_edit,[],"server_side_scripts/dropdown/common/dd_operator_en_list.php");
});

$('#'+mdl_prdn_app_edit+' #tbl_operator_list tbody').on('click' , 'a', function(){
    $(this).closest('tr').remove();
    return false;
});

$('#'+mdl_prdn_app_edit+' #tbl_operator_list tbody').on('change', 'tr #operator_name', function() {
    var emp_name = $(this).val();
    var row_index = $(this).closest('tr').index();
    fn_get_emp_no_by_operator_name(emp_name, mdl_prdn_app_edit, frm_prdn_app_edit+' #tbl_operator_list tbody tr:eq('+row_index+')');
});

$('#'+mdl_prdn_app_edit+' #tbl_operator_list tbody').on('change', 'tr #prdn_first_take_result', function() {
    var first_result = $(this).val();
    var row_index = $(this).closest('tr').index();
    if(first_result == 'FAILED') {
        $('#'+frm_prdn_app_edit+' #tbl_operator_list tbody tr:eq('+row_index+') td:eq(5) select').prop('disabled', false);
    } else {
		$('#'+frm_prdn_app_edit+' #tbl_operator_list tbody tr:eq('+row_index+') td:eq(5) select').prop('disabled', true);
		$('#'+frm_prdn_app_edit+' #tbl_operator_list tbody tr:eq('+row_index+') td:eq(5) select').val('');
    }
	fn_prdn_check_first_take_result(mdl_prdn_app_edit+' #tbl_operator_list', frm_prdn_app_edit);
});

$('#'+frm_prdn_app_edit).submit(function(e){
    e.preventDefault(); 
	if($('#'+frm_prdn_app_edit+' #tbl_operator_list tbody tr').length == 0) {
		$('#'+frm_prdn_app_edit+' #container_etr_production_new_message').html('Please select operator names');
		$('#'+frm_prdn_app_edit+' #container_etr_production_new_message').show();
	} else {
		$('#'+frm_prdn_app_edit+' #container_etr_production_new_message').hide();
		var serialized_data = $(this).serialize();
		fn_edit_prdn_training(mdl_prdn_app_edit, frm_prdn_app_edit, serialized_data, 'FOR ENGR. QUALIFICATION');
	}
});

/* ***************************
	ETR Production Main Table - End
*************************** */

/* ***************************
	ETR Production Main Table - View - Start
*************************** */

var mdl_prdn_view 		= 'modal_etr_production_view';
var frm_prdn_view 		= 'frm_etr_production_view';
var mdl_app_conf		= 'modal_etr_approver_message';
var frm_app_conf		= 'frm_etr_approvers_decision';

$('#' + tbl_etr_production_app + ' tbody').on('click', 'tr .fa-eye', function() {
	var pkid 	= $(this).attr('id');
	var row 	= $(this).closest('tr');
	var status	= row.find('td:eq(0)').text();
	fn_get_etr_details_by_pkid(pkid, mdl_prdn_view, frm_prdn_view, 'PRDN');
	if(status == ' PENDING') {
		$('#'+mdl_prdn_view+' .approver').show();		
	} else {
		$('#'+mdl_prdn_view+' .approver').hide();
	}
	$('#'+mdl_prdn_view).data('id', pkid);
	$('#'+mdl_prdn_view).modal();
});

$('#'+mdl_prdn_view+' .fa-thumbs-up').click(function() {
	$('#'+mdl_app_conf).data('id', $('#'+mdl_prdn_view).data('id'));
	$('#'+mdl_app_conf).data('status', 'FOR ENGR. QUALIFICATION');
	$('#'+mdl_app_conf).data('app_status', 'APPROVED');
	$('#'+mdl_app_conf).data('checked_by_field', 'prdn_checked_by');
	$('#'+mdl_app_conf).data('checked_by_logs_field', 'prdn_checked_by_logs');
	$('#'+mdl_app_conf+' #container_approver_message').attr('class','alert alert-success');
	$('#'+mdl_app_conf+' #container_approver_message').html('Are you sure you want to approve the request?<br><br>Remarks:<textarea name="remarks" style="width:100%;" rows="4"></textarea>');
	$('#'+mdl_app_conf+' #container_approver_message').show();
	$('#'+mdl_app_conf).modal();
});

$('#'+mdl_prdn_view+' .fa-thumbs-down').click(function() {
	$('#'+mdl_app_conf).data('id', $('#'+mdl_prdn_view).data('id'));
	$('#'+mdl_app_conf).data('status', 'DISAPPROVED PRODUCTION');
	$('#'+mdl_app_conf).data('app_status', 'DISAPPROVED');
	$('#'+mdl_app_conf).data('checked_by_field', 'prdn_checked_by');
	$('#'+mdl_app_conf).data('checked_by_logs_field', 'prdn_checked_by_logs');
	$('#'+mdl_app_conf+' #container_approver_message').attr('class','alert alert-success');
	$('#'+mdl_app_conf+' #container_approver_message').html('Are you sure you want to approve the request?<br><br>Remarks:<textarea name="remarks" style="width:100%;" rows="4" required></textarea>');
	$('#'+mdl_app_conf+' #container_approver_message').show();
	$('#'+mdl_app_conf).modal();
});

$('#' + tbl_etr_prdn + ' tbody').on('click', 'tr .fa-eye', function() {
	var pkid 	= $(this).attr('id');
	var row 	= $(this).closest('tr');
	var status	= row.find('td:eq(0)').text();
	fn_get_etr_details_by_pkid(pkid, mdl_prdn_view, frm_prdn_view, 'PRDN');
	
	$('#'+mdl_prdn_view).data('id', pkid);
	$('#'+mdl_prdn_view+' .approver').hide();
	$('#'+mdl_prdn_view).modal();
});

$('#'+mdl_prdn_view+' .fa-eye').click(function() {
	var pkid = $('#'+mdl_prdn_view).data('id');
	fn_return_operator_lists(pkid);
});

/* Production, Engineering and QC Approvers function start*/
$('#'+frm_app_conf).submit(function(e) {
	e.preventDefault();
	fn_prdn_engr_approval();
});

function fn_prdn_engr_approval() {
	var data = {
		"action"				: "update_prdn_eng_approval_logs",
		"pkid"					: $('#'+mdl_app_conf).data('id'),
		"status"				: $('#'+mdl_app_conf).data('status'),
		"remarks"				: $('#'+mdl_app_conf+' textarea[name="remarks"]').val(),
		"checked_by_logs_field"	: $('#'+mdl_app_conf).data('checked_by_logs_field'),
		"app_status"			: $('#'+mdl_app_conf).data('app_status'),
		"username"				: username,
	}
	call_ajax(data, handler_etr, function(result){			
		fn_etr_reload_datatables();
		$('.modal').modal('hide');
	});
}

/* Production, Engineering and QC Approvers function end*/

function fn_get_etr_details_by_pkid(pkid, mdl_id, frm_id, user) {
	var data = {
		"action"	: "get_etr_details_by_pkid",
		"pkid"		: pkid,
		"user"		: user,
	}
	call_ajax(data, handler_etr, function(result){	
		$.each(result['data'][0],function(key, value){
			$('#'+frm_id+' input[name="'+key+'"]').val(value);
			$('#'+frm_id+' button[name="'+key+'"]').val(value);
			$('#'+frm_id+' select[name="'+key+'"]').val(value);
			$('#'+frm_id+' textarea[name="'+key+'"]').val(value);
			
			if(key == 'prdn_first_take_trained_by') {
				assign_value_select2('#'+frm_id+' #prdn_first_take_trained_by',result['data'][0]['prdn_first_take_trained_by']);				
				re_initialize_select2_server_side('#'+mdl_id+' #prdn_first_take_trained_by','#'+mdl_id+' #'+frm_id,[],"server_side_scripts/dropdown/common/dd_hris_all_list.php");
			} 
			if(key == 'prdn_checked_by') {
				assign_value_select2('#'+frm_id+' #prdn_checked_by',result['data'][0]['prdn_checked_by']);	
				re_initialize_select2_server_side('#'+mdl_id+' #prdn_checked_by','#'+mdl_id+' #'+frm_id,[],"server_side_scripts/dropdown/common/dd_hris_all_list.php");
			} 
			if(key == 'prdn_second_take_trained_by') {				
				if(result['data'][0]['prdn_second_take_trained_by'][0]['id'] == '') {
					$('#'+frm_id+' #div_prdn_second_take').hide();
				} else {
					$('#'+frm_id+' #div_prdn_second_take').show();
					assign_value_select2('#'+frm_id+' #prdn_second_take_trained_by',result['data'][0]['prdn_second_take_trained_by']);
					re_initialize_select2_server_side('#'+mdl_id+' #prdn_second_take_trained_by','#'+mdl_id+' #'+frm_id,[],"server_side_scripts/dropdown/common/dd_hris_all_list.php");	
				}
			} 
			if(key == 'eng_first_take_qualified_by') {
				assign_value_select2('#'+frm_id+' #eng_first_take_qualified_by',result['data'][0]['eng_first_take_qualified_by']);				
				re_initialize_select2_server_side('#'+mdl_id+' #eng_first_take_qualified_by','#'+mdl_id+' #'+frm_id,[],"server_side_scripts/dropdown/etr/dd_etr_engr_list.php");
			} 
			if(key == 'reason_certification_others') {
				if(value == '') {
					$('#'+frm_id+' #reason_certification_others').prop('required', false);
				} else {
					$('#'+frm_id+' #reason_certification_others').prop('required', true);
				}
			} 
			if(key == 'eng_second_take_qualified_by') {
				if(result['data'][0]['eng_second_take_qualified_by'][0]['id'] == '') {
					$('#'+frm_id+' #div_engr_second_take').hide();
				} else {
					$('#'+frm_id+' #div_engr_second_take').show();
					assign_value_select2('#'+frm_id+' #eng_second_take_qualified_by',result['data'][0]['eng_second_take_qualified_by']);
					re_initialize_select2_server_side('#'+mdl_id+' #eng_second_take_qualified_by','#'+mdl_id+' #'+frm_id,[],"server_side_scripts/dropdown/common/dd_hris_all_list.php");
				}										
			} 
			if(key == 'engr_checked_by') {
				assign_value_select2('#'+frm_id+' #engr_checked_by',result['data'][0]['engr_checked_by']);	
				re_initialize_select2_server_side('#'+mdl_id+' #engr_checked_by','#'+mdl_id+' #'+frm_id,[],"server_side_scripts/dropdown/common/dd_hris_all_list.php");
			} 
			if(key == 'qc_first_take_certified_by') {
				assign_value_select2('#'+frm_id+' #qc_first_take_certified_by',result['data'][0]['qc_first_take_certified_by']);		
				re_initialize_select2_server_side('#'+mdl_id+' #qc_first_take_certified_by','#'+mdl_id+' #'+frm_id,[],"server_side_scripts/dropdown/etr/dd_etr_qc_list.php");				
			} 
			if(key == 'qc_checked_by') {
				assign_value_select2('#'+frm_id+' #qc_checked_by',result['data'][0]['qc_checked_by']);		
				re_initialize_select2_server_side('#'+mdl_id+' #qc_checked_by','#'+mdl_id+' #'+frm_id,[],"server_side_scripts/dropdown/etr/dd_etr_qc_list.php");				
			} 
			if(key == 'qc_second_take_certified_by') {
				if(result['data'][0]['qc_second_take_certified_by'][0]['id'] == '') {
					$('#'+frm_id+' #div_qc_second_take').hide();
				} else {
					$('#'+frm_id+' #div_qc_second_take').show();
					assign_value_select2('#'+frm_id+' #qc_second_take_certified_by',result['data'][0]['qc_second_take_certified_by']);
					re_initialize_select2_server_side('#'+mdl_id+' #qc_second_take_certified_by','#'+mdl_id+' #'+frm_id,[],"server_side_scripts/dropdown/common/dd_hris_all_list.php");
				}										
			} 
					
			// re_initialize_select2_server_side('#'+mdl_id+' #eng_second_take_qualified_by','#'+mdl_id,[],"server_side_scripts/dropdown/common/dd_hris_all_list.php");
		});
		
		if(result['data_1'] == 'HAVE DATA') {
			var table_array = new Array();
				table_array = result['data'][1];
			var	table_tr	= '';
			
			if(user == 'PRDN') {
				$('#' + frm_id + ' #tbl_operator_list tbody').empty();
				for(var i=0; i<(table_array).length; i++) {			
					table_tr  = '<tr>';
					table_tr += '    <td><select class="" id="operator_name" name="operator_name[]"  style="width:100%;" required></select></td>';
					table_tr += '    <td><select class="" id="operator_en" name="operator_en[]"  style="width:100%;" required></select></td>';
					table_tr += '    <td><input type="text" class="form-control" id="station_from" name="station_from[]"  style="width:100%;" required></td>';
					table_tr += '    <td><input type="text" class="form-control" id="station_to" name="station_to[]"  style="width:100%;" required></td>';
					table_tr += '    <td>';
					table_tr += '       <select class="form-control" id="prdn_first_take_result" name="prdn_first_take_result[]"  style="width:100%;" required>';
					table_tr += '           <option value="">-</option>';
					table_tr += '           <option value="PASSED">PASSED</option>';
					table_tr += '           <option value="FAILED">FAILED</option>';
					table_tr += '       </select>';
					table_tr += '    </td>';
					table_tr += '    <td>';
					table_tr += '       <select class="form-control" id="prdn_second_take_result" name="prdn_second_take_result[]"  style="width:100%;">';
					table_tr += '           <option value="">-</option>';
					table_tr += '           <option value="PASSED">PASSED</option>';
					table_tr += '           <option value="FAILED">FAILED</option>';
					table_tr += '       </select>';
					table_tr += '    </td>';
					table_tr += '    <td><input type="hidden" id="details_pkid" name="details_pkid[]"><a href="#" class="fa fa-remove"> Remove</a></td>';
					table_tr += '</tr>';
					$('#' + frm_id + ' #tbl_operator_list tbody').append(table_tr);
					
					//set table value
					$.each(table_array[i],function(key, value){		
						$('#'+frm_id+' #tbl_operator_list tbody tr:eq('+i+') select[id="'+key+'"]').val(value);		
						$('#'+frm_id+' #tbl_operator_list tbody tr:eq('+i+') input[id="'+key+'"]').val(value);		
						
						if(key == 'pkid') {
							$('#'+frm_id+' #tbl_operator_list tbody tr:eq('+i+') #details_pkid').val(value);		
						}
						if(key == 'operators_name') {
							assign_value_select2('#'+frm_id+' #tbl_operator_list tbody tr:eq('+i+') #operator_name',table_array[i][key]);		
							re_initialize_select2_server_side('#'+mdl_id+' #tbl_operator_list tbody tr:eq('+i+') #operator_name','#'+mdl_id+' #'+frm_id,[],"server_side_scripts/dropdown/common/dd_operator_list.php");
						}
						if(key == 'employee_no') {
							assign_value_select2('#'+frm_id+' #tbl_operator_list tbody tr:eq('+i+') #operator_en',table_array[i][key]);		
							re_initialize_select2_server_side('#'+mdl_id+' #tbl_operator_list tbody tr:eq('+i+') #operator_en','#'+mdl_id+' #'+frm_id,[],"server_side_scripts/dropdown/common/dd_operator_list.php");
						}
						if(key == 'prdn_second_take_result') {
							if(value == '') {
								$('#'+frm_id+' #tbl_operator_list tbody tr:eq('+i+') #prdn_second_take_result').prop('disabled', true);
							} else {
								$('#'+frm_id+' #tbl_operator_list tbody tr:eq('+i+') #prdn_second_take_result').prop('disabled', false);
								re_initialize_select2_server_side('#'+mdl_id+' #prdn_second_take_trained_by','#'+mdl_id+' #'+frm_id,[],"server_side_scripts/dropdown/common/dd_hris_all_list.php");
							}			
						}
					});
					fn_prdn_check_first_take_result(mdl_id+' #tbl_operator_list', frm_id);
				}	
			} else if(user == 'ENGR') {
				$('#' + frm_id + ' #tbl_operator_list tbody').empty();
				for(var i=0; i<(table_array).length; i++) {			
					table_tr  = '<tr>';
					table_tr += '    <td><select class="" id="operator_name" name="operator_name[]" style="width:100%;" required readonly></select></td>';
					table_tr += '    <td><select class="" id="operator_en" name="operator_en[]"  style="width:100%;" required readonly></select></td>';
					table_tr += '    <td>';
					table_tr += '       <select class="form-control" id="eng_first_take_observation_interview" name="eng_first_take_observation_interview[]"  style="width:100%;" required>';
					table_tr += '           <option value="">-</option>';
					table_tr += '           <option value="PASSED">PASSED</option>';
					table_tr += '           <option value="FAILED">FAILED</option>';
					table_tr += '       </select>';
					table_tr += '    </td>';
					table_tr += '    <td>';
					table_tr += '       <select class="form-control" id="eng_second_take_observation_interview" name="eng_second_take_observation_interview[]"  style="width:100%;">';
					table_tr += '           <option value="">-</option>';
					table_tr += '           <option value="PASSED">PASSED</option>';
					table_tr += '           <option value="FAILED">FAILED</option>';
					table_tr += '       </select>';
					table_tr += '    </td>';
					table_tr += '    <td>';
					table_tr += '    	<input type="number" style="width:100%" id="eng_first_take_sample_checking_ok" name="eng_first_take_sample_checking_ok[]" min="0" required>';
					table_tr += '    </td>';
					table_tr += '    <td>';
					table_tr += '    	<input type="number" style="width:100%" id="eng_first_take_sample_checking_ng" name="eng_first_take_sample_checking_ng[]" min="0" required>';
					table_tr += '    </td>';
					table_tr += '    <td>';
					table_tr += '    	<input type="number" style="width:100%" id="eng_second_take_sample_checking_ok" name="eng_second_take_sample_checking_ok[]" min="0">';
					table_tr += '    </td>';
					table_tr += '    <td>';
					table_tr += '    	<input type="number" style="width:100%" id="eng_second_take_sample_checking_ng" name="eng_second_take_sample_checking_ng[]" min="0">';
					table_tr += '    </td>';
					table_tr += '    <td>';
					table_tr += '       <select class="form-control" id="eng_first_take_overall_assessment" name="eng_first_take_overall_assessment[]"  style="width:100%;" required>';
					table_tr += '           <option value="">-</option>';
					table_tr += '           <option value="PASSED">PASSED</option>';
					table_tr += '           <option value="FAILED">FAILED</option>';
					table_tr += '       </select>';
					table_tr += '    </td>';
					table_tr += '    <td>';
					table_tr += '       <select class="form-control" id="eng_second_take_overall_assessment" name="eng_second_take_overall_assessment[]"  style="width:100%;">';
					table_tr += '           <option value="">-</option>';
					table_tr += '           <option value="PASSED">PASSED</option>';
					table_tr += '           <option value="FAILED">FAILED</option>';
					table_tr += '       </select>';
					table_tr += '       <input type="hidden" id="details_pkid" name="details_pkid[]">';
					table_tr += '    </td>';
					table_tr += '    <td>';
					table_tr += '    	<textarea class="form-control" id="eng_reason_for_disqualification" name="eng_reason_for_disqualification[]"  style="width:100%;"></textarea>';
					table_tr += '    </td>';
					table_tr += '</tr>';
					$('#' + frm_id + ' #tbl_operator_list tbody').append(table_tr);
					
					//set table value
					$.each(table_array[i],function(key, value){		
						$('#'+frm_id+' #tbl_operator_list tbody tr:eq('+i+') input[id="'+key+'"]').val(value);			
						$('#'+frm_id+' #tbl_operator_list tbody tr:eq('+i+') select[id="'+key+'"]').val(value);				
						$('#'+frm_id+' #tbl_operator_list tbody tr:eq('+i+') textarea[id="'+key+'"]').val(value);		
						
						if(key == 'pkid') {
							$('#'+frm_id+' #tbl_operator_list tbody tr:eq('+i+') #details_pkid').val(value);		
						}
						if(key == 'operators_name') {
							assign_value_select2('#'+frm_id+' #tbl_operator_list tbody tr:eq('+i+') #operator_name',table_array[i][key]);		
							// re_initialize_select2_server_side('#'+mdl_id+' #tbl_operator_list tbody tr:eq('+i+') #operator_name','#'+mdl_id+' #'+frm_id,[],"server_side_scripts/dropdown/common/dd_operator_list.php");
						}
						if(key == 'employee_no') {
							assign_value_select2('#'+frm_id+' #tbl_operator_list tbody tr:eq('+i+') #operator_en',table_array[i][key]);		
							// re_initialize_select2_server_side('#'+mdl_id+' #tbl_operator_list tbody tr:eq('+i+') #operator_en','#'+mdl_id+' #'+frm_id,[],"server_side_scripts/dropdown/common/dd_operator_list.php");
						}
						if(key == 'eng_first_take_observation_interview') {
							if(value == 'FAILED') {
								$('#'+frm_id+' #tbl_operator_list tbody tr:eq('+i+') td:eq(3) select').prop('disabled', false);
								$('#'+frm_id+' #tbl_operator_list tbody tr:eq('+i+') td:eq(9) select').prop('disabled', false);
								$('#'+frm_id+' #tbl_operator_list tbody tr:eq('+i+') td:eq(6) input').prop('disabled', false);
								$('#'+frm_id+' #tbl_operator_list tbody tr:eq('+i+') td:eq(7) input').prop('disabled', false);
								$('#'+frm_id+' #tbl_operator_list tbody tr:eq('+i+') td:eq(6) input').prop('required', true);
								$('#'+frm_id+' #tbl_operator_list tbody tr:eq('+i+') td:eq(7) input').prop('required', true);
							} else {
								$('#'+frm_id+' #tbl_operator_list tbody tr:eq('+i+') td:eq(3) select').prop('disabled', true);
								$('#'+frm_id+' #tbl_operator_list tbody tr:eq('+i+') td:eq(3) select').val('');
								$('#'+frm_id+' #tbl_operator_list tbody tr:eq('+i+') td:eq(8) select').val('');
								$('#'+frm_id+' #tbl_operator_list tbody tr:eq('+i+') td:eq(9) select').prop('disabled', true);
								$('#'+frm_id+' #tbl_operator_list tbody tr:eq('+i+') td:eq(9) select').val('');
								$('#'+frm_id+' #tbl_operator_list tbody tr:eq('+i+') td:eq(6) input').prop('disabled', true);
								$('#'+frm_id+' #tbl_operator_list tbody tr:eq('+i+') td:eq(7) input').prop('disabled', true);
								$('#'+frm_id+' #tbl_operator_list tbody tr:eq('+i+') td:eq(6) input').prop('required', false);
								$('#'+frm_id+' #tbl_operator_list tbody tr:eq('+i+') td:eq(7) input').prop('required', false);
							}
						}
						if(key == 'eng_second_take_observation_interview') {
							if(value == '') {
								$('#'+frm_id+' #tbl_operator_list tbody tr:eq('+i+') #eng_second_take_observation_interview').prop('disabled', true);
							} else {
								$('#'+frm_id+' #tbl_operator_list tbody tr:eq('+i+') #eng_second_take_observation_interview').prop('disabled', false);
							}
						}
						if(key == 'eng_second_take_overall_assessment') {
							if(value == '') {
								$('#'+frm_id+' #tbl_operator_list tbody tr:eq('+i+') #eng_second_take_overall_assessment').prop('disabled', true);
							} else {
								$('#'+frm_id+' #tbl_operator_list tbody tr:eq('+i+') #eng_second_take_overall_assessment').prop('disabled', false);
							}
						}
					});
				}	
				fn_return_check_items_by_fketr(pkid, mdl_id, frm_id);
				dn_engr_check_first_take_result(mdl_id+' #tbl_operator_list', frm_id);
			} else if(user == 'QC') {
				$('#' + frm_id + ' #tbl_operator_list tbody').empty();
				for(var i=0; i<(table_array).length; i++) {			
					table_tr  = '<tr>';
					table_tr += '    <td><select class="" id="operator_name" name="operator_name[]" style="width:100%;" required readonly></select></td>';
					table_tr += '    <td><select class="" id="operator_en" name="operator_en[]"  style="width:100%;" required readonly></select></td>';
					table_tr += '    <td>';
					table_tr += '       <select class="form-control" id="qc_first_take_observation_interview_result" name="qc_first_take_observation_interview_result[]"  style="width:100%;" required>';
					table_tr += '           <option value="">-</option>';
					table_tr += '           <option value="PASSED">PASSED</option>';
					table_tr += '           <option value="FAILED">FAILED</option>';
					table_tr += '       </select>';
					table_tr += '    </td>';
					table_tr += '    <td>';
					table_tr += '       <select class="form-control" id="qc_second_take_observation_interview_result" name="qc_second_take_observation_interview_result[]"  style="width:100%;">';
					table_tr += '           <option value="">-</option>';
					table_tr += '           <option value="PASSED">PASSED</option>';
					table_tr += '           <option value="FAILED">FAILED</option>';
					table_tr += '       </select>';
					table_tr += '    </td>';
					table_tr += '    <td>';
					table_tr += '    	<input type="number" style="width:100%" id="qc_first_take_sample_checking_ok" name="qc_first_take_sample_checking_ok[]" min="0" required>';
					table_tr += '    </td>';
					table_tr += '    <td>';
					table_tr += '    	<input type="number" style="width:100%" id="qc_first_take_sample_checking_ng" name="qc_first_take_sample_checking_ng[]" min="0" required>';
					table_tr += '    </td>';
					table_tr += '    <td>';
					table_tr += '    	<input type="number" style="width:100%" id="qc_second_take_sample_checking_ok" name="qc_second_take_sample_checking_ok[]" min="0">';
					table_tr += '    </td>';
					table_tr += '    <td>';
					table_tr += '    	<input type="number" style="width:100%" id="qc_second_take_sample_checking_ng" name="qc_second_take_sample_checking_ng[]" min="0">';
					table_tr += '    </td>';
					table_tr += '    <td>';
					table_tr += '       <select class="form-control" id="qc_first_take_overall_assessment" name="qc_first_take_overall_assessment[]"  style="width:100%;" required>';
					table_tr += '           <option value="">-</option>';
					table_tr += '           <option value="PASSED">PASSED</option>';
					table_tr += '           <option value="FAILED">FAILED</option>';
					table_tr += '       </select>';
					table_tr += '    </td>';
					table_tr += '    <td>';
					table_tr += '       <select class="form-control" id="qc_second_take_overall_assessment" name="qc_second_take_overall_assessment[]"  style="width:100%;">';
					table_tr += '           <option value="">-</option>';
					table_tr += '           <option value="PASSED">PASSED</option>';
					table_tr += '           <option value="FAILED">FAILED</option>';
					table_tr += '       </select>';
					table_tr += '       <input type="hidden" id="details_pkid" name="details_pkid[]">';
					table_tr += '    </td>';
					table_tr += '    <td>';
					table_tr += '    	<textarea class="form-control" id="qc_reason_for_disqualification" name="qc_reason_for_disqualification[]"  style="width:100%;"></textarea>';
					table_tr += '    </td>';
					table_tr += '</tr>';
					$('#' + frm_id + ' #tbl_operator_list tbody').append(table_tr);
					
					//set table value
					$.each(table_array[i],function(key, value){		
						$('#'+frm_id+' #tbl_operator_list tbody tr:eq('+i+') input[id="'+key+'"]').val(value);			
						$('#'+frm_id+' #tbl_operator_list tbody tr:eq('+i+') select[id="'+key+'"]').val(value);				
						$('#'+frm_id+' #tbl_operator_list tbody tr:eq('+i+') textarea[id="'+key+'"]').val(value);		
						
						if(key == 'pkid') {
							$('#'+frm_id+' #tbl_operator_list tbody tr:eq('+i+') #details_pkid').val(value);		
						}
						if(key == 'operators_name') {
							assign_value_select2('#'+frm_id+' #tbl_operator_list tbody tr:eq('+i+') #operator_name',table_array[i][key]);		
							// re_initialize_select2_server_side('#'+mdl_id+' #tbl_operator_list tbody tr:eq('+i+') #operator_name','#'+mdl_id+' #'+frm_id,[],"server_side_scripts/dropdown/common/dd_operator_list.php");
						}
						if(key == 'employee_no') {
							assign_value_select2('#'+frm_id+' #tbl_operator_list tbody tr:eq('+i+') #operator_en',table_array[i][key]);		
							// re_initialize_select2_server_side('#'+mdl_id+' #tbl_operator_list tbody tr:eq('+i+') #operator_en','#'+mdl_id+' #'+frm_id,[],"server_side_scripts/dropdown/common/dd_operator_list.php");
						}
						if(key == 'qc_first_take_observation_interview_result') {
							if(value == 'FAILED') {
								$('#'+frm_id+' #tbl_operator_list tbody tr:eq('+i+') td:eq(3) select').prop('disabled', false);
								$('#'+frm_id+' #tbl_operator_list tbody tr:eq('+i+') td:eq(9) select').prop('disabled', false);
								$('#'+frm_id+' #tbl_operator_list tbody tr:eq('+i+') td:eq(6) input').prop('disabled', false);
								$('#'+frm_id+' #tbl_operator_list tbody tr:eq('+i+') td:eq(7) input').prop('disabled', false);
								$('#'+frm_id+' #tbl_operator_list tbody tr:eq('+i+') td:eq(6) input').prop('required', true);
								$('#'+frm_id+' #tbl_operator_list tbody tr:eq('+i+') td:eq(7) input').prop('required', true);
							} else {
								$('#'+frm_id+' #tbl_operator_list tbody tr:eq('+i+') td:eq(3) select').prop('disabled', true);
								$('#'+frm_id+' #tbl_operator_list tbody tr:eq('+i+') td:eq(3) select').val('');
								$('#'+frm_id+' #tbl_operator_list tbody tr:eq('+i+') td:eq(8) select').val('');
								$('#'+frm_id+' #tbl_operator_list tbody tr:eq('+i+') td:eq(9) select').prop('disabled', true);
								$('#'+frm_id+' #tbl_operator_list tbody tr:eq('+i+') td:eq(9) select').val('');
								$('#'+frm_id+' #tbl_operator_list tbody tr:eq('+i+') td:eq(6) input').prop('disabled', true);
								$('#'+frm_id+' #tbl_operator_list tbody tr:eq('+i+') td:eq(7) input').prop('disabled', true);
								$('#'+frm_id+' #tbl_operator_list tbody tr:eq('+i+') td:eq(6) input').prop('required', false);
								$('#'+frm_id+' #tbl_operator_list tbody tr:eq('+i+') td:eq(7) input').prop('required', false);
							}
						}
						if(key == 'qc_second_take_observation_interview_result') {
							if(value == '') {
								$('#'+frm_id+' #tbl_operator_list tbody tr:eq('+i+') #qc_second_take_observation_interview_result').prop('disabled', true);
							} else {
								$('#'+frm_id+' #tbl_operator_list tbody tr:eq('+i+') #qc_second_take_observation_interview_result').prop('disabled', false);
							}
						}
						if(key == 'qc_second_take_overall_assessment') {
							if(value == '') {
								$('#'+frm_id+' #tbl_operator_list tbody tr:eq('+i+') #qc_second_take_overall_assessment').prop('disabled', true);
								$('#'+frm_id+' #tbl_operator_list tbody tr:eq('+i+') #qc_reason_for_disqualification').prop('required', false);
								$('#'+frm_id+' #tbl_operator_list tbody tr:eq('+i+') #qc_first_take_overall_assessment').prop('disabled', false);
							} else {								
								if(value == 'FAILED') {
									$('#'+frm_id+' #tbl_operator_list tbody tr:eq('+i+') #qc_reason_for_disqualification').prop('required', true);
									$('#'+frm_id+' #tbl_operator_list tbody tr:eq('+i+') #qc_first_take_overall_assessment').prop('disabled', true);
									$('#'+frm_id+' #tbl_operator_list tbody tr:eq('+i+') #qc_second_take_overall_assessment').prop('disabled', true);
								} else {
									$('#'+frm_id+' #tbl_operator_list tbody tr:eq('+i+') #qc_reason_for_disqualification').prop('required', false);
									$('#'+frm_id+' #tbl_operator_list tbody tr:eq('+i+') #qc_first_take_overall_assessment').prop('disabled', false);
									$('#'+frm_id+' #tbl_operator_list tbody tr:eq('+i+') #qc_second_take_overall_assessment').prop('disabled', false);
								}
							}
						}
					});
					dn_qc_check_first_take_result(mdl_id+' #tbl_operator_list', frm_id);
				}	
			} else if(user == 'TH') {
				$('#' + frm_id + ' #tbl_operator_list tbody').empty();
				$('#' + frm_id + ' #tbl_operator_list tbody').append(result['tbl_body']);
			}
		}
		
		/* Return the checkboxes :) */
		fn_return_reason_certification_by_fketr(pkid, mdl_id, frm_id);
		fn_return_training_category_by_fketr(pkid, mdl_id, frm_id);
	});
	
}

function fn_return_reason_certification_by_fketr(fk_etr, mdl_id, frm_id) {
	$('#'+mdl_id+' #container_reason_certification').empty();
	$('#'+mdl_id+' #container_reason_certification').show();
	var data = {
		"action"	: "return_reason_certification_by_fketr",
		"fk_etr"	: fk_etr,
	}
	call_ajax(data, handler_etr, function(result){	
		if(result['html_chkbox'] === "") {
			fn_return_reason_certification_lists(frm_id+' #container_reason_certification');
			fn_return_training_category_lists(frm_id+' #container_training_category');
		} else {
			$('#'+mdl_id+' #container_reason_certification').append(result['html_chkbox']);
			
			if(result['others_value'] != '') {
				$('#'+frm_id+' #container_reason_certification_others').show();
			} else {
				$('#'+frm_id+' #container_reason_certification_others').hide();
			}
			$('#'+frm_id+' input[type="checkbox"]').click(function() {
			   if(($(this).is(':checked')) && $(this).val() == 5) {
					$('#'+mdl_prdn_new+' #container_reason_certification_others').show();
				} else if((!$(this).is(':checked')) && $(this).val() == 5) {
					$('#'+mdl_prdn_new+' #container_reason_certification_others').hide();
				}
			});
		}		
	});
}

function fn_return_training_category_by_fketr(fk_etr, mdl_id, frm_id) {
	$('#'+mdl_id+' #container_training_category').empty();
	$('#'+mdl_id+' #container_training_category').show();
	var data = {
		"action"	: "return_training_category_by_fketr",
		"fk_etr"	: fk_etr,
	}
	call_ajax(data, handler_etr, function(result){			
		$('#'+mdl_id+' #container_training_category').append(result['html_chkbox']);
	});
}

function fn_return_check_items_by_fketr(fk_etr, mdl_id, frm_id) {
	$('#'+mdl_id+' #container_check_items').empty();
	$('#'+mdl_id+' #container_check_items').show();	
	
	var data = {
		"action"	: "return_check_items_by_fketr",
		"fk_etr"	: fk_etr,
	}
	call_ajax(data, handler_etr, function(result){		
		$('#'+mdl_id+' #container_check_items').append(result['html_chkbox']);
	});
}


/* ***************************
	ETR Production Main Table - End
*************************** */


/* ***************************
	ETR Engineering Main Table - Start
*************************** */
var tbl_etr_engr    	= 'tbl_etr_engineering';
var dt_etr_engr 		= '';

dt_etr_engr = $('#'+tbl_etr_engr).DataTable({
	"aaSorting"	 : [],	
	"bProcessing": true,
	"bServerSide": true,
	"sAjaxSource": "server_side_scripts/etr/dt_etr_engineering.php?username="+username,
	"drawCallback": function( settings ) {
		$('#'+tbl_etr_engr).attr('style','width:100%;');
	}
});

/* ***************************
	ETR Engineering Main Table - End
*************************** */


/* ***************************
	ETR Engineering Add Functions - Start
*************************** */
var mdl_engr_add 		= 'modal_etr_engineering_add';
var frm_engr_add 		= 'frm_etr_engineering_add';
var mdl_view_ope 		= 'modal_view_operator_list';

$('#' + tbl_etr_engr + ' tbody').on('click', 'tr .fa-plus', function() {
	var pkid = $(this).attr('id');
	fn_get_etr_details_by_pkid(pkid, mdl_engr_add, frm_engr_add, 'ENGR');
	re_initialize_select2_server_side('#'+mdl_engr_add+' #eng_second_take_qualified_by','#'+mdl_engr_add+' #'+frm_engr_add,[],"server_side_scripts/dropdown/etr/dd_etr_engr_list.php");
	re_initialize_select2_server_side('#'+mdl_engr_add+' #engr_checked_by','#'+mdl_engr_add+' #'+frm_engr_add,[],"server_side_scripts/dropdown/etr/dd_etr_engr_list.php");
	
	$('input[type="text"],input[type="datetime-local"],input[type="number"], select').prop('required', true);
	$('#'+frm_engr_add+' #eng_second_take_qualified_by').prop('required', false);
	$('#'+frm_engr_add+' #eng_second_take_date_time').prop('required', false);
	$('#'+frm_engr_add+' #reason_certification_others').prop('required', false);
	
	$('#'+mdl_engr_add).data('id', pkid);
	$('#'+mdl_engr_add).modal();
});

$('#'+mdl_engr_add+' .fa-eye').click(function() {
	var pkid = $('#'+mdl_engr_add).data('id');
	fn_return_operator_lists(pkid);
});

$('#'+mdl_engr_add+' #tbl_operator_list tbody').on('change', 'tr #eng_first_take_observation_interview', function() {
    var first_result = $(this).val();
    var row_index = $(this).closest('tr').index();
    if(first_result == 'FAILED') {
        $('#'+frm_engr_add+' #tbl_operator_list tbody tr:eq('+row_index+') td:eq(3) select').prop('disabled', false);
        $('#'+frm_engr_add+' #tbl_operator_list tbody tr:eq('+row_index+') td:eq(9) select').prop('disabled', false);
        $('#'+frm_engr_add+' #tbl_operator_list tbody tr:eq('+row_index+') td:eq(6) input').prop('required', true);
        $('#'+frm_engr_add+' #tbl_operator_list tbody tr:eq('+row_index+') td:eq(7) input').prop('required', true);
        $('#'+frm_engr_add+' #tbl_operator_list tbody tr:eq('+row_index+') td:eq(6) input').prop('required', true);
        $('#'+frm_engr_add+' #tbl_operator_list tbody tr:eq('+row_index+') td:eq(7) input').prop('required', true);
        $('#'+frm_engr_add+' #tbl_operator_list tbody tr:eq('+row_index+') td:eq(6) input').prop('disabled', false);
        $('#'+frm_engr_add+' #tbl_operator_list tbody tr:eq('+row_index+') td:eq(7) input').prop('disabled', false);
    } else {
		$('#'+frm_engr_add+' #tbl_operator_list tbody tr:eq('+row_index+') td:eq(3) select').prop('disabled', true);
		$('#'+frm_engr_add+' #tbl_operator_list tbody tr:eq('+row_index+') td:eq(3) select').val('');
		$('#'+frm_engr_add+' #tbl_operator_list tbody tr:eq('+row_index+') td:eq(8) select').val('');
		$('#'+frm_engr_add+' #tbl_operator_list tbody tr:eq('+row_index+') td:eq(9) select').prop('disabled', true);
		$('#'+frm_engr_add+' #tbl_operator_list tbody tr:eq('+row_index+') td:eq(9) select').val('');
        $('#'+frm_engr_add+' #tbl_operator_list tbody tr:eq('+row_index+') td:eq(6) input').prop('required', false);
        $('#'+frm_engr_add+' #tbl_operator_list tbody tr:eq('+row_index+') td:eq(7) input').prop('required', false);
        $('#'+frm_engr_add+' #tbl_operator_list tbody tr:eq('+row_index+') td:eq(6) input').prop('disabled', true);
        $('#'+frm_engr_add+' #tbl_operator_list tbody tr:eq('+row_index+') td:eq(7) input').prop('disabled', true);
        $('#'+frm_engr_add+' #tbl_operator_list tbody tr:eq('+row_index+') td:eq(6) input').prop('required', false);
        $('#'+frm_engr_add+' #tbl_operator_list tbody tr:eq('+row_index+') td:eq(7) input').prop('required', false);
    }
	dn_engr_check_first_take_result(mdl_engr_add+' #tbl_operator_list', frm_engr_add);
});

$('#'+mdl_engr_add+' #tbl_operator_list tbody').on('change', 'tr #eng_second_take_observation_interview', function() {
    var first_result = $(this).val();
    var row_index = $(this).closest('tr').index();
	
	if(($('#'+frm_engr_add+' #tbl_operator_list tbody tr:eq('+row_index+') td:eq(2) select').val()) && first_result == 'FAILED') {
		$('#'+frm_engr_add+' #tbl_operator_list tbody tr:eq('+row_index+') td:eq(8) select').prop('disabled', true);
		$('#'+frm_engr_add+' #tbl_operator_list tbody tr:eq('+row_index+') td:eq(8) select').val('FAILED');
		$('#'+frm_engr_add+' #tbl_operator_list tbody tr:eq('+row_index+') td:eq(9) select').prop('disabled', true);
		$('#'+frm_engr_add+' #tbl_operator_list tbody tr:eq('+row_index+') td:eq(9) select').val('FAILED');
		$('#'+frm_engr_add+' #tbl_operator_list tbody tr:eq('+row_index+') td:eq(10) textarea').prop('required', true);
	} else if(first_result == 'FAILED') {
		$('#'+frm_engr_add+' #tbl_operator_list tbody tr:eq('+row_index+') td:eq(8) select').prop('disabled', false);
        $('#'+frm_engr_add+' #tbl_operator_list tbody tr:eq('+row_index+') td:eq(9) select').prop('disabled', true);
		$('#'+frm_engr_add+' #tbl_operator_list tbody tr:eq('+row_index+') td:eq(9) select').val('FAILED');
		$('#'+frm_engr_add+' #tbl_operator_list tbody tr:eq('+row_index+') td:eq(10) textarea').prop('required', true);		
    } else {
		$('#'+frm_engr_add+' #tbl_operator_list tbody tr:eq('+row_index+') td:eq(8) select').prop('disabled', false);
		$('#'+frm_engr_add+' #tbl_operator_list tbody tr:eq('+row_index+') td:eq(9) select').prop('disabled', false);
		$('#'+frm_engr_add+' #tbl_operator_list tbody tr:eq('+row_index+') td:eq(9) select').val('');
		$('#'+frm_engr_add+' #tbl_operator_list tbody tr:eq('+row_index+') td:eq(10) textarea').prop('required', false);
    }
});

$('#'+mdl_engr_add+' .fa-save').click(function(){
    var serialized_data = $('#'+frm_engr_add).serialize();
    fn_add_engr_training(serialized_data, 'DRAFT ENGR',mdl_engr_add, frm_engr_add);
});

$('#'+frm_engr_add).submit(function(e){
    e.preventDefault(); 
	$('#'+frm_engr_add+' #container_etr_engineering_new_message').hide();
	var serialized_data = $(this).serialize();
	// fn_add_engr_training(serialized_data, 'FOR QC QUALIFICATION', mdl_engr_add, frm_engr_add);
	// fn_add_engr_training(serialized_data, 'FOR ENGR CHECKING', mdl_engr_add, frm_engr_add);//commented by novs 2019-06-27
	fn_add_engr_training(serialized_data, 'FOR QC QUALIFICATION', mdl_engr_add, frm_engr_add);
});

function fn_add_engr_training(serialized_data, status, mdl_engr_id, frm_id) {		
	var eng_second_take_observation_interview 	= new Array();
	var eng_second_take_sample_checking_ok 		= new Array();
	var eng_second_take_sample_checking_ng 		= new Array();
	var eng_first_take_overall_assessment 		= new Array();
	var eng_second_take_overall_assessment 		= new Array();
	$('#'+frm_id+' #tbl_operator_list tbody tr').each(function() {
		if($(this).find('td select').prop('disabled')) {
			eng_second_take_observation_interview.push("");
			eng_first_take_overall_assessment.push($(this).find('td:eq(8) select').val());
			eng_second_take_overall_assessment.push($(this).find('td:eq(9) select').val());
			$(this).find('td select').prop('disabled', false);
			$(this).find('td input').prop('disabled', false);
		} else {
			eng_second_take_observation_interview.push($(this).find('td:eq(3) select').val());
			eng_first_take_overall_assessment.push($(this).find('td:eq(8) select').val());
			eng_second_take_overall_assessment.push($(this).find('td:eq(9) select').val());
		}
		eng_second_take_sample_checking_ok.push($(this).find('td:eq(6) input').val());
		eng_second_take_sample_checking_ng.push($(this).find('td:eq(7) input').val());
	});
	
	
    var check_items_id  = new Array();
    var check_items_value = new Array();
    $('#'+mdl_engr_id+' #container_check_items input[type="checkbox"]').each(function() {
        check_items_id.push($(this).data('id'));
        check_items_value.push($(this).prop('checked'));
    });
	
	$('.btn').prop("disabled",false);
	var data = {
		"action" 	                				: "add_engr_training",
		"check_items_id" 	       					: check_items_id,
		"check_items_value"   						: check_items_value,
		"eng_second_take_observation_interview2" 	: eng_second_take_observation_interview,
		"eng_second_take_sample_checking_ok2" 		: eng_second_take_sample_checking_ok,
		"eng_second_take_sample_checking_ng2" 		: eng_second_take_sample_checking_ng,
		"eng_first_take_overall_assessment2"   		: eng_first_take_overall_assessment,
		"eng_second_take_overall_assessment2"   	: eng_second_take_overall_assessment,
		"pkid" 			            				: $('#'+mdl_engr_id).data('id'),
		"status" 			        				: status,
		"username" 			        				: username,
	}
	call_ajax_serialize(data,serialized_data,handler_etr,function(result){
		console.log(result);
		$('#'+mdl_engr_id).modal('hide');
		$('#modal_system_message').modal();
		$('#container_message').attr('class','alert alert-success');
		$('#container_message').html( '<h4>'+result['msg']+'</h4>' );
		$('.btn').prop("disabled",false);
		fn_etr_reload_datatables();
		$('input, select').val('');
	});
}

function dn_engr_check_first_take_result(tbl_id, frm_id) {
	var show_second_take = false;	
	$('#'+tbl_id+' tbody tr').each(function() {
		if($(this).find('td:eq(8) select').val() == 'FAILED') {
			$('#'+frm_id+' #eng_second_take_qualified_by').prop('required', true);
			$('#'+frm_id+' #eng_second_take_date_time').prop('required', true);
			$('#'+frm_id+' #div_engr_second_take').show();
			show_second_take = true;
		}
	});
	if(!show_second_take) {
		$('#'+frm_id+' #eng_second_take_qualified_by').prop('required', false);
		$('#'+frm_id+' #eng_second_take_date_time').prop('required', false);
		$('#'+frm_id+' #div_engr_second_take').hide();
	}
}

/* ***************************
	ETR Engineering Add Functions - End
*************************** */

/* ***************************
	ETR Engineering Edit Functions - Start
*************************** */

var mdl_engr_edit 		= 'modal_etr_engineering_edit';
var frm_engr_edit 		= 'frm_etr_engineering_edit';

$('#' + tbl_etr_engr + ' tbody').on('click', 'tr .fa-edit', function() {
	var pkid 	= $(this).attr('id');
	var row 	= $(this).closest('tr');
	var status	= row.find('td:eq(0)').text();
	if(status == 'DRAFT' || status == 'PENDING') {
		$('#'+mdl_engr_edit+' .fa-save').show();
	} else {
		$('#'+mdl_engr_edit+' .fa-save').hide();
	}
	$('#'+mdl_engr_edit+' .fa-remove').hide();
	fn_get_etr_details_by_pkid(pkid, mdl_engr_edit, frm_engr_edit, 'ENGR');
	re_initialize_select2_server_side('#'+mdl_engr_edit+' #eng_second_take_qualified_by','#'+mdl_engr_edit+' #'+frm_engr_edit,[],"server_side_scripts/dropdown/etr/dd_etr_qc_list.php");
	re_initialize_select2_server_side('#'+mdl_engr_edit+' #engr_checked_by','#'+mdl_engr_edit+' #'+frm_engr_add,[],"server_side_scripts/dropdown/etr/dd_etr_engr_list.php");
	
	$('input[type="text"],input[type="datetime-local"],input[type="number"], select').prop('required', true);
	$('#'+frm_engr_edit+' #eng_second_take_qualified_by').prop('required', false);
	$('#'+frm_engr_edit+' #eng_second_take_date_time').prop('required', false);
	$('#'+frm_engr_edit+' #reason_certification_others').prop('required', false);
	
	$('#'+mdl_engr_edit).data('id', pkid);
	$('#'+mdl_engr_edit).modal();
});

$('#'+mdl_engr_edit+' .fa-eye').click(function() {
	var pkid = $('#'+mdl_engr_edit).data('id');
	fn_return_operator_lists(pkid);
});

$('#'+mdl_engr_edit+' #tbl_operator_list tbody').on('change', 'tr #eng_first_take_observation_interview', function() {
    var first_result = $(this).val();
    var row_index = $(this).closest('tr').index();
    if(first_result == 'FAILED') {
        $('#'+frm_engr_edit+' #tbl_operator_list tbody tr:eq('+row_index+') td:eq(3) select').prop('disabled', false);
        $('#'+frm_engr_edit+' #tbl_operator_list tbody tr:eq('+row_index+') td:eq(9) select').prop('disabled', false);
        $('#'+frm_engr_edit+' #eng_second_take_qualified_by').prop('required', true);
        $('#'+frm_engr_edit+' #prdn_second_take_date_time').prop('required', true);
		$('#'+frm_engr_edit+' #div_engr_second_take').show();
    } else {
		$('#'+frm_engr_edit+' #tbl_operator_list tbody tr:eq('+row_index+') td:eq(3) select').prop('disabled', true);
		$('#'+frm_engr_edit+' #tbl_operator_list tbody tr:eq('+row_index+') td:eq(3) select').val('');
		$('#'+frm_engr_edit+' #tbl_operator_list tbody tr:eq('+row_index+') td:eq(8) select').val('');
		$('#'+frm_engr_edit+' #tbl_operator_list tbody tr:eq('+row_index+') td:eq(9) select').prop('disabled', true);
		$('#'+frm_engr_edit+' #tbl_operator_list tbody tr:eq('+row_index+') td:eq(9) select').val('');
        $('#'+frm_engr_edit+' #eng_second_take_qualified_by').prop('required', false);
        $('#'+frm_engr_edit+' #prdn_second_take_date_time').prop('required', false);
		$('#'+frm_engr_edit+' #div_engr_second_take').hide();
    }
});

$('#'+mdl_engr_edit+' #tbl_operator_list tbody').on('change', 'tr #eng_second_take_observation_interview', function() {
    var first_result = $(this).val();
    var row_index = $(this).closest('tr').index();
	
	if(($('#'+frm_engr_edit+' #tbl_operator_list tbody tr:eq('+row_index+') td:eq(2) select').val()) && first_result == 'FAILED') {
		$('#'+frm_engr_edit+' #tbl_operator_list tbody tr:eq('+row_index+') td:eq(8) select').prop('disabled', true);
		$('#'+frm_engr_edit+' #tbl_operator_list tbody tr:eq('+row_index+') td:eq(8) select').val('FAILED');
		$('#'+frm_engr_edit+' #tbl_operator_list tbody tr:eq('+row_index+') td:eq(9) select').prop('disabled', true);
		$('#'+frm_engr_edit+' #tbl_operator_list tbody tr:eq('+row_index+') td:eq(9) select').val('FAILED');
		$('#'+frm_engr_edit+' #tbl_operator_list tbody tr:eq('+row_index+') td:eq(10) textarea').prop('required', true);
	} else if(first_result == 'FAILED') {
		$('#'+frm_engr_edit+' #tbl_operator_list tbody tr:eq('+row_index+') td:eq(8) select').prop('disabled', false);
        $('#'+frm_engr_edit+' #tbl_operator_list tbody tr:eq('+row_index+') td:eq(9) select').prop('disabled', true);
		$('#'+frm_engr_edit+' #tbl_operator_list tbody tr:eq('+row_index+') td:eq(9) select').val('FAILED');
		$('#'+frm_engr_edit+' #tbl_operator_list tbody tr:eq('+row_index+') td:eq(10) textarea').prop('required', true);
    } else {
		$('#'+frm_engr_edit+' #tbl_operator_list tbody tr:eq('+row_index+') td:eq(8) select').prop('disabled', false);
		$('#'+frm_engr_edit+' #tbl_operator_list tbody tr:eq('+row_index+') td:eq(9) select').prop('disabled', false);
		$('#'+frm_engr_edit+' #tbl_operator_list tbody tr:eq('+row_index+') td:eq(9) select').val('');
		$('#'+frm_engr_edit+' #tbl_operator_list tbody tr:eq('+row_index+') td:eq(10) textarea').prop('required', false);
    }
});


$('#'+mdl_engr_edit+' .fa-save').click(function(){
    var serialized_data = $('#'+frm_engr_edit).serialize();
    fn_add_engr_training(serialized_data, 'DRAFT ENGR', mdl_engr_edit, frm_engr_edit);
});

$('#'+frm_engr_edit).submit(function(e){
    e.preventDefault(); 
	$('#'+frm_engr_edit+' #container_etr_engineering_new_message').hide();
	var serialized_data = $(this).serialize();
	// fn_add_engr_training(serialized_data, 'FOR QC QUALIFICATION', mdl_engr_edit, frm_engr_edit); 
	// fn_add_engr_training(serialized_data, 'FOR ENGR CHECKING', mdl_engr_edit, frm_engr_edit); //commented by novs 2019-06-27
	fn_add_engr_training(serialized_data, 'FOR QC QUALIFICATION', mdl_engr_edit, frm_engr_edit); 

});


/* ***************************
	ETR Engineering Edit Functions - End
*************************** */

/* ***************************
	ETR Engineering View Functions - Start
*************************** */

var mdl_engr_view 		= 'modal_etr_engineering_view';
var frm_engr_view 		= 'frm_etr_engineering_view';

$('#' + tbl_etr_engr + ' tbody').on('click', 'tr .fa-eye', function() {
	var pkid 	= $(this).attr('id');
	var row 	= $(this).closest('tr');
	var status	= row.find('td:eq(0)').text();
	$('#'+mdl_engr_view+' .approver').hide();
	fn_get_etr_details_by_pkid(pkid, mdl_engr_view, frm_engr_view, 'ENGR');
	
	$('#'+mdl_engr_view).data('id', pkid);
	$('#'+mdl_engr_view).modal();
});

$('#'+mdl_engr_view+' .fa-eye').click(function() {
	var pkid = $('#'+mdl_engr_view).data('id');
	fn_return_operator_lists(pkid);
});

/* ***************************
	ETR Engineering View Functions - End
*************************** */

/* ***************************
	ETR Engineering - Approver Main Table - Start
*************************** */
var tbl_etr_engineering_app    	= 'tbl_etr_engineering_app';
var dt_etr_engr_app 			= '';

dt_etr_engr_app = $('#'+tbl_etr_engineering_app).DataTable({
	"aaSorting"	 : [],	
	"bProcessing": true,
	"bServerSide": true,
	"sAjaxSource": "server_side_scripts/etr/dt_etr_engineering_approver.php?un="+username,
	"drawCallback": function( settings ) {
		$('#'+tbl_etr_engineering_app).attr('style','width:100%;');
	}
});

$('#' + tbl_etr_engineering_app + ' tbody').on('click', 'tr .fa-eye', function() {
	var pkid 	= $(this).attr('id');
	var row 	= $(this).closest('tr');
	var status	= row.find('td:eq(0)').text();
	if(status == ' PENDING') {
		$('#'+mdl_engr_view+' .approver').show();		
	} else {
		$('#'+mdl_engr_view+' .approver').hide();
	}
	fn_get_etr_details_by_pkid(pkid, mdl_engr_view, frm_engr_view, 'ENGR');
	
	$('#'+mdl_engr_view).data('id', pkid);
	$('#'+mdl_engr_view).modal();
});

$('#'+mdl_engr_view+' .fa-thumbs-up').click(function() {
	$('#'+mdl_app_conf).data('id', $('#'+mdl_engr_view).data('id'));
	$('#'+mdl_app_conf).data('status', 'FOR QC QUALIFICATION');
	$('#'+mdl_app_conf).data('app_status', 'APPROVED');
	$('#'+mdl_app_conf).data('checked_by_field', 'engr_checked_by');
	$('#'+mdl_app_conf).data('checked_by_logs_field', 'engr_checked_by_logs');
	$('#'+mdl_app_conf+' #container_approver_message').attr('class','alert alert-success');
	$('#'+mdl_app_conf+' #container_approver_message').html('Are you sure you want to approve the request?<br><br>Remarks:<textarea name="remarks" style="width:100%;" rows="4"></textarea>');
	$('#'+mdl_app_conf+' #container_approver_message').show();
	$('#'+mdl_app_conf).modal();
});

$('#'+mdl_engr_view+' .fa-thumbs-down').click(function() {
	$('#'+mdl_app_conf).data('id', $('#'+mdl_engr_view).data('id'));
	$('#'+mdl_app_conf).data('status', 'DISAPPROVED ENGINEERING');
	$('#'+mdl_app_conf).data('app_status', 'DISAPPROVED');
	$('#'+mdl_app_conf).data('checked_by_field', 'engr_checked_by');
	$('#'+mdl_app_conf).data('checked_by_logs_field', 'engr_checked_by_logs');
	$('#'+mdl_app_conf+' #container_approver_message').attr('class','alert alert-success');
	$('#'+mdl_app_conf+' #container_approver_message').html('Are you sure you want to approve the request?<br><br>Remarks:<textarea name="remarks" style="width:100%;" rows="4" required></textarea>');
	$('#'+mdl_app_conf+' #container_approver_message').show();
	$('#'+mdl_app_conf).modal();
});

/* ***************************
	ETR Engineering - Approver Main Table - End
*************************** */

/* ***************************
	ETR Engineering Cancel Functions - Start
*************************** */

$('#' + tbl_etr_engr + ' tbody').on('click', 'tr .fa-remove', function() {
	var pkid 	= $(this).attr('id');
	var row 	= $(this).closest('tr');
	var status	= row.find('td:eq(0)').text();
	if(status.match("CANCEL")){
		$('#'+mdl_engr_edit+' .fa-remove').hide();
	} else {
		$('#'+mdl_engr_edit+' .fa-remove').show();
	}
	$('#'+mdl_engr_edit+' .fa-save').hide();
	$('#'+mdl_engr_edit+' .fa-send-o').hide();
	$('#'+frm_cancel+' input[name="status"]').val('CANCELLED BY ENGINEERING');
	fn_get_etr_details_by_pkid(pkid, mdl_engr_edit, frm_engr_edit, 'ENGR');
	$('#'+mdl_engr_edit).data('id', pkid);
	$('#'+mdl_engr_edit).modal();
});

$('#'+mdl_engr_edit+' .fa-remove').click(function(){
	$('#'+mdl_cancel).data('id', $('#'+mdl_engr_edit).data('id'));
    $('#'+mdl_cancel).modal();
});
/* ***************************
	ETR Engineering Cancel Functions - End
*************************** */

/* ***************************
	ETR Cancel Functions - Start
*************************** */

var mdl_cancel = 'modal_etr_cancel';
var frm_cancel = 'frm_etr_cancel';

$('#'+frm_cancel).submit(function(e){
    e.preventDefault(); 
	var serialized_data = $(this).serialize();
	fn_cancel_etr($('#'+mdl_cancel).data('id'), serialized_data);
});

function fn_cancel_etr(pkid, serialized_data) {
	var data = {
		"action"  	: "cancel_etr",
		"pkid"	  	: pkid,
		"username"	: username,
	}
	call_ajax_serialize(data,serialized_data,handler_etr,function(result){
		$('.modal').modal('hide');
		$('#modal_system_message').modal();
		$('#container_message').attr('class','alert alert-success');
		$('#container_message').html( '<h4>'+result['msg']+'</h4>' );
		$('.btn').prop("disabled",false);
		fn_etr_reload_datatables();
	});
}

/* ***************************
	ETR Cancel Functions - End
*************************** */

/* ***************************
	ETR Quality Section Main Table - Start
*************************** */
var tbl_etr_qc    	= 'tbl_etr_qc';
var dt_etr_qc 		= '';

dt_etr_qc = $('#'+tbl_etr_qc).DataTable({
	"aaSorting"	 : [],	
	"bProcessing": true,
	"bServerSide": true,
	"sAjaxSource": "server_side_scripts/etr/dt_etr_qc.php?username="+username,
	"drawCallback": function( settings ) {
		$('#'+tbl_etr_qc).attr('style','width:100%;');
	}
});

/* ***************************
	ETR Quality Section Main Table - End
*************************** */

/* ***************************
	ETR Quality Section Add Functions - Start
*************************** */
var mdl_qc_add 		= 'modal_etr_qc_add';
var frm_qc_add 		= 'frm_etr_qc_add';

$('#' + tbl_etr_qc + ' tbody').on('click', 'tr .fa-plus', function() {
	var pkid = $(this).attr('id');
	fn_get_etr_details_by_pkid(pkid, mdl_qc_add, frm_qc_add, 'QC');
	re_initialize_select2_server_side('#'+mdl_qc_add+' #qc_second_take_certified_by','#'+mdl_qc_add+' #'+frm_qc_add,[],"server_side_scripts/dropdown/etr/dd_etr_qc_list.php");
	
	$('input[type="text"],input[type="datetime-local"],input[type="number"], select').prop('required', true);
	$('#'+frm_qc_add+' #qc_second_take_certified_by').prop('required', false);
	$('#'+frm_qc_add+' #qc_second_take_date_time').prop('required', false);
	$('#'+frm_qc_add+' #reason_certification_others').prop('required', false);
	
	$('#'+mdl_qc_add).data('id', pkid);
	$('#'+mdl_qc_add).modal();
});

$('#'+mdl_qc_add+' .fa-eye').click(function() {
	var pkid = $('#'+mdl_qc_add).data('id');
	fn_return_operator_lists(pkid);
});

$('#'+mdl_qc_add+' #tbl_operator_list tbody').on('change', 'tr #qc_first_take_observation_interview_result', function() {
    var first_result = $(this).val();
    var row_index = $(this).closest('tr').index();
    if(first_result == 'FAILED') {
        $('#'+frm_qc_add+' #tbl_operator_list tbody tr:eq('+row_index+') td:eq(3) select').prop('disabled', false);
        $('#'+frm_qc_add+' #tbl_operator_list tbody tr:eq('+row_index+') td:eq(9) select').prop('disabled', false);
        $('#'+frm_qc_add+' #tbl_operator_list tbody tr:eq('+row_index+') td:eq(6) input').prop('disabled', false);
        $('#'+frm_qc_add+' #tbl_operator_list tbody tr:eq('+row_index+') td:eq(7) input').prop('disabled', false);
        $('#'+frm_qc_add+' #tbl_operator_list tbody tr:eq('+row_index+') td:eq(6) input').prop('required', true);
        $('#'+frm_qc_add+' #tbl_operator_list tbody tr:eq('+row_index+') td:eq(7) input').prop('required', true);
    } else {
		$('#'+frm_qc_add+' #tbl_operator_list tbody tr:eq('+row_index+') td:eq(3) select').prop('disabled', true);
		$('#'+frm_qc_add+' #tbl_operator_list tbody tr:eq('+row_index+') td:eq(3) select').val('');
		$('#'+frm_qc_add+' #tbl_operator_list tbody tr:eq('+row_index+') td:eq(8) select').val('');
		$('#'+frm_qc_add+' #tbl_operator_list tbody tr:eq('+row_index+') td:eq(9) select').prop('disabled', true);
		$('#'+frm_qc_add+' #tbl_operator_list tbody tr:eq('+row_index+') td:eq(9) select').val('');
        $('#'+frm_qc_add+' #tbl_operator_list tbody tr:eq('+row_index+') td:eq(6) input').prop('disabled', true);
        $('#'+frm_qc_add+' #tbl_operator_list tbody tr:eq('+row_index+') td:eq(7) input').prop('disabled', true);
        $('#'+frm_qc_add+' #tbl_operator_list tbody tr:eq('+row_index+') td:eq(6) input').prop('required', false);
        $('#'+frm_qc_add+' #tbl_operator_list tbody tr:eq('+row_index+') td:eq(7) input').prop('required', false);
    }
	dn_qc_check_first_take_result(mdl_qc_add+' #tbl_operator_list', frm_qc_add);
});

$('#'+mdl_qc_add+' #tbl_operator_list tbody').on('change', 'tr #qc_second_take_observation_interview_result', function() {
    var first_result = $(this).val();
    var row_index = $(this).closest('tr').index();
	
	if(($('#'+frm_qc_add+' #tbl_operator_list tbody tr:eq('+row_index+') td:eq(2) select').val()) && first_result == 'FAILED') {
		$('#'+frm_qc_add+' #tbl_operator_list tbody tr:eq('+row_index+') td:eq(8) select').prop('disabled', true);
		$('#'+frm_qc_add+' #tbl_operator_list tbody tr:eq('+row_index+') td:eq(8) select').val('FAILED');
		$('#'+frm_qc_add+' #tbl_operator_list tbody tr:eq('+row_index+') td:eq(9) select').prop('disabled', true);
		$('#'+frm_qc_add+' #tbl_operator_list tbody tr:eq('+row_index+') td:eq(9) select').val('FAILED');
		$('#'+frm_qc_add+' #tbl_operator_list tbody tr:eq('+row_index+') td:eq(10) textarea').prop('required', true);
	} else if(first_result == 'FAILED') {
		$('#'+frm_qc_add+' #tbl_operator_list tbody tr:eq('+row_index+') td:eq(8) select').prop('disabled', false);
        $('#'+frm_qc_add+' #tbl_operator_list tbody tr:eq('+row_index+') td:eq(9) select').prop('disabled', true);
		$('#'+frm_qc_add+' #tbl_operator_list tbody tr:eq('+row_index+') td:eq(9) select').val('FAILED');
		$('#'+frm_qc_add+' #tbl_operator_list tbody tr:eq('+row_index+') td:eq(10) textarea').prop('required', true);
    } else {
		$('#'+frm_qc_add+' #tbl_operator_list tbody tr:eq('+row_index+') td:eq(8) select').prop('disabled', false);
		$('#'+frm_qc_add+' #tbl_operator_list tbody tr:eq('+row_index+') td:eq(9) select').prop('disabled', false);
		$('#'+frm_qc_add+' #tbl_operator_list tbody tr:eq('+row_index+') td:eq(9) select').val('');
		$('#'+frm_qc_add+' #tbl_operator_list tbody tr:eq('+row_index+') td:eq(10) textarea').prop('required', false);
    }
});

$('#'+mdl_qc_add+' .fa-save').click(function(){
    var serialized_data = $('#'+frm_qc_add).serialize();
    fn_add_qc_training(serialized_data, 'DRAFT QC', mdl_qc_add, frm_qc_add);
});

$('#'+frm_qc_add).submit(function(e){
    e.preventDefault(); 
	$('#'+frm_qc_add+' #container_etr_engineering_new_message').hide();
	var serialized_data = $(this).serialize();
	// fn_add_qc_training(serialized_data, 'FOR POSTING', mdl_qc_add, frm_qc_add);
	// fn_add_qc_training(serialized_data, 'FOR QC APPROVAL', mdl_qc_add, frm_qc_add);comntd by novs 2019-06-27
	fn_add_qc_training(serialized_data, 'FOR POSTING', mdl_qc_add, frm_qc_add);
});

function dn_qc_check_first_take_result(tbl_id, frm_id) {
	var show_second_take = false;	
	$('#'+tbl_id+' tbody tr').each(function() {
		if($(this).find('td:eq(2) select').val() == 'FAILED') {
			$('#'+frm_id+' #qc_second_take_certified_by').prop('required', true);
			$('#'+frm_id+' #prdn_second_take_date_time').prop('required', true);
			$('#'+frm_id+' #div_qc_second_take').show();
			show_second_take = true;
		}
	});
	if(!show_second_take) {
		$('#'+frm_id+' #qc_second_take_certified_by').prop('required', false);
		$('#'+frm_id+' #prdn_second_take_date_time').prop('required', false);
		$('#'+frm_id+' #div_qc_second_take').hide();
	}
}

function fn_add_qc_training(serialized_data, status, mdl_qc_id, frm_id) {		
	var qc_second_take_observation_interview 	= new Array();
	var qc_second_take_sample_checking_ok 		= new Array();
	var qc_second_take_sample_checking_ng 		= new Array();
	var qc_first_take_overall_assessment 		= new Array();
	var qc_second_take_overall_assessment 		= new Array();
	$('#'+frm_id+' #tbl_operator_list tbody tr').each(function() {
		if($(this).find('td select').prop('disabled')) {
			qc_second_take_observation_interview.push("");
			qc_first_take_overall_assessment.push($(this).find('td:eq(8) select').val());
			qc_second_take_overall_assessment.push($(this).find('td:eq(9) select').val());
			$(this).find('td select').prop('disabled', false);
			$(this).find('td input').prop('disabled', false);
		} else {
			qc_second_take_observation_interview.push($(this).find('td:eq(3) select').val());
			qc_first_take_overall_assessment.push($(this).find('td:eq(8) select').val());
			qc_second_take_overall_assessment.push($(this).find('td:eq(9) select').val());
		}
		qc_second_take_sample_checking_ok.push($(this).find('td:eq(6) input').val());
		qc_second_take_sample_checking_ng.push($(this).find('td:eq(7) input').val());
	});
	$('.btn').prop("disabled",false);
	var data = {
		"action" 	                				: "add_qc_training",
		"qc_second_take_observation_interview2" 	: qc_second_take_observation_interview,
		"qc_second_take_sample_checking_ok2"   		: qc_second_take_sample_checking_ok,
		"qc_second_take_sample_checking_ng2"   		: qc_second_take_sample_checking_ng,
		"qc_first_take_overall_assessment2"   		: qc_first_take_overall_assessment,
		"qc_second_take_overall_assessment2"   		: qc_second_take_overall_assessment,
		"pkid" 			            				: $('#'+mdl_qc_id).data('id'),
		"status" 			        				: status,
		"username" 			        				: username,
	}
	call_ajax_serialize(data,serialized_data,handler_etr,function(result){
		console.log(result);
		$('#'+mdl_qc_id).modal('hide');
		$('#modal_system_message').modal();
		$('#container_message').attr('class','alert alert-success');
		$('#container_message').html( '<h4>'+result['msg']+'</h4>' );
		$('.btn').prop("disabled",false);
		fn_etr_reload_datatables();
		$('input, select').val('');
	});
}

/* ***************************
	ETR Quality Section Add Functions - End
*************************** */

/* ***************************
	ETR Quality Section Edit Functions - Start
*************************** */

var mdl_qc_edit 		= 'modal_etr_qc_edit';
var frm_qc_edit 		= 'frm_etr_qc_edit';

$('#' + tbl_etr_qc + ' tbody').on('click', 'tr .fa-edit', function() {
	var pkid 	= $(this).attr('id');
	var row 	= $(this).closest('tr');
	var status	= row.find('td:eq(0)').text();
	if(status == 'DRAFT' || status == 'PENDING') {
		$('#'+mdl_qc_edit+' .fa-save').show();
	} else {
		$('#'+mdl_qc_edit+' .fa-save').hide();
	}
	$('#'+mdl_qc_edit+' .fa-remove').hide();
	fn_get_etr_details_by_pkid(pkid, mdl_qc_edit, frm_qc_edit, 'QC');
	re_initialize_select2_server_side('#'+mdl_qc_edit+' #qc_second_take_certified_by','#'+mdl_qc_edit+' #'+frm_qc_edit,[],"server_side_scripts/dropdown/etr/dd_etr_qc_list.php");
	
	$('input[type="text"],input[type="datetime-local"],input[type="number"], select').prop('required', true);
	$('#'+frm_qc_edit+' #qc_second_take_certified_by').prop('required', false);
	$('#'+frm_qc_edit+' #qc_second_take_date_time').prop('required', false);
	$('#'+frm_qc_edit+' #reason_certification_others').prop('required', false);
	
	$('#'+mdl_qc_edit).data('id', pkid);
	$('#'+mdl_qc_edit).modal();
});

$('#'+mdl_qc_edit+' .fa-eye').click(function() {
	var pkid = $('#'+mdl_qc_edit).data('id');
	fn_return_operator_lists(pkid);
});


$('#'+mdl_qc_edit+' #tbl_operator_list tbody').on('change', 'tr #qc_first_take_observation_interview_result', function() {
    var first_result = $(this).val();
    var row_index = $(this).closest('tr').index();
    if(first_result == 'FAILED') {
        $('#'+frm_qc_edit+' #tbl_operator_list tbody tr:eq('+row_index+') td:eq(3) select').prop('disabled', false);
        $('#'+frm_qc_edit+' #tbl_operator_list tbody tr:eq('+row_index+') td:eq(9) select').prop('disabled', false);
        $('#'+frm_qc_edit+' #qc_second_take_certified_by').prop('required', true);
        $('#'+frm_qc_edit+' #prdn_second_take_date_time').prop('required', true);
		$('#'+frm_qc_edit+' #div_qc_second_take').show();
        $('#'+frm_qc_edit+' #tbl_operator_list tbody tr:eq('+row_index+') td:eq(6) input').prop('required', true);
        $('#'+frm_qc_edit+' #tbl_operator_list tbody tr:eq('+row_index+') td:eq(7) input').prop('required', true);
    } else {
		$('#'+frm_qc_edit+' #tbl_operator_list tbody tr:eq('+row_index+') td:eq(3) select').prop('disabled', true);
		$('#'+frm_qc_edit+' #tbl_operator_list tbody tr:eq('+row_index+') td:eq(3) select').val('');
		$('#'+frm_qc_edit+' #tbl_operator_list tbody tr:eq('+row_index+') td:eq(8) select').val('');
		$('#'+frm_qc_edit+' #tbl_operator_list tbody tr:eq('+row_index+') td:eq(9) select').prop('disabled', true);
		$('#'+frm_qc_edit+' #tbl_operator_list tbody tr:eq('+row_index+') td:eq(9) select').val('');
        $('#'+frm_qc_edit+' #qc_second_take_certified_by').prop('required', false);
        $('#'+frm_qc_edit+' #prdn_second_take_date_time').prop('required', false);		
        $('#'+frm_qc_edit+' #tbl_operator_list tbody tr:eq('+row_index+') td:eq(6) input').prop('disabled', true);
        $('#'+frm_qc_edit+' #tbl_operator_list tbody tr:eq('+row_index+') td:eq(7) input').prop('disabled', true);
        $('#'+frm_qc_edit+' #tbl_operator_list tbody tr:eq('+row_index+') td:eq(6) input').prop('required', false);
        $('#'+frm_qc_edit+' #tbl_operator_list tbody tr:eq('+row_index+') td:eq(7) input').prop('required', false);
		$('#'+frm_qc_edit+' #div_qc_second_take').hide();
    }
});

$('#'+mdl_qc_edit+' #tbl_operator_list tbody').on('change', 'tr #qc_second_take_observation_interview_result', function() {
    var first_result = $(this).val();
    var row_index = $(this).closest('tr').index();
	
	if(($('#'+frm_qc_edit+' #tbl_operator_list tbody tr:eq('+row_index+') td:eq(2) select').val()) && first_result == 'FAILED') {
		$('#'+frm_qc_edit+' #tbl_operator_list tbody tr:eq('+row_index+') td:eq(8) select').prop('disabled', true);
		$('#'+frm_qc_edit+' #tbl_operator_list tbody tr:eq('+row_index+') td:eq(8) select').val('FAILED');
		$('#'+frm_qc_edit+' #tbl_operator_list tbody tr:eq('+row_index+') td:eq(9) select').prop('disabled', true);
		$('#'+frm_qc_edit+' #tbl_operator_list tbody tr:eq('+row_index+') td:eq(9) select').val('FAILED');
		$('#'+frm_qc_edit+' #tbl_operator_list tbody tr:eq('+row_index+') td:eq(10) textarea').prop('required', true);
	} else if(first_result == 'FAILED') {
		$('#'+frm_qc_edit+' #tbl_operator_list tbody tr:eq('+row_index+') td:eq(8) select').prop('disabled', false);
        $('#'+frm_qc_edit+' #tbl_operator_list tbody tr:eq('+row_index+') td:eq(9) select').prop('disabled', true);
		$('#'+frm_qc_edit+' #tbl_operator_list tbody tr:eq('+row_index+') td:eq(9) select').val('FAILED');
		$('#'+frm_qc_edit+' #tbl_operator_list tbody tr:eq('+row_index+') td:eq(10) textarea').prop('required', true);
    } else {
		$('#'+frm_qc_edit+' #tbl_operator_list tbody tr:eq('+row_index+') td:eq(8) select').prop('disabled', false);
		$('#'+frm_qc_edit+' #tbl_operator_list tbody tr:eq('+row_index+') td:eq(9) select').prop('disabled', false);
		$('#'+frm_qc_edit+' #tbl_operator_list tbody tr:eq('+row_index+') td:eq(9) select').val('');
		$('#'+frm_qc_edit+' #tbl_operator_list tbody tr:eq('+row_index+') td:eq(10) textarea').prop('required', false);
    }
});

$('#'+mdl_qc_edit+' .fa-save').click(function(){
    var serialized_data = $('#'+frm_qc_edit).serialize();
    fn_add_qc_training(serialized_data, 'DRAFT QC', mdl_qc_edit, frm_qc_edit);
});

$('#'+frm_qc_edit).submit(function(e){
    e.preventDefault(); 
	$('#'+frm_qc_edit+' #container_etr_engineering_new_message').hide();
	var serialized_data = $(this).serialize();
	fn_add_qc_training(serialized_data, 'FOR POSTING', mdl_qc_edit, frm_qc_edit); 
});

/* ***************************
	ETR Quality Section Edit Functions - End
*************************** */

/* ***************************
	ETR Quality Section View Functions - Start
*************************** */
var mdl_qc_view 		= 'modal_etr_qc_view';
var frm_qc_view 		= 'frm_etr_qc_view';

$('#' + tbl_etr_qc + ' tbody').on('click', 'tr .fa-eye', function() {
	var pkid 	= $(this).attr('id');
	var row 	= $(this).closest('tr');
	fn_get_etr_details_by_pkid(pkid, mdl_qc_view, frm_qc_view, 'QC');
	re_initialize_select2_server_side('#'+mdl_qc_view+' #qc_second_take_certified_by','#'+mdl_qc_view+' #'+frm_qc_view,[],"server_side_scripts/dropdown/etr/dd_etr_qc_list.php");
	$('#'+mdl_qc_view).data('id', pkid);
	$('#'+mdl_qc_view).modal();
});

$('#'+mdl_qc_view+' .fa-eye').click(function() {
	var pkid = $('#'+mdl_qc_view).data('id');
	fn_return_operator_lists(pkid);
});


/* ***************************
	ETR Quality Section View Functions - End
*************************** */

/* ***************************
	ETR QC - Approver Main Table - Start
*************************** */
var tbl_etr_qc_app    		= 'tbl_etr_qc_app';
var dt_etr_qc_app 			= '';
var mdl_qc_app_view 		= 'modal_etr_qc_app_view';
var frm_qc_app_view 		= 'frm_etr_qc_app_view';

dt_etr_qc_app = $('#'+tbl_etr_qc_app).DataTable({
	"aaSorting"	 : [],	
	"bProcessing": true,
	"bServerSide": true,
	"sAjaxSource": "server_side_scripts/etr/dt_etr_qc_approver.php?un="+username,
	"drawCallback": function( settings ) {
		$('#'+tbl_etr_qc_app).attr('style','width:100%;');
	}
});

$('#' + tbl_etr_qc_app + ' tbody').on('click', 'tr .fa-eye', function() {
	var pkid 	= $(this).attr('id');
	var row 	= $(this).closest('tr');
	var status	= row.find('td:eq(0)').text();
	if(status == ' PENDING') {
		$('#'+mdl_qc_app_view+' .approver').show();		
	} else {
		$('#'+mdl_qc_app_view+' .approver').hide();
	}
	fn_get_etr_details_by_pkid(pkid, mdl_qc_app_view, frm_qc_app_view, 'QC');
	
	$('#'+mdl_qc_app_view).data('id', pkid);
	$('#'+mdl_qc_app_view).modal();
});

$('#'+mdl_qc_app_view+' .fa-thumbs-o-up').click(function() {
	$('#'+mdl_app_conf).data('id', $('#'+mdl_qc_app_view).data('id'));
	$('#'+mdl_app_conf).data('status', 'FOR POSTING');
	$('#'+mdl_app_conf).data('app_status', 'APPROVED');
	$('#'+mdl_app_conf).data('checked_by_field', 'qc_checked_by');
	$('#'+mdl_app_conf).data('checked_by_logs_field', 'qc_checked_by_logs');
	$('#'+mdl_app_conf+' #container_approver_message').attr('class','alert alert-success');
	$('#'+mdl_app_conf+' #container_approver_message').html('Are you sure you want to approve the request?<br><br>Remarks:<textarea name="remarks" style="width:100%;" rows="4"></textarea>');
	$('#'+mdl_app_conf+' #container_approver_message').show();
	$('#'+mdl_app_conf).modal();
});

$('#'+mdl_qc_app_view+' .fa-thumbs-o-down').click(function() {
	$('#'+mdl_app_conf).data('id', $('#'+mdl_qc_app_view).data('id'));
	$('#'+mdl_app_conf).data('status', 'DISAPPROVED QC');
	$('#'+mdl_app_conf).data('app_status', 'DISAPPROVED');
	$('#'+mdl_app_conf).data('checked_by_field', 'qc_checked_by');
	$('#'+mdl_app_conf).data('checked_by_logs_field', 'qc_checked_by_logs');
	$('#'+mdl_app_conf+' #container_approver_message').attr('class','alert alert-danger');
	$('#'+mdl_app_conf+' #container_approver_message').html('Are you sure you want to disapprove the request?<br><br>Remarks:<textarea name="remarks" style="width:100%;" rows="4" required></textarea>');
	$('#'+mdl_app_conf+' #container_approver_message').show();
	$('#'+mdl_app_conf).modal();
});


/* ***************************
	ETR Training Head Main Table - Start
*************************** */
var tbl_etr_th    	= 'tbl_etr_th';
var dt_etr_th 		= '';

dt_etr_th = $('#'+tbl_etr_th).DataTable({
	"aaSorting"	 : [],
	"bProcessing": true,
	"bServerSide": true,
	"sAjaxSource": "server_side_scripts/etr/dt_etr_training_head.php?username="+username,
	"drawCallback": function( settings ) {
		$('#'+tbl_etr_th).attr('style','width:100%;');
	}
});

/* ***************************
	ETR Training Head Main Table - End
*************************** */


/* ***************************
	ETR Training Head Acknowledgement Functions - Start
*************************** */
var mdl_th_ackn 		= 'modal_etr_th_acknowledge';
var frm_th_ackn 		= 'frm_etr_th_acknowledge';
var mdl_th_confirm 		= 'modal_etr_th_confirmation';
var frm_th_confirm 		= 'frm_etr_th_confirm';

$('#' + tbl_etr_th + ' tbody').on('click', 'tr .fa-sticky-note-o', function() {
	var pkid = $(this).attr('id');
	fn_get_etr_details_by_pkid(pkid, mdl_th_ackn, frm_th_ackn, 'TH');
	$('#'+mdl_th_ackn+' .fa-handshake-o').show();
	$('#'+mdl_th_ackn+' .modal-title').html('<i class="fa fa-handshake-o"></i> Acknowledgement of Training / Qualification / Certification');
	$('input[type="text"],input[type="number"], select').prop('required', true);	
	$('#'+mdl_th_ackn).data('id', pkid);
	$('#'+mdl_th_ackn).modal();
});

$('#'+mdl_th_ackn+' .fa-handshake-o').click(function() {
	$('#'+mdl_th_confirm).data('id', ($('#'+mdl_th_ackn).data('id')));
	$('#'+mdl_th_confirm).modal();
});

$('#'+frm_th_confirm).submit(function(e) {
	e.preventDefault();
	var data = {
		"action"	: "save_data_hris_etr",
		"pkid"		: $('#'+mdl_th_confirm).data('id'),
		"username"	: username
	}
	call_ajax(data, handler_etr, function(result){	
		$('.modal').modal('hide');
		$('#modal_system_message').modal();
		$('#container_message').attr('class','alert alert-success');
		$('#container_message').html( '<h4>'+result['msg']+'</h4>' );
		$('.btn').prop("disabled",false);
		fn_etr_reload_datatables();
	});
});


/* ***************************
	ETR Training Head Acknowledgement Functions - End
*************************** */

/* ***************************
	ETR Training Head View Functions - Start
*************************** */
$('#' + tbl_etr_th + ' tbody').on('click', 'tr .fa-eye', function() {
	var pkid = $(this).attr('id');
	fn_get_etr_details_by_pkid(pkid, mdl_th_ackn, frm_th_ackn, 'TH');
	$('#'+mdl_th_ackn+' .modal-title').html('<i class="fa fa-eye"></i> Training / Qualification / Certification');
	$('#'+mdl_th_ackn+' .fa-handshake-o').hide();
	$('#'+mdl_th_ackn).modal();
});

/* ***************************
	ETR Training Head View Functions - End
*************************** */

/* ***************************
	ETR Employee Records - Start
*************************** */
var tbl_etr_er    		= 'tbl_etr_er';
var dt_etr_er 			= '';
var tbl_etr_trainings	= 'tbl_emp_trainings';
var dt_etr_trainings	= '';

dt_etr_er = $('#'+tbl_etr_er).DataTable({
	"aaSorting"	 : [],	
	"bProcessing": true,
	"bServerSide": true,
	"pageLength" : 25,
	"sAjaxSource": "server_side_scripts/etr/dt_etr_emp_records.php?db=db_hris.",
	"drawCallback": function( settings ) {
		$('#'+tbl_etr_er).attr('style','width:100%;');
	}
});

$('a[data-toggle="tab"]').on('shown.bs.tab', function (e) {
    var target = $(e.target).attr("href");
    if ((target == '#etr_er')) {
        $('#etr_er #container_emp_records').show();
		$('#etr_er #container_emp_data').hide();
    } 
});

$('#' + tbl_etr_er + ' tbody').on('click', '.fa-eye', function() {
	$('#etr_er #container_emp_records').hide();
	$('#etr_er #container_emp_data').show();
	var fkemployee = $(this).data('id');
	fn_get_emp_training_record_by_fkemployee('frm_emp_info', fkemployee);
	if(dt_etr_trainings == '') {
		dt_etr_trainings = $('#'+tbl_etr_trainings).DataTable({
			"aaSorting"	 : [],	
			"bProcessing": true,
			"bServerSide": true,
			"pageLength" : 10,
			"sAjaxSource": "server_side_scripts/etr/dt_emp_trainings.php?fk_employee="+fkemployee,
			"drawCallback": function( settings ) {
				$('#'+tbl_etr_trainings).attr('style','width:100%;');
			}
		});
	} else {
		dt_etr_trainings.ajax.url("server_side_scripts/etr/dt_emp_trainings.php?fk_employee="+fkemployee ).load();
	}
});

$('#container_emp_data .fa-home').click(function() {
	$('#etr_er #container_emp_records').show();
	$('#etr_er #container_emp_data').hide();
});

$('input[name="emp_type"]').click(function() {
	dt_etr_er.ajax.url("server_side_scripts/etr/dt_etr_emp_records.php?db="+$('input[name="emp_type"]:checked').val() + "&search_by="+$('#search_by').val() + "&search_for="+$('#search_for').val() ).load();
});

$('select[name="search_by"]').change(function() {
	if($(this).val() == 'EmpName') {
		$('input[name="search_for"]').attr("placeholder", "Lastname, Firstname Middlename");
	} else {
		$('input[name="search_for"]').attr("placeholder", "-Type/Select here-");
	}
	dt_etr_er.ajax.url("server_side_scripts/etr/dt_etr_emp_records.php?db="+$('input[name="emp_type"]:checked').val() + "&search_by="+$('#search_by').val() + "&search_for="+$('#search_for').val() ).load();
});

$('input[name="search_for"]').keyup(function(e){
	var pattern 	= $(this).val();
	var search_by 	= $('select[name="search_by"]').val();
	var db		 	= $('input[name="emp_type"]:checked').val();
	if(search_by == 'EmpNo') {
		fn_return_search_for_lists('return_empno_list', 'dl_search_for', pattern, db);
	} else if(search_by == 'EmpName') {
		fn_return_search_for_lists('return_empname_list', 'dl_search_for', pattern, db);
	} else if(search_by == 'FirstName') {
		fn_return_search_for_lists('return_firstname_list', 'dl_search_for', pattern, db);
	} else if(search_by == 'LastName') {
		fn_return_search_for_lists('return_lastname_list', 'dl_search_for', pattern, db);
	} else if(search_by == 'MiddleName') {
		fn_return_search_for_lists('return_middlename_list', 'dl_search_for', pattern, db);
	} else if(search_by == 'Position') {
		fn_return_search_for_lists('return_position_list', 'dl_search_for', pattern, db);
	} else if(search_by == 'Department') {
		fn_return_search_for_lists('return_department_list', 'dl_search_for', pattern, db);
	} else {
		$('#dl_search_for').empty();
	}
});

$('input[name="search_for"]').keyup(function() {
	dt_etr_er.ajax.url("server_side_scripts/etr/dt_etr_emp_records.php?db="+$('input[name="emp_type"]:checked').val() + "&search_by="+$('#search_by').val() + "&search_for="+$('#search_for').val() ).load();
});

function fn_get_emp_training_record_by_fkemployee(frm_id, fk_employee) {
	var data = {
		"action"		: "return_emp_info",
		"fk_employee"	: fk_employee
	}
	call_ajax(data, common_handler, function(result){	
		$.each(result['data'], function(key, value) {
			$('#'+frm_id+' input[name="'+key+'"]').val(value);
		});
	});
}

/* ***************************
	ETR Employee Records - End
*************************** */

/* ***************************
	ETR Training Records - Start
*************************** */
var tbl_etr_tr    	= 'tbl_etr_tr';
var dt_etr_tr 		= '';
var mdl_cert_ope   	= 'modal_etr_certified_operators';
var frm_cert_ope	= 'frm_etr_certified_operators';

dt_etr_tr = $('#'+tbl_etr_tr).DataTable({
	"aaSorting"	 : [],	
	"bProcessing": true,
	"bServerSide": true,
	"pageLength" : 25,
	"sAjaxSource": "server_side_scripts/etr/dt_etr_training_records.php",
	"drawCallback": function( settings ) {
		$('#'+tbl_etr_tr).attr('style','width:100%;');
	}
});

$('#' + tbl_etr_tr + ' tbody').on('click', 'tr .fa-eye', function() {
	var pkid 	= $(this).attr('id');
	var row 	= $(this).closest('tr');
	fn_return_certified_operators(frm_cert_ope, pkid);
	$('#'+mdl_cert_ope).data('id', pkid);
	$('#'+mdl_cert_ope).modal();
});

$('select[name="group_by"]').change(function() {
	var group_by_val = $('#group_by_val').val();
	if($('#group_by').val() == 'station_to') {
		var group_by = "(SELECT station_to FROM tbl_etr_training_employees WHERE tbl_etr_training.pkid = tbl_etr_training_employees.fketr AND station_to LIKE '%"+group_by_val+"%' LIMIT 0,1)";
	} else {
		var group_by = $('#group_by').val();
	}
	dt_etr_tr.ajax.url("server_side_scripts/etr/dt_etr_training_records.php?group_by="+ group_by + "&group_by_val="+group_by_val ).load();
});

$('input[name="group_by_val"]').keyup(function() {
	var group_by_val = $('#group_by_val').val();
	if($('#group_by').val() == 'station_to') {
		var group_by = "(SELECT station_to FROM tbl_etr_training_employees WHERE tbl_etr_training.pkid = tbl_etr_training_employees.fketr AND station_to LIKE '%"+group_by_val+"%' LIMIT 0,1)";
	} else {
		var group_by = $('#group_by').val();
	}
	dt_etr_tr.ajax.url("server_side_scripts/etr/dt_etr_training_records.php?group_by="+ group_by + "&group_by_val="+group_by_val ).load();
});

$('#btn_export_training_records').click(function() {
	var group_by 		= $('#group_by').val();
	var group_by_val 	= $('#group_by_val').val();
	var date_from 		= $('#date_from').val();
	var date_to 		= $('#date_to').val();
	if(date_from != '' && date_to != '') {
		window.location.href = 'reports/etr/excel_etr_qualified_operators_date.php?group_by='+group_by+'&group_by_val='+group_by_val+'&date_from='+date_from+'&date_to='+date_to;
	} else {
		window.location.href = 'reports/etr/excel_etr_training_records.php?group_by='+group_by+'&group_by_val='+group_by_val+'&date_from='+date_from+'&date_to='+date_to;
	}
});

$('#btn_export_cert_operators').click(function() {
	var pkid 		= $('#'+mdl_cert_ope).data('id');
	window.location.href = 'reports/etr/excel_etr_qualified_operators.php?id='+pkid;
});

function fn_return_certified_operators(frm_id, pkid) {
	var data = {
		"action"	: "return_certified_operators",
		"pkid"		: pkid
	}
	call_ajax(data, handler_etr, function(result){	
		$('#'+frm_id+' #series_name').val(result['series_name']);
		$('#'+frm_id+' #station_to').val(result['station_to']);
		$('#'+frm_id+' #tbl_operator_list tbody').empty();
		$('#'+frm_id+' #tbl_operator_list tbody').append(result['tbl_body']);
	});
}

/* ***************************
	ETR Training Records - End
*************************** */

/* ***************************
	ETR Data Common Functions - Start
*************************** */

var mdl_cancel = 'modal_etr_cancel';
var frm_cancel = 'frm_etr_cancel';

/* $('#'+frm_engr_edit).submit(function(e){
    e.preventDefault(); 
	$('#'+frm_engr_edit+' #container_etr_engineering_new_message').hide();
	var serialized_data = $(this).serialize();
	// fn_add_engr_training(serialized_data, 'FOR QC QUALIFICATION', mdl_engr_edit, frm_engr_edit); 
	fn_add_engr_training(serialized_data, 'FOR ENGR CHECKING', mdl_engr_edit, frm_engr_edit); 
}); */

function fn_etr_reload_datatables() {
	dt_etr_prdn.ajax.reload();
	dt_etr_prdn_app.ajax.reload();
	dt_etr_engr.ajax.reload();
	dt_etr_engr_app.ajax.reload();
	dt_etr_qc.ajax.reload();
	dt_etr_qc_app.ajax.reload();
	dt_etr_th.ajax.reload();
}

function fn_return_etr_training_title_lists(datalist_id, pattern) {
	var data = {
		"action"	: "return_etr_training_title_lists",
		"pattern"	: pattern
	}
	call_ajax(data, handler_etr, function(result){	
		$('#'+datalist_id).empty();
		$('#'+datalist_id).append(result['html_select']);
	});
}

function fn_return_etr_training_objective_by_title(frm_id, title_id) {
	var data = {
		"action"		: "return_etr_training_objective_by_title",
		"title_id"		: title_id
	}
	call_ajax(data, handler_etr, function(result){	
		console.log(result);
		$('#'+frm_id+' textarea[name="training_objective"]').text(result['objective']);
	});
}

function fn_return_etr_training_mechanics_lists(datalist_id, pattern)  {
	var data = {
		"action"	: "return_etr_training_mechanics_lists",
		"pattern"	: pattern
	}
	call_ajax(data, handler_etr, function(result){	
		$('#'+datalist_id).empty();
		$('#'+datalist_id).append(result['html_select']);
	});
}

function fn_return_etr_type_training_lists(datalist_id, pattern)  {
	var data = {
		"action"	: "return_etr_type_training_lists",
		"pattern"	: pattern
	}
	call_ajax(data, handler_etr, function(result){	
		$('#'+datalist_id).empty();
		$('#'+datalist_id).append(result['html_select']);
	});
}

function fn_return_etr_venue_lists(datalist_id, pattern)  {
	var data = {
		"action"	: "return_etr_venue_lists",
		"pattern"	: pattern
	}
	call_ajax(data, handler_etr, function(result){	
		$('#'+datalist_id).empty();
		$('#'+datalist_id).append(result['html_select']);
	});
}

function fn_return_reason_certification_lists(div_id)  {
    $('#'+div_id).empty();
	var data = {
		"action"	: "return_reason_certification_lists"
	}
	call_ajax(data, handler_etr, function(result){	console.log(result);
		$('#'+div_id).show();
		$('#'+div_id).append(result['html_chkbox']);
        
        $('#'+frm_prdn_new+' #container_reason_certification input[type="checkbox"]').click(function() {
            if(($(this).is(':checked')) && $(this).val() == 5) {
                $('#'+mdl_prdn_new+' #container_reason_certification_others').show();
            } else if((!$(this).is(':checked')) && $(this).val() == 5) {
                $('#'+mdl_prdn_new+' #container_reason_certification_others').hide();
            }
        });
	});
}

function fn_return_training_category_lists(div_id)  {
    $('#'+div_id).empty();
	var data = {
		"action"	: "return_training_category_lists"
	}
	call_ajax(data, handler_etr, function(result){	
		$('#'+div_id).show();
		$('#'+div_id).append(result['html_chkbox']);
	});
}

function fn_get_emp_no_by_operator_name(empname, mdl_id, frm_id)  {
	var data = {
		"action"	: "get_emp_no_by_operator_name",
		"empname"	: empname
	}
	call_ajax(data, handler_etr, function(result){	
        assign_value_select2('#'+frm_id+' #operator_en',result['data']['empno']);
        re_initialize_select2_server_side('#'+mdl_id+' #tbl_operator_list #operator_en','#'+mdl_id+' #'+frm_id,[],"server_side_scripts/dropdown/common/dd_operator_en_list.php");
	});
}

function fn_get_emp_name_by_operator_empno(empno, mdl_id, frm_id)  {
	var data = {
		"action"  : "get_emp_name_by_operator_empno",
		"empno"	  : empno
	}
	call_ajax(data, handler_etr, function(result){	
		assign_value_select2('#'+frm_id+' #operator_name',result['data']['empname']);	
        re_initialize_select2_server_side('#'+mdl_id+' #tbl_operator_list #operator_name','#'+mdl_id+' #'+frm_id,[],"server_side_scripts/dropdown/common/dd_operator_list.php");
	});
}

function fn_return_operator_lists(pkid) {
	$('#'+mdl_view_ope+' #div_view_operator_list').empty();
	var data = {
		"action"  : "return_operator_lists",
		"pkid"	  : pkid
	}
	call_ajax(data, handler_etr, function(result){	
		$('#'+mdl_view_ope+' #div_view_operator_list').append(result['tbl_data']);
		$('#'+mdl_view_ope).modal();
	});
}

function fn_return_search_for_lists(action, datalist_id, pattern, db) {
	var data = {
		"action"	: action,
		"db"		: db,
		"pattern"	: pattern
	}
	call_ajax(data, handler_etr, function(result){	
		$('#'+datalist_id).empty();
		$('#'+datalist_id).append(result['html_select']);
	});
}


/* ***************************
	
*************************** */
/* ***************************
	ETR Data Common Functions - End
*************************** */