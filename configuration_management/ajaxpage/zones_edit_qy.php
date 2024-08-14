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
$editid = $_POST['id'];
$country_id = $_POST['country'];
$hcountryID = $_POST['hcountryID'];
$zone_name = $_POST['zone_name'];
$hzonename = $_POST['hzonename'];
$zone_details = $_POST['department_details'];
if ($country_id != '' && $zone_name != '') {
    $rowcount = $org_query->get_row_count_of_table($conn, 'cnf_mst_zone', '*', "country_id='$country_id' AND zone_name='$zone_name'");
    if ($rowcount == 0) {
        $result = $org_query->update_zone_data($conn, $editid, $country_id, $zone_name, $zone_details);
        echo "1";
    } else {
        if (($country_id == $hcountryID) && ($hzonename == $zone_name)) {
            $result = $org_query->update_zone_data($conn, $editid, $country_id, $zone_name, $zone_details);
            echo "1";
        } else {
            echo "2";
        }
    }
} else
    echo "0";
?>