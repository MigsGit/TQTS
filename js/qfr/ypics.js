/* YPICS 4.0 */
function fn_get_ng_invoice_num_datalist(pattern,datalist_id){
	$('#'+datalist_id).empty(); //added 10/01/2018
	var data = {
		"action"	: "get_invoice_num_list",
		"pattern"	: pattern
	}
	call_ajax(data, common_handler, function(result){
		console.log(result);
		// $('#'+datalist_id).empty();
		$('#'+datalist_id).append(result['html']);
	});
}
function fn_get_partcode_list(pattern,datalist_id){
	var data = {
		"action"	: "get_partcode_list",
		"pattern"	: pattern
	}
	call_ajax(data, handler_qfr, function(result){
		// console.log(result);
		$('#'+datalist_id).empty();
		for(x=0;x<result['part_code'].length;x++){
			$('#'+datalist_id).append('<option>'+result['part_code'][x]+'</option>');
		}
	});
}

function fn_get_partname(code,frm_id){
	var data = {
		"action"	: "get_partname_by_partcode",
		"part_code"	: code
	}
	call_ajax(data, handler_qfr, function(result){
		console.log(result);
		$('#'+frm_id+' input[name="parts_affected_parts"]').val(result['part_name']);
		$('#'+frm_id+' input[name="drawing_number"]').val(result['drawing_number']);
		$('#'+frm_id+' input[name="supplier"]').val(result['supplier']);
	});
}
function fn_get_partname_at(code,frm_id){
	var data = {
		"action"	: "get_partname_by_partcode_at",
		"part_code"	: code
	}
	call_ajax(data, handler_qfr, function(result){
		// console.log(result);
		$('#'+frm_id+' input[name="product"]').val(result['part_name']);
		// $('#'+frm_id+' input[name="drawing_number"]').val(result['drawing_number']);
		// $('#'+frm_id+' input[name="supplier"]').val(result['supplier']);
	});
}

function fn_get_partname_place_in_input(code,input_id){
	var data = {
		"action"	: "get_partname_by_partcode_at",
		"part_code"	: code
	}
	call_ajax(data, handler_qfr, function(result){
		$('#'+input_id).val(result['part_name']);
	});
}

function fn_get_po_list(pattern,datalist_id){
	$('#'+datalist_id).empty(); //added 10/01/2018
	var data = {
		"action"	: "get_po_list",
		"pattern"	: pattern
	}
	call_ajax(data, handler_qfr, function(result){
		// console.log(result);
		// $('#'+datalist_id).empty();
		for(x=0;x<result['po_number'].length;x++){
			$('#'+datalist_id).append('<option>'+result['po_number'][x]+'</option>');
		}
	});
}

function fn_get_devicename_by_po(po_number,frm_id){
	var data = {
		"action"	: "get_po_details",
		"po_number"	: po_number
	}
	call_ajax(data, handler_qfr, function(result){
		$('#'+frm_id).val(result['device_name']);
	});
}

function fn_get_po_details(po_number,frm_id,array_fields){
	var data = {
		"action"	: "get_po_details",
		"po_number"	: po_number
	}
	call_ajax(data, handler_qfr, function(result){
		// console.log(result);
		if(array_fields[0] != ''){
			$('#'+frm_id+' '+array_fields[0]).val(result['device_name']);
		}if(array_fields[1] != ''){
			$('#'+frm_id+' '+array_fields[1]).val(result['po_qty']);
		}if(array_fields[2] != ''){
			$('#'+frm_id+' '+array_fields[2]).val(result['drawing_number']);
		}if(array_fields[3] != ''){
			$('#'+frm_id+' '+array_fields[3]).val(result['customer_name']);
		}			
		// $('#'+frm_id+' input[name="parts_affected_device"]').val(result['device_name']);
	});
}


/* YPICS Subsystems */
function fn_get_lot_number_list(pattern, datalist_id, callback) {
	var data = {
		"action"	: "get_lot_number_list",
		"pattern"	: pattern
	}
	call_ajax(data, common_handler, function(result){
		$('#'+datalist_id).empty();
		$('#'+datalist_id).append(result['html_select']);
		callback();
	});
}
function fn_get_quantity_by_lot_number(lot_number, txt_id) {
	var data = {
		"action"		: "get_quantity_by_lot_number",
		"lot_number"	: lot_number
	}
	call_ajax(data, common_handler, function(result){
		$('#'+txt_id).val(result['quantity']);
	});
}