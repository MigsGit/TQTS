<?php
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

$pkid 		= trim($_GET['id'],' ');
$file	 	= get_file_path_by_pkid($pkid);
$file_path 	= $file['file_path'];
// $extension 	= $file['extension'];
$file_name 	= $file['file_name'];

echo $file = $file_path;


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
}else{
	echo "<br>"."file does not exist";
}

function get_file_path_by_pkid($fkdetails) {
	require_once('../../class/oop_ptis.php');
	$array_fields = array('file_path','file_name');
	$table 	   	= 'tbl_uploads details ';
	$joins 	   	= '';
	$sql_where 	= 'WHERE fkid_pkid_ptisNo="'.$fkdetails.'" AND logdel=0';
	$sql_order 	= '';
	$sql_limit 	= 'LIMIT 0,1';
	$file 		= array();
	$result = PTIS::getInstance()->select_query($array_fields,$table,$joins,$sql_where,$sql_order,$sql_limit);
	if($row = mysqli_fetch_array($result)){
		$file['file_path'] = '../../../WebPTIS/pages/'.$row['file_path'];
		$file['file_name'] = '../../../WebPTIS/pages/'.$row['file_name'];
	}
	return $file;
}

?>