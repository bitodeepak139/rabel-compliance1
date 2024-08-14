<?php
die();
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}
require_once "../../classfile/initialize.php";
require_once "../../classfile/compliance_certificate_management.php";
require_once "../../phphelper.php";
$ins_by = $_SESSION['user_id'];
$ins_date = date('d-m-Y');
$ins_time = date('h:i:s A');
$ins_date_time = date('d-m-Y h:i:s');
$ins_system = 'Web';
$status = 1;
$alert_id = $_POST['alert_id'];
$response_arr = array();


$fetch_data = $ccm_query->fetch_data($conn, "cpl_compliance_send_alert as a left join sfa_ent_mst_entity as b on a.fk_sfa_ent_entity_id=b.pk_sfa_ent_entity_id left join cpl_compliance_type as c on a.fk_cpl_compliancetype_id=c.pk_cpl_compliancetype_id  left join cpl_compliance_master as d on a.fk_cpl_compliance_id=d.pk_cpl_compliance_id left join usm_add_users as e on a.fk_usm_user_id=e.pk_usm_user_id", "a.*,b.entity_name,c.compliance_name,d.expiry_date,e.user_email,e.primary_contact_no as contact_no", "a.pk_comliance_send_alert_id='$alert_id' AND a.whatsapp_send_status='0' AND b.transaction_status='1' AND c.transaction_status='1' AND d.transaction_status='1' AND e.transaction_status='1' ");
if($fetch_data != 0){
    foreach ($fetch_data as $data) {
        $sendmailStatus = 0;
        if ($data['message_level'] == 'L1') {
            $sendMessage = $data['compliance_name'] . ' License of ' . $data['entity_name'] . '(' . $data['fk_sfa_ent_entity_id'] . ')' . ' Kitchen will expire on ' . $data['expiry_date'] . ' date.  Kindly start the renewal Process.';
        } else if ($data['message_level'] == 'L2') {
            if ($data['user_type'] == 'L1') {
                $sendMessage = $data['compliance_name'] . ' License of ' . $data['entity_name'] . '(' . $data['fk_sfa_ent_entity_id'] . ')' . ' Kitchen will expire on ' . $data['expiry_date'] . ' date was not renewed and hence accelerated to L2 user';
            } else if ($data['user_type'] == 'L2') {
                $sendMessage = $data['compliance_name'] . ' License of ' . $data['entity_name'] . '(' . $data['fk_sfa_ent_entity_id'] . ')' . ' Kitchen will expire on ' . $data['expiry_date'] . ' date. Need to renew on priority.';
            }
        } else if ($data['message_level'] == 'L3') {
            if ($data['user_type'] == 'L1' || $data['user_type'] == 'L2') {
                $sendMessage = $data['compliance_name'] . ' License of ' . $data['entity_name'] . '(' . $data['fk_sfa_ent_entity_id'] . ')' . ' Kitchen will expire on ' . $data['expiry_date'] . ' date was not renewed and hence accelerated to L3 user';
            } else if ($data['user_type'] == 'L3') {
                $sendMessage = $data['compliance_name'] . ' License of ' . $data['entity_name'] . '(' . $data['fk_sfa_ent_entity_id'] . ')' . ' Kitchen will expire on ' . $data['expiry_date'] . ' date. Need to renew on priority.';
            }
        } else if ($data['message_level'] == 'L4') {
            if ($data['user_type'] == 'L1' || $data['user_type'] == 'L2' || $data['user_type'] == 'L3') {
                $sendMessage = $data['compliance_name'] . ' License of ' . $data['entity_name'] . '(' . $data['fk_sfa_ent_entity_id'] . ')' . ' Kitchen will expire on ' . $data['expiry_date'] . ' date was not renewed and hence accelerated to L4 user.';
            } else if ($data['user_type'] == 'L4') {
                $sendMessage = $data['compliance_name'] . ' License of ' . $data['entity_name'] . '(' . $data['fk_sfa_ent_entity_id'] . ')' . ' Kitchen will expire on ' . $data['expiry_date'] . ' date.';
            }
        }
        $id = $data['id'];
        $number = $data['contact_no'];
        $send_date = date('d-m-Y');
        $update_date_time = date('d-m-Y h:i:s');
        $send_time = date('h:i:s');

        $whatsapp_msg_status = sendMsg($number, $sendMessage);
        $json = json_decode($whatsapp_msg_status);
        $whatsapp_msg_status = $json->status;
        $whatsapp_msg_statusCode = $json->statusCode;
        $whatsapp_msg_description = $json->description;
    

        $update_whatsapp_send_msg = ['whatsapp_message' => $sendMessage, 'whatsapp_no' => $number, 'whatsapp_send_status' => $whatsapp_msg_statusCode, 'send_whatsapp_msg_type' => 'manually', 'whatsapp_msg_send_date' => $send_date,'whatsapp_msg_send_time'=>$send_time, 'whatsapp_server_response' => $whatsapp_msg_status, 'whatsapp_server_msg_description' => $whatsapp_msg_description, 'update_by' => $ins_by, 'update_date_time' => $update_date_time];
        $ConditionSendAlert = ['id' => $id];
        $result3 = $ccm_query->UpdateData($conn, 'cpl_compliance_send_alert', $update_whatsapp_send_msg, $ConditionSendAlert);
        if($result3 == '1'){
            array_push($response_arr,"true","Whatsapp message sent successfully","#");
        }else{
            array_push($response_arr,"false","Whatsapp message not sent","#");
        }
    }
}else{
    array_push($response_arr,"false","No data found","#");
}
echo json_encode($response_arr);