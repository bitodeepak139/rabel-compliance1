<?php
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}
$key = $_REQUEST['md'];
$module_id = base64_decode(base64_decode($key));
$page_id = base64_decode(base64_decode($_GET['pg']));
if (($module_id == '' && $page_id == '') || $module_id == '' || $page_id == '') { //header('Location:login.php');} ?>
  <script>window.location = '../'</script>
<?php }
require_once '../classfile/initialize.php';
?>
<script src="../assets/vendor_components/jquery/dist/jquery.js"></script>
<script>
  $(document).ready(function () {
    getCurentFileName();
  })

  function getCurentFileName() {
    var pagePathName = window.location.pathname;
    var page = (pagePathName.substring(pagePathName.lastIndexOf("/") + 1));

    $('.sidebar-menu>li').each(function () {
      var url = $(this).find('a').attr('href');
      var str = $(this).find('i').attr('class');
      url = (url.substring(url.lastIndexOf("/") + 1));
      url = url.split('?')[0];
      if (url.toLowerCase() == page.toLowerCase()) {
        $(this).addClass("active");

      }
    });

    $('.sidebar-menu>li>ul>li').each(function () {
      var url = $(this).find('a').attr('href');
      var page1 = (url.substring(url.lastIndexOf("/") + 1));
      if (page1.toLowerCase() == page.toLowerCase()) {
        $(this).parent().parent().addClass("active");
        $(this).parent().css("display", "block");
        $(this).addClass("active");
        $(this).parent().parent().addClass("active");
        //$(this).parent().parent().find('i').addClass("menu-icon fa  fa-minus-circle");
      }
    });
  }
</script>
<aside class="main-sidebar">
  <!-- sidebar: style can be found in sidebar.less -->
  <section class="sidebar">
    <!-- Sidebar user panel -->
    <!-- sidebar menu: : style can be found in sidebar.less -->
    <ul class="sidebar-menu" data-widget="tree">

      <li>
        <?php $result = $abc->fetch_data($conn, "usm_add_modules", "*", "pk_usm_module_id='$module_id'");
        // $abc->debug($result);
        $module_url = $result[0]['module_url'];
        $backURL = "../" . $module_url . "?md=" . base64_encode(base64_encode($module_id));

        ?>
        <a href="<?php echo $backURL; ?>">
          <i class="fa fa-dashboard"></i> <span>Back</span>
          <span class="pull-right-container">
            <i class="fa fa-backward pull-right"></i>
          </span>
        </a>
      </li>
      <?php
      $subModuleData = $abc->fetch_data($conn, "usm_add_pages", "fk_usm_sub_module_id","pk_usm_page_id='$page_id'");
      $subModuleID = $subModuleData[0]["fk_usm_sub_module_id"];
      $all_page_row_module = $abc->fetch_data($conn, "usm_add_pages as a INNER JOIN usm_page_rights as b ON a.pk_usm_page_id = b.fk_usm_page_id", "a.*,b.transaction_status", "b.fk_usm_user_id='$_SESSION[user_id]' AND a.transaction_status='1' AND b.transaction_status='1' AND b.fk_usm_module_id='$module_id' AND b.fk_usm_sub_module_id='$subModuleID'  ORDER by a.page_sequence asc");
      if ($all_page_row_module != 0) {
        foreach ($all_page_row_module as $page) {
          $page_id = base64_encode(base64_encode($page['pk_usm_page_id']));
          $module_id = base64_encode(base64_encode($page['fk_usm_module_id']));
          echo "<li><a href='$page[page_actual]?pg=$page_id&md=$module_id'><i class='fa fa-bars'></i>$page[page_name]</a></li>";
        }
      }
      ?>



      <!-- <li> <a href="add_country.php"><i class="fa fa-bars"></i> Add Country</a></li>
      <li> <a href="add_state.php"><i class="fa fa-bars"></i> Add State</a></li>
      <li><a href="add_city.php"><i class="fa fa-bars"></i> Add City</a></li> -->

    </ul>
  </section>
  <!-- /.sidebar -->
  <!--<div class="sidebar-footer">
    
    <a href="logout.php" class="link" data-toggle="tooltip" title="" data-original-title="Logout"><i class="fa fa-power-off"></i></a>
  </div> -->
</aside>