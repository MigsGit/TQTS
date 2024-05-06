<?php
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

$pkid 		= trim($_GET['id'],' ');
$tbl_name 	= $_GET['tbl_name'];
$stat 		= $_GET['stat'];
$pkid_field = isset($_GET['f']) ? $_GET['f'] : 'pkid'; //short for "field"
$file_id	= $_GET['id'];

if($stat == 'multiple') {
	$pkid = explode('_', $pkid);
	$pkid = $pkid[1];
} 

$file	 	= get_file_path_by_pkid($tbl_name, $pkid, $pkid_field);
$file_path 	= $file['file_path'];
$extension 	= $file['extension'];
$file_name 	= $file['file_name'];

if($stat == 'final') {
	$file_id 	= $file['pkid'];
}

// echo $file = $file_path . $pkid . '.' . $extension; 
$file = $file_path . $file_id . '.' . $extension; 

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
} else {
	echo '<script>alert("File not found!!!");</script>';
}

function get_file_path_by_pkid($tbl_name, $fkdetails, $pkid_field) {
	require_once('../../class/oop_tqts.php');
	$array_fields = array('details.pkid','path.file_path','details.file_name');
	$table 	   	= $tbl_name .' details ';
	$joins 	   	= 'INNER JOIN tbl_file_path path ON path.pkid = details.fkfile_path';
	$sql_where 	= 'WHERE details.'.$pkid_field.'="'.$fkdetails.'" AND details.logdel=0';
	$sql_order 	= '';
	$sql_limit 	= 'LIMIT 0,1';
	$file 		= array();
	$result = TQTS::getInstance()->select_query($array_fields,$table,$joins,$sql_where,$sql_order,$sql_limit);
	// echo TQTS::getInstance()->select_query_script($array_fields,$table,$joins,$sql_where,$sql_order,$sql_limit);
	if($row = mysqli_fetch_array($result)){
		$file['file_path'] = '../'.$row['file_path'];
		$file['extension'] = end(explode('.',$row['file_name']));
		$file['file_name'] = $row['file_name'];		
		$file['pkid'] 	   = $row['pkid'];		
	}
	return $file;
}
?>