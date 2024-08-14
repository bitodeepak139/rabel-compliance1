<?php
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}
require_once "../../classfile/initialize.php";
require_once "../../classfile/user.php";
// $id = $_POST['id'];
// $retval = $user_query->get_select_module($conn, $id);
if (isset($_POST['isset_get_seq'])) {
    $id = $_POST['id'];
    $rowCount = $user_query->get_row_count_of_table($conn, "usm_mst_submodule", "*", "`fk_usm_module_id`='$id' order by `id` desc");
    echo $rowCount;
}
if (isset($_POST['isset_get_sub_module_seq'])) {
    $module_id = $_POST['module_id'];
    $submodule_id = $_POST['submodule_id'];
    $rowCount = $user_query->get_row_count_of_table($conn, "usm_add_pages", "*", "`fk_usm_module_id`='$module_id' AND `fk_usm_sub_module_id`='$submodule_id' order by `id` desc");
    echo $rowCount;
}


if (isset($_POST['isset_dependent_sub_module'])) {
    $id = $_POST['id'];
    $subModuleStatus = $user_query->fetch_data($conn, "usm_add_modules", "sub_module_status", "`pk_usm_module_id`='$id'");
    $response_arr = array();
    if ($subModuleStatus[0]['sub_module_status']) {
        $rowCount = $user_query->get_row_count_of_table($conn, "usm_mst_submodule", "*", "`fk_usm_module_id`='$id' order by `id` desc");
        $html = '';
        if ($rowCount != 0) {
            $result = $user_query->fetch_data($conn, "usm_mst_submodule", "*", "`fk_usm_module_id`='$id'");
            $html ="<option value=''>--Please Select the Sub Module--</option>";
            foreach ($result as $row) {
                $html .="<option value='$row[pk_usm_submodule_id]'>$row[submodule_name]</option>";
            }
        } else {
            $html="<option value=''>No Sub Module Added Yet!!!</option>";
        }
        array_push($response_arr,'true',$html);
    }else{
        $rowCount = $user_query->get_row_count_of_table($conn, "usm_add_pages", "*", "`fk_usm_module_id`='$id' order by `id` desc");
        array_push($response_arr,'false',$rowCount);
    }
    echo json_encode($response_arr);
}


?>