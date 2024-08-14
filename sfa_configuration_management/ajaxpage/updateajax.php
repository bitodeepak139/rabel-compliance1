<?php
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}
require_once "../../classfile/initialize.php";
require_once "../../classfile/sfa_configuration_management.php";
$update_by = $_SESSION['user_id'];
$update_date = date('d-m-Y');
$update_time = date('h:i:s A');
$update_system = 'Web';
$status = 1;

if (isset($_POST["isset_update_org_type"])) {
    $id = trim($_POST["id"]);
    $orgid = trim($_POST["orgid"]);
    $horgid = trim($_POST["horgid"]);
    $orgname = trim($_POST["orgname"]);
    $horgname = trim($_POST["horgname"]);
    $response_arr = array();

    if ($orgid != '' && $orgname != '') {
        if ($horgid != $orgid)
            $rowcount = $sfa_query->get_row_count_of_table($conn, 'sfa_cnf_mst_organization_type', '*', "pk_sfa_cnf_custype_id='$orgid' AND type_name='$orgname'");
        else
            $rowcount = 0;


        if ($rowcount == 0) {
            if ($horgname != $orgname)
                $rowcount1 = $sfa_query->get_row_count_of_table($conn, 'sfa_cnf_mst_organization_type', '*', "pk_sfa_cnf_custype_id='$orgid' AND type_name='$orgname'");
            else
                $rowcount1 = 0;

            if ($rowcount1 == 0) {
                $updateValue = ['pk_sfa_cnf_custype_id' => $orgid, 'type_name' => $orgname, 'update_by' => $update_by, 'update_date' => $update_date, 'update_system' => $update_system, 'update_ip' => $ip];
                $Conditions = ['id' => $id];
                $result = $sfa_query->UpdateData($conn, 'sfa_cnf_mst_organization_type', $updateValue, $Conditions);
                if ($result) {
                    array_push($response_arr, "true", "Organization Details Update Successfully", "ajaxpage/get_data_ajax.php", "isset_get_org_type");

                } else {
                    array_push($response_arr, "false", "Error in Query", "#");
                }
            } else
                array_push($response_arr, "false", "Organization Name Already Exists", "#");
        } else
            array_push($response_arr, "false", "Organization Already Exists", "#");
    } else {
        array_push($response_arr, "false", "Please Fill the Required Fields", "#");
    }
    echo json_encode($response_arr);
}

if (isset($_POST['isset_update_entity_category'])) {
    $hentity_type = trim($_POST['hentity_type']);
    $hcategory_name = trim($_POST['hcategory_name']);
    $entity_type = trim($_POST['entity_type']);
    $category_name = trim($_POST['category_name']);
    $category_details = trim($_POST['category_details']);
    $id = trim($_POST['id']);

    $response_arr = array();
    if ($entity_type != '' && $category_name != '') {
        if ($hentity_type != $entity_type)
            $rowcount = $sfa_query->get_row_count_of_table($conn, 'sfa_cnf_mst_entity_category', '*', "fk_sfa_cnf_entitytype_id='$entity_type' AND category_name='$category_name'");
        else
            $rowcount = 0;


        if ($rowcount == 0) {
            if ($hcategory_name != $category_name)
                $rowcount1 = $sfa_query->get_row_count_of_table($conn, 'sfa_cnf_mst_entity_category', '*', "fk_sfa_cnf_entitytype_id='$entity_type' AND category_name='$category_name'");
            else
                $rowcount1 = 0;

            if ($rowcount1 == 0) {
                $updateValue = ['fk_sfa_cnf_entitytype_id' => $entity_type, 'category_name' => $category_name, 'category_details' => $category_details, 'update_by' => $update_by, 'update_date' => $update_date, 'update_time' => $update_time, 'update_system' => $update_system, 'update_ip' => $ip];
                $Conditions = ['id' => $id];
                $result = $sfa_query->UpdateData($conn, 'sfa_cnf_mst_entity_category', $updateValue, $Conditions);
                if ($result) {
                    array_push($response_arr, "true", "Entity Category Update Successfully", "ajaxpage/get_data_ajax.php", "isset_get_entity_category");

                } else {
                    array_push($response_arr, "false", "Error in Query", "#");
                }
            } else
                array_push($response_arr, "false", "Category Name Already Exists", "#");
        } else
            array_push($response_arr, "false", "Entity Category Already Exists", "#");
    } else {
        array_push($response_arr, "false", "Please Fill the Required Fields", "#");
    }
    echo json_encode($response_arr);
}


if (isset($_POST['isset_update_entity_sub_category'])) {
    $hentity_id = trim($_POST['hentity_id']);
    $hcategory_id = trim($_POST['hcategory_id']);
    $hsubcategory_name = trim($_POST['hsubcategory_name']);
    $entity_id = trim($_POST['entity_id']);
    $category_id = trim($_POST['category_id']);
    $sub_category_name = trim($_POST['sub_category_name']);
    $sub_category_details = trim($_POST['sub_category_details']);
    $id = trim($_POST['id']);

    $response_arr = array();

    if ($entity_id != '' && $category_id != '' && $sub_category_name != '') {
        if ($hentity_id != $entity_id)
            $rowcount = $sfa_query->get_row_count_of_table($conn, 'sfa_cnf_mst_entity_subcategory', '*', "fk_sfa_cnf_entitytype_id='$entity_id' AND fk_sfa_cnf_entcategory_id='$category_id' AND subcategory_name='$sub_category_name'");
        else
            $rowcount = 0;


        if ($rowcount == 0) {
            if ($hcategory_id != $category_id)
                $rowcount1 = $sfa_query->get_row_count_of_table($conn, 'sfa_cnf_mst_entity_subcategory', '*', "fk_sfa_cnf_entitytype_id='$entity_id' AND fk_sfa_cnf_entcategory_id='$category_id' AND subcategory_name='$sub_category_name'");
            else
                $rowcount1 = 0;

            if ($rowcount1 == 0) {
                if ($sub_category_name != $hsub_category_name)
                    $rowcount1 = $sfa_query->get_row_count_of_table($conn, 'sfa_cnf_mst_entity_subcategory', '*', "fk_sfa_cnf_entitytype_id='$entity_id' AND fk_sfa_cnf_entcategory_id='$category_id' AND subcategory_name='$sub_category_name'");
                else
                    $rowcount2 = 0;
                if ($rowcount2 == 0) {
                    $updateValue = ['fk_sfa_cnf_entitytype_id' => $entity_id, 'fk_sfa_cnf_entcategory_id' => $category_id, 'subcategory_name' => $sub_category_name, 'subcategory_details' => $sub_category_details, 'update_by' => $update_by, 'update_date' => $update_date, 'update_time' => $update_time, 'update_system' => $update_system, 'update_ip' => $ip];
                    $Conditions = ['id' => $id];
                    $result = $sfa_query->UpdateData($conn, 'sfa_cnf_mst_entity_subcategory', $updateValue, $Conditions);
                    if ($result) {
                        array_push($response_arr, "true", "Entity Category Update Successfully", "ajaxpage/get_data_ajax.php", "isset_get_entity_sub_category");

                    } else {
                        array_push($response_arr, "false", "Error in Query", "#");
                    }
                } else
                    array_push($response_arr, "false", "Sub Category Name Already Exists", "#");
            } else
                array_push($response_arr, "false", "Category Name Already Exists", "#");
        } else
            array_push($response_arr, "false", "Entity Category Already Exists", "#");
    } else {
        array_push($response_arr, 'false', 'Please Fill All the Required.!!!', "#");
    }
    echo json_encode($response_arr);
}

?>