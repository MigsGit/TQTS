/* **************************************************
	8D Module - Start
/***************************************************/
var dt_tbl_8d				= '';
var tbl_8d					= 'tbl_8d';
var dt_tbl_8d_admin			= '';
var tbl_8d_admin			= 'tbl_8d_final';

/* 8D Handler Link */
var frm_id_new 				= "frm_8d";
var frm_id_edit 			= "frm_8d_edit";
var frm_id_edit_approver 	= "frm_8d_edit_approver";
var frm_id_edit_requestor 	= "frm_8d_edit_requestor";
var frm_id_view 			= "frm_8d_view";
var frm_8d_admin_email_edit = "frm_8d_admin_email_edit";
var frm_8d_admin_edit 		= "frm_8d_admin_edit";
var frm_8d_admin_view 		= "frm_8d_admin_view";

var rev_status				= '';
var rev_no					= '';

$('input[type="text"]').attr("autocomplete","off");

/* Admin - START */
dt_tbl_8d_admin = $('#'+tbl_8d_admin).DataTable({
	"aaSorting"	: [],
	"bProcessing": true,
	"bServerSide": true,
	"sAjaxSource": "server_side_scripts/qr/dt_8d_admin.php?username="+username,
	"drawCallback": function( settings ) {
		$('#'+tbl_8d_admin).attr('style','width:100%;');
	}
});
	
$('#' + tbl_8d_admin + ' tbody').on('click', 'tr .fa-paperclip', function() {
	fn_return_8d_attachments( 'tbl_view_attachments', $(this).val() );
	fn_return_final_8d_attachment( 'container_final_attachment', $(this).val() );
});

/* Send the report to QAD - Start */
$('#'+ tbl_8d_admin +' tbody').on('click','tr .fa-send-o', function(){
	/* Assign the modal_id and pkid to variable */
	var modal_id 		= 'modal_8d_admin_email_edit';
	var pkid 			= $(this).attr('data-id');
	var existing_status = $(this).closest('tr').find('td:eq(0)').text();
	
	/* Function that fetches the details of the selected row */	
	fn_load_8d_main_data(pkid,modal_id,'');
	$('#div_admin_reupload input[type="file"]').prop('disabled', true);
	/* Assign the pkid to the data id of the modal */
	$('#'+modal_id).data('id',pkid);
	
	fn_ng_get_recipients_list('cmb_8d_send_to', function() {
		$('.chosen-select#cmb_8d_send_to').chosen({width:"100%", height: "100%"});
		fn_ng_get_recipients_list('cmb_8d_send_cc', function() {
			$('.chosen-select#cmb_8d_send_cc').chosen({width:"100%", height: "100%"});
			$('#'+modal_id).modal('show');
		});
	});
	
	
	
});

$('#'+ frm_8d_admin_email_edit +' .fa-paperclip').click(function() {
	var tbl_name 		 = 'tbl_qfr_8d_attachment_final'; 	//table of module with fkfile_path
	var stat 		 	 = 'final'; 						//multiple or empty. empty means single
	var field 		 	 = 'fk8d'; 							
	window.location.href = "./pages/qfr/dl_excel_file.php?id="+$(this).val()+'&tbl_name='+tbl_name+'&stat='+stat+'&f='+field;
});

$('#'+frm_8d_admin_email_edit+' #chk_replace').click(function() {
	if($(this).is(':checked')) {
		$('#' + frm_8d_admin_email_edit + ' input[type="file"]').prop('disabled', false);
		$('#' + frm_8d_admin_email_edit + ' input[type="file"]').attr('name', 'file_8d');
	} else {
		$('#' + frm_8d_admin_email_edit + ' input[type="file"]').prop('disabled', true);
		$('#' + frm_8d_admin_email_edit + ' input[type="file"]').attr('name', '');
	}
});

$('#'+ frm_8d_admin_email_edit).submit(function(e){
	/* Prevent page from submitting and reloading */
	e.preventDefault();
	
	if(fn_validate_recipient('cmb_8d_send_to', 'frm_8d_admin_email_edit #container_message_8d')) {
		/* Get the form data */
		var serialized_data = new FormData(this);
			serialized_data.append("action", "admin_save_final_report");
			serialized_data.append("send", "send");
			serialized_data.append("fk8d", $('#modal_8d_admin_email_edit').data('id'));
			serialized_data.append("to_recipient",JSON.stringify($('#cmb_8d_send_to').val()));
			serialized_data.append("cc_recipient",JSON.stringify($('#cmb_8d_send_cc').val()));
			serialized_data.append("username", username);
			$('.btn').prop("disabled",true);
		/* Function for saving data to database */
		fn_admin_send_final_report(serialized_data, 'modal_8d_admin_email_edit');
	}
});

function fn_admin_send_final_report(serialized_data, modal_id) {			
	call_ajax_attachment(serialized_data, handler_qfr_8d, function(result){
		$('#'+modal_id).modal('hide');
		$('#modal_system_message').modal();
		$('#container_message').attr('class','alert alert-success');
		$('#container_message').html( '<h4>'+result['msg']+'</h4>' );
		$('#' + frm_8d_admin_email_edit + ' input[type="file"]').prop('checked', false);
		dt_tbl_8d_admin.ajax.reload();
		$('.btn').prop("disabled",false);
	});
}

function fn_ng_get_recipients_list(cmb_id, callback) {
	$('#'+cmb_id).empty();
	var data = {
		"action" 		: "get_email_recipients_list"
	} 
	call_ajax(data, handler_qfr, function(result){
		$('#'+cmb_id).append( '<option>-</option>' );
		$('#'+cmb_id).append( result['html_select'] );
		callback();
	});
}

/* Send the report to QAD - End */

/* Close the report to QAD -Start */
$('#'+ tbl_8d_admin +' tbody').on('click','tr .fa-window-restore', function(){
	/* Assign the modal_id and pkid to variable */
	var modal_id 		= 'modal_8d_admin_edit';
	var pkid 			= $(this).attr('data-id');
	var existing_status = $(this).closest('tr').find('td:eq(0)').text();
	
	/* Function that fetches the details of the selected row */	
	fn_load_8d_main_data(pkid,modal_id,'');
	$('#div_admin_reupload2 input[type="file"]').prop('disabled', true);
	/* Assign the pkid to the data id of the modal */
	$('#'+modal_id).data('id',pkid);	
	$('#'+modal_id).modal('show');
});

$('#'+ frm_8d_admin_edit +' .fa-paperclip').click(function() {
	var tbl_name 		 = 'tbl_qfr_8d_attachment_final'; 	//table of module with fkfile_path
	var stat 		 	 = 'final'; 						//multiple or empty. empty means single
	var field 		 	 = 'fk8d'; 							
	window.location.href = "./pages/qfr/dl_excel_file.php?id="+$(this).val()+'&tbl_name='+tbl_name+'&stat='+stat+'&f='+field;
});

$('#'+frm_8d_admin_edit+' #chk_replace').click(function() {
	if($(this).is(':checked')) {
		$('#' + frm_8d_admin_edit + ' input[type="file"]').prop('disabled', false);
		$('#' + frm_8d_admin_edit + ' input[type="file"]').attr('name', 'file_8d');
	} else {
		$('#' + frm_8d_admin_edit + ' input[type="file"]').prop('disabled', true);
		$('#' + frm_8d_admin_edit + ' input[type="file"]').attr('name', '');
	}
});

$('#'+ frm_8d_admin_edit).submit(function(e){
	/* Prevent page from submitting and reloading */
	e.preventDefault();
	var serialized_data = new FormData(this);
		serialized_data.append("action", "admin_save_final_report");
		serialized_data.append("send", "");
		serialized_data.append("fk8d", $('#modal_8d_admin_edit').data('id'));
		serialized_data.append("username", username);
		$('.btn').prop("disabled",true);
	/* Function for saving data to database */
	fn_admin_send_final_report(serialized_data, 'modal_8d_admin_edit');
});

/* Close the report to QAD - End */

/* Admin View report */
$('#'+ tbl_8d_admin +' tbody').on('click','tr .fa-eye', function(){
	/* Assign the modal_id and pkid to variable */
	var modal_id 		= 'modal_8d_admin_view';
	var pkid 			= $(this).attr('data-id');
	/* Function that fetches the details of the selected row */	
	fn_load_8d_main_data(pkid,modal_id,'');
	fn_get_approvers_log_by_fk8d(pkid, frm_8d_admin_view+' #tbl_approver_8d_admin_view');
	/* Assign the pkid to the data id of the modal */
	$('#'+modal_id).data('id',pkid);
	$('#'+modal_id).modal('show');
});

$('#'+ frm_8d_admin_view +' .fa-paperclip').click(function() {
	var tbl_name 		 = 'tbl_qfr_8d_attachment_final'; 	//table of module with fkfile_path
	var stat 		 	 = 'final'; 						//multiple or empty. empty means single
	var field 		 	 = 'fk8d'; 							
	window.location.href = "./pages/qfr/dl_excel_file.php?id="+$(this).val()+'&tbl_name='+tbl_name+'&stat='+stat+'&f='+field;
});

$('#tbl_approver_8d_admin_view tbody').on('click', 'tr .fa-paperclip', function() {
	var tbl_name 		 = 'tbl_qfr_8d_approvers'; 	//table of module with fkfile_path
	var stat 		 	 = ''; 						//multiple or empty. empty means single
	var field 		 	 = 'pkid'; 					//field name
	window.location.href = "./pages/qfr/dl_excel_file.php?id="+this.id+'&tbl_name='+tbl_name+'&stat='+stat+'&f='+field;
});

/* Datatable initialization */
dt_tbl_8d = $('#'+tbl_8d).DataTable({
	"aaSorting"	: [],
	"bProcessing": true,
	"bServerSide": true,
	"sAjaxSource": "server_side_scripts/qr/dt_8d.php?username="+username,
	"drawCallback": function( settings ) {
		$('#'+tbl_8d).attr('style','width:100%;');
	}
	// "drawCallback": function( settings ) {
		// $('#tbl_iqc_qar_requestor').attr('style','width:100%;');
	// }
});
	
/* Download file */
$('#' + tbl_8d + ' tbody').on('click', 'tr .fa-paperclip', function() {
	fn_return_8d_attachments( 'tbl_view_attachments', $(this).val() );
	fn_return_final_8d_attachment( 'container_final_attachment', $(this).val() );
});


/* **************************** 
	Start - Add New 8D record
**************************** */
/* Event when the add new button has been clicked */
$('#btn_add_8d').click(function(){
	/* Assign the modal ID, disable the save button and open modal */
	var modal_id = 'modal_8d';
	// $('#'+modal_id+' .fa-save').prop('disabled',true);
	// $('#'+modal_id+' #container_8d_upload_message').hide();
	$('#'+modal_id).modal('show');
	fn_get_po_list("", frm_id_new+' #list_po_num');
	get_8d_approvers(frm_id_new + " select[name='approver']", function() {
		$('.chosen-select#approver_new').chosen({width:"100%", height: "100%"});
	});
});

/* 
	Adding New 8D
*/


$('#'+frm_id_new+' input[name="po_number"]').keyup(function(e){
	var pattern = $(this).val();
	fn_get_po_list(pattern, frm_id_new+' #list_po_num');
});

$('#'+frm_id_new+' input[name="po_number"]').change(function(e){
	var po_number = $(this).val();
	var array_fields = [
		'input[name="device_name"]',
		'input[name="po_qty"]',
		'',
		'input[name="customer_name"]'
	]
	fn_get_po_details(po_number,frm_id_new,array_fields);
});
/* Event when the submit button of saving the 8D Details to database */
$('#'+frm_id_new).submit(function(e){
	/* Prevent page from submitting and reloading */
	e.preventDefault();
	/* Validate report approvers */
	if(fn_validate_approvers('approver_new', 'frm_8d #container_message_8d')) {
		var approver_username = [];
		$('#'+frm_id_new+' #approver_new :selected').each(function(i, selected) {
			approver_username[i] = $(selected).val();
		});
		$('.btn').prop("disabled",true);
		/* Get the form data */
		var serialized_data = new FormData(this);
			serialized_data.append("action", "save_8d");
			serialized_data.append("username", username);
			serialized_data.append("approvers", JSON.stringify(approver_username));
		/* Function for saving data to database */
		fn_save_8d(frm_id_new, serialized_data);
	}
	
});

function fn_save_8d(frm_id_new, serialized_data){
	call_ajax_attachment( serialized_data, handler_qfr_8d, function(result){
		console.log(result);
		/* Change this to your desired system message modal ID */
		var modal_id 		= 'modal_8d_system_message';
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
		}else{
			/* Update system message for success in saving data */
			$('.modal').modal('hide');
			$('#'+modal_id+' #div_system_message').empty();
			$('#'+modal_id+' #div_system_message').attr("class","alert alert-success");
			$('#'+modal_id+' #div_system_message').append("8D has been successfully uploaded!");
			$('#'+modal_id+'').modal('show');
			$('#'+frm_id_new+' input').val('');
			/* fn_system_message_timer(''+modal_id+''); */
			dt_tbl_8d.ajax.reload();
		}
		$('.btn').prop("disabled",false);
	});
}

/* 
	View/Edit 8D
*/
/* Event when the edit button on the table has been clicked */

$('#tbl_view_attachments tbody').on('click', 'tr .fa-paperclip', function() {
	var tbl_name 		 = 'tbl_qfr_8d_attachments_initial'; 	//table of module with fkfile_path
	var stat 		 	 = 'multiple'; 	//multiple or empty. empty means single
	window.location.href = "./pages/qfr/dl_excel_file.php?id="+$(this).val()+'&tbl_name='+tbl_name+'&stat='+stat;
});

$('#modal_8d_attachment_viewer .fa-download').click(function() {
	var tbl_name 		 = 'tbl_qfr_8d_attachment_final'; 	//table of module with fkfile_path
	var stat 		 	 = 'final'; 						//multiple or empty. empty means single
	var field 		 	 = 'pkid'; 							
	window.location.href = "./pages/qfr/dl_excel_file.php?id="+$(this).val()+'&tbl_name='+tbl_name+'&stat='+stat+'&f='+field;
});

$('#tbl_view_attachments tbody').on('click', 'tr .fa-trash', function() {
	var pkid = $(this).val();
	$('#btn_yes_remove_attachment').val(pkid);
	$('#btn_yes_remove_attachment').data('id','remove_8d_attachment');
	$('#modal_remove_attachment_confirmation').modal();
});

$('#frm_remove_attachment').on('submit', function(e) {
	e.preventDefault();
	fn_remove_attachment();
});

function fn_remove_attachment() {
	var data = {
		"action" 		: $('#btn_yes_remove_attachment').data('id'),
		"pkid"			: $('#btn_yes_remove_attachment').val(),
		"reason"		: $('#reason').val(),
		"username"		: username
	} 
	call_ajax(data, handler_qfr_8d, function(result){
		$('#modal_remove_attachment_confirmation').modal('hide');
		
		if($('#btn_yes_remove_attachment').data('id') == 'remove_8d_attachment') {
			fn_return_8d_attachments( 'tbl_view_attachments', result['fk8d'] );
		} 
		$('#modal_system_message').modal();
		$('#container_message').attr('class','alert alert-success');
		$('#container_message').html( '<h4>'+result['msg']+'</h4>' );
	});
}
/* Approver section - START */
$('#tbl_8d tbody').on('click','tr .fa-commenting-o', function(){
	/* Assign the modal_id and pkid to variable */
	var modal_id 		= 'modal_8d_edit_approver';
	var pkid 			= $(this).attr('data-id');
	var existing_status 	= $(this).closest('tr').find('td:eq(0)').text();
	/* Function that fetches the details of the selected row */	
	fn_load_8d_main_data(pkid,modal_id,'');
	fn_get_approvers_log_by_fk8d(pkid, frm_id_edit_approver+' #tbl_approver_8d_edit_approver');
	/* Assign the pkid to the data id of the modal */
	$('#'+modal_id).data('id',pkid);
	$('#'+modal_id).modal('show');
	fn_validate_is_approver(pkid, existing_status);
});

$('#'+ frm_id_edit_approver +' .fa-paperclip').click(function() {
	fn_return_8d_attachments( 'tbl_view_attachments', $(this).val() );
	fn_return_final_8d_attachment( 'container_final_attachment', $(this).val() );
});

$('#tbl_approver_8d_edit_approver tbody').on('click', 'tr .fa-paperclip', function() {
	var tbl_name 		 = 'tbl_qfr_8d_approvers'; 	//table of module with fkfile_path
	var stat 		 	 = ''; 						//multiple or empty. empty means single
	var field 		 	 = 'pkid'; 					//field name
	window.location.href = "./pages/qfr/dl_excel_file.php?id="+this.id+'&tbl_name='+tbl_name+'&stat='+stat+'&f='+field;
});

$('#'+ frm_id_edit_approver + ' #chk_recomment').click(function() {
	if($(this).is(':checked')) {
		$('#' + frm_id_edit_approver + ' input[type="file"]').prop('disabled', false);
		$('#' + frm_id_edit_approver + ' input[type="file"]').attr('name', 'file_8d');
		$('#' + frm_id_edit_approver + ' input[type="submit"]').show();
		$('#' + frm_id_edit_approver + ' textarea').prop('readonly', false);
	} else {
		$('#' + frm_id_edit_approver + ' input[type="file"]').prop('disabled', true);
		$('#' + frm_id_edit_approver + ' input[type="file"]').attr('name', '');
		$('#' + frm_id_edit_approver + ' textarea').prop('readonly', true);
		$('#' + frm_id_edit_approver + ' input[type="submit"]').hide();
	}
});

$('#'+ frm_id_edit_approver + ' .fa-remove').click(function() {
	var pkid = $('#modal_8d_edit_approver').data('id');
	$('#modal_8d_edit_approver').modal('hide');
	$('#btn_yes_remove_attachment').val(pkid);
	$('#btn_yes_remove_attachment').data('id','remove_8d_approver_attachment');
	$('#modal_remove_attachment_confirmation').modal();
});

$('#'+ frm_id_edit_approver).submit(function(e){
	/* Prevent page from submitting and reloading */
	e.preventDefault();
	if($('#'+ frm_id_edit_approver+' #file_8d').val() === '' && $('#'+ frm_id_edit_approver+' textarea[name="approver_comment"]').val() == '') {
		$('#modal_system_message').modal();
		$('#container_message').attr('class','alert alert-danger');
		$('#container_message').html( '<h4>Please select file or add some comment.</h4>' );
	} else {
		$('.btn').prop("disabled",true);
		/* Get the form data */
		var serialized_data = new FormData(this);
			serialized_data.append("action", "approver_8d_comment");
			serialized_data.append("fk8d", $('#modal_8d_edit_approver').data('id'));
			serialized_data.append("username", username);
		/* Function for saving data to database */
		fn_approver_8d_comment(serialized_data);	
	}
});

function fn_get_approvers_log_by_fk8d(fk8d, table_id) {
	$('#'+table_id+' tbody').empty();
	var data = {
		"action" : "get_8d_approvers_log",
		"fk8d"	 : fk8d
	}
	call_ajax( data, handler_qfr_8d, function(result) {			
		$('#'+table_id+' tbody').append(result['table_body']);
	});
}

/* Approver section - END */

/* Requestor sending section - START */
$('#tbl_8d tbody').on('click','tr .fa-upload', function(){
	/* Assign the modal_id and pkid to variable */
	var modal_id 		= 'modal_8d_edit_requestor';
	var pkid 			= $(this).attr('data-id');
	var existing_status 	= $(this).closest('tr').find('td:eq(0)').text();
	/* Function that fetches the details of the selected row */	
	fn_load_8d_main_data(pkid,modal_id,'');
	fn_get_approvers_log_by_fk8d(pkid, frm_id_edit_requestor+' #tbl_approver_8d_edit_requestor');
	/* Assign the pkid to the data id of the modal */
	$('#'+modal_id).data('id',pkid);
	$('#'+modal_id).modal('show');
	fn_validate_is_approver(pkid, existing_status);
});

$('#'+ frm_id_edit_requestor +' .fa-paperclip').click(function() {
	fn_return_8d_attachments( 'tbl_view_attachments', $(this).val() );
	fn_return_final_8d_attachment( 'container_final_attachment', $(this).val() );
});

$('#tbl_approver_8d_edit_requestor tbody').on('click', 'tr .fa-paperclip', function() {
	var tbl_name 		 = 'tbl_qfr_8d_approvers'; 	//table of module with fkfile_path
	var stat 		 	 = ''; 	//multiple or empty. empty means single
	var field 		 	 = 'pkid'; 	//field name
	window.location.href = "./pages/qfr/dl_excel_file.php?id="+this.id+'&tbl_name='+tbl_name+'&stat='+stat+'&f='+field;
});

$('#'+ frm_id_edit_requestor).submit(function(e){
	/* Prevent page from submitting and reloading */
	e.preventDefault();
	$('.btn').prop("disabled",true);
	/* Get the form data */
	var serialized_data = new FormData(this);
		serialized_data.append("action", "requestor_8d_comment");
		serialized_data.append("fk8d", $('#modal_8d_edit_requestor').data('id'));
		serialized_data.append("username", username);
	// /* Function for saving data to database */
	fn_approver_8d_comment(serialized_data);	
});

/* Requestor sending section - END */


/* View code */
$('#tbl_8d tbody').on('click','tr .fa-eye', function(){
	/* Assign the modal_id and pkid to variable */
	var modal_id 		= 'modal_8d_view';
	var pkid 			= $(this).attr('data-id');
	var existing_status 	= $(this).closest('tr').find('td:eq(0)').text();
	/* Function that fetches the details of the selected row */	
	fn_load_8d_main_data(pkid,modal_id,'');
	fn_get_approvers_log_by_fk8d(pkid, frm_id_view+' #tbl_approver_8d_view');
	/* Assign the pkid to the data id of the modal */
	$('#'+modal_id).data('id',pkid);
	$('#'+modal_id).modal('show');
});

$('#'+ frm_id_view +' .fa-paperclip').click(function() {
	fn_return_8d_attachments( 'tbl_view_attachments', $(this).val() );
	fn_return_final_8d_attachment( 'container_final_attachment', $(this).val() );
});

$('#tbl_approver_8d_view tbody').on('click', 'tr .fa-paperclip', function() {
	var tbl_name 		 = 'tbl_qfr_8d_approvers'; 	//table of module with fkfile_path
	var stat 		 	 = ''; 	//multiple or empty. empty means single
	var field 		 	 = 'pkid'; 	//field name
	window.location.href = "./pages/qfr/dl_excel_file.php?id="+this.id+'&tbl_name='+tbl_name+'&stat='+stat+'&f='+field;
});

function fn_validate_is_approver(fk8d, existing_status) {
	var data = {
		"action" 	 : "validate_is_approver",
		"fk8d" 		 : fk8d,
		"username" 	 : username
	}
	call_ajax( data, handler_qfr_8d, function(result) {
		if(result['is_approver'] == 0) {
			$('#' + frm_id_edit_approver + ' #container_approver_section').hide();
			$('#' + frm_id_edit_approver + ' .fa-send-o').hide();
			$('#' + frm_id_edit_approver + ' input[type="file"]').prop('disabled', false);
			$('#' + frm_id_edit_approver + ' textarea').prop('readonly', false);
		} else {
			$('#' + frm_id_edit_approver + ' #container_approver_section').show();
			$('#' + frm_id_edit_approver + ' .fa-send-o').show();
			if(existing_status == 'PENDING' || existing_status == 'OPEN') {
				$('#' + frm_id_edit_approver + ' #container_as_chk').hide();
				$('#' + frm_id_edit_approver + ' input[type="file"]').prop('disabled', false);
				$('#' + frm_id_edit_approver + ' textarea').prop('readonly', false);
			} else if(existing_status == 'CLOSED' || existing_status == 'DONE') {
				$('#' + frm_id_edit_approver + ' #container_as_chk').show();
				$('#' + frm_id_edit_approver + ' input[type="file"]').prop('disabled', true);
				$('#' + frm_id_edit_approver + ' textarea').prop('readonly', true);
			}
		}
	});
}

function fn_approver_8d_comment(serialized_data) {			
	call_ajax_attachment(serialized_data, handler_qfr_8d, function(result){
		$('#modal_8d_edit_approver').modal('hide');
		$('#modal_8d_edit_requestor').modal('hide');
		$('#modal_system_message').modal();
		$('#container_message').attr('class','alert alert-success');
		$('#container_message').html( '<h4>'+result['msg']+'</h4>' );
		$('#' + frm_id_edit_approver + ' input[type="file"]').prop('checked', false);
		dt_tbl_8d.ajax.reload();
		dt_tbl_8d_admin.ajax.reload();
		$('.btn').prop("disabled",false);
	});
}

$('#tbl_8d tbody').on('click','tr .fa-edit', function(){
	var modal_id = 'modal_8d_edit';
	var pkid = $(this).attr('data-id');
	/* Assign the modal_id and pkid to variable */
	if($(this).text() == ' Edit') {
		rev_status = 'existing';
		$('#'+frm_id_edit+' input[type="file"]').prop('required', false);
	} else if($(this).text() == ' Revise') {
		rev_status = 'new';
		$('#'+frm_id_edit+' input[type="file"]').prop('required', true);
	} else {
		rev_status = '';
	}
	/* Function that fetches the details of the selected row */	
	get_8d_approvers(frm_id_edit + " select[name='approver']", function() {
		$('.chosen-select#approver_edit').chosen({width:"100%", height: "100%"});
		fn_load_8d_main_data(pkid,modal_id,'approver_edit');
	});
	$('#'+frm_id_edit).show();
	/* Assign the pkid to the data id of the modal */
	$('#'+modal_id).data('id',pkid);
	$('#'+modal_id).modal('show');
});

$('#'+frm_id_edit+' .fa-paperclip').click(function() {
	fn_return_8d_attachments( 'tbl_view_attachments', $(this).val() );
	fn_return_final_8d_attachment( 'container_final_attachment', $(this).val() );
});

/* Event when the re-upload button for replacing 8D */
$('#'+frm_id_edit).submit(function(e){
	/* Prevent the page from submitting and reloading */
	e.preventDefault();
	/* Validate report approvers */
	if(fn_validate_approvers('approver_edit', frm_id_edit+' #container_message_8d')) {
		var approver_username = [];
		$('#'+frm_id_edit+' #approver_edit :selected').each(function(i, selected) {
			approver_username[i] = $(selected).val();
		});
		$('.btn').prop("disabled",true);
		/* Get the form data */
		var serialized_data = new FormData(this);
			serialized_data.append("action", "edit_8d");
			serialized_data.append("pkid", $('#modal_8d_edit').data('id') );
			serialized_data.append("username", username);
			serialized_data.append("rev_status", rev_status);
			serialized_data.append("rev_no", $('#'+frm_id_edit+' input[name="rev_no"]').val());
			serialized_data.append("approvers", JSON.stringify(approver_username));
		/* Function for saving data to database */
		fn_update_8d(serialized_data, 'modal_8d_edit');
	}
});

function fn_load_8d_main_data(pkid,modal_id, chosen_id){
	var data = {
		"action"	: "load_8d_main_data",
		"username"	: username,
		"pkid"		: pkid
	}
	call_ajax( data, handler_qfr_8d, function(result){
		console.log(result);
		/* append values on form elements */
		$.each(result['data'],function(key,value){
			$('#' + modal_id +' form input[name="'+key+'"]').val(value);
			$( '#' + modal_id + ' form textarea[name="' + key + '"]' ).val(value);
			
			if(key == 'pkid') {
				$('#' + modal_id +' form button[type="button"]').val(value);
			}
			if(key == 'po_number') {
				// $('#' + modal_id +' form button[type="button"]').val(value);
				var po_number = value;
				var array_fields = [
					'input[name="device_name"]',
					'input[name="po_qty"]',
					'',
					'input[name="customer_name"]'
				]
				fn_get_po_details(po_number,modal_id,array_fields);
			}
		});
		
		if(chosen_id != '') {
			/* Approver */
			$.each((result['approver_username']).split(','), function(index, element)
			{
			   $('#'+chosen_id).find('option[value="'+ element +'"]').attr('Selected', 'Selected');
			   $("#"+chosen_id).trigger('chosen:updated');   
			});
		}
		
		if(result['remove_attachment'] == 'true') {
			$('#' + modal_id +' .fa-remove').show();
		} else {
			$('#' + modal_id +' .fa-remove').hide();
		}
	});
}

function fn_update_8d(serialized_data, modal_id){
	call_ajax_attachment(serialized_data, handler_qfr_8d, function(result){
		console.log(result);
		$('#container_message').attr('class', 'alert alert-success');
		$('#modal_system_message').modal();
		$('#modal_8d_edit').modal('hide');
		$('#container_message').html( '<h4>'+result['msg']+'</h4>' );
		dt_tbl_8d.ajax.reload();
		$('.btn').prop("disabled",false);
	});
}

function fn_edit_8d(serialized_data){
	var data = {
		"action"	: "edit_8d",
		"excel_file": $('#'+frm_id_edit+' input[type="file"]').val(),
		"pkid"		: $('#modal_8d_edit').data('id'),
		"username"	: username
	}
	call_ajax_serialize( data, serialized_data, handler_qfr_8d, function(result){
		console.log(result);
		/* Change this to your desired system message modal ID */
		var modal_id = 'modal_8d_system_message';
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
		}else{
			/* Update system message for success in saving data */
			$('.modal').modal('hide');
			$('#'+modal_id+' #div_system_message').empty();
			$('#'+modal_id+' #div_system_message').attr("class","alert alert-success");
			$('#'+modal_id+' #div_system_message').append("8D has been successfully updated!");
			$('#'+modal_id).modal('show');
			$('#'+frm_id_edit+' input').val('');
			dt_tbl_8d.ajax.reload();
		}
	});
}

/* 
	Cancel/Delete 8D
*/
$('#tbl_8d tbody').on('click','tr .fa-remove', function(){
	/* Assign the modal_id and pkid to variable */
	var modal_id = 'modal_8d_cancel';
	var form_id  = 'frm_8d_edit';
	var pkid = $(this).attr('id');
	/* Function that fetches the details of the selected row */
	fn_load_8d_main_data(pkid,modal_id);
	$('#'+form_id).hide();
	/* Assign the pkid to the data id of the modal */
	$('#'+modal_id).data('id',pkid);
	$('#'+modal_id).modal('show');
});

$('#frm_8d_cancel').submit(function(e){
	e.preventDefault();
	if(confirm("You are about to cancel this 8D")){
		fn_cancel_8d();
	}
});

function fn_cancel_8d(){
	var modal_id = 'modal_8d_cancel';
	var data = {
		"action"	: "cancel_8d",
		"pkid"		: $('#'+modal_id).data('id')
	}
	call_ajax(data, handler_qfr_8d, function(result){
		console.log(result);
		var modal_id = 'modal_8d_system_message';
		var form_id  = 'frm_8d_cancel';
		/* Update system message for success in saving data */
		$('.modal').modal('hide');
		$('#'+modal_id+' #div_system_message').empty();
		$('#'+modal_id+' #div_system_message').attr("class","alert alert-success");
		$('#'+modal_id+' #div_system_message').append("8D has been successfully removed!");
		$('#'+modal_id).modal('show');
		fn_system_message_timer(''+modal_id+'');
		dt_tbl_8d.ajax.reload();
	});
}

/* **************************** 
	Start - Common Functions
**************************** */

function get_8d_approvers(cmb_id, callback) {
	$('#'+cmb_id).empty();
	var data = {
		"action"				: "get_8d_approvers"
	}
	call_ajax( data, handler_qfr_8d, function(result){
		console.log(result);
		/* append values on form elements */
		$('#'+cmb_id).append(result['html_select']);
		callback();
	});
}

function fn_validate_approvers(approver_id, container_message_id) {
	if($('#'+approver_id + ' option:selected').length <= 1 ) {
		$('#'+container_message_id).html('Please select approver atleast 2.');
		$('#'+container_message_id).show();
		$('.btn').prop("disabled",false);
		return false;
	} else {
		$('#'+container_message_id).hide();
		return true;
	}
}

function fn_validate_recipient(approver_id, container_message_id) {
	if($('#'+approver_id + ' option:selected').length <= 0 ) {
		$('#'+container_message_id).html('Please select recipient.');
		$('#'+container_message_id).show();
		$('.btn').prop("disabled",false);
		return false;
	} else {
		$('#'+container_message_id).hide();
		return true;
	}
}

function fn_return_8d_attachments(tbl_id, pkid) {
	$('#' + tbl_id + ' tbody').empty();
	var data = {
		"action"	: "return_8d_attachments",
		"username"	: username,
		"fk8d"		: pkid
	}
	call_ajax( data, handler_qfr_8d, function(result){
		console.log(result);
		$('#' + tbl_id + ' tbody').append( result['table_body'] );
		$('#modal_8d_attachment_viewer').modal();
	});
}

function fn_return_final_8d_attachment(div_id, pkid) {
	var data = {
		"action"	: "return_final_8d_attachment",
		"fk8d"		: pkid
	}
	call_ajax( data, handler_qfr_8d, function(result){
		if(result['pkid'] == '0') {
			$('#' + div_id).hide();
		} else {
			$('#' + div_id).show();
			$('#' + div_id + ' .fa-download').val(result['pkid']);
		}
	});
}

/* **************************** 
	End - Common Functions
**************************** */

/* **************************** 
	Start - Advanced Search 
**************************** */
// var global_qfr_8d_as_where		 	= '';
// var qfr_8d_as_select_ctr			= 1;

// $('#btn_qfr_8d_search_main').click(function(){
	// if( global_qfr_8d_as_where == ""){
		// $('#tbl_qfr_8d_advance_search tbody').empty();
		// fn_qfr_8d_as_draw_row('cmb_qfr_8d_as_field0');
		// fn_return_qfr_8d_fields('cmb_qfr_8d_as_field0');
	// }
	// $('#modal_qfr_8d_advance_search').modal('show');
// });

// $('#frm_qfr_8d_advance_search #btn_dir_as_add').click(function() {
	// qfr_8d_as_select_ctr++;
	// var select_id = 'cmb_qfr_8d_as_field0'+qfr_8d_as_select_ctr;
	// fn_qfr_8d_as_draw_row(select_id);
	// fn_return_qfr_8d_fields(select_id);
// });

// $('#frm_qfr_8d_advance_search #btn_dir_as_reset').click(function() {
	// global_qfr_8d_as_where = '';
	// $('#tbl_qfr_8d_advance_search tbody').empty();
	// fn_qfr_8d_as_draw_row('cmb_qfr_8d_as_field0');
	// fn_return_qfr_8d_fields('cmb_qfr_8d_as_field0');
	// dt_qfr_8d.ajax.url("server_side_scripts/qfr/8d.php?username="+username+"&wh="+global_qfr_8d_as_where).load();
// });

// $('#frm_qfr_8d_advance_search').on('submit', function(e) {
	// e.preventDefault();
	// var serialized_data = $(this).serialize();
	// fn_qfr_8d_advance_search(serialized_data);
	// $('#modal_qfr_8d_advance_search').modal('hide');
	// $('#tbl_qfr_8d_advance_search tbody').empty();
	// vir_as_select_ctr = 0;
// });

// /* change the input type once date is selected */
// $('#tbl_qfr_8d_advance_search tbody').on('change', 'select[name="field_name[]"]', function(){
	// var select_value = $(this).val();
	// var selected_row = $(this).closest('tr');
	// var row_index 	= selected_row.index();
	// if(select_value == "shipment_date"){
		// selected_row.find('td:eq(2)').html('<input type="text" class="form-control ui-datepicker" name="val[]" id="txt_date_range" placeholder="Click to add date" required readonly>');
		// selected_row.find('td:eq(1) select').empty();
		// selected_row.find('td:eq(1) select').append('<option value="BETWEEN">BETWEEN</option>');
		// date_time_picker('tbl_qfr_8d_advance_search tr:eq('+row_index+') #txt_date_range');
	// }else{
		// selected_row.find('td:eq(2)').html('<input type="text" id="cmb_oqc_dir_as_value" name="val[]" class="form-control condensed" required>');
		// selected_row.find('td:eq(1) select').empty();
		// selected_row.find('td:eq(1) select').append('<option value="EQUALS"> EQUALS </option>');
		// selected_row.find('td:eq(1) select').append('<option value="LIKE"> CONTAINS </option>');
	// }
// });

// $('#tbl_qfr_8d_advance_search tbody').on('click', 'button[type="button"]', function() {
	// $(this).closest('tr').remove();
	// return false;
// });

// function fn_qfr_8d_as_draw_row(select_id){
	// var row  = '<tr>';
		// row += '	<td style="width:30%;">';
		// row += '		<select id="'+select_id+'" name="field_name[]" class="form-control condensed" required>';
		// row += '		</select>';
		// row += '	</td>';
		// row += '	<td style="width:20%;">';
		// row += '		<select id="cmb_dir_as_condition" name="condition[]" class="form-control condensed" required>';
		// row += '			<option value="EQUALS"> EQUALS </option>';
		// row += '			<option value="LIKE"> CONTAINS </option>';
		// row += '		</select>';
		// row += '	</td>';
		// row += '	<td style="width:40%;">';
		// row += '		<input type="text" id="cmb_oqc_dir_as_value" name="val[]" class="form-control condensed" required>';
		// row += '	</td>';
		// row += '	<td style="width:10%;">';
		// row += '		<button type="button" id="btn_dir_as_remove" class="btn btn-default fa fa-trash"> Remove</button>';
		// row += '	</td>';
		// row += '</tr>';
	// $('#tbl_qfr_8d_advance_search tbody').append(row);
// }

// function fn_return_qfr_8d_fields(select_id){
	// var data = {
		// "action"	: "qfr_8d_return_dir_fields"
	// }
	// call_ajax(data, handler_qfr_8d, function(result){	
		// console.log(result);
		// for(var i=0; i < result['ctr']; i++) {
			// $('#'+select_id).append(result['option'][i]);
		// }
	// });
// }

// function fn_qfr_8d_advance_search(serialized_data) {
	// var data = {
		// "action"	: "qfr_8d_advance_search"
	// }
	// call_ajax_serialize(data, serialized_data, handler_qfr_8d, function(result){	
		// console.log(result);
		// global_qfr_8d_as_where = encodeURIComponent(result['sql_where']);
		// dt_qfr_8d.ajax.url("server_side_scripts/qfr/8d.php?username="+username+"&wh="+global_qfr_8d_as_where).load(); //check this
	// });
// }
/* ****************************
	End - Advanced Search 
*****************

/* **************************************************
	8D Module - End
/***************************************************/