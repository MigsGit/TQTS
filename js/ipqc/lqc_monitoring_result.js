/**
* ! ****FUNCTION LIST****
* fn_remove_lqc_monitoring
* fn_update_lqc_monitoring
* fn_get_info_lqc_monitoring
* fn_save_lqc_monitoring
* fn_monitoring_type
* $('#add_lqc_monitoring').click
* ! ****BUTTON LIST****
* $('#'+form_remove_lqc_monitoring).submit
* $('#'+form_update_lqc_monitoring).submit
* $('#'+form_lqc_monitoring).submit
* $('#'+form_update_lqc_monitoring+' #btn_selected_file').click
* $('#'+form_update_lqc_monitoring+ ' input[name="radio_type"]').click
* $('#'+form_lqc_monitoring+ ' input[name="radio_type"]').click
* $('#add_lqc_monitoring').click
* $('#'+tbl_lqc_monitoring).on( 'click','tr a#a_download', function ()
* $('#'+tbl_lqc_monitoring).on( 'click','tr .fa-remove', function ()
* $('#'+tbl_lqc_monitoring).on( 'click','tr .fa-eye', function ()
 */

var modal_lqc_monitoring = 'modal_lqc_monitoring';
var modal_update_lqc_monitoring = 'modal_update_lqc_monitoring';
var modal_remove_lqc_monitoring ='modal_remove_lqc_monitoring';
var form_remove_lqc_monitoring = 'form_remove_lqc_monitoring';
var form_update_lqc_monitoring = 'form_update_lqc_monitoring';
var form_lqc_monitoring = 'form_lqc_monitoring';
var tbl_lqc_monitoring = 'tbl_lqc_monitoring';



$(document).ready(function () {
    $.ajaxSetup({
        type: "POST",
        url: handler_ipqc_lmr,
        dataType: "json",
    });
    var dt_lqc_monitoring = $('#tbl_lqc_monitoring').DataTable({
        // sorting	: [],
        // processing: true,
        // serverSide: true,
        // ajax: "server_side_scripts/ipqc/dt_lqc_monitoring.php?username="+username,
        // "drawCallback": function( settings ) {
        //     $('#tbl_special_acceptance').attr('style','width:100%;');
        // }
        "aaSorting"	: [],
		"bProcessing": true,
        "bServerSide": true,
		"sAjaxSource": "server_side_scripts/ipqc/dt_lqc_monitoring.php?username="+username,
		"drawCallback": function( settings ) {
			$('#tbl_lqc_monitoring').attr('style','width:100%;');
		}
    });
    $('#'+tbl_lqc_monitoring).on( 'click','tr .fa-eye', function () {
        var pkid = $(this).data('id');
        $('#'+modal_update_lqc_monitoring).modal('show');
        $('#'+form_update_lqc_monitoring+ ' select[name="monitoring_type"]').empty();
        $('#'+form_update_lqc_monitoring+ ' input[name="monitoring_file"]').val('');
        $('#'+form_update_lqc_monitoring+ ' #monitoring_file').hide();
        $('#'+form_update_lqc_monitoring+ ' #btn_selected_file').show();
        $('#'+form_update_lqc_monitoring+ ' #checkbox_file').prop('checked',false);
        fn_get_info_lqc_monitoring(pkid);
    });
    $('#'+tbl_lqc_monitoring).on( 'click','tr .fa-remove', function () {
        var pkid = $(this).data('id');
        $('#'+modal_remove_lqc_monitoring).modal('show');
        fn_get_info_lqc_monitoring(pkid);
    });
    $('#'+tbl_lqc_monitoring).on( 'click','tr a#a_download', function () {
        var pkid = $(this).data('id');
        window.location.href="./reports/ipqc/excel_ipqc_lqc_monitoring_download.php?id="+pkid;
    });
    $('#add_lqc_monitoring').click(function (e) { 
        e.preventDefault();
        // console.log('hello world');
        $('#'+modal_lqc_monitoring).modal('show');
		// re_initialize_select2_server_side('#modal_lqc_monitoring #cmb_checked_by','#modal_lqc_monitoring #form_lqc_monitoring',[],"server_side_scripts/dropdown/common/dd_hris_above_ss_list.php");
		// re_initialize_select2_server_side('#modal_lqc_monitoring #cmb_approved_by','#modal_lqc_monitoring #form_lqc_monitoring',[],"server_side_scripts/dropdown/common/dd_hris_above_ss_list.php");
        re_initialize_select2_server_side('#modal_lqc_monitoring #cmb_checked_by','#modal_lqc_monitoring #form_lqc_monitoring',[],"server_side_scripts/dropdown/common/dd_rapid_hris_and_subcon_list.php");
		re_initialize_select2_server_side('#modal_lqc_monitoring #cmb_approved_by','#modal_lqc_monitoring #form_lqc_monitoring',[],"server_side_scripts/dropdown/common/dd_rapid_hris_and_subcon_list.php");

        fn_empty_lqc_fields('form_lqc_monitoring');
    });
    
    
    $('#'+form_lqc_monitoring+ ' input[name="radio_type"]').click(function () { 
        var checked_value = $(this).val();
        $('#'+form_lqc_monitoring+ ' select[name="monitoring_type"]').empty();
        if(checked_value == 'Machine'){
            fn_monitoring_type(checked_value,form_lqc_monitoring,'monitoring_type');
        }else if(checked_value == 'Area'){
            fn_monitoring_type(checked_value,form_lqc_monitoring,'monitoring_type');

        }
    });
    $('#'+form_update_lqc_monitoring+ ' input[name="radio_type"]').click(function () { 
        var checked_value = $(this).val();
        $('#'+form_update_lqc_monitoring+ ' select[name="monitoring_type"]').empty();
        if(checked_value == 'Machine'){
            fn_monitoring_type(checked_value,form_update_lqc_monitoring,'monitoring_type');
        }else if(checked_value == 'Area'){
            fn_monitoring_type(checked_value,form_update_lqc_monitoring,'monitoring_type');
        }
    });
    $('#'+form_update_lqc_monitoring+' #btn_selected_file').click(function(){
		var pkid = $(this).val();
        window.location.href='reports/excel_ipqc_lqc_monitoring_download.php?id='+pkid;
	});
    $('#'+form_update_lqc_monitoring+' #checkbox_file').click(function(){
		if($(this).prop('checked')){
            $('#'+form_update_lqc_monitoring+' #monitoring_file').show();
            $('#'+form_update_lqc_monitoring+' #btn_selected_file').hide();
        }else{
            $('#'+form_update_lqc_monitoring+' #monitoring_file').hide();
            $('#'+form_update_lqc_monitoring+' #btn_selected_file').show();
        }
	});
    
    $('#'+form_lqc_monitoring).submit(function (e) { 
        e.preventDefault();
            var serialized_data = new FormData(this);
        if(fn_validate_checked_by(form_lqc_monitoring,'cmb_checked_by')){
            if(fn_validate_approved_by(form_lqc_monitoring,'cmb_approved_by')){
                serialized_data.append('action','save_lqc_monitoring');
                serialized_data.append('username',username);
                fn_save_lqc_monitoring(serialized_data);
            }   
        }
    });
    $('#'+form_update_lqc_monitoring).submit(function (e) { 
        e.preventDefault();
        $('#'+form_update_lqc_monitoring+ ' option:selected').attr('disabled',false);
        var serialized_data = new FormData(this);
        if(fn_validate_checked_by(form_update_lqc_monitoring,'cmb_checked_by')){
            if(fn_validate_approved_by(form_update_lqc_monitoring,'cmb_approved_by')){
                serialized_data.append('action','update_lqc_monitoring');
                fn_update_lqc_monitoring(serialized_data);
            }
        }
    });
    $('#'+form_remove_lqc_monitoring).submit(function (e) { 
        e.preventDefault();
        var serialized_data = new FormData(this);
        serialized_data.append('action','remove_lqc_monitoring');
        fn_remove_lqc_monitoring(serialized_data);
    });

    function fn_monitoring_type(type,form_id,select_id){
        if(type == "Machine"){
            html = '<option value="" selected disabled>-Select Monitoring Type-</option>';
            html += '<option value="Oven">Oven</option>';
            html += '<option value="Chiller">Chiller</option>';
            $('#'+form_id+ ' select[name="'+select_id+'"]').append(html);
        }else{
            html = '<option value="" selected disabled>-Select Monitoring Type-</option>';
            html += '<option value="RT/RH">RT/RH</option>';
            html += '<option value="Dust Count">Dust Count</option>';
            html += '<option value="5s">5s</option>';
            html += '<option value="Clean Room">Clean Room</option>';
            $('#'+form_id+ ' select[name="'+select_id+'"]').append(html);
        }
    }
    function fn_save_lqc_monitoring(serialized_data){
        $.ajax({
            data	: serialized_data, 			// Data sent to server, a set of key/value pairs (i.e. form fields and values)
			contentType: false,       		// The content type used when sending data to the server.
			cache: false,             		// To unable request pages to be cached
			processData:false,        		// To send DOMDocument or non processed data file it is set to false
            success: function (response) {
                notif_success('Saved Sucessfully');
                $('#'+modal_lqc_monitoring).modal('hide');
                dt_lqc_monitoring.draw();
            }
        });
    }
    function fn_get_info_lqc_monitoring(pkid){
        data = {
            'action': 'read_info_lqc_monitoring',
            'pkid'  : pkid  };
        data = $.param(data);
        $.ajax({
            data: data,
            success: function (response) {
                
                var machine_area= response['machine_area'];
                var monitoring_type= response['monitoring_type'];
                if(machine_area=="Machine"){
                    $('#'+form_update_lqc_monitoring+ ' input#machine').prop('checked',true);
                    $('#'+form_update_lqc_monitoring+ ' input[name="monitoring_no"]').val(response['machine_no']);
                    html ='<option value="'+monitoring_type+'" selected disabled>--'+monitoring_type+'--</option>';
                    html +='<option value="Oven">Oven</option>';
                    html +='<option value="Chiller">Chiller</option>';
                    $('#'+form_update_lqc_monitoring+ ' select[name="monitoring_type"]').append(html);
                }else{
                    $('#'+form_update_lqc_monitoring+ ' input#area').prop('checked',true);
                    $('#'+form_update_lqc_monitoring+ ' input[name="monitoring_no"]').val(response['area']);
                    html ='<option value="'+monitoring_type+'" selected disabled> --'+monitoring_type+'-- </option>';
                    html +='<option value="RT/RH">RT/RH</option>';
                    html +='<option value="Dust Count">Dust Count</option>';
                    html +='<option value="5s">5s</option>';
                    html += '<option value="Clean Room">Clean Room</option>';
                    $('#'+form_update_lqc_monitoring+ ' select[name="monitoring_type"]').append(html);
                }
                $('#'+form_update_lqc_monitoring+ ' input[name="pkid"]').val(response['pkid']);
                $('#'+form_update_lqc_monitoring+ ' a#btn_selected_file').val(response['pkid']);
                $('#'+form_update_lqc_monitoring+ ' input[name="monitoring_year_month"]').val(response['monitoring_year_month']);
                $('#'+form_update_lqc_monitoring+ ' input[name="txt_selected_file"]').val(response['monitoring_file']);
				assign_value_select2('#form_update_lqc_monitoring #cmb_checked_by',response['checked_by']);
				assign_value_select2('#form_update_lqc_monitoring #cmb_approved_by',response['approved_by']);
				// re_initialize_select2_server_side('#modal_update_lqc_monitoring #cmb_checked_by','#modal_update_lqc_monitoring #form_update_lqc_monitoring',[],"server_side_scripts/dropdown/common/dd_hris_above_ss_list.php");
				// re_initialize_select2_server_side('#modal_update_lqc_monitoring #cmb_approved_by','#modal_update_lqc_monitoring #form_update_lqc_monitoring',[],"server_side_scripts/dropdown/common/dd_hris_above_ss_list.php");
                re_initialize_select2_server_side('#modal_update_lqc_monitoring #cmb_checked_by','#modal_update_lqc_monitoring #form_update_lqc_monitoring',[],"server_side_scripts/dropdown/common/dd_hris_above_ss_list.php");
                re_initialize_select2_server_side('#modal_update_lqc_monitoring #cmb_approved_by','#modal_update_lqc_monitoring #form_update_lqc_monitoring',[],"server_side_scripts/dropdown/common/dd_hris_above_ss_list.php");
        

                $('#'+form_remove_lqc_monitoring+ ' input[name="pkid"]').val(response['pkid']);

            
            }
        });
    }
    function fn_update_lqc_monitoring(serialized_data){
        $.ajax({
            data	: serialized_data, 			// Data sent to server, a set of key/value pairs (i.e. form fields and values)
			contentType: false,       		// The content type used when sending data to the server.
			cache: false,             		// To unable request pages to be cached
			processData:false,        		// To send DOMDocument or non processed data file it is set to false
            success: function (response) {
                notif_success('Updated Sucessfully');
                $('#'+modal_update_lqc_monitoring).modal('hide');
                dt_lqc_monitoring.draw();
            }
        });
    }
    function fn_remove_lqc_monitoring(serialized_data){
        $.ajax({
            data	: serialized_data, 			// Data sent to server, a set of key/value pairs (i.e. form fields and values)
			contentType: false,       		// The content type used when sending data to the server.
			cache: false,             		// To unable request pages to be cached
			processData:false,        		// To send DOMDocument or non processed data file it is set to false
            success: function (response) {
                notif_success('Deleted Sucessfully');
                $('#'+modal_remove_lqc_monitoring).modal('hide');
                dt_lqc_monitoring.draw();
            }
        });
    }

    
}); /** End DocReady */


// list of button and functions

/** **********                           *********** */ 
/** ********** Internal Common Function *********** */ 
/** **********                           *********** */ 
/**
 * fn_empty_lqc_fields
 * fn_validate_checked_by
 * fn_validate_approved_by
 */

/** 
 * TODO: Empty Values
*/ 
function fn_empty_lqc_fields(form_id){
    $('#'+form_id+ ' select').val('');
    $('#'+form_id+' select#cmb_approved_by').empty();
    $('#'+form_id+' select#cmb_checked_by').empty();
    $('#'+form_id+ ' input[type="text"]').val('');
    $('#'+form_id+ ' input[type="file"]').val('');
    $('#'+form_id+ ' input[type="month"]').val('');
    $('#'+form_id+ ' input[name="radio_type"]').prop('checked',false);
}
/** 
 * TODO: validation for approver and checked by
*/ 
function fn_validate_checked_by(form_id,checked_id){
    if($('#'+form_id+' #'+checked_id +' option:selected').length > 1) {
        notif_warning('Please Select 1 Checker only');
        return false;
    }else{
        return true;
    }
}
function fn_validate_approved_by(form_id,approved_id){
    console.log;
    if($('#'+form_id+' #'+approved_id +' option:selected').length > 1) {
        notif_warning('Please Select 1 Approver only');
        return false;
    }else{
        return true;
    }
}
/**
 * TODO: Toaster Notification
 */
function notif_success(data) {
    notif({
        type: "success",
        msg: "<b>Success:</b> " + data,
        type: "success",
        position: "right",
        timeout: 3000
    });
}

function notif_warning(data) {
    notif({
        type: "warning",
        msg: "<b>Warning:</b> " + data,
        position: "right",
        timeout: 3000
    });
}

function notif_info(data) {
    notif({
        type: "info",
        msg: "<b>Info:</b> " + data,
        position: "right",
        timeout: 3000
    });
}

function notif_err(data) {
    notif({
        type: "error",
        msg: "<b>Error:</b> " + data,
        position: "right",
        timeout: 3000
    });
}

