<?php
/* you may use any file from pages as your homepage */
if( isset($_GET['page']) ){
	$page = $_GET['page'];
	/* changes here must also be applied in handler fn_get_page() */
	switch($page){
		case "dashboard" 	: $page_link = 'pages/dashboard/index.php'; break;
		case "iqc" 			: $page_link = 'pages/iqc/index.php'; break;
		case "ipqc"			: $page_link = 'pages/ipqc/index.php'; break;
		case "oqc"			: $page_link = 'pages/oqc/index.php'; break;
		case "qfr" 			: $page_link = 'pages/qfr/index.php'; break;
		case "etr" 			: $page_link = 'pages/etr/index.php'; break;
		case "ypd" 			: $page_link = 'pages/ypd/index.php'; break;
		case "ccte" 		: $page_link = 'pages/ccte/index.php'; break;
		case "configuration": $page_link = 'pages/configuration/index.php'; break;
		default 			: $page_link = 'pages/redirect_page/index.php';
	}
	$selected_menu = $page;
	include($page_link);
}else{
	$page_link 		= 'pages/dashboard/index.php';
	$selected_menu 	= 'dashboard';
	include($page_link);
}

// echo 'test';
?>
