var dt_loss_cost 			= '';
var tbl_loss_cost 			= 'tbl_loss_cost';
var mdl_new_loss_cost 		= 'mdl_new_loss_cost';
var frm_new_loss_cost 		= 'frm_new_loss_cost';

dt_loss_cost = $('#'+tbl_loss_cost).DataTable({
	"aaSorting"	 : [],
	"bProcessing": true,
	"bServerSide": true,
	"sAjaxSource": "server_side_scripts/qr/dt_loss_cost.php?username="+username,
	"drawCallback": function( settings ) {
		$('#'+tbl_loss_cost).attr('style','width:100%;');
	}
});

$('#btn_new_loss_cost').click(function() {
	$('#'+mdl_new_loss_cost).modal('show');
});

$('#'+frm_new_loss_cost).on('submit', function(e) {
	e.preventDefault();
	var serialized_data = new FormData(this);
		serialized_data.append("action","save_loss_cost");
		serialized_data.append("username",username);
	fn_save_loss_cost(serialized_data, mdl_new_loss_cost, frm_new_loss_cost);
});

function fn_save_loss_cost(serialized_data, mdl_id, frm_id) {
	// $('.btn').prop("disabled",true);
	call_ajax_attachment(serialized_data, handler_loss_cost, function(result){
		// console.log(result);
		$('#'+mdl_id).modal('hide');
		$('#modal_system_message').modal();
		$('#container_message').attr('class','alert alert-success');
		$('#container_message').html( '<h4>'+result['msg']+'</h4>' );
		$('.btn').prop("disabled",false);
		fn_reload_lc_datatables();
		$('#'+mdl_id+' input,textarea').val('');
	});
}
/* Loss Cost - Add */
/* Loss Cost - Edit Start */
var mdl_edit_loss_cost 		= 'mdl_edit_loss_cost';
var frm_edit_loss_cost 		= 'frm_edit_loss_cost';
var for_delete				= [];

$('#'+tbl_loss_cost+' tbody').on('click','.fa-edit', function() {
	var pkid = $(this).data('id');
	$('#'+mdl_edit_loss_cost).data('id',pkid);
	fn_get_loss_cost_details_by_pkid(pkid,mdl_edit_loss_cost,frm_edit_loss_cost);
	fn_display_attachment(pkid, mdl_edit_loss_cost,'edit');
	for_delete = [];
});

$('#'+frm_edit_loss_cost).on('submit', function(e) {
	e.preventDefault();
	var serialized_data = new FormData(this);
		serialized_data.append("action","update_loss_cost");
		serialized_data.append("pkid",$('#'+mdl_edit_loss_cost).data('id'));
		serialized_data.append("username",username);
		serialized_data.append("pkid_for_delete",for_delete);
	fn_update_loss_cost(serialized_data, mdl_edit_loss_cost, frm_edit_loss_cost);
});

$('#'+mdl_edit_loss_cost+' .fa-paperclip').on('click', function() {
	$('#'+mdl_edit_loss_cost).data('id', $(this).val());
	fn_display_attachment($(this).val(), mdl_lc_attachments, 'edit');
	$('#'+mdl_lc_attachments).modal('show');
});

$('#'+mdl_edit_loss_cost+' table tbody').on('click','.fa-trash', function() {
	var pkid = $(this).data('id');
	$(this).closest('tr').remove();
	for_delete.push(pkid);
	// console.log(for_delete); 
});

$('#'+mdl_edit_loss_cost+' table tbody').on('click','.fa-paperclip', function() {
	var pkid = $(this).data('id');
	window.open('./pages/qfr/loss_cost_data_file_view.php?id='+pkid, '_blank');
});

function fn_update_loss_cost(serialized_data, mdl_id, frm_id) {
	$('.btn').prop("disabled",true);
	call_ajax_attachment(serialized_data, handler_loss_cost, function(result){
		// console.log(result);
		$('#'+mdl_id).modal('hide');
		$('#modal_system_message').modal();
		$('#container_message').attr('class','alert alert-success');
		$('#container_message').html( '<h4>'+result['msg']+'</h4>' );
		$('.btn').prop("disabled",false);
		fn_reload_lc_datatables();
		for_delete = [];
		$('#'+mdl_id+' input,textarea').val('');
	});
}

/* Loss Cost - Edit End */

/* Loss Cost - View attachment Start*/
var mdl_lc_attachments 		= 'mdl_lc_attachment_viewer';

$('#'+tbl_loss_cost+' tbody').on('click','.fa-paperclip', function() {
	var pkid_attach = $(this).val();
	fn_display_attachment(pkid_attach, mdl_lc_attachments,'view');
	$('#'+mdl_lc_attachments).modal('show');
});

$('#'+mdl_lc_attachments+' table tbody').on('click','.fa-paperclip', function() {
	var pkid = $(this).data('id');
	window.open('./pages/qfr/loss_cost_data_file_view.php?id='+pkid, '_blank');
});

function fn_display_attachment(pkid, mdl_id,action2) {
	$('#'+mdl_id+' table tbody').empty();
	var data = {
		"action" 		: "get_loss_cost_attachments",
		"pkid"			: pkid,
		"action2"		: action2
	} 
	call_ajax(data, handler_loss_cost, function(result){
		$('#'+mdl_id+' table tbody').append( result['table_body'] );
	});
}

/* Loss Cost - View attachment End*/
/* Loss Cost - View Start */
var mdl_view_loss_cost 		= 'mdl_view_loss_cost';
var frm_view_loss_cost 		= 'frm_view_loss_cost';

$('#'+tbl_loss_cost+' tbody').on('click','.fa-eye', function() {
	var pkid = $(this).data('id');
	fn_get_loss_cost_details_by_pkid(pkid,mdl_view_loss_cost,frm_view_loss_cost);
});

$('#'+mdl_view_loss_cost+' .fa-paperclip').on('click', function() {
	fn_display_attachment($(this).val(), mdl_lc_attachments, 'view');
	$('#'+mdl_lc_attachments).modal('show');
});

function fn_get_loss_cost_details_by_pkid(pkid,mdl_id,frm_id) {
	var data = {
		"action"	: "get_loss_cost_details_by_pkid",
		"pkid"		: pkid
	}
	call_ajax(data, handler_loss_cost, function(result){
		// console.log(result);
		$.each(result['data'],function(key, value){
			$('#'+frm_id+' input[name="'+key+'"]').val(value);
			$('#'+frm_id+' button[name="'+key+'"]').val(value);
			$('#'+frm_id+' textarea[name="'+key+'"]').val(value);			
		});
		$('#'+mdl_id).modal('show');
	});
}

/* Loss Cost - View End */

function fn_reload_lc_datatables() {
	dt_loss_cost.ajax.reload(null, false);
}