var dt_examinee 			= '';
var tbl_examinee 			= 'tbl_examinee';
var mdl_new_exam 			= 'mdl_new_exam';
var frm_new_exam 			= 'frm_new_exam';
var mdl_exam_confirmation 	= 'mdl_exam_confirmation';
var frm_exam_confirmation 	= 'frm_exam_confirmation';

dt_examinee = $('#'+tbl_examinee).DataTable({
	"aaSorting"	 : [],
	"bProcessing": true,
	"bServerSide": true,
	"sAjaxSource": "server_side_scripts/ccte/dt_ccte_examinee.php?username="+username,
	"drawCallback": function( settings ) {
		$('#'+tbl_examinee).attr('style','width:100%;');
	}
});

$('#btn_new_exam').click(function() {
	fn_return_empno_by_username(frm_new_exam);
	$('#'+mdl_new_exam).modal('show');
});

$('#'+frm_new_exam+' .fa-save').click(function() {
	var serialized_data = $('#'+frm_new_exam).serialize();
		
	var data = {
		"action" 	      : "save_exam",
		"status" 		  : 'DRAFT',
		"username" 		  : username,
	}
	fn_save_exam(data, serialized_data, mdl_new_exam);
});

$('#'+frm_new_exam).on('submit', function(e) {
	e.preventDefault();
	$('#'+mdl_exam_confirmation).modal('show');
});	

$('#'+frm_exam_confirmation).on('submit', function(e) {
	e.preventDefault();
	$('#'+mdl_exam_confirmation).modal('hide');
	$('.btn').prop("disabled",true);
	
	var serialized_data = $('#'+frm_new_exam).serialize();
		
	var data = {
		"action" 	      : "save_exam",
		"status" 		  : 'FOR CHECKING',
		"username" 		  : username,
	}
	fn_save_exam(data, serialized_data, mdl_new_exam);
});	

function fn_save_exam(data, serialized_data, modal_id) {
	call_ajax_serialize(data,serialized_data,handler_ccte,function(result){
		$('#'+modal_id).modal('hide');
		$('#modal_system_message').modal();
		$('#container_message').attr('class','alert alert-success');
		$('#container_message').html( '<h4>'+result['msg']+'</h4>' );
		$('.btn').prop("disabled",false);
		fn_reload_ccte_datatables();
	});
}

/* Edit Examinee */
var mdl_edit_exam = 'mdl_edit_exam';
var frm_edit_exam = 'frm_edit_exam';

$('#'+tbl_examinee+' tbody').on('click', 'tr .fa-edit', function() {
	var pkid = $(this).data('id');
	$('#'+mdl_edit_exam).data('id', pkid);
	fn_return_exam_details(pkid, mdl_edit_exam, frm_edit_exam);
});

$('#'+frm_edit_exam+' .fa-save').click(function() {
	var serialized_data = $('#'+frm_edit_exam).serialize();
	fn_update_exam(serialized_data, frm_edit_exam, mdl_edit_exam, 'DRAFT');
});

$('#'+frm_edit_exam).on('submit', function(e) {
	e.preventDefault();
	var serialized_data = $(this).serialize();
	fn_update_exam(serialized_data, frm_edit_exam, mdl_edit_exam, 'FOR CHECKING');
});	

/* View Examinee */
var mdl_view_exam = 'mdl_view_exam';
var frm_view_exam = 'frm_view_exam';

$('#'+tbl_examinee+' tbody').on('click', 'tr .fa-eye', function() {
	var pkid = $(this).data('id');
	$('#'+mdl_view_exam).data('id', pkid);
	// fn_return_exam_details(pkid, mdl_view_exam, frm_view_exam);
	
	var status = $(this).closest('tr').find('td:eq(0)').text();
	if(status == 'DRAFT' || status == 'FOR CHECKING') {
		fn_return_exam_details(pkid, mdl_view_exam, frm_view_exam);
	} else {
		fn_return_exam_details(pkid, mdl_admin_view, frm_admin_view);
	}
});


/* Admin start */
var dt_admin 		= '';
var tbl_admin 		= 'tbl_admin';
var mdl_admin_check = 'mdl_admin_checking';
var frm_admin_check = 'frm_admin_checking';
var mdl_check_confirmation 	= 'mdl_check_confirmation';
var frm_check_confirmation 	= 'frm_check_confirmation';

dt_admin = $('#'+tbl_admin).DataTable({
	"aaSorting"	 : [],
	"bProcessing": true,
	"bServerSide": true,
	"sAjaxSource": "server_side_scripts/ccte/dt_ccte_admin.php?username="+username,
	"drawCallback": function( settings ) {
		$('#'+tbl_admin).attr('style','width:100%;');
	}
});

$('#'+tbl_admin+' tbody').on('click', 'tr .fa-check', function() {
	var pkid = $(this).data('id');
	$('#'+mdl_admin_check).data('id', pkid);
	fn_return_exam_details(pkid, mdl_admin_check, frm_admin_check);
});

$('#'+frm_admin_check+' #series_name_score').on('change', function() {
	fn_validate_score(frm_admin_check, 'series_name_score', 'series_name_points');
});

$('#'+frm_admin_check+' #defect_score').on('change', function() {
	fn_validate_score(frm_admin_check, 'defect_score', 'defect_points');
});

$('#'+frm_admin_check+' #brief_desc_score').on('change', function() {
	fn_validate_score(frm_admin_check, 'brief_desc_score', 'brief_desc_points');
});

$('#'+frm_admin_check+' #state_score').on('change', function() {
	fn_validate_score(frm_admin_check, 'state_score', 'state_points');
});

$('#'+frm_admin_check).on('submit', function(e) {
	e.preventDefault();
	$('#'+mdl_check_confirmation).modal('show');
});

$('#'+frm_check_confirmation).on('submit', function(e) {
	e.preventDefault();
	$('#'+mdl_check_confirmation).modal('hide');
	var serialized_data = $('#'+frm_admin_check).serialize();
	fn_update_exam(serialized_data, frm_admin_check, mdl_admin_check, 'CHECKED');
});

function fn_update_exam(serialized_data, frm_id, mdl_id, status) {
	// $('.btn').prop("disabled",true);
	var data = {
		"action"	: "update_exam",
		"pkid"		: $('#'+mdl_id).data('id'),
		"status"	: status,
		"username"	: username
	}
	call_ajax_serialize(data, serialized_data, handler_ccte, function(result){
		console.log(result);
		$('#'+mdl_id).modal('hide');
		$('#modal_system_message').modal();
		$('#container_message').attr('class','alert alert-success');
		$('#container_message').html( '<h4>'+result['msg']+'</h4>' );
		$('.btn').prop("disabled",false);
		fn_reload_ccte_datatables();
	});
}
function fn_validate_score(frm_id, txt_score, txt_overall) {
	$('#'+frm_id + ' #' + txt_score).prop('max', $('#'+frm_id + ' #' + txt_overall).val());
	
	if(parseInt($('#'+frm_id + ' #' + txt_score).val()) > $('#'+frm_id + ' #' + txt_overall).val()) {
		$('#'+frm_id + ' #total_score').val('-');
	} else {
		var total_score = 0;
		var total_overall = $('#'+frm_id + ' #total_overall').val();
		$('#'+frm_id+' input[name*=_score]').each(function() {
			total_score += parseInt($(this).val());
			if(total_score > total_overall) {
				$('#'+frm_id + ' #total_score').val('-');
			} else {
				$('#'+frm_id + ' #total_score').val(total_score);
			}
		});
	}	
}



/* View Examinee */
var mdl_admin_view = 'mdl_admin_view';
var frm_admin_view = 'frm_admin_view';

$('#'+tbl_admin+' tbody').on('click', 'tr .fa-eye', function() {
	var pkid = $(this).data('id');
	var status = $(this).closest('tr').find('td:eq(0)').text();
	$('#'+mdl_admin_view).data('id', pkid);
	if(status == 'FOR CHECKING') {
		fn_return_exam_details(pkid, mdl_view_exam, frm_view_exam);
	} else {
		fn_return_exam_details(pkid, mdl_admin_view, frm_admin_view);
	}
});

function fn_return_empno_by_username(frm_id) {
	var data = {
		"action"	: "return_empno_by_username",
		"username"	: username
	}
	call_ajax(data, handler_ccte, function(result){
		$('#'+frm_id+' #empno').val(result['empno']);
	});
}

function fn_return_exam_details(pkid, mdl_id, frm_id) {
	var data = {
		"action"	: "return_exam_details",
		"pkid"		: pkid
	}
	call_ajax(data, handler_ccte, function(result){
		console.log(result);
		var total_score  = 0;
		var total_points = 0;
		$.each(result['data'], function(key, value) {
			$('#'+frm_id+' input[name="'+key+'"]').val(value);
			$('#'+frm_id+' textarea[name="'+key+'"]').val(value);
			
			if(key.indexOf('_score') != -1) {
				total_score += parseInt(value);
			}
		});
		$('#'+frm_id+' #total_score').val( total_score );
		
		$.each(result['points'], function(key, value) {
			$('#'+frm_id+' input[name="'+key+'"]').val(value);
			
			if(key.indexOf('_points') != -1) {
				total_points += parseInt(value);
			}
		});
		$('#'+frm_id+' #total_points').val( total_points );
		$('#'+mdl_id).modal('show');
	});
}

function fn_reload_ccte_datatables() {
	dt_examinee.ajax.reload(null, false);
	dt_admin.ajax.reload(null, false);
}