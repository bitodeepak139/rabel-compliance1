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
$status = 1;
$country = $_POST['country'];
$zone_name = $_POST['zone_name'];
$department_details = $_POST['department_details'];
if ($country != '' && $zone_name != '') {
    $rowcount = $org_query->get_row_count_of_table($conn,"cnf_mst_zone","*","country_id='$country' AND zone_name='$zone_name'");
    if ($rowcount == 0) {
        $result = $org_query->insert_zone_data($conn, $country,$zone_name,$department_details, $status, $ins_by, $ins_date, $ins_time, $ins_device, $ip);
        echo "1";
    } else
        echo "2";
} else
    echo "0";
?>