var dt_new_supplier = $('#tbl_supplier').DataTable({
	"processing": true,
	"serverSide": true,
	"ajaxSource": "server_side_scripts/configuration/supplier_main.php"
});

$('#btn_add_supplier').click(function(){
	fn_get_supplier('#frm_add_supplier select[name="fksupplier_group"]');
	$('#modal_add_supplier').modal('show');
});

$('#frm_add_supplier').submit(function(e){
	e.preventDefault();
	var serialized_data = $(this).serialize();
	fn_add_supplier(serialized_data);
});

$('#tbl_supplier tbody').on('click','tr .fa-edit', function(){
	var row				 = $(this);
	var pkid 			 = this.id;
	var supplier_group 	 = $(this).closest('tr').find('td:eq(1)').text();
	var fksupplier_group = $(this).closest('tr').find('td:eq(1) input').val();
	var supplier 		 = $(this).closest('tr').find('td:eq(2)').text();
	var to_recipient	 = $(this).closest('tr').find('td:eq(3)').text();
	var cc_recipient	 = $(this).closest('tr').find('td:eq(4)').text();
	var buttons 		 = '<button class="btn btn-primary fa fa-save mb-2" id="'+pkid+'"> Save Changes</button><br/><br/>';
		buttons   		+= '<button class="btn btn-danger fa fa-trash mb-2" id="'+pkid+'"> Delete</button><br/><br/>';
		buttons   		+= '<button class="btn btn-default fa fa-remove" id="'+pkid+'"> Cancel</button>';
	/* add select box */
	var html 			 = '';
		html 			 += '<select class="form-control" name="fksupplier_group" required>';
		html 			 += '</select>';
	$(this).closest('tr').find('td:eq(1)').html(html);
	fn_get_supplier( $(this).closest('tr').find('td:eq(1) select') );
	setSelectValue($(this).closest('tr').find('td:eq(1) select'),fksupplier_group);
	$(this).closest('tr').find('td:eq(1) select').val(fksupplier_group);
	/* add input type box */
		html 			 = '<input type="text" class="form-control" value="'+supplier+'" name="supplier" required>';
	$(this).closest('tr').find('td:eq(2)').html(html);
	/* add input type box */
		html 			 = '<textarea type="text" class="form-control" cols="150" rows="5" name="to_recipient">'+to_recipient+'</textarea>';
	$(this).closest('tr').find('td:eq(3)').html(html);
	/* add input type box */
		html 			 = '<textarea type="text" cols="300" rows="5" class="form-control" name="cc_recipient">'+cc_recipient+'</textarea>';
	$(this).closest('tr').find('td:eq(4)').html(html);
	$(this).closest('tr').find('td:eq(0)').html(buttons);
	
});

/* define events here since button will be removed on cancel */
$('#tbl_supplier tbody').on('click','tr .fa-save',function(){
	var data = {
		"action"			: "edit_supplier",
		"fksupplier_group"	: $(this).closest('tr').find('td:eq(1) select').val(),
		"supplier"			: $(this).closest('tr').find('td:eq(2) input').val(),
		"recipients_to"		: $(this).closest('tr').find('td:eq(3) textarea').val(),
		"recipients_cc"		: $(this).closest('tr').find('td:eq(4) textarea').val(),
		"username"			: username,
		"pkid"				: this.id
	}
	fn_edit_supplier(data);
});

$('#tbl_supplier tbody').on('click','tr .fa-trash',function(){
	$('#modal_delete_supplier').data('id',this.id);
	$('#modal_delete_supplier #delete_message').text('You are about to delete a supplier, Continue?');
	$('#modal_delete_supplier').modal('show');
});

$('#frm_delete_supplier').submit(function(e){
	e.preventDefault();
	var data = {
		"action"			: "delete_supplier",
		"username"			: username,
		"pkid"				: $('#modal_delete_supplier').data('id')
	}
	fn_delete_supplier(data);
});

$('#tbl_supplier tbody').on('click','tr .fa-remove',function(){
	dt_new_supplier.ajax.reload(null, false);
});
	
function fn_get_supplier(select_id){
	var data = {
		"action"	: "get_supplier"
	}
	call_ajax(data, handler_configuration, function(result){
		$(select_id).empty();
		$(select_id).append('<option value="">-Select Group-</option>');
		$(select_id).append(result['html']);
	});
}

function fn_add_supplier(serialized_data){
	$('.btn').attr('disabled',true);
	var data = {
		"action"   : "add_supplier",
		"username" : username
	}
	call_ajax_serialize(data, serialized_data, handler_configuration, function(result){
		//console.log(result);
		$('.btn').attr('disabled',false);
		empty_form_fields('frm_add_supplier');
		$('.modal').modal('hide');
		dt_new_supplier.draw();
	});
}

function fn_edit_supplier(data){
	console.log(data);
	call_ajax(data, handler_configuration, function(result){
		dt_new_supplier.ajax.reload(null, false);
	});
}
function fn_delete_supplier(data){
	call_ajax(data, handler_configuration, function(result){
		alert('result');
		$('#modal_delete_supplier').modal('hide');
		// dt_new_supplier.ajax.reload(null, false);
		dt_new_supplier.draw();
	});
}

function setSelectValue(select_id,value){
	setTimeout(function(){
		select_id.val(value);
	},20);
}