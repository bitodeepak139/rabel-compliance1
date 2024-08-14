<?php
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}
require_once "../../classfile/initialize.php";
require_once "../../classfile/compliance_certificate_management.php";

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
                        <th scope='col'>Certificate<i class="invisible">_</i>File</th>
                        <th scope='col'>Expiry<i class="invisible">_</i>Date</th>
                        <th scope='col'>L1<i class="invisible">_</i>User<i class="invisible">_</i>Name</th>
                        <th scope='col'>L1<i class="invisible">_</i>Alert<i class="invisible">_</i>Date</th>
                        <th scope='col'>L2<i class="invisible">_</i>User<i class="invisible">_</i>Name</th>
                        <th scope='col'>L2<i class="invisible">_</i>Alert<i class="invisible">_</i>Date</th>
                        <th scope='col'>L3<i class="invisible">_</i>User<i class="invisible">_</i>Name</th>
                        <th scope='col'>L3<i class="invisible">_</i>Alert<i class="invisible">_</i>Date</th>
                        <th scope='col'>L4<i class="invisible">_</i>User<i class="invisible">_</i>Name</th>
                        <th scope='col'>L4<i class="invisible">_</i>Alert<i class="invisible">_</i>Date</th>
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
        $compliance_verification = $ccm_query->fetch_data($conn, "cpl_compliance_master as a left join usm_add_users as b on a.ins_by = b.pk_usm_user_id left join cpl_compliance_type as c on a.fk_cpl_compliancetype_id = c.pk_cpl_compliancetype_id left join sfa_ent_mst_entity as d on a.fk_sfa_ent_entity_id=d.pk_sfa_ent_entity_id left join usm_add_users as e on a.verified_by=e.pk_usm_user_id left join cnf_mst_zone as f on d.zone_id=f.pk_cnf_zone_id inner join cpl_define_kitchen_rights as r on a.fk_sfa_ent_entity_id=r.kitchen_id ", "a.*,b.user_name,c.compliance_name,d.entity_name,e.user_name as user_verified_by,f.zone_name,r.l1_user,r.l2_user,r.l3_user,r.l4_user", $condition);
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

        $compliance_verification = $ccm_query->fetch_data($conn, "cpl_compliance_master as a left join usm_add_users as b on a.ins_by = b.pk_usm_user_id left join cpl_compliance_type as c on a.fk_cpl_compliancetype_id = c.pk_cpl_compliancetype_id left join sfa_ent_mst_entity as d on a.fk_sfa_ent_entity_id=d.pk_sfa_ent_entity_id left join usm_add_users as e on a.verified_by=e.pk_usm_user_id left join cnf_mst_zone as f on d.zone_id=f.pk_cnf_zone_id inner join cpl_define_kitchen_rights as r on a.fk_sfa_ent_entity_id=r.kitchen_id", "a.*,b.user_name,c.compliance_name,d.entity_name,e.user_name as user_verified_by,f.zone_name,r.l1_user,r.l2_user,r.l3_user,r.l4_user", $condition);
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

            $l1_user = $ccm_query->fetch_data($conn, "usm_add_users", "user_name", "pk_usm_user_id='$SV[l1_user]'");
            if($l1_user != 0){
                $l1_user = $l1_user[0]['user_name'];
            }
            $l2_user = $ccm_query->fetch_data($conn, "usm_add_users", "user_name", "pk_usm_user_id='$SV[l2_user]'");
            if($l2_user != 0){
                $l2_user = $l2_user[0]['user_name'];
            }
            $l3_user = $ccm_query->fetch_data($conn, "usm_add_users", "user_name", "pk_usm_user_id='$SV[l3_user]'");
            if($l3_user != 0){
                $l3_user = $l3_user[0]['user_name'];
            }
            $l4_user = $ccm_query->fetch_data($conn, "usm_add_users", "user_name", "pk_usm_user_id='$SV[l4_user]'");
            if($l4_user != 0){
                $l4_user = $l4_user[0]['user_name'];
            }

            echo "<tr>
                            <td>$sno</td>
                            <td>$SV[certification_date]</td>
                            <td>$SV[compliance_name]</td>
                            <td>$SV[certificate_no]</td>
                            <td>$SV[fk_sfa_ent_entity_id]</td>
                            <td>$SV[entity_name]</td>
                            <td><a href='../upload/certificate/$SV[certificate_file]' target='_blank' style='color:#1AACAC;'>View</a></td>
                            <td>$ExpiryDate</td>
                            <td>$l1_user</td>
                            <td>$SV[renew_due_date_l1]</td>
                            <td>$l2_user</td>
                            <td>$SV[renew_due_date_l2]</td>
                            <td>$l3_user</td>
                            <td>$SV[renew_due_date_l3]</td>
                            <td>$l4_user</td>
                            <td>$SV[renew_due_date_l4]</td>
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
?>