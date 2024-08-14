<?php
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}
require_once "../../classfile/initialize.php";
require_once "../../classfile/sfa_entity_management.php";
$ins_by = $_SESSION['user_id'];
$ins_date = date('d-m-Y');
$ins_time = date('h:i:s A');
$ins_system = 'Web';
$status = 1;


if (isset($_POST['isset_addBankDetailsTemp'])) {
    $account_holder_name = trim($_POST['account_holder_name']);
    $account_no = trim($_POST['account_no']);
    $account_type = trim($_POST['account_type']);
    $bank_name = trim($_POST['bank_name']);
    $branch_name = trim($_POST['branch_name']);
    $ifsc_code = trim($_POST['ifsc_code']);
    $swift = trim($_POST['swift']);

    $response_arr = array();
    if ($account_holder_name != '' && $account_no != '' && $account_type != '' && $bank_name != '' && $branch_name != '' && $ifsc_code != '') {
        $rowCount = $sfa_ent->get_row_count_of_table($conn, "sfa_ent_hst_entity_bank_accounts_temp", "*", "account_no='$account_no' AND ifsc_code='$ifsc_code'");
        if ($rowCount == 0) {

            $session_id = session_id();
            // inserted data
            $inserted_value = ['fk_sfa_ent_session_id' => $session_id, 'holder_name' => $account_holder_name, 'account_no' => $account_no, 'account_type' => $account_type, 'bank_name' => $bank_name, 'branch_name' => $branch_name, 'ifsc_code' => $ifsc_code, 'swift_code' => $swift, 'transaction_status' => $status, 'ins_by' => $ins_by, 'ins_date' => $ins_date, 'ins_ip' => $ip, 'ins_system' => $ins_system];

            // Call the function insert Data
            $result = $sfa_ent->InsertData($conn, "sfa_ent_hst_entity_bank_accounts_temp", $inserted_value);
            if ($result) {
                array_push($response_arr, 'true', "", "ajaxpage/get_data_ajax.php", "isset_bank_details_temp", '#datadiv');
            } else {
                array_push($response_arr, 'false', 'Error in Query', '#');
            }

        } else
            array_push($response_arr, "false", 'Account Already Added', "#");

    } else {
        array_push($response_arr, "false", "Please Fill All Required Fields", "#");
    }
    echo json_encode($response_arr);
}
if (isset($_POST['isset_addContactDetailsTemp'])) {
    $person_name = trim($_POST['person_name']);
    $designation = trim($_POST['designation']);
    $contact_no = trim($_POST['contact_no']);
    $contact_no2 = trim($_POST['contact_no2']);
    $landline = trim($_POST['landline']);
    $email_id = trim($_POST['email_id']);
    $remark = trim($_POST['remark']);

    $response_arr = array();
    if ($person_name != '' && $contact_no != '' && $email_id != '') {
        $rowCount = $sfa_ent->get_row_count_of_table($conn, "sfa_ent_hst_contact_temp", "*", "mobile1='$contact_no'");
        if ($rowCount == 0) {
            $rowCount1 = $sfa_ent->get_row_count_of_table($conn, "sfa_ent_hst_contact_temp", "*", "	email='$email_id'");
            if ($rowCount1 == 0) {
                $session_id = session_id();

                // inserted data
                $inserted_value = ['fk_sfa_ent_entity_id' => $session_id, 'contact_name' => $person_name, 'designation' => $designation, 'mobile1' => $contact_no, 'mobile2' => $contact_no2, 'landline' => $landline, 'email' => $email_id, 'contact_remark' => $remark, 'transaction_status' => $status, 'ins_by' => $ins_by, 'ins_date' => $ins_date, 'ins_ip' => $ip, 'ins_system' => $ins_system];

                // Call the function insert Data
                $result = $sfa_ent->InsertData($conn, "sfa_ent_hst_contact_temp", $inserted_value);
                if ($result) {
                    array_push($response_arr, 'true', "", "ajaxpage/get_data_ajax.php", "isset_contact_details_temp", '#resultData');
                } else {
                    array_push($response_arr, 'false', 'Error in Query', '#');
                }
            }
            array_push($response_arr, "false", 'Email Already Exists', "#");
        } else
            array_push($response_arr, "false", 'Mobile Number Already Exists', "#");
    } else {
        array_push($response_arr, "false", "Please Fill All Required Fields", "#");
    }
    echo json_encode($response_arr);
}



if (isset($_POST['isset_sfa_ent_add_entity'])) {
    $entity_type_id = trim($_POST['entity_id']);
    $organization_id = trim($_POST['organization_id']);
    $category = trim($_POST['category']);
    $sub_category = trim($_POST['sub_category']);
    $zone = trim($_POST['zone']);
    $region = trim($_POST['region']);
    $entity_code = trim($_POST['entity_code']);
    $entity_name = trim($_POST['entity_name']);
    $address = trim($_POST['address']);
    $country = trim($_POST['country']);
    $state = trim($_POST['state']);
    $district = trim($_POST['district']);
    $pincode = trim($_POST['pincode']);
    $land_mark = trim($_POST['land_mark']);
    $contact1 = trim($_POST['contact1']);
    $contact2 = trim($_POST['contact2']);
    $website = trim($_POST['website']);
    $email = trim($_POST['email']);
    $pan_no = trim($_POST['pan_no']);
    $gst_no = trim($_POST['gst_no']);
    $tan_no = trim($_POST['tan_no']);
    $other_docu1 = trim($_POST['other_docu1']);
    $other_doc2 = trim($_POST['other_doc2']);
    $response_arr = array();


    if ($entity_type_id != '' && $organization_id != '' && $category != '' && $sub_category != '' && $zone != '' && $region != '' && $entity_code != '' && $entity_name != '') {
        $rowCount = $sfa_ent->get_row_count_of_table($conn, "sfa_ent_mst_entity", "*", "pk_sfa_ent_entity_id='$entity_code'");
        if ($rowCount == 0) {
            $rowCount1 = $sfa_ent->get_row_count_of_table($conn, "sfa_ent_mst_entity", "*", "entity_name='$entity_name'");
            if ($rowCount1 == 0) {
                $target_Dir = '../../upload/documents/' . $entity_code . '/'; //Specified Pathname
                if (!file_exists($target_Dir)) {
                    mkdir($target_Dir, 0777, true);
                }

                $conn->beginTransaction();
                $sid = session_id();
                $fetch_data_bank = $sfa_ent->fetch_data($conn, "sfa_ent_hst_entity_bank_accounts_temp", "*", "fk_sfa_ent_session_id='$sid'");
                if ($fetch_data_bank != 0) {
                    foreach ($fetch_data_bank as $bankDetail) {
                        $inserted_value = ['fk_sfa_ent_entity_id' => $entity_code, 'holder_name' => $bankDetail['holder_name'], 'account_no' => $bankDetail['account_no'], 'account_type' => $bankDetail['account_type'], 'bank_name' => $bankDetail['bank_name'], 'branch_name' => $bankDetail['branch_name'], 'ifsc_code' => $bankDetail['ifsc_code'], 'swift_code' => $bankDetail['swift_code'], 'transaction_status' => $status, 'ins_by' => $ins_by, 'ins_date' => $ins_date, 'ins_ip' => $ip, 'ins_system' => $ins_system];

                        // Call the function insert Data
                        $result = $sfa_ent->InsertData($conn, "sfa_ent_tns_entity_bank_accounts", $inserted_value);
                        if (!$result) {
                            $conn->rollback();
                        }
                    }
                }
                $fetch_data_contact = $sfa_ent->fetch_data($conn, "sfa_ent_hst_contact_temp", "*", "fk_sfa_ent_entity_id='$sid'");

                if ($fetch_data_contact != 0) {
                    foreach ($fetch_data_contact as $contactDetails) {
                        $inserted_value = ['fk_sfa_ent_entity_id' => $entity_code, 'contact_name' => $contactDetails['contact_name'], 'designation' => $contactDetails['designation'], 'mobile1' => $contactDetails['mobile1'], 'mobile2' => $contactDetails['mobile2'], 'landline' => $contactDetails['landline'], 'email' => $contactDetails['email'], 'contact_remark' => $contactDetails['contact_remark'], 'transaction_status' => $status, 'ins_by' => $ins_by, 'ins_date' => $ins_date, 'ins_ip' => $ip, 'ins_system' => $ins_system];

                        // Call the function insert Data
                        $result = $sfa_ent->InsertData($conn, "sfa_ent_mst_contact_master", $inserted_value);
                        if (!$result) {
                            $conn->rollback();
                        }
                    }
                }
                $password = $sfa_ent->passwordGenetor(8);
                $logoName = '';
                if ($_FILES['logo']['name'] != '') {
                    $logoName = $sfa_ent->RenameImage('logo');
                    $logo_image = $sfa_ent->uploadImage('logo', $logoName, $target_Dir);
                    if ($logo_image['status'] == 0) {
                        array_push($response_arr, 'false', $logo_image['msg'], '#');
                        $conn->rollback();
                        echo json_encode($response_arr);
                        die();
                    }
                }
                if ($_FILES['doc_pan']['name'] != '') {
                    $doc_panName = $sfa_ent->RenameImage('doc_pan');
                    $doc_pan_image = $sfa_ent->uploadImage('doc_pan', $doc_panName, $target_Dir);
                    if ($doc_pan_image['status'] == 0) {
                        array_push($response_arr, 'false', $doc_pan_image['msg'], '#');
                        $conn->rollback();
                        echo json_encode($response_arr);
                        die();
                    } else if ($doc_pan_image['status'] == 1) {
                        $inserted_value = ['fk_sfa_ent_entity_id' => $entity_code, 'document_type' => 'PAN', 'document_name' => $pan_no, 'document_file' => $doc_panName, 'transaction_status' => $status, 'ins_by' => $ins_by, 'ins_date' => $ins_date, 'ins_ip' => $ip, 'ins_system' => $ins_system];

                        // Call the function insert Data
                        $result = $sfa_ent->InsertData($conn, "sfa_ent_tns_entity_documents", $inserted_value);
                        if (!$result) {
                            $conn->rollback();
                        }
                    }
                }
                if ($_FILES['doc_tan']['name'] != '') {
                    $doc_tanName = $sfa_ent->RenameImage('doc_tan');
                    $doc_tan_image = $sfa_ent->uploadImage('doc_tan', $doc_tanName, $target_Dir);
                    if ($doc_tan_image['status'] == 0) {
                        array_push($response_arr, 'false', $doc_tan_image['msg'], '#');
                        $conn->rollback();
                        echo json_encode($response_arr);
                        die();
                    } else if ($doc_tan_image['status'] == 1) {
                        $inserted_value = ['fk_sfa_ent_entity_id' => $entity_code, 'document_type' => 'TAN', 'document_name' => $tan_no, 'document_file' => $doc_tanName, 'transaction_status' => $status, 'ins_by' => $ins_by, 'ins_date' => $ins_date, 'ins_ip' => $ip, 'ins_system' => $ins_system];

                        // Call the function insert Data
                        $result = $sfa_ent->InsertData($conn, "sfa_ent_tns_entity_documents", $inserted_value);
                        if (!$result) {
                            $conn->rollback();
                        }
                    }
                }
                if ($_FILES['doc_gst']['name'] != '') {
                    $doc_gstName = $sfa_ent->RenameImage('doc_gst');
                    $doc_gst_image = $sfa_ent->uploadImage('doc_gst', $doc_gstName, $target_Dir);
                    if ($doc_gst_image['status'] == 0) {
                        array_push($response_arr, 'false', $doc_gst_image['msg'], '#');
                        $conn->rollback();
                        echo json_encode($response_arr);
                        die();
                    } else if ($doc_gst_image['status'] == 1) {
                        $inserted_value = ['fk_sfa_ent_entity_id' => $entity_code, 'document_type' => 'GST', 'document_name' => $gst_no, 'document_file' => $doc_gstName, 'transaction_status' => $status, 'ins_by' => $ins_by, 'ins_date' => $ins_date, 'ins_ip' => $ip, 'ins_system' => $ins_system];

                        // Call the function insert Data
                        $result = $sfa_ent->InsertData($conn, "sfa_ent_tns_entity_documents", $inserted_value);
                        if (!$result) {
                            $conn->rollback();
                        }
                    }
                }
                if ($_FILES['doc_registration']['name'] != '') {
                    $doc_registrationName = $sfa_ent->RenameImage('doc_registration');
                    $doc_registration_image = $sfa_ent->uploadImage('doc_registration', $doc_registrationName, $target_Dir);
                    if ($doc_registration_image['status'] == 0) {
                        array_push($response_arr, 'false', $doc_registration_image['msg'], '#');
                        $conn->rollback();
                        echo json_encode($response_arr);
                        die();
                    } else if ($doc_registration_image['status'] == 1) {
                        $inserted_value = ['fk_sfa_ent_entity_id' => $entity_code, 'document_type' => 'Registration', 'document_name' => 'Registration', 'document_file' => $doc_registrationName, 'transaction_status' => $status, 'ins_by' => $ins_by, 'ins_date' => $ins_date, 'ins_ip' => $ip, 'ins_system' => $ins_system];

                        // Call the function insert Data
                        $result = $sfa_ent->InsertData($conn, "sfa_ent_tns_entity_documents", $inserted_value);
                        if (!$result) {
                            $conn->rollback();
                        }
                    }
                }
                if ($_FILES['doc_other_docu1']['name'] != '') {
                    $doc_other_docu1Name = $sfa_ent->RenameImage('doc_other_docu1');
                    $doc_other_docu1_image = $sfa_ent->uploadImage('doc_other_docu1', $doc_other_docu1Name, $target_Dir);
                    if ($doc_other_docu1_image['status'] == 0) {
                        array_push($response_arr, 'false', $doc_other_docu1_image['msg'], '#');
                        $conn->rollback();
                        echo json_encode($response_arr);
                        die();
                    } else if ($doc_other_docu1_image['status'] == 1) {
                        $inserted_value = ['fk_sfa_ent_entity_id' => $entity_code, 'document_type' => 'Other Document1', 'document_name' => $other_docu1, 'document_file' => $doc_other_docu1Name, 'transaction_status' => $status, 'ins_by' => $ins_by, 'ins_date' => $ins_date, 'ins_ip' => $ip, 'ins_system' => $ins_system];

                        // Call the function insert Data
                        $result = $sfa_ent->InsertData($conn, "sfa_ent_tns_entity_documents", $inserted_value);
                        if (!$result) {
                            $conn->rollback();
                        }
                    }
                }
                if ($_FILES['other_doc2']['name'] != '') {
                    $other_doc2Name = $sfa_ent->RenameImage('other_doc2');
                    $other_doc2_image = $sfa_ent->uploadImage('other_doc2', $other_doc2Name, $target_Dir);
                    if ($other_doc2_image['status'] == 0) {
                        array_push($response_arr, 'false', $other_doc2_image['msg'], '#');
                        $conn->rollback();
                        echo json_encode($response_arr);
                        die();
                    } else if ($other_doc2_image['status'] == 1) {
                        $inserted_value = ['fk_sfa_ent_entity_id' => $entity_code, 'document_type' => 'Other Document 2', 'document_name' => $other_doc2, 'document_file' => $other_doc2Name, 'transaction_status' => $status, 'ins_by' => $ins_by, 'ins_date' => $ins_date, 'ins_ip' => $ip, 'ins_system' => $ins_system];

                        // Call the function insert Data
                        $result = $sfa_ent->InsertData($conn, "sfa_ent_tns_entity_documents", $inserted_value);
                        if (!$result) {
                            $conn->rollback();
                        }
                    }
                }

                $inserted_value_entity = [
                    'pk_sfa_ent_entity_id' => $entity_code,
                    'fk_sfa_cnf_entitytype_id' => $entity_type_id,
                    'fk_sfa_cnf_orgtype_id' => $organization_id,
                    'fk_sfa_cnf_entcategory_id' => $category,
                    'fk_sfa_cnf_entsubcategory_id' => $sub_category,
                    'zone_id' => $zone,
                    'region_id' => $region,
                    'entity_name' => $entity_name,
                    'entity_address' => $address,
                    'country_id' => $country,
                    'state_id' => $state,
                    'city_id' => $district,
                    'add_pincode' => $pincode,
                    'add_landmark' => $land_mark,
                    'contact_no1' => $contact1,
                    'contact_no2' => $contact2,
                    'website_url' => $website,
                    'ent_email' => $email,
                    'entity_logo' => $logoName,
                    'pan_no' => $pan_no,
                    'gstn_no' => $gst_no,
                    'tan_no' => $tan_no,
                    'login_password' => $password,
                    'transaction_status' => $status,
                    'ins_by' => $ins_by,
                    'ins_date' => $ins_date,
                    'ins_ip' => $ip,
                    'ins_system' => $ins_system
                ];
                // Call the function insert Data
                $result = $sfa_ent->InsertData($conn, "sfa_ent_mst_entity", $inserted_value_entity);

                if ($result) {
                    $delete1 = $sfa_ent->deleteData($conn, 'sfa_ent_hst_entity_bank_accounts_temp', "", "fk_sfa_ent_session_id", $sid);
                    if (!$delete1) {
                        $conn->rollback();
                        array_push($response_arr, 'false', 'Some Error Occured Please Try Later', '#');
                        die();
                    }
                    $delete2 = $sfa_ent->deleteData($conn, "sfa_ent_hst_contact_temp", "", "fk_sfa_ent_entity_id", $sid);
                    if (!$delete2) {
                        $conn->rollback();
                        array_push($response_arr, 'false', 'Some Error Occured Please Try Later', '#');
                        die();
                    }
                    $conn->commit();
                    array_push($response_arr, 'true', 'Entity Added Successfully', '#');
                } else {
                    array_push($response_arr, 'false', 'Some Error Occured Please Try Later', '#');
                    $conn->rollback();
                }

            } else {
                array_push($response_arr, "false", "$entity_name Already Exists.", "#");
            }
        } else {
            array_push($response_arr, "false", "$entity_code Already Exists.", "#");
        }



    } else {
        if ($entity_type_id == '') {
            array_push($response_arr, 'false', 'Entity Type is Required Field..', '#');
        }
        if ($organization_id == '') {
            array_push($response_arr, 'false', 'Organization type is Required Field..', '#');
        }
        if ($category == '') {
            array_push($response_arr, 'false', 'Category is Required Field..', '#');
        }
        if ($sub_category == '') {
            array_push($response_arr, 'false', 'Sub Category is Required Field..', '#');
        }
        if ($zone == '') {
            array_push($response_arr, 'false', 'Zone is Required Field..', '#');
        }
        if ($region == '') {
            array_push($response_arr, 'false', 'Region is Required Field..', '#');
        }
        if ($entity_code == '') {
            array_push($response_arr, 'false', 'Entity Code is Required Field..', '#');
        }
        if ($entity_name == '') {
            array_push($response_arr, 'false', 'Entity name is Required Field..', '#');
        }
    }
    echo json_encode($response_arr);
}


if (isset($_POST['isset_addBankDetailsUpdate'])) {
    $account_holder_name = trim($_POST['account_holder_name']);
    $account_no = trim($_POST['account_no']);
    $account_type = trim($_POST['account_type']);
    $bank_name = trim($_POST['bank_name']);
    $branch_name = trim($_POST['branch_name']);
    $ifsc_code = trim($_POST['ifsc_code']);
    $swift = trim($_POST['swift']);
    $entityID = trim($_POST['entityID']);
    $response_arr = array();
    if ($account_holder_name != '' && $account_no != '' && $account_type != '' && $bank_name != '' && $branch_name != '' && $ifsc_code != '') {
        $rowCount = $sfa_ent->get_row_count_of_table($conn, "sfa_ent_tns_entity_bank_accounts", "*", "account_no='$account_no' AND ifsc_code='$ifsc_code'");
        if ($rowCount == 0) {

            // inserted data
            $inserted_value = ['fk_sfa_ent_entity_id' => $entityID, 'holder_name' => $account_holder_name, 'account_no' => $account_no, 'account_type' => $account_type, 'bank_name' => $bank_name, 'branch_name' => $branch_name, 'ifsc_code' => $ifsc_code, 'swift_code' => $swift, 'transaction_status' => $status, 'ins_by' => $ins_by, 'ins_date' => $ins_date, 'ins_ip' => $ip, 'ins_system' => $ins_system];

            // Call the function insert Data
            $result = $sfa_ent->InsertData($conn, "sfa_ent_tns_entity_bank_accounts", $inserted_value);
            if ($result) {
                array_push($response_arr, 'true', "", "ajaxpage/get_data_ajax.php", "isset_bank_details_update", '#datadiv', $entityID);
            } else {
                array_push($response_arr, 'false', 'Error in Query', '#');
            }
        } else
            array_push($response_arr, "false", 'Account Already Added', "#");
    } else {
        array_push($response_arr, "false", "Please Fill All Required Fields", "#");
    }
    echo json_encode($response_arr);
}



if (isset($_POST['isset_addContactDetailsUpdate'])) {
    // $sfa_ent->debug($_POST);
    $person_name = trim($_POST['person_name']);
    $designation = trim($_POST['designation']);
    $contact_no = trim($_POST['contact_no']);
    $contact_no2 = trim($_POST['contact_no2']);
    $landline = trim($_POST['landline']);
    $email_id = trim($_POST['email_id']);
    $remark = trim($_POST['remark']);
    $entityID = trim($_POST['entityID']);
    $response_arr = array();
    if ($person_name != '' && $contact_no != '' && $email_id != '') {
        $rowCount = $sfa_ent->get_row_count_of_table($conn, "sfa_ent_mst_contact_master", "*", "mobile1='$contact_no'");
        if ($rowCount == 0) {
            $rowCount1 = $sfa_ent->get_row_count_of_table($conn, "sfa_ent_mst_contact_master", "*", "	email='$email_id'");
            if ($rowCount1 == 0) {
                // inserted data
                $inserted_value = ['fk_sfa_ent_entity_id' => $entityID, 'contact_name' => $person_name, 'designation' => $designation, 'mobile1' => $contact_no, 'mobile2' => $contact_no2, 'landline' => $landline, 'email' => $email_id, 'contact_remark' => $remark, 'transaction_status' => $status, 'ins_by' => $ins_by, 'ins_date' => $ins_date, 'ins_ip' => $ip, 'ins_system' => $ins_system];

                // Call the function insert Data
                $result = $sfa_ent->InsertData($conn, "sfa_ent_mst_contact_master", $inserted_value);
                if ($result) {
                    array_push($response_arr, 'true', "", "ajaxpage/get_data_ajax.php", "isset_contact_details_update", '#resultData', $entityID);
                } else {
                    array_push($response_arr, 'false', 'Error in Query', '#');
                }
            }
            array_push($response_arr, "false", 'Email Already Exists', "#");
        } else
            array_push($response_arr, "false", 'Mobile Number Already Exists', "#");
    } else {
        array_push($response_arr, 'false', 'Please fill All the Required Fields', '#');
    }
    echo json_encode($response_arr);
}



if (isset($_POST['isset_addContactDetailsContactSearch'])) {
    // $sfa_ent->debug($_POST);
    $person_name = trim($_POST['name']);
    $designation = trim($_POST['designation']);
    $contact_no = trim($_POST['contact_no']);
    $contact_no2 = trim($_POST['contact_no2']);
    $landline = trim($_POST['landline']);
    $email_id = trim($_POST['email_id']);
    $remark = trim($_POST['contact_remark']);
    $entityID = trim($_POST['entityID']);
    $response_arr = array();
    if ($person_name != '' && $contact_no != '' && $email_id != '') {
        $rowCount = $sfa_ent->get_row_count_of_table($conn, "sfa_ent_mst_contact_master", "*", "mobile1='$contact_no' AND fk_sfa_ent_entity_id='$entityID'");
        if ($rowCount == 0) {
            $rowCount1 = $sfa_ent->get_row_count_of_table($conn, "sfa_ent_mst_contact_master", "*", "	email='$email_id' AND fk_sfa_ent_entity_id='$entityID'");
            if ($rowCount1 == 0) {
                // inserted data
                $inserted_value = ['fk_sfa_ent_entity_id' => $entityID, 'contact_name' => $person_name, 'designation' => $designation, 'mobile1' => $contact_no, 'mobile2' => $contact_no2, 'landline' => $landline, 'email' => $email_id, 'contact_remark' => $remark, 'transaction_status' => $status, 'ins_by' => $ins_by, 'ins_date' => $ins_date, 'ins_ip' => $ip, 'ins_system' => $ins_system];

                // Call the function insert Data
                $result = $sfa_ent->InsertData($conn, "sfa_ent_mst_contact_master", $inserted_value);
                if ($result) {
                    array_push($response_arr, 'true', 'Contact Details Add Successfully.','#','#');
                } else {
                    array_push($response_arr, 'false', 'Error in Query', '#');
                }
            }
            array_push($response_arr, "false", 'Email Already Exists', "#");
        } else
            array_push($response_arr, "false", 'Mobile Number Already Exists', "#");
    } else {
        array_push($response_arr, 'false', 'Please fill All the Required Fields', '#');
    }
    echo json_encode($response_arr);
}

?>