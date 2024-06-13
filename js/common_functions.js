/* Note: you need to call jquery or other library for these to work */
var handler_common_handler		= "handler/common_handler.php";

/* Call basic ajax for submit */
function call_ajax(data, handler, fn) {
    data = $.param(data);
    $.ajax({
        type: "post",
        dataType: "json",
        data: data,
        url: handler,
        success: function (result) {
            fn(result);
        },
        error: function (result) {
            fn(result);
        }
    });
}

function call_ajax_serialize(data, serialized_data, handler, fn) {
    data = $.param(data) + '&' + serialized_data;
	$.ajax({
        type: "post",
        dataType: "json",
        data: data,
        url: handler,
        success: function (result) {
            fn(result);
        },
        error: function (result) {
            alert('error ajax');
        }
    });
}

function call_ajax_async_false(data, handler, fn) {
    data = $.param(data);
    $.ajax({
        type: "post",
        dataType: "json",
        data: data,
        url: handler,
		async: false,
        success: function (result) {
            fn(result);
        },
        error: function (result) {
            alert('error ajax');
        }
    });
}

function create_table(table_id, table_class, array_theader, array_tbody) {
    var html = '<table id="' + table_id + '" class="' + table_class + '">';
    /* Generate table header */
	html += '	<thead>';
	for(x=0;x<array_theader.length;x++){
		html += '	<th>' + array_theader[x] + '</th>';
    }
	html += '	</thead>'
	/* Generate table body */
	html += '	<tbody>';
	for(x=0;x<array_theader.length;x++){
		html += '	<td>' + array_tbody[x] + '</td>';
    }
	html += '	</tbody>';
	html += '</table>';
	return html;
}

function call_ajax_attachment(serialized_data, handler, fn) {
	$.ajax({
		url				: handler, 		
		type			: "POST",          
		data			: serialized_data, 
		contentType		: false,       
		dataType		: 'json',
		cache			: false,             
		processData		: false,     
		success			: function(result)  
		{
			fn(result);
		}, error : function (result) {
			// alert('ERROR: '+result['upload_msg']);
			/**
			 * TODO: Debug the for disposition in SAR
			 */
			alert('Email Sent');
		}
	}); 
}

function table_loading_screen(tbl_id,colspan){
	var html  = '<tr>';
		html += ' <td colspan="'+colspan+'"><center><span class="fa fa-4x fa-circle-o-notch fa-spin"></span> <h3>Loading.....</h3></center></td>'; 
		html += '</tr>';
	$('#'+tbl_id + ' tbody').empty();
	$('#'+tbl_id + ' tbody').append( html );
}

function fn_system_message_timer(system_message_id){
	var counter = 5;
	$('#'+system_message_id+' .modal-footer #div_countdown').empty();
	$('#'+system_message_id+' .modal-footer #div_countdown').append("System message will automatically close in "+counter+"...");
	var interval = setInterval(function() {
		counter--;
		/* Display 'counter' wherever you want to display it */
		$('#'+system_message_id+' .modal-footer #div_countdown').empty();
		$('#'+system_message_id+' .modal-footer #div_countdown').append("System message will automatically close in "+counter+"...");
		if (counter == 0) {
			/* Clear counter */
			clearInterval(interval);
			$('#'+system_message_id+' .modal-footer #div_countdown').empty();
			/* 
				Close all the modal with ID that starts with modal_ and ends with _system message
				Regex Used:
				div[id^=modal_][id$=_system_message]
			*/
			$('div[id^=modal_][id$=_system_message]').modal('hide');
		}
	}, 1000);
}

function assign_value_select2(combo_id,data_value){
	$(combo_id).select2({
		data : data_value
	});
	var username_array = [];
	$.each(data_value, function(key, value){
		username_array.push(value['id']);
	});
	$(combo_id).val(username_array).trigger('change');
	console.log(data_value);
	
}

function re_initialize_select2_server_side(combo_id,dropdown_parent,data_value,ajax_url){
	$(combo_id).select2({
		dropdownParent	: $(dropdown_parent),
		minimumInputLength: 2,
		triggerChange: true,
		allowClear: true,
		placeholder: {
			id: "",
			placeholder: "Leave blank to ..."
		},
		ajax: {
		url: ajax_url,
			dataType: 'json',
			delay: 100,
			data: function (params) {
				return {
					q: params.term, // search term
				};
			},
			processResults: function (data) {
				return {
					/* get the json encode data data[id => [], text => []] */
					results: data
				};
			},
			cache: true
		}
	});
}

/* 
	Common Functions 
*/
function fn_get_emp_name_by_username(username, txt_id){
	var data = {
		"action"	: "get_emp_name_by_username2",
		"username"	: username
	}
	call_ajax(data, handler_common_handler, function(result){
		$('#'+txt_id).val(result['emp_name']);
	});
}
function fn_get_emp_name_by_username_array(username_array, txt_id){
	var data = {
		"action"			: "get_emp_name_by_username_array",
		"username_array"	: username_array
	}
	call_ajax(data, handler_common_handler, function(result){
		$('#'+txt_id).val(result['emp_name']);
	});
}


/* 
	YPICS Common Functions 
*/
function get_po_details(text_id,po_number,callback){
	var data = {
		"action"	: "get_po_details",
		"po_number"	: po_number
	}
	call_ajax(data, handler_common_handler, function(result){
		console.log('result',result);
		callback(result);
	});
}

function fn_get_partcode_datalist(datalist_id,pattern){
	var data = {
		"action"	: "get_partcode_datalist",
		"pattern"	: pattern
	}
	call_ajax(data, handler_common_handler, function(result){
		console.log(result);
		$('#'+datalist_id).empty();
		$('#'+datalist_id).append(result['html']);
	});
}

function fn_get_po_number_datalist(datalist_id,pattern){
	var data = {
		"action"	: "get_po_datalist",
		"pattern"	: pattern
	}
	call_ajax(data, handler_common_handler, function(result){
		console.log(result);
		$('#'+datalist_id).empty();
		$('#'+datalist_id).append(result['html']);
	});
}

function fn_get_partname_by_partcode(input_field_id,partcode){
	console.log('common handler to CNYPICS');
	var data = {
		"action"	: "get_partname_by_partcode",
		"partcode"	: partcode
	}
	call_ajax(data, handler_common_handler, function(result){
		console.log(result);
		$('#'+input_field_id).val(result['partname']);
	});
}

