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

if (isset($_POST['isset_update_rent_details'])) {
    $id = trim($_POST['id']);
    $kitchen_area = trim($_POST['kitchen_area']);
    $rent_expiry_date = trim($_POST['rent_expiry_date']);
    $notice_period = trim($_POST['notice_period']);
  
    $lockinPeriod = trim($_POST['lockinPeriod']);
    $monthly_rent = trim($_POST['monthly_rent']);
    $staffRoomApplicable = trim($_POST['staffRoomApplicable']);
    $kitchen_rent_security_deposit = trim($_POST['kitchen_rent_security_deposit']);
    $staff_room_expiry_date = trim($_POST['staff_room_expiry_date']);
    $staff_room_rent_amount = trim($_POST['staff_room_rent_amount']);
    $staff_room_security_deposit = trim($_POST['staff_room_security_deposit']);
    $response_array = array();
    $conn->beginTransaction();




    if ($id != '' && $kitchen_area != '' && $rent_expiry_date != '' && $notice_period != '' && $monthly_rent != '' && $staffRoomApplicable != '' && $kitchen_rent_security_deposit != '' && (($staffRoomApplicable == 1 && $staff_room_expiry_date != '' && $staff_room_rent_amount != '' && $staff_room_security_deposit != '') || ($staffRoomApplicable == 0))) {
        $staffRoomAlertDateL1 = '';
        $staffRoomAlertDateL2 = '';
        $staffRoomAlertDateL3 = '';
        $staffRoomAlertDateL4 = '';

        if ($staffRoomApplicable == 1 && $staff_room_expiry_date != '' && $staff_room_rent_amount != '' && $staff_room_security_deposit != '') {
            $fetch_data_due_date = $rent_query->fetch_data($conn, "cpl_compliance_type", "*", "pk_cpl_compliancetype_id='34'");
            if ($fetch_data_due_date != 0) {
                foreach ($fetch_data_due_date as $dueDate) {
                    $L1Day = '-' . $dueDate['L1Day'] . ' days';
                    $L2Day = '-' . $dueDate['L2Day'] . ' days';
                    $L3Day = '-' . $dueDate['L3Day'] . ' days';
                    $L4Day = '-' . $dueDate['L4Day'] . ' days';
                    $staffRoomAlertDateL1 = date('d-m-Y', strtotime($staff_room_expiry_date . $L1Day));
                    $staffRoomAlertDateL2 = date('d-m-Y', strtotime($staff_room_expiry_date . $L2Day));
                    $staffRoomAlertDateL3 = date('d-m-Y', strtotime($staff_room_expiry_date . $L3Day));
                    $staffRoomAlertDateL4 = date('d-m-Y', strtotime($staff_room_expiry_date . $L4Day));
                }
            }
        } else {
            $staff_room_expiry_date = '';
            $staff_room_rent_amount = '';
            $staff_room_security_deposit = '';
        }



        $rowCount = $rent_query->get_row_count_of_table($conn, "cpl_rent_master_hst", "*", "fk_sfa_ent_entity_id='$id' AND verification_status='0'");
        // $rowCount = 0;
        if ($rowCount == 0) {
            $RentAlertDateL1 = '';
            $RentAlertDateL2 = '';
            $RentAlertDateL3 = '';
            $RentAlertDateL4 = '';
            // insert the data in the database for the first time
            // get the max id in the table
            $max_id = $rent_query->fetch_data($conn, "cpl_rent_master_hst", " max(id) as max_id", "1");
            $max_id = $max_id[0]['max_id'] + 1;

            $primary_key = "RNTH" . $max_id;


            $fetch_data_due_date = $rent_query->fetch_data($conn, "cpl_compliance_type", "*", "pk_cpl_compliancetype_id='33'");
            if ($fetch_data_due_date != 0) {
                foreach ($fetch_data_due_date as $dueDate) {
                    $L1Day = '-' . $dueDate['L1Day'] . ' days';
                    $L2Day = '-' . $dueDate['L2Day'] . ' days';
                    $L3Day = '-' . $dueDate['L3Day'] . ' days';
                    $L4Day = '-' . $dueDate['L4Day'] . ' days';
                    $RentAlertDateL1 = date('d-m-Y', strtotime($rent_expiry_date . $L1Day));
                    $RentAlertDateL2 = date('d-m-Y', strtotime($rent_expiry_date . $L2Day));
                    $RentAlertDateL3 = date('d-m-Y', strtotime($rent_expiry_date . $L3Day));
                    $RentAlertDateL4 = date('d-m-Y', strtotime($rent_expiry_date . $L4Day));
                }
            }

            $inserted_value = [
                'pk_cpl_renthst_id' => $primary_key, 'fk_cpl_rent_id' => '', 'fk_sfa_ent_entity_id' => $id, 'area_sqft' => $kitchen_area,'rent_expiry_date' => $rent_expiry_date, 'rent_alert_l1' => $RentAlertDateL1, 'rent_alert_l2' => $RentAlertDateL2,
                'rent_alert_l3' => $RentAlertDateL3, 'rent_alert_l4' => $RentAlertDateL4, 'notice_period' => $notice_period, 'lockin_date' => $lockinPeriod, 'monthly_rent' => $monthly_rent, 'kitchen_rent_security_deposit' => $kitchen_rent_security_deposit, 'staff_room_applicable' => $staffRoomApplicable, 'staffroom_expiry_date' => $staff_room_expiry_date, 'staffroom_expiry_alert_l1' => $staffRoomAlertDateL1, 'staffroom_expiry_alert_l2' => $staffRoomAlertDateL2, 'staffroom_expiry_alert_l3' => $staffRoomAlertDateL3, 'staffroom_expiry_alert_l4' => $staffRoomAlertDateL4, 'staff_room_rent' => $staff_room_rent_amount, 'staff_room_security_deposit' => $staff_room_security_deposit, 'verification_status' => 0, 'ins_by' => $update_by, 'ins_date' => $update_date, 'ins_ip' => $ip, 'ins_system' => $update_system
            ];

            $inserted = $rent_query->InsertData($conn, "cpl_rent_master_hst", $inserted_value);
            if ($inserted == 1) {
                $conn->commit();
                array_push($response_array, 'true', "Rent Details Added Successfully", '#', '#', '#', '#getRentStatus');
            } else {
                $conn->rollBack();
                array_push($response_array, 'false', 'Error in Query', '#');
            }
        } else {
            array_push($response_array, 'false', 'Rent Is Already Pending For Verification', '#');
        }
    } else {
        if ($id == '') {
            array_push($response_array, 'false', 'Please Select Entity', '#');
        } else if ($kitchen_area == '') {
            array_push($response_array, 'false', 'Please Enter Kitchen Area', '#');
        } else if ($rent_expiry_date == '') {
            array_push($response_array, 'false', 'Please Enter Rent Expiry Date', '#');
        } else if ($kitchen_rent_security_deposit == '') {
            array_push($response_array, 'false', 'Please Enter Kitchen Rent Security Deposit', '#');
        } else if ($notice_period == '') {
            array_push($response_array, 'false', 'Please Enter Notice Period', '#');
        } else if ($monthly_rent == '') {
            array_push($response_array, 'false', 'Please Enter Monthly Rent', '#');
        } else if ($staffRoomApplicable == '') {
            array_push($response_array, 'false', 'Please Select Staff Room Applicable', '#');
        } else if ($staffRoomApplicable == 1 && $staff_room_expiry_date == '') {
            array_push($response_array, 'false', 'Please Enter Staff Room Expiry Date', '#');
        } else if ($staffRoomApplicable == 1 && $staff_room_rent_amount == '') {
            array_push($response_array, 'false', 'Please Enter Staff Room Rent Amount', '#');
        } else if ($staffRoomApplicable == 1 && $staff_room_security_deposit == '') {
            array_push($response_array, 'false', 'Please Enter Staff Room Security Deposit', '#');
        }
    }
    echo json_encode($response_array);
}
