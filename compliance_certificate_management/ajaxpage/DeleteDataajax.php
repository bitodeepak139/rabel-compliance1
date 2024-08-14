<?php
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}
require_once "../../classfile/initialize.php";
require_once "../../classfile/sfa_entity_management.php";

if (isset($_POST["isset_delete_bank_account_temp"])) {
    $table_name = $_POST['table_name'];
    $id = $_POST['database_col_id'];
    $rowCount = $sfa_ent->get_row_count_of_table($conn, $table_name, '*', "pk_sfa_ent_bankaccount_id='$id'");
    $response_arr = array();
    if ($rowCount > 0) {
        $result = $sfa_ent->deleteData($conn, $table_name, "", "pk_sfa_ent_bankaccount_id", $id);
        if ($result) {
            array_push($response_arr, "true", "Data Deleted Successfully...!!!", "ajaxpage/get_data_ajax.php", "isset_contact_details_temp", '#datadiv');
        } else {
            array_push($response_arr, "false", "Error in Query");
        }
    } else {
        array_push($response_arr, "false", "Data Not Found");
    }
    echo json_encode($response_arr);
}
if (isset($_POST["isset_delete_contact_temp"])) {
    $table_name = $_POST['table_name'];
    $id = $_POST['database_col_id'];
    $rowCount = $sfa_ent->get_row_count_of_table($conn, $table_name, '*', "pk_sfa_ent_contact_id='$id'");
    $response_arr = array();
    if ($rowCount > 0) {
        $result = $sfa_ent->deleteData($conn, $table_name, "", "pk_sfa_ent_contact_id", $id);
        if ($result) {
            array_push($response_arr, "true", "Data Deleted Successfully...!!!", "ajaxpage/get_data_ajax.php", "isset_contact_details_temp", '#resultData');
        } else {
            array_push($response_arr, "false", "Error in Query");
        }
    } else {
        array_push($response_arr, "false", "Data Not Found");
    }
    echo json_encode($response_arr);
}

?>