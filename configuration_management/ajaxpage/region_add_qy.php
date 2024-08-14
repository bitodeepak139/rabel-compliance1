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
$country = $_POST['country'];
$zone_id = $_POST['zone_id'];
$region_name = $_POST['region_name'];
$region_details = trim($_POST['region_details']);

if ($country != '' && $zone_id != '' && $region_name != '') {

    $rowcount = $org_query->get_row_count_of_table($conn, "cnf_mst_region", "*", "country_id='$country' AND fk_cnf_zone_id='$zone_id' AND region_name='$region_name'");
    if ($rowcount == 0) {
        $result = $org_query->insert_region_data($conn, $country, $zone_id, $region_name, $region_details, $status, $ins_by, $ins_date, $ins_time, $ins_device, $ip);
        echo "1";
    } else
        echo "2";
} else
    echo "0";
?>