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
if (!isset($_GET['c_id'])) {
    echo "<script>window.history.back()</script>";
}
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
    <title>Certificate Full View</title>
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
                        <h3 class="box-title float-left">Certificate Full View</h3>
                        <!-- <h3 class="box-title float-right"><a href="javascript:void(0)" class="btn btn-primary"
                                onclick="addpopup('ajaxpage/add_popup_cpl_certificate_type.php')"> Add New</a></h3> -->
                    </div>
                    <!-- /.box-header -->
                    <div class="box-body">
                        <div class="row">
                            <div class="col-12 col-md-6 p-1 mb-1">
                                <b>Certificate Preview </b>
                            </div>
                            <div class="col-12 col-md-6 p-1 mb-1">
                                <b>Certificate Fields</b>
                            </div>
                            <br>
                            <?php
                            $compliance_certificate = $ccm_query->fetch_data($conn, "cpl_compliance_master as a  left join cpl_compliance_type as c on a.fk_cpl_compliancetype_id = c.pk_cpl_compliancetype_id left join sfa_ent_mst_entity as d on a.fk_sfa_ent_entity_id=d.pk_sfa_ent_entity_id", "a.*,c.compliance_name,d.entity_name", "a.pk_cpl_compliance_id='$_GET[c_id]'");
                            // $ccm_query->debug($compliance_certificate);
                            if ($compliance_certificate != 0) {
                                foreach ($compliance_certificate as $certificate) {
                                    $total = $certificate['certification_cost'] + $certificate['convinience_fee'];
                                    if ($total == 0) {
                                        $total = '';
                                    }
                                    $fetch_org_name = $ccm_query->fetch_data($conn, 'sfa_ent_mst_entity', 'entity_name as org_name', "pk_sfa_ent_entity_id='$certificate[certification_organization]'");
                                    $org_name = $fetch_org_name[0]['org_name'];
                                    ?>
                                    <div class='col-12 col-md-6 p-0' style='border: solid 1px black;'>
                                        <embed src='../upload/certificate/<?php echo $certificate["certificate_file"] ?>'
                                            type='application/pdf' width='100%' height='100%'>
                                    </div>
                                    <div class='col-12 col-md-6 ' style='padding-top: 10px; border: black solid 1px;'>
                                        <table
                                            style='width: 100%; border-collapse: collapse; margin-bottom: 15px; color: black;'
                                            cellspacing='5' cellpadding='5'>
                                            <tbody>
                                                <tr>
                                                    <th style='width:160px'>Establishment ID </th>
                                                    <td style='width:10px'>:</td>
                                                    <td>
                                                        <?php echo $certificate['fk_sfa_ent_entity_id'] ?>
                                                    </td>
                                                </tr>
                                                <tr>
                                                    <th>Establishment Name </th>
                                                    <td>:</td>
                                                    <td>
                                                        <?php echo $certificate['entity_name'] ?>
                                                    </td>
                                                </tr>
                                                <tr>
                                                    <th>Certificate Date </th>
                                                    <td>:</td>
                                                    <td>
                                                        <?php echo $certificate['certification_date'] ?>
                                                    </td>
                                                </tr>
                                                <tr>
                                                    <th>Type </th>
                                                    <td>:</td>
                                                    <td>
                                                        <?php echo $certificate['compliance_name'] ?>
                                                    </td>
                                                </tr>
                                                <tr>
                                                    <th>Certificate No </th>
                                                    <td>:</td>
                                                    <td>
                                                        <?php echo $certificate['certificate_no'] ?>
                                                    </td>
                                                </tr>
                                                <tr>
                                                    <th>Certification Org. </th>
                                                    <td>:</td>
                                                    <td><?php echo $org_name ?></td>
                                                </tr>
                                                <tr>
                                                    <th>Consultant Name </th>
                                                    <td>:</td>
                                                    <td>
                                                        <?php echo $certificate['constant_name'] ?>
                                                    </td>
                                                </tr>
                                                <tr>
                                                    <th>Consultant Mobile </th>
                                                    <td>:</td>
                                                    <td>
                                                        <?php echo $certificate['consutant_mobile_no'] ?>
                                                    </td>
                                                </tr>
                                                <tr>
                                                    <th>Certificate Cost </th>
                                                    <td>:</td>
                                                    <td>
                                                        <?php echo $certificate['certification_cost'] ?>
                                                    </td>
                                                </tr>
                                                <tr>
                                                    <th>Convenience Fee </th>
                                                    <td>:</td>
                                                    <td>
                                                        <?php echo $certificate['convinience_fee'] ?>
                                                    </td>
                                                </tr>
                                                <tr>
                                                    <th>Total </th>
                                                    <td>:</td>
                                                    <td><?php echo $total ?></td>
                                                </tr>
                                                <tr>
                                                    <th>Expiry Date </th>
                                                    <td>:</td>
                                                    <td>
                                                        <?php echo $certificate['expiry_date'] ?>
                                                    </td>
                                                </tr>
                                                <tr>
                                                    <th>Renewal Due Date </th>
                                                    <td>:</td>
                                                    <td>
                                                        <?php echo $certificate['renew_due_date_l1'] ?>
                                                    </td>
                                                </tr>
                                                <tr>
                                                    <th>Verification Remark </th>
                                                    <td>:</td>
                                                    <td>
                                                        <?php echo $certificate['verification_remark'] ?>
                                                    </td>
                                                </tr>
                                            </tbody>
                                        </table>
                                        <br>
                                        <?php
                                        if ($certificate['verification_status'] == 0) {
                                            echo "<div class='text-warning' style='font-size:16px;font-weight:700;text-align:center;margin-bottom:14px;'>Verifcation Pending</div>";
                                        } else if ($certificate['verification_status'] == 1) {
                                            echo "<div class='text-success' style='font-size:16px;font-weight:700;text-align:center;margin-bottom:14px;'>Verification Done</div>";
                                        } else if ($certificate['verification_status'] == -1) {
                                            echo "<div class='text-danger' style='font-size:16px;font-weight:700;text-align:center;margin-bottom:14px;'>Rejected</div>";
                                        }
                                        echo "</div>";
                                }
                            }
                            ?>
                            </div>
                        </div>
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