<?php
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}
require_once "../../classfile/initialize.php";
require_once "../../classfile/rent_management.php";
$update_by = $_SESSION['user_id'];
$update_date = date('d-m-Y');
$update_time = date('h:i:s A');
$update_system = 'Web';
$ins_by = $_SESSION['user_id'];
$ins_date_time = date('d-m-Y h:i:s A');
$ins_system = 'Web';
$ins_ip = $abc->get_client_ip();

$status = 1;

if (isset($_POST['isset_acceptRejectRentDetail'])) {
    $renthst_id = trim($_POST['renthst_id']);
    $kitchen_id = trim($_POST['kitchen_id']);
    $remark = trim($_POST['remark']);
    $submissionType = trim($_POST['submissionType']);

    $response_array = array();
    $conn->beginTransaction();

    if ($renthst_id != ''  && $submissionType != '' && (($submissionType == 'verify') || ($submissionType == 'reject' && $remark != ''))) {
        $fetch_data = $rent_query->fetch_data($conn, "cpl_rent_master_hst", "*", "pk_cpl_renthst_id='$renthst_id'");
        if ($fetch_data != 0) {

            // $checkRowInMaster = 0;
            $checkRowInMaster = $rent_query->fetch_data($conn, "cpl_rent_master", "*", "fk_sfa_ent_entity_id='" . $fetch_data[0]['fk_sfa_ent_entity_id'] . "'");
            if ($checkRowInMaster != 0) {
                $primary_key = $checkRowInMaster[0]['pk_cpl_rent_id'];
            } else if ($checkRowInMaster == 0) {
                $max_id = $rent_query->fetch_data($conn, "cpl_rent_master", " max(id) as max_id", "1");
                $max_id = $max_id[0]['max_id'] + 1;

                $primary_key = "RNT" . $max_id;
            }


            /* The above PHP code is fetching the maximum value of the 'id' column from the
            'cpl_rent_master' table using the fetch_data method of the  object. The
            fetch_data method is likely a custom method that executes a query on the database
            connection represented by  and returns the result. The query being executed is
            selecting the maximum value of the 'id' column and aliasing it as 'max_id'. The "1" in
            the query may indicate a condition or limit for the query. */
            $max_id = $rent_query->fetch_data($conn, "cpl_rent_master", " max(id) as max_id", "1");
            $max_id = $max_id[0]['max_id'] + 1;

            $primary_key = "RNT" . $max_id;

            $VerificationStatus = 0;
            if ($submissionType == 'verify') {
                $VerificationStatus = 1;
            } else if ($submissionType == 'reject') {
                $VerificationStatus = -1;
            }
            $update_arr = ['fk_cpl_rent_id' => $primary_key, 'verification_status' => $VerificationStatus, 'verified_by' => $update_by, 'verification_date' => $update_date, 'verification_time' => $update_time, 'verification_remark' => $remark, 'update_by' => $update_by, 'update_date' => $update_date, 'update_ip' => $ins_ip, 'update_system' => $update_system];
            $condition = ['pk_cpl_renthst_id' => $renthst_id];
            $updateStatus = $rent_query->UpdateData($conn, 'cpl_rent_master_hst', $update_arr, $condition);

            if ($updateStatus != 1) {
                $conn->rollback();
                array_push($response_array, 'false', 'Error in updating the status', '#');
            }



            if ($VerificationStatus == 1) {
                foreach ($fetch_data as $d) {
                    if ($checkRowInMaster == 0) {
                        // insert the data into the main table
                        $inserted_arr = ['pk_cpl_rent_id' => $primary_key, 'fk_sfa_ent_entity_id' => $d['fk_sfa_ent_entity_id'], 'area_sqft' => $d['area_sqft'],'rent_expiry_date' => $d['rent_expiry_date'], 'rent_alert_l1' => $d['rent_alert_l1'], 'rent_alert_l2' => $d['rent_alert_l2'], 'rent_alert_l3' => $d['rent_alert_l3'], 'rent_alert_l4' => $d['rent_alert_l4'], 'notice_period' => $d['notice_period'], 'lockin_date' => $d['lockin_date'], 'monthly_rent' => $d['monthly_rent'], 'kitchen_rent_security_deposit' => $d['kitchen_rent_security_deposit'], 'staff_room_applicable' => $d['staff_room_applicable'], 'staffroom_expiry_date' => $d['staffroom_expiry_date'], 'staffroom_expiry_alert_l1' => $d['staffroom_expiry_alert_l1'], 'staffroom_expiry_alert_l2' => $d['staffroom_expiry_alert_l2'], 'staffroom_expiry_alert_l3' => $d['staffroom_expiry_alert_l3'], 'staffroom_expiry_alert_l4' => $d['staffroom_expiry_alert_l4'], 'staff_room_rent' => $d['staff_room_rent'], 'staff_room_security_deposit' => $d['staff_room_security_deposit'], 'verified_by' => $update_by, 'verification_date' => $update_date, 'verification_time' => $update_time, 'verification_remark' => $remark, 'verification_status' => $status, 'ins_by' => $ins_by, 'ins_date' => $ins_date_time, 'ins_ip' => $ins_ip, 'ins_system' => $ins_system,];

                        $insertedStatus = $rent_query->InsertData($conn, 'cpl_rent_master', $inserted_arr);
                        if ($insertedStatus === true) {
                            $conn->commit();
                            array_push($response_array, 'true', 'Data updated successfully', '#verifyRentDetails');
                        }else{
                            $conn->rollback();
                            array_push($response_array, 'false', 'Error in updating the status', '#');
                        }
                    } else{
                        // update the data in the main table
                        $update_arr = ['area_sqft' => $d['area_sqft'],'rent_expiry_date' => $d['rent_expiry_date'], 'rent_alert_l1' => $d['rent_alert_l1'], 'rent_alert_l2' => $d['rent_alert_l2'], 'rent_alert_l3' => $d['rent_alert_l3'], 'rent_alert_l4' => $d['rent_alert_l4'], 'notice_period' => $d['notice_period'], 'lockin_date' => $d['lockin_date'], 'monthly_rent' => $d['monthly_rent'], 'kitchen_rent_security_deposit' => $d['kitchen_rent_security_deposit'], 'staff_room_applicable' => $d['staff_room_applicable'], 'staffroom_expiry_date' => $d['staffroom_expiry_date'], 'staffroom_expiry_alert_l1' => $d['staffroom_expiry_alert_l1'], 'staffroom_expiry_alert_l2' => $d['staffroom_expiry_alert_l2'], 'staffroom_expiry_alert_l3' => $d['staffroom_expiry_alert_l3'], 'staffroom_expiry_alert_l4' => $d['staffroom_expiry_alert_l4'], 'staff_room_rent' => $d['staff_room_rent'], 'staff_room_security_deposit' => $d['staff_room_security_deposit'], 'verified_by' => $update_by, 'verification_date' => $update_date, 'verification_time' => $update_time, 'verification_remark' => $remark, 'verification_status' => $status, 'update_by' => $update_by, 'update_date' => $update_date, 'update_ip' => $ins_ip, 'update_system' => $update_system];

                        $condition = ['fk_sfa_ent_entity_id' => $d['fk_sfa_ent_entity_id']];
                        $updateStatus = $rent_query->UpdateData($conn, 'cpl_rent_master', $update_arr, $condition);
                        if ($updateStatus == 1) {
                            $conn->commit();
                            array_push($response_array, 'true', 'Data updated successfully', '#verifyRentDetails');
                        }else{
                            $conn->rollback();
                            array_push($response_array, 'false', 'Error in updating the status', '#');
                        }
                    }
                }
            } else {
                $conn->commit();
                array_push($response_array, 'true', 'Data updated successfully', '#verifyRentDetails');
            }
        } else {
            array_push($response_array, 'false', 'No data found', '#');
        }
    } else {
        if ($submissionType == 'reject' && $remark == '') {
            array_push($response_array, 'false', 'Please enter the remark', '#');
        } else {
            array_push($response_array, 'false', 'Please enter the required fields', '#');
        }
    }

    echo json_encode($response_array);
}


if (isset($_POST['isset_acceptRejectAgreementDetails'])) {
    $agreementhst_id = trim($_POST['agreementhst_id']);
    $kitchen_id = trim($_POST['kitchen_id']);
    $remark = trim($_POST['remark']);
    $submissionType = trim($_POST['submissionType']);

    $response_array = array();
    $conn->beginTransaction();

    if ($agreementhst_id != ''  && $submissionType != '' && (($submissionType == 'verify') || ($submissionType == 'reject' && $remark != ''))) {
        $fetch_data = $rent_query->fetch_data($conn, "cpl_rent_agreement_hst", "*", "pk_cpl_renthstagreement_id='$agreementhst_id'");
        if ($fetch_data != 0) {

            $max_id = $rent_query->fetch_data($conn, "cpl_rent_agreement", " max(id) as max_id", "1");
            $max_id = $max_id[0]['max_id'] + 1;
            $primary_key = "AGR" . $max_id;

            if ($submissionType == 'verify') {
                $VerificationStatus = 1;
            } else if ($submissionType == 'reject') {
                $VerificationStatus = -1;
            }

            $d = $fetch_data[0];

            // insert the data into the main table


            $update_arr = ['verification_status' => $VerificationStatus, 'verified_by' => $update_by, 'verification_date' => $update_date, 'verification_time' => $update_time, 'verification_remark' => $remark, 'update_by' => $update_by, 'update_date' => $update_date, 'update_ip' => $ins_ip, 'update_system' => $update_system];
            $condition = ['pk_cpl_renthstagreement_id' => $agreementhst_id];
            $updateStatus = $rent_query->UpdateData($conn, 'cpl_rent_agreement_hst', $update_arr, $condition);
            if ($updateStatus != 1) {
                $conn->rollback();
                array_push($response_array, 'false', 'Error in updating the status', '#');
            }
            if ($VerificationStatus == 1) {
                $inserted_arr = [
                    'pk_cpl_rentagreement_id' => $primary_key, 'fk_sfa_ent_entity_id' => $d['fk_sfa_ent_entity_id'], 'fk_cpl_compliancetype_id' => $d['fk_cpl_compliancetype_id'], 'agreement_date' => $d['agreement_date'], 'agreement_expiry_date' => $d['agreement_expiry_date'], 'alert_user_l1' => $d['alert_user_l1'], 'alert_user_l2' => $d['alert_user_l2'], 'alert_user_l3' => $d['alert_user_l3'], 'alert_user_l4' => $d['alert_user_l4'], 'agreement_amount' => $d['agreement_amount'], 'agreement_file' => $d['agreement_file'], 'agreement_remark' => $d['agreement_remark'], 'verification_status' => $VerificationStatus, 'verified_by' => $update_by,
                    'verification_date' => $update_date, 'verification_time' => $update_time, 'verification_remark' => $remark, 'ins_by' => $ins_by, 'ins_date' => $ins_date_time, 'ins_ip' => $ins_ip, 'ins_system' => $ins_system, 'update_by' => $update_by, 'update_date' => $update_date, 'update_ip' => $ins_ip, 'update_system' => $update_system
                ];

                $insertedStatus = $rent_query->InsertData($conn, 'cpl_rent_agreement', $inserted_arr);
                if ($insertedStatus != 1) {
                    $conn->rollback();
                    array_push($response_array, 'false', 'Error in updating the status', '#');
                }

                // get the landloard details
                $landlord_details = $rent_query->fetch_data($conn, "cpl_rent_landlords_hst", "*", "fk_cpl_rentagreement_id='$agreementhst_id'");

                foreach ($landlord_details as $ld) {
                    $landlord_id = $rent_query->fetch_data($conn, "cpl_rent_landlords", " max(id) as max_id", "1");
                    $landlord_id = $landlord_id[0]['max_id'] + 1;
                    $landlord_primary_key = "LND" . $landlord_id;
                    $name = $ld['landlord_name'];
                    $address = $ld['landlord_address'];
                    $country = $ld['country_id'];
                    $state = $ld['state_id'];
                    $city = $ld['city_id'];
                    $mobile = $ld['mobile_no'];
                    $email = $ld['email_id'];
                    $percentage = $ld['agreement_percentage'];
                    $landlord_inserted_value = ['pk_cpl_rentlandlord_id' => $landlord_primary_key, 'fk_cpl_rentagreement_id' => $primary_key, 'landlord_name' => $name, 'landlord_address' => $address, 'country_id' => $country, 'state_id' => $state, 'city_id' => $city, 'mobile_no' => $mobile, 'email_id' => $email, 'agreement_percentage' => $percentage, 'transaction_status' => $status, 'ins_by' => $ins_by, 'ins_date' => $ins_date_time, 'ins_ip' => $ins_ip, 'ins_system' => $ins_system];
                    $landlord_inserted = $rent_query->InsertData($conn, "cpl_rent_landlords", $landlord_inserted_value);
                    if ($landlord_inserted != '1') {
                        $conn->rollback();
                        array_push($response_array, 'false', 'Error in inserting the Landlord Details', '#');
                    }
                }

                if ($insertedStatus == '1') {
                    $conn->commit();
                    array_push($response_array, 'true', 'Agreement Details Added Successfully', '#getAllAgreement');
                } else {
                    $conn->rollback();
                    array_push($response_array, 'false', 'Agreement Details Not Added', '#');
                }
            } else {
                $conn->commit();
                array_push($response_array, 'true', 'Agreement Rejected successfully', '#getAllAgreement');
            }
        } else {
            array_push($response_array, 'false', 'No data found', '#');
        }
    } else {
        if ($submissionType == 'reject' && $remark == '') {
            array_push($response_array, 'false', 'Please enter the remark', '#');
        } else {
            array_push($response_array, 'false', 'Please enter the required fields', '#');
        }
    }

    echo json_encode($response_array);
}
