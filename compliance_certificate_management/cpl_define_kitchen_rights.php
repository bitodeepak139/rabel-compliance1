<?php
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}
if ($_SESSION['user_id'] == '')
    header('Location:../login.php');
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
    <title>Admin Panel - Compliance Certificate Management - Define Kitchen Rights</title>
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
    <link rel="stylesheet"
        href="https://cdnjs.cloudflare.com/ajax/libs/datatables/1.10.21/css/dataTables.bootstrap.min.css"
        integrity="sha512-BMbq2It2D3J17/C7aRklzOODG1IQ3+MHw3ifzBHMBwGO/0yUqYmsStgBjI0z5EYlaDEFnvYV7gNYdD3vFLRKsA=="
        crossorigin="anonymous" referrerpolicy="no-referrer" />
    <!-- select2 css -->
    <link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" />
    <link rel="stylesheet" href="../css/cmxform.css">
    <link rel="stylesheet" href="../multiselect/jquery.multiselect.css">
    <link rel="stylesheet" href="css/custom.css">
</head>

<body class="hold-transition skin-black sidebar-mini">
    <div class="wrapper">
        <?php include "../header.php"; ?>
        <!-- Left side column. contains the logo and sidebar -->
        <?php include "menu.php"; ?>
        <!-- Content Wrapper. Contains page content -->
        <div class="content-wrapper">
            <!-- Main content -->
            <section class="content">
                <!-- Small boxes (Stat box) -->
                <!-- Basic Forms -->
                <div class="box box-default">
                    <div class="box-header with-border">
                        <h3 class="box-title float-left">Define Kitchen Rights</h3>
                    </div>
                    <!-- /.box-header -->
                    <div class="box-body">
                        <div class="col-12 col-lg-12  ">
                            <form method="post" id='getDefineKitchenRights' onsubmit="getDataForm('ajaxpage/get_define_kitchen_rights.php','isset_getDefineKitchenRights','getDefineKitchenRights','#datadiv',event)">
                            <div class="form-group row">
                                    <label for="staticEmail" class="col-lg-3 col-form-label">Select Entity Type <span
                                            class="req text-danger">*</span></label>
                                    <div class="col-lg-3">
                                        <select name="entityType"
                                            onchange="DependantDropDown('entityType', 'entity_name','ajaxpage/get_data_ajax.php', 'isset_dependent_entityType')"
                                            id="entityType" class="form-control js-example-basic-single">
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
                                    <label for="staticEmail" class="col-lg-3 col-form-label">Select Entity <span
                                            class="req text-danger">*</span></label>
                                    <div class="col-lg-3">
                                        <select name="entity_name" id="entity_name"
                                            class="form-control js-example-basic-single">
                                            <option value="">-Select-</option>
                                        </select>

                                    </div>
                                </div>
                                <div class="form-group row">
                                    <!-- cnf_mst_zone -->

                                    <label for="staticEmail" class="col-lg-3 col-form-label">SELECT ZONE <span
                                            class="req text-danger">*</span></label>
                                    <div class="col-lg-3">
                                        <select name="zone_name" id="zone_name"
                                            class="form-control js-example-basic-single">
                                            <option value="">-Select-</option>
                                            <?php $fetch_zone = $ccm_query->fetch_data($conn, "cnf_mst_zone", "*", "transaction_status='1'");
// $ccm_query->debug($fetch_zone);
if ($fetch_zone != 0) {
    foreach ($fetch_zone as $row_zone) {
        echo "<option value='$row_zone[pk_cnf_zone_id]'>$row_zone[zone_name]</option>";
    }
}
?>
                                        </select>

                                    </div>
                                    <div class="col-lg-1 mt-2 mt-lg-0">
                                        <input type="submit" value="Submit" id="Body_btnsubmit"
                                            class="btn btn-primary mb-2">
                                    </div>
                                </div>
                            </form>
                        </div>
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
        <?php include "../footer.php"; ?>
        <div class="control-sidebar-bg"></div>
    </div>
    <!-- ./wrapper -->
    <?php include "all_js.php"; ?>
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
</body>

</html>