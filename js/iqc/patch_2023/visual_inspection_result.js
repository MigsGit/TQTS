/* ***************************
	Visual Inspection Result Functions - Start
*************************** */

var tbl_iqc_visual 	    = 'tbl_iqc_visual';
var dt_iqc_visual	= '';

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
	$('#' + tbl_iqc_visual + ' tbody').on('click','tr .clickExport',function(){ //NOTE: MIGZ EXPORT
		var pkid 	= $(this).attr("id");	
		console.log(pkid); //NOTE: EXPORT
	window.location.href = "./reports/iqc/excel_iqc_visual_inspection.php?id="+pkid;
	// window.location.href = "./reports/oqc/excel_oqc_lon - Chopy.php?id="+pkid;
	// \\rapid_test\www\TQTS_TS\reports\iqc\qar\excel_iqc_visual_inspection.php


		
	});
});
	
/* ***************************
	Visual Inspection Result Functions - End
*************************** */