/* ***************************
	Special Acceptance - Start
/****************************/

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
	
	setTimeout(function(){
		/* view or edit special acceptance */
		$('#tbl_special_acceptance tbody').on('click', 'tr .fa-edit', function(){
			$('#modal_sa_edit').data('id',this.id);
			fn_load_special_acceptance(this.id,'edit');
			$('#modal_sa_edit').modal('show');
			fn_sa_hide_text_fields('frm_sa_edit','');
		});
		$('#tbl_special_acceptance tbody').on('click', 'tr .fa-plus', function(){
			$('#modal_sa_edit').data('id',this.id);
			fn_load_special_acceptance(this.id,'view');
			$('#modal_sa_edit').modal('show');
			fn_sa_hide_text_fields('frm_sa_edit','');
		});
		$('#tbl_special_acceptance tbody').on('click', 'tr .fa-eye', function(){
			$('#modal_sa_edit').data('id',this.id);
			fn_load_special_acceptance(this.id,'view');
			$('#modal_sa_edit').modal('show');
			fn_sa_hide_text_fields('frm_sa_edit','');
		});
		$('#tbl_special_acceptance tbody').on('click', 'tr a#a_download_excel', function(){
			var pkid = $(this).data('id');
			var data = {
				"action"	: "check_sa_judgement",
				"pkid"		: pkid
			}
			call_ajax(data, handler_qfr, function(result){
				console.log(result);
				if(result['judgement'] == 'No judgement'){
					window.location.href = "reports/excel_qfr_sa_report.php?pkid="+pkid;
				} else if(result['judgement'] == ''){
					alert('There was an error with your file!');
				} else {
					window.location.href = "reports/excel_qfr_sa_report_download.php?id="+pkid;
				}
			});
		});
		$('#tbl_special_acceptance tbody').on('click', 'tr .fa-remove', function(){
			var parts_and_prod_details = $(this).closest('tr').find('td:eq(1)').text();
			$('#frm_sa_cancel #label_info').text(parts_and_prod_details);
			$('#modal_sa_cancel').data('id',this.id);
			$('#modal_sa_cancel').modal('show');
		});
		$('#frm_sa_edit select[name="category"]').change(function(){
			var category = $(this).val();
			fn_sa_hide_text_fields('frm_sa_edit',category);
		});
	},500);
	
	fn_sa_hide_text_fields('frm_sa','');
	
	$('#frm_sa select[name="category"]').change(function(){
		var category = $(this).val();
		fn_sa_hide_text_fields('frm_sa',category);
	});	
	
	$('#btn_sa').click(function(){
		fn_generate_sa_control_number_view();
		$('#modal_sa').data('id',0);
		fn_empty_sa_fields('frm_sa');
		$('#modal_sa').modal('show');
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
		var array_fields = [
			'input[name="device_name"]',
			'input[name="po_qty"]',
			'input[name="drawing_number"]',
			'input[name="customer_name"]'
		]
		fn_get_po_details(po_number,'frm_sa',array_fields);
	});
	
	$('#frm_sa select[name="judged_by"]').change(function(){
		var judged_by = $(this).val();
		if (judged_by == "YEC QC"){
			$('#frm_sa #container_approver_name').hide();
			$('#container_approver_name .col-sm-4').empty();
		}else if(judged_by == "PMI Technical Adviser"){
			$('#frm_sa #container_approver_name').show();
			get_sa_approvers('frm_sa','judged_by_approver','Technical Adviser');
		}else if(judged_by == "Others"){
			$('#frm_sa #container_approver_name').show();
			get_sa_approvers('frm_sa','judged_by_approver','PMI');
		}
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
		fn_get_partname(code,'frm_sa');
	});
	
	$('#btn_report_ordinates').click(function(){
		$('#modal_report_ordinates').modal('show');
	});
	
	$('#frm_sa').submit(function(e){
		e.preventDefault();
		var form_data = new FormData(this);
			form_data.append("action","save_special_acceptance");
			form_data.append("pkid",$('#modal_sa').data('id'));
			form_data.append("upload_type","new");
			form_data.append("username",username);
			fn_save_special_acceptance(form_data);
	});
	
	$('#frm_sa_edit #replace_image').click(function(){
		// var attachment_pkid = $('#frm_sa_edit a[id="uploaded_image"]').data('id');
		// $('#modal_sa_replace_image').data('id',attachment_pkid);
		$('#modal_sa_replace_image').modal('show');
	});
	
	$('#frm_sa_replace_image').submit(function(e){
		e.preventDefault();
		var form_data = new FormData(this);
			form_data.append("action","replace_sa_image");
			form_data.append("attachment_pkid",$('#modal_sa_edit').data('id'));
			form_data.append("username",username);
			fn_sa_replace_image(form_data);
	});
	
	$('#frm_sa_edit').submit(function(e){
		e.preventDefault();
		$(this).find('input').prop('disabled',false);
		$(this).find('select').prop('disabled',false);
		$(this).find('textarea').prop('disabled',false);
		var form_data = new FormData(this);
			form_data.append("action","edit_special_acceptance");
			form_data.append("pkid",$('#modal_sa_edit').data('id'));
			form_data.append("username",username);
		fn_edit_special_acceptance(form_data);
	});
	
	$('#frm_sa_edit select[name="judged_by"]').change(function(){
		var judged_by = $(this).val();
		if (judged_by == "YEC QC"){
			$('#frm_sa_edit #container_approver_name').hide();
			$('#container_approver_name .col-sm-4').empty();
		}else if(judged_by == "PMI Technical Adviser"){
			$('#frm_sa_edit #container_approver_name').show();
			get_sa_approvers('frm_sa_edit','judged_by_approver','Technical Adviser');
		}else if(judged_by == "Others"){
			$('#frm_sa_edit #container_approver_name').show();
			get_sa_approvers('frm_sa_edit','judged_by_approver','PMI');
		}
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
				//console.log(result);
				$('.modal').modal('hide');
				dt_special_acceptance.ajax.reload();
			},error	: function(result){
				console.log(result+' error');
			}
		});
	}
	
	function fn_sa_replace_image(form_data){
		$.ajax({
			url		: handler_qfr, 		// Url to which the request is send
			type	: "POST",           	// Type of request to be send, called as method
			dataType: "JSON",           	// Type of request to be send, called as method
			data	: form_data, 			// Data sent to server, a set of key/value pairs (i.e. form fields and values)
			contentType: false,       		// The content type used when sending data to the server.
			cache: false,             		// To unable request pages to be cached
			processData:false,        		// To send DOMDocument or non processed data file it is set to false
			success: function(result){  	// A function to be called if request succeeds
				console.log(result);
				$('#modal_sa_replace_image input').val('');
				$('#modal_sa_replace_image').modal('hide');
				fn_load_special_acceptance($('#modal_sa_edit').data('id'),'edit');
			},error	: function(result){
				console.log(result+' error');
			}
		});
	}
	
	function fn_edit_special_acceptance(form_data){
		call_ajax_attachment(form_data, handler_qfr, function(result){
			console.log(result);
			var modal_system_message_id = "modal_sa_system_message";
			var ctr = 1;
			if(result['error'].length != 0){
				$('.modal').modal('hide');
				$('#'+modal_system_message_id+' #div_system_message').empty();
				$('#'+modal_system_message_id+' #div_system_message').attr("class","alert alert-danger");
				$('#'+modal_system_message_id+' #div_system_message').append("<p>Error Upload:</p>");
				$.each(result['error'],function(key,value){
					$('#'+modal_system_message_id+' #div_system_message').append("<p>"+(ctr)+'. '+value+"</p>");
					ctr++;
				});			
				$('#'+modal_system_message_id+'').modal('show');
			}else{
				$('.modal').modal('hide');
				$('#'+modal_system_message_id+' #div_system_message').empty();
				$('#'+modal_system_message_id+' #div_system_message').attr("class","alert alert-success");
				$('#'+modal_system_message_id+' #div_system_message').append("Special acceptance has been successfully updated!");
				$('#'+modal_system_message_id+'').modal('show');
				fn_system_message_timer(modal_system_message_id);
				dt_special_acceptance.ajax.reload();
			}
		});
	}
	
	function fn_cancel_special_acceptance(serialized_data){
		var data = {
			"action"	: "cancel_special_acceptance",
			"pkid"		: $('#modal_sa_cancel').data('id'),
			"username"	: username
		}
		call_ajax_serialize(data, serialized_data,handler_qfr, function(result){
			//console.log(result);
			$('#modal_sa_cancel').modal('hide');
			dt_special_acceptance.ajax.reload();
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
		$('#'+frm_id+' #container_approver_name').hide();
	}
	
	function fn_load_special_acceptance(pkid,mode){
		var data = {
			"action"	: "load_special_acceptance",
			"pkid"		: pkid,
			"username"	: username
		}
		call_ajax(data, handler_qfr, function(result){
			//console.log(result);
			$('#frm_sa_edit .fa-save').show();
			$('#frm_sa_edit #container_uploaded_image').show();
			result['judgement_application'] == "" ? $('#frm_sa_edit #badge_status').text('Open') : $('#frm_sa_edit #badge_status').text('Closed');
			result['judgement_application'] == "" ? $('#frm_sa_edit #badge_status').attr('class','badge highlight-color-red') : $('#frm_sa_edit #badge_status').attr('class','badge highlight-color-green');
			// $('#frm_sa_edit label[id="label_control_number"]').text('Control #: '+result['control_number']);
			$('#frm_sa_edit input[name="control_number"]').val(result['control_number']);
			$('#frm_sa_edit select[name="category"]').val(result['category']);
			fn_sa_hide_text_fields('frm_sa_edit',result['category']);
			$('#frm_sa_edit a[id="uploaded_image"]').attr("href",result['attached_file_link']);
			$('#frm_sa_edit a[id="uploaded_image"]').data("id",result['attachhment_pkid']);
			$('#frm_sa_edit a[id="uploaded_image"]').text(result['file_name']);
			if(result['category'] == 'Parts'){
				$('#frm_sa_edit input[name="part_code"]').val(result['part_code']);
				$('#frm_sa_edit input[name="parts_affected_parts"]').val(result['parts_affected_parts']);
				$('#frm_sa_edit input[name="problem_parts"]').val(result['problem_parts']);
				$('#frm_sa_edit input[name="supplier"]').val(result['supplier']);
				$('#frm_sa_edit input[name="lot_number"]').val(result['lot_number']);
				$('#frm_sa_edit input[name="quantity"]').val(result['quantity']);
			}else{
				$('#frm_sa_edit input[name="po_number"]').val(result['po_number']);
				$('#frm_sa_edit input[name="po_qty"]').val(result['po_qty']);
				$('#frm_sa_edit input[name="device_name"]').val(result['device_name']);
				$('#frm_sa_edit input[name="problem_device"]').val(result['problem_device']);
				$('#frm_sa_edit input[name="parts_affected_device"]').val(result['parts_affected_device']);
				$('#frm_sa_edit input[name="affected_quantity"]').val(result['affected_quantity']);
				$('#frm_sa_edit input[name="customer_name"]').val(result['customer_name']);
				$('#frm_sa_edit input[name="shipment_date"]').val(result['shipment_date']);
			}
			$('#frm_sa_edit input[name="drawing_number"]').val(result['drawing_number']);
			$('#frm_sa_edit select[name="judged_by"]').val(result['judged_by']);
			$('#frm_sa_edit select[name="judgement_application"]').val(result['judgement_application']);
			$('#frm_sa_edit textarea[name="notation_remarks"]').text(result['notations_remarks']);
			$('#frm_sa_edit textarea[name="other_details"]').text(result['other_details']);
			$('#frm_sa_edit #container_approver_name').hide();
			if(result['judged_by_approver'] != ''){
				$('#frm_sa_edit #container_approver_name').show();
				$('#container_approver_name .col-sm-4').empty();
				var judged_by = result['judged_by'];
				if(judged_by == "PMI Technical Adviser"){
					$('#frm_sa #container_approver_name').show();
					get_sa_approvers('frm_sa_edit','judged_by_approver','Technical Adviser');
				}else if(judged_by == "Others"){
					$('#frm_sa #container_approver_name').show();
					get_sa_approvers('frm_sa_edit','judged_by_approver','PMI');
				}
				setTimeout(function(){
					$('#frm_sa_edit #container_approver_name .col-sm-4 select').val(result['judged_by_approver']).trigger('chosen:updated');
				},100);
			}
			
			
			
			$('#container_yec_disposition').hide();
			$('#container_yec_disposition .col-sm-4').empty();
			
			if(mode == 'edit'){
				$('#frm_sa_edit #replace_image').prop('disabled',false);
				$('#frm_sa_edit #container_disposition').hide();
				$('#frm_sa_edit #container_remarks').hide();
				$('#frm_sa_edit input,#frm_sa_edit select').prop('disabled',false);
				$('#frm_sa_edit input,#frm_sa_edit textarea').prop('disabled',false);
				if( result['judged_by'] != "YEC QC" ){
					get_sa_approvers('frm_sa_edit','judged_by_approver','');
				}
			}
			if(mode == 'view'){
				$('#frm_sa_edit .fa-save').hide();
				setTimeout(function(){
					$('#frm_sa_edit #container_approver_name').hide();
				},100);
				$('#frm_sa_edit #replace_image').prop('disabled',true);
				$('#frm_sa_edit input,#frm_sa_edit select,#frm_sa_edit textarea').prop('disabled',true);
				if(result['status'] == 1){
					return false;
				}
				/* check if the user is the approver */
				if( username == result['judged_by_approver'] ){
					$('#frm_sa_edit select[name="judgement_application"]').prop('disabled',false);
					$('#frm_sa_edit #container_disposition').show();
					$('#frm_sa_edit #container_remarks').show();
					$('#frm_sa_edit #container_remarks textarea').prop('disabled',false);
					$('#frm_sa_edit .fa-save').show();
				}else{
					if(result['judged_by'] == "YEC QC"){
						$('#container_yec_disposition').show();
						$('#container_yec_disposition .col-sm-4').append('<input type="file" class="form-control" name="file_yec_disposition">');
						$('#frm_sa_edit #container_disposition').show();
						$('#frm_sa_edit #container_remarks').show();
						$('#frm_sa_edit #container_remarks textarea').prop('disabled',true);
						$('#frm_sa_edit .fa-save').show();
					}else{
						$('#frm_sa_edit #container_disposition').hide();
						// $('#frm_sa_edit #container_remarks').hide();
					}
				}
				$('#frm_sa_edit select[name="judgement_application"]').val(result['judgement_application']);
				$('#frm_sa_edit textarea[name="notation_remarks"]').text(result['notations_remarks']);
				/* check role */
				if(result['role'] != "SUPERVISOR"){
					$('#frm_sa_edit input[name="file_yec_disposition"]').prop('disabled',true);
				}else{
					$('#frm_sa_edit input[name="file_yec_disposition"]').prop('disabled',false);
				}
			}
		});
	}
		
	function fn_sa_hide_text_fields(frm_id,category){
		/* hide containers for parts and device */
		$('#'+frm_id+' input[name="drawing_number"]').val(""); //empty drawing number
		$('#'+frm_id+' #container_parts').hide();
		$('#'+frm_id+' #container_device').hide();
		$('#'+frm_id+' #container_parts select, #'+frm_id+' #container_parts input').prop('required',false);
		$('#'+frm_id+' #container_device select, #'+frm_id+' #container_device input').prop('required',false);
		if(category == 'Parts'){
			/* display parts container */
			$('#'+frm_id+' #container_parts').show();
			$('#'+frm_id+' #container_parts select, #'+frm_id+' #container_parts input').prop('required',true);
		}else if(category == 'Device'){
			/* display device container */
			$('#'+frm_id+' #container_device').show();
			$('#'+frm_id+' #container_device select, #'+frm_id+' #container_device input').prop('required',true);
		}
	}
	
	function get_sa_approvers(frm_id,select_name,approver_type_check){
		var approver_type = [];
		if (approver_type_check == "YEC QC"){
			return false;
		}else if(approver_type_check == "PMI"){
			approver_type.push("");
		}else if(approver_type_check == "Technical Adviser"){
			approver_type.push("Technical Adviser");
		}else if(approver_type_check == ""){
			approver_type.push("");
		}else{
			return false;
		}
		var data = {
			"action"		: "get_report_approvers",
			"fk_module"		: ['4'],
			"approver_type"	: approver_type
		}
		console.log(data);
		call_ajax(data, handler_qfr, function(result){
			//console.log(result);
			$('#container_approver_name .col-sm-4').empty();
			var html  = '<select data-placeholder="Select Approver" class="chosen-select form-control" name="judged_by_approver" id="judged_by_approver" required>';
				html += '</select>';
			$('#container_approver_name .col-sm-4').append(html);
			$('#'+frm_id+' select[name="'+select_name+'"]').empty();
			$('#'+frm_id+' select[name="'+select_name+'"]').append(result['html_select']);
			$('#'+frm_id+' select[name="'+select_name+'"]').chosen({
				width	:	"95%"
			});
		});
	}
	
	function fn_generate_sa_control_number_view(){
		var data = {
			"action"	: "generate_sa_control_number_view",
			"username"	: username
		}
		call_ajax(data,handler_qfr,function(result){
			//console.log(result);
			$('#frm_sa input[name="control_number"]').val(result);
			
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
			//console.log(result);
			global_sa_as_where = encodeURIComponent(result['sql_where']);
			dt_special_acceptance.ajax.url("server_side_scripts/qr/dt_sa.php?username="+username+"&wh="+global_sa_as_where).load();
		});
	}

	/* ************************************** 
		End - Advanced Search 
	************************************** */
});
/* ***************************
	Special Acceptance - End
/****************************/