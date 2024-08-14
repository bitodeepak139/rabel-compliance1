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
$module_id = $_POST['module_id'];
$page_id = $_POST['page_id'];
$user_id = $_POST['user_id'];
$rightStatus = $_POST['rightStatus'];
$subModule = $_POST['subModule'];
if ($module_id != '' && $page_id != '' && $user_id != '') {
    $checkUserRight = $user_query->fetch_data($conn, "usm_page_rights", "*", "`fk_usm_page_id`='$page_id' AND `fk_usm_user_id`='$user_id'");
    if ($checkUserRight == 0) {
        $status = 1;
        if ($subModule != '') {
            $result = $user_query->insert_user_page_right($conn, $module_id, $user_id, $status, $ins_by, $ins_date, $entry_type, $ins_device, $ip, $page_id, $subModule);
            echo "1";
        } else {
            $result = $user_query->insert_user_page_right($conn, $module_id, $user_id, $status, $ins_by, $ins_date, $entry_type, $ins_device, $ip, $page_id);
            echo "1";
        }
    } else {
        if ($rightStatus != '') {
            ($rightStatus == 1) ? $updatedStatus = 0 : $updatedStatus = 1;
            if ($subModule != '') {
                $result = $user_query->update_user_page_right($conn, $module_id, $user_id, $page_id, $updatedStatus, $ins_by, $ins_date, $ins_device, $ip, $subModule);
                echo '2';
            } else {
                $result = $user_query->update_user_page_right($conn, $module_id, $user_id, $page_id, $updatedStatus, $ins_by, $ins_date, $ins_device, $ip);
                echo '2';
            }
        } else {
            echo '3';
        }
    }

    // $checkpageRight = $user_query->fetch_data($conn, "usm_page_rights","*","`fk_usm_page_id`='$page_id' AND `fk_usm_user_id`='$user_id'");
    // $user_query->debug(count($checkpageRight));
    // $user_query->debug($checkpageRight);
    // if($checkpageRight == 0){
    //     // $result = $crop_query->insert_crop_variable_data($conn, $crpid, $type, $id, $status, $ins_by, $ins_date, $ip);
    // }else{

    // }
    // if(count($checkpageRight) == 0){
    //     $user_query->debug(count($checkpageRight));
    // }
}
// $array = array();
// $array1 = array();

// $user = $_POST['user'];
// $module = $_POST['module'];
// $pages = $_POST['pages'];
// $rights = $_POST['rights'];
// $array = explode(',', $pages);
// $array1 = explode(',', $rights);
// if ($user != '' && $module != '') {
//     $count = count($array);
//     for ($i = 1; $i < $count; $i++) {
//         $page_id = $array[$i];
//         $status = $array1[$i];
//         $rowcount = $user_query->check_page_right($conn, $user, $module, $page_id);
//         if ($rowcount == 0)
//             $result = $user_query->insert_page_right($conn, $module, $user, $status, $ins_by, $ins_date, $entry_type, $ins_device, $ip, $page_id);
//         else {
//             $result = $user_query->update_page_right($conn, $module, $user, $page_id, $status, $ins_by, $ins_date, $entry_type, $ins_device, $ip);
//         }
//     }
//     echo "1";
// } else
//     echo "0";
?>