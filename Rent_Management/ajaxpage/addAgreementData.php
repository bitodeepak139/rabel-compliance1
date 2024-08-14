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
$status = 1;

if (isset($_POST['isset_add_agreement_data'])) {
    $agreement_type = trim($_POST['agreement_type']);
    $agreement_date = trim($_POST['agreement_date']);
    $agreement_expiry_date = trim($_POST['agreement_expiry_date']);
    $agreement_amount = trim($_POST['agreement_amount']);
    $no_of_landlords = trim($_POST['no_of_landlords']);
    $agreement_remark = trim($_POST['agreement_remark']);
    if ($no_of_landlords != '' && $no_of_landlords != 0) {
        $landlord_name = $_POST['landlord_name'];
        $landlord_address = $_POST['landlord_address'];
        $landlord_country = $_POST['landlord_country'];
        $landlord_state = $_POST['landlord_state'];
        $landlord_city = $_POST['landlord_city'];
        $landlord_mobile = $_POST['landlord_mobile'];
        $landlord_email = $_POST['landlord_email'];
        $landlord_percentage = $_POST['landlord_percentage'];
    }

    $id = trim($_POST['id']);

    $response_array = array();
    $conn->beginTransaction();


    if ($agreement_type != '' && $agreement_date != '' && $agreement_expiry_date != '' && $agreement_amount != '' && $no_of_landlords != '' && $agreement_remark != '' && $id != '') {
        if (in_array('', $landlord_name)) {
            array_push($response_array, 'false', 'Landlord Name is Required', '#');
        } else if (in_array('', $landlord_address)) {
            array_push($response_array, 'false', 'Landlord Address is Required', '#');
        } else if (in_array('', $landlord_country)) {
            array_push($response_array, 'false', 'Landlord Country is Required', '#');
        } else if (in_array('', $landlord_state)) {
            array_push($response_array, 'false', 'Landlord State is Required', '#');
        } else if (in_array('', $landlord_city)) {
            array_push($response_array, 'false', 'Landlord City is Required', '#');
        } else if (in_array('', $landlord_mobile)) {
            array_push($response_array, 'false', 'Landlord Mobile is Required', '#');
        } else if (in_array('', $landlord_email)) {
            array_push($response_array, 'false', 'Landlord Email is Required', '#');
        } else if (in_array('', $landlord_percentage)) {
            array_push($response_array, 'false', 'Landlord Percentage is Required', '#');
        } else if (array_sum($landlord_percentage) != 100) {
            array_push($response_array, 'false', 'Landlord Percentage must be 100%', '#');
        } else if ($_FILES['agreement_document']['name'] == '') {
            array_push($response_array, 'false', 'Agreement Document is Required', '#');
        } else {

            $max_id = $rent_query->fetch_data($conn, "cpl_rent_agreement_hst", " max(id) as max_id", "1");
            $max_id = $max_id[0]['max_id'] + 1;

            $primary_key = "AGRH" . $max_id;

            // upload the file in the folder

            // create the folder
            if (!file_exists('../../upload/agreements/')) {
                mkdir('../../upload/agreements/' . $primary_key, 0777, true);
            }
            $target_Dir = '../../upload/agreements/';
            $agreementFile = $rent_query->RenameImage('agreement_document');
            $agreementFileName = $rent_query->uploadImage('agreement_document', $agreementFile, $target_Dir, array('PDF', 'pdf'));
            if ($agreementFileName['status'] == 0) {
                array_push($response_array, 'false', $agreementFileName['msg'], '#');
                echo json_encode($response_array);
                die();
            } else {

                $fetch_data_due_date = $rent_query->fetch_data($conn, "cpl_compliance_type", "*", "pk_cpl_compliancetype_id='$agreement_type'");
                if ($fetch_data_due_date != 0) {
                    foreach ($fetch_data_due_date as $dueDate) {
                        $L1Day = '-' . $dueDate['L1Day'] . ' days';
                        $L2Day = '-' . $dueDate['L2Day'] . ' days';
                        $L3Day = '-' . $dueDate['L3Day'] . ' days';
                        $L4Day = '-' . $dueDate['L4Day'] . ' days';
                        $alert_dateL1 = date('d-m-Y', strtotime($agreement_expiry_date . $L1Day));
                        $alert_dateL2 = date('d-m-Y', strtotime($agreement_expiry_date . $L2Day));
                        $alert_dateL3 = date('d-m-Y', strtotime($agreement_expiry_date . $L3Day));
                        $alert_dateL4 = date('d-m-Y', strtotime($agreement_expiry_date . $L4Day));
                    }
                }



                $inserted_value = ['pk_cpl_renthstagreement_id' => $primary_key, 'fk_sfa_ent_entity_id' => $id, 'fk_cpl_compliancetype_id' => $agreement_type, 'agreement_date' => $agreement_date, 'agreement_expiry_date' => $agreement_expiry_date, 'alert_user_l1' => $alert_dateL1, 'alert_user_l2' => $alert_dateL2, 'alert_user_l3' => $alert_dateL3, 'alert_user_l4' => $alert_dateL4, 'agreement_amount' => $agreement_amount, 'agreement_file' => $agreementFile, 'agreement_remark' => $agreement_remark, 'verification_status' => 0, 'ins_by' => $update_by, 'ins_date' => $update_date, 'ins_ip' => $ip, 'ins_system' => $update_system];

                $inserted = $rent_query->InsertData($conn, "cpl_rent_agreement_hst", $inserted_value);

                for ($i = 0; $i < $no_of_landlords; $i++) {
                    $landlord_id = $rent_query->fetch_data($conn, "cpl_rent_landlords_hst", " max(id) as max_id", "1");
                    $landlord_id = $landlord_id[0]['max_id'] + 1;
                    $landlord_primary_key = "LNDH" . $landlord_id;
                    $name = $landlord_name[$i];
                    $address = $landlord_address[$i];
                    $country = $landlord_country[$i];
                    $state = $landlord_state[$i];
                    $city = $landlord_city[$i];
                    $mobile = $landlord_mobile[$i];
                    $email = $landlord_email[$i];
                    $percentage = $landlord_percentage[$i];
                    $landlord_inserted_value = ['pk_cpl_renthstlandlord_id' => $landlord_primary_key, 'fk_cpl_rentagreement_id' => $primary_key, 'landlord_name' => $name, 'landlord_address' => $address, 'country_id' => $country, 'state_id' => $state, 'city_id' => $city, 'mobile_no' => $mobile, 'email_id' => $email, 'agreement_percentage' => $percentage, 'transaction_status' => $status, 'ins_by' => $update_by, 'ins_date' => $update_date, 'ins_ip' => $ip, 'ins_system' => $update_system];
                    $landlord_inserted = $rent_query->InsertData($conn, "cpl_rent_landlords_hst", $landlord_inserted_value);
                    if ($landlord_inserted != '1') {
                        $conn->rollback();
                        array_push($response_array, 'false', 'Error in inserting the Landlord Details', '#');
                    }
                }


                if ($inserted == '1') {
                    $conn->commit();
                    array_push($response_array, 'true', 'Agreement Details Added Successfully', '#', '#', '#','#getAllAgreement');
                } else {
                    $conn->rollback();
                    array_push($response_array, 'false', 'Agreement Details Not Added', '#');
                }
            }
        }
    } else {
        if ($agreement_type == '') {
            array_push($response_array, 'false', 'Agreement Type is Required', '#');
        } else if ($agreement_date == '') {
            array_push($response_array, 'false', 'Agreement Date is Required', '#');
        } else if ($agreement_expiry_date == '') {
            array_push($response_array, 'false', 'Agreement Expiry Date is Required', '#');
        } else if ($agreement_amount == '') {
            array_push($response_array, 'false', 'Agreement Expenses is Required', '#');
        } else if ($no_of_landlords == '') {
            array_push($response_array, 'false', 'No of Landlords is Required', '#');
        } else if ($agreement_remark == '') {
            array_push($response_array, 'false', 'Agreement Remark is Required', '#');
        } else if ($id == '') {
            array_push($response_array, 'false', 'Entity ID is Required', '#');
        }
    }
    echo json_encode($response_array);
}
