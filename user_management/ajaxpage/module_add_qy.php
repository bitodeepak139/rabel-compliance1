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
$url = $_POST['url'];
$name = $_POST['name'];
// $module_seq = $_POST['module_seq'];
$sub_module_status = $_POST['sub_module_status'];
if ($url != '' && $name != '' ) {
    $rowcount = $user_query->check_module_url_name($conn, $name, 'name');
    if ($rowcount == 0) {
        $rowcount1 = $user_query->check_module_url_name($conn, $url, 'url');
        if ($rowcount1 == 0) {
            $module_seq = $user_query->get_row_count_of_table($conn, "usm_add_modules", "*", "1");
            $module_seq = $module_seq+1;
            // $rowcount2 = $user_query->check_module_url_name($conn, $module_seq, 'module_seq');
            // if($rowcount2 == 0){
                $result = $user_query->insert_module_data($conn, $url, $name,$module_seq,$sub_module_status,$status, $ins_by, $ins_date, $entry_type, $ins_device, $ip);
                echo "1";
            // }else{
            //     echo "4";
            // }
        } else
            echo "3";
    } else
        echo "2";
} else
    echo "0";
?>