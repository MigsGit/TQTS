/* *************************************************
	Lot-out Notice - LQC Inspector Functions - Start
************************************************** */

var dt_oqc_lon_lqc_inspector	= '';
var tbl_oqc_lon_lqc_inspector	= 'tbl_oqc_lon_lqc_inspector';
var tbl_oqc_lon_capa_monitoring	= 'tbl_oqc_lon_capa_monitoring';
var frm_lqc_inspector_new		= 'frm_lqc_inspector_new';
var mdl_lqc_inspector_new		= 'modal_lon_lqc_inspector_new';
var frm_lqc_inspector_edit		= 'frm_lqc_inspector_edit';
var mdl_lqc_inspector_edit		= 'modal_lon_lqc_inspector_edit';
var mdl_lon_cancel_message		= 'modal_lon_cancel_message';
var frm_lon_cancel				= 'frm_lon_cancel';
var mdl_report					= 'modal_lon_report';
var frm_report					= 'frm_lon_report';
var $frm_oqc_capa_monitoring	= $('#frm_oqc_capa_monitoring');
var oqc_lon_id = $frm_oqc_capa_monitoring.find('#oqc_lon_id').val();

dt_oqc_lon_lqc_inspector = $('#'+tbl_oqc_lon_lqc_inspector).DataTable({
	"aaSorting"	 : [],
	"bProcessing": true,
	"bServerSide": true,
	"sAjaxSource": "server_side_scripts/oqc/dt_lon_lqc_inspector.php?username="+username,
	"drawCallback": function( settings ) {
		// assign_value_select2('#frm_sa #supplier', supplier);
		$('#'+tbl_oqc_lon_lqc_inspector).attr('style','width:100%;');


	}
});

dt_oqc_lon_capa_monitoring = $('#'+tbl_oqc_lon_capa_monitoring).DataTable({
	"aaSorting"	 : [],
	"bProcessing": true,
	"bServerSide": true,
	"columnDefs":[
		{"orderable":false,"targets":[0,1]}
	],
	"sAjaxSource": "server_side_scripts/oqc/dt_lon_lqc_inspector_capa_monitoring.php?username="+username +"&"+ "oqc_lon_id="+oqc_lon_id, 
	"drawCallback": function( settings ) {
		$('#'+tbl_oqc_lon_capa_monitoring).attr('style','width:100%;');
	}
});

/* CAPA MONITORING */
const save_oqc_capa_monitoring = function (serialized_data){
	let data = {
		'action' : 'save_oqc_capa_monitoring',
		'username': username
	}
	call_ajax_serialize(data, serialized_data, handler_lon, function(result) {
		if(result.is_success === 'true'){
			$('#modal_oqc_capa_monitoring').modal('hide');
			notif_success(result.message);
			dt_oqc_lon_capa_monitoring.ajax.url("server_side_scripts/oqc/dt_lon_lqc_inspector_capa_monitoring.php?username="+username +"&"+ "oqc_lon_id="+$frm_oqc_capa_monitoring.find('#oqc_lon_id').val()).draw();
		
		}
	})
}
const read_oqc_lon_capa_monitoring_by_id =function (oqc_lon_capa_monitoring_id){
	let data = {
		'action' : 'read_oqc_capa_monitoring_by_id',
		'oqc_lon_capa_monitoring_id' : oqc_lon_capa_monitoring_id,
	}
	call_ajax(data, handler_lon, function(result) {
		$('#modal_oqc_capa_monitoring').modal();
		if(result.is_success === 'true'){
			if(result.oqc_capa_status === 'Open'){
				$('.submissionDate').hide();
			}else{
				$('.submissionDate').show();
			}
			$frm_oqc_capa_monitoring.find('[name="oqc_capa_action"]').val(result.oqc_capa_action);
			$frm_oqc_capa_monitoring.find('[name="oqc_lon_capa_monitoring_id"]').val(result.id);
			$frm_oqc_capa_monitoring.find('[name="oqc_capa_actual_sub_date"]').val(result.oqc_capa_actual_sub_date);
			$frm_oqc_capa_monitoring.find('[name="oqc_capa_due_date"]').val(result.oqc_capa_due_date);
			$frm_oqc_capa_monitoring.find('[name="oqc_capa_due_date"]').val(result.oqc_capa_due_date);
			$frm_oqc_capa_monitoring.find('[name="oqc_capa_remarks"]').val(result.oqc_capa_remarks);
			$frm_oqc_capa_monitoring.find('[name="oqc_capa_req_sub_date"]').val(result.oqc_capa_req_sub_date);
			$frm_oqc_capa_monitoring.find('[name="oqc_capa_status"]').val(result.oqc_capa_status);
			assign_value_select2('#frm_oqc_capa_monitoring'+' #oqc_capa_action_incharge',result['oqc_capa_action_incharge']);				
			re_initialize_select2_server_side('#modal_oqc_capa_monitoring #oqc_capa_action_incharge','#modal_oqc_capa_monitoring #frm_oqc_capa_monitoring',[],"server_side_scripts/dropdown/common/dd_hris_above_ss_list.php");
		}
	})
}

$('#add_capa_monitoring').click(function(){
	$('#modal_oqc_capa_monitoring').modal();
	$('.submissionDate').hide();
	re_initialize_select2_server_side('#modal_oqc_capa_monitoring #oqc_capa_action_incharge','#modal_oqc_capa_monitoring #frm_oqc_capa_monitoring',[],"server_side_scripts/dropdown/common/dd_hris_above_ss_list.php");
	$frm_oqc_capa_monitoring.find('#oqc_lon_id').val();
});

$frm_oqc_capa_monitoring.submit(function (e) { 
	e.preventDefault();
	save_oqc_capa_monitoring ($(this).serialize());
});

$('#' + tbl_oqc_lon_capa_monitoring + ' tbody').on('click','tr .fa-edit',function(){
	let oqc_lon_capa_monitoring_id = $(this).attr('tbl-oqc-lon-capa-monitoring-id');
	read_oqc_lon_capa_monitoring_by_id(oqc_lon_capa_monitoring_id);
})

$('#modal_oqc_capa_monitoring').on('hidden.bs.modal', function (e) {
	/* Allows the overlayed modal to be scrollable */
	if($('#modal_oqc_capa_monitoring').hasClass('in')) {
		$(this).find('body').addClass('modal-open');
	}    
	
	$frm_oqc_capa_monitoring.find('[name="oqc_capa_action"]').val('');
	$frm_oqc_capa_monitoring.find('[name="oqc_lon_capa_monitoring_id"]').val('');
	$frm_oqc_capa_monitoring.find('[name="oqc_capa_actual_sub_date"]').val('');
	$frm_oqc_capa_monitoring.find('[name="oqc_capa_due_date"]').val('');
	$frm_oqc_capa_monitoring.find('[name="oqc_capa_due_date"]').val('');
	$frm_oqc_capa_monitoring.find('[name="oqc_capa_remarks"]').val('');
	$frm_oqc_capa_monitoring.find('[name="oqc_capa_req_sub_date"]').val('');
	$frm_oqc_capa_monitoring.find('[name="oqc_capa_status"]').val('');
	$frm_oqc_capa_monitoring.find('[name="oqc_capa_action_incharge[]"]').empty();
});

$('#oqc_capa_status').change(function (e) { 
	e.preventDefault();
	if($(this).val() === 'Open'){
		$('.submissionDate').hide();
	}else{
		$('.submissionDate').show();
	}
});


/* Report - start */
$('#btn_lon_report_ins,#btn_lon_report_sup,#btn_lon_report_man,#btn_lon_report_prod').click(function(){
	$('#'+mdl_report).modal('show');
});

$('#'+frm_report).submit(function(e) {
	e.preventDefault();
	window.location.href = "./reports/oqc/excel_oqc_lon_summary.php?df="+$('#'+frm_report+' #date_from').val()+"&dt="+$('#'+frm_report+' #date_to').val();
});

/* Add - start */
$('#btn_lon_new').click(function(){
	/* Load */
	re_initialize_select2_server_side('#'+mdl_lqc_inspector_new+' #cmb_attention','#'+mdl_lqc_inspector_new+' #'+frm_lqc_inspector_new,[],"server_side_scripts/dropdown/common/dd_hris_below_ss_list.php");
	re_initialize_select2_server_side('#'+mdl_lqc_inspector_new+' #cmb_verified_by','#'+mdl_lqc_inspector_new+' #'+frm_lqc_inspector_new,[],"server_side_scripts/dropdown/common/dd_hris_below_ss_list.php");
	re_initialize_select2_server_side('#'+mdl_lqc_inspector_new+' #cmb_operator','#'+mdl_lqc_inspector_new+' #'+frm_lqc_inspector_new,[],"server_side_scripts/dropdown/common/dd_operator_list.php");
	re_initialize_select2_server_side('#'+mdl_lqc_inspector_new+' #cmb_checked_by','#'+mdl_lqc_inspector_new+' #'+frm_lqc_inspector_new,[],"server_side_scripts/dropdown/common/dd_hris_above_ss_list.php");
	re_initialize_select2_server_side('#'+mdl_lqc_inspector_new+' #cmb_approved_by','#'+mdl_lqc_inspector_new+' #'+frm_lqc_inspector_new,[],"server_side_scripts/dropdown/common/dd_hris_above_ss_list.php");
	fn_generate_lon_no(frm_lqc_inspector_new);
	fn_get_lon_disposition_lists(frm_lqc_inspector_new+' #disposition');
	$('#'+frm_lqc_inspector_new+' input').val('');
	$('#'+mdl_lqc_inspector_new).modal('show');
});

$('#'+frm_lqc_inspector_new+' input[name="po_number"]').keyup(function(e){
	var pattern = $(this).val();
	fn_get_po_list(pattern, frm_lqc_inspector_new+' #list_po_num');
});

$('#'+frm_lqc_inspector_new+' input[name="po_number"]').change(function(e){
	var po_number = $(this).val();
	var array_fields = [
		'input[name="device_name"]',
		'',
		'',
		''
	]
	fn_get_po_details(po_number,frm_lqc_inspector_new,array_fields);
});

$('#'+frm_lqc_inspector_new+' #lot_qty').change(function() {
	var lot_qty 		= $(this).val();
	var sample_size 	= frm_lqc_inspector_new + ' #sample_size';
	$('#'+sample_size).attr({max : lot_qty });
});

$('#'+frm_lqc_inspector_new).on('submit', function(e) {
	e.preventDefault();
	
	var serialized_data = new FormData(this);
	if(fn_validate_upload(frm_lqc_inspector_new)) {		
		$('.btn').prop("disabled",true);
		serialized_data.append("action","save_lqc_inspector");
		serialized_data.append("username",username);
		fn_save_lqc_inspector_new(serialized_data, mdl_lqc_inspector_new);
	}
});	

function fn_generate_lon_no(frm_id) {
	var data = {
		"action"	: "generate_lon_no"
	}
	call_ajax(data, handler_lon, function(result){	
		$('#'+frm_id+' input[name="section"]').val(result['section']);
		$('#'+frm_id+' input[name="lon_no"]').val(result['lon_no']);
	});
}

function fn_get_empname_list(select_id, callback) {
	$('#'+select_id).val('').trigger('chosen:updated');
	var data = {
		"action"	: "get_emp_name"
	}
	call_ajax(data, common_handler, function(result){	
		$('#'+select_id).append(result['html_select']);
		$('#'+select_id).trigger('chosen:updated');
		callback();
	});
}

function fn_get_operators_name(select_id, callback) {
	$('#'+select_id).val('').trigger('chosen:updated');
	var data = {
		"action"	: "get_operators_name"
	}
	call_ajax(data, common_handler, function(result){	
		$('#'+select_id).append(result['html_select']);
		$('#'+select_id).trigger('chosen:updated');
		callback();
	});
}

function fn_get_lon_disposition_lists(select_id) {
	$('#'+select_id).empty();
	var data = {
		"action"	: "get_lon_disposition_lists"
	}
	call_ajax(data, handler_lon, function(result){	
		$('#'+select_id).append(result['html_select']);
	});
}

function fn_validate_upload(frm_id) {
	$('#container_lqc_inspector_new_message').empty();
	var message = '';
	if($('#'+frm_id + ' #cmb_attention').val().length <= 1 ) {
		message = '<br>- Atttention (atleast 2)';
	} 
	if(message != '') {
		$('#container_lqc_inspector_new_message').html('Please select atleast 2 Attention');
		$('#container_lqc_inspector_new_message').show();
		$('.btn').prop("disabled",false);
		return false;
	} else {
		$('#container_lqc_inspector_new_message').hide();
		return true;
	}
}

function fn_save_lqc_inspector_new(serialized_data, modal_id) {
	call_ajax_attachment(serialized_data, handler_lon, function(result) {
		$('#'+modal_id).modal('hide');
		$('#modal_system_message').modal();
		$('#container_message').attr('class','alert alert-success');
		$('#container_message').html( '<h4>'+result['msg']+'</h4>' );
		$('.btn').prop("disabled",false);
		fn_reload_lon_datatables();
	});
}

/* Add - end */

/* EDIT - start */
$('#' + tbl_oqc_lon_lqc_inspector + ' tbody').on('click','tr .fa-edit',function(){
	var pkid 	= $(this).attr("id");	
	var row 	= $(this).closest('tr');
	var status  = row.find('td:eq(0)').text();
	
	$('#'+mdl_lqc_inspector_edit+' .fa-save').show();
	$('#'+mdl_lqc_inspector_edit+' .modal-title').html('<i class="fa fa-edit"></i> Edit Lot-out Notice');
	
	fn_get_lon_disposition_lists(frm_lqc_inspector_edit+' #disposition');
	fn_get_oqc_lon_details_edit(pkid, mdl_lqc_inspector_edit, frm_lqc_inspector_edit);
	$('#'+mdl_lqc_inspector_edit).data('id',pkid);
	$('#'+mdl_lqc_inspector_edit).modal('show');
	$('#'+mdl_lqc_inspector_edit + ' #lon_container_message').hide();
});

$('#'+mdl_lqc_inspector_edit+' .fa-paperclip').click(function() {	
	window.location.href = "./pages/oqc/dl_oqc_lon.php?id="+$(this).val()+'&type=inspector';
});	

$('#'+frm_lqc_inspector_edit).on('submit', function(e) {
	e.preventDefault();
	var serialized_data = new FormData(this);
	if(fn_validate_upload(frm_lqc_inspector_edit)) {		
		$('.btn').prop("disabled",true);
		serialized_data.append("action","edit_lqc_inspector");
		serialized_data.append("pkid", $('#'+mdl_lqc_inspector_edit).data('id') );
		serialized_data.append("username",username);
		fn_save_lqc_inspector_new(serialized_data, mdl_lqc_inspector_edit);
	}
});	

/* EDIT - end */

/* VIEW - start */
$('#' + tbl_oqc_lon_lqc_inspector + ' tbody').on('click','tr .fa-eye',function(){
	var pkid 	= $(this).attr("id");	
	var row 	= $(this).closest('tr');
	var status  = row.find('td:eq(0)').text();
	$frm_oqc_capa_monitoring.find('#oqc_lon_id').val(pkid);

	if(status == " CONFORMED") {
		$('#'+mdl_inspector_production+' .fa-thumbs-o-up').hide();
		$('#'+mdl_inspector_production+' .fa-thumbs-o-down').hide();
		
		fn_get_oqc_lon_details(pkid, mdl_inspector_production, frm_inspector_production);
		$('#'+mdl_inspector_production).data('id',pkid);
		$('#'+mdl_inspector_production+' input[type="file"]').hide();
		$('#'+mdl_inspector_production).modal('show');
		$('#'+mdl_inspector_production + ' #lon_container_message').hide();
	} else {		
		$('#'+mdl_lqc_inspector_edit+' .fa-save').hide();
		$('#'+mdl_lqc_inspector_edit+' .modal-title').html('<i class="fa fa-eye"></i> View Lot-out Notice');
		$('#'+mdl_lqc_inspector_edit+' input[type="file"]').hide();
		
		fn_get_lon_disposition_lists(frm_lqc_inspector_edit+' #disposition');
		$('#'+frm_lqc_inspector_edit+' input').val('');
		fn_get_oqc_lon_details_edit(pkid, mdl_lqc_inspector_edit, frm_lqc_inspector_edit);
		$('#'+mdl_lqc_inspector_edit).data('id',pkid);
		$('#'+mdl_lqc_inspector_edit).modal('show');
		$('#'+mdl_lqc_inspector_edit + ' #lon_container_message').hide();
	}
});

$('#' + tbl_oqc_lon_lqc_inspector + ' tbody').on('click','tr .fa-file-excel-o',function(){
	var pkid 	= $(this).attr("id");	
	window.location.href = "./reports/oqc/excel_oqc_lon.php?id="+pkid;
});

/* VIEW - end */

/* CANCEL - start */
$('#' + tbl_oqc_lon_lqc_inspector + ' tbody').on('click','tr .fa-close',function(){
	var pkid 	= $(this).attr("id");	
	var row 	= $(this).closest('tr');
	
	$('#'+mdl_lon_cancel_message).data('id',pkid);
	$('#'+mdl_lon_cancel_message).data('status','CANCELLED BY LQC INSPECTOR');
	$('#'+mdl_lon_cancel_message).modal('show');
});

$('#'+frm_lon_cancel).on('submit', function(e) {
	e.preventDefault();
	$('.btn').prop("disabled",true);
	var serialized_data = $('#'+frm_lon_cancel).serialize();
	var data = {
		"action"				: "save_lqc_cancel",
		"pkid"					: $('#'+mdl_lon_cancel_message).data('id'),
		"status"				: $('#'+mdl_lon_cancel_message).data('status'),
		"username"				: username,
	}
	call_ajax_serialize(data, serialized_data, handler_lon, function(result) {
		$('#'+mdl_lon_cancel_message).modal('hide');
		$('#modal_system_message').modal();
		$('#container_message').attr('class','alert alert-success');
		$('#container_message').html( '<h4>'+result['msg']+'</h4>' );
		fn_reload_lon_datatables();
		$('.btn').prop("disabled",false);
	});
});	

/* CANCEL - end */

/* *************************************************
	Lot-out Notice - LQC Inspector Functions - End
************************************************** */

/* *************************************************
	Lot-out Notice - LQC Supervisor Functions - Start
************************************************** */

var dt_oqc_lon_lqc_supervisor	= '';
var tbl_oqc_lon_lqc_supervisor	= 'tbl_oqc_lon_lqc_supervisor';
var frm_lqc_supervisor_edit		= 'frm_lqc_supervisor_edit';
var mdl_lqc_supervisor_edit		= 'modal_lon_lqc_supervisor_edit';
var frm_lqc_supervisor_view		= 'frm_lqc_supervisor_view';
var mdl_lqc_supervisor_view		= 'modal_lon_lqc_supervisor_view';

dt_oqc_lon_lqc_supervisor = $('#'+tbl_oqc_lon_lqc_supervisor).DataTable({
	"aaSorting"	 : [],
	"bProcessing": true,
	"bServerSide": true,
	"sAjaxSource": "server_side_scripts/oqc/dt_lon_lqc_supervisor.php?username="+username,
	"drawCallback": function( settings ) {
		$('#'+tbl_oqc_lon_lqc_supervisor).attr('style','width:100%;');
	}
});

/* EDIT - start */
$('#' + tbl_oqc_lon_lqc_supervisor + ' tbody').on('click','tr .fa-edit',function(){
	var pkid 	= $(this).attr("id");	
	var row 	= $(this).closest('tr');
	var status  = row.find('td:eq(0)').text();
	
	$('#'+mdl_lqc_supervisor_edit+' .fa-save').show();
	
	fn_get_lon_disposition_lists(frm_lqc_supervisor_edit+' #disposition');
	$('#'+frm_lqc_supervisor_edit+' input').val('');
	fn_get_oqc_lon_details_edit(pkid, mdl_lqc_supervisor_edit, frm_lqc_supervisor_edit);
	
	$('#'+mdl_lqc_supervisor_edit).data('id',pkid);
	$('#'+mdl_lqc_supervisor_edit).modal('show');
	$('#'+mdl_lqc_supervisor_edit + ' #lon_container_message').hide();
});

$('#'+mdl_lqc_supervisor_edit+' .fa-paperclip').click(function() {	
	window.location.href = "./pages/oqc/dl_oqc_lon.php?id="+$(this).val()+'&type=inspector';
});	

$('#'+frm_lqc_supervisor_edit).on('submit', function(e) {
	e.preventDefault();
	var serialized_data = new FormData(this);
	if(fn_validate_upload(frm_lqc_supervisor_edit)) {		
		$('.btn').prop("disabled",true);
		serialized_data.append("action","edit_lqc_supervisor");
		serialized_data.append("pkid", $('#'+mdl_lqc_supervisor_edit).data('id') );
		serialized_data.append("username",username);
		fn_save_lqc_supervisor_edit(serialized_data, mdl_lqc_supervisor_edit);
	}
});	

function fn_save_lqc_supervisor_edit(serialized_data, modal_id) {
	call_ajax_attachment(serialized_data, handler_lon, function(result) {
		$('#'+modal_id).modal('hide');
		$('#modal_system_message').modal();
		$('#container_message').attr('class','alert alert-success');
		$('#container_message').html( '<h4>'+result['msg']+'</h4>' );
		$('.btn').prop("disabled",false);
		fn_reload_lon_datatables();
		console.log(result);
	});
}


/* EDIT - end */

/* VIEW  - start */

$('#' + tbl_oqc_lon_lqc_supervisor + ' tbody').on('click','tr .fa-eye',function(){
	var pkid 	= $(this).attr("id");	
	var row 	= $(this).closest('tr');
	var status_display  = row.find('td:eq(0) span').text();
	var status  = row.find('td:eq(0) input').val();
	$frm_oqc_capa_monitoring.find('#oqc_lon_id').val(pkid);
	if(status_display == ' PENDING') {
		$('#'+mdl_lqc_supervisor_view+' .fa-thumbs-o-up').show();
		$('#'+mdl_lqc_supervisor_view+' .fa-thumbs-o-down').show();
		$('#'+mdl_lqc_supervisor_view).data('id',pkid);
		$('#'+mdl_lqc_supervisor_view).modal('show');
		$('#'+mdl_lqc_supervisor_view + ' #lon_container_message').hide();
		re_initialize_select2_server_side('#'+mdl_lqc_supervisor_view+' #cmb_cc','#'+mdl_lqc_supervisor_view+' #'+frm_lqc_supervisor_view,[],"server_side_scripts/dropdown/common/dd_hris_all_list.php");
		fn_get_oqc_lon_details(pkid, mdl_lqc_supervisor_view, frm_lqc_supervisor_view);
	} else {
		if(fn_lon_display_modal_by_status(status, pkid)) {
			$('#'+mdl_lqc_supervisor_view+' .fa-thumbs-o-up').hide();
			$('#'+mdl_lqc_supervisor_view+' .fa-thumbs-o-down').hide();
			$('#'+mdl_lqc_supervisor_view).data('id',pkid);
			$('#'+mdl_lqc_supervisor_view).modal('show');
			$('#'+mdl_lqc_supervisor_view + ' #lon_container_message').hide();
			re_initialize_select2_server_side('#'+mdl_lqc_supervisor_view+' #cmb_cc','#'+mdl_lqc_supervisor_view+' #'+frm_lqc_supervisor_view,[],"server_side_scripts/dropdown/common/dd_hris_all_list.php");	
			fn_get_oqc_lon_details(pkid, mdl_lqc_supervisor_view, frm_lqc_supervisor_view);
		}	
	}
	
	
});

$('#'+mdl_lqc_supervisor_view+' .fa-paperclip').click(function() {	
	window.location.href = "./pages/oqc/dl_oqc_lon.php?id="+$(this).val()+'&type=inspector';
});	

$('#'+mdl_lqc_supervisor_view+' .fa-thumbs-o-up').click(function() {
	$('#'+mdl_lqc_supervisor_view + ' #lon_container_message').empty();	
	if($('#'+mdl_lqc_supervisor_view+' input[name="capa_due_date"]').val() == '') {
		$('#'+mdl_lqc_supervisor_view + ' #lon_container_message').html('Please select CAPA due date');
		$('#'+mdl_lqc_supervisor_view + ' #lon_container_message').show();
	} else {
		$('.btn').prop("disabled",true);
		$('#'+mdl_lqc_supervisor_view + ' #lon_container_message').hide();
		fn_save_lqc_supervisor_decision('ACCEPT', mdl_lqc_supervisor_view, frm_lqc_supervisor_view);
	}	
});	

$('#'+mdl_lqc_supervisor_view+' .fa-thumbs-o-down').click(function() {	
	$('#'+mdl_lqc_supervisor_view + ' #lon_container_message').empty();	
	if($('#'+mdl_lqc_supervisor_view+' textarea[name="checked_by_remarks"]').val() == '') {
		$('#'+mdl_lqc_supervisor_view + ' #lon_container_message').html('Please write reason of rejection on remarks portion');
		$('#'+mdl_lqc_supervisor_view + ' #lon_container_message').show();
	} else {
		$('.btn').prop("disabled",true);
		$('#'+mdl_lqc_supervisor_view + ' #lon_container_message').hide();
		fn_save_lqc_supervisor_decision('REJECT', mdl_lqc_supervisor_view, frm_lqc_supervisor_view);
	}	
});	

$('#' + tbl_oqc_lon_lqc_supervisor + ' tbody').on('click','tr .fa-file-excel-o',function(){
	var pkid 	= $(this).attr("id");	
	window.location.href = "./reports/oqc/excel_oqc_lon.php?id="+pkid;
});

function fn_save_lqc_supervisor_decision(decision, modal_id, form_id) {
	var serialized_data = $('#'+form_id).serialize();
	var cc_usernames 	= frm_lqc_supervisor_view + ' #cmb_cc_lqc_supervisor_view';
	var data = {
		"action"				: "save_lqc_supervisor_decision",
		"pkid"					: $('#'+modal_id).data('id'),
		"cc_usernames"			: JSON.stringify($('#' + cc_usernames).val()),
		"decision"				: decision,
		"username"				: username,
	}
	call_ajax_serialize(data, serialized_data, handler_lon, function(result) {
		$('#'+modal_id).modal('hide');
		$('#modal_system_message').modal();
		$('#container_message').attr('class','alert alert-success');
		$('#container_message').html( '<h4>'+result['msg']+'</h4>' );
		fn_reload_lon_datatables();
		$('.btn').prop("disabled",false);
	});
}

/* VIEW - end */

/* CANCEL - start */
$('#' + tbl_oqc_lon_lqc_supervisor + ' tbody').on('click','tr .fa-close',function(){
	var pkid 	= $(this).attr("id");	
	var row 	= $(this).closest('tr');
	
	$('#'+mdl_lon_cancel_message).data('id',pkid);
	$('#'+mdl_lon_cancel_message).data('status','CANCELLED BY LQC SUPERVISOR');
	$('#'+mdl_lon_cancel_message).modal('show');
});

/* CANCEL - end */

/* *************************************************
	Lot-out Notice - LQC Supervisor Functions - End
************************************************** */

/* *************************************************
	Lot-out Notice - LQC Manager Functions - Start
************************************************** */

var dt_oqc_lon_lqc_manager		= '';
var tbl_oqc_lon_lqc_manager		= 'tbl_oqc_lon_lqc_manager';
var frm_lqc_manager				= 'frm_lqc_manager_view';
var mdl_lqc_manager				= 'modal_lon_lqc_manager_view';
var frm_lqc_manager_approver	= 'frm_lon_approvers_decision';
var mdl_lqc_manager_approver	= 'modal_lon_approver_message';

dt_oqc_lon_lqc_manager = $('#'+tbl_oqc_lon_lqc_manager).DataTable({
	"aaSorting"	 : [],
	"bProcessing": true,
	"bServerSide": true,
	"sAjaxSource": "server_side_scripts/oqc/dt_lon_lqc_manager.php?username="+username,
	"drawCallback": function( settings ) {
		$('#'+tbl_oqc_lon_lqc_manager).attr('style','width:100%;');
	}
});

$('#' + tbl_oqc_lon_lqc_manager + ' tbody').on('click','tr .fa-eye',function(){
	var pkid 	= $(this).attr("id");	
	var row 	= $(this).closest('tr');
	var status_display  = row.find('td:eq(0) span').text();
	var status  = row.find('td:eq(0) input').val();

	if(status_display == ' PENDING') {
		$('#'+mdl_lqc_manager+' .fa-thumbs-o-up').show();
		$('#'+mdl_lqc_manager+' .fa-thumbs-o-down').show();
		fn_get_oqc_lon_details(pkid, mdl_lqc_manager, frm_lqc_manager);
		$('#'+mdl_lqc_manager).data('id',pkid);
		$('#'+mdl_lqc_manager).modal('show');
		$('#'+mdl_lqc_manager + ' #lon_container_message').hide();
	} else {
		if(fn_lon_display_modal_by_status(status, pkid)) {
			$('#'+mdl_lqc_manager+' .fa-thumbs-o-up').hide();
			$('#'+mdl_lqc_manager+' .fa-thumbs-o-down').hide();
			fn_get_oqc_lon_details(pkid, mdl_lqc_manager, frm_lqc_manager);
			$('#'+mdl_lqc_manager).data('id',pkid);
			$('#'+mdl_lqc_manager).modal('show');
			$('#'+mdl_lqc_manager + ' #lon_container_message').hide();
		}
	}	
});

$('#'+mdl_lqc_manager+' .fa-paperclip').click(function() {	
	window.location.href = "./pages/oqc/dl_oqc_lon.php?id="+$(this).val()+'&type=inspector';
});

// \\rapid\www\TQTS_TS\js\oqc\lot_out_notice.js
$('#' + tbl_oqc_lon_lqc_manager + ' tbody').on('click','tr .fa-file-excel-o',function(){
	var pkid 	= $(this).attr("id");	
	window.location.href = "./reports/oqc/excel_oqc_lon.php?id="+pkid;
});

$('#'+mdl_lqc_manager+' .fa-thumbs-o-up').click(function() {
	$('#'+mdl_lqc_manager_approver + ' #container_approver_message').attr('class','alert alert-success');
	$('#'+mdl_lqc_manager_approver + ' #container_approver_message').html('Are you sure you want to approve the request?<br><br>Remarks:<textarea name="approved_by_remarks" style="width:100%;" rows="4"></textarea>');
	$('#'+mdl_lqc_manager_approver + ' #container_approver_message').show();
	$('#'+mdl_lqc_manager_approver).modal();
});	

$('#'+mdl_lqc_manager+' .fa-thumbs-o-down').click(function() {	
	$('#'+mdl_lqc_manager_approver + ' #container_approver_message').attr('class','alert alert-danger');
	$('#'+mdl_lqc_manager_approver + ' #container_approver_message').html('Are you sure you want to disapprove the request?<br><br>Remarks:<textarea name="approved_by_remarks" style="width:100%;" rows="4" required></textarea>');
	$('#'+mdl_lqc_manager_approver + ' #container_approver_message').show();
	$('#'+mdl_lqc_manager_approver).modal();
});	

$('#'+frm_lqc_manager_approver).on('submit', function(e) {
	e.preventDefault();
	$('.btn').prop("disabled",true);
	var decision = $('#'+mdl_lqc_manager_approver + ' #container_approver_message').attr('class');
	if(decision == 'alert alert-success') {
		var status = 'APPROVED';
	} else if(decision == 'alert alert-danger') {
		var status = 'DISAPPROVED';
	} 
	$('#'+mdl_lqc_manager).modal('hide');
	fn_save_lqc_manager_decision(status, mdl_lqc_manager_approver, frm_lqc_manager_approver);
});	

function fn_save_lqc_manager_decision(decision, modal_id, form_id) {
	var serialized_data = $('#'+form_id).serialize();
	var data = {
		"action"				: "save_lqc_manager_decision",
		"pkid"					: $('#'+mdl_lqc_manager).data('id'),
		"decision"				: decision,
		"username"				: username,
	}
	call_ajax_serialize(data, serialized_data, handler_lon, function(result) {
		$('#'+modal_id).modal('hide');
		$('#modal_system_message').modal();
		$('#container_message').attr('class','alert alert-success');
		$('#container_message').html( '<h4>'+result['msg']+'</h4>' );
		$('.btn').prop("disabled",false);
		fn_reload_lon_datatables();
		console.log(result);
	});
}

/* CANCEL - start */
$('#' + tbl_oqc_lon_lqc_manager + ' tbody').on('click','tr .fa-close',function(){
	var pkid 	= $(this).attr("id");	
	var row 	= $(this).closest('tr');
	
	$('#'+mdl_lon_cancel_message).data('id',pkid);
	$('#'+mdl_lon_cancel_message).data('status','CANCELLED BY LQC MANAGER');
	$('#'+mdl_lon_cancel_message).modal('show');
});

/* CANCEL - end */

/* *************************************************
	Lot-out Notice - LQC Manager Functions - End
************************************************** */

/* *************************************************
	Lot-out Notice - Production Functions - Start
************************************************** */

var dt_oqc_lon_production		= '';
var tbl_oqc_lon_production		= 'tbl_oqc_lon_production';
var frm_production_new			= 'frm_lqc_production_add';
var mdl_production				= 'modal_lon_production_add';
var frm_production_edit			= 'frm_lqc_production_edit';
var mdl_production_edit			= 'modal_lon_production_edit';
var mdl_prdn_mode_defect		= 'modal_lon_production_mode_defect_add';
var frm_prdn_mode_defect		= 'frm_lqc_production_mode_defect_add';
var mdl_prdn_mode_defect_edit	= 'modal_lon_production_mode_defect_edit';
var frm_prdn_mode_defect_edit	= 'frm_lqc_production_mode_defect_edit';
var mdl_prdn_mode_defect_view	= 'modal_lon_production_mode_defect_view';
var frm_prdn_mode_defect_view	= 'frm_lqc_production_mode_defect_view';
var mode_defect_array			= [];


dt_oqc_lon_production = $('#'+tbl_oqc_lon_production).DataTable({
	"aaSorting"	 : [],
	"bProcessing": true,
	"bServerSide": true,
	"sAjaxSource": "server_side_scripts/oqc/dt_lon_production.php?username="+username,
	"drawCallback": function( settings ) {
		$('#'+tbl_oqc_lon_production).attr('style','width:100%;');
	}
});

/* ADD - start */
$('#' + tbl_oqc_lon_production + ' tbody').on('click','tr .fa-plus',function(){
	var pkid 	= $(this).attr("id");	
	var row 	= $(this).closest('tr');
	var status  = row.find('td:eq(0)').text();
	if(status == ' PENDING') {
		$('#'+mdl_production+' .fa-save').show();
	} else {
		$('#'+mdl_production+' .fa-save').hide();
	}
	
	fn_get_oqc_lon_details(pkid, mdl_production, frm_production_new);
	$('#'+mdl_production).data('id',pkid);
	$('#'+mdl_production).modal('show');
	$('#'+mdl_production + ' #lon_container_message').hide();
});

$('#'+mdl_production+' .fa-paperclip').click(function() {	
	window.location.href = "./pages/oqc/dl_oqc_lon.php?id="+$(this).val()+'&type=inspector';
});	



$('#'+frm_production_new+' input[name="ok_qty"]').keyup(function(e) {
	var ok_qty 		= parseFloat($('#'+frm_production_new+' input[name="ok_qty"]').val());
	var sorted_qty 	= parseFloat($('#'+frm_production_new+' input[name="sorted_qty"]').val());
	var ng_qty 		= sorted_qty  - ok_qty;
	
	$('#'+frm_production_new+' input[name="ng_qty"]').val(ng_qty);
	
	if($('#'+frm_production_new+' input[name="ng_qty"]').val() == 0 || $('#'+frm_production_new+' input[name="ng_qty"]').val() == "") {
		$('#'+frm_production_new+' .fa-plus').prop("disabled", true);
	} else {
		$('#'+frm_production_new+' .fa-plus').prop("disabled", false);
	}
});
$('#'+frm_production_new+' input[name="ng_qty"]').keyup(function(e) {
	if($(this).val() == 0 || $(this).val() == "") {
		$('#'+frm_production_new+' .fa-plus').prop("disabled", true);
	} else {
		$('#'+frm_production_new+' .fa-plus').prop("disabled", false);
	}
	
	var ng_qty 		= parseFloat($('#'+frm_production_new+' input[name="ng_qty"]').val());
	var sorted_qty 	= parseFloat($('#'+frm_production_new+' input[name="sorted_qty"]').val());
	var ok_qty 		= sorted_qty  - ng_qty;
	
	$('#'+frm_production_new+' input[name="ok_qty"]').val(ok_qty);
});

$('#'+frm_production_new+' button[name="add_mode_defect"]').click(function() {	
	var fklon = $('#'+mdl_production).data('id');
	$('#'+mdl_prdn_mode_defect).data('id', fklon)
	$('#'+mdl_prdn_mode_defect).modal();
});

$('#'+frm_prdn_mode_defect).on('submit', function(e) {
	e.preventDefault();
	var html_body  = '<tr>';
		html_body += '<td>'+$('#'+frm_prdn_mode_defect+' input[name="mode_defect"]').val()+'</td>';
		html_body += '<td><a href="#" class="fa fa-remove"> Remove</a></td>';
		html_body += '</tr>';
	$('#'+frm_prdn_mode_defect+' table tbody').append(html_body);
	$('#'+frm_prdn_mode_defect+' input').val('');
	$('#'+frm_prdn_mode_defect+' input[name="mode_defect"]').focus();
});

$('#'+frm_prdn_mode_defect+' table tbody').on('click' , 'a', function(){
	$(this).closest('tr').remove();
	return false;
});

$('#'+frm_production_new).on('submit', function(e) {
	e.preventDefault();
	$('.btn').prop("disabled",true);
	var mode_defect = [];
	$('#'+frm_prdn_mode_defect+' table tbody tr').each(function() {
		mode_defect.push( $(this).find('td:eq(0)').text() );
	});
	
	var serialized_data = new FormData(this);
		serialized_data.append("action","save_production_disposition");
		serialized_data.append("fklon", $('#'+mdl_production).data('id') );
		serialized_data.append("mode_defect",mode_defect);
		serialized_data.append("username",username);
	fn_save_production_disposition(serialized_data, mdl_production, frm_production_new);
});


function fn_save_production_disposition(serialized_data, modal_id, form_id) {
	call_ajax_attachment(serialized_data, handler_lon, function(result) {
		$('#'+modal_id).modal('hide');
		$('#modal_system_message').modal();
		$('#container_message').attr('class','alert alert-success');
		$('#container_message').html( '<h4>'+result['msg']+'</h4>' );
		$('.btn').prop("disabled",false);
		fn_reload_lon_datatables();
	});
}

/* ADD - end */

/* EDIT - start */
$('#' + tbl_oqc_lon_production + ' tbody').on('click','tr .fa-edit',function(){
	var pkid 	= $(this).attr("id");	
	var row 	= $(this).closest('tr');
	
	$('#'+mdl_production_edit+' .fa-save').show();
	$('#'+mdl_production_edit+' .modal-title').html('<i class="fa fa-edit"></i> Edit CAPA Report');
	
	fn_get_oqc_lon_details(pkid, mdl_production_edit, frm_production_edit);
	fn_get_mode_defect_details(pkid, 'edit', mdl_production_edit);
	$('#'+mdl_production_edit).data('id',pkid);
	$('#'+mdl_production_edit).modal('show');
	$('#'+mdl_production_edit + ' #lon_container_message').hide();
});

$('#'+mdl_production_edit+' .fa-paperclip').click(function() {	
	window.location.href = "./pages/oqc/dl_oqc_lon.php?id="+$(this).val()+'&type=inspector';
});	

$('#'+frm_production_edit+' input[name="ok_qty"]').keyup(function(e) {
	var ok_qty 		= parseFloat($('#'+frm_production_edit+' input[name="ok_qty"]').val());
	var lot_qty 	= parseFloat($('#'+frm_production_edit+' input[name="lot_qty"]').val());
	var ng_qty 		= lot_qty  - ok_qty;
	
	$('#'+frm_production_edit+' input[name="ng_qty"]').val(ng_qty);
	
	if($('#'+frm_production_edit+' input[name="ng_qty"]').val() == 0 || $('#'+frm_production_edit+' input[name="ng_qty"]').val() == "") {
		$('#'+frm_production_edit+' .fa-plus').prop("disabled", true);
	} else {
		$('#'+frm_production_edit+' .fa-plus').prop("disabled", false);
	}
});

$('#'+frm_production_edit+' input[name="ng_qty"]').keyup(function(e) {
	if($(this).val() == 0 || $(this).val() == "") {
		$('#'+frm_production_edit+' .fa-plus').prop("disabled", true);
	} else {
		$('#'+frm_production_edit+' .fa-plus').prop("disabled", false);
	}
	
	var ng_qty 		= parseFloat($('#'+frm_production_edit+' input[name="ng_qty"]').val());
	var lot_qty 	= parseFloat($('#'+frm_production_edit+' input[name="lot_qty"]').val());
	var ok_qty 		= lot_qty  - ng_qty;
	
	$('#'+frm_production_edit+' input[name="ok_qty"]').val(ok_qty);
});

$('#'+frm_production_edit+' button[name="add_mode_defect"]').click(function() {
	if($(this).attr('class') == 'btn btn-primary fa fa-plus') {
		$('#'+mdl_prdn_mode_defect_edit).data('id', fklon);
		$('#'+frm_prdn_mode_defect_edit+' table tbody').empty();
		var fklon 		= $('#'+mdl_production_edit).data('id');
		var tbl_body	= '';
		for(var i=0; i<mode_defect_array.length; i++) {
			tbl_body += '<tr>';
			tbl_body += '	<td>'+mode_defect_array[i]+'</td>';
			tbl_body += '	<td><a href="#" class="fa fa-remove"> Remove</a></td>';
			tbl_body += '</tr>';
		}
		$('#'+frm_prdn_mode_defect_edit+' table tbody').append(tbl_body);
		$('#'+mdl_prdn_mode_defect_edit).modal();
	} else if($(this).attr('class') == 'btn btn-default fa fa-eye') {
		var fklon 		= $('#'+mdl_inspector_production).data('id');
		$('#'+mdl_prdn_mode_defect_view).data('id', fklon);
		$('#'+mdl_prdn_mode_defect_view+' table tbody').empty();
		var tbl_body	= '';
		for(var i=0; i<mode_defect_array.length; i++) {
			tbl_body += '<tr>';
			tbl_body += '	<td>'+mode_defect_array[i]+'</td>';
			tbl_body += '</tr>';
		}
		$('#'+mdl_prdn_mode_defect_view+' table tbody').append(tbl_body);
		$('#'+mdl_prdn_mode_defect_view).modal();
	}
	
});

// $('#'+frm_production_edit+' button[name="add_mode_defect"].fa-eye').click(function() {	
	// var fklon 		= $('#'+mdl_inspector_production).data('id');
	// $('#'+mdl_prdn_mode_defect_view).data('id', fklon);
	// $('#'+mdl_prdn_mode_defect_view+' table tbody').empty();
	// var tbl_body	= '';
	// for(var i=0; i<mode_defect_array.length; i++) {
		// tbl_body += '<tr>';
		// tbl_body += '	<td>'+mode_defect_array[i]+'</td>';
		// tbl_body += '</tr>';
	// }
	// $('#'+mdl_prdn_mode_defect_view+' table tbody').append(tbl_body);
	// $('#'+mdl_prdn_mode_defect_view).modal();
// });

$('#'+frm_prdn_mode_defect_edit).on('submit', function(e) {
	e.preventDefault();
	var html_body  = '<tr>';
		html_body += '<td>'+$('#'+frm_prdn_mode_defect_edit+' input[name="mode_defect"]').val()+'</td>';
		html_body += '<td><a href="#" class="fa fa-remove"> Remove</a></td>';
		html_body += '</tr>';
	$('#'+frm_prdn_mode_defect_edit+' table tbody').append(html_body);
	$('#'+frm_prdn_mode_defect_edit+' input').val('');
	$('#'+frm_prdn_mode_defect_edit+' input[name="mode_defect"]').focus();
});

$('#'+frm_prdn_mode_defect_edit+' table tbody').on('click' , 'a', function(){
	$(this).closest('tr').remove();
	return false;
});

$('#'+frm_production_edit).on('submit', function(e) {
	e.preventDefault();
	$('.btn').prop("disabled",true);
	var mode_defect = [];
	$('#'+frm_prdn_mode_defect_edit+' table tbody tr').each(function() {
		mode_defect.push( $(this).find('td:eq(0)').text() );
	});
	var serialized_data = new FormData(this);
		serialized_data.append("action","edit_production_disposition");
		serialized_data.append("fklon", $('#'+mdl_production_edit).data('id') );
		serialized_data.append("mode_defect",mode_defect);
		serialized_data.append("username",username);
	fn_save_production_disposition(serialized_data, mdl_production_edit, frm_production_edit);
});

$('#'+mdl_production_edit+' .fa-paperclip').click(function() {
	var type = $(this).data('id');
	window.location.href = "./pages/oqc/dl_oqc_lon.php?id="+$(this).val()+'&type='+type;
});	

function fn_get_mode_defect_details(fklon, action, modal_id){
	mode_defect_array = [];
	var data = {
		"action"	: "get_mode_defect_details",
		"fklon"		: fklon
	}
	call_ajax(data, handler_lon, function(result){
		var mode_defect = result['mode_defect'];
		for(var i=0; i<mode_defect.length; i++) {
			mode_defect_array.push(mode_defect[i]);
		}
		if(mode_defect == '') {
			$('#'+modal_id+' button[name="add_mode_defect"]').prop('disabled', true);
		} else {
			$('#'+modal_id+' button[name="add_mode_defect"]').prop('disabled', false);
		}
		if(action == 'edit') {
			$('#'+modal_id+' button[name="add_mode_defect"]').attr('class','btn btn-primary fa fa-plus');
		} else {
			$('#'+modal_id+' button[name="add_mode_defect"]').attr('class','btn btn-default fa fa-eye');
		}
	});
}

/* EDIT - end */

/* VIEW - start */
$('#' + tbl_oqc_lon_production + ' tbody').on('click','tr .fa-eye',function(){
	var pkid 	= $(this).attr("id");		
	var row 	= $(this).closest("tr");	
	var status  = row.find('td:eq(0) input').val();
	
	if(status == "CONFORMED BY OQC INSPECTOR") {
		$('#'+mdl_inspector_production+' .fa-thumbs-o-up').hide();
		$('#'+mdl_inspector_production+' .fa-thumbs-o-down').hide();
		
		fn_get_oqc_lon_details(pkid, mdl_inspector_production, frm_inspector_production);
		$('#'+mdl_inspector_production).data('id',pkid);
		$('#'+mdl_inspector_production+' input[type="file"]').hide();
		$('#'+mdl_inspector_production).modal('show');
		$('#'+mdl_inspector_production + ' #lon_container_message').hide();
	} else {
		$('#'+mdl_production_edit+' input[type="file"]').hide();
		$('#'+mdl_production_edit+' .fa-save').hide();
		$('#'+mdl_production_edit+' .modal-title').html('<i class="fa fa-eye"></i> View CAPA Report');		
		fn_get_oqc_lon_details(pkid, mdl_production_edit, frm_production_edit);
		fn_get_mode_defect_details(pkid, 'view', mdl_production_edit);
		$('#'+mdl_production_edit).data('id',pkid);
		$('#'+mdl_production_edit).modal('show');
		$('#'+mdl_production_edit + ' #lon_container_message').hide();
	}
});

$('#' + tbl_oqc_lon_production + ' tbody').on('click','tr .fa-file-excel-o',function(){
	var pkid 	= $(this).attr("id");	
	window.location.href = "./reports/oqc/excel_oqc_lon.php?id="+pkid;
});

/* VIEW - end */


/* CANCEL - start */
$('#' + tbl_oqc_lon_production + ' tbody').on('click','tr .fa-close',function(){
	var pkid 	= $(this).attr("id");	
	var row 	= $(this).closest('tr');
	
	$('#'+mdl_lon_cancel_message).data('id',pkid);
	$('#'+mdl_lon_cancel_message).data('status','CANCELLED BY PRODUCTION');
	$('#'+mdl_lon_cancel_message).modal('show');
});

/* CANCEL - end */

/* *************************************************
	Lot-out Notice - Production Functions - End
************************************************** */

/* *************************************************
	Lot-out Notice - LQC Inspector - Conformance Functions (from Production) - Start
************************************************** */

var frm_inspector_production			= 'frm_lqc_inspector_production';
var mdl_inspector_production			= 'modal_lon_lqc_inspector_production_view';
var frm_lqc_inspector_conformance		= 'frm_lon_inspector_conformance_decision';
var mdl_lqc_inspector_conformance		= 'modal_lon_inspector_conformance_message';

$('#' + tbl_oqc_lon_lqc_inspector + ' tbody').on('click','tr .fa-tasks',function(){
	var pkid 	= $(this).attr("id");	
	var row 	= $(this).closest('tr');
	var status  = row.find('td:eq(0)').text();
	if(status == ' FOR CONFORMANCE') {
		$('#'+mdl_inspector_production+' .fa-thumbs-o-up').show();
		$('#'+mdl_inspector_production+' .fa-thumbs-o-down').show();
	} else {
		$('#'+mdl_inspector_production+' .fa-thumbs-o-up').hide();
		$('#'+mdl_inspector_production+' .fa-thumbs-o-down').hide();
	}
	
	fn_get_oqc_lon_details(pkid, mdl_inspector_production, frm_inspector_production);
	fn_get_mode_defect_details(pkid, 'view', mdl_inspector_production);
	$('#'+mdl_inspector_production).data('id',pkid);
	$('#'+mdl_inspector_production).modal('show');
	$('#'+mdl_inspector_production + ' #lon_container_message').hide();
	
	// $frm_oqc_capa_monitoring.find('#oqc_lon_id').val(pkid);
});

$('#'+frm_inspector_production+' button[name="add_mode_defect"]').click(function() {	
	var fklon 		= $('#'+mdl_inspector_production).data('id');
	$('#'+mdl_prdn_mode_defect_view).data('id', fklon);
	$('#'+mdl_prdn_mode_defect_view+' table tbody').empty();
	var tbl_body	= '';
	for(var i=0; i<mode_defect_array.length; i++) {
		tbl_body += '<tr>';
		tbl_body += '	<td>'+mode_defect_array[i]+'</td>';
		tbl_body += '</tr>';
	}
	$('#'+mdl_prdn_mode_defect_view+' table tbody').append(tbl_body);
	$('#'+mdl_prdn_mode_defect_view).modal();
});

$('#'+mdl_inspector_production+' .fa-paperclip').click(function() {	
	window.location.href = "./pages/oqc/dl_oqc_lon.php?id="+$(this).val()+'&type=inspector';
});	

// === Re upload === 
$('#'+mdl_inspector_production+' .re-upload').click(function() {	
	$('#form_lon_file_re_upload').find('#tbl_oqc_lon_production_id').val($(this).val());
	$('#modal_lon_file_re_upload').modal();
});	

$('#form_lon_file_re_upload').submit(function (e) { 
	e.preventDefault();
	let serialized_data = new FormData(this);
		serialized_data.append( "action","lon_file_re_upload" );
		serialized_data.append( "tbl_oqc_lon_production_id", $( '#form_lon_file_re_upload').find('#tbl_oqc_lon_production_id').val() );
		serialized_data.append( "username",username );
	call_ajax_attachment(serialized_data, handler_lon, function(result) {
		if(result.is_success === 'true'){
			$('#modal_lon_file_re_upload').modal('hide');
			notif_success(result.message);
		}else{
			notif_success(result.message);
		}
	});
});

$('#'+mdl_inspector_production+' .fa-thumbs-o-up').click(function() {
	if($('#'+mdl_inspector_production+' #treatment').val() == '' || $('#'+mdl_inspector_production+' #verification_result').val() == '') {
		$('#'+mdl_inspector_production + ' #container_inspector_message').show();
	} else {
		$('#'+mdl_inspector_production + ' #container_inspector_message').hide();
		$('#'+mdl_lqc_inspector_conformance + ' #container_approver_message').attr('class','alert alert-success');
		$('#'+mdl_lqc_inspector_conformance + ' #container_approver_message').html('Are you sure you want to verify and conform the request?<br><br>Remarks:<textarea name="conform_by_remarks" style="width:100%;" rows="4"></textarea>');
		$('#'+mdl_lqc_inspector_conformance + ' #container_approver_message').show();
		$('#'+mdl_lqc_inspector_conformance).modal();
	}
});	

$('#'+mdl_inspector_production+' .fa-thumbs-o-down').click(function() {	
	$('#'+mdl_lqc_inspector_conformance + ' #container_approver_message').attr('class','alert alert-danger');
	$('#'+mdl_lqc_inspector_conformance + ' #container_approver_message').html('Are you sure you want to reject the request?<br><br>Remarks:<textarea name="conform_by_remarks" style="width:100%;" rows="4" required></textarea>');
	$('#'+mdl_lqc_inspector_conformance + ' #container_approver_message').show();
	$('#'+mdl_lqc_inspector_conformance).modal();
});	

$('#'+frm_lqc_inspector_conformance).on('submit', function(e) {
	e.preventDefault();
	$('.btn').prop("disabled",true);
	var decision = $('#'+mdl_lqc_inspector_conformance + ' #container_approver_message').attr('class');
	if(decision == 'alert alert-success') {
		var status = 'CONFORM';
	} else if(decision == 'alert alert-danger') {
		var status = 'REJECT';
	} 
	$('#'+mdl_inspector_production).modal('hide');
	fn_save_lqc_inspector_conformance_decision(status, mdl_lqc_inspector_conformance, frm_lqc_inspector_conformance);
});	

function fn_save_lqc_inspector_conformance_decision(decision, modal_id, form_id) {
	var serialized_data = $('#'+form_id).serialize();
	var data = {
		"action"				: "save_lqc_inspector_conformance_decision",
		"pkid"					: $('#'+mdl_inspector_production).data('id'),
		"treatment"				: $('#'+mdl_inspector_production+' #treatment').val(),
		"verification_result"	: $('#'+mdl_inspector_production+' #verification_result').val(),
		"decision"				: decision,
		"username"				: username,
	}
	call_ajax_serialize(data, serialized_data, handler_lon, function(result) {
		$('#'+modal_id).modal('hide');
		$('#modal_system_message').modal();
		$('#container_message').attr('class','alert alert-success');
		$('#container_message').html( '<h4>'+result['msg']+'</h4>' );
		$('.btn').prop("disabled",false);
		fn_reload_lon_datatables();
	});
}

/* *************************************************
	Lot-out Notice - LQC Inspector - Conformance Functions (from Production) - End
************************************************** */





/* *************************************************
	Lot-out Notice - Common Functions - Start
************************************************** */

function fn_get_oqc_lon_details(pkid,modal_id,frm_id){
	var lot_qty 	= 0;
	var sample_size = 0;
	var sorted_qty 	= 0;
	var data = {
		"action"	: "get_lon_details_by_pkid",
		"action2"	: "add",
		"pkid"		: pkid
	}
	call_ajax(data, handler_lon, function(result){
		if(result['status'] == 'CONFORMED BY OQC INSPECTOR'){ //show Add CAPA Monitoring 
			$('#add_capa_monitoring').show();
		}else{
			$('#add_capa_monitoring').hide();
		}
		$.each(result['data'][0],function(key, value){
			$('#'+frm_id+' input[name="'+key+'"]').val(value);
			$('#'+frm_id+' button[name="'+key+'"]').val(value);
			$('#'+frm_id+' textarea[name="'+key+'"]').val(value);
			// if(key == 'po_number' && value != "") {
				// var array_fields = [
					// 'input[name="device_name"]'
				// ]
				// fn_get_po_details(value,frm_id,array_fields);
			// } 
			if(key == 'created_by' && value != "") {
				fn_get_emp_name_by_username(value, frm_id+' #'+key);
			} 
			if(key == 'checked_by' && value != "") {
				fn_get_emp_name_by_username(value, frm_id+' #'+key);
			} 
			if(key == 'verified_by' && value != "") {
				fn_get_emp_name_by_username_array(value, frm_id+' #'+key);
			} 
			if(key == 'approved_by' && value != "") {
				fn_get_emp_name_by_username(value, frm_id+' #'+key);
			} 
			if(key == 'attention' && value != "") {
				fn_get_emp_name_by_username_array(value, frm_id+' #'+key);
			} 
			if(key == 'cc') {
				assign_value_select2('#'+frm_id+' #cmb_cc',result['data'][0]['cc']);				
				re_initialize_select2_server_side('#'+modal_id+' #cmb_cc','#'+modal_id,[],"server_side_scripts/dropdown/common/dd_hris_all_list.php");
			} 
			if(key == 'lot_qty' && value != "") {
				lot_qty = value;
				if(frm_id == 'frm_lqc_production_add') {
					if(sample_size != 0 || lot_qty != 0) {
						sorted_qty = lot_qty - sample_size;
						$('#'+frm_id+' input[name="sorted_qty"]').val(sorted_qty);  
					}
				}					
			} 
			if(key == 'sample_size' && value != "") {
				sample_size = value;
				if(frm_id == 'frm_lqc_production_add') {
					if(sample_size != 0 || lot_qty != 0) {
						sorted_qty = lot_qty - sample_size;
						$('#'+frm_id+' input[name="sorted_qty"]').val(sorted_qty);  
					}
				}	
			} 
		});
		
		if(result['data_1'] == 'HAVE DATA') {
			$.each(result['data'][1],function(key, value){
				$('#'+frm_id+' input[name="'+key+'"]').val(value);
				$('#'+frm_id+' textarea[name="'+key+'"]').val(value);
			});
		}
		$('#'+frm_id+' input[name="lon_no"]').val(result['lon_no_w_rev']);
		fn_check_inspector_attachment(modal_id, pkid)
		dt_oqc_lon_capa_monitoring.ajax.url("server_side_scripts/oqc/dt_lon_lqc_inspector_capa_monitoring.php?username="+username +"&"+ "oqc_lon_id="+pkid).draw();
	});
}

function fn_get_oqc_lon_details_edit(pkid,modal_id,frm_id){
	var data = {
		"action"	: "get_lon_details_by_pkid",
		"action2"	: "edit",
		"pkid"		: pkid
	}
	call_ajax(data, handler_lon, function(result){
		
		$.each(result['data'][0],function(key, value){
			$('#'+frm_id+' input[name="'+key+'"]').val(value);
			$('#'+frm_id+' button[name="'+key+'"]').val(value);
			$('#'+frm_id+' textarea[name="'+key+'"]').val(value);
			if(key != "attention"){
				$('#'+frm_id+' select[name="'+key+'"]').val(value);
			}			
			// if(key == 'po_number' && value != "") {
				// var array_fields = [
					// 'input[name="device_name"]'
				// ]
				// fn_get_po_details(value,frm_id,array_fields);
			// }
		});
		assign_value_select2('#'+frm_id+' #cmb_attention',result['data'][0]['attention']);
		assign_value_select2('#'+frm_id+' #cmb_verified_by',result['data'][0]['verified_by']);
		assign_value_select2('#'+frm_id+' #cmb_operator',result['data'][0]['operator']);
		assign_value_select2('#'+frm_id+' #cmb_checked_by',result['data'][0]['checked_by']);
		assign_value_select2('#'+frm_id+' #cmb_approved_by',result['data'][0]['approved_by']);
		assign_value_select2('#'+frm_id+' #cmb_cc',result['data'][0]['cc']);
		re_initialize_select2_server_side('#'+modal_id+' #cmb_attention','#'+modal_id,[],"server_side_scripts/dropdown/common/dd_hris_below_ss_list.php");
		re_initialize_select2_server_side('#'+modal_id+' #cmb_verified_by','#'+modal_id,[],"server_side_scripts/dropdown/common/dd_hris_below_ss_list.php");
		re_initialize_select2_server_side('#'+modal_id+' #cmb_operator','#'+modal_id,[],"server_side_scripts/dropdown/common/dd_operator_list.php");
		re_initialize_select2_server_side('#'+modal_id+' #cmb_checked_by','#'+modal_id,[],"server_side_scripts/dropdown/common/dd_hris_above_ss_list.php");
		re_initialize_select2_server_side('#'+modal_id+' #cmb_approved_by','#'+modal_id,[],"server_side_scripts/dropdown/common/dd_hris_above_ss_list.php");
		re_initialize_select2_server_side('#'+modal_id+' #cmb_cc','#'+modal_id,[],"server_side_scripts/dropdown/common/dd_hris_all_list.php");
		
		if(result['data_1'] == 'HAVE DATA') {
			$.each(result['data'][1],function(key, value){
				$('#'+frm_id+' input[name="'+key+'"]').val(value);
				$('#'+frm_id+' textarea[name="'+key+'"]').val(value);
			});
		} 
		$('#'+frm_id+' input[name="lon_no"]').val(result['lon_no_w_rev']);
		fn_check_inspector_attachment(modal_id, pkid);
	});
}

function fn_ng_get_recipients_list(cmb_id, callback) {
	$('#'+cmb_id).empty();
	var data = {
		"action" 		: "get_email_recipients_list"
	} 
	call_ajax(data, handler_lon, function(result){
		$('#'+cmb_id).append( '<option>-</option>' );
		$('#'+cmb_id).append( result['html_select'] );
		callback();
	});
}

function fn_check_inspector_attachment(mdl_id, pkid) {
	var data = {
		"action" 	: "check_inspector_attachment",
		"pkid" 		: pkid
	} 
	call_ajax(data, handler_lon, function(result){
		console.log(result);
		if(result['inspector'] == 0) {
			$('#'+mdl_id+' [data-id=inspector]').prop('disabled',true);
		} else {
			$('#'+mdl_id+' [data-id=inspector]').prop('disabled',false);
		}
		if(result['production'] == 0) {
			$('#'+mdl_id+' [data-id=production]').prop('disabled',true);
		} else {
			$('#'+mdl_id+' [data-id=production]').prop('disabled',false);
		}
	});
}

function fn_lon_display_modal_by_status(status, pkid) {
	if(status == "UPLOADED DISPOSITION") {
		$('#'+mdl_production_edit+' .fa-thumbs-o-up').hide();
		$('#'+mdl_production_edit+' .fa-thumbs-o-down').hide();
		$('#'+mdl_production_edit+' input[type="file"]').hide();
		$('#'+mdl_production_edit+' .fa-save').hide();
		$('#'+mdl_production_edit+' .modal-title').html('<i class="fa fa-eye"></i> View CAPA Report');		
		fn_get_oqc_lon_details(pkid, mdl_production_edit, frm_production_edit);
		fn_get_mode_defect_details(pkid, 'view', mdl_production_edit);
		$('#'+mdl_production_edit).data('id',pkid);
		$('#'+mdl_production_edit).modal('show');
		$('#'+mdl_production_edit + ' #lon_container_message').hide();
	} else if(status == "CONFORMED BY OQC INSPECTOR") {
		$('#'+mdl_inspector_production+' .fa-thumbs-o-up').hide();
		$('#'+mdl_inspector_production+' .fa-thumbs-o-down').hide();
		
		fn_get_oqc_lon_details(pkid, mdl_inspector_production, frm_inspector_production);
		$('#'+mdl_inspector_production).data('id',pkid);
		$('#'+mdl_inspector_production+' input[type="file"]').hide();
		$('#'+mdl_inspector_production).modal('show');
		$('#'+mdl_inspector_production + ' #lon_container_message').hide();
	} else {
		return true;
	}
}

function fn_reload_lon_datatables() {
	dt_oqc_lon_lqc_inspector.ajax.reload();
	dt_oqc_lon_lqc_supervisor.ajax.reload();
	dt_oqc_lon_lqc_manager.ajax.reload();
	dt_oqc_lon_production.ajax.reload();
}

var dateFrom =  $('#frm_lon_report').find('#date_from');
var dateTo =  $('#frm_lon_report').find('#date_to');

dateFrom.on('change', function() {
	let fromDate = $(this).val();
	// Set the minimum value of the "date to" input to the selected "date from" value
	dateTo.attr('min', fromDate);
	dateTo.prop('readonly', false);
});

dateTo.on('change', function() {
	let toDate = $(this).val();
	let fromDate = dateFrom.val();

	if (toDate < fromDate) {
		alert('The "Date To" cannot be earlier than the "Date From".');
		$(this).val(fromDate);
	}
});

/* *************************************************
	Lot-out Notice - Common Functions - End
************************************************** */

