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
                        <h3 class="box-title float-left">Contact MIS</h3>
                        <!-- <h3 class="box-title float-right"><a href="javascript:void(0)" class="btn btn-primary"
                                onclick="addpopup('ajaxpage/add_popup_cpl_certificate_type.php')"> Add New</a></h3> -->
                    </div>
                    <!-- /.box-header -->
                    <div class="box-body">
                        <!-- <div class="col-12 col-lg-12  "> -->
                        <div class="col-12" style="overflow: auto">
                            <table cellspacing="0" autogeneratecolumns="False" style='width:100%;'>
                                <tbody>
                                    <tr>
                                        <td>
                                            <input class="contactMisCheck" id="check1" type="checkbox"
                                                onclick="checkStatusContactMIS('#check1','#datadiv','All')">
                                            <label for="check1">All</label>

                                        </td>
                                        <td>
                                            <input class="contactMisCheck" id="check2" type="checkbox"
                                                onclick="checkStatusContactMIS('#check2','#datadiv','A')">
                                            <label for="check2">A</label>
                                        </td>
                                        <td>
                                            <input class="contactMisCheck" id="check3" type="checkbox"
                                                onclick="checkStatusContactMIS('#check3','#datadiv','B')">
                                            <label for="check3">B</label>
                                        </td>
                                        <td>
                                            <input class="contactMisCheck" id="check4" type="checkbox"
                                                onclick="checkStatusContactMIS('#check4','#datadiv','C')">
                                            <label for="check4">C</label>
                                        </td>
                                        <td>
                                            <input class="contactMisCheck" id="check5" type="checkbox"
                                                onclick="checkStatusContactMIS('#check5','#datadiv','D')">
                                            <label for="check5">D</label>
                                        </td>
                                        <td>
                                            <input class="contactMisCheck" id="check6" type="checkbox"
                                                onclick="checkStatusContactMIS('#check6','#datadiv','E')">
                                            <label for="check6">E</label>
                                        </td>
                                        <td>
                                            <input class="contactMisCheck" id="check7" type="checkbox"
                                                onclick="checkStatusContactMIS('#check7','#datadiv','F')">
                                            <label for="check7">F</label>
                                        </td>
                                        <td>
                                            <input class="contactMisCheck" id="check8" type="checkbox"
                                                onclick="checkStatusContactMIS('#check8','#datadiv','G')">
                                            <label for="check8">G</label>
                                        </td>
                                        <td>
                                            <input class="contactMisCheck" id="check9" type="checkbox"
                                                onclick="checkStatusContactMIS('#check9','#datadiv','H')">
                                            <label for="check9">H</label>
                                        </td>
                                        <td>
                                            <input class="contactMisCheck" id="check10" type="checkbox"
                                                onclick="checkStatusContactMIS('#check10','#datadiv','I')">
                                            <label for="check10">I</label>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td>
                                            <input class="contactMisCheck" id="check11" type="checkbox"
                                                onclick="checkStatusContactMIS('#check11','#datadiv','J')">
                                            <label for="check11">J</label>
                                        </td>
                                        <td>
                                            <input class="contactMisCheck" id="check12" type="checkbox"
                                                onclick="checkStatusContactMIS('#check12','#datadiv','K')">
                                            <label for="check12">K</label>
                                        </td>
                                        <td>
                                            <input class="contactMisCheck" id="check13" type="checkbox"
                                                onclick="checkStatusContactMIS('#check13','#datadiv','L')">
                                            <label for="check13">L</label>
                                        </td>
                                        <td>
                                            <input class="contactMisCheck" id="check14" type="checkbox"
                                                onclick="checkStatusContactMIS('#check14','#datadiv','M')">
                                            <label for="check14">M</label>
                                        </td>
                                        <td>
                                            <input class="contactMisCheck" id="check15" type="checkbox"
                                                onclick="checkStatusContactMIS('#check15','#datadiv','N')">
                                            <label for="check15">N</label>
                                        </td>
                                        <td>
                                            <input class="contactMisCheck" id="check16" type="checkbox"
                                                onclick="checkStatusContactMIS('#check16','#datadiv','O')">
                                            <label for="check16">O</label>
                                        </td>
                                        <td>
                                            <input class="contactMisCheck" id="check17" type="checkbox"
                                                onclick="checkStatusContactMIS('#check17','#datadiv','P')">
                                            <label for="check17">P</label>
                                        </td>
                                        <td>
                                            <input class="contactMisCheck" id="check18" type="checkbox"
                                                onclick="checkStatusContactMIS('#check18','#datadiv','Q')">
                                            <label for="check18">Q</label>
                                        </td>
                                        <td>
                                            <input class="contactMisCheck" id="check19" type="checkbox"
                                                onclick="checkStatusContactMIS('#check19','#datadiv','R')">
                                            <label for="check19">R</label>
                                        </td>
                                        <td>
                                            <input class="contactMisCheck" id="check20" type="checkbox"
                                                onclick="checkStatusContactMIS('#check20','#datadiv','S')">
                                            <label for="check20">S</label>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td>
                                            <input class="contactMisCheck" id="check21" type="checkbox"
                                                onclick="checkStatusContactMIS('#check21','#datadiv','T')">
                                            <label for="check21">T</label>
                                        </td>
                                        <td>
                                            <input class="contactMisCheck" id="check22" type="checkbox"
                                                onclick="checkStatusContactMIS('#check22','#datadiv','U')">
                                            <label for="check22">U</label>
                                        </td>
                                        <td>
                                            <input class="contactMisCheck" id="check23" type="checkbox"
                                                onclick="checkStatusContactMIS('#check23','#datadiv','V')">
                                            <label for="check23">V</label>
                                        </td>
                                        <td>
                                            <input class="contactMisCheck" id="check24" type="checkbox"
                                                onclick="checkStatusContactMIS('#check24','#datadiv','W')">
                                            <label for="check24">W</label>
                                        </td>
                                        <td>
                                            <input class="contactMisCheck" id="check25" type="checkbox"
                                                onclick="checkStatusContactMIS('#check25','#datadiv','X')">
                                            <label for="check25">X</label>
                                        </td>
                                        <td>
                                            <input class="contactMisCheck" id="check26" type="checkbox"
                                                onclick="checkStatusContactMIS('#check26','#datadiv','Y')">
                                            <label for="check26">Y</label>
                                        </td>
                                        <td>
                                            <input class="contactMisCheck" id="check27" type="checkbox"
                                                onclick="checkStatusContactMIS('#check27','#datadiv','Z')">
                                            <label for="check27">Z</label>
                                        </td>
                                    </tr>

                                </tbody>
                            </table>
                        </div>
                        <!-- </div> -->
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
    <script src="js/sfa_entity_management2.js"></script>
    <script>
        $(function () {
            $(".datepicker").datepicker({
                dateFormat: 'dd-mm-yy',
                changeMonth: true,
                changeYear: true,
            });
        });
    </script>

    <div class="modal fade" id="mymodal1">
        <div class="modal-dialog modal-lg" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h4 class="modal-title">Edit </h4>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span></button>
                </div>
                <div id="editdiv"></div>
            </div>
            <!-- /.modal-content -->
        </div>
        <!-- /.modal-dialog -->
    </div>



    <div class="modal fade" id="mymodal2">
        <div class="modal-dialog modal-lg" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h4 class="modal-title">View</h4>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span></button>
                </div>
                <div id="viewdiv"></div>
            </div>
            <!-- /.modal-content -->
        </div>
        <!-- /.modal-dialog -->
    </div>


</body>

</html>