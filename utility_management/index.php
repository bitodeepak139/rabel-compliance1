<?php
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}
if($_SESSION['user_id']=='')
header('Location:../login.php');
date_default_timezone_set('Asia/Calcutta');
?>
<script>window.location='add_country.php';</script>