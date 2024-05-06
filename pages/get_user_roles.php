<?php
$oop = 'class/oop_user_roles.php';
if(!file_exists($oop)){
	if(file_exists('../../'.$oop)) {
		require_once('../../'.$oop);
	} else {
		echo '<br><br><br>
				<h1><center>OOP does not exist!!!</center>
			  </h1>';
		exit;
	}
}else{
	require_once($oop);
}

$username = $_SESSION['username'];
$array_fields 	= array('`subsystem`.`subsystem_code`','`module`.`module`','`subsystem`.`pkid`','`roles`.*');
$table 			= 'tbl_user_roles `roles`';
$joins			= 'INNER JOIN `tbl_module` `module` ON `module`.`pkid` = `roles`.`fk_module`
				   INNER JOIN `tbl_subsystem` `subsystem` ON `module`.`fk_subsystem` = `subsystem`.`pkid`';
$sql_where		= "WHERE `roles`.`user` = '$username' AND `roles`.`logdel` = '0' AND `module`.`logdel`= '0' "; /** Show only the module that is active / logdel = 0  */
$sql_order		= '';
$sql_limit		= '';
$result = ROLES::getInstance()->select_query($array_fields,$table,$joins,$sql_where,$sql_order,$sql_limit);
$script = ROLES::getInstance()->select_query_script($array_fields,$table,$joins,$sql_where,$sql_order,$sql_limit);
$user_role = array(
	"pkid"			=> array(),
	"subsystem_code"=> array(),
	"fk_module"		=> array(),
	"module"		=> array(),
	"user"			=> array(),
	"section"		=> array(),
	"role"			=> array(),
	"create"		=> array(),
	"read"			=> array(),
	"update"		=> array(),
	"delete"		=> array()
);
while($row = mysqli_fetch_array($result)){
	$user_role['pkid'][] 			= $row['pkid'];
	$user_role['subsystem_code'][] 	= $row['subsystem_code'];
	$user_role['fk_module'][] 		= $row['fk_module'];
	$user_role['module'][] 			= $row['module'];
	$user_role['user'][] 			= $row['user'];
	$user_role['section'][] 		= $row['section'];
	$user_role['role'][] 			= $row['role'];
	$user_role['create'][] 			= $row['create'];
	$user_role['read'][] 			= $row['read'];
	$user_role['update'][] 			= $row['update'];
	$user_role['delete'][] 			= $row['delete'];
}
// print_r($user_role);
// echo $script;
// echo json_encode($user_role);
// exit;
?>