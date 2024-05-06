<?php
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

$pkid 		= trim($_GET['id'],' ');
$fk_cor 	= trim($_GET['fk_cor'],' ');
$type 		= trim($_GET['type'],' ');
$user 		= trim($_GET['user'],' ').'_';
$order 		= trim($_GET['order'],' ');
$val 		= isset($_GET['val']) ? trim($_GET['val'],' ') : 0;
$file	 	= get_file_path_by_pkid($pkid, $fk_cor, $type, $user, $order, $val);
$file_path 	= $file['file_path'];
$extension 	= $file['extension'];
$file_name 	= $file['file_name'];

echo $file = $file_path . $pkid . '.' . $extension;


if (file_exists($file)) {
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

function get_file_path_by_pkid($fkdetails, $fk_cor, $type, $user, $order, $val) {
	require_once('../../class/oop_tqts.php');
	require_once('../../handler/handler_ts_qfr_capa.php');
	$sub_folder 	= return_monitoring_field($user, $order);
	$array_fields 	= $type == 'main' ? array('path.file_path','details.file_name') : array('path.file_path','details.'.$sub_folder.($val == 1 ? 'monitoring' : 'validation').'_attachment as file_name');
	$table 	   		= $type == 'main' ? 'tbl_qfr_capa_main details ' : ($val == 1 ? 'tbl_qfr_capa_1st_monitoring details' : ($val == '2' ? 'tbl_qfr_capa_2nd_validation_external details' : 'tbl_qfr_capa_3rd_validation_external details'));
	$joins 	   		= 'INNER JOIN tbl_file_path path ON path.pkid = details.fkfile_path';
	$sql_where 		= $type == 'main' ? 'WHERE details.pkid="'.$fkdetails.'" AND details.logdel=0' : 'WHERE details.fk_capa="'.$fkdetails.'" AND details.logdel=0 AND details.fk_capa_correction="'.$fk_cor.'"';
	$sql_order 		= '';
	$sql_limit 		= 'LIMIT 0,1';
	$file 			= array();
	$result = TQTS::getInstance()->select_query($array_fields,$table,$joins,$sql_where,$sql_order,$sql_limit);
	echo $script = TQTS::getInstance()->select_query_script($array_fields,$table,$joins,$sql_where,$sql_order,$sql_limit);
	if($row = mysqli_fetch_array($result)){
		if($type != 'main') {
			$file['file_path'] = '../'.$row['file_path'].$sub_folder.($val == 1 ? 'monitoring/' : 'validation/');
		} else {
			$file['file_path'] = '../'.$row['file_path'];
		}
		
		$file['extension'] = end(explode('.',$row['file_name']));
		$file['file_name'] = $row['file_name'];		
	}
	return $file;
}
?>