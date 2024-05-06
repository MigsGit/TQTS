<?php
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

$handler 	= '../handler/common_function.php';
if(file_exists($handler)){
	require_once($handler);
}else{
	echo 'handler not found!';
	exit;
}

$pkid 		= trim($_GET['id'],' ');
$file 		= return_file_path_by_div_mod('iqc_qar_reference');
$file_info  = get_file_name_and_rev_from_table('tbl_iqc_qar','reference_file_name','disposition_rev',$pkid);
echo json_encode($file_info);
$file	= $file['path'].$pkid.'/'.$file_info['reference_file_name'];

if(file_exists($file)) {
	$file_name 	= $file_info['reference_file_name'];
	header('Content-Description: File Transfer');
    header('Content-Type: application/octet-stream');
    header('Content-Disposition: attachment; filename="'.basename($file_name).'"');
    header('Expires: 0');
    header('Cache-Control: must-revalidate');
    header('Pragma: public');
    header('Content-Length: ' . filesize($file));
	ob_clean();
    readfile($file);
    exit;
}else {
	echo 'File not found!';
}
?>