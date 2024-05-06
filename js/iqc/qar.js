/* *************************************
    QAR Requestor Page - New Quality Alert Report - Start
****************************************/
$(document).ready(function() {
	var handler_iqc_qar 			= "handler/handler_iqc_qar.php";
	var iqc_qar_requestor_section 	= $('#txt_iqc_qar_requestor_section').val();
	
	/* Datatable */
	var dt_tbl_iqc_qar_requestor = $('#tbl_iqc_qar_requestor').DataTable({
		"aaSorting"	 	: [],
		"bProcessing"	: true,
		"bServerSide"	: true,
		"sAjaxSource"	: "server_side_scripts/iqc/dt_qar.php?username="+username,
		"drawCallback": function( settings ) {
			$('#tbl_iqc_qar_requestor').attr('style','width:100%;');
		}
	});
	
	var dt_tbl_iqc_qar_conformance = $('#tbl_iqc_qar_conformance').DataTable({
		"aaSorting"	 : [],
		"bProcessing": true,
		"bServerSide": true,
		"sAjaxSource": "server_side_scripts/iqc/dt_qar_conformance.php?username="+username,
		colReorder	 : true,
		"drawCallback": function() {
			$('#tbl_iqc_qar_conformance').attr('style','width:100%;');
		}
	});
	
	var dt_tbl_iqc_qar_recipient = $('#tbl_iqc_qar_recipient').DataTable({
		"aaSorting"	 : [],
		"bProcessing": true,
		"bServerSide": true,
		"sAjaxSource": "server_side_scripts/iqc/dt_qar_recipient.php?username="+username,
		colReorder   : true,
		"drawCallback": function() {
			$('#tbl_iqc_qar_recipient').attr('style','width:100%;');
		}
	});
	
	
	
	/* **************************
		QAR Requestor Page - QAR - View  Start
	****************************/
	var modal_id = 'modal_iqc_qar_view';
	$("#"+modal_id+" #cmb_to").select2({
		placeHolder	: "Please select a section",
		data 		: [
						{
							id: '',
							text: ''
						},
						{
							id: 'PPS',
							text: 'PPS'
						},
						{
							id: 'CN',
							text: 'CN'
						},
						{
							id: 'TS',
							text: 'TS'
						},
						{
							id: 'TS - WHS',
							text: 'TS - WHS'
						},
						{
							id: 'YF',
							text: 'YF'
						}
					]
	});
	
	$('#tbl_iqc_qar_requestor tbody').on('click','tr .fa-eye',function(){
		var id = $(this).attr('value');
		var modal_id = 'modal_iqc_qar_view';
		var frm_id = 'frm_iqc_qar_view';
		$('#'+frm_id+' input').prop('disabled',true);
		$('#'+frm_id+' select').prop('disabled',true);
		$('#'+frm_id+' textarea').prop('disabled',true);
		$('#'+modal_id).data('id',id);
		$('#'+modal_id).modal('show');
		var data = {
			"action"	: "get_qar_data",
			"id"		: id
		}
		fn_get_qar_data(data,modal_id,frm_id);
	});
	
	$('#modal_iqc_qar_view #btn_add_lot, #modal_iqc_qar_conformance #btn_add_lot, #modal_iqc_qar_recipient #btn_add_lot').click(function(){
		$('#modal_iqc_qar_view_lot #div_add_lot').attr('style',"display:none;");
		$('#modal_iqc_qar_view_lot').modal('show');
		var modal_id = $(this).closest('div[role="dialog"]').attr('id');
		var lot_name = $("#"+modal_id).data('lot_name').split('|');
		var lot_qty = $("#"+modal_id).data('lot_qty').split('|');
		var modal_id = 'modal_iqc_qar_view_lot';
		$('#'+modal_id+' #tbl_iqc_qar_lot_number tbody').empty();
		var modal_id = 'modal_iqc_qar_view_lot';
		$.each(lot_name,function(key,value){
			var html = '';
				html += '<tr>';
				html += '	<td>'+value+'</td>';
				html += '	<td>'+lot_qty[key]+'</td>';
				html += '	<td><button type="button" class="btn btn-danger fa fa-remove" disabled></button></td>';
				html += '</tr>';
			$('#'+modal_id+' #tbl_iqc_qar_lot_number tbody').append(html);
		});
	});

	$('#modal_iqc_qar_view #btn_add_mode_of_defect, #modal_iqc_qar_conformance #btn_add_mode_of_defect, #modal_iqc_qar_recipient #btn_add_mode_of_defect').click(function(){
		$('#modal_iqc_qar_view_mode_of_defect #div_add_mode_of_defect').attr('style',"display:none;");
		$('#modal_iqc_qar_view_mode_of_defect').modal('show');
		var modal_id = $(this).closest('div[role="dialog"]').attr('id');
		var mode_of_defect = $("#"+modal_id).data('mode_of_defect').split('|');
		var location_of_defect = $("#"+modal_id).data('location_of_defect').split('|');
		var modal_id = 'modal_iqc_qar_view_mode_of_defect';
		$('#'+modal_id+' #tbl_iqc_qar_mode_of_defect tbody').empty();
		$.each(mode_of_defect,function(key,value){
			var html = '';
				html += '<tr>';
				html += '	<td>'+mode_of_defect[key]+'</td>';
				html += '	<td>'+location_of_defect[key]+'</td>';
				html += '	<td><button type="button" class="btn btn-danger fa fa-remove" disabled></button></td>';
				html += '</tr>';
			$('#'+modal_id+' #tbl_iqc_qar_mode_of_defect tbody').append(html);
		});
	});
	
	$('#modal_iqc_qar_view #btn_download_qar_excel_attachment').click(function(){
		var modal_id = $(this).closest('div[role="dialog"]').attr('id');
		var id = $('#'+modal_id).data('id');
		if($('#'+modal_id).data('disposition_by') == "" ){
			window.location.href = "reports/excel_iqc_qar_blank.php?id="+id;
		}else{
			window.location.href = "reports/excel_iqc_qar_report_download.php?id="+id;
		}
	});
	
	$('#modal_iqc_qar_view #a_reference_file,#modal_iqc_qar_edit #a_reference_file,#modal_iqc_qar_conformance #a_reference_file,#modal_iqc_qar_recipient #a_reference_file').click(function(){
		var modal_id = $(this).closest('div[role="dialog"]').attr('id');
		var pkid = $('#'+modal_id+' #a_reference_file').attr('value');
		if(pkid == 0){ return false; }
		window.location.href = 'reports/excel_iqc_qar_reference_download.php?id='+pkid;
	});

	function fn_get_qar_data(data,modal_id,frm_id){
		fn_return_prod_code_list(frm_id, 'prod_code');
		/* hide and disable buttons */
		if(modal_id == 'modal_iqc_qar_conformance'){
			$('#'+modal_id+' .modal-footer #btn_conform, #'+modal_id+' .modal-footer #btn_reject').hide();
			$('#'+modal_id+' .modal-footer #btn_conform, #'+modal_id+' .modal-footer #btn_reject').prop('disabled',true);
			$('#'+modal_id+' .modal-footer #btn_close, #'+modal_id+' .modal-footer #btn_return').hide();
			$('#'+modal_id+' .modal-footer #btn_close, #'+modal_id+' .modal-footer #btn_return').prop('disabled',true);
		}
		call_ajax(data,handler_iqc_qar,function(result){
			console.log(result);
			$.each(result['row'],function(key,value){
				$('#'+modal_id+' select[name="'+key+'"]').val(value);
				$('#'+modal_id+' input[name="'+key+'"][type="text"]').val("");
				$('#'+modal_id+' input[name="'+key+'"][type="text"]').val(value);
				$('#'+modal_id+' input[name="'+key+'"][type="number"]').val("0");
				$('#'+modal_id+' input[name="'+key+'"][type="number"]').val(value);
				$('#'+modal_id+' input[name="'+key+'"][type="date"]').val();
				$('#'+modal_id+' input[name="'+key+'"][type="date"]').val(value);
				$('#'+modal_id+' textarea[name="'+key+'"]').val("");
				$('#'+modal_id+' textarea[name="'+key+'"]').val(value);
				$('#'+modal_id).data(key,value);
			});
			/* uploaded image */
			$('#'+modal_id+' img[id="img_ok"]').attr("src",result['row']['file_src_ok_condition_file']);
			$('#'+modal_id+' img[id="img_ng"]').attr("src",result['row']['file_src_ng_condition_file']);
			/* label for disposition */
			$('#'+modal_id+' span[id="span_disposition_text"]').text(result['row']['span_disposition_text']);
			$('#'+modal_id+' span[id="span_disposition_text"]').attr('class',result['row']['span_disposition_class']);
			var combo_id 		= "#"+modal_id+" #cmb_to";
			var ajax_url 		= "server_side_scripts/dropdown/iqc/qar_to_recipient.php";
			var data_value 		= result['row']['to'];
				$('#'+modal_id+' #cmb_to').val(data_value).trigger('change');
			var dropdown_parent = "#"+modal_id;
				combo_id 		= "#"+modal_id+" #cmb_attn";
				data_value 		= result['data_attn'];
				assign_value_select2(combo_id,data_value);
				re_initialize_select2_server_side(combo_id,dropdown_parent,data_value,ajax_url);
				combo_id 		= "#"+modal_id+" #cmb_cc";
				data_value 		= result['data_cc'];
				assign_value_select2(combo_id,data_value);
				re_initialize_select2_server_side(combo_id,dropdown_parent,data_value,ajax_url);
				combo_id 		= "#"+modal_id+" #cmb_qc_supervisor";
				data_value 		= result['data_qc_supervisor'];
				assign_value_select2(combo_id,data_value);
				re_initialize_select2_server_side(combo_id,dropdown_parent,data_value,ajax_url);
			/* Modal conditions base on Modal ID */
			if(modal_id == 'modal_iqc_qar_conformance'){
				if(result['row']['status'] == 0){
					/* for conformance */
					$('#'+modal_id+' .modal-footer #btn_conform, #'+modal_id+' .modal-footer #btn_reject').show();
					$('#'+modal_id+' .modal-footer #btn_conform, #'+modal_id+' .modal-footer #btn_reject').prop('disabled',false);
					$('#'+modal_id+' #txt_disposition_required_date_reply').val("");
					$('#'+modal_id+' #txt_disposition_required_date_reply').prop("disabled",false);
				}else if(result['row']['status'] == 3){
					/* for approval disposition */
					$('#'+modal_id+' .modal-footer #btn_close, #'+modal_id+' .modal-footer #btn_return').show();
					$('#'+modal_id+' .modal-footer #btn_close, #'+modal_id+' .modal-footer #btn_return').prop('disabled',false);
				}
			}
			if(modal_id == 'modal_iqc_qar_recipient'){
				if(result['row']['status'] == 9 || result['row']['status'] == 3 || result['row']['status'] == 4){
					$('#'+modal_id+' .modal-footer button.fa-check-circle').prop('disabled',true);
				}else{
					$('#'+modal_id+' .modal-footer button').prop('disabled',false);
				}
			}
			if(modal_id == 'modal_iqc_qar_view' || modal_id == 'modal_iqc_qar_edit' || modal_id == 'modal_iqc_qar_conformance' || modal_id == 'modal_iqc_qar_recipient'){
				if(result['row']['reference_file_name'] == ""){
					$('#'+modal_id+' #a_reference_file').text('No reference attached');
					$('#'+modal_id+' #a_reference_file').attr('value',0);
				}else{
					$('#'+modal_id+' #a_reference_file').text(result['row']['reference_file_name']);
					$('#'+modal_id+' #a_reference_file').attr('value',result['row']['pkid']);
				}
			}
			if(modal_id == 'modal_iqc_qar_edit'){
				load_mode_of_defect_for_edit(modal_id);
				load_lot_name_for_edit(modal_id);
			}			
		});
	}
	/* *******************************************************
		QAR Requestor Page - QAR - View  End
	********************************************************/

	/* **************************************
		QAR Requestor Page - QAR - New 
	*****************************************/
	/* SELECT2 Initialization */
	var modal_id = 'modal_iqc_qar_new';
	re_initialize_select2_server_side("#"+modal_id+" #cmb_attn",$("#"+modal_id+" #frm_iqc_qar_new"),[],"server_side_scripts/dropdown/iqc/qar_to_recipient.php");
	re_initialize_select2_server_side("#"+modal_id+" #cmb_cc",$("#"+modal_id+" #frm_iqc_qar_new"),[],"server_side_scripts/dropdown/iqc/qar_to_recipient.php");
	re_initialize_select2_server_side("#"+modal_id+" #cmb_qc_supervisor",$("#"+modal_id+" #frm_iqc_qar_new"),[],"server_side_scripts/dropdown/iqc/qar_to_recipient.php");
	
	$("#"+modal_id+" #cmb_to").select2({
		placeHolder	: "Please select a section",
		data 		: [
						{
							id: '',
							text: ''
						},
						{
							id: 'PPS',
							text: 'PPS'
						},
						{
							id: 'CN',
							text: 'CN'
						},
						{
							id: 'TS',
							text: 'TS'
						},
						{
							id: 'TS - WHS',
							text: 'TS - WHS'
						},
						{
							id: 'YF',
							text: 'YF'
						}
					]
	});

	/* combo new*/
	var modal_id = 'modal_iqc_qar_cancel';
	$("#"+modal_id+" #cmb_to").select2({
		placeHolder	: "Please select a section",
		data 		: [
						{
							id: '',
							text: ''
						},
						{
							id: 'PPS',
							text: 'PPS'
						},
						{
							id: 'CN',
							text: 'CN'
						},
						{
							id: 'TS',
							text: 'TS'
						},
						{
							id: 'TS - WHS',
							text: 'TS - WHS'
						},
						{
							id: 'YF',
							text: 'YF'
						}
					]
	});

	$('#btn_new_iqc_qar').click(function(){	
		var modal_id 	= 'modal_iqc_qar_new';
		var frm_id 		= 'frm_iqc_qar_new';
		fn_return_prod_code_list(frm_id, 'prod_code');
		$('#'+modal_id+' input').attr("autocomplete","off");
		$('#'+modal_id).modal('show');
	});
	/*
		Add Lot No
	*/
	$('#modal_iqc_qar_new #cmb_to').change(function(){
		var to = $(this).val();
		if(to !== '') { fn_get_qar_group_list('modal_iqc_qar_new', to); }
	});
	$('#modal_iqc_qar_new #btn_add_lot').click(function(){
		$('#modal_iqc_qar_new_lot').modal('show');
	});
	
	$('#modal_iqc_qar_new #txt_partcode').keyup(function(){
		var modal_id = 'modal_iqc_qar_new';
		var datalist_id = modal_id+" #list_partcode_qar";
		var pattern = $(this).val();
		fn_get_partcode_datalist(datalist_id,pattern);
	});
	
	$('#modal_iqc_qar_new #txt_partcode').change(function(){
		var modal_id = 'modal_iqc_qar_new';
		var input_field_id = modal_id+" #txt_partname";
		var partcode = $(this).val();
		fn_get_partname_by_partcode(input_field_id,partcode);
	});

	$('#modal_iqc_qar_new_lot #btn_add_lot').click(function(){
		var modal_id = "modal_iqc_qar_new_lot";
		var frm_id = "frm_iqc_qar_new_lot";
		var tbl_id = "tbl_iqc_qar_lot_number";
		var lot_no = $('#'+frm_id+' #txt_lot_no').val();
		var lot_qty = $('#'+frm_id+' #txt_lot_qty').val();
		if(lot_no == "" || lot_qty == ""){
			fn_display_modal_error_message(modal_id,"Please enter a lot no. and a lot qty!");
			return false;
		}
		var data = [lot_no,lot_qty,'<button type="button" class="btn btn-danger fa fa-remove"></button>'];
		if( $('#'+frm_id+' #' + tbl_id + ' tbody tr:eq(0) td:eq(0)').text() == "No record found" ){
			/* Empty table body if there are no record currently added */
			$('#'+frm_id+' #' + tbl_id + ' tbody').empty();
		}
		var html  = '<tr id="0">';
		$.each(data,function(key,value){
			html += '   <td>'+value+'</td>';
		});
			html += '</tr>';
		$('#'+frm_id+' #' + tbl_id + ' tbody').append(html);
		/*empty input fields */
		$('#'+frm_id+' input').val('');
		// compute_checked_qty();
	});
		
	$('#modal_iqc_qar_new_lot #tbl_iqc_qar_lot_number tbody').on('click','tr .btn-danger',function(){
		$(this).closest('tr').remove();
		// compute_checked_qty();
	});
		
	$('#modal_iqc_qar_new #txt_checked_qty,#modal_iqc_qar_new #txt_ng_qty').keyup(function(){
		compute_checked_qty();
	});

	$('#frm_iqc_qar_new').submit(function(e){
		e.preventDefault();
		var frm_id = "frm_iqc_qar_new_lot";
		var tbl_id = "tbl_iqc_qar_lot_number";
		var lot_details     		= fn_get_lot_name_and_qty(frm_id+' #'+tbl_id);
		var lot_name 				= lot_details.lot_name.join("|");
		var lot_qty 				= lot_details.lot_qty.join("|");
		var frm_id = "frm_iqc_qar_mode_of_defect";
		var tbl_id = "tbl_iqc_qar_mode_of_defect";
		var mode_details     		= fn_get_mode_details(frm_id+' #'+tbl_id);
		var mode_of_defect 			= mode_details.mode_of_defect.join("|");
		var location_of_defect		= mode_details.location_of_defect.join("|");	
		var serialized_data = new FormData(this);
			serialized_data.append('action',"save_qar");
			serialized_data.append('lot_name',lot_name);
			serialized_data.append('lot_qty',lot_qty);
			serialized_data.append('mode_of_defect',mode_of_defect);
			serialized_data.append('location_of_defect',location_of_defect);
			serialized_data.append('section',iqc_qar_requestor_section);
			serialized_data.append('username',username);
		fn_save_qar(serialized_data);
	});
	
	function fn_get_qar_group_list(modal_id, to) {
		var data = {
			"action"	: "get_qar_group_list",
			"group_to"	: to
		}
		call_ajax(data,handler_iqc_qar,function(result){
			var ajax_url 		= "server_side_scripts/dropdown/iqc/qar_to_recipient.php";	
			var dropdown_parent = "#"+modal_id;
				cmb_attn 		= "#"+modal_id+" #cmb_attn";
				data_value 		= result['data_attn'];
				assign_value_select2(cmb_attn,data_value);
				re_initialize_select2_server_side(cmb_attn,dropdown_parent,data_value,ajax_url);
				
			var dropdown_parent = "#"+modal_id;
				cmb_cc 		= "#"+modal_id+" #cmb_cc";
				data_value 		= result['data_cc'];
				assign_value_select2(cmb_cc,data_value);
				re_initialize_select2_server_side(cmb_cc,dropdown_parent,data_value,ajax_url);
				
			var dropdown_parent = "#"+modal_id;
				cmb_supervisor 		= "#"+modal_id+" #cmb_qc_supervisor";
				data_value 		= result['data_supervisor'];
				assign_value_select2(cmb_supervisor,data_value);
				re_initialize_select2_server_side(cmb_supervisor,dropdown_parent,data_value,ajax_url);
		});
	}
	
	function compute_checked_qty(){
		modal_id = "modal_iqc_qar_new";
		var checked_qty = $('#' + modal_id + ' #txt_checked_qty' ).val();
		var ng_qty = $('#' + modal_id + ' #txt_ng_qty' ).val();
		checked_qty == "" ? checked_qty = 0 : "";
		ng_qty == "" ? ng_qty = 0 : "";
		var ng_rate = ( parseFloat(ng_qty) / parseFloat(checked_qty) ) * 100;
		$('#' + modal_id + ' #txt_ng_rate' ).val( ng_rate.toFixed(2) );
	}
	
	/*
		Add Mode of Defect
	*/   
	$('#modal_iqc_qar_new #btn_add_mode_of_defect').click(function(){
		$('#modal_iqc_qar_mode_of_defect').modal('show');
	});
		
	$('#modal_iqc_qar_mode_of_defect #btn_add_mode_of_defect').click(function(){
		var modal_id = "modal_iqc_qar_mode_of_defect";
		var frm_id = "frm_iqc_qar_mode_of_defect";
		var tbl_id = "tbl_iqc_qar_mode_of_defect";
		var mode_of_defect = $('#'+frm_id+' #txt_mode_of_defect').val();
		var location_of_defect = $('#'+frm_id+' #txt_location_of_defect').val();
		if(mode_of_defect == "" || location_of_defect == ""){
			fn_display_modal_error_message(modal_id,"Please enter a mode of defect and location of defect!");
			return false;
		}
		var data = [mode_of_defect,location_of_defect,'<button type="button" class="btn btn-danger fa fa-remove"></button>'];
		if( $('#'+frm_id+' #' + tbl_id + ' tbody tr:eq(0) td:eq(0)').text() == "No record found" ){
			/* Empty table body if there are no record currently added */
			$('#'+frm_id+' #' + tbl_id + ' tbody').empty();
		}
		var html  = '<tr id="0">';
		$.each(data,function(key,value){
			html += '   <td>'+value+'</td>';
		});
			html += '</tr>';
		$('#'+frm_id+' #' + tbl_id + ' tbody').append(html);
		/*empty input fields */
		$('#'+frm_id+' input').val('');
	});
		
	$('#modal_iqc_qar_mode_of_defect #tbl_iqc_qar_mode_of_defect tbody').on('click','tr .btn-danger',function(){
		$(this).closest('tr').remove();
	});
	
	$('#frm_iqc_qar_new_file_upload_ng_condition').submit(function(e){
		e.preventDefault();
		var serialized_data = new FormData(this);
			serialized_data.append("action","upload_temp_image_attachments");
			fn_upload_temp_image_attachments(serialized_data);
	});
	
	function fn_display_modal_error_message(modal_id,content){
	   var html  = '<div class="alert alert-danger" id="div_error_message">';
		   html += '    <strong>Validation Error!</strong> ' + content;
		   html += '</div>';
		$('#' + modal_id + " .modal-body").prepend(html);
		setTimeout(function(){
			$('#' + modal_id + " .modal-body #div_error_message").remove();
		},2000);
	}

	function fn_get_mode_details(tbl_id){
		var mode_details    	 				= [];
			mode_details.mode_of_defect 		= [];
			mode_details.location_of_defect 	= [];
		$('#'+tbl_id+' tbody tr').each(function(){
			mode_details.mode_of_defect.push( $(this).find("td:eq(0)").text() );
			mode_details.location_of_defect.push( $(this).find("td:eq(1)").text() );
		});
		return mode_details;
	}

	function fn_get_lot_name_and_qty(tbl_id){
		var lot_details     		= [];
			lot_details.lot_name 	= [];
			lot_details.lot_qty 	= [];
		$('#'+tbl_id+' tbody tr').each(function(){
			lot_details.lot_name.push( $(this).find("td:eq(0)").text() );
			lot_details.lot_qty.push( $(this).find("td:eq(1)").text() );
		});
		return lot_details;
	}

	function fn_get_uploaded_files(tbl_id){
		var uploaded_files     			= [];
			uploaded_files.name 		= [];
			uploaded_files.tmp_name 	= [];
			uploaded_files.file_size 	= [];
		$('#'+tbl_id+' tbody tr').each(function(){
			uploaded_files.name.push( $(this).find("td:eq(0)").text() );
			uploaded_files.file_size.push( $(this).find("td:eq(2)").text() );
			uploaded_files.tmp_name.push( $(this).find("td:eq(3)").text() );
		});
		return uploaded_files;
	}
	
	function fn_save_qar(serialized_data){
		$('.btn').attr('disabled',true);
		call_ajax_attachment(serialized_data, handler_iqc_qar, function(result){
			console.log(result);
			$('.btn').attr('disabled',false);
			/* Change this to your desired system message modal ID */
			var modal_id 		= 'modal_iqc_qar_system_message';
			var form_id 		= '';
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
				$('#'+modal_id+' #div_system_message').append("Dimension inspection result has been successfully uploaded!");
				$('#'+modal_id+'').modal('show');
				$('#modal_iqc_qar_new #cmb_to').val(null).trigger('change');
				$('#modal_iqc_qar_new #cmb_attn').val(null).trigger('change');
				$('#modal_iqc_qar_new #cmb_cc').val(null).trigger('change');
				$('#modal_iqc_qar_new #cmb_qc_supervisor').val(null).trigger('change');
				$('#modal_iqc_qar_new input').val("");
				$('#modal_iqc_qar_new input[type="number"]').val(0);
				$('#modal_iqc_qar_new_lot #tbl_iqc_qar_lot_number tbody').empty();
				$('#modal_iqc_qar_mode_of_defect #tbl_iqc_qar_mode_of_defect tbody').empty();
				fn_system_message_timer(''+modal_id+'');
				dt_tbl_iqc_qar_requestor.ajax.reload();
				dt_tbl_iqc_qar_conformance.ajax.reload();
				dt_tbl_iqc_qar_recipient.ajax.reload();
				clear_fields_qar_modal(modal_id);
			}
		});
	}
	
	function clear_fields_qar_modal(modal_id){
		$('#'+modal_id+' input, #'+modal_id+' textarea').val();
	}
	/* *************************************
		QAR Requestor Page - New Quality Alert Report - End
	***************************************/
	
	/* ******************************************************
		QAR Requestor Page - QAR - Edit  Start
	*********************************************************/
	var modal_id = 'modal_iqc_qar_edit';
	$("#"+modal_id+" #cmb_to").select2({
		placeHolder	: "Please select a section",
		data 		: [
						{
							id: '',
							text: ''
						},
						{
							id: 'PPS',
							text: 'PPS'
						},
						{
							id: 'CN',
							text: 'CN'
						},
						{
							id: 'TS',
							text: 'TS'
						},
						{
							id: 'TS - WHS',
							text: 'TS - WHS'
						},
						{
							id: 'YF',
							text: 'YF'
						}
					]
	});
	
	$('#tbl_iqc_qar_requestor tbody').on('click','tr .fa-edit',function(){
		var modal_id 	= "modal_iqc_qar_edit";
		var frm_id 		= "frm_iqc_qar_edit";
		var id 			= $(this).val(); 
		$('#'+modal_id).modal('show');
		var data = {
			"action"	: "get_qar_data",
			"id"		: id
		}
		$('#'+modal_id).data('id',id);
		fn_get_qar_data(data,modal_id,frm_id);
	});
	
	$('#modal_iqc_qar_edit #btn_add_lot').click(function(){
		$('#modal_iqc_qar_view_lot #div_add_lot').attr('style',"");
		$('#modal_iqc_qar_view_lot').modal('show');
	});
	
	$('#modal_iqc_qar_view_lot #btn_add_lot').click(function(){
		var modal_id = $(this).closest('div[role="dialog"]').attr('id');
		var frm_id = "frm_iqc_qar_view_lot";
		var tbl_id = "tbl_iqc_qar_lot_number";
		var lot_no = $('#'+modal_id+' #'+frm_id+' #txt_lot_no').val();
		var lot_qty = $('#'+modal_id+' #'+frm_id+' #txt_lot_qty').val();
		if(lot_no == "" || lot_qty == ""){
			fn_display_modal_error_message(modal_id,"Please enter a lot no. and a lot qty!");
			return false;
		}
		var data = [lot_no,lot_qty,'<button type="button" class="btn btn-danger fa fa-remove"></button>'];
		if( $('#'+modal_id+' #'+frm_id+' #' + tbl_id + ' tbody tr:eq(0) td:eq(0)').text() == "No record found" ){
			/* Empty table body if there are no record currently added */
			$('#'+modal_id+' #'+frm_id+' #' + tbl_id + ' tbody').empty();
		}
		var html  = '<tr id="0">';
		$.each(data,function(key,value){
			html += '   <td>'+value+'</td>';
		});
			html += '</tr>';
		$('#'+modal_id+' #'+frm_id+' #' + tbl_id + ' tbody').append(html);
		/*empty input fields */
		$('#'+modal_id+' #'+frm_id+' input').val('');
	});
	
	$('#modal_iqc_qar_view_lot #tbl_iqc_qar_mode_of_defect tbody').on('click','tr .btn-danger',function(){
		$(this).closest('tr').remove();
	});
	
	$('#modal_iqc_qar_edit #btn_add_mode_of_defect').click(function(){
		$('#modal_iqc_qar_view_mode_of_defect #div_add_mode_of_defect').attr('style',"");
		$('#modal_iqc_qar_view_mode_of_defect').modal('show');
	});
	
	$('#modal_iqc_qar_view_mode_of_defect #btn_add_mode_of_defect').click(function(){
		var modal_id = $(this).closest('div[role="dialog"]').attr('id');
		var frm_id = "frm_iqc_qar_view_mode_of_defect";
		var tbl_id = "tbl_iqc_qar_mode_of_defect";
		var mode_of_defect = $('#'+modal_id+' #'+frm_id+' #txt_mode_of_defect').val();
		var location_of_defect = $('#'+modal_id+' #'+frm_id+' #txt_location_of_defect').val();
		if(mode_of_defect == "" || location_of_defect == ""){
			fn_display_modal_error_message(modal_id,"Please enter a mode of defect and location of defect!");
			return false;
		}
		var data = [mode_of_defect,location_of_defect,'<button type="button" class="btn btn-danger fa fa-remove"></button>'];
		if( $('#'+modal_id+' #'+frm_id+' #' + tbl_id + ' tbody tr:eq(0) td:eq(0)').text() == "No record found" ){
			/* Empty table body if there are no record currently added */
			$('#'+modal_id+' #'+frm_id+' #' + tbl_id + ' tbody').empty();
		}
		var html  = '<tr id="0">';
		$.each(data,function(key,value){
			html += '   <td>'+value+'</td>';
		});
			html += '</tr>';
		
		$('#'+modal_id+' #'+frm_id+' #' + tbl_id + ' tbody').append(html);
		/*empty input fields */
		$('#'+modal_id+' #'+frm_id+' input').val('');
	});
		
	$('#modal_iqc_qar_view_mode_of_defect #tbl_iqc_qar_mode_of_defect tbody').on('click','tr .btn-danger',function(){
		$(this).closest('tr').remove();
	});
	
	$('#modal_iqc_qar_edit #txt_checked_qty,#modal_iqc_qar_edit #txt_ng_qty').keyup(function(){
		compute_checked_qty_edit();
	});
	
	$('#frm_iqc_qar_edit').submit(function(e){
		e.preventDefault();
		var id = $(this).closest('div[role="dialog"]').data('id');
		var frm_id = "frm_iqc_qar_view_lot";
		var tbl_id = "tbl_iqc_qar_lot_number";
		var lot_details     		= fn_get_lot_name_and_qty(frm_id+' #'+tbl_id);
		var lot_name 				= lot_details.lot_name.join("|");
		var lot_qty 				= lot_details.lot_qty.join("|");
		var frm_id = "frm_iqc_qar_view_mode_of_defect";
		var tbl_id = "tbl_iqc_qar_mode_of_defect";
		var mode_details     		= fn_get_mode_details(frm_id+' #'+tbl_id);
		var mode_of_defect 			= mode_details.mode_of_defect.join("|");
		var location_of_defect		= mode_details.location_of_defect.join("|");	
		var serialized_data = new FormData(this);
			serialized_data.append('action','edit_qar');
			serialized_data.append('id',id);
			serialized_data.append('section',iqc_qar_requestor_section);
			serialized_data.append('lot_name',lot_name);
			serialized_data.append('lot_qty',lot_qty);
			serialized_data.append('mode_of_defect',mode_of_defect);
			serialized_data.append('location_of_defect',location_of_defect);
			serialized_data.append('section',iqc_qar_requestor_section);
			serialized_data.append('username',username);
		fn_edit_qar(serialized_data);
	});
	
	function load_mode_of_defect_for_edit(modal_id){
		var mode_of_defect = $("#"+modal_id).data('mode_of_defect').split('|');
		var location_of_defect = $("#"+modal_id).data('location_of_defect').split('|');
		var modal_id = 'modal_iqc_qar_view_mode_of_defect';
		$('#'+modal_id+' #tbl_iqc_qar_mode_of_defect tbody').empty();
		$.each(mode_of_defect,function(key,value){
			var html = '';
				html += '<tr>';
				html += '	<td>'+mode_of_defect[key]+'</td>';
				html += '	<td>'+location_of_defect[key]+'</td>';
				html += '	<td><button type="button" class="btn btn-danger fa fa-remove"></button></td>';
				html += '</tr>';
			$('#'+modal_id+' #tbl_iqc_qar_mode_of_defect tbody').append(html);
		});
	}

	function load_lot_name_for_edit(modal_id){
		var lot_name = $("#"+modal_id).data('lot_name').split('|');
		var lot_qty = $("#"+modal_id).data('lot_qty').split('|');
		var modal_id = 'modal_iqc_qar_view_lot';
		$('#'+modal_id+' #tbl_iqc_qar_lot_number tbody').empty();
		var modal_id = 'modal_iqc_qar_view_lot';
		$.each(lot_name,function(key,value){
			var html = '';
				html += '<tr>';
				html += '	<td>'+value+'</td>';
				html += '	<td>'+lot_qty[key]+'</td>';
				html += '	<td><button type="button" class="btn btn-danger fa fa-remove"></button></td>';
				html += '</tr>';
			$('#'+modal_id+' #tbl_iqc_qar_lot_number tbody').append(html);
		});
	}
	
	function compute_checked_qty_edit(){
		modal_id = "modal_iqc_qar_edit";
		var checked_qty = $('#' + modal_id + ' #txt_checked_qty' ).val();
		var ng_qty = $('#' + modal_id + ' #txt_ng_qty' ).val();
		checked_qty == "" ? checked_qty = 0 : "";
		ng_qty == "" ? ng_qty = 0 : "";
		var ng_rate = ( parseFloat(ng_qty) / parseFloat(checked_qty) ) * 100;
		$('#' + modal_id + ' #txt_ng_rate' ).val( ng_rate.toFixed(2) );
	}	
	
	function fn_edit_qar(data){
		call_ajax_attachment(data,handler_iqc_qar,function(result){
			console.log(result);
			$('.btn').attr('disabled',false);
			/* Change this to your desired system message modal ID */
			var modal_id 		= 'modal_iqc_qar_system_message';
			var form_id 		= '';
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
				$('#'+modal_id+' #div_system_message').append("Quality alert has been updated!");
				$('#'+modal_id+'').modal('show');
				fn_system_message_timer(''+modal_id+'');
				dt_tbl_iqc_qar_conformance.ajax.reload();
				dt_tbl_iqc_qar_requestor.ajax.reload();
				dt_tbl_iqc_qar_conformance.ajax.reload();
				$('#modal_iqc_qar_edit input[type="text"]').val("");
				$('#modal_iqc_qar_edit input[type="file"]').val("");
				$('#modal_iqc_qar_edit input[type="number"]').val(0);
			}
		});
	}
	
	/* **************************
		QAR Requestor Page - QAR - Edit  End
	****************************/
	
	/* **************************
		QAR Requestor Page - QAR - Cancel  Start
	****************************/

	$('#tbl_iqc_qar_requestor tbody').on('click','tr .fa-remove',function(){
		var id = $(this).attr('value');
		var modal_id = 'modal_iqc_qar_cancel';
		var frm_id = 'frm_iqc_qar_cancel';
		$('#'+frm_id+' input').prop('disabled',true);
		$('#'+frm_id+' select').prop('disabled',true);
		$('#'+frm_id+' textarea').prop('disabled',true);
		$('#'+modal_id).data('id',id);
		$('#'+modal_id).modal('show');
		var data = {
			"action"	: "get_qar_data",
			"id"		: id
		}
		fn_get_qar_data(data,modal_id,frm_id);
	});
	
	$('#modal_iqc_qar_cancel #btn_cancel_request').click(function(){
		var modal_id = 'modal_iqc_qar_confirm_cancel';
		$('#'+modal_id).modal('show');
	});
	
	$('#modal_iqc_qar_confirm_cancel #btn_confirm_cancel_request').click(function(){
		var modal_id = 'modal_iqc_qar_cancel';
		var id = $('#'+modal_id).data('id');
		var modal_id = 'modal_iqc_qar_confirm_cancel';
		var remarks = $('#'+modal_id+' textarea[name="remarks"]').val();
		fn_cancel_qar(id,remarks);
	});
	
	function fn_cancel_qar(id,remarks){
		var data = {
			"action"	: "cancel_qar",
			"id"		: id,
			"remarks"	: remarks,
			"username"	: username
		}
		$('.btn').attr('disabled',true);
		call_ajax(data, handler_iqc_qar, function(result){
			console.log(result);
			$('.btn').attr('disabled',false);
			/* Change this to your desired system message modal ID */
			var modal_id 		= 'modal_iqc_qar_system_message';
			var form_id 		= '';
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
				$('#'+modal_id+' #div_system_message').attr("class","alert alert-danger");
				$('#'+modal_id+' #div_system_message').append("Quality alert has been cancelled!");
				$('#'+modal_id+'').modal('show');
				fn_system_message_timer(''+modal_id+'');
				dt_tbl_iqc_qar_conformance.ajax.reload();
				dt_tbl_iqc_qar_requestor.ajax.reload();
				dt_tbl_iqc_qar_conformance.ajax.reload();
			}
		});
	}

	/* ******************************************
		QAR Requestor Page - QAR - Cancel  End
	********************************************/

	/* *************************************************
		QAR Conformance Page - Conform Request - Start
	***************************************************/
	var modal_id = 'modal_iqc_qar_conformance';
	$("#"+modal_id+" #cmb_to").select2({
		placeHolder	: "Please select a section",
		data 		: [
						{
							id: '',
							text: ''
						},
						{
							id: 'PPS',
							text: 'PPS'
						},
						{
							id: 'CN',
							text: 'CN'
						},
						{
							id: 'TS',
							text: 'TS'
						},
						{
							id: 'TS - WHS',
							text: 'TS - WHS'
						},
						{
							id: 'YF',
							text: 'YF'
						}
					]
	});
	
	$('#tbl_iqc_qar_conformance tbody').on('click', 'tr .fa-eye', function(){
		var id = $(this).attr('value');
		var modal_id = 'modal_iqc_qar_conformance';
		var frm_id = 'frm_iqc_qar_conformance';
		$('#'+frm_id+' input').prop('disabled',true);
		$('#'+frm_id+' select').prop('disabled',true);
		$('#'+frm_id+' textarea').prop('disabled',true);
		$('#'+modal_id).data('id',id);
		$('#'+modal_id).modal('show');
		var data = {
			"action"	: "get_qar_data",
			"id"		: id
		}
		fn_get_qar_data(data,modal_id,frm_id);
	});
	
	$('#modal_iqc_qar_conformance #btn_conform').click(function(){
		var modal_id = $(this).closest('div[role="dialog"]').attr('id');
		var id = $('#'+modal_id).data('id');
		fn_conform_and_send_qar(id,'conform');
	});
	
	$('#modal_iqc_qar_conformance #btn_reject').click(function(){
		var modal_id = $(this).closest('div[role="dialog"]').attr('id');
		var id = $('#'+modal_id).data('id');
		fn_reject_qar(id);
	});
	
	$('#modal_iqc_qar_conformance #btn_close').click(function(){
		var modal_id = $(this).closest('div[role="dialog"]').attr('id');
		var id = $('#'+modal_id).data('id');
		fn_close_qar(id);
	});
	
	$('#modal_iqc_qar_conformance #btn_return').click(function(){
		var modal_id = $(this).closest('div[role="dialog"]').attr('id');
		var id = $('#'+modal_id).data('id');
		fn_conform_and_send_qar(id,'return');
	});
	
	$('#modal_iqc_qar_conformance #btn_download_qar_excel_attachment').click(function(){
		var modal_id = $(this).closest('div[role="dialog"]').attr('id');
		var id = $('#'+modal_id).data('id');
		if($('#'+modal_id).data('disposition_by') == "" ){
			window.location.href = "reports/excel_iqc_qar_blank.php?id="+id;
		}else{
			window.location.href = "reports/excel_iqc_qar_report_download.php?id="+id;
		}
	});
	
	function fn_conform_and_send_qar(id,type){
		var data = {
			"action"							: "conform_and_send_qar",
			"id"								: id,
			"disposition_required_date_reply"	: $('#modal_iqc_qar_conformance #txt_disposition_required_date_reply').val(),
			"attn"								: $('#modal_iqc_qar_conformance').data('attn'),
			"cc"								: $('#modal_iqc_qar_conformance').data('cc'),
			"date_issued"						: $('#modal_iqc_qar_conformance').data('date_issued'),
			"part_code"							: $('#modal_iqc_qar_conformance').data('part_code'),
			"part_name"							: $('#modal_iqc_qar_conformance').data('part_name'),
			"model"								: $('#modal_iqc_qar_conformance').data('model'),
			"mode_of_defect"					: $('#modal_iqc_qar_conformance').data('mode_of_defect'),
			"username"							: username
		}
		
		$('.btn').attr('disabled',true);
		call_ajax(data, handler_iqc_qar, function(result){
			console.log(result);
			$('.btn').attr('disabled',false);
			/* Change this to your desired system message modal ID */
			var modal_id 		= 'modal_iqc_qar_system_message';
			var form_id 		= '';
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
				if(type == 'conform'){
					var html_class = "alert alert-success";
					var message = "Quality alert has been successfully approved!";
				}else{
					var html_class = "alert alert-danger";
					var message = "Quality alert has been returned to recipient!";
				}
				$('.modal').modal('hide');
				$('#'+modal_id+' #div_system_message').empty();
				$('#'+modal_id+' #div_system_message').attr("class",html_class);
				$('#'+modal_id+' #div_system_message').append("Quality alert has been successfully approved!");
				$('#'+modal_id+'').modal('show');
				fn_system_message_timer(''+modal_id+'');
				dt_tbl_iqc_qar_conformance.ajax.reload();
				dt_tbl_iqc_qar_requestor.ajax.reload();
				dt_tbl_iqc_qar_recipient.ajax.reload();
			}
		});
	}
	
	function fn_reject_qar(id){
		var data = {
			"action"	: "reject_qar",
			"id"		: id,
			"username"	: username
		}
		$('.btn').attr('disabled',true);
		call_ajax(data, handler_iqc_qar, function(result){
			console.log(result);
			$('.btn').attr('disabled',false);
			/* Change this to your desired system message modal ID */
			var modal_id 		= 'modal_iqc_qar_system_message';
			var form_id 		= '';
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
				$('#'+modal_id+' #div_system_message').attr("class","alert alert-danger");
				$('#'+modal_id+' #div_system_message').append("Quality alert has been rejected!");
				$('#'+modal_id+'').modal('show');
				fn_system_message_timer(''+modal_id+'');
				dt_tbl_iqc_qar_conformance.ajax.reload();
				dt_tbl_iqc_qar_requestor.ajax.reload();
				dt_tbl_iqc_qar_recipient.ajax.reload();
			}
		});
	}
	
	function fn_close_qar(id){
		var data = {
			"action"	: "close_qar",
			"id"		: id,
			"username"	: username
		}
		$('.btn').attr('disabled',true);
		call_ajax(data, handler_iqc_qar, function(result){
			console.log(result);
			$('.btn').attr('disabled',false);
			/* Change this to your desired system message modal ID */
			var modal_id 		= 'modal_iqc_qar_system_message';
			var form_id 		= '';
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
				$('#'+modal_id+' #div_system_message').append("Quality alert has been accepted and closed!");
				$('#'+modal_id+'').modal('show');
				fn_system_message_timer(''+modal_id+'');
				dt_tbl_iqc_qar_conformance.ajax.reload();
				dt_tbl_iqc_qar_requestor.ajax.reload();
				dt_tbl_iqc_qar_recipient.ajax.reload();
			}
		});
	}
	/* *************************************************
		QAR Approver Page - Conform Request - End
	***************************************************/
	
	/* *************************************************
		QAR Recipient Page - Recipient - Start
	***************************************************/
	var modal_id = 'modal_iqc_qar_recipient';
	$("#"+modal_id+" #cmb_to").select2({
		placeHolder	: "Please select a section",
		data 		: [
						{
							id: '',
							text: ''
						},
						{
							id: 'PPS',
							text: 'PPS'
						},
						{
							id: 'CN',
							text: 'CN'
						},
						{
							id: 'TS',
							text: 'TS'
						},
						{
							id: 'TS - WHS',
							text: 'TS - WHS'
						},
						{
							id: 'YF',
							text: 'YF'
						}
					]
	});
	
	$('#tbl_iqc_qar_recipient tbody').on('click', 'tr .fa-eye', function(){
		var id = $(this).attr('value');
		var status = $(this).closest('tr').find('td:eq(0)').text();
		if(status == ' For Disposition') {
			var modal_id = 'modal_iqc_qar_recipient';
			var frm_id = 'frm_iqc_qar_recipient';
		} else {
			var modal_id = 'modal_iqc_qar_view';
			var frm_id = 'frm_iqc_qar_view';
		}
		$('#'+frm_id+' input').prop('disabled',true);
		$('#'+frm_id+' select').prop('disabled',true);
		$('#'+frm_id+' input[type="file"]').prop('disabled',false);
		$('#'+modal_id).data('id',id);
		$('#'+modal_id).modal('show');
		var data = {
			"action"	: "get_qar_data",
			"id"		: id
		}
		fn_get_qar_data(data,modal_id,frm_id);
	});
	
	$('#modal_iqc_qar_recipient #frm_iqc_qar_recipient').submit(function(e){
		e.preventDefault();
		var id 				= $(this).closest('div[role="dialog"]').data('id');
		var serialized_data = new FormData(this);
			serialized_data.append("action","add_disposition_qar_recipient");
			serialized_data.append("id",id);
			serialized_data.append("username",username);
		fn_add_disposition_qar_recipient(serialized_data);
	});
	
	$('#modal_iqc_qar_recipient #btn_invalid').click(function(){
		var id 		 = $(this).closest('div[role="dialog"]').data('id');
		var modal_id = 'modal_iqc_qar_confirm_invalid';
		$('#'+modal_id).data('id',id);
		$('#'+modal_id).modal('show');
	});
	
	$('#modal_iqc_qar_confirm_invalid #frm_iqc_qar_confirm_invalid').submit(function(e){
		e.preventDefault();
		var modal_id 		= $(this).closest('div[role="dialog"]').attr('id');
		var id 				= $('#'+modal_id).data('id');
		fn_invalid_qar(id);
	});
	
	$('#modal_iqc_qar_recipient #btn_download_qar_excel_attachment').click(function(){
		var modal_id = $(this).closest('div[role="dialog"]').attr('id');
		var id = $('#'+modal_id).data('id');
		if($('#'+modal_id).data('disposition_by') == "" ){
			window.location.href = "reports/excel_iqc_qar_blank.php?id="+id;
		}else{
			window.location.href = "reports/excel_iqc_qar_report_download.php?id="+id;
		}
	});	
	
	function fn_add_disposition_qar_recipient(serialized_data){
		call_ajax_attachment(serialized_data,handler_iqc_qar,function(result){
			console.log(result);
			/* Change this to your desired system message modal ID */
			var modal_id 		= 'modal_iqc_qar_system_message';
			var form_id 		= '';
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
				$('#'+modal_id+' #div_system_message').append("Quality alert has been sent for review!");
				$('#'+modal_id+'').modal('show');
				fn_system_message_timer(''+modal_id+'');
				dt_tbl_iqc_qar_conformance.ajax.reload();
				dt_tbl_iqc_qar_requestor.ajax.reload();
				dt_tbl_iqc_qar_recipient.ajax.reload();
				/* empty the file upload */
				$('#modal_iqc_qar_recipient input[type="file"]').val("");
			}
		});
	}
	
	function fn_invalid_qar(id){
		var data = {
			"action"	: "invalid_qar", //wala pa code sa handler
			"id"		: id,
			"username"	: username
		}
		$('.btn').attr('disabled',true);
		call_ajax(data, handler_iqc_qar, function(result){
			console.log(result);
			$('.btn').attr('disabled',false);
			/* Change this to your desired system message modal ID */
			var modal_id 		= 'modal_iqc_qar_system_message';
			var form_id 		= '';
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
				$('#'+modal_id+' #div_system_message').attr("class","alert alert-danger");
				$('#'+modal_id+' #div_system_message').append("Quality alert has been disapproved!");
				$('#'+modal_id+'').modal('show');
				fn_system_message_timer(''+modal_id+'');
				dt_tbl_iqc_qar_conformance.ajax.reload();
				dt_tbl_iqc_qar_requestor.ajax.reload();
				dt_tbl_iqc_qar_recipient.ajax.reload();
			}
		});
	}
	
	function fn_return_prod_code_list(frm_id, select_name){
		$('#'+frm_id+' select[name="'+select_name+'"]').empty();
		var data = {
			"action"	: "return_prod_code_list"
		}
		call_ajax(data, handler_iqc_qar, function(result){
			console.log(result);
			$('#'+frm_id+' select[name="'+select_name+'"]').append(result['html_select']);
		});
	}	
	
	/* *************************************************
		QAR Conformance Page - Approve Request - End
	***************************************************/
	
	/* TEST CODES */
	
	// var table = $('#example').DataTable();
 
	// dt_tbl_iqc_qar_requestor
	// .column( 1 )
    // .search( 'QAR-TS-PROD-1802-029' )
    // .draw();
		
	// $('#tbl_iqc_qar_requestor').floatThead();

	/* Setup - add a text input to each footer cell */
    // $('#tbl_iqc_qar_requestor thead th').each( function () {
        // var title = $(this).text();
        // $(this).html( '<input type="text" placeholder="Search '+title+'" />' );
    // } );
	
	/* Apply the search */
    // dt_tbl_iqc_qar_requestor.columns().every( function () {
        // var that = this;
		// $( 'input', this.header() ).on( 'keyup change', function () {
            // if ( that.search() !== this.value ) {
                // console.log(this.value);
				// that
                    // .search( this.value )
                    // .draw();
            // }
        // } );
    // });
});