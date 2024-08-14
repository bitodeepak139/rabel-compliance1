<?php
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}
if ($_SESSION['user_id'] == '')
	header('Location:../login.php');
date_default_timezone_set('Asia/Calcutta');
include "../check.php";
require_once "../classfile/initialize.php";
require_once "../classfile/configuration_management.php";
?>
<!DOCTYPE html>
<html lang="en">

<head>
	<meta charset="utf-8">
	<meta http-equiv="X-UA-Compatible" content="IE=edge">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<meta name="description" content="">
	<meta name="author" content="">
	<link rel="icon" href="../images/logo.jpg" sizes="32x32">
	<title>Admin Panel - Configuration Management - Add Company</title>
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

<body class="hold-transition skin-black sidebar-mini" onload="getdata()">
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
						<h3 class="box-title float-left"> Company Details</h3>

					</div>
					<!-- /.box-header -->
					<?php //require_once "submit_item.php"; ?>
					<!-- <div id="datadiv"></div> -->
					<div>
						<?php $fetch_data = $org_query->fetch_data($conn, "cnf_mst_company", "*", "id=1");
						$company_data = $fetch_data[0];

						?>
						<div class="modal-body">
							<div class="row">
								<div class="col-12">
									<form method="post" enctype="multipart/form-data" id="update_company"
										onsubmit="uploadData('update_company','isset_edit_company_details','btn_box','ajaxpage/org_edit_qy.php', event)">

										<!-- Hidden fields -->
										<input type="hidden" name="id" value='<?php echo $company_data['id'] ?>'>
										<input type="hidden" name="logo_old"
											value='<?php echo $company_data['company_logo'] ?>'>
										<!-- Hidden fields -->
										<div class="form-group row">
											<label for="example-text-input" class="col-sm-2 col-form-label">ENTER
												COMPANY NAME<span class="text-danger">*</span></label>
											<div class="col-sm-10">
												<input type="text" id="company_name" name='company_name'
													class="form-control"
													value="<?php echo $company_data['company_name'] ?>"
													autocomplete="off">
											</div>
										</div>
										<div class="form-group row">
											<label for="example-text-input" class="col-sm-2 col-form-label">ENTER CIN
												NO</label>
											<div class="col-sm-2">
												<input type="text" id="cin_no" name='cin_no' class="form-control"
													value="<?php echo $company_data['cin_no'] ?>" autocomplete="off">
											</div>
											<label for="example-text-input" class="col-sm-2 col-form-label">ENTER PAN
												NO</label>
											<div class="col-sm-2">
												<input type="text" id="pan_no" name='pan_no' class="form-control"
													value="<?php echo $company_data['pan_no'] ?>" autocomplete="off">
											</div>
											<label for="example-text-input" class="col-sm-2 col-form-label">ENTER GST
												NO</label>
											<div class="col-sm-2">
												<input type="text" id="gst_no" name='gst_no' class="form-control"
													value="<?php echo $company_data['gstn_no'] ?>" autocomplete="off">
											</div>
										</div>
										<div class="form-group row">
											<label for="example-text-input" class="col-sm-2 col-form-label">ENTER TAN
												NO</label>
											<div class="col-sm-2">
												<input type="text" id="tan_no" name="tan_no" class="form-control"
													value="<?php echo $company_data['tan_no'] ?>" autocomplete="off">
											</div>
											<label for="example-text-input" class="col-sm-2 col-form-label">ENTER FAX
												NO</label>
											<div class="col-sm-2">
												<input type="text" id="fax_no" name="fax_no" class="form-control"
													value="<?php echo $company_data['fax_no'] ?>" autocomplete="off">
											</div>
										</div>
										<div class="form-group row">
											<label for="example-text-input" class="col-sm-2 col-form-label">REGISTERED
												ADDRESS</label>
											<div class="col-sm-10">
												<textarea class="form-control" name="registered_address" id=""
													rows="3"><?php echo $company_data['registered_address'] ?></textarea>
											</div>
										</div>
										<div class="form-group row">
											<label for="example-text-input" class="col-sm-2 col-form-label">Select
												Country</label>
											<div class="col-sm-2">
												<select id="country" class="form-control"
													onchange="getstate(this.value)" name='country'>
													<option value="">Select Country</option>
													<?php $retval = $org_query->get_country_select($conn);
													foreach ($retval as $row) {
														$id = $row['pk_utm_country_id'];
														$country_name = $row['country_name'];
														?>
														<option value="<?php echo $id ?>">
															<?php echo $country_name ?>
														</option>
													<?php } ?>
												</select>
											</div>
											<label for="example-text-input" class="col-sm-2 col-form-label">Select
												State</label>
											<div class="col-sm-2">
												<div id="statediv">
													<select id="state" class="form-control" name='state'>
														<option value="">Select State</option>
													</select>
												</div>
											</div>

											<label for="example-text-input" class="col-sm-2 col-form-label">Select
												City</label>
											<div class="col-sm-2">
												<div id="citydiv">
													<select id="city" class="form-control" name='city'>
														<option value="">Select City</option>
													</select>
												</div>
											</div>
										</div>



										<div class="form-group row">
											<label for="example-text-input" class="col-sm-2 col-form-label">Contact
												No.<span class="text-danger">*</span></label>
											<div class="col-sm-4"><input type="text" id="phone" name="contact1"
													class="form-control"
													value="<?php echo $company_data['contact_no1'] ?>"
													autocomplete="off" maxlength="10">
											</div>
											<label for="example-text-input" class="col-sm-2 col-form-label">Alternate
												No.</label>
											<div class="col-sm-4"><input type="text" id="altno" name="contact2"
													class="form-control"
													value="<?php echo $company_data['contact_no2'] ?>"
													autocomplete="off" maxlength="12">
											</div>
										</div>
										<div class="form-group row">
											<label for="example-text-input"
												class="col-sm-2 col-form-label">Email</label>
											<div class="col-sm-4"><input type="text" id="email" name="email"
													class="form-control" value="<?php echo $company_data['email_id'] ?>"
													autocomplete="off">
											</div>
											<label for="example-text-input"
												class="col-sm-2 col-form-label">Website</label>
											<div class="col-sm-4"><input type="text" id="website" name="website"
													class="form-control"
													value="<?php echo $company_data['company_website'] ?>"
													autocomplete="off">
											</div>
										</div>
										<div class="form-group row">
											<label for="example-text-input" class="col-sm-2 col-form-label">Logo
												Preview</label>
											<div class="col-sm-4">
												<img src="../upload/logo/<?php echo $company_data['company_logo']; ?>"
													width="180" alt="company_logo" id='company_logo_preview'>
											</div>
										</div>
										<div class="form-group row">
											<label for="example-text-input" class="col-sm-2 col-form-label">Company
												Logo<span class="text-danger">*</span></label>
											<div class="col-sm-4">
												<input type="file" id="file" name='logo_image' class="form-control"
													onchange="ImagePreview('company_logo_preview' , event)">
											</div>
											<label for="example-text-input" class="col-sm-6 col-form-label">(Image Only,
												Max 100kb)</label>
										</div>
										<div class='d-flex justify-content-center align-items-center'>
											<button type="submit" class='btn btn-success' id='btn_box'>UPDATE</button>
										</div>
									</form>
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
	<script src="js/orgnization.js"></script>
	<div class="modal fade" id="mymodal">
		<div class="modal-dialog modal-lg" role="document">
			<div class="modal-content">
				<div class="modal-header">
					<h4 class="modal-title">Add New Organization Details</h4>
					<button type="button" class="close" data-dismiss="modal" aria-label="Close">
						<span aria-hidden="true">&times;</span></button>
				</div>
				<div id="adddiv"></div>
			</div>
			<!-- /.modal-content -->
		</div>
		<!-- /.modal-dialog -->
	</div>
	<!-- /.modal -->
	<div class="modal fade" id="mymodal1">
		<div class="modal-dialog modal-lg" role="document">
			<div class="modal-content">
				<div class="modal-header">
					<h4 class="modal-title">Edit Organization Details</h4>
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
	<div class="modal fade" id="mymodal2">
		<div class="modal-dialog modal-lg" role="document">
			<div class="modal-content">
				<div class="modal-header">
					<h4 class="modal-title">View Organization Details</h4>
					<button type="button" class="close" data-dismiss="modal" aria-label="Close">
						<span aria-hidden="true">&times;</span></button>
				</div>
				<div id="viewdiv"></div>
			</div>
			<!-- /.modal-content -->
		</div>
		<!-- /.modal-dialog -->
	</div>
	<!-- /.modal -->
</body>

</html>