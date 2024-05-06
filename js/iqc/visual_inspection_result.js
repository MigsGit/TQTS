/**
	*!Visual Inspection Result Functions - Start
*/
var tbl_iqc_visual 	    = 'tbl_iqc_visual';
var dt_iqc_visual	= '';
var table_view = '';
dt_iqc_visual = $('#'+tbl_iqc_visual).DataTable({
	"aaSorting"	 : [],	
	"bProcessing": true,
	"bServerSide": true,
	"sAjaxSource": "server_side_scripts/iqc/dt_visual.php",
	"rowCallback" : function( row, data, index ) {
	  if ( data[12] == "Accepted" ) {
	   $("td",row).css("background-color","lightgreen");
	  }
	  if ( data[12] == "Rejected" ) {
	   $("td",row).css("background-color","#ff8080");
	  }
	},
	"drawCallback": function( settings ) {
		$('#'+tbl_iqc_visual).attr('style','width:100%;');
	}
});

$(document).ready(function () {
	$('#btnSetWeeklyReport').click(function (e) { /* LOAD EXISTING WEEKS TABLE */
		e.preventDefault();
		loadTableWeek();
        $('#modal_week_table').modal('show');
		// ftable
	});
	$('#create_week').click(function (e) { 
		e.preventDefault();
		$('#modal_create_week #year').empty();
		$('#modal_create_week').modal('show');
		fn_empty_sa_fields('form_create_week');
		get_option_date('form_create_week','year');
	});
	$('#form_create_week').submit(function (e) { /* CREATE NEW WEEKS */
		e.preventDefault();
		createWeek(function () {
			loadTableWeek();	
		});
	});
	$('#edit_week').click(function (e) { //***** SHOW THE EDIT VALUE  *****
		e.preventDefault();
		$('#form_edit_week #month_edit').empty();
		$('#form_edit_week #year_edit').empty();
		get_option_date('form_edit_week','year_edit');
		get_option_month();
		if (table_view) {
			$('#form_edit_week #id_edit').val(table_view.id);
			$('#form_edit_week #year_edit').append(`<option value="${table_view.year}" selected disabled>--${table_view.year}--</option>`);
			$('#form_edit_week #month_edit').append(`<option value="${table_view.month}" selected disabled>--${table_view.month}--</option>`);
			$('#form_edit_week #w1s_edit').val(table_view.w1s);
			$('#form_edit_week #w1e_edit').val(table_view.w1e);
			$('#form_edit_week #w2s_edit').val(table_view.w2s);
			$('#form_edit_week #w2e_edit').val(table_view.w2e);
			$('#form_edit_week #w3s_edit').val(table_view.w3s);
			$('#form_edit_week #w3e_edit').val(table_view.w3e);
			$('#form_edit_week #w4s_edit').val(table_view.w4s);
			$('#form_edit_week #w4e_edit').val(table_view.w4e);
			$('#form_edit_week #w5s_edit').val(table_view.w5s);
			$('#form_edit_week #w5e_edit').val(table_view.w5e);
			$('#modal_edit_week').modal('show');
		} else {
			notif_info('Please select a row');
			return false;
		}
		
	});

// $('form_edit_week #btn btn-secondary').click(function (e) { 
// 	e.preventDefault();
	
// });
function get_option_date(form_id,option_id){
	for (i = new Date().getFullYear(); i > 2015; i--)
	{
		$('#'+form_id+ ' #'+option_id).append($('<option />').val(i).html(i));
	}
}
function get_option_month(){
	
	html ='<option value="January">January</option>';
	html +='<option value="February">February</option>';
	html +='<option value="March">March</option>';
	html +='<option value="April">April</option>';
	html +='<option value="May">May</option>';
	html +='<option value="June">June</option>';
	html +='<option value="July">July</option>';
	html +='<option value="August">August</option>';
	html +='<option value="September">September</option>';
	html +='<option value="October">October</option>';
	html +='<option value="November">November</option>';
	html +='<option value="December">December</option>';
	$('#form_edit_week #month_edit').append(html);
}
	

	$('#form_edit_week').submit(function (e) {  //***** SUBMIT THE UPDATED VALUE  *****
		e.preventDefault();
		$('#form_edit_week option:selected').attr('disabled',false);
		fEditWeek(function(){
		});
	});
	function fn_empty_sa_fields(frm_id){
		$('#'+frm_id+' input').val('');
	}
	$('#delete_week').click(function (e) { //***** SET THE WEEK INACTIVE  *****
		e.preventDefault();
		
        if(confirm("Confirm delete?")) {
			fDeleteWeek();
        }else {
            return false;
        }
	});
	$('#set_default_week').click(function (e) { //***** LOAD THE EXISTING MONTH AND YEAR TO MODAL  *****
		e.preventDefault();
		// ('set_default_week');

		fSetDefaultWeek(function(){
			// ('success_load_weeks');
		});
		// loadTableWeek();
	});
	$('#btn_default_week').click(function () { //***** CHANGE THE ACTIVE WEEKS FOR THE MONTH  *****
		fChangeDefaultWeek(function(){
			// ('success_change_default');
			loadTableWeek();
		});
    });
	$('#btnMonthlyReport').click(function (e) { //***** BUTTON FOR GENERATING REPORT  *****
		e.preventDefault();
		// ('Export');
		window.location.href = "./reports/iqc/excel_iqc_visual_inspection.php?";
	});
}); /** end document ready */

//===================ALL FUNCTIONS FOR GENERATING REPORT ====================
function createWeek(callback){
	let data = $.param({
		'action' : 'create_week',
		'username' : username
	})  + '&' +  $('#form_create_week').serialize();

	$.ajax({
		type: "POST",
		url: handler_view_week,
		// url: 'server_side_scripts/iqc/handler_view_week.php',
		data: data,
		dataType: "json",
		success: function (data) {
			callback();
			$('#modal_create_week').modal('hide');
			notif_success("Saved!");
		}
	});
}

loadTableWeek();
function loadTableWeek(){
		
	var data = $.param({
		'action' : 'load_table_week',
		
	});
	$.ajax({
		type: "POST",
		url: handler_view_week,
		// url: 'server_side_scripts/iqc/handler_view_week.php',
		data: data,
		dataType: "json",
		success: function (data) {
			let ctr = data['ctr'];
			$('#data_table').empty();

				let table_view = `  <table class="table table-striped table-hover table-bordered table-responsive" id="table_view" style="text-align:center">
				<thead>
					<tr>
						<th>Status</th>
						<th>Year</th>
						<th>Month</th>
						<th>W1 Start</th>
						<th>W1 End</th>
						<th>W2 Start</th>
						<th>W2 End</th>
						<th>W3 Start</th>
						<th>W3 End</th>
						<th>W4 Start</th>
						<th>W4 End</th>
						<th>W5 Start</th>
						<th>W5 End</th>
					</tr>
				</thead>

					<tbody></tbody>
				</table>`;
		$('#data_table').append(table_view);
		
			for (let i = 0; i < ctr; i++) {
				
					// var status = 'Active';
					if (data.status[i] == '1') {
						var status = `<span class="btn btn-success" style="padding: 0px; font-size:20px;">Active</span>`;

					} else {
						var status = `-`;
					}
					let body = `
					<tr id="${data.pkid[i]}">
					<td>${status}</td>
					<td>${data.year[i]}</td>
					<td>${data.month[i]}</td>
					<td>${data.w1s[i]}</td>
					<td>${data.w1e[i]}</td>
					<td>${data.w2s[i]}</td>
					<td>${data.w2e[i]}</td>
					<td>${data.w3s[i]}</td>
					<td>${data.w3e[i]}</td>
					<td>${data.w4s[i]}</td>
					<td>${data.w4e[i]}</td>
					<td>${data.w5s[i]}</td>
					<td>${data.w5e[i]}</td>
					</tr>`;

                $(`#table_view tbody`).append(body);
			}
			
            $('#table_view').DataTable({
                retrieve: true,
                destroy: true,
                'paging': true,
                'lengthChange': true,
                'searching': true,
                'ordering': true,
                'info': true,
                'autoWidth': true,
            });
			
            tableEditEvent();
		}
	});
}
function tableEditEvent(){
	$(`#table_view tbody`).on('click', 'tr', function () {
        $(`#table_view  tbody tr`).attr('style', '');
		$(this).attr('style', 'background:#6c757d; color:red;');
		console.log(this.id);
        table_view = '';
        table_view = {
            id: this.id,
            status: $(this).find("td:eq(0)").html(),
            year: $(this).find("td:eq(1)").html(),
            month: $(this).find("td:eq(2)").html(),
            w1s: $(this).find("td:eq(3)").html(),
            w1e: $(this).find("td:eq(4)").html(),
            w2s: $(this).find("td:eq(5)").html(),
            w2e: $(this).find("td:eq(6)").html(),
            w3s: $(this).find("td:eq(7)").html(),
            w3e: $(this).find("td:eq(8)").html(),
            w4s: $(this).find("td:eq(9)").html(),
            w4e: $(this).find("td:eq(10)").html(),
            w5s: $(this).find("td:eq(11)").html(),
            w5e: $(this).find("td:eq(12)").html()
        }
	
    });
}
function fEditWeek(callback){
	data= $.param({
		'action' : 'f_edit_week',
	
	}) + '&' + $('#form_edit_week').serialize();

	$.ajax({
		type: "POST",
		url: handler_view_week,
		// url: "server_side_scripts/iqc/handler_view_week.php",
		data: data,
		dataType: "json",
		success: function (data) {
			callback();
			// console.log('success_edit');
			loadTableWeek();
			$('#modal_edit_week').modal('hide');
			notif_success("Updated Successfully");
		}
	});
}

function fDeleteWeek(){
	data= $.param({
		'action' : 'f_delete_week',
		'pkid'  : table_view.id	
	});

	$.ajax({
		type: "POST",
		url: handler_view_week,
		// url: "server_side_scripts/iqc/handler_view_week.php",
		data: data,
		dataType: "json",
		success: function (data) {
			loadTableWeek();
			notif_info("Deleted Successfully");
		}
	});

}

function fSetDefaultWeek(callback){
	data= $.param({
		'action': 'load_report_list'
	});

	$.ajax({
		type: "POST",
		url: handler_view_week,
		// url: "server_side_scripts/iqc/handler_view_week.php",
		data: data,
		dataType: "json",
		success: function (data) {
			let ctr = data['ctr'];
			$('#default_week').empty();

			for (let i = 0; i < ctr; i++) {
				let content = `<option value="${data['pkid'][i]}">${data['month'][i]} - ${data['year'][i]}</option>`;
				$('#default_week').append(content);
			}
			if (ctr > 0){
				$('#modal_set_default_week').modal('show');
			}else{
				notif_info("Please Insert Date");
			}
			callback();
		}
	});

}

function fChangeDefaultWeek(callback){
		let default_week = $('#default_week').val();
        data = $.param({
            'action': 'change_default_week',
            'week_id': default_week
        });
		$.ajax({
			type: "POST",
			url: handler_view_week,
			// url: "server_side_scripts/iqc/handler_view_week.php",
			data: data,
			dataType: "json",
			success: function (data) {
                $('#modal_set_default_week').modal('hide');
				notif_info("Default Week Changed.");
				callback();
			}
		});

}
/**
 * !Toaster Notification
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
