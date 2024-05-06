<?php
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

$pkid 		= trim($_GET['id'],' ');
$file	 	= get_file_path_by_pkid($pkid);
$file_path 	= $file['file_path'];
$extension 	= $file['extension'];
$file_name 	= $file['file_name'];

echo $file = $file_path . $pkid . '.' . $extension; 


if (file_exists($file)) {
	// flush();
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
}

function get_file_path_by_pkid($fkdetails) {
	require_once('../../class/oop_tqts.php');
	$array_fields = array('path.file_path','details.inspection_file');
	$table 	   	= 'tbl_ipqc_dimension_inspection details ';
	$joins 	   	= 'INNER JOIN tbl_file_path path ON path.pkid = details.fkfile_path';
	$sql_where 	= 'WHERE details.pkid="'.$fkdetails.'" AND details.logdel=0';
	$sql_order 	= '';
	$sql_limit 	= 'LIMIT 0,1';
	$file 		= array();
	$result = TQTS::getInstance()->select_query($array_fields,$table,$joins,$sql_where,$sql_order,$sql_limit);
	// echo TQTS::getInstance()->select_query_script($array_fields,$table,$joins,$sql_where,$sql_order,$sql_limit);
	if($row = mysqli_fetch_array($result)){
		$file['file_path'] = '../'.$row['file_path'];
		$file['extension'] = end(explode('.',$row['inspection_file']));
		$file['file_name'] = $row['inspection_file'];		
	}
	return $file;
}
?>