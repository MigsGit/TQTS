/* **************************************************
	ITN Report - Start
/***************************************************/
var dt_itn = $('#tbl_itn').DataTable({
	"aaSorting"	: [],
	"bProcessing": true,
	"bServerSide": true,
	"sAjaxSource": 'server_side_scripts/qr/dt_itn_originator.php?username='+username,
	"drawCallback": function( settings ) {
		$('#tbl_itn').attr('style','width:100%;');
	}
});

var dt_lqc_supervisor = $('#tbl_itn_lqc_supervisor').DataTable({
	"aaSorting"	: [],
	"bProcessing": true,
	"bServerSide": true,
	"sAjaxSource": 'server_side_scripts/qr/dt_itn_lqc_supervisor.php?username='+username,
	"drawCallback": function( settings ) {
		$('#tbl_itn_lqc_supervisor').attr('style','width:100%;');
	}
});

var dt_engineering_production_supervisor = $('#tbl_itn_engineering_production_supervisor').DataTable({
	"aaSorting"	: [],
	"bProcessing": true,
	"bServerSide": true,
	"sAjaxSource": 'server_side_scripts/qr/dt_engineering_production_supervisor.php?username='+username,
	"drawCallback": function( settings ) {
		$('#tbl_itn_engineering_production_supervisor').attr('style','width:100%;');
	}
});


/* ***************************************
			ITN New - Start
*************************************** */
/* Select2 */
$('document').ready(function(){
	var modal_id = 'modal_qfr_itn_new';
	var frm_id   = 'frm_qfr_itn_new';
	re_initialize_select2_server_side("#"+modal_id+" #cmb_attn",$("#"+modal_id+" #"+frm_id),[],"server_side_scripts/dropdown/iqc/qar_to_recipient.php");
	re_initialize_select2_server_side("#"+modal_id+" select[name='fp_inspected_by']",$("#"+modal_id+" #"+frm_id),[],"server_side_scripts/dropdown/common/dd_hris_pmi_and_subcon_list.php");
	re_initialize_select2_server_side("#"+modal_id+" select[name='fp_verfied_by']",$("#"+modal_id+" #"+frm_id),[],"server_side_scripts/dropdown/common/dd_hris_pmi_and_subcon_list.php");
	re_initialize_select2_server_side("#"+modal_id+" select[name='fp_conformed_by[]']",$("#"+modal_id+" #"+frm_id),[],"server_side_scripts/dropdown/common/dd_hris_pmi_and_subcon_list.php");
	re_initialize_select2_server_side("#"+modal_id+" select[name='a_validated_by[]']",$("#"+modal_id+" #"+frm_id),[],"server_side_scripts/dropdown/common/dd_hris_pmi_and_subcon_list.php");
	re_initialize_select2_server_side("#"+modal_id+" select[name='ca_responsible[]']",$("#"+modal_id+" #"+frm_id),[],"server_side_scripts/dropdown/common/dd_hris_pmi_and_subcon_list.php");
	re_initialize_select2_server_side("#"+modal_id+" select[name='rc_responsible[]']",$("#"+modal_id+" #"+frm_id),[],"server_side_scripts/dropdown/common/dd_hris_pmi_and_subcon_list.php");
});


$('#btn_qfr_itn_new').click(function(){
	var modal_id = 'modal_qfr_itn_new';
	var frm_id   = 'frm_qfr_itn_new';
	fn_get_control_no_itn_display(modal_id);
	var itn_required_fields = [
		"attention","project","lot_no",
		"model","date_time","station",
		"sample","name","ac_re",
		"reference","issuance_date","lot_qty",
		"return_date"
	]
	fn_add_required_fields(frm_id,itn_required_fields);
	var array_div_id = ['div_analysis','div_corrective_action','div_result_of_confirmation'];
	$.each(array_div_id,function(div_key,div_id){
		$('#' + frm_id + ' div#' + div_id + ' input[type="date"]').prop('disabled',true);
		$('#' + frm_id + ' div#' + div_id + ' textarea').prop('disabled',true);
	});
	re_initialize_select2_server_side('#'+modal_id+' select[name="fp_inspected_by"]','#'+modal_id+' #'+frm_id,[],"server_side_scripts/dropdown/common/dd_hris_pmi_and_subcon_list.php");
	// assign_value_select2_by_username('#' + frm_id + ' select[name="fp_inspected_by"]',username);
	// assign_value_select2_by_username('#' + frm_id + ' select[name="fp_conformed_by"]',username);
	var ajax_url = "server_side_scripts/dropdown/iqc/qar_to_recipient.php";
	$('#'+modal_id).modal('show');
});

$('#frm_qfr_itn_new').submit(function(e){
	e.preventDefault();
	var serialized_data = $(this).serialize();
	fn_save_itn(serialized_data);
});

$('#tbl_itn tbody').on('click', 'tr .fa-eye', function(){
	var modal_id = 'modal_itn_view_edit';
	var pkid = $(this).closest('tr').find('td:eq(0) span').attr('id');
	var control_no = $(this).closest('tr').find('td:eq(1)').text();
	$('#' + modal_id + ' span#span_ctrl_no').text(control_no);
	$('#' + modal_id).data('id',pkid);
	$('#' + modal_id + ' #error_message').hide();
	fn_get_itn_details(pkid, 'frm_itn_view_edit', 'view');
	$('#modal_itn_view_edit').modal('show');
});

$('#tbl_itn tbody').on('click', 'tr .fa-edit', function(){
	var modal_id = 'modal_itn_view_edit';
	var pkid = $(this).closest('tr').find('td:eq(0) span').attr('id');
	var control_no = $(this).closest('tr').find('td:eq(1)').text();
	$('#' + modal_id + ' span#span_ctrl_no').text(control_no);
	$('#' + modal_id).data('id',pkid);
	$('#' + modal_id + ' #error_message').hide();
	fn_get_itn_details(pkid, 'frm_itn_view_edit','edit_originator');
	$('#modal_itn_view_edit').modal('show');
});

$('#frm_itn_view_edit').submit(function(e){
	e.preventDefault();
	var serialized_data = $(this).serialize();
	fn_update_itn(serialized_data);
});

$('#tbl_itn tbody').on('click', 'tr .fa-remove,tr .fa-check', function(){
	var pkid = $(this).closest('tr').find('td:eq(0) span').attr('id');
	var status = $(this).closest('tr').find('td:eq(0) span').text();
	var control_no = $(this).closest('tr').find('td:eq(1)').text();
	$('#modal_itn_change_status').data('id',pkid);
	$('#modal_itn_change_status').data('status',status);
	if(status == 'Open'){
		var message = 'Do you want to close ITN '+control_no;
	}else{
		var message = 'Do you want to re-open ITN '+control_no;
	}
	$('#modal_itn_change_status .modal-body p').empty();
	$('#modal_itn_change_status .modal-body p').append(message);
	$('#modal_itn_change_status').modal('show');
});

function fn_get_control_no_itn_display(modal_id){
	var data = {
		"action"	: "get_control_no_itn_display",
		"username"	: username
	}
	call_ajax(data, handler_qfr_itn, function(result){
		if(result['error'] != ''){
			$('#'+modal_id+' #error_message').show();
			$('#'+modal_id+' #error_message div').empty();
			$('#'+modal_id+' #error_message div').append('<p>Error Message:</p>');
			$('#'+modal_id+' #error_message div').append('<p>'+result['error']+'</p>');
			return false;
		}
		$('#'+modal_id+' #span_ctrl_no').text(result['control_no']);
	});
}

function fn_save_itn(serialized_data){
	$('#frm_itn_new #error_message').hide();
	var data = {
		"action"	: "save_itn",
		"username"	: username
	}
	call_ajax_serialize(data, serialized_data, handler_qfr_itn, function(result){
		console.log(result);
		// $('.modal').modal('hide');
		var modal_id 		= 'modal_qfr_itn_system_message';
		if( result['error'].length != 0 ){
			$('#frm_itn_new #error_message').show();
			$('#frm_itn_new #error_message div').empty();
			$('#frm_itn_new #error_message div').append('<p>Error Message:</p>');
			$.each(result['error'], function(key,value){
				$.each(result['error'][key], function(key2,value2){
					$('#frm_itn_new #error_message div').append('<p>'+value2+'</p>');
				});
			});
			return false;
		} else {
			$('#'+modal_id+' #div_system_message').empty();
			/* Add a an alert success class */
			$('#'+modal_id+' #div_system_message').attr("class","alert alert-success");
			/* Append system message */
			$('#'+modal_id+' #div_system_message').append("<p>"+result['mail_data']['mail_result']+"</p>");
			$('#'+modal_id+'').modal('show');
		}		
		dt_itn.ajax.reload(null, false);
		dt_lqc_supervisor.ajax.reload(null, false);
		dt_engineering_production_supervisor.ajax.reload(null, false);
		var modal_id = "modal_qfr_itn_new";
		// $('#' + modal_id + ' input').val("");
		// $('#' + modal_id + ' textarea').val("");
		// $('#' + modal_id + ' select').val("");
		// $('#' + modal_id + ' select').val([]).trigger('change');
	});
}

function fn_get_itn_details(pkid,frm_id,type){
	var data = {
		"action"	: "get_itn_details",
		"username"	: username,
		"pkid"		: pkid
	}
	call_ajax(data, handler_qfr_itn, function(result){
		console.log(result);
		$('#btn_edit_itn').hide();
		$('#btn_save_itn_result_confirmation').hide();
		$.each(result,function(key,value){
			/* check if checkbox */
			if( $('#' + frm_id + ' input[name="'+key+'"]').attr('type') == 'checkbox' ){
				if(value == 1){
					$('#' + frm_id + ' input[name="'+key+'"]').prop('checked',true);
				}else{
					$('#' + frm_id + ' input[name="'+key+'"]').prop('checked',false);
				}
			}else{
				$('#' + frm_id + ' input[name="'+key+'"]').val(value);
				$('#' + frm_id + ' textarea[name="'+key+'"]').val(value);
				$('#' + frm_id + ' select[name="'+key+'"]').val(value);
				if( Array.isArray(value) ){
					if(key=="attention"){
						console.log(value);
					}
					assign_value_select2('#' + frm_id + ' select[name="'+key+'"]',value);
					var ajax_url = "server_side_scripts/dropdown/iqc/qar_to_recipient.php";
					var modal_id = $('#' + frm_id).closest('div[role="dialog"]').attr('id');
					re_initialize_select2_server_side('#' + frm_id + ' select[name="'+key+'"]', '#' + modal_id + ' #' + frm_id, '', ajax_url);
				}
			}
			if(type=="view"){
				$('#' + frm_id + ' input[name="'+key+'"]').prop('disabled',true);
				$('#' + frm_id + ' select[name="'+key+'"]').prop('disabled',true);
				$('#' + frm_id + ' textarea[name="'+key+'"]').prop('disabled',true);
				var modal_id = $('#' + frm_id).closest('div[role="dialog"]').attr('id');
				if(key == 'status' && value == '2'){
					var closest_div = $('#' + frm_id + ' textarea[name="result_confirmation"]').closest('div.row');
					closest_div.find('textarea[name="result_confirmation"]').prop('disabled',false);
					closest_div.find('textarea[name="result_confirmation"]').prop('required',true);
					$('#btn_edit_itn').hide();
					$('#btn_save_itn_result_confirmation').show();
				}
			}
			if(type=="edit_originator"){
				// $('#' + frm_id + ' button.fa-save').show();
				/* Disable Control No. */
				// $('#' + frm_id + ' textarea[name="control_no"]').prop('disabled',true);
				$('#' + frm_id + ' input[name="'+key+'"]').prop('disabled',false);
				$('#' + frm_id + ' textarea[name="'+key+'"]').prop('disabled',false);
				$('#' + frm_id + ' select[name="'+key+'"]').prop('disabled',false);
				var array_div_id = ['div_analysis','div_corrective_action','div_result_of_confirmation'];
				$.each(array_div_id,function(div_key,div_id){
					$('#frm_itn_view_edit div#' + div_id + ' input[type="date"]').prop('disabled',true);
					$('#' + frm_id + ' div#' + div_id + ' textarea[name="'+key+'"]').prop('disabled',true);
				});
				$('#btn_edit_itn').show();
			}
			if(type=="lqc_supervisor_approver"){
				$('#' + frm_id + ' input[name="'+key+'"]').prop('disabled',true);
				$('#' + frm_id + ' select[name="'+key+'"]').prop('disabled',true);
				$('#' + frm_id + ' textarea[name="'+key+'"]').prop('disabled',true);
				var modal_id = $('#' + frm_id).closest('div[role="dialog"]').attr('id');
				if(result['status'] == 0){
					$('#' + modal_id + ' button#btn_approve').prop('disabled',false);
					$('#' + modal_id + ' button#btn_disapprove').prop('disabled',false);
					$('#' + modal_id + ' button#btn_approve').show();					
					$('#' + modal_id + ' button#btn_disapprove').show();
				}else{
					$('#' + modal_id + ' button#btn_approve').prop('disabled',true);
					$('#' + modal_id + ' button#btn_disapprove').prop('disabled',true);
					$('#' + modal_id + ' button#btn_approve').hide();					
					$('#' + modal_id + ' button#btn_disapprove').hide();
				}
			}
			if(type=="engineering_production_supervisor"){
				$('#' + frm_id + ' input[name="'+key+'"]').prop('disabled',true);
				$('#' + frm_id + ' select[name="'+key+'"]').prop('disabled',true);
				$('#' + frm_id + ' textarea[name="'+key+'"]').prop('disabled',true);
				var modal_id = $('#' + frm_id).closest('div[role="dialog"]').attr('id');
				if(result['status'] == 1){
					var array_div_id = ['div_analysis','div_corrective_action'];
					$.each(array_div_id,function(div_key,div_id){
						$('#' + frm_id + ' div#' + div_id + ' textarea[name="'+key+'"]').prop('disabled',false);
						$('#' + frm_id + ' div#' + div_id + ' textarea[name="'+key+'"]').prop('required',true);
						$('#' + frm_id + ' div#' + div_id + ' textarea[name="'+key+'"]').prop('required',true);
						/* Remove the disabled in select for analysis and corrective action */
						$('#' + frm_id + ' #div_analysis select[name="'+key+'"]').prop('disabled',false);
						$('#' + frm_id + ' #div_corrective_action select[name="'+key+'"]').prop('disabled',false);
						$('#' + modal_id + ' button.fa-save').show();
					});
				}else{
					$('#' + modal_id + ' button.fa-save').hide();
				}
			}
		});
	});
}

function fn_update_itn(serialized_data){
	$('#frm_itn_new #error_message').hide();
	var data = {
		"action"	: "update_itn",
		"username"	: username,
		"pkid"		: $('#modal_itn_view_edit').data('id')
	}
	call_ajax_serialize(data, serialized_data, handler_qfr_itn, function(result){
		//console.log(result);
		$('.modal').modal('hide');
		var modal_id = 'modal_qfr_itn_system_message';
		$('#'+modal_id+' #div_system_message').empty();
		if(result['error'] !='' ){
			$('#'+modal_id+' #div_system_message').attr("class","alert alert-danger");
			$('#frm_itn_new #error_message').show();
			$('#frm_itn_new #error_message div').empty();
			$('#frm_itn_new #error_message div').append('<p>Error Message:</p>');
			$.each(result['error'], function(key,value){
				$.each(result['error'][key], function(key2,value2){
					$('#frm_itn_new #error_message div').append('<p>'+value2+'</p>');
				});
			});
			return false;
		} else {
			/* Add a an alert success class */
			$('#'+modal_id+' #div_system_message').attr("class","alert alert-success");
			/* Append system message */
			$('#'+modal_id+' #div_system_message').append("<p>"+result['msg']+"</p>");
		}
		$('#'+modal_id+'').modal('show');
		$('#modal_itn_view_edit').modal('hide');
		dt_itn.ajax.reload();
	});
}

function fn_itn_change_status(){
	var data = {
		"action"	: "change_status_itn",
		"username"	: username,
		"pkid"		: $('#modal_itn_change_status').data('id'),
		"status"	: $('#modal_itn_change_status').data('status')
	}
	call_ajax(data, handler_qfr_itn, function(result){
		$('.modal').modal('hide');
		dt_itn.ajax.reload();
	});
}


/* *******************************************************
******** 	 		LQC Supervisor				**********
*********************************************************/
$('document').ready(function(){
	// var modal_id = 'modal_qfr_itn_lqc_supervisor';
	// re_initialize_select2_server_side("#"+modal_id+" #cmb_attn",$("#"+modal_id+" #"+frm_id),[],"server_side_scripts/dropdown/iqc/qar_to_recipient.php");
	// re_initialize_select2_server_side("#"+modal_id+" select[name='fp_inspected_by']",$("#"+modal_id+" #"+frm_id),[],"server_side_scripts/dropdown/common/dd_hris_pmi_and_subcon_list.php");
	// re_initialize_select2_server_side("#"+modal_id+" select[name='fp_verfied_by']",$("#"+modal_id+" #"+frm_id),[],"server_side_scripts/dropdown/common/dd_hris_pmi_and_subcon_list.php");
	// re_initialize_select2_server_side("#"+modal_id+" select[name='fp_conformed_by']",$("#"+modal_id+" #"+frm_id),[],"server_side_scripts/dropdown/common/dd_hris_pmi_and_subcon_list.php");
	// re_initialize_select2_server_side("#"+modal_id+" select[name='a_validated_by']",$("#"+modal_id+" #"+frm_id),[],"server_side_scripts/dropdown/common/dd_hris_pmi_and_subcon_list.php");
	// re_initialize_select2_server_side("#"+modal_id+" select[name='ca_responsible']",$("#"+modal_id+" #"+frm_id),[],"server_side_scripts/dropdown/common/dd_hris_pmi_and_subcon_list.php");
	// re_initialize_select2_server_side("#"+modal_id+" select[name='rc_responsible']",$("#"+modal_id+" #"+frm_id),[],"server_side_scripts/dropdown/common/dd_hris_pmi_and_subcon_list.php");
});

$('#tbl_itn_lqc_supervisor tbody').on('click', 'tr .fa-eye', function(){
	var modal_id	= 'modal_qfr_itn_lqc_supervisor';
	var frm_id		= 'frm_qfr_itn_lqc_supervisor';
	var pkid = $(this).closest('tr').find('td:eq(0) span').attr('id');
	var control_no = $(this).closest('tr').find('td:eq(1)').text();
	$('#' + modal_id + ' span#span_ctrl_no').text(control_no);
	$('#' + modal_id).data('id',pkid);
	$('#' + modal_id + ' #error_message').hide();
	fn_get_itn_details(pkid,modal_id,'lqc_supervisor_approver');
	$('#' + modal_id).modal('show');
});

$('#modal_qfr_itn_lqc_supervisor button#btn_approve').click(function(){
	var modal_id = 'modal_qfr_itn_lqc_supervisor_update_status';
	$('#' + modal_id).data('status','1');
	$('#' + modal_id).find('b#b_decision').text('Approve');
	$('#' + modal_id).find('button.btn-primary').text(' Approve');
	$('#' + modal_id).find('textarea').prop('required',false);
	$('#' + modal_id).modal('show');
});

$('#modal_qfr_itn_lqc_supervisor button#btn_disapprove').click(function(){
	var modal_id = 'modal_qfr_itn_lqc_supervisor_update_status';
	$('#' + modal_id).data('status','2');
	$('#' + modal_id).find('b#b_decision').text('Disapprove');
	$('#' + modal_id).find('button.btn-primary').text(' Disapprove');
	$('#' + modal_id).find('textarea').prop('required',true);
	$('#' + modal_id).modal('show');
});

$('#frm_qfr_itn_lqc_supervisor_update_status').submit(function(e){
	e.preventDefault();
	var modal_id = '';
	var serialized_data = $(this).serialize();
	fn_lqc_supervisor_update_status(serialized_data);
});

function fn_lqc_supervisor_update_status(serialized_data){
	var data = {
		"action"	: "lqc_supervisor_update_status",
		"pkid"		: $('#modal_qfr_itn_lqc_supervisor').data('id'),
		"status"	: $('#modal_qfr_itn_lqc_supervisor_update_status').data('status'),
		"username"	: username
	}
	call_ajax_serialize( data, serialized_data, handler_qfr_itn, function(result){
		console.log(result);
		$('.modal').modal('hide');
		var modal_id = 'modal_qfr_itn_system_message';
		$('#'+modal_id+' #div_system_message').empty();
		/* Add a an alert success class */
		$('#'+modal_id+' #div_system_message').attr("class","alert alert-success");
		/* Append system message */
		$('#'+modal_id+' #div_system_message').append("<p>"+result['mail_data']['mail_result']+"</p>");
		$('#'+modal_id+'').modal('show');
		dt_itn.ajax.reload(null, false);
		dt_lqc_supervisor.ajax.reload(null, false);
		dt_engineering_production_supervisor.ajax.reload(null, false);
	});
}

/* *******************************************************
********  Engineering / Production Supervisor	**********
*********************************************************/
$('document').ready(function(){
	// var modal_id 	= 'modal_qfr_itn_engineering_production_supervisor';
	// var frm_id 		= 'frm_qfr_itn_engineering_production_supervisor';
	// re_initialize_select2_server_side("#"+modal_id+" #cmb_attn",$("#"+modal_id+" #"+frm_id),[],"server_side_scripts/dropdown/iqc/qar_to_recipient.php");
	// re_initialize_select2_server_side("#"+modal_id+" select[name='fp_inspected_by']",$("#"+modal_id+" #"+frm_id),[],"server_side_scripts/dropdown/common/dd_hris_pmi_and_subcon_list.php");
	// re_initialize_select2_server_side("#"+modal_id+" select[name='fp_verfied_by']",$("#"+modal_id+" #"+frm_id),[],"server_side_scripts/dropdown/common/dd_hris_pmi_and_subcon_list.php");
	// re_initialize_select2_server_side("#"+modal_id+" select[name='fp_conformed_by']",$("#"+modal_id+" #"+frm_id),[],"server_side_scripts/dropdown/common/dd_hris_pmi_and_subcon_list.php");
	// re_initialize_select2_server_side("#"+modal_id+" select[name='a_validated_by']",$("#"+modal_id+" #"+frm_id),[],"server_side_scripts/dropdown/common/dd_hris_pmi_and_subcon_list.php");
	// re_initialize_select2_server_side("#"+modal_id+" select[name='ca_responsible']",$("#"+modal_id+" #"+frm_id),[],"server_side_scripts/dropdown/common/dd_hris_pmi_and_subcon_list.php");
	// re_initialize_select2_server_side("#"+modal_id+" select[name='rc_responsible']",$("#"+modal_id+" #"+frm_id),[],"server_side_scripts/dropdown/common/dd_hris_pmi_and_subcon_list.php");
});

$('#tbl_itn_engineering_production_supervisor tbody').on('click', 'tr .fa-eye', function(){
	var modal_id	= 'modal_qfr_itn_engineering_production_supervisor';
	var frm_id		= 'frm_qfr_itn_engineering_production_supervisor';
	var pkid = $(this).closest('tr').find('td:eq(0) span').attr('id');
	var control_no = $(this).closest('tr').find('td:eq(1)').text();
	$('#' + modal_id + ' span#span_ctrl_no').text(control_no);
	$('#' + modal_id).data('id',pkid);
	$('#' + modal_id + ' #error_message').hide();
	fn_get_itn_details(pkid,frm_id,'engineering_production_supervisor');
	$('#' + modal_id).modal('show');
});


$('#frm_qfr_itn_engineering_production_supervisor').submit(function(e){
	e.preventDefault();
	var modal_id = $(this).closest('div[role="dialog"]').attr('id');
	var serialized_data = $(this).serialize();
	fn_engineering_production_supervisor_update_status(serialized_data);
});

function fn_engineering_production_supervisor_update_status(serialized_data){
	var data = {
		"action"	: "engineering_production_supervisor_update_status",
		"pkid"		: $('#modal_qfr_itn_engineering_production_supervisor').data('id'),
		"username"	: username
	}
	call_ajax_serialize( data, serialized_data, handler_qfr_itn, function(result){
		console.log(result);
		$('.modal').modal('hide');
		var modal_id = 'modal_qfr_itn_system_message';
		$('#'+modal_id+' #div_system_message').empty();
		/* Add a an alert success class */
		$('#'+modal_id+' #div_system_message').attr("class","alert alert-success");
		/* Append system message */
		$('#'+modal_id+' #div_system_message').append("<p>"+result['mail_data']['mail_result']+"</p>");
		$('#'+modal_id+'').modal('show');
		dt_itn.ajax.reload(null, false);
		dt_lqc_supervisor.ajax.reload(null, false);
		dt_engineering_production_supervisor.ajax.reload(null, false);
	});
}

/* *******************************************************
*******  LQC / Originator Result of Confirmation  ********
*********************************************************/
$('#modal_itn_view_edit #btn_save_itn_result_confirmation').click(function(e){
	var modal_id = $(this).closest('div[role="dialog"]').attr('id');
	var serialized_data = $('#frm_itn_view_edit').serialize();
	console.log(serialized_data);
	fn_lqc_result_of_confirmation_update_status(serialized_data);
});

function fn_lqc_result_of_confirmation_update_status(serialized_data){
	var data = {
		"action"	: "lqc_result_of_confirmation_update_status",
		"pkid"		: $('#modal_itn_view_edit').data('id'),
		"username"	: username
	}
	call_ajax_serialize( data, serialized_data, handler_qfr_itn, function(result){
		console.log(result);
		$('.btn').attr('disabled',false);
		/* Change this to your desired system message modal ID */
		var modal_id 		= 'modal_qfr_itn_system_message';
		var form_id 		= '';
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
			return false;
		}
		$('.modal').modal('hide');
		dt_itn.ajax.reload(null, false);
		dt_lqc_supervisor.ajax.reload(null, false);
		dt_engineering_production_supervisor.ajax.reload(null, false);
	});
}

