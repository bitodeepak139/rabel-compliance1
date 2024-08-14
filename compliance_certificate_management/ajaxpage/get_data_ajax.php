<?php
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}
require_once "../../classfile/initialize.php";
require_once "../../classfile/compliance_certificate_management.php";

if (isset($_POST['isset_get_ccm_certificate_type'])) {
    $result = $ccm_query->fetch_data($conn, "cpl_compliance_type", "*", "1");
    if ($result != 0) {
        ?>
        <div class="box">
            <!-- /.box-header -->
            <div class="box-body">
                <table id="regservice" class="table table-bordered table-hover display nowrap margin-top-10 table-responsive">
                    <thead>
                        <tr>
                            <th width='8%'>S. No</th>
                            <th>Compliance Type</th>
                            <th>Compliance Name</th>
                            <th>L1 Day</th>
                            <th>L2 Day</th>
                            <th>L3 Day</th>
                            <th>L4 Day</th>
                            <th>Renewal Type</th>
                            <th>Details</th>
                            <th width='10%'>Status</th>
                            <th width='6%'>Action</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php
$slno = 1;
        $passname = "cpl_compliance_type-" . "transaction_status";
        foreach ($result as $row) {
            $id = $row['pk_cpl_compliancetype_id'];
            $compliance_name = $row['compliance_name'];
            $L1Day = $row['L1Day'];
            $L2Day = $row['L2Day'];
            $L3Day = $row['L3Day'];
            $L4Day = $row['L4Day'];
            $renewal_type = $row['renewal_type'];
            $compliance_details = $row['compliance_details'];
            $status = $row['transaction_status'];
            $stypeid = "pk_cpl_compliancetype_id-" . $id;
            ?>
                            <tr>
                                <td>
                                    <?php echo $slno ?>
                                </td>
                                <td>
                                    <?php echo $row['compliance_type'] ?>
                                </td>
                                <td>
                                    <?php echo $compliance_name ?>
                                </td>
                                <td>
                                    <?php echo $L1Day ?>
                                </td>
                                <td>
                                    <?php echo $L2Day ?>
                                </td>
                                <td>
                                    <?php echo $L3Day ?>
                                </td>
                                <td>
                                    <?php echo $L4Day ?>
                                </td>
                                <td>
                                    <?php echo $renewal_type ?>
                                </td>
                                <td>
                                    <?php echo $compliance_details ?>
                                </td>
                                <?php
if ($status == '1') {
                echo '<td> <span class="label-success label label-default">Active</span></td>';
            } else {
                echo '<td> <span class="label-default label label-danger">Block</span></td>';
            }

            ?>
                                <td><a href='javascript:void(0)' class='btn btn-danger btn-xs' id='blk<?php echo $stypeid; ?>' onClick="block('<?php echo $stypeid; ?>','<?php echo $passname; ?>','8')" <?php if ($status == 0) {?> style="display:none" <?php }?> title="Block Record">B</a>
                                    <a href='javascript:void(0)' class='btn btn-info btn-xs' id='act<?php echo $stypeid; ?>' onclick="actived('<?php echo $stypeid; ?>','<?php echo $passname; ?>','8')" <?php if ($status == 1) {?> style="display:none" <?php }?> title="Active Record">A</a>
                                    <a href="javascript:void(0)" class="btn btn-warning btn-xs" onClick="editpopup('<?php echo $id ?>','ajaxpage/edit_popup_cpl_certificate_type.php')" id="edt<?php echo $id ?>" title="Edit Details">E</a>
                                </td>
                            </tr>
                        <?php $slno++;
        }?>
                    </tbody>
                </table>


            </div>
            <!-- /.box-body -->
        </div>
    <?php
}
}

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
            echo "<option value='$row[pk_sfa_ent_entity_id]-$row[entity_name]'>$row[entity_name] ($row[pk_sfa_ent_entity_id])</option>";
        }
    } else {
        echo "<option value=''>No Entity Added in this Entity Type</option>";
    }
}
if (isset($_POST["isset_dependent_certificate_type"])) {
    $entity_data = $_POST["selected_id"];
    $entity_arr = explode("-", $entity_data);
    $entity_type_id = $entity_arr[0];
    $complianceData = $ccm_query->fetch_data($conn, "cpl_establishment_compliance as a left join cpl_compliance_type as b on a.fk_cpl_compliancetype_id=b.pk_cpl_compliancetype_id", "a.*,b.compliance_name", "a.fk_sfa_ent_entity_id='$entity_type_id' and a.transaction_status='1' and b.compliance_type='Compliance' and a.compliance_applicable='Yes'");
    echo "<option value=''>-Select-</option>";
    if ($complianceData != 0) {
        foreach ($complianceData as $row) {
            echo "<option value='$row[fk_cpl_compliancetype_id]'>$row[compliance_name] </option>";
        }
    } else {
        echo "<option value=''>No Certificate Added Yet</option>";
    }
}

if (isset($_POST["isset_getDataGridStatus"])) {
    $establishmentType = trim($_POST['entityType']);
    $entity_name = trim($_POST['entity_name']);
    $zone_name = trim($_POST['zone_name']);
    ?>
    <div class="box">
        <!-- /.box-header -->
        <div class="box-body">
            <table id='regservice' class="table table-bordered table-hover display nowrap margin-top-10 table-responsive">
                <thead>
                    <tr>
                        <th width='8%'>S. No</th>
                        <th>Zone Name</th>
                        <th>Establishment Name</th>
                        <?php
$fetch_compliance_type = $ccm_query->fetch_data($conn, 'cpl_compliance_type', '*', "transaction_status='1' and compliance_type='Compliance'");
    if ($fetch_compliance_type != 0) {
        foreach ($fetch_compliance_type as $row_compliance_type) {
            echo "<th>$row_compliance_type[compliance_name]</th>";
        }
    }
    ?>
                        <th width='6%'>Overall</th>
                    </tr>
                </thead>
                <tbody>
                    <?php
if ($_SESSION['user_id'] == 'USM-U1') {
        $conditions = "a.transaction_status='1'";

        if ($establishmentType != '') {
            $conditions .= " AND a.fk_sfa_cnf_entitytype_id='$establishmentType'";
        }
        if ($entity_name != '') {
            $entity_arr = explode("-", $entity_name);
            $entityId = $entity_arr[0];
            $conditions .= " AND a.pk_sfa_ent_entity_id='$entityId'";
        }
        if ($zone_name != '') {
            $conditions .= " AND a.zone_id='$zone_name'";
        }
        $fetch_data_zone_k = $ccm_query->fetch_data($conn, "sfa_ent_mst_entity as a left join cnf_mst_zone as b on a.zone_id=b.pk_cnf_zone_id", "a.*,b.zone_name", $conditions);
    } else {
        // get the level of user
        $userLevel = $ccm_query->fetch_data($conn, "usm_add_users", "user_level", "pk_usm_user_id='$_SESSION[user_id]'");

        $condition = "1";

        if ($establishmentType != '') {
            $condition .= " AND a.fk_sfa_cnf_entitytype_id='$establishmentType'";
        }
        if ($entity_name != '') {
            $entity_arr = explode("-", $entity_name);
            $entityId = $entity_arr[0];
            $condition .= " AND a.pk_sfa_ent_entity_id='$entityId'";
        }
        if ($zone_name != '') {
            $condition .= " AND a.zone_id='$zone_name'";
        }

        $condition .= " AND pk_sfa_ent_entity_id IN (SELECT kitchen_id FROM cpl_define_kitchen_rights WHERE ";
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

        $fetch_data_zone_k = $ccm_query->fetch_data($conn, "sfa_ent_mst_entity as a left join cnf_mst_zone as b on a.zone_id=b.pk_cnf_zone_id", "a.*,b.zone_name", $condition);
    }

    if ($fetch_data_zone_k != 0) {
        $sno = 1;
        foreach ($fetch_data_zone_k as $singleRowK) {
            ?>
                            <tr>
                                <td width='8%'><?php echo $sno; ?></td>
                                <td><?php echo $singleRowK['zone_name']; ?></td>
                                <td><?php echo $singleRowK['entity_name']; ?></td>
                                <?php
$overallStatus = 'not applicable';
            $overAllClass = 'NotApplicable';
            $fetch_compliance_type = $ccm_query->fetch_data($conn, 'cpl_compliance_type', '*', "transaction_status='1' and compliance_type='Compliance'");
            if ($fetch_compliance_type != 0) {

                foreach ($fetch_compliance_type as $row_compliance_type) {
                    $complianceTypeID = $row_compliance_type['pk_cpl_compliancetype_id'];
                    $kitchenID = $singleRowK['pk_sfa_ent_entity_id'];
                    $cpl_establishment_compliance = $ccm_query->fetch_data($conn, "cpl_establishment_compliance", "*", "fk_sfa_ent_entity_id='$kitchenID' AND fk_cpl_compliancetype_id='$complianceTypeID' AND compliance_applicable='Yes'");
                    if ($cpl_establishment_compliance != 0) {
                        $cpl_compliance_data = $ccm_query->fetch_data($conn, "cpl_compliance_master", "*", "fk_sfa_ent_entity_id='$kitchenID' AND fk_cpl_compliancetype_id='$complianceTypeID' AND transaction_status='1'");
                        if ($cpl_compliance_data != 0) {
                            foreach ($cpl_compliance_data as $singleCompliance) {
                                if ($singleCompliance['verification_status'] == '1') {
                                    $expiryDate = strtotime($singleCompliance['expiry_date']);
                                    $currentDate = strtotime(date('d-m-Y'));
                                    $L1AlertDate = strtotime($singleCompliance['renew_due_date_l1']);

                                    if (($expiryDate >= $currentDate) && ($L1AlertDate <= $currentDate)) {
                                        $overallStatus = 'complete';
                                        $overAllClass = 'Complied';
                                        echo "<td><span class='badge ExpiringSoon mb-2'>Expiring Soon</span></td>";
                                    } else if (($expiryDate > $currentDate) && ($L1AlertDate > $currentDate)) {
                                        $overallStatus = 'complete';
                                        $overAllClass = 'Complied';
                                        echo "<td><span class='badge Complied mb-2'>Complied</span></td>";
                                    } else if ($expiryDate < $currentDate) {
                                        $overallStatus = 'Incomplete';
                                        $overAllClass = 'Expired';
                                        echo "<td><span class='badge Expired mb-2'>Expired</span></td>";
                                    }
                                } else if ($singleCompliance['verification_status'] == '0') {
                                    $overallStatus = 'Incomplete';
                                    $overAllClass = 'Expired';
                                    echo "<td><span class='badge mb-2' style='background:orange;'>Verification Pending</span></td>";
                                }
                            }
                        } else {
                            $overallStatus = 'Incomplete';
                            $overAllClass = 'Expired';
                            echo "<td><span class='badge NotUpdate mb-2'>not update</span></td>";
                        }
                    } else {
                        echo "<td><span class='badge NotApplicable mb-2'>not appliable</span></td>";
                    }
                }
            }
            ?>
                                <td width='6%'><span class='badge <?php echo $overAllClass; ?>'><?php echo $overallStatus; ?></span>
                                </td>
                            </tr>
                    <?php
$sno++;
        }
    }

    ?>
                </tbody>
            </table>


        </div>
        <!-- /.box-body -->
    </div>
<?php
}

// isset_complianceVerification
if (isset($_POST['isset_complianceVerification'])) {
    $estiblishment = trim($_POST['entityType']);
    $entityName = trim($_POST['entity_name']);
    $zone_name = trim($_POST['zone_name']);
    $certificate_type = trim($_POST['certificate_type']);
    $date_form = trim($_POST['date_form']);
    $date_to = trim($_POST['date_to']);
    $status = trim($_POST['status']);
    ?>
    <div class="box">
        <!-- /.box-header -->
        <div class="box-body">
            <table id="regservice" class="table table-bordered table-hover display nowrap margin-top-10 table-responsive">
                <thead>
                    <tr>
                        <th width='8%'>Sr. No</th>
                        <th>Certificate Date</th>
                        <th>Certificate Type</th>
                        <th>Certificate No</th>
                        <th>Establishment Type</th>
                        <th>Licence Nominee</th>
                        <th>Uploaded By</th>
                        <th>Upload Date / Time</th>
                        <th>Status</th>
                        <th width='9%'>Action</th>
                    </tr>
                </thead>
                <tbody>
                    <?php
$condition = '1';
    if ($estiblishment != '') {
        $condition .= " AND d.fk_sfa_cnf_entitytype_id='$estiblishment' AND c.compliance_type='Compliance'";
    }
    if ($entityName != '') {
        $entity_arr = explode("-", $entityName);
        $entityId = $entity_arr[0];
        $condition .= " AND a.fk_sfa_ent_entity_id='$entityId'";
    }
    if ($zone_name != '') {
        $condition .= " AND d.zone_id='$zone_name'";
    }

    if ($certificate_type != '') {
        $condition .= " AND a.fk_cpl_compliancetype_id='$certificate_type'";
    }

    if ($date_form != '') {
        $condition .= " AND str_to_date(a.ins_date_time,'%d/%m/%Y') >= str_to_date('$date_form','%d/%m/%Y') ";
    }
    if ($date_to != '') {
        $condition .= " AND str_to_date(a.ins_date_time,'%d/%m/%Y') <= str_to_date('$date_to','%d/%m/%Y') ";
    }

    if ($status != '') {
        $condition .= " AND a.verification_status='$status'";
    }

    $compliance_verification = $ccm_query->fetch_data($conn, "cpl_compliance_master as a left join usm_add_users as b on a.ins_by = b.pk_usm_user_id left join cpl_compliance_type as c on a.fk_cpl_compliancetype_id = c.pk_cpl_compliancetype_id left join sfa_ent_mst_entity as d on a.fk_sfa_ent_entity_id=d.pk_sfa_ent_entity_id", "a.*,b.user_name,c.compliance_name,d.entity_name", $condition);
    $slno = 1;
    if ($compliance_verification != 0) {
        foreach ($compliance_verification as $Compliance_Certificate) {
            $verification_status = $Compliance_Certificate['verification_status'];
            if ($verification_status == '1') {
                $badge = "<span class='badge mb-1 bg-success'>Verified</span>";
                $button = "<a href='javascript:void(0)' class='badge mb-1 bg-info'
                onclick='verificationpopup($Compliance_Certificate[pk_cpl_compliance_id])'>Details</a>";
            } else if ($verification_status == '0') {
                $badge = "<span class='badge mb-1 bg-warning'>Pending</span>";
                $button = "<a href='ComplianceVerification2.php?pg=VlZSTkxWQTVNQT09&md=VlZOTkxVMHlNUT09&c_id=$Compliance_Certificate[pk_cpl_compliance_id]' target='_blank' class='NotApplicable badge mb-1'>Verify</a>";
            } else if ($verification_status == '-1') {
                $badge = "<span class='badge mb-1 bg-danger'>Rejected</span>";
                $button = "<a href='javascript:void(0)' class='badge mb-1 bg-info' onclick='rejectedpopup($Compliance_Certificate[pk_cpl_compliance_id])'>Details</a>";
            }
            echo "<tr>
                                <th width='8%'>$slno</th>
                                <th>$Compliance_Certificate[certification_date]</th>
                                <th>$Compliance_Certificate[compliance_name]</th>
                                <th>$Compliance_Certificate[certificate_no]</th>
                                <th>$Compliance_Certificate[entity_name]</th>
                                <th>$Compliance_Certificate[licence_nominee]</th>
                                <th>$Compliance_Certificate[user_name]</th>
                                <th>$Compliance_Certificate[ins_date_time]</th>
                                <th>$badge</th>
                                <th width='9%'>$button</th>
                            </tr>";
            $slno++;
        }
    }
    ?>
                </tbody>
            </table>


        </div>
        <!-- /.box-body -->
    </div>
<?php
}

if (isset($_POST['isset_complianceMIS'])) {
    $zone = trim($_POST['zone']);
    $status = trim($_POST['status']);
    $establishmentType = trim($_POST['establishmentType']);
    $establishment = trim($_POST['establishment']);
    $certificate_type = trim($_POST['certificate_type']);
    $verfication_status = trim($_POST['verfication_status']);
    $date_form = trim($_POST['date_form']);
    $date_to = trim($_POST['date_to']);
    $expiry_date_form = trim($_POST['expiry_date_form']);
    $expiry_date_to = trim($_POST['expiry_date_to']);
    $entity_arr = explode("-", $establishment);
    $entity_type_id = $entity_arr[0];
    $total = 0;
    ?>
    <div class="box-body ">
        <div class="table-responsive">
            <table id="regservice" class="table table-bordered table-hover display nowrap " style="width:100%">
                <thead>
                    <tr>
                        <th scope='col'>S.No</th>
                        <th scope='col'>Certificate<i class="invisible">_</i>Date</th>
                        <th scope='col'>Certificate<i class="invisible">_</i>Type</th>
                        <th scope='col'>Certificate<i class="invisible">_</i>No</th>
                        <th scope='col'>Establishment<i class="invisible">_</i>Code</th>
                        <th scope='col'>Establishment<i class="invisible">_</i>Name</th>
                        <th scope='col'>Licence<i class="invisible">_</i>Nominee</th>
                        <th scope='col'>Certificate<i class="invisible">_</i>File</th>
                        <th scope='col'>Renewal<i class="invisible">_</i>Due<i class="invisible">_</i>Date</th>
                        <th scope='col'>Expiry<i class="invisible">_</i>Date</th>
                        <th scope='col'>Expiry<i class="invisible">_</i>Date<i class="invisible">_</i>Status</th>
                        <th scope='col'>Uploaded<i class="invisible">_</i>By</th>
                        <th scope='col'>Verification<i class="invisible">_</i>Status</th>
                        <th scope='col'>Verified<i class="invisible">_</i>By</th>
                        <th scope='col'>Next Year Renewal Budget</th>
                        <th scope='col'>Renewal<i class="invisible">_</i>Process</th>
                        <th scope='col'>Renewal<i class="invisible">_</i>Application<i class="invisible">_</i>Date</th>
                        <th scope='col'>Renewal<i class="invisible">_</i>Application<i class="invisible">_</i>No</th>
                        <th scope='col'>Application<i class="invisible">_</i>Receipt</th>
                        <th scope='col'>View</th>
                    </tr>
                </thead>
                <tbody>
                    <?php
$sno = 1;
    $condition = '1 ';
    if ($zone != '') {
        $condition .= " AND f.`pk_cnf_zone_id`='$zone'";
    }
    if ($establishmentType != '') {
        $condition .= " AND d.`fk_sfa_cnf_entitytype_id`='$establishmentType'";
    }
    if ($establishment != '') {
        $condition .= " AND a.`fk_sfa_ent_entity_id`='$entity_type_id'";
    }
    if ($certificate_type != '') {
        $condition .= " AND a.`fk_cpl_compliancetype_id`='$certificate_type'";
    }
    if ($verfication_status != '') {
        $condition .= " AND a.`verification_status`='$verfication_status'";
    }

    if ($date_form != '') {
        $condition .= " AND str_to_date(a.`ins_date_time`,'%d-%m-%Y') <= str_to_date('$date_form','%d-%m-%Y')";
    }

    if ($date_to != '') {
        $condition .= " AND str_to_date(a.`ins_date_time`,'%d-%m-%Y') <= str_to_date('$date_to','%d-%m-%Y')";
    }

    if ($expiry_date_form != '') {
        $condition .= " AND str_to_date(a.`expiry_date`,'%Y-%m-%d') >= str_to_date('$expiry_date_form','%d-%m-%Y')";
    }

    if ($expiry_date_to != '') {
        $condition .= " AND str_to_date(a.`expiry_date`,'%Y-%m-%d') <= str_to_date('$expiry_date_to','%d-%m-%Y')";
    }

    $todaysDate = date('d-m-Y');

    // expiry_date > '$currentDate' AND renew_due_date_l1 > '$currentDate' complete

    if ($status == 'active') {
        $condition .= " AND str_to_date(a.`expiry_date`,'%Y-%m-%d') > str_to_date('$todaysDate','%d-%m-%Y') AND str_to_date(a.`renew_due_date_l1`,'%d-%m-%Y') > str_to_date('$todaysDate','%d-%m-%Y') AND a.`verification_status`='1'";
    }

    // AND expiry_date >= '$currentDate' AND renew_due_date_l1 < '$currentDate'  soon

    if ($status == 'expiring_soon') {
        $condition .= " AND str_to_date(a.`renew_due_date_l1`,'%d-%m-%Y') <= str_to_date('$todaysDate','%d-%m-%Y') AND str_to_date(a.`expiry_date`,'%d-%m-%Y') >= str_to_date('$todaysDate','%d-%m-%Y') AND a.`verification_status`='1'";
    }
    // expiry_date < '$currentDate'
    if ($status == 'expired') {
        $condition .= " AND str_to_date(a.`expiry_date`,'%Y-%m-%d') < str_to_date('$todaysDate','%d-%m-%Y') AND a.`verification_status`='1'";
    }

    if ($_SESSION['user_id'] == 'USM-U1') {
        $compliance_verification = $ccm_query->fetch_data($conn, "cpl_compliance_master as a left join usm_add_users as b on a.ins_by = b.pk_usm_user_id left join cpl_compliance_type as c on a.fk_cpl_compliancetype_id = c.pk_cpl_compliancetype_id left join sfa_ent_mst_entity as d on a.fk_sfa_ent_entity_id=d.pk_sfa_ent_entity_id left join usm_add_users as e on a.verified_by=e.pk_usm_user_id left join cnf_mst_zone as f on d.zone_id=f.pk_cnf_zone_id", "a.*,b.user_name,c.compliance_name,d.entity_name,e.user_name as user_verified_by,f.zone_name", $condition);
    } else {
        // get the level of user
        $userLevel = $ccm_query->fetch_data($conn, "usm_add_users", "user_level", "pk_usm_user_id='$_SESSION[user_id]'");

        $condition .= " AND pk_sfa_ent_entity_id IN (SELECT kitchen_id FROM cpl_define_kitchen_rights WHERE ";
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

        $compliance_verification = $ccm_query->fetch_data($conn, "cpl_compliance_master as a left join usm_add_users as b on a.ins_by = b.pk_usm_user_id left join cpl_compliance_type as c on a.fk_cpl_compliancetype_id = c.pk_cpl_compliancetype_id left join sfa_ent_mst_entity as d on a.fk_sfa_ent_entity_id=d.pk_sfa_ent_entity_id left join usm_add_users as e on a.verified_by=e.pk_usm_user_id left join cnf_mst_zone as f on d.zone_id=f.pk_cnf_zone_id", "a.*,b.user_name,c.compliance_name,d.entity_name,e.user_name as user_verified_by,f.zone_name", $condition);
    }

    if ($compliance_verification != 0) {
        foreach ($compliance_verification as $SV) {
            $verfication_status = '';
            if ($SV['verification_status'] == 0) {
                $verfication_status = "<span class='badge ExpiringSoon mb-2'>Pending</span>";
            } else if ($SV['verification_status'] == 1) {
                $verfication_status = "<span class='badge Complied mb-2'>Verified</span>";
            } else if ($SV['verification_status'] == -1) {
                $verfication_status = "<span class='badge Expired mb-2'>Rejected</span>";
            }

            $expiryStatus = '';
            $expiryDate = strtotime($SV['expiry_date']);
            $currentDate = strtotime(date('d-m-Y'));
            $L1AlertDate = strtotime($SV['renew_due_date_l1']);
            if (($expiryDate >= $currentDate) && ($L1AlertDate <= $currentDate)) {
                $expiryStatus = "<span class='badge ExpiringSoon mb-2'>Expiring Soon</span>";
            } else if (($expiryDate > $currentDate) && ($L1AlertDate > $currentDate)) {
                $expiryStatus = "<span class='badge Complied mb-2'>Complied</span>";
            } else if ($expiryDate < $currentDate) {
                $expiryStatus = "<span class='badge Expired mb-2'>Expired</span>";
            }

            // $renewalDate = $SV['renew_due_date_l1']
            $renewalDate = date('d-m-Y', strtotime($SV['renew_due_date_l1']));
            $ExpiryDate = date('d-m-Y', strtotime($SV['expiry_date']));

            $total += $SV['next_year_budget'];

            echo "<tr>
                            <td>$sno</td>
                            <td>$SV[certification_date]</td>
                            <td>$SV[compliance_name]</td>
                            <td>$SV[certificate_no]</td>
                            <td>$SV[fk_sfa_ent_entity_id]</td>
                            <td>$SV[entity_name]</td>
                            <td>$SV[licence_nominee]</td>
                            <td><a href='../upload/certificate/$SV[certificate_file]' target='_blank' style='color:#1AACAC;'>View</a></td>
                            <td>$renewalDate</td>
                            <td>$ExpiryDate</td>
                            <td>$expiryStatus</td>
                            <td>$SV[user_name]</td>
                            <td>$verfication_status</td>
                            <td>$SV[user_verified_by]</td>
                            <td>$SV[next_year_budget]</td>
                            <td></td>
                            <td></td>
                            <td></td>
                            <td></td>
                            <td><a href='certificateMIS2.php?pg=VlZSTkxWQTVNUT09&md=VlZOTkxVMHlNUT09&c_id=$SV[pk_cpl_compliance_id]' target='_blank' style='color:#1AACAC;'>View</a></td>
                        </tr>";
            $sno++;
        }
    }
    ?>
                    <tr style='background:#131313;color:whitesmoke; font-size:16px;'>
                        <td>Expiry From</td>
                        <td><?php echo $expiry_date_form; ?></td>
                        <td>Expiry To</td>
                        <td><?php echo $expiry_date_to ?></td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td>total</td>
                        <td><?php echo $total; ?></td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                    </tr>
                </tbody>

            </table>
        </div>
    </div>
<?php
}

if (isset($_POST['isset_updateComplianceCertificate'])) {
    $zone = trim($_POST['zone']);
    $status = trim($_POST['status']);
    $establishmentType = trim($_POST['establishmentType']);
    $establishment = trim($_POST['establishment']);
    $certificate_type = trim($_POST['certificate_type']);
    $verfication_status = trim($_POST['verfication_status']);
    $date_form = trim($_POST['date_form']);
    $date_to = trim($_POST['date_to']);
    $entity_arr = explode("-", $establishment);
    $entity_type_id = $entity_arr[0];

    ?>
    <div class="box-body ">
        <div class="table-responsive">
            <table id="regservice" class="table table-bordered table-hover display nowrap " style="width:100%">
                <thead>
                    <tr style=''>
                        <th scope='col'>S.No</th>
                        <th scope='col'>Certificate<i class="invisible">_</i>Date</th>
                        <th scope='col'>Certificate<i class="invisible">_</i>Type</th>
                        <th scope='col'>Certificate<i class="invisible">_</i>No</th>
                        <th scope='col'>Establishment<i class="invisible">_</i>Code</th>
                        <th scope='col'>Establishment<i class="invisible">_</i>Name</th>
                        <th scope='col'>Licence<i class="invisible">_</i>Nominee</th>
                        <th scope='col'>Certificate<i class="invisible">_</i>File</th>
                        <th scope='col'>Renewal<i class="invisible">_</i>Due<i class="invisible">_</i>Date</th>
                        <th scope='col'>Expiry<i class="invisible">_</i>Date</th>
                        <th scope='col'>Expiry<i class="invisible">_</i>Date<i class="invisible">_</i>Status</th>
                        <th scope='col'>Uploaded<i class="invisible">_</i>By</th>
                        <th scope='col'>Verification<i class="invisible">_</i>Status</th>
                        <th scope='col'>Verified<i class="invisible">_</i>By</th>
                        <th scope='col'>Renewal<i class="invisible">_</i>Process</th>
                        <th scope='col'>Renewal<i class="invisible">_</i>Application<i class="invisible">_</i>Date</th>
                        <th scope='col'>Renewal<i class="invisible">_</i>Application<i class="invisible">_</i>No</th>
                        <th scope='col'>Application<i class="invisible">_</i>Receipt</th>
                        <th scope='col'>Action</th>
                    </tr>
                </thead>
                <tbody>
                    <?php
$sno = 1;
    $condition = '1';
    if ($zone != '') {
        $condition .= " AND f.`pk_cnf_zone_id`='$zone'";
    }
    if ($establishmentType != '') {
        $condition .= " AND d.`fk_sfa_cnf_entitytype_id`='$establishmentType'";
    }
    if ($establishment != '') {
        $condition .= " AND a.`fk_sfa_ent_entity_id`='$entity_type_id'";
    }
    if ($certificate_type != '') {
        $condition .= " AND a.`fk_cpl_compliancetype_id`='$certificate_type'";
    }
    if ($verfication_status != '') {
        $condition .= " AND a.`verification_status`='$verfication_status'";
    }

    if ($date_form != '') {
        $condition .= " AND str_to_date(a.`ins_date_time`,'%d-%m-%Y') >= str_to_date('$date_form','%d-%m-%Y')";
    }

    if ($date_to != '') {
        $condition .= " AND str_to_date(a.`ins_date_time`,'%d-%m-%Y') <= str_to_date('$date_to','%d-%m-%Y')";
    }

    $todaysDate = date('d-m-Y');

    if ($status == 'active') {
        $condition .= " AND str_to_date(a.`expiry_date`,'%Y-%m-%d') >= str_to_date('$todaysDate','%d-%m-%Y')";
    }

    if ($status == 'expiring_soon') {
        $condition .= " AND str_to_date(a.`renew_due_date_l1`,'%d-%m-%Y') <= str_to_date('$todaysDate','%d-%m-%Y') AND str_to_date(a.`expiry_date`,'%Y-%m-%d') > str_to_date('$todaysDate','%d-%m-%Y')";
    }

    if ($status == 'expired') {
        $condition .= " AND str_to_date(a.`expiry_date`,'%Y-%m-%d') < str_to_date('$todaysDate','%d-%m-%Y')";
    }

    if ($_SESSION['user_id'] == 'USM-U1') {
        $compliance_verification = $ccm_query->fetch_data($conn, "cpl_compliance_master as a left join usm_add_users as b on a.ins_by = b.pk_usm_user_id left join cpl_compliance_type as c on a.fk_cpl_compliancetype_id = c.pk_cpl_compliancetype_id left join sfa_ent_mst_entity as d on a.fk_sfa_ent_entity_id=d.pk_sfa_ent_entity_id left join usm_add_users as e on a.verified_by=e.pk_usm_user_id left join cnf_mst_zone as f on d.zone_id=f.pk_cnf_zone_id", "a.*,b.user_name,c.compliance_name,d.entity_name,e.user_name as user_verified_by,f.zone_name", $condition);
    } else {
        // get the level of user
        $userLevel = $ccm_query->fetch_data($conn, "usm_add_users", "user_level", "pk_usm_user_id='$_SESSION[user_id]'");

        $condition .= " AND pk_sfa_ent_entity_id IN (SELECT kitchen_id FROM cpl_define_kitchen_rights WHERE ";
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

        $compliance_verification = $ccm_query->fetch_data($conn, "cpl_compliance_master as a left join usm_add_users as b on a.ins_by = b.pk_usm_user_id left join cpl_compliance_type as c on a.fk_cpl_compliancetype_id = c.pk_cpl_compliancetype_id left join sfa_ent_mst_entity as d on a.fk_sfa_ent_entity_id=d.pk_sfa_ent_entity_id left join usm_add_users as e on a.verified_by=e.pk_usm_user_id left join cnf_mst_zone as f on d.zone_id=f.pk_cnf_zone_id", "a.*,b.user_name,c.compliance_name,d.entity_name,e.user_name as user_verified_by,f.zone_name", $condition);
    }

    if ($compliance_verification != 0) {
        foreach ($compliance_verification as $SV) {
            $verfication_status = '';
            if ($SV['verification_status'] == 0) {
                $verfication_status = "<span class='badge ExpiringSoon mb-2'>Pending</span>";
            } else if ($SV['verification_status'] == 1) {
                $verfication_status = "<span class='badge Complied mb-2'>Verified</span>";
            } else if ($SV['verification_status'] == -1) {
                $verfication_status = "<span class='badge Expired mb-2'>Rejected</span>";
            }

            $expiryStatus = '';
            $expiryDate = strtotime($SV['expiry_date']);
            $currentDate = strtotime(date('d-m-Y'));
            $L1AlertDate = strtotime($SV['renew_due_date_l1']);
            if (($L1AlertDate <= $currentDate) && ($currentDate < $expiryDate)) {
                $expiryStatus = "<span class='badge ExpiringSoon mb-2'>Expiring Soon</span>";
            } else if ($expiryDate >= $currentDate) {
                $expiryStatus = "<span class='badge Complied mb-2'>Complied</span>";
            } else if ($expiryDate < $currentDate) {
                $expiryStatus = "<span class='badge Expired mb-2'>Expired</span>";
            }

            // $renewalDate = $SV['renew_due_date_l1']
            $renewalDate = date('d-m-Y', strtotime($SV['renew_due_date_l1']));
            $ExpiryDate = date('d-m-Y', strtotime($SV['expiry_date']));

            echo "<tr>
                            <td>$sno</td>
                            <td>$SV[certification_date]</td>
                            <td>$SV[compliance_name]</td>
                            <td>$SV[certificate_no]</td>
                            <td>$SV[fk_sfa_ent_entity_id]</td>
                            <td>$SV[entity_name]</td>
                            <td>$SV[licence_nominee]</td>
                            <td><a href='../upload/certificate/$SV[certificate_file]' target='_blank' style='color:#1AACAC;'>View</a></td>
                            <td>$renewalDate</td>
                            <td>$ExpiryDate</td>
                            <td>$expiryStatus</td>
                            <td>$SV[user_name]</td>
                            <td>$verfication_status</td>
                            <td>$SV[user_verified_by]</td>
                            <td></td>
                            <td></td>
                            <td></td>
                            <td></td>
                            <td>
                                <a href='certificateMIS2.php?pg=VlZSTkxWQTVNUT09&md=VlZOTkxVMHlNUT09&c_id=$SV[pk_cpl_compliance_id]' target='_blank' class='btn-info btn-sm'  title='View'>V</a>
                                <a href='javascript:void(0)' class='btn-warning btn-sm' title='Edit' onclick='editComplianceCertificate($SV[pk_cpl_compliance_id])'>E</a>
                            </td>
                        </tr>";
            $sno++;
        }
    }
    ?>
                </tbody>
            </table>
        </div>
    </div>
<?php
}

if (isset($_POST['isset_renew_Certificate'])) {
    $establishment = trim($_POST['establishment']);
    $status = trim($_POST['status']);
    $currentDate = date('d-m-Y');
    ?>
    <div class="box-body ">
        <div class="table-responsive">
            <table id="regservice" class="table table-bordered table-hover display nowrap " style="width:100%">
                <thead>
                    <tr style=''>
                        <th class='text-center'>S.No</th>
                        <th class='text-center'>Establishment ID</th>
                        <th class='text-center'>Establishment Name</th>
                        <th class='text-center'>Certificate<i class="invisible">_</i>Type</th>
                        <th class='text-center'>Last<i class="invisible">_</i>Update<i class="invisible">_</i>Date</th>
                        <th class='text-center'>Certificate<i class="invisible">_</i>No</th>
                        <th class='text-center'>Certificate<i class="invisible">_</i>Date</th>
                        <th class='text-center'>Licence<i class='invisible'>_</i>Nominee</th>
                        <th class='text-center'>Expiry<i class="invisible">_</i>Date<i class="invisible">_</i></th>
                        <th class='text-center'>Status</th>
                        <th class='text-center'>Application<i class="invisible">_</i>Date</th>
                        <th class='text-center'>Application<i class="invisible">_</i>By</th>
                        <th class='text-center'>Application<i class="invisible">_</i>Refrence<i class="invisible">_</i>No
                        </th>
                        <th class='text-center'>Application<i class="invisible">_</i>File</th>
                        <th class='text-center'>Estiamted<i class="invisible">_</i>Date<i class="invisible">_</i>of<i class="invisible">_</i>Confirmation</th>
                        <th class='text-center'>Application<i class="invisible">_</i>Remark</th>
                        <th class='text-center'>Application<i class="invisible">_</i>Status</th>
                        <th class='text-center'>Edit</th>
                    </tr>
                </thead>
                <tbody>
                    <?php
$sno = 1;
    $condition = "1 AND verification_status='1' AND renewal_type='Renewal'";
    if ($establishment != '') {
        $condition .= " AND a.`fk_sfa_ent_entity_id`='$establishment'";
    }

    if ($status != '') {
        if ($status == 'expiring_soon') {
            $condition .= " AND str_to_date(a.`expiry_date`,'%d-%m-%Y') >= str_to_date('$currentDate','%d-%m-%Y') AND str_to_date(a.`renew_due_date_l1`,'%d-%m-%Y') <= str_to_date('$currentDate','%d-%m-%Y')";
        }

        if ($status == 'expired') {
            $condition .= " AND str_to_date(a.`expiry_date`,'%d-%m-%Y') < str_to_date('$currentDate','%d-%m-%Y') AND a.`verification_status`='1'";
        }
    }

    $condition .= " AND (str_to_date(a.`expiry_date`,'%d-%m-%Y') >= str_to_date('$currentDate','%d-%m-%Y') AND str_to_date(a.`renew_due_date_l1`,'%d-%m-%Y') <= str_to_date('$currentDate','%d-%m-%Y') OR str_to_date(a.`expiry_date`,'%d-%m-%Y') < str_to_date('$currentDate','%d-%m-%Y')) AND a.`verification_status`='1'";

    if ($_SESSION['user_id'] == 'USM-U1') {
        $compliance_verification = $ccm_query->fetch_data($conn, "cpl_compliance_master as a left join usm_add_users as b on a.ins_by = b.pk_usm_user_id left join cpl_compliance_type as c on a.fk_cpl_compliancetype_id = c.pk_cpl_compliancetype_id left join sfa_ent_mst_entity as d on a.fk_sfa_ent_entity_id=d.pk_sfa_ent_entity_id left join usm_add_users as e on a.verified_by=e.pk_usm_user_id left join cnf_mst_zone as f on d.zone_id=f.pk_cnf_zone_id", "a.*,b.user_name,c.compliance_name,d.entity_name,e.user_name as user_verified_by,f.zone_name", $condition);
    } else {
        // get the level of user
        $userLevel = $ccm_query->fetch_data($conn, "usm_add_users", "user_level", "pk_usm_user_id='$_SESSION[user_id]'");

        $condition .= " AND pk_sfa_ent_entity_id IN (SELECT kitchen_id FROM cpl_define_kitchen_rights WHERE ";
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

        $compliance_verification = $ccm_query->fetch_data($conn, "cpl_compliance_master as a left join usm_add_users as b on a.ins_by = b.pk_usm_user_id left join cpl_compliance_type as c on a.fk_cpl_compliancetype_id = c.pk_cpl_compliancetype_id left join sfa_ent_mst_entity as d on a.fk_sfa_ent_entity_id=d.pk_sfa_ent_entity_id left join usm_add_users as e on a.verified_by=e.pk_usm_user_id left join cnf_mst_zone as f on d.zone_id=f.pk_cnf_zone_id", "a.*,b.user_name,c.compliance_name,d.entity_name,e.user_name as user_verified_by,f.zone_name", $condition);
    }
    if ($compliance_verification != 0) {
        foreach ($compliance_verification as $SV) {
            $verfication_status = '';
            if ($SV['verification_status'] == 0) {
                $verfication_status = "<span class='badge ExpiringSoon mb-2'>Pending</span>";
            } else if ($SV['verification_status'] == 1) {
                $verfication_status = "<span class='badge Complied mb-2'>Verified</span>";
            } else if ($SV['verification_status'] == -1) {
                $verfication_status = "<span class='badge Expired mb-2'>Rejected</span>";
            }

            $expiryStatus = '';
            $expiryDate = strtotime($SV['expiry_date']);
            $currentDate = strtotime(date('d-m-Y'));
            $L1AlertDate = strtotime($SV['renew_due_date_l1']);
            if (($L1AlertDate <= $currentDate) && ($currentDate < $expiryDate)) {
                $expiryStatus = "<span class='badge ExpiringSoon mb-2'>Expiring Soon</span>";
            } else if ($L1AlertDate >= $currentDate) {
                $expiryStatus = "<span class='badge Complied mb-2'>Complied</span>";
            } else if ($expiryDate < $currentDate) {
                $expiryStatus = "<span class='badge Expired mb-2'>Expired</span>";
            }

            $renewal_data = $ccm_query->fetch_data($conn, "cpl_compliance_renewal_attempts", "*", "fk_sfa_ent_entity_id='$SV[fk_sfa_ent_entity_id]' AND fk_cpl_compliancetype_id='$SV[fk_cpl_compliancetype_id]' order by pk_cpl_complianceattempt_id DESC LIMIT 1");
            $last_updated = '';
            $application_date = '';
            $application_by = '';
            $application_reference_no = '';
            $application_file = '';
            $estimate_date_of_confirmation = '';
            $application_remark = '';
            $step_status = 0;
            $step_verification_status = '';
            if ($renewal_data != 0) {
                $rd = $renewal_data[0];
                $last_updated = $rd['ins_date_time'];
                $application_date = $rd['application_date'];
                $application_by = $rd['application_by'];
                $application_reference_no = $rd['application_reference_no'];
                $application_file = "<a href='../upload/renewal/$rd[application_form_file]' target='_blank' style='color:#1AACAC;'>View</a>";
                $estimate_date_of_confirmation = $rd['estimated_confirmation_date'];
                $application_remark = $rd['enter_remark'];
                $step_status = $rd['transaction_status'];
                if ($step_status == 0) {
                    $step_verification_status = "<span class='badge ExpiringSoon mb-2'>Pending</span>";
                } else if ($step_status == 1) {
                    $step_verification_status = "<span class='badge Complied mb-2'>Verified</span>";
                } else if ($step_status == -1) {
                    $step_verification_status = "<span class='badge Expired mb-2'>Rejected</span>";
                    $application_remark = $rd['rejection_cause'];
                }
            }
            ?>
                            <tr>
                                <td><?php echo $sno ?></td>
                                <td><?php echo $SV['fk_sfa_ent_entity_id'] ?></td>
                                <td><?php echo $SV['entity_name'] ?></td>
                                <td><?php echo $SV['compliance_name'] ?></td>
                                <td><?php echo $last_updated; ?></td>
                                <td><?php echo $SV['certificate_no'] ?></td>
                                <td><?php echo date('d-m-Y', strtotime($SV['certification_date'])); ?></td>
                                <td><?php echo $SV['licence_nominee'] ?></td>
                                <td><?php echo date('d-m-Y', strtotime($SV['expiry_date'])); ?></td>
                                <td><?php echo $expiryStatus ?></td>
                                <td><?php echo $application_date; ?></td>
                                <td><?php echo $application_by ?></td>
                                <td><?php echo $application_reference_no ?></td>
                                <td><?php echo $application_file ?></td>
                                <td><?php echo $estimate_date_of_confirmation; ?></td>
                                <td><?php echo $application_remark ?></td>
                                <td><?php echo $step_verification_status ?></td>
                                <td>
                                    <?php

            if ($last_updated != '' && $application_date != '' && $application_by != '' && $application_reference_no != '' && $application_file != '' && $step_status == 0) {
                $getStep2Data = $ccm_query->fetch_data($conn, "cpl_compliance_renewal_step2", "*", "fk_cpl_complianceattempt_id='$rd[pk_cpl_complianceattempt_id]' and fk_sfa_ent_entity_id='$SV[fk_sfa_ent_entity_id]' and verification_status='0'");

                if ($getStep2Data != 0) {
                    echo "<span class='badge ExpiringSoon mb-2'>Waiting for Approval</span>";
                } else {
                    ?>
                                            <a href='javascript:void(0)' class='btn btn-link' onclick="step2popup('<?php echo $rd['pk_cpl_complianceattempt_id'] ?>','<?php echo $SV['pk_cpl_compliance_id'] ?>','ajaxpage/renew_process_step_2.php')"> Process Step 2</a>
                                        <?php
}
            } else {?>
                                        <a href='javascript:void(0)' class='btn btn-link' onclick="editpopup('<?php echo $SV['pk_cpl_compliance_id'] ?>','ajaxpage/renew_process_step_1.php')">
                                            Process Step 1</a>
                                    <?php }?>
                                </td>
                            </tr>
                    <?php
$sno++;
        }
    } else {
        echo "<tr><td colspan='17'>No Compliance To Renew in this Kitchen</td></tr>";
    }
    ?>
                </tbody>
            </table>
        </div>
    </div>
<?php
}

// isset_renew_certificate_verification
if (isset($_POST['isset_renew_certificate_verification'])) {
    $estiblishment = trim($_POST['entityType']);
    $entityName = trim($_POST['entity_name']);
    $zone_name = trim($_POST['zone_name']);
    $status = trim($_POST['status']);
    ?>
    <div class="box">
        <!-- /.box-header -->
        <div class="box-body">
            <table id="regservice" class="table table-bordered table-hover display nowrap margin-top-10 table-responsive">
                <thead>
                    <tr>
                        <th width='8%'>Sr. No</th>
                        <th>Certificate Date</th>
                        <th>Certificate Type</th>
                        <th>Certificate No</th>
                        <th>Establishment Type</th>
                        <th>Licence Nominee</th>
                        <th>Uploaded By</th>
                        <th>Upload Date / Time</th>
                        <th>Status</th>
                        <th width='9%'>Action</th>
                    </tr>
                </thead>
                <tbody>
                    <?php
$condition = '1';
    if ($estiblishment != '') {
        $condition .= " AND c.fk_sfa_cnf_entitytype_id='$estiblishment' ";
    }
    if ($entityName != '') {
        $entity_arr = explode("-", $entityName);
        $entityId = $entity_arr[0];
        $condition .= " AND a.fk_sfa_ent_entity_id='$entityId'";
    }
    if ($zone_name != '') {
        $condition .= " AND c.zone_id='$zone_name'";
    }
    if ($status != '') {
        $condition .= " AND a.verification_status='$status'";
    }

    $compliance_verification = $ccm_query->fetch_data($conn, "cpl_compliance_renewal_step2 as a left join cpl_compliance_renewal_attempts as b on a.fk_cpl_complianceattempt_id=b.pk_cpl_complianceattempt_id left join sfa_ent_mst_entity as c on a.fk_sfa_ent_entity_id=c.pk_sfa_ent_entity_id left join cpl_compliance_type as d on b.fk_cpl_compliancetype_id=d.pk_cpl_compliancetype_id left join usm_add_users as e on a.ins_by=e.pk_usm_user_id", "a.*,b.application_by,b.licence_nominee,c.entity_name,d.compliance_name,e.user_name", $condition);
    $slno = 1;
    if ($compliance_verification != 0) {
        foreach ($compliance_verification as $Compliance_Certificate) {
            $verification_status = $Compliance_Certificate['verification_status'];
            if ($verification_status == '1') {
                $badge = "<span class='badge mb-1 bg-success'>Verified</span>";
                $button = "<a href='javascript:void(0)' class='badge mb-1 bg-info'
                onclick='verificationpopupRenew($Compliance_Certificate[id])'>Details</a>";
            } else if ($verification_status == '0') {
                $badge = "<span class='badge mb-1 bg-warning'>Pending</span>";
                $button = "<a href='renew_certificate_verification2.php?pg=VlZSTkxWQXhNRGs9&md=VlZOTkxVMHlNUT09&c_id=$Compliance_Certificate[pk_cpl_compliancestep2_id]' target='_blank' class='NotApplicable badge mb-1'>Verify</a>";
            } else if ($verification_status == '-1') {
                $badge = "<span class='badge mb-1 bg-danger'>Rejected</span>";
                $button = "<a href='javascript:void(0)' class='badge mb-1 bg-info' onclick='rejectedpopupRenew($Compliance_Certificate[id])'>Details</a>";
            }
            echo "<tr>
                                <th width='8%'>$slno</th>
                                <th>$Compliance_Certificate[certificate_date]</th>
                                <th>$Compliance_Certificate[compliance_name]</th>
                                <th>$Compliance_Certificate[certificate_no]</th>
                                <th>$Compliance_Certificate[entity_name]</th>
                                <th>$Compliance_Certificate[licence_nominee]</th>
                                <th>$Compliance_Certificate[user_name]</th>
                                <th>$Compliance_Certificate[ins_date_time]</th>
                                <th>$badge</th>
                                <th width='9%'>$button</th>
                            </tr>";
            $slno++;
        }
    }
    ?>
                </tbody>
            </table>


        </div>
        <!-- /.box-body -->
    </div>
    <?php
}

if (isset($_POST['isset_compliance_history'])) {
    $establishment = trim($_POST['establishment']);
    $certificate_type = trim($_POST['certificate_type']);
    $status = trim($_POST['status']);

    if ($establishment != '') {
        $condition = " a.`fk_sfa_ent_entity_id`='$establishment' AND str_to_date(a.ins_date_time,'%d-%m-%Y') >= str_to_date('03-05-2024','%d-%m-%Y')";

        if ($certificate_type != '') {
            $condition .= " AND a.`fk_cpl_compliancetype_id`='$certificate_type'";
        }
        if ($status != "") {
            $condition .= " AND a.`verification_status`='$status'";
        }

        $compliance_verification = $ccm_query->fetch_data($conn, "cpl_compliance_master_hst as a left join usm_add_users as b on a.ins_by = b.pk_usm_user_id left join cpl_compliance_type as c on a.fk_cpl_compliancetype_id = c.pk_cpl_compliancetype_id left join sfa_ent_mst_entity as d on a.fk_sfa_ent_entity_id=d.pk_sfa_ent_entity_id left join usm_add_users as e on a.verified_by=e.pk_usm_user_id left join cnf_mst_zone as f on d.zone_id=f.pk_cnf_zone_id", "a.*,b.user_name,c.compliance_name,d.entity_name,e.user_name as user_verified_by,f.zone_name", $condition);

        $sno = 1;

        if ($compliance_verification != 0) {
            ?>
            <div class="box-body ">
                <div class="table-responsive">
                    <table id="regservice" class="table table-bordered table-hover display nowrap " style="width:100%">
                        <thead>
                            <tr style=''>
                                <th scope='col'>S.No</th>
                                <th scope='col'>Certificate<i class="invisible">_</i>Date</th>
                                <th scope='col'>Certificate<i class="invisible">_</i>Type</th>
                                <th scope='col'>Certificate<i class="invisible">_</i>No</th>
                                <th scope='col'>Establishment<i class="invisible">_</i>Code</th>
                                <th scope='col'>Establishment<i class="invisible">_</i>Name</th>
                                <th scope='col'>Licence<i class="invisible">_</i>Nominee</th>
                                <th scope='col'>Certificate<i class="invisible">_</i>File</th>
                                <th scope='col'>Renewal<i class="invisible">_</i>Due<i class="invisible">_</i>Date</th>
                                <th scope='col'>Expiry<i class="invisible">_</i>Date</th>
                                <th scope='col'>Expiry<i class="invisible">_</i>Date<i class="invisible">_</i>Status</th>
                                <th scope='col'>Uploaded<i class="invisible">_</i>By</th>
                                <th scope='col'>Verification<i class="invisible">_</i>Status</th>
                                <th scope='col'>Verified<i class="invisible">_</i>By</th>
                                <th scope='col'>Verification<i class="invisible">_</i>Remark</th>

                            </tr>
                        </thead>
                        <tbody>
                            <?php
foreach ($compliance_verification as $SV) {
                $verfication_status = '';
                if ($SV['verification_status'] == 0) {
                    $verfication_status = "<span class='badge ExpiringSoon mb-2'>Pending</span>";
                } else if ($SV['verification_status'] == 1) {
                    $verfication_status = "<span class='badge Complied mb-2'>Verified</span>";
                } else if ($SV['verification_status'] == -1) {
                    $verfication_status = "<span class='badge Expired mb-2'>Rejected</span>";
                }

                $expiryStatus = '';
                $expiryDate = strtotime($SV['expiry_date']);
                $currentDate = strtotime(date('d-m-Y'));
                $L1AlertDate = strtotime($SV['renew_due_date_l1']);
                if (($L1AlertDate <= $currentDate) && ($currentDate < $expiryDate)) {
                    $expiryStatus = "<span class='badge ExpiringSoon mb-2'>Expiring Soon</span>";
                } else if ($expiryDate >= $currentDate) {
                    $expiryStatus = "<span class='badge Complied mb-2'>Complied</span>";
                } else if ($expiryDate < $currentDate) {
                    $expiryStatus = "<span class='badge Expired mb-2'>Expired</span>";
                }

                // $renewalDate = $SV['renew_due_date_l1']
                $renewalDate = date('d-m-Y', strtotime($SV['renew_due_date_l1']));
                $ExpiryDate = date('d-m-Y', strtotime($SV['expiry_date']));

                echo "<tr>
                            <td>$sno</td>
                            <td>$SV[certification_date]</td>
                            <td>$SV[compliance_name]</td>
                            <td>$SV[certificate_no]</td>
                            <td>$SV[fk_sfa_ent_entity_id]</td>
                            <td>$SV[entity_name]</td>
                            <td>$SV[licence_nominee]</td>
                            <td><a href='../upload/certificate/$SV[certificate_file]' target='_blank' style='color:#1AACAC;'>View</a></td>
                            <td>$renewalDate</td>
                            <td>$ExpiryDate</td>
                            <td>$expiryStatus</td>
                            <td>$SV[user_name]</td>
                            <td>$verfication_status</td>
                            <td>$SV[user_verified_by]</td>
                            <td>$SV[verification_remark]</td>

                            </tr>";
                $sno++;
            }
            ?>
                        </tbody>
                    </table>
                </div>
            </div>

        <?php
} else {
            echo "<div class='col-md-12 alert alert-danger'>No Compliance Found</div>";
        }

        $pending_condition = "a.verification_status='0' AND " . $condition;

        $pending_verification = $ccm_query->fetch_data($conn, "cpl_compliance_master as a left join usm_add_users as b on a.ins_by = b.pk_usm_user_id left join cpl_compliance_type as c on a.fk_cpl_compliancetype_id = c.pk_cpl_compliancetype_id left join sfa_ent_mst_entity as d on a.fk_sfa_ent_entity_id=d.pk_sfa_ent_entity_id left join usm_add_users as e on a.verified_by=e.pk_usm_user_id left join cnf_mst_zone as f on d.zone_id=f.pk_cnf_zone_id", "a.*,b.user_name,c.compliance_name,d.entity_name,e.user_name as user_verified_by,f.zone_name", $pending_condition);

        // $ccm_query->debug($pending_verification);
        if ($pending_verification != 0) {
            ?>
            <div class="box-body ">
                <div class="table-responsive" style="overflow-y:auto;">
                    <table id="regservice21" class="table table-bordered table-hover display nowrap " style="width:100%;overflow-y:auto;">
                        <thead>
                            <tr style=''>
                                <th scope='col'>S.No</th>
                                <th scope='col'>Certificate<i class="invisible">_</i>Date</th>
                                <th scope='col'>Certificate<i class="invisible">_</i>Type</th>
                                <th scope='col'>Certificate<i class="invisible">_</i>No</th>
                                <th scope='col'>Establishment<i class="invisible">_</i>Code</th>
                                <th scope='col'>Establishment<i class="invisible">_</i>Name</th>
                                <th scope='col'>Licence<i class="invisible">_</i>Nominee</th>
                                <th scope='col'>Certificate<i class="invisible">_</i>File</th>
                                <th scope='col'>Renewal<i class="invisible">_</i>Due<i class="invisible">_</i>Date</th>
                                <th scope='col'>Expiry<i class="invisible">_</i>Date</th>
                                <th scope='col'>Expiry<i class="invisible">_</i>Date<i class="invisible">_</i>Status</th>
                                <th scope='col'>Uploaded<i class="invisible">_</i>By</th>
                                <th scope='col'>Verification<i class="invisible">_</i>Status</th>
                                <th scope='col'>Verified<i class="invisible">_</i>By</th>
                                <th scope='col'>Verification<i class="invisible">_</i>Remark</th>

                            </tr>
                        </thead>
                        <tbody>
                            <?php
foreach ($pending_verification as $SV1) {
                $verfication_status = '';
                if ($SV1['verification_status'] == 0) {
                    $verfication_status = "<span class='badge ExpiringSoon mb-2'>Pending</span>";
                } else if ($SV1['verification_status'] == 1) {
                    $verfication_status = "<span class='badge Complied mb-2'>Verified</span>";
                } else if ($SV1['verification_status'] == -1) {
                    $verfication_status = "<span class='badge Expired mb-2'>Rejected</span>";
                }

                $expiryStatus = '';
                $expiryDate = strtotime($SV1['expiry_date']);
                $currentDate = strtotime(date('d-m-Y'));
                $L1AlertDate = strtotime($SV1['renew_due_date_l1']);
                if (($L1AlertDate <= $currentDate) && ($currentDate < $expiryDate)) {
                    $expiryStatus = "<span class='badge ExpiringSoon mb-2'>Expiring Soon</span>";
                } else if ($expiryDate >= $currentDate) {
                    $expiryStatus = "<span class='badge Complied mb-2'>Complied</span>";
                } else if ($expiryDate < $currentDate) {
                    $expiryStatus = "<span class='badge Expired mb-2'>Expired</span>";
                }

                // $renewalDate = $SV1['renew_due_date_l1']
                $renewalDate = date('d-m-Y', strtotime($SV1['renew_due_date_l1']));
                $ExpiryDate = date('d-m-Y', strtotime($SV1['expiry_date']));

                echo "<tr>
                            <td>$sno</td>
                            <td>$SV1[certification_date]</td>
                            <td>$SV1[compliance_name]</td>
                            <td>$SV1[certificate_no]</td>
                            <td>$SV1[fk_sfa_ent_entity_id]</td>
                            <td>$SV1[entity_name]</td>
                            <td>$SV1[licence_nominee]</td>
                            <td><a href='../upload/certificate/$SV1[certificate_file]' target='_blank' style='color:#1AACAC;'>View</a></td>
                            <td>$renewalDate</td>
                            <td>$ExpiryDate</td>
                            <td>$expiryStatus</td>
                            <td>$SV1[user_name]</td>
                            <td>$verfication_status</td>
                            <td>$SV1[user_verified_by]</td>
                            <td>$SV1[verification_remark]</td>

                            </tr>";
                $sno++;
            }
            ?>
                        </tbody>
                    </table>
                </div>
            </div>
        <?php
} else {
            echo "<div class='col-md-12 alert alert-danger'>No Pending Compliance Found</div>";
        }
    } else {
        echo "<div class='col-md-12 alert alert-danger'>Please Select Establishment</div>";
    }
}

if (isset($_POST['isset_renewal_step_information'])) {
    $establishmentId = trim($_POST['establishment']);
    $certificate_type = trim($_POST['certificate_type']);
    $condition = 'a.transaction_status="0"';
    // $response_arr = array();
    if ($establishmentId != '') {
        $condition .= " AND  a.fk_sfa_ent_entity_id='$establishmentId'";
    }

    if ($certificate_type != '') {
        $condition .= " AND a.fk_cpl_compliancetype_id='$certificate_type'";
    }

    // fetch all the step 1 data
    $step1Data = $ccm_query->fetch_data($conn, "cpl_compliance_renewal_attempts as a left join cpl_compliance_type as b on a.fk_cpl_compliancetype_id=b.pk_cpl_compliancetype_id", "a.*,b.compliance_name", $condition);
    if ($step1Data != 0) {
        ?>
        <div class="box">
            <!-- /.box-header -->
            <div class="box-body">
                <h5>Completed Step 1</h5>
                <table id="regservice" class="table table-bordered table-hover display nowrap margin-top-10 table-responsive">
                    <thead>
                        <tr>
                            <th width='8%'>Sr. No</th>
                            <th>Establishment ID</th>
                            <th>Compliance Type</th>
                            <th>Application Date</th>
                            <th>Application By</th>
                            <th>Application Reference No</th>
                            <th>Application File</th>
                            <th>Consultant Name</th>
                            <th>Consultant Mobile No</th>
                            <th>Licence Nominee</th>
                            <th>Verification Date</th>
                            <th>Verification Remark</th>
                            <th>Status</th>
                            <!-- <th width='9%'>Action</th> -->
                        </tr>
                    </thead>
                    <tbody>
                        <?php
$sno = 1;
        foreach ($step1Data as $step1) {
            if ($step1['transaction_status'] == '1') {
                $status = "<span class='badge bg-success'>Verified</span>";
            } else if ($step1['transaction_status'] == '0') {
                $status = "<span class='badge bg-warning'>Pending</span>";
            } else if ($step1['transaction_status'] == '-1') {
                $status = "<span class='badge bg-danger'>Rejected</span>";
            }
            echo "<tr>
                                    <td>$sno</td>
                                    <td>$step1[fk_sfa_ent_entity_id]</td>
                                    <td>$step1[compliance_name]</td>
                                    <td>$step1[application_date]</td>
                                    <td>$step1[application_by]</td>
                                    <td>$step1[application_reference_no]</td>
                                    <td><a href='./../upload/renewal/$step1[application_form_file]' target='_blank'>View</a></td>
                                    <td>$step1[consultant_name]</td>
                                    <td>$step1[consultant_mobile_no]</td>
                                    <td>$step1[licence_nominee]</td>
                                    <td>$step1[rejection_date]</td>
                                    <td>$step1[rejection_cause]</td>
                                    <td>$status</td>
                                </tr>";
            $sno++;
        }
        ?>
                    </tbody>
                </table>
            </div>
        </div>
    <?php

    } else {
        echo "<div class='alert alert-danger'>No Data Found</div>";
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
                                    <a href='javascript:void(0)'  class='btn btn-sm btn-success' onclick="sendMailMsg('<?php echo $row['pk_comliance_send_alert_id'] ?>',this)"><i class='fa fa-telegram'></i> Send</a>
                                </td>
                            </tr>
                        <?php $slno++;
        }?>
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
                                    <a href='javascript:void(0)'  class='btn btn-sm btn-success' onclick="sendWhatsappMsg('<?php echo $row['pk_comliance_send_alert_id'] ?>')"><i class='fa fa-telegram'></i> Send</a>
                                </td>
                            </tr>
                        <?php $slno++;
        }?>
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

if (isset($_POST['isset_reject_compliance_mis'])) {
    $entityType = trim($_POST['entityType']);
    $entity_name = trim($_POST['entity_name']);
    $zone_name = trim($_POST['zone_name']);
    $certificate_type = trim($_POST['certificate_type']);

    $response_arr = array();

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

    $rejectedCondition = $condition . " AND a.verification_status='-1' AND str_to_date(a.ins_date_time,'%d-%m-%Y') >= str_to_date('03-05-2024','%d-%m-%Y')";

    if ($entityType != '') {
        $rejectedCondition .= " AND b.fk_sfa_cnf_entitytype_id='$entityType' AND c.compliance_type='Compliance'";
    }

    if ($entity_name != '') {
        $entity_arr = explode("-", $entity_name);
        $entityId = $entity_arr[0];
        $rejectedCondition .= " AND a.fk_sfa_ent_entity_id='$entityId'";
    }

    if ($zone_name != '') {
        $rejectedCondition .= " AND b.zone_id='$zone_name'";
    }

    if ($certificate_type != '') {
        $rejectedCondition .= " AND a.fk_cpl_compliancetype_id='$certificate_type'";
    }

    $rejected = $ccm_query->fetch_data($conn, "cpl_compliance_master_hst as a left join sfa_ent_mst_entity as b on a.fk_sfa_ent_entity_id=b.pk_sfa_ent_entity_id left join cpl_compliance_type as c on a.fk_cpl_compliancetype_id=c.pk_cpl_compliancetype_id left join sfa_ent_mst_entity as d on a.certification_organization=d.pk_sfa_ent_entity_id left join sfa_ent_mst_entity as e on a.certification_vendor=e.pk_sfa_ent_entity_id left join usm_add_users as f on a.verified_by=f.pk_usm_user_id", "a.*,b.entity_name,c.compliance_name,d.entity_name as org , e.entity_name as vendor,f.user_name as verifiedBy", $rejectedCondition);

    if ($rejected != 0) {
        ?>
        <div class="table-responsive">
            <table id="regservice" class="table table-bordered table-hover display nowrap " style="width:100%">
                <thead>
                    <tr style>
                        <th scope='col'>S.No</th>
                        <th scope='col'>Establishment<i class="invisible">_</i>Code</th>
                        <th scope='col'>Establishment<i class="invisible">_</i>Name</th>
                        <th scope='col'>Compliance<i class="invisible">_</i>Type</th>
                        <th scope='col'>Certificate<i class="invisible">_</i>Date</th>
                        <th scope='col'>Certificate<i class="invisible">_</i>Organization</th>
                        <th scope='col'>Certificate<i class="invisible">_</i>Vendor</th>
                        <th scope='col'>Consultant<i class="invisible">_</i>Name</th>
                        <th scope='col'>Consultant<i class="invisible">_</i>No</th>
                        <th scope='col'>Certificate<i class="invisible">_</i>No</th>
                        <th scope='col'>Expiry<i class="invisible">_</i>Date</th>
                        <th scope='col'>Renewal<i class="invisible">_</i>Date(L1)</th>
                        <th scope='col'>Ceritificate</th>
                        <th scope="col">Licence<i class="invisible">_</i>Nominee</th>
                        <th scope="col">Next<i class="invisible">_</i>Year<i class="invisible">_</i>Budget</th>
                        <th>Certificate File</th>
                        <th>Verified<i class="invisible">_</i>By</th>
                        <th>Verified<i class="invisible">_</i>Date</th>
                        <th>Verification<i class="invisible">_</i>Remarks</th>
                    </tr>
                </thead>
                <tbody>
                <?php
$sno = 1;
        foreach ($rejected as $r) {
            echo "<tr>
                                <td scope='col'>$sno</td>
                                <td scope='col'>$r[fk_sfa_ent_entity_id]</td>
                                <td scope='col'>$r[entity_name]</td>
                                <td scope='col'>$r[compliance_name]</td>
                                <td scope='col'>$r[certification_date]</td>
                                <td scope='col'>$r[org]</td>
                                <td scope='col'>$r[vendor]</td>
                                <td scope='col'>$r[constant_name]</td>
                                <td scope='col'>$r[consutant_mobile_no]</td>
                                <td scope='col'>$r[certificate_no]</td>
                                <td scope='col'>$r[expiry_date]</td>
                                <td scope='col'>$r[renew_due_date_l1]</td>
                                <td scope='col'><a href='../upload/certificate/$r[certificate_file]' target='_blank'>View</a></td>
                                <td scope='col'>$r[licence_nominee]</td>
                                <td scope='col'>$r[next_year_budget]</td>
                                <td scope='col'><a href='../upload/certificate/$r[certificate_file]' target='_blank'>View</a></td>
                                <td scope='col'>$r[verifiedBy]</td>
                                <td scope='col'>$r[verification_date]</td>
                                <td scope='col'>$r[verification_remark]</td>
                            </tr>";
            $sno++;
        }
        ?>
                                    </tbody>
                                </table>
                            </div>
                            <?php
} else {
        echo "<div class='alert alert-danger'>No Data Found</div>";
    }
}

?>