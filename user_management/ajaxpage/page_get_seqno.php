<?php 
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}
require_once "../../classfile/initialize.php";
require_once "../../classfile/user.php";
$id=$_POST['id'];
echo $retval=$user_query->get_page_seqno($conn,$id);
?>