<?php
if (session_status() === PHP_SESSION_NONE) {
    session_start();
} 
require_once "../../classfile/initialize.php";
require_once "../../classfile/utility.php"; 
$ins_by=$_SESSION['user_id']; $ins_date=date('d-m-Y'); $ins_time=date('h:i:s A'); $ins_device='Web'; $entry_type='Admin'; $status=1;
$editid=$_POST['id']; $name=$_POST['name']; $state=$_POST['state']; $hcode=$_POST['hcode']; $hname=$_POST['hname'];
if($name !='' && $state !=''){
if($hname != $name) $rowcount1=$utility_query->check_city_name($conn,$state,$name); else $rowcount1=0; 
if($rowcount1==0){
$result=$utility_query->update_city_data($conn,$editid,$state,$name,$ins_by,$ins_date,$entry_type,$ins_device,$ip);
echo "1";
}else echo "2";
}else echo "0";
?>