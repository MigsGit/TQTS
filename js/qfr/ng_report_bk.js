/* **************************************************
	NG Report - Start
/***************************************************/
	var dt_ng_for_filling	= '';
	var dt_ng_records		= '';
	var dt_ng_for_dispo		= '';
	var tbl_ng_for_filling	= 'tbl_ng_for_filling';
	var tbl_ng			    = 'tbl_ng';
	var tbl_ng_for_dispo    = 'tbl_ng_for_disposition';
	var global_fkqr_ng	    = '';
	var attachment 			= '';
	var ng_approver_status 	= '';
	var ng_approver_username 	= '';
	var ng_approver_name	 	= '';
	var ng_approver_remarks 	= '';
	var ng_approver_date_time 	= '';
	var ng_status 	            = '';
	var tbl_qfr_ng_wbs_id 	    = 0;

	dt_ng_for_filling = $('#'+tbl_ng_for_filling).DataTable({
		"aaSorting"	 : [],	
		"bProcessing": true,
        "bServerSide": true,
		"sAjaxSource": "server_side_scripts/qr/dt_ng_for_filling.php?un="+username
	});

	$('#btn_reload_wbs_record').click(function() {
		fn_ng_reload_wbs_record();
	});
		
	$('#'+tbl_ng_for_filling+' tbody').on('click', '#btn_edit', function() {
		var tr = $(this).closest('tr');
		tbl_qfr_ng_wbs_id = $(this).val();
		$('#frm_upload_ng #invoice_no_ng').val(tr.find('td:eq(3)').text());
		$('#frm_upload_ng #part_code_ng').val(tr.find('td:eq(4)').text());
		$('#frm_upload_ng #part_name_ng').val(tr.find('td:eq(5)').text());
		$('#frm_upload_ng #lot_no_ng').val(tr.find('td:eq(6)').text());
		$('#frm_upload_ng #supplier_ng').val(tr.find('td:eq(7)').text());
		$('#frm_upload_ng #invoice_no_ng').prop('readOnly', true);
		$('#frm_upload_ng #part_name_ng').prop('readOnly', true);
		$('#frm_upload_ng #supplier_ng').prop('readOnly', true);
		$('#frm_upload_ng #part_code_ng').prop('readOnly', true);
		$('#frm_upload_ng #lot_no_ng').prop('readOnly', true);
		$('#container_upload_ng_message').hide();		
		fn_get_ng_supplier_list('frm_upload_ng #supplier_ng',function() {
			$('.chosen-select#supplier_ng').chosen({width:"100%", height: "100%"});
		});	
		fn_get_ng_material_type_list('frm_upload_ng #material_type',function() {});	
		fn_load_ng_approver_chosen('tbl_approver_ng',function() {
			fn_ng_get_new_issuance_no(function() {
				$('#issuance_date_ng').val( date_today );
				// fn_get_ng_invoice_num_datalist('','list_invoice_no_ng');
				$('#modal_upload_ng').modal('show');
			});
		});
	});

	dt_ng_for_dispo = $('#'+tbl_ng_for_dispo).DataTable({
		"aaSorting"	 : [],	
		"bProcessing": true,
        "bServerSide": true,
		"sAjaxSource": "server_side_scripts/qr/dt_ng_for_disposition.php?un="+username
	});
	
	$('#'+tbl_ng_for_dispo+' tbody').on('click', '#btn_view', function() {
		global_fkqr_ng = $(this).val();		
		fn_get_ng_material_type_list('frm_upload_ng_update #material_type_ng_edit',function() {});	
		fn_get_ng_supplier_list('frm_upload_ng_update #supplier_ng_edit',function() {
			$('.chosen-select#supplier_ng_edit').chosen({width:"100%", height: "100%"});
			fn_display_ng_details('lbl_ng_status_edit','issuance_no_ng_edit','issuance_date_ng_edit','supplier_ng_edit','invoice_no_ng_edit','part_code_ng_edit','part_name_ng_edit','lot_no_ng_edit','drawing_number_ng_edit','material_type_ng_edit','remarks_ng_edit','btn_attachment_ng_edit','tbl_approver_ng_edit',function() {
				$('#btn_ng_add_disposition').hide();
				$('#btn_ng_report_edit').hide();
				$('#chk_reupload').attr('disabled', false);
				fn_ng_check_disposition_rights();
				
				$('#file_ng_edit').hide();
				$('#file_ng_edit').attr('required', false);
				$('#chk_reupload').attr('checked', false);
				$('#modal_upload_ng_edit').modal();
			});
		});
	});

	dt_ng_records = $('#'+tbl_ng).DataTable({
		"aaSorting"	 : [],	
		"bProcessing": true,
        "bServerSide": true,
		"sAjaxSource": "server_side_scripts/qr/dt_ng.php?un="+username+"&st="+ng_status,
		"rowCallback"	: function( row, data, index ) {
			if ( data[0] == "FOR APPROVAL") {
				$("td",row).css("background-color","#f0ad4e");
				$("td",row).css("color","#ffffff");
			}
			if ( data[0] == "APPROVED" ) {
				$("td",row).css("background-color","#5bc0de");
				$("td",row).css("color","#ffffff");
			}
			if ( data[0] == "DISAPPROVED" || data[0] == "WITH TREATMENT") {
				$("td",row).css("background-color","#d9534f");
				$("td",row).css("color","#ffffff");
			}
			if ( data[0] == "WITH TREATMENT (OK TO USE)" || data[0] == "WITH TREATMENT (USE AS IS)" || data[0] == "WITH FINAL REPLY") {
				$("td",row).css("background-color","#5cb85c");
				$("td",row).css("color","#ffffff");
			}
		}
	});

	$('#btn_ng_load_for_approval').click(function() {
		dt_ng_records.ajax.url("server_side_scripts/qr/dt_ng.php?un="+username+"&st=FOR APPROVAL").load();
	});

	$('#btn_ng_load_approved').click(function() {
		dt_ng_records.ajax.url("server_side_scripts/qr/dt_ng.php?un="+username+"&st=APPROVED").load();
	});

	$('#btn_ng_load_disapproved').click(function() {
		dt_ng_records.ajax.url("server_side_scripts/qr/dt_ng.php?un="+username+"&st=DISAPPROVED").load();
	});

	$('#btn_ng_load_no_final_reply').click(function() {
		dt_ng_records.ajax.url("server_side_scripts/qr/dt_ng.php?un="+username+"&st=WITH TREATMENT ").load();
	});

	$('#btn_ng_load_with_treatment').click(function() {
		dt_ng_records.ajax.url("server_side_scripts/qr/dt_ng.php?un="+username+"&st=WITHOUT FINAL REPLY ").load();
	});

	$('#btn_upload_ng').click(function(){      
		tbl_qfr_ng_wbs_id = 0;
		$('#frm_upload_ng #invoice_no_ng').prop('readOnly', false);
		$('#frm_upload_ng #part_name_ng').prop('readOnly', false);
		$('#frm_upload_ng #supplier_ng').prop('readOnly', false);
		$('#frm_upload_ng #part_code_ng').prop('readOnly', false);
		$('#frm_upload_ng #lot_no_ng').prop('readOnly', false);
		$('#container_upload_ng_message').hide();
		fn_get_ng_supplier_list('frm_upload_ng #supplier_ng',function() {
			$('.chosen-select#supplier_ng').chosen({width:"100%", height: "100%"});
		});	
		fn_load_ng_approver_chosen('tbl_approver_ng',function() {
			fn_ng_get_new_issuance_no(function() {
				$('#issuance_date_ng').val( date_today );
				// fn_get_ng_invoice_num_datalist('','list_invoice_no_ng');
				fn_get_ng_material_type_list('frm_upload_ng #material_type',function() {});	
				fn_get_ng_supplier_list('frm_upload_ng #supplier_ng', function(){});	
				$('#modal_upload_ng').modal('show');
			});
		});
	});

	$('#invoice_no_ng').keyup(function(e){
		var key = e.which;
		if(key == 38 || key == 40){
			return false;
		}
		var pattern = $(this).val();
		fn_get_ng_invoice_num_datalist(pattern,'list_invoice_no_ng');
	});

	$('#part_code_ng').keyup(function(e){
		var key = e.which;
		if(key == 38 || key == 40){
			return false;
		}
		var pattern = $(this).val();
		fn_get_partname_by_partcode($(this).val(), 'part_name_ng', 'drawing_number_ng');
	});

	$('#invoice_no_ng').change(function(e) {
		if($(this).val() != '' || e.keyCode == 13) {
			fn_get_partcode_datalist_by_invoice_num($(this).val(), 'frm_upload_ng #list_part_code');
		} 
	});

	$('#part_code_ng').change(function() {
		if($(this).val() != '') {
			fn_get_partname_by_partcode($(this).val(), 'part_name_ng', 'drawing_number_ng');
		}
	});

	$('#frm_upload_ng').on('submit', function(e) {
		e.preventDefault();
		var serialized_data = new FormData(this);
		if($('#supplier_ng').val() == '') {
			$('#container_upload_ng_message').html('Please select Supplier');
			$('#container_upload_ng_message').show();
		} else {
			$('#container_upload_ng_message').html('');
			$('#container_upload_ng_message').hide();
			if(fn_ng_validate_approvers('tbl_approver_ng', 'container_upload_ng_message')){
				$('.btn').prop("disabled",true);
				var approvers = [];
					$('#tbl_approver_ng tbody tr').each(function() {
						approvers.push($(this).find('td:eq(1) option:selected').val());
					});
				serialized_data.append("action","ng_upload_report");
				serialized_data.append("category_code",qfr_category);
				serialized_data.append("username",username);
				serialized_data.append("approvers",approvers);
				serialized_data.append("tbl_qfr_ng_wbs_id",tbl_qfr_ng_wbs_id);
					
				call_ajax_attachment(serialized_data, handler_ts_qfr_ng, function(result){
					$('#modal_upload_ng').modal('hide');
					$('#modal_system_message').modal();
					$('#container_message').attr('class','alert alert-success');
					$('#container_message').html( '<h4>'+result['msg']+'</h4>' );
					dt_ng_records.ajax.reload();
					dt_ng_for_filling.ajax.reload();
					$('.btn').prop("disabled",false);
				});
			} 
		}
		
	});

	$('#' + tbl_ng + ' tbody').on('click', ' tr', function() {
		$('#'+tbl_ng+' tbody tr').attr('style','');
		$(this).attr('style','background:teal;color:white;');
	});

	$('#'+tbl_ng+' tbody').on('click', '#btn_dl_ng_report', function() {
		window.location.href = "./pages/qfr/dl_ng_report.php?id="+$(this).val();
	});
	
	$('#'+tbl_ng+' tbody').on('click', '#btn_edit', function() {
		global_fkqr_ng = $(this).val();		
		fn_get_ng_material_type_list('frm_upload_ng_update #material_type_ng_edit',function() {});	
		fn_get_ng_supplier_list('frm_upload_ng_update #supplier_ng_edit',function() {
			$('.chosen-select#supplier_ng_edit').chosen({width:"100%", height: "100%"});
			fn_display_ng_details('lbl_ng_status_edit','issuance_no_ng_edit','issuance_date_ng_edit','supplier_ng_edit','invoice_no_ng_edit','part_code_ng_edit','part_name_ng_edit','lot_no_ng_edit','drawing_number_ng_edit','material_type_ng_edit','remarks_ng_edit','btn_attachment_ng_edit','tbl_approver_ng_edit',function() {
				if($('#lbl_ng_status_edit').text() == 'FOR APPROVAL') {
					$('#btn_ng_send_supplier').hide();
					$('#btn_ng_add_disposition').hide();
					$('#btn_ng_report_edit').show();
					$('#chk_reupload').attr('disabled', false);
				} else if($('#lbl_ng_status_edit').text() == 'APPROVED') {
					$('#btn_ng_add_disposition').hide();
					$('#btn_ng_report_edit').hide();
					$('#chk_reupload').attr('disabled', false);
					fn_ng_check_disposition_rights();
				} else if($('#lbl_ng_status_edit').text() == 'WAITING DISPOSITION') {
					$('#btn_ng_report_edit').hide();
					$('#btn_ng_send_supplier').hide();
					$('#btn_ng_add_disposition').show();
					$('#chk_reupload').attr('disabled', true);
				} else if($('#lbl_ng_status_edit').text() == 'WITH TREATMENT') {
					$('#btn_ng_report_edit').hide();
					$('#btn_ng_add_disposition').attr('class','btn btn-success fa fa-plus-circle');
					$('#btn_ng_add_disposition').text(' Add Disposition');
					$('#btn_ng_add_disposition').show();
					$('#btn_ng_send_supplier').hide();
					$('#chk_reupload').attr('disabled', true);
				} else if($('#lbl_ng_status_edit').text() == 'WITH TREATMENT (OK TO USE)' || $('#lbl_ng_status_edit').text() == 'WITH TREATMENT (USE AS IS)') {
					$('#btn_ng_report_edit').hide();
					$('#btn_ng_add_disposition').attr('class','btn btn-success fa fa-eye');
					$('#btn_ng_add_disposition').text(' View Disposition');
					$('#btn_ng_add_disposition').show();
					$('#btn_ng_send_supplier').hide();
					$('#chk_reupload').attr('disabled', true);
				} else if($('#lbl_ng_status_edit').text() == 'WITH FINAL REPLY') {
					$('#btn_ng_report_edit').hide();
					$('#btn_ng_add_disposition').attr('class','btn btn-success fa fa-eye');
					$('#btn_ng_add_disposition').text(' View Disposition');
					$('#btn_ng_add_disposition').show();
					$('#btn_ng_send_supplier').hide();
					$('#chk_reupload').attr('disabled', true);
				} else {
					$('#btn_ng_report_edit').hide();
					$('#btn_ng_send_supplier').hide();
					$('#btn_ng_add_disposition').hide();
					$('#chk_reupload').attr('disabled', false);
				}
				
				$('#file_ng_edit').hide();
				$('#file_ng_edit').attr('required', false);
				$('#chk_reupload').attr('checked', false);
				$('#modal_upload_ng_edit').modal();
			});
		});
	});
	
	$('#invoice_no_ng_edit').keyup(function(e){
		var key = e.which;
		if(key == 38 || key == 40){
			return false;
		}
		var pattern = $(this).val();
		fn_get_ng_invoice_num_datalist(pattern,'list_invoice_no_ng_edit');
	});

	$('#part_code_ng_edit').keyup(function(e){
		var key = e.which;
		if(key == 38 || key == 40){
			return false;
		}
		var pattern = $(this).val();
		fn_get_partname_by_partcode($(this).val(), 'part_name_ng', 'drawing_number_ng');
	});

	$('#invoice_no_ng_edit').change(function(e) {
		if($(this).val() != '' || e.keyCode == 13) {
			fn_get_partcode_datalist_by_invoice_num($(this).val(), 'list_part_code_edit');
		} 
	});

	$('#part_code_ng_edit').change(function() {
		if($(this).val() != '') {
			fn_get_partname_by_partcode($(this).val(), 'part_name_ng', 'drawing_number_ng_edit');
		}
	});

	$('#chk_reupload').click(function() {		
		if($(this).is(':checked')) {
			attachment = $('#btn_attachment_ng_edit').text();
			$('#file_ng_edit').show();
			$('#file_ng_edit').attr('required', true);
			$('#btn_attachment_ng_edit').text(' ');
			if($('#lbl_ng_status_edit').text() == 'FOR APPROVAL') {
				$('#container_upload_ng_message_edit').html('<h4>Re-uploading of file will reset the approval history (from approved to pending). Uncheck the checkbox if you want to cancel the action.</h4>');
			} else {
				$('#container_upload_ng_message_edit').html('<h4>Re-uploading of file will increment the revision number of Issuance No. and will reset the approval process.</h4>');
			}
			$('#container_upload_ng_message_edit').show();
			$('#btn_ng_report_edit').show();
			fn_ng_reset_approver_table('tbl_approver_ng_edit');
		} else {
			$('#file_ng_edit').hide();
			$('#file_ng_edit').attr('required', false);
			$('#btn_attachment_ng_edit').text(' '+attachment);
			$('#container_upload_ng_message_edit').hide();
			// $('#btn_ng_report_edit').hide();
			fn_ng_reload_approver_table();
		}
	});

	$('#btn_attachment_ng_edit').click(function() {
		window.location.href = "./pages/qfr/dl_ng_report.php?id="+$(this).val();
	});

	$('#btn_attachment_ng_view').click(function() {
		window.location.href = "./pages/qfr/dl_ng_report.php?id="+$(this).val();
	});
		
	$('#frm_upload_ng_update').on('submit', function(e) {
		e.preventDefault();
		$('.btn').prop("disabled",true);
		var current_status = $('#lbl_ng_status_edit').text();
		var serialized_data = new FormData(this);
		
		if(current_status == 'FOR APPROVAL') {
			var handler_action = "ng_update_report_info";
		} else {
			var handler_action = "ng_upload_report";
			var issuance = ($('#issuance_no_ng_edit').val()).split(' Rev. ');
			serialized_data.append("issuance_no_ng",issuance[0]);
			serialized_data.append("rev_no",issuance[1]);
		}
		if($('#supplier_ng').val() == '') {
			$('#container_upload_ng_message').html('Please select Supplier');
			$('#container_upload_ng_message').show();
		} else {
			$('#container_upload_ng_message').html('');
			$('#container_upload_ng_message').hide();
			
			if(fn_ng_validate_approvers('tbl_approver_ng_edit', 'container_upload_ng_message_edit')){
				var approvers   = [];
				var app_order   = [];
				var app_status  = [];
				var app_remarks = [];
				var app_logs    = [];
				$('#tbl_approver_ng_edit tbody tr').each(function() {
					app_order.push((($(this).find('td:eq(0)').text()).replace(/\s/g,'')).charAt(0));
					app_status.push(($(this).find('td:eq(1)').text()).replace(/\s/g,''));
					approvers.push($(this).find('td:eq(2) option:selected').val());
					app_remarks.push($(this).find('td:eq(3) option:selected').val());
					app_logs.push($(this).find('td:eq(4) option:selected').val());
				});
				serialized_data.append("action",handler_action);
				serialized_data.append("pkid",global_fkqr_ng);
				serialized_data.append("category_code",qfr_category);
				serialized_data.append("username",username);
				serialized_data.append("approvers",approvers);
				serialized_data.append("app_order",app_order);
				serialized_data.append("app_status",app_status);
				serialized_data.append("app_remarks",app_remarks);
				serialized_data.append("app_logs",app_logs);
				serialized_data.append("current_status",current_status);
					
				call_ajax_attachment(serialized_data, handler_ts_qfr_ng, function(result){
					$('#modal_upload_ng_edit').modal('hide');
					$('#modal_system_message').modal();
					$('#container_message').attr('class','alert alert-success');
					$('#container_message').html( '<h4>'+result['msg']+'</h4>' );
					dt_ng_records.ajax.reload();
					dt_ng_for_filling.ajax.reload();
					$('.btn').prop("disabled",false);
				});
			} 
		}
	});
		
	$('#'+tbl_ng+' tbody').on('click', '#btn_view', function() {
		global_fkqr_ng = $(this).val();
		fn_display_ng_details('lbl_ng_status_view','issuance_no_ng_view','issuance_date_ng_view','supplier_ng_view','invoice_no_ng_view','part_code_ng_view','part_name_ng_view','lot_no_ng_view','drawing_number_ng_view','material_type_ng_view','remarks_ng_view','btn_attachment_ng_view','tbl_approver_ng_view',function() {
			$('#file_ng_view').hide();
			$('#file_ng_view').attr('required', false);
			$('#chk_reupload').attr('checked', false);
			
			if($('#lbl_ng_status_view').text() == 'WITH TREATMENT' || $('#lbl_ng_status_view').text() == 'WITH FINAL REPLY') {
				$('#btn_ng_submit_disposition').hide();
				$('#btn_ng_view_disposition').show();
			} else {
				$('#btn_ng_view_disposition').hide();
			}
			fn_ng_check_disposition_rights();
			fn_ng_validate_approver(function () {
				$('#modal_approver_ng_view').modal();
			});
		});
	});
		
	$('#btn_ng_approve').click(function() {
		$('#container_approver_message').attr('class','alert alert-success');
		$('#container_approver_message').html('Are you sure you want to approve the request?<br><br>Remarks:<textarea name="remarks" style="width:100%;" rows="4"></textarea>');
		$('#container_approver_message').show();
		$('#modal_approver_message').modal();
	});
		
	$('#btn_ng_disapprove').click(function() {
		$('#container_approver_message').attr('class','alert alert-danger');
		$('#container_approver_message').html('Are you sure you want to approve the request?<br><br>Remarks:<textarea name="remarks" style="width:100%;" rows="4" required></textarea>');
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
			serialized_data.append("fkqr",global_fkqr_ng);
			serialized_data.append("status",status);
			serialized_data.append("username",username);
				
			call_ajax_attachment(serialized_data, handler_ts_qfr_ng, function(result){
				$('#modal_approver_message').modal('hide');
				$('#modal_approver_ng_view').modal('hide');
				$('#modal_system_message').modal();
				$('#container_message').attr('class','alert alert-success');
				$('#container_message').html( '<h4>'+result['msg']+'</h4>' );
				dt_ng_records.ajax.reload();
				dt_ng_for_filling.ajax.reload();
				$('.btn').prop("disabled",false);
			});
	});

	$('#btn_ng_send_supplier').click(function() {
		$('#btn_ng_send_attachment').text(' '+ $('#btn_attachment_ng_edit').text());
		$('#btn_ng_send_attachment').val(' '+ $('#btn_attachment_ng_edit').val());
		fn_ng_get_recipients_list('cmb_ng_send_to', function() {
			$('.chosen-select#cmb_ng_send_to').chosen({width:"100%", height: "100%"});
		});
		fn_ng_get_recipients_list('cmb_ng_send_cc', function() {
			$('.chosen-select#cmb_ng_send_cc').chosen({width:"100%", height: "100%"});
			fn_ng_load_email_recipients('cmb_ng_send_to','cmb_ng_send_cc',function() {
			   $('#modal_upload_ng_edit').modal('hide');
			   $('#modal_ng_send_supplier').modal(); 
			});   
		});                 
		if($('#frm_upload_ng_update #supplier_ng_edit').val() != '') {
			fn_get_supplier_email_address($('#frm_upload_ng_update #supplier_ng_edit').val(), 'recipients_to', 'cmb_ng_send_external_to', function() {
				$('.chosen-select#cmb_ng_send_external_to').chosen({width:"100%", height: "100%"});
				$('#cmb_ng_send_external_to').prop('disabled', true).trigger('chosen:updated');
			});
			fn_get_supplier_email_address($('#frm_upload_ng_update #supplier_ng_edit').val(), 'recipients_cc', 'cmb_ng_send_external_cc', function() {
				$('.chosen-select#cmb_ng_send_external_cc').chosen({width:"100%", height: "100%"});
				$('#cmb_ng_send_external_cc').prop('disabled', true).trigger('chosen:updated');
			});
		}
	});					

	$('#btn_ng_send_attachment').click(function() {
		window.location.href = "./pages/qfr/dl_ng_report.php?id="+$(this).val();
	});

	$('#frm_send_report_internal').on('submit', function(e) {
	   e.preventDefault();
	   $('.btn').prop("disabled",true);
	   var serialized_data = $(this).serialize();
	   var data = {
			"action" 				: "ng_send_for_disposition",
			"pkid"		    		: global_fkqr_ng,
			"send_to_internal"		: JSON.stringify($('#cmb_ng_send_to').val()),
			"send_to_external"		: JSON.stringify($('#cmb_ng_send_external_to').val()),
			"send_cc_internal"		: JSON.stringify($('#cmb_ng_send_cc').val()),
			"send_cc_external"		: JSON.stringify($('#cmb_ng_send_external_cc').val()),
			"username"		: username
		} 
		call_ajax_serialize(data, serialized_data, handler_ts_qfr_ng, function(result){
			// console.log(data);
			$('#modal_system_message').modal();	
			$('#modal_ng_send_supplier').modal('hide');
			$('#container_message').attr('class','alert alert-success');
			$('#container_message').html( '<h4>'+result['msg']+'</h4>' );
			dt_ng_records.ajax.reload();
			dt_ng_for_filling.ajax.reload();
			$('.btn').prop("disabled",false);
		});
	});

	$('#btn_ng_add_disposition').click(function() {
		fn_get_disposition_list('txt_ng_disposition', function() {
		  fn_ng_return_disposition_details_by_fkqr('txt_ng_sent_by','txt_ng_sent_date_time','txt_ng_sent_remarks','txt_ng_disposition', 'txt_ng_disposition_by', 'txt_ng_disposition_date', 'txt_ng_disposition_time', 'txt_ng_disposition_remarks', 'file_disposition', 'lbl_ng_reupload_initial_dispo','lbl_ng_initial_dispo', 'btn_ng_initial_dispo', 'cmb_ng_final_reply', 'cmb_ng_final_reply_by', 'txt_ng_final_reply_date', 'txt_ng_final_reply_time', 'cmb_ng_final_reply_remarks', 'file_final_reply', 'container_ng_disposition', 'container_ng_final_reply', 'btn_ng_final_dispo','btn_ng_submit_disposition', 'txt_hidden_disposition_type', 'modal_ng_add_disposition', function() {                    
			  $('#modal_ng_add_disposition').modal();
		  });  
		});
		
	});

	$('#btn_ng_view_disposition').click(function() {
		fn_get_disposition_list('txt_ng_disposition_view', function() {
		  fn_ng_return_disposition_details_by_fkqr('txt_ng_sent_by_view','txt_ng_sent_date_time_view','txt_ng_sent_remarks_view','txt_ng_disposition_view', 'txt_ng_disposition_by_view', 'txt_ng_disposition_date_view', 'txt_ng_disposition_time_view','txt_ng_disposition_remarks_view', 'file_disposition_view', '','','btn_ng_initial_dispo_view','cmb_ng_final_reply_view', 'cmb_ng_final_reply_by_view', 'txt_ng_final_reply_date_view', 'txt_ng_final_reply_time_view', 'cmb_ng_final_reply_remarks_view', 'file_final_reply_view', 'container_ng_disposition_view', 'container_ng_final_reply_view', 'btn_ng_final_dispo_view','btn_ng_submit_disposition_view', 'txt_hidden_disposition_type_view', 'modal_ng_view_disposition', function() {                    
				$('#modal_ng_view_disposition').modal();
		  });         
		});		
	});

	$('#frm_ng_add_disposition').on('submit', function(e) {
		e.preventDefault();
		$('.btn').prop("disabled",true);
		$('#txt_ng_disposition').prop('disabled', false);
		var serialized_data = new FormData(this);
			serialized_data.append("action","ng_add_disposition");
			serialized_data.append("fkqr",global_fkqr_ng);
			serialized_data.append("category_code",qfr_category);
			serialized_data.append("username",username);
				
			call_ajax_attachment(serialized_data, handler_ts_qfr_ng, function(result){
				$('#modal_ng_add_disposition').modal('hide');
				$('#modal_upload_ng_edit').modal('hide');
				$('#modal_system_message').modal();
				$('#container_message').attr('class','alert alert-success');
				$('#container_message').html( '<h4>'+result['msg']+'</h4>' );
				dt_ng_records.ajax.reload();
				dt_ng_for_filling.ajax.reload();
				$('.btn').prop("disabled",false);
			});
	});

	$('#frm_ng_add_disposition #chk_ng_reupload_initial_dispo').click(function() {
		if($(this).is(':checked')) {
			$('#file_disposition').prop('disabled', false);
		} else {
			$('#file_disposition').prop('disabled', true);
		}
	});

	$('#frm_ng_add_disposition #btn_ng_initial_dispo').click(function() {
		window.location.href = "./pages/qfr/dl_ng_disposition_report.php?id="+$(this).val()+'_1';
	});

	$('#frm_ng_add_disposition #btn_ng_final_dispo').click(function() {
		window.location.href = "./pages/qfr/dl_ng_disposition_report.php?id="+$(this).val()+'_2';
	});

	$('#txt_ng_disposition').change(function() {
		if($(this).val() == 'OK TO USE' || $(this).val() == 'USE AS IS') {
			$('#txt_hidden_final_reply_status').val('N/A');
		} else {
			$('#txt_hidden_final_reply_status').val('REQUIRED');   
		}
		$('#btn_ng_final_dispo').hide();
	});

	$('#btn_report_ng').click(function() {
		$('#container_ng_supplier').show();
		fn_return_fiscal_year('cmb_ng_fy_start');
		fn_return_fiscal_year('cmb_ng_fy_end');
		$('.chosen-select#cmb_ng_section').chosen({width:"100%", height: "100%"});		
		fn_get_ng_supplier_list('cmb_ng_supplier', function() {
			$('.chosen-select#cmb_ng_supplier').chosen({width:"100%", height: "100%"});
		});		
		$('#modal_ng_report').modal();
	});

	$('#frm_export_ng_report').on('submit', function(e) {
		e.preventDefault();
		var report_type = $('#cmb_ng_report_type').val();
		var ng_fy_start = $('#cmb_ng_fy_start').val();
		var ng_fy_end 	= $('#cmb_ng_fy_end').val();
		var ng_supplier	= JSON.stringify($('#cmb_ng_supplier').val());
		var ng_section 	= JSON.stringify($('#cmb_ng_section').val());
		if(report_type == 'dispo_summary') {
			window.location.href = './reports/excel_ng_report_disposition.php?rt='+report_type+'&fs='+ng_fy_start+'&fe='+ng_fy_end+'&sp='+ng_supplier+'&sc='+ng_section;
		} else if(report_type == 'dispo_leadtime_first') {
			window.location.href = './reports/excel_ng_report_disposition_first.php?rt='+report_type+'&fs='+ng_fy_start+'&fe='+ng_fy_end+'&sp='+ng_supplier+'&sc='+ng_section;
		} else if(report_type == 'dispo_leadtime_final') {
			window.location.href = './reports/excel_ng_report_disposition_final.php?rt='+report_type+'&fs='+ng_fy_start+'&fe='+ng_fy_end+'&sp='+ng_supplier+'&sc='+ng_section;
		} else if(report_type == 'ng_report_issuance_per_supplier') {
			window.location.href = './reports/excel_ng_report_issuance_per_supplier.php?rt='+report_type+'&fs='+ng_fy_start+'&fe='+ng_fy_end+'&sc='+ng_section;
		} else if(report_type == 'ng_report_per_material_type') {
			alert('No data found in IQC Database of SEIKO :( ');
			// window.location.href = './reports/excel_ng_report_per_material_type.php?rt='+report_type+'&fs='+ng_fy_start+'&fe='+ng_fy_end+'&sc='+ng_section;
		} 
	});

	$('#frm_export_ng_report #cmb_ng_report_type').change(function() {
		if($(this).val() == 'ng_report_issuance_per_supplier' || $(this).val() == 'ng_report_per_material_type') {
			$('#container_ng_supplier').hide();
		} else {
			$('#container_ng_supplier').show();
		}
	});
		
	function fn_ng_reload_wbs_record() {
		var data = {
			"action" 		: "ng_reload_wbs_record",
			"username" 		: username
		} 
		call_ajax(data, handler_ts_qfr_ng, function(result){
			$('#container_message').attr('class','');
			$('#modal_system_message').modal();
			$('#container_message').html( result['table'] );
		});
	}

	function fn_ng_get_new_issuance_no(callback) {
		var data = {
			"action" 		: "ng_get_new_issuance_no",
			"username" 		: username
		} 
		call_ajax(data, handler_ts_qfr_ng, function(result){
			$('#issuance_no_ng').val( result['issuance_no'] );
			callback();
		});
	}

	function fn_get_disposition_list(cmb_id, callback) {
		$('#'+cmb_id).empty();
		var data = {
			"action" 		: "ng_get_disposition_list"
		} 
		call_ajax(data, handler_ts_qfr_ng, function(result){
			$('#'+cmb_id).append( '<option value="">-</option>' );
			$('#'+cmb_id).append( result['html_select'] );
			callback();
		});
	}

	function fn_display_part_name(part_code,part_name_id) {
		$('#'+cmb_id).empty();
		var data = {
			"action" 		: "get_partcode_datalist_by_invoice_num",
			"invoice_num"	: invoice_num
		} 
		call_ajax(data, handler_ts_qfr, function(result){
			$('#'+cmb_id).append( '<option value="">-</option>' );
			$('#'+cmb_id).append( result['html_select'] );
		});
	}

	function fn_get_partcode_datalist_by_invoice_num(invoice_num, cmb_id) {
		$('#'+cmb_id).empty();
		var data = {
			"action" 		: "get_partcode_datalist_by_invoice_num",
			"invoice_num"	: invoice_num
		} 
		call_ajax(data, handler_ts_qfr, function(result){
			$('#'+cmb_id).append( '<option value="">-</option>' );
			$('#'+cmb_id).append( result['html_select'] );
		});
	}

	function fn_get_report_approvers(cmb_id, callback) {
		$('#'+cmb_id).empty();
		var data = {
			"action" 		: "get_report_approvers",
			"fk_module"		: ['3'],
			"approver_type"	: ['']
		} 
		call_ajax(data, handler_ts_qfr, function(result){
			$('#'+cmb_id).append( '<option>-</option>' );
			$('#'+cmb_id).append( result['html_select'] );
			$('#'+cmb_id).trigger("chosen:updated");
			callback();
		});
	}

	function fn_ng_validate_approvers(tbl_id, container_msg) {
		var no_input = '';
		var exist = '';
		var current_data = [];
		if(tbl_id == 'tbl_approver_ng') {
			$('#tbl_approver_ng tbody tr').each(function() {
				if(($(this).find('td:eq(0)').text()).trim() == "3rd Approver") {
				} else {
					if($(this).find('td:eq(1) option:selected').html() == '-') {
						no_input += ' - '+$(this).find('td:eq(0)').text()+'<br>';
					} else {
						if ( $.inArray($(this).find('td:eq(1) option:selected').html(), current_data) > -1 ) {
							exist += ' - '+$(this).find('td:eq(1) option:selected').html() + '<br>';
						} else {       
							if(typeof($(this).find('td:eq(1) option:selected').html()) != 'undefined') {
								current_data.push($(this).find('td:eq(1) option:selected').html());
							}
						}
					}
				}
			});
		} else if(tbl_id == 'tbl_approver_ng_edit') {
			$('#tbl_approver_ng_edit tbody tr').each(function() {
				if(($(this).find('td:eq(0)').text()).trim() == "3rd Approver") {
				} else {
					if($(this).find('td:eq(2) option:selected').html() == '-') {
						no_input += ' - '+$(this).find('td:eq(0)').text()+'<br>';
					} else {
						if ( $.inArray($(this).find('td:eq(2) option:selected').html(), current_data) > -1 ) {
							exist += ' - '+$(this).find('td:eq(2) option:selected').html() + '<br>';
						} else {    
							if(typeof($(this).find('td:eq(2) option:selected').html()) != 'undefined') {
								current_data.push($(this).find('td:eq(2) option:selected').html());
							}
						}
					}
				}
			});
		}
		if(no_input != '' || exist != '') {
			if(no_input != '') {                
				$('#'+container_msg).html('Please select data on: <br> '+no_input);
				$('#'+container_msg).show();
				$('.btn').prop("disabled",false);
				return false;
			}
			if(exist != '') {                
				$('#'+container_msg).html('Please remove the duplicate name of: <br> '+exist);
				$('#'+container_msg).show();
				$('.btn').prop("disabled",false);
				return false;
			}
		} else {
			$('#'+container_msg).hide();
			return true;
		}
	}
	function fn_display_ng_details(lbl_ng_status,issuance_no_ng,issuance_date_ng,supplier_ng,invoice_no_ng,part_code_ng,part_name_ng,lot_no_ng,drawing_number_ng,material_type_ng,remarks_ng,btn_attachment_ng,tbl_approver_ng,callback) {
		var data = {
			"action" 		: "ng_display_details_by_pkid",
			"pkid" 			: global_fkqr_ng
		} 
		call_ajax(data, handler_ts_qfr_ng, function(result){
			//console.log(result);
			$('#'+lbl_ng_status).html(result['status_main']);
			$('#'+lbl_ng_status).attr('class', result['status_class']);
			$('#'+issuance_no_ng).val(result['issuance_no']);
			$('#'+issuance_date_ng).val(result['issuance_date']);
			$('#'+supplier_ng).val(result['supplier']).trigger('chosen:updated');
			$('#'+invoice_no_ng).val(result['invoice_no']);
			$('#'+part_code_ng).val(result['part_code']);
			$('#'+part_name_ng).val(result['part_name']);
			$('#'+lot_no_ng).val(result['lot_no']);
			$('#'+drawing_number_ng).val(result['drawing_number']);
			$('#'+material_type_ng).val(result['material_type']);
			$('#'+remarks_ng).val(result['remarks']);
			// $('#'+btn_attachment_ng).text(' '+result['file_name']);
			$('#'+btn_attachment_ng).text(' Download File');
			$('#'+btn_attachment_ng).val(global_fkqr_ng);
			
			ng_approver_status 	    = result['status'];
			ng_approver_username 	= result['username'];
			ng_approver_name	 	= result['app_name'];
			ng_approver_remarks 	= result['app_remarks'];
			ng_approver_date_time 	= result['date_time'];
			
			fn_load_ng_approver_chosen(tbl_approver_ng,function() {
				setTimeout(function () {
					var ctr = 0;
					if(tbl_approver_ng == 'tbl_approver_ng_edit') {
						$('#tbl_approver_ng_edit tbody tr').each(function() {
							var cmb_id = ($(this).find('td:eq(2) .chosen-select').attr('id'));
							if(ng_approver_status[ctr] == 'PENDING' || ng_approver_status[ctr] == '-') {
								var disabled = false;
							} else {
								var disabled = true;
							}
							$(this).find('td:eq(1)').html('<center>'+ng_approver_status[ctr]+'</center>');
							$(this).find('td:eq(2) #'+cmb_id).val(ng_approver_username[ctr]).trigger('chosen:updated');
							$(this).find('td:eq(2) #'+cmb_id).prop('disabled',disabled).trigger("chosen:updated");
							$(this).find('td:eq(3) textarea').val(ng_approver_remarks[ctr]);
							$(this).find('td:eq(4)').text(ng_approver_date_time[ctr]);
							ctr++;
						});
					}
					if(tbl_approver_ng == 'tbl_approver_ng_view') {
						$('#tbl_approver_ng_view tbody tr').each(function() {
							var cmb_id = ($(this).find('td:eq(2) .chosen-select').attr('id'));
							if(ng_approver_status[ctr] == 'PENDING' || ng_approver_status[ctr] == '-') {
								var disabled = false;
							} else {
								var disabled = true;
							}
							$(this).find('td:eq(1)').html('<center>'+ng_approver_status[ctr]+'</center>');
							$(this).find('td:eq(2)').html(ng_approver_name[ctr]);
							$(this).find('td:eq(3) textarea').val(ng_approver_remarks[ctr]);
							$(this).find('td:eq(4)').text(ng_approver_date_time[ctr]);
							ctr++;
						});
					}
				},1000);
			});
			callback();
		});
	}

	function return_approver_order(num) {
		switch (num % 10) {
			case 1:  return num+'st';
			case 2:  return num+'nd';
			case 3:  return num+'rd';
		}
		return num+'th';  
	}

	function fn_load_ng_approver_chosen(tbl_id, callback) {
		$('#'+tbl_id+' tbody').empty();
		var tbl_body = '';
		var row = 1;
		if(tbl_id == 'tbl_approver_ng') {
			for(var i=0;i<3;i++) {
				setTimeout(function () {
					var order = return_approver_order(row);
					var cmb_id = 'cmb_'+order+'_approver_ng';
						tbl_body  = '<tr>';
						tbl_body += '	<td>';
						tbl_body += '		<center>'+order+' Approver</center>';
						tbl_body += '	</td>';
						tbl_body += '	<td>';
						tbl_body += '		<select data-placeholder="Select Approver" class="chosen-select" name="" id="'+cmb_id+'">';
						tbl_body += '		</select>';
						tbl_body += '	</td>';
						tbl_body += '</tr>';	
					$('#'+tbl_id+' tbody').append(tbl_body);
					fn_get_report_approvers(cmb_id,function() {
						$('.chosen-select#'+cmb_id).chosen({width:"100%", height: "100%"});
					});
					row++;				
				}, 1000);
				if(i == 2) {
					callback();
				}
			}		
		} 
		else if(tbl_id == 'tbl_approver_ng_edit') {
			for(var i=0;i<3;i++) {
				setTimeout(function () {
					if(row == 1){
						var stat = 'PENDING';
					} else {
					  var stat = '';  
					}
					var order = return_approver_order(row);
					var cmb_id = 'cmb_'+order+'_approver_ng';
						tbl_body  = '<tr>';
						tbl_body += '	<td>';
						tbl_body += '		<center>'+order+' Approver</center>';
						tbl_body += '	</td>';
						tbl_body += '	<td>';
						tbl_body += '		<center>'+stat+'</center>';
						tbl_body += '	</td>';
						tbl_body += '	<td>';
						tbl_body += '		<select data-placeholder="Select Approver" class="chosen-select" name="" id="'+cmb_id+'">';
						tbl_body += '		</select>';
						tbl_body += '	</td>';
						tbl_body += '	<td>';
						tbl_body += '		<center><textarea style="width:100%;" rows="2" disabled></textarea></center>';
						tbl_body += '	</td>';
						tbl_body += '	<td>';
						tbl_body += '		<center></center>';
						tbl_body += '	</td>';
						tbl_body += '</tr>'; 
					$('#'+tbl_id+' tbody').append(tbl_body);
					fn_get_report_approvers(cmb_id,function() {
						$('.chosen-select#'+cmb_id).chosen({width:"100%", height: "100%"});alert('draw chosen');
					});
					row++;				
				}, 1000);
				if(i == 2) {alert(i+' done');
					callback();
				}
			}	
		} else if(tbl_id == 'tbl_approver_ng_view') {
			for(var i=0;i<3;i++) {
				setTimeout(function () {
					var order = return_approver_order(row);
					var cmb_id = 'cmb_'+order+'_approver_ng';
						tbl_body  = '<tr>';
						tbl_body += '	<td>';
						tbl_body += '		<center>'+order+' Approver</center>';
						tbl_body += '	</td>';
						tbl_body += '	<td>';
						tbl_body += '		<center></center>';
						tbl_body += '	</td>';
						tbl_body += '	<td>';
						tbl_body += '		<center></center>';
						tbl_body += '	</td>';
						tbl_body += '	<td>';
						tbl_body += '		<center><textarea style="width:100%;" rows="2" disabled></textarea></center>';
						tbl_body += '	</td>';
						tbl_body += '	<td>';
						tbl_body += '		<center></center>';
						tbl_body += '	</td>';
						tbl_body += '</tr>'; 
					$('#'+tbl_id+' tbody').append(tbl_body);
					row++;				
				}, 100);
				if(i == 2) {
					callback();
				}
			}	
		}
	}

	function fn_ng_validate_approver(callback) {
		var data = {
			"action" 		: "ng_validate_approver",
			"pkid"			: global_fkqr_ng,
			"username"		: username
		} 
		call_ajax(data, handler_ts_qfr_ng, function(result){
			if(result['is_approver'] == "YES") {
				$('#btn_ng_approve').show();
				$('#btn_ng_disapprove').show();
			} else {
				$('#btn_ng_approve').hide();
				$('#btn_ng_disapprove').hide();
			}
			callback();
		});
	}

	function fn_ng_reset_approver_table(tbl_id) {
		fn_load_ng_approver_chosen('tbl_approver_ng_edit',function() {            
		});
	}

	function fn_ng_reload_approver_table() {
		var ctr = 0;
		$('#tbl_approver_ng_edit tbody tr').each(function() {
			var cmb_id = ($(this).find('td:eq(2) .chosen-select').attr('id'));
			if(ng_approver_status[ctr] == 'PENDING' || ng_approver_status[ctr] == '-') {
				var disabled = false;
			} else {
				var disabled = true;
			}
			$(this).find('td:eq(1)').html('<center>'+ng_approver_status[ctr]+'</center>');
			$(this).find('td:eq(2) #'+cmb_id).val(ng_approver_username[ctr]).trigger('chosen:updated');
			$(this).find('td:eq(2) #'+cmb_id).prop('disabled',disabled).trigger("chosen:updated");
			$(this).find('td:eq(3) textarea').val(ng_approver_remarks[ctr]);
			$(this).find('td:eq(4)').text(ng_approver_date_time[ctr]);
			ctr++;
		});
	}

	function fn_ng_get_recipients_list(cmb_id, callback) {
		$('#'+cmb_id).empty();
		var data = {
			"action" 		: "get_email_recipients_list"
		} 
		call_ajax(data, handler_ts_qfr, function(result){
			$('#'+cmb_id).append( '<option>-</option>' );
			$('#'+cmb_id).append( result['html_select'] );
			callback();
		});
	}

	function fn_ng_load_email_recipients(txt_to_id, txt_cc_id, callback) {
		var data = {
			"action" 		: "get_email_recipients_by_category",
			"qfr_category"	: qfr_category
		} 
		call_ajax(data, handler_ts_qfr, function(result){
			var to_recipients = result['to'];
			$.each(to_recipients.split(','), function(index, element)
			{
			   $('#'+txt_to_id).find('option[value="'+ element +'"]').attr('Selected', 'Selected');
			   $("#"+txt_to_id).trigger('chosen:updated');   
			});
			var cc_recipients = result['cc'];
			$.each(cc_recipients.split(','), function(index, element)
			{
			   $('#'+txt_cc_id).find('option[value="'+ element +'"]').attr('Selected', 'Selected');
			   $("#"+txt_cc_id).trigger('chosen:updated');   
			});
			callback();
		});
	}

	function fn_ng_return_disposition_details_by_fkqr(txt_ng_sent_by, txt_ng_sent_date_time, txt_ng_sent_remarks, txt_ng_disposition, txt_ng_disposition_by, txt_ng_disposition_date, txt_ng_disposition_time, txt_ng_disposition_remarks, file_disposition,lbl_ng_reupload_initial_dispo, lbl_ng_initial_dispo, btn_ng_initial_dispo, cmb_ng_final_reply, cmb_ng_final_reply_by, txt_ng_final_reply_date, txt_ng_final_reply_time, cmb_ng_final_reply_remarks, file_final_reply, container_ng_disposition, container_ng_final_reply, btn_ng_final_dispo, btn_ng_submit_disposition, txt_hidden_disposition_type, modal_ng_add_disposition, callback) {
		var data = {
			"action" 		: "ng_return_disposition_details_by_fkqr",
			"fkqr"          : global_fkqr_ng
		} 
		call_ajax(data, handler_ts_qfr_ng, function(result){
			if(result['disposition'] == '' && result['disposition_by'] == '' && result['disposition_date'] == '') {
				$('#container_ng_disposition input').prop('disabled',false);
				$('#container_ng_disposition select').prop('disabled',false);
				$('#container_ng_disposition textarea').prop('disabled',false);
				$('#container_ng_final_reply input').prop('disabled',false);
				$('#container_ng_final_reply select').prop('disabled',false);
				$('#container_ng_final_reply textarea').prop('disabled',false);
				
				$('#'+btn_ng_initial_dispo).hide();
				$('#'+lbl_ng_initial_dispo).show();
				$('#'+file_disposition).show();
				$('#'+lbl_ng_reupload_initial_dispo).hide();
				$('#'+btn_ng_submit_disposition).show();
				$('#'+container_ng_final_reply).hide();
				
				$('#'+file_final_reply).prop('required', false);                
				$('#'+file_disposition).attr('style', 'width:100%;display:inline-block;');                
				$('#'+txt_hidden_disposition_type).val('WITH TREATMENT');
				$('#'+modal_ng_add_disposition+' .modal-title').html('<i class="fa fa-plus-circle"></i> Add Disposition');
			} 
			else if(result['final_reply_status'] == 'N/A' && result['final_reply_date'] == '' && result['final_reply_time'] == '') {
				$('#'+file_disposition).attr('style', 'width:60%;display:inline-block;');
				$('#'+file_disposition).prop('readOnly', false);
				$('#'+file_disposition).prop('disabled', true);

				$('#'+btn_ng_initial_dispo).show();
				$('#'+lbl_ng_initial_dispo).hide();
				$('#'+file_disposition).show();
				$('#'+btn_ng_final_dispo).hide();
				$('#'+lbl_ng_reupload_initial_dispo).show();
				$('#'+btn_ng_submit_disposition).show();
				$('#'+btn_ng_submit_disposition).text(' Update');
				$('#'+btn_ng_submit_disposition).attr('class','btn btn-info fa fa-edit');
				$('#'+file_final_reply).show();                 

				$('#'+container_ng_final_reply).hide();

				$('#'+txt_hidden_disposition_type).val(result['disposition']);
				$('#'+modal_ng_add_disposition+' .modal-title').html('<i class="fa fa-eye"></i> View Disposition');
			} else if(result['final_reply_status'] == 'REQUIRED' && result['final_reply_date'] == '' && result['final_reply_time'] == '') {
				$('#'+container_ng_final_reply+' input').prop('disabled',false);
				$('#'+container_ng_final_reply+' select').prop('disabled',false);
				$('#'+container_ng_final_reply+' textarea').prop('disabled',false);
				$('#'+container_ng_final_reply+' input').prop('required',true);
				$('#'+container_ng_final_reply+' select').prop('required',true);
				$('#'+file_final_reply).prop('required', true);

				$('#'+file_disposition).attr('style', 'width:60%;display:inline-block;');
				$('#'+file_disposition).prop('readOnly', false);
				$('#'+file_disposition).prop('disabled', true);

				$('#'+btn_ng_initial_dispo).show();
				$('#'+lbl_ng_initial_dispo).hide();
				$('#'+file_disposition).show();
				$('#'+btn_ng_final_dispo).hide();
				$('#'+lbl_ng_reupload_initial_dispo).show();
				$('#'+btn_ng_submit_disposition).show();
				$('#'+file_final_reply).show();  
				
				$('#'+container_ng_final_reply).show();
				$('#container_ng_sent_details').show();

				$('#'+txt_ng_final_reply_date).attr({'min' : result['disposition_date']});
				$('#'+txt_hidden_disposition_type).val('WITH FINAL REPLY');
				$('#txt_hidden_final_reply_status').val(result['final_reply_status']);
				$('#'+modal_ng_add_disposition+' .modal-title').html('<i class="fa fa-plus-circle"></i> Add Disposition');
			} else {
				$('#'+container_ng_disposition+' input').prop('disabled',false);
				$('#'+container_ng_disposition+' select').prop('disabled',false);
				$('#'+container_ng_disposition+' textarea').prop('disabled',false);
				$('#'+container_ng_final_reply+' input').prop('disabled',false);
				$('#'+container_ng_final_reply+' select').prop('disabled',false);
				$('#'+container_ng_final_reply+' textarea').prop('disabled',false);
							  
				$('#'+file_final_reply).hide();       
				$('#'+container_ng_final_reply).show();
				$('#container_ng_sent_details').hide();
				$('#'+btn_ng_submit_disposition).hide();       
				$('#'+lbl_ng_reupload_initial_dispo).hide();
				$('#'+lbl_ng_initial_dispo).show();
				$('#'+file_disposition).hide();
				$('#'+btn_ng_initial_dispo).show();
				$('#'+btn_ng_final_dispo).show();
				$('#'+container_ng_final_reply).show();
				$('#container_ng_sent_details').show();
				$('#'+modal_ng_add_disposition+' .modal-title').html('<i class="fa fa-eye"></i> View Disposal');
			}
			
			$('#container_ng_sent_details').show();         
			$('#'+container_ng_disposition).show();
			$('#'+btn_ng_initial_dispo).val(global_fkqr_ng);
			$('#'+txt_ng_sent_by).val(result['sent_by']);
			$('#'+txt_ng_sent_date_time).val(result['sent_date']);
			$('#'+txt_ng_sent_remarks).val(result['sent_remarks']);
			$('#'+txt_ng_disposition).val(result['disposition']);
			$('#'+txt_ng_disposition_by).val(result['disposition_by']);
			$('#'+txt_ng_disposition_date).val(result['disposition_date']);
			$('#'+txt_ng_disposition_time).val(result['disposition_time']);
			$('#'+txt_ng_disposition_remarks).val(result['disposition_remarks']);
			$('#'+cmb_ng_final_reply).val(result['final_reply']);
			$('#'+cmb_ng_final_reply_by).val(result['final_reply_by']);
			$('#'+txt_ng_final_reply_date).val(result['final_reply_date']);
			$('#'+txt_ng_final_reply_time).val(result['final_reply_time']);
			$('#'+cmb_ng_final_reply_remarks).val(result['final_reply_remarks']);
			$('#'+btn_ng_final_dispo).val(global_fkqr_ng);
			callback();
		});
	}

	function fn_ng_check_disposition_rights() {
		var data = {
			"action" 	: "ng_check_disposition_rights",
			"username" 	: username
		}
		call_ajax(data, handler_ts_qfr_ng, function(result){		
			if(result['access'] == 0) {
				$('#btn_ng_send_supplier').hide();
			} else {
				$('#btn_ng_send_supplier').show();
			}
		});
	}

	function fn_get_ng_invoice_num_datalist(pattern,list_id){
		$('#'+list_id).empty();
		var data = {
			"action" : "get_ng_invoice_num_datalist",
			"pattern" : pattern
		}
		call_ajax(data, handler_ts_qfr, function(result){		
			// console.log(result['html']);
			$('#'+list_id).append(result['html']);
		});
	}

	function fn_get_partname_by_partcode(part_code, txt_part_name, txt_drawing_number) {
		var data = {
			"action" 		: "get_partname_by_partcode",
			"part_code"		: part_code
		} 
		call_ajax(data, handler_ts_qfr, function(result){
			$('#'+txt_part_name).val(result['part_name']);
			$('#'+txt_drawing_number).val(result['drawing_number']);
		});
	}

	function fn_return_fiscal_year(cmb_id) {
		$('#'+cmb_id).empty();
		var data = {
			"action" 		: "get_fiscal_year"
		} 
		call_ajax(data, handler_ts_qfr, function(result){
			$('#'+cmb_id).append( result['html_select'] );
		});
	}

	
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
		dt_ng_records.ajax.url("server_side_scripts/qr/dt_ng.php?un="+username+"&wh="+global_ng_as_where).load();
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
		call_ajax(data, handler_ts_qfr, function(result){	
			for(var i=0; i < result['ctr']; i++) {
				$('#'+select_id).append(result['option'][i]);
			}
		});
	}

	function fn_ng_advance_search(serialized_data) {
		var data = {
			"action"	: "sa_advance_search"
		}
		call_ajax_serialize(data, serialized_data, handler_ts_qfr, function(result){	
			//console.log(result);
			global_ng_as_where = encodeURIComponent(result['sql_where']);
			dt_ng_records.ajax.url("server_side_scripts/qr/dt_ng.php?un="+username+"&wh="+global_ng_as_where).load();
		});
	}

	function fn_get_ng_supplier_list(cmb_id, callback) {
		$('.chosen-select option#'+cmb_id).prop('selected', false).trigger('chosen:updated'); 
		$('#'+cmb_id).empty();
		var data = {
			"action" 		: "get_supplier_list"
		} 
		call_ajax(data, handler_ts_qfr, function(result){
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
		call_ajax(data, handler_ts_qfr, function(result){
			$('#'+cmb_id).append( '<option value="">-</option>' );
			$('#'+cmb_id).append( result['html_select'] );
			callback();
		});
	}
	
	function fn_get_supplier_email_address(supplier, category, id, callback) {
		$('#frm_send_report_internal #'+id).val('').trigger('chosen:updated');
		var data = {
			"action" 		: "get_supplier_email_address",
			"supplier"		: supplier,
			"field_name"	: category
		}
		call_ajax(data, handler_ts_qfr, function(result) {
			$('#frm_send_report_internal #'+id).append(result['html_select']);
			$('#frm_send_report_internal #'+id).trigger('chosen:updated');
			callback();
		});
	}

	/* ************************************** 
		End - Advanced Search 
	************************************** */

/* **************************************************
	NG Report / Special Acceptance - End
/***************************************************/