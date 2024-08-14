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
$smname = $_POST['name'];
$module = $_POST['module'];
$url = $_POST['url'];
$seqno = $_POST['seqno'];

if ($module != '' && $smname != '' && $url != '' && $seqno != '') {
    $rowcount = $user_query->get_row_count_of_table($conn, "usm_mst_submodule", "*", "`submodule_name`='$smname' AND `fk_usm_module_id`='$module'");
    if ($rowcount == 0 ) {
        $rowcount1 = $user_query->get_row_count_of_table($conn, "usm_mst_submodule", "*", "`sm_seq`='$seqno' AND `fk_usm_module_id`='$module' ");
        if ($rowcount1 == 0 ) {
            $rowcount2 = $user_query->get_row_count_of_table($conn, "usm_mst_submodule", "*", "`dashboard_url`='$url' AND `fk_usm_module_id`='$module'");
            if ($rowcount2 == 0 ) {
                $result = $user_query->update_sub_module_data($conn, $editid, $module, $smname, $seqno, $url, $ins_by, $ins_date, $entry_type, $ins_device, $ip);
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