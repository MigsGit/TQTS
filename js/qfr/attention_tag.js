/* ***************************
	Attention Tag - Start
/****************************/
$.ajaxSetup({
	url		: handler_qfr, 		// Url to which the request is send
	type	: "POST",           	// Type of request to be send, called as method
	dataType: "JSON",           	// Type of request to be send, called as method
});
var dt_tbl_attention_tag = $('#tbl_attention_tag').DataTable({
	"aaSorting"	 : [],
	"bProcessing": true,
	"bServerSide": true,
	// "sAjaxSource": "server_side_scripts/qr/dt_at.php?username=ronfern&"+username,
	"sAjaxSource": "server_side_scripts/qr/dt_at.php?username="+username,
	"drawCallback": function( settings ) {
		$('#tbl_attention_tag').attr('style','width:100%;');
	}
});
var tbl_attention_tag = 'tbl_attention_tag';
/**
 * 
 *  *Modal*
 * !modal_add_attention_tag
 * !modal_view_attention_tag
 * *Form Submit*
 * !$('#'+form_add_attention_tag).submit
 * !$('#'+form_view_attention_tag).submit
 * !$('#'+form_at_cancel).submit
 * *FUNCTION*
 * !fn_save_attention_tag
 * !fn_update_attention_tag
 * !get_control_number
 * !fn_load_at_info
 * !fn_cancel_attention_tag
 * !re_initialize_select2_server_side 
 * !assign_value_select2
 * !Toaster Notification
 * *Datatables button*
 * !$('#'+tbl_attention_tag+' tbody' ).on('click', 'tr .fa-eye'
 * !$('#'+tbl_attention_tag).on('click', 'tr .fa-edit'
 * !$('#'+tbl_attention_tag).on('click','tr .fa-remove'
 * !$('#'+tbl_attention_tag).on('click', 'tr a[name="a_download"]'
 * 
 */
$(document).ready(function () {
	var form_add_attention_tag = 'form_add_attention_tag';
	var form_view_attention_tag ='form_view_attention_tag';
	var form_at_cancel ='form_at_cancel';
	
	$('#'+tbl_attention_tag).on('click', 'tr a[name="a_download"]', function () {
		var pkid = this.id;
		window.location.href = "./reports/pdf_qfr_attention_tag_download.php?id="+pkid;
	});
	$('#'+tbl_attention_tag).on('click', 'tr .fa-eye', function () {
		var pkid = this.id;
		var mode = 'view';
		$('#modal_view_attention_tag').modal('show');
		$('#'+form_view_attention_tag+' #selected_file').hide();
		$('#'+form_view_attention_tag+' #btn_selected_file').show();
		fn_load_at_info(pkid,mode);
	});
	$('#'+tbl_attention_tag).on('click', 'tr .fa-edit', function () {
		var pkid = this.id;
		var mode = 'edit';
		$('#modal_view_attention_tag').modal('show');
		$('#'+form_view_attention_tag+' #selected_file').hide();
		$('#'+form_view_attention_tag+' #btn_selected_file').show();
		fn_load_at_info(pkid,mode);
	});
	$('#'+tbl_attention_tag).on('click','tr .fa-remove',function(){
		var pkid = this.id;
		fn_load_at_info(pkid);
		$('#modal_at_cancel').modal('show');
	});
	$('#'+form_at_cancel).submit(function (e) { 
		e.preventDefault();
		var serialized_data = new FormData(this);
			serialized_data.append('action','cancel_attention_tag');
		fn_cancel_attention_tag(serialized_data);

	});
	$('#'+form_view_attention_tag+' input[name="radio_type_search"]').click(function() {
		$('#'+form_view_attention_tag+' #part_po').show();

		$('#'+form_view_attention_tag+' input[name="model"]').val('');
		$('#'+form_view_attention_tag+' input[name="product"]').val('');
		$('#'+form_view_attention_tag+' input[name="po_no"]').val('');
		$('#'+form_view_attention_tag+' input[name="part_code"]').val('');

		var search_type = "";
		$('#'+form_view_attention_tag+' input[name="radio_type_search"]').each(function(){
			if( $(this).prop('checked') ){
				search_type = $(this).val();
				$('#'+form_view_attention_tag+' input[name="part_po"]').val('');
			}
		});
		// console.log(search_type);
		if( search_type == 'Parts'){
			$('#'+form_view_attention_tag+' #po_no').hide();
			$('#'+form_view_attention_tag+' #part_code').show();
			fn_get_partcode_list('','list_at_po');
			
		}else{
			$('#'+form_view_attention_tag+' #po_no').show();
			$('#'+form_view_attention_tag+' #part_code').hide();
			fn_get_po_list('','list_at_po');
		}
	});
	$('#'+form_view_attention_tag+' input[name="part_po"]').change(function(e){
		e.preventDefault();
		var current_value = $(this).val();
		var search_type = '';
		$('#'+form_view_attention_tag+' input[name="radio_type_search"]').each(function(){
			if($(this).prop('checked')){
				search_type = $(this).val();
			}
		});
		if(search_type == 'Parts'){
			var product_id= form_view_attention_tag+' input[name="product"]';
			fn_get_partname_place_in_input(current_value,product_id);
		}else{
			var model_id= form_view_attention_tag+' input[name="model"]';
			fn_get_devicename_by_po(current_value,model_id);
		}
	});
	$('#'+form_view_attention_tag+' #file_chkbox').click(function(){
		// console.log('file_chkbox');
		if($(this).prop('checked')){
			$('#'+form_view_attention_tag+' #selected_file').show();
			$('#'+form_view_attention_tag+' #btn_selected_file').hide();
		}else{
			$('#'+form_view_attention_tag+' #selected_file').hide();
			$('#'+form_view_attention_tag+' #btn_selected_file').show();
		}
	});
	$('#'+form_view_attention_tag+' #btn_selected_file').click(function(){
		var pkid = $(this).val();
		window.location.href = "./reports/pdf_qfr_attention_tag_download.php?id="+pkid;
	});
	$('#btn_attention_tag_new').click(function(e) { 
		e.preventDefault();
		$('#modal_add_attention_tag').modal('show');
		$('#'+form_add_attention_tag+' #part_po').hide();
		get_control_number(username);
		re_initialize_select2_server_side('#modal_add_attention_tag #issuance_by','#modal_add_attention_tag #form_add_attention_tag',[],"server_side_scripts/dropdown/common/dd_rapid_hris_and_subcon_list.php");
		fn_empty_at_fields(form_add_attention_tag);
	});
	$('#'+form_add_attention_tag+' input[name="radio_type_search"]').click(function() {
		$('#'+form_add_attention_tag+' #part_po').show();

		$('#'+form_add_attention_tag+' input[name="model"]').val('');
		$('#'+form_add_attention_tag+' input[name="product"]').val('');
		$('#'+form_add_attention_tag+' input[name="po_no"]').val('');
		$('#'+form_add_attention_tag+' input[name="part_code"]').val('');

		var search_type = "";
		$('#'+form_add_attention_tag+' input[name="radio_type_search"]').each(function(){
			if( $(this).prop('checked') ){
				search_type = $(this).val();
				$('#'+form_add_attention_tag+' input[name="part_po"]').val('');
			}
		});
		// console.log(search_type);
		if( search_type == 'Parts'){
			$('#'+form_add_attention_tag+' #po_no').hide();
			$('#'+form_add_attention_tag+' #part_code').show();
			fn_get_partcode_list('','list_at_po');
			
		}else{
			$('#'+form_add_attention_tag+' #po_no').show();
			$('#'+form_add_attention_tag+' #part_code').hide();
			fn_get_po_list('','list_at_po');
		}
	});
	$('#'+form_add_attention_tag+' input[name="part_po"]').change(function(e){
		e.preventDefault();
		var current_value = $(this).val();
		var search_type = '';
		$('#'+form_add_attention_tag+' input[name="radio_type_search"]').each(function(){
			if($(this).prop('checked')){
				search_type = $(this).val();
			}
		});
		if(search_type == 'Parts'){
			var product_id= form_add_attention_tag+' input[name="product"]';
			fn_get_partname_place_in_input(current_value,product_id);
		}else{
			var model_id= form_add_attention_tag+' input[name="model"]';
			fn_get_devicename_by_po(current_value,model_id);
		}
	});

	$('#'+form_view_attention_tag+' input[name="category"]').click(function(e){
		$('#'+form_view_attention_tag+' input[name="category"]').each(function(){
			if($(this).prop('checked')){
				var current_value = $(this).val();
				console.log(current_value);
			}
		});
	});
	$('#'+form_add_attention_tag+' input[name="category"]').click(function(e){
		$('#'+form_add_attention_tag+' input[name="category"]').each(function(){
			if($(this).prop('checked')){
				var current_value = $(this).val();
				console.log(current_value);
			}
		});
	});
	function get_control_number(){
		var data = {
			"action"	: "generate_at_control_number_view",
			"username"	: username
		}
		call_ajax(data,handler_qfr,function(result){
			
			$('#'+form_add_attention_tag+' input[name="control_number"]').val(result);
		});
	}
	$('#'+form_add_attention_tag).submit(function(e){
		e.preventDefault();
		var serialized_data = new FormData(this);
		// if(fn_validate_checked_by(form_add_attention_tag,'issuance_by')){
			serialized_data.append('action','save_attention_tag');
			serialized_data.append("username",username);
			fn_save_attention_tag(serialized_data);
			$('.btn').prop("disabled",false);
		// }
	});
	$('#'+form_view_attention_tag).submit(function(e){
		e.preventDefault();
		var serialized_data = new FormData(this);
			serialized_data.append('action','update_attention_tag');
			serialized_data.append("username",username);
			fn_update_attention_tag(serialized_data);
	});

	function fn_save_attention_tag(serialized_data){
		$.ajax({
			data	: serialized_data, 			// Data sent to server, a set of key/value pairs (i.e. form fields and values)
			contentType: false,       		// The content type used when sending data to the server.
			cache: false,             		// To unable request pages to be cached
			processData:false,        		// To send DOMDocument or non processed data file it is set to false
			success: function (response) {
				// console.log(response);
				dt_tbl_attention_tag.draw();
				$('#modal_add_attention_tag').modal('hide');
				notif_success('Saved Successfully');
			}
		});
	}
	function fn_load_at_info(pkid,mode){
		data = {
			'action':'load_at_info',
			'pkid':pkid
		};
		data = $.param(data);
		$.ajax({
			data: data,
			success: function (response) {
				var pkid = response['pkid']
				var parts_po = response['parts_po'];
				var category = response['category'];
				if(parts_po == 'Parts'){
					$('#'+form_view_attention_tag+' #radio_parts').prop('checked',true);
					$('#'+form_view_attention_tag+' #part_po').val(response['part_code']);
				}else{
					$('#'+form_view_attention_tag+' #radio_po').prop('checked',true);
					$('#'+form_view_attention_tag+' #part_po').val(response['po_number']);
				}
				if(category == 'Material'){
					$('#'+form_view_attention_tag+' #radio1').prop('checked',true);
				}
				else if (category == 'Workmanship'){
					$('#'+form_view_attention_tag+' #radio2').prop('checked',true);
				}
				else if (category == 'Machine'){
					$('#'+form_view_attention_tag+' #radio3').prop('checked',true);
				}
				else if (category == 'Others'){
					$('#'+form_view_attention_tag+' #radio4').prop('checked',true);
				}
				$('#'+form_view_attention_tag+' input[name="pkid"]').val(response['pkid']);
				$('#'+form_view_attention_tag+' #file_chkbox').prop('checked',false);
				$('#'+form_view_attention_tag+' #btn_selected_file').val(pkid);
				$('#'+form_view_attention_tag+' #selected_file').hide();
				$('#'+form_view_attention_tag+' input[name="control_number"]').val(response['control_no']);
				$('#'+form_view_attention_tag+' input[name="product"]').val(response['product']);
				$('#'+form_view_attention_tag+' input[name="model"]').val(response['model']);
				$('#'+form_view_attention_tag+' #selected_file').val('');
				$('#'+form_view_attention_tag+' input[name="input_file_name"]').val(response['file_name']);
				$('#'+form_view_attention_tag+' input[name="date"]').val(response['date']);
				$('#'+form_view_attention_tag+' input[name="lot_no"]').val(response['lot_number']);
				$('#'+form_view_attention_tag+' input[name="quantity"]').val(response['quantity']);
				$('#'+form_view_attention_tag+' textarea[name="description"]').val(response['description']);
				$('#'+form_view_attention_tag+' textarea[name="remarks"]').val(response['remarks']);
				assign_value_select2('#form_view_attention_tag #issuance_by',response['issuance_by']);
				re_initialize_select2_server_side('#modal_view_attention_tag #issuance_by','#modal_view_attention_tag #form_view_attention_tag',[],"server_side_scripts/dropdown/common/dd_rapid_hris_and_subcon_list.php");
				
				if(mode == 'view'){
					$('#'+form_view_attention_tag+' input').prop('disabled',true);
					$('#'+form_view_attention_tag+' select').prop('disabled',true);
					$('#'+form_view_attention_tag+' textarea').prop('disabled',true);
					$('#'+form_view_attention_tag+' textarea').prop('disabled',true);
					$('#'+form_view_attention_tag+' #btn_save').hide('fast');

				}else if(mode == 'edit'){
					$('#'+form_view_attention_tag+' input').prop('disabled',false);
					$('#'+form_view_attention_tag+' select').prop('disabled',false);
					$('#'+form_view_attention_tag+' textarea').prop('disabled',false);
					$('#'+form_view_attention_tag+' textarea').prop('disabled',false);
					$('#'+form_view_attention_tag+' #btn_save').show('fast');
				}

				$('#'+form_at_cancel+' input[name="pkid"]').val(pkid);
				
			}
		});
	}
	function fn_update_attention_tag(serialized_data){
		$.ajax({
			data	: serialized_data, 			// Data sent to server, a set of key/value pairs (i.e. form fields and values)
			contentType: false,       		// The content type used when sending data to the server.
			cache: false,             		// To unable request pages to be cached
			processData:false,        		// To send DOMDocument or non processed data file it is set to false
			success: function (response) {
				dt_tbl_attention_tag.draw();
				$('#modal_view_attention_tag').modal('hide');
				notif_success('Updated Successfully');
			}
		});
	}
	function fn_cancel_attention_tag(serialized_data){
		// console.log(data_serialized);
		$.ajax({
			data	: serialized_data, 			// Data sent to server, a set of key/value pairs (i.e. form fields and values)
			contentType: false,       		// The content type used when sending data to the server.
			cache: false,             		// To unable request pages to be cached
			processData:false,        		// To send DOMDocument or non processed data file it is set to false
			success: function (response) {
				console.log('deleted');
				dt_tbl_attention_tag.draw();
				$('#modal_at_cancel').modal('hide');
				notif_info('Deleted Successfully');
			}
		});

	}

}); //endDocReady
/* ***************************
	Attention Tag - End
/****************************/

/** 
 * TODO: Empty Values
*/ 
function fn_empty_at_fields(form_id){
    $('#'+form_id+ ' select').val('');
    $('#'+form_id+' select#issuance_by').empty();
    $('#'+form_id+ ' input[type="text"]').val('');
    $('#'+form_id+ ' input[type="file"]').val('');
    $('#'+form_id+ ' input[type="date"]').val('');
    $('#'+form_id+ ' textarea').val('');
    $('#'+form_id+ ' input[name="radio_type_search"]').prop('checked',false);
    $('#'+form_id+ ' input[name="category"]').prop('checked',false);

}

/**
 * !Toaster Notification
 */
 function notif_success(data) {
    notif({
        type: "success",
        msg: "<b>Success:</b> " + data,
        type: "success",
        position: "right",
        timeout: 3000
    });
}

function notif_warning(data) {
    notif({
        type: "warning",
        msg: "<b>Warning:</b> " + data,
        position: "right",
        timeout: 3000
    });
}

function notif_info(data) {
    notif({
        type: "info",
        msg: "<b>Info:</b> " + data,
        position: "right",
        timeout: 3000
    });
}

function notif_err(data) {
    notif({
        type: "error",
        msg: "<b>Error:</b> " + data,
        position: "right",
        timeout: 3000
    });
}