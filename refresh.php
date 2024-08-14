<?php
include "classfile/initialize.php";
include "classfile/login.php";

$user_id = $_POST['user_id'];
$total = 0;
$complied = 0;
$expiring = 0;
$expired = 0;
$not_update = 0;
$currentDate = date('d-m-Y');
$todaysRenewal = 0;
$verified = 0;
$pendingVerificaton = 0;
$rejected = 0;

$condition = '';
if ($_SESSION['user_id'] == 'USM-U1') {
  $condition .= " a.fk_sfa_ent_entity_id IN (SELECT pk_sfa_ent_entity_id FROM sfa_ent_mst_entity WHERE pk_sfa_ent_entity_id IN (SELECT kitchen_id FROM cpl_define_kitchen_rights WHERE transaction_status='1')) AND a.fk_cpl_compliancetype_id IN ( SELECT pk_cpl_compliancetype_id FROM cpl_compliance_type WHERE transaction_status='1' AND compliance_type='Compliance') AND a.transaction_status='1'";
} else {
  // get the level of user
  $userLevel = $abc->fetch_data($conn, "usm_add_users", "user_level", "pk_usm_user_id='$_SESSION[user_id]'");


  $condition .= "  a.transaction_status='1' and a.fk_sfa_ent_entity_id IN (SELECT pk_sfa_ent_entity_id FROM sfa_ent_mst_entity WHERE pk_sfa_ent_entity_id IN (SELECT kitchen_id FROM cpl_define_kitchen_rights WHERE ";


  if ($userLevel[0]['user_level'] == 'L1') {
    $condition .= "l1_user='$_SESSION[user_id]' AND transaction_status='1')";
  }
  if ($userLevel[0]['user_level'] == 'L2') {
    $condition .= "l2_user='$_SESSION[user_id]' AND transaction_status='1')";
  }
  if ($userLevel[0]['user_level'] == 'L3') {
    $condition .= "l3_user='$_SESSION[user_id]' AND transaction_status='1')";
  }
  if ($userLevel[0]['user_level'] == 'L4') {
    $condition .= "l4_user='$_SESSION[user_id]' AND transaction_status='1')";
  }

  $condition .= " ) AND a.fk_cpl_compliancetype_id IN ( SELECT pk_cpl_compliancetype_id FROM cpl_compliance_type WHERE transaction_status='1' AND compliance_type='Compliance') AND a.transaction_status='1'";
}

$notCondition = $condition . " AND a.`compliance_applicable`='Yes' AND NOT EXISTS (SELECT * FROM cpl_compliance_master as cm WHERE cm.fk_sfa_ent_entity_id = a.fk_sfa_ent_entity_id AND cm.fk_cpl_compliancetype_id = a.fk_cpl_compliancetype_id) AND transaction_status='1'";
$notUP = $abc->get_row_count_of_table($conn, "cpl_establishment_compliance as a", " * ", $notCondition);
$not_update = $notUP;

$totalCondition = $condition . " AND a.compliance_applicable='Yes'";
$total = $abc->get_row_count_of_table($conn, "cpl_establishment_compliance as a", "* ", $totalCondition);


$pendingCondition = $condition . " AND a.verification_status='0' ";
$pendingVerificaton = $abc->get_row_count_of_table($conn, "cpl_compliance_master as a", "*", $pendingCondition);

$rejectedCondition = $condition . " AND a.verification_status='-1' AND str_to_date(a.ins_date_time,'%d-%m-%Y') >= str_to_date('03-05-2024','%d-%m-%Y')";
$rejected = $abc->get_row_count_of_table($conn, "cpl_compliance_master_hst as a", "*", $rejectedCondition);

$verificatioCondition = $condition . " AND a.verification_status='1'";
$verified = $abc->get_row_count_of_table($conn, "cpl_compliance_master as a", "*", $verificatioCondition);

$expiringSoonCondition = $verificatioCondition . " AND str_to_date(a.`expiry_date`,'%d-%m-%Y') >= str_to_date('$currentDate','%d-%m-%Y') AND str_to_date(a.`renew_due_date_l1`,'%d-%m-%Y') <= str_to_date('$currentDate','%d-%m-%Y')";
$expiring = $abc->get_row_count_of_table($conn, "cpl_compliance_master as a", "*", $expiringSoonCondition);

$compliedCondition = $verificatioCondition . " AND str_to_date(a.`expiry_date`,'%d-%m-%Y') > str_to_date('$currentDate','%d-%m-%Y')  AND str_to_date(a.`renew_due_date_l1`,'%d-%m-%Y') > str_to_date('$currentDate','%d-%m-%Y')";
$complied = $abc->get_row_count_of_table($conn, "cpl_compliance_master as a", "*", $compliedCondition);

$expiredCondition = $verificatioCondition . " AND str_to_date(a.`expiry_date`,'%d-%m-%Y') < str_to_date('$currentDate','%d-%m-%Y')";
$expired = $abc->get_row_count_of_table($conn, "cpl_compliance_master as a", "*", $expiredCondition);

$todaysRenewalCondition = $verificatioCondition . " AND a.renew_due_date_l1 = '$currentDate'";
$todaysRenewal = $abc->get_row_count_of_table($conn, "cpl_compliance_master as a", "*", $todaysRenewalCondition);


$renewalExpiredCondition = $condition . "AND str_to_date(a.`expiry_date`,'%d-%m-%Y') < str_to_date('$currentDate','%d-%m-%Y') AND a.`verification_status`='1'  AND b.`verification_status`='0' ";
$renewalExpired = $abc->get_row_count_of_table($conn, "cpl_compliance_master as a Inner join cpl_compliance_renewal_step2 as b on a.pk_cpl_compliance_id=b.fk_cpl_compliance_id", "a.*", $renewalExpiredCondition);

$renewalExpiringCondition = $condition . "AND str_to_date(a.`expiry_date`,'%d-%m-%Y') >= str_to_date('$currentDate','%d-%m-%Y') AND str_to_date(a.`renew_due_date_l1`,'%d-%m-%Y') < str_to_date('$currentDate','%d-%m-%Y') AND a.`verification_status`='1'  AND b.`verification_status`='0' ";
$renewalExpiring = $abc->get_row_count_of_table($conn, "cpl_compliance_master as a Inner join cpl_compliance_renewal_step2 as b on a.pk_cpl_compliance_id=b.fk_cpl_compliance_id", "a.*", $renewalExpiringCondition);

$_SESSION['total_compliance'] = $total;
$_SESSION['complied'] = $complied;
$_SESSION['expiring'] = $expiring;
$_SESSION['expired'] = $expired;
$_SESSION['not_update'] = $not_update;
$_SESSION['todaysRenewal'] = $todaysRenewal;
$_SESSION['verified'] = $verified;
$_SESSION['pendingVerificaton'] = $pendingVerificaton;
$_SESSION['rejected'] = $rejected;
$_SESSION['renewalExpired'] = $renewalExpired;
$_SESSION['renewalExpiring'] = $renewalExpiring;
