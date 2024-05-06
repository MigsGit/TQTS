/* ***************************
	PTIS - Start
/****************************/

$(document).ready(function(){
	
	var dt_special_acceptance = $('#tbl_ptis').DataTable({
		"aaSorting"	: [],
		"bProcessing": true,
        "bServerSide": true,
		"sAjaxSource": "server_side_scripts/qr/dt_ptis.php?username="+username,
		rowGroup: {
			dataSrc: 3
		},
		"drawCallback": function( settings ) {
			$('#tbl_ptis').attr('style','width:100%;');
		}
	});
	
	/* ************************************** 
		Start - Advanced Search 
	************************************** */
	var global_ptis_as_where		 	= '';
	var ptis_as_select_ctr				= 1;
	
	$('#btn_ptis_advanced_search').click(function(){
		if( global_ptis_as_where == ""){
			$('#tbl_ptis_advance_search tbody').empty();
			fn_ptis_as_draw_row('cmb_ptis_as_field0');
			fn_ptis_return_visual_inspection_fields('cmb_ptis_as_field0');
		}
		$('#modal_ptis_advance_search').modal('show');
	});
	
	$('#frm_ptis_advance_search #btn_ptis_as_add').click(function() {
		ptis_as_select_ctr++;
		var select_id = 'cmb_ptis_as_field'+ptis_as_select_ctr;
		fn_ptis_as_draw_row(select_id);
		fn_ptis_return_visual_inspection_fields(select_id);
	});
	
	$('#frm_ptis_advance_search #btn_ptis_as_reset').click(function() {
		global_ptis_as_where = '';
		$('#tbl_ptis_advance_search tbody').empty();
		fn_ptis_as_draw_row('cmb_ptis_as_field0');
		fn_ptis_return_visual_inspection_fields('cmb_ptis_as_field0');
		dt_special_acceptance.ajax.url("server_side_scripts/qr/dt_ptis.php?username="+username+"&wh="+global_ptis_as_where).load();
	});
	
	$('#frm_ptis_advance_search').on('submit', function(e) {
		e.preventDefault();
		var serialized_data = $(this).serialize();
		fn_ptis_advance_search(serialized_data);
		$('#modal_ptis_advance_search').modal('hide');
		vir_as_select_ctr = 0;
	});

	/* change the input type once date is selected */
	$('#tbl_ptis_advance_search tbody').on('change', 'select[name="field_name[]"]', function(){
		var select_value = $(this).val();
		var selected_row = $(this).closest('tr');
		var row_index 	= selected_row.index();
		if(select_value == "`ptis`.`regDate`" || select_value == "`po`.`shipDate`"){
			selected_row.find('td:eq(2)').html('<input type="text" class="form-control ui-datepicker" name="val[]" id="txt_date_range" placeholder="Click to add date" required readonly>');
			selected_row.find('td:eq(1) select').empty();
			selected_row.find('td:eq(1) select').append('<option value="BETWEEN">BETWEEN</option>');
			date_time_picker('tbl_ptis_advance_search tr:eq('+row_index+') #txt_date_range');
		}else{
			selected_row.find('td:eq(2)').html('<input type="text" id="cmb_ptis_as_value" name="val[]" class="form-control condensed" required>');
			selected_row.find('td:eq(1) select').empty();
			selected_row.find('td:eq(1) select').append('<option value="EQUALS"> EQUALS </option>');
			selected_row.find('td:eq(1) select').append('<option value="LIKE"> CONTAINS </option>');
		}
	});

	$('#tbl_ptis_advance_search tbody').on('click', 'button[type="button"]', function() {
		$(this).closest('tr').remove();
		return false;
	});
	
	function fn_ptis_as_draw_row(select_id){
		var row  = '<tr>';
			row += '	<td style="width:30%;">';
			row += '		<select id="'+select_id+'" name="field_name[]" class="form-control condensed" required>';
			row += '		</select>';
			row += '	</td>';
			row += '	<td style="width:20%;">';
			row += '		<select id="cmb_ptis_as_condition" name="condition[]" class="form-control condensed" required>';
			row += '			<option value="EQUALS"> EQUALS </option>';
			row += '			<option value="LIKE"> CONTAINS </option>';
			row += '		</select>';
			row += '	</td>';
			row += '	<td style="width:40%;">';
			row += '		<input type="text" id="cmb_ptis_as_value" name="val[]" class="form-control condensed" required>';
			row += '	</td>';
			row += '	<td style="width:10%;">';
			row += '		<button type="button" id="btn_ptis_as_remove" class="btn btn-default fa fa-trash"> Remove</button>';
			row += '	</td>';
			row += '</tr>';
		$('#tbl_ptis_advance_search tbody').append(row);
	}

	function fn_ptis_return_visual_inspection_fields(select_id){
		var data = {
			"action"	: "qfr_return_ptis_fields"
		}
		call_ajax(data, handler_qfr, function(result){	
			for(var i=0; i < result['ctr']; i++) {
				$('#'+select_id).append(result['option'][i]);
			}
		});
	}

	function fn_ptis_advance_search(serialized_data) {
		var data = {
			"action"	: "ptis_advance_search"
		}
		call_ajax_serialize(data, serialized_data, handler_qfr, function(result){	
			//console.log(result);
			global_ptis_as_where = encodeURIComponent(result['sql_where']);
			dt_special_acceptance.ajax.url("server_side_scripts/qr/dt_ptis.php?username="+username+"&wh="+global_ptis_as_where).load();
		});
	}

	/* ************************************** 
		End - Advanced Search 
	************************************** */
});
/* ***************************
	PTIS - End
/****************************/