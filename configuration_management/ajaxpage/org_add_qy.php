<?php
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}
require_once "../../classfile/initialize.php";
require_once "../../classfile/configuration_management.php";
$ins_by=$_SESSION['user_id']; $ins_date=date('d-m-Y'); $ins_time=date('h:i:s A'); $ins_device='Web'; $entry_type='Admin'; $status=1;
$country=$_POST['country']; $name=$_POST['name']; $state=$_POST['state']; $city=$_POST['city']; $address=$_POST['address']; $phone=$_POST['phone'];
$altno=$_POST['altno']; $email=$_POST['email']; $website=$_POST['website']; $imgfile=strtolower($_FILES["file"]['name']);
if($phone !='' && $name !='' && $imgfile !=''){
$rowcount=$org_query->check_org_name($conn,$name);
if($rowcount==0){
$rowcount1=$org_query->check_org_contact($conn,$phone);
if($rowcount1==0){
$target_dir="../../upload/logo/"; $randno=mt_rand(100000,999999);
$imgfile=strtolower($_FILES["file"]['name']);
if($imgfile !='') {
$target_file=basename($imgfile);
$fileext=pathinfo($target_file,PATHINFO_EXTENSION);
if($fileext=="png" || $fileext=="jpg" || $fileext=="jpeg"){
$filename=$name.'-'.'logo'.'.'.$fileext;
$filepath=$target_dir.$filename; 
move_uploaded_file($_FILES["file"]['tmp_name'], $filepath);
$file=1;
} else { $file=3; $filename=''; }
} else { $file=1; $filename=''; }
if($file==1){
$result=$org_query->insert_org_data($conn,$country,$state,$name,$city,$address,$phone,$altno,$email,$website,$filename,$status,$ins_by,$ins_date,$entry_type,$ins_device,$ip);
echo "1";
}else  echo "4";
}else  echo "3";
}else  echo "2";
}else  echo "0";
?>