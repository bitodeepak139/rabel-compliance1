<?php
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}
if ($_SESSION['user_id'] == '') { //header('Location:login.php');} ?>
    <script>window.location = '../login.php'</script>
<?php }
if (!isset($_GET['md'])) {
    echo "<script>window.location='../'</script>";
}
require_once '../classfile/initialize.php';
$mdid = base64_decode(base64_decode($_GET["md"]));
$result = $abc->fetch_data($conn, "usm_add_modules", "*", "pk_usm_module_id='$mdid'");
if ($result != 0) {
    $module_id = $mdid;
    $module_name = $result[0]['module_name'];
} else {
    echo "<script>window.location='../'</script>";
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
    <title>Admin Panel - Sales Force Automation</title>
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
    <!-- google font -->
    <link href="https://fonts.googleapis.com/css?family=Poppins:300,400,500,600,700" rel="stylesheet">
    <script src="../assets/vendor_components/jquery/dist/jquery.js"></script>
    <link rel="stylesheet" href="../datepicker/jquery.calendar.css" />
</head>

<body class="hold-transition skin-black sidebar-mini">
    <div class="wrapper">

        <?php include "../header.php"; ?>

        <!-- Left side column. contains the logo and sidebar -->
        <?php //include "menu.php"; ?>

        <!-- Content Wrapper. Contains page content -->
        <div class="content-wrapper" style="margin-left:0px">
            <!-- Content Header (Page header) -->
            <section class="content-header">
                <h1>
                    <?php echo $module_name; ?>
                    <!--<small>Control panel</small> -->
                </h1>
                <ol class="breadcrumb">
                    <li class="breadcrumb-item"><a href="../"><i class="fa fa-dashboard"></i> Home</a></li>
                    <li class="breadcrumb-item active"><a href="#">
                            <?php echo $module_name; ?>
                        </a></li>
                </ol>
            </section>

            <!-- Main content -->
            <section class="content">
                <!-- Small boxes (Stat box) -->
                <div class="row">
                    <div class="col-xl-4 col-md-4 col-12">
                        <?php
                        $rightData = $abc->fetch_data($conn, "usm_add_pages as a INNER JOIN usm_page_rights as b ON a.pk_usm_page_id = b.fk_usm_page_id INNER JOIN usm_add_modules as c on a.fk_usm_module_id=c.pk_usm_module_id INNER JOIN usm_mst_submodule as d ON a.fk_usm_sub_module_id = d.pk_usm_submodule_id", "DISTINCT  a.fk_usm_module_id,c.module_name,c.sub_module_status,c.module_url,d.pk_usm_submodule_id,d.submodule_name,d.dashboard_url,d.sm_seq", "b.fk_usm_user_id='$_SESSION[user_id]' AND a.transaction_status = '1' AND b.transaction_status = '1' AND c.transaction_status = '1' AND d.submodule_status = '1' AND d.fk_usm_module_id='USM-M4' ORDER by d.sm_seq asc");
                        
                        if ($rightData != 0) {
                            $slno = 1;
                            ?>
                            <div class="row">
                                <!-- /.col -->
                                <?php
                                foreach ($rightData as $subModRight) {
                                    if ($slno == 1) {
                                        $bgclr = '#287dc5';
                                        $bgicon = 'bg-aqua';
                                        $icon = 'bag';
                                    } else if ($slno == 2) {
                                        $bgclr = '#218a2e';
                                        $bgicon = 'bg-green';
                                        $icon = 'thumbsup';
                                    } else if ($slno == 3) {
                                        $bgclr = '#129c8f';
                                        $bgicon = 'bg-blue';
                                        $icon = 'person-stalker';
                                    } else if ($slno == 4) {
                                        $bgclr = '#e6456a';
                                        $bgicon = 'bg-red';
                                        $icon = 'ios-pricetag-outline';
                                    } else if ($slno == 5) {
                                        $bgclr = '#d47504';
                                        $bgicon = 'bg-orange';
                                        $icon = 'stats-bars';
                                    } else if ($slno == 6) {
                                        $bgclr = '#a13dd4fc';
                                        $bgicon = 'bg-purple';
                                        $icon = 'ios-cloud-download-outline';
                                    } else if ($slno == 7) {
                                        $bgclr = '#df19b1';
                                        $bgicon = 'bg-red';
                                        $icon = 'bag';
                                    }

                                    // $abc->debug($modRight);    
                                    $module_id = $subModRight['fk_usm_module_id'];
                                    $subModuleStatus = $subModRight['sub_module_status'];
                                    $subModuleID = $subModRight['pk_usm_submodule_id'];

                                    $page_sql_row = $abc->fetch_data($conn, "usm_add_pages as a INNER JOIN usm_page_rights as b ON a.pk_usm_page_id = b.fk_usm_page_id", "a.*", "b.fk_usm_user_id='$_SESSION[user_id]' AND a.transaction_status='1' AND b.transaction_status='1' AND a.fk_usm_module_id ='$module_id' AND b.transaction_status='1' AND b.fk_usm_sub_module_id='$subModuleID'  ORDER by a.page_sequence asc LIMIT 1");
                                    // $abc->debug($page_sql_row);

                                    if ($page_sql_row != 0) {
                                        $firstPageData = $page_sql_row[0];
                                        $page_id = base64_encode(base64_encode($firstPageData['pk_usm_page_id']));
                                        $module_id = base64_encode(base64_encode($firstPageData['fk_usm_module_id']));
                                        echo "<div class='col-xl-12 col-md-12 col-12'>
                      <a href='../$subModRight[dashboard_url]/$firstPageData[page_actual]?pg=$page_id&md=$module_id'>
                        <div class='info-box' style='background:$bgclr'>
                          <span class='info-box-icon $bgicon'><i class='ion ion-$icon '></i></span>
                          <div class='info-box-content'>
                            <span class='info-box-text'>
                              $subModRight[submodule_name] 
                            </span>
                          </div> 
                        </div> 
                      </a>
                    </div>";
                                    }

                                    $slno++;
                                    if ($slno == 8)
                                        $slno = 1;
                                }

                        } else {
                            echo 'No Sub module rights given for you.!!!';
                        } ?>
                        </div>
                    </div>
                    <div class="col-xl-8 col-md-8 col-12">
                        <div class="row">
                            <div class="col-xl-12 col-md-12 col-12">
                                <div class="border-bottom" style="padding:15px"></div>
                                <!-- <div id="pnlStyleContainer" style="width:100%;"></div> -->
                            </div>

                        </div>
                    </div>
                </div>
            </section>
            <!-- /.content -->
        </div>
        <!-- /.content-wrapper -->
        <?php include "../footer.php"; ?>
        <div class="control-sidebar-bg"></div>

    </div>
    <!-- ./wrapper -->
    <?php include "../all_js.php"; ?>
    <script src="../datepicker/jquery.calendar.js"></script>
    <script>
        $(function () {
            $('#pnlStyleContainer').calendar({
                color: '#0f5577',
                months: ['Jan', 'Feb', 'Mar', 'Apr', 'May', 'Jun', 'Jul', 'Aug', 'Sep', 'Oct', 'Nov', 'Dec'],
                days: ['Mon', 'Tue', 'Wed', 'Thu', 'Fri', 'Sat', 'Sun']
            });
        });
    </script>
</body>

</html>