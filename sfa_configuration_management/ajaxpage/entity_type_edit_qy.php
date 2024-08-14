<?php
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}
require_once "../../classfile/initialize.php";
require_once "../../classfile/sfa_configuration_management.php";
$update_by = $_SESSION['user_id'];
$update_date = date('d-m-Y');
$ins_time = date('h:i:s A');
$update_system = 'Web';
$status = 1;
$id = $_POST['id'];
$typeid = $_POST['typeid'];
$typename = $_POST['typename'];
$htypeid = $_POST['htypeid'];
$htypename = $_POST['htypename'];
if ($typeid != '' && $typename != '') {
    if ($htypeid != $typeid)
        $rowcount = $sfa_query->get_row_count_of_table($conn, 'sfa_cnf_mst_entity_type', '*', "pk_sfa_cnf_entitytype_id='$typeid'");
    else
        $rowcount = 0;
    if ($rowcount == 0) {
        if ($htypename != $typename)
            $rowcount1 = $sfa_query->get_row_count_of_table($conn, 'sfa_cnf_mst_entity_type', '*', "type_name='$typename'");
        else
            $rowcount1 = 0;
        if ($rowcount1 == 0) {
            $updateValue = ['pk_sfa_cnf_entitytype_id'=>$typeid,'type_name'=>$typename,'update_by'=>$update_by,'update_date'=>$update_date,'update_system'=>$update_system,'update_ip'=>$ip];
            $Conditions = ['id'=>$id];
            $result = $sfa_query->UpdateData($conn,'sfa_cnf_mst_entity_type',$updateValue, $Conditions);
            echo "1";
        } else
            echo "3";
    } else
        echo "2";
} else
    echo "0";
?>