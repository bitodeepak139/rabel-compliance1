<?php
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}
$id=$_POST['id']; 
$_SESSION['session_id']=$id;
?>