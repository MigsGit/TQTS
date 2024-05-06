/* **************************************************
	YPICS 4.0 - Start
/***************************************************/
		
	function fn_get_po_number_list(pattern, list_id) {
		$('#'+list_id).empty();
        var data = {
            "action" : "get_po_datalist",
            "pattern" : pattern
        }
        call_ajax(data, handler_common, function(result){			
            $('#'+list_id).append(result['html']);
		});
	}
	
	function fn_get_series_name_by_po_number(po_number, txt_id) {
		var data = {
            "action" : "get_series_name_by_po_number",
            "pattern" : po_number
        }
        call_ajax(data, handler_common, function(result){			
            $('#'+txt_id).val(result['series_name']);
		});
	}
	
	function fn_get_series_name_datalist(pattern, list_id) {
		$('#'+list_id).empty();
        var data = {
            "action" : "get_series_name_datalist",
            "pattern" : pattern
        }
        call_ajax(data, handler_common, function(result){			
            $('#'+list_id).append(result['html']);
		});
	}
	
	function fn_get_po_number_by_series_name(series_name, txt_id) {
		var data = {
            "action" : "get_po_number_by_series_name",
            "pattern" : series_name
        }
        call_ajax(data, handler_common, function(result){			
            $('#'+txt_id).val(result['po_number']);
		});
	}
	
	function fn_get_po_details(po_number,frm_id,array_fields){
	var data = {
		"action"	: "get_po_details",
		"po_number"	: po_number
	}
	call_ajax(data, './handler/handler_qfr.php', function(result){
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

/* **************************************************
	YPICS 4.0 - End
/***************************************************/