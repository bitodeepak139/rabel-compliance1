<?php
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

require_once "../../classfile/initialize.php";
require_once "../../classfile/rent_management.php";

if (isset($_POST["isset_dependent_entityType"])) {
    $entity_type_id = $_POST["selected_id"];
    if ($_SESSION['user_id'] == 'USM-U1') {
        $entityData = $rent_query->fetch_data($conn, "sfa_ent_mst_entity", "*", "fk_sfa_cnf_entitytype_id='$entity_type_id' and transaction_status='1'");
    } else {
        // get the level of user
        $userLevel = $rent_query->fetch_data($conn, "usm_add_users", "user_level", "pk_usm_user_id='$_SESSION[user_id]'");

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

        $entityData = $rent_query->fetch_data($conn, "sfa_ent_mst_entity", "*", $condition);
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

if (isset($_POST['isset_dependent_state'])) {
    $state_id = $_POST['selected_id'];
    $cityData = $rent_query->fetch_data($conn, "utm_add_city", "*", "fk_utm_state_id='$state_id' and transaction_status='1' order by city_name asc");
    echo "<option value=''>Select City</option>";
    if ($cityData != 0) {
        foreach ($cityData as $row) {
            echo "<option value='$row[pk_utm_city_id]'>$row[city_name]</option>";
        }
    } else {
        echo "<option value=''>No City Added in this State</option>";
    }
}

if (isset($_POST['isset_dependent_country'])) {
    $country_id = $_POST['selected_id'];
    $stateData = $rent_query->fetch_data($conn, "utm_add_state", "*", "fk_utm_country_id='$country_id' and transaction_status='1' order by state_name asc");
    echo "<option value=''>Select State</option>";
    if ($stateData != 0) {
        foreach ($stateData as $row) {
            echo "<option value='$row[pk_utm_state_id]'>$row[state_name]</option>";
        }
    } else {
        echo "<option value=''>No State Added in this Country</option>";
    }
}

if (isset($_POST["isset_add_Rent_Details"])) {
    $entityType = trim($_POST['entityType']);
    $entity_name = trim($_POST['entity_name']);

    $zone = trim($_POST['zone']);
    $staff_room_applicability = trim($_POST['staff_room_applicability']);
    $state = trim($_POST['state']);
    $city = trim($_POST['city']);
    $today = date('Y-m-d');

    $condition = " a.transaction_status='1'";

    if ($entityType != '') {
        $condition .= " AND a.fk_sfa_cnf_entitytype_id='$entityType'";
    }
    if ($entity_name != '') {
        $entity_arr = explode("-", $entity_name);
        $entity_id = $entity_arr[0];
        $condition .= " AND a.pk_sfa_ent_entity_id='$entity_id'";
    }
    if ($zone != '') {
        $condition .= " AND a.zone_id='$zone'";
    }
    if ($state != '') {
        $condition .= " AND a.state_id='$state'";
    }
    if ($city != '') {
        $condition .= " AND a.city_id='$city'";
    }


    $html = '';

    $rentData = $rent_query->fetch_data($conn, "sfa_ent_mst_entity as a left join sfa_cnf_mst_entity_type as b on a.fk_sfa_cnf_entitytype_id = b.pk_sfa_cnf_entitytype_id left join cnf_mst_zone as d on a.zone_id=d.pk_cnf_zone_id left join utm_add_state as e on a.state_id=e.pk_utm_state_id left join utm_add_city as f on a.city_id=f.pk_utm_city_id ", "a.*,b.type_name,d.zone_name,e.state_name,f.city_name", $condition);


    if ($rentData != 0) {
?>
        <div class="box">
            <!-- /.box-header -->
            <div class="box-body">
                <table id="regservice" class="table table-bordered table-hover display nowrap margin-top-10 table-responsive">
                    <thead>
                        <tr>
                            <th colspan='8'>Establishment Details</th>
                            <th colspan='6'>Rent</th>
                            <th colspan='5'>Staff Room</th>
                            <th></th>
                        </tr>
                        <tr>
                            <th>S.No</th>
                            <th>Establishment ID</th>
                            <th>Establishment Type</th>
                            <th>Establishment Name</th>
                            <th>Zone</th>
                            <th>State</th>
                            <th>City</th>
                            <th>Area in Sq Ft</th>
                        
                            <th>Rent Expiry Date</th>
                            <th>Notice Period In Days</th>
                            <th>Lock in Period Date</th>
                            <th>Monthly Rent</th>
                            <th>Kitchen Security Deposit</th>
                            <th>No of Agreements</th>
                            <th>Staff Room Applicable</th>
                            <th>Staff Room Expiry Date</th>
                            <th>Staff Room Rent</th>
                            <th>Staff Room Security Deposit</th>
                            <th>No of Agreement</th>
                            <th>Action</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php
                        $i = 1;
                        foreach ($rentData as $row) {

                            $getRentMaster = $rent_query->fetch_data($conn, "cpl_rent_master", "*", "fk_sfa_ent_entity_id='$row[pk_sfa_ent_entity_id]' and verification_status='1'");


                            if ($getRentMaster != 0) {
                                $area_sqft = $getRentMaster[0]['area_sqft'];
                                
                                $rent_expiry_date = $getRentMaster[0]['rent_expiry_date'];
                                $notice_period = $getRentMaster[0]['notice_period'];
                                $lockin_date = $getRentMaster[0]['lockin_date'];
                                $monthly_rent = $getRentMaster[0]['monthly_rent'];
                                $kitchen_rent_security_deposit = $getRentMaster[0]['kitchen_rent_security_deposit'];
                                $staff_room_applicable = $getRentMaster[0]['staff_room_applicable'];
                                $staffroom_expiry_date = $getRentMaster[0]['staffroom_expiry_date'];
                                $staff_room_security_deposit = $getRentMaster[0]['staff_room_security_deposit'];
                                $staff_room_rent = $getRentMaster[0]['staff_room_rent'];
                            } else {
                                $area_sqft = '';
                                $applicable_date = '';
                                $rent_expiry_date = '';
                                $notice_period = '';
                                $lockin_date = '';
                                $monthly_rent = '';
                                $kitchen_rent_security_deposit = '';
                                $staff_room_applicable = '';
                                $staffroom_expiry_date = '';
                                $staff_room_security_deposit = '';
                                $staff_room_rent = '';
                            }


                        ?>
                            <tr>
                                <td><?php echo $i; ?></td>
                                <td><?php echo $row['pk_sfa_ent_entity_id']; ?></td>
                                <td><?php echo $row['type_name']; ?></td>
                                <td><?php echo $row['entity_name']; ?></td>
                                <td><?php echo $row['zone_name'] ?></td>
                                <td><?php echo $row['state_name'] ?></td>
                                <td><?php echo $row['city_name'] ?></td>
                                <td><?php echo $area_sqft; ?></td>
            
                                <td><?= $rent_expiry_date ?></td>
                                <td><?= $notice_period ?></td>
                                <td><?= $lockin_date ?></td>
                                <td><?= $monthly_rent ?></td>
                                <td><?= $kitchen_rent_security_deposit ?></td>
                                <td>
                                    <?php
                                    $agreementId = '';
                                    $rentAgreement = $rent_query->fetch_data($conn, "cpl_rent_agreement as a", "a.*", "a.fk_cpl_compliancetype_id='33' and a.fk_sfa_ent_entity_id='$row[pk_sfa_ent_entity_id]' and a.verification_status='1'");

                                    if ($rentAgreement != 0) {
                                        // $agreementId = $rentAgreement[0]['pk_cpl_renthstagreement_id'];
                                        echo count($rentAgreement);
                                    } else {
                                        echo '';
                                    }
                                    ?></td>

                                <td>
                                    <?php
                                    $staff_expiry_date = '';
                                    $no_of_agreement = '';

                                    if ($staff_room_applicable == 1) {
                                        echo 'Yes';
                                    } else if ($staff_room_applicable == '') {
                                        echo '';
                                    } else if ($staff_room_applicable == 0) {
                                        echo 'No';
                                    }
                                    ?>
                                </td>



                                <td><?php echo $staffroom_expiry_date; ?></td>
                                <td><?= $staff_room_rent ?></td>
                                <td><?= $staff_room_security_deposit ?></td>
                                <td><?php $staff_room_rent_agreement_count = $rent_query->get_row_count_of_table($conn, "cpl_rent_agreement as a  left join cpl_compliance_type as b on a.fk_sfa_ent_entity_id=b.pk_cpl_compliancetype_id", "a.*,b.compliance_type", "a.fk_cpl_compliancetype_id='34' and a.fk_sfa_ent_entity_id='$row[pk_sfa_ent_entity_id]' AND a.verification_status='1'");
                                    if ($staff_room_rent_agreement_count != 0) {
                                        echo $staff_room_rent_agreement_count;
                                    } else {
                                        echo '';
                                    }
                                    ?></td>

                                <td><a href="javascript:void(0)" onClick="editpopup('<?php echo $row['pk_sfa_ent_entity_id'] ?>','mymodal1','editdiv','ajaxpage/edit_rent_details.php')" class="btn btn-primary">UPDATE</a></td>
                            </tr>
                        <?php
                            $i++;
                        }
                        ?>
                    </tbody>
                </table>
            </div>
            <!-- /.box-body -->
        </div>
        <!-- /.box -->
    <?php
    } else {
        $html .= "<div class='alert alert-danger'>No Data Found</div>";
    }
    echo $html;
}

if (isset($_POST["isset_verify_Rent_Details"])) {
    $entityType = trim($_POST['entityType']);
    $entity_name = trim($_POST['entity_name']);
    $zone = trim($_POST['zone']);
    $staff_room_applicability = trim($_POST['staff_room_applicability']);
    $state = trim($_POST['state']);
    $city = trim($_POST['city']);
    $verificationStatus = trim($_POST['verificationStatus']);

    $condition = " a.transaction_status='1' ";

    if ($entityType != '') {
        $condition .= " AND a.fk_sfa_cnf_entitytype_id='$entityType'";
    }
    if ($entity_name != '') {
        $entity_arr = explode("-", $entity_name);
        $entity_id = $entity_arr[0];
        $condition .= " AND a.pk_sfa_ent_entity_id='$entity_id'";
    }
    if ($zone != '') {
        $condition .= " AND a.zone_id='$zone'";
    }
    if ($state != '') {
        $condition .= " AND a.state_id='$state'";
    }
    if ($city != '') {
        $condition .= " AND a.city_id='$city'";
    }
    if ($verificationStatus != '') {
        $condition .= " AND c.verification_status='$verificationStatus'";
    }



    $html = '';

    $rentData = $rent_query->fetch_data($conn, "sfa_ent_mst_entity as a left join sfa_cnf_mst_entity_type as b on a.fk_sfa_cnf_entitytype_id = b.pk_sfa_cnf_entitytype_id inner join cpl_rent_master_hst as c on a.pk_sfa_ent_entity_id=c.fk_sfa_ent_entity_id left join cnf_mst_zone as d on a.zone_id=d.pk_cnf_zone_id left join utm_add_state as e on a.state_id=e.pk_utm_state_id left join utm_add_city as f on a.city_id=f.pk_utm_city_id ", "a.*,b.type_name,c.*,d.zone_name,e.state_name,f.city_name", $condition);


    if ($rentData != 0) {
    ?>
        <div class="box">
            <!-- /.box-header -->
            <div class="box-body">
                <table id="regservice" class="table table-bordered table-hover display nowrap margin-top-10 table-responsive">
                    <thead>
                        <tr>
                            <th colspan='8'>Establishment Details</th>
                            <th colspan='5'>Rent</th>
                            <th colspan='3'>Staff Room</th>
                            <th colspan="2"></th>
                        </tr>
                        <tr>
                            <th>S.No</th>
                            <th>Establishment ID</th>
                            <th>Establishment Type</th>
                            <th>Establishment Name</th>
                            <th>Zone</th>
                            <th>State</th>
                            <th>City</th>
                            <th>Area in Sq Ft</th>
                            <th>Rent Expiry Date</th>
                            <th>Notice Period In Days</th>
                            <th>Lock in Period Date</th>
                            <th>Monthly Rent</th>
                            <th>Kitchen Security Deposit</th>
                            <th>Staff Room Applicable</th>
                            <th>Staff Room Expiry Date</th>
                            <th>Staff Room Security Deposit</th>
                            <th>Status</th>
                            <th>Action</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php
                        $i = 1;
                        foreach ($rentData as $row) {
                        ?>
                            <tr>
                                <td><?php echo $i; ?></td>
                                <td><?php echo $row['pk_sfa_ent_entity_id']; ?></td>
                                <td><?php echo $row['type_name']; ?></td>
                                <td><?php echo $row['entity_name']; ?></td>
                                <td><?php echo $row['zone_name'] ?></td>
                                <td><?php echo $row['state_name'] ?></td>
                                <td><?php echo $row['city_name'] ?></td>
                                <td><?php echo $row['area_sqft']; ?></td>
                                <td><?php echo $row['rent_expiry_date']; ?></td>
                                <td><?php echo $row['notice_period']; ?></td>
                                <td><?php echo $row['lockin_date']; ?></td>
                                <td><?php echo $row['monthly_rent']; ?></td>
                                <td><?php echo $row['kitchen_rent_security_deposit']; ?></td>
                                <td><?php
                                    $staff_expiry_date = '';
                                    $no_of_agreement = '';
                                    if ($row['staff_room_applicable'] == 1) {
                                        echo 'Yes';
                                    } else if ($row['staff_room_applicable'] == 0) {
                                        echo 'No';
                                    }
                                    ?></td>
                                <td><?php echo $row['staffroom_expiry_date']; ?></td>
                                <td><?= $row['staff_room_security_deposit'] ?></td>
                                <td><?php
                                    if ($row['verification_status'] == 0) {
                                        echo "<span class='badge badge-warning'>Pending</span>";
                                    } else if ($row['verification_status'] == 1) {
                                        echo "<span class='badge badge-success'>Verified</span>";
                                    } else if ($row['verification_status'] == -1) {
                                        echo "<span class='badge badge-danger'>Rejected</span>";
                                    }
                                    ?></td>
                                <td><?php
                                    if ($row['verification_status'] == 0) {
                                        echo "<a href='javascript:void(0)' onClick='editpopup(\"$row[pk_cpl_renthst_id]\",\"mymodal1\",\"editdiv\",\"ajaxpage/verify_rent_details.php\")' class='btn btn-primary'>Verify</a>";
                                    } else {
                                        echo "<a href='javascript:void(0)' onClick='editpopup(\"$row[pk_cpl_renthst_id]\",\"mymodal1\",\"editdiv\",\"ajaxpage/verify_rent_details.php\")' class='btn btn-primary'>Details</a>";
                                    }
                                    ?></td>
                            </tr>
                        <?php
                            $i++;
                        }
                        ?>
                    </tbody>
                </table>
            </div>
            <!-- /.box-body -->
        </div>
        <!-- /.box -->
    <?php
    } else {
        $html .= "<div class='alert alert-danger'>No Data Found</div>";
    }
    echo $html;
}

if (isset($_POST['isset_rentVerification'])) {
    $entityType = trim($_POST['entityType']);
    $entity_name = trim($_POST['entity_name']);

    $zone = trim($_POST['zone']);
    $staff_room_applicability = trim($_POST['staff_room_applicability']);
    $state = trim($_POST['state']);
    $city = trim($_POST['city']);
    $AgreementStatus = trim($_POST['AgreementStatus']);

    $condition = "b.transaction_status='1' AND b.compliance_type='Rent'";

    if ($entityType != '') {
        $condition .= " AND c.fk_sfa_cnf_entitytype_id='$entityType'";
    }
    if ($entity_name != '') {
        $entity_arr = explode("-", $entity_name);
        $entity_id = $entity_arr[0];
        $condition .= " AND c.pk_sfa_ent_entity_id='$entity_id'";
    }
    if ($zone != '') {
        $condition .= " AND c.zone_id='$zone'";
    }
    if ($state != '') {
        $condition .= " AND c.state_id='$state'";
    }
    if ($city != '') {
        $condition .= " AND c.city_id='$city'";
    }

    $html = '';


    $agreeMentData = $rent_query->fetch_data($conn, "cpl_rent_agreement as a left join cpl_compliance_type as b on a.fk_cpl_compliancetype_id=b.pk_cpl_compliancetype_id left join sfa_ent_mst_entity as c on a.fk_sfa_ent_entity_id=c.pk_sfa_ent_entity_id left join sfa_cnf_mst_entity_type as d on c.fk_sfa_cnf_entitytype_id=d.pk_sfa_cnf_entitytype_id", "a.*,b.compliance_name,c.entity_name,d.type_name", $condition);

    if ($agreeMentData != 0) {
    ?>
        <div class="box">
            <!-- /.box-header -->
            <div class="box-body">
                <table id="regservice" class="table table-bordered table-hover display nowrap margin-top-10 table-responsive">
                    <thead>
                        <tr>
                            <th colspan='4'>Establishment Details</th>
                            <th colspan='5'>Agreement Details</th>
                            <th></th>
                        </tr>
                        <tr>
                            <th>S.No</th>
                            <th>Establishment ID</th>
                            <th>Establishment Type</th>
                            <th>Establishment Name</th>
                            <th>Agreement Date</th>
                            <th>Agreement Type</th>
                            <th>Agreement Expiry Date</th>
                            <th>No of LandLords</th>
                            <th>Status</th>
                            <th>Action</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php
                        $i = 1;
                        foreach ($agreeMentData as $row) {
                        ?>
                            <tr>
                                <td><?php echo $i; ?></td>
                                <td><?php echo $row['fk_sfa_ent_entity_id']; ?></td>
                                <td><?php echo $row['type_name']; ?></td>
                                <td><?php echo $row['entity_name']; ?></td>
                                <td><?php echo $row['agreement_date']; ?></td>
                                <td><?php echo $row['compliance_name']; ?></td>
                                <td><?php echo $row['agreement_expiry_date']; ?></td>
                                <td><?php echo $getLandLordCount = $rent_query->get_row_count_of_table($conn, "cpl_rent_landlords", "*", "fk_cpl_rentagreement_id='$row[pk_cpl_renthstagreement_id]'"); ?></td>
                                <?php
                                $today = date('Y-m-d');
                                $agreement_expiry_date = $row['agreement_expiry_date'];
                                $agreement_expiring_soon = date('Y-m-d', strtotime($agreement_expiry_date . ' -60 days'));

                                if ($today > $agreement_expiry_date) {
                                    $status = "<span class='badge badge-danger'>Expired</span>";
                                } else if ($today == $agreement_expiry_date) {
                                    $status = "<span class='badge badge-warning'>Expiring Today</span>";
                                } else if ($today >= $agreement_expiring_soon && $today <= $agreement_expiry_date) {
                                    $status = "<span class='badge badge-warning'>Expiring Soon</span>";
                                } else {
                                    $status = "<span class='badge badge-success'>Active</span>";
                                }
                                echo "<td>$status</td>";
                                ?>
                                <td>
                                    <a href="javascript:void(0)" class="btn btn-success btn-xs" onClick="viewpopup('<?php echo $row['pk_cpl_renthstagreement_id'] ?>','ajaxpage/view_agreement_mis.php')" id="view<?php echo $id ?>" title="View Details">V</a>
                                </td>
                            </tr>
                        <?php
                            $i++;
                        }
                        ?>
                    </tbody>
                </table>
            </div>
            <!-- /.box-body -->
        </div>
        <!-- /.box -->
    <?php
    } else {
    ?>
        <div class='alert alert-danger'>No Agreement Found</div>
    <?php
    }
}

if (isset($_POST['isset_all_agreement'])) {
    $id = $_POST['id'];
    ?>
    <table class="table table-bordered">
        <thead>
            <tr>
                <th>S. No.</th>
                <th>Agreement Type</th>
                <th>Agreement Date</th>
                <th>Agreement Expiry Date</th>
                <th>Agreement Expenses</th>
                <th>Agreement Document</th>
                <th>No of Landlords</th>
                <th>Status</th>
                <th>Action</th>
            </tr>
        </thead>
        <tbody>
            <?php
            $fetchAgreementData = $rent_query->fetch_data($conn, "cpl_rent_agreement_hst as a left join cpl_compliance_type as b on a.fk_cpl_compliancetype_id=b.pk_cpl_compliancetype_id", "a.*,b.compliance_name", "a.fk_sfa_ent_entity_id='$id' and b.compliance_type='Rent' and b.transaction_status='1' AND verification_status!='-1'");
            if ($fetchAgreementData != 0) {
                $i = 1;
                foreach ($fetchAgreementData as $row) {

                    if ($row['verification_status'] == 0) {
                        $status = "<span class='badge badge-warning'>Pending</span>";
                    } else if ($row['verification_status'] == 1) {
                        $status = "<span class='badge badge-success'>Verified</span>";
                    } else if ($row['verification_status'] == -1) {
                        $status = "<span class='badge badge-danger'>Rejected</span>";
                    }


                    echo "<tr>
<td>$i</td>
<td>$row[compliance_name]</td>
<td>$row[agreement_date]</td>
<td>$row[agreement_expiry_date]</td>
<td>$row[agreement_amount]</td>
<td><a href='../upload/agreements/$row[pk_cpl_renthstagreement_id]/$row[agreement_file]' target='_blank'>View Document</a></td>
<td>" .
                        $getLandLordCount = $rent_query->get_row_count_of_table($conn, "cpl_rent_landlords_hst", "*", "fk_cpl_rentagreement_id='$row[pk_cpl_renthstagreement_id]'") . "</td>
<td>$status</td>
<td>
    <a href=\"javascript:void(0)\" class=\"btn btn-success btn-xs\" onClick=\"viewpopup('$row[pk_cpl_renthstagreement_id]','ajaxpage/view_agreement_mis.php')\" id=\"view$i\" title=\"View Details\">V</a>
</td>
</tr>";
                    $i++;
                }
            } else {
                echo "<tr><td colspan='9'>No Agreement Added Yet</td></tr>";
            }
            ?>
        </tbody>
    </table>
<?php
}
if (isset($_POST['isset_all_agreement_verify'])) {
    $id = $_POST['id'];
?>
    <table class="table table-bordered">
        <thead>
            <tr>
                <th>S. No.</th>
                <th>Agreement Type</th>
                <th>Agreement Date</th>
                <th>Agreement Expiry Date</th>
                <th>Agreement Expenses</th>
                <th>Agreement Document</th>
                <th>No of Landlords</th>
                <th>Status</th>
                <th>Action</th>
            </tr>
        </thead>
        <tbody>
            <?php
            $fetchAgreementData = $rent_query->fetch_data($conn, "cpl_rent_agreement_hst as a left join cpl_compliance_type as b on a.fk_cpl_compliancetype_id=b.pk_cpl_compliancetype_id", "a.*,b.compliance_name", "a.fk_sfa_ent_entity_id='$id' and b.compliance_type='Rent' and b.transaction_status='1'");
            if ($fetchAgreementData != 0) {
                $i = 1;
                foreach ($fetchAgreementData as $row) {

                    if ($row['verification_status'] == 0) {
                        $status = "<span class='badge badge-warning'>Pending</span>";
                    } else if ($row['verification_status'] == 1) {
                        $status = "<span class='badge badge-success'>Verified</span>";
                    } else if ($row['verification_status'] == -1) {
                        $status = "<span class='badge badge-danger'>Rejected</span>";
                    }


                    echo "<tr>
<td>$i</td>
<td>$row[compliance_name]</td>
<td>$row[agreement_date]</td>
<td>$row[agreement_expiry_date]</td>
<td>$row[agreement_amount]</td>
<td><a href='../upload/agreements/$row[pk_cpl_renthstagreement_id]/$row[agreement_file]' target='_blank'>View Document</a></td>
<td>" .
                        $getLandLordCount = $rent_query->get_row_count_of_table($conn, "cpl_rent_landlords_hst", "*", "fk_cpl_rentagreement_id='$row[pk_cpl_renthstagreement_id]'") . "</td>
<td>$status</td>
<td>
    <a href=\"javascript:void(0)\" class=\"btn btn-success btn-xs\" onClick=\"viewpopup('$row[pk_cpl_renthstagreement_id]','ajaxpage/verify_agreement_details.php')\" id=\"view$i\" title=\"View Details\">V</a>
</td>
</tr>";
                    $i++;
                }
            } else {
                echo "<tr><td colspan='9'>No Agreement Added Yet</td></tr>";
            }
            ?>
        </tbody>
    </table>
    <?php
}



if (isset($_POST['isset_add_agreement_details'])) {
    $entityType = trim($_POST['entityType']);
    $entity_name = trim($_POST['entity_name']);
    $zone = trim($_POST['zone']);
    $staff_room_applicability = trim($_POST['staff_room_applicability']);
    $state = trim($_POST['state']);
    $city = trim($_POST['city']);
    // $verificationStatus = trim($_POST['verificationStatus']);

    $condition = " a.transaction_status='1' ";

    if ($entityType != '') {
        $condition .= " AND a.fk_sfa_cnf_entitytype_id='$entityType'";
    }
    if ($entity_name != '') {
        $entity_arr = explode("-", $entity_name);
        $entity_id = $entity_arr[0];
        $condition .= " AND a.pk_sfa_ent_entity_id='$entity_id'";
    }
    if ($zone != '') {
        $condition .= " AND a.zone_id='$zone'";
    }
    if ($state != '') {
        $condition .= " AND a.state_id='$state'";
    }
    if ($city != '') {
        $condition .= " AND a.city_id='$city'";
    }


    $html = '';

    $rentData = $rent_query->fetch_data($conn, "sfa_ent_mst_entity as a left join sfa_cnf_mst_entity_type as b on a.fk_sfa_cnf_entitytype_id = b.pk_sfa_cnf_entitytype_id left join cpl_rent_master as c on a.pk_sfa_ent_entity_id=c.fk_sfa_ent_entity_id left join cnf_mst_zone as d on a.zone_id=d.pk_cnf_zone_id left join utm_add_state as e on a.state_id=e.pk_utm_state_id left join utm_add_city as f on a.city_id=f.pk_utm_city_id ", "a.*,b.type_name,c.*,d.zone_name,e.state_name,f.city_name", $condition);


    if ($rentData != 0) {
    ?>
        <div class="box">
            <!-- /.box-header -->
            <div class="box-body">
                <table id="regservice" class="table table-bordered table-hover display nowrap margin-top-10 table-responsive">
                    <thead>
                        <tr>
                            <th colspan='8'>Establishment Details</th>
                            <th colspan='5'>Rent</th>
                            <th colspan='3'>Staff Room</th>
                            <th colspan="3"></th>
                        </tr>
                        <tr>
                            <th>S.No</th>
                            <th>Establishment ID</th>
                            <th>Establishment Type</th>
                            <th>Establishment Name</th>
                            <th>Zone</th>
                            <th>State</th>
                            <th>City</th>
                            <th>Area in Sq Ft</th>
                            <th>Rent Expiry Date</th>
                            <th>Notice Period In Days</th>
                            <th>Lock in Period Date</th>
                            <th>Monthly Rent</th>
                            <th>Kitchen Security Deposit</th>
                            <th>Staff Room Applicable</th>
                            <th>Staff Room Expiry Date</th>
                            <th>Staff Room Security Deposit</th>
                            <th>Rent Status</th>
                            <th>Agreement Status</th>
                            <th>Action</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php
                        $i = 1;
                        foreach ($rentData as $row) {
                        ?>
                            <tr>
                                <td><?php echo $i; ?></td>
                                <td><?php echo $row['pk_sfa_ent_entity_id']; ?></td>
                                <td><?php echo $row['type_name']; ?></td>
                                <td><?php echo $row['entity_name']; ?></td>
                                <td><?php echo $row['zone_name'] ?></td>
                                <td><?php echo $row['state_name'] ?></td>
                                <td><?php echo $row['city_name'] ?></td>
                                <td><?php echo $row['area_sqft']; ?></td>
                                <td><?php echo $row['rent_expiry_date']; ?></td>
                                <td><?php echo $row['notice_period']; ?></td>
                                <td><?php echo $row['lockin_date']; ?></td>
                                <td><?php echo $row['monthly_rent']; ?></td>
                                <td><?php echo $row['kitchen_rent_security_deposit']; ?></td>
                                <td><?php
                                    $staff_expiry_date = '';
                                    $no_of_agreement = '';
                                    if ($row['staff_room_applicable'] == 1) {
                                        echo 'Yes';
                                    } else if ($row['staff_room_applicable'] == 0) {
                                        echo 'No';
                                    }
                                    ?></td>
                                <td><?php echo $row['staffroom_expiry_date']; ?></td>
                                <td><?= $row['staff_room_security_deposit'] ?></td>
                                <td><?php
                                    if ($row['verification_status'] == 0) {
                                        echo "<span class='badge badge-warning'>Pending</span>";
                                    } else if ($row['verification_status'] == 1) {
                                        echo "<span class='badge badge-success'>Verified</span>";
                                    } else if ($row['verification_status'] == -1) {
                                        echo "<span class='badge badge-danger'>Rejected</span>";
                                    }
                                    ?></td>
                                <td>
                                    <?php
                                    $agreement = $rent_query->fetch_data($conn, "cpl_rent_agreement_hst", "*", "fk_sfa_ent_entity_id='$row[pk_sfa_ent_entity_id]'");
                                    if ($agreement != 0) {
                                        $agreementStatus = $rent_query->fetch_data($conn, "cpl_rent_agreement_hst", "*", "verification_status='0' AND fk_sfa_ent_entity_id='$row[pk_sfa_ent_entity_id]'");
                                        if ($agreementStatus != 0) {
                                            echo "<span class='badge badge-warning'>Pending</span>";
                                        } else {
                                            echo "<span class='badge badge-success'>Verified</span>";
                                        }
                                    } else {
                                        echo "<span class='badge badge-danger'>No Agreement Added</span>";
                                    }
                                    ?>
                                </td>
                                <td>
                                    <a href="javascript:void(0)" onClick="editpopup('<?php echo $row['pk_sfa_ent_entity_id'] ?>','mymodal1','editdiv','ajaxpage/addAgreementDataPopup.php')" class="btn btn-primary">Add</a>
                                </td>
                            </tr>
                        <?php
                            $i++;
                        }
                        ?>
                    </tbody>
                </table>
            </div>
            <!-- /.box-body -->
        </div>
        <!-- /.box -->
    <?php
    } else {
        $html .= "<div class='alert alert-danger'>No Data Found</div>";
    }
    echo $html;
}


if (isset($_POST['isset_verify_agreement_details'])) {
    $entityType = trim($_POST['entityType']);
    $entity_name = trim($_POST['entity_name']);
    $zone = trim($_POST['zone']);
    $staff_room_applicability = trim($_POST['staff_room_applicability']);
    $state = trim($_POST['state']);
    $city = trim($_POST['city']);
    $verificationStatus = trim($_POST['verificationStatus']);

    $condition = " a.transaction_status='1' ";

    if ($entityType != '') {
        $condition .= " AND a.fk_sfa_cnf_entitytype_id='$entityType'";
    }
    if ($entity_name != '') {
        $entity_arr = explode("-", $entity_name);
        $entity_id = $entity_arr[0];
        $condition .= " AND ag.fk_sfa_ent_entity_id='$entity_id'";
    }
    if ($zone != '') {
        $condition .= " AND a.zone_id='$zone'";
    }
    if ($state != '') {
        $condition .= " AND a.state_id='$state'";
    }
    if ($city != '') {
        $condition .= " AND a.city_id='$city'";
    }

    if ($verificationStatus != '') {
        $condition .= " AND ag.verification_status='$verificationStatus'";
    }



    $html = '';

    $rentData = $rent_query->fetch_data($conn, "cpl_rent_agreement_hst as ag left join  sfa_ent_mst_entity as a on ag.fk_sfa_ent_entity_id=a.pk_sfa_ent_entity_id left join sfa_cnf_mst_entity_type as b on a.fk_sfa_cnf_entitytype_id = b.pk_sfa_cnf_entitytype_id left join cpl_rent_master as c on a.pk_sfa_ent_entity_id=c.fk_sfa_ent_entity_id left join cnf_mst_zone as d on a.zone_id=d.pk_cnf_zone_id left join utm_add_state as e on a.state_id=e.pk_utm_state_id left join utm_add_city as f on a.city_id=f.pk_utm_city_id ", "a.*,b.type_name,c.*,d.zone_name,e.state_name,f.city_name", $condition);


    if ($rentData != 0) {
    ?>
        <div class="box">
            <!-- /.box-header -->
            <div class="box-body">
                <table id="regservice" class="table table-bordered table-hover display nowrap margin-top-10 table-responsive">
                    <thead>
                        <tr>
                            <th colspan='8'>Establishment Details</th>
                            <th colspan='5'>Rent</th>
                            <th colspan='3'>Staff Room</th>
                            <th colspan="3"></th>
                        </tr>
                        <tr>
                            <th>S.No</th>
                            <th>Establishment ID</th>
                            <th>Establishment Type</th>
                            <th>Establishment Name</th>
                            <th>Zone</th>
                            <th>State</th>
                            <th>City</th>
                            <th>Area in Sq Ft</th>
                            <th>Rent Expiry Date</th>
                            <th>Notice Period In Days</th>
                            <th>Lock in Period Date</th>
                            <th>Monthly Rent</th>
                            <th>Kitchen Security Deposit</th>
                            <th>Staff Room Applicable</th>
                            <th>Staff Room Expiry Date</th>
                            <th>Staff Room Security Deposit</th>
                            <th>Rent Status</th>
                            <th>Agreement Status</th>
                            <th>Action</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php
                        $i = 1;
                        foreach ($rentData as $row) {
                        ?>
                            <tr>
                                <td><?php echo $i; ?></td>
                                <td><?php echo $row['pk_sfa_ent_entity_id']; ?></td>
                                <td><?php echo $row['type_name']; ?></td>
                                <td><?php echo $row['entity_name']; ?></td>
                                <td><?php echo $row['zone_name'] ?></td>
                                <td><?php echo $row['state_name'] ?></td>
                                <td><?php echo $row['city_name'] ?></td>
                                <td><?php echo $row['area_sqft']; ?></td>
                                <td><?php echo $row['rent_expiry_date']; ?></td>
                                <td><?php echo $row['notice_period']; ?></td>
                                <td><?php echo $row['lockin_date']; ?></td>
                                <td><?php echo $row['monthly_rent']; ?></td>
                                <td><?php echo $row['kitchen_rent_security_deposit']; ?></td>
                                <td><?php
                                    $staff_expiry_date = '';
                                    $no_of_agreement = '';
                                    if ($row['staff_room_applicable'] == 1) {
                                        echo 'Yes';
                                    } else if ($row['staff_room_applicable'] == 0) {
                                        echo 'No';
                                    }
                                    ?></td>
                                <td><?php echo $row['staffroom_expiry_date']; ?></td>
                                <td><?= $row['staff_room_security_deposit'] ?></td>
                                <td><?php
                                    if ($row['verification_status'] == 0) {
                                        echo "<span class='badge badge-warning'>Pending</span>";
                                    } else if ($row['verification_status'] == 1) {
                                        echo "<span class='badge badge-success'>Verified</span>";
                                    } else if ($row['verification_status'] == -1) {
                                        echo "<span class='badge badge-danger'>Rejected</span>";
                                    }
                                    ?></td>
                                <td>
                                    <?php
                                    $agreement = $rent_query->fetch_data($conn, "cpl_rent_agreement_hst", "*", "fk_sfa_ent_entity_id='$row[pk_sfa_ent_entity_id]'");
                                    if ($agreement != 0) {
                                        $agreementStatus = $rent_query->fetch_data($conn, "cpl_rent_agreement_hst", "*", "verification_status='0' AND fk_sfa_ent_entity_id='$row[pk_sfa_ent_entity_id]'");
                                        if ($agreementStatus != 0) {
                                            echo "<span class='badge badge-warning'>Pending</span>";
                                        } else {
                                            echo "<span class='badge badge-success'>Verified</span>";
                                        }
                                    } else {
                                        echo "<span class='badge badge-danger'>No Agreement Added</span>";
                                    }
                                    ?>
                                </td>
                                <td>
                                    <a href="javascript:void(0)" onClick="editpopup('<?php echo $row['pk_sfa_ent_entity_id'] ?>','mymodal1','editdiv','ajaxpage/verifyAgreementDataPopup.php')" class="btn btn-primary">View</a>
                                </td>
                            </tr>
                        <?php
                            $i++;
                        }
                        ?>
                    </tbody>
                </table>
            </div>
            <!-- /.box-body -->
        </div>
        <!-- /.box -->
    <?php
    } else {
        $html .= "<div class='alert alert-danger'>No Data Found</div>";
    }
    echo $html;
}


if (isset($_POST['isset_rentMIS'])) {
    $entityType = trim($_POST['entityType']);
    $entity_name = trim($_POST['entity_name']);
    $zone = trim($_POST['zone']);
    $staff_room_applicability = trim($_POST['staff_room_applicability']);
    $state = trim($_POST['state']);
    $city = trim($_POST['city']);
    $today = date('Y-m-d');

    $condition = " a.transaction_status='1'  AND c.verification_status='1' ";

    if ($entityType != '') {
        $condition .= " AND a.fk_sfa_cnf_entitytype_id='$entityType'";
    }
    if ($entity_name != '') {
        $entity_arr = explode("-", $entity_name);
        $entity_id = $entity_arr[0];
        $condition .= " AND a.pk_sfa_ent_entity_id='$entity_id'";
    }
    if ($zone != '') {
        $condition .= " AND a.zone_id='$zone'";
    }
    if ($state != '') {
        $condition .= " AND a.state_id='$state'";
    }
    if ($city != '') {
        $condition .= " AND a.city_id='$city'";
    }

    $html = '';

    $rentData = $rent_query->fetch_data($conn, "sfa_ent_mst_entity as a left join sfa_cnf_mst_entity_type as b on a.fk_sfa_cnf_entitytype_id = b.pk_sfa_cnf_entitytype_id inner join cpl_rent_master as c on a.pk_sfa_ent_entity_id=c.fk_sfa_ent_entity_id left join cnf_mst_zone as d on a.zone_id=d.pk_cnf_zone_id left join utm_add_state as e on a.state_id=e.pk_utm_state_id left join utm_add_city as f on a.city_id=f.pk_utm_city_id left join usm_add_users as g on c.ins_by=g.pk_usm_user_id left join usm_add_users as h on c.verified_by=h.pk_usm_user_id", "a.*,b.type_name,c.*,d.zone_name,e.state_name,f.city_name,g.user_name as uploaded_by , h.user_name as verified_by", $condition);

    if ($rentData != 0) {
    ?>
        <div class="box">
            <!-- /.box-header -->
            <div class="box-body">
                <table id="regservice" class="table table-bordered table-hover display nowrap margin-top-10 table-responsive">
                    <thead>
                        <tr>
                            <th colspan='8'>Establishment Details</th>
                            <th colspan='5'>Rent</th>
                            <th colspan='5'>Staff Room</th>
                            <th></th>
                        </tr>
                        <tr>
                            <th>S.No</th>
                            <th>Establishment ID</th>
                            <th>Establishment Type</th>
                            <th>Establishment Name</th>
                            <th>Zone</th>
                            <th>State</th>
                            <th>City</th>
                            <th>Area in Sq Ft</th>
                            <th>Rent Expiry Date</th>
                            <th>Notice Period In Days</th>
                            <th>Lock in Period Date</th>
                            <th>Monthly Rent</th>
                            <th>Kitchen Security Deposit</th>
                            <th>Staff Room Applicable</th>
                            <th>Staff Room Expiry Date</th>
                            <th>Staff Room Security Deposit</th>
                            <th>Uploaded By</th>
                            <th>Verified By</th>
                            <th>Status</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php
                        $i = 1;
                        foreach ($rentData as $row) {
                        ?>
                            <tr>
                                <td><?php echo $i; ?></td>
                                <td><?php echo $row['pk_sfa_ent_entity_id']; ?></td>
                                <td><?php echo $row['type_name']; ?></td>
                                <td><?php echo $row['entity_name']; ?></td>
                                <td><?php echo $row['zone_name'] ?></td>
                                <td><?php echo $row['state_name'] ?></td>
                                <td><?php echo $row['city_name'] ?></td>
                                <td><?php echo $row['area_sqft']; ?></td>
                                <td><?php echo $row['rent_expiry_date']; ?></td>
                                <td><?php echo $row['notice_period']; ?></td>
                                <td><?php echo $row['lockin_date']; ?></td>
                                <td><?php echo $row['monthly_rent']; ?></td>
                                <td><?php echo $row['kitchen_rent_security_deposit']; ?></td>
                                <td><?php
                                    $staff_expiry_date = '';
                                    $no_of_agreement = '';
                                    if ($row['staff_room_applicable'] == 1) {
                                        echo 'Yes';
                                    } else if ($row['staff_room_applicable'] == 0) {
                                        echo 'No';
                                    }
                                    ?></td>
                                <td><?php echo $row['staffroom_expiry_date']; ?></td>
                                <td><?= $row['staff_room_security_deposit'] ?></td>
                                <td><?= $row['uploaded_by'] ?></td>
                                <td><?= $row['verified_by'] ?></td>
                                <td><?php
                                    if ($row['verification_status'] == 0) {
                                        echo "<span class='badge badge-warning'>Pending</span>";
                                    } else if ($row['verification_status'] == 1) {
                                        echo "<span class='badge badge-success'>Verified</span>";
                                    } else if ($row['verification_status'] == -1) {
                                        echo "<span class='badge badge-danger'>Rejected</span>";
                                    }
                                    ?></td>
                            </tr>
                        <?php
                            $i++;
                        }
                        ?>
                    </tbody>
                </table>
            </div>
            <!-- /.box-body -->
        </div>
    <?php
    } else {
    ?>
        <div class='alert alert-danger'>No Rent Found</div>
    <?php
    }
}


if (isset($_POST['isset_agreementMIS'])) {
    $entityType = trim($_POST['entityType']);
    $entity_name = trim($_POST['entity_name']);
    $zone = trim($_POST['zone']);
    $staff_room_applicability = trim($_POST['staff_room_applicability']);
    $state = trim($_POST['state']);
    $city = trim($_POST['city']);
    $verificationStatus = trim($_POST['verificationStatus']);
    $status = trim($_POST['status']);

    $currentDate = date('Y-m-d');


    $condition = "b.transaction_status='1' AND b.compliance_type='Rent'";

    if ($entityType != '') {
        $condition .= " AND c.fk_sfa_cnf_entitytype_id='$entityType'";
    }
    if ($entity_name != '') {
        $entity_arr = explode("-", $entity_name);
        $entity_id = $entity_arr[0];
        $condition .= " AND c.pk_sfa_ent_entity_id='$entity_id'";
    }
    if ($zone != '') {
        $condition .= " AND c.zone_id='$zone'";
    }
    if ($state != '') {
        $condition .= " AND c.state_id='$state'";
    }
    if ($city != '') {
        $condition .= " AND c.city_id='$city'";
    }
    if ($verificationStatus != '') {
        $condition .= " AND a.verification_status='$verificationStatus'";
    }
    $todays = date('d-m-Y');
    if($status != ''){
        if($status == 'expired'){
            $condition .= " AND str_to_date(a.`agreement_expiry_date`,'%Y-%m-%d') < str_to_date('$currentDate','%Y-%m-%d')";
        } else if ($status == 'expiringToday'){
            $condition .= " AND str_to_date(a.`agreement_expiry_date`,'%Y-%m-%d') = str_to_date('$currentDate','%Y-%m-%d')";
        } else if($status == 'expiringSoon'){
            $condition .= " AND str_to_date(a.`agreement_expiry_date`,'%Y-%m-%d') > str_to_date('$currentDate','%Y-%m-%d') AND str_to_date('$todays','%d-%m-%Y') >= str_to_date(a.`alert_user_l1`,'%d-%m-%Y')";     
        } else if($status == 'active'){
            $condition .= " AND str_to_date('$currentDate','%Y-%m-%d') < str_to_date(a.`agreement_expiry_date`,'%Y-%m-%d')  AND str_to_date('$todays','%d-%m-%Y') <  str_to_date(a.`alert_user_l1`,'%d-%m-%Y')";     
        }
    }
    // $rent_query->debug($condition);

    $html = '';


    $agreeMentData = $rent_query->fetch_data($conn, "cpl_rent_agreement_hst as a left join cpl_compliance_type as b on a.fk_cpl_compliancetype_id=b.pk_cpl_compliancetype_id left join sfa_ent_mst_entity as c on a.fk_sfa_ent_entity_id=c.pk_sfa_ent_entity_id left join sfa_cnf_mst_entity_type as d on c.fk_sfa_cnf_entitytype_id=d.pk_sfa_cnf_entitytype_id left join usm_add_users as e on a.ins_by=e.pk_usm_user_id left join usm_add_users as f on a.verified_by=f.pk_usm_user_id", "a.*,b.compliance_name,c.entity_name,d.type_name,e.user_name as uploaded_by ,f.user_name as verified_by", $condition);


    if ($agreeMentData != 0) {
    ?>
        <div class="box">
            <!-- /.box-header -->
            <div class="box-body">
                <table id="regservice" class="table table-bordered table-hover display nowrap margin-top-10 table-responsive">
                    <thead>
                        <tr>
                            <th colspan='4'>Establishment Details</th>
                            <th colspan='7'>Agreement Details</th>
                            <th colspan='2'></th>
                        </tr>
                        <tr>
                            <th>S.No</th>
                            <th>Establishment ID</th>
                            <th>Establishment Type</th>
                            <th>Establishment Name</th>
                            <th>Agreement Date</th>
                            <th>Agreement Type</th>
                            <th>Agreement Expiry Date</th>
                            <th>No of LandLords</th>
                            <th>Uploaded By</th>
                            <th>Verified By</th>
                            <th>Status</th>
                            <th>Verification Status</th>
                            <th>Action</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php
                        $i = 1;
                        foreach ($agreeMentData as $row) {
                        ?>
                            <tr>
                                <td><?php echo $i; ?></td>
                                <td><?php echo $row['fk_sfa_ent_entity_id']; ?></td>
                                <td><?php echo $row['type_name']; ?></td>
                                <td><?php echo $row['entity_name']; ?></td>
                                <td><?php echo $row['agreement_date']; ?></td>
                                <td><?php echo $row['compliance_name']; ?></td>
                                <td><?php echo $row['agreement_expiry_date']; ?></td>
                                <td><?php echo $getLandLordCount = $rent_query->get_row_count_of_table($conn, "cpl_rent_landlords_hst", "*", "fk_cpl_rentagreement_id='$row[pk_cpl_renthstagreement_id]'"); ?></td>
                                <td><?php echo $row['uploaded_by']; ?></td>
                                <td><?php echo $row['verified_by']; ?></td>
                                <?php
                                $today = date('Y-m-d');
                                $agreement_expiry_date = $row['agreement_expiry_date'];
                                $alert_user_l1 = date("Y-m-d", strtotime($row['alert_user_l1']));

                                if ($today > $agreement_expiry_date) {
                                    $status = "<span class='badge badge-danger'>Expired</span>";
                                } else if ($today == $agreement_expiry_date) {
                                    $status = "<span class='badge badge-warning'>Expiring Today</span>";
                                } else if ($today < $agreement_expiry_date && $today >= $alert_user_l1) {
                                    $status = "<span class='badge badge-warning'>Expiring Soon</span>";
                                } else {
                                    $status = "<span class='badge badge-success'>Active</span>";
                                }
                                echo "<td>$status</td>";
                                if ($row['verification_status'] == 0) {
                                    $status = "<span class='badge badge-warning'>Pending</span>";
                                } else if ($row['verification_status'] == 1) {
                                    $status = "<span class='badge badge-success'>Verified</span>";
                                } else if ($row['verification_status'] == -1) {
                                    $status = "<span class='badge badge-danger'>Rejected</span>";
                                }
                                echo "<td>$status</td>";
                                ?>
                                <td>
                                    <a href="javascript:void(0)" class="btn btn-success btn-xs" onClick="viewpopup('<?php echo $row['pk_cpl_renthstagreement_id'] ?>','ajaxpage/view_agreement_mis2.php')" id="view<?php echo $id ?>" title="View Details">V</a>
                                </td>
                            </tr>
                        <?php
                            $i++;
                        }
                        ?>
                    </tbody>
                </table>
            </div>
            <!-- /.box-body -->
        </div>
        <!-- /.box -->
    <?php
    } else {
    ?>
        <div class='alert alert-danger'>No Agreement Found</div>
<?php
    }
}
