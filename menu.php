<script>
$(document).ready(function(){
getCurentFileName();
})
            function getCurentFileName() {
                var pagePathName = window.location.pathname;
                var page = (pagePathName.substring(pagePathName.lastIndexOf("/") + 1));
				
                $('.sidebar-menu>li').each(function () {
                    var url = $(this).find('a').attr('href');
					var str = $(this).find('i').attr('class');					
					url =(url.substring(url.lastIndexOf("/") + 1));
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
                        $(this).addClass("active");	$(this).parent().parent().addClass("active");												
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
          <a href="./">
            <i class="fa fa-dashboard"></i> <span>Dashboard</span>            
          </a>
        </li>
        <li> <a href="my_profile.php"><i class="fa fa-bars"></i> My Profile</a></li>
        <li><a href="update_profile.php"><i class="fa fa-bars"></i> Update Profile</a></li>
		<li><a href="billing_address.php"><i class="fa fa-bars"></i> Billing Address</a></li>
		<li> <a href="#"><i class="fa fa-bars"></i> Change Password</a></li>
        <li><a href="logout.php"><i class="fa fa-bars"></i> Logout</a></li>
        
      </ul>
    </section>
    <!-- /.sidebar -->
    <!--<div class="sidebar-footer">
		
		<a href="logout.php" class="link" data-toggle="tooltip" title="" data-original-title="Logout"><i class="fa fa-power-off"></i></a>
	</div> -->
  </aside>