/* ***************************
	AYE Report - Start
/****************************/

$(document).ready(function(){
	var lot_number_selected = [];
	var quantity_selected 	= [];
	var pkid_selected	 	= [];
	var sub_total_qty	 	= 0;
	var global_aye_as_where		 		= '';
	var aye_as_select_ctr				= 1;
	var isset_lot_values	= 0;
	
	var dt_aye_report = $('#tbl_aye').DataTable({
		"aaSorting"	: [],
		"bProcessing": true,
        "bServerSide": true,
		"sAjaxSource": "server_side_scripts/qr/dt_aye.php?username="+username+"&wh="+global_aye_as_where,
		"rowCallback": function( row, data, index ) {
			if ( data[5] == "<i>[Pending]</i>" ) {
				$(row).css("background-color","ffcccc");
			}
		},
		"drawCallback": function( settings ) {
			$('#tbl_aye').attr('style','width:100%;');
		}
	});
	
	setTimeout(function(){
		/* view or edit special acceptance */
		$('#tbl_aye tbody').on('click', 'tr .fa-edit', function(){
			lot_number_selected = [];
			quantity_selected 	= [];
			pkid_selected	 	= [];
			$('#modal_aye_edit').data('id',this.id);
			$('#frm_aye_edit button[type="button"]').val(this.id);
			fn_load_aye_report('frm_aye_edit',this.id,'edit');
			isset_lot_values	= 0;
			$('#modal_aye_edit').modal('show');
		});
		$('#tbl_aye tbody').on('click', 'tr .fa-plus', function(){
			$('#modal_aye_add_judgement').data('id',this.id);
			$('#frm_aye_judgement button[type="button"]').val(this.id);
			fn_load_aye_report('frm_aye_judgement',this.id,'view');
			$('#modal_aye_add_judgement').modal('show');
			fn_aye_hide_text_fields('modal_aye_add_judgement','add');
		});
		$('#tbl_aye tbody').on('click', 'tr .fa-eye', function(){
			$('#modal_aye_edit').data('id',this.id);
			fn_load_aye_report('frm_aye_judgement',this.id,'view');
			$('#modal_aye_add_judgement').modal('show');
			fn_aye_hide_text_fields('modal_aye_add_judgement','view');
		});
		$('#tbl_aye tbody').on('click', 'tr .fa-times-circle', function(){
			$('#modal_aye_cancel').modal('show');
		});
		$('#tbl_aye tbody').on('click', 'tr #a_download_excel', function(){
			var status = $(this).data('id');
			var pkid = $(this).val();
			if(status == 'NO JUDGEMENT') {
				window.location.href = "reports/excel_qfr_aye_report.php?pkid="+pkid;
			} else if(status == 'WITH JUDGEMENT') {
				window.location.href = "reports/excel_qfr_aye_report_download.php?pkid="+pkid;
			}
		});
		$('#tbl_aye tbody').on('click', 'tr .fa-remove', function(){
			var parts_and_prod_details = $(this).closest('tr').find('td:eq(0)').text();
			$('#frm_aye_cancel #label_info').text(parts_and_prod_details);
			$('#modal_aye_cancel').data('id',this.id);
			$('#modal_aye_cancel').modal('show');
		});
		$('#frm_aye_edit select[name="category"]').change(function(){
			var category = $(this).val();
			fn_aye_hide_text_fields('frm_aye_edit',category);
		});
	},500);
	
	fn_aye_hide_text_fields('frm_aye','');
	
	$('#frm_aye select[name="category"]').change(function(){
		var category = $(this).val();
		fn_aye_hide_text_fields('frm_aye',category);
	});	
	
	$('#btn_aye').click(function(){
		// $('#modal_upload_aye').data('id',0);
		fn_empty_aye_fields('frm_aye');
		fn_generate_new_aye_control_no('frm_aye #control_number');
		$('#frm_aye #chk_with_part_code').trigger('click');
		$('#modal_aye').modal('show');
	});
	
	$('#frm_aye #chk_with_part_code').click(function() {
		if($(this).is(':checked')) {
			$('#frm_aye #partcode').prop('readonly', false);
			$('#frm_aye #partcode').prop('required', true);
			$('#frm_aye #partname').prop('required', true);
		} else {
			$('#frm_aye #chk_with_part_code').prop('required', false);
			$('#frm_aye #partcode').prop('readonly', true);
			$('#frm_aye #partcode').prop('required', false);
			$('#frm_aye #partname').prop('required', false);
		}
	});
	
	$('#frm_aye input[name="po_number"]').keyup(function(e){
		var key = e.which;
		if(key == 38 || key == 40){
			return false;
		}
		var pattern = $(this).val();
		fn_get_po_list(pattern,'list_aye_po');
	});
	
	$('#frm_aye input[name="po_number"]').change(function(e){
		var po_number = $(this).val();
		var array_fields = [
			'input[name="device_name"]',
			'input[name="po_qty"]',
			'input[name="drawing_number"]',
			'input[name="customer_name"]'
		]
		fn_get_po_details(po_number,'frm_aye',array_fields);
	});
	
	$('#frm_aye input[name="partcode"]').keyup(function(e){
		var key = e.which;
		if(key == 38 || key == 40){
			return false;
		}
		var pattern = $(this).val();
		fn_get_partcode_list(pattern,'list_aye_part_code');
	});
	
	$('#frm_aye input[name="partcode"]').change(function(e){
		var code = $(this).val();
		fn_get_partname(code,'frm_aye');		
	});
	
	$('#frm_aye button[name="add_lot_number"]').click(function() {
		fn_get_lot_number_list('', 'list_aye_lot_number_add', function() {
			$('#modal_aye_add_lot_number').modal();
		});		
	});
	
	$('#frm_aye_add_lot_number input[name="lot_number"]').keyup(function(e){
		var key = e.which;
		if(key == 38 || key == 40){
			return false;
		}
		var pattern = $(this).val();
		fn_get_lot_number_list(pattern,'list_aye_lot_number_add', function(){});
	});
	
	$('#frm_aye_add_lot_number input[name="lot_number"]').change(function(e){
		var lot_number = $(this).val();
		fn_get_quantity_by_lot_number(lot_number,'frm_aye_add_lot_number #quantity');
	});	
	
	$('#frm_aye_add_lot_number').submit(function(e){
		e.preventDefault();
		var html_body  = '<tr>';
			html_body += '<td>'+$('#frm_aye_add_lot_number input[name="lot_number"]').val()+'</td>';
			html_body += '<td>'+$('#frm_aye_add_lot_number input[name="quantity"]').val()+'</td>';
			html_body += '<td><a href="#" class="fa fa-remove"> Remove</a></td>';
			html_body += '</tr>';
		$('#frm_aye_add_lot_number table tbody').append(html_body);
		$('#frm_aye_add_lot_number input').val('');
		$('#frm_aye_add_lot_number input[name="lot_number"]').focus();
	});	
	
	$('#frm_aye_add_lot_number #tbl_lot_details tbody').on('click' , 'a', function(){
		$(this).closest('tr').remove();
		return false;
	});
		
	$('#btn_save_aye_lot_number_details').click(function() {
		sub_total_qty	 	= 0;
		$('#frm_aye_add_lot_number #tbl_lot_details tbody tr').each(function() {
			lot_number_selected.push( $(this).find('td:eq(0)').text() );
			quantity_selected.push( $(this).find('td:eq(1)').text() );
			pkid_selected.push( 0 );
			sub_total_qty += parseFloat($(this).find('td:eq(1)').text());
			$('#frm_aye input[name="quantity"]').val(sub_total_qty);
		});
		$('#modal_aye_add_lot_number').modal('hide');
	});
	
	$('#frm_aye').submit(function(e){
		e.preventDefault();
		if($('#frm_aye select[name="category"]').val() == 'Parts' && $('#frm_aye input[name="quantity"]').val() == '') {
			$('#modal_system_message').modal();
			$('#container_message').prop('class','alert alert-danger');
			$('#container_message').html( '<h4>No lot number selected!</h4>' );
		} else {
			$('.btn').prop("disabled",true);
			var form_data = new FormData(this);
				form_data.append("action","save_aye_report");
				form_data.append("pkid",$('#modal_aye').data('id'));
				form_data.append("username",username);
				
				call_ajax_attachment(form_data, handler_qfr_aye, function(result){
					//console.log(result);
					$('.modal').modal('hide');
					$('#modal_system_message').modal();
					$('#container_message').prop('class','alert alert-success');
					$('#container_message').html( '<h4>'+result['msg']+'</h4>' );
					if($('#frm_aye select[name="category"]').val() == 'Parts') {
						fn_add_aye_lot_numbers(result['pkid']);
					}
					dt_aye_report.ajax.reload();
					$('.btn').prop("disabled",false);
				});
		}
	});
	
	$('#frm_aye_edit #chk_with_part_code').click(function() {
		if($(this).is(':checked')) {
			$('#frm_aye_edit #partcode').prop('readonly', false);
			$('#frm_aye_edit #partcode').prop('required', true);
			$('#frm_aye_edit #partname').prop('required', true);
		} else {
			$('#frm_aye_edit #chk_with_part_code').prop('required', false);
			$('#frm_aye_edit #partcode').prop('readonly', true);
			$('#frm_aye_edit #partcode').prop('required', false);
			$('#frm_aye_edit #partname').prop('required', false);
		}
	});
	
	$('#frm_aye_edit input[name="po_number"]').keyup(function(e){
		var key = e.which;
		if(key == 38 || key == 40){
			return false;
		}
		var pattern = $(this).val();
		fn_get_po_list(pattern,'list_aye_po_edit');
	});
	
	$('#frm_aye_edit input[name="po_number"]').change(function(e){
		var po_number = $(this).val();
		var array_fields = [
			'input[name="device_name"]',
			'input[name="po_qty"]',
			'input[name="drawing_number"]',
			'input[name="customer_name"]'
		]
		fn_get_po_details(po_number,'frm_aye_edit',array_fields);
	});
	
	$('#frm_aye_edit input[name="partcode"]').keyup(function(e){
		var key = e.which;
		if(key == 38 || key == 40){
			return false;
		}
		var pattern = $(this).val();
		fn_get_partcode_list(pattern,'list_aye_part_code_edit');
	});
	
	$('#frm_aye_edit input[name="partcode"]').change(function(e){
		var code = $(this).val();
		fn_get_partname(code,'frm_aye_edit');
	});
	
	$('#frm_aye_edit #chk_reselect_image').click(function() {
		if($(this).is(':checked')) {
			$('#frm_aye_edit #file_aye').show();
			$('#frm_aye_edit #file_aye').prop('required', true);
			$('#frm_aye_edit #file_aye').attr('name', 'file_aye');
			$('#frm_aye_edit #illustration_file').hide();
		} else {
			$('#frm_aye_edit #file_aye').hide();
			$('#frm_aye_edit #file_aye').prop('required', false);
			$('#frm_aye_edit #file_aye').attr('name', '');
			$('#frm_aye_edit #illustration_file').show();
		}
	});
	
	$('#frm_aye_edit button[name="add_lot_number"]').click(function() {		
		// lot_number_selected = [];
		// quantity_selected 	= [];
		// pkid_selected	 	= [];
		if(lot_number_selected.length == 0) {
			fn_get_lot_number_by_fkaye('edit', 'frm_aye_edit_lot_number', $(this).val(), function() {
				$('#modal_aye_edit_lot_number').modal();
			});
		} else {
			$('#frm_aye_edit_lot_number table tbody').empty();
			var html_body = '';
			var total = '';
			for(var i=0; i<lot_number_selected.length; i++) {
				html_body += '<tr>';
				html_body += '<td>'+lot_number_selected[i]+'</td>';
				html_body += '<td>'+quantity_selected[i]+'</td>';
				html_body += '<td><a href="#" class="fa fa-remove"> Remove</a></td>';
				html_body += '<td style="display:none;">'+pkid_selected[i]+'</td>';
				html_body += '</tr>';
				total += quantity_selected[i];
			}				
			$('#frm_aye_edit_lot_number table tbody').append(html_body);
			$('#frm_aye_edit_lot_number input').val('');
			$('#frm_aye_edit_lot_number input[name="lot_number"]').focus();
			$('#modal_aye_edit_lot_number').modal();
		}
		isset_lot_values	= 1;
	});
	
	$('#frm_aye_edit_lot_number input[name="lot_number"]').keyup(function(e){
		var key = e.which;
		if(key == 38 || key == 40){
			return false;
		}
		var pattern = $(this).val();
		fn_get_lot_number_list(pattern,'list_aye_lot_number_edit', function(){});
	});
	
	$('#frm_aye_edit_lot_number input[name="lot_number"]').change(function(e){
		var lot_number = $(this).val();
		fn_get_quantity_by_lot_number(lot_number,'frm_aye_edit_lot_number #quantity');
	});	
	
	$('#frm_aye_edit_lot_number').submit(function(e){
		e.preventDefault();
		var html_body  = '<tr>';
			html_body += '<td>'+$('#frm_aye_edit_lot_number input[name="lot_number"]').val()+'</td>';
			html_body += '<td>'+$('#frm_aye_edit_lot_number input[name="quantity"]').val()+'</td>';
			html_body += '<td><a href="#" class="fa fa-remove"> Remove</a></td>';
			html_body += '<td style="display:none;">0</td>';
			html_body += '</tr>';
		$('#frm_aye_edit_lot_number table tbody').append(html_body);
		$('#frm_aye_edit_lot_number input').val('');
		$('#frm_aye_edit_lot_number input[name="lot_number"]').focus();
	});	
	
	$('#frm_aye_edit_lot_number #tbl_lot_details tbody').on('click' , 'a', function(){
		$(this).closest('tr').remove();
		return false;
	});
	
	$('#btn_update_lot_number_details').click(function() {
		sub_total_qty	 	= 0;
		$('#frm_aye_edit_lot_number #tbl_lot_details tbody tr').each(function() {
			pkid_selected.push( $(this).find('td:eq(3)').text() );
			lot_number_selected.push( $(this).find('td:eq(0)').text() );
			quantity_selected.push( $(this).find('td:eq(1)').text() );
			sub_total_qty += parseFloat($(this).find('td:eq(1)').text());
			$('#frm_aye_edit input[name="quantity"]').val(sub_total_qty);
		});
		console.log('pkid '+pkid_selected);
		console.log('lot number '+lot_number_selected);
		console.log('qty '+quantity_selected);
		$('#modal_aye_edit_lot_number').modal('hide');
	});
	
	$('#frm_aye_edit').submit(function(e) {
		e.preventDefault();
		$('.btn').prop("disabled",true);
		var form_data = new FormData(this);
			form_data.append("action","update_aye_report");
			form_data.append("pkid",$('#modal_aye_edit').data('id'));
			form_data.append("username",username);
			
			call_ajax_attachment(form_data, handler_qfr_aye, function(result){
				//console.log(result);
				$('.modal').modal('hide');
				$('#modal_system_message').modal();
				$('#container_message').html( '<h4>'+result['msg']+'</h4>' );
				if($('#frm_aye_edit select[name="category"]').val() == 'Parts' && isset_lot_values == 1) {
					fn_add_aye_lot_numbers($('#modal_aye_edit').data('id'));
				}
				dt_aye_report.ajax.reload();
				$('.btn').prop("disabled",false);
			});
	});
	$('#frm_aye_judgement button[name="add_lot_number"]').click(function() {
		fn_get_lot_number_by_fkaye('view', 'frm_aye_view_lot_number', $(this).val(), function() {
			$('#modal_aye_view_lot_number').modal();
		});
	});
	
	
	$('#modal_aye_add_judgement #judgement_file').change(function() {
		if($(this).val() != '') {
			$('#btn_submit_aye_judgement').submit();
		} else {
			$('#modal_aye_add_judgement #container_judgment_details').hide();
			$('#modal_aye_add_judgement #container_judgment_details_remarks').hide();
			$('#modal_aye_add_judgement #btn_add_judgement').hide();
		}
	});
	$('#frm_aye_upload_judgement').submit(function(e) {
		e.preventDefault();
		$('.btn').prop("disabled",true);
		var serialized_data = new FormData(this);
		fn_upload_aye_judgement(serialized_data);
	});
	
	$('#frm_aye_add_judgement').submit(function(e) {
		e.preventDefault();
		$('.btn').prop("disabled",true);
		var serialized_data = $(this).serialize();
		fn_add_aye_judgement(serialized_data);
	});
	
	function fn_generate_new_aye_control_no(txt_id) {
		var data = {
			"action" 		: "generate_new_aye_control_no",
			"username" 		: username
		} 
		call_ajax(data, handler_qfr_aye, function(result){
			$('#'+txt_id).val(result['control_no']);
		});
	}
	
	function fn_aye_hide_text_fields(frm_id,category){
		/* hide containers for parts and device */
		$('#'+frm_id+' #container_parts').hide();
		$('#'+frm_id+' #container_device').hide();
		$('#'+frm_id+' #container_parts select, #'+frm_id+' #container_parts input').prop('required',false);
		$('#'+frm_id+' #container_parts select[class="chosen-select"], #'+frm_id+' #container_parts input').prop('required',false);
		$('#'+frm_id+' #container_device select, #'+frm_id+' #container_device input').prop('required',false);
		if(category == 'Parts'){
			/* display parts container */
			$('#'+frm_id+' #container_parts').show();
			$('#'+frm_id+' #container_parts select, #'+frm_id+' #container_parts input').prop('required',true);
			$('#'+frm_id+' #container_parts select[class="chosen-select"], #'+frm_id+' #container_parts input').prop('required',false);
		}else if(category == 'Device'){
			/* display device container */
			$('#'+frm_id+' #container_device').show();
			$('#'+frm_id+' #container_device select, #'+frm_id+' #container_device input').prop('required',true);
		}
		if(frm_id == 'modal_aye_add_judgement' && category == 'add') {
			$('#'+frm_id+' #container_judgment_details').hide();
			$('#'+frm_id+' #container_judgment_details_remarks').hide();
			$('#'+frm_id+' #btn_add_judgement').hide();
			$('#'+frm_id+' #container_judgment_upload').show();
			$('#'+frm_id+' #judgement_file').val('');
		} else if(frm_id == 'modal_aye_add_judgement' && category == 'view') {
			$('#'+frm_id+' #container_judgment_details').show();
			$('#'+frm_id+' #container_judgment_details_remarks').show();
			$('#'+frm_id+' #btn_add_judgement').hide();
			$('#'+frm_id+' #container_judgment_upload').hide();
			$('#'+frm_id+' #judgement_file').val('');
		}
	}
	
	function fn_empty_aye_fields(frm_id){
		$('#'+frm_id+' #container_disposition').hide();
		$('#'+frm_id+' #container_disposition select,#frm_sa #container_disposition input').prop('required',false);
		$('#'+frm_id+' .alert').hide();
		$('#'+frm_id+' .alert').text('');
		$('#'+frm_id+' .alert').attr('class','alert alert-danger');
		$('#'+frm_id+' input').val('');
		$('#'+frm_id+' select').val('');
		$('#'+frm_id+' #container_approver_name').hide();
	}
	
	function fn_load_aye_report(frm_id,pkid,mode){
		var data = {
			"action"	: "load_aye_report_record",
			"pkid"		: pkid
		}
		call_ajax(data, handler_qfr_aye, function(result){
			fn_aye_hide_text_fields(frm_id,result['category']);
			if(result['category'] == 'Parts') {
				if(result['part_code'] != "") {
					$('#frm_aye_edit #chk_with_part_code').trigger('click');
				} else{
					$('#frm_aye_edit #chk_with_part_code').prop('required', false);
					$('#frm_aye_edit #partcode').prop('readonly', true);
					$('#frm_aye_edit #partcode').prop('required', false);
					$('#frm_aye_edit #partname').prop('required', false);
				}
				$('#'+frm_id+' #partcode').val( result['part_code'] );
				$('#'+frm_id+' #parts_affected_parts').val( result['parts_affected_parts'] );
				$('#'+frm_id+' #supplier').val( result['supplier'] );
				$('#'+frm_id+' #quantity').val( result['quantity'] );
			} else {				
				$('#'+frm_id+' #po_number').val( result['po_number'] );
				$('#'+frm_id+' #po_qty').val( result['po_qty'] );
				$('#'+frm_id+' #customer_name').val( result['customer_name'] );
				$('#'+frm_id+' #device_name').val( result['device_name'] );
				$('#'+frm_id+' #shipment_date').val( result['shipment_date'] );
			}
			$('#'+frm_id+' #control_number').val( result['control_no'] );
			$('#'+frm_id+' #date_issued').val( result['date_issued'] );
			$('#'+frm_id+' #category').val( result['category'] );
			$('#'+frm_id+' #sample_size').val( result['sample_size'] );
			$('#'+frm_id+' #percent_ng').val( result['percent_ng'] );
			$('#'+frm_id+' #remarks').val( result['remarks'] );
			$('#'+frm_id+' a[id="illustration_file"]').attr("href",result['file_path']);
			$('#'+frm_id+' a[id="illustration_file"]').data("id",result['file_path']);
			$('#'+frm_id+' a[id="illustration_file"]').html( '<span class="fa fa-file-image-o"></span> Download Image' );
			if(mode == 'edit') {
				$('#'+frm_id+' #chk_reselect_image').prop("checked", false);
				$('#frm_aye_edit #file_aye').hide();
				$('#frm_aye_edit #file_aye').prop('required', false);
				$('#frm_aye_edit #file_aye').attr('name', '');
				$('#frm_aye_edit #illustration_file').show();
				$('#modal_aye_edit .modal-title').html('<i class="fa fa-edit"></i> Edit AYE Report');
				
			} else if(mode == 'view') {
				$('#modal_aye_edit .modal-title').html('<i class="fa fa-eye"></i> View AYE Report');
			}  
			if(result['status'] == 'NO JUDGEMENT') {
				$('#modal_aye_add_judgement #container_aye_judgement_additional_info').show();
				$('#modal_aye_add_judgement #container_judgment_upload').show();
				$('#modal_aye_add_judgement .modal-title').html('<i class="fa fa-plus"></i> Add Judgement');
			} else if(result['status'] == 'WITH JUDGEMENT') {
				$('#modal_aye_add_judgement #container_judgment_details').show();
				$('#modal_aye_add_judgement #container_judgment_details_remarks').show();
				$('#modal_aye_add_judgement #container_judgment_upload').hide();
				$('#modal_aye_add_judgement #btn_add_judgement').hide();
				$('#modal_aye_add_judgement #container_aye_judgement_additional_info').hide();
				$('#container_judgment_details #aye_judgement').val( result['aye_judgement'] );
				$('#container_judgment_details #judgement_date').val( result['judgement_date'] );
				$('#container_judgment_details_remarks #judgement_remarks').val( result['judgement_remarks'] );
				$('#modal_aye_add_judgement .modal-title').html('<i class="fa fa-eye"></i> View Judgement');
			}
			$('#'+frm_id+' #file_aye').hide();
			$('#'+frm_id+' .btn-link').show();
		});
	}

	function fn_upload_aye_judgement(serialized_data) { 
		serialized_data.append("action","upload_aye_judgement");
		serialized_data.append("pkid",$('#modal_aye_add_judgement').data('id'));
		serialized_data.append("control_number",$('#frm_aye_judgement #control_number').val());
	
		call_ajax_attachment(serialized_data, handler_qfr_aye, function(result){
			//console.log(result);
			$('.btn').prop("disabled",false);
			if(result['msg'] == 'File was successfully uploaded to the system') {
				$('#modal_aye_add_judgement #container_judgment_details').show();
				$('#modal_aye_add_judgement #container_judgment_details_remarks').show();
				$('#modal_aye_add_judgement #btn_add_judgement').show();
				$('#container_judgment_details #aye_judgement').val( result['judgement'] );
				$('#container_judgment_details #judgement_date').val( result['j_date'] );
				$('#container_judgment_details_remarks #judgement_remarks').val( result['remarks'] );
			} else {
				$('#modal_system_message').modal();
				$('#container_message').attr( 'class', 'alert alert-danger');
				$('#container_message').html( '<h4>'+result['msg']+'</h4>' );
				$('#container_judgment_details').hide();
				$('#container_judgment_details_remarks').hide();
				$('#btn_add_judgement').hide();
			}
			
		});
	}
	
	function fn_add_aye_judgement(serialized_data) {
		var data = {
			"action" 		: "add_aye_judgement",
			"pkid" 			: $('#modal_aye_add_judgement').data('id'),
			"username" 		: username
		} 
		call_ajax_serialize(data, serialized_data, handler_qfr_aye, function(result){	
			$('#modal_aye_add_judgement').modal('hide');
			$('#modal_system_message').modal();
			$('#container_message').attr( 'class', 'alert alert-success');
			$('#container_message').html( '<h4>'+result['msg']+'</h4>' );
			$('.btn').prop("disabled",false);
			dt_aye_report.ajax.reload();
		});
	}
	
	function fn_add_aye_lot_numbers(fk_aye) {
		console.log('pkid '+pkid_selected);
		console.log('lot number '+lot_number_selected);
		console.log('qty '+quantity_selected);
		var data = {
			"action"		: "save_aye_lot_numbers",
			"fk_aye"		: fk_aye,
			"pkid"			: pkid_selected,
			"lot_number"	: lot_number_selected,
			"quantity"		: quantity_selected,
			"username"		: username,
		}
		call_ajax(data, handler_qfr_aye, function(result){
			console.log(result);
			lot_number_selected = [];
			quantity_selected 	= [];
			pkid_selected	 	= [];
		});
	}
	
	/* ************************************** 
		Start - Advanced Search 
	************************************** */	
	
	$('#btn_aye_advanced_search').click(function(){
		if( global_aye_as_where == ""){
			$('#tbl_aye_advance_search tbody').empty();
			fn_aye_as_draw_row('cmb_aye_as_field0');
			fn_aye_return_visual_inspection_fields('cmb_aye_as_field0');
		}
		$('#modal_aye_advance_search').modal('show');
	});
	
	$('#frm_aye_advance_search #btn_aye_as_add').click(function() {
		aye_as_select_ctr++;
		var select_id = 'cmb_aye_as_field'+aye_as_select_ctr;
		fn_aye_as_draw_row(select_id);
		fn_aye_return_visual_inspection_fields(select_id);
	});
	
	$('#frm_aye_advance_search #btn_aye_as_reset').click(function() {
		global_aye_as_where = '';
		$('#tbl_aye_advance_search tbody').empty();
		fn_aye_as_draw_row('cmb_aye_as_field0');
		fn_aye_return_visual_inspection_fields('cmb_aye_as_field0');
		dt_aye_report.ajax.url("server_side_scripts/qr/dt_aye.php?username="+username+"&wh="+global_aye_as_where).load();
	});
	
	$('#frm_aye_advance_search').on('submit', function(e) {
		e.preventDefault();
		var serialized_data = $(this).serialize();
		fn_aye_advance_search(serialized_data);
		$('#modal_aye_advance_search').modal('hide');
		vir_as_select_ctr = 0;
	});

	/* change the input type once date is selected */
	$('#tbl_aye_advance_search tbody').on('change', 'select[name="field_name[]"]', function(){
		var select_value = $(this).val();
		var selected_row = $(this).closest('tr');
		var row_index 	= selected_row.index();
		if(select_value == "date_issued" || select_value == "shipment_date" || select_value == "judgement_date"){
			selected_row.find('td:eq(2)').html('<input type="text" class="form-control ui-datepicker" name="val[]" id="txt_date_range" placeholder="Click to add date" required readonly>');
			selected_row.find('td:eq(1) select').empty();
			selected_row.find('td:eq(1) select').append('<option value="BETWEEN">BETWEEN</option>');
			date_time_picker('tbl_aye_advance_search tr:eq('+row_index+') #txt_date_range');
		}else{
			selected_row.find('td:eq(2)').html('<input type="text" id="cmb_aye_as_value" name="val[]" class="form-control condensed" required>');
			selected_row.find('td:eq(1) select').empty();
			selected_row.find('td:eq(1) select').append('<option value="EQUALS"> EQUALS </option>');
			selected_row.find('td:eq(1) select').append('<option value="LIKE"> CONTAINS </option>');
		}
	});

	$('#tbl_aye_advance_search tbody').on('click', 'button[type="button"]', function() {
		$(this).closest('tr').remove();
		return false;
	});
	
	function fn_aye_as_draw_row(select_id){
		var row  = '<tr>';
			row += '	<td style="width:30%;">';
			row += '		<select id="'+select_id+'" name="field_name[]" class="form-control condensed" required>';
			row += '		</select>';
			row += '	</td>';
			row += '	<td style="width:20%;">';
			row += '		<select id="cmb_aye_as_condition" name="condition[]" class="form-control condensed" required>';
			row += '			<option value="EQUALS"> EQUALS </option>';
			row += '			<option value="LIKE"> CONTAINS </option>';
			row += '		</select>';
			row += '	</td>';
			row += '	<td style="width:40%;">';
			row += '		<input type="text" id="cmb_aye_as_value" name="val[]" class="form-control condensed" required>';
			row += '	</td>';
			row += '	<td style="width:10%;">';
			row += '		<button type="button" id="btn_aye_as_remove" class="btn btn-default fa fa-trash"> Remove</button>';
			row += '	</td>';
			row += '</tr>';
		$('#tbl_aye_advance_search tbody').append(row);
	}

	function fn_aye_return_visual_inspection_fields(select_id){
		var data = {
			"action"	: "qfr_return_aye_fields"
		}
		call_ajax(data, handler_qfr_aye, function(result){	
			for(var i=0; i < result['ctr']; i++) {
				$('#'+select_id).append(result['option'][i]);
			}
		});
	}

	function fn_get_lot_number_by_fkaye(action, frm_id, fk_aye, callback) {
		$('#'+frm_id+' table tbody').empty();
		var data = {
			"action"	: "get_lot_number_by_fkaye",
			"fk_aye"	: fk_aye
		}
		call_ajax(data, handler_qfr_aye, function(result){
			console.log(result);
			if(action == 'edit') {
				$('#'+frm_id+' table tbody').append(result['table_body_edit']);
			} else {
				$('#'+frm_id+' table tbody').append(result['table_body_view']);
			}
			callback();
		});
	}
	
	function fn_aye_advance_search(serialized_data) {
		var data = {
			"action"	: "aye_advance_search"
		}
		call_ajax_serialize(data, serialized_data, handler_qfr_aye, function(result){	
			//console.log(result);
			console.log(global_aye_as_where);
			global_aye_as_where = encodeURIComponent(result['sql_where']);
			dt_aye_report.ajax.url("server_side_scripts/qr/dt_aye.php?username="+username+"&wh="+global_aye_as_where).load();
		});
	}

	
	/* ************************************** 
		End - Advanced Search 
	************************************** */
	
	/* ************************************** 
		Start - Report
	************************************** */
	
	$('#btn_report').click(function() {
		if(global_aye_as_where == '') {
			alert('Please select search keywords from Advance Search portion.');
		} else {
			window.location.href = "./reports/excel_qfr_aye_report_summary.php?username="+username+"&wh="+global_aye_as_where;
		}
	});
	/* ************************************** 
		End - Advanced Search 
	************************************** */
});
/* ***************************
	AYE Report - End
/****************************/