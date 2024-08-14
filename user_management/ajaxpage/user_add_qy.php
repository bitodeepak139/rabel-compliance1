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
$name = $_POST['name'];
$phone = $_POST['phone'];
$altno = $_POST['altno'];
$email = $_POST['email'];
$design = $_POST['design'];
$password = $_POST['password'];
$type_of_user_id = $_POST['type_of_user_id'];

if ($phone != '' && $name != '' && $email != '' && $type_of_user_id != '') {
    $rowcount = $user_query->check_user_name_contact_email($conn, $name, 'name');
    if ($rowcount == 0) {
        $rowcount1 = $user_query->check_user_name_contact_email($conn, $phone, 'phone');
        if ($rowcount1 == 0) {
            $rowcount2 = $user_query->check_user_name_contact_email($conn, $email, 'email');
            if ($rowcount2 == 0) {
                $target_dir = "../../upload/user/";
                $randno = mt_rand(100000, 999999);
                if (isset($_FILES["file"]) && $_FILES["file"]['name'] != '') {
                    $imgfile = strtolower($_FILES["file"]['name']);
                    $target_file = basename($imgfile);
                    $fileext = pathinfo($target_file, PATHINFO_EXTENSION);
                    if ($fileext == "png" || $fileext == "jpg" || $fileext == "jpeg") {
                        $filename = $name . '-' . 'image' . '.' . $fileext;
                        $filepath = $target_dir . $filename;
                        move_uploaded_file($_FILES["file"]['tmp_name'], $filepath);
                        $file = 1;
                    } else {
                        $file = 3;
                        $filename = '';
                    }
                } else {
                    $file = 1;
                    $filename = '';
                }
                $result = $user_query->insert_user_data($conn,$type_of_user_id,$name, $phone, $altno, $email, $password, $design, $filename, $status, $ins_by, $ins_date, $entry_type, $ins_device, $ip);
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