var tbl_approver = $('#tbl_approver').DataTable({
	"processing": true,
	"serverSide": true,
	"ajaxSource": "server_side_scripts/configuration/approver_main.php"
});

$('#btn_add_approver').click(function(){
	$('#modal_add_approver').modal('show');
});

$('#frm_add_approver select[name="subsystem_name"]').change(function(){
	fn_get_module_list('frm_add_approver select[name="fk_module"]',$(this).val());
});

$('#frm_add_approver select[name="fk_module"]').change(function(){
	if($(this).val() == 15) {
		$('#frm_add_approver input[name="approver_type"]').prop('readonly', true);
	} else {
		fn_get_approver_type('frm_add_approver #list_approver_type',$(this).val());
		$('#frm_add_approver input[name="approver_type"]').prop('readonly', false);
	}
	
});

$('#frm_add_approver input[name="approver_username"]').keyup(function(e){
	var key = e.which;
	if(key == 38 || key == 40){
		return false;
	}
	var pattern = $(this).val();
	fn_get_approver_user_list('frm_add_approver #list_approver_username_list',pattern);
});

$('#frm_add_approver input[name="username"]').keyup(function(e){
	var key = e.which;
	if(key == 38 || key == 40){
		return false;
	}
	fn_get_approver_user_list('frm_add_approver #list_approver_username_list',$(this).val());
});

$('#frm_add_approver').submit(function(e){
	e.preventDefault();
	var serialized_data = $(this).serialize();
	fn_save_approver(serialized_data);
});

fn_get_subystem_list('frm_add_approver select[name="subsystem_name"]');
function fn_get_subystem_list(object_id){
	var data = {
		"action"	: "get_subystem_list"
	}
	call_ajax(data, handler_configuration, function(result){
		//console.log(result);
		$('#'+object_id).empty();
		$('#'+object_id).append('<option value=""></option>');
		$('#'+object_id).append(result['html']);
	});
}

function fn_get_module_list(object_id,subsystem){
	var data = {
		"action"	: "get_module_list",
		"subsystem"	: subsystem
	}
	call_ajax(data, handler_configuration, function(result){
		//console.log(result);
		$('#'+object_id).empty();
		$('#'+object_id).append('<option value=""></option>');
		$('#'+object_id).append(result['html']);
	});
}

function fn_get_approver_type(object_id,module){
	var data = {
		"action"	: "get_approver_type",
		"module"	: module
	}
	call_ajax(data, handler_configuration, function(result){
		//console.log(result);
		$('#'+object_id).empty();
		$('#'+object_id).append('<option value=""></option>');
		$('#'+object_id).append(result['html']);
	});
}

fn_get_approver_user_list('frm_add_approver #list_approver_username_list',"");
function fn_get_approver_user_list(object_id,pattern){
	var data = {
		"action"	: "get_approver_user_list",
		"pattern"	: pattern
	}
	call_ajax(data, handler_configuration, function(result){
		//console.log(result);
		$('#'+object_id).empty();
		$('#'+object_id).append('<option value=""></option>');
		$('#'+object_id).append(result['html']);
	});
}

function fn_save_approver(serialized_data){
	/* get equivalent username from datalist */
	var data = {
		"action"	: "save_approver",
		"username"	: username
	}
	call_ajax_serialize(data,serialized_data,handler_configuration,function(result){
		//console.log(result);
		tbl_approver.draw();
		$('#frm_add_approver select,#frm_add_approver input').val("");
	});
}

