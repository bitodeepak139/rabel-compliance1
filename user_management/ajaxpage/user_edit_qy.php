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
$hname = $_POST['hname'];
$name = $_POST['name'];
$hphone = $_POST['hphone'];
$hemail = $_POST['hemail'];
$pass = $_POST['pass'];
$phone = $_POST['phone'];
$altno = $_POST['altno'];
$type_of_user_id = $_POST['type_of_user'];
$email = $_POST['email'];
$design = $_POST['design'];
$hfile = $_POST['hfile'];
// $imgfile = strtolower($_FILES["file"]['name']);
if ($name != '' && $phone != '' && $email != '') {
    if ($hname != $name)
        $rowcount = $user_query->check_user_name_contact_email($conn, $name, 'name');
    else
        $rowcount = 0;
    if ($rowcount == 0) {
        if ($hphone != $phone)
            $rowcount1 = $user_query->check_user_name_contact_email($conn, $phone, 'phone');
        else
            $rowcount1 = 0;
        if ($rowcount1 == 0) {
            if ($hemail != $email)
                $rowcount2 = $user_query->check_user_name_contact_email($conn, $email, 'email');
            else
                $rowcount2 = 0;
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
                    } else {
                        $filename = $hfile;
                    }
                } else {
                    $filename = $hfile;
                }
                $result = $user_query->update_user_data($conn, $editid, $name,$type_of_user_id,$phone, $altno, $email, $pass, $design, $filename, $ins_by, $ins_date, $entry_type, $ins_device, $ip);
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