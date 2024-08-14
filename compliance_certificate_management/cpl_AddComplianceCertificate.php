<?php
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}
if ($_SESSION['user_id'] == '') {
    header('Location:../login.php');
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
    <title>Admin Panel - Compliance Certificate Management - Add Compliance Certificate</title>
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
    <link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" />
    <link href="https://fonts.googleapis.com/css?family=Poppins:300,400,500,600,700" rel="stylesheet">
    <link rel="stylesheet" href="../css/cmxform.css">
    <link rel="stylesheet" href="css/custom.css">
</head>

<body class="hold-transition skin-black sidebar-mini"
    onload="getdata('ajaxpage/get_data_ajax.php','isset_get_ccm_certificate_type','#datadiv')">
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
                        <h3 class="box-title float-left">Add Compliance Certificate</h3>
                        <!-- <h3 class="box-title float-right"><a href="javascript:void(0)" class="btn btn-primary"
                                onclick="addpopup('ajaxpage/add_popup_cpl_certificate_type.php')"> Add New</a></h3> -->
                    </div>
                    <!-- /.box-header -->
                    <div class="box-body">
                        <div class="row">
                            <div class="col-12">
                                <form method="post" enctype="multipart/form-data" id="addComplianceCertificate">
                                    <div class="form-group row">
                                        <label for="example-text-input" class="col-md-3 col-form-label">SELECT
                                            ESTABLISHMENT TYPE <span class='text-danger'>*</span></label>
                                        <div class="col-md-3">
                                            <select name="establishmentType"
                                                onchange="DependantDropDown('entityType', 'entity_name','ajaxpage/get_data_ajax.php', 'isset_dependent_entityType')"
                                                id="entityType" class="form-control js-example-basic-single">
                                                <option selected="selected" value="">Select Entity</option>
                                                <?php $fetch_data = $ccm_query->fetch_data($conn, "sfa_cnf_mst_entity_type", "*", "transaction_status='1'");
if ($fetch_data != 0) {
    foreach ($fetch_data as $row) {
        if ($row['pk_sfa_cnf_entitytype_id'] == 'KIT') {
            echo "<option value='$row[pk_sfa_cnf_entitytype_id]' selected>$row[type_name]</option>";
        } else {
            echo "<option value='$row[pk_sfa_cnf_entitytype_id]'>$row[type_name]</option>";
        }

    }
}
?>
                                            </select>
                                        </div>
                                        <label for="example-text-input" class="col-md-3 col-form-label">SELECT
                                            ESTABLISHMENT <span class='text-danger'>*</span></label>
                                        <div class="col-md-3">
                                            <select name="establishment" id="entity_name"
                                                onchange="DependantDropDown('entity_name', 'certificate_type','ajaxpage/get_data_ajax.php', 'isset_dependent_certificate_type')"
                                                class="form-control js-example-basic-single">
                                                <?php
if ($_SESSION['user_id'] == 'USM-U1') {
    $entityData = $ccm_query->fetch_data($conn, "sfa_ent_mst_entity", "*", "fk_sfa_cnf_entitytype_id='KIT' and transaction_status='1'");
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
?>
                                            </select>

                                        </div>
                                    </div>
                                    <div class="form-group row">
                                        <label for="example-text-input" class="col-md-3 col-form-label">SELECT
                                            CERTIFICATE
                                            <span class='text-danger'>*</span></label>
                                        <div class="col-md-3">
                                            <select class="form-select form-control form-select-lg js-example-basic-single"
                                                name="certificate_type" id="certificate_type">
                                                <option value="">-Select-</option>
                                            </select>
                                        </div>
                                        <label for="example-text-input" class="col-md-3 col-form-label">CERTIFICATE DATE
                                            <span class='text-danger'>*</span></label>
                                        <div class="col-md-3">
                                            <input type="text" name="certificate_date" class='form-control datepicker'
                                                autocomplete='off'>
                                        </div>
                                    </div>
                                    <div class="form-group row">

                                        <label for="example-text-input" class="col-md-3 col-form-label">CERTIFICATE
                                            ORGANIZATION
                                            <span class='text-danger'>*</span></label>
                                        <div class="col-md-3">
                                            <select class="form-select form-control form-select-lg js-example-basic-single"
                                                name="certificate_organization" id="">
                                                <option value="">-Select-</option>
                                                <?php
$fetch_org = $ccm_query->fetch_data($conn, "sfa_ent_mst_entity", "*", "fk_sfa_cnf_entitytype_id='ORG'");
if ($fetch_org != 0) {
    foreach ($fetch_org as $row_org) {
        echo "<option value='$row_org[pk_sfa_ent_entity_id]'>$row_org[entity_name] ($row_org[pk_sfa_ent_entity_id])</option>";
    }
}
?>
                                            </select>
                                        </div>

                                        <label for="example-text-input" class="col-md-3 col-form-label">CERTIFICATE
                                            VENDOR <span class='text-danger'>*</span></label>
                                        <div class="col-md-3">
                                            <select class="form-select form-control form-select-lg js-example-basic-single"
                                                name="certificate_vendor" id="">
                                                <option value="">-Select-</option>
                                                <?php
$fetch_vendor = $ccm_query->fetch_data($conn, "sfa_ent_mst_entity", "*", "fk_sfa_cnf_entitytype_id='SUP' Order by `entity_name` ASC");
if ($fetch_vendor != 0) {
    foreach ($fetch_vendor as $row_vendor) {
        echo "<option value='$row_vendor[pk_sfa_ent_entity_id]'>$row_vendor[entity_name] ($row_vendor[pk_sfa_ent_entity_id])</option>";
    }
}
// $ccm_query->debug($fetch_vendor);
?>
                                            </select>
                                        </div>
                                    </div>
                                    <div class="form-group row">
                                        <label for="example-text-input" class="col-md-3 col-form-label">CONSULT BY
                                            NAME</label>
                                        <div class="col-md-3">
                                            <input type="text" name="consult_name" class='form-control'
                                                autocomplete='off'>
                                        </div>
                                        <label for="example-text-input" class="col-md-3 col-form-label">CONSULT BY
                                            MOBILE</label>
                                        <div class="col-md-3">
                                            <input type="text" name="consult_mobile" id="consult_mobile"
                                                class='form-control' autocomplete='off'
                                                onkeyup="inputWithNumber('consult_mobile')">
                                        </div>
                                    </div>
                                    <div class="form-group row">
                                        <label for="example-text-input" class="col-md-3 col-form-label">CERTIFICATE
                                            NO <span class='text-danger'>*</span></label>
                                        <div class="col-md-3">
                                            <input type="text" name="certificate_no" class='form-control'
                                                autocomplete='off'>
                                        </div>
                                        <label for="example-text-input" class="col-md-3 col-form-label">CERTIFICATE
                                            EXPIRY DATE
                                            <span class='text-danger'>*</span></label>
                                        <div class="col-md-3">
                                            <input type="text" name="certificate_expire_date"
                                                class='form-control datepicker' autocomplete='off'>
                                        </div>
                                    </div>

                                    <div class="form-group row">
                                        <label for="licensceNominee" class="col-md-3 col-form-label">Licence Nominee<span class='text-danger'>*</span></label>
                                        <div class="col-md-9">
                                            <input type="text" name="licenceNominee" class='form-control'
                                                autocomplete='off'>
                                        </div>  
                                    </div>

                                    <div class="form-group row">
                                        <label for="example-text-input" class="col-md-3 col-form-label">UPLOAD
                                            CERTIFICATE <span class='text-danger'>*</span></label>
                                        <div class="col-md-3">
                                            <input type="file" name="ceritificate_upload" class='form-control'>
                                        </div>
                                        <label for="example-text-input" class="col-md-3 col-form-label">NEXT YEAR
                                            RENEWAL BUDGET <span class='text-danger'>*</span></label>
                                        <div class="col-md-3">
                                            <input type="text" name="renewal_budget" id='renewal_budget'
                                                class='form-control' autocomplete='off'
                                                onkeyup="inputWithNumber('renewal_budget')">
                                        </div>
                                    </div>

                                    <div class="form-group row">
                                        <label for="example-text-input" class="col-sm-3 col-form-label">Enter
                                            Details</label>
                                        <div class="col-sm-9">
                                            <textarea id="certificate_remark" rows="2" class="form-control"
                                                name='compliance_details'></textarea>
                                        </div>
                                    </div>
                                </form>
                                <div class="form-group row d-flex justify-content-center">
                                    <button type="submit" class='btn btn-primary'
                                        onClick="adddata('addComplianceCertificate','ajaxpage/addDataajax.php','isset_cpl_add_compliance_certificate')">Submit</button>
                                </div>
                            </div>
                            <!-- /.col -->
                        </div>
                    </div>
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
    <!-- select2 javascript -->
    <script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>
    <script src="../active_block.js"></script>
    <script src="js/compliance_certificate_management.js"></script>
    <script>
        $(function () {
            $(".datepicker").datepicker({
                dateFormat: 'dd-mm-yy',
                changeMonth: true,
                changeYear: true,
            });
        });
    </script>
</body>

</html>