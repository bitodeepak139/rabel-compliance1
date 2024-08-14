<?php
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}
require_once "../../classfile/initialize.php";
require_once "../../classfile/user.php";
$ins_by = $_SESSION['user_id'];
$ins_date = date('d-m-Y');
$ins_time = date('h:i:s A');
$ins_device = 'Web';
$entry_type = 'Admin';
$status = 1;
$editid = $_POST['id'];
$name = $_POST['name'];
$code = $_POST['code'];
$hcode = $_POST['hcode'];
$hname = $_POST['hname'];
$seq = $_POST['seq'];
$hseq = $_POST['hseq'];
$sub_module_status = $_POST['sub_module_status'];
// $user_query->debug($_POST);
if ($name != '' && $code != '') {
    if ($hcode != $code)
        $rowcount = $user_query->check_module_url_name($conn, $code, 'url');
    else
        $rowcount = 0;
    if ($rowcount == 0) {
        if ($hname != $name)
            $rowcount1 = $user_query->check_module_url_name($conn, $name, 'name');
        else
            $rowcount1 = 0;
        if ($rowcount1 == 0) {
            if ($hseq != $seq) {
                $rowcount2 = $user_query->check_module_url_name($conn, $seq, 'module_seq');
            } else {
                $rowcount2 = 0;
            }
            if ($rowcount2 == 0) {
                $result = $user_query->update_module_data($conn, $editid, $code, $name, $seq, $sub_module_status, $ins_by, $ins_date, $entry_type, $ins_device, $ip);
                echo "1";
            } else {
                echo "4";
            }
        } else
            echo "3";
    } else
        echo "2";
} else
    echo "0";
?>