<?php
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}
require_once "../../classfile/initialize.php";
require_once "../../classfile/sfa_entity_management.php";
$update_by = $_SESSION['user_id'];
$update_date = date('d-m-Y');
$update_time = date('h:i:s A');
$update_system = 'Web';
$status = 1;


if (isset($_POST['isset_addBankDetailsUpdateSingleRow'])) {
    $holder_name = trim($_POST['holder_name']);
    $account_no = trim($_POST['account_no']);
    $account_type = trim($_POST['account_type']);
    $bank_name = trim($_POST['bank_name']);
    $branch_name = trim($_POST['branch_name']);
    $ifsc_code = trim($_POST['ifsc_code']);
    $swift = trim($_POST['swift']);
    $entityID = trim($_POST['entityID']);
    $id = trim($_POST['id']);


    $response_arr = array();
    if (
        $holder_name != '' &&
        $account_no != '' &&
        $account_type != '' &&
        $bank_name != '' &&
        $branch_name != '' &&
        $ifsc_code != '' &&
        $id != ''
    ) {
        $rowCount = $sfa_ent->get_row_count_of_table($conn, "sfa_ent_tns_entity_bank_accounts", '*', "pk_sfa_ent_bankaccount_id='$id'");
        if ($rowCount != 0) {

            $updated_value = ['holder_name' => $holder_name, 'account_no' => $account_no, 'account_type' => $account_type, 'bank_name' => $bank_name, 'branch_name' => $branch_name, 'ifsc_code' => $ifsc_code, 'swift_code' => $swift, 'transaction_status' => $status, 'update_by' => $update_by, 'update_date' => $update_date, 'update_ip' => $ip, 'update_system' => $update_system];
            $Conditions = ['pk_sfa_ent_bankaccount_id' => $id];
            $result = $sfa_ent->UpdateData($conn, 'sfa_ent_tns_entity_bank_accounts', $updated_value, $Conditions);
            if ($result) {
                array_push($response_arr, 'true', "Data updated Successfully", "ajaxpage/get_data_ajax.php", "isset_bank_details_update", '#datadiv', $entityID);
            } else {
                array_push($response_arr, 'false', 'Something went Wrong!!', "#");
            }
        } else {
            array_push($response_arr, 'false', 'No Data Found', "#");
        }
    } else {
        array_push($response_arr, 'false', 'Please Fill All the Required Fields!!!', "#");
    }
    echo json_encode($response_arr);
}

if (isset($_POST['isset_addContactDetailsUpdateSingleRow'])) {
    $person_name = trim($_POST['person_name']);
    $designation = trim($_POST['designation']);
    $contact_no = trim($_POST['contact_no']);
    $contact_no2 = trim($_POST['contact_no2']);
    $landline = trim($_POST['landline']);
    $email_id = trim($_POST['email_id']);
    $remark = trim($_POST['remark']);
    $id = trim($_POST['id']);
    $entityID = trim($_POST['entityID']);
    $response_arr = array();
    if ($person_name != '' && $contact_no != '' && $email_id != '') {
        $rowCount = $sfa_ent->get_row_count_of_table($conn, "sfa_ent_mst_contact_master", '*', "pk_sfa_ent_contact_id='$id'");
        if ($rowCount != 0) {

            $updated_value = ['contact_name' => $person_name, 'designation' => $designation, 'mobile1' => $contact_no, 'mobile2' => $contact_no2, 'landline' => $landline, 'email' => $email_id, 'contact_remark' => $remark, 'transaction_status' => $status, 'update_by' => $update_by, 'update_date' => $update_date, 'update_ip' => $ip, 'update_system' => $update_system];
            $Conditions = ['pk_sfa_ent_contact_id' => $id];
            $result = $sfa_ent->UpdateData($conn, 'sfa_ent_mst_contact_master', $updated_value, $Conditions);
            if ($result) {
                array_push($response_arr, 'true', "Contact Details Updated Successfully", "ajaxpage/get_data_ajax.php", "isset_contact_details_update", '#resultData', $entityID);
            } else {
                array_push($response_arr, 'false', 'Something went Wrong!!', "#");
            }
        } else {
            array_push($response_arr, 'false', 'No Data Found', "#");
        }
    } else {
        array_push($response_arr, 'false', 'Please Fill All Required Fields', "#");
    }

    echo json_encode($response_arr);
}


if (isset($_POST['isset_sfa_ent_update_entity'])) {
    $id = trim($_POST['id']);
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
        if ($rowCount != 0) {
            $target_Dir = '../../upload/documents/' . $entity_code . '/'; //Specified Pathname
            if (!file_exists($target_Dir)) {
                mkdir($target_Dir, 0777, true);
            }

            $conn->beginTransaction();

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

                    $rowCnt_PAN = $sfa_ent->get_row_count_of_table($conn, "sfa_ent_tns_entity_documents", "*", "fk_sfa_ent_entity_id='$entity_code' AND document_type='PAN'");
                    if ($rowCnt_PAN == 0) {
                        $inserted_value = ['fk_sfa_ent_entity_id' => $entity_code, 'document_type' => 'PAN', 'document_name' => $other_docu1, 'document_file' => $doc_panName, 'transaction_status' => $status, 'ins_by' => $update_by, 'ins_date' => $update_date, 'ins_ip' => $ip, 'ins_system' => $update_system];

                        // Call the function insert Data
                        $result = $sfa_ent->InsertData($conn, "sfa_ent_tns_entity_documents", $inserted_value);
                        if (!$result) {
                            $conn->rollback();
                        }
                    } else {
                        // update
                        $data = $sfa_ent->fetch_data($conn, "sfa_ent_tns_entity_documents", "*", "fk_sfa_ent_entity_id='$entity_code' AND document_type='PAN'");
                        $file_name = $data[0]['document_file'];

                        $updated_value = ['document_file' => $doc_panName, 'transaction_status' => $status, 'ins_by' => $update_by, 'ins_date' => $update_date, 'ins_ip' => $ip, 'ins_system' => $update_system];
                        $Conditions = ['fk_sfa_ent_entity_id' => $entity_code, 'document_type' => 'PAN'];
                        $result = $sfa_ent->UpdateData($conn, 'sfa_ent_tns_entity_documents', $updated_value, $Conditions);
                        if (!$result) {
                            $conn->rollback();
                        } else {
                            if (file_exists($target_Dir . $file_name)) {
                                unlink($target_Dir . $file_name);
                            }
                        }
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
                    $rowCnt_TAN = $sfa_ent->get_row_count_of_table($conn, "sfa_ent_tns_entity_documents", "*", "fk_sfa_ent_entity_id='$entity_code' AND document_type='TAN'");
                    if ($rowCnt_TAN == 0) {
                        $inserted_value = ['fk_sfa_ent_entity_id' => $entity_code, 'document_type' => 'TAN', 'document_name' => $other_docu1, 'document_file' => $doc_tanName, 'transaction_status' => $status, 'ins_by' => $update_by, 'ins_date' => $update_date, 'ins_ip' => $ip, 'ins_system' => $update_system];

                        // Call the function insert Data
                        $result = $sfa_ent->InsertData($conn, "sfa_ent_tns_entity_documents", $inserted_value);
                        if (!$result) {
                            $conn->rollback();
                        }
                    } else {
                        // update
                        $data = $sfa_ent->fetch_data($conn, "sfa_ent_tns_entity_documents", "*", "fk_sfa_ent_entity_id='$entity_code' AND document_type='TAN'");
                        $file_name = $data[0]['document_file'];

                        $updated_value = ['document_file' => $doc_tanName, 'transaction_status' => $status, 'ins_by' => $update_by, 'ins_date' => $update_date, 'ins_ip' => $ip, 'ins_system' => $update_system];
                        $Conditions = ['fk_sfa_ent_entity_id' => $entity_code, 'document_type' => 'TAN'];
                        $result = $sfa_ent->UpdateData($conn, 'sfa_ent_tns_entity_documents', $updated_value, $Conditions);
                        if (!$result) {
                            $conn->rollback();
                        } else {
                            if (file_exists($target_Dir . $file_name)) {
                                unlink($target_Dir . $file_name);
                            }
                        }
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
                    $rowCnt_GST = $sfa_ent->get_row_count_of_table($conn, "sfa_ent_tns_entity_documents", "*", "fk_sfa_ent_entity_id='$entity_code' AND document_type='GST'");
                    if ($rowCnt_GST == 0) {
                        $inserted_value = ['fk_sfa_ent_entity_id' => $entity_code, 'document_type' => 'GST', 'document_name' => $other_docu1, 'document_file' => $doc_gstName, 'transaction_status' => $status, 'ins_by' => $update_by, 'ins_date' => $update_date, 'ins_ip' => $ip, 'ins_system' => $update_system];

                        // Call the function insert Data
                        $result = $sfa_ent->InsertData($conn, "sfa_ent_tns_entity_documents", $inserted_value);
                        if (!$result) {
                            $conn->rollback();
                        }
                    } else {
                        // update
                        $data = $sfa_ent->fetch_data($conn, "sfa_ent_tns_entity_documents", "*", "fk_sfa_ent_entity_id='$entity_code' AND document_type='GST'");
                        $file_name = $data[0]['document_file'];

                        $updated_value = ['document_file' => $doc_gstName, 'transaction_status' => $status, 'ins_by' => $update_by, 'ins_date' => $update_date, 'ins_ip' => $ip, 'ins_system' => $update_system];
                        $Conditions = ['fk_sfa_ent_entity_id' => $entity_code, 'document_type' => 'GST'];
                        $result = $sfa_ent->UpdateData($conn, 'sfa_ent_tns_entity_documents', $updated_value, $Conditions);
                        if (!$result) {
                            $conn->rollback();
                        } else {
                            if (file_exists($target_Dir . $file_name)) {
                                unlink($target_Dir . $file_name);
                            }
                        }
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
                    $rowCnt_Reg = $sfa_ent->get_row_count_of_table($conn, "sfa_ent_tns_entity_documents", "*", "fk_sfa_ent_entity_id='$entity_code' AND document_type='Registration'");
                    if ($rowCnt_Reg == 0) {
                        $inserted_value = ['fk_sfa_ent_entity_id' => $entity_code, 'document_type' => 'Registration', 'document_name' => $other_docu1, 'document_file' => $doc_registrationName, 'transaction_status' => $status, 'ins_by' => $update_by, 'ins_date' => $update_date, 'ins_ip' => $ip, 'ins_system' => $update_system];

                        // Call the function insert Data
                        $result = $sfa_ent->InsertData($conn, "sfa_ent_tns_entity_documents", $inserted_value);
                        if (!$result) {
                            $conn->rollback();
                        }
                    } else {
                        // update
                        $data = $sfa_ent->fetch_data($conn, "sfa_ent_tns_entity_documents", "*", "fk_sfa_ent_entity_id='$entity_code' AND document_type='Registration'");
                        $file_name = $data[0]['document_file'];

                        $updated_value = ['document_file' => $doc_registrationName, 'transaction_status' => $status, 'ins_by' => $update_by, 'ins_date' => $update_date, 'ins_ip' => $ip, 'ins_system' => $update_system];
                        $Conditions = ['fk_sfa_ent_entity_id' => $entity_code, 'document_type' => 'Registration'];
                        $result = $sfa_ent->UpdateData($conn, 'sfa_ent_tns_entity_documents', $updated_value, $Conditions);
                        if (!$result) {
                            $conn->rollback();
                        } else {
                            if (file_exists($target_Dir . $file_name)) {
                                unlink($target_Dir . $file_name);
                            }
                        }
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
                    $rowCnt_Other_1 = $sfa_ent->get_row_count_of_table($conn, "sfa_ent_tns_entity_documents", "*", "fk_sfa_ent_entity_id='$entity_code' AND document_type='Other Document1'");
                    if ($rowCnt_Other_1 == 0) {
                        $inserted_value = ['fk_sfa_ent_entity_id' => $entity_code, 'document_type' => 'Other Document1', 'document_name' => $other_docu1, 'document_file' => $doc_other_docu1Name, 'transaction_status' => $status, 'ins_by' => $update_by, 'ins_date' => $update_date, 'ins_ip' => $ip, 'ins_system' => $update_system];

                        // Call the function insert Data
                        $result = $sfa_ent->InsertData($conn, "sfa_ent_tns_entity_documents", $inserted_value);
                        if (!$result) {
                            $conn->rollback();
                        }
                    } else {
                        // update
                        $data = $sfa_ent->fetch_data($conn, "sfa_ent_tns_entity_documents", "*", "fk_sfa_ent_entity_id='$entity_code' AND document_type='Other Document1'");
                        $file_name = $data[0]['document_file'];

                        $updated_value = ['document_file' => $doc_other_docu1Name, 'transaction_status' => $status, 'ins_by' => $update_by, 'ins_date' => $update_date, 'ins_ip' => $ip, 'ins_system' => $update_system];
                        $Conditions = ['fk_sfa_ent_entity_id' => $entity_code, 'document_type' => 'Other Document1'];
                        $result = $sfa_ent->UpdateData($conn, 'sfa_ent_tns_entity_documents', $updated_value, $Conditions);
                        if (!$result) {
                            $conn->rollback();
                        } else {
                            if (file_exists($target_Dir . $file_name)) {
                                unlink($target_Dir . $file_name);
                            }
                        }
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
                    $rowCnt_Other_2 = $sfa_ent->get_row_count_of_table($conn, "sfa_ent_tns_entity_documents", "*", "fk_sfa_ent_entity_id='$entity_code' AND document_type='Other Document 2'");
                    if ($rowCnt_Other_2 == 0) {
                        $inserted_value = ['fk_sfa_ent_entity_id' => $entity_code, 'document_type' => 'Other Document 2', 'document_name' => $other_doc2, 'document_file' => $other_doc2Name, 'transaction_status' => $status, 'ins_by' => $update_by, 'ins_date' => $update_date, 'ins_ip' => $ip, 'ins_system' => $update_system];

                        // Call the function insert Data
                        $result = $sfa_ent->InsertData($conn, "sfa_ent_tns_entity_documents", $inserted_value);
                        if (!$result) {
                            $conn->rollback();
                        }
                    } else {
                        // update
                        $data = $sfa_ent->fetch_data($conn, "sfa_ent_tns_entity_documents", "*", "fk_sfa_ent_entity_id='$entity_code' AND document_type='Other Document 2'");
                        $file_name = $data[0]['document_file'];

                        $updated_value = ['document_file' => $other_doc2Name, 'transaction_status' => $status, 'ins_by' => $update_by, 'ins_date' => $update_date, 'ins_ip' => $ip, 'ins_system' => $update_system];
                        $Conditions = ['fk_sfa_ent_entity_id' => $entity_code, 'document_type' => 'Other Document 2'];
                        $result = $sfa_ent->UpdateData($conn, 'sfa_ent_tns_entity_documents', $updated_value, $Conditions);
                        if (!$result) {
                            $conn->rollback();
                        } else {
                            if (file_exists($target_Dir . $file_name)) {
                                unlink($target_Dir . $file_name);
                            }
                        }
                    }
                }
            }


            $updated_value_entity = [
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
                'transaction_status' => $status,
                'update_by' => $update_by,
                'update_date' => $update_date,
                'update_ip' => $ip,
                'update_system' => $update_system
            ];
            $conditions = ['id' => $id];
            $result = $sfa_ent->UpdateData($conn, 'sfa_ent_mst_entity', $updated_value_entity, $conditions);


            if ($result) {
                $conn->commit();
                array_push($response_arr, 'true', 'Entity Added Successfully', '#');
            } else {
                array_push($response_arr, 'false', 'Some Error Occured Please Try Later', '#');
                $conn->rollback();
            }

        } else {
            array_push($response_arr, "false", "No Record found.", "#");
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



if (isset($_POST['isset_update_ContactEntity'])) {
    $selected_letter = $_POST['selected_letter'];
    $selected_id = $_POST['selected_id'];
    $name = $_POST['name'];
    $designation = $_POST['designation'];
    $mobile1 = $_POST['mobile1'];
    $mobile2 = $_POST['mobile2'];
    $landline = $_POST['landline'];
    $email = $_POST['email'];
    $contact_dob = $_POST['contact_dob'];
    $contact_dom = $_POST['contact_dom'];
    $contact_remark = $_POST['contact_remark'];
    $id = $_POST['id'];
    $response_arr = array();
    if ($name != '' && $mobile1 != '' && $email != '') {
        $rowCount = $sfa_ent->get_row_count_of_table($conn, "sfa_ent_mst_contact_master", '*', "pk_sfa_ent_contact_id='$id'");
        if ($rowCount != 0) {
            $updated_value = ['contact_name' => $name, 'designation' => $designation, 'mobile1' => $mobile1, 'mobile2' => $mobile2, 'landline' => $landline, 'email' => $email, 'contact_dob' => $contact_dob, 'contact_dom' => $contact_dom, 'contact_remark' => $contact_remark, 'transaction_status' => $status, 'update_by' => $update_by, 'update_date' => $update_date, 'update_ip' => $ip, 'update_system' => $update_system];
            $Conditions = ['pk_sfa_ent_contact_id' => $id];
            $result = $sfa_ent->UpdateData($conn, 'sfa_ent_mst_contact_master', $updated_value, $Conditions);
            if ($result) {
                array_push($response_arr, 'true', "Contact Details Updated Successfully", $selected_id, $selected_letter);
            } else {
                array_push($response_arr, 'false', 'Something went Wrong!!', "#");
            }
        } else {
            array_push($response_arr, 'false', 'No Data Found', "#");
        }
    } else {
        array_push($response_arr, 'false', 'Please Fill All Required Fields', "#");
    }

    echo json_encode($response_arr);
}


if (isset($_POST['isset_individual_bulk_update_SingleRow'])) {
    // $sfa_ent->debug($_POST);
    $state = $_POST['state'];
    $district = $_POST['district'];
    $zone = $_POST['zone'];
    $region = $_POST['region'];
    $gst_no = $_POST['gst_no'];
    $email = $_POST['email'];
    $mobile = $_POST['mobile'];
    $id = $_POST['id'];
    $response_arr = array();


    if ($state != '' && $district != '' && $zone != '' && $region != '' && $gst_no != '') {
        $rowCount = $sfa_ent->get_row_count_of_table($conn, "sfa_ent_mst_entity", '*', "id='$id'");
        if ($rowCount != 0) {
            $updated_value_entity = [
                'zone_id' => $zone,
                'region_id' => $region,
                'state_id' => $state,
                'city_id' => $district,
                'contact_no1' => $mobile,
                'ent_email' => $email,
                'gstn_no' => $gst_no,
                'update_by' => $update_by,
                'update_date' => $update_date,
                'update_ip' => $ip,
                'update_system' => $update_system
            ];
            $conditions = ['id' => $id];
            $result = $sfa_ent->UpdateData($conn, 'sfa_ent_mst_entity', $updated_value_entity, $conditions);


            if ($result) {
                array_push($response_arr, 'true', 'Entity Details Updated Successfully', '#');
            } else {
                array_push($response_arr, 'false', 'Some Error Occured Please Try Later', '#');
            }
        } else {
            array_push($response_arr, 'false', 'No Data Found', "#");
        }
    } else {
        array_push($response_arr, 'false', 'Please Fill All Required Fields', "#");
    }
echo json_encode($response_arr);
}

?>