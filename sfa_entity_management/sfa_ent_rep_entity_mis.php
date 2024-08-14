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
    <title>Entity MIS</title>
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
                        <h3 class="box-title float-left">Entity MIS</h3>
                        <!-- <h3 class="box-title float-right"><a href="javascript:void(0)" class="btn btn-primary"
                                onclick="addpopup('ajaxpage/add_popup_cpl_certificate_type.php')"> Add New</a></h3> -->
                    </div>
                    <!-- /.box-header -->
                    <div class="box-body">
                        <div class="col-12 col-lg-12  ">
                            <form method="post" id='entityMIS'
                                onsubmit="getDataFormWithEvent('ajaxpage/get_data_ajax.php','isset_EntityMIS','entityMIS','#datadiv',event)">
                                <div class="form-group row">
                                    <label for="staticEmail" class="col-lg-2 col-form-label">DATE FROM</label>
                                    <div class="col-lg-2">
                                        <input type="text" name='date_form' class="form-control datepicker"
                                            autocomplete="off">
                                    </div>
                                    <label for="staticEmail" class="col-lg-2 col-form-label">DATE TO</label>
                                    <div class="col-lg-2">
                                        <input type="text" name="date_to" class="form-control datepicker"
                                            autocomplete="off">
                                    </div>
                                </div>
                                <div class="form-group row">
                                    <label for="example-text-input" class="col-lg-2 col-form-label">ENTITY TYPE </label>
                                    <div class="col-lg-2">
                                        <select name="establishmentType"
                                            onchange="DependantDropDown('entityType', 'entity_name','ajaxpage/get_data_ajax.php', 'isset_dependent_entityType')"
                                            id="entityType" class="form-control">
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
                                    <label for="example-text-input" class="col-lg-2 col-form-label">SELECT
                                        STATE </label>
                                    <div class="col-lg-2">
                                        <div id="statediv">
                                            <select id="state" class="form-control " name='state'
                                                onchange="DependantDropDown('state', 'district','ajaxpage/get_data_ajax.php', 'isset_dependent_state_for_district')">
                                                <option value="">Select State</option>
                                                <?php
                                                $stateData = $sfa_ent->fetch_data($conn, "utm_add_state", "*", "fk_utm_country_id='+91' AND transaction_status='1'");
                                                if ($stateData != 0) {
                                                    foreach ($stateData as $row) {
                                                        echo "<option value='$row[pk_utm_state_id]'>$row[state_name]</option>";
                                                    }
                                                }
                                                ?>
                                            </select>
                                        </div>
                                    </div>
                                    <label for="example-text-input" class="col-lg-2 col-form-label">SELECT
                                        DISTRICT </label>
                                    <div class="col-lg-2">
                                        <select id="district" class="form-control" name='district'>
                                            <option value="">Select District</option>

                                        </select>
                                    </div>
                                </div>
                                <div class="form-group row">
                                    <label for="example-text-input" class="col-lg-2 col-form-label">SELECT
                                        ZONE </label>
                                    <div class="col-lg-2">
                                        <select id="zone" class="form-control"
                                            onchange="DependantDropDown('zone', 'region','ajaxpage/get_data_ajax.php', 'isset_dependent_zone')"
                                            name='zone'>
                                            <option value="">Select Zone</option>
                                            <?php
                                            $retval = $sfa_ent->fetch_data($conn, "cnf_mst_zone ", "*", "transaction_status='1'");
                                            if ($retval != 0) {
                                                foreach ($retval as $row) {
                                                    echo "<option value='$row[pk_cnf_zone_id]'>$row[zone_name]</option>";
                                                }
                                            }
                                            ?>
                                        </select>
                                    </div>
                                    <label for="example-text-input" class="col-lg-2 col-form-label">SELECT
                                        REGION </label>
                                    <div class="col-lg-2">
                                        <div id="statediv">
                                            <select id="region" class="form-control" name='region'>
                                                <option value="">Select Region</option>
                                            </select>
                                        </div>
                                    </div>


                                    <div class="col-lg-1 mt-2 mt-lg-0">
                                        <input type="submit" value="Submit" id="Body_btnsubmit"
                                            class="btn btn-primary mb-2">
                                    </div>
                                </div>

                            </form>
                        </div>
                    </div>
                    <div id="datadiv"></div>
                </div>
                <!-- <div class="box">
                    
                </div> -->
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
    <script src="js/sfa_entity_management.js"></script>
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