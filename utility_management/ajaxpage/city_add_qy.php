<?php
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}
require_once "../../classfile/initialize.php";
require_once "../../classfile/utility.php";
$ins_by=$_SESSION['user_id']; $ins_date=date('d-m-Y'); $ins_time=date('h:i:s A'); $ins_device='Web'; $entry_type='Admin'; $status=1;
$country=$_POST['country']; $name=$_POST['name']; $state=$_POST['state']; 
if($country !='' && $name !='' && $state !=''){
$rowcount=$utility_query->check_city_name($conn,$state,$name);
if($rowcount==0){
$result=$utility_query->insert_city_data($conn,$country,$state,$name,$status,$ins_by,$ins_date,$entry_type,$ins_device,$ip);
echo "1";
}else  echo "2";
}else  echo "0";
?>