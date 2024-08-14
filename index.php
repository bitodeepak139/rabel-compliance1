<?php
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}
if ($_SESSION['user_id'] == '') { //header('Location:login.php');}
    ?>
    <script>
        window.location = 'login.php'
    </script>
<?php
}
require_once 'classfile/initialize.php';
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="description" content="">
    <meta name="author" content="">
    <link rel="icon" href="images/logo.png" sizes="32x32">
    <title>Admin Panel - Dashboard</title>
    <!-- Bootstrap 4.0-->
    <link rel="stylesheet" href="assets/vendor_components/bootstrap/dist/css/bootstrap.css">
    <!-- Bootstrap 4.0-->
    <link rel="stylesheet" href="assets/vendor_components/bootstrap/dist/css/bootstrap-extend.css">
    <!-- font awesome -->
    <link rel="stylesheet" href="assets/vendor_components/font-awesome/css/font-awesome.css">
    <!-- ionicons -->
    <link rel="stylesheet" href="assets/vendor_components/Ionicons/css/ionicons.css">
    <!-- theme style -->
    <link rel="stylesheet" href="css/master_style.css">
    <!-- apro_admin skins. choose a skin from the css/skins folder instead of downloading all of them to reduce the load. -->
    <link rel="stylesheet" href="css/skins/_all-skins.css">
    <!-- weather weather -->
    <link rel="stylesheet" href="assets/vendor_components/weather-icons/weather-icons.css">
    <!-- jvectormap -->
    <link rel="stylesheet" href="assets/vendor_components/jvectormap/jquery-jvectormap.css">
    <!-- date picker -->
    <link rel="stylesheet" href="assets/vendor_components/bootstrap-datepicker/dist/css/bootstrap-datepicker.css">
    <!-- daterange picker -->
    <link rel="stylesheet" href="assets/vendor_components/bootstrap-daterangepicker/daterangepicker.css">
    <!-- bootstrap wysihtml5 - text editor -->
    <link rel="stylesheet" href="assets/vendor_plugins/bootstrap-wysihtml5/bootstrap3-wysihtml5.css">
    <!-- google font -->
    <link href="https://fonts.googleapis.com/css?family=Poppins:300,400,500,600,700" rel="stylesheet">
    <script src="assets/vendor_components/jquery/dist/jquery.js"></script>
    <link rel="stylesheet" href="datepicker/jquery.calendar.css" />
    <style>
        .title-heading {
            font-size: 20px;
            font-weight: 600;
            color: #0f5577;
            margin-bottom: 10px;
        }

        .title-heading:after {
            content: '';
            display: block;
            width: 8%;
            height: 2px;
            background: #0f5577;
            margin-top: 5px;
        }
    </style>
</head>

<body class="hold-transition skin-black sidebar-mini">
    <div class="wrapper">

        <?php include "header.php";?>

        <!-- Left side column. contains the logo and sidebar -->
        <?php //include "menu.php";
?>

        <!-- Content Wrapper. Contains page content -->
        <div class="content-wrapper" style="margin-left:0px">
            <!-- Content Header (Page header) -->
            <section class="content-header">
                <h1>
                    Dashboard
                    <!--<small>Control panel</small> -->
                </h1>
                <ol class="breadcrumb">
                    <li class="breadcrumb-item"><a href="#"><i class="fa fa-dashboard"></i> Home</a></li>
                    <li class="breadcrumb-item active">Dashboard</li>
                </ol>
            </section>
            <!-- Main content -->
            <section class="content">
                <!-- Small boxes (Stat box) -->
                <div class="row">
                    <div class="col-xl-4 col-md-4 col-12">
                        <?php

$rightData = $abc->fetch_data($conn, "usm_add_pages as a INNER JOIN usm_page_rights as b ON a.pk_usm_page_id = b.fk_usm_page_id INNER JOIN usm_add_modules as c on a.fk_usm_module_id=c.pk_usm_module_id", "DISTINCT  a.fk_usm_module_id,c.module_name,c.sub_module_status,c.module_url,c.module_seq", "b.fk_usm_user_id='$_SESSION[user_id]' AND a.transaction_status = '1' AND b.transaction_status='1' AND c.transaction_status = '1' ORDER by c.module_seq asc");
if ($rightData != 0) {
    $slno = 1;

    ?>
                            <div class="row">
                                <!-- /.col -->
                            <?php
foreach ($rightData as $modRight) {
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

        $module_id = $modRight['fk_usm_module_id'];
        $subModuleStatus = $modRight['sub_module_status'];
        if ($subModuleStatus != 0) {
            $module_id = base64_encode(base64_encode($modRight['fk_usm_module_id']));
            echo "<div class='col-xl-12 col-md-12 col-12'>
                    <a href='$modRight[module_url]?md=$module_id'>
                      <div class='info-box' style='background:$bgclr'>
                        <span class='info-box-icon $bgicon'><i class='ion ion-$icon '></i></span>
                        <div class='info-box-content'>
                          <span class='info-box-text'>
                            $modRight[module_name]
                          </span>
                        </div>
                      </div>
                    </a>
                  </div>";
        } else {
            $page_sql_row = $abc->fetch_data($conn, "usm_add_pages as a INNER JOIN usm_page_rights as b ON a.pk_usm_page_id = b.fk_usm_page_id", "a.*", "b.fk_usm_user_id='$_SESSION[user_id]' AND a.transaction_status='1' AND a.fk_usm_module_id ='$module_id'  ORDER by a.page_sequence asc LIMIT 1");
            if ($page_sql_row != 0) {
                $firstPageData = $page_sql_row[0];
                $page_id = base64_encode(base64_encode($firstPageData['pk_usm_page_id']));
                $module_id = base64_encode(base64_encode($firstPageData['fk_usm_module_id']));
                echo "<div class='col-xl-12 col-md-12 col-12'>
                      <a href='$modRight[module_url]/$firstPageData[page_actual]?pg=$page_id&md=$module_id'>
                        <div class='info-box' style='background:$bgclr'>
                          <span class='info-box-icon $bgicon'><i class='ion ion-$icon '></i></span>
                          <div class='info-box-content'>
                            <span class='info-box-text'>
                              $modRight[module_name]
                            </span>
                          </div>
                        </div>
                      </a>
                    </div>";
            }
        }

        $slno++;
        if ($slno == 8) {
            $slno = 1;
        }
    }
} else {
    echo 'No module rights given for you.!!!';
}?>
                            </div>


                    </div>
                    <?php if ($rightData != 0) {

    $pageRight = $abc->fetch_data($conn, "usm_add_pages as a INNER JOIN usm_page_rights as b ON a.pk_usm_page_id = b.fk_usm_page_id", "a.*,b.transaction_status", "b.fk_usm_user_id='$_SESSION[user_id]' AND a.transaction_status='1' AND b.transaction_status='1' AND b.fk_usm_module_id='USM-M21' AND fk_usm_page_id='UTM-P116'  ORDER by a.page_sequence asc");

    ?>
                        <div class="col-xl-8 col-md-8 col-12">
                            <div class="row">
                                <div class="col-xl-9 col-md-9">
                                    <h5 class='title-heading'>Compliance Grid Status</h5>
                                </div>
                                <div class="col-xl-3 col-md-3" style='display: flex;justify-content: end;align-items: center;'>
                                    <a href="javascript:void(0);" class="btn btn-primary btn-sm" style="margin-top: 10px;" id='refreshBtn' onclick="Refresh('<?=$_SESSION['user_id']?>')"><i class="fa fa-refresh" aria-hidden="true"></i></a>
                                </div>
                                <div class="col-xl-4 col-md-6 ">
                                    <a href="">
                                        <div class="card bg-primary shadow h-100 mb-1">
                                            <div class="card-body">
                                                <div class="row no-gutters align-items-center">
                                                    <div class="col mr-2">
                                                        <div class="text-xs font-weight-bold text-white text-uppercase ">
                                                            Total Compliance</div>
                                                        <div class="h5 mb-0 font-weight-bold text-white">
                                                            <?php echo $_SESSION['total_compliance']; ?>
                                                        </div>
                                                    </div>
                                                    <div class="col-auto">
                                                        <img src="images/tab/compliant.png" alt="compliance" style='max-width:50px;'>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </a>
                                </div>
                                <div class="col-xl-4 col-md-6 ">
                                    <?php
$urlc = "#";
    if ($pageRight != 0) {
        $page = $pageRight[0];
        $page_id = base64_encode(base64_encode($page['pk_usm_page_id']));
        $module_id = base64_encode(base64_encode($page['fk_usm_module_id']));
        $urlc = "compliance_certificate_management/$page[page_actual]?pg=$page_id&md=$module_id&st=5";
    }
    ?>
                                    <a href="<?=$urlc?>">
                                        <div class="card bg-success shadow h-100 mb-1">
                                            <div class="card-body">
                                                <div class="row no-gutters align-items-center">
                                                    <div class="col mr-2">
                                                        <div class="text-xs font-weight-bold text-white text-uppercase mb-1">
                                                            Total Complied</div>
                                                        <div class="h5 mb-0 font-weight-bold text-white ">
                                                            <?=$_SESSION['complied']?>
                                                        </div>
                                                    </div>
                                                    <div class="col-auto">
                                                        <img src="images/tab/checking.png" alt="compliance" style='max-width:50px;'>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </a>
                                </div>
                                <div class="col-xl-4 col-md-6 ">
                                    <?php
$urles = "#";
    if ($pageRight != 0) {
        $page = $pageRight[0];
        $page_id = base64_encode(base64_encode($page['pk_usm_page_id']));
        $module_id = base64_encode(base64_encode($page['fk_usm_module_id']));
        $urles = "compliance_certificate_management/$page[page_actual]?pg=$page_id&md=$module_id&st=2";
    }
    ?>
                                    <a href="<?=$urles?>">
                                        <div class="card bg-warning shadow h-100 mb-1">
                                            <div class="card-body">
                                                <div class="row no-gutters align-items-center">
                                                    <div class="col mr-2">
                                                        <div class="text-xs font-weight-bold text-white text-uppercase mb-1">
                                                            Expiring Soon</div>
                                                        <div class="h5 mb-0 font-weight-bold text-white ">
                                                            <?=$_SESSION['expiring']?>
                                                        </div>
                                                    </div>
                                                    <div class="col-auto">
                                                        <img src="images/tab/expiring-soon.png" alt="compliance" style='max-width:50px;'>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </a>
                                </div>
                                <div class="col-xl-4 col-md-6 ">
                                    <?php
$urle = "#";
    if ($pageRight != 0) {
        $page = $pageRight[0];
        $page_id = base64_encode(base64_encode($page['pk_usm_page_id']));
        $module_id = base64_encode(base64_encode($page['fk_usm_module_id']));
        $urle = "compliance_certificate_management/$page[page_actual]?pg=$page_id&md=$module_id&st=3";
    }
    ?>
                                    <a href="<?=$urle?>">
                                        <div class="card bg-danger shadow h-100 mb-1">
                                            <div class="card-body">
                                                <div class="row no-gutters align-items-center">
                                                    <div class="col mr-2">
                                                        <div class="text-xs font-weight-bold text-white text-uppercase mb-1">
                                                            Total Expired</div>
                                                        <div class="h5 mb-0 font-weight-bold text-white ">
                                                            <?=$_SESSION['expired']?>
                                                        </div>
                                                    </div>
                                                    <div class="col-auto">
                                                        <img src="images/tab/expired.png" alt="compliance" style='max-width:50px;'>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </a>
                                </div>
                                <div class="col-xl-4 col-md-6 ">
                                    <?php
$urln = "#";
    if ($pageRight != 0) {
        $page = $pageRight[0];
        $page_id = base64_encode(base64_encode($page['pk_usm_page_id']));
        $module_id = base64_encode(base64_encode($page['fk_usm_module_id']));
        $urln = "compliance_certificate_management/$page[page_actual]?pg=$page_id&md=$module_id&st=1";
    }
    ?>
                                    <a href="<?=$urln?>">
                                        <div class="card bg-secondary shadow h-100 mb-1">
                                            <div class="card-body">
                                                <div class="row no-gutters align-items-center">
                                                    <div class="col mr-2">
                                                        <div class="text-xs font-weight-bold text-white text-uppercase mb-1">
                                                            Total Not Update</div>
                                                        <div class="h5 mb-0 font-weight-bold text-white ">
                                                            <?php echo $_SESSION['not_update'] ?>
                                                        </div>
                                                    </div>
                                                    <div class="col-auto">
                                                        <img src="images/tab/waiting.png" alt="waiting" style='max-width:50px;'>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </a>
                                </div>
                                <div class="col-xl-4 col-md-6 ">
                                    <?php
$urlr = "#";
    if ($pageRight != 0) {
        $page = $pageRight[0];
        $page_id = base64_encode(base64_encode($page['pk_usm_page_id']));
        $module_id = base64_encode(base64_encode($page['fk_usm_module_id']));
        $urlr = "compliance_certificate_management/$page[page_actual]?pg=$page_id&md=$module_id&st=4";
    }
    ?>
                                    <a href="<?=$urlr?>">
                                        <div class="card bg-dark shadow h-100 mb-1">
                                            <div class="card-body">
                                                <div class="row no-gutters align-items-center">
                                                    <div class="col mr-2">
                                                        <div class="text-xs font-weight-bold text-white text-uppercase mb-1">
                                                            Today's Renewal</div>
                                                        <div class="h5 mb-0 font-weight-bold text-white ">
                                                            <?php echo $_SESSION['todaysRenewal']; ?>
                                                        </div>
                                                    </div>
                                                    <div class="col-auto">
                                                        <img src="images/tab/renewal.png" alt="compliance" style='max-width:50px;'>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </a>
                                </div>

                                <div class="col-xl-12 col-md-12">
                                    <h5 class='title-heading'>Renewal Applied Status</h5>
                                </div>

                                <div class="col-xl-4 col-md-6 ">
                                    <div class="card bg-primary shadow h-100 mb-1">
                                        <div class="card-body">
                                            <div class="row no-gutters align-items-center">
                                                <div class="col mr-2">
                                                    <div class="text-xs font-weight-bold text-white text-uppercase mb-1">
                                                        Renewal Applied for expiry soon</div>
                                                    <div class="h5 mb-0 font-weight-bold text-white ">
                                                        <?php echo $_SESSION['renewalExpiring'] ?>
                                                    </div>
                                                </div>
                                                <div class="col-auto">
                                                    <img src="images/tab/expiring-soon.png" alt="compliance" style='max-width:50px;'>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-xl-4 col-md-6 ">
                                    <div class="card bg-success shadow h-100 mb-1">
                                        <div class="card-body">
                                            <div class="row no-gutters align-items-center">
                                                <div class="col mr-2">
                                                    <div class="text-xs font-weight-bold text-white text-uppercase mb-1">
                                                        Renewal Applied for expired</div>
                                                    <div class="h5 mb-0 font-weight-bold text-white ">
                                                        <?=$_SESSION['renewalExpired']?>
                                                    </div>
                                                </div>
                                                <div class="col-auto">
                                                    <img src="images/tab/expired.png" alt="compliance" style='max-width:50px;'>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>


                                <div class="col-xl-12 col-md-12">
                                    <h5 class='title-heading'>Verification Status</h5>
                                </div>

                                <div class="col-xl-4 col-md-6 ">
                                    <div class="card bg-success shadow h-100 mb-1">
                                        <div class="card-body">
                                            <div class="row no-gutters align-items-center">
                                                <div class="col mr-2">
                                                    <div class="text-xs font-weight-bold text-white text-uppercase mb-1">Verified Compliance</div>
                                                    <div class="h5 mb-0 font-weight-bold text-white ">
                                                        <?=$_SESSION['verified']?>
                                                    </div>
                                                </div>
                                                <div class="col-auto">
                                                    <img src="images/tab/checking.png" alt="compliance" style='max-width:50px;'>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-xl-4 col-md-6 ">
                                    <div class="card bg-warning shadow h-100 mb-1">
                                        <div class="card-body">
                                            <div class="row no-gutters align-items-center">
                                                <div class="col mr-2">
                                                    <div class="text-xs font-weight-bold text-white text-uppercase mb-1">Pending Verification</div>
                                                    <div class="h5 mb-0 font-weight-bold text-white ">
                                                        <?=$_SESSION['pendingVerificaton']?>
                                                    </div>
                                                </div>
                                                <div class="col-auto">
                                                    <img src="images/tab/expiring-soon.png" alt="compliance" style='max-width:50px;'>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <?php
$urlre = "#";
    if ($pageRight != 0) {
        $page = $pageRight[0];
        $page_id = base64_encode(base64_encode($page['pk_usm_page_id']));
        $module_id = base64_encode(base64_encode($page['fk_usm_module_id']));
        $urlre = "compliance_certificate_management/$page[page_actual]?pg=$page_id&md=$module_id&st=6";
    }
    ?>
                                <div class="col-xl-4 col-md-6 ">
                                    <a href="<?=$urlre?>">
                                        <div class="card bg-danger shadow h-100 mb-1">
                                            <div class="card-body">
                                                <div class="row no-gutters align-items-center">
                                                    <div class="col mr-2">
                                                        <div class="text-xs font-weight-bold text-white text-uppercase mb-1">Rejected</div>
                                                        <div class="h5 mb-0 font-weight-bold text-white ">
                                                            <?=$_SESSION['rejected']?>
                                                        </div>
                                                    </div>
                                                    <div class="col-auto">
                                                        <img src="images/tab/expired.png" alt="compliance" style='max-width:50px;'>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </a>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-xl-12 col-md-12 col-12">
                                    <div class="border-bottom" style="padding:15px"></div>
                                    <!-- <div id="pnlStyleContainer" style="width:100%;"></div> -->
                                </div>
                            </div>
                        </div>
                    <?php
}?>
                </div>
            </section>
            <!-- /.content -->
        </div>
        <!-- /.content-wrapper -->
        <?php include "footer.php";?>
        <div class="control-sidebar-bg"></div>
    </div>
    <!-- ./wrapper -->
    <?php include "all_js.php";?>
    <script src="datepicker/jquery.calendar.js"></script>
    <script>
        $(function() {
            $('#pnlStyleContainer').calendar({
                color: '#0f5577',
                months: ['Jan', 'Feb', 'Mar', 'Apr', 'May', 'Jun', 'Jul', 'Aug', 'Sep', 'Oct', 'Nov',
                    'Dec'
                ],
                days: ['Mon', 'Tue', 'Wed', 'Thu', 'Fri', 'Sat', 'Sun']
            });
        });

        function Refresh(user_id) {
            console.log($('#refreshBtn'));
            $('#refreshBtn').html(`<img src="images/loader.gif" alt="loading" style="width: 20px;">`);
            $.ajax({
                url: 'refresh.php',
                type: 'POST',
                data: {
                    'user_id': user_id
                },
                success: function(data) {
                    $('#refreshBtn').html(`<i class="fa fa-refresh" aria-hidden="true"></i>`);
                    location.reload();
                }
            });
        }
    </script>
</body>

</html>