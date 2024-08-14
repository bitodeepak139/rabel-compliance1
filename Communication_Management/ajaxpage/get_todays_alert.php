<?php
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}
require_once "../../classfile/initialize.php";
require_once "../../classfile/compliance_certificate_management.php";
$ins_by = $_SESSION['user_id'];
$ins_date = date('d-m-Y');
$ins_time = date('h:i:s A');
$ins_date_time = date('d-m-Y h:i:s');
$ins_system = 'Web';
$status = 1;


$cr_status1 = 1;
$conn->beginTransaction();
$alertUserL1 = $ccm_query->fetch_data($conn, "`cpl_compliance_master`", "*", "transaction_status='1' AND verification_status='1' AND str_to_date(renew_due_date_l1,'%d-%m-%Y') < str_to_date('" . date('d-m-Y') . "','%d-%m-%Y')");
if ($alertUserL1 != 0) {
    //insert the data into the table 
    foreach ($alertUserL1 as $user1) {
        $kitchen_id = $user1['fk_sfa_ent_entity_id'];
        // fetch the kitchen right 
        $kitchen_right = $ccm_query->fetch_data($conn, "cpl_define_kitchen_rights", "*", "kitchen_id='$kitchen_id' AND transaction_status='1'");
        $userId = $kitchen_right[0]['l1_user'];
        // create the primary key
        $primary_key = $ccm_query->fetch_data($conn, "cpl_compliance_send_alert", "max(id) as max_id", "1");
        $pk = '';
        if ($primary_key != 0) {
            $count = $primary_key[0]['max_id'] + 1;
            $pk = "CAS" . $count;
        } else {
            $pk = "CAS" . "1";
        }


        $inserted_value = ['pk_comliance_send_alert_id' => $pk, 'fk_sfa_ent_entity_id' => $kitchen_id, 'fk_cpl_compliancetype_id' => $user1['fk_cpl_compliancetype_id'], 'fk_cpl_compliance_id' => $user1['pk_cpl_compliance_id'], 'fk_usm_user_id' => $userId, 'user_type' => 'L1', 'message_level' => 'L1', 'send_status' => 0, 'whatsapp_send_status' => 0, 'ins_by' => $ins_by, 'ins_date_time' => $ins_date_time, 'ins_ip' => $ip, 'ins_application' => $ins_system];
        // Call the function insert Data
        $result = $ccm_query->InsertData($conn, "cpl_compliance_send_alert", $inserted_value);
        // $ccm_query->debug($result);

        if ($result != '1') {
            $cr_status1 = 0;
            $ccm_query->debug("Error in Inserting the data");
        }
    }
}

$cr_status2 = 1;
$alertUserL2 = $ccm_query->fetch_data($conn, "`cpl_compliance_master`", "*", "transaction_status='1' AND verification_status='1' AND str_to_date(renew_due_date_l2,'%d-%m-%Y') < str_to_date('" . date('d-m-Y') . "','%d-%m-%Y')");
// $ccm_query->debug($alertUserL2);
if ($alertUserL2 != 0) {
    //insert the data into the table 
    foreach ($alertUserL2 as $user2) {
        $kitchen_id = $user2['fk_sfa_ent_entity_id'];
        // fetch the kitchen right 
        $kitchen_right = $ccm_query->fetch_data($conn, "cpl_define_kitchen_rights", "*", "kitchen_id='$kitchen_id' AND transaction_status='1'");

        for ($i = 1; $i <= 2; $i++) {
            $userId = $kitchen_right[0]['l' . $i . '_user'];
            // create the primary key
            $primary_key = $ccm_query->fetch_data($conn, "cpl_compliance_send_alert", "max(id) as max_id", "1");
            $pk = '';
            if ($primary_key != 0) {
                $count = $primary_key[0]['max_id'] + 1;
                $pk = "CAS" . $count;
            } else {
                $pk = "CAS" . "1";
            }

            $user_type = 'L' . $i;

            $inserted_value = ['pk_comliance_send_alert_id' => $pk, 'fk_sfa_ent_entity_id' => $kitchen_id, 'fk_cpl_compliancetype_id' => $user2['fk_cpl_compliancetype_id'], 'fk_cpl_compliance_id' => $user2['pk_cpl_compliance_id'], 'fk_usm_user_id' => $userId, 'user_type' => $user_type, 'message_level' => 'L2', 'send_status' => 0, 'whatsapp_send_status' => 0,  'ins_by' => $ins_by, 'ins_date_time' => $ins_date_time, 'ins_ip' => $ip, 'ins_application' => $ins_system];
            // Call the function insert Data
            $result = $ccm_query->InsertData($conn, "cpl_compliance_send_alert", $inserted_value);
            if ($result != '1') {
                $cr_status2 = 0;
                $ccm_query->debug("Error in Inserting the data");
            }
        }
    }
}

echo "Alert User 3";
$cr_status3 = 1;
$alertUserL3 = $ccm_query->fetch_data($conn, "`cpl_compliance_master`", "*", "transaction_status='1' AND verification_status='1' AND str_to_date(renew_due_date_l3,'%d-%m-%Y') < str_to_date('" . date('d-m-Y') . "','%d-%m-%Y')");
// $ccm_query->debug($alertUserL3);
if ($alertUserL3 != 0) {
    //insert the data into the table 
    foreach ($alertUserL3 as $user3) {
        $kitchen_id = $user3['fk_sfa_ent_entity_id'];
        // fetch the kitchen right 
        $kitchen_right = $ccm_query->fetch_data($conn, "cpl_define_kitchen_rights", "*", "kitchen_id='$kitchen_id' AND transaction_status='1'");

        for ($i = 1; $i <= 3; $i++) {
            $userId = $kitchen_right[0]['l' . $i . '_user'];
            // create the primary key
            $primary_key = $ccm_query->fetch_data($conn, "cpl_compliance_send_alert", "max(id) as max_id", "1");
            $pk = '';
            if ($primary_key != 0) {
                $count = $primary_key[0]['max_id'] + 1;
                $pk = "CAS" . $count;
            } else {
                $pk = "CAS" . "1";
            }

            $user_type = 'L' . $i;

            $inserted_value = ['pk_comliance_send_alert_id' => $pk, 'fk_sfa_ent_entity_id' => $kitchen_id, 'fk_cpl_compliancetype_id' => $user3['fk_cpl_compliancetype_id'], 'fk_cpl_compliance_id' => $user3['pk_cpl_compliance_id'], 'fk_usm_user_id' => $userId, 'user_type' => $user_type, 'message_level' => 'L3', 'send_status' => 0, 'whatsapp_send_status' => 0,  'ins_by' => $ins_by, 'ins_date_time' => $ins_date_time, 'ins_ip' => $ip, 'ins_application' => $ins_system];
            // Call the function insert Data
            $result = $ccm_query->InsertData($conn, "cpl_compliance_send_alert", $inserted_value);
            if ($result != '1') {
                $cr_status3 = 0;
                $ccm_query->debug("Error in Inserting the data");
            }
        }
    }
}
echo "Alert User 4";
$cr_status4 = 1;
$alertUserL4 = $ccm_query->fetch_data($conn, "`cpl_compliance_master`", "*", "transaction_status='1' AND verification_status='1' AND str_to_date(renew_due_date_l4,'%d-%m-%Y') < str_to_date('" . date('d-m-Y') . "','%d-%m-%Y')");
// $ccm_query->debug($alertUserL4);
if ($alertUserL4 != 0) {
    //insert the data into the table 
    foreach ($alertUserL4 as $user4) {
        $kitchen_id = $user4['fk_sfa_ent_entity_id'];
        // fetch the kitchen right 
        $kitchen_right = $ccm_query->fetch_data($conn, "cpl_define_kitchen_rights", "*", "kitchen_id='$kitchen_id' AND transaction_status='1'");
        // $userId = $kitchen_right[0]['l4_user'];
        // // create the primary key
        // $primary_key = $ccm_query->fetch_data($conn, "cpl_compliance_send_alert", "max(id) as max_id", "1");
        // $pk = '';
        // if ($primary_key != 0) {
        //     $count = $primary_key[0]['max_id'] + 1;
        //     $pk = "CAS" . $count;
        // } else {
        //     $pk = "CAS" . "1";
        // }
        // $inserted_value = ['pk_comliance_send_alert_id' => $pk, 'fk_sfa_ent_entity_id' => $kitchen_id, 'fk_cpl_compliancetype_id' => $user1['fk_cpl_compliancetype_id'], 'fk_cpl_compliance_id' => $user1['pk_cpl_compliance_id'], 'fk_usm_user_id' => $userId, 'user_type' => 'L4', 'send_status' => 0, 'whatsapp_send_status' => 0, 'transaction_status' => 0, 'ins_by' => $ins_by, 'ins_date_time' => $ins_date_time, 'ins_ip' => $ip, 'ins_application' => $ins_system];
        // // Call the function insert Data
        // $result = $ccm_query->InsertData($conn, "cpl_compliance_send_alert", $inserted_value);
        // if ($result != '1') {
        //     $cr_status4 = 0;
        //     $ccm_query->debug("Error in Inserting the data");
        // }
        for ($i = 1; $i <= 4; $i++) {
            $userId = $kitchen_right[0]['l' . $i . '_user'];
            // create the primary key
            $primary_key = $ccm_query->fetch_data($conn, "cpl_compliance_send_alert", "max(id) as max_id", "1");
            $pk = '';
            if ($primary_key != 0) {
                $count = $primary_key[0]['max_id'] + 1;
                $pk = "CAS" . $count;
            } else {
                $pk = "CAS" . "1";
            }

            $user_type = 'L' . $i;

            $inserted_value = ['pk_comliance_send_alert_id' => $pk, 'fk_sfa_ent_entity_id' => $kitchen_id, 'fk_cpl_compliancetype_id' => $user4['fk_cpl_compliancetype_id'], 'fk_cpl_compliance_id' => $user4['pk_cpl_compliance_id'], 'fk_usm_user_id' => $userId, 'user_type' => $user_type, 'message_level' => 'L4', 'send_status' => 0, 'whatsapp_send_status' => 0,  'ins_by' => $ins_by, 'ins_date_time' => $ins_date_time, 'ins_ip' => $ip, 'ins_application' => $ins_system];
            // Call the function insert Data
            $result = $ccm_query->InsertData($conn, "cpl_compliance_send_alert", $inserted_value);
            if ($result != '1') {
                $cr_status4 = 0;
                $ccm_query->debug("Error in Inserting the data");
            }
        }
    }
}

if ($cr_status1 == 1 && $cr_status2 == 1 && $cr_status3 == 1 && $cr_status4 == 1) {
    $conn->commit();
    echo "Data Inserted Successfully";
} else {
    $conn->rollBack();
    echo "Error in Inserting the data";
}
