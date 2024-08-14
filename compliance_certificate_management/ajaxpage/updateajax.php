<?php
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}
require_once "../../classfile/initialize.php";
require_once "../../classfile/compliance_certificate_management.php";
$update_by = $_SESSION['user_id'];
$update_date = date('d-m-Y');
$update_time = date('h:i:s A');
$update_system = 'Web';
$ins_by = $_SESSION['user_id'];
$ins_date_time = date('d-m-Y h:i:s A');
$ins_system = 'Web';
$ins_ip = $abc->get_client_ip();

$status = 1;

if (isset($_POST['isset_update_compliance_certificate_type'])) {
    $id = $_POST['id'];
    $hcompliance_name = trim($_POST['hcompliance_name']);
    $compliance_type = trim($_POST['compliance_type']);
    $compliance_name = trim($_POST['compliance_name']);
    $renewal_type = trim($_POST['renewal_type']);
    $l1_alert_day = trim($_POST['l1_alert_day']);
    $l2_alert_day = trim($_POST['l2_alert_day']);
    $l3_alert_day = trim($_POST['l3_alert_day']);
    $l4_alert_day = trim($_POST['l4_alert_day']);
    $compliance_details = trim($_POST['compliance_details']);
    $response_arr = array();

    if ($compliance_name != '' && $compliance_type != '' && $renewal_type != '' && $l1_alert_day != '' && $l2_alert_day != '' && $l3_alert_day != '' && $l4_alert_day != '') {
        if ($hcompliance_name != $compliance_name) {
            $rowCount = $ccm_query->get_row_count_of_table($conn, "cpl_compliance_type", "*", "compliance_name='$compliance_name' and compliance_type='$compliance_type'");
        } else {
            $rowCount = 0;
        }

        if ($rowCount == 0) {
            $updated_value = ['compliance_type' => $compliance_type, 'compliance_name' => $compliance_name, 'L1Day' => $l1_alert_day, 'L2Day' => $l2_alert_day, 'L3Day' => $l3_alert_day, 'L4Day' => $l4_alert_day, 'renewal_type' => $renewal_type, 'compliance_details' => $compliance_details];

            $Conditions = ['pk_cpl_compliancetype_id' => $id];
            $result = $ccm_query->UpdateData($conn, 'cpl_compliance_type', $updated_value, $Conditions);
            if ($result) {
                array_push($response_arr, 'true', "Certificate Type Updated Successfully", 'ajaxpage/get_data_ajax.php', 'isset_get_ccm_certificate_type', '#datadiv');
            } else {
                array_push($response_arr, 'false', 'Error in Query', '#');
            }
        } else {
            array_push($response_arr, 'false', 'Compliance Name Already Exists!!!', "#");
        }
    } else {
        array_push($response_arr, 'false', 'Please Fill All the Required Fields', '#');
    }
    echo json_encode($response_arr);
}

if (isset($_POST['isset_acceptRejectCertificate'])) {
    $certificate_id = trim($_POST['certificate_id']);
    $remark = trim($_POST['remark']);
    $submissionType = trim($_POST['submissionType']);
    $response_arr = array();
    $verificationStatus = 0;
    if ($submissionType == 'reject') {
        $verificationStatus = -1;
    } else if ($submissionType == 'verify') {
        $verificationStatus = 1;
    }

    if ($submissionType == 'reject' && $remark == '') {
        array_push($response_arr, 'false', 'Please Enter Remark Of Rejection', '#');
    } else {
        $conn->beginTransaction();
        $fetchCompliance = $ccm_query->fetch_data($conn, 'cpl_compliance_master', '*', "pk_cpl_compliance_id='$certificate_id'");
        if ($fetchCompliance != 0) {
            foreach ($fetchCompliance as $v) {
                $inserted_value = ['update_by' => $update_by, 'update_date' => $update_date, 'pk_cpl_compliance_id' => $v['pk_cpl_compliance_id'], 'fk_sfa_ent_entity_id' => $v['fk_sfa_ent_entity_id'], 'fk_cpl_compliancetype_id' => $v['fk_cpl_compliancetype_id'], 'certification_date' => $v['certification_date'], 'certification_organization' => $v['certification_organization'], 'certification_vendor' => $v['certification_vendor'], 'constant_name' => $v['constant_name'], 'consutant_mobile_no' => $v['consutant_mobile_no'], 'certificate_no' => $v['certificate_no'], 'expiry_date' => $v['expiry_date'], 'renew_due_date_l1' => $v['renew_due_date_l1'], 'renew_due_date_l2' => $v['renew_due_date_l2'], 'renew_due_date_l3' => $v['renew_due_date_l3'], 'renew_due_date_l4' => $v['renew_due_date_l4'], 'certificate_file' => $v['certificate_file'], 'licence_nominee' => $v['licence_nominee'], 'next_year_budget' => $v['next_year_budget'], 'certificate_remark' => $v['certificate_remark'], 'verification_status' => $verificationStatus, 'verified_by' => $update_by, 'verification_date' => $update_date, 'verification_remark' => $remark, 'transaction_status' => $v['transaction_status'], 'ins_by' => $v['ins_by'], 'ins_date_time' => $v['ins_date_time'], 'ins_ip' => $v['ins_ip'], 'ins_application' => $v['ins_application']];

                // Call the function insert Data
                $result = $ccm_query->InsertData($conn, "cpl_compliance_master_hst", $inserted_value);
                if ($result !== true) {
                    $conn->rollBack();
                }
            }
        }
        // update the Verification Status
        $statusMsg = '';
        if ($submissionType == 'reject') {
            // $updated_value = ['verification_status' => -1, 'verified_by' => $update_by, 'verification_date' => $update_date, 'verification_remark' => $remark];
            $statusMsg = 'Compliance Rejected Successfully';
            $result = $ccm_query->DeleteData($conn, 'cpl_compliance_master', "", 'pk_cpl_compliance_id', $certificate_id);
        } else if ($submissionType == 'verify') {
            $updated_value = ['verification_status' => 1, 'verified_by' => $update_by, 'verification_date' => $update_date, 'verification_remark' => $remark];
            $statusMsg = 'Compliance Verified Successfully';
            $Conditions = ['pk_cpl_compliance_id' => $certificate_id];
            $result = $ccm_query->UpdateData($conn, 'cpl_compliance_master', $updated_value, $Conditions);
        }

        if ($result === true) {
            $conn->commit();
            array_push($response_arr, 'true', $statusMsg, '#');
        } else {
            
            array_push($response_arr, 'false', 'Error in Query', '#');
        }
    }
    echo json_encode($response_arr);
}

if (isset($_POST['isset_acceptRejectRenewCertificate'])) {
    $renew_id = trim($_POST['renew_id']);
    $remark = trim($_POST['remark']);
    $submissionType = trim($_POST['submissionType']);
    $response_arr = array();

    if ($submissionType == 'reject' && $remark == '') {
        array_push($response_arr, 'false', 'Please Enter Remark Of Rejection', '#');
    } else {
        $conn->beginTransaction();
        if ($submissionType == 'reject') {
            $fetchRenewal = $ccm_query->fetch_data($conn, 'cpl_compliance_renewal_step2', '*', "pk_cpl_compliancestep2_id='$renew_id'");
            if ($fetchRenewal != 0) {

                $renewalAttempt = $fetchRenewal[0]['fk_cpl_complianceattempt_id'];

                $updateAttempt = ['transaction_status' => -1, 'rejectionApprovalBy' => $update_by, 'rejection_date' => $update_date, 'action_date' => $update_date, 'rejection_cause' => $remark];
                $Conditions1 = ['pk_cpl_complianceattempt_id' => $renewalAttempt];
                $result1 = $ccm_query->UpdateData($conn, 'cpl_compliance_renewal_attempts', $updateAttempt, $Conditions1);

                $updated_value = ['verification_status' => -1, 'verified_by' => $update_by, 'verification_date' => $update_date, 'action_date' => $update_date, 'verification_cause' => $remark];
                $Conditions = ['pk_cpl_compliancestep2_id' => $renew_id];
                $result = $ccm_query->UpdateData($conn, 'cpl_compliance_renewal_step2', $updated_value, $Conditions);
                if ($result === true && $result1 === true) {
                    $conn->commit();
                    array_push($response_arr, 'true', 'Renewal Certificate Rejected !!!', '#');
                } else {
                    array_push($response_arr, 'false', 'Error in Query', '#');
                }
            } else {
                array_push($response_arr, 'false', 'No Data Found', '#');
            }
        } else if ($submissionType == 'verify') {

            $fetchRenewal = $ccm_query->fetch_data($conn, 'cpl_compliance_renewal_step2 as a left join cpl_compliance_renewal_attempts as b on a.fk_cpl_complianceattempt_id=b.pk_cpl_complianceattempt_id', 'a.*,b.fk_cpl_compliancetype_id,b.licence_nominee', "pk_cpl_compliancestep2_id='$renew_id'");
            // $ccm_query->debug($fetchRenewal);

            if ($fetchRenewal != 0) {
                $id = $fetchRenewal[0]['fk_cpl_complianceattempt_id'];
                $certificate_id = $fetchRenewal[0]['fk_cpl_compliance_id'];
                $expiry_date = $fetchRenewal[0]['expiry_date'];
                $certificate_type = $fetchRenewal[0]['fk_cpl_compliancetype_id'];
                $licence_nominee = $fetchRenewal[0]['licence_nominee'];

                $certificate_date = $fetchRenewal[0]['certificate_date'];
                $certificate_no = $fetchRenewal[0]['certificate_no'];
                $certificate_file = $fetchRenewal[0]['certificate_file'];
                $certificate_fee_deposited = $fetchRenewal[0]['certificate_fee_deposited'];
                $conveyance_fee = $fetchRenewal[0]['conveyance_fee'];
                $renewal_budget = $certificate_fee_deposited + $conveyance_fee;

                $fetchCompliance = $ccm_query->fetch_data($conn, 'cpl_compliance_master', '*', "pk_cpl_compliance_id='$certificate_id'");

                if ($fetchCompliance != 0) {
                    foreach ($fetchCompliance as $v) {
                        // $ccm_query->debug($v);

                        $inserted_value = ['update_by' => $update_by, 'update_date' => $update_date, 'pk_cpl_compliance_id' => $v['pk_cpl_compliance_id'], 'fk_sfa_ent_entity_id' => $v['fk_sfa_ent_entity_id'], 'fk_cpl_compliancetype_id' => $v['fk_cpl_compliancetype_id'], 'certification_date' => $v['certification_date'], 'licence_nominee' => $v['licence_nominee'], 'certification_organization' => $v['certification_organization'], 'certification_vendor' => $v['certification_vendor'], 'constant_name' => $v['constant_name'], 'consutant_mobile_no' => $v['consutant_mobile_no'], 'certificate_no' => $v['certificate_no'], 'expiry_date' => $v['expiry_date'], 'renew_due_date_l1' => $v['renew_due_date_l1'], 'renew_due_date_l2' => $v['renew_due_date_l2'], 'renew_due_date_l3' => $v['renew_due_date_l3'], 'renew_due_date_l4' => $v['renew_due_date_l4'], 'certificate_file' => $v['certificate_file'], 'next_year_budget' => $v['next_year_budget'], 'certificate_remark' => $v['certificate_remark'], 'verification_status' => $v['verification_status'], 'transaction_status' => $v['transaction_status'], 'ins_by' => $v['ins_by'], 'ins_date_time' => $v['ins_date_time'], 'ins_ip' => $v['ins_ip'], 'ins_application' => $v['ins_application']];

                        // // Call the function insert Data
                        $result = $ccm_query->InsertData($conn, "cpl_compliance_master_hst", $inserted_value);                      
                        if (!$result) {
                            $conn->rollBack();
                            array_push($response_arr, 'false', 'Error in Query of History Table', '#');
                        }

                        $renewalAttempt = $fetchRenewal[0]['fk_cpl_complianceattempt_id'];

                        $updateAttempt = ['transaction_status' => 1, 'rejectionApprovalBy' => $update_by, 'rejection_date' => $update_date, 'action_date' => $update_date, 'rejection_cause' => $remark];
                        $Conditions1 = ['pk_cpl_complianceattempt_id' => $renewalAttempt];
                        $result1 = $ccm_query->UpdateData($conn, 'cpl_compliance_renewal_attempts', $updateAttempt, $Conditions1);

                        $updated_value = ['verification_status' => 1, 'verified_by' => $update_by, 'verification_date' => $update_date, 'action_date' => $update_date, 'verification_cause' => $remark];
                        $Conditions = ['pk_cpl_compliancestep2_id' => $renew_id];
                        $upResult = $ccm_query->UpdateData($conn, 'cpl_compliance_renewal_step2', $updated_value, $Conditions);
                        
                        if (!$upResult && !$result1) {
                            $conn->rollBack();
                            array_push($response_arr, 'false', 'Error in Query', '#');
                        }
                    }
                }

                $fetch_data_due_date = $ccm_query->fetch_data($conn, "cpl_compliance_type", "*", "pk_cpl_compliancetype_id='$certificate_type'");

                if ($fetch_data_due_date != 0) {
                    foreach ($fetch_data_due_date as $dueDate) {
                        $L1Day = '-' . $dueDate['L1Day'] . ' days';
                        $L2Day = '-' . $dueDate['L2Day'] . ' days';
                        $L3Day = '-' . $dueDate['L3Day'] . ' days';
                        $L4Day = -$dueDate['L4Day'] . ' days';
                        $renew_dateL1 = date('d-m-Y', strtotime($expiry_date . $L1Day));
                        $renew_dateL2 = date('d-m-Y', strtotime($expiry_date . $L2Day));
                        $renew_dateL3 = date('d-m-Y', strtotime($expiry_date . $L3Day));
                        $renew_dateL4 = date('d-m-Y', strtotime($expiry_date . $L4Day));
                    }
                }

                $ComplianceRenewal = $ccm_query->fetch_data($conn, "cpl_compliance_renewal_attempts", "*", "pk_cpl_complianceattempt_id='$id'");
                if ($ComplianceRenewal != 0) {
                    $certificate_organization = $ComplianceRenewal[0]['certification_organization'];
                    $certification_vendor = $ComplianceRenewal[0]['certification_vendor'];
                    $constant_name = $ComplianceRenewal[0]['consultant_name'];
                    $consutant_mobile_no = $ComplianceRenewal[0]['consultant_mobile_no'];
                    $nominee = $ComplianceRenewal[0]['licence_nominee'];
                }

                $expiry_date1 = date('d-m-Y', strtotime($expiry_date));
                $updated_compliance_master = ['certification_date' => $certificate_date, 'certification_organization' => $certificate_organization, 'certification_vendor' => $certification_vendor, 'constant_name' => $constant_name, 'consutant_mobile_no' => $consutant_mobile_no, 'certificate_no' => $certificate_no, 'licence_nominee' => $nominee, 'expiry_date' => $expiry_date1, 'renew_due_date_l1' => $renew_dateL1, 'renew_due_date_l2' => $renew_dateL2, 'renew_due_date_l3' => $renew_dateL3, 'renew_due_date_l4' => $renew_dateL4, 'certificate_file' => $certificate_file, 'next_year_budget' => $renewal_budget, 'certificate_remark' => $remark, 'verification_status' => 1, 'transaction_status' => $status, 'ins_by' => $ins_by, 'ins_date_time' => $ins_date_time, 'ins_ip' => $ip, 'ins_application' => $ins_system];
                $ConditionsComplianceMaster = ['pk_cpl_compliance_id' => $certificate_id];

                $result2 = $ccm_query->UpdateData($conn, 'cpl_compliance_master', $updated_compliance_master, $ConditionsComplianceMaster);
                
                if ($result2 === true) {
                    $conn->commit();
                    array_push($response_arr, 'true', "Compliance Certificate Renewal is Successful", '#', 'hide2');
                } else {
                    array_push($response_arr, 'false', 'Error in Query', '#');
                }
            }
            // update the Verification in the Step2 table
            // update the Master table of certificate

        }
    }
    echo json_encode($response_arr);
}

if (isset($_POST['isset_update_compliance_details'])) {
    // $ccm_query->debug($_POST);
    $id = $_POST['id'];
    // $establishmentType = trim($_POST['establishmentType']);
    // $establishment = trim($_POST['establishment']);
    $certificate_type = trim($_POST['certificate_type']);
    $certificate_date = trim($_POST['certificate_date']);
    $certificate_organization = trim($_POST['certificate_organization']);
    $certificate_vendor = trim($_POST['certificate_vendor']);
    $consult_name = trim($_POST['consult_name']);
    $consult_mobile = trim($_POST['consult_mobile']);
    $certificate_no = trim($_POST['certificate_no']);
    $certificate_expire_date = trim($_POST['certificate_expire_date']);
    $licenceNominee = trim($_POST['licenceNominee']);
    $renewal_budget = trim($_POST['renewal_budget']);
    $compliance_details = trim($_POST['compliance_details']);
    $response_arr = array();
    $conn->beginTransaction();
    if ($certificate_type != '' && $certificate_date != '' && $certificate_organization != '' && $certificate_vendor != '' && $consult_name != '' && $consult_mobile != '' && $certificate_no != '' && $certificate_expire_date != '' && $licenceNominee != '' && $renewal_budget != '') {
        // check the certificate no is already exists or not
        $certificateData = $ccm_query->fetch_data($conn, "cpl_compliance_master", "*", "pk_cpl_compliance_id='$id'");
        if ($certificateData != 0) {

            $establishment_DB = $certificateData[0]['fk_sfa_ent_entity_id'];
            $certificate_type_DB = $certificateData[0]['fk_cpl_compliancetype_id'];

            if ($certificate_type_DB == $certificate_type) {
                $rowCount = 0;
            } else {
                $rowCount = $ccm_query->get_row_count_of_table($conn, "cpl_compliance_master", "*", "fk_sfa_ent_entity_id='$establishment_DB' AND fk_cpl_compliancetype_id='$certificate_type'");
            }

            // // check the certificate with exist with same category

            // $ccm_query->debug($rowCount);

            if ($rowCount == 0) {
                // insert data in the history table
                $renew_dateL1 = '';
                $renew_dateL2 = '';
                $renew_dateL3 = '';
                $renew_dateL4 = '';
                $fetch_data_due_date = $ccm_query->fetch_data($conn, "cpl_compliance_type", "*", "pk_cpl_compliancetype_id='$certificate_type'");

                if ($fetch_data_due_date != 0) {
                    foreach ($fetch_data_due_date as $dueDate) {
                        $L1Day = '-' . $dueDate['L1Day'] . ' days';
                        $L2Day = '-' . $dueDate['L2Day'] . ' days';
                        $L3Day = '-' . $dueDate['L3Day'] . ' days';
                        $L4Day = -$dueDate['L4Day'] . ' days';
                        $renew_dateL1 = date('d-m-Y', strtotime($certificate_expire_date . $L1Day));
                        $renew_dateL2 = date('d-m-Y', strtotime($certificate_expire_date . $L2Day));
                        $renew_dateL3 = date('d-m-Y', strtotime($certificate_expire_date . $L3Day));
                        $renew_dateL4 = date('d-m-Y', strtotime($certificate_expire_date . $L4Day));
                    }
                }

                // Enter data in the history table

                $fetchCompliance = $ccm_query->fetch_data($conn, 'cpl_compliance_master', '*', "pk_cpl_compliance_id='$id'");
                if ($fetchCompliance != 0) {
                    foreach ($fetchCompliance as $v) {
                        $inserted_value = ['update_by' => $update_by, 'update_date' => $update_date, 'pk_cpl_compliance_id' => $v['pk_cpl_compliance_id'], 'fk_sfa_ent_entity_id' => $v['fk_sfa_ent_entity_id'], 'fk_cpl_compliancetype_id' => $v['fk_cpl_compliancetype_id'], 'certification_date' => $v['certification_date'], 'certification_organization' => $v['certification_organization'], 'certification_vendor' => $v['certification_vendor'], 'constant_name' => $v['constant_name'], 'consutant_mobile_no' => $v['consutant_mobile_no'], 'certificate_no' => $v['certificate_no'], 'expiry_date' => $v['expiry_date'], 'renew_due_date_l1' => $v['renew_due_date_l1'], 'renew_due_date_l2' => $v['renew_due_date_l2'], 'renew_due_date_l3' => $v['renew_due_date_l3'], 'renew_due_date_l4' => $v['renew_due_date_l4'], 'certificate_file' => $v['certificate_file'], 'next_year_budget' => $v['next_year_budget'], 'certificate_remark' => $v['certificate_remark'], 'verification_status' => $v['verification_status'], 'transaction_status' => $v['transaction_status'], 'ins_by' => $v['ins_by'], 'ins_date_time' => $v['ins_date_time'], 'ins_ip' => $v['ins_ip'], 'ins_application' => $v['ins_application']];

                        // // Call the function insert Data
                        $result = $ccm_query->InsertData($conn, "cpl_compliance_master_hst", $inserted_value);
                        if (!$result) {
                            $conn->rollBack();
                        }
                    }
                }

                // check the file is uploaded or not
                if ($_FILES['ceritificate_upload']['name'] != '') {
                    // if file is uploaded
                    $target_Dir = '../../upload/certificate/';
                    $certi_Name = $sfa_ent->RenameImage('ceritificate_upload');
                    $certi_pdf = $sfa_ent->uploadImage('ceritificate_upload', $certi_Name, $target_Dir, array('PDF', 'pdf'));
                    if ($certi_pdf['status'] == 0) {
                        array_push($response_arr, 'false', $certi_pdf['msg'], '#');
                        echo json_encode($response_arr);
                        die();
                    } else {

                        $updated_value = [
                            'fk_cpl_compliancetype_id' => $certificate_type, 'certification_date' => $certificate_date, 'certification_organization' => $certificate_organization, 'certification_vendor' => $certificate_vendor, 'constant_name' => $consult_name, 'consutant_mobile_no' => $consult_mobile, 'certificate_no' => $certificate_no, 'expiry_date' => $certificate_expire_date, 'renew_due_date_l1' => $renew_dateL1,
                            'renew_due_date_l2' => $renew_dateL2, 'renew_due_date_l3' => $renew_dateL3, 'renew_due_date_l4' => $renew_dateL4, 'certificate_file' => $certi_Name, 'licence_nominee' => $licenceNominee, 'next_year_budget' => $renewal_budget, 'certificate_remark' => $compliance_details, 'transaction_status' => $status, 'update_by' => $update_by, 'update_date_time' => $ins_date_time, 'update_ip' => $ins_ip, 'update_system' => $update_system,
                        ];
                        $Conditions = ['pk_cpl_compliance_id' => $id];

                        $result = $ccm_query->UpdateData($conn, 'cpl_compliance_master', $updated_value, $Conditions);
                        if ($result) {
                            $conn->commit();
                            array_push($response_arr, 'true', 'Compliance Certificate Updated Successfully', '#', '#', '#', "updateComplianceCertificate");
                        } else {
                            array_push($response_arr, 'false', 'Error in Query', '#');
                        }
                    }
                } else {
                    // if file is not uploaded
                    $certificate_file = $certificateData[0]['certificate_file'];

                    $updated_value = [
                        'fk_cpl_compliancetype_id' => $certificate_type, 'certification_date' => $certificate_date, 'certification_organization' => $certificate_organization, 'certification_vendor' => $certificate_vendor, 'constant_name' => $consult_name, 'consutant_mobile_no' => $consult_mobile, 'certificate_no' => $certificate_no, 'expiry_date' => $certificate_expire_date, 'renew_due_date_l1' => $renew_dateL1,
                        'renew_due_date_l2' => $renew_dateL2, 'renew_due_date_l3' => $renew_dateL3, 'renew_due_date_l4' => $renew_dateL4, 'licence_nominee' => $licenceNominee, 'next_year_budget' => $renewal_budget, 'certificate_remark' => $compliance_details, 'transaction_status' => $status, 'update_by' => $update_by, 'update_date_time' => $ins_date_time, 'update_ip' => $ins_ip, 'update_system' => $update_system,
                    ];
                    $Conditions = ['pk_cpl_compliance_id' => $id];

                    $result = $ccm_query->UpdateData($conn, 'cpl_compliance_master', $updated_value, $Conditions);
                    if ($result) {
                        $conn->commit();
                        array_push($response_arr, 'true', 'Compliance Certificate Updated Successfully', '#', '#', '#', "updateComplianceCertificate");
                    } else {
                        array_push($response_arr, 'false', 'Error in Query', '#');
                    }
                }
            } else {
                array_push($response_arr, 'false', 'Certificate Already Exists', '#');
            }
        } else {
            array_push($response_arr, 'false', 'No Record Found', '#');
        }
    } else {
        if ($establishmentType == '') {
            array_push($response_arr, 'false', 'Please Select Establishment Type', '#');
        } else if ($establishment == '') {
            array_push($response_arr, 'false', 'Please Select Establishment', '#');
        } else if ($certificate_type == '') {
            array_push($response_arr, 'false', 'Please Select Certificate Type', '#');
        } else if ($certificate_date == '') {
            array_push($response_arr, 'false', 'Please Select Certificate Date', '#');
        } else if ($certificate_organization == '') {
            array_push($response_arr, 'false', 'Please Enter Certificate Organization', '#');
        } else if ($certificate_vendor == '') {
            array_push($response_arr, 'false', 'Please Enter Certificate Vendor', '#');
        } else if ($consult_name == '') {
            array_push($response_arr, 'false', 'Please Enter Consultant Name', '#');
        } else if ($consult_mobile == '') {
            array_push($response_arr, 'false', 'Please Enter Consultant Mobile No', '#');
        } else if ($certificate_no == '') {
            array_push($response_arr, 'false', 'Please Enter Certificate No', '#');
        } else if ($certificate_expire_date == '') {
            array_push($response_arr, 'false', 'Please Select Certificate Expire Date', '#');
        } else if ($licenceNominee == '') {
            array_push($response_arr, 'false', 'Please Enter Licence Nominee', '#');
        } else if ($renewal_budget == '') {
            array_push($response_arr, 'false', 'Please Enter Renewal Budget', '#');
        }
    }
    echo json_encode($response_arr);
}
