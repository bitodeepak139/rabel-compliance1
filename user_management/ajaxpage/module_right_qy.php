<?php
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}
require_once "../../classfile/initialize.php";
require_once "../../classfile/user.php";
$ins_by=$_SESSION['user_id']; $ins_date=date('d-m-Y'); $ins_time=date('h:i:s A'); $ins_device='Web'; $entry_type='Admin'; $array=array(); $array1=array();
$user=$_POST['user']; $module=$_POST['module']; $rights=$_POST['rights']; $array =  explode(',', $module); $array1 =  explode(',', $rights);
if($user !=''){
$count=count($array);
for($i=1; $i<$count; $i++){ $module_id=$array[$i]; $status=$array1[$i]; 
$rowcount=$user_query->check_module_right($conn,$user,$module_id);
if($rowcount==0) $result=$user_query->insert_module_right($conn,$module_id,$user,$status,$ins_by,$ins_date,$entry_type,$ins_device,$ip);
else $result=$user_query->update_module_right($conn,$module_id,$user,$status,$ins_by,$ins_date,$entry_type,$ins_device,$ip);
}
echo "1";
}else  echo "0";
?>