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

if (isset($_POST['isset_add_compliance_certificate_type'])) {
    $compliance_name = trim($_POST['compliance_name']);
    $compliance_type = trim($_POST['compliance_type']);
    $renewal_type = trim($_POST['renewal_type']);
    $l1_alert_day = trim($_POST['l1_alert_day']);
    $l2_alert_day = trim($_POST['l2_alert_day']);
    $l3_alert_day = trim($_POST['l3_alert_day']);
    $l4_alert_day = trim($_POST['l4_alert_day']);
    $compliance_details = trim($_POST['compliance_details']);
    $response_arr = array();

    if ($compliance_name != '' && $compliance_type != '' && $renewal_type != '' && $l1_alert_day != '' && $l2_alert_day != '' && $l3_alert_day != '' && $l4_alert_day != '') {
        $rowCount = $ccm_query->get_row_count_of_table($conn, "cpl_compliance_type", "*", "compliance_name='$compliance_name' and compliance_type='$compliance_type'");
        if ($rowCount == 0) {
            $inserted_value = ['compliance_type' => $compliance_type, 'compliance_name' => $compliance_name, 'L1Day' => $l1_alert_day, 'L2Day' => $l2_alert_day, 'L3Day' => $l3_alert_day, 'L4Day' => $l4_alert_day, 'renewal_type' => $renewal_type, 'compliance_details' => $compliance_details, 'transaction_status' => $status, 'ins_by' => $ins_by, 'ins_date_time' => $ins_date_time, 'ins_ip' => $ip, 'ins_application' => $ins_system];

            // Call the function insert Data
            $result = $ccm_query->InsertData($conn, "cpl_compliance_type", $inserted_value);
            if ($result) {
                array_push($response_arr, 'true', "Certificate Type Add Successfully", 'ajaxpage/get_data_ajax.php', 'isset_get_ccm_certificate_type', '#datadiv');
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

if (isset($_POST['isset_mapestablishment_certificate'])) {
    $applicable = trim($_POST['applicable']);
    $compliance_name = trim($_POST['compliance_name']);
    $complianceTypeID = trim($_POST['complianceTypeID']);
    $EntityId = trim($_POST['EntityId']);
    $userL1 = trim($_POST['userL1']);
    $userL2 = trim($_POST['userL2']);
    $userL3 = trim($_POST['userL3']);
    $userL4 = trim($_POST['userL4']);
    $response_arr = array();
    $conn->beginTransaction();
    $rowCount = $ccm_query->get_row_count_of_table($conn, "cpl_establishment_compliance", "*", "fk_sfa_ent_entity_id='$EntityId' AND fk_cpl_compliancetype_id='$complianceTypeID'");

    if ($rowCount == 0) {

        // select the compliance type
        $fetch_data = $ccm_query->fetch_data($conn, "cpl_compliance_type", "*", "pk_cpl_compliancetype_id='$complianceTypeID'");
        if ($fetch_data != 0) {
            $renewal_type = $fetch_data[0]['renewal_type'];
            if ($renewal_type == 'One Time') {
                if ($applicable == 'Yes') {
                    // Insert data in Compliance Table
                    $inserted_compliance = ['fk_sfa_ent_entity_id' => $EntityId, 'fk_cpl_compliancetype_id' => $complianceTypeID, 'compliance_applicable' => $applicable, 'transaction_status' => $status, 'ins_by' => $ins_by, 'ins_date_time' => $ins_date_time, 'ins_ip' => $ip, 'ins_application' => $ins_system];
                    $result_compliance = $ccm_query->InsertData($conn, "cpl_establishment_compliance", $inserted_compliance);
                    if (!$result_compliance) {
                        $conn->rollback();
                        array_push($response_arr, "false", "Some Error Occured", "#");
                    } else {
                        $conn->commit();
                        array_push($response_arr, "true", "Establishment Certificate Detail add Successfully", "#");
                    }
                } else {
                    array_push($response_arr, "false", "Please Check the Applicable Checkbox", "#");
                }
            } else if ($renewal_type == 'Renewal') {
                if ($applicable == 'Yes') {
                    if ($userL1 != '' && $userL2 != '' && $userL3 != '' && $userL4 != '') {
                        $userL1 = explode(",", $_POST['userL1']);
                        $userL2 = explode(",", $_POST['userL2']);
                        $userL3 = explode(",", $_POST['userL3']);
                        $userL4 = explode(",", $_POST['userL4']);

                        // // Insert data in Compliance Table
                        $inserted_compliance = ['fk_sfa_ent_entity_id' => $EntityId, 'fk_cpl_compliancetype_id' => $complianceTypeID, 'compliance_applicable' => $applicable, 'transaction_status' => $status, 'ins_by' => $ins_by, 'ins_date_time' => $ins_date_time, 'ins_ip' => $ip, 'ins_application' => $ins_system];
                        $result_compliance = $ccm_query->InsertData($conn, "cpl_establishment_compliance", $inserted_compliance);
                        if (!$result_compliance) {
                            $conn->rollback();
                            array_push($response_arr, "false", "Some Error Occured", "#");
                        }

                        if (isset($_POST['userL1'])) {
                            $alluserL1 = $userL1;
                            foreach ($alluserL1 as $singleuserL1) {
                                // Insert data in User  Table
                                $insert_cpl_user = ['fk_sfa_ent_entity_id' => $EntityId, 'fk_cpl_compliancetype_id' => $complianceTypeID, 'empId' => $singleuserL1, 'transaction_status' => $status, 'ins_by' => $ins_by, 'ins_date_time' => $ins_date_time, 'ins_ip' => $ip, 'ins_application' => $ins_system];
                                $result_user = $ccm_query->InsertData($conn, "cpl_establishment_compliance_users", $insert_cpl_user);
                                if (!$result_user) {
                                    $conn->rollback();
                                    array_push($response_arr, "false", "Some Error Occured", "#");
                                }
                            }
                        }
                        if (isset($_POST['userL2'])) {
                            $alluserL2 = $userL2;
                            foreach ($alluserL2 as $singleuserL2) {
                                // Insert data in User  Table
                                $insert_cpl_user2 = ['fk_sfa_ent_entity_id' => $EntityId, 'fk_cpl_compliancetype_id' => $complianceTypeID, 'empId' => $singleuserL2, 'transaction_status' => $status, 'ins_by' => $ins_by, 'ins_date_time' => $ins_date_time, 'ins_ip' => $ip, 'ins_application' => $ins_system];
                                $result_user = $ccm_query->InsertData($conn, "cpl_establishment_compliance_users", $insert_cpl_user2);
                                if (!$result_user) {
                                    $conn->rollback();
                                    array_push($response_arr, "false", "Some Error Occured", "#");
                                }
                            }
                        }
                        if (isset($_POST['userL3'])) {
                            $alluserL3 = $userL3;
                            foreach ($alluserL3 as $singleuserL3) {
                                // Insert data in User  Table
                                $insert_cpl_user3 = ['fk_sfa_ent_entity_id' => $EntityId, 'fk_cpl_compliancetype_id' => $complianceTypeID, 'empId' => $singleuserL3, 'transaction_status' => $status, 'ins_by' => $ins_by, 'ins_date_time' => $ins_date_time, 'ins_ip' => $ip, 'ins_application' => $ins_system];
                                $result_user = $ccm_query->InsertData($conn, "cpl_establishment_compliance_users", $insert_cpl_user3);
                                if (!$result_user) {
                                    $conn->rollback();
                                    array_push($response_arr, "false", "Some Error Occured", "#");
                                }
                            }
                        }
                        if (isset($_POST['userL4'])) {
                            $alluserL4 = $userL4;
                            foreach ($alluserL4 as $singleuserL4) {

                                // Insert data in User  Table
                                $insert_cpl_user4 = ['fk_sfa_ent_entity_id' => $EntityId, 'fk_cpl_compliancetype_id' => $complianceTypeID, 'empId' => $singleuserL4, 'transaction_status' => $status, 'ins_by' => $ins_by, 'ins_date_time' => $ins_date_time, 'ins_ip' => $ip, 'ins_application' => $ins_system];
                                $result_user = $ccm_query->InsertData($conn, "cpl_establishment_compliance_users", $insert_cpl_user4);
                                if (!$result_user) {
                                    $conn->rollback();
                                    array_push($response_arr, "false", "Some Error Occured", "#");
                                }
                            }
                        }

                        $conn->commit();
                        array_push($response_arr, "true", "Establishment Certificate Detail add Successfully", "#");
                    } else {
                        if ($userL1 == '') {
                            array_push($response_arr, "false", "Please Select the User L1", "#");
                        } else if ($userL2 == '') {
                            array_push($response_arr, "false", "Please Select the User L2", "#");
                        } else if ($userL3 == '') {
                            array_push($response_arr, "false", "Please Select the User L3", "#");
                        } else if ($userL4 == '') {
                            array_push($response_arr, "false", "Please Select the User L4", "#");
                        }
                    }
                } else {
                    array_push($response_arr, "false", "Please Check the Applicable Checkbox", "#");
                }
            } else {
                array_push($response_arr, "false", "Some Error Occured", "#");
            }
        } else {
            array_push($response_arr, "false", "Invalid Compliance type", "#");
        }
    } else {

        $fetch_compliance_data = $ccm_query->fetch_data($conn, 'cpl_establishment_compliance as a left join cpl_compliance_type as b on a.fk_cpl_compliancetype_id=b.pk_cpl_compliancetype_id', "a.*,b.renewal_type", "a.fk_sfa_ent_entity_id='$EntityId' AND a.fk_cpl_compliancetype_id='$complianceTypeID'");

        if ($fetch_compliance_data != 0) {
            $pk_cpl_establishmentcompliance_id = $fetch_compliance_data[0]["pk_cpl_establishmentcompliance_id"];

            if ($fetch_compliance_data[0]["renewal_type"] == 'One Time') {
                // Insert in History Table
                foreach ($fetch_compliance_data as $single_comp) {

                    $inserted_value_hst = ['fk_sfa_ent_entity_id' => $single_comp['fk_sfa_ent_entity_id'], 'fk_cpl_compliancetype_id' => $single_comp['fk_cpl_compliancetype_id'], 'compliance_applicable' => $single_comp['compliance_applicable'], 'transaction_status' => $single_comp['transaction_status'], 'ins_by' => $single_comp['ins_by'], 'ins_date_time' => $single_comp['ins_date_time'], 'ins_ip' => $single_comp['ins_ip'], 'ins_application' => $single_comp['ins_application']];
                    $result_comp_hst = $ccm_query->InsertData($conn, "cpl_establishment_compliance_hst", $inserted_value_hst);
                    if (!$result_comp_hst) {
                        $conn->rollback();
                        array_push($response_arr, "false", "Some Error Occured", "#");
                    }
                }

                // update in compliance table
                $updated_comp_value = ['compliance_applicable' => $applicable, 'transaction_status' => $status, 'ins_by' => $ins_by, 'ins_date_time' => $ins_date_time, 'ins_ip' => $ip, 'ins_application' => $ins_system];

                $Conditions_comp = ['pk_cpl_establishmentcompliance_id' => $pk_cpl_establishmentcompliance_id];
                $result_update_comp = $ccm_query->UpdateData($conn, 'cpl_establishment_compliance', $updated_comp_value, $Conditions_comp);
                if (!$result_update_comp) {
                    $conn->rollback();
                    array_push($response_arr, "false", "Some Error Occured", "#");
                } else {
                    $conn->commit();
                    array_push($response_arr, "true", "Establishment Certificate Detail Update Successfully", "#");
                }
            } else if ($fetch_compliance_data[0]["renewal_type"] == 'Renewal') {
                if ($userL1 != '' && $userL2 != '' && $userL3 != '' && $userL4 != '') {
                    $userL1 = explode(",", $_POST['userL1']);
                    $userL2 = explode(",", $_POST['userL2']);
                    $userL3 = explode(",", $_POST['userL3']);
                    $userL4 = explode(",", $_POST['userL4']);

                    // Insert in History Table
                    foreach ($fetch_compliance_data as $single_comp) {

                        $inserted_value_hst = ['fk_sfa_ent_entity_id' => $single_comp['fk_sfa_ent_entity_id'], 'fk_cpl_compliancetype_id' => $single_comp['fk_cpl_compliancetype_id'], 'compliance_applicable' => $single_comp['compliance_applicable'], 'transaction_status' => $single_comp['transaction_status'], 'ins_by' => $single_comp['ins_by'], 'ins_date_time' => $single_comp['ins_date_time'], 'ins_ip' => $single_comp['ins_ip'], 'ins_application' => $single_comp['ins_application']];
                        $result_comp_hst = $ccm_query->InsertData($conn, "cpl_establishment_compliance_hst", $inserted_value_hst);
                        if (!$result_comp_hst) {
                            $conn->rollback();
                            array_push($response_arr, "false", "Some Error Occured", "#");
                        }
                    }

                    // update in compliance table
                    $updated_comp_value = ['compliance_applicable' => $applicable, 'transaction_status' => $status, 'ins_by' => $ins_by, 'ins_date_time' => $ins_date_time, 'ins_ip' => $ip, 'ins_application' => $ins_system];

                    $Conditions_comp = ['pk_cpl_establishmentcompliance_id' => $pk_cpl_establishmentcompliance_id];
                    $result_update_comp = $ccm_query->UpdateData($conn, 'cpl_establishment_compliance', $updated_comp_value, $Conditions_comp);
                    if (!$result_update_comp) {
                        $conn->rollback();
                        array_push($response_arr, "false", "Some Error Occured", "#");
                    }

                    $fetch_data_comp_user = $ccm_query->fetch_data($conn, "cpl_establishment_compliance_users", "*", "fk_sfa_ent_entity_id='$EntityId' AND fk_cpl_compliancetype_id='$complianceTypeID'");

                    if ($fetch_data_comp_user != 0) {
                        // Insert data in User History Table
                        foreach ($fetch_data_comp_user as $single_user) {

                            $insert_cpl_user_hst = ['fk_sfa_ent_entity_id' => $single_user['fk_sfa_ent_entity_id'], 'fk_cpl_compliancetype_id' => $single_user['fk_cpl_compliancetype_id'], 'empId' => $single_user['empId'], 'transaction_status' => $single_user['transaction_status'], 'ins_by' => $single_user['ins_by'], 'ins_date_time' => $single_user['ins_date_time'], 'ins_ip' => $single_user['ins_ip'], 'ins_application' => $single_user['ins_application']];
                            $result_user_hst = $ccm_query->InsertData($conn, "cpl_establishment_compliance_users_hst", $insert_cpl_user_hst);

                            if (!$result_user_hst) {
                                $conn->rollback();
                                array_push($response_arr, "false", "Some Error Occured", "#");
                            }

                            $delete_comp = $ccm_query->DeleteData($conn, "cpl_establishment_compliance_users", '', "pk_cpl_establishmentcompliance_user_id", "$single_user[pk_cpl_establishmentcompliance_user_id]");
                            if (!$delete_comp) {
                                $conn->rollback();
                                array_push($response_arr, "false", "Some Error Occured", "#");
                            }
                        }
                    }

                    if (isset($_POST['userL1'])) {
                        $alluserL1 = $userL1;
                        foreach ($alluserL1 as $singleuserL1) {
                            // Insert data in User  Table
                            $insert_cpl_user = ['fk_sfa_ent_entity_id' => $EntityId, 'fk_cpl_compliancetype_id' => $complianceTypeID, 'empId' => $singleuserL1, 'transaction_status' => $status, 'ins_by' => $ins_by, 'ins_date_time' => $ins_date_time, 'ins_ip' => $ip, 'ins_application' => $ins_system];
                            $result_user = $ccm_query->InsertData($conn, "cpl_establishment_compliance_users", $insert_cpl_user);
                            if (!$result_user) {
                                $conn->rollback();
                                array_push($response_arr, "false", "Some Error Occured", "#");
                            }
                        }
                    }
                    if (isset($_POST['userL2'])) {
                        $alluserL2 = $userL2;

                        foreach ($alluserL2 as $singleuserL2) {
                            // Insert data in User  Table
                            $insert_cpl_user2 = ['fk_sfa_ent_entity_id' => $EntityId, 'fk_cpl_compliancetype_id' => $complianceTypeID, 'empId' => $singleuserL2, 'transaction_status' => $status, 'ins_by' => $ins_by, 'ins_date_time' => $ins_date_time, 'ins_ip' => $ip, 'ins_application' => $ins_system];
                            $result_user = $ccm_query->InsertData($conn, "cpl_establishment_compliance_users", $insert_cpl_user2);
                            if (!$result_user) {
                                $conn->rollback();
                                array_push($response_arr, "false", "Some Error Occured", "#");
                            }
                        }
                    }
                    if (isset($_POST['userL3'])) {
                        $alluserL3 = $userL3;

                        foreach ($alluserL3 as $singleuserL3) {
                            // Insert data in User  Table
                            $insert_cpl_user3 = ['fk_sfa_ent_entity_id' => $EntityId, 'fk_cpl_compliancetype_id' => $complianceTypeID, 'empId' => $singleuserL3, 'transaction_status' => $status, 'ins_by' => $ins_by, 'ins_date_time' => $ins_date_time, 'ins_ip' => $ip, 'ins_application' => $ins_system];
                            $result_user = $ccm_query->InsertData($conn, "cpl_establishment_compliance_users", $insert_cpl_user3);
                            if (!$result_user) {
                                $conn->rollback();
                                array_push($response_arr, "false", "Some Error Occured", "#");
                            }
                        }
                    }
                    if (isset($_POST['userL4'])) {
                        $alluserL4 = $userL4;

                        foreach ($alluserL4 as $singleuserL4) {
                            // Insert data in User  Table
                            $insert_cpl_user4 = ['fk_sfa_ent_entity_id' => $EntityId, 'fk_cpl_compliancetype_id' => $complianceTypeID, 'empId' => $singleuserL4, 'transaction_status' => $status, 'ins_by' => $ins_by, 'ins_date_time' => $ins_date_time, 'ins_ip' => $ip, 'ins_application' => $ins_system];
                            $result_user = $ccm_query->InsertData($conn, "cpl_establishment_compliance_users", $insert_cpl_user4);
                            if (!$result_user) {
                                $conn->rollback();
                                array_push($response_arr, "false", "Some Error Occured", "#");
                            }
                        }
                    }
                    $conn->commit();
                    array_push($response_arr, "true", "Establishment Certificate Detail Update Successfully", "#");
                } else {
                    if ($userL1 == '') {
                        array_push($response_arr, "false", "Please Select the User L1", "#");
                    } else if ($userL2 == '') {
                        array_push($response_arr, "false", "Please Select the User L2", "#");
                    } else if ($userL3 == '') {
                        array_push($response_arr, "false", "Please Select the User L3", "#");
                    } else if ($userL4 == '') {
                        array_push($response_arr, "false", "Please Select the User L4", "#");
                    }
                }
            }
        }
    }
    echo json_encode($response_arr);
}

if (isset($_POST["isset_cpl_add_compliance_certificate"])) {
    $establishmentType = trim($_POST['establishmentType']);
    $establishment = trim($_POST['establishment']);
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

    if ($establishmentType != '' && $establishment != '' && $certificate_type != '' && $certificate_date != '' && $certificate_organization != '' && $certificate_vendor != '' && $certificate_no != '' && $certificate_expire_date != '' && $renewal_budget != '' && $licenceNominee != '') {
        if ($_FILES['ceritificate_upload']['name'] != '') {
            $entity_arr = explode("-", $establishment);
            $entity_type_id = $entity_arr[0];
            $rowCount = $ccm_query->get_row_count_of_table($conn, "cpl_compliance_master", "*", "fk_sfa_ent_entity_id='$entity_type_id' AND fk_cpl_compliancetype_id='$certificate_type' AND verification_status='1'");
            if ($rowCount == 0) {

                $rowCount1 = $ccm_query->get_row_count_of_table($conn, "cpl_compliance_master", "*", "fk_sfa_ent_entity_id='$entity_type_id' AND fk_cpl_compliancetype_id='$certificate_type' AND verification_status='0'");
                if ($rowCount1 == 0) {
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

                    // $logoName = '';
                    // if ($_FILES['logo']['name'] != '') {
                    $target_Dir = '../../upload/certificate/';
                    $certi_Name = $sfa_ent->RenameImage('ceritificate_upload');
                    $certi_pdf = $sfa_ent->uploadImage('ceritificate_upload', $certi_Name, $target_Dir, array('PDF', 'pdf'));
                    if ($certi_pdf['status'] == 0) {
                        array_push($response_arr, 'false', $certi_pdf['msg'], '#');
                        echo json_encode($response_arr);
                        die();
                    } else {

                        $inserted_value = ['fk_sfa_ent_entity_id' => $entity_type_id, 'fk_cpl_compliancetype_id' => $certificate_type, 'certification_date' => $certificate_date, 'certification_organization' => $certificate_organization, 'certification_vendor' => $certificate_vendor, 'constant_name' => $consult_name, 'consutant_mobile_no' => $consult_mobile, 'certificate_no' => $certificate_no, 'expiry_date' => $certificate_expire_date, 'renew_due_date_l1' => $renew_dateL1, 'renew_due_date_l2' => $renew_dateL2, 'renew_due_date_l3' => $renew_dateL3, 'renew_due_date_l4' => $renew_dateL4, 'certificate_file' => $certi_Name, 'licence_nominee' => $licenceNominee, 'next_year_budget' => $renewal_budget, 'certificate_remark' => $compliance_details, 'verification_status' => 0, 'transaction_status' => $status, 'ins_by' => $ins_by, 'ins_date_time' => $ins_date_time, 'ins_ip' => $ip, 'ins_application' => $ins_system];

                        // // Call the function insert Data
                        $result = $ccm_query->InsertData($conn, "cpl_compliance_master", $inserted_value);
                        if ($result) {
                            array_push($response_arr, 'true', "Certificate  Add Successfully", '#');
                        } else {
                            array_push($response_arr, 'false', 'Error in Query', '#');
                        }
                    }
                    // }
                } else {
                    array_push($response_arr, 'false', 'Compliance Certificate in Pending Status. Kindly Contact to Admin For Approval', "#");
                }
            } else {
                array_push($response_arr, 'false', 'Compliance Certificate Already Exists!!!', "#");
            }
        } else {
            array_push($response_arr, 'false', 'Please Upload the Certificate in PDF Format', '#');
        }
    } else {
        if ($establishmentType == '') {
            array_push($response_arr, 'false', 'Please Select The Establishment Type', '#');
        } else if ($establishment == '') {
            array_push($response_arr, 'false', 'Please Select the Establishment', '#');
        } else if ($certificate_type == '') {
            array_push($response_arr, 'false', 'Please Select the Certificate', '#');
        } else if ($certificate_date == '') {
            array_push($response_arr, 'false', 'Please Enter the Certificate Date', '#');
        } else if ($certificate_organization == '') {
            array_push($response_arr, 'false', 'Please Select Organization ', '#');
        } else if ($certificate_vendor == '') {
            array_push($response_arr, 'false', 'Please Select Certificate Vendor', '#');
        } else if ($certificate_no == '') {
            array_push($response_arr, 'false', 'Please Enter Certificate No', '#');
        } else if ($certificate_expire_date == '') {
            array_push($response_arr, 'false', 'Please Enter Expiry Date', '#');
        } else if ($renewal_budget == '') {
            array_push($response_arr, 'false', 'Please Enter Renewal Budget', '#');
        }
    }

    echo json_encode($response_arr);
}

if (isset($_POST['isset_addRenewalComplianceCertificateStep1'])) {
    $entity_type_id = trim($_POST['entity_type_id']);
    $compliance_type = trim($_POST['compliance_type_id']);
    $application_date = trim($_POST['application_date']);
    $compliance_id = trim($_POST['pk_compliance']);
    $application_reference_no = trim($_POST['application_reference_no']);
    $application_by = trim($_POST['application_by']);
    $certificate_organization = trim($_POST['certificate_organization']);
    $certificate_vendor = trim($_POST['certificate_vendor']);
    $consultant_name = trim($_POST['consultant_name']);
    $consultant_mobile = trim($_POST['consultant_mobile']);
    $fee_deposited = trim($_POST['fee_deposited']);
    $conveyance_fee = trim($_POST['conveyance_fee']);
    $tatal_amount = trim($_POST['total_amount']);
    $estimated_date = trim($_POST['estimate_date']);
    $remark = trim($_POST['remark']);
    $licence_nominee = trim($_POST['licence_nominee']);
    $response_arr = array();

    if ($application_date != '' && $application_reference_no != '' && $application_by != '' && $certificate_organization != '' && $certificate_vendor != '' && $fee_deposited != '' && $conveyance_fee != '' && $tatal_amount != '' && $licence_nominee != '') {

        if ($_FILES['application_form']['name'] != '') {

            $target_Dir = '../../upload/renewal/';
            $certi_Name = $sfa_ent->RenameImage('application_form');
            $certi_pdf = $sfa_ent->uploadImage('application_form', $certi_Name, $target_Dir, array('PDF', 'pdf'));
            if ($certi_pdf['status'] == 0) {
                array_push($response_arr, 'false', $certi_pdf['msg'], '#');
                echo json_encode($response_arr);
                die();
            } else {

                $inserted_value = [
                    'fk_sfa_ent_entity_id' => $entity_type_id,
                    'fk_cpl_compliance_id' => $compliance_id, // 'pk_cpl_compliance_id
                    'fk_cpl_compliancetype_id' => $compliance_type,
                    'application_date' => $application_date,
                    'application_by' => $application_by,
                    'application_reference_no' => $application_reference_no,
                    'application_form_file' => $certi_Name,
                    'licence_nominee' => $licence_nominee, // 'licence_nominee' => $licence_nominee,
                    'certification_organization' => $certificate_organization,
                    'certification_vendor' => $certificate_vendor,
                    'consultant_name' => $consultant_name,
                    'consultant_mobile_no' => $consultant_mobile,
                    'certification_cost' => $fee_deposited,
                    'convinience_fee' => $conveyance_fee,
                    'estimated_confirmation_date' => $estimated_date,
                    'enter_remark' => $remark,
                    'transaction_status' => 0,
                    'ins_by' => $ins_by,
                    'ins_date_time' => $ins_date_time,
                    'ins_ip' => $ip,
                    'ins_application' => $ins_system,
                ];

                $result = $ccm_query->InsertData($conn, "cpl_compliance_renewal_attempts", $inserted_value);
                if ($result) {
                    array_push($response_arr, 'true', "Renewal Process 1 Completed Successfully", '#', 'hide');
                } else {
                    array_push($response_arr, 'false', 'Error in Query', '#');
                }
            }
        } else {
            array_push($response_arr, 'false', 'Please Upload the Form in PDF Format', '#');
        }
    } else {
        if ($application_date == '') {
            array_push($response_arr, 'false', 'Please Enter the Application Date', '#');
        } else if ($application_reference_no == '') {
            array_push($response_arr, 'false', 'Please Enter the Reference No', '#');
        } else if ($application_by == '') {
            array_push($response_arr, 'false', 'Please Enter the Applicant Name', '#');
        } else if ($certificate_organization == '') {
            array_push($response_arr, 'false', 'Please Select Certificate Organisation', '#');
        } else if ($certificate_vendor == '') {
            array_push($response_arr, 'false', 'Please Select the Certificate Vendor', '#');
        } else if ($fee_deposited == '') {
            array_push($response_arr, 'false', 'Please Enter Certificate Fee Deposit', '#');
        } else if ($conveyance_fee == '') {
            array_push($response_arr, 'false', 'Please Enter Conveyance Fee', '#');
        } else if ($licence_nominee == '') {
            array_push($response_arr, 'false', 'Please Enter Licence Nominee', '#');
        }
    }

    echo json_encode($response_arr);
}

if (isset($_POST['isset_addRenewalComplianceCertificateStep2'])) {
    $id = trim($_POST['compliance_renewal_id']);
    $master_id = trim($_POST['compliance_masterid']);
    $certificate_type = trim($_POST['compliance_type_id']);
    $renewal_status = trim($_POST['renewal_status']);
    $rejected_date = trim($_POST['rejected_date']);
    $rejection_remark = trim($_POST['rejection_remark']);
    $certificate_date = trim($_POST['certificate_date']);
    $certificate_fee_deposited = trim($_POST['certificate_fee_deposited']);
    $conveyance_fee = trim($_POST['conveyance_fee']);
    $certificate_no = trim($_POST['certificate_no']);
    $expiry_date = trim($_POST['expiry_date']);
    $entity_type_id = trim($_POST['kitchen_id']);
    $renewal_budget = trim($_POST['renewal_budget']);
    $remark = trim($_POST['remark']);

    // $ccm_query->debug($_POST);

    $response_arr = array();
    if ($renewal_status != '') {
        if ($renewal_status == 'rejected') {
            if ($rejected_date != '' && $rejection_remark != '') {
                $updated_value = ['action_date' => $ins_date_time, 'rejection_date' => $rejected_date, 'rejection_cause' => $rejection_remark, 'transaction_status' => -1];
                $Conditions = ['pk_cpl_complianceattempt_id' => $id];
                $result = $ccm_query->UpdateData($conn, 'cpl_compliance_renewal_attempts', $updated_value, $Conditions);
                if ($result) {
                    array_push($response_arr, 'true', 'Compliance Renewal Rejected', '#', 'hide2');
                } else {
                    array_push($response_arr, 'false', 'Oops! Something went wrong', '#');
                }
            } else {
                if ($rejected_date == '') {
                    array_push($response_arr, 'false', 'Please Enter Rejection Date', '#');
                } else if ($rejection_remark == '') {
                    array_push($response_arr, 'false', 'Please Enter Rejection Remark', '#');
                }
            }
        } else if ($renewal_status == 'confirmed') {
            if ($certificate_date != '' && $certificate_no != '' && $expiry_date != '' && $renewal_budget != '' && $remark != '') {
                if ($_FILES['ceritificate_upload']['name'] != '') {
                    $target_Dir = '../../upload/certificate/';
                    $certi_Name = $sfa_ent->RenameImage('ceritificate_upload');
                    $certi_pdf = $sfa_ent->uploadImage('ceritificate_upload', $certi_Name, $target_Dir, array('PDF', 'pdf'));
                    if ($certi_pdf['status'] == 0) {
                        array_push($response_arr, 'false', $certi_pdf['msg'], '#');
                        echo json_encode($response_arr);
                        die();
                    } else {

                        $conn->beginTransaction();

                        // fetch the compliance type from attempt table
                        $fetch_data = $ccm_query->fetch_data($conn, "cpl_compliance_renewal_attempts", "*", "pk_cpl_complianceattempt_id='$id'");
                        if ($fetch_data != 0) {
                            $certificate_type = $fetch_data[0]['fk_cpl_compliancetype_id'];
                        }

                        // create the primary key
                        $pk_cpl_compliancestep2_id_row = $ccm_query->fetch_data($conn, "cpl_compliance_renewal_step2", "max(id) as max_id", "1");

                        if ($pk_cpl_compliancestep2_id_row != 0) {
                            $count = $pk_cpl_compliancestep2_id_row[0]['max_id'] + 1;
                            $pk = "RNS" . $count;
                        } else {
                            $pk = "RNS" . "1";
                        }

                        $inserted_value = ['pk_cpl_compliancestep2_id' => $pk, 'fk_sfa_ent_entity_id' => $entity_type_id, 'fk_cpl_compliance_id' => $master_id, 'fk_cpl_compliancetype_id' => $certificate_type, 'fk_cpl_complianceattempt_id' => $id, 'certificate_date' => $certificate_date, 'certificate_file' => $certi_Name, 'certificate_fee_deposited' => $certificate_fee_deposited, 'conveyance_fee' => $conveyance_fee, 'certificate_no' => $certificate_no, 'expiry_date' => $expiry_date, 'renewal_budget' => $renewal_budget, 'remark' => $remark, 'verification_status' => 0, 'ins_by' => $ins_by, 'ins_date_time' => $ins_date_time, 'ins_ip' => $ip, 'ins_application' => $ins_system];

                        // Call the function insert Data
                        $result = $ccm_query->InsertData($conn, "cpl_compliance_renewal_step2", $inserted_value);

                        if ($result === true) {
                            $conn->commit();
                            array_push($response_arr, 'true', 'Step 2 Completed Successfully', '#', 'hide2');
                        } else {
                            $conn->rollBack();
                            array_push($response_arr, 'false', 'Oops! Something went wrong', '#');
                        }
                    }
                } else {
                    array_push($response_arr, 'false', 'Please Upload the Certificate ', '#');
                }
            } else {
                if ($certificate_date == '') {
                    array_push($response_arr, 'false', 'Please Enter Certificate Date', '#');
                } else if ($certificate_no == '') {
                    array_push($response_arr, 'false', 'Please Enter Certificate No', '#');
                } else if ($expiry_date == '') {
                    array_push($response_arr, 'false', 'Please Enter Expiry Date', '#');
                } else if ($renewal_budget == '') {
                    array_push($response_arr, 'false', 'Please Enter Renewal Budget', '#');
                } else if ($remark == '') {
                    array_push($response_arr, 'false', 'Please Enter Remark', '#');
                }
            }
        }
    } else {
        array_push($response_arr, 'false', 'Please Select the Action', '#');
    }
    echo json_encode($response_arr);
}

if (isset($_POST['isset_defineKitchenRights'])) {
    $kitchen_id = trim($_POST['kitchen_id']);
    $L1_user = trim($_POST['L1_user']);
    $L2_user = trim($_POST['L2_user']);
    $L3_user = trim($_POST['L3_user']);
    $L4_user = trim($_POST['L4_user']);

    $response_arr = array();

    if ($kitchen_id != '' && ($L1_user != '' || $L2_user != '' || $L3_user != '' || $L4_user != '')) {

        $fetch_data = $ccm_query->fetch_data($conn, "cpl_define_kitchen_rights", "*", "kitchen_id='$kitchen_id'");

        if ($fetch_data == 0) {
            $inserted_value = ['kitchen_id' => $kitchen_id, 'l1_user' => $L1_user, 'l2_user' => $L2_user, 'l3_user' => $L3_user, 'l4_user' => $L4_user, 'transaction_status' => $status, 'ins_by' => $ins_by, 'ins_date' => $ins_date, 'ins_time' => $ins_time, 'ins_ip' => $ip];
            $result = $ccm_query->InsertData($conn, "cpl_define_kitchen_rights", $inserted_value);
            if ($result) {
                array_push($response_arr, 'true', 'Kitchen Rights Define Successfully', '#');
            } else {
                array_push($response_arr, 'false', 'Some Error Occured', '#');
            }
        } else {
            // update the data
            $updated_value = ['l1_user' => $L1_user, 'l2_user' => $L2_user, 'l3_user' => $L3_user, 'l4_user' => $L4_user, 'transaction_status' => $status, 'update_by' => $ins_by, 'update_date' => $ins_date, 'update_time' => $ins_time, 'update_ip' => $ip];
            $Conditions = ['kitchen_id' => $kitchen_id];
            $result = $ccm_query->UpdateData($conn, 'cpl_define_kitchen_rights', $updated_value, $Conditions);
            if ($result) {
                array_push($response_arr, 'true', 'Kitchen Rights Define Updated Successfully', '#');
            } else {
                array_push($response_arr, 'false', 'Some Error Occured', '#');
            }
        }
    } else {
        if ($kitchen_id == '') {
            array_push($response_arr, 'false', 'Please Select the Kitchen', '#');
        } else if ($L1_user == '' && $L2_user == '' && $L3_user == '' && $L4_user == '') {
            array_push($response_arr, 'false', 'Please Select the User', '#');
        }
    }
    echo json_encode($response_arr);
}
