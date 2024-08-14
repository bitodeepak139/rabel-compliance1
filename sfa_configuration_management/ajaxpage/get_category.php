<?php
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}
require_once "../../classfile/initialize.php";
require_once "../../classfile/sfa_configuration_management.php";
$id = $_POST['selected_id'];
$retval = $sfa_query->fetch_data($conn, "sfa_cnf_mst_entity_category", "*", "transaction_status='1' AND fk_sfa_cnf_entitytype_id='$id'");
echo "<option value=''>Select Category</option>";
foreach ($retval as $row) {
    echo "<option value='$row[pk_sfa_cnf_entcategory_id]'>$row[category_name]</option>";
}
?>