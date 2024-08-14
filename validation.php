<?php
function get_reg_validation() {
$imgfile=strtolower($_FILES["file"]['name']);
$target_file=basename($imgfile);
$imageFileType=pathinfo($target_file,PATHINFO_EXTENSION);
if($_POST['name'] == '') {
$validate=0; $errormsg='Name Required..!!';
return array('v' => $validate, 'e' => $errormsg); 
}
else if($_POST['mobile'] == '') {
$validate=0; $errormsg='Mobile No. Required..!!';
return array('v' => $validate, 'e' => $errormsg); 
}
/*else if($_POST['email'] == '') {
$validate=0; $errormsg='Email ID Required..!!';
return array('v' => $validate, 'e' => $errormsg); 
}
else if($_POST['firmname'] == '') {
$validate=0; $errormsg='Firm Name Required..!!';
return array('v' => $validate, 'e' => $errormsg); 
}
else if($_POST['address'] == '') {
$validate=0; $errormsg='H.O. Address Required..!!';
return array('v' => $validate, 'e' => $errormsg); 
}*/
else if($_POST['username'] == '') {
$validate=0; $errormsg='Username Required..!!';
return array('v' => $validate, 'e' => $errormsg); 
}
else if($_POST['password'] == '') {
$validate=0; $errormsg='Password Required..!!';
return array('v' => $validate, 'e' => $errormsg); 
}
else if($_POST['password'] != $_POST['confirm_password']) {
$validate=0; $errormsg='Confirm Password Not Match..!!';
return array('v' => $validate, 'e' => $errormsg); 
}
else   {
$validate=1; $errormsg=''; 
return array('v' => $validate, 'e' => $errormsg);
}
}

function get_serv_validation(){
/*$extension=array("jpeg","jpg","png","doc","docx","xls","xlsx","pdf");
$count=0;
foreach($_FILES["allfile"]["tmp_name"] as $key=>$tmp_name){
$file_name=strtolower($_FILES["allfile"]["name"][$key]);
$file_tmp=$_FILES["allfile"]["tmp_name"][$key];
echo $ext=pathinfo($file_name,PATHINFO_EXTENSION);
if(!in_array($ext,$extension))
$count++; 
}
if($count > 0){
$validate=0; $errormsg='Data not saved, one or more file not valid file, please select all valid file and format..!!';
return array('v' => $validate, 'e' => $errormsg);
}
else{*/
$validate=1; $errormsg=''; 
return array('v' => $validate, 'e' => $errormsg);
//}
}

function get_item_validation() {
if($_POST['process'] == '') {
$validate=0; $errormsg='Item Process Required..!!';
return array('v' => $validate, 'e' => $errormsg); 
}
else if($_POST['itmname'] == '') {
$validate=0; $errormsg='Item Name Required..!!';
return array('v' => $validate, 'e' => $errormsg); 
}
else if($_POST['munit'] == '') {
$validate=0; $errormsg='Measure Unit Required..!!';
return array('v' => $validate, 'e' => $errormsg); 
}
else if($_POST['hsn'] == '') {
$validate=0; $errormsg='HSN/SAC Required..!!';
return array('v' => $validate, 'e' => $errormsg); 
}
else if($_POST['sqty'] == '') {
$validate=0; $errormsg='Special Qunatity Required..!!';
return array('v' => $validate, 'e' => $errormsg); 
}
else if($_POST['qty'] == '') {
$validate=0; $errormsg='Qunatity Required..!!';
return array('v' => $validate, 'e' => $errormsg); 
}
else if($_POST['price'] == '') {
$validate=0; $errormsg='Unit Price Required..!!';
return array('v' => $validate, 'e' => $errormsg); 
}
else if($_POST['hastax'] == '') {
$validate=0; $errormsg='Has Direct Tax Required..!!';
return array('v' => $validate, 'e' => $errormsg); 
}
else if($_POST['gstrate'] == '') {
$validate=0; $errormsg='GST Rate Required..!!';
return array('v' => $validate, 'e' => $errormsg); 
}
else if($_POST['cess'] == '') {
$validate=0; $errormsg='CESS Required..!!';
return array('v' => $validate, 'e' => $errormsg); 
}
else if($_POST['tds'] == '') {
$validate=0; $errormsg='TDS Required..!!';
return array('v' => $validate, 'e' => $errormsg); 
}
else   {
$validate=1; $errormsg=''; 
return array('v' => $validate, 'e' => $errormsg);
}
}
function get_bank_validation() {
if($_POST['bname'] == '') {
$validate=0; $errormsg='BANK NAME Required..!!';
return array('v' => $validate, 'e' => $errormsg); 
}
else if($_POST['accountno'] == '') {
$validate=0; $errormsg='ACCOUNT NO. Required..!!';
return array('v' => $validate, 'e' => $errormsg); 
}
else if($_POST['ifsccode'] == '') {
$validate=0; $errormsg='IFSC CODE Required..!!';
return array('v' => $validate, 'e' => $errormsg); 
}
else if($_POST['branch'] == '') {
$validate=0; $errormsg='BRANCH Required..!!';
return array('v' => $validate, 'e' => $errormsg); 
}
else if($_POST['defaulacc'] == '') {
$validate=0; $errormsg='IS DEFAULT ACCOUNT Required..!!';
return array('v' => $validate, 'e' => $errormsg); 
}
else   {
$validate=1; $errormsg=''; 
return array('v' => $validate, 'e' => $errormsg);
}
}

function get_expense_validation() {
if($_POST['name'] == '') {
$validate=0; $errormsg='FIRM NAME REQUIRED..!!';
return array('v' => $validate, 'e' => $errormsg); 
}
else if($_POST['gstrate'] == '') {
$validate=0; $errormsg='GST RATE REQUIRED..!!';
return array('v' => $validate, 'e' => $errormsg); 
}
else if($_POST['cess'] == '') {
$validate=0; $errormsg='CESS REQUIRED..!!';
return array('v' => $validate, 'e' => $errormsg); 
}
else if($_POST['tds'] == '') {
$validate=0; $errormsg='TDS REQUIRED..!!';
return array('v' => $validate, 'e' => $errormsg); 
}
else   {
$validate=1; $errormsg=''; 
return array('v' => $validate, 'e' => $errormsg);
}
}
function get_profile_validation() {
if($_POST['name'] == '') {
$validate=0; $errormsg='Name Required..!!';
return array('v' => $validate, 'e' => $errormsg); 
}
else if($_POST['firmname'] == '') {
$validate=0; $errormsg='Firm Name Required..!!';
return array('v' => $validate, 'e' => $errormsg); 
}
else if($_POST['address'] == '') {
$validate=0; $errormsg='H.O Address Required..!!';
return array('v' => $validate, 'e' => $errormsg); 
}
else if($_POST['state'] == '') {
$validate=0; $errormsg='State Required..!!';
return array('v' => $validate, 'e' => $errormsg); 
}

else if($_POST['mobile'] == '') {
$validate=0; $errormsg='Mobile No. Required..!!';
return array('v' => $validate, 'e' => $errormsg); 
}

else if($_POST['invprefix'] == '') {
$validate=0; $errormsg='INVOICE PREFIX Required..!!';
return array('v' => $validate, 'e' => $errormsg); 
}
else   {
$validate=1; $errormsg=''; 
return array('v' => $validate, 'e' => $errormsg);
}
}

?>