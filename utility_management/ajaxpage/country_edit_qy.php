<?php
if (session_status() === PHP_SESSION_NONE) {
    session_start();
} 
require_once "../../classfile/initialize.php";
require_once "../../classfile/utility.php"; 
$ins_by=$_SESSION['user_id']; $ins_date=date('d-m-Y'); $ins_time=date('h:i:s A'); $ins_device='Web'; $entry_type='Admin'; $status=1;
$editid=$_POST['id']; $name=$_POST['name']; $code=strtoupper($_POST['code']); $hcode=$_POST['hcode']; $hname=$_POST['hname'];
if($name !='' && $code !=''){
if($hcode != $code) $rowcount=$utility_query->check_country_code_name($conn,$code,'code'); else $rowcount=0;
if($rowcount==0){
if($hname != $name) $rowcount1=$utility_query->check_country_code_name($conn,$name,'name'); else $rowcount1=0; 
if($rowcount1==0){
$result=$utility_query->update_country_data($conn,$editid,$code,$name,$ins_by,$ins_date,$entry_type,$ins_device,$ip);
echo "1";
}else echo "3";
}else echo "2";
}else echo "0";
?>