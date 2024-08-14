<?php
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}
require_once "../../classfile/initialize.php";
require_once "../../classfile/configuration_management.php";
$ins_by = $_SESSION['user_id'];
$ins_date = date('d-m-Y');
$ins_time = date('h:i:s A');
$ins_device = 'Web';
$entry_type = 'Admin';
$status = 1;

$company_name = $_POST['company_name'];
$cin_no = $_POST['cin_no'];
$pan_no = $_POST['pan_no'];
$gst_no = $_POST['gst_no'];
$tan_no = $_POST['tan_no'];
$fax_no = $_POST['fax_no'];
$registered_address = $_POST['registered_address'];
$country = $_POST['country'];
$state = $_POST['state'];
$city = $_POST['city'];
$contact1 = $_POST['contact1'];
$contact2 = $_POST['contact2'];
$email = $_POST['email'];
$website = $_POST['website'];
$editid = $_POST['id'];
$hfile = $_POST['logo_old'];
$imgfile = strtolower($_FILES["logo_image"]['name']);
$response_arr = array();
if ($company_name != '' ) {
    $target_dir = "../../upload/logo/";
    $randno = mt_rand(100000, 999999);
    $imgfile = strtolower($_FILES["logo_image"]['name']);
    if ($imgfile != '') {
        $target_file = basename($imgfile);
        $fileext = pathinfo($target_file, PATHINFO_EXTENSION);
        if ($fileext == "png" || $fileext == "jpg" || $fileext == "jpeg") {
            $filename = $company_name . '-' . 'logo' . '.' . $fileext;
            $filepath = $target_dir . $filename;
            move_uploaded_file($_FILES["logo_image"]['tmp_name'], $filepath);
        } else {
            $filename = $hfile;
        }
    } else {
        $filename = $hfile;
    }
    $result = $org_query->update_org_data($conn, $editid, $company_name,$cin_no,$pan_no,$gst_no,$tan_no,$fax_no,$registered_address,$country,$state,$city,$contact1,$contact2,$email,$website, $filename, $ins_by, $ins_date, $entry_type, $ins_device, $ip);
    array_push($response_arr,'true','Company Details Updated Successfully!!!','#');
} else{
    array_push($response_arr,'false','Company Name is Required Field !!!',"#");
}

echo json_encode($response_arr);
    
?>