$('#tbl_user_main').DataTable({
	"aaSorting"	 : [],	
	"sAjaxSource": "server_side_scripts/configuration/user_roles_main.php?fk_system=65&fk_module=113"
	// "sAjaxSource": "server_side_scripts/configuration/user_roles_main.php?fk_system=65"
	// "sAjaxSource": "server_side_scripts/configuration/user_roles_main.php?fk_system=20"
});

var tbl_user_role = $('#tbl_user_role').DataTable();

$('#tbl_user_main tbody').on('click', 'tr .btn-primary', function(){
	var user = this.value;
	fn_get_current_user_role(user);
	$('#modal_edit_user_roles').data('user',user);
	$('#modal_edit_user_roles').modal('show');
	
});

$('#frm_edit_user_roles').submit(function(e){
	e.preventDefault();
	var serialized_data = $(this).serialize();
	var user = $('#modal_edit_user_roles').data('user');
	fn_save_edit_user_role(serialized_data,user);
});

function fn_get_current_user_role(user){
	var data = {
		"action"	: "get_current_user_role",
		"user"		: user
	}
	tbl_user_role.destroy();
	$('#tbl_user_role tbody').empty();
	$('#tbl_user_role tbody').append('<tr><td colspan="7"><h3><center><img src="images/loader.gif"><br>Fetching Data... Please Wait...</center></h3></td></tr>');
	call_ajax(data, handler_configuration, function(result){
		//console.log(result);
		$('#tbl_user_role tbody').empty();
		$('#tbl_user_role tbody').append(result['html']);
		tbl_user_role = $('#tbl_user_role').DataTable();
	});
}

function fn_get_user_roles_section(user){
	var data = {
		"action"	: "get_user_roles_section"
	}
	call_ajax(data, handler_configuration, function(result){
		//console.log(result);
	});
}

function fn_get_user_roles_role(){
	var data = {
		"action"	: "get_user_roles_role"
	}
	call_ajax(data, handler_configuration, function(result){
		//console.log(result);
	});
}

function fn_save_edit_user_role(serialized_data,user){
	var data = {
		"action"	: "save_edit_user_role",
		"user"		: user,
		"username"	: username
	}
	call_ajax_serialize(data, serialized_data, handler_configuration, function(result){
		console.log(result);
		$('.modal').modal('hide');
	});
}