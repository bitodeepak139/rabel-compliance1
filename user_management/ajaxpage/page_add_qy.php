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
$module = $_POST['module'];
$submodule = $_POST['submodule'];
$name = $_POST['name'];
$url = $_POST['url'];
$seqno = $_POST['seqno'];
if ($module != '' && $name != '' && $url != '' && $seqno != '') {
    if ($submodule != '')
        $rowcount = $user_query->get_row_count_of_table($conn, "usm_add_pages", "*", "`fk_usm_module_id`='$module' AND `fk_usm_sub_module_id`='$submodule' AND `page_name`='$name'");
    else
        $rowcount = $user_query->get_row_count_of_table($conn, "usm_add_pages", "*", "`fk_usm_module_id`='$module' AND `page_name`='$name'");

    if ($rowcount == 0) {
        if ($submodule != '')
            $rowcount1 = $user_query->get_row_count_of_table($conn, "usm_add_pages", "*", "`fk_usm_module_id`='$module' AND `fk_usm_sub_module_id`='$submodule' AND `page_sequence`='$seqno'");
        else
            $rowcount1 = $user_query->get_row_count_of_table($conn, "usm_add_pages", "*", "`fk_usm_module_id`='$module' AND  `page_sequence`='$seqno'");

        if ($rowcount1 == 0) {
            if ($submodule != '')
                $rowcount2 = $user_query->get_row_count_of_table($conn, "usm_add_pages", "*", "`fk_usm_module_id`='$module' AND `fk_usm_sub_module_id`='$submodule' AND `page_actual`='$url'");
            else
                $rowcount2 = $user_query->get_row_count_of_table($conn, "usm_add_pages", "*", "`fk_usm_module_id`='$module'  AND `page_actual`='$url'");
            if ($rowcount2 == 0) {
                $result = $user_query->insert_page_data($conn, $module, $submodule, $name, $url, $seqno, $status, $ins_by, $ins_date, $entry_type, $ins_device, $ip);
                echo "1";
            } else
                echo "4";
        } else
            echo "3";
    } else
        echo "2";
} else
    echo "0";
?>