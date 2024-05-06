var dt_qcfr_lqc_ins 			= '';
var tbl_qcfr 					= 'tbl_qcfr';
var mdl_new_qcfr 				= 'mdl_new_qcfr';
var frm_new_qcfr 				= 'frm_new_qcfr';

dt_qcfr_lqc_ins = $('#'+tbl_qcfr).DataTable({
	"aaSorting"	 : [],
	"bProcessing": true,
	"bServerSide": true,
	"sAjaxSource": "server_side_scripts/qr/dt_qcfr_lqc_inspector.php?username="+username,
	"drawCallback": function( settings ) {
		$('#'+tbl_qcfr).attr('style','width:100%;');
	}
});

$("#"+mdl_new_qcfr+" input[name='subcon_pmi[]']").on('change', function() {
	var subcon_pmi = $(this).val();
	fn_set_to_list(mdl_new_qcfr,frm_new_qcfr, subcon_pmi);
});

$("#"+mdl_new_qcfr+" input[name='found_during[]']").on('click', function() {
	var found_during = $(this).attr('id');	
});

$("#"+mdl_new_qcfr+" #chk_fd_others").on('click', function() {
	if($(this).is(':checked')) {
		$('#'+mdl_new_qcfr+' input[name=found_during_others]').prop('disabled', false);
		$('#'+mdl_new_qcfr+' input[name=found_during_others]').prop('required', true);
	} else {
		$('#'+mdl_new_qcfr+' input[name=found_during_others]').prop('disabled', true);
		$('#'+mdl_new_qcfr+' input[name=found_during_others]').prop('required', false);
	}
});

$('#'+frm_new_qcfr+' input[name="po_no_invoice_no"]').keyup(function(e){
	var pattern = $(this).val();
	if($('#'+mdl_new_qcfr+' #chk_fd_incoming_inspection').is(':checked')) {
		fn_get_ng_invoice_num_datalist(pattern,frm_new_qcfr+' #list_po_no_invoice_no');
	} else {
		fn_get_po_list(pattern, frm_new_qcfr+' #list_po_no_invoice_no');
	}
	
});

$('#'+frm_new_qcfr+' input[name="po_no_invoice_no"]').change(function(e){
	var po_no_invoice_no = $(this).val();
	if($('#'+mdl_new_qcfr+' #chk_fd_incoming_inspection').is(':checked')) {
		
	} else {
		var array_fields = [
			'input[name="model_no"]',
			'',
			'',
			''
		]
		fn_get_po_details(po_no_invoice_no,frm_new_qcfr,array_fields);
	}
});

$("#"+mdl_new_qcfr+" input[name='nature_of_request[]']").on('change', function() {
	var nature_of_request = $(this).val();
	fn_set_answer_by_nature_request(mdl_new_qcfr, nature_of_request);
});

$("#"+mdl_new_qcfr+" #chk_dispo_others").on('click', function() {
	if($(this).is(':checked')) {
		$('#'+mdl_new_qcfr+' input[name=disposition_others]').prop('disabled', false);
		$('#'+mdl_new_qcfr+' input[name=disposition_others]').prop('required', true);
	} else {
		$('#'+mdl_new_qcfr+' input[name=disposition_others]').prop('disabled', true);
		$('#'+mdl_new_qcfr+' input[name=disposition_others]').prop('required', false);
	}
});

$('#'+frm_new_qcfr+' input[name="defective_qty"]').change(function(e){
	var defective_qty 	= $('#'+frm_new_qcfr+' input[name="defective_qty"]').val();
	var sampling_plan_n = $('#'+frm_new_qcfr+' input[name="sampling_plan_n"]').val();
	if(defective_qty == '' || sampling_plan_n == '') {
		$('#'+frm_new_qcfr+' input[name="defective_percentage"]').val('0');
	} else {		
		var defective_percentage = parseFloat(defective_qty / sampling_plan_n).toFixed(2);
		$('#'+frm_new_qcfr+' input[name="defective_percentage"]').val(defective_percentage);
	}
});
$('#'+frm_new_qcfr+' input[name="sampling_plan_n"]').change(function(e){
	var defective_qty 	= $('#'+frm_new_qcfr+' input[name="defective_qty"]').val();
	var sampling_plan_n = $('#'+frm_new_qcfr+' input[name="sampling_plan_n"]').val();
	if(defective_qty == '' || sampling_plan_n == '') {
		$('#'+frm_new_qcfr+' input[name="defective_percentage"]').val('0');
	} else {		
		var defective_percentage = parseFloat(defective_qty / sampling_plan_n).toFixed(2);
		$('#'+frm_new_qcfr+' input[name="defective_percentage"]').val(defective_percentage);
	}
});

$('#btn_add_qcfr').click(function() {
	fn_return_reported_by(mdl_new_qcfr);
	fn_return_product_name_list(frm_new_qcfr);
	fn_return_prod_family_list(frm_new_qcfr);
	$('#'+mdl_new_qcfr+' input[type="text"], input[type="date"], input[type="number"], select,textarea').prop('readOnly', false);
	$('#'+mdl_new_qcfr+' input[name="reported_by"],input[name="model_no"],input[name="defective_percentage"]').prop('readOnly', true);
	re_initialize_select2_server_side('#'+mdl_new_qcfr+' #cmb_attn','#'+mdl_new_qcfr+' #'+frm_new_qcfr,[],"server_side_scripts/dropdown/common/dd_hris_pmi_and_subcon_list.php");	
	fn_set_to_list(mdl_new_qcfr,frm_new_qcfr, "PMI Assy");	
	re_initialize_select2_server_side('#'+mdl_new_qcfr+' #batch_no_lot_no','#'+mdl_new_qcfr+' #'+frm_new_qcfr,[],"server_side_scripts/dropdown/qfr/dd_qcfr_lotno_list.php");
	re_initialize_select2_server_side('#'+mdl_new_qcfr+' #cmb_reported_by','#'+mdl_new_qcfr+' #'+frm_new_qcfr,[],"server_side_scripts/dropdown/common/dd_hris_pmi_and_subcon_list.php");
	re_initialize_select2_server_side('#'+mdl_new_qcfr+' #verified_conformed_by_lqc','#'+mdl_new_qcfr+' #'+frm_new_qcfr,[],"server_side_scripts/dropdown/common/dd_hris_pmi_and_subcon_list.php");
	re_initialize_select2_server_side('#'+mdl_new_qcfr+' #verified_conformed_by_eng','#'+mdl_new_qcfr+' #'+frm_new_qcfr,[],"server_side_scripts/dropdown/common/dd_hris_pmi_and_subcon_list.php");
	re_initialize_select2_server_side('#'+mdl_new_qcfr+' #verified_conformed_by_prdn','#'+mdl_new_qcfr+' #'+frm_new_qcfr,[],"server_side_scripts/dropdown/common/dd_hris_pmi_and_subcon_list.php");
	re_initialize_select2_server_side('#'+mdl_new_qcfr+' #approved_by_sh','#'+mdl_new_qcfr+' #'+frm_new_qcfr,[],"server_side_scripts/dropdown/common/dd_hris_above_ss_list.php");
	re_initialize_select2_server_side('#'+mdl_new_qcfr+' #approved_by_dh','#'+mdl_new_qcfr+' #'+frm_new_qcfr,[],"server_side_scripts/dropdown/common/dd_hris_above_ss_list.php");
	
	$('#'+mdl_new_qcfr).modal('show');
});

$('#'+frm_new_qcfr).on('submit', function(e) {
	e.preventDefault();
	// alert($('#'+frm_new_qcfr+' input[name="found_during[]"]').val());
	if(fn_validate_data_submission(frm_new_qcfr) == '') {
		var serialized_data = new FormData(this);
			serialized_data.append("action","save_qcfr");
			serialized_data.append("status","FOR VERIFICATION");
			serialized_data.append("username",username);
		fn_save_qcfr(serialized_data, frm_new_qcfr, mdl_new_qcfr);
	} else {
		$('#modal_system_message').modal();
		$('#container_message').attr('class','alert alert-warning');
		$('#container_message').html( '<h4>'+fn_validate_data_submission(frm_new_qcfr)+'</h4>' );
	}
});

function fn_validate_data_submission(frm_id) {
	/* We will do the manual checking of required checkbox's since funkyradio did not support "required of form submit" */
	var no_data_input = '';
	var no_data 	  = '';
	if($('#'+frm_id+' input[name="subcon_pmi[]"]:checked').length == 0) {
		no_data += '> Supplier/Subcon or PMI Assy. <br>';
	}
	if($('#'+frm_id+' input[name="found_during[]"]:checked').length == 0) {
		no_data += '> Found during <br>';
	}
	if($('#'+frm_id+' input[name="inspection_method[]"]:checked').length == 0) {
		no_data += '> Inspection method <br>';
	}
	if($('#'+frm_id+' input[name="disposition[]"]:checked').length == 0) {
		no_data += '> Disposition <br>';
	}
	if($('#'+frm_id+' input[name="nature_of_request[]"]:checked').length == 0) {
		no_data += '> Nature of request <br>';
	}
	if($('#'+frm_id+' input[name="answer[]"]:checked').length == 0) {
		no_data += '> Answer <br>';
	}
	
	if(no_data != '') {
		no_data_input  = 'No data selected on:<br>';
		no_data_input += no_data;
	}
	return no_data_input;
}

function fn_save_qcfr(serialized_data, frm_id, mdl_id) {
	// $('.btn').prop("disabled",true);
	call_ajax_attachment(serialized_data, handler_qcfr, function(result){
		console.log(result);
		$('#'+mdl_id).modal('hide');
		$('#modal_system_message').modal();
		$('#container_message').attr('class','alert alert-success');
		$('#container_message').html( '<h4>'+result['msg']+'</h4>' );
		$('.btn').prop("disabled",false);
		fn_reload_qcfr_datatables();
	});
}

/* Add answer - start */
var mdl_add_answer_qcfr 		= 'mdl_add_answer_qcfr';
var frm_add_answer_qcfr			= 'frm_add_answer_qcfr';
var frm_add_answer_qcfr_edit 	= 'frm_add_answer_qcfr_edit';

$('#' + tbl_qcfr + ' tbody').on('click','tr .fa-plus',function(){
	var pkid 	= $(this).data("id");
	$('#'+mdl_add_answer_qcfr).data("id", pkid);	
	$('#'+frm_add_answer_qcfr+' input[type="text"], input[type="date"], input[type="number"], select, textarea').prop('readOnly', true);
	$('#'+frm_add_answer_qcfr_edit+' select, textarea').prop('readOnly', false);
	
	fn_get_qcfr_details(pkid,mdl_add_answer_qcfr,frm_add_answer_qcfr,'view');
	fn_get_qcfr_fill_in_signatories(pkid,mdl_add_answer_qcfr,frm_add_answer_qcfr_edit);
});

$('#'+frm_add_answer_qcfr + ' #btn_request_attachment' ).click(function() {
	fn_return_qcfr_attachments($(this).val(),"REQUEST","");
});

$('#'+frm_add_answer_qcfr + ' #btn_view_attachment_8d_capa' ).click(function() {
	fn_return_qcfr_attachments($(this).val(),"8D/CAPA","");
});

$('#'+frm_add_answer_qcfr_edit).on('submit', function(e) {
	e.preventDefault();
	var serialized_data = $(this).serialize();
	// $('.btn').prop("disabled",true);
	fn_update_originator_fillin(serialized_data, mdl_add_answer_qcfr, frm_add_answer_qcfr_edit);
});	

$('#'+mdl_add_answer_qcfr+' table tbody').on('click', 'tr .fa-paperclip', function() {
	var pkid 		= $(this).attr('id');
	window.location.href = "./pages/qfr/dl_qcfr.php?id="+pkid;
});

function fn_update_originator_fillin(serialized_data, mdl_id, frm_id) {
	var data = {
		"action"			: 'update_originator_fillin',
		"pkid"				: $('#'+mdl_id).data('id'),
		"username"			: username,
	}
	call_ajax_serialize(data, serialized_data, handler_qcfr, function(result){	
	console.log(result);
		$('#'+mdl_id).modal('hide');
		$('#modal_system_message').modal();
		$('#container_message').attr('class','alert alert-success');
		$('#container_message').html( '<h4>'+result['msg']+'</h4>' );
		$('.btn').prop("disabled",false);
		fn_reload_qcfr_datatables();
		
	});
}

function fn_update_qcfr(serialized_data, mdl_id, frm_id, status) {
	var data = {
		"action"			: 'update_qcfr',
		"pkid"				: $('#'+mdl_id).data('id'),
		"status"			: status,
		"username"			: username,
	}
	call_ajax_serialize(data, serialized_data, handler_qcfr, function(result){	
	console.log(result);
		$('#'+mdl_id).modal('hide');
		$('#modal_system_message').modal();
		$('#container_message').attr('class','alert alert-success');
		$('#container_message').html( '<h4>'+result['msg']+'</h4>' );
		$('.btn').prop("disabled",false);
		fn_reload_qcfr_datatables();
		
	});
}

/* Add answer - end */

/* EDIT - start */
var mdl_edit_qcfr 				= 'mdl_edit_qcfr';
var frm_edit_qcfr 				= 'frm_edit_qcfr';
var mdl_edit_with_answer_qcfr	= 'mdl_edit_with_answer_qcfr';
var frm_edit_with_answer_qcfr	= 'frm_edit_with_answer_qcfr';

$("#"+mdl_edit_qcfr+" input[name='subcon_pmi[]']").on('change', function() {
	var subcon_pmi = $(this).val();
	fn_set_to_list(mdl_edit_qcfr,frm_new_qcfr, subcon_pmi);
});

$("#"+mdl_edit_qcfr+" #chk_fd_others2").on('click', function() {
	if($(this).is(':checked')) {
		$('#'+mdl_edit_qcfr+' input[name=found_during_others]').prop('disabled', false);
		$('#'+mdl_edit_qcfr+' input[name=found_during_others]').prop('required', true);
	} else {
		$('#'+mdl_edit_qcfr+' input[name=found_during_others]').prop('disabled', true);
		$('#'+mdl_edit_qcfr+' input[name=found_during_others]').prop('required', false);
	}
});

$('#'+frm_edit_qcfr+' input[name="po_no_invoice_no"]').keyup(function(e){
	var pattern = $(this).val();
	if($('#'+mdl_edit_qcfr+' #chk_fd_incoming_inspection2').is(':checked')) {
		fn_get_ng_invoice_num_datalist(pattern,frm_edit_qcfr+' #list_po_no_invoice_no2');
	} else {
		fn_get_po_list(pattern, frm_edit_qcfr+' #list_po_no_invoice_no2');
	}
	
});

$('#'+frm_edit_qcfr+' input[name="po_no_invoice_no"]').change(function(e){
	var po_no_invoice_no = $(this).val();
	if($('#'+mdl_edit_qcfr+' #chk_fd_incoming_inspection2').is(':checked')) {
		
	} else {
		var array_fields = [
			'input[name="model_no"]',
			'',
			'',
			''
		]
		fn_get_po_details(po_no_invoice_no,frm_edit_qcfr,array_fields);
	}
});

$("#"+mdl_edit_qcfr+" input[name='nature_of_request[]']").on('change', function() {
	var nature_of_request = $(this).val();
	fn_set_answer_by_nature_request(mdl_edit_qcfr, nature_of_request);
});

$("#"+mdl_edit_qcfr+" #chk_dispo_others").on('click', function() {
	if($(this).is(':checked')) {
		$('#'+mdl_edit_qcfr+' input[name=disposition_others]').prop('disabled', false);
		$('#'+mdl_edit_qcfr+' input[name=disposition_others]').prop('required', true);
	} else {
		$('#'+mdl_edit_qcfr+' input[name=disposition_others]').prop('disabled', true);
		$('#'+mdl_edit_qcfr+' input[name=disposition_others]').prop('required', false);
	}
});

$('#'+frm_edit_qcfr+' input[name="defective_qty"]').change(function(e){
	var defective_qty 	= $('#'+frm_edit_qcfr+' input[name="defective_qty"]').val();
	var sampling_plan_n = $('#'+frm_edit_qcfr+' input[name="sampling_plan_n"]').val();
	if(defective_qty == '' || sampling_plan_n == '') {
		$('#'+frm_edit_qcfr+' input[name="defective_percentage"]').val('0');
	} else {		
		var defective_percentage = parseFloat(defective_qty / sampling_plan_n).toFixed(2);
		$('#'+frm_edit_qcfr+' input[name="defective_percentage"]').val(defective_percentage);
	}
});
$('#'+frm_edit_qcfr+' input[name="sampling_plan_n"]').change(function(e){
	var defective_qty 	= $('#'+frm_edit_qcfr+' input[name="defective_qty"]').val();
	var sampling_plan_n = $('#'+frm_edit_qcfr+' input[name="sampling_plan_n"]').val();
	if(defective_qty == '' || sampling_plan_n == '') {
		$('#'+frm_edit_qcfr+' input[name="defective_percentage"]').val('0');
	} else {		
		var defective_percentage = parseFloat(defective_qty / sampling_plan_n).toFixed(2);
		$('#'+frm_edit_qcfr+' input[name="defective_percentage"]').val(defective_percentage);
	}
});


$('#' + tbl_qcfr + ' tbody').on('click','tr .fa-edit',function(){
	var pkid 	= $(this).data("id");	
	var row 	= $(this).closest("tr");
	var status_hidden  = row.find('td #status').val();	
	
	if(status_hidden.match('FOR ADD') || status_hidden.match('CLOSED') || status_hidden.match('FOR QC CHECKING') || status_hidden.match('FOR CHECKING')) {
		fn_get_qcfr_details(pkid,mdl_edit_with_answer_qcfr,frm_edit_with_answer_qcfr,'edit');
		fn_return_product_name_list(frm_edit_with_answer_qcfr);
		fn_return_prod_family_list(frm_edit_with_answer_qcfr);
	} else {
		$('#'+mdl_edit_qcfr).data('id', pkid);
		fn_return_product_name_list(frm_edit_qcfr);
		fn_return_prod_family_list(frm_edit_qcfr);
		fn_get_qcfr_details(pkid,mdl_edit_qcfr,frm_edit_qcfr,'edit');
	}
});

$('#'+frm_edit_qcfr).on('submit', function(e) {
	e.preventDefault();
	if(fn_validate_data_submission(frm_edit_qcfr) == '') {
		var serialized_data = new FormData(this);
			serialized_data.append("action","update_qcfr");
			serialized_data.append("pkid",$('#'+mdl_edit_qcfr).data('id'));
			serialized_data.append("status","FOR VERIFICATION");
			serialized_data.append("username",username);
		fn_save_qcfr(serialized_data, frm_edit_qcfr, mdl_edit_qcfr);
	} else {
		$('#modal_system_message').modal();
		$('#container_message').attr('class','alert alert-warning');
		$('#container_message').html( '<h4>'+fn_validate_data_submission(frm_new_qcfr)+'</h4>' );
	}
});
/* EDIT - end */

/* VIEW - start */
var mdl_view_qcfr 				= 'mdl_view_qcfr';
var frm_view_qcfr 				= 'frm_view_qcfr';
var mdl_view_with_answer_qcfr	= 'mdl_view_with_answer_qcfr';
var frm_view_with_answer_qcfr	= 'frm_view_with_answer_qcfr';
var mdl_qcfr_attachment_viewer	= 'mdl_qcfr_attachment_viewer';

$('#' + tbl_qcfr + ' tbody').on('click','tr .fa-eye',function(){
	var pkid 	= $(this).data("id");	
	var row 	= $(this).closest("tr");
	var status_hidden  = row.find('td #status').val();	
	if(status_hidden.match('CLOSED') || status_hidden.match('FOR QC CHECKING') || status_hidden.match('FOR CHECKING')) {
		fn_get_qcfr_details(pkid,mdl_view_with_answer_qcfr,frm_view_with_answer_qcfr,'view');
	} else {
		fn_get_qcfr_details(pkid,mdl_view_qcfr,frm_view_qcfr,'view');
	}
});

$('#' + tbl_qcfr + ' tbody').on('click','tr .fa-file-excel-o',function(){
	var pkid 	= $(this).data("id");	
	window.location.href = "././reports/qfr/excel_qfr_qcfr.php?id="+pkid;
});

$('#'+frm_view_qcfr + ' #btn_request_attachment' ).click(function() {
	fn_return_qcfr_attachments($(this).val(),"REQUEST","");
});

$('#'+frm_view_qcfr + ' #btn_view_attachment_8d_capa' ).click(function() {
	fn_return_qcfr_attachments($(this).val(),"8D/CAPA","");
});

$('#'+frm_view_with_answer_qcfr + ' #btn_request_attachment' ).click(function() {
	fn_return_qcfr_attachments($(this).val(),"REQUEST","");
});

$('#'+frm_view_with_answer_qcfr + ' #btn_view_attachment_8d_capa' ).click(function() {
	fn_return_qcfr_attachments($(this).val(),"8D/CAPA","");
});

function fn_return_qcfr_attachments(pkid,category,frm_id){
	$('#'+mdl_qcfr_attachment_viewer+' table tbody').empty();
	var data = {
		"action"	: "return_qcfr_attachments",
		"pkid"		: pkid,
		"category"	: category
	}
	call_ajax(data, handler_qcfr, function(result){
		console.table(result['table_body']);
		if(result['table_body'] == '' && frm_id != '') {
			$('#'+frm_id+' #div_recipient_fillin').hide();
		} else if(result['table_body'] != '' && frm_id != '') {
			$('#'+frm_id+' #div_recipient_fillin').show();
			$('#'+frm_id+' #div_recipient_report_label').show();
			$('#'+frm_id+' #div_recipient_report_input').show();
		} else {			
			$('#'+mdl_qcfr_attachment_viewer+' table tbody').append(result['table_body']);
			$('#'+mdl_qcfr_attachment_viewer).modal('show');
		}
		
	});
}

$('#'+mdl_qcfr_attachment_viewer+' table tbody').on('click', 'tr .fa-paperclip', function() {
	var pkid 		= $(this).attr('id');
	window.location.href = "./pages/qfr/dl_qcfr.php?id="+pkid;
});
/* VIEW - end */

/* LQC Supervisor - start */
var dt_qcfr_lqc_supervisor				= '';
var tbl_qcfr_supervisor 				= 'tbl_qcfr_supervisor';
var mdl_lqc_verified_conformed_qcfr 	= 'mdl_lqc_verified_conformed_qcfr';
var frm_mdl_lqc_verified_conformed_qcfr	= 'frm_mdl_lqc_verified_conformed_qcfr';

dt_qcfr_lqc_supervisor = $('#'+tbl_qcfr_supervisor).DataTable({
	"aaSorting"	 : [],
	"bProcessing": true,
	"bServerSide": true,
	"sAjaxSource": "server_side_scripts/qr/dt_qcfr_lqc_supervisor.php?username="+username,
	"drawCallback": function( settings ) {
		$('#'+tbl_qcfr_supervisor).attr('style','width:100%;');
	}
});
$('#' + tbl_qcfr_supervisor + ' tbody').on('click','tr .fa-eye',function(){
	var pkid 	= $(this).data("id");
	var row 	= $(this).closest("tr");
	var status  = row.find('td:eq(0)').text();
	var status_hidden  = row.find('td #status').val();
	$('#'+mdl_lqc_verified_conformed_qcfr+' .fa-thumbs-o-down').data("id", pkid);
	
	if(status == ' PENDING') {
		$('#'+mdl_lqc_verified_conformed_qcfr+' #div_result_confirmation').hide();
		$('#'+mdl_lqc_verified_conformed_qcfr+' .fa-thumbs-o-up').show();
		$('#'+mdl_lqc_verified_conformed_qcfr+' .fa-thumbs-o-down').show();
		$('#'+mdl_lqc_verified_conformed_qcfr+' .fa-thumbs-o-up').text(" ACCEPT");
		$('#'+mdl_lqc_verified_conformed_qcfr+' .fa-thumbs-o-down').text(" REJECT");
		$('#'+mdl_lqc_verified_conformed_qcfr+' .fa-thumbs-o-up').val("ACCEPT LQC SUPERVISOR");
		$('#'+mdl_lqc_verified_conformed_qcfr+' .fa-thumbs-o-up').data("id", pkid);
		$('#'+mdl_lqc_verified_conformed_qcfr+' .fa-thumbs-o-down').val("REJECT LQC SUPERVISOR");
		fn_get_qcfr_details(pkid,mdl_lqc_verified_conformed_qcfr,frm_mdl_lqc_verified_conformed_qcfr,'view');
	} else if(status == ' PENDING ') {
		$('#'+mdl_lqc_verified_conformed_qcfr+' #div_result_confirmation').show();
		$('#'+mdl_lqc_verified_conformed_qcfr+' .fa-thumbs-o-up').show();
		$('#'+mdl_lqc_verified_conformed_qcfr+' .fa-thumbs-o-down').show();
		$('#'+mdl_lqc_verified_conformed_qcfr+' .fa-thumbs-o-up').text(" APPROVE");
		$('#'+mdl_lqc_verified_conformed_qcfr+' .fa-thumbs-o-down').text(" DISAPPROVED");
		$('#'+mdl_lqc_verified_conformed_qcfr+' .fa-thumbs-o-up').val("CHECKED LQC");
		$('#'+mdl_lqc_verified_conformed_qcfr+' .fa-thumbs-o-up').data("id", pkid);
		$('#'+mdl_lqc_verified_conformed_qcfr+' .fa-thumbs-o-down').val("REJECT LQC SUPERVISOR2");
		fn_get_qcfr_details(pkid,mdl_lqc_verified_conformed_qcfr,frm_mdl_lqc_verified_conformed_qcfr,'view');
	} else {
		$('#'+mdl_lqc_verified_conformed_qcfr+' .fa-thumbs-o-up').hide();
		$('#'+mdl_lqc_verified_conformed_qcfr+' .fa-thumbs-o-down').hide();
		if(status_hidden.match('CLOSED') || status_hidden.match('FOR QC CHECKING') || status_hidden.match('FOR CHECKING')) {
			fn_get_qcfr_details(pkid,mdl_view_with_answer_qcfr,frm_view_with_answer_qcfr,'view');
		} else {
			$('#'+mdl_lqc_verified_conformed_qcfr+' #div_result_confirmation').hide();
			fn_get_qcfr_details(pkid,mdl_lqc_verified_conformed_qcfr,frm_mdl_lqc_verified_conformed_qcfr,'view');
		}		
	}	
});

$('#' + tbl_qcfr_supervisor + ' tbody').on('click','tr .fa-file-excel-o',function(){
	var pkid 	= $(this).data("id");	
	window.location.href = "././reports/qfr/excel_qfr_qcfr.php?id="+pkid;
});

$('#'+frm_mdl_lqc_verified_conformed_qcfr + ' #btn_request_attachment' ).click(function() {
	fn_return_qcfr_attachments($(this).val(),"REQUEST","");
});

$('#'+frm_mdl_lqc_verified_conformed_qcfr + ' #btn_view_attachment_8d_capa' ).click(function() {
	fn_return_qcfr_attachments($(this).val(),"8D/CAPA","");
});

/* LQC Supervisor - end */

/* LQC Production - start */
var dt_qcfr_lqc_production				= '';
var tbl_qcfr_production 				= 'tbl_qcfr_production';

dt_qcfr_lqc_production = $('#'+tbl_qcfr_production).DataTable({
	"aaSorting"	 : [],
	"bProcessing": true,
	"bServerSide": true,
	"sAjaxSource": "server_side_scripts/qr/dt_qcfr_lqc_production.php?username="+username,
	"drawCallback": function( settings ) {
		$('#'+tbl_qcfr_production).attr('style','width:100%;');
	}
});
$('#' + tbl_qcfr_production + ' tbody').on('click','tr .fa-eye',function(){
	var pkid 	= $(this).data("id");
	var row 	= $(this).closest("tr");
	var status_hidden  = row.find('td #status').val();		
	
	$('#'+mdl_lqc_verified_conformed_qcfr+' #div_result_confirmation').hide();
	
	if(row.find('td:eq(0)').text() == ' PENDING') {
		$('#'+mdl_lqc_verified_conformed_qcfr+' .fa-thumbs-o-up').text(" ACCEPT");
		$('#'+mdl_lqc_verified_conformed_qcfr+' .fa-thumbs-o-down').text(" REJECT");
		$('#'+mdl_lqc_verified_conformed_qcfr+' .fa-thumbs-o-up').val("ACCEPT PRODUCTION");
		$('#'+mdl_lqc_verified_conformed_qcfr+' .fa-thumbs-o-up').data("id", pkid);
		$('#'+mdl_lqc_verified_conformed_qcfr+' .fa-thumbs-o-down').val("REJECT PRODUCTION");
		$('#'+mdl_lqc_verified_conformed_qcfr+' .fa-thumbs-o-down').data("id", pkid);
		fn_get_qcfr_details(pkid,mdl_lqc_verified_conformed_qcfr,frm_mdl_lqc_verified_conformed_qcfr,'view');
	} else {
		$('#'+mdl_lqc_verified_conformed_qcfr+' .fa-thumbs-o-up').hide();
		$('#'+mdl_lqc_verified_conformed_qcfr+' .fa-thumbs-o-down').hide();
		if(status_hidden.match('CLOSED') || status_hidden.match('FOR QC CHECKING') || status_hidden.match('FOR CHECKING')) {
			fn_get_qcfr_details(pkid,mdl_view_with_answer_qcfr,frm_view_with_answer_qcfr,'view');
		} else {
			$('#'+mdl_lqc_verified_conformed_qcfr+' #div_result_confirmation').hide();
			fn_get_qcfr_details(pkid,mdl_lqc_verified_conformed_qcfr,frm_mdl_lqc_verified_conformed_qcfr,'view');
		}
	}
});

$('#' + tbl_qcfr_production + ' tbody').on('click','tr .fa-file-excel-o',function(){
	var pkid 	= $(this).data("id");	
	window.location.href = "././reports/qfr/excel_qfr_qcfr.php?id="+pkid;
});

/* LQC Production - end */

/* LQC Engineering - start */
var dt_qcfr_lqc_engineering				= '';
var tbl_qcfr_engineering 				= 'tbl_qcfr_engineering';

dt_qcfr_lqc_engineering = $('#'+tbl_qcfr_engineering).DataTable({
	"aaSorting"	 : [],
	"bProcessing": true,
	"bServerSide": true,
	"sAjaxSource": "server_side_scripts/qr/dt_qcfr_engineering.php?username="+username,
	"drawCallback": function( settings ) {
		$('#'+tbl_qcfr_engineering).attr('style','width:100%;');
	}
});
$('#' + tbl_qcfr_engineering + ' tbody').on('click','tr .fa-eye',function(){
	var pkid 	= $(this).data("id");
	var row 	= $(this).closest("tr");
	var status_hidden  = row.find('td #status').val();
	
	$('#'+mdl_lqc_verified_conformed_qcfr+' #div_result_confirmation').hide();
	
	if(row.find('td:eq(0)').text() == ' PENDING') {
		$('#'+mdl_lqc_verified_conformed_qcfr+' .fa-thumbs-o-up').text(" ACCEPT");
		$('#'+mdl_lqc_verified_conformed_qcfr+' .fa-thumbs-o-down').text(" REJECT");
		$('#'+mdl_lqc_verified_conformed_qcfr+' .fa-thumbs-o-up').val("ACCEPT ENGINEERING");
		$('#'+mdl_lqc_verified_conformed_qcfr+' .fa-thumbs-o-up').data("id", pkid);
		$('#'+mdl_lqc_verified_conformed_qcfr+' .fa-thumbs-o-down').val("REJECT ENGINEERING");
		$('#'+mdl_lqc_verified_conformed_qcfr+' .fa-thumbs-o-down').data("id", pkid);
		fn_get_qcfr_details(pkid,mdl_lqc_verified_conformed_qcfr,frm_mdl_lqc_verified_conformed_qcfr,'view');
	} else {
		$('#'+mdl_lqc_verified_conformed_qcfr+' .fa-thumbs-o-up').hide();
		$('#'+mdl_lqc_verified_conformed_qcfr+' .fa-thumbs-o-down').hide();
		if(status_hidden.match('CLOSED') || status_hidden.match('FOR QC CHECKING') || status_hidden.match('FOR CHECKING')) {
			fn_get_qcfr_details(pkid,mdl_view_with_answer_qcfr,frm_view_with_answer_qcfr,'view');
		} else {
			fn_get_qcfr_details(pkid,mdl_lqc_verified_conformed_qcfr,frm_mdl_lqc_verified_conformed_qcfr,'view');
		}
	}	
});

$('#' + tbl_qcfr_engineering + ' tbody').on('click','tr .fa-file-excel-o',function(){
	var pkid 	= $(this).data("id");	
	window.location.href = "././reports/qfr/excel_qfr_qcfr.php?id="+pkid;
});

/* LQC Engineering - end */

/* LQC SectHead - start */
var dt_qcfr_lqc_secthead			= '';
var tbl_qcfr_secthead 				= 'tbl_qcfr_secthead';

dt_qcfr_lqc_secthead = $('#'+tbl_qcfr_secthead).DataTable({
	"aaSorting"	 : [],
	"bProcessing": true,
	"bServerSide": true,
	"sAjaxSource": "server_side_scripts/qr/dt_qcfr_secthead.php?username="+username,
	"drawCallback": function( settings ) {
		$('#'+tbl_qcfr_secthead).attr('style','width:100%;');
	}
});
$('#' + tbl_qcfr_secthead + ' tbody').on('click','tr .fa-eye',function(){
	var pkid 	= $(this).data("id");
	var row 	= $(this).closest("tr");
	var status_hidden  = row.find('td #status').val();	
	
	if(row.find('td:eq(0)').text() == ' PENDING') {
		$('#'+mdl_lqc_verified_conformed_qcfr+' #div_result_confirmation').hide();
		$('#'+mdl_lqc_verified_conformed_qcfr+' .fa-thumbs-o-up').text(" APPROVED");
		$('#'+mdl_lqc_verified_conformed_qcfr+' .fa-thumbs-o-down').text(" DISAPPROVED");
		$('#'+mdl_lqc_verified_conformed_qcfr+' .fa-thumbs-o-up').val("APPROVED SECTHEAD");
		$('#'+mdl_lqc_verified_conformed_qcfr+' .fa-thumbs-o-up').data("id", pkid);
		$('#'+mdl_lqc_verified_conformed_qcfr+' .fa-thumbs-o-down').val("DISAPPROVED SECTHEAD");
		$('#'+mdl_lqc_verified_conformed_qcfr+' .fa-thumbs-o-down').data("id", pkid);
		fn_get_qcfr_details(pkid,mdl_lqc_verified_conformed_qcfr,frm_mdl_lqc_verified_conformed_qcfr,'view');
	} else if(row.find('td:eq(0)').text() == ' PENDING ') {
		$('#'+mdl_lqc_verified_conformed_qcfr+' #div_result_confirmation').show();
		$('#'+mdl_lqc_verified_conformed_qcfr+' .fa-thumbs-o-up').text(" APPROVED");
		$('#'+mdl_lqc_verified_conformed_qcfr+' .fa-thumbs-o-down').text(" DISAPPROVED");
		$('#'+mdl_lqc_verified_conformed_qcfr+' .fa-thumbs-o-up').val("APPROVED QC HEAD");
		$('#'+mdl_lqc_verified_conformed_qcfr+' .fa-thumbs-o-up').data("id", pkid);
		$('#'+mdl_lqc_verified_conformed_qcfr+' .fa-thumbs-o-down').val("DISAPPROVED QC HEAD");
		$('#'+mdl_lqc_verified_conformed_qcfr+' .fa-thumbs-o-down').data("id", pkid);
		fn_get_qcfr_details(pkid,mdl_lqc_verified_conformed_qcfr,frm_mdl_lqc_verified_conformed_qcfr,'view');
	} else {
		$('#'+mdl_lqc_verified_conformed_qcfr+' .fa-thumbs-o-up').hide();
		$('#'+mdl_lqc_verified_conformed_qcfr+' .fa-thumbs-o-down').hide();		
		if(status_hidden.match('CLOSED') || status_hidden.match('FOR QC CHECKING') || status_hidden.match('FOR CHECKING')) {
			fn_get_qcfr_details(pkid,mdl_view_with_answer_qcfr,frm_view_with_answer_qcfr,'view');
		} else {
			$('#'+mdl_lqc_verified_conformed_qcfr+' #div_result_confirmation').hide();
			fn_get_qcfr_details(pkid,mdl_lqc_verified_conformed_qcfr,frm_mdl_lqc_verified_conformed_qcfr,'view');
		}
	}	
});

$('#' + tbl_qcfr_secthead + ' tbody').on('click','tr .fa-file-excel-o',function(){
	var pkid 	= $(this).data("id");	
	window.location.href = "././reports/qfr/excel_qfr_qcfr.php?id="+pkid;
});

/* LQC SectHead - end */

/* LQC DeptHead - start */
var dt_qcfr_lqc_depthead			= '';
var tbl_qcfr_depthead 				= 'tbl_qcfr_depthead';

dt_qcfr_lqc_depthead = $('#'+tbl_qcfr_depthead).DataTable({
	"aaSorting"	 : [],
	"bProcessing": true,
	"bServerSide": true,
	"sAjaxSource": "server_side_scripts/qr/dt_qcfr_depthead.php?username="+username,
	"drawCallback": function( settings ) {
		$('#'+tbl_qcfr_depthead).attr('style','width:100%;');
	}
});
$('#' + tbl_qcfr_depthead + ' tbody').on('click','tr .fa-eye',function(){
	var pkid 	= $(this).data("id");
	var row 	= $(this).closest("tr");	
	var status_hidden  = row.find('td #status').val();
	if(row.find('td:eq(0)').text() == ' PENDING') {
		$('#'+mdl_lqc_verified_conformed_qcfr+' #div_result_confirmation').hide();
		$('#'+mdl_lqc_verified_conformed_qcfr+' .fa-thumbs-o-up').show();
		$('#'+mdl_lqc_verified_conformed_qcfr+' .fa-thumbs-o-down').show();
		$('#'+mdl_lqc_verified_conformed_qcfr+' .fa-thumbs-o-up').text(" APPROVED");
		$('#'+mdl_lqc_verified_conformed_qcfr+' .fa-thumbs-o-down').text(" DISAPPROVED");
		$('#'+mdl_lqc_verified_conformed_qcfr+' .fa-thumbs-o-up').val("APPROVED DEPTHEAD");
		$('#'+mdl_lqc_verified_conformed_qcfr+' .fa-thumbs-o-up').data("id", pkid);
		$('#'+mdl_lqc_verified_conformed_qcfr+' .fa-thumbs-o-down').val("DISAPPROVED DEPTHEAD");
		$('#'+mdl_lqc_verified_conformed_qcfr+' .fa-thumbs-o-down').data("id", pkid);
		fn_get_qcfr_details(pkid,mdl_lqc_verified_conformed_qcfr,frm_mdl_lqc_verified_conformed_qcfr,'view');
	} else {
		$('#'+mdl_lqc_verified_conformed_qcfr+' #div_result_confirmation').show();
		$('#'+mdl_lqc_verified_conformed_qcfr+' .fa-thumbs-o-up').hide();
		$('#'+mdl_lqc_verified_conformed_qcfr+' .fa-thumbs-o-down').hide();
		if(status_hidden.match('CLOSED') || status_hidden.match('FOR QC CHECKING') || status_hidden.match('FOR CHECKING')) {
			fn_get_qcfr_details(pkid,mdl_view_with_answer_qcfr,frm_view_with_answer_qcfr,'view');
		} else {
			$('#'+mdl_lqc_verified_conformed_qcfr+' #div_result_confirmation').hide();
			fn_get_qcfr_details(pkid,mdl_lqc_verified_conformed_qcfr,frm_mdl_lqc_verified_conformed_qcfr,'view');
		}
	}	
});

$('#' + tbl_qcfr_depthead + ' tbody').on('click','tr .fa-file-excel-o',function(){
	var pkid 	= $(this).data("id");	
	window.location.href = "././reports/qfr/excel_qfr_qcfr.php?id="+pkid;
});

/* LQC DeptHead - end */

/* Recipient Fill-in - start */
var dt_qcfr_recipient			= '';
var tbl_qcfr_recipient 			= 'tbl_qcfr_recipient';

var mdl_recipient_fillin		= 'mdl_recipient_fillin';
var frm_recipient_fillin 		= 'frm_recipient_fillin';

dt_qcfr_recipient = $('#'+tbl_qcfr_recipient).DataTable({
	"aaSorting"	 : [],
	"bProcessing": true,
	"bServerSide": true,
	"sAjaxSource": "server_side_scripts/qr/dt_qcfr_recipient.php?username="+username,
	"drawCallback": function( settings ) {
		$('#'+tbl_qcfr_recipient).attr('style','width:100%;');
	}
});
$('#' + tbl_qcfr_recipient + ' tbody').on('click','tr .fa-plus',function(){
	var pkid 	= $(this).data("id");
	var row 	= $(this).closest("tr");	
	var status_hidden  = row.find('td #status').val();
	
	$('#'+mdl_recipient_fillin).data('id', pkid);
	$('#'+mdl_recipient_fillin+' input[type="text"], input[type="date"], input[type="number"], select,textarea').prop('readOnly', true);
	
	fn_get_qcfr_details(pkid,mdl_recipient_fillin,frm_recipient_fillin,'view');	
});

$('#'+frm_recipient_fillin).on('submit', function(e) {
	e.preventDefault();
	// $('.btn').prop("disabled",true);
	var serialized_data = new FormData(this);
		serialized_data.append("action", "add_recipient_fillin");
		serialized_data.append("fkqcfr", $('#'+mdl_recipient_fillin).data('id'));
		serialized_data.append("username", username);
		
	fn_save_recipient_fillin(mdl_recipient_fillin, frm_recipient_fillin, serialized_data);
});	

$('#' + tbl_qcfr_recipient + ' tbody').on('click','tr .fa-eye',function(){
	var pkid 	= $(this).data("id");
	var row 	= $(this).closest("tr");
	var status_hidden  = row.find('td:eq(0)').text();
	
	if(status_hidden.match('VIEW ONLY')) {
		$('#mdl_lqc_verified_conformed_qcfr .fa-thumbs-o-up').hide();
		$('#mdl_lqc_verified_conformed_qcfr .fa-thumbs-o-down').hide();
		fn_get_qcfr_details(pkid,mdl_lqc_verified_conformed_qcfr,frm_mdl_lqc_verified_conformed_qcfr,'view');
	} else {
		fn_get_qcfr_details(pkid,mdl_view_with_answer_qcfr,frm_view_with_answer_qcfr,'view');		
	}
});

$('#' + tbl_qcfr_recipient + ' tbody').on('click','tr .fa-file-excel-o',function(){
	var pkid 	= $(this).data("id");	
	window.location.href = "././reports/qfr/excel_qfr_qcfr.php?id="+pkid;
});

function fn_save_recipient_fillin(modal_id, form_id, serialized_data) {	
	call_ajax_attachment(serialized_data, handler_qcfr, function(result) {
		$('.modal').modal('hide');
		$('#modal_system_message').modal();
		$('#container_message').attr('class','alert alert-success');
		$('#container_message').html( '<h4>'+result['msg']+'</h4>' );
		// $('.btn').prop("disabled",false);
		fn_reload_qcfr_datatables();
		console.log(result);
	});
}

/* Recipient Fill-in - end */

/* Approver's decision - start */
var modal_qcfr_approver_message			= 'modal_qcfr_approver_message';
var frm_qcfr_approvers_decision			= 'frm_qcfr_approvers_decision';

$('#'+frm_mdl_lqc_verified_conformed_qcfr+' .fa-thumbs-o-up').on('click', function() {
	$('#'+modal_qcfr_approver_message + ' #status').val( $(this).val() );
	$('#'+modal_qcfr_approver_message).data("id", $('#'+mdl_lqc_verified_conformed_qcfr+' .fa-thumbs-o-up').data("id"));
	$('#'+modal_qcfr_approver_message + ' #container_approver_message').attr('class','alert alert-success');
	$('#'+modal_qcfr_approver_message + ' #container_approver_message').html('Are you sure you want to approve the request?<br><br>Remarks:<textarea name="remarks" style="width:100%;" rows="4"></textarea>');
	$('#'+modal_qcfr_approver_message + ' #container_approver_message').show();
	$('#'+modal_qcfr_approver_message).modal();
});
$('#'+frm_mdl_lqc_verified_conformed_qcfr+' .fa-thumbs-o-down').on('click', function() {
	$('#'+modal_qcfr_approver_message + ' #status').val( $(this).val() );
	$('#'+modal_qcfr_approver_message).data("id", $('#'+mdl_lqc_verified_conformed_qcfr+' .fa-thumbs-o-down').data("id"));
	$('#'+modal_qcfr_approver_message + ' #container_approver_message').attr('class','alert alert-success');
	$('#'+modal_qcfr_approver_message + ' #container_approver_message').html('Are you sure you want to disapprove the request?<br><br>*Remarks:<textarea name="remarks" style="width:100%;" rows="4" required></textarea>');
	$('#'+modal_qcfr_approver_message + ' #container_approver_message').show();
	$('#'+modal_qcfr_approver_message).modal();
});

$('#'+frm_qcfr_approvers_decision).on('submit', function(e) {
	e.preventDefault();
	// $('.btn').prop("disabled",true);
	var status = $('#'+modal_qcfr_approver_message + ' #status').val();
	fn_save_qcfr_approvers_decision(status, modal_qcfr_approver_message, frm_qcfr_approvers_decision);
});	

function fn_save_qcfr_approvers_decision(status, modal_id, form_id) {
	var serialized_data = $('#'+form_id).serialize();
	var data = {
		"action"				: "save_qcfr_approvers_decision",
		"pkid"					: $('#'+modal_id).data('id'),
		"status"				: status,
		"username"				: username,
	}
	call_ajax_serialize(data, serialized_data, handler_qcfr, function(result) {
		$('.modal').modal('hide');
		$('#modal_system_message').modal();
		$('#container_message').attr('class','alert alert-success');
		$('#container_message').html( '<h4>'+result['msg']+'</h4>' );
		// $('.btn').prop("disabled",false);
		fn_reload_qcfr_datatables();
		console.log(result);
	});
}

/* Approver's decision - end */

/* Report - start */
var mdl_report					= 'modal_qcfr_report';
var frm_report					= 'frm_qcfr_report';

$('#btn_qcfr_report_ins,#btn_qcfr_report_sup,#btn_qcfr_report_prdn,#btn_qcfr_report_eng,#btn_qcfr_report_sh,#btn_qcfr_report_dp,#btn_qcfr_report_rec').click(function(){
	$('#'+mdl_report).modal('show');
});

$('#'+frm_report).submit(function(e) {
	e.preventDefault();
	window.location.href = "./reports/qfr/excel_qfr_qcfr_summary.php?df="+$('#'+frm_report+' #date_from').val()+"&dt="+$('#'+frm_report+' #date_to').val()+"&tp="+$('#'+frm_report+' #subcon_pmi').val();
});


function fn_return_reported_by(mdl_id) {
	var data = {
		"action"	: "return_user_name",
		"username"	: username
	}
	call_ajax(data, handler_qcfr, function(result){
		$('#'+mdl_id+' input[name=reported_by]').val(result['empname']);
	});
}
function fn_return_product_name_list(frm_id) {
	$('#'+frm_id+' select[name=product_name]').empty();
	var data = {
		"action"	: "return_product_name_list"
	}
	call_ajax(data, handler_qcfr, function(result){
		$('#'+frm_id+' select[name=product_name]').append(result['html_select']);
	});
}
function fn_return_prod_family_list(frm_id) {
	$('#'+frm_id+' select[name=prod_family]').empty();
	var data = {
		"action"	: "return_prod_family_list"
	}
	call_ajax(data, handler_qcfr, function(result){
		$('#'+frm_id+' select[name=prod_family]').append(result['html_select']);
	});
}

function fn_set_answer_by_nature_request(mdl_id, nature_of_request) {
	if(nature_of_request == 'For Information only') {
		$('#'+mdl_id+' input:radio[name="answer[]"][value="No Need"]').prop('checked', true);
		$('#'+mdl_id+' input[name="date_answer_required"]').prop('required', false);
		$('#'+mdl_id+' input[name="date_answer_required"]').prop('readOnly', true);
		$('#'+mdl_id+' #div_date_answer_label').hide();
		$('#'+mdl_id+' #div_date_answer_input').hide();
	} else {
		$('#'+mdl_id+' input:radio[name="answer[]"][value="Need"]').prop('checked', true);
		$('#'+mdl_id+' input[name="date_answer_required"]').prop('required', true);
		$('#'+mdl_id+' input[name="date_answer_required"]').prop('readOnly', false);
		$('#'+mdl_id+' #div_date_answer_label').show();
		$('#'+mdl_id+' #div_date_answer_input').show();
	}
}

function fn_set_to_list(mdl_id,frm_id, subcon_pmi_category) {
	$('#'+mdl_id+' #cmb_to').empty().trigger('change')
	if(subcon_pmi_category == "Supplier/Subcon") {
		re_initialize_select2_server_side('#'+mdl_id+' #cmb_to','#'+mdl_id+' #'+frm_id,[],"server_side_scripts/dropdown/qfr/dd_qcfr_supplier_list.php?q=");	
		$('#'+mdl_id+' #div_cc_supplier').show();
		$('#'+mdl_id+' input[name=cc_supplier]').prop('required', true);
		$('#'+mdl_id+' input[name="cc_pmi[]"]').prop('required', false);
		$('#'+mdl_id+' #div_cc_pmi').hide();
		$('#'+mdl_id+' #div_supplier_approvers').hide();
		$('#'+mdl_id+' #div_supplier_approvers2').hide();
		$('#'+mdl_id+' select[name="verified_conformed_by_eng[]"]').prop('required', false);
		$('#'+mdl_id+' select[name="approved_by_dh[]"]').prop('required', false);
		$('#'+mdl_id+' select[name="verified_conformed_by_prdn[]"]').prop('required', false);
	} else if(subcon_pmi_category == "PMI Assy") {
		$('#'+mdl_id+' #div_cc_supplier').hide();
		$('#'+mdl_id+' input[name=cc_supplier]').prop('required', false);
		$('#'+mdl_id+' input[name="cc_pmi[]"]').prop('required', true);
		$('#'+mdl_id+' #div_cc_pmi').show();
		$('#'+mdl_id+' #div_supplier_approvers').show();
		$('#'+mdl_id+' #div_supplier_approvers2').show();
		// $('#'+mdl_id+' select[name="verified_conformed_by_eng[]"]').prop('required', true);
		$('#'+mdl_id+' select[name="approved_by_dh[]"]').prop('required', true);
		// $('#'+mdl_id+' select[name="verified_conformed_by_prdn[]"]').prop('required', true);
		/* Set values for to */
		$("#"+mdl_id+" #cmb_to").select2({
			placeHolder	: "Please select a 'TO' recipient",
			data 		: [
							{
								id: '',
								text: ''
							},
							{
								id: 'Production',
								text: 'Production'
							},
							{
								id: 'Engineering',
								text: 'Engineering'
							},
							{
								id: 'QC',
								text: 'QC'
							},
							{
								id: 'PPC/WHS',
								text: 'PPC/WHS'
							}
						]
		});		
		/* Set values for cc to select */
		re_initialize_select2_server_side('#'+mdl_id+' #cmb_cc','#'+mdl_id+' #'+frm_id,[],"server_side_scripts/dropdown/common/dd_hris_pmi_and_subcon_list.php");
	}
	$("#"+mdl_id+" #cmb_from").select2({
		placeHolder	: "Please select a section",
		data 		: [
						{
							id: '',
							text: ''
						},
						{
							id: 'CN-QC',
							text: 'CN-QC'
						},
						{
							id: 'TS-QC',
							text: 'TS-QC'
						},
						{
							id: 'PPS-QC',
							text: 'PPS-QC'
						},
						{
							id: 'YF-QC',
							text: 'YF-QC'
						}
					]
	});
}

function fn_get_qcfr_details(pkid,mdl_id,frm_id, action){
	var data = {
		"action"	: "get_qcfr_details_by_pkid",
		"pkid"		: pkid,
		"action2"	: action,
	}
	call_ajax(data, handler_qcfr, function(result){
		console.log(result);
		$.each(result['data'][0],function(key, value){
			$('#'+frm_id+' span[name="'+key+'"]').html(value);
			$('#'+frm_id+' input[name="'+key+'"]').val(value);
			$('#'+frm_id+' select[name="'+key+'"]').val(value);
			$('#'+frm_id+' button[name="'+key+'"]').val(value);
			$('#'+frm_id+' textarea[name="'+key+'"]').val(value);
			
			if(key == 'subcon_pmi') {
				$('#'+mdl_id+' input:radio[name="'+key+'[]"][value="'+value+'"]').attr('checked', true);
				fn_set_to_list(mdl_id,frm_id, value);
				if(value == 'Supplier/Subcon') {
					$('#'+mdl_id+' #div_supplier_approvers').hide();
					$('#'+mdl_id+' #div_supplier_approvers2').hide();
				} else if(value == 'PMI Assy') {				
					$('#'+mdl_id+' #div_supplier_approvers').show();
					$('#'+mdl_id+' #div_supplier_approvers2').show();
				}
			}
			if(key == 'cc_supplier' && value != '') {
				$('#'+frm_id+' input[name="cc_supplier"]').val(value);			
			}
			if(key == 'cc' && value != '') {
				$('#'+frm_id+' input[name="cc"]').val(value);			
			}
			if(key == 'found_during') {
				var value_array = value.split(' | ');
				for(i=0; i < value_array.length; i++ ) {
					$('#'+mdl_id+' input:checkbox[name="'+key+'[]"][value="'+value_array[i]+'"]').attr('checked', true);
				}				
			}
			if(key == 'inspection_method') {
				$('#'+mdl_id+' input:radio[name="'+key+'[]"][value="'+value+'"]').attr('checked', true);				
			}
			if(key == 'disposition') {
				var value_array = value.split(' | ');
				for(i=0; i < value_array.length; i++ ) {
					$('#'+mdl_id+' input:checkbox[name="'+key+'[]"][value="'+value_array[i]+'"]').prop('checked', true);
				}				
			}
			if(key == 'nature_of_request') {
				$('#'+mdl_id+' input:radio[name="'+key+'[]"][value="'+value+'"]').prop('checked', true);	
				if(mdl_id == 'mdl_recipient_fillin') {
					if(value == 'Submit 8D report') {
						$('#'+mdl_id+' input[name="file_name_8d_report[]"]').show();
						$('#'+mdl_id+' input[name="file_name_capa[]"]').hide();
					} else {
						$('#'+mdl_id+' input[name="file_name_8d_report[]"]').hide();
						$('#'+mdl_id+' input[name="file_name_capa[]"]').show();
					}
				} else {
					if(value == 'For Information only') {
						$('#'+frm_id+' #div_recipient_fillin').hide();	
					} else {						
						fn_return_qcfr_attachments(pkid,"CHECKING", frm_id);
					}
				}
			}
			if(key == 'answer') {
				var value_array = value.split(' | ');
				for(i=0; i < value_array.length; i++ ) {
					$('#'+mdl_id+' input:radio[name="'+key+'[]"][value="'+value_array[i]+'"]').prop('checked', true);
					if(value_array[i] == 'Need') {
						$('#'+frm_id+' #div_recipient_report_label').show();
						$('#'+frm_id+' #div_recipient_report_input').show();
					} else {
						$('#'+frm_id+' #div_date_answer_label').hide();
						$('#'+frm_id+' #div_date_answer_input').hide();
					}
				}				
			}
			if(key == 'factory_line_audit') {
				$('#'+mdl_id+' input:radio[name="'+key+'[]"][value="'+value+'"]').prop('checked', true);
			}
			if(key == 'request_attachment' && value == 0) {
				$('#'+mdl_id+' #btn_request_attachment').prop('disabled', true);
			} if(key == 'request_attachment' && value != 0) {
				$('#'+mdl_id+' #btn_request_attachment').prop('disabled', false);
			}
		
		});
		
		if(action == 'edit') {
			assign_value_select2('#'+frm_id+' #cmb_to',result['data'][0]['to']);	
			assign_value_select2('#'+frm_id+' #cmb_from',result['data'][0]['from']);	
			assign_value_select2('#'+frm_id+' #cmb_attn',result['data'][0]['attn']);	
			re_initialize_select2_server_side('#'+mdl_id+' #cmb_attn','#'+mdl_id+' #'+frm_id,[],"server_side_scripts/dropdown/common/dd_hris_pmi_and_subcon_list.php");	
			assign_value_select2('#'+frm_id+' #cmb_cc',result['data'][0]['cc_pmi']);
			re_initialize_select2_server_side('#'+mdl_id+' #cmb_cc','#'+mdl_id+' #'+frm_id,[],"server_side_scripts/dropdown/common/dd_hris_pmi_and_subcon_list.php");			
			assign_value_select2('#'+frm_id+' #verified_conformed_by_lqc',result['data'][0]['verified_conformed_by_lqc']);		
			re_initialize_select2_server_side('#'+mdl_id+' #verified_conformed_by_lqc','#'+mdl_id+' #'+frm_id,[],"server_side_scripts/dropdown/common/dd_hris_pmi_and_subcon_list.php");
			assign_value_select2('#'+frm_id+' #verified_conformed_by_eng',result['data'][0]['verified_conformed_by_eng']);		
			re_initialize_select2_server_side('#'+mdl_id+' #verified_conformed_by_eng','#'+mdl_id+' #'+frm_id,[],"server_side_scripts/dropdown/common/dd_hris_pmi_and_subcon_list.php");
			assign_value_select2('#'+frm_id+' #verified_conformed_by_prdn',result['data'][0]['verified_conformed_by_prdn']);		
			re_initialize_select2_server_side('#'+mdl_id+' #verified_conformed_by_prdn','#'+mdl_id+' #'+frm_id,[],"server_side_scripts/dropdown/common/dd_hris_pmi_and_subcon_list.php");
			assign_value_select2('#'+frm_id+' #approved_by_sh',result['data'][0]['approved_by_sh']);		
			re_initialize_select2_server_side('#'+mdl_id+' #approved_by_sh','#'+mdl_id+' #'+frm_id,[],"server_side_scripts/dropdown/common/dd_hris_above_ss_list.php");
			assign_value_select2('#'+frm_id+' #approved_by_dh',result['data'][0]['approved_by_dh']);		
			re_initialize_select2_server_side('#'+mdl_id+' #approved_by_dh','#'+mdl_id+' #'+frm_id,[],"server_side_scripts/dropdown/common/dd_hris_above_ss_list.php");
			assign_value_select2('#'+frm_id+' #created_by',result['data'][0]['created_by']);		
			re_initialize_select2_server_side('#'+mdl_id+' #created_by','#'+mdl_id+' #'+frm_id,[],"server_side_scripts/dropdown/common/dd_hris_pmi_and_subcon_list.php");
			assign_value_select2('#'+frm_id+' #pmi_orginator_fill_in_checked_by',result['data'][0]['pmi_orginator_fill_in_checked_by']);		
			re_initialize_select2_server_side('#'+mdl_id+' #pmi_orginator_fill_in_checked_by','#'+mdl_id+' #'+frm_id,[],"server_side_scripts/dropdown/common/dd_hris_above_ss_list.php");
			assign_value_select2('#'+frm_id+' #pmi_orginator_fill_in_approved_by',result['data'][0]['pmi_orginator_fill_in_approved_by']);		
			re_initialize_select2_server_side('#'+mdl_id+' #pmi_orginator_fill_in_approved_by','#'+mdl_id+' #'+frm_id,[],"server_side_scripts/dropdown/common/dd_hris_above_ss_list.php");
			assign_value_select2('#'+frm_id+' #batch_no_lot_no',result['data'][0]['batch_no_lot_no']);	
			re_initialize_select2_server_side('#'+mdl_id+' #batch_no_lot_no','#'+mdl_id+' #'+frm_id,[],"server_side_scripts/dropdown/qfr/dd_qcfr_lotno_list.php");
		}
		$('#'+mdl_id).modal('show');
	});
}

function fn_get_qcfr_fill_in_signatories(pkid,mdl_id,frm_id){
	var data = {
		"action"	: "get_qcfr_fill_in_signatories",
		"pkid"		: pkid
	}
	call_ajax(data, handler_qcfr, function(result){
		console.log(result);
		assign_value_select2('#'+frm_id+' #created_by',result['data'][0]['created_by']);		
		re_initialize_select2_server_side('#'+mdl_id+' #created_by','#'+mdl_id+' #'+frm_id,[],"server_side_scripts/dropdown/common/dd_hris_pmi_and_subcon_list.php");
		assign_value_select2('#'+frm_id+' #pmi_orginator_fill_in_checked_by',result['data'][0]['pmi_orginator_fill_in_checked_by']);		
		re_initialize_select2_server_side('#'+mdl_id+' #pmi_orginator_fill_in_checked_by','#'+mdl_id+' #'+frm_id,[],"server_side_scripts/dropdown/common/dd_hris_above_ss_list.php");
		assign_value_select2('#'+frm_id+' #pmi_orginator_fill_in_approved_by',result['data'][0]['pmi_orginator_fill_in_approved_by']);		
		re_initialize_select2_server_side('#'+mdl_id+' #pmi_orginator_fill_in_approved_by','#'+mdl_id+' #'+frm_id,[],"server_side_scripts/dropdown/common/dd_hris_above_ss_list.php");
		
		$('#'+mdl_id).modal('show');
	});
}

function fn_reload_qcfr_datatables() {
	dt_qcfr_lqc_ins.ajax.reload(null, false);
	dt_qcfr_lqc_supervisor.ajax.reload(null, false);
	dt_qcfr_lqc_production.ajax.reload(null, false);
	dt_qcfr_lqc_engineering.ajax.reload(null, false);
	dt_qcfr_lqc_secthead.ajax.reload(null, false);
	dt_qcfr_lqc_depthead.ajax.reload(null, false);
	dt_qcfr_recipient.ajax.reload(null, false);
}
