<?php
if (session_status() === PHP_SESSION_NONE) {
    session_start();
} 
require_once "../classfile/initialize.php";
$tmpid=$_POST['id']; $table_name=$_POST['tbname']; $tbid= $_POST['tbid'];
$del_query="delete from $table_name where $tbid=:var3";
//echo $del_query;
$del_sql=$conn->prepare($del_query);
$del_sql->bindParam(':var3',$tmpid);
$del_sql->execute();
?>