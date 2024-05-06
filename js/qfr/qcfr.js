var tbl_qcfr 					= 'tbl_qcfr';

dt_qcfr_lqc_ins = $('#'+tbl_qcfr).DataTable({
	"aaSorting"	 : [],
	"bProcessing": true,
	"bServerSide": true,
	"sAjaxSource": "server_side_scripts/qr/dt_qcfr.php?username="+username,
	"drawCallback": function( settings ) {
		$('#'+tbl_qcfr).attr('style','width:100%;');
	}
});
