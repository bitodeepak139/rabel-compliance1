<?php
require 'classfile/initialize.php';
$data=trim($_POST['id']);  
$data1=trim($_POST['details']); 
$actid=substr($data, strpos($data, "-") + 1); 
$idfield= reset(explode('-', $data));
$table_name= reset(explode('-', $data1));
$field=substr($data1, strpos($data1, "-") + 1);
$check=$db->unv_active_block_data($actid,$idfield,$table_name,$field,$status);
?>