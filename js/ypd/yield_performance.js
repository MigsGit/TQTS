/* ***************************
	Yield Performance Data Functions - Start
*************************** */

var tbl_ypd     = 'tbl_ypd';
var dt_ypd		= '';

dt_ypd = $('#'+tbl_ypd).DataTable({
	"aaSorting"	 : [],	
	"bProcessing": true,
	"bServerSide": true,
	"sAjaxSource": "server_side_scripts/ypd/dt_yield.php",
	"drawCallback": function( settings ) {
		$('#'+tbl_ypd).attr('style','width:100%;');
	}
});
	
/* ***************************
	Yield Performance Data Functions - End
*************************** */