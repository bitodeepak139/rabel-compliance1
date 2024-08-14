<?php
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}
if ($_SESSION['user_id'] == '')
    header('Location:../login.php');
date_default_timezone_set('Asia/Calcutta');
include "../check.php";
require_once "../classfile/initialize.php";
require_once "../classfile/sfa_entity_management.php";
if (!isset($_GET['ent_id'])) {
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
    <title>Admin Panel - Update Entity</title>
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
    <link rel="stylesheet" href="../css/cmxform.css">
    <link rel="stylesheet" href="css/custom.css">
</head>

<body class="hold-transition skin-black sidebar-mini" onload="getDataForm('ajaxpage/get_data_ajax.php','isset_bank_details_full_report','<?php echo $_GET['ent_id'] ?>','#datadiv'),getDataForm('ajaxpage/get_data_ajax.php','isset_contact_details_full_report','<?php echo $_GET['ent_id'] ?>','#resultData')">
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
                        <?php
                        $entity_id = $_GET['ent_id'];
                        $condition = "a.pk_sfa_ent_entity_id='$entity_id'";
                        $entityData = $sfa_ent->fetch_data($conn, "sfa_ent_mst_entity as a LEFT JOIN  sfa_ent_tns_entity_documents as b ON b.fk_sfa_ent_entity_id=a.pk_sfa_ent_entity_id LEFT JOIN sfa_cnf_mst_entity_type AS c ON a.fk_sfa_cnf_entitytype_id=c.pk_sfa_cnf_entitytype_id LEFT JOIN sfa_cnf_mst_entity_category as d ON a.fk_sfa_cnf_entcategory_id=d.pk_sfa_cnf_entcategory_id LEFT JOIN sfa_cnf_mst_entity_subcategory as e ON a.fk_sfa_cnf_entsubcategory_id=e.pk_sfa_cnf_entsubcategory_id LEFT JOIN sfa_cnf_mst_organization_type as f ON a.fk_sfa_cnf_orgtype_id=f.pk_sfa_cnf_custype_id LEFT JOIN utm_add_country as g ON a.country_id=g.pk_utm_country_id LEFT JOIN utm_add_state as h ON a.state_id=h.pk_utm_state_id LEFT JOIN utm_add_city as i ON a.city_id=i.pk_utm_city_id", "b.*,a.*,c.type_name,d.category_name,e.subcategory_name,f.type_name as org_type,g.country_name,h.state_name,i.city_name", $condition);
                        if (count($entityData) == 0) {
                            echo "<script>window.history.back()</script>";
                        } else {
                            $v = $entityData[0];
                        }
                        $target_Dir = '../upload/documents/' . $v['fk_sfa_ent_entity_id'] . '/';
                        $logo = $target_Dir . $v['entity_logo'];

                        ?>
                        <h3 class="box-title float-left">Entity Report</h3>
                        <button class='float-right btn btn-info' onclick="print_data('print_data')"><i class="fa fa-print" aria-hidden="true"></i></button>
                    </div>
                    <!-- /.box-header -->
                    <div>
                        <div class="modal-body">
                            <div class="row">
                                <div class="col-12" id='print_data'>
                                    <div class="table-responsive">
                                        <table class="table table-primary">
                                            <thead>
                                                <tr>
                                                    <th colspan="3" scope="col">Report Name : Client Full Details Report
                                                    </th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                <tr class="">
                                                    <td>Report Date :
                                                        <?php echo date('d-m-Y'); ?>
                                                    </td>
                                                    <td>User IP:
                                                        <?php echo $ip; ?>
                                                    </td>
                                                    <td>User System:
                                                        <?php echo 'Web'; ?>
                                                    </td>
                                                </tr>
                                            </tbody>
                                        </table>
                                    </div>
                                    <div class="row">
                                        <label class="col-sm-2 ">Entity Name</label>
                                        <div class="col-sm-6">: <span id="Body_ent_name">
                                                <?php echo $v['entity_name'] ?>
                                            </span></div>
                                        <label class="col-sm-2">Logo</label>
                                        <div class="col-sm-2">
                                            :
                                            <a href='<?php echo $logo; ?>' target='_blank'><img
                                                    src="<?php echo $logo; ?>" width="100px" height="50px"
                                                    alt="No Logo"></a>
                                        </div>
                                    </div>
                                    <div class="row">
                                        <label class="col-sm-2">Entity Code</label>
                                        <div class="col-sm-2">
                                            :
                                            <span id="Body_ent_code">
                                                <?php echo $v['fk_sfa_ent_entity_id'] ?>
                                            </span>
                                        </div>
                                        <label class="col-sm-2">Entry Date </label>
                                        <div class="col-sm-2">
                                            :
                                            <span id="Body_ent_date">
                                                <?php echo $v['ins_date']; ?>
                                            </span>
                                        </div>
                                        <label class="col-sm-2">Entry User </label>
                                        <div class="col-sm-2">
                                            :
                                            <span id="Body_ent_user">
                                                <?php echo $v['ins_by'] ?>
                                            </span>
                                        </div>
                                    </div>
                                    <div class="row">
                                        <label class="col-sm-2">Entity Type</label>
                                        <div class="col-sm-2">
                                            :
                                            <span id="Body_ent_type">
                                                <?php echo $v['type_name'] ?>
                                            </span>
                                        </div>
                                        <label class="col-sm-2">Category</label>
                                        <div class="col-sm-2">
                                            :
                                            <span id="Body_ent_cat">
                                                <?php echo $v['category_name'] ?>
                                            </span>
                                        </div>
                                        <label class="col-sm-2">Sub Category</label>
                                        <div class="col-sm-2">
                                            :
                                            <span id="Body_ent_sub_cat">
                                                <?php echo $v['subcategory_name']; ?>
                                            </span>
                                        </div>
                                        <label class="col-sm-2">Org Type</label>
                                        <div class="col-sm-2">
                                            :
                                            <span id="Body_ent_org">
                                                <?php echo $v['org_type'] ?>
                                            </span>
                                        </div>
                                    </div>
                                    <div class="row">
                                        <label class="col-sm-2">Entity Address</label>
                                        <div class="col-sm-10">
                                            :
                                            <span id="Body_ent_address">
                                                <?php echo $v['entity_address']; ?>
                                            </span>
                                        </div>
                                    </div>
                                    <div class="row">
                                        <label class="col-sm-2">Country</label>
                                        <div class="col-sm-2">
                                            :
                                            <span id="Body_country">
                                                <?php echo $v['country_name'] ?>
                                            </span>
                                        </div>
                                        <label class="col-sm-2">State</label>
                                        <div class="col-sm-2">
                                            :
                                            <span id="Body_state">
                                                <?php echo $v['state_name'] ?>
                                            </span>
                                        </div>
                                        <label class="col-sm-2">City</label>
                                        <div class="col-sm-2">
                                            :
                                            <span id="Body_city">
                                                <?php echo $v['city_name'] ?>
                                            </span>
                                        </div>
                                        <label class="col-sm-2">PIN Code</label>
                                        <div class="col-sm-2">
                                            :
                                            <span id="Body_pin_code">
                                                <?php echo $v['add_pincode'] ?>
                                            </span>
                                        </div>
                                    </div>
                                    <div class="row">
                                        <label class="col-sm-2">Landmark</label>
                                        <div class="col-sm-10">
                                            :
                                            <span id="Body_landmark">
                                                <?php echo $v['add_landmark'] ?>
                                            </span>
                                        </div>
                                    </div>
                                    <div class="row">

                                        <label class="col-sm-2">Contact No</label>
                                        <div class="col-sm-4">
                                            :
                                            <span id="Body_contact_no">
                                                <?php echo $v['contact_no1'] ?>
                                            </span>
                                        </div>
                                        <label class="col-sm-2">Alternate No</label>
                                        <div class="col-sm-4">
                                            :
                                            <span id="Body_alt_contact">
                                                <?php echo $v['contact_no2']; ?>
                                            </span>
                                        </div>
                                    </div>
                                    <div class="row">
                                        <label class="col-sm-2">Website</label>
                                        <div class="col-sm-4">
                                            :
                                            <span id="Body_website">
                                                <?php echo $v['website_url'] ?>
                                            </span>
                                        </div>
                                        <label class="col-sm-2">Email ID</label>
                                        <div class="col-sm-4">
                                            :
                                            <span id="Body_email_id">
                                                <?php echo $v['ent_email'] ?>
                                            </span>
                                        </div>
                                    </div>
                                    <div class="row">
                                        <label class="col-sm-2">Pan No </label>
                                        <div class="col-sm-2">
                                            :
                                            <span id="Body_pan_no">
                                                <?php echo $v['pan_no'] ?>
                                            </span>
                                        </div>
                                        <label class="col-sm-2">GSTN No </label>
                                        <div class="col-sm-2">
                                            :
                                            <span id="Body_gst_no">
                                                <?php echo $v['gstn_no'] ?>
                                            </span>
                                        </div>
                                        <label class="col-sm-2">Tan No </label>
                                        <div class="col-sm-2">
                                            :
                                            <span id="Body_tan_no" style='word-wrap:break-word;'>
                                                <?php echo $v['tan_no'] ?>
                                            </span>
                                        </div>
                                    </div>
                                    <hr>
                                    <h5>Document List :-</h5>
                                    <br>
                                    <div class="row">
                                        <div class="col-12 table table-responsive ">
                                            <?php if($v['document_file']){ ?>
                                            <table
                                                class="table table-bordered table-striped table-hover display table_design m-0">
                                                <thead class='bg-primary text-white'>
                                                    <tr style=''>
                                                        <th class="text-left text-nowrap" scope='col'>S.No</th>
                                                        <th class="text-left text-nowrap">Document Type</th>
                                                        <th class="text-left text-nowrap" scope='col'>Document Name
                                                        </th>
                                                        <th class="text-left text-nowrap" scope='col'>Action
                                                        </th>
                                                    </tr>
                                                </thead>
                                                <tbody>
                                                    <?php
                                                    for ($i = 0; $i < count($entityData); $i++) {
                                                        $sno = $i;
                                                        $sno++;
                                                        $entityID = $v['pk_sfa_ent_entity_id'];
                                                        $docType = $entityData[$i]['document_type'];
                                                        $fileName = $entityData[$i]['document_file'];
                                                        $docName = $entityData[$i]['document_name'];
                                                        if($docType != ''){
                                                            echo "
                                                            <tr style=''>
                                                                <td class='text-left text-nowrap' scope='col'>$sno</td>
                                                                <td class='text-left text-nowrap' scope='col'>$docType</td>
                                                                <td class='text-left text-nowrap' scope='col'>$docName</td>
                                                                <td class='text-left text-nowrap' scope='col'>
                                                                 <a href='../upload/documents/$entityID/$fileName'
                                                                target='_blank' class='text-danger text-left d-block'>Download</a>
                                                                </td>
                                                            </tr>
                                                                ";
                                                        }
                                                        ?>
                                                        <?php
                                                    } ?>
                                                </tbody>
                                            </table>
                                            <?php } ?>
                                        </div>
                                    </div>
                                    <hr>
                                    <h5>Bank Details :-</h5>
                                    <div class="row">
                                        <div class="col-12 table table-responsive ">
                                            <div style='margin-top:6px;' id='datadiv'></div>
                                        </div>
                                    </div>
                                    <hr>
                                    <h5>Entity Contact List :-</h5>
                                    <div class="row">
                                        <div class="col-12 table table-responsive ">
                                            <div style='margin-top:6px;' id='resultData'></div>
                                        </div>
                                    </div>
                                    <hr>
                                </div>
                                <!-- /.col -->
                            </div>
                            <!-- /.row -->
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
    <script src="../active_block.js"></script>
    <script src="js/sfa_entity_management.js"></script>
    <!-- <div class="modal fade" id="mymodal">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h4 class="modal-title">Add New Entity Type</h4>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span></button>
                </div>
                <div id="adddiv"></div>
            </div>
        </div>
    </div> -->
    <!-- /.modal -->
    <div class="modal fade" id="mymodal1">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h4 class="modal-title">Edit Entity Type Details</h4>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span></button>
                </div>
                <div id="editdiv"></div>
            </div>
            <!-- /.modal-content -->
        </div>
        <!-- /.modal-dialog -->
    </div>
    <!-- /.modal -->
</body>

</html>