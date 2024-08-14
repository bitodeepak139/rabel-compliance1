<?php
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}
require_once 'classfile/initialize.php';
$page_id = base64_decode(base64_decode($_GET['pg']));
$module_id = base64_decode(base64_decode($_GET['md']));

$page_row = $abc->fetch_data($conn, "usm_add_pages as a INNER JOIN usm_page_rights as b ON a.pk_usm_page_id = b.fk_usm_page_id", "b.transaction_status", "b.fk_usm_user_id='$_SESSION[user_id]' AND a.transaction_status='1' AND b.fk_usm_module_id='$module_id' AND b.fk_usm_page_id='$page_id'   ORDER by a.page_sequence asc LIMIT 1");
// $abc->debug($page_row);
if ($page_row != 0) {
    $status = $page_row[0]['transaction_status'];
    if ($status == 0) {
        echo "<script>window.location='../'</script>";
    }
} else {
    echo "<script>window.location='../'</script>";
}



?>