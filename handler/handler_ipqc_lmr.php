<?php 
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

include('common_function.php');
function is_ajax() {
    return isset($_SERVER['HTTP_X_REQUESTED_WITH']) && strtolower($_SERVER['HTTP_X_REQUESTED_WITH']) == 'xmlhttprequest';
}

if(is_ajax()){
    if(isset($_POST["action"]) && !empty($_POST["action"])) {
        $action = $_POST["action"];
        switch ($action) {
            case 'save_lqc_monitoring'          : save_lqc_monitoring();  break;
            case 'read_info_lqc_monitoring'     : read_info_lqc_monitoring();  break;
            case 'update_lqc_monitoring'        : update_lqc_monitoring();  break;
            case 'remove_lqc_monitoring'        : remove_lqc_monitoring();  break;
        }
    }
}


function save_lqc_monitoring(){
    require_once('../class/oop_tqts.php');

    $return =  $_POST;
    $date_time_today = date('Y-m-d H:m:s');
    $username = $return['username'];
    $file_name = $_FILES['monitoring_file']['name'];
    $file_tmp = $_FILES['monitoring_file']['tmp_name'];

/** Value Condition */
    $machine_or_area = $return['radio_type'] ;
    $machine = ($machine_or_area=="Machine") ? $return['monitoring_no'] : '';
    $area = ($machine_or_area=="Area") ? $return['monitoring_no'] : '';
/** Insert Query */
    $table = 'tbl_ipqc_lqc_monitoring';
    $array_fields = array('created_by','machine_area','monitoring_type','machine_no','area','monitoring_year_month','monitoring_file',
                        'fkfile_path','remarks','checked_by','approved_by','username','created_at','updated_at');
/* add blanks to undefined or empty values */
    foreach($array_fields as $key => $value){
        if(!isset($return[$value]) || $return[$value] == ""){
            $return[$value] = "";
        }
    }
    $array_values = array($return['username'],$machine_or_area,$return['monitoring_type'],$machine,$area,$return['monitoring_year_month'],$file_name,
                        33,'',$return['checked_by'],$return['approved_by'],$username,$date_time_today,$date_time_today);

    $pkid = TQTS::getInstance()->insert_query_id($table,$array_fields,$array_values);
    
    $extension = pathinfo($file_name,PATHINFO_EXTENSION);
    $ext = ($extension == "XLSX")?"xlsx":$extension;
    $path_directory= return_file_path_by_div_mod('lqc_monitoring');

    $uploaded = move_uploaded_file($file_tmp,$path_directory['path'].$pkid.'.'.$ext);
    
    echo json_encode($return);
}

function read_info_lqc_monitoring(){
    // echo 'true';
    require_once('../class/oop_tqts.php');
    $return = $_POST;
    $pkid = $return['pkid'];
    $array_fields 	= array('*');
    $table      	= 'tbl_ipqc_lqc_monitoring';
    $joins      	= '';
    $sql_where  	= 'WHERE `pkid`="'.$pkid.'"';
    $sql_order  	= '';
    $sql_limit  	= 'LIMIT 0,1';
    $result = TQTS::getInstance()->select_query($array_fields,$table,$joins,$sql_where,$sql_order,$sql_limit);
    while($row = mysqli_fetch_array($result)){
        $return ['created_by'] = $row['created_by'];
        $return ['machine_area'] = $row['machine_area'];
        $return ['monitoring_type'] = $row['monitoring_type'];
        $return ['machine_no'] = $row['machine_no'];
        $return ['area'] = $row['area'];
        $return ['monitoring_year_month'] = $row['monitoring_year_month'];
        $return ['monitoring_file'] = $row['monitoring_file'];
        $checked_by[] = $row['checked_by'];
        $approved_by[] = $row['approved_by'];
    }
    foreach ($checked_by as $key => $value) {
        # code...
        $array_value =array();
        $array_value['id']=$value;
        $array_value['text']=get_emp_name_by_username_systemone($value);
        $return ['checked_by'][] = $array_value;
    }
    foreach ($approved_by as $key => $value) {
        # code...
        $array_value =array();
        $array_value['id']=$value;
        $array_value['text']=get_emp_name_by_username_systemone($value);
        $return ['approved_by'][] = $array_value;
    }
    echo json_encode($return);
}
function update_lqc_monitoring(){
    require_once('../class/oop_tqts.php');
    $date_time_today = date('Y-m-d H:m:s');

    $return                 = $_POST;
    $machine_area           = $return ['radio_type'];
    $monitoring_type        = $return ['monitoring_type'];
    $machine                = ($machine_area=="Machine")?$return ['monitoring_no']:'';
    $area                   = ($machine_area=="Area")?$return ['monitoring_no']:'';
    $current_file_name      = $return ['txt_selected_file'];
    $monitoring_year_month  = $return ['monitoring_year_month'];
    $checked_by             = $return ['checked_by'];
    $approved_by            = $return ['approved_by'];
    $file_name              = $_FILES ['monitoring_file']['name'];
    $file_name              = $file_name=='' ? $current_file_name: $file_name;
    $file_tmp               = $_FILES ['monitoring_file']['tmp_name'];
    $file                   = return_file_path_by_div_mod('lqc_monitoring');


    $table = 'tbl_ipqc_lqc_monitoring';
    $pkid                   = $return['pkid'];
    $array_fields = array('machine_area','monitoring_type','machine_no','area','monitoring_year_month','monitoring_file',
                    'checked_by','approved_by','updated_at');
    /* add blanks to undefined or empty values */
    foreach($array_fields as $key => $value){
        if(!isset($return[$value]) || $return[$value] == ""){
            $return[$value] = "";
        }
    }
    $array_values =array(
        $machine_area,$monitoring_type,$machine,$area,$monitoring_year_month,$file_name,$checked_by,$approved_by,$date_time_today
    );
    $result = TQTS::getInstance()->update_query($table,$array_fields,$array_values,$pkid);
    /** Check if the file existed, then deleted it into the folder */
    $current_file = $file['path'].$_POST['pkid'].'.xls' ;
    $current_file_x = $file['path'].$_POST['pkid'].'.xlsx';
    $current_files_y = $file['path'].$_POST['pkid'].'.XLSX';
    if(file_exists($current_file) ){
        $is_exist_files = $current_file;
    }else if(file_exists($current_file_x)){
        $is_exist_files = $current_file_x;
    }else{
        $is_exist_files = $current_files_y;
    }
    $is_exist_files;
    if(!isset($_FILES["monitoring_file"]["tmp_name"]) || $_FILES["monitoring_file"]["tmp_name"] == '') {
        $return['msg'] = 'Error : the file does not exist';
    }else{
        unlink($is_exist_files);
        $extension = pathinfo($file_name,PATHINFO_EXTENSION); 
        $ext = $extension=='XLSX'?'xlsx':$extension;
        $target_dir = $file['path'];
        $value = move_uploaded_file($file_tmp,$target_dir.$pkid.'.'.$ext);
        $return['msg'] = 'File uploaded successfully!';
    }
    
    echo json_encode($return);
}

function remove_lqc_monitoring(){
    require_once('../class/oop_tqts.php');

    $return                 = $_POST;

    $table = 'tbl_ipqc_lqc_monitoring';
    $pkid                   = $return['pkid'];
    $array_fields = array('remarks','logdel');
    $array_values =array($return['deleted_remarks'],1);
    $result = TQTS::getInstance()->update_query($table,$array_fields,$array_values,$pkid);

    echo json_encode($return);
}