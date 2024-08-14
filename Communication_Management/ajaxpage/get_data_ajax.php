<?php
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}
require_once "../../classfile/initialize.php";
require_once "../../classfile/compliance_certificate_management.php";

if (isset($_POST["isset_dependent_entityType"])) {
    $entity_type_id = $_POST["selected_id"];
    if ($_SESSION['user_id'] == 'USM-U1') {
        $entityData = $ccm_query->fetch_data($conn, "sfa_ent_mst_entity", "*", "fk_sfa_cnf_entitytype_id='$entity_type_id' and transaction_status='1'");
    } else {
        // get the level of user
        $userLevel = $ccm_query->fetch_data($conn, "usm_add_users", "user_level", "pk_usm_user_id='$_SESSION[user_id]'");

        $condition = "pk_sfa_ent_entity_id IN (SELECT kitchen_id FROM cpl_define_kitchen_rights WHERE ";
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

        $entityData = $ccm_query->fetch_data($conn, "sfa_ent_mst_entity", "*", $condition);
    }

    echo "<option value=''>Select Entity</option>";
    if ($entityData != 0) {
        foreach ($entityData as $row) {
            echo "<option value='$row[pk_sfa_ent_entity_id]'>$row[entity_name] ($row[pk_sfa_ent_entity_id])</option>";
        }
    } else {
        echo "<option value=''>No Entity Added in this Entity Type</option>";
    }
}

if (isset($_POST['isset_get_mail_msg_manually'])) {
    // $result = $ccm_query->fetch_data($conn, "cpl_compliance_type", "*", "1");
    $fetch_data = $ccm_query->fetch_data($conn, "cpl_compliance_send_alert as a left join sfa_ent_mst_entity as b on a.fk_sfa_ent_entity_id=b.pk_sfa_ent_entity_id left join cpl_compliance_type as c on a.fk_cpl_compliancetype_id=c.pk_cpl_compliancetype_id  left join cpl_compliance_master as d on a.fk_cpl_compliance_id=d.pk_cpl_compliance_id left join usm_add_users as e on a.fk_usm_user_id=e.pk_usm_user_id", "a.*,b.entity_name,c.compliance_name,d.expiry_date,e.user_email,e.user_name,e.primary_contact_no as contact_no", "a.send_status='0' AND b.transaction_status='1' AND c.transaction_status='1' AND d.transaction_status='1' AND e.transaction_status='1' ");
    if ($fetch_data != 0) {
?>
        <div class="box">
            <!-- /.box-header -->
            <div class="box-body">
                <table id="regservice" class="table table-bordered table-hover display nowrap margin-top-10 table-responsive">
                    <thead>
                        <tr>
                            <th width='8%'>S. No</th>
                            <th>Compliance Name</th>
                            <th>Establishment ID</th>
                            <th>Establishment Name</th>
                            <th>Expiry Date</th>
                            <th>Name</th>
                            <th>Email ID</th>
                            <th width='6%'>Action</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php
                        $slno = 1;
                        foreach ($fetch_data as $row) {
                        ?>
                            <tr>
                                <td>
                                    <?php echo $slno ?>
                                </td>
                                <td>
                                    <?php echo $row['compliance_name'] ?>
                                </td>
                                <td>
                                    <?php echo $row['fk_sfa_ent_entity_id'] ?>
                                </td>
                                <td>
                                    <?php echo $row['entity_name'] ?>
                                </td>
                                <td>
                                    <?php echo $row['expiry_date'] ?>
                                </td>
                                <td>
                                    <?php echo $row['user_name'] ?>
                                </td>
                                <td>
                                    <?php echo $row['user_email'] ?>
                                </td>
                                <td>
                                    <a href='javascript:void(0)' class='btn btn-sm btn-success' onclick="sendMailMsg('<?php echo $row['pk_comliance_send_alert_id'] ?>',this)"><i class='fa fa-telegram'></i> Send</a>
                                </td>
                            </tr>
                        <?php $slno++;
                        } ?>
                    </tbody>
                </table>


            </div>
            <!-- /.box-body -->
        </div>
    <?php
    } else {
        echo "<div class='alert alert-danger mt-3'>No Mail to Send</div>";
    }
}



if (isset($_POST['isset_get_whatsapp_msg_manually'])) {
    // $result = $ccm_query->fetch_data($conn, "cpl_compliance_type", "*", "1");
    $fetch_data = $ccm_query->fetch_data($conn, "cpl_compliance_send_alert as a left join sfa_ent_mst_entity as b on a.fk_sfa_ent_entity_id=b.pk_sfa_ent_entity_id left join cpl_compliance_type as c on a.fk_cpl_compliancetype_id=c.pk_cpl_compliancetype_id  left join cpl_compliance_master as d on a.fk_cpl_compliance_id=d.pk_cpl_compliance_id left join usm_add_users as e on a.fk_usm_user_id=e.pk_usm_user_id", "a.*,b.entity_name,c.compliance_name,d.expiry_date,e.user_email,e.user_name,e.primary_contact_no as contact_no", "a.whatsapp_send_status='0' AND b.transaction_status='1' AND c.transaction_status='1' AND d.transaction_status='1' AND e.transaction_status='1' ");
    if ($fetch_data != 0) {
    ?>
        <div class="box">
            <!-- /.box-header -->
            <div class="box-body">
                <table id="regservice" class="table table-bordered table-hover display nowrap margin-top-10 table-responsive">
                    <thead>
                        <tr>
                            <th width='8%'>S. No</th>
                            <th>Compliance Name</th>
                            <th>Establishment ID</th>
                            <th>Establishment Name</th>
                            <th>Expiry Date</th>
                            <th>Name</th>
                            <th>Contact No</th>
                            <th width='6%'>Action</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php
                        $slno = 1;
                        foreach ($fetch_data as $row) {
                        ?>
                            <tr>
                                <td>
                                    <?php echo $slno ?>
                                </td>
                                <td>
                                    <?php echo $row['compliance_name'] ?>
                                </td>
                                <td>
                                    <?php echo $row['fk_sfa_ent_entity_id'] ?>
                                </td>
                                <td>
                                    <?php echo $row['entity_name'] ?>
                                </td>
                                <td>
                                    <?php echo $row['expiry_date'] ?>
                                </td>
                                <td>
                                    <?php echo $row['user_name'] ?>
                                </td>
                                <td>
                                    <?php echo $row['contact_no'] ?>
                                </td>
                                <td>
                                    <a href='javascript:void(0)' class='btn btn-sm btn-success' onclick="sendWhatsappMsg('<?php echo $row['pk_comliance_send_alert_id'] ?>')"><i class='fa fa-telegram'></i> Send</a>
                                </td>
                            </tr>
                        <?php $slno++;
                        } ?>
                    </tbody>
                </table>


            </div>
            <!-- /.box-body -->
        </div>
    <?php
    } else {
        echo "<div class='alert alert-danger mt-3'>No Whatsapp Message to Send</div>";
    }
}




if (isset($_POST['isset_get_whatsapp_msg_report'])) {
    $establishmentType = trim($_POST['establishmentType']);
    $establishment = trim($_POST['establishment']);
    $certificate_type = trim($_POST['certificate_type']);
    $status = trim($_POST['status']);
    $send_type = trim($_POST['send_type']);
    $user = trim($_POST['user']);
    $date_form = trim($_POST['date_form']);
    $date_to = trim($_POST['date_to']);

    $condition = "b.transaction_status='1' AND c.transaction_status='1' AND d.transaction_status='1' AND e.transaction_status='1' ";

    if ($establishmentType != '') {
        $condition .= " AND b.fk_sfa_cnf_entitytype_id='$establishmentType'";
    }
    if ($establishment != '') {
        $condition .= " AND a.fk_sfa_ent_entity_id='$establishment'";
    }
    if ($certificate_type != '') {
        $condition .= " AND a.fk_cpl_compliancetype_id='$certificate_type'";
    }
    if ($status != '') {
        $condition .= " AND a.whatsapp_send_status='$status'";
    }
    if ($send_type != '') {
        $condition .= " AND a.send_whatsapp_msg_type='$send_type'";
    }
    if ($user != '') {
        $condition .= " AND a.fk_usm_user_id='$user'";
    }
    if ($date_form != '' && $date_to != '') {
        $condition .= " AND a.whatsapp_msg_send_date BETWEEN '$date_form' AND '$date_to'";
    }
    $fetch_data = $ccm_query->fetch_data($conn, "cpl_compliance_send_alert as a left join sfa_ent_mst_entity as b on a.fk_sfa_ent_entity_id=b.pk_sfa_ent_entity_id left join cpl_compliance_type as c on a.fk_cpl_compliancetype_id=c.pk_cpl_compliancetype_id  left join cpl_compliance_master as d on a.fk_cpl_compliance_id=d.pk_cpl_compliance_id left join usm_add_users as e on a.fk_usm_user_id=e.pk_usm_user_id", "a.*,b.entity_name,c.compliance_name,d.expiry_date,e.user_email,e.user_name,e.primary_contact_no as contact_no", $condition);
    if ($fetch_data != 0) {
    ?>
        <div class="box">
            <!-- /.box-header -->
            <div class="box-body">
                <table id="regservice" class="table table-bordered table-hover display nowrap margin-top-10 table-responsive">
                    <thead>
                        <tr>
                            <th width='8%'>S. No</th>
                            <th>Compliance Name</th>
                            <th>Establishment ID</th>
                            <th>Establishment Name</th>
                            <th>Expiry Date</th>
                            <th>Name</th>
                            <th>Contact No</th>
                            <th style="width: 50%;">Whatsapp Message</th>
                            <th>Send Type</th>
                            <th>Send Date</th>
                            <th>Send Time</th>
                            <th>Status</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php
                        $slno = 1;
                        foreach ($fetch_data as $row) {
                        ?>
                            <tr>
                                <td>
                                    <?php echo $slno ?>
                                </td>
                                <td>
                                    <?php echo $row['compliance_name'] ?>
                                </td>
                                <td>
                                    <?php echo $row['fk_sfa_ent_entity_id'] ?>
                                </td>
                                <td>
                                    <?php echo $row['entity_name'] ?>
                                </td>
                                <td>
                                    <?php echo $row['expiry_date'] ?>
                                </td>
                                <td>
                                    <?php echo $row['user_name'] ?>
                                </td>
                                <td>
                                    <?php echo $row['contact_no'] ?>
                                </td>
                                <td>
                                    <?php echo $row['whatsapp_message'] ?>
                                </td>
                                <td>
                                    <?php
                                    echo $row['send_whatsapp_msg_type'];
                                    ?>
                                </td>
                                <td>
                                    <?php
                                    echo $row['whatsapp_msg_send_date'];
                                    ?>
                                </td>
                                <td>
                                    <?php
                                    echo $row['whatsapp_msg_send_time'];
                                    ?>
                                </td>
                                <td>
                                    <?php
                                    if ($row['whatsapp_send_status'] == 0) {
                                        echo "<span class='badge badge-warning'>Pending</span>";
                                    } else if ($row['whatsapp_send_status'] == 1) {
                                        echo "<span class='badge badge-success'>Sent</span>";
                                    } else if ($row['whatsapp_send_status'] == -1) {
                                        echo "<span class='badge badge-danger'>Failed</span>";
                                    }
                                    ?>
                            </tr>
                        <?php $slno++;
                        } ?>
                    </tbody>
                </table>
            </div>
            <!-- /.box-body -->
        </div>

    <?php
    } else {
        echo "<div class='alert alert-danger mt-3'>No Whatsapp Message Sent</div>";
    }
}


if (isset($_POST['isset_get_mail_report'])) {
    $establishmentType = trim($_POST['establishmentType']);
    $establishment = trim($_POST['establishment']);
    $certificate_type = trim($_POST['certificate_type']);
    $status = trim($_POST['status']);
    $send_type = trim($_POST['send_type']);
    $user = trim($_POST['user']);
    $date_form = trim($_POST['date_form']);
    $date_to = trim($_POST['date_to']);

    $condition = "b.transaction_status='1' AND c.transaction_status='1' AND d.transaction_status='1' AND e.transaction_status='1' ";

    if ($establishmentType != '') {
        $condition .= " AND b.fk_sfa_cnf_entitytype_id='$establishmentType'";
    }
    if ($establishment != '') {
        $condition .= " AND a.fk_sfa_ent_entity_id='$establishment'";
    }
    if ($certificate_type != '') {
        $condition .= " AND a.fk_cpl_compliancetype_id='$certificate_type'";
    }
    if ($status != '') {
        $condition .= " AND a.send_status='$status'";
    }
    if ($send_type != '') {
        $condition .= " AND a.send_message_type='$send_type'";
    }
    if ($user != '') {
        $condition .= " AND a.fk_usm_user_id='$user'";
    }
    if ($date_form != '' && $date_to != '') {
        $condition .= " AND a.send_mail_date BETWEEN '$date_form' AND '$date_to'";
    }



    $fetch_data = $ccm_query->fetch_data($conn, "cpl_compliance_send_alert as a left join sfa_ent_mst_entity as b on a.fk_sfa_ent_entity_id=b.pk_sfa_ent_entity_id left join cpl_compliance_type as c on a.fk_cpl_compliancetype_id=c.pk_cpl_compliancetype_id  left join cpl_compliance_master as d on a.fk_cpl_compliance_id=d.pk_cpl_compliance_id left join usm_add_users as e on a.fk_usm_user_id=e.pk_usm_user_id", "a.*,b.entity_name,c.compliance_name,d.expiry_date,e.user_email,e.user_name,e.primary_contact_no as contact_no", $condition);
    if ($fetch_data != 0) {
    ?>
        <div class="box">
            <!-- /.box-header -->
            <div class="box-body">
                <table id="regservice" class="table table-bordered table-hover display nowrap margin-top-10 table-responsive">
                    <thead>
                        <tr>
                            <th width='8%'>S. No</th>
                            <th>Compliance Name</th>
                            <th>Establishment ID</th>
                            <th>Establishment Name</th>
                            <th>Expiry Date</th>
                            <th>Name</th>
                            <th>Email</th>
                            <th style="width: 50%;">Message</th>
                            <th>Send Type</th>
                            <th>Send Date</th>
                            <th>Send Time</th>
                            <th>Status</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php
                        $slno = 1;
                        foreach ($fetch_data as $row) {
                        ?>
                            <tr>
                                <td>
                                    <?php echo $slno ?>
                                </td>
                                <td>
                                    <?php echo $row['compliance_name'] ?>
                                </td>
                                <td>
                                    <?php echo $row['fk_sfa_ent_entity_id'] ?>
                                </td>
                                <td>
                                    <?php echo $row['entity_name'] ?>
                                </td>
                                <td>
                                    <?php echo $row['expiry_date'] ?>
                                </td>
                                <td>
                                    <?php echo $row['user_name'] ?>
                                </td>
                                <td>
                                    <?php echo $row['user_email'] ?>
                                </td>
                                <td>
                                    <?php echo $row['sended_message'] ?>
                                </td>
                                <td>
                                    <?php
                                    echo $row['send_message_type'];
                                    ?>
                                </td>
                                <td>
                                    <?php
                                    echo $row['send_mail_date'];
                                    ?>
                                </td>
                                <td>
                                    <?php
                                    echo $row['send_mail_time'];
                                    ?>
                                </td>
                                <td>
                                    <?php
                                    if ($row['send_status'] == 0) {
                                        echo "<span class='badge badge-warning'>Pending</span>";
                                    } else if ($row['send_status'] == 1) {
                                        echo "<span class='badge badge-success'>Sent</span>";
                                    } else if ($row['send_status'] == -1) {
                                        echo "<span class='badge badge-danger'>Failed</span>";
                                    }
                                    ?>
                            </tr>
                        <?php $slno++;
                        } ?>
                    </tbody>
                </table>
            </div>
            <!-- /.box-body -->
        </div>

<?php
    } else {
        echo "<div class='alert alert-danger mt-3'>No Data Found</div>";
    }
}

?>