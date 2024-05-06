/* **************************************************
	IPQC Visual Inspection - Start
/***************************************************/

var global_as_where 		= '';
var vi_as_select_ctr 		= 0;
var dt_ipqc_dimension 		= '';
var tbl_ipqc_dimension 		= 'tbl_visual_inspection';
var mdl_new_monitoring 		= 'modal_vi_new_monitoring';
var frm_vi_new_monitoring 	= 'form_vi_new_monitoring';
var mdl_edit_monitoring 	= 'modal_vi_edit_monitoring';
var frm_vi_edit_monitoring 	= 'form_vi_edit_monitoring';
var mdl_view_monitoring 	= 'modal_vi_view_monitoring';
var frm_vi_view_monitoring 	= 'form_vi_view_monitoring';

$('document').ready(function() {
	re_initialize_select2_server_side('#'+mdl_new_monitoring+' #inspected_by','#'+mdl_new_monitoring+' #'+frm_vi_new_monitoring,[],"server_side_scripts/dropdown/common/dd_hris_pmi_and_subcon_list.php");
	re_initialize_select2_server_side('#'+mdl_new_monitoring+' #checked_by','#'+mdl_new_monitoring+' #'+frm_vi_new_monitoring,[],"server_side_scripts/dropdown/common/dd_hris_pmi_and_subcon_list.php");
});

if(dt_ipqc_dimension == '') {
	dt_ipqc_dimension = $('#tbl_visual_inspection').DataTable({
		"aaSorting"	 : [],	
		"bProcessing": true,
		"bServerSide": true,
		"sAjaxSource": "server_side_scripts/ipqc/dt_visual_inspection.php?username="+username+"&wh="+global_as_where,
		rowGroup: {
			dataSrc: 0
		},
		"columnDefs": [
			{
				"targets": [ 0 ],
				"visible": false
			}
		],
		"drawCallback": function( settings ) {
			$('#'+tbl_ipqc_dimension).attr('style','width:100%;');
		}
	});
}
/* NEW */
$('.fa-plus').click(function() {
	fn_return_current_workweek(mdl_new_monitoring);
	fn_return_current_fiscal_year(mdl_new_monitoring);
	$('#'+mdl_new_monitoring).modal();
});

$('#'+frm_vi_new_monitoring).on('submit', function(e) {
	e.preventDefault();
	
	var serialized_data = new FormData(this);
	$('.btn').prop("disabled",true);
	serialized_data.append("action","save_vir_new_monitoring");
	serialized_data.append("username",username);
	fn_save_vir_new_monitoring(serialized_data, mdl_new_monitoring);
});	

/* EDIT */
$('#'+tbl_ipqc_dimension+' tbody').on('click', 'tr .fa-edit', function() {
	$('#'+frm_vi_edit_monitoring+' #monitoring_file').hide();
	fn_get_ipqc_vir_details_by_pkid(mdl_edit_monitoring, frm_vi_edit_monitoring, $(this).val());
	$('#'+mdl_edit_monitoring).data('id', $(this).val());
	$('#'+mdl_edit_monitoring).modal('show');
});

$('#'+frm_vi_edit_monitoring+' #chk_reselect_file').click(function() {
	if($(this).is(':checked')) {
		$('#'+frm_vi_edit_monitoring+' #monitoring_file').attr('name', "monitoring_file");
		$('#'+frm_vi_edit_monitoring+' #pkid').text('');
		$('#'+frm_vi_edit_monitoring+' #monitoring_file').show();
		$('#'+frm_vi_edit_monitoring+' #monitoring_file').prop('required', true);
	} else {
		$('#'+frm_vi_edit_monitoring+' #monitoring_file').attr('name', "");
		$('#'+frm_vi_edit_monitoring+' #pkid').text(' Download File');
		$('#'+frm_vi_edit_monitoring+' #monitoring_file').hide();
		$('#'+frm_vi_edit_monitoring+' #monitoring_file').prop('required', false);
	}
});

$('#'+frm_vi_edit_monitoring).on('submit', function(e) {
	e.preventDefault();
	
	var serialized_data = new FormData(this);
	$('.btn').prop("disabled",true);
	serialized_data.append("action","edit_vir_monitoring");
	serialized_data.append("pkid",$('#'+mdl_edit_monitoring).data('id'));
	serialized_data.append("username",username);
	fn_edit_vir_monitoring(serialized_data, mdl_edit_monitoring);
});	

$('#'+frm_vi_edit_monitoring+' #pkid').click( function() {
	var pkid = $(this).val();
	window.location.href = "./reports/ipqc/excel_ipqc_monitoring_file.php?id="+pkid;
});

/* VIEW */
$('#'+tbl_ipqc_dimension+' tbody').on('click', 'tr .fa-eye', function() {
	fn_get_ipqc_vir_details_by_pkid(mdl_view_monitoring, frm_vi_view_monitoring, $(this).val());
	$('#'+mdl_view_monitoring).data('id', $(this).val());
	$('#'+mdl_view_monitoring).modal('show');
});

$('#'+tbl_ipqc_dimension+' tbody').on('click', 'tr .fa-file-excel-o', function() {
	var pkid = $(this).val();
	window.location.href = "./reports/ipqc/excel_ipqc_monitoring_file.php?id="+pkid;
});


function fn_save_vir_new_monitoring(serialized_data, modal_id) {
	call_ajax_attachment(serialized_data, handler_ipqc_vir, function(result) {
		$('#'+modal_id).modal('hide');
		$('#modal_system_message').modal();
		$('#container_message').attr('class','alert alert-success');
		$('#container_message').html( '<h4>'+result['msg']+'</h4>' );
		$('.btn').prop("disabled",false);
		dt_ipqc_dimension.ajax.reload(null, false);
		console.log(result);
	});
}

function fn_get_ipqc_vir_details_by_pkid(mdl_id, frm_id, pkid) {
	var data = {
		"action"	: "get_ipqc_vir_details_by_pkid",
		"pkid"		: pkid
	}
	call_ajax(data, handler_ipqc_vir, function(result){
		$.each(result['data'], function(key, value) {
			$('#'+frm_id+' input[type="text"][name="'+key+'"]').val(value);
			$('#'+frm_id+' a[name="'+key+'"]').val(value);
			if(key == 'inspected_by' && value != "") {
				assign_value_select2('#'+frm_id+' #inspected_by',result['data']['inspected_by']);				
				re_initialize_select2_server_side('#'+mdl_id+' #inspected_by','#'+mdl_id+' #'+frm_id,[],"server_side_scripts/dropdown/common/dd_hris_pmi_and_subcon_list.php");
			} 
			if(key == 'checked_by' && value != "") {
				assign_value_select2('#'+frm_id+' #checked_by',result['data']['checked_by']);				
				re_initialize_select2_server_side('#'+mdl_id+' #checked_by','#'+mdl_id+' #'+frm_id,[],"server_side_scripts/dropdown/common/dd_hris_pmi_and_subcon_list.php");
			} 
		});
		console.log(result);
	});
}

function fn_edit_vir_monitoring(serialized_data, modal_id) {
	call_ajax_attachment(serialized_data, handler_ipqc_vir, function(result) {
		$('#'+modal_id).modal('hide');
		$('#modal_system_message').modal();
		$('#container_message').attr('class','alert alert-success');
		$('#container_message').html( '<h4>'+result['msg']+'</h4>' );
		$('.btn').prop("disabled",false);
		dt_ipqc_dimension.ajax.reload(null, false);
		console.log(result);
	});
}

function fn_return_current_workweek(mdl_id) {
	var data = {
		"action"	: "return_current_workweek"
	}
	call_ajax(data, handler_ipqc_vir, function(result){
		$('#'+mdl_id+' #workweek').val(result['ww']);
	});
}

function fn_return_current_fiscal_year(mdl_id) {
	var data = {
		"action"	: "return_current_fiscal_year"
	}
	call_ajax(data, handler_ipqc_vir, function(result){
		$('#'+mdl_id+' #fiscal_year').val(result['fy']);
	});
}

/* **************************************************
	IPQC Visual Inspection - End
/***************************************************/