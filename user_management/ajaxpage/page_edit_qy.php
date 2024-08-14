<?php
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}
require_once "../../classfile/initialize.php";
require_once "../../classfile/user.php";
// $user_query->debug($_POST);
$ins_by = $_SESSION['user_id'];
$ins_date = date('d-m-Y');
$ins_time = date('h:i:s A');
$ins_device = 'Web';
$entry_type = 'Admin';
$status = 1;
$editid = $_POST['id'];
$name = $_POST['name'];
$module = $_POST['module'];
$submodule = $_POST['sub-module'];
$url = $_POST['url'];
$seqno = $_POST['seqno'];
$hmodule_id = $_POST['hmodule_id'];
$hsubmodule_id = $_POST['hsubmodule_id'];
$hpage_name = $_POST['hpage_name'];
$hpage_url = $_POST['hpage_url'];
$hpage_seqno = $_POST['hpage_seqno'];
($submodule == 'undefined') ? $submodule = '' : $submodule = $_POST['sub-module'];
if ($module != '' && $name != '' && $url != '' && $seqno != '') {
    if ($submodule != '')
        if ($module == $hmodule_id && $submodule == $hsubmodule_id && $name == $hpage_name)
            $rowcount = 0;
        else
            $rowcount = $user_query->get_row_count_of_table($conn, "usm_add_pages", "*", "`fk_usm_module_id`='$module' AND `fk_usm_sub_module_id`='$submodule' AND `page_name`='$name'");
    else
        if ($module == $hmodule_id && $name == $hpage_name)
            $rowcount = 0;
        else
            $rowcount = $user_query->get_row_count_of_table($conn, "usm_add_pages", "*", "`fk_usm_module_id`='$module' AND `page_name`='$name'");

    if ($rowcount == 0) {
        if ($submodule != '')
            if ($module == $hmodule_id && $submodule == $hsubmodule_id && $seqno == $hpage_seqno)
                $rowcount1 = 0;
            else
                $rowcount1 = $user_query->get_row_count_of_table($conn, "usm_add_pages", "*", "`fk_usm_module_id`='$module' AND `fk_usm_sub_module_id`='$submodule' AND `page_sequence`='$seqno'");
        else
            if ($module == $hmodule_id && $seqno == $hpage_seqno)
                $rowcount1 = 0;
            else
                $rowcount1 = $user_query->get_row_count_of_table($conn, "usm_add_pages", "*", "`fk_usm_module_id`='$module' AND  `page_sequence`='$seqno'");
        if ($rowcount1 == 0) {
            if ($submodule != '')
                if ($module == $hmodule_id && $submodule == $hsubmodule_id && $url == $hpage_url)
                    $rowcount2 = 0;
                else
                    $rowcount2 = $user_query->get_row_count_of_table($conn, "usm_add_pages", "*", "`fk_usm_module_id`='$module' AND `fk_usm_sub_module_id`='$submodule' AND `page_actual`='$url'");
            else
                if ($module == $hmodule_id && $url == $hpage_url)
                    $rowcount2 = 0;
                else
                    $rowcount2 = $user_query->get_row_count_of_table($conn, "usm_add_pages", "*", "`fk_usm_module_id`='$module'  AND `page_actual`='$url'");
            if ($rowcount2 == 0) {
                $result = $user_query->update_page_data($conn, $editid, $module, $submodule, $name, $seqno, $url, $ins_by, $ins_date, $entry_type, $ins_device, $ip);
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