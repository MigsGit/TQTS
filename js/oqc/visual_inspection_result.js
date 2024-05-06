/* ***************************
	Visual Inspection Result Functions - Start
*************************** */

var tbl_iqc_visual 	    = 'tbl_iqc_visual';
var dt_iqc_visual	= '';

dt_iqc_visual = $('#'+tbl_iqc_visual).DataTable({
	"aaSorting"	 : [],	
	"bProcessing": true,
	"bServerSide": true,
	"sAjaxSource": "server_side_scripts/oqc/dt_visual.php",
	"rowCallback" : function( row, data, index ) {
	  if ( data[10] == "Accept" ) {
	   $("td",row).css("background-color","lightgreen");
	  }
	  if ( data[10] == "Reject" ) {
	   $("td",row).css("background-color","#ff8080");
	  }
	},
	"drawCallback": function( settings ) {
		$('#'+tbl_iqc_visual).attr('style','width:100%;');
	}
});
	
/* ***************************
	Visual Inspection Result Functions - End
*************************** */