/* ***************************
	Attention Tag - Start
/****************************/
	var dt_tbl_attention_tag = $('#tbl_attention_tag').DataTable({
		"aaSorting"	 : [],
		"bProcessing": true,
        "bServerSide": true,
		"sAjaxSource": "server_side_scripts/qr/dt_at.php?username=ronfern&"+username,
		"drawCallback": function( settings ) {
			$('#tbl_attention_tag').attr('style','width:100%;');
		}
	});

	$('#btn_attention_tag_new').click(function(){
		$('#modal_itn_attention_tag').modal('show');
	});

	$('#frm_attention_tag_new').submit(function(e){
		e.preventDefault();
		var serialized_data = $(this).serialize();
		fn_save_attention_tag(serialized_data);
	});

	$('#frm_attention_tag_new').on('click','input[name="category[]"]',function(){
		var checkbox_value = $(this).val();
		var checked = $(this).prop('checked');
		fn_check_machine_selected('frm_attention_tag_new',checkbox_value,checked);
	});

	/* re initialize values for datalist */
	fn_get_partcode_list('','list_at_po');
	$('#frm_attention_tag_new input[name="chk_search_type"]').click(function(){
		var search_type = "";
		$('#frm_attention_tag_new input[name="chk_search_type"]').each(function(){
			if( $(this).prop('checked') ){
				search_type = $(this).val();
			}
		});
		if( search_type == 'parts'){
			fn_get_partcode_list('','list_at_po');
		}else{
			fn_get_po_list('','list_at_po');
		}
	});
	
	$('#frm_attention_tag_new input[name="partscode_pono"]').keyup(function(e){
		var key = e.which;
		if(key == 38 || key == 40){
			return false;
		}
		var pattern = $(this).val();
		var search_type = "";
		$('#frm_attention_tag_new input[name="chk_search_type"]').each(function(){
			if( $(this).prop('checked') ){
				search_type = $(this).val();
			}
		});
		if( search_type == 'parts'){
			fn_get_partcode_list(pattern,'list_at_po');
		}else{
			fn_get_po_list(pattern,'list_at_po');
		}
	});

	$('#frm_attention_tag_new input[name="partscode_pono"]').change(function(e){
		var code = $(this).val();
		var po = $(this).val();
		$('#frm_attention_tag_new input[name="chk_search_type"]').each(function(){
			if( $(this).prop('checked') ){
				search_type = $(this).val();
			}
		});
		if( search_type == 'parts'){
			fn_get_partname_place_in_input(code,'frm_attention_tag_new input[name="product"]');
			$('#frm_attention_tag_new input[name="model"]').val("");
		}else{
		    fn_get_devicename_by_po(po,'frm_attention_tag_new input[name="model"]');
			$('#frm_attention_tag_new input[name="product"]').val("");
		}
	});

	$('#frm_itn_attention_tag_edit').submit(function(e){
		e.preventDefault();
		var pkid = $('#modal_itn_attention_tag_edit').data('id');
		var serialized_data = $(this).serialize();
		fn_edit_attention_tag(serialized_data);
	});

	$('#tbl_attention_tag tbody').on('click','tr .fa-edit',function(){
		var pkid = this.id;
		fn_load_attention_tag('edit',pkid);
	});

	$('#tbl_attention_tag tbody').on('click','tr .fa-eye',function(){
		var pkid = this.id;
		fn_load_attention_tag('view',pkid);
	});
	var at_status = '';
	$('#tbl_attention_tag tbody').on('click','tr .fa-remove',function(){
		var pkid = this.id;
		var control_no = $(this).closest('tr').find('td:eq(1)').text();
			at_status = 'Closed';
		$('#modal_itn_attention_tag_change_status form p').text('Do you want to Close Attention Tag Control: ' + control_no);
		$('#modal_itn_attention_tag_change_status').data('id',pkid);
		$('#modal_itn_attention_tag_change_status').modal('show');
	});
	
	$('#tbl_attention_tag tbody').on('click','tr .fa-check',function(){
		var pkid = this.id;
		var control_no = $(this).closest('tr').find('td:eq(1)').text();
			at_status = 'Open';
		$('#modal_itn_attention_tag_change_status form p').text('Do you want to Re-Open Attention Tag Control: ' + control_no);
		$('#modal_itn_attention_tag_change_status').data('id',pkid);
		$('#modal_itn_attention_tag_change_status').modal('show');
	});
	
	$('#frm_itn_attention_tag_change_status').submit(function(e){
		e.preventDefault();
		var pkid = $('#modal_itn_attention_tag_change_status').data('id');
		fn_change_itn_at_status(pkid,at_status);
	});

	$('#tbl_attention_tag tbody').on('click','tr a',function(){
		var pkid = this.id;
		window.location.href = "reports/excel_qfr_attention_tag.php?pkid="+pkid;
	});

	function fn_get_at_search_fields(){
		
	}

	function fn_check_machine_selected(frm_id,value,checked){
		if(value == "Machine" && checked){
			$('#'+frm_id+' input[name="product"]').prop('disabled',true);
			$('#'+frm_id+' input[name="lot_number"]').prop('disabled',true);
			$('#'+frm_id+' input[name="quantity"]').prop('disabled',true);
			$('#'+frm_id+' input[name="product"]').val('N/A');
			$('#'+frm_id+' input[name="lot_number"]').val('N/A');
			$('#'+frm_id+' input[name="quantity"]').val('0');
		}else{
			$('#'+frm_id+' input[name="product"]').prop('disabled',false);
			$('#'+frm_id+' input[name="lot_number"]').prop('disabled',false);
			$('#'+frm_id+' input[name="quantity"]').prop('disabled',false);
			$('#'+frm_id+' input[name="product"]').val('');
			$('#'+frm_id+' input[name="lot_number"]').val('');
			$('#'+frm_id+' input[name="quantity"]').val('0');
		}
	}

	function fn_save_attention_tag(serialized_data){
		$('.btn').attr('disabled',true);
		var data = {
			"action"	:  "save_attention_tag",
			"username"	: username
		}
		call_ajax_serialize(data, serialized_data, handler_qfr, function(result){
			console.log(result);
			$('.modal').modal('hide');
			$('.btn').attr('disabled',false);
			$('#frm_attention_tag_new input').val("");
			$('#frm_attention_tag_new select').val("");
			$('#frm_attention_tag_new textarea').val("");
			dt_tbl_attention_tag.ajax.reload();
		});
	}

	function fn_edit_attention_tag(serialized_data){
		$('.btn').attr('disabled',true);
		var data = {
			"action"	:  "edit_attention_tag",
			"pkid"		: $('#modal_itn_attention_tag_edit').data('id'),
			"username"	: username
		}
		call_ajax_serialize(data, serialized_data, handler_qfr, function(result){
			//console.log(result);
			$('.modal').modal('hide');
			$('.btn').attr('disabled',false);
			$('#frm_attention_tag_new input').val("");
			$('#frm_attention_tag_new select').val("");
			$('#frm_attention_tag_new textarea').val("");
			dt_tbl_attention_tag.ajax.reload();
			$('.modal').modal('hide');
		});
	}

	function fn_load_attention_tag(view_type,pkid){
		var data = {
			"action"	: "load_attention_tag",
			"pkid"		: pkid,
			"username"	: username
		}
		call_ajax(data, handler_qfr, function(result){
			//console.log(result);
			$('#modal_itn_attention_tag_edit').data('id',result['pkid']);
			$('#frm_itn_attention_tag_edit input[type="text"]').val("");
			$('#frm_itn_attention_tag_edit input[type="number"]').val("");
			$('#frm_itn_attention_tag_edit input[type="date"]').val("");
			$('#frm_itn_attention_tag_edit textarea').val("");
			$('#frm_itn_attention_tag_edit .funkyradio input[type="checkbox"]').prop('checked',false);
			
			$('#frm_itn_attention_tag_edit input[name="product"]').attr('readonly',false);
			$('#frm_itn_attention_tag_edit input[name="lot_number"]').attr('readonly',false);
			$('#frm_itn_attention_tag_edit input[name="quantity"]').attr('readonly',false);
			$.each(result['category'], function(key,value){
				$('#frm_itn_attention_tag_edit .funkyradio input').each(function(){
					if(this.value == value){
						$(this).prop('checked',true);
					}
					if(value == "Machine"){
						$('#frm_itn_attention_tag_edit input[name="product"]').val('N/A');
						$('#frm_itn_attention_tag_edit input[name="lot_number"]').val('N/A');
						$('#frm_itn_attention_tag_edit input[name="quantity"]').val('0');
						$('#frm_itn_attention_tag_edit input[name="product"]').attr('readonly',true);
						$('#frm_itn_attention_tag_edit input[name="lot_number"]').attr('readonly',true);
						$('#frm_itn_attention_tag_edit input[name="quantity"]').attr('readonly',true);
					}
				});
			});
			$('#frm_itn_attention_tag_edit input[name="control_no"]').val(result['control_no']);
			$('#frm_itn_attention_tag_edit input[name="date"]').val(result['date']);
			$('#frm_itn_attention_tag_edit input[name="product"]').val(result['product']);
			$('#frm_itn_attention_tag_edit input[name="lot_number"]').val(result['lot_number']);
			$('#frm_itn_attention_tag_edit input[name="model"]').val(result['model']);
			$('#frm_itn_attention_tag_edit input[name="quantity"]').val(result['quantity']);
			$('#frm_itn_attention_tag_edit input[name="partscode_pono"]').val(result['partscode_pono']);
			$('#frm_itn_attention_tag_edit input[name="issued_by"]').val(result['issued_by']);
			$('#frm_itn_attention_tag_edit textarea[name="description"]').val(result['description']);
			$('#frm_itn_attention_tag_edit textarea[name="analysis"]').val(result['analysis']);
			$('#frm_itn_attention_tag_edit textarea[name="disposition"]').val(result['disposition']);
			$('#frm_itn_attention_tag_edit textarea[name="corrective_action"]').val(result['corrective_action']);
			$('#frm_itn_attention_tag_edit textarea[name="remarks"]').val(result['remarks']);
			$('#frm_itn_attention_tag_edit input[name="incharge"]').val(result['incharge']);
			$('#frm_itn_attention_tag_edit span[id="status"]').text(result['status']);
			if(result['status'] == "Open"){
				$('#frm_itn_attention_tag_edit span[id="status"]').attr('class','badge highlight-color-red');
			}else{
				$('#frm_itn_attention_tag_edit span[id="status"]').attr('class','badge highlight-color-green');
			}			
			if(view_type == "view"){
				$('#frm_itn_attention_tag_edit input[type="text"]').prop("disabled",true);
				$('#frm_itn_attention_tag_edit input[type="number"]').prop("disabled",true);
				$('#frm_itn_attention_tag_edit input[type="date"]').prop("disabled",true);
				$('#frm_itn_attention_tag_edit textarea').prop("disabled",true);
				$('#frm_itn_attention_tag_edit .funkyradio input[type="checkbox"]').prop("disabled",true);
				$('#modal_itn_attention_tag_edit .modal-footer .fa-save').hide();
			}else{
				$('#frm_itn_attention_tag_edit input[type="text"]').prop("disabled",false);
				$('#frm_itn_attention_tag_edit input[name="control_no"]').prop("disabled",true);
				$('#frm_itn_attention_tag_edit input[type="number"]').prop("disabled",false);
				$('#frm_itn_attention_tag_edit input[type="date"]').prop("disabled",false);
				$('#frm_itn_attention_tag_edit textarea').prop("disabled",false);
				$('#frm_itn_attention_tag_edit .funkyradio input[type="checkbox"]').prop("disabled",false);
				$('#modal_itn_attention_tag_edit .modal-footer .fa-save').show();
			}
			$('#modal_itn_attention_tag_edit').modal('show');
		});
	}
	
	function fn_change_itn_at_status(pkid,status){
		var data = {
			"action"	: "change_itn_at_status",
			"pkid"		: pkid,
			"status"	: status,
			"username"	: username
		}
		call_ajax(data, handler_qfr, function(result){
			dt_tbl_attention_tag.ajax.reload();
			$('.modal').modal('hide');
		});
	}

	/* **************************** 
		Start - Advanced Search 
	**************************** */
	var global_at_as_where		 		= '';
	var at_as_select_ctr				= 1;
	
	$('#btn_at_search_main').click(function(){
		if( global_at_as_where == ""){
			$('#tbl_at_advance_search tbody').empty();
			fn_at_as_draw_row('cmb_at_as_field0');
			fn_at_return_visual_inspection_fields('cmb_at_as_field0');
		}
		$('#modal_at_advance_search').modal('show');
	});

	$('#frm_at_advance_search #btn_at_as_add').click(function() {
		at_as_select_ctr++;
		var select_id = 'cmb_at_as_field'+at_as_select_ctr;
		fn_at_as_draw_row(select_id);
		fn_at_return_visual_inspection_fields(select_id);
	});

	$('#frm_at_advance_search #btn_at_as_reset').click(function() {
		global_at_as_where = '';
		$('#tbl_at_advance_search tbody').empty();
		fn_at_as_draw_row('cmb_at_as_field0');
		fn_at_return_visual_inspection_fields('cmb_at_as_field0');
		dt_tbl_attention_tag.ajax.url("server_side_scripts/qr/dt_at.php?username="+username+"&wh="+global_at_as_where).load();
	});

	$('#frm_at_advance_search').on('submit', function(e) {
		e.preventDefault();
		var serialized_data = $(this).serialize();
		fn_at_advance_search(serialized_data);
		$('#modal_at_advance_search').modal('hide');
		// $('#tbl_at_advance_search tbody').empty();
		vir_as_select_ctr = 0;
	});

	/* change the input type once date is selected */
	$('#tbl_at_advance_search tbody').on('change', 'select[name="field_name[]"]', function(){
		var select_value = $(this).val();
		var selected_row = $(this).closest('tr');
		var row_index 	= selected_row.index();
		if(select_value == "date"){
			selected_row.find('td:eq(2)').html('<input type="text" class="form-control ui-datepicker" name="val[]" id="txt_date_range" placeholder="Click to add date" required readonly>');
			selected_row.find('td:eq(1) select').empty();
			selected_row.find('td:eq(1) select').append('<option value="BETWEEN">BETWEEN</option>');
			date_time_picker('tbl_at_advance_search tr:eq('+row_index+') #txt_date_range');
		}else{
			selected_row.find('td:eq(2)').html('<input type="text" id="cmb_at_as_value" name="val[]" class="form-control condensed" required>');
			selected_row.find('td:eq(1) select').empty();
			selected_row.find('td:eq(1) select').append('<option value="EQUALS"> EQUALS </option>');
			selected_row.find('td:eq(1) select').append('<option value="LIKE"> CONTAINS </option>');
		}
	});

	$('#tbl_at_advance_search tbody').on('click', 'button[type="button"]', function() {
		$(this).closest('tr').remove();
		return false;
	});
	
	function fn_at_as_draw_row(select_id){
		var row  = '<tr>';
			row += '	<td style="width:30%;">';
			row += '		<select id="'+select_id+'" name="field_name[]" class="form-control condensed" required>';
			row += '		</select>';
			row += '	</td>';
			row += '	<td style="width:20%;">';
			row += '		<select id="cmb_at_as_condition" name="condition[]" class="form-control condensed" required>';
			row += '			<option value="EQUALS"> EQUALS </option>';
			row += '			<option value="LIKE"> CONTAINS </option>';
			row += '		</select>';
			row += '	</td>';
			row += '	<td style="width:40%;">';
			row += '		<input type="text" id="cmb_at_as_value" name="val[]" class="form-control condensed" required>';
			row += '	</td>';
			row += '	<td style="width:10%;">';
			row += '		<button type="button" id="btn_at_as_remove" class="btn btn-default fa fa-trash"> Remove</button>';
			row += '	</td>';
			row += '</tr>';
		$('#tbl_at_advance_search tbody').append(row);
	}

	function fn_at_return_visual_inspection_fields(select_id){
		var data = {
			"action"	: "qfr_return_at_fields"
		}
		call_ajax(data, handler_qfr, function(result){	
			for(var i=0; i < result['ctr']; i++) {
				$('#'+select_id).append(result['option'][i]);
			}
		});
	}

	function fn_at_advance_search(serialized_data) {
		var data = {
			"action"	: "at_advance_search"
		}
		call_ajax_serialize(data, serialized_data, handler_qfr, function(result){	
			//console.log(result);
			global_at_as_where = encodeURIComponent(result['sql_where']);
			dt_tbl_attention_tag.ajax.url("server_side_scripts/qr/dt_at.php?username="+username+"&wh="+global_at_as_where).load();
		});
	}
	/* ****************************
		End - Advanced Search 
	**************************** */
	
	/* **************************** 
		Start - Report
	**************************** */
	$('#btn_export_attention_tag_summary').click(function(){
		if(global_at_as_where == ""){
			alert("Please select a data to export!");
			return false;
		}
		var data = {
			"action"	: "at_advance_search"
		}
		var serialized_data = $('#frm_at_advance_search').serialize();
		call_ajax_serialize(data, serialized_data, handler_qfr, function(result){	
			global_at_as_where = encodeURIComponent(result['sql_where']);
			window.location.href = "reports/excel_qfr_attention_tag_summary.php?username="+username+"&wh="+global_at_as_where;
		});
		
	});
	/* **************************** 
		End - Report
	**************************** */
	
/* ***************************
	Attention Tag - End
/****************************/