<?php
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}
?>
<!-- jQuery 3 -->
<style> .hddrpdwn{ padding: 0px 15px; vertical-align: middle; line-height: 50px; display: block; margin-top:12px;}
@media only screen and (max-width: 600px) {
  #hdname {
    display: none;
  }
}
</style>
<?php require 'url.php'; ?>
<header class="main-header">
  <!-- Logo -->  
  <a href="<?php echo $url ?>" class="logo">
  <!-- mini logo for sidebar mini 50x50 pixels -->
  <span class="logo-mini"><!--<img src="<?php echo $url ?>images/logo.png" alt=""> --></span>
  <!-- logo for regular state and mobile devices -->
  <span class="logo-lg"><b>Admin</b> Portal</span> </a>
  <!-- Header Navbar: style can be found in header.less -->
  <nav class="navbar navbar-static-top">
    <!-- Sidebar toggle button-->
    <a href="#" class="sidebar-toggle" data-toggle="push-menu" role="button"> <span class="sr-only">Toggle navigation</span> </a>
    <h3 style="margin-top:10px" id="hdname">Welcome to Rebel Compliance Admin Portal</h3>
    <div class="navbar-custom-menu">
      <ul class="nav navbar-nav">
        <!-- User Account: style can be found in dropdown.less -->
              
        <li class="dropdown user user-menu"> <a href="#" class="dropdown-toggle" data-toggle="dropdown"> <?php echo $_SESSION['username']; ?><i class="fa fa fa-angle-down"></i> </a>
          <ul class="dropdown-menu scale-up">
            <!-- Menu Body -->
            <!-- <li class="user-body">
              <div class="row no-gutters">
                <div class="col-12 text-left"> <a href="<?php echo $url ?>my_profile.php"><i class="ion ion-person"></i> My Profile</a> </div>
              </div>
            </li> -->
            <!-- Menu Footer-->
            <li class="user-footer">
              <div class="pull-right"> <a href="<?php echo $url ?>logout.php" class="btn btn-block btn-danger"><i class="ion ion-power"></i> Log Out</a> </div>
            </li>
          </ul>
        </li>
        <!-- Messages: style can be found in dropdown.less-->
        <li><a href="<?php echo $url ?>logout.php" class="link" data-toggle="tooltip" title="" data-original-title="Logout"><i class="fa fa-power-off"></i></a></li>
      </ul>
    </div>
  </nav>
</header>
<div id="loading" style="display:none" class="background">
  <div style="position: fixed; left: 50%; top: 30%; text-align: center;"> <img src="<?php echo $url ?>loading.gif" style="height:120px;"> </div>
</div>
<script>
  function setsession(id){    
    $.ajax({
		type: 'POST',
		url: '<?php echo $url ?>'+'set_session.php',
		data: {id:id},
		cache: false,
		success: function (data) {
          //alert(data);	
		}
	});
  }
</script>