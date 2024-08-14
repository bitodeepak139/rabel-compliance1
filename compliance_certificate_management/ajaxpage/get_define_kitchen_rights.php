<?php
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}
require_once "../../classfile/initialize.php";
require_once "../../classfile/compliance_certificate_management.php";

if ($_POST['isset_getDefineKitchenRights']) {
    $establishmentType = trim($_POST['entityType']);
    $entity_name = trim($_POST['entity_name']);
    $zone_name = trim($_POST['zone_name']);

    // ='$establishmentType' AND a.zone_id='$zone_name'
    $condition = '1';

    if ($establishmentType != '') {
        $condition .= " AND a.fk_sfa_cnf_entitytype_id='$establishmentType'";
    }

    if ($entity_name != '') {
        $entity_arr = explode("-", $entity_name);
        $entityId = $entity_arr[0];
        $conditions .= " AND a.pk_sfa_ent_entity_id='$entityId'";
    }

    if ($zone_name != '') {
        $condition .= " AND a.zone_id='$zone_name'";
    }

    $fetch_data_zone_k = $ccm_query->fetch_data($conn, "sfa_ent_mst_entity as a left join cnf_mst_zone as b on a.zone_id=b.pk_cnf_zone_id", "a.*,b.zone_name", $condition);
    // $ccm_query->debug($fetch_data_zone_k);
    $html = '';
    if ($fetch_data_zone_k != 0) {
        $html .= "
        <div class='table-responsive'>
        <table class='table table-bordered table-striped'>
        <thead>
            <tr>
                <th>Entity ID</th>
                <th>Entity Name</th>
                <th>Zone Name</th>
                <th>L1 User</th>
                <th>L2 User</th>
                <th>L3 User</th>
                <th>L4 User</th>
                <th>Action</th>
            </tr>
        </thead>
        <tbody>";
        foreach ($fetch_data_zone_k as $row) {
            $html .= "
        <tr>
            <td>$row[pk_sfa_ent_entity_id]</td>
            <td>$row[entity_name]</td>
            <td>$row[zone_name]</td>
            <td>
                <select class='form-control' name='L1_user' id='L1_user_$row[pk_sfa_ent_entity_id]'>
                    <option value=''>Select L1 User</option>";
            $result_userl1 = $ccm_query->fetch_data($conn, "usm_add_users", "*", "transaction_status='1' AND user_level='L1'");
            if ($result_userl1 != 0) {
                foreach ($result_userl1 as $row_userl1) {
                    $fetch_data_selectedL1user = $ccm_query->fetch_data($conn, "cpl_define_kitchen_rights", "l1_user", "kitchen_id='$row[pk_sfa_ent_entity_id]'");
                    if ($fetch_data_selectedL1user != 0) {
                        if ($fetch_data_selectedL1user[0]['l1_user'] == $row_userl1['pk_usm_user_id']) {
                            $html .= "<option value='$row_userl1[pk_usm_user_id]' selected>$row_userl1[user_name]</option>";
                        } else {
                            $html .= "<option value='$row_userl1[pk_usm_user_id]'>$row_userl1[user_name]</option>";
                        }
                    } else {
                        $html .= "<option value='$row_userl1[pk_usm_user_id]'>$row_userl1[user_name]</option>";
                    }
                }
            }
            $html .= "</select>
            </td>
            <td>
                <select class='form-control' name='L2_user' id='L2_user_$row[pk_sfa_ent_entity_id]'>
                    <option value=''>Select L2 User</option>";
            $result_userL2 = $ccm_query->fetch_data($conn, "usm_add_users", "*", "transaction_status='1' AND user_level='L2'");
            if ($result_userL2 != 0) {
                foreach ($result_userL2 as $row_userL2) {
                    $fetch_data_selectedL2user = $ccm_query->fetch_data($conn, "cpl_define_kitchen_rights", "l2_user", "kitchen_id='$row[pk_sfa_ent_entity_id]'");
                    if ($fetch_data_selectedL2user != 0) {
                        if ($fetch_data_selectedL2user[0]['l2_user'] == $row_userL2['pk_usm_user_id']) {
                            $html .= "<option value='$row_userL2[pk_usm_user_id]' selected>$row_userL2[user_name]</option>";
                        } else {
                            $html .= "<option value='$row_userL2[pk_usm_user_id]'>$row_userL2[user_name]</option>";
                        }
                    } else {
                        $html .= "<option value='$row_userL2[pk_usm_user_id]'>$row_userL2[user_name]</option>";
                    }
                    // $html.="<option value='$row_userL2[pk_usm_user_id]'>$row_userL2[user_name]</option>";
                }
            }
            $html .= "</select>
            </td>
            <td>
                <select class='form-control' name='L3_user' id='L3_user_$row[pk_sfa_ent_entity_id]'>
                    <option value=''>Select L3 User</option>";
            $result_userL3 = $ccm_query->fetch_data($conn, "usm_add_users", "*", "transaction_status='1' AND user_level='L3'");
            if ($result_userL3 != 0) {
                foreach ($result_userL3 as $row_userL3) {
                    $fetch_data_selectedL3user = $ccm_query->fetch_data($conn, "cpl_define_kitchen_rights", "l3_user", "kitchen_id='$row[pk_sfa_ent_entity_id]'");
                    if ($fetch_data_selectedL3user != 0) {
                        if ($fetch_data_selectedL3user[0]['l3_user'] == $row_userL3['pk_usm_user_id']) {
                            $html .= "<option value='$row_userL3[pk_usm_user_id]' selected>$row_userL3[user_name]</option>";
                        } else {
                            $html .= "<option value='$row_userL3[pk_usm_user_id]'>$row_userL3[user_name]</option>";
                        }
                    } else {
                        $html .= "<option value='$row_userL3[pk_usm_user_id]'>$row_userL3[user_name]</option>";
                    }
                    // $html.="<option value='$row_userL3[pk_usm_user_id]'>$row_userL3[user_name]</option>";
                }
            }
            $html .= "</select>
            </td>
            <td>
                <select class='form-control' name='L4_user' id='L4_user_$row[pk_sfa_ent_entity_id]'>
                    <option value=''>Select L4 User</option>";
            $result_userl4 = $ccm_query->fetch_data($conn, "usm_add_users", "*", "transaction_status='1' AND user_level='L4'");
            if ($result_userl4 != 0) {
                foreach ($result_userl4 as $row_userl4) {
                    $fetch_data_selectedL4user = $ccm_query->fetch_data($conn, "cpl_define_kitchen_rights", "l4_user", "kitchen_id='$row[pk_sfa_ent_entity_id]'");
                    if ($fetch_data_selectedL4user != 0) {
                        if ($fetch_data_selectedL4user[0]['l4_user'] == $row_userl4['pk_usm_user_id']) {
                            $html .= "<option value='$row_userl4[pk_usm_user_id]' selected>$row_userl4[user_name]</option>";
                        } else {
                            $html .= "<option value='$row_userl4[pk_usm_user_id]'>$row_userl4[user_name]</option>";
                        }
                    } else {
                        $html .= "<option value='$row_userl4[pk_usm_user_id]'>$row_userl4[user_name]</option>";
                    }
                    // $html.="<option value='$row_userl4[pk_usm_user_id]'>$row_userl4[user_name]</option>";
                }
            }
            $html .= "</select>
            </td>
            <td class='mx-auto'>
                <input type='submit' value='Save' class='btn btn-primary' onclick=\"defineKitchenRights('$row[pk_sfa_ent_entity_id]')\">
            </td>
        </tr>
        ";
        }
        $html .= "</tbody>
</table>
</div>";
        echo $html;
    } else {
        echo "<h6 class='text-danger p-2'>No Data Found</h6>";
    }
}
