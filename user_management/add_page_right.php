<?php
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}
if ($_SESSION['user_id'] == '')
  header('Location:../login.php');
date_default_timezone_set('Asia/Calcutta');
include "../check.php";
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
  <title>Admin Panel - User Management - Assign Module Rights</title>
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
        <?php
        require_once "../classfile/initialize.php";
        require_once "../classfile/user.php";
        ?>
        <!-- Basic Forms -->
        <div class="box box-default">
          <div class="box-header with-border">
            <h3 class="box-title float-left"> Assign Page Rights </a></h3>

          </div>
          <!-- /.box-header -->
          <?php //require_once "submit_module_right.php"; 
          ?>
          <div class="box">
            <!-- /.box-header -->
            <div class="box-body">
              <form method="post" enctype="multipart/form-data" id="myform">
                <div class="row">
                  <div class="col-12">

                    <div class="form-group row">
                      <label for="example-text-input" class="col-sm-2 col-form-label">Select User<span class="text-danger">*</span></label>
                      <div class="col-sm-4">
                        <select name="user" id="user" class="form-control" onchange="getmudule(this.value)">
                          <option value="">Select User</option>
                          <?php $retval = $user_query->get_user($conn);
                          foreach ($retval as $row) {
                            $userid = $row['pk_usm_user_id'];
                            $user_name = $row['user_name'];
                          ?>
                            <option value="<?php echo $userid ?>" <?php if (isset($_POST['user']) && $_POST['user'] == $userid) echo "selected='selected'" ?>><?php echo $user_name ?></option>
                          <?php } ?>
                        </select>
                      </div>
                    </div>
                    
                  </div><!-- /.col -->
                </div><!-- /.row -->
                  <div id="datadiv"></div>
              </form>

            </div> <!-- /.box-body -->
          </div><!-- /.box -->
        </div>

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
  <script src="js/module_right.js"></script>

</body>

</html>