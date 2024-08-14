<?php
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}
if ($_SESSION['user_id'] == '') {
    header('Location:../login.php');
}

if ($_GET['st'] == '') {
    header('Location:../');
}
date_default_timezone_set('Asia/Calcutta');
include "../check.php";
require_once "../classfile/initialize.php";
require_once "../classfile/compliance_certificate_management.php";
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="description" content="">
    <meta name="author" content="">
    <link rel="icon" href="../images/logo.png" sizes="32x32">
    <title>Admin Panel - Compliance Certificate Management - Compliance MIS</title>
    <!-- Bootstrap 4.0-->
    <link rel="stylesheet" href="../assets/vendor_components/bootstrap/dist/css/bootstrap.css">
    <!-- Bootstrap 4.0-->
    <link rel="stylesheet" href="../assets/vendor_components/bootstrap/dist/css/bootstrap-extend.css">
    <!-- font awesome -->
    <link rel="stylesheet" href="../assets/vendor_components/font-awesome/css/font-awesome.css">
    <!-- ionicons -->
    <link rel="stylesheet" href="../assets/vendor_components/Ionicons/css/ionicons.css">
    <!-- theme style -->
    <link rel="stylesheet" href="../css/master_style.css">
    <!-- apro_admin skins. choose a skin from the css/skins folder instead of downloading all of them to reduce the load. -->
    <link rel="stylesheet" href="../css/skins/_all-skins.css">
    <!-- weather weather -->
    <link rel="stylesheet" href="../assets/vendor_components/weather-icons/weather-icons.css">
    <!-- jvectormap -->
    <link rel="stylesheet" href="../assets/vendor_components/jvectormap/jquery-jvectormap.css">
    <!-- date picker -->
    <link rel="stylesheet" href="../assets/vendor_components/bootstrap-datepicker/dist/css/bootstrap-datepicker.css">
    <!-- daterange picker -->
    <link rel="stylesheet" href="../assets/vendor_components/bootstrap-daterangepicker/daterangepicker.css">
    <!-- bootstrap wysihtml5 - text editor -->
    <link rel="stylesheet" href="../assets/vendor_plugins/bootstrap-wysihtml5/bootstrap3-wysihtml5.css">
    <!-- toast CSS -->
    <link href="../assets/vendor_components/jquery-toast-plugin-master/src/jquery.toast.css" rel="stylesheet">
    <!-- google font -->
    <link href="https://fonts.googleapis.com/css?family=Poppins:300,400,500,600,700" rel="stylesheet">
    <!-- Data Table Css -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/datatables/1.10.21/css/dataTables.bootstrap.min.css" integrity="sha512-BMbq2It2D3J17/C7aRklzOODG1IQ3+MHw3ifzBHMBwGO/0yUqYmsStgBjI0z5EYlaDEFnvYV7gNYdD3vFLRKsA==" crossorigin="anonymous" referrerpolicy="no-referrer" />

    <!-- select2 css -->
    <link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" />
    <link rel="stylesheet" href="../css/cmxform.css">
    <link rel="stylesheet" href="../multiselect/jquery.multiselect.css">
    <link rel="stylesheet" href="css/custom.css">

</head>

<body class="hold-transition skin-black sidebar-mini">
    <div class="wrapper">
        <?php include "../header.php";?>
        <!-- Left side column. contains the logo and sidebar -->
        <?php include "menu.php";?>
        <!-- Content Wrapper. Contains page content -->
        <div class="content-wrapper">
            <!-- Main content -->
            <section class="content">
                <!-- Small boxes (Stat box) -->
                <!-- Basic Forms -->
                <div class="box box-default">
                    <div class="box-header with-border">
                        <h3 class="box-title float-left">Status Report</h3>
                        <!-- <h3 class="box-title float-right"><a href="javascript:void(0)" class="btn btn-primary"
                                onclick="addpopup('ajaxpage/add_popup_cpl_certificate_type.php')"> Add New</a></h3> -->
                    </div>
                    <!-- /.box-header -->
                    <?php
$currentDate = date('d-m-Y');
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
?>
                    <div class="box-body ">
                        <?php if ($_GET['st'] == 1) {?>
                            <div class="table-responsive">
                                <table id="regservice" class="table table-bordered table-hover display nowrap " style="width:100%">
                                    <thead>
                                        <tr style>
                                            <th scope='col'>S.No</th>
                                            <th scope='col'>Establishment<i class="invisible">_</i>Code</th>
                                            <th scope='col'>Establishment<i class="invisible">_</i>Name</th>
                                            <th scope='col'>Compliance<i class="invisible">_</i>Type</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <?php
$notCondition = $condition . " AND a.`compliance_applicable`='Yes' AND NOT EXISTS (SELECT * FROM cpl_compliance_master as cm WHERE cm.fk_sfa_ent_entity_id = a.fk_sfa_ent_entity_id AND cm.fk_cpl_compliancetype_id = a.fk_cpl_compliancetype_id) AND a.transaction_status='1'";
    $not_update = $ccm_query->fetch_data($conn, "cpl_establishment_compliance as a left join sfa_ent_mst_entity as b on a.fk_sfa_ent_entity_id=b.pk_sfa_ent_entity_id left join cpl_compliance_type as c on a.fk_cpl_compliancetype_id=c.pk_cpl_compliancetype_id", "a.*,b.entity_name,c.compliance_name", $notCondition);
    $sno = 1;
    if ($not_update != 0) {
        foreach ($not_update as $nu) {
            echo "<tr>
                                                <td scope='col'>$sno</td>
                                                <td scope='col'>$nu[fk_sfa_ent_entity_id]</td>
                                                <td scope='col'>$nu[entity_name]</td>
                                                <td scope='col'>$nu[compliance_name]</td>
                                            </tr>";
            $sno++;
        }
    }
    ?>
                                    </tbody>
                                </table>
                            </div>
                        <?php } else if ($_GET['st'] == 2) {?>
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
                                            <th>Verified<i class="invisible">_</i>By</th>
                                            <th>Verified<i class="invisible">_</i>Date</th>
                                            <th>Verification<i class="invisible">_</i>Remarks</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <?php
$expiringSoonCondition = $condition . " AND a.verification_status='1' AND str_to_date(a.`expiry_date`,'%d-%m-%Y') >= str_to_date('$currentDate','%d-%m-%Y') AND str_to_date(a.`renew_due_date_l1`,'%d-%m-%Y') <= str_to_date('$currentDate','%d-%m-%Y')";
    $expiring = $ccm_query->fetch_data($conn, "cpl_compliance_master as a left join sfa_ent_mst_entity as b on a.fk_sfa_ent_entity_id=b.pk_sfa_ent_entity_id left join cpl_compliance_type as c on a.fk_cpl_compliancetype_id=c.pk_cpl_compliancetype_id left join sfa_ent_mst_entity as d on a.certification_organization=d.pk_sfa_ent_entity_id left join sfa_ent_mst_entity as e on a.certification_vendor=e.pk_sfa_ent_entity_id left join usm_add_users as f on a.verified_by=f.pk_usm_user_id", "a.*,b.entity_name,c.compliance_name,d.entity_name as org , e.entity_name as vendor,f.user_name as verifiedBy", $expiringSoonCondition);
    $sno = 1;
    if ($expiring != 0) {
        foreach ($expiring as $es) {
            echo "<tr>
                                                <td scope='col'>$sno</td>
                                                <td scope='col'>$es[fk_sfa_ent_entity_id]</td>
                                                <td scope='col'>$es[entity_name]</td>
                                                <td scope='col'>$es[compliance_name]</td>
                                                <td scope='col'>$es[certification_date]</td>
                                                <td scope='col'>$es[org]</td>
                                                <td scope='col'>$es[vendor]</td>
                                                <td scope='col'>$es[constant_name]</td>
                                                <td scope='col'>$es[consutant_mobile_no]</td>
                                                <td scope='col'>$es[certificate_no]</td>
                                                <td scope='col'>$es[expiry_date]</td>
                                                <td scope='col'>$es[renew_due_date_l1]</td>
                                                <td scope='col'><a href='../upload/certificate/$es[certificate_file]' target='_blank'>View</a></td>
                                                <td scope='col'>$es[licence_nominee]</td>
                                                <td scope='col'>$es[next_year_budget]</td>
                                                <td scope='col'>$es[verifiedBy]</td>
                                                <td scope='col'>$es[verification_date]</td>
                                                <td scope='col'>$es[verification_remark]</td>
                                            </tr>";
            $sno++;
        }
    }
    ?>
                                    </tbody>
                                </table>
                            </div>
                        <?php } else if ($_GET['st'] == 3) {?>
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
                                            <th>Verified<i class="invisible">_</i>By</th>
                                            <th>Verified<i class="invisible">_</i>Date</th>
                                            <th>Verification<i class="invisible">_</i>Remarks</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <?php
$expiredCondition = $condition . " AND a.verification_status='1' AND str_to_date(a.`expiry_date`,'%d-%m-%Y') < str_to_date('$currentDate','%d-%m-%Y')";
    $expired = $ccm_query->fetch_data($conn, "cpl_compliance_master as a left join sfa_ent_mst_entity as b on a.fk_sfa_ent_entity_id=b.pk_sfa_ent_entity_id left join cpl_compliance_type as c on a.fk_cpl_compliancetype_id=c.pk_cpl_compliancetype_id left join sfa_ent_mst_entity as d on a.certification_organization=d.pk_sfa_ent_entity_id left join sfa_ent_mst_entity as e on a.certification_vendor=e.pk_sfa_ent_entity_id left join usm_add_users as f on a.verified_by=f.pk_usm_user_id", "a.*,b.entity_name,c.compliance_name,d.entity_name as org , e.entity_name as vendor,f.user_name as verifiedBy", $expiredCondition);
    $sno = 1;
    if ($expired != 0) {
        foreach ($expired as $e) {
            echo "<tr>
                                                <td scope='col'>$sno</td>
                                                <td scope='col'>$e[fk_sfa_ent_entity_id]</td>
                                                <td scope='col'>$e[entity_name]</td>
                                                <td scope='col'>$e[compliance_name]</td>
                                                <td scope='col'>$e[certification_date]</td>
                                                <td scope='col'>$e[org]</td>
                                                <td scope='col'>$e[vendor]</td>
                                                <td scope='col'>$e[constant_name]</td>
                                                <td scope='col'>$e[consutant_mobile_no]</td>
                                                <td scope='col'>$e[certificate_no]</td>
                                                <td scope='col'>$e[expiry_date]</td>
                                                <td scope='col'>$e[renew_due_date_l1]</td>
                                                <td scope='col'><a href='../upload/certificate/$e[certificate_file]' target='_blank'>View</a></td>
                                                <td scope='col'>$e[licence_nominee]</td>
                                                <td scope='col'>$e[next_year_budget]</td>
                                                <td scope='col'>$e[verifiedBy]</td>
                                                <td scope='col'>$e[verification_date]</td>
                                                <td scope='col'>$e[verification_remark]</td>
                                            </tr>";
            $sno++;
        }
    }
    ?>
                                    </tbody>
                                </table>
                            </div>

                        <?php } else if ($_GET['st'] == 4) {?>
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
                                            <th>Verified<i class="invisible">_</i>By</th>
                                            <th>Verified<i class="invisible">_</i>Date</th>
                                            <th>Verification<i class="invisible">_</i>Remarks</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <?php
$todayRenewalCondition = $condition . " AND a.verification_status='1' AND a.renew_due_date_l1 = '$currentDate'";
    $todayRenewal = $ccm_query->fetch_data($conn, "cpl_compliance_master as a left join sfa_ent_mst_entity as b on a.fk_sfa_ent_entity_id=b.pk_sfa_ent_entity_id left join cpl_compliance_type as c on a.fk_cpl_compliancetype_id=c.pk_cpl_compliancetype_id left join sfa_ent_mst_entity as d on a.certification_organization=d.pk_sfa_ent_entity_id left join sfa_ent_mst_entity as e on a.certification_vendor=e.pk_sfa_ent_entity_id left join usm_add_users as f on a.verified_by=f.pk_usm_user_id", "a.*,b.entity_name,c.compliance_name,d.entity_name as org , e.entity_name as vendor,f.user_name as verifiedBy", $todayRenewalCondition);
    $sno = 1;
    if ($todayRenewal != 0) {
        foreach ($todayRenewal as $r) {
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
                                                <td scope='col'>$r[verifiedBy]</td>
                                                <td scope='col'>$r[verification_date]</td>
                                                <td scope='col'>$r[verification_remark]</td>
                                            </tr>";
            $sno++;
        }
    }
    ?>
                                    </tbody>
                                </table>
                            </div>

                        <?php } else if ($_GET['st'] == 5) {?>
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
                                            <th>Verified<i class="invisible">_</i>By</th>
                                            <th>Verified<i class="invisible">_</i>Date</th>
                                            <th>Verification<i class="invisible">_</i>Remarks</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <?php
$todayRenewalCondition = $condition . " AND a.verification_status='1' AND str_to_date(a.`expiry_date`,'%d-%m-%Y') > str_to_date('$currentDate','%d-%m-%Y')  AND str_to_date(a.`renew_due_date_l1`,'%d-%m-%Y') > str_to_date('$currentDate','%d-%m-%Y')";
    $todayRenewal = $ccm_query->fetch_data($conn, "cpl_compliance_master as a left join sfa_ent_mst_entity as b on a.fk_sfa_ent_entity_id=b.pk_sfa_ent_entity_id left join cpl_compliance_type as c on a.fk_cpl_compliancetype_id=c.pk_cpl_compliancetype_id left join sfa_ent_mst_entity as d on a.certification_organization=d.pk_sfa_ent_entity_id left join sfa_ent_mst_entity as e on a.certification_vendor=e.pk_sfa_ent_entity_id left join usm_add_users as f on a.verified_by=f.pk_usm_user_id", "a.*,b.entity_name,c.compliance_name,d.entity_name as org , e.entity_name as vendor,f.user_name as verifiedBy", $todayRenewalCondition);
    $sno = 1;
    if ($todayRenewal != 0) {
        foreach ($todayRenewal as $r) {
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
                                                <td scope='col'>$r[verifiedBy]</td>
                                                <td scope='col'>$r[verification_date]</td>
                                                <td scope='col'>$r[verification_remark]</td>
                                            </tr>";
            $sno++;
        }
    }
    ?>
                                    </tbody>
                                </table>
                            </div>
                        <?php } else if ($_GET['st'] == 6) {?>

                            <div class="box-body">
                        <div class="col-12 col-lg-12  ">
                            <form method="post" id='reject_compliance_mis' onsubmit="getDataForm('ajaxpage/get_data_ajax.php','isset_reject_compliance_mis','reject_compliance_mis','#datadiv',event)">
                                <div class="form-group row">
                                    <label for="staticEmail" class="col-lg-3 col-form-label">Select Entity Type <span class="req">*</span></label>
                                    <div class="col-lg-3">
                                        <select name="entityType" onchange="DependantDropDown('entityType', 'entity_name','ajaxpage/get_data_ajax.php', 'isset_dependent_entityType')" id="entityType" class="form-control js-example-basic-single">
                                            <option selected="selected" value="">Select Entity</option>
                                            <?php $fetch_data = $ccm_query->fetch_data($conn, "sfa_cnf_mst_entity_type", "*", "transaction_status='1'");
    if ($fetch_data != 0) {
        foreach ($fetch_data as $row) {
            echo "<option value='$row[pk_sfa_cnf_entitytype_id]'>$row[type_name]</option>";
        }
    }
    ?>
                                        </select>
                                    </div>
                                    <label for="staticEmail" class="col-lg-3 col-form-label">Select Entity <span class="req">*</span></label>
                                    <div class="col-lg-3">
                                        <select name="entity_name" id="entity_name" class="form-control js-example-basic-single">
                                            <option value="">-Select-</option>
                                        </select>

                                    </div>
                                </div>
                                <div class="form-group row">

                                    <label for="staticEmail" class="col-lg-3 col-form-label">SELECT ZONE <span class="req text-danger">*</span></label>
                                    <div class="col-lg-3">
                                        <select name="zone_name" id="zone_name" class="form-control js-example-basic-single">
                                            <option value="">-Select-</option>
                                            <?php
$fetch_zone = $ccm_query->fetch_data($conn, "cnf_mst_zone", "*", "transaction_status='1'");
    if ($fetch_zone != 0) {
        foreach ($fetch_zone as $row_zone) {
            echo "<option value='$row_zone[pk_cnf_zone_id]'>$row_zone[zone_name]</option>";
        }
    }
    ?>
                                        </select>
                                    </div>
                                    <label for="staticEmail" class="col-lg-3 col-form-label">CERTIFICATE TYPE </label>
                                    <div class="col-lg-3">
                                        <select name="certificate_type" id="" class="form-control">
                                            <option value="">-Select-</option>
                                            <?php $fetch_compliance_type = $ccm_query->fetch_data($conn, "cpl_compliance_type", "*", "transaction_status='1'");
    if ($fetch_compliance_type != 0) {
        foreach ($fetch_compliance_type as $row_compliance_type) {
            echo "<option value='$row_compliance_type[pk_cpl_compliancetype_id]'>$row_compliance_type[compliance_name]</option>";
        }
    }
    ?>
                                        </select>
                                    </div>

                                </div>


                                <div class="form-group row">
                                    <div class="col-lg-1 mt-2 mt-lg-0">
                                        <input type="submit" value="Submit" id="Body_btnsubmit" class="btn btn-primary mb-2">
                                    </div>
                                </div>
                            </form>
                        </div>
                    </div>

                        <?php }?>
                    </div>
                </div>
                <div class="box">
                    <div id="datadiv"></div>
                </div>
                <!-- /.box -->
            </section>
            <!-- /.content -->
        </div>
        <!-- /.content-wrapper -->
        <?php include "../footer.php";?>
        <div class="control-sidebar-bg"></div>
    </div>
    <!-- ./wrapper -->
    <?php include "all_js.php";?>
    <!-- This is data table -->
    <script src="../assets/vendor_plugins/DataTables-1.10.15/media/js/jquery.dataTables.min.js"></script>
    <script src="../assets/vendor_plugins/DataTables-1.10.15/extensions/Buttons/js/dataTables.buttons.min.js"></script>
    <script src="../assets/vendor_plugins/DataTables-1.10.15/extensions/Buttons/js/buttons.flash.min.js"></script>
    <script src="../assets/vendor_plugins/DataTables-1.10.15/ex-js/jszip.min.js"></script>
    <script src="../assets/vendor_plugins/DataTables-1.10.15/ex-js/pdfmake.min.js"></script>
    <script src="../assets/vendor_plugins/DataTables-1.10.15/ex-js/vfs_fonts.js"></script>
    <script src="../assets/vendor_plugins/DataTables-1.10.15/extensions/Buttons/js/buttons.html5.min.js"></script>
    <script src="../assets/vendor_plugins/DataTables-1.10.15/extensions/Buttons/js/buttons.print.min.js"></script>
    <!-- end - This is for export functionality only -->
    <!-- javidation -->
    <script src="../assets/vendor_components/jquery-toast-plugin-master/src/jquery.toast.js"></script>
    <script src="../js/pages/toastr.js"></script>
    <script src="../assets/jsvalidation/dist/jquery.validate.js"></script>
    <script src="validation.js"></script>
    <link rel="stylesheet" href="../css/jquery-ui.css" />
    <script src="../js/jquery-ui.min.js"></script>
    <script src="../multiselect/jquery.multiselect.js"></script>

    <!-- select2 javascript -->
    <script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>
    <script src="../active_block.js"></script>
    <script src="js/compliance_certificate_management.js"></script>
    <script>
        $("#loading").show();
        $(function() {
            $("#loading").hide();
            $(".datepicker").datepicker({
                dateFormat: 'dd-mm-yy',
                changeMonth: true,
                changeYear: true,
            });
        });


        $("#regservice").DataTable({
            scrollX: true,
            bDestroy: true,
            dom: "Bfrtip",
            buttons: ["csv", "excel"],
            order: []
        });
    </script>
</body>

</html>