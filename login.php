<?php
if (session_status() === PHP_SESSION_NONE) {
  session_start();
}
date_default_timezone_set('Asia/Calcutta');
//require_once "simple_php_captcha.php"; 
//$_SESSION['captcha'] = simple_php_captcha();
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

  <title>Rebel Foods - Log in</title>

  <!-- Bootstrap 4.0-->
  <link rel="stylesheet" href="assets/vendor_components/bootstrap/dist/css/bootstrap.min.css">

  <!-- Bootstrap 4.0-->
  <link rel="stylesheet" href="assets/vendor_components/bootstrap/dist/css/bootstrap-extend.css">

  <!-- Font Awesome -->
  <link rel="stylesheet" href="assets/vendor_components/font-awesome/css/font-awesome.min.css">

  <!-- Ionicons -->
  <link rel="stylesheet" href="assets/vendor_components/Ionicons/css/ionicons.min.css">

  <!-- toast CSS -->
  <link href="assets/vendor_components/jquery-toast-plugin-master/src/jquery.toast.css" rel="stylesheet">

  <!-- Theme style -->
  <link rel="stylesheet" href="css/master_style.css">

  <!-- apro_admin Skins. Choose a skin from the css/skins
     folder instead of downloading all of them to reduce the load. -->
  <link rel="stylesheet" href="css/skins/_all-skins.css">

  <!-- google font -->
  <link href='https://fonts.googleapis.com/css?family=Open+Sans' rel='stylesheet' type='text/css'>
  <script src="assets/vendor_components/jquery/dist/jquery.min.js"></script>
</head>

<body class="hold-transition login-page">
  <div class="wrapper">
    <?php $ins_date = date('d-m-Y');
    $ins_time = date('h:i:s A');
    include "classfile/initialize.php";
    include "classfile/login.php";
    if (isset($_POST["submit"])) {
      $username = $_POST["username"];
      $pass = $_POST["password"];
      $logintype = 'admin';
      if ($logintype == 'admin') {
        $count = $login_query->check_login_username_password($conn, $username, $pass);
        if ($count != 0) {
          $check = $login_query->get_login_data($conn, $username, $pass);
          $status = $check['transaction_status'];
          if ($status == 1) {
            $row_id = $check['id'];
            $pk_user_id = $check['pk_usm_user_id'];
            $username = $check['user_name'];
            $type = 'login';
            $_SESSION['user_id'] = $pk_user_id;
            $_SESSION['username'] = $username;

            $total = 0;
            $complied = 0;
            $expiring = 0;
            $expired = 0;
            $not_update = 0;
            $currentDate = date('d-m-Y');
            $todaysRenewal = 0;
            $verified = 0;
            $pendingVerificaton = 0;
            $rejected = 0;

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

            $notCondition = $condition . " AND a.`compliance_applicable`='Yes' AND NOT EXISTS (SELECT * FROM cpl_compliance_master as cm WHERE cm.fk_sfa_ent_entity_id = a.fk_sfa_ent_entity_id AND cm.fk_cpl_compliancetype_id = a.fk_cpl_compliancetype_id) AND transaction_status='1'";
            $notUP = $abc->get_row_count_of_table($conn, "cpl_establishment_compliance as a", " * ", $notCondition);
            $not_update = $notUP;

            $totalCondition = $condition . " AND a.compliance_applicable='Yes'";
            $total = $abc->get_row_count_of_table($conn, "cpl_establishment_compliance as a", "* ", $totalCondition);


            $pendingCondition = $condition . " AND a.verification_status='0' ";
            $pendingVerificaton = $abc->get_row_count_of_table($conn, "cpl_compliance_master as a", "*", $pendingCondition);

            $rejectedCondition = $condition . " AND a.verification_status='-1' AND str_to_date(a.ins_date_time,'%d-%m-%Y') >= str_to_date('03-05-2024','%d-%m-%Y')";
            $rejected = $abc->get_row_count_of_table($conn, "cpl_compliance_master_hst as a", "*", $rejectedCondition);

            $verificatioCondition = $condition . " AND a.verification_status='1'";
            $verified = $abc->get_row_count_of_table($conn, "cpl_compliance_master as a", "*", $verificatioCondition);

            $expiringSoonCondition = $verificatioCondition . " AND str_to_date(a.`expiry_date`,'%d-%m-%Y') >= str_to_date('$currentDate','%d-%m-%Y') AND str_to_date(a.`renew_due_date_l1`,'%d-%m-%Y') <= str_to_date('$currentDate','%d-%m-%Y')";
            $expiring = $abc->get_row_count_of_table($conn, "cpl_compliance_master as a", "*", $expiringSoonCondition);

            $compliedCondition = $verificatioCondition . " AND str_to_date(a.`expiry_date`,'%d-%m-%Y') > str_to_date('$currentDate','%d-%m-%Y')  AND str_to_date(a.`renew_due_date_l1`,'%d-%m-%Y') > str_to_date('$currentDate','%d-%m-%Y')";
            $complied = $abc->get_row_count_of_table($conn, "cpl_compliance_master as a", "*", $compliedCondition);

            $expiredCondition = $verificatioCondition . " AND str_to_date(a.`expiry_date`,'%d-%m-%Y') < str_to_date('$currentDate','%d-%m-%Y')";
            $expired = $abc->get_row_count_of_table($conn, "cpl_compliance_master as a", "*", $expiredCondition);

            $todaysRenewalCondition = $verificatioCondition . " AND a.renew_due_date_l1 = '$currentDate'";
            $todaysRenewal = $abc->get_row_count_of_table($conn, "cpl_compliance_master as a", "*", $todaysRenewalCondition);


            $renewalExpiredCondition = $condition . "AND str_to_date(a.`expiry_date`,'%d-%m-%Y') < str_to_date('$currentDate','%d-%m-%Y') AND a.`verification_status`='1'  AND b.`verification_status`='0' ";
            $renewalExpired = $abc->get_row_count_of_table($conn, "cpl_compliance_master as a Inner join cpl_compliance_renewal_step2 as b on a.pk_cpl_compliance_id=b.fk_cpl_compliance_id", "a.*", $renewalExpiredCondition);

            $renewalExpiringCondition = $condition . "AND str_to_date(a.`expiry_date`,'%d-%m-%Y') >= str_to_date('$currentDate','%d-%m-%Y') AND str_to_date(a.`renew_due_date_l1`,'%d-%m-%Y') < str_to_date('$currentDate','%d-%m-%Y') AND a.`verification_status`='1'  AND b.`verification_status`='0' ";
            $renewalExpiring = $abc->get_row_count_of_table($conn, "cpl_compliance_master as a Inner join cpl_compliance_renewal_step2 as b on a.pk_cpl_compliance_id=b.fk_cpl_compliance_id", "a.*", $renewalExpiringCondition);

            $_SESSION['total_compliance'] = $total;
            $_SESSION['complied'] = $complied;
            $_SESSION['expiring'] = $expiring;
            $_SESSION['expired'] = $expired;
            $_SESSION['not_update'] = $not_update;
            $_SESSION['todaysRenewal'] = $todaysRenewal;
            $_SESSION['verified'] = $verified;
            $_SESSION['pendingVerificaton'] = $pendingVerificaton;
            $_SESSION['rejected'] = $rejected;
            $_SESSION['renewalExpired'] = $renewalExpired;
            $_SESSION['renewalExpiring'] = $renewalExpiring;

            echo "<script>
              window.location = './'
            </script>";
          } else { ?>
            <script>
              $(document).ready(function() {
                $.toast({
                  heading: 'Error',
                  text: "Your Username Password Is Blocked..!",
                  position: 'top-right',
                  loaderBg: '#ff6849',
                  icon: 'error',
                  hideAfter: 3500
                });
              });
            </script>
          <?php }
        } else { ?>
          <script>
            $(document).ready(function() {
              $.toast({
                heading: 'Error',
                text: "Wrong Username or Password",
                position: 'top-right',
                loaderBg: '#ff6849',
                icon: 'error',
                hideAfter: 3500
              });
            });
          </script>
    <?php
        }
      }
    }
    ?>
    <style>
      @media only screen and (max-width: 600px) {
        .hdschoolname {
          padding: 0px 5px 0px 5px;
        }
      }
    </style>
    <section class="content" style="padding: 0px;">
      <div class="row">
        <div class="col-xl-12 col-md-12 col-12">
          <div class="loginheading">
            <div class="row">
              <div class="col-xl-12 col-md-12 col-12">
                <div class="logo" style='display:flex;justify-content:center;'>
                  <img src="images/rebelImage/rebel-logo-black.png" alt="" style="height: 100px;box-shadow: 1px 2px 18px #b5adad; ">
                </div>
                <!-- <h1 align="center" style="font-weight:600;color:#f68c48;font-size:36px;">RASPHIL <span style="color:#4d5497;">ACADEMY</span></h1>
        <div align="center"><span class="address text-center">We Shape the Future</span></div> -->
              </div>
              <!-- <div class="col-xl-7 col-md-7 col-12" style="padding-left: 0px; padding-right: 0px;">
                <h2 class="hdschoolname" style="color: #226205;">Rebel Compliance</h2>
              </div> -->
            </div>
          </div>
        </div>
        <div class="col-xl-8 col-md-8 col-12">
          <div style="margin: 20px;width: 100%;height: 435px; overflow: hidden;background:url('images/rebelImage/login-img.jpg'); background-size:cover; background-position: center; border-radius:15px;box-shadow:0px 0px 15px gray;">
            <!-- <img src="images/rebelImage/login-img.jpg" style="width: 100%; border-radius: 8px; box-shadow: 0px 0px 15px gray;"> -->
          </div>
        </div>
        <div class="col-xl-4 col-md-4 col-12">
          <div class="login-box">
            <div class="login-logo">
              <b>Login</b>
            </div>

            <!-- /.login-logo -->
            <div class="login-box-body">
              <p class="login-box-msg">Sign in to start your session</p>
              <form method="post" class="form-element" id="myporm">
                <!-- <div class="form-group has-feedback">
          <select class="form-control" id="type" name="type" style="padding: 5px;">
            <option value="">Select Login As</option>
            <option value="admin">Admin</option>
            <option value="teacher">Teacher</option>
            <option value="student">Student</option>
          </select>-->
                <!-- <span class="ion ion-person form-control-feedback"></span> -->
                <!-- </div> -->
                <div class="form-group has-feedback">
                  <input type="text" class="form-control" placeholder="Username" id="username" name="username" maxlength="50">
                  <span class="ion ion-person form-control-feedback"></span>
                </div>
                <div class="form-group has-feedback">
                  <input type="password" class="form-control" placeholder="Password" name="password" id="password">
                  <span class="ion ion-locked form-control-feedback"></span>
                </div>
                <!-- <div class="form-group has-feedback">
          <input type="password" class="form-control" placeholder="Enter Captcha Code" name="captcha" id="captcha">
          <span class="fa fa-shield form-control-feedback"></span>
          <p><img src="captcha.php?rand=<?php echo rand(); ?>" id='captcha_image'> <a href='javascript: refreshCaptcha();'>click here</a> to refresh</p>
        </div>       -->
                <div class="row">
                  <!-- /.col -->
                  <div class="col-12 text-center">
                    <button type="submit" class="btn btn-block btn-flat margin-top-10 btn-primary" name="submit" id="submit">LOGIN</button>
                  </div>
                  <!-- /.col -->
                </div>
              </form>

            </div>
            <!-- /.login-box-body -->
          </div>
          <!-- /.login-box -->
        </div>
      </div>
    </section>
    <!-- popper -->
  </div>
  <script src="assets/vendor_components/popper/dist/popper.min.js"></script>
  <!-- Bootstrap 4.0-->
  <script src="assets/vendor_components/bootstrap/dist/js/bootstrap.min.js"></script>
  <link rel="stylesheet" href="css/cmxform.css">
  <script src="js/dist/jquery.validate.js"></script>
  <script src="validation.js"></script>

  <script src="assets/vendor_components/jquery-toast-plugin-master/src/jquery.toast.js"></script>
  <script src="js/pages/toastr.js"></script>
  <script>
    //Refresh Captcha
    function refreshCaptcha() {
      var img = document.images['captcha_image'];
      img.src = img.src.substring(0, img.src.lastIndexOf("?")) + "?rand=" + Math.random() * 1000;
    }
    $(document).ready(function() {
      $('#submit').click(function() {
        var s1, s2, s3, s4;
        s1 = $('#username').val();
        s2 = $('#password').val();
        s3 = $('#type option:selected').val();
        s4 = $('#hcpt').val();
        if (s3 != '') {
          if (s1 != '') {
            if (s2 != '') {
              return true;
            } else {
              $.toast({
                heading: 'Error',
                text: "Password Required.!",
                position: 'top-right',
                loaderBg: '#ff6849',
                icon: 'error',
                hideAfter: 3500
              });
              $('#password').focus();
              return false;
            }
          } else {
            $.toast({
              heading: 'Error',
              text: "Username Required.!",
              position: 'top-right',
              loaderBg: '#ff6849',
              icon: 'error',
              hideAfter: 3500
            });
            $('#username').focus();
            return false;
          }
        } else {
          $.toast({
            heading: 'Error',
            text: "Login As Required.!",
            position: 'top-right',
            loaderBg: '#ff6849',
            icon: 'error',
            hideAfter: 3500
          });
          $('#type').focus();
          return false;
        }

        //return false;

      });
    });
  </script>
</body>

</html>