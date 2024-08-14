<?php
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}
require_once "../../classfile/initialize.php";
require_once "../../classfile/configuration_management.php";
$id = $_POST['id'];
$retval = $org_query->fetch_data($conn, "cnf_mst_zone", "*", "transaction_status='1' AND country_id='$id'");
echo "<option value=''>Select Zone</option>";
foreach ($retval as $row) {
    echo "<option value='$row[pk_cnf_zone_id]'>$row[zone_name]</option>";
}
?>