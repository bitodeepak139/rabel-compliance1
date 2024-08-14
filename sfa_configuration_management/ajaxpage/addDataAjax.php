<?php
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}
require_once "../../classfile/initialize.php";
require_once "../../classfile/sfa_configuration_management.php";
$ins_by = $_SESSION['user_id'];
$ins_date = date('d-m-Y');
$ins_time = date('h:i:s A');
$ins_system = 'Web';
$status = 1;


if (isset($_POST['isset_add_entity_category'])) {
    $entity_type = trim($_POST['entity_type']);
    $category_name = trim($_POST['category_name']);
    $category_details = trim($_POST['category_details']);
    $response_arr = array();
    if ($entity_type != '' && $category_name != '') {
        $rowCount = $sfa_query->get_row_count_of_table($conn, 'sfa_cnf_mst_entity_category', '*', "fk_sfa_cnf_entitytype_id='$entity_type' AND category_name='$category_name'");

        if ($rowCount == 0) {
            $selectRow = $sfa_query->fetch_data($conn, "sfa_cnf_mst_entity_category a", "a.id", "1 order by a.id desc limit 1");
            $maxid = $selectRow[0]['id'] + 1;
            $primary_id = "SFACC" . $maxid;

            // inserted data
            $inserted_value = ['pk_sfa_cnf_entcategory_id' => $primary_id, 'fk_sfa_cnf_entitytype_id' => $entity_type, 'category_name' => $category_name, 'category_details' => $category_details, 'transaction_status' => $status, 'ins_by' => $ins_by, 'ins_date' => $ins_date, 'ins_time' => $ins_time, 'ins_ip' => $ip, 'ins_system' => $ins_system];

            // Call the function insert Data
            $result = $sfa_query->InsertData($conn, "sfa_cnf_mst_entity_category", $inserted_value);
            if ($result) {
                array_push($response_arr, 'true', 'Entity Category Added Successfully..!!!', "ajaxpage/get_data_ajax.php", "isset_get_entity_category");
            } else {
                array_push($response_arr, 'false', 'Error in Query', '#');
            }
        } else {
            array_push($response_arr, 'false', 'Entity Category Name Already Exists...!!!', '#');
        }
    } else {
        array_push($response_arr, 'false', 'Please Fill the Required Fields!!!', '#');
    }

    echo json_encode($response_arr);
}


if (isset($_POST['isset_add_entity_sub_category'])) {
    $entity_id = trim($_POST['entity_id']);
    $category_id = trim($_POST['category_id']);
    $sub_category_name = trim($_POST['sub_category_name']);
    $sub_category_details = trim($_POST['sub_category_details']);

    $response_arr = array();

    if ($entity_id != '' && $category_id != '' && $sub_category_name != '') {
        $rowCount = $sfa_query->get_row_count_of_table($conn, 'sfa_cnf_mst_entity_subcategory', '*', "fk_sfa_cnf_entitytype_id='$entity_id' AND fk_sfa_cnf_entcategory_id='$category_id' AND subcategory_name='$sub_category_name'");

        if ($rowCount == 0) {
            $selectRow = $sfa_query->fetch_data($conn, "sfa_cnf_mst_entity_subcategory a", "a.id", "1 order by a.id desc limit 1");
            $maxid = $selectRow[0]['id'] + 1;
            $primary_id = "SFACS" . $maxid;


            // inserted data
            $inserted_value = ['pk_sfa_cnf_entsubcategory_id' => $primary_id, 'fk_sfa_cnf_entitytype_id' => $entity_id, 'fk_sfa_cnf_entcategory_id' => $category_id, 'subcategory_name' => $sub_category_name, 'subcategory_details' => $sub_category_details, 'transaction_status' => $status, 'ins_by' => $ins_by, 'ins_date' => $ins_date, 'ins_time' => $ins_time, 'ins_ip' => $ip, 'ins_system' => $ins_system];

            // Call the function insert Data
            $result = $sfa_query->InsertData($conn, "sfa_cnf_mst_entity_subcategory", $inserted_value);
            if ($result) {
                array_push($response_arr, 'true', 'Entity Sub Category Added Successfully..!!!', "ajaxpage/get_data_ajax.php", "isset_get_entity_sub_category");
            } else {
                array_push($response_arr, 'false', 'Error in Query', '#');
            }
        } else {
            array_push($response_arr, 'false', 'Entity Category Name Already Exists...!!!', '#');
        }
    } else {
        array_push($response_arr, "false", 'Please Fill All the Required Fields.!!!', "#");
    }
    echo json_encode($response_arr);
}

?>