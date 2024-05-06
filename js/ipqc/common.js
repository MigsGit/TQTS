/* **************************************************
	Common Functions - Start
/***************************************************/
/**
 * 
 * fn_get_ipqc_emp_list
 * fn_return_report_approvers
 * fn_return_report_approvers_dept
 * fn_return_report_approvers_dept
 * fn_get_operators_name_list
 * $('input[type="file"]').change(function() {
 * 
 */
	function fn_get_ipqc_emp_list(cmb_id, role, logdel, callback) {
		$('#'+cmb_id).empty();
		var data = {
			"action"	: "get_emp_list_by_section",
			"role"		: role,
			"section"	: "IPQC",
			"logdel"	: logdel
		}
		call_ajax(data, handler_common, function(result){			
            $('#'+cmb_id).append(result['html_select']);
			callback();
		});
	}
	
	function fn_return_report_approvers(cmb_id, fk_module, callback) {
		$('#'+cmb_id).empty();
		var data = {
			"action" 		: "get_report_approvers",
			"fk_module"		: fk_module,
			"approver_type"	: ['']
		} 
		call_ajax(data, handler_common, function(result){
			// $('#'+cmb_id).append( '<option>-</option>' );
			$('#'+cmb_id).append( result['html_select'] );
			$('#'+cmb_id).trigger("chosen:updated");
			callback();
		});
	}
	
	function fn_return_report_approvers_dept(cmb_id, fk_module, callback) {
		$('#'+cmb_id).empty();
		var data = {
			"action" 		: "get_report_approvers",
			"fk_module"		: fk_module,
			"approver_type"	: ['Department Head']
		} 
		call_ajax(data, handler_common, function(result){
			// $('#'+cmb_id).append( '<option>-</option>' );
			$('#'+cmb_id).append( result['html_select'] );
			$('#'+cmb_id).trigger("chosen:updated");
			callback();
		});
	}
	
	function fn_get_operators_name_list(cmb_id, callback) {
		$('#'+cmb_id).empty();
		var data = {
			"action"	: "get_operators_name"
		}
		call_ajax(data, handler_common, function(result){			
            $('#'+cmb_id).append(result['html_select']);
			callback();
		});
	}
	
	// $('input[type="file"]').change(function() {
	// 	if(this.files[0].size > 2097152){
	// 	   alert("File is too big! Maximum file size is 2MB only.");
	// 	   this.value = "";
	// 	};
	// });

/* **************************************************
	Common Functions - End
/***************************************************/