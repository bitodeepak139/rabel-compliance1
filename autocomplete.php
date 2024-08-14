<?php 
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}
require "classfile/initialize.php";
require "classfile/sale_invc.php";
$val=$_GET['term']; $client_id=$_SESSION['client_id'];
$itmtype_retval=$salereg_query->get_buyer_seller($conn,$client_id,$val);
foreach($itmtype_retval as $row){
$text = $row['firm_name'].' ('.$row['buyer_seller_id'].')'.' ('.$row['user_type'].')';
$data[]=$text;
}
echo json_encode($data);
?>