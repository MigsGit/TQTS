/* ***************************
	CAPA QS Inspector Main Table - Start
*************************** */

var tbl_capa_external   	= 'tbl_capa_external';
var dt_external 			= '';

if(dt_external == '') {
	dt_external = $('#'+tbl_capa_external).DataTable({
		"aaSorting"	 : [],	
		"bProcessing": true,
		"bServerSide": true,
		"sAjaxSource": "server_side_scripts/qr/dt_capa_dashboard.php",
		"drawCallback": function( settings ) {
			$('#'+tbl_capa_external).attr('style','width:100%;');
		}
	});
}

/* ***************************
	CAPA QS Inspector Main Table - End
*************************** */
/* ***************************
	CAPA QS Inspector Main Table - Start
*************************** */

var mdl_capa_system_message    	= 'modal_capa_system_message';
var tbl_qs_inspector    		= 'tbl_capa_qs_inspector';
var dt_qs_inspector 			= '';
var mdl_qs_inspector_ext_new	= 'modal_capa_qs_inspector_external_new';
var frm_qs_inspector_ext_new	= 'frm_capa_qs_inspector_external_new';
var mdl_qs_inspector_int_new	= 'modal_capa_qs_inspector_internal_new';
var frm_qs_inspector_int_new	= 'frm_capa_qs_inspector_internal_new';
var modal_capa_add_correction	= 'modal_capa_add_correction';
var frm_capa_add_correction		= 'frm_capa_add_correction';

if(dt_qs_inspector == '') {
	dt_qs_inspector = $('#'+tbl_qs_inspector).DataTable({
		"aaSorting"	 : [],	
		"bProcessing": true,
		"bServerSide": true,
		"sAjaxSource": "server_side_scripts/qr/dt_capa_qs_inspector.php?username="+username,
		"drawCallback": function( settings ) {
			$('#'+tbl_qs_inspector).attr('style','width:100%;');
		}
	});
}

$('.dropdown-menu li a').click(function() {
	var keyword = $(this).text();
	if(keyword == ' External') {
		load_new(mdl_qs_inspector_ext_new, frm_qs_inspector_ext_new);
		$('#'+mdl_qs_inspector_ext_new).modal('show');
	} else {
		load_new(mdl_qs_inspector_int_new, frm_qs_inspector_int_new);
		$('#'+mdl_qs_inspector_int_new).modal('show');
	}
});

/* Internal */
$('#'+frm_qs_inspector_int_new+' #fklink_subsystem').change(function() {
	if($(this).val() != '') {
		fn_get_8d_po_list('', frm_qs_inspector_int_new+' #list_reference_po');
	}
});

$('#'+frm_qs_inspector_int_new+' #section').change(function() {
	if($(this).val() != '') {
		fn_get_qad_incharge(frm_qs_inspector_int_new, $(this).val());
	}
});

$('#'+frm_qs_inspector_int_new+' input[name="fklink_id"]').keyup(function(e){
	var pattern = $(this).val();
	if($('#'+frm_qs_inspector_int_new+' #fklink_subsystem').val() != '') {		
		fn_get_8d_po_list(pattern, frm_qs_inspector_int_new+' #list_reference_po');
	}
});

$('#'+frm_qs_inspector_int_new+' #btn_add_correction').click(function() {
	$('#'+frm_capa_add_correction+' #mdl_id_append').val(mdl_qs_inspector_int_new);
	re_initialize_select2_server_side('#'+modal_capa_add_correction+' #incharge_person','#'+modal_capa_add_correction+' #'+frm_capa_add_correction,[],"server_side_scripts/dropdown/common/dd_hris_all_list.php");	
	$('#'+modal_capa_add_correction).modal('show');
});

$('#'+mdl_qs_inspector_int_new+' #tbl_correction_list tbody').on('click', 'button[type="button"]', function() {
	$(this).closest('tr').remove();
	return false;
});
monitoring_type
$('#'+mdl_qs_inspector_int_new+' #tbl_corrective_action_list tbody').on('click', 'button[type="button"]', function() {
	$(this).closest('tr').remove();
	return false;
});

$('#'+frm_qs_inspector_int_new).submit(function(e) {
	e.preventDefault();
	var serialized_data = new FormData(this);
	if(fn_validate_correction(mdl_qs_inspector_int_new)) {
		$('.btn').prop("disabled",true);
		/* Add main data */
		$('#'+frm_qs_inspector_int_new+' #container_capa_production_new_message').hide();		
		serialized_data.append("action", "save_capa_report");
		serialized_data.append("classification", "Internal");
		serialized_data.append("username", username);
		fn_save_capa_report(mdl_qs_inspector_int_new, frm_qs_inspector_int_new, serialized_data);
	} else {
		$('#'+frm_qs_inspector_int_new+' #container_capa_production_new_message').empty();
		$('#'+frm_qs_inspector_int_new+' #container_capa_production_new_message').append('No Correction or Corrective action found!');
		$('#'+frm_qs_inspector_int_new+' #container_capa_production_new_message').show();
	}
});
/* Internal */

$('#'+frm_qs_inspector_ext_new+' #fklink_subsystem').change(function() {
	if($(this).val() != '') {
		fn_get_8d_po_list('', frm_qs_inspector_ext_new+' #list_reference_po');
	}
});

$('#'+frm_qs_inspector_ext_new+' #section').change(function() {
	if($(this).val() != '') {
		fn_get_qad_incharge(frm_qs_inspector_ext_new, $(this).val());
	}
});

$('#'+frm_qs_inspector_ext_new+' input[name="fklink_id"]').keyup(function(e){
	var pattern = $(this).val();
	if($('#'+frm_qs_inspector_ext_new+' #fklink_subsystem').val() != '') {		
		fn_get_8d_po_list(pattern, frm_qs_inspector_ext_new+' #list_reference_po');
	}
});

$('#'+frm_qs_inspector_ext_new+' #btn_add_correction').click(function() {
	$('#'+frm_capa_add_correction+' #mdl_id_append').val(mdl_qs_inspector_ext_new);
	re_initialize_select2_server_side('#'+modal_capa_add_correction+' #incharge_person','#'+modal_capa_add_correction+' #'+frm_capa_add_correction,[],"server_side_scripts/dropdown/common/dd_hris_all_list.php");	
	$('#'+modal_capa_add_correction).modal('show');
});

$('#'+frm_capa_add_correction).submit(function(e) {
	e.preventDefault();
	var mdl_id 				= $('#mdl_id_append').val();
	var monitoring_type 	= $('#monitoring_type').val();
	var correction_action 	= $('#correction_action').val();
	var incharge_person 	= $('#incharge_person').val();
	var due_date 			= $('#due_date').val();

	var html_table			= '<tr>';
		html_table		   += '<td>'+correction_action+'</td>';
		html_table		   += '<td>'+incharge_person+'</td>';
		html_table		   += '<td>'+due_date+'</td>';
		html_table		   += '<td><button type="button" class="btn btn-danger fa fa-remove"></button></td>';
		html_table		   += '</tr>';
		
	if(monitoring_type == 'correction') {
		$('#'+mdl_id+' #tbl_correction_list').append(html_table);
	} else if(monitoring_type == 'corrective_action') {
		$('#'+mdl_id+' #tbl_corrective_action_list').append(html_table);
	} 	
	$('#'+frm_capa_add_correction+' textarea').val('');
});

$('#'+mdl_qs_inspector_ext_new+' #tbl_correction_list tbody').on('click', 'button[type="button"]', function() {
	$(this).closest('tr').remove();
	return false;
});

$('#'+mdl_qs_inspector_ext_new+' #tbl_corrective_action_list tbody').on('click', 'button[type="button"]', function() {
	$(this).closest('tr').remove();
	return false;
});

$('#'+frm_qs_inspector_ext_new).submit(function(e) {
	e.preventDefault();
	var serialized_data = new FormData(this);
	if(fn_validate_correction(mdl_qs_inspector_ext_new)) {
		$('.btn').prop("disabled",true);
		/* Add main data */
		$('#'+frm_qs_inspector_ext_new+' #container_capa_production_new_message').hide();		
		serialized_data.append("action", "save_capa_report");
		serialized_data.append("classification", "External");
		serialized_data.append("username", username);
		fn_save_capa_report(mdl_qs_inspector_ext_new, frm_qs_inspector_ext_new, serialized_data);
		
		
		
	} else {
		$('#'+frm_qs_inspector_ext_new+' #container_capa_production_new_message').empty();
		$('#'+frm_qs_inspector_ext_new+' #container_capa_production_new_message').append('No Correction or Corrective action found!');
		$('#'+frm_qs_inspector_ext_new+' #container_capa_production_new_message').show();
	}
});

function fn_get_qad_incharge(frm_id, section) {
	var data = {
		"action"				: "return_qad_incharge_by_section",
		"section"				: section
	}
	call_ajax(data, handler_qfr_capa, function(result){	
		assign_value_select2('#'+frm_id+' #operations_qe',result['assigned_staffs']);	
	});
}

function fn_validate_correction(mdl_id) {
	if(($('#'+mdl_id+' #tbl_correction_list >tbody >tr').length) == 0 && ($('#'+mdl_id+' #tbl_corrective_action_list >tbody >tr').length == 0)) {
		return false;
	} else {
		return true;
	}
}

function fn_save_capa_report(mdl_id_new, frm_id_new, serialized_data){
	call_ajax_attachment( serialized_data, handler_qfr_capa, function(result){
		console.log(result);		
		$('.btn').prop("disabled",false);
		/* Add correction data */
		fn_save_correction(mdl_id_new, frm_id_new, result['pkid']);
	});
}

function fn_save_correction(mdl_id_new, frm_id_new, pkid) {
	var monitoring_type 	= new Array();
	var correction_action 	= new Array();
	var incharge_person 	= new Array();
	var due_date 			= new Array();
	if($('#'+mdl_id_new+' #tbl_correction_list >tbody >tr').length != 0) {
		$('#'+mdl_id_new+' #tbl_correction_list tbody tr').each(function() {
			monitoring_type.push("CORRECTION");
			correction_action.push($(this).find('td:eq(0)').text());
			incharge_person.push($(this).find('td:eq(1)').text());
			due_date.push($(this).find('td:eq(2)').text());
		});
	}
	if($('#'+mdl_id_new+' #tbl_corrective_action_list >tbody >tr').length != 0) {
		$('#'+mdl_id_new+' #tbl_corrective_action_list tbody tr').each(function() {
			monitoring_type.push("CORRECTIVE");
			correction_action.push($(this).find('td:eq(0)').text());
			incharge_person.push($(this).find('td:eq(1)').text());
			due_date.push($(this).find('td:eq(2)').text());
		});
	}
	var data = {
		"action"				: "save_correction",
		"pkid"					: pkid,
		"monitoring_type"		: monitoring_type,
		"correction_action"		: correction_action,
		"incharge_person"		: incharge_person,
		"due_date"				: due_date,
		"username"				: username
	}
	call_ajax(data, handler_qfr_capa, function(result){	
		$('.modal').modal('hide');
		$('#modal_system_message').modal();
		$('#container_message').attr('class','alert alert-success');
		$('#container_message').html( '<h4>'+result['msg']+'</h4>' );
		$('.btn').prop("disabled",false);
		fn_capa_reload_datatables();
		console.log(result);
	});
}

/* ***************************
	CAPA QS Inspector Main Table - End
*************************** */
/* ***************************
	CAPA QS Inspector Add Monitoring - Start
*************************** */
var mdl_qs_insp_ext_add_moni	= 'modal_capa_qs_inspector_external_1st_monitoring';
var frm_qs_insp_ext_add_moni	= 'frm_capa_qs_inspector_external_add_monitoring';
var mdl_add_monitoring			= 'modal_capa_add_monitoring';
var frm_add_monitoring			= 'frm_capa_add_monitoring';

$('#'+ tbl_qs_inspector +' tbody').on('click','tr .fa-plus', function(){
	var pkid = $(this).data('id');
	load_new(mdl_qs_insp_ext_add_moni, frm_qs_insp_ext_add_moni);
	fn_get_capa_main_details(mdl_qs_insp_ext_add_moni, frm_qs_insp_ext_add_moni, pkid);
	fn_get_capa_1st_monitoring_details(mdl_qs_insp_ext_add_moni, frm_qs_insp_ext_add_moni, pkid, 'inspector');
	$('#'+mdl_qs_insp_ext_add_moni).modal('show');
 });
 
$('#'+mdl_qs_insp_ext_add_moni+' .fa-paperclip').click(function() {
	window.location.href = "./pages/qfr/dl_capa_attachments.php?id="+$(this).val()+"&fk_cor="+$(this).data('fk')+"&type=main&user=qs&order=";
});

$('#'+frm_qs_insp_ext_add_moni+' #tbl_monitoring tbody').on('click' , 'a', function(){
	window.location.href = "./pages/qfr/dl_capa_attachments.php?id="+$(this).data('id')+"&fk_cor="+$(this).data('fk')+"&type=validation&val=1&user=qs&order="+$(this).data('order');
	return false;
});
 
$('#'+ frm_qs_insp_ext_add_moni +' #btn_add_monitoring').click(function(){
	var fk_capa = $(this).val();
	$('#'+frm_add_monitoring+' #tbl_id').val('tbl_qfr_capa_1st_monitoring');
	$('#'+frm_add_monitoring+' #mdl').val('modal_capa_qs_inspector_external_1st_monitoring');
	$('#'+frm_add_monitoring+' #frm').val('frm_capa_qs_inspector_external_add_monitoring');
	$('#'+frm_add_monitoring+' #user').val('qs');
	$('#'+mdl_add_monitoring).data('id', fk_capa);
	re_initialize_select2_server_side('#'+mdl_add_monitoring+' #correction_list','#'+mdl_add_monitoring+' #'+frm_add_monitoring,[],"server_side_scripts/dropdown/qfr/dd_capa_correction_list.php?fk_capa="+fk_capa);	
	re_initialize_select2_server_side('#'+mdl_add_monitoring+' #monitoring_by','#'+mdl_add_monitoring+' #'+frm_add_monitoring,[],"server_side_scripts/dropdown/common/dd_hris_above_ss_list.php");	
	$('#'+mdl_add_monitoring).modal('show');
 });

 $('#'+frm_add_monitoring+' select[name="fk_capa_correction"]').change(function() {
	fn_set_monitoring_date_minimum($('#'+mdl_add_monitoring).data('id'), $(this).val(), frm_add_monitoring, $('#'+frm_add_monitoring+' input[name="user"]').val(), $('#'+frm_add_monitoring+' input[name="tbl_id"]').val());
 });
 
 $('#'+frm_add_monitoring).submit(function(e) {
	e.preventDefault();
	
	var serialized_data = new FormData(this);
		serialized_data.append("action", "save_monitoring_validation");
		serialized_data.append("fk_capa", $('#'+mdl_add_monitoring).data('id'));
		serialized_data.append("username", username);
	fn_add_monitoring(serialized_data, mdl_add_monitoring);
});

function fn_set_monitoring_date_minimum(fk_capa, fk_capa_correction, frm_id, user, tbl_id) {
	var data = {
		"action"				: "get_monitoring_date_minimum",
		"fk_capa"				: fk_capa,
		"fk_capa_correction"	: fk_capa_correction,
		"user"					: user,
		"tbl_id"				: tbl_id,
	}
	call_ajax(data, handler_qfr_capa, function(result){	
		if(result['min_monitoring_date'] != '') {
			$('#'+frm_id+' input[name="monitoring_date"]').attr({"min" : result['min_monitoring_date'], "max" : result['date_today'] });
		}
	});
}

 function fn_add_monitoring(serialized_data, mdl_id) {
	call_ajax_attachment( serialized_data, handler_qfr_capa, function(result){
		$('#'+mdl_id).modal('hide');
		$('#modal_system_message').modal();
		if(result['msg'] == 'Invalid monitoring record!') {
			$('#container_message').attr('class','alert alert-danger');
		} else {
			$('#container_message').attr('class','alert alert-success');
		}
		
		$('#container_message').html( '<h4>'+result['msg']+'</h4>' );
		$('.btn').prop("disabled",false);
		$(frm_add_monitoring+' input, select, textarea').val("");
		fn_get_capa_1st_monitoring_details($('#'+frm_add_monitoring+' #mdl').val(), $('#'+frm_add_monitoring+' #frm').val(), $('#'+mdl_add_monitoring).data('id'), $('#'+frm_add_monitoring+' #user').val());
		fn_check_capa_classification($('#'+frm_add_monitoring+' #mdl').val(), $('#'+frm_add_monitoring+' #frm').val(), $('#'+mdl_add_monitoring).data('id'), $('#'+frm_add_monitoring+' #user').val());
		fn_capa_reload_datatables();
		console.log(result);
	});
 }

/* ***************************
	CAPA QS Inspector Add Monitoring - End
*************************** */

/* ***************************
	CAPA QS Inspector Edit Monitoring - Start
*************************** */
var mdl_qs_insp_ext_edit_moni		= 'modal_capa_qs_inspector_external_1st_monitoring_edit';
var frm_qs_insp_ext_edit_moni		= 'frm_capa_qs_inspector_external_edit_monitoring';
var mdl_edit_ccrrection_monitoring	= 'modal_capa_edit_correction_monitoring';
var frm_edit_correction				= 'frm_capa_edit_correction';
var frm_edit_monitoring				= 'frm_capa_edit_monitoring';

$('#'+ tbl_qs_inspector +' tbody').on('click','tr .fa-edit', function(){
	var pkid = $(this).data('id');
	load_new(mdl_qs_insp_ext_edit_moni, frm_qs_insp_ext_edit_moni);
	fn_get_capa_main_details(mdl_qs_insp_ext_edit_moni, frm_qs_insp_ext_edit_moni, pkid);
	fn_get_capa_1st_monitoring_details(mdl_qs_insp_ext_edit_moni, frm_qs_insp_ext_edit_moni, pkid, 'inspector_edit');
	$('#'+mdl_qs_insp_ext_edit_moni).modal('show');
 });
 
$('#'+mdl_qs_insp_ext_edit_moni+' .fa-paperclip').click(function() {
	window.location.href = "./pages/qfr/dl_capa_attachments.php?id="+$(this).val()+"&fk_cor="+$(this).data('fk')+"&type=main&user=qs&order=";
});

$('#'+frm_qs_insp_ext_edit_moni+' #tbl_monitoring tbody').on('click' , 'a', function(){
	window.location.href = "./pages/qfr/dl_capa_attachments.php?id="+$(this).data('id')+"&fk_cor="+$(this).data('fk')+"&type=validation&val=1&user=qs&order="+$(this).data('order');
	return false;
});

$('#'+ mdl_qs_insp_ext_edit_moni +' #tbl_monitoring tbody').on('click','tr .fa-edit', function(){
	$('#'+frm_edit_correction).show();
	fn_get_capa_correction_details(mdl_edit_ccrrection_monitoring, frm_edit_correction, $(this).data('correction'));
	fn_return_editable_monitoring(frm_edit_monitoring, $(this).data('correction'), 'qs', 'monitoring');	
	$('#'+frm_edit_monitoring+' #dl_capa_attachment').hide();
	$('#'+mdl_edit_ccrrection_monitoring).data('fkcapa', $(this).data('capa'));
	$('#'+mdl_edit_ccrrection_monitoring).data('fkcorrection', $(this).data('correction'));
	
	$('#'+frm_edit_monitoring+' #tbl_id').val('tbl_qfr_capa_1st_monitoring');
	$('#'+frm_edit_monitoring+' #mdl').val('modal_capa_qs_inspector_external_1st_monitoring_edit');
	$('#'+frm_edit_monitoring+' #frm').val('frm_capa_qs_inspector_external_edit_monitoring');
	$('#'+frm_edit_monitoring+' #user').val('inspector_edit');
	$('#'+mdl_edit_ccrrection_monitoring).data('id', $(this).data('capa'));
	
	$('#'+mdl_edit_ccrrection_monitoring).modal('show');
 });
 
$('#'+frm_edit_correction).on('submit', function(e) {
	e.preventDefault();
	var serialized_data = $(this).serialize();
	$('.btn').prop("disabled",true);
	fn_update_correction_details(serialized_data, mdl_edit_ccrrection_monitoring, frm_edit_monitoring);
});	

$('#'+ frm_edit_monitoring +' #monitoring_number').change(function() {
	if($(this).val() != '') {
		fn_return_monitoring_data_by_field(mdl_edit_ccrrection_monitoring, frm_edit_monitoring, $('#'+mdl_edit_ccrrection_monitoring).data('fkcapa'), $('#'+mdl_edit_ccrrection_monitoring).data('fkcorrection'), 'qs', 'tbl_qfr_capa_1st_monitoring', $(this).val());
	} else {
		$('#'+frm_edit_monitoring+' input, select, textarea').val('');
		$('#'+frm_edit_monitoring+' #monitoring_by').val([]).trigger('change');
	}
});

$('#'+ frm_edit_monitoring +' #dl_capa_attachment').click(function() {
	window.location.href = "./pages/qfr/dl_capa_attachments.php?id="+$(this).data('id')+"&fk_cor="+$(this).data('fk')+"&type=monitoring&val=1&user=qs&order="+$(this).data('order');
	return false;
});

 $('#'+frm_edit_monitoring).on('submit', function(e) {
	e.preventDefault();
	var serialized_data = $(this).serialize();
	$('.btn').prop("disabled",true);
	fn_update_monitoring_details(serialized_data, mdl_edit_ccrrection_monitoring, frm_edit_monitoring, 'qs');
});	

function fn_update_correction_details(serialized_data, mdl_id, frm_id) {
	var data = {
		"action"			: 'update_correction_details',
		"pkid"				: $('#'+mdl_id).data('fkcorrection'),
		"username"			: username,
	}
	call_ajax_serialize(data, serialized_data, handler_qfr_capa, function(result){	
		$('#'+mdl_id).modal('hide');
		$('#'+mdl_capa_system_message + ' #div_system_message').attr('class','alert alert-success');
		$('#'+mdl_capa_system_message + ' #div_system_message').html(result['msg']);
		$('#'+mdl_capa_system_message + ' #div_system_message').show();
		$('#'+mdl_capa_system_message).modal();
		$('.btn').prop("disabled",false);
		fn_get_capa_1st_monitoring_details($('#'+frm_id+' #mdl').val(), $('#'+frm_id+' #frm').val(), $('#'+mdl_id).data('id'), $('#'+frm_id+' #user').val());
		fn_check_capa_classification($('#'+frm_id+' #mdl').val(), $('#'+frm_id+' #frm').val(), $('#'+mdl_id).data('id'), $('#'+frm_id+' #user').val());
		fn_capa_reload_datatables();
		console.log(result);
	});
}

function fn_update_monitoring_details(serialized_data, mdl_id, frm_id, user_group) {
	var data = {
		"action"			: 'update_monitoring_details',
		"fkcapa"			: $('#'+mdl_id).data('fkcapa'),
		"fkcorrection"		: $('#'+mdl_id).data('fkcorrection'),
		"user_group"		: user_group,
		"username"			: username
	}
	call_ajax_serialize(data, serialized_data, handler_qfr_capa, function(result){	
		$('#'+mdl_id).modal('hide');
		$('#'+mdl_capa_system_message + ' #div_system_message').attr('class','alert alert-success');
		$('#'+mdl_capa_system_message + ' #div_system_message').html(result['msg']);
		$('#'+mdl_capa_system_message + ' #div_system_message').show();
		$('#'+mdl_capa_system_message).modal();
		$('.btn').prop("disabled",false);
		fn_get_capa_1st_monitoring_details($('#'+frm_id+' #mdl').val(), $('#'+frm_id+' #frm').val(), $('#'+mdl_id).data('id'), $('#'+frm_id+' #user').val());
		fn_check_capa_classification($('#'+frm_id+' #mdl').val(), $('#'+frm_id+' #frm').val(), $('#'+mdl_id).data('id'), $('#'+frm_id+' #user').val());
		fn_capa_reload_datatables();
		console.log(result);
	});
}

/* ***************************
	CAPA QS Inspector Edit Monitoring - End
*************************** */


/* ***************************
	CAPA QS Inspector View Monitoring - Start
*************************** */
var mdl_qs_insp_ext_view_moni		= 'modal_capa_qs_inspector_external_1st_monitoring_view';
var frm_qs_insp_ext_view_moni		= 'frm_capa_qs_inspector_external_view_monitoring';

$('#'+ tbl_qs_inspector +' tbody').on('click','tr .fa-eye', function(){
	var pkid = $(this).data('id');
	load_new(mdl_qs_insp_ext_view_moni, frm_qs_insp_ext_view_moni);
	fn_get_capa_main_details(mdl_qs_insp_ext_view_moni, frm_qs_insp_ext_view_moni, pkid);
	fn_get_capa_1st_monitoring_details(mdl_qs_insp_ext_view_moni, frm_qs_insp_ext_view_moni, pkid, 'inspector');
	$('#'+mdl_qs_insp_ext_view_moni).modal('show');
 });
 
$('#'+mdl_qs_insp_ext_view_moni+' .fa-paperclip').click(function() {
	window.location.href = "./pages/qfr/dl_capa_attachments.php?id="+$(this).val()+"&fk_cor="+$(this).data('fk')+"&type=main&user=qs&order=";
});

$('#'+frm_qs_insp_ext_view_moni+' #tbl_monitoring tbody').on('click' , 'a', function(){
	window.location.href = "./pages/qfr/dl_capa_attachments.php?id="+$(this).data('id')+"&fk_cor="+$(this).data('fk')+"&type=validation&val=1&user=qs&order="+$(this).data('order');
	return false;
});


/* ***************************
	CAPA QS Inspector View Monitoring - End
*************************** */
/* ***************************
	CAPA-Operations QS Supervisor - Start
*************************** */
var tbl_ope_qs_sup    		= 'tbl_capa_ope_qs_sup_access';
var dt_ope_qs_sup 			= '';
var mdl_qs_supervisor		= 'modal_capa_qs_supervisor';
var frm_qs_supervisor		= 'frm_capa_qs_supervisor';
var mdl_qs_supervisor_conf	= 'modal_capa_qs_supervisor_confirmation';
var frm_qs_supervisor_conf	= 'frm_capa_qs_supervisor_confirmation';

var mdl_qc_qad_supervisor		= 'modal_capa_qc_qad_supervisor_confirmation';
var frm_qc_qad_supervisor		= 'frm_capa_qc_qad_supervisor_confirmation';

var mdl_qc_qad_conformance		= 'modal_capa_qc_qad_conformance';
var frm_qc_qad_conformance		= 'frm_capa_qc_qad_conformance';

if(dt_ope_qs_sup == '') {
	dt_ope_qs_sup = $('#'+tbl_ope_qs_sup).DataTable({
		"aaSorting"	 : [],	
		"bProcessing": true,
		"bServerSide": true,
		"sAjaxSource": "server_side_scripts/qr/dt_capa_qs_supervisor.php?username="+username,
		"drawCallback": function( settings ) {
			$('#'+tbl_ope_qs_sup).attr('style','width:100%;');
		}
	});
}

$('#'+ tbl_ope_qs_sup +' tbody').on('click','tr .fa-eye', function(){
	var pkid = $(this).data('id');
	fn_check_capa_2nd_monitoring_supervisor(pkid);
 }); 
 
$('#'+mdl_qs_supervisor+' .fa-paperclip').click(function() {
	window.location.href = "./pages/qfr/dl_capa_attachments.php?id="+$(this).val()+"&fk_cor="+$(this).data('fk')+"&type=main&user=qs&order=";
});

$('#'+frm_qs_supervisor+' table tbody').on('click' , 'a', function(){
	window.location.href = "./pages/qfr/dl_capa_attachments.php?id="+$(this).data('id')+"&fk_cor="+$(this).data('fk')+"&type=validation&val=1&user=qs&order="+$(this).data('order');
	return false;
});
 
 $('#'+mdl_qc_qad_conformance+' .fa-paperclip').click(function() {
	window.location.href = "./pages/qfr/dl_capa_attachments.php?id="+$(this).val()+"&fk_cor="+$(this).data('fk')+"&type=main&user=qs&order=";
});

$('#'+frm_qc_qad_conformance+' #tbl_monitoring tbody').on('click' , 'a', function(){
	window.location.href = "./pages/qfr/dl_capa_attachments.php?id="+$(this).data('id')+"&fk_cor="+$(this).data('fk')+"&type=validation&val=1&user=qs&order="+$(this).data('order');
	return false;
});

$('#'+frm_qc_qad_conformance+' #tbl_monitoring2 tbody').on('click' , 'a', function(){
	window.location.href = "./pages/qfr/dl_capa_attachments.php?id="+$(this).data('id')+"&fk_cor="+$(this).data('fk')+"&type=validation&val=2&user=qc&order="+$(this).data('order');
	return false;
});

$('#'+frm_qc_qad_supervisor+' #tbl_monitoring tbody').on('click' , 'a', function(){
	window.location.href = "./pages/qfr/dl_capa_attachments.php?id="+$(this).data('id')+"&fk_cor="+$(this).data('fk')+"&type=validation&val=1&user=qs&order="+$(this).data('order');
	return false;
});

$('#'+frm_qc_qad_supervisor+' #tbl_monitoring2 tbody').on('click' , 'a', function(){
	window.location.href = "./pages/qfr/dl_capa_attachments.php?id="+$(this).data('id')+"&fk_cor="+$(this).data('fk')+"&type=validation&val=2&user=qc&order="+$(this).data('order');
	return false;
});

$('#'+ frm_qc_qad_supervisor+ ' #tbl_monitoring tbody').on('click','tr .fa-check-square-o', function(){
	var monitoring_field = $(this).data('id');
	$('#'+mdl_qs_supervisor_conf + ' #container_approver_message').attr('class','alert alert-success');
	$('#'+mdl_qs_supervisor_conf + ' #container_approver_message').html('Are you sure you want to approve the request?<br><br>Remarks:<textarea name="remarks" id="remarks" style="width:100%;" rows="4"></textarea>');
	$('#'+mdl_qs_supervisor_conf + ' #container_approver_message').show();
	$('#'+mdl_qs_supervisor_conf).data('id', $('#'+mdl_qc_qad_supervisor).data('id'));
	$('#'+mdl_qs_supervisor_conf).data('type', 'Check Supervisor2');
	$('#'+mdl_qs_supervisor_conf).data('monitoring_field', monitoring_field);
	$('#'+mdl_qs_supervisor_conf).data('status', 'CHECKED');
	$('#'+mdl_qs_supervisor_conf).modal();	
 });
 
$('#'+ frm_qc_qad_supervisor+ ' #tbl_monitoring tbody').on('click','tr .fa-times-rectangle-o', function(){
	var monitoring_field = $(this).data('id');
	$('#'+mdl_qs_supervisor_conf + ' #container_approver_message').attr('class','alert alert-danger');
	$('#'+mdl_qs_supervisor_conf + ' #container_approver_message').html('Are you sure you want to reject the request?<br><br>Remarks:<textarea name="remarks" id="remarks" style="width:100%;" rows="4" required></textarea>');
	$('#'+mdl_qs_supervisor_conf + ' #container_approver_message').show();
	$('#'+mdl_qs_supervisor_conf).data('id', $('#'+mdl_qc_qad_supervisor).data('id'));
	$('#'+mdl_qs_supervisor_conf).data('type', 'Check Supervisor2');
	$('#'+mdl_qs_supervisor_conf).data('monitoring_field', monitoring_field);
	$('#'+mdl_qs_supervisor_conf).data('status', 'REJECTED');
	$('#'+mdl_qs_supervisor_conf).modal();
 });


$('#'+ frm_qc_qad_conformance+ ' #tbl_monitoring tbody').on('click','tr .fa-thumbs-o-up', function(){
	var monitoring_field = $(this).data('id');
	$('#'+mdl_qs_conformance_conf + ' #container_approver_message').attr('class','alert alert-success');
	$('#'+mdl_qs_conformance_conf + ' #container_approver_message').html('Are you sure you want to conform the request?<br><br>Remarks:<textarea name="remarks" id="remarks" style="width:100%;" rows="4"></textarea>');
	$('#'+mdl_qs_conformance_conf + ' #container_approver_message').show();
	$('#'+mdl_qs_conformance_conf).data('mdl', mdl_qc_qad_conformance);
	$('#'+mdl_qs_conformance_conf).data('frm', frm_qc_qad_conformance);
	$('#'+mdl_qs_conformance_conf).data('type', 'Conform Supervisor');
	$('#'+mdl_qs_conformance_conf).data('monitoring_field', monitoring_field);
	$('#'+mdl_qs_conformance_conf).data('status', 'CONFORMED');
	$('#'+mdl_qs_conformance_conf).modal();
 });
 
$('#'+ frm_qc_qad_conformance+ ' #tbl_monitoring tbody').on('click','tr .fa-thumbs-o-down', function(){
	var monitoring_field = $(this).data('id');
	$('#'+mdl_qs_conformance_conf + ' #container_approver_message').attr('class','alert alert-danger');
	$('#'+mdl_qs_conformance_conf + ' #container_approver_message').html('Are you sure you want to reject the request?<br><br>Remarks:<textarea name="remarks" id="remarks" style="width:100%;" rows="4" required></textarea>');
	$('#'+mdl_qs_conformance_conf + ' #container_approver_message').show();
	$('#'+mdl_qs_conformance_conf).data('mdl', mdl_qc_qad_conformance);
	$('#'+mdl_qs_conformance_conf).data('frm', frm_qc_qad_conformance);
	$('#'+mdl_qs_conformance_conf).data('type', 'Conform Supervisor');
	$('#'+mdl_qs_conformance_conf).data('monitoring_field', monitoring_field);
	$('#'+mdl_qs_conformance_conf).data('status', 'REJECTED');
	$('#'+mdl_qs_conformance_conf).modal();
 });
 
$('#'+ frm_qs_supervisor+ ' #tbl_monitoring tbody').on('click','tr .fa-check-square-o', function(){
	var monitoring_field = $(this).data('id');
	$('#'+mdl_qs_supervisor_conf + ' #container_approver_message').attr('class','alert alert-success');
	$('#'+mdl_qs_supervisor_conf + ' #container_approver_message').html('Are you sure you want to approve the request?<br><br>Remarks:<textarea name="remarks" id="remarks" style="width:100%;" rows="4"></textarea>');
	$('#'+mdl_qs_supervisor_conf + ' #container_approver_message').show();
	$('#'+mdl_qs_supervisor_conf).data('type', 'Check Supervisor');
	$('#'+mdl_qs_supervisor_conf).data('monitoring_field', monitoring_field);
	$('#'+mdl_qs_supervisor_conf).data('status', 'CHECKED');
	$('#'+mdl_qs_supervisor_conf).modal();	
 });
 
$('#'+ frm_qs_supervisor+ ' #tbl_monitoring tbody').on('click','tr .fa-times-rectangle-o', function(){
	var monitoring_field = $(this).data('id');
	$('#'+mdl_qs_supervisor_conf + ' #container_approver_message').attr('class','alert alert-danger');
	$('#'+mdl_qs_supervisor_conf + ' #container_approver_message').html('Are you sure you want to reject the request?<br><br>Remarks:<textarea name="remarks" id="remarks" style="width:100%;" rows="4" required></textarea>');
	$('#'+mdl_qs_supervisor_conf + ' #container_approver_message').show();
	$('#'+mdl_qs_supervisor_conf).data('type', 'Check Supervisor');
	$('#'+mdl_qs_supervisor_conf).data('monitoring_field', monitoring_field);
	$('#'+mdl_qs_supervisor_conf).data('status', 'REJECTED');
	$('#'+mdl_qs_supervisor_conf).modal();
 });
 
$('#'+ frm_qs_supervisor+ ' #tbl_monitoring tbody').on('click','tr .fa-remove', function(){
	var fk_capa_correction = $(this).data('fk');
	$('#'+mdl_qs_supervisor_conf + ' #container_approver_message').attr('class','alert alert-danger');
	$('#'+mdl_qs_supervisor_conf + ' #container_approver_message').html('Are you sure you want to cancel the corrective/correction action?');
	$('#'+mdl_qs_supervisor_conf + ' #container_approver_message').show();
	$('#'+mdl_qs_supervisor_conf).data('type', 'Post Supervisor');
	$('#'+mdl_qs_supervisor_conf).data('fk', fk_capa_correction);
	$('#'+mdl_qs_supervisor_conf).data('status', 'CANCELLED');
	$('#'+mdl_qs_supervisor_conf).modal();
 });
 
$('#'+ frm_qs_supervisor+ ' #tbl_monitoring tbody').on('click','tr .fa-tags', function(){
	var fk_capa_correction = $(this).data('fk');
	$('#'+mdl_qs_supervisor_conf + ' #container_approver_message').attr('class','alert alert-success');
	$('#'+mdl_qs_supervisor_conf + ' #container_approver_message').html('Are you sure you want to post the corrective/correction action?');
	$('#'+mdl_qs_supervisor_conf + ' #container_approver_message').show();
	$('#'+mdl_qs_supervisor_conf).data('id', $('#'+mdl_qs_supervisor).data('id'));
	$('#'+mdl_qs_supervisor_conf).data('type', 'Post Supervisor From Inspector');
	$('#'+mdl_qs_supervisor_conf).data('fk', fk_capa_correction);
	$('#'+mdl_qs_supervisor_conf).data('status', 'CLOSED');
	$('#'+mdl_qs_supervisor_conf).modal();
 });
 
$('#'+ frm_qc_qad_supervisor+ ' #tbl_monitoring tbody').on('click','tr .fa-tags', function(){
	var fk_capa_correction = $(this).data('fk');
	$('#'+mdl_qs_supervisor_conf + ' #container_approver_message').attr('class','alert alert-success');
	$('#'+mdl_qs_supervisor_conf + ' #container_approver_message').html('Are you sure you want to post the corrective/correction action?');
	$('#'+mdl_qs_supervisor_conf + ' #container_approver_message').show();
	$('#'+mdl_qs_supervisor_conf).data('id', $('#'+mdl_qc_qad_supervisor).data('id'));
	$('#'+mdl_qs_supervisor_conf).data('type', 'Post Supervisor From QAD');
	$('#'+mdl_qs_supervisor_conf).data('fk', fk_capa_correction);
	$('#'+mdl_qs_supervisor_conf).data('status', 'CLOSED');
	$('#'+mdl_qs_supervisor_conf).modal();
 });

$('#'+ frm_qc_qad_supervisor+ ' #tbl_monitoring2 tbody').on('click','tr .fa-tags', function(){
	var fk_capa_correction = $(this).data('fk');
	$('#'+mdl_qs_supervisor_conf + ' #container_approver_message').attr('class','alert alert-success');
	$('#'+mdl_qs_supervisor_conf + ' #container_approver_message').html('Are you sure you want to post the corrective/correction action?');
	$('#'+mdl_qs_supervisor_conf + ' #container_approver_message').show();
	$('#'+mdl_qs_supervisor_conf).data('id', $('#'+mdl_qc_qad_supervisor).data('id'));
	$('#'+mdl_qs_supervisor_conf).data('type', 'Post Supervisor2 From QAD');
	$('#'+mdl_qs_supervisor_conf).data('fk', fk_capa_correction);
	$('#'+mdl_qs_supervisor_conf).data('status', 'CLOSED');
	$('#'+mdl_qs_supervisor_conf).modal();
 });

$('#'+ frm_qc_qad_supervisor+ ' #tbl_monitoring3 tbody').on('click','tr .fa-tags', function(){
	var fk_capa_correction = $(this).data('fk');
	$('#'+mdl_qs_supervisor_conf + ' #container_approver_message').attr('class','alert alert-success');
	$('#'+mdl_qs_supervisor_conf + ' #container_approver_message').html('Are you sure you want to post the corrective/correction action?');
	$('#'+mdl_qs_supervisor_conf + ' #container_approver_message').show();
	$('#'+mdl_qs_supervisor_conf).data('id', $('#'+mdl_qc_qad_supervisor).data('id'));
	$('#'+mdl_qs_supervisor_conf).data('type', 'Post Supervisor3 From QAD');
	$('#'+mdl_qs_supervisor_conf).data('fk', fk_capa_correction);
	$('#'+mdl_qs_supervisor_conf).data('status', 'CLOSED');
	$('#'+mdl_qs_supervisor_conf).modal();
 });
 
 $('#'+frm_qs_supervisor_conf).submit(function(e) {
	e.preventDefault();
	if( $('#'+mdl_qs_supervisor_conf).data('type') == 'Check Supervisor' || $('#'+mdl_qs_supervisor_conf).data('type') == 'Check Supervisor2' ) {
		fn_save_qs_check_supervisor_log($('#'+mdl_qs_supervisor_conf).data('id'), $('#'+mdl_qs_supervisor_conf).data('status'), $('#'+mdl_qs_supervisor_conf).data('monitoring_field'), 'supervisor');
	} else if( $('#'+mdl_qs_supervisor_conf).data('type') == 'Post Supervisor From Inspector' ) {
		fn_save_qs_supervisor_post_log($('#'+mdl_qs_supervisor_conf).data('id'), $('#'+mdl_qs_supervisor_conf).data('status'), $('#'+mdl_qs_supervisor_conf).data('fk'), 'from inspector');
	} else if( $('#'+mdl_qs_supervisor_conf).data('type') == 'Post Supervisor From QAD' ) {
		fn_save_qs_supervisor_post_log($('#'+mdl_qs_supervisor_conf).data('id'), $('#'+mdl_qs_supervisor_conf).data('status'), $('#'+mdl_qs_supervisor_conf).data('fk'), 'from qc_qad');
	} else if( $('#'+mdl_qs_supervisor_conf).data('type') == 'Post Supervisor2 From QAD' ) {
		fn_save_qc_supervisor_post_log($('#'+mdl_qs_supervisor_conf).data('id'), $('#'+mdl_qs_supervisor_conf).data('status'), $('#'+mdl_qs_supervisor_conf).data('fk'), 'from qc_qad');
	} else if( $('#'+mdl_qs_supervisor_conf).data('type') == 'Post Supervisor3 From QAD' ) {
		fn_close_external_capa($('#'+mdl_qs_supervisor_conf).data('id'), $('#'+mdl_qs_supervisor_conf).data('status'), $('#'+mdl_qs_supervisor_conf).data('fk'), 'from qad');
	} else if( $('#'+mdl_qs_supervisor_conf).data('type') == 'Check AM-Up' ) {
		fn_save_qs_check_supervisor_log($('#'+mdl_qc_qad_am_up).data('id'), $('#'+mdl_qs_supervisor_conf).data('status'), $('#'+mdl_qs_supervisor_conf).data('validation_field'), 'ampup');
	}
});
 
function fn_save_qs_check_supervisor_log(fk_capa, status, monitoring_field, user) {
	var data = {
		"action"			: 'save_qs_check_supervisor_log',
		"status"			: status,
		"fk_capa"			: fk_capa,
		"user"				: user,
		"remarks"			: $('#'+frm_qs_supervisor_conf+' #remarks').val(),
		"monitoring_field"	: monitoring_field,
		"username"			: username,
	}
	call_ajax(data, handler_qfr_capa, function(result){	
		$('#'+mdl_qs_supervisor_conf).modal('hide');
		$('#'+mdl_capa_system_message + ' #div_system_message').attr('class','alert alert-success');
		$('#'+mdl_capa_system_message + ' #div_system_message').html(result['msg']);
		$('#'+mdl_capa_system_message + ' #div_system_message').show();
		$('#'+mdl_capa_system_message).modal();
		fn_capa_reload_datatables();
		if($('#'+mdl_qs_supervisor_conf).data('type') == 'Check Supervisor') {
			fn_get_capa_1st_monitoring_details(mdl_qs_supervisor, frm_qs_supervisor, fk_capa, 'supervisor');
		} else {
			// fn_get_capa_1st_monitoring_details(mdl_qc_qad_supervisor, frm_qc_qad_supervisor, fk_capa, 'supervisor');
			fn_check_capa_2nd_monitoring_supervisor(fk_capa);
		}
		console.log(result);
		if($('#'+mdl_qs_supervisor_conf).data('type') == 'Check AM-Up') {
			fn_check_capa_classification(mdl_qc_qad_am_up, frm_qc_qad_am_up, fk_capa, 'am_up');
		}
	});
}
 
function fn_save_qs_supervisor_post_log(fk_capa, status, fk_capa_correction, from_data) {
	var data = {
		"action"			 : "save_qs_supervisor_post_log",
		"status"			 : status,
		"fk_capa"			 : fk_capa,
		"fk_capa_correction" : fk_capa_correction,
		"username"			 : username,
	}
	call_ajax(data, handler_qfr_capa, function(result){	
		$('#'+mdl_qs_supervisor_conf).modal('hide');
		$('#'+mdl_capa_system_message + ' #div_system_message').attr('class','alert alert-success');
		$('#'+mdl_capa_system_message + ' #div_system_message').html(result['msg']);
		$('#'+mdl_capa_system_message + ' #div_system_message').show();
		$('#'+mdl_capa_system_message).modal();
		fn_capa_reload_datatables();
		//reload ung table data based sa from_data at modal id 
		if(from_data == 'from inspector') {
			fn_get_capa_1st_monitoring_details(mdl_qs_supervisor, frm_qs_supervisor, fk_capa, 'supervisor');
		} else if(from_data == 'from qc_qad') {
			fn_get_capa_1st_monitoring_details(mdl_qc_qad_supervisor, frm_qc_qad_supervisor, fk_capa, 'supervisor');
			fn_check_capa_classification(mdl_qc_qad_supervisor, frm_qc_qad_supervisor, fk_capa, 'supervisor');
		}  
		
		console.log(result);
	});
}
function fn_save_qc_supervisor_post_log(fk_capa, status, fk_capa_correction, from_data) {
	var data = {
		"action"			 : "save_qc_supervisor_post_log",
		"status"			 : status,
		"fk_capa"			 : fk_capa,
		"fk_capa_correction" : fk_capa_correction,
		"from_data" 		 : from_data,
		"username"			 : username,
	}
	call_ajax(data, handler_qfr_capa, function(result){	
		$('#'+mdl_qs_supervisor_conf).modal('hide');
		$('#'+mdl_capa_system_message + ' #div_system_message').attr('class','alert alert-success');
		$('#'+mdl_capa_system_message + ' #div_system_message').html(result['msg']);
		$('#'+mdl_capa_system_message + ' #div_system_message').show();
		$('#'+mdl_capa_system_message).modal();
		fn_capa_reload_datatables();
		//reload ung table data based sa from_data at modal id 
		if(from_data == 'from inspector') {
			fn_get_capa_1st_monitoring_details(mdl_qs_supervisor, frm_qs_supervisor, fk_capa, 'supervisor');
		} else if(from_data == 'from qc_qad') {
			fn_get_capa_1st_monitoring_details(mdl_qc_qad_supervisor, frm_qc_qad_supervisor, fk_capa, 'supervisor');
			fn_check_capa_classification(mdl_qc_qad_supervisor, frm_qc_qad_supervisor, fk_capa, 'supervisor');
		}  
		
		console.log(result);
	});
}
function fn_close_external_capa(fk_capa, status, fk_capa_correction, from_data) {
	var data = {
		"action"			 : "update_3rd_validation_status",
		"status"			 : status,
		"fk_capa"			 : fk_capa,
		"fk_capa_correction" : fk_capa_correction,
		"username"			 : username,
	}
	call_ajax(data, handler_qfr_capa, function(result){	
		$('#'+mdl_qs_supervisor_conf).modal('hide');
		$('#'+mdl_capa_system_message + ' #div_system_message').attr('class','alert alert-success');
		$('#'+mdl_capa_system_message + ' #div_system_message').html(result['msg']);
		$('#'+mdl_capa_system_message + ' #div_system_message').show();
		$('#'+mdl_capa_system_message).modal();
		fn_capa_reload_datatables();
		fn_get_capa_1st_monitoring_details(mdl_qc_qad_supervisor, frm_qc_qad_supervisor, fk_capa, 'supervisor');
		fn_check_capa_classification(mdl_qc_qad_supervisor, frm_qc_qad_supervisor, fk_capa, 'supervisor');
		console.log(result);
	});
}

/* ***************************
	CAPA-Operations QS Supervisor - End
*************************** */

/* ***************************
	CAPA-Operations QS Conformance - Start
*************************** */
var tbl_ope_qs_conf    		= 'tbl_capa_ope_qs_conf_access';
var dt_ope_qs_conf 			= '';
var mdl_qs_conformance		= 'modal_capa_qs_conformance';
var frm_qs_conformance		= 'frm_capa_qs_conformance';
var mdl_qs_conformance_conf	= 'modal_capa_qs_conformance_confirmation';
var frm_qs_conformance_conf	= 'frm_capa_qs_conformance_confirmation';

if(dt_ope_qs_conf == '') {
	dt_ope_qs_conf = $('#'+tbl_ope_qs_conf).DataTable({
		"aaSorting"	 : [],	
		"bProcessing": true,
		"bServerSide": true,
		"sAjaxSource": "server_side_scripts/qr/dt_capa_qs_conformance.php?username="+username,
		"drawCallback": function( settings ) {
			$('#'+tbl_ope_qs_conf).attr('style','width:100%;');
		}
	});
}

$('#'+ tbl_ope_qs_conf +' tbody').on('click','tr .fa-eye', function(){
	var pkid = $(this).data('id');
	fn_check_capa_2nd_monitoring_conformance(pkid);
 });
 
$('#'+mdl_qs_conformance+' .fa-paperclip').click(function() {
	window.location.href = "./pages/qfr/dl_capa_attachments.php?id="+$(this).val()+"&fk_cor="+$(this).data('fk')+"&type=main&user=qs&order=";
});

$('#'+frm_qs_conformance+' table tbody').on('click' , 'a', function(){
	window.location.href = "./pages/qfr/dl_capa_attachments.php?id="+$(this).data('id')+"&fk_cor="+$(this).data('fk')+"&type=validation&val=1&user=qs&order="+$(this).data('order');
	return false;
});

$('#'+ frm_qs_conformance+ ' #tbl_monitoring tbody').on('click','tr .fa-thumbs-o-up', function(){
	var monitoring_field = $(this).data('id');
	$('#'+mdl_qs_conformance_conf + ' #container_approver_message').attr('class','alert alert-success');
	$('#'+mdl_qs_conformance_conf + ' #container_approver_message').html('Are you sure you want to conform the request?<br><br>Remarks:<textarea name="remarks" id="remarks" style="width:100%;" rows="4"></textarea>');
	$('#'+mdl_qs_conformance_conf + ' #container_approver_message').show();
	$('#'+mdl_qs_conformance_conf).data('mdl', mdl_qs_conformance);
	$('#'+mdl_qs_conformance_conf).data('frm', frm_qs_conformance);
	$('#'+mdl_qs_conformance_conf).data('type', 'Conform Supervisor');
	$('#'+mdl_qs_conformance_conf).data('monitoring_field', monitoring_field);
	$('#'+mdl_qs_conformance_conf).data('status', 'CONFORMED');
	$('#'+mdl_qs_conformance_conf).modal();
 });
 
$('#'+ frm_qs_conformance+ ' #tbl_monitoring tbody').on('click','tr .fa-thumbs-o-down', function(){
	var monitoring_field = $(this).data('id');
	$('#'+mdl_qs_conformance_conf + ' #container_approver_message').attr('class','alert alert-danger');
	$('#'+mdl_qs_conformance_conf + ' #container_approver_message').html('Are you sure you want to reject the request?<br><br>Remarks:<textarea name="remarks" id="remarks" style="width:100%;" rows="4" required></textarea>');
	$('#'+mdl_qs_conformance_conf + ' #container_approver_message').show();
	$('#'+mdl_qs_conformance_conf).data('mdl', mdl_qs_conformance);
	$('#'+mdl_qs_conformance_conf).data('frm', frm_qs_conformance);
	$('#'+mdl_qs_conformance_conf).data('type', 'Conform Supervisor');
	$('#'+mdl_qs_conformance_conf).data('monitoring_field', monitoring_field);
	$('#'+mdl_qs_conformance_conf).data('status', 'REJECTED');
	$('#'+mdl_qs_conformance_conf).modal();
 });
 
$('#'+ frm_qc_qad_conformance+ ' #tbl_monitoring2 tbody').on('click','tr .fa-thumbs-o-up', function(){
	var validation_field = $(this).data('id');
	$('#'+mdl_qs_conformance_conf + ' #container_approver_message').attr('class','alert alert-success');
	$('#'+mdl_qs_conformance_conf + ' #container_approver_message').html('Are you sure you want to conform the request?<br><br>Remarks:<textarea name="remarks" id="remarks" style="width:100%;" rows="4"></textarea>');
	$('#'+mdl_qs_conformance_conf + ' #container_approver_message').show();
	$('#'+mdl_qs_conformance_conf).data('mdl', mdl_qc_qad_conformance);
	$('#'+mdl_qs_conformance_conf).data('frm', frm_capa_qc_qad_conformance);
	$('#'+mdl_qs_conformance_conf).data('type', 'Conform QC & QAD');
	$('#'+mdl_qs_conformance_conf).data('validation_field', validation_field);
	$('#'+mdl_qs_conformance_conf).data('status', 'CONFORMED');
	$('#'+mdl_qs_conformance_conf).modal();
 });
 
$('#'+ frm_qc_qad_conformance+ ' #tbl_monitoring2 tbody').on('click','tr .fa-thumbs-o-down', function(){
	var validation_field = $(this).data('id');
	$('#'+mdl_qs_conformance_conf + ' #container_approver_message').attr('class','alert alert-danger');
	$('#'+mdl_qs_conformance_conf + ' #container_approver_message').html('Are you sure you want to reject the request?<br><br>Remarks:<textarea name="remarks" id="remarks" style="width:100%;" rows="4" required></textarea>');
	$('#'+mdl_qs_conformance_conf + ' #container_approver_message').show();
	$('#'+mdl_qs_conformance_conf).data('mdl', mdl_qc_qad_conformance);
	$('#'+mdl_qs_conformance_conf).data('frm', frm_capa_qc_qad_conformance);
	$('#'+mdl_qs_conformance_conf).data('type', 'Conform QC & QAD');
	$('#'+mdl_qs_conformance_conf).data('validation_field', validation_field);
	$('#'+mdl_qs_conformance_conf).data('status', 'REJECTED');
	$('#'+mdl_qs_conformance_conf).modal();
 });
 
 $('#'+frm_qs_conformance_conf).submit(function(e) {
	e.preventDefault();
	if( $('#'+mdl_qs_conformance_conf).data('type') == 'Conform Supervisor' ) {
		fn_save_qs_conformance_log($('#'+mdl_qs_conformance).data('id'), $('#'+mdl_qs_conformance_conf).data('status'), $('#'+mdl_qs_conformance_conf).data('monitoring_field'), $('#'+mdl_qs_conformance_conf).data('mdl'), $('#'+mdl_qs_conformance_conf).data('frm'));
	} else if( $('#'+mdl_qs_conformance_conf).data('type') == 'Conform QC & QAD' ) {
		fn_save_qs_conformance_log($('#'+mdl_qc_qad_conformance).data('id'), $('#'+mdl_qs_conformance_conf).data('status'), $('#'+mdl_qs_conformance_conf).data('validation_field'),$('#'+mdl_qs_conformance_conf).data('mdl'), $('#'+mdl_qs_conformance_conf).data('frm'));
		fn_check_capa_classification(mdl_qc_qad_conformance, frm_qc_qad_conformance, $('#'+mdl_qc_qad_conformance).data('id'), 'conformance');
	}
});
 
function fn_save_qs_conformance_log(fk_capa, status, monitoring_field, mdl_id, frm_id) {
	var data = {
		"action"			: "save_qs_conformance_log",
		"status"			: status,
		"fk_capa"			: fk_capa,
		"remarks"			: $('#'+frm_qs_conformance_conf+' #remarks').val(),
		"monitoring_field"	: monitoring_field,
		"username"			: username,
	}
	call_ajax(data, handler_qfr_capa, function(result){	
		$('#'+mdl_qs_conformance_conf).modal('hide');
		$('#'+mdl_capa_system_message + ' #div_system_message').attr('class','alert alert-success');
		$('#'+mdl_capa_system_message + ' #div_system_message').html(result['msg']);
		$('#'+mdl_capa_system_message + ' #div_system_message').show();
		$('#'+mdl_capa_system_message).modal();
		fn_capa_reload_datatables();
		fn_get_capa_1st_monitoring_details(mdl_id, frm_id, fk_capa, 'conformance');		
		console.log(result);
	});
}

/* ***************************
	CAPA-Operations QS Supervisor - End
*************************** */

/* ***************************
	CAPA Operations QE and QAD QE - Start
*************************** */

var tbl_ope_qe_qad    			= 'tbl_capa_ope_qe_qad_access';
var dt_ope_qe_qad 				= '';
var mdl_qc_qad_monitoring		= 'modal_capa_qc_qad_external_2nd_monitoring';
var frm_qc_qad_monitoring		= 'frm_capa_qc_qad_external_2nd_monitoring';

if(dt_ope_qe_qad == '') {
	dt_ope_qe_qad = $('#'+tbl_ope_qe_qad).DataTable({
		"aaSorting"	 : [],	
		"bProcessing": true,
		"bServerSide": true,
		"sAjaxSource": "server_side_scripts/qr/dt_capa_qc_qad_access.php?username="+username,
		"drawCallback": function( settings ) {
			$('#'+tbl_ope_qe_qad).attr('style','width:100%;');
		}
	});
}

$('#'+ tbl_ope_qe_qad +' tbody').on('click','tr .fa-plus', function(){
	var pkid = $(this).data('id');
	load_new(mdl_qc_qad_monitoring, frm_qc_qad_monitoring);
	fn_get_capa_main_details(mdl_qc_qad_monitoring, frm_qc_qad_monitoring, pkid);
	fn_get_capa_1st_monitoring_details(mdl_qc_qad_monitoring, frm_qc_qad_monitoring, pkid, 'qc_qad');
	fn_check_capa_classification(mdl_qc_qad_monitoring, frm_qc_qad_monitoring, pkid, 'qc_qad');
	$('#'+mdl_qc_qad_monitoring).modal('show');
 });

$('#'+mdl_qc_qad_monitoring+' .fa-paperclip').click(function() {
	window.location.href = "./pages/qfr/dl_capa_attachments.php?id="+$(this).val()+"&fk_cor="+$(this).data('fk')+"&type=main&user=qs&order=";
});

$('#'+frm_qc_qad_monitoring+' #tbl_monitoring tbody').on('click' , 'a', function(){
	window.location.href = "./pages/qfr/dl_capa_attachments.php?id="+$(this).data('id')+"&fk_cor="+$(this).data('fk')+"&type=validation&val=1&user=qs&order="+$(this).data('order');
	return false;
});

$('#'+frm_qc_qad_monitoring+' #tbl_monitoring2 tbody').on('click' , 'a', function(){
	window.location.href = "./pages/qfr/dl_capa_attachments.php?id="+$(this).data('id')+"&fk_cor="+$(this).data('fk')+"&type=validation&val=2&user=qc&order="+$(this).data('order');
	return false;
});
  
$('#'+ frm_qc_qad_monitoring +' #btn_add_validation').click(function(){
	var fk_capa = $(this).val();
	$('#'+frm_add_monitoring+' #tbl_id').val('tbl_qfr_capa_2nd_validation_external');
	$('#'+frm_add_monitoring+' #mdl').val('modal_capa_qc_qad_external_2nd_monitoring');
	$('#'+frm_add_monitoring+' #frm').val('frm_capa_qc_qad_external_2nd_monitoring');
	$('#'+frm_add_monitoring+' #user').val('qc');
	$('#'+mdl_add_monitoring).data('id', fk_capa);
	re_initialize_select2_server_side('#'+mdl_add_monitoring+' #correction_list','#'+mdl_add_monitoring+' #'+frm_add_monitoring,[],"server_side_scripts/dropdown/qfr/dd_capa_correction_list.php?fk_capa="+fk_capa+"&status=");	
	re_initialize_select2_server_side('#'+mdl_add_monitoring+' #monitoring_by','#'+mdl_add_monitoring+' #'+frm_add_monitoring,[],"server_side_scripts/dropdown/common/dd_hris_above_ss_list.php");	
	$('#'+mdl_add_monitoring).modal('show');
 });
  
/* ***************************
	CAPA Operations QE and QAD QE - End
*************************** */
  
/* ***************************
	CAPA Operations QE and QAD QE Edit - Start
*************************** */
   
var mdl_qc_qad_monitoring_edit	= 'modal_capa_qc_qad_external_2nd_monitoring_edit';
var frm_qc_qad_monitoring_edit	= 'frm_capa_qc_qad_external_2nd_monitoring_edit';
var mdl_edit_ccrrection_valid	= 'modal_capa_edit_correction_validation';
var frm_edit_validation			= 'frm_capa_edit_validation';

$('#'+ tbl_ope_qe_qad +' tbody').on('click','tr .fa-edit', function(){
	var pkid = $(this).data('id');
	load_new(mdl_qc_qad_monitoring_edit, frm_qc_qad_monitoring_edit);
	fn_get_capa_main_details(mdl_qc_qad_monitoring_edit, frm_qc_qad_monitoring_edit, pkid);
	fn_get_capa_1st_monitoring_details(mdl_qc_qad_monitoring_edit, frm_qc_qad_monitoring_edit, pkid, 'qc_qad_edit');
	fn_check_capa_classification(mdl_qc_qad_monitoring_edit, frm_qc_qad_monitoring_edit, pkid, 'qc_qad_edit');
	$('#'+mdl_qc_qad_monitoring_edit).modal('show');
 });
 
 $('#'+mdl_qc_qad_monitoring_edit+' .fa-paperclip').click(function() {
	window.location.href = "./pages/qfr/dl_capa_attachments.php?id="+$(this).val()+"&fk_cor="+$(this).data('fk')+"&type=main&user=qs&order=";
});

$('#'+frm_qc_qad_monitoring_edit+' #tbl_monitoring tbody').on('click' , 'a', function(){
	window.location.href = "./pages/qfr/dl_capa_attachments.php?id="+$(this).data('id')+"&fk_cor="+$(this).data('fk')+"&type=validation&val=1&user=qs&order="+$(this).data('order');
	return false;
});

$('#'+frm_qc_qad_monitoring_edit+' #tbl_monitoring2 tbody').on('click' , 'a', function(){
	window.location.href = "./pages/qfr/dl_capa_attachments.php?id="+$(this).data('id')+"&fk_cor="+$(this).data('fk')+"&type=validation&val=2&user=qc&order="+$(this).data('order');
	return false;
});  

 $('#'+ mdl_qc_qad_monitoring_edit +' #tbl_monitoring2 tbody').on('click','tr .fa-edit', function(){
	fn_return_editable_monitoring(frm_edit_validation, $(this).data('correction'), 'qc', 'validation');	
	$('#'+frm_edit_validation+' #dl_capa_attachment').hide();
	$('#'+mdl_edit_ccrrection_valid).data('fkcapa', $(this).data('capa'));
	$('#'+mdl_edit_ccrrection_valid).data('fkcorrection', $(this).data('correction'));
	
	$('#'+frm_edit_validation+' #tbl_id').val('tbl_qfr_capa_2nd_validation_external');
	$('#'+frm_edit_validation+' #mdl').val('modal_capa_qs_inspector_external_1st_monitoring_edit');
	$('#'+frm_edit_validation+' #frm').val('frm_capa_qs_inspector_external_edit_monitoring');
	$('#'+frm_edit_validation+' #user').val('qc_qad_edit');
	$('#'+frm_edit_validation).data('user-id','qc');
	$('#'+mdl_edit_ccrrection_valid).data('id', $(this).data('capa'));
	re_initialize_select2_server_side('#'+mdl_edit_ccrrection_valid+' #monitoring_by','#'+mdl_edit_ccrrection_valid+' #'+frm_edit_validation,[],"server_side_scripts/dropdown/common/dd_hris_all_list.php");
	
	$('#'+mdl_edit_ccrrection_valid).modal('show');
 });
 
 $('#'+ frm_edit_validation +' #monitoring_number').change(function() {
	if($(this).val() != '') {
		fn_return_monitoring_data_by_field(mdl_edit_ccrrection_valid, frm_edit_validation, $('#'+mdl_edit_ccrrection_valid).data('fkcapa'), $('#'+mdl_edit_ccrrection_valid).data('fkcorrection'), 'qc', 'tbl_qfr_capa_2nd_validation_external', $(this).val());
	} else {
		$('#'+frm_edit_validation+' input, select, textarea').val('');
		$('#'+frm_edit_validation+' #monitoring_by').val([]).trigger('change');
	}
});

$('#'+ frm_edit_validation +' #dl_capa_attachment').click(function() {
	window.location.href = "./pages/qfr/dl_capa_attachments.php?id="+$(this).data('id')+"&fk_cor="+$(this).data('fk')+"&type=monitoring&val=2&user=qc&order="+$(this).data('order');
	return false;
});

 $('#'+frm_edit_validation).on('submit', function(e) {
	e.preventDefault();
	var serialized_data = $(this).serialize();
	$('.btn').prop("disabled",true);
	// fn_update_monitoring_details(serialized_data, mdl_edit_ccrrection_valid, frm_edit_validation, 'qc');
	fn_update_monitoring_details(serialized_data, mdl_edit_ccrrection_valid, frm_edit_validation, $('#'+frm_edit_validation).data('user-id'));
});	

function fn_update_validation_details(serialized_data, mdl_id, frm_id, user_group) {
	var data = {
		"action"			: 'update_validation_details',
		"fkcapa"			: $('#'+mdl_id).data('fkcapa'),
		"fkcorrection"		: $('#'+mdl_id).data('fkcorrection'),
		"user_group"		: user_group,
		"username"			: username
	}
	call_ajax_serialize(data, serialized_data, handler_qfr_capa, function(result){	
		$('#'+mdl_id).modal('hide');
		$('#'+mdl_capa_system_message + ' #div_system_message').attr('class','alert alert-success');
		$('#'+mdl_capa_system_message + ' #div_system_message').html(result['msg']);
		$('#'+mdl_capa_system_message + ' #div_system_message').show();
		$('#'+mdl_capa_system_message).modal();
		$('.btn').prop("disabled",false);
		fn_get_capa_1st_monitoring_details($('#'+frm_id+' #mdl').val(), $('#'+frm_id+' #frm').val(), $('#'+mdl_id).data('id'), $('#'+frm_id+' #user').val());
		fn_check_capa_classification($('#'+frm_id+' #mdl').val(), $('#'+frm_id+' #frm').val(), $('#'+mdl_id).data('id'), $('#'+frm_id+' #user').val());
		fn_capa_reload_datatables();
		console.log(result);
	});
}
/* ***************************
	CAPA Operations QE and QAD QE Edit - End
*************************** */
/* ***************************
	CAPA Operations QE and QAD QE View - Start
*************************** */
var mdl_qc_qad_monitoring_view		= 'modal_capa_qc_qad_external_2nd_monitoring_view';
var frm_qc_qad_monitoring_view		= 'frm_capa_qc_qad_external_2nd_monitoring_view';

$('#'+ tbl_ope_qe_qad +' tbody').on('click','tr .fa-eye', function(){
	var pkid = $(this).data('id');
	load_new(mdl_qc_qad_monitoring_view, frm_qc_qad_monitoring_view);
	fn_get_capa_main_details(mdl_qc_qad_monitoring_view, frm_qc_qad_monitoring_view, pkid);
	fn_get_capa_1st_monitoring_details(mdl_qc_qad_monitoring_view, frm_qc_qad_monitoring_view, pkid, 'qc_qad');
	fn_check_capa_classification(mdl_qc_qad_monitoring_view, frm_qc_qad_monitoring_view, pkid, 'qc_qad');
	$('#'+mdl_qc_qad_monitoring_view).modal('show');
 });

/* ***************************
	CAPA Operations QE and QAD QE View - End
*************************** */

/* ***************************
	CAPA QC and QAD AM Up - Start
*************************** */

var tbl_qc_qad_am_up    		= 'tbl_capa_qc_qad_am_up';
var dt_qc_qad_am_up 			= '';
var mdl_qc_qad_am_up			= 'modal_capa_qc_qad_am_up';
var frm_qc_qad_am_up			= 'frm_capa_qc_qad_am_up';

if(dt_qc_qad_am_up == '') {
	dt_qc_qad_am_up = $('#'+tbl_qc_qad_am_up).DataTable({
		"aaSorting"	 : [],	
		"bProcessing": true,
		"bServerSide": true,
		"sAjaxSource": "server_side_scripts/qr/dt_capa_qc_qad_am_up.php?username="+username,
		"drawCallback": function( settings ) {
			$('#'+tbl_qc_qad_am_up).attr('style','width:100%;');
		}
	});
}

$('#'+ tbl_qc_qad_am_up +' tbody').on('click','tr .fa-eye', function(){
	var pkid = $(this).data('id');
	$('#'+mdl_qc_qad_am_up).data('id', pkid);
	load_new(mdl_qc_qad_am_up, frm_qc_qad_am_up);
	fn_get_capa_main_details(mdl_qc_qad_am_up, frm_qc_qad_am_up, pkid);
	fn_get_capa_1st_monitoring_details(mdl_qc_qad_am_up, frm_qc_qad_am_up, pkid, 'am_up');
	fn_check_capa_classification(mdl_qc_qad_am_up, frm_qc_qad_am_up, pkid, 'am_up');
	$('#'+mdl_qc_qad_am_up).modal('show');
 });

$('#'+mdl_qc_qad_am_up+' .fa-paperclip').click(function() {
	window.location.href = "./pages/qfr/dl_capa_attachments.php?id="+$(this).val()+"&fk_cor="+$(this).data('fk')+"&type=main&user=qs&order=";
});

 $('#'+frm_qc_qad_am_up+' #tbl_monitoring tbody').on('click' , 'a', function(){
	window.location.href = "./pages/qfr/dl_capa_attachments.php?id="+$(this).data('id')+"&fk_cor="+$(this).data('fk')+"&type=validation&val=1&user=qs&order="+$(this).data('order');
	return false;
});

$('#'+frm_qc_qad_am_up+' #tbl_monitoring2 tbody').on('click' , 'a', function(){
	window.location.href = "./pages/qfr/dl_capa_attachments.php?id="+$(this).data('id')+"&fk_cor="+$(this).data('fk')+"&type=validation&val=2&user=qc&order="+$(this).data('order');
	return false;
});
 
$('#'+ frm_qc_qad_am_up+ ' #tbl_monitoring2 tbody').on('click','tr .fa-check-square-o', function(){
	var validation_field = $(this).data('id');
	$('#'+mdl_qs_supervisor_conf + ' #container_approver_message').attr('class','alert alert-success');
	$('#'+mdl_qs_supervisor_conf + ' #container_approver_message').html('Are you sure you want to approve the request?<br><br>Remarks:<textarea name="remarks" id="remarks" style="width:100%;" rows="4"></textarea>');
	$('#'+mdl_qs_supervisor_conf + ' #container_approver_message').show();
	$('#'+mdl_qs_supervisor_conf).data('type', 'Check AM-Up');
	$('#'+mdl_qs_supervisor_conf).data('validation_field', validation_field);
	$('#'+mdl_qs_supervisor_conf).data('status', 'CHECKED');
	$('#'+mdl_qs_supervisor_conf).modal();	
 });
 
$('#'+ frm_qc_qad_am_up+ ' #tbl_monitoring2 tbody').on('click','tr .fa-times-rectangle-o', function(){
	var validation_field = $(this).data('id');
	$('#'+mdl_qs_supervisor_conf + ' #container_approver_message').attr('class','alert alert-danger');
	$('#'+mdl_qs_supervisor_conf + ' #container_approver_message').html('Are you sure you want to reject the request?<br><br>Remarks:<textarea name="remarks" id="remarks" style="width:100%;" rows="4" required></textarea>');
	$('#'+mdl_qs_supervisor_conf + ' #container_approver_message').show();
	$('#'+mdl_qs_supervisor_conf).data('type', 'Check AM Up');
	// $('#'+mdl_qs_supervisor_conf).data('monitoring_field', monitoring_field);
	$('#'+mdl_qs_supervisor_conf).data('validation_field', validation_field);
	$('#'+mdl_qs_supervisor_conf).data('status', 'REJECTED');
	$('#'+mdl_qs_supervisor_conf).modal();
 });
 
$('#'+ frm_qc_qad_am_up+ ' #tbl_monitoring2 tbody').on('click','tr .fa-remove', function(){
	var fk_capa_correction = $(this).data('fk');
	$('#'+mdl_qc_qad_am_up_conf + ' #container_approver_message').attr('class','alert alert-danger');
	$('#'+mdl_qc_qad_am_up_conf + ' #container_approver_message').html('Are you sure you want to cancel the corrective/correction action?');
	$('#'+mdl_qc_qad_am_up_conf + ' #container_approver_message').show();
	$('#'+mdl_qc_qad_am_up_conf).data('type', 'Post');
	$('#'+mdl_qc_qad_am_up_conf).data('fk', fk_capa_correction);
	$('#'+mdl_qc_qad_am_up_conf).data('status', 'CANCELLED');
	$('#'+mdl_qc_qad_am_up_conf).modal();
 });
 
$('#'+ frm_qc_qad_am_up+ ' #tbl_monitoring2 tbody').on('click','tr .fa-tags', function(){
	var fk_capa_correction = $(this).data('fk');
	$('#'+mdl_qc_qad_am_up_conf + ' #container_approver_message').attr('class','alert alert-success');
	$('#'+mdl_qc_qad_am_up_conf + ' #container_approver_message').html('Are you sure you want to post the corrective/correction action?');
	$('#'+mdl_qc_qad_am_up_conf + ' #container_approver_message').show();
	$('#'+mdl_qc_qad_am_up_conf).data('type', 'Post');
	$('#'+mdl_qc_qad_am_up_conf).data('fk', fk_capa_correction);
	$('#'+mdl_qc_qad_am_up_conf).data('status', 'CLOSED');
	$('#'+mdl_qc_qad_am_up_conf).modal();
 });
/* ***************************
	CAPA QC and QAD AM Up - End
*************************** */

/* ***************************
	CAPA QAD - Start
*************************** */

var tbl_qad    					= 'tbl_capa_qad_access';
var dt_tbl_qad 					= '';
var mdl_qad						= 'modal_capa_qad_external_3rd_monitoring';
var frm_qad						= 'frm_capa_qad_external_3rd_monitoring';

if(dt_tbl_qad == '') {
	dt_tbl_qad = $('#'+tbl_qad).DataTable({
		"aaSorting"	 : [],	
		"bProcessing": true,
		"bServerSide": true,
		"sAjaxSource": "server_side_scripts/qr/dt_capa_qad.php?username="+username,
		"drawCallback": function( settings ) {
			$('#'+tbl_qad).attr('style','width:100%;');
		}
	});
}

$('#'+ tbl_qad +' tbody').on('click','tr .fa-plus', function(){
	var pkid = $(this).data('id');
	$('#'+mdl_qad).data('id', pkid);
	load_new(mdl_qad, frm_qad);
	fn_get_capa_main_details(mdl_qad, frm_qad, pkid);
	fn_get_capa_1st_monitoring_details(mdl_qad, frm_qad, pkid, 'qad');
	fn_check_capa_classification(mdl_qad, frm_qad, pkid, 'qad');
	$('#'+mdl_qad).modal('show');
 });
 
 $('#'+mdl_qad+' .fa-paperclip').click(function() {
	window.location.href = "./pages/qfr/dl_capa_attachments.php?id="+$(this).val()+"&fk_cor="+$(this).data('fk')+"&type=main&user=qs&order=";
});

$('#'+frm_qad+' #tbl_monitoring tbody').on('click' , 'a', function(){
	window.location.href = "./pages/qfr/dl_capa_attachments.php?id="+$(this).data('id')+"&fk_cor="+$(this).data('fk')+"&type=validation&val=1&user=qs&order="+$(this).data('order');
	return false;
});

$('#'+frm_qad+' #tbl_monitoring2 tbody').on('click' , 'a', function(){
	window.location.href = "./pages/qfr/dl_capa_attachments.php?id="+$(this).data('id')+"&fk_cor="+$(this).data('fk')+"&type=validation&val=2&user=qc&order="+$(this).data('order');
	return false;
});

$('#'+frm_qad+' #tbl_monitoring3 tbody').on('click' , 'a', function(){
	window.location.href = "./pages/qfr/dl_capa_attachments.php?id="+$(this).data('id')+"&fk_cor="+$(this).data('fk')+"&type=validation&val=3&user=qad&order="+$(this).data('order');
	return false;
});

$('#'+ frm_qad +' #btn_add_validation').click(function(){
	var fk_capa = $(this).val();
	$('#'+frm_add_monitoring+' #tbl_id').val('tbl_qfr_capa_3rd_validation_external');
	$('#'+frm_add_monitoring+' #mdl').val('modal_capa_qad_external_3rd_monitoring');
	$('#'+frm_add_monitoring+' #frm').val('frm_capa_qad_external_3rd_monitoring');
	$('#'+frm_add_monitoring+' #user').val('qad');
	$('#'+mdl_add_monitoring).data('id', fk_capa);
	re_initialize_select2_server_side('#'+mdl_add_monitoring+' #correction_list','#'+mdl_add_monitoring+' #'+frm_add_monitoring,[],"server_side_scripts/dropdown/qfr/dd_capa_correction_list.php?fk_capa="+fk_capa+"&status=");	
	re_initialize_select2_server_side('#'+mdl_add_monitoring+' #monitoring_by','#'+mdl_add_monitoring+' #'+frm_add_monitoring,[],"server_side_scripts/dropdown/common/dd_hris_above_ss_list.php");	
	$('#'+mdl_add_monitoring).modal('show');
 });

/* ***************************
	CAPA QAD Edit - Start
*************************** */

var mdl_qad_edit				= 'modal_capa_qad_external_3rd_monitoring_edit';
var frm_qad_edit				= 'frm_capa_qad_external_3rd_monitoring_edit';

$('#'+ tbl_qad +' tbody').on('click','tr .fa-edit', function(){
	var pkid = $(this).data('id');
	$('#'+mdl_qad_edit).data('id', pkid);
	load_new(mdl_qad_edit, frm_qad_edit);
	fn_get_capa_main_details(mdl_qad_edit, frm_qad_edit, pkid);
	fn_get_capa_1st_monitoring_details(mdl_qad_edit, frm_qad_edit, pkid, 'qad_edit');
	fn_check_capa_classification(mdl_qad_edit, frm_qad_edit, pkid, 'qad_edit');
	$('#'+mdl_qad_edit).modal('show');
 });
 
 $('#'+mdl_qad_edit+' .fa-paperclip').click(function() {
	window.location.href = "./pages/qfr/dl_capa_attachments.php?id="+$(this).val()+"&fk_cor="+$(this).data('fk')+"&type=main&user=qs&order=";
});

$('#'+frm_qad_edit+' #tbl_monitoring tbody').on('click' , 'a', function(){
	window.location.href = "./pages/qfr/dl_capa_attachments.php?id="+$(this).data('id')+"&fk_cor="+$(this).data('fk')+"&type=validation&val=1&user=qs&order="+$(this).data('order');
	return false;
});

$('#'+frm_qad_edit+' #tbl_monitoring2 tbody').on('click' , 'a', function(){
	window.location.href = "./pages/qfr/dl_capa_attachments.php?id="+$(this).data('id')+"&fk_cor="+$(this).data('fk')+"&type=validation&val=2&user=qc&order="+$(this).data('order');
	return false;
});

$('#'+frm_qad_edit+' #tbl_monitoring3 tbody').on('click' , 'a', function(){
	window.location.href = "./pages/qfr/dl_capa_attachments.php?id="+$(this).data('id')+"&fk_cor="+$(this).data('fk')+"&type=validation&val=3&user=qad&order="+$(this).data('order');
	return false;
});

 $('#'+ mdl_qad_edit +' #tbl_monitoring3 tbody').on('click','tr .fa-edit', function(){
	fn_return_editable_monitoring(frm_edit_validation, $(this).data('correction'), 'qad', 'validation');	
	$('#'+frm_edit_validation+' #dl_capa_attachment').hide();
	$('#'+mdl_edit_ccrrection_valid).data('fkcapa', $(this).data('capa'));
	$('#'+mdl_edit_ccrrection_valid).data('fkcorrection', $(this).data('correction'));
	
	$('#'+frm_edit_validation+' #tbl_id').val('tbl_qfr_capa_3rd_validation_external');
	$('#'+frm_edit_validation+' #mdl').val('modal_capa_qs_inspector_external_1st_monitoring_edit');
	$('#'+frm_edit_validation+' #frm').val('frm_capa_qs_inspector_external_edit_monitoring');
	$('#'+frm_edit_validation+' #user').val('qad_edit');
	$('#'+frm_edit_validation).data('user-id','qad');
	$('#'+mdl_edit_ccrrection_valid).data('id', $(this).data('capa'));
	re_initialize_select2_server_side('#'+mdl_edit_ccrrection_valid+' #monitoring_by','#'+mdl_edit_ccrrection_valid+' #'+frm_edit_validation,[],"server_side_scripts/dropdown/common/dd_hris_all_list.php");
	
	$('#'+mdl_edit_ccrrection_valid).modal('show');
 });

$('#'+ frm_qad_edit +' #btn_add_validation').click(function(){
	var fk_capa = $(this).val();
	$('#'+frm_add_monitoring+' #tbl_id').val('tbl_qfr_capa_3rd_validation_external');
	$('#'+frm_add_monitoring+' #mdl').val('modal_capa_qad_external_3rd_monitoring');
	$('#'+frm_add_monitoring+' #frm').val('frm_capa_qad_external_3rd_monitoring');
	$('#'+frm_add_monitoring+' #user').val('qad');
	$('#'+mdl_add_monitoring).data('id', fk_capa);
	re_initialize_select2_server_side('#'+mdl_add_monitoring+' #correction_list','#'+mdl_add_monitoring+' #'+frm_add_monitoring,[],"server_side_scripts/dropdown/qfr/dd_capa_correction_list.php?fk_capa="+fk_capa+"&status=");	
	re_initialize_select2_server_side('#'+mdl_add_monitoring+' #monitoring_by','#'+mdl_add_monitoring+' #'+frm_add_monitoring,[],"server_side_scripts/dropdown/common/dd_hris_above_ss_list.php");	
	$('#'+mdl_add_monitoring).modal('show');
 });


/* ***************************
	CAPA Data Common Functions - Start
*************************** */

function load_new(mdl_id, frm_id) {
	fn_get_section_list(frm_id);
	re_initialize_select2_server_side('#'+mdl_id+' #assigned_line','#'+mdl_id+' #'+frm_id,[],"server_side_scripts/dropdown/common/dd_hris_above_ss_list.php");
	re_initialize_select2_server_side('#'+mdl_id+' #checked_by','#'+mdl_id+' #'+frm_id,[],"server_side_scripts/dropdown/common/dd_hris_above_ss_list.php");	
	re_initialize_select2_server_side('#'+mdl_id+' #conformed_by','#'+mdl_id+' #'+frm_id,[],"server_side_scripts/dropdown/common/dd_hris_all_list.php");	
	re_initialize_select2_server_side('#'+mdl_id+' #operations_qe','#'+mdl_id+' #'+frm_id,[],"server_side_scripts/dropdown/common/dd_hris_all_list.php");	
	re_initialize_select2_server_side('#'+mdl_id+' #qc_qad_manager','#'+mdl_id+' #'+frm_id,[],"server_side_scripts/dropdown/common/dd_hris_all_list.php");	
	re_initialize_select2_server_side('#'+mdl_id+' #qad_auditor','#'+mdl_id+' #'+frm_id,[],"server_side_scripts/dropdown/common/dd_hris_all_list.php");	
	re_initialize_select2_server_side('#'+mdl_id+' #conformance','#'+mdl_id+' #'+frm_id,[],"server_side_scripts/dropdown/common/dd_hris_all_list.php");	
	
}

function fn_capa_reload_datatables() {
	dt_external.ajax.reload(null, false);
	dt_qs_inspector.ajax.reload(null, false);
	dt_ope_qs_sup.ajax.reload(null, false);
	dt_ope_qs_conf.ajax.reload(null, false);
	dt_ope_qe_qad.ajax.reload(null, false);
	dt_qc_qad_am_up.ajax.reload(null, false);
	// dt_qc_qad_conformance.ajax.reload(null, false);
}

function fn_get_section_list(frm_id) {
	$('#'+frm_id+' select[name="section"]').empty();
	var data = {
		"action"	: "get_section_list"
	}
	call_ajax(data, common_handler, function(result){	
		$('#'+frm_id+' select[name="section"]').append(result['html_select']);
	});
}

function fn_get_8d_po_list(pattern, frm_id) {
	$('#'+frm_id).empty();
	var data = {
		"action"	: "get_8d_po_list",
		pattern		: pattern,
	}
	call_ajax(data, handler_qfr_capa, function(result){	
		$('#'+frm_id).append(result['html_select']);
	});
}

function fn_get_capa_main_details(mdl_id, frm_id, pkid) {
	var data = {
		"action"	: "get_capa_main_details",
		pkid		: pkid,
	}
	call_ajax(data, handler_qfr_capa, function(result){	
		$.each(result['data'], function(key, value) {
			$('#'+frm_id+' input[name="'+key+'"]').val(value);
			$('#'+frm_id+' select[name="'+key+'"]').val(value);
			$('#'+frm_id+' textarea[name="'+key+'"]').val(value);
			
			if(key == 'pkid') {
				$('#'+frm_id+' button').val(value);
			}
			if(key == 'assigned_line') {
				assign_value_select2('#'+frm_id+' #assigned_line',result['data']['assigned_line']);	
				re_initialize_select2_server_side('#'+mdl_id+' #assigned_line','#'+mdl_id+' #'+frm_id,[],"server_side_scripts/dropdown/common/dd_hris_all_list.php");						
			}
			if(key == 'checked_by') {
				assign_value_select2('#'+frm_id+' #checked_by',result['data']['checked_by']);		
				re_initialize_select2_server_side('#'+mdl_id+' #checked_by','#'+mdl_id+' #'+frm_id,[],"server_side_scripts/dropdown/common/dd_hris_all_list.php");								
			}
			if(key == 'conformed_by') {
				assign_value_select2('#'+frm_id+' #conformed_by',result['data']['conformed_by']);
				re_initialize_select2_server_side('#'+mdl_id+' #conformed_by','#'+mdl_id+' #'+frm_id,[],"server_side_scripts/dropdown/common/dd_hris_all_list.php");					
			}
			if(key == 'operations_qe') {
				assign_value_select2('#'+frm_id+' #operations_qe',result['data']['operations_qe']);
				re_initialize_select2_server_side('#'+mdl_id+' #operations_qe','#'+mdl_id+' #'+frm_id,[],"server_side_scripts/dropdown/common/dd_hris_all_list.php");					
			}
			if(key == 'file_name') {
				if(value == '') {
					$('#'+frm_id+' .fa-paperclip').prop('disabled', true);
				} else {
					$('#'+frm_id+' .fa-paperclip').prop('disabled', false);
				}				
			}
		});
		// console.log('rona '+result['script']);
	});
}

function fn_get_capa_1st_monitoring_details(mdl_id, frm_id, fk_capa, user) {
	$('#'+frm_id+' #tbl_monitoring tbody').empty();	
	var data = {
		"action"	: "get_capa_1st_monitoring_details",
		"user"		: user,
		"fk_capa"	: fk_capa,
	}
	call_ajax(data, handler_qfr_capa, function(result){	
		$('#'+frm_id+' #tbl_monitoring tbody').append(result['table_body']);
		console.log(result);
	});
}

function fn_get_capa_2nd_validation_details(mdl_id, frm_id, fk_capa, user) {
	$('#'+frm_id+' #tbl_monitoring2 tbody').empty();
	var data = {
		"action"	: "get_capa_2nd_validation_details",
		"user"		: user,
		"fk_capa"	: fk_capa,
	}
	call_ajax(data, handler_qfr_capa, function(result){	
		$('#'+frm_id+' #tbl_monitoring2 tbody').append(result['table_body']);
		console.log(result);
	});
}

function fn_get_capa_3rd_validation_details(mdl_id, frm_id, fk_capa, user) {
	$('#'+frm_id+' #tbl_monitoring3 tbody').empty();
	var data = {
		"action"	: "get_capa_3rd_validation_details",
		"user"		: user,
		"fk_capa"	: fk_capa,
	}
	call_ajax(data, handler_qfr_capa, function(result){	
		$('#'+frm_id+' #tbl_monitoring3 tbody').append(result['table_body']);
		console.log('3rd validation '+result);
	});
}

function fn_check_capa_classification(mdl_id, frm_id, fk_capa, user) {
	var data = {
		"action"	: "check_capa_classification",
		"pkid"		: fk_capa
	}
	call_ajax(data, handler_qfr_capa, function(result){	
		if(result['classification'] == 'External') {
			fn_get_capa_2nd_validation_details(mdl_id, frm_id, fk_capa, user);
			fn_get_capa_3rd_validation_details(mdl_id, frm_id, fk_capa, user);
		}
	});
}

function fn_check_capa_2nd_monitoring_supervisor(pkid) {
	var data = {
		"action"	: "check_capa_2nd_monitoring",
		"pkid"		: pkid
	}
	call_ajax(data, handler_qfr_capa, function(result){	
		if(result['rows'] == 0) {
			$('#'+mdl_qs_supervisor).data('id', pkid);
			load_new(mdl_qs_supervisor, frm_qs_supervisor);
			fn_get_capa_main_details(mdl_qs_supervisor, frm_qs_supervisor, pkid);
			fn_get_capa_1st_monitoring_details(mdl_qs_supervisor, frm_qs_supervisor, pkid, 'supervisor');
			$('#'+mdl_qs_supervisor).modal('show');
		} else {			
			$('#'+mdl_qc_qad_supervisor).data('id', pkid);
			load_new(mdl_qc_qad_supervisor, frm_qc_qad_supervisor);
			fn_get_capa_main_details(mdl_qc_qad_supervisor, frm_qc_qad_supervisor, pkid);
			fn_get_capa_1st_monitoring_details(mdl_qc_qad_supervisor, frm_qc_qad_supervisor, pkid, 'supervisor');
			fn_check_capa_classification(mdl_qc_qad_supervisor, frm_qc_qad_supervisor, pkid, 'supervisor');
			$('#'+mdl_qc_qad_supervisor).modal('show');
		}
		$('#'+mdl_qs_supervisor_conf).data('id', pkid);
	});
}

function fn_check_capa_2nd_monitoring_conformance(pkid) {
	var data = {
		"action"	: "check_capa_2nd_monitoring",
		"pkid"		: pkid
	}
	call_ajax(data, handler_qfr_capa, function(result){	
		if(result['rows'] == 0) {
			$('#'+mdl_qs_conformance).data('id', pkid);
			load_new(mdl_qs_conformance, frm_qs_conformance);
			fn_get_capa_main_details(mdl_qs_conformance, frm_qs_conformance, pkid);
			fn_get_capa_1st_monitoring_details(mdl_qs_conformance, frm_qs_conformance, pkid, 'conformance');
			$('#'+mdl_qs_conformance).modal('show');
		} else {
			$('#'+mdl_qc_qad_conformance).data('id', pkid);
			$('#'+mdl_qs_conformance).data('id', pkid);
			load_new(mdl_qc_qad_conformance, frm_qc_qad_conformance);
			fn_get_capa_main_details(mdl_qc_qad_conformance, frm_qc_qad_conformance, pkid);
			fn_get_capa_1st_monitoring_details(mdl_qc_qad_conformance, frm_qc_qad_conformance, pkid, 'conformance');
			fn_check_capa_classification(mdl_qc_qad_conformance, frm_qc_qad_conformance, pkid, 'conformance');
			$('#'+mdl_qc_qad_conformance).modal('show');
		}
	});
}

function fn_get_capa_correction_details(mdl_id, frm_id, pkid) {
	var data = {
		"action"	: "get_capa_correction_details",
		"pkid"		: pkid,
	}
	call_ajax(data, handler_qfr_capa, function(result){	
		$.each(result['data'], function(key, value) {
			$('#'+frm_id+' input[name="'+key+'"]').val(value);
			$('#'+frm_id+' select[name="'+key+'"]').val(value);
			$('#'+frm_id+' textarea[name="'+key+'"]').val(value);
			
			if(key == 'pkid') {
				$('#'+frm_id+' button').val(value);
			}
			if(key == 'incharge_person') {
				assign_value_select2('#'+frm_id+' #incharge_person',result['data']['incharge_person']);	
				re_initialize_select2_server_side('#'+mdl_id+' #incharge_person','#'+mdl_id+' #'+frm_id,[],"server_side_scripts/dropdown/common/dd_hris_all_list.php");						
			}
		});
		console.log(result);
	});
}

function fn_return_editable_monitoring(frm_id, pkid, user, field) {
	$('#'+frm_id+' #monitoring_number').empty();
	var data = {
		"action"	: "return_editable_monitoring",
		"pkid"		: pkid,
		"user"		: user,
		"field"		: field,
	}
	call_ajax(data, handler_qfr_capa, function(result){	
		$('#'+frm_id+' #monitoring_number').append(result['html_select']);
		console.log('rona '+result['script']);
		console.log('rona '+result['POST']);
		console.log('rona '+result['html_select']);
	});
}

function fn_return_monitoring_data_by_field(mdl_id, frm_id, fk_capa, fk_capa_correction, user, tbl_id, field) {
	var data = {
		"action"				: "return_monitoring_data_by_field",
		"fk_capa"				: fk_capa,
		"fk_capa_correction"	: fk_capa_correction,
		"user"					: user,
		"field"					: field,
		"tbl_id"				: tbl_id,
	}
	call_ajax(data, handler_qfr_capa, function(result){	
		$('#'+frm_id+' #monitoring_date').val(result['monitoring_date']);
		$('#'+frm_id+' #monitoring_result').val(result['monitoring_result']);
		if(result['file_capa_attachment'] != '') {
			$('#'+frm_id+' #dl_capa_attachment').data('id', fk_capa);
			$('#'+frm_id+' #dl_capa_attachment').data('fk', fk_capa_correction);
			$('#'+frm_id+' #dl_capa_attachment').data('order', result['order']);
			$('#'+frm_id+' #dl_capa_attachment').show();
		} else {
			$('#'+frm_id+' #dl_capa_attachment').hide();
		}
		assign_value_select2('#'+frm_id+' #monitoring_by',result['monitoring_by']);	
		re_initialize_select2_server_side('#'+mdl_id+' #monitoring_by','#'+mdl_id+' #'+frm_id,[],"server_side_scripts/dropdown/common/dd_hris_all_list.php");	
		console.log(result);
	});
}


/* ***************************
	CAPA Data Common Functions - End
*************************** */