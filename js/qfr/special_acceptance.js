/* ***************************
	Special Acceptance - Start 
/****************************/

/** 
	* !REMOVE MULTIPLE APPROVERS & RESET THE ORDER*
	* $('#tbl_approver tbody').on
	* $('#tbl_approver_view tbody').on

	* !Add Multiple Approver 
	* $('#btn_add_approver').click
	* $('#edit_btn_add_approver').click

	* !FUNCTION LIST FOR MULTI APPROVERS*
	* default_approver_input
	* reorder_approvers
	* get_last_row_index
	* append_approver_table_view
*/

/**
	 * $('#tbl_special_acceptance tbody').on
	 * $('#frm_sa_edit a[id="uploaded_file').click
	 * $('#frm_sa_edit select[name="category"]').change
	 * $('#frm_sa select[name="category"]').change
	 * $('#column_coordinate,#edit_column_coordinate').keyup

	* $('#tbl_approver tbody').on('click','#btn_remove', function()
	* $('#tbl_approver_view tbody').on('click','#btn_remove', function()
	* $('#frm_sa_edit input[name="po_number"]').keyup(function(e)
	* $('#frm_sa_edit  input[name="po_number"]').change
	* $('#frm_sa input[name="po_number"]').keyup
	* $('#frm_sa input[name="po_number"]').change
	* $('#frm_sa_edit input[name="part_code"]').keyup
	* $('#frm_sa_edit input[name="part_code"]').change
	* $('#frm_sa input[name="part_code"]').keyup
	* $('#frm_sa input[name="part_code"]').change
	* $('#btn_report_ordinates').click

	* $('#frm_sa_edit #replace_file').click
	* $('#frm_sa_replace_file').submit
	* $('#frm_sa_edit .fa-thumbs-o-up')
	* $('#frm_sa_edit .fa-thumbs-o-down').click
	* $('#frm_sa_approvers_decisions').on('submit'
	* $('#frm_sa_edit .main_approve').click
	* $('#frm_sa_edit .main_disapprove').click
	* $('#frm_sa_main_approvers_decisions').on('submit'
	* 
	* $('#btn_sa').click
	* 
	* $('#frm_sa').submit
	* $('#frm_sa_edit').submit
	* $('#frm_sa_cancel').submit
	* 
	* function fn_save_special_acceptance
	* function default_approver_input
	* function reorder_approvers
	* function get_last_row_index
	* function append_approver_table_view
	* function fn_sa_replace_file
	* function fn_edit_special_acceptance
	* function fn_cancel_special_acceptance
	* function fn_empty_sa_fields select[name="category"]
	* function fn_load_special_acceptance
	* function fn_sa_hide_text_fields
	* function fn_generate_sa_control_number_view
*/ 
var pkid	 = [];
var frm_sa_for_revision = 'frm_sa_for_revision';
var frm_sa_for_qc_checking = 'frm_sa_for_qc_checking'; //fmodifynow
var tbl_special_acceptance_disposition ='tbl_special_acceptance_disposition';
var tbl_special_acceptance_with_treatment ='tbl_special_acceptance_with_treatment';
var tbl_special_acceptance_approval = 'tbl_special_acceptance_approval';
$(document).ready(function(){

	
	var dt_special_acceptance = $('#tbl_special_acceptance').DataTable({
		"aaSorting"	: [],
		"bProcessing": true,
        "bServerSide": true,
		"sAjaxSource": "server_side_scripts/qr/dt_sa.php?username="+username,
		"drawCallback": function( settings ) {
			$('#tbl_special_acceptance').attr('style','width:100%;');
		}
	});

	$('#tbl_special_acceptance tbody').on('click', 'tr .fa-search', function(){//fmodifynow
		var pkid = this.id;
		fn_load_special_acceptance(pkid); //modifynow
			
		$('#'+frm_sa_for_qc_checking+ ' input[name="status"]').prop('checked',false);
		$('#'+frm_sa_for_qc_checking+ ' textarea[name="remarks"]').val('');
		$('#'+frm_sa_for_qc_checking+' .fa-save').prop('disabled',true);
		$('#modal_for_qc_checking').modal();
		// frm_sa_for_qc_checking 
	});
	
	/* view or edit special acceptance */
	$('#tbl_special_acceptance tbody').on('click', 'tr .fa-edit', function(){
		row_count = 1;
		$('#modal_sa_edit').data('id',this.id);
		$('#modal_sa_edit').modal({backdrop: 'static',
		keyboard: false},'show');
		$('#btn_ng_disapprove ').hide();
		$('#btn_ng_approve ').hide();
		$('#tbl_approver_view tbody').empty();
		// $('#tbl_approver_view tbody,#frm_sa_edit #btn_remove').prop('disabled',true);
		$('#modal_sa_edit #is_replace_file_closed').show(); //nmodify
		$('#edit_btn_add_approver').prop('disabled',false);
		$('#modal_sa_edit #container_upload_sa_message').hide();
		var html ;
			html = '<h4>Updating the details or Re-uploading of file  will reset the approval history (from approved to pending).';
			html += ' Please always save your report.</h4>';
		$('#container_upload_sa_message').empty().append(html);
		$('#container_upload_sa_message').show();
		fn_load_special_acceptance(this.id,'edit');
	});
	$('#tbl_special_acceptance tbody').on('click', 'tr .fa-plus', function(){
		var pkid = this.id;
		$('#modal_sa_edit').data('id',pkid);
		$('#modal_sa_edit').modal({backdrop: 'static',
		keyboard: false},'show');
		fn_load_special_acceptance(pkid,'view');
	});
	$('#tbl_special_acceptance tbody').on('click', 'tr .fa-refresh', function(){
		var pkid = this.id;
		fn_load_special_acceptance(pkid);
	
		$('#modal_for_revision').modal('show');
	});
	$('#'+frm_sa_for_qc_checking).submit(function(e){ 
		e.preventDefault();
		data = {
			'action' : 'sa_qc_approvers_decision',
			'username' : username
		}
		serialized_data = $(this).serialize();
		call_ajax_serialize(data,serialized_data,handler_qfr,function(result){
			$('#modal_for_qc_checking').modal('hide');
			dt_special_acceptance.draw();
			//appoved then change the status
		});
	});
	$('#'+frm_sa_for_qc_checking+' input[name="status"]').click(function(e){
		$('#'+frm_sa_for_qc_checking+' .fa-save').prop('disabled',false);
	});

	$('#'+frm_sa_for_revision).submit(function (e) { 
		e.preventDefault();
		data = {
			'action' : 'save_sa_for_revision',
			'username' : username
		};
		serialized_data = $(this).serialize();
		call_ajax_serialize(data,serialized_data,handler_qfr,function(result){
			dt_special_acceptance.draw();
			$('#modal_for_revision').modal('hide');
		});
	});
	$('#tbl_special_acceptance tbody').on('click', 'tr .fa-eye', function(){
		var pkid = this.id;
		var current_status 	= $(this).closest('tr').find('td:eq(0)').text();
		$('#modal_sa_edit').modal('show');
		$('#modal_sa_edit').data('id',pkid);
		$('#tbl_approver_view tbody').empty();
		$('#edit_btn_add_approver').prop('disabled',false);
		$('#modal_sa_edit #container_upload_sa_message').hide();
		fn_load_special_acceptance(pkid,'view',current_status);
	});
	$('#tbl_special_acceptance tbody').on('click', 'tr a#a_download_excel', function(){
		var pkid = $(this).data('id');
		var current_status 	= $(this).closest('tr').find('td:eq(0)').text(); /** find the table column 1 */
			window.location.href = "reports/excel_qfr_sa_common_download.php?id="+pkid; //newcommon
	});
	$('#tbl_special_acceptance tbody').on('click', 'tr .fa-remove', function(){
		var parts_and_prod_details = $(this).closest('tr').find('td:eq(1)').text();
		$('#frm_sa_cancel #label_info').text(parts_and_prod_details);
		$('#modal_sa_cancel').data('id',this.id);
		$('#modal_sa_cancel').modal('show');
	});

	
	

	$('#frm_sa select[name="category"]').change(function(){
		var category = $(this).val();
		fn_sa_hide_text_fields('frm_sa',category);
	});	
	$('#column_coordinate,#edit_column_coordinate').keyup(function () { 
		$(this).val($(this).val().toUpperCase());
	});
	$('#btn_sa').click(function(){
		fn_generate_sa_control_number_view();
		$('#modal_save_sa_control_num').modal({backdrop: 'static',
		keyboard: false},'show');
	});
	
	$('#frm_sa input[name="part_code"]').keyup(function(e){
		var key = e.which;
		if(key == 38 || key == 40){
			return false;
		}
		var pattern = $(this).val();
		fn_get_partcode_list(pattern,'list_sa_part_code');
	});
	$('#frm_sa input[name="part_code"]').change(function(e){
		var code = $(this).val();
		console.log(code);

		fn_get_partname(code,'frm_sa');
	});

	$('#frm_sa input[name="po_number"]').keyup(function(e){
		var key = e.which;
		if(key == 38 || key == 40){
			return false;
		}
		var pattern = $(this).val();
		fn_get_po_list(pattern,'list_sa_po');
	});
	$('#frm_sa input[name="po_number"]').change(function(e){
		var po_number = $(this).val();
		console.log(po_number);

		var array_fields = [
			'input[name="device_name"]',
			'input[name="po_qty"]',
			'input[name="drawing_number"]',
			'input[name="customer_name"]'
		]
		fn_get_po_details(po_number,'frm_sa',array_fields);
	});

	$('#btn_report_ordinates').click(function(){
		$('#modal_report_ordinates').modal('show');
	});

	$('#frm_sa').submit(function(e){
		e.preventDefault();
		$('.btn').prop("disabled",true);
		var form_data = new FormData(this);

		form_data.append("action","save_special_acceptance");
		form_data.append("pkid",$('#modal_sa').data('id'));
		form_data.append("upload_type","new");
		form_data.append("username",username);
		fn_save_special_acceptance(form_data);
		$('.btn').prop("disabled",false);
	});

	

	$('#frm_sa_approvers_decisions').on('submit', function(e) {
		e.preventDefault();
		pkid= this.id;
		decision = 	container_approver_message.attr('class');
		if(decision == 'alert alert-success') {
			var status = 'APPROVED';
		} else if(decision == 'alert alert-danger') {
			var status = 'DISAPPROVED';
		} 
		var serialized_data = new FormData(this);
			serialized_data.append("action","sa_approver_decision");
			serialized_data.append("pkid",$('#modal_sa_edit').data('id'));
			serialized_data.append("status",status);
			serialized_data.append("username",username);
			getApproverDecision(serialized_data);
			notif_info('Approver`s Decision has been Saved !');
	});

	/* NOTE : fdecision */
	decisions_container_approver_message = $('#frm_sa_main_approvers_decisions #container_approver_messages');
	
	$('#frm_sa_main_approvers_decisions').on('submit', function(e) {
		e.preventDefault();
		pkid= this.id;
		decision = 	decisions_container_approver_message.attr('class');
		if(decision == 'alert alert-success') {
			var status = 'APPROVED';
		} else if(decision == 'alert alert-danger') {
			var status = 'DISAPPROVED';
		} 
		var serialized_data = new FormData(this);
			serialized_data.append("action","sa_main_approver_decision");
			serialized_data.append("pkid",$('#modal_sa_edit').data('id'));
			serialized_data.append("status",status);
			serialized_data.append("username",username);
			getMainApproverDecision(serialized_data);
			notif_info('Approver`s Decision has been Saved !');
	});
	$('#frm_sa_cancel').submit(function(e){
		e.preventDefault();
		var serialized_data = $(this).serialize();
		fn_cancel_special_acceptance(serialized_data);
	});

	function fn_save_special_acceptance(form_data){
		$.ajax({
			url		: handler_qfr, 		// Url to which the request is send
			type	: "POST",           	// Type of request to be send, called as method
			dataType: "JSON",           	// Type of request to be send, called as method
			data	: form_data, 			// Data sent to server, a set of key/value pairs (i.e. form fields and values)
			contentType: false,       		// The content type used when sending data to the server.
			cache: false,             		// To unable request pages to be cached
			processData:false,        		// To send DOMDocument or non processed data file it is set to false
			success: function(result){  	// A function to be called if request succeeds
				/* $('#modal_sa #supplier').val(null).trigger('change');*/
			
				if( result.is_success === 'true'){
					console.log(result.message); //omodify
					notif_success(result.message);
					$('#modal_sa #judged_by_approver').val(null).trigger('change');
					$('#modal_sa').modal('hide');
					dt_special_acceptance.draw();
					dt_special_acceptance_disposition.draw();
					dt_special_acceptance_with_treatment.draw();
					notif_success('Saved Successfully !');
				}
				
			},error	: function(result){

			}
		});
	}
 
	function fn_sa_replace_file(form_data){
		$.ajax({
			url		: handler_qfr, 		// Url to which the request is send
			type	: "POST",           	// Type of request to be send, called as method
			dataType: "JSON",           	// Type of request to be send, called as method
			data	: form_data, 			// Data sent to server, a set of key/value pairs (i.e. form fields and values)
			contentType: false,       		// The content type used when sending data to the server.
			cache: false,             		// To unable request pages to be cached
			processData:false,        		// To send DOMDocument or non processed data file it is set to false
			success: function(result){  	// A function to be called if request succeeds
				if(result['result']===1){
					$('#modal_sa_replace_file input').val('');
					$('#modal_sa_replace_file').modal('hide');
					fn_load_special_acceptance($('#modal_sa_edit').data('id'),'edit');
					$('#modal_sa_edit #is_replace_file_closed').hide(); //nmodify
					reorder_approvers('tbl_approver_view');
					notif_success('File has been Updated !')
				}else{
					notif_err(result['error_msg'])
				}
			},error	: function(result){
				notif_err(result)
			}
		});
	}
	function fn_edit_special_acceptance(form_data){
		call_ajax_attachment(form_data, handler_qfr, function(result){
			var modal_system_message_id = "modal_sa_system_message";
			
				$('.modal').modal('hide');
				fn_system_message_timer(modal_system_message_id);
				dt_special_acceptance.draw();
				dt_special_acceptance_disposition.draw();
				dt_special_acceptance_with_treatment.draw();
				notif_success('Updated Successfully !');
		});
	}
	function fn_cancel_special_acceptance(serialized_data){
		var data = {
			"action"	: "cancel_special_acceptance",
			"pkid"		: $('#modal_sa_cancel').data('id'),
			"username"	: username
		}
		call_ajax_serialize(data, serialized_data,handler_qfr, function(result){
			//
			$('#modal_sa_cancel').modal('hide');
			dt_special_acceptance.draw();
			dt_special_acceptance_disposition.draw();
			dt_special_acceptance_with_treatment.draw();
		});
	}
	function fn_empty_sa_fields(frm_id){
		$('#'+frm_id+' #container_disposition').hide();
		$('#'+frm_id+' #container_disposition select,#frm_sa #container_disposition input').prop('required',false);
		$('#'+frm_id+' .alert').hide();
		$('#'+frm_id+' .alert').text('');
		$('#'+frm_id+' .alert').attr('class','alert alert-danger');
		$('#'+frm_id+' input').val('');
		$('#'+frm_id+' select').val('');
		$("#tbl_approver").find("tr:gt(0)").remove();
		$('#btn_add_approver').prop('disabled',false);
	}
	function fn_load_special_acceptance(pkid,mode,current_status){
		var data = {
			"action"	: "load_special_acceptance",
			"pkid"		: pkid,
			"username"	: username
		}
		call_ajax(data, handler_qfr, function(result){
			fn_sa_hide_text_fields('frm_sa',result['category'],'edit');
			$('#frm_sa_for_revision #pkid').val(result['pkid']);
			$('#frm_send_report_internal_sa #txt_control_number').val(result['control_number']).prop('readonly',true);
			$('#modal_for_qc_checking #pkid, #modal_for_qc_checking #frm_sa_for_qc_checking').val(result['pkid']);
		
			$('#frm_sa').find('[name="special_acceptance_id"]').val(pkid);
			$('#frm_sa').find('[name="control_number"]').val(result['control_number']);
			$('#frm_sa').find('select[name="category"]').val(result['category']);
			$('#frm_sa #badge_status').html(result['status']);
			$('#frm_sa').find('textarea[name="other_details"]').text(result['other_details']);
			$('#frm_sa').find('[name="factory_location"]').val(result['factory_location']);
			$('#frm_sa').find('[name="problem"]').val(result['problem']);
			$('#frm_sa').find('[name="date_issued"]').val(result['date_issued']);
			$('#frm_sa').find('[name="immediate_action"]').val(result['immediate_action']);
			$('#frm_sa').find('[name="permanent_action"]').val(result['permanent_action']);
			$('#frm_sa').find('[name="immediate_action_due_date"]').val(result['immediate_action_due_date']);
			$('#frm_sa').find('[name="permanent_action_due_date"]').val(result['permanent_action_due_date']);
			if(result['category'] == 'Parts'){
				$('#frm_sa').find('[name="part_code"]').val(result['part_code']);
				$('#frm_sa').find('[name="parts_affected_parts"]').val(result['parts_affected_parts']);
				$('#frm_sa').find('[name="supplier"]').val(result['supplier']);
				$('#frm_sa').find('[name="quantity"]').val(result['quantity']);
			}else{
				$('#frm_sa').find('[name="po_number"]').val(result['po_number']);
				$('#frm_sa').find('[name="po_qty"]').val(result['po_qty']);
				$('#frm_sa').find('[name="device_name"]').val(result['device_name']);
				$('#frm_sa').find('[name="parts_affected_device"]').val(result['parts_affected_device']);
				$('#frm_sa').find('[name="customer_name"]').val(result['customer_name']);
			}
			
			re_initialize_select2_server_side('#modal_sa #supplier','#modal_sa #frm_sa',[],"server_side_scripts/dropdown/qfr/dd_sar_supplier_list.php");
			fn_get_supplier_by_pkid(result['pkid'],'edit');
			
			if(mode == 'edit'){
				$('#frm_sa .fa-save').show();
			}
			else if(mode == 'view'){
				$('#frm_sa .fa-save').hide();
			}
		});
	}

	function fn_sa_hide_text_fields(frm_id,category,mode=null){
		/* hide containers for parts and device */
		$('#'+frm_id+' #container_parts').hide();
		$('#'+frm_id+' #container_device').hide();
		$('#'+frm_id+' #container_parts select, #'+frm_id+' #container_parts input').prop('required',false);
		$('#'+frm_id+' #container_device select, #'+frm_id+' #container_device input').prop('required',false);
		if(category == 'Parts'){
			/* display parts container */
			$('#'+frm_id+' #container_parts').show();
			$('#'+frm_id+' #container_parts select, #'+frm_id+' #container_parts input').prop('required',true);
			$('#'+frm_id+' #container_device input').val('');
	
		}else if(category == 'Device'){
			/* display device container */
			$('#'+frm_id+' #container_device').show();
			$('#'+frm_id+' #container_device select, #'+frm_id+' #container_device input').prop('required',true);
			$('#'+frm_id+' #container_parts input').val('');
		}
		if(mode == null){
			$('#'+frm_id+' #global_input_field input').val('N/A');
			$('#'+frm_id+' textarea').text('N/A');
		}
	}
	function fn_generate_sa_control_number_view(){
		var data = {
			"action"	: "generate_sa_control_number_view",
			"username"	: username
		}
		call_ajax(data,handler_qfr,function(result){
			$('#frm_sa  input[name="control_number"]').val(result);
			$('#form_save_sa_control_num  input[name="control_number"]').val(result);
			
		});
	}
	/* ************************************** 
		Start - Advanced Search 
	************************************** */
	var global_sa_as_where		 		= '';
	var sa_as_select_ctr				= 1;
	
	$('#btn_sa_advanced_search').click(function(){
		if( global_sa_as_where == ""){
			$('#tbl_sa_advance_search tbody').empty();
			fn_sa_as_draw_row('cmb_sa_as_field0');
			fn_sa_return_visual_inspection_fields('cmb_sa_as_field0');
		}
		$('#modal_sa_advance_search').modal('show');
	});
	
	$('#frm_sa_advance_search #btn_sa_as_add').click(function() {
		sa_as_select_ctr++;
		var select_id = 'cmb_sa_as_field'+sa_as_select_ctr;
		fn_sa_as_draw_row(select_id);
		fn_sa_return_visual_inspection_fields(select_id);
	});
	
	$('#frm_sa_advance_search #btn_sa_as_reset').click(function() {
		global_sa_as_where = '';
		$('#tbl_sa_advance_search tbody').empty();
		fn_sa_as_draw_row('cmb_sa_as_field0');
		fn_sa_return_visual_inspection_fields('cmb_sa_as_field0');
		dt_special_acceptance.ajax.url("server_side_scripts/qr/dt_sa.php?username="+username+"&wh="+global_sa_as_where).load();
	});
	
	$('#frm_sa_advance_search').on('submit', function(e) {
		e.preventDefault();
		var serialized_data = $(this).serialize();
		fn_sa_advance_search(serialized_data);
		$('#modal_sa_advance_search').modal('hide');
		vir_as_select_ctr = 0;
	});

	/* change the input type once date is selected */
	$('#tbl_sa_advance_search tbody').on('change', 'select[name="field_name[]"]', function(){
		var select_value = $(this).val();
		var selected_row = $(this).closest('tr');
		var row_index 	= selected_row.index();
		if(select_value == "shipment_date" || select_value == "date_created"){
			selected_row.find('td:eq(2)').html('<input type="text" class="form-control ui-datepicker" name="val[]" id="txt_date_range" placeholder="Click to add date" required readonly>');
			selected_row.find('td:eq(1) select').empty();
			selected_row.find('td:eq(1) select').append('<option value="BETWEEN">BETWEEN</option>');
			date_time_picker('tbl_sa_advance_search tr:eq('+row_index+') #txt_date_range');
		}else{
			selected_row.find('td:eq(2)').html('<input type="text" id="cmb_sa_as_value" name="val[]" class="form-control condensed" required>');
			selected_row.find('td:eq(1) select').empty();
			selected_row.find('td:eq(1) select').append('<option value="EQUALS"> EQUALS </option>');
			selected_row.find('td:eq(1) select').append('<option value="LIKE"> CONTAINS </option>');
		}
	});

	$('#tbl_sa_advance_search tbody').on('click', 'button[type="button"]', function() {
		$(this).closest('tr').remove();
		return false;
	});
	
	function fn_sa_as_draw_row(select_id){
		var row  = '<tr>';
			row += '	<td style="width:30%;">';
			row += '		<select id="'+select_id+'" name="field_name[]" class="form-control condensed" required>';
			row += '		</select>';
			row += '	</td>';
			row += '	<td style="width:20%;">';
			row += '		<select id="cmb_sa_as_condition" name="condition[]" class="form-control condensed" required>';
			row += '			<option value="EQUALS"> EQUALS </option>';
			row += '			<option value="LIKE"> CONTAINS </option>';
			row += '		</select>';
			row += '	</td>';
			row += '	<td style="width:40%;">';
			row += '		<input type="text" id="cmb_sa_as_value" name="val[]" class="form-control condensed" required>';
			row += '	</td>';
			row += '	<td style="width:10%;">';
			row += '		<button type="button" id="btn_sa_as_remove" class="btn btn-default fa fa-trash"> Remove</button>';
			row += '	</td>';
			row += '</tr>';
		$('#tbl_sa_advance_search tbody').append(row);
	}

	function fn_sa_return_visual_inspection_fields(select_id){
		var data = {
			"action"	: "qfr_return_sa_fields"
		}
		call_ajax(data, handler_qfr, function(result){	
			for(var i=0; i < result['ctr']; i++) {
				$('#'+select_id).append(result['option'][i]);
			}
		});
	}

	function fn_sa_advance_search(serialized_data) {
		var data = {
			"action"	: "sa_advance_search"
		}
		call_ajax_serialize(data, serialized_data, handler_qfr, function(result){	
			//
			global_sa_as_where = encodeURIComponent(result['sql_where']);
			dt_special_acceptance.ajax.url("server_side_scripts/qr/dt_sa.php?username="+username+"&wh="+global_sa_as_where).load();
		});
	}

	
	
	function getApproverDecision(serialized_data){
		$.ajax({
			type: "POST",
			url: handler_qfr,
			data: serialized_data,
			dataType: "json",
			contentType: false,       		// The content type used when sending data to the server.
			cache: false,             		// To unable request pages to be cached
			processData:false,        	
			success: function (result) {
				$('#modal_approver_messages').modal('hide');
				$('#modal_sa_edit').modal('hide');
				dt_special_acceptance.draw();
				dt_special_acceptance_disposition.draw();
				dt_special_acceptance_with_treatment.draw();
			}
		});
	}
	function getMainApproverDecision(serialized_data){
		$.ajax({
			type: "POST",
			url: handler_qfr,
			data: serialized_data,
			dataType: "json",
			contentType: false,       	// The content type used when sending data to the server.
			cache: false,             	// To unable request pages to be cached
			processData:false,     
			success: function (result) {
				$('#modal_main_approver_messages').modal('hide');
				$('#modal_sa_edit').modal('hide');
				dt_special_acceptance.draw();
				dt_special_acceptance_disposition.draw();
				dt_special_acceptance_with_treatment.draw();
			}
		});
	}

	/* *********
		End 
	**********/

	/* ***************************
		!Special Acceptance - For Disposition
	/****************************/ //NOTE : fdisposition
	var dt_special_acceptance_disposition = $('#'+tbl_special_acceptance_disposition).DataTable({
		"aaSorting"	: [],
		"bProcessing": true,
        "bServerSide": true,
		"sAjaxSource": "server_side_scripts/qr/dt_sa_disposition.php?username="+username,
		"drawCallback": function( settings ) {
			$('#'+tbl_special_acceptance_disposition).attr('style','width:100%;');
		}
	});


	$('#tbl_view_attachments_sa tbody').on('click','tr .without_signature', function () {
		let id = $(this).attr('id');
		window.location.href = "reports/excel_qfr_sa_common_download.php?id="+id; //nmodify
	});

	$('#'+tbl_special_acceptance_disposition+' tbody').on('click','tr .fa-plus',function(){
		pkid = this.id;
		html = '<option value="" selected disabled>-Select Disposition-</option>';
		$('#frm_sa_add_disposition #disposition').html(html);
		getSentDetails('frm_sa_add_disposition',pkid);
		fn_get_disposition_list('frm_sa_add_disposition');
		fn_empty_sa_fields('frm_sa_add_disposition');
		$('#modal_sa_add_disposition').modal('show');
		$('#frm_sa_add_disposition #container_sa_disposition').show();
		
	});

	$('#'+tbl_special_acceptance_disposition +' tbody').on('click', 'tr .fa-eye', function(){ //nmodify $('#modal_sa')
		$('#modal_sa').data('id',this.id);
		$('#modal_sa').modal({backdrop: 'static',
		keyboard: false},'show');
		fn_load_special_acceptance(this.id,'view');
	});
	$('#'+tbl_special_acceptance_disposition +' tbody').on('click', 'tr .fa-edit', function(){
		
		$('#modal_sa').data('id',this.id);
		$('#modal_sa').modal({backdrop: 'static',
		keyboard: false},'show');
		fn_load_special_acceptance(this.id,'edit');
	});
	/*NOTE : fdisposition fetch all External and Internal Recipients  - PMI and Suppliers */
	$('#'+tbl_special_acceptance_disposition+' tbody').on('click','tr .fa-send-o', function() {
		fn_empty_sa_fields('frm_send_report_internal_sa');
		pkid = this.id;
	/* fetch the control number */
		fn_load_special_acceptance(pkid);
		$('#modal_send_supplier_sa').data('id',pkid);
		$('#frm_send_report_internal_sa #cmb_sa_send_external_to').val(null).trigger('change');
		$('#frm_send_report_internal_sa #cmb_sa_send_external_cc').val(null).trigger('change');
	/* function that get the email recipeients */	
		fn_get_supplier_by_pkid(pkid); 
		$('#frm_send_report_internal_sa #container_cmb_sa_send_external_cc').hide(); /** NOTE: External CC for Special Acceptance Report */
		$('#modal_send_supplier_sa').modal('show');
	});
	$('#'+tbl_special_acceptance_disposition+' tbody').on('click', 'tr .fa-remove', function(){
		var parts_and_prod_details = $(this).closest('tr').find('td:eq(1)').text();
		$('#frm_sa_cancel #label_info').text(parts_and_prod_details);
		$('#modal_sa_cancel').data('id',this.id);
		$('#modal_sa_cancel').modal('show');
	});

	/** MODAL TBL WITH DOWNLOAD ATTACHMENT */
	$('#tbl_view_attachments_sa tbody').on('click','tr .fa-paperclip', function () {
		var id = $(this).attr('id');
		var key_id = $(this).attr('key-id');
		var file_name = $(this).attr('file-name');
		window.location.href = "reports/excel_qfr_sa_for_disposition_download.php?id="+id+"&key_id="+key_id+"&file_name="+file_name;
	});
	$('#tbl_view_attachments_sa tbody').on('click','tr .fa-files-o', function () {
		var id = $(this).attr('id');
		window.location.href = "reports/excel_qfr_sa_report_download.php?id="+id; //new
		console.log(id);
	});
	$('#frm_sa_add_disposition #status').click(function (e) { 
		e.preventDefault();
		var status = $(this).val();
		fn_disposition_fields(status,'frm_sa_add_disposition');
	});
	
	$('#frm_send_report_internal_sa #supplier').change(function() {
		fn_get_supplier_email_address($(this).val(), 'recipients_to', 'cmb_sa_send_external_to');
		fn_get_supplier_email_address($(this).val(), 'recipients_cc', 'cmb_sa_send_external_cc');
	});

	$('#frm_sa_add_disposition #disposition').change(function (e) { 
		e.preventDefault();
		var disposition = $('#frm_sa_add_disposition #disposition').val();
		if(disposition == 'APPROVED'){
			$('#frm_sa_add_disposition #container_result').show();
			$('#frm_sa_add_disposition 	#disposition_remarks').show();
		}else{
			$('#frm_sa_add_disposition #container_result').hide();
		}
	});
	
	$('#frm_send_report_internal_sa').submit(function (e) { 
		e.preventDefault();
		
		$('#cmb_sa_send_external_to').prop("disabled",false);
		$('#cmb_sa_send_external_cc').prop("disabled",false);
		var  serialized_data = new FormData(this);
			 serialized_data.append("action","send_email_for_disposition");
			 serialized_data.append("control_number",$('#frm_send_report_internal_sa #txt_control_number').val());
			 serialized_data.append("pkid",$('#modal_send_supplier_sa').data('id'));
			 serialized_data.append("username",username);
		call_ajax_attachment(serialized_data, handler_qfr, function(result){
			// console.log(result);
			// return;
			$('#modal_send_supplier_sa').modal('hide');
			dt_special_acceptance_disposition.draw();
			dt_special_acceptance_with_treatment.draw();
			notif_info('Email Sent !');
		 });
	 });
	$('#frm_sa_add_disposition').submit(function(e){
		e.preventDefault();
		serialized_data = new FormData(this);
		serialized_data.append("action","save_add_disposition");
		serialized_data.append("username",username);
		call_ajax_attachment(serialized_data, handler_qfr, function(result){
			$('#modal_sa_add_disposition').modal('hide');
			dt_special_acceptance_disposition.draw();
			dt_special_acceptance_with_treatment.draw();
			notif_success('Saved Successfully');
		});
	});
	$('#frm_sa_edit_disposition').submit(function(e){
		e.preventDefault();
		serialized_data = new FormData(this);
		serialized_data.append("action","update_sa_disposition");
		serialized_data.append("username",username);
		call_ajax_attachment(serialized_data, handler_qfr, function(result){
			$('#modal_sa_edit_disposition').modal('hide');
			dt_special_acceptance_disposition.draw();
			dt_special_acceptance_with_treatment.draw();
			// notif_success('Saved Successfully');
		});
	});

	/** 
	 * 	FOR DISPOSITION FUNCTION
	 * function fn_disposition_fields
	 * function fn_get_disposition_list
	 * function fn_get_view_attachment
	 * function getTreatment
	 * 
	 * function getSentDetails
	 * function fn_get_supplier_by_pkid
	 * function fn_get_supplier_email_address
	 * function fn_ng_load_email_recipients
	 * function fn_ng_load_email_recipients
	 */
	function fn_disposition_fields(status,frm_id){
		if(status=="APPROVED"){
			$('#' +frm_id + ' #disposition').show('fast').prop('required',true);
			$('#' +frm_id + ' #disposition_remarks').hide('fast').prop('required',false).val('');
		}else if(status=="DISAPPROVED"){ 
			$('#' +frm_id + ' #disposition').hide('fast').prop('required',false).val('');
			$('#' +frm_id + ' #disposition_remarks').show('fast').prop('required',true);
		}
	}
	function fn_get_disposition_list(frm_id){

		var data = {'action': 'get_disposition_list'
					};
		call_ajax(data,handler_qfr,function(result){
			$('#frm_sa_add_disposition #disposition').empty();
			let ctr = result['ctr'];
			let option = `<option value="" disabled selected>-Select disposition-</option>`;
			$('#' + frm_id + ' #disposition').empty().append(option);
			
			for (let i = 0; i< ctr;i++){
				let body = `<option value = "${result['disposition'][i]}" > ${result['disposition'][i]} </option>`;
				$('#' + frm_id + ' #disposition').append(body);
			}
		});
	}
	function fn_get_view_attachment(pkid){
		var data = {
			'action' : 'get_view_attachment',
			'fkid' : pkid
		}
		call_ajax(data,handler_qfr,function(result){
			$('#tbl_view_attachments_sa tbody').empty().append(result);
			$('#modal_attachment_viewer_sa').data('id',pkid);
			$('#modal_attachment_viewer_sa').modal('show');
		});
	}
	function getTreatment(pkid,mode){
		var data = {
			'action' : 'get_treatment',
			'pkid' : pkid
		}
		call_ajax(data,handler_qfr,function(result){
			let status 		  = result['status'];
			let option 		  = `<option value="${result['disposition']}" hidden selected>${result['disposition']}</option>`;
			let status_option = `<option value="${result['status']}" hidden selected>${result['status']}</option>`;

			$('#frm_sa_edit_disposition select[name="disposition"]').prepend(option);
			$('#frm_sa_edit_disposition select[name="status"]').prepend(status_option);
			$('#frm_sa_edit_disposition #disposition_by').val(result['disposition_by']);
			$('#frm_sa_edit_disposition #disposition_date').val(result['disposition_date']);
			$('#frm_sa_edit_disposition #disposition_remarks').val(result['disposition_remarks']);
			$('#frm_sa_edit_disposition #disposition_time').val(result['disposition_time']);

			fn_disposition_fields(status,'frm_sa_edit_disposition'); /** Disposition Fields */

			if(mode == 'view'){
				$('#frm_sa_edit_disposition select[name="disposition"]').prop('disabled',true);
				$('#frm_sa_edit_disposition select[name="status"]').prop('disabled',true);
				$('#frm_sa_edit_disposition #disposition').prop('disabled',true);
				$('#frm_sa_edit_disposition #disposition_by').prop('disabled',true);
				$('#frm_sa_edit_disposition #disposition_date').prop('disabled',true);
				$('#frm_sa_edit_disposition #disposition_remarks').prop('disabled',true);
				$('#frm_sa_edit_disposition #disposition_time').prop('disabled',true);
				$('#frm_sa_edit_disposition #treatment_file').prop('disabled',true);	
			}else{
				$('#frm_sa_edit_disposition select[name="disposition"]').prop('disabled',false);
				$('#frm_sa_edit_disposition select[name="status"]').prop('disabled',false);
				$('#frm_sa_edit_disposition #disposition').prop('disabled',false);
				$('#frm_sa_edit_disposition #disposition_by').prop('disabled',false);
				$('#frm_sa_edit_disposition #disposition_date').prop('disabled',false);
				$('#frm_sa_edit_disposition #disposition_remarks').prop('disabled',false);
				$('#frm_sa_edit_disposition #disposition_time').prop('disabled',false);
				$('#frm_sa_edit_disposition #treatment_file').prop('disabled',false);	
			}
		});
	}
	function getSentDetails(frm_id,pkid){
		data = {
			'action'	: 'get_sent_details',
			'pkid'		: pkid
		}
		$.ajax({
			type: "POST",
			url: handler_qfr,
			data: data,
			dataType: "json",
			success: function (result) {
				var sent_by	= result['sent_by'];
				var date_time_sent	= result['date_time_sent'];
				var remarks	= result['remarks'];

				$('#' + frm_id +' #pkid').val(pkid);
				$('#' + frm_id +' #disposition_sent_by').val(sent_by);
				$('#' + frm_id +' #disposition_sent_date').val(date_time_sent);
				$('#' + frm_id +' #disposition_sent_remarks').val(remarks);
				// dt_special_acceptance.draw();
				// dt_special_acceptance_disposition.draw();
				// dt_special_acceptance_with_treatment.draw();
			}
		});
	}
	function fn_get_supplier_by_pkid(pkid,mode=null) {
		var data = {
			"action" 	: "get_supplier_by_pkid",
			"pkid"		: pkid
		}
		$.ajax({
			type: "POST",
			url: handler_qfr,
			data: data,
			dataType: "json",
			success: function (result) {
				var supplier = result['supplier'];
				if( mode != null){
					assign_value_select2('#frm_sa #supplier', supplier);
					re_initialize_select2_server_side('#modal_sa #supplier','#modal_sa #frm_sa',[],"server_side_scripts/dropdown/qfr/dd_sar_supplier_list.php");
					return;
				}
				assign_value_select2('#frm_send_report_internal_sa #supplier', supplier); 
				/* get the email recipeients external group by the supplier*/
				fn_get_supplier_email_address(result['supplier_name'], 'recipients_to', 'cmb_sa_send_external_to');
				fn_get_supplier_email_address(result['supplier_name'], 'recipients_cc', 'cmb_sa_send_external_cc');
				/* get the email recipients internal */
				fn_ng_load_email_recipients('cmb_sa_send_to','cmb_sa_send_cc'); 
				/* get the supplier */
				re_initialize_select2_server_side('#modal_send_supplier_sa #supplier','#modal_send_supplier_sa #frm_send_report_internal_sa',[],"server_side_scripts/dropdown/qfr/dd_sar_supplier_list.php");
				/** Get the supplier for modal VIEW	*/
				
			}
		});
	}
	function fn_get_supplier_email_address(supplier, category, id) {
		var data = {
			"action" 		: "get_supplier_email_address",
			"supplier"		: supplier,
			"field_name"	: category
		}
		$.ajax({
			type: "POST",
			url: handler_qfr,
			data: data,
			dataType: "json",
			success: function (result) {
				assign_value_select2('#'+id,result['email_add']);
			}
		});
	}
	function fn_ng_load_email_recipients(txt_to_id, txt_cc_id) {
		var data = {
			"action" 		: "get_email_recipients_by_category",
			"qfr_category"	: 'sa'
			//"qfr_category"	: qfr_category

		} 
		$.ajax({
			type: "POST",
			url: handler_qfr_ng,
			data: data,
			dataType: "json",
			success: function (result) {
				assign_value_select2('#'+txt_to_id,result['to']);
				assign_value_select2('#'+txt_cc_id,result['cc']);
				re_initialize_select2_server_side('#modal_send_supplier_sa #'+txt_to_id,'#modal_send_supplier_sa #frm_send_report_internal_sa',[],"server_side_scripts/dropdown/common/dd_hris_email_list.php");
				re_initialize_select2_server_side('#modal_send_supplier_sa #'+txt_cc_id,'#modal_send_supplier_sa #frm_send_report_internal_sa',[],"server_side_scripts/dropdown/common/dd_hris_email_list.php");
			}
		});
	}

	/* ***************************
		!Special Acceptance - For Approval
	/****************************/ //NOTE : fdisposition
	// var dt_special_acceptance_approval = $('#'+tbl_special_acceptance_approval).DataTable({
	// 	"aaSorting"	: [],
	// 	"bProcessing": true,
    //     "bServerSide": true,
	// 	"sAjaxSource": "server_side_scripts/qr/dt_sa_for_approval.php?username="+username,
	// 	"drawCallback": function( settings ) {
	// 		$('#'+tbl_special_acceptance_approval).attr('style','width:100%;');
	// 	}
	// });
	// setTimeout(function(){ //NOTE : set time out for the button to disappered
		/* view or edit special acceptance */
		$('#tbl_special_acceptance_approval tbody').on('click', 'tr .fa-edit', function(){
			$('#modal_sa_edit').data('id',this.id);
			fn_load_special_acceptance(this.id,'edit');
			$('#modal_sa_edit').modal('show');
			fn_sa_hide_text_fields('frm_sa_edit','');
			$('#btn_ng_disapprove ').hide();
			$('#btn_ng_approve ').hide();
			//NOTE : feditcount
		});
		$('#tbl_special_acceptance_approval tbody').on('click', 'tr .fa-plus', function(){
			var pkid = this.id;
			$('#modal_sa_edit').data('id',pkid);
			fn_load_special_acceptance(pkid,'view');
			$('#modal_sa_edit').modal('show');
			fn_sa_hide_text_fields('frm_sa_edit','');
		
		});
		$('#tbl_special_acceptance_approval tbody').on('click', 'tr .fa-eye', function(){
			var pkid = this.id;
			var current_status 	= $(this).closest('tr').find('td:eq(0)').text();
			$('#modal_sa_edit').data('id',pkid);
			fn_load_special_acceptance(pkid,'view',current_status);
			$('#modal_sa_edit').modal('show');
			fn_sa_hide_text_fields('frm_sa_edit','');
		});
		$('#tbl_special_acceptance_approval tbody').on('click', 'tr a#a_download_excel', function(){
			var pkid = $(this).data('id');
			window.location.href = "reports/excel_qfr_sa_common_download.php?id="+pkid; //newcommon
		});
		$('#tbl_special_acceptance_approval tbody').on('click', 'tr .fa-remove', function(){
			var parts_and_prod_details = $(this).closest('tr').find('td:eq(1)').text();
			$('#frm_sa_cancel #label_info').text(parts_and_prod_details);
			$('#modal_sa_cancel').data('id',this.id);
			$('#modal_sa_cancel').modal('show');
		});
	

		/*
		 
		 
		 */
		$('.deletedField').hide();
		var dt_special_acceptance_with_treatment = $('#'+tbl_special_acceptance_with_treatment).DataTable({
			"aaSorting"	: [],
			"bProcessing": true,
		    "bServerSide": true,
			"sAjaxSource": "server_side_scripts/qr/dt_sa_with_treatment.php?username="+username,
			"drawCallback": function( settings ) {
				$('#'+tbl_special_acceptance_with_treatment).attr('style','width:100%;');
			}
		});
		$('#'+tbl_special_acceptance_with_treatment+' tbody').on('click', 'tr a#a_download_excel', function(){ //nmodify
			var pkid = $(this).data('id');
			var current_status 	= $(this).closest('tr').find('td:eq(0)').text();
			fn_get_view_attachment(pkid);

			// if (current_status == 'FOR DISPOSITION') { /* NOTE : fchecked if the current status is approved the download will active? */
			// 	window.location.href = "reports/excel_qfr_sa_report_download.php?id="+pkid; //new
			// }else if(current_status == 'WAITING FOR DISPOSITION' || current_status == 'APPROVED BY YEC' ||current_status =="DISAPPROVED BY YEC"){
			// 	fn_get_view_attachment(pkid);
			// }else{
			// 	window.location.href = "reports/excel_qfr_sa_common_download.php?id="+pkid; //newcommon
			// }
			// if(current_status == 'FOR DISPOSITION' || current_status == 'WAITING FOR DISPOSITION' || current_status == 'APPROVED BY YEC' ||current_status =="DISAPPROVED BY YEC"){
			// 	fn_get_view_attachment(pkid);
			// }else{
			// 	window.location.href = "reports/excel_qfr_sa_common_download.php?id="+pkid; //newcommon
			// }
		});
	
		$('#'+tbl_special_acceptance_with_treatment+' tbody').on('click','tr .fa-edit',function(){
			pkid = this.id;
			mode = 'edit';
			getTreatment(pkid,mode);
			getSentDetails('frm_sa_edit_disposition',pkid);
			fn_get_disposition_list('frm_sa_edit_disposition');
	
			$('#frm_sa_edit_disposition #treatment_file').val('');
			$('#modal_sa_edit_disposition').modal('show');
			$('#frm_sa_edit_disposition #container_sa_disposition').show();
		});
		$('#'+ tbl_special_acceptance_with_treatment +' tbody').on('click','tr .fa-eye',function(){
			pkid = this.id;
			mode = 'view';
			getTreatment(pkid,mode);
			getSentDetails('frm_sa_edit_disposition',pkid);
	
			$('#frm_sa_edit_disposition #treatment_file').val('');
			$('#modal_sa_edit_disposition').modal('show');
			$('#frm_sa_edit_disposition #container_sa_disposition').show();
		});

	/*  */
	var $form_save_sa_control_num = $('#form_save_sa_control_num');
	const save_sa_control_num = function (serialized_data){
		var data = {
			"action"	: "save_sa_control_num",
			"username"	: username
		}
		call_ajax_serialize(data, serialized_data, handler_qfr, function(result){	
			if(result['is_success'] === 'true'){
				dt_special_acceptance.draw();
				dt_special_acceptance_disposition.draw();
				dt_special_acceptance_with_treatment.draw();
				$('#modal_save_sa_control_num').modal('hide');
				notif_success(result.message);
			}
		});
	}
	const change_sar_status = function (status,pkid){
		var data = {
			"action"	: "change_sar_status",
			"pkid"		: pkid,
			"status"	: status,
		}
		call_ajax(data, handler_qfr, function(result){
			if(result['is_success'] === 'true'){
				dt_special_acceptance.draw();
				dt_special_acceptance_disposition.draw();
				dt_special_acceptance_with_treatment.draw();
				notif_success(result.message);
			}
		});
	}
	$form_save_sa_control_num.submit(function (e) { 
		e.preventDefault();
		save_sa_control_num( $(this).serialize() );
	});

	$('#'+tbl_special_acceptance_with_treatment+' tbody').on('click','.btnCloseSar', function () {
		let pkid = this.id;
		let answer = confirm('Are you sure you want to close this document?');

		if (answer){
			change_sar_status('CL',pkid)
		}
	});
	var dateFrom =  $('#frm_sar_report').find('#date_from');
	var dateTo =  $('#frm_sar_report').find('#date_to');
	$('#frm_sar_report').submit(function (e) {
		e.preventDefault();
		let sar_summary_date_from = dateFrom.val();
		let sar_summary_date_to = dateTo.val();
		
		if(sar_summary_date_from === "" || sar_summary_date_from === ""){
			notif_err("Invalid date, Please try again!")
		}else{
			window.location.href = "./reports/iqc/excel_iqc_sa_summary_report.php?sar_summary_date_from="+sar_summary_date_from + "&" + "sar_summary_date_to="+sar_summary_date_to ;
			notif_info("Downloading, Please Wait ...")
		}
		dateFrom.val('');
		dateTo.val('');
	});

	$('#btn_sa_summary_report').click(function (e) { 
		e.preventDefault();
		$('#modal_sar_report').modal();
	});

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
});


/* ***************************
	Special Acceptance - End
/****************************/
