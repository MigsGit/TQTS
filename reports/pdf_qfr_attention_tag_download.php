<?php
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);
include('../class/excel_new.php');
include('../handler/common_function.php');


$pkid 		= trim($_GET['id'],' ');
$file_path = get_file_path_by_pkid($pkid);
$file= $file_path . '/' .$pkid. '/' .$pkid . '.pdf';
// $file_x=$file_path . '/' .$pkid. '/' .$pkid . '.pdf';

$file_name = 'Attention Tag.pdf';
if (file_exists($file)) {
    header('Content-Description: File Transfer');
    header('Content-Type: application/octet-stream');
    header("Content-Type: application/force-download");
    header('Content-Disposition: attachment; filename= "'.basename($file_name).'"');
    // header('Content-Transfer-Encoding: binary');
    header('Expires: 0');
    header('Cache-Control: must-revalidate, post-check=0, pre-check=0');
    header('Pragma: public');
    header('Content-Length: ' . filesize($file));
    ob_clean();
    flush();
    readfile($file);
    exit;
}

function get_file_path_by_pkid($pkid){
    require_once('../class/oop_tqts.php');
    $result = '';
    $array_fields = array('path.file_path');
	$table 	   	= 'tbl_qfr_attention_tag_attachment details ';
	$joins 	   	= 'INNER JOIN tbl_file_path path ON path.pkid = details.fkfile_path';
	$sql_where 	= 'WHERE details.pkid="'.$pkid.'" AND details.logdel=0';
	$sql_order 	= '';
	$sql_limit 	= 'LIMIT 0,1';
	$file 		= array();
    $result = TQTS::getInstance()->select_query($array_fields,$table,$joins,$sql_where,$sql_order,$sql_limit);
    if($row = mysqli_fetch_array($result)){
      $file['file_path'] = $row['file_path'];
    }
    return $file['file_path'];
}

?>