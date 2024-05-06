<?php
session_start();
$page = './pages/get_user_roles.php';
require_once('../../'.$page);
/* get user role for QS Inspector */
$capa_qs_inspector_access 	    = array("create" => false, 
									"read" => false,
									"update" => false,
									"delete" => false
									);
$subsystem_code 			= "QFR";
$module 					= "CAPA-QS Inspector";
foreach($user_role['subsystem_code'] as $key => $subsystem_code2 ){
	if($subsystem_code == $subsystem_code2 && $user_role['module'][$key] == $module){ 
		if ($user_role['create'][$key] == 1){
			$capa_qs_inspector_access['create'] = true;
		}
		if ($user_role['read'][$key] == 1){
			$capa_qs_inspector_access['read'] = true;
		}
		if ($user_role['update'][$key] == 1){
			$capa_qs_inspector_access['update'] = true;
		}
		if ($user_role['delete'][$key] == 1){
			$capa_qs_inspector_access['delete'] = true;
		}
		// echo $user_role['create'][$key].'<br>';
	}
}
// echo $capa_qs_inspector_access['create'].'rona';
/* get user role for QS Supervisor */
$capa_ope_qs_sup_access 	    = array("create" => false, 
									"read" => false,
									"update" => false,
									"delete" => false
									);
$subsystem_code 			= "QFR";
$module 					= "CAPA-Operations QS Supervisor";
foreach($user_role['subsystem_code'] as $key => $subsystem_code2 ){
	if($subsystem_code == $subsystem_code2 && $user_role['module'][$key] == $module){ 
		if ($user_role['create'][$key] == 1){
			$capa_ope_qs_sup_access['create'] = true;
		}
		if ($user_role['read'][$key] == 1){
			$capa_ope_qs_sup_access['read'] = true;
		}
		if ($user_role['update'][$key] == 1){
			$capa_ope_qs_sup_access['update'] = true;
		}
		if ($user_role['delete'][$key] == 1){
			$capa_ope_qs_sup_access['delete'] = true;
		}
	}
}
/* get user role for QS Conformance */
$capa_ope_qs_conf_access 	    = array("create" => false, 
									"read" => false,
									"update" => false,
									"delete" => false
									);
$subsystem_code 			= "QFR";
$module 					= "CAPA-Operations QS Conformance";
foreach($user_role['subsystem_code'] as $key => $subsystem_code2 ){
	if($subsystem_code == $subsystem_code2 && $user_role['module'][$key] == $module){ 
		if ($user_role['create'][$key] == 1){
			$capa_ope_qs_conf_access['create'] = true;
		}
		if ($user_role['read'][$key] == 1){
			$capa_ope_qs_conf_access['read'] = true;
		}
		if ($user_role['update'][$key] == 1){
			$capa_ope_qs_conf_access['update'] = true;
		}
		if ($user_role['delete'][$key] == 1){
			$capa_ope_qs_conf_access['delete'] = true;
		}
	}
}
/* get user role for Operations QE and QAD QE */
$capa_ope_qe_qad_access 	    = array("create" => false, 
									"read" => false,
									"update" => false,
									"delete" => false
									);
$subsystem_code 			= "QFR";
$module 					= "CAPA-Operations QE and QAD QE";
foreach($user_role['subsystem_code'] as $key => $subsystem_code2 ){
	if($subsystem_code == $subsystem_code2 && $user_role['module'][$key] == $module){ 
		if ($user_role['create'][$key] == 1){
			$capa_ope_qe_qad_access['create'] = true;
		}
		if ($user_role['read'][$key] == 1){
			$capa_ope_qe_qad_access['read'] = true;
		}
		if ($user_role['update'][$key] == 1){
			$capa_ope_qe_qad_access['update'] = true;
		}
		if ($user_role['delete'][$key] == 1){
			$capa_ope_qe_qad_access['delete'] = true;
		}
	}
}
/* get user role for QC and QAD AM-up (Checked by) */
$capa_qc_qad_am_up 	    = array("create" => false, 
									"read" => false,
									"update" => false,
									"delete" => false
									);
$subsystem_code 			= "QFR";
$module 					= "CAPA-QC and QAD AM-up";
foreach($user_role['subsystem_code'] as $key => $subsystem_code2 ){
	if($subsystem_code == $subsystem_code2 && $user_role['module'][$key] == $module){ 
		if ($user_role['create'][$key] == 1){
			$capa_qc_qad_am_up['create'] = true;
		}
		if ($user_role['read'][$key] == 1){
			$capa_qc_qad_am_up['read'] = true;
		}
		if ($user_role['update'][$key] == 1){
			$capa_qc_qad_am_up['update'] = true;
		}
		if ($user_role['delete'][$key] == 1){
			$capa_qc_qad_am_up['delete'] = true;
		}
	}
}

/* get user role for QAD (final) */
$capa_qad_access 	    = array("create" => false, 
									"read" => false,
									"update" => false,
									"delete" => false
									);
$subsystem_code 			= "QFR";
$module 					= "CAPA-QAD";
foreach($user_role['subsystem_code'] as $key => $subsystem_code2 ){
	if($subsystem_code == $subsystem_code2 && $user_role['module'][$key] == $module){ 
		if ($user_role['create'][$key] == 1){
			$capa_qad_access['create'] = true;
		}
		if ($user_role['read'][$key] == 1){
			$capa_qad_access['read'] = true;
		}
		if ($user_role['update'][$key] == 1){
			$capa_qad_access['update'] = true;
		}
		if ($user_role['delete'][$key] == 1){
			$capa_qad_access['delete'] = true;
		}
	}
}
?>