<?php
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}
require_once "../../classfile/initialize.php";
require_once "../../classfile/utility.php";
$ins_by=$_SESSION['user_id']; $ins_date=date('d-m-Y'); $ins_time=date('h:i:s A'); $ins_device='Web'; $entry_type='Admin'; $status=1;
$country=$_POST['country']; $name=$_POST['name']; 
if($country !='' && $name !=''){
$rowcount=$utility_query->check_state_name($conn,$country,$name);
if($rowcount==0){
$result=$utility_query->insert_state_data($conn,$country,$name,$status,$ins_by,$ins_date,$entry_type,$ins_device,$ip);
echo "1";
}else  echo "2";
}else  echo "0";
?>