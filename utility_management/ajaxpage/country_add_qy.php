<?php
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}
require_once "../../classfile/initialize.php";
require_once "../../classfile/utility.php";
$ins_by=$_SESSION['user_id']; $ins_date=date('d-m-Y'); $ins_time=date('h:i:s A'); $ins_device='Web'; $entry_type='Admin'; $status=1;
$code=strtoupper($_POST['code']); $name=$_POST['name']; 
if($code !='' && $name !=''){
$rowcount=$utility_query->check_country_code_name($conn,$code,'code');
if($rowcount==0){
$rowcount1=$utility_query->check_country_code_name($conn,$name,'name');
if($rowcount1==0){
$result=$utility_query->insert_country_data($conn,$code,$name,$status,$ins_by,$ins_date,$entry_type,$ins_device,$ip);
echo "1";
}else  echo "3";
}else  echo "2";
}else  echo "0";
?>