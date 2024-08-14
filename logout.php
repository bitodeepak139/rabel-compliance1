<?php
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}
unset($_SESSION['client_id']);
session_destroy();
echo'<script>window.location.href="login.php";</script>';
?>