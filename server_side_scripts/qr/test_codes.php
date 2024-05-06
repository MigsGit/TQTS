<?php
$common_function = "../../handler/common_function.php";
if(!file_exists($common_function)){
	// exit;
}else{
	require_once($common_function);
}
$user_roles = get_user_roles('marlope');
echo json_encode($user_roles);
?>

