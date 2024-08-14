/* **************************************************
	NG Report - Start
/***************************************************/
	var dt_ng_for_filling		= '';
	var dt_ng					= '';
	var dt_ng_for_disposition	= '';
	var tbl_ng_for_filling		= 'tbl_ng_for_filling';
	var tbl_ng					= 'tbl_ng';
	var tbl_ng_for_disposition  = 'tbl_ng_for_disposition';
	
	var lot_number_selected = [];
	var quantity_selected 	= [];
	var pkid_selected	 	= [];
	var wbs_id	 			= 0;
	
	$('input[type="text"]').attr("autocomplete","off");
	
	/* Button reload */
	$('#btn_reload_wbs_record').click(function() {
		fn_ng_reload_wbs_record();
	});
	
	/* START Scripts for "For Filling " */
	dt_ng_for_filling = $('#'+tbl_ng_for_filling).DataTable({
		"aaSorting"	 : [],	
		"bProcessing": true,
        "bServerSide": true,
		"sAjaxSource": "server_side_scripts/qr/dt_ng_for_filling.php?un="+username,
		"drawCallback": function( settings ) {
			$('#'+tbl_ng_for_filling).attr('style','width:100%;');
		}
	});
	
	$('#'+tbl_ng_for_filling+' tbody').on('click','tr .fa-plus', function() {
		var tr = $(this).closest('tr');
		$('#frm_upload_ng input[name="rbtn_new"][value="part_code"]').trigger("click");
		wbs_id = $(this).val();
		lot_number_selected = [];
		quantity_selected 	= [];
		pkid_selected 		= [];
		var invoice_no 		= (tr.find('td:eq(3)').text());
		var part_code 		= (tr.find('td:eq(4)').text());
		var part_name 		= (tr.find('td:eq(5)').text());
		var lot_no 			= (tr.find('td:eq(6)').text()).split(",");
		var qty 			= (tr.find('td:eq(7)').text()).split(",");
		var supplier 		= (tr.find('td:eq(8)').text());
		$('#frm_upload_ng #invoice_no').val(invoice_no);
		$('#frm_upload_ng #part_code').val(part_code);
		$('#frm_upload_ng input[name="rbtn_new"][value="part_code"]').prop("checked", true);
		$('#frm_upload_ng #parts_affected_parts').val(part_name);
		// $('#frm_upload_ng #supplier').val(supplier);
		
		for(var i=0; i<lot_no.length; i++) {
			lot_number_selected.push( lot_no[i] );
			quantity_selected.push( qty[i] );
			pkid_selected.push( 0 );
		}
		fn_ng_get_material_type_list('frm_upload_ng');
		re_initialize_select2_server_side('#modal_upload_ng #supplier','#modal_upload_ng #frm_upload_ng',[],"server_side_scripts/dropdown/qfr/dd_ng_supplier_list.php");
		re_initialize_select2_server_side('#modal_upload_ng #cmb_approver_username','#modal_upload_ng #frm_upload_ng',[],"server_side_scripts/dropdown/common/dd_hris_above_ss_list.php");
		
		$('#modal_upload_ng #cmb_approver_username').val(supplier).trigger('change');
		$('#modal_upload_ng').modal();
	});
	
	$('#frm_upload_ng #invoice_no').keyup(function(e){
		var key = e.which;
		if(key == 38 || key == 40){
			return false;
		}
		var pattern = $(this).val();
		fn_get_ng_invoice_num_datalist(pattern,'frm_upload_ng #list_invoice_no');
	});
		
	$('#frm_upload_ng input[name="part_code"]').keyup(function(e){
		var key = e.which;
		if(key == 38 || key == 40){
			return false;
		}
		var pattern = $(this).val();
		fn_get_partcode_list(pattern,'frm_upload_ng #list_part_code');
	});
	
	$('#frm_upload_ng input[name="part_code"]').change(function(e){
		var code = $(this).val();
		fn_get_partname(code,'frm_upload_ng');
	});
	
	$('#frm_upload_ng input[name="po_number"]').keyup(function(e){
		var key = e.which;
		if(key == 38 || key == 40){
			return false;
		}
		var pattern = $(this).val();
		fn_get_po_list(pattern,'frm_upload_ng #list_po_number');
	});
	
	$('#frm_upload_ng input[name="po_number"]').change(function(e){
		var po_number = $(this).val();
		var array_fields = [
			'input[name="device_name"]'
		]
		fn_get_po_details(po_number,'frm_upload_ng',array_fields);
	});
	
	$('#frm_upload_ng button[name="add_lot_number"]').click(function() { //nmodify
		$('#frm_ng_add_lot_number table tbody').empty();
		for(var i=0; i<lot_number_selected.length; i++) {
			var html_body  = '<tr>';
				html_body += '<td>'+lot_number_selected[i]+'</td>';
				html_body += '<td>'+quantity_selected[i]+'</td>';
				html_body += '<td><a href="#" class="fa fa-remove"> Remove</a></td>';
				html_body += '</tr>';
			$('#frm_ng_add_lot_number table tbody').append(html_body);
		}
		$('#modal_ng_add_lot_number').modal();
	});
	
	$('#frm_ng_add_lot_number input[name="lot_number"]').keyup(function(e){
		var key = e.which;
		if(key == 38 || key == 40){
			return false;
		}
		var pattern = $(this).val();
		fn_get_lot_number_list(pattern,'list_ng_lot_number_add', function(){});
	});
	
	$('#frm_ng_add_lot_number input[name="lot_number"]').change(function(e){
		var lot_number = $(this).val();
		fn_get_quantity_by_lot_number(lot_number,'frm_ng_add_lot_number input[name="quantity"]');
	});	
	
	$('#frm_ng_add_lot_number').submit(function(e){
		e.preventDefault();
		if(jQuery.inArray($('#frm_ng_add_lot_number input[name="lot_number"]').val(), lot_number_selected) != -1) {	
			$('#frm_ng_add_lot_number .alert-danger').show();
		} else {
			var html_body  = '<tr>';
				html_body += '<td>'+$('#frm_ng_add_lot_number input[name="lot_number"]').val()+'</td>';
				html_body += '<td>'+$('#frm_ng_add_lot_number input[name="quantity"]').val()+'</td>';
				html_body += '<td><a href="#" class="fa fa-remove"> Remove</a></td>';
				html_body += '</tr>';
			$('#frm_ng_add_lot_number table tbody').append(html_body);
			$('#frm_ng_add_lot_number input').val('');
			$('#frm_ng_add_lot_number input[name="lot_number"]').focus();
			$('#frm_ng_add_lot_number .alert-danger').hide();
		}
		
	});	
	
	$('#frm_ng_add_lot_number #tbl_lot_details tbody').on('click' , 'a', function(){
		var lot_no 	= $(this).closest('tr').find('td:eq(0)').text();
		var qty 	= $(this).closest('tr').find('td:eq(1)').text();
		if(jQuery.inArray(lot_no, lot_number_selected) != -1) {
			lot_number_selected.splice($.inArray(lot_no, lot_number_selected), 1);
			var index = lot_number_selected.indexOf(lot_no);
			quantity_selected.splice(index);
			pkid_selected.splice(index);
		}
		$(this).closest('tr').remove();
		return false;
	});
		
	$('#btn_save_lot_number_details').click(function() {
		$('#frm_ng_add_lot_number #tbl_lot_details tbody tr').each(function() {
			if(jQuery.inArray($(this).find('td:eq(0)').text(),  lot_number_selected) != -1) {
			} else {
				lot_number_selected.push( $(this).find('td:eq(0)').text() );
				quantity_selected.push( $(this).find('td:eq(1)').text() );
				pkid_selected.push( 0 );
			}
		});
		$('#modal_ng_add_lot_number').modal('hide');
	});
	
	$('#frm_upload_ng').on('submit', function(e) {
		e.preventDefault();
		$('.btn').prop("disabled",true);
		var form_data = new FormData(this);
		if(fn_validate_upload('cmb_approver_username')) {			
			form_data.append("action", "save_ng_report");
			form_data.append("username", username);
			form_data.append("lot_numbers", lot_number_selected);
			form_data.append("quantity", quantity_selected);
			form_data.append("lot_pkid", pkid_selected);
			form_data.append("wbs_id", wbs_id);
			call_ajax_attachment(form_data, handler_qfr_ng, function(result){
				// console.log(result);
				if(result['msg'] == 'NG Report No. already exists!') {
					$('#container_message').attr('class', 'alert alert-danger');
				} else {
					$('#container_message').attr('class', 'alert alert-success');
				}
				$('#modal_system_message').modal();
				$('#modal_upload_ng').modal('hide');
				$('#container_message').html( '<h4>'+result['msg']+'</h4>' );
				
				$('#modal_upload_ng #supplier').val(null).trigger('change');
				$('#modal_upload_ng #cmb_approver_username').val(null).trigger('change');
				reload_ng_datatables();
				$('.btn').prop("disabled",false);
			});		
		} 
	});
	
	/* END Scripts for "For Filling " */
	
	/* START Scripts for "New NG report " */
	
	$('#btn_upload_ng').click(function() {
		fn_ng_get_material_type_list('frm_upload_ng');
		
		re_initialize_select2_server_side('#modal_upload_ng #supplier','#modal_upload_ng #frm_upload_ng',[],"server_side_scripts/dropdown/qfr/dd_ng_supplier_list.php");
		re_initialize_select2_server_side('#modal_upload_ng #cmb_approver_username','#modal_upload_ng #frm_upload_ng',[],"server_side_scripts/dropdown/common/dd_hris_above_ss_list.php");
		$('#modal_upload_ng').modal();
		lot_number_selected = [];
		quantity_selected 	= [];
		pkid_selected 		= [];
		wbs_id				= 0;
		$('#frm_ng_add_lot_number table tbody').empty();
	});
	/* END Scripts for "For Filling " */
	
	/* START Scripts for "Edit NG report " */
	dt_ng = $('#'+tbl_ng).DataTable({
		"aaSorting"	 : [],	
		"bProcessing": true,
        "bServerSide": true,
		"sAjaxSource": "server_side_scripts/qr/dt_ng.php?un="+username,
		"drawCallback": function( settings ) {
			$('#'+tbl_ng).attr('style','width:100%;');
		}
	});
	
	$('#'+tbl_ng+' tbody').on('click', 'tr .fa-paperclip', function() {
		// window.location.href = "./pages/qfr/dl_ng_report.php?id="+$(this).val();
		fn_view_ng_attachments($(this).val());
	});
	
	$('#'+tbl_ng+' tbody').on('click', 'tr .fa-edit', function() {
		var pkid 			= $(this).val();
		var current_status 	= $(this).closest('tr').find('td:eq(0)').text();
		lot_number_selected = [];
		quantity_selected 	= [];
		pkid_selected 		= [];
		fn_get_ng_lot_numbers_by_fkng(pkid);
		fn_ng_get_material_type_list('frm_upload_ng_update');
		$('#frm_upload_ng_update button[type="submit"]').val(pkid);
		$('#modal_upload_ng_edit input[type="file"]').prop('disabled', true);
		fn_ng_load_details(pkid, 'modal_upload_ng_edit','cmb_approved_by','frm_upload_ng_update');
		
		if(current_status == 'FOR APPROVAL' || current_status == 'APPROVED' || current_status == 'DISAPPROVED') {
			$('#frm_upload_ng_update .fa-save').show();
			$('#frm_upload_ng_update input[type="checkbox"]').attr('disabled', false);
		} else {
			$('#frm_upload_ng_update .fa-save').hide();
			$('#frm_upload_ng_update input[type="checkbox"]').attr('disabled', true);
		}
		
		$('#modal_upload_ng_edit').modal();	
	});
	
	$('#frm_upload_ng_update #invoice_no').keyup(function(e){
		var key = e.which;
		if(key == 38 || key == 40){
			return false;
		}
		var pattern = $(this).val();
		fn_get_ng_invoice_num_datalist(pattern,'frm_upload_ng_update #list_invoice_no2');
	});
	
	$('#frm_upload_ng_update input[name="part_code"]').keyup(function(e){
		var key = e.which;
		if(key == 38 || key == 40){
			return false;
		}
		var pattern = $(this).val();
		fn_get_partcode_list(pattern,'frm_upload_ng_update #list_part_code2');
	});
	
	$('#frm_upload_ng_update input[name="part_code"]').change(function(e){
		var code = $(this).val();
		fn_get_partname(code,'frm_upload_ng_update');
	});
	
	$('#frm_upload_ng_update input[name="po_number"]').keyup(function(e){
		var key = e.which;
		if(key == 38 || key == 40){
			return false;
		}
		var pattern = $(this).val();
		fn_get_po_list(pattern,'frm_upload_ng_update #list_po_number2');
	});
	
	$('#frm_upload_ng_update input[name="po_number"]').change(function(e){
		var po_number = $(this).val();
		var array_fields = [
			'input[name="device_name"]'
		]
		fn_get_po_details(po_number,'frm_upload_ng_update',array_fields);
	});
		
	$('#frm_upload_ng_update button[name="add_lot_number"]').click(function() {
		$('#frm_ng_add_lot_number .alert-danger').hide();
		$('#frm_ng_add_lot_number table tbody').empty();
		for(var i=0; i<lot_number_selected.length; i++) {
			var html_body  = '<tr>';
				html_body += '<td>'+lot_number_selected[i]+'</td>';
				html_body += '<td>'+quantity_selected[i]+'</td>';
				html_body += '<td><a href="#" class="fa fa-remove"> Remove</a></td>';
				html_body += '</tr>';
			$('#frm_ng_add_lot_number table tbody').append(html_body);
		}
		$('#modal_ng_add_lot_number').modal();
	});
	
	$('#frm_upload_ng_update .fa-paperclip').click(function() {
		// window.location.href = "./pages/qfr/dl_ng_report.php?id="+$(this).val();
		fn_view_ng_attachments($(this).val());
	});
	
	$('#frm_upload_ng_update input[type="checkbox"]').click(function() {
		if($(this).is(':checked')) {
			$('#frm_upload_ng_update input[type="file"]').prop('required', true);
			$('#frm_upload_ng_update input[type="file"]').prop('disabled', false);
			$('#frm_upload_ng_update input[type="file"]').attr('name', 'file_ng[]');
			$('#container_upload_ng_message_edit').html('<h4>Re-uploading of file will reset the approval history (from approved to pending). Uncheck the checkbox if you want to cancel the action.</h4>');
			$('#container_upload_ng_message_edit').show();
		} else {
			$('#frm_upload_ng_update input[type="file"]').prop('required', false);
			$('#frm_upload_ng_update input[type="file"]').prop('disabled', true);
			$('#frm_upload_ng_update input[type="file"]').attr('name', '');
			$('#container_upload_ng_message_edit').hide();
		}
	});
	
	$('#frm_upload_ng_update').on('submit', function(e) {
		e.preventDefault();
		// console.log(lot_number_selected);
		// console.log(quantity_selected);
		// console.log(pkid_selected);
		var pkid = $('#frm_upload_ng_update button[type="submit"]').val();
		$('.btn').prop("disabled",true);
		var form_data = new FormData(this);
		if(fn_validate_upload('cmb_approved_by')) {
			form_data.append("action", "update_ng_report");
			form_data.append("pkid", pkid);
			form_data.append("username", username);
			form_data.append("lot_numbers", lot_number_selected);
			form_data.append("quantity", quantity_selected);
			form_data.append("lot_pkid", pkid_selected);
			form_data.append("wbs_id", wbs_id);
			call_ajax_attachment(form_data, handler_qfr_ng, function(result){
				// console.log(result);
				if(result['msg'] == 'NG Report No. already exists!') {
					$('#container_message').attr('class', 'alert alert-danger');
				} else {
					$('#container_message').attr('class', 'alert alert-success');
				}
				$('#modal_system_message').modal();
				$('#modal_upload_ng_edit').modal('hide');
				$('#container_message').html( '<h4>'+result['msg']+'</h4>' );
				reload_ng_datatables();
				$('.btn').prop("disabled",false);
			});		
		} 
	});
		
	/* END Scripts for "Edit NG report " */
	
	/* START Scripts for "View NG report " */
	$('#'+tbl_ng+' tbody').on('click', 'tr .fa-eye', function() {
		var pkid 			= $(this).val();
		var current_status 	= $(this).closest('tr').find('td:eq(0)').text();
		var treatment	 	= $(this).closest('tr').find('td:eq(3)').text();
		lot_number_selected = [];
		quantity_selected 	= [];
		pkid_selected 		= [];
		fn_get_ng_lot_numbers_by_fkng(pkid);
		fn_ng_get_material_type_list('frm_upload_ng_view');
		$('#frm_upload_ng_view .fa-thumbs-o-up').val(pkid);
		$('#frm_upload_ng_view .fa-eye').val(pkid);
		$('#frm_upload_ng_view .fa-paperclip').val(pkid);
		$('#modal_approver_ng_view input[type="file"]').prop('disabled', true);
		
		if(current_status == 'FOR APPROVAL') {
			$('#frm_upload_ng_view .fa-thumbs-o-up').show();
			$('#frm_upload_ng_view .fa-thumbs-o-down').show();
			$('#frm_upload_ng_view #btn_ng_view_disposition').hide();
		} else {
			$('#frm_upload_ng_view .fa-thumbs-o-up').hide();
			$('#frm_upload_ng_view .fa-thumbs-o-down').hide();
			if(treatment == 'N/A') {
				$('#frm_upload_ng_view #btn_ng_view_disposition').hide();
			} else {
				$('#frm_upload_ng_view #btn_ng_view_disposition').show();
			}
		}
		
		fn_ng_load_details(pkid, 'modal_approver_ng_view','','frm_upload_ng_view');
		fn_get_approvers_log_by_fkng(pkid, 'frm_upload_ng_view #tbl_approver_ng_view');
		$('#modal_approver_ng_view').modal();		
		fn_validate_is_approver(pkid, current_status);
	});
	
	$('#frm_upload_ng_view button[name="view_lot_number"]').click(function() {
		$('#frm_ng_view_lot_number table tbody').empty();
		for(var i=0; i<lot_number_selected.length; i++) {
			var html_body  = '<tr>';
				html_body += '<td>'+lot_number_selected[i]+'</td>';
				html_body += '<td>'+quantity_selected[i]+'</td>';
				html_body += '</tr>';
			$('#frm_ng_view_lot_number table tbody').append(html_body);
		}
		$('#modal_ng_view_lot_number').modal();
	});
	
	$('#frm_upload_ng_view .fa-thumbs-o-up').click(function() {
		$('#container_approver_message').attr('class','alert alert-success');
		$('#container_approver_message').html('Are you sure you want to approve the request?<br><br>Remarks:<textarea name="remarks" style="width:100%;" rows="4"></textarea>');
		$('#container_approver_message').show();
		$('#modal_approver_message').modal();
	});
		
	$('#frm_upload_ng_view .fa-thumbs-o-down').click(function() {
		$('#container_approver_message').attr('class','alert alert-danger');
		$('#container_approver_message').html('Are you sure you want to disapprove the request?<br><br>Remarks:<textarea name="remarks" style="width:100%;" rows="4" required></textarea>');
		$('#container_approver_message').show();
		$('#modal_approver_message').modal();
	});
	
	$('#frm_ng_approvers_decision').on('submit', function(e) {
		e.preventDefault();
		$('.btn').prop("disabled",true);
		var decision = $('#container_approver_message').attr('class');
		if(decision == 'alert alert-success') {
			var status = 'APPROVED';
		} else if(decision == 'alert alert-danger') {
			var status = 'DISAPPROVED';
		} 
		var serialized_data = new FormData(this);
			serialized_data.append("action","ng_approver_decision");
			serialized_data.append("fkng", $('#frm_upload_ng_view .fa-thumbs-o-up').val() );
			serialized_data.append("status",status);
			serialized_data.append("username",username);
				
			call_ajax_attachment(serialized_data, handler_qfr_ng, function(result){
				$('#modal_approver_message').modal('hide');
				$('#modal_approver_ng_view').modal('hide');
				$('#modal_system_message').modal();
				$('#container_message').attr('class','alert alert-success');
				$('#container_message').html( '<h4>'+result['msg']+'</h4>' );
				reload_ng_datatables();
				$('.btn').prop("disabled",false);
			});
	});
	
	$('#frm_upload_ng_view #btn_ng_view_disposition').click(function() {
		var fkng = $(this).val();
		fn_get_disposition_list('frm_ng_view_disposition #disposition', function() {
			fn_load_ng_treatment_details_by_fkng( 'modal_ng_view_disposition', fkng, function() {
				fn_hide_show_ng_disposition('modal_ng_view_disposition', fkng);
				$('#modal_ng_view_disposition #btn_ng_initial_dispo').show();
				$('#modal_ng_view_disposition').modal();
			});
		});		
	});
	
	$('#frm_upload_ng_view .fa-paperclip').click(function() {
		// window.location.href = "./pages/qfr/dl_ng_report.php?id="+$(this).val();
		fn_view_ng_attachments($(this).val());
	});
	
	/* END Scripts for "View NG report " */
		
	/* START Scripts for "For Disposition " */
	dt_ng_for_disposition = $('#'+tbl_ng_for_disposition).DataTable({
		"aaSorting"	 : [],	
		"bProcessing": true,
        "bServerSide": true,
		"sAjaxSource": "server_side_scripts/qr/dt_ng_for_disposition?un="+username,
		"drawCallback": function( settings ) {
			$('#'+tbl_ng_for_disposition).attr('style','width:100%;');
		}
	});
	
	$('#'+tbl_ng_for_disposition+' tbody').on('click', 'tr .fa-paperclip', function() {
		// window.location.href = "./pages/qfr/dl_ng_report.php?id="+$(this).val();
		fn_view_ng_attachments($(this).val());
	});
	
	$('#'+tbl_ng_for_disposition+' tbody').on('click','tr .fa-send-o', function() {
		$('#frm_send_report_internal .fa-paperclip').val(' '+ $(this).val());
		$('#frm_send_report_internal button[type="submit"]').val(' '+ $(this).val());
		$('#frm_send_report_internal #cmb_ng_send_external_to').val(null).trigger('change');
		$('#frm_send_report_internal #cmb_ng_send_external_cc').val(null).trigger('change');
		
		fn_get_supplier_by_pkid($(this).val());		
		$('#modal_upload_ng_edit').modal('hide');
		$('#modal_ng_send_supplier').modal();
	});
	
	$('#'+tbl_ng_for_disposition+' tbody').on('click','tr .fa-plus', function() {
		var fkng = $(this).val();
		fn_get_disposition_list('frm_ng_add_disposition #disposition', function() {
			fn_load_ng_treatment_details_by_fkng( 'modal_ng_add_disposition', fkng, function() {
				fn_hide_show_ng_disposition('modal_ng_add_disposition', fkng);
				$('#modal_ng_add_disposition').modal();
			});	
		});
	});
	
	$('#frm_send_report_internal .fa-paperclip').click(function() {
		// window.location.href = "./pages/qfr/dl_ng_report.php?id="+$(this).val();
		fn_view_ng_attachments($(this).val());
	});
	
	$('#frm_send_report_internal').on('submit', function(e) {
	   e.preventDefault();
	   $('.btn').prop("disabled",true);
	   $('#cmb_ng_send_external_to').prop("disabled",false);
	   $('#cmb_ng_send_external_cc').prop("disabled",false);
	   var  serialized_data = new FormData(this);
			serialized_data.append("action","ng_send_for_disposition");
			serialized_data.append("fkng",$('#frm_send_report_internal button[type="submit"]').val());
			serialized_data.append("username",username);
	   call_ajax_attachment(serialized_data, handler_qfr_ng, function(result){
			if(result['msg'] == 'NG Report Number already exist!') {
				$('#container_message').attr('class','alert alert-danger');
			} else {
				$('#container_message').attr('class','alert alert-success');
				$('#modal_ng_send_supplier').modal('hide');	
			}
			$('#modal_system_message').modal();						
			$('#container_message').html( '<h4>'+result['msg']+'</h4>' );
			reload_ng_datatables();
			$('.btn').prop("disabled",false);
		});
	});
	
	$('#frm_ng_add_disposition').on('submit', function(e) {
		e.preventDefault();
		$('#frm_ng_add_disposition #container_ng_disposition select').prop('disabled', false);
		var serialized_data = new FormData(this);
		var fkng 			= $('#frm_ng_add_disposition button[type="submit"]').val();
		if($('#txt_hidden_disposition_type').val() == 'WITH TREATMENT' || $('#txt_hidden_disposition_type').val() == 'WITH FINAL REPLY') {
			if($('#frm_ng_add_disposition #disposition').val() == 'OK TO USE' || $('#frm_ng_add_disposition #disposition').val() == 'USE AS IS') {
				var final_reply_status = "N/A";
			} else {
				var final_reply_status = "REQUIRED";
			}
			fn_add_treatment('modal_ng_add_disposition', fkng, final_reply_status, serialized_data);
		} 
	});
	
	$('#frm_ng_add_disposition #container_ng_disposition .fa-paperclip').click(function() {
		// window.location.href = "./pages/qfr/dl_ng_report.php?id="+$(this).val();
		fn_view_ng_attachments($(this).val());
	});
		
	$('#'+tbl_ng_for_disposition+' tbody').on('click','tr .fa-edit', function() {
		var fkng = $(this).val();
		fn_get_disposition_list('frm_ng_edit_disposition #disposition', function() {
			fn_load_ng_treatment_details_by_fkng( 'modal_ng_edit_disposition', fkng, function() {
				fn_hide_show_ng_disposition('modal_ng_edit_disposition', fkng);
				$('#modal_ng_edit_disposition #btn_ng_initial_dispo').show();
				$('#modal_ng_edit_disposition').modal();
			});
		});		
	});
	
	$('#frm_ng_edit_disposition #chk_reupload_treatment').click(function() {
		if($(this).is(':checked')) {
			$('#frm_ng_edit_disposition #treatment_file').attr('name', 'treatment_file');
			$('#frm_ng_edit_disposition #treatment_file').prop('required', true);
			$('#frm_ng_edit_disposition #treatment_file').prop('disabled', false);
			$('#frm_ng_edit_disposition #txt_hidden_disposition_type').val('WITH TREATMENT');
		} else {
			$('#frm_ng_edit_disposition #treatment_file').attr('name', '');
			$('#frm_ng_edit_disposition #treatment_file').prop('required', false);
			$('#frm_ng_edit_disposition #treatment_file').prop('disabled', true);
			$('#frm_ng_edit_disposition #txt_hidden_disposition_type').val('');
		}
	});
	
	$('#frm_ng_edit_disposition #chk_reupload_final_reply').click(function() {
		if($(this).is(':checked')) {
			$('#frm_ng_edit_disposition #final_reply_file').attr('name', 'final_reply_file');
			$('#frm_ng_edit_disposition #final_reply_file').prop('required', true);
			$('#frm_ng_edit_disposition #final_reply_file').prop('disabled', false);
			$('#frm_ng_edit_disposition #txt_hidden_disposition_type').val('WITH TREATMENT');
		} else {
			$('#frm_ng_edit_disposition #final_reply_file').attr('name', '');
			$('#frm_ng_edit_disposition #final_reply_file').prop('required', false);
			$('#frm_ng_edit_disposition #final_reply_file').prop('disabled', true);
			$('#frm_ng_edit_disposition #txt_hidden_disposition_type').val('');
		}
	});
	
	$('#frm_ng_edit_disposition #disposition').change(function() {
		if($(this).val() == 'OK TO USE' || $(this).val() == 'USE AS IS') {
			// $('#frm_ng_edit_disposition #final_reply_file').prop('required', false);
			$('#frm_ng_edit_disposition input[type="date"]').prop('required', false);
			$('#frm_ng_edit_disposition input[type="time"]').prop('required', false);
			$('#frm_ng_edit_disposition input[type="file"]').prop('required', false);
			$('#frm_ng_edit_disposition #container_ng_final_reply').hide();
		} else {
			// $('#frm_ng_edit_disposition #final_reply_file').prop('required', true);
			// $('#frm_ng_edit_disposition input[type="date"]').prop('required', true);
			// $('#frm_ng_edit_disposition input[type="time"]').prop('required', true);
			// $('#frm_ng_edit_disposition input[type="file"]').prop('required', true);
			$('#frm_ng_edit_disposition #container_ng_final_reply').show();
			$('#modal_ng_edit_disposition #txt_hidden_disposition_type').val('WITH FINAL REPLY');
		}		
	});
	
	$('#frm_ng_edit_disposition').on('submit', function(e) {
		e.preventDefault();
		$('#frm_ng_edit_disposition #container_ng_disposition select').prop('disabled', false);
		var serialized_data = new FormData(this);
		var fkng 			= $('#frm_ng_edit_disposition button[type="submit"]').val();
		if($('#frm_ng_edit_disposition #disposition').val() == 'OK TO USE' || $('#frm_ng_edit_disposition #disposition').val() == 'USE AS IS') {
			var final_reply_status = "N/A";
		} else {
			var final_reply_status = "REQUIRED";
		}
		fn_add_treatment('modal_ng_edit_disposition', fkng, final_reply_status, serialized_data);
	});
	
	$('#frm_ng_edit_disposition #btn_ng_initial_dispo').click(function() {
		fn_view_ng_attachments($(this).val());
	});
	
	$('#frm_ng_edit_disposition #btn_ng_final_dispo').click(function() {
		fn_view_ng_attachments($(this).val());
	});
	
	$('#'+tbl_ng_for_disposition+' tbody').on('click','tr .fa-eye', function() {
		var fkng = $(this).val();
		fn_get_disposition_list('frm_ng_view_disposition #disposition', function() {
			fn_load_ng_treatment_details_by_fkng( 'modal_ng_view_disposition', fkng, function() {
				fn_hide_show_ng_disposition('modal_ng_view_disposition', fkng);
				$('#modal_ng_view_disposition #btn_ng_initial_dispo').show();
				$('#modal_ng_view_disposition').modal();
			});
		});		
	});
	
	$('#frm_ng_view_disposition #btn_ng_initial_dispo').click(function() {
		fn_view_ng_attachments($(this).val());
	});
	
	$('#frm_ng_view_disposition #btn_ng_final_dispo').click(function() {
		fn_view_ng_attachments($(this).val());
	});
	
	$('#tbl_view_attachments_ng tbody').on('click', 'tr .fa-paperclip',function() {
		var fkng 		= $(this).attr('id');
		var folder 		= $(this).attr('folder');
		var file_name 	= $(this).text();
		if(folder == 'new') {
			window.location.href = "./pages/qfr/dl_ng_report.php?id="+fkng;
		} else {
			fn_dl_disposition_attachment(fkng,folder,file_name);
		}		
	});
	
	$('#frm_send_report_internal #supplier').change(function() {
		fn_get_supplier_email_address($(this).val(), 'recipients_to', 'cmb_ng_send_external_to');
		fn_get_supplier_email_address($(this).val(), 'recipients_cc', 'cmb_ng_send_external_cc');
	});
	
	/* END Scripts for "For Disposition " */
	
	/* START Scripts for "Cancel NG report " */
	$('#'+tbl_ng+' tbody').on('click', 'tr .fa-remove', function() {
		var pkid = $(this).val();
		$('#frm_ng_cancel button[type="submit"]').val(pkid);
		$('#modal_cancel_message').modal();
	});
	
	$('#frm_ng_cancel').on('submit', function(e) {
		e.preventDefault();
		var serialized_data = $(this).serialize();
		$('.btn').prop("disabled",true);
		var data = {
			"action" 	: "cancel_ng",
			"pkid"		: $('#frm_ng_cancel button[type="submit"]').val(),
			"username"	: username
		} 
		call_ajax_serialize(data, serialized_data, handler_qfr_ng, function(result){	
			$('#modal_cancel_message').modal('hide');
			$('#modal_system_message').modal();
			$('#container_message').attr('class','alert alert-success');
			$('#container_message').html( '<h4>'+result['msg']+'</h4>' );
			reload_ng_datatables();
			$('.btn').prop("disabled",false);
		});
	});
	/* END Scripts for "Cancel NG report " */
	
	
	function fn_ng_get_material_type_list(frm_id) {
		$('#'+frm_id+' #material_type').empty();
		var data = {
			"action" 		: "get_material_type_list",
			"username" 		: username
		} 
		call_ajax(data, handler_qfr_ng, function(result){
			$('#'+frm_id+' #material_type').append( result['html_select'] );
		});
	}
	
	function fn_ng_reload_wbs_record() {
		var data = {
			"action" 		: "ng_reload_wbs_record",
			"username" 		: username
		} 
		call_ajax(data, handler_qfr_ng, function(result){
			$('#container_message').attr('class','');
			$('#modal_system_message').modal();
			$('#container_message').html( result['table'] );
			reload_ng_datatables();
		});
	}
	
	function fn_ng_load_details(pkid, modal_id,chosen_id, frm_id) {
		var data = {
			"action" : "load_ng_details_by_pkid",
			"pkid"	 : pkid
		}
		call_ajax( data, handler_qfr_ng, function(result) {
			console.log(result);
			$.each(result['data'], function(key,value) {
				$( '#' + modal_id + ' form input[name="' + key + '"]' ).val(value);
				$( '#' + modal_id + ' form select[name="' + key + '"]' ).val(value);
				$( '#' + modal_id + ' form textarea[name="' + key + '"]' ).val(value);
				$( '#' + modal_id + ' #btn_attachment' ).val(pkid);
				if(key == 'part_code' && value != "") {
					fn_get_partname(value,frm_id);
				} if(key == 'po_number' && value != "") {
					var array_fields = [
						'input[name="device_name"]'
					]
					fn_get_po_details(value,frm_id,array_fields);
				} 
				assign_value_select2('#'+frm_id+' #cmb_approved_by',result['approver_username']);
				assign_value_select2('#'+frm_id+' #supplier',result['supplier']);
				re_initialize_select2_server_side('#'+modal_id+' #cmb_approved_by','#'+modal_id+' #'+frm_id,[],"server_side_scripts/dropdown/common/dd_hris_above_ss_list.php");
				re_initialize_select2_server_side('#'+modal_id+' #supplier','#'+modal_id+' #'+frm_id,[],"server_side_scripts/dropdown/qfr/dd_ng_supplier_list.php");
			});
		});
	}
	
	function fn_get_ng_lot_numbers_by_fkng(fkng) {
		var data = {
			"action" : "get_ng_lot_numbers_by_fkng",
			"fkng"	 : fkng
		}
		call_ajax( data, handler_qfr_ng, function(result) {			
			var lot_no 			= result['lot_no'].split(",");
			var quantity 		= result['quantity'].split(",");
			var lot_pkid 		= result['lot_pkid'].split(",");
			for(var i=0; i<lot_no.length; i++) {
				lot_number_selected.push( lot_no[i] );
				quantity_selected.push( quantity[i] );
				pkid_selected.push( lot_pkid[i] );
			}
		});
	}
	
	function fn_get_approvers_log_by_fkng(fkng, table_id) {
		$('#'+table_id+' tbody').empty();
		var data = {
			"action" : "get_approvers_log",
			"fkng"	 : fkng
		}
		call_ajax( data, handler_qfr_ng, function(result) {			
			$('#'+table_id+' tbody').append(result['table_body']);
		});
	}
	
	function fn_get_report_approvers(cmb_id, callback) {
		$('#'+cmb_id).empty();
		var data = {
			"action" 		: "get_report_approvers",
			"fk_module"		: ['3'],
			"approver_type"	: ['']
		} 
		call_ajax(data, handler_qfr, function(result){
			$('#'+cmb_id).append( '<option>-</option>' );
			$('#'+cmb_id).append( result['html_select'] );
			$('#'+cmb_id).trigger("chosen:updated");
			callback();
		});
	}
	
	function fn_validate_upload(approver_id) {
		if($('#'+approver_id + ' option:selected').length <= 1 ) {
			$('#container_upload_ng_message').html('Please select approver atleast 2.');
			$('#container_upload_ng_message').show();
			$('.btn').prop("disabled",false);
			return false;
		} else {
			$('#container_upload_ng_message').hide();
			return true;
		}
	}
	
	function reload_ng_datatables() {
		dt_ng_for_filling.ajax.reload();
		dt_ng.ajax.reload();
		dt_ng_for_disposition.ajax.reload();
	}
	
	function fn_load_ng_treatment_details_by_fkng(modal_id, fkng, callback) {
		var data = {
			"action" : "load_ng_treatment_details_by_fkng",
			"fkng"	 : fkng
		}
		call_ajax( data, handler_qfr_ng, function(result) {
			if(result['data'] !=0){
				$.each(result['data'], function(key,value) {
					$( '#' + modal_id + ' form input[name="' + key + '"]' ).val(value);
					$( '#' + modal_id + ' form select[name="' + key + '"]' ).val(value);
					$( '#' + modal_id + ' form textarea[name="' + key + '"]' ).val(value);
					
					if(key == 'disposition_sent_by') {
						fn_get_emp_name_by_username2(value,key); 
					} // console.log('['+key+']');
					if(key == 'final_reply_file_name') {
						if(value == '') {
							$('#'+ modal_id +' #btn_ng_final_dispo').attr('style','display:none;'); 
						} else {
							$('#'+ modal_id +' #btn_ng_final_dispo').attr('style','display:inline-block;'); 
						}					
					}
				});
				$( '#' + modal_id + ' form a' ).val(fkng);
				$('#'+modal_id+' button[type="submit"]').val(fkng);
				callback();	
			}
		});
	}
	
	function fn_hide_show_ng_disposition(modal_id, fkng) {		
		if($('#' + modal_id + ' #disposition').val() == '') {
			$('#'+ modal_id +' #container_ng_disposition').show();
			$('#'+ modal_id +' #container_ng_final_reply').hide();
			$('#'+ modal_id +' #txt_hidden_disposition_type').val('WITH TREATMENT');
			$('#'+ modal_id +' #treatment_file').prop('required', true);
			$('#'+ modal_id +' #treatment_file').show();
			$('#'+ modal_id +' #btn_ng_initial_dispo').hide();
			$('#'+ modal_id +' #final_reply_file').prop('disabled', false);
			$('#'+ modal_id +' #final_reply_file').prop('required', false);
		// } else if(key == 'disposition' && value != '') {
		} else if($('#' + modal_id + ' #final_reply_status').val() == 'N/A') {
			$('#'+ modal_id +' #container_ng_disposition').show();
			$('#'+ modal_id +' #container_ng_final_reply').hide();
			$('#'+ modal_id +' #txt_hidden_disposition_type').val('WITH TREATMENT');
			$('#'+ modal_id +' #treatment_file').prop('required', true);
			$('#'+ modal_id +' #treatment_file').show();
			$('#'+ modal_id +' #btn_ng_initial_dispo').hide();
			$('#'+ modal_id +' #final_reply_file').prop('disabled', false);
			$('#'+ modal_id +' #final_reply_file').prop('required', false);
			
			$('#' + modal_id + ' #container_ng_final_reply input[type="date"]').prop('required', false);
			$('#' + modal_id + ' #container_ng_final_reply input[type="time"]').prop('required', false);
			$('#' + modal_id + ' #container_ng_final_reply input[type="file"]').prop('required', false);
		} else if($('#' + modal_id + ' #final_reply_status').val() == 'REQUIRED') {
			$('#'+ modal_id +' #container_ng_disposition').show();
			$('#'+ modal_id +' #container_ng_final_reply').show();
			$('#'+ modal_id +' #txt_hidden_disposition_type').val('WITH FINAL REPLY');
			$('#'+ modal_id +' #treatment_file').prop('disabled', true);
			$('#'+ modal_id +' #treatment_file').show();
			$('#'+ modal_id +' #btn_ng_initial_dispo').val(fkng);
			$('#'+ modal_id +' #btn_ng_initial_dispo').show();
			$('#'+ modal_id +' #treatment_file').prop('required', false);
			// $('#'+ modal_id +' #final_reply_file').prop('required', true);
			
			
			// $('#' + modal_id + ' #container_ng_final_reply input[type="date"]').prop('required', true); //nmodify
			// $('#' + modal_id + ' #container_ng_final_reply input[type="time"]').prop('required', true);
			// $('#' + modal_id + ' #container_ng_final_reply input[type="file"]').prop('required', true);
		}
		
		if((modal_id == 'modal_ng_add_disposition' && $('#' + modal_id + ' #disposition').val() != ''))  {
			$('#' + modal_id + ' #container_ng_disposition input[type="text"]').prop('readonly', true);
			$('#' + modal_id + ' #container_ng_disposition input[type="date"]').prop('readonly', true);
			$('#' + modal_id + ' #container_ng_disposition input[type="time"]').prop('readonly', true);
			$('#' + modal_id + ' #container_ng_disposition input[type="file"]').prop('readonly', true);
			$('#' + modal_id + ' #container_ng_disposition select').prop('disabled', true);
			$('#' + modal_id + ' #container_ng_disposition textarea').prop('readonly', true);
		} else {
			$('#' + modal_id + ' #container_ng_disposition input[type="text"]').prop('readonly', false);
			$('#' + modal_id + ' #container_ng_disposition input[type="date"]').prop('readonly', false);
			$('#' + modal_id + ' #container_ng_disposition input[type="time"]').prop('readonly', false);
			$('#' + modal_id + ' #container_ng_disposition input[type="file"]').prop('readonly', false);
			$('#' + modal_id + ' #container_ng_disposition select').prop('disabled', false);
			$('#' + modal_id + ' #container_ng_disposition textarea').prop('readonly', false);
			$('#frm_ng_edit_disposition #treatment_file').prop('required', false);
			$('#frm_ng_edit_disposition #treatment_file').prop('disabled', true);
		}
	}
	
	function fn_add_treatment(modal_id, fkng, final_reply_status, serialized_data) { //nmodify
		serialized_data.append("action","add_treatment");
		serialized_data.append("fkng",fkng);
		serialized_data.append("final_reply_status",final_reply_status);
		serialized_data.append("username",username);
		$('.btn').prop("disabled",true);
		call_ajax_attachment(serialized_data, handler_qfr_ng, function(result){
			$('#'+modal_id).modal('hide');
			$('#modal_system_message').modal();
			$('#container_message').attr('class','alert alert-success');
			$('#container_message').html( '<h4>'+result['msg']+'</h4>' );
			reload_ng_datatables();
			$('.btn').prop("disabled",false);
		});
	}
	
	function fn_get_emp_name_by_username2(username, txt_id) {
		var data = {
			"action" 	 : "get_emp_name_by_username2",
			"username"	 : username
		}
		call_ajax( data, common_handler, function(result) {
			$('#'+ txt_id).val( result['emp_name'] );
		});
	}
	
	function fn_get_disposition_list(cmd_id, callback) {
		$('#'+ cmd_id).empty();
		var data = {
			"action" 	 : "get_disposition_list"
		}
		call_ajax( data, handler_qfr_ng, function(result) {
			$('#'+ cmd_id).append( result['html_select'] );
			callback();
		});
	}
	
	function fn_validate_is_approver(fkng, current_status) {
		var data = {
			"action" 	 : "validate_is_approver",
			"fkng" 		 : fkng,
			"username" 	 : username
		}
		call_ajax( data, handler_qfr_ng, function(result) {
			if(current_status == 'FOR APPROVAL' && result['is_approver'] == 1) {
				$('#frm_upload_ng_view #btn_ng_approve').show();
				$('#frm_upload_ng_view #btn_ng_disapprove').show();
				$('#frm_upload_ng_view #btn_ng_view_disposition').hide();
			} else if(current_status == 'FOR APPROVAL' && result['is_approver'] == 0) {
				$('#frm_upload_ng_view #btn_ng_approve').hide();
				$('#frm_upload_ng_view #btn_ng_disapprove').hide();
				$('#frm_upload_ng_view #btn_ng_view_disposition').hide();
			} else if(current_status == 'APPROVED') {
				$('#frm_upload_ng_view #btn_ng_approve').hide();
				$('#frm_upload_ng_view #btn_ng_disapprove').hide();
				$('#frm_upload_ng_view #btn_ng_view_disposition').hide();
			} else if(current_status == 'WAITING DISPOSITION') {
				$('#frm_upload_ng_view #btn_ng_approve').hide();
				$('#frm_upload_ng_view #btn_ng_disapprove').hide();
				$('#frm_upload_ng_view #btn_ng_view_disposition').show();
			} else {
				$('#frm_upload_ng_view #btn_ng_approve').hide();
				$('#frm_upload_ng_view #btn_ng_disapprove').hide();
				$('#frm_upload_ng_view #btn_ng_view_disposition').show();
			}
			$('#frm_upload_ng_view #btn_ng_view_disposition').val(fkng);
		});
	}
	
	function fn_view_ng_attachments(fkng) {
		$('#tbl_view_attachments_ng tbody').empty();
		var data = {
			"action" 	 : "view_ng_attachments",
			"fkng" 		 : fkng
		}
		call_ajax( data, handler_qfr_ng, function(result) {
			console.log('modal_attachment_viewer');
			$('#tbl_view_attachments_ng tbody').append(result['table_body']);
			$('#modal_sa_attachment_viewer').data('id',fkng);
			$('#modal_sa_attachment_viewer').modal('show');
		});
	}
	
	function fn_dl_disposition_attachment(fkng,folder,file_name) {
		window.location.href = "./pages/qfr/dl_ng_treatment.php?id="+fkng+"&folder="+folder+'&file_name='+encodeURIComponent(file_name);
	}
	
	/* ************************************** 
		Start - Report
	************************************** */
	
	$('#btn_report_ng').click(function() {
		$('#container_ng_supplier').show();
		fn_return_fiscal_year('cmb_ng_fy_start');
		fn_return_fiscal_year('cmb_ng_fy_end');
		$('.chosen-select#cmb_ng_section').chosen({width:"100%", height: "100%"});		
		re_initialize_select2_server_side('#modal_ng_report #supplier','#modal_ng_report #frm_export_ng_report',[],"server_side_scripts/dropdown/qfr/dd_ng_supplier_list.php");		
		$('#modal_ng_report').modal();
	});

	$('#frm_export_ng_report').on('submit', function(e) {
		e.preventDefault();
		var report_type = $('#cmb_ng_report_type').val();
		var ng_fy_start = $('#cmb_ng_fy_start').val();
		var ng_fy_end 	= $('#cmb_ng_fy_end').val();
		var ng_supplier	= $('#modal_ng_report #supplier').val();
		var ng_section 	= JSON.stringify($('#cmb_ng_section').val());
		if(report_type == 'dispo_summary') {
			window.location.href = './reports/qfr/ng/excel_ng_report_disposition.php?rt='+report_type+'&fs='+ng_fy_start+'&fe='+ng_fy_end+'&sp='+ng_supplier+'&sc='+ng_section;
		} else if(report_type == 'dispo_leadtime_first') {
			window.location.href = './reports/qfr/ng/excel_ng_report_disposition_first.php?rt='+report_type+'&fs='+ng_fy_start+'&fe='+ng_fy_end+'&sp='+ng_supplier+'&sc='+ng_section;
		} else if(report_type == 'dispo_leadtime_final') {
			window.location.href = './reports/qfr/ng/excel_ng_report_disposition_final.php?rt='+report_type+'&fs='+ng_fy_start+'&fe='+ng_fy_end+'&sp='+ng_supplier+'&sc='+ng_section;
		} else if(report_type == 'ng_report_issuance_per_supplier') {
			window.location.href = './reports/qfr/ng/excel_ng_report_issuance_per_supplier.php?rt='+report_type+'&fs='+ng_fy_start+'&fe='+ng_fy_end+'&sc='+ng_section;
		} else if(report_type == 'ng_report_per_material_type') {
			alert('For development :) ');
			// window.location.href = './reports/excel_ng_report_per_material_type.php?rt='+report_type+'&fs='+ng_fy_start+'&fe='+ng_fy_end+'&sc='+ng_section;
		} 
	});

	$('#frm_export_ng_report #cmb_ng_report_type').change(function() {
		if($(this).val() == 'ng_report_issuance_per_supplier' || $(this).val() == 'ng_report_per_material_type') {
			$('#modal_ng_report #supplier').prop('required',false);
			$('#container_ng_supplier').hide();
		} else {
			$('#modal_ng_report #supplier').prop('required',true);
			$('#container_ng_supplier').show();
		}
	});
	
	function fn_return_fiscal_year(cmb_id) {
		$('#'+cmb_id).empty();
		var data = {
			"action" 		: "get_fiscal_year"
		} 
		call_ajax(data, handler_qfr, function(result){
			$('#'+cmb_id).append( result['html_select'] );
		});
	}
	
	/* ************************************** 
		End - Report
	************************************** */
	
	/* ************************************** 
		Start - Advanced Search 
	************************************** */
	var global_ng_as_where		 		= '';
	var ng_as_select_ctr				= 1;
	
	$('#btn_ng_advanced_search').click(function(){
		if( global_ng_as_where == ""){
			$('#tbl_ng_advance_search tbody').empty();
			fn_ng_as_draw_row('cmb_ng_as_field0');
			fn_ng_return_visual_inspection_fields('cmb_ng_as_field0');
		}
		$('#modal_ng_advance_search').modal('show');
	});
	
	$('#frm_ng_advance_search #btn_ng_as_add').click(function() {
		ng_as_select_ctr++;
		var select_id = 'cmb_ng_as_field'+ng_as_select_ctr;
		fn_ng_as_draw_row(select_id);
		fn_ng_return_visual_inspection_fields(select_id);
	});
	
	$('#frm_ng_advance_search #btn_ng_as_reset').click(function() {
		global_ng_as_where = '';
		$('#tbl_ng_advance_search tbody').empty();
		fn_ng_as_draw_row('cmb_ng_as_field0');
		fn_ng_return_visual_inspection_fields('cmb_ng_as_field0');
		dt_ng.ajax.url("server_side_scripts/qr/dt_ng.php?un="+username+"&wh="+global_ng_as_where).load();
	});
	
	$('#frm_ng_advance_search').on('submit', function(e) {
		e.preventDefault();
		var serialized_data = $(this).serialize();
		fn_ng_advance_search(serialized_data);
		$('#modal_ng_advance_search').modal('hide');
		vir_as_select_ctr = 0;
	});

	/* change the input type once date is selected */
	$('#tbl_ng_advance_search tbody').on('change', 'tr td:eq(0) select', function(){
		var select_value = $(this).val();
		var selected_row = $(this).closest('tr');
		var row_index 	= selected_row.index();
		if(select_value == "issuance_date"){
			selected_row.find('td:eq(2)').html('<input type="text" class="form-control ui-datepicker" name="val[]" id="txt_date_range" placeholder="Click to add date" required readonly>');
			selected_row.find('td:eq(1) select').empty();
			selected_row.find('td:eq(1) select').append('<option value="BETWEEN">BETWEEN</option>');
			date_time_picker('tbl_ng_advance_search tr:eq('+row_index+') #txt_date_range');
		}else{
			selected_row.find('td:eq(2)').html('<input type="text" id="cmb_ng_as_value" name="val[]" class="form-control condensed" required>');
			selected_row.find('td:eq(1) select').empty();
			selected_row.find('td:eq(1) select').append('<option value="EQUALS"> EQUALS </option>');
			selected_row.find('td:eq(1) select').append('<option value="LIKE"> CONTAINS </option>');
		}
	});

	$('#tbl_ng_advance_search tbody').on('click', 'button[type="button"]', function() {
		$(this).closest('tr').remove();
		return false;
	});
	
	function fn_ng_as_draw_row(select_id){
		var row  = '<tr>';
			row += '	<td style="width:30%;">';
			row += '		<select id="'+select_id+'" name="field_name[]" class="form-control condensed" required>';
			row += '		</select>';
			row += '	</td>';
			row += '	<td style="width:20%;">';
			row += '		<select id="cmb_ng_as_condition" name="condition[]" class="form-control condensed" required>';
			row += '			<option value="EQUALS"> EQUALS </option>';
			row += '			<option value="LIKE"> CONTAINS </option>';
			row += '		</select>';
			row += '	</td>';
			row += '	<td style="width:40%;">';
			row += '		<input type="text" id="cmb_ng_as_value" name="val[]" class="form-control condensed" required>';
			row += '	</td>';
			row += '	<td style="width:10%;">';
			row += '		<button type="button" id="btn_ng_as_remove" class="btn btn-default fa fa-trash"> Remove</button>';
			row += '	</td>';
			row += '</tr>';
		$('#tbl_ng_advance_search tbody').append(row);
	}

	function fn_ng_return_visual_inspection_fields(select_id){
		var data = {
			"action"	: "qfr_return_ng_fields"
		}
		call_ajax(data, handler_qfr, function(result){	
			for(var i=0; i < result['ctr']; i++) {
				$('#'+select_id).append(result['option'][i]);
			}
		});
	}

	function fn_ng_advance_search(serialized_data) {
		var data = {
			"action"	: "sa_advance_search"
		}
		call_ajax_serialize(data, serialized_data, handler_qfr, function(result){	
			//// console.log(result);
			global_ng_as_where = encodeURIComponent(result['sql_where']);
			dt_ng.ajax.url("server_side_scripts/qr/dt_ng.php?un="+username+"&wh="+global_ng_as_where).load();
		});
	}

	function fn_get_ng_supplier_list(cmb_id, callback) {
		$('.chosen-select option#'+cmb_id).prop('selected', false).trigger('chosen:updated'); 
		$('#'+cmb_id).empty();
		var data = {
			"action" 		: "get_supplier_list"
		} 
		call_ajax(data, handler_qfr, function(result){
			$('#'+cmb_id).append( '<option value="">-</option>' );
			$('#'+cmb_id).append( result['html_select'] );
			callback();
		});
	}

	function fn_get_ng_material_type_list(cmb_id, callback) {
		$('.chosen-select option#'+cmb_id).prop('selected', false).trigger('chosen:updated'); 
		$('#'+cmb_id).empty();
		var data = {
			"action" 		: "get_material_type_list"
		} 
		call_ajax(data, handler_qfr, function(result){
			$('#'+cmb_id).append( '<option value="">-</option>' );
			$('#'+cmb_id).append( result['html_select'] );
			callback();
		});
	}
	
	function fn_get_supplier_email_address(supplier, category, id) { //nmodify
		
		var data = {
			"action" 		: "get_supplier_ng_email_address",
			"supplier"		: supplier,
			"field_name"	: category
		}
		call_ajax(data, handler_qfr_ng, function(result) {
			assign_value_select2('#'+id,result['email_add']);
			console.log(result);
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

	function fn_ng_load_email_recipients(txt_to_id, txt_cc_id) {
		var data = {
			"action" 		: "get_email_recipients_by_category",
			"qfr_category"	: 'ng'
		} 
		call_ajax(data, handler_qfr_ng, function(result){
			console.log(result);
			assign_value_select2('#'+txt_to_id,result['to']);
			assign_value_select2('#'+txt_cc_id,result['cc']);
			re_initialize_select2_server_side('#modal_ng_send_supplier #'+txt_to_id,'#modal_ng_send_supplier #frm_send_report_internal',[],"server_side_scripts/dropdown/common/dd_hris_email_list.php");
			re_initialize_select2_server_side('#modal_ng_send_supplier #'+txt_cc_id,'#modal_ng_send_supplier #frm_send_report_internal',[],"server_side_scripts/dropdown/common/dd_hris_email_list.php");
		});
	}
	
	function fn_get_supplier_by_pkid(pkid) {
		var data = {
			"action" 	: "get_supplier_by_pkid",
			"pkid"		: pkid
		}
		call_ajax(data, handler_qfr_ng, function(result) {
			assign_value_select2('#frm_send_report_internal #supplier',result['supplier']);
			fn_get_supplier_email_address(result['supplier_name'], 'recipients_to', 'cmb_ng_send_external_to');
			fn_get_supplier_email_address(result['supplier_name'], 'recipients_cc', 'cmb_ng_send_external_cc');
			fn_ng_load_email_recipients('cmb_ng_send_to','cmb_ng_send_cc'); 
			re_initialize_select2_server_side('#modal_ng_send_supplier #supplier','#modal_ng_send_supplier #frm_send_report_internal',[],"server_side_scripts/dropdown/qfr/dd_ng_supplier_list.php");
		});
	}
	
	/* ************************************** 
		End - Advanced Search 
	************************************** */

/* **************************************************
	NG Report / Special Acceptance - End
/***************************************************/