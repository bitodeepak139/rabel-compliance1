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

<body class="hold-transition skin-black sidebar-mini"
	onload="getDataForm('ajaxpage/get_data_ajax.php','isset_bank_details_update','<?php echo $_GET['ent_id'] ?>','#datadiv'),getDataForm('ajaxpage/get_data_ajax.php','isset_contact_details_update','<?php echo $_GET['ent_id'] ?>','#resultData')">
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
						$entityData = $sfa_ent->fetch_data($conn, "sfa_ent_mst_entity as a LEFT JOIN  sfa_ent_tns_entity_documents as b ON b.fk_sfa_ent_entity_id=a.pk_sfa_ent_entity_id", "b.*,a.*", $condition);
						if (count($entityData) == 0) {
							echo "<script>window.history.back()</script>";
						} else {
							$v = $entityData[0];
						}

						?>
						<h3 class="box-title float-left">Update Entity</h3>
					</div>
					<!-- /.box-header -->
					<div>
						<div class="modal-body">
							<div class="row">
								<div class="col-12">
									<form method="post" action='text.php' enctype="multipart/form-data"
										id="sfa_ent_update_entity"
										onsubmit="uploadData('sfa_ent_update_entity','isset_sfa_ent_update_entity','btn_box','ajaxpage/updateajax.php', event)">
										<input type="hidden" name="id" value="<?php echo $v['id']; ?>">
										<div class="form-group row">
											<label for="example-text-input" class="col-xl-3 col-form-label">SELECT
												ENTITY TYPE<span class='text-danger'>*</span></label>
											<div class="col-xl-3">
												<select id="entity_id" class="form-control" name='entity_id' required>

													<?php
													$entity_type = $sfa_ent->fetch_data($conn, "sfa_cnf_mst_entity_type", "*", "transaction_status='1'");
													if ($entity_type != 0) {
														foreach ($entity_type as $row) {
															?>
															<option value='<?php echo $row['pk_sfa_cnf_entitytype_id'] ?>' <?php echo ($v['fk_sfa_cnf_entitytype_id'] == $row['pk_sfa_cnf_entitytype_id']) ? "selected" : ""; ?>>
																<?php echo $row['type_name'] ?>
															</option>
															<?php
														}
													}
													?>
												</select>
											</div>

											<label for="example-text-input" class="col-xl-3 col-form-label">SELECT
												ORGANIZATION TYPE <span class='text-danger'>*</span></label>
											<div class="col-xl-3">
												<div id="statediv">
													<select id="organization_id" class="form-control"
														name='organization_id' required>
														<?php
														$org_details = $sfa_ent->fetch_data($conn, "sfa_cnf_mst_organization_type a", "a.*,a.type_name as org_name", "transaction_status='1'");
														if ($org_details != 0) {
															foreach ($org_details as $data) {
																?>
																<option value='<?php echo $data['pk_sfa_cnf_custype_id'] ?>'
																	<?php echo ($data['pk_sfa_cnf_custype_id'] == $v['fk_sfa_cnf_orgtype_id']) ? 'selected' : ""; ?>>
																	<?php echo $data['org_name'] ?>
																</option>
																<?php
															}
														}
														?>
													</select>
												</div>
											</div>

										</div>
										<div class="form-group row">
											<label for="example-text-input" class="col-xl-3 col-form-label">SELECT
												CATEGORY <span class='text-danger'>*</span></label>
											<div class="col-xl-3">
												<select id="category" class="form-control"
													onchange="DependantDropDown('category', 'sub_category','ajaxpage/get_data_ajax.php', 'isset_dependent_category')"
													name='category' required>
													<?php
													$result = $sfa_ent->fetch_data($conn, "sfa_cnf_mst_entity_category a LEFT JOIN sfa_cnf_mst_entity_type as b ON a.fk_sfa_cnf_entitytype_id = b.pk_sfa_cnf_entitytype_id", "a.*,b.type_name", "a.transaction_status='1'");
													if ($result != 0) {
														foreach ($result as $row) {
															?>
															<option value='<?php echo $row['pk_sfa_cnf_entcategory_id'] ?>'
																<?php echo ($row['pk_sfa_cnf_entcategory_id'] == $v['fk_sfa_cnf_entcategory_id']) ? "selected" : ""; ?>>
																<?php echo $row['category_name'] ?>
															</option>
															<?php
														}
													}
													?>
												</select>
											</div>
											<label for="example-text-input" class="col-xl-3 col-form-label">SELECT SUB
												CATEGORY <span class='text-danger'>*</span></label>
											<div class="col-xl-3">
												<div id="statediv">
													<select id="sub_category" class="form-control" name='sub_category'
														required>
														<?php

														$sub_category = $sfa_query->fetch_data($conn, "sfa_cnf_mst_entity_subcategory a LEFT JOIN sfa_cnf_mst_entity_type as b ON a.fk_sfa_cnf_entitytype_id = b.pk_sfa_cnf_entitytype_id LEFT JOIN sfa_cnf_mst_entity_category as c ON a.fk_sfa_cnf_entcategory_id = c.pk_sfa_cnf_entcategory_id", "a.*,b.type_name,c.category_name", "a.transaction_status='1' AND a.fk_sfa_cnf_entcategory_id='$v[fk_sfa_cnf_entcategory_id]'");
														if ($sub_category != 0) {
															foreach ($sub_category as $row) {
																?>
																<option
																	value='<?php echo $row['pk_sfa_cnf_entsubcategory_id'] ?>'
																	<?php echo ($row['pk_sfa_cnf_entsubcategory_id'] == $v['fk_sfa_cnf_entsubcategory_id']) ? "" : ""; ?>>
																	<?php echo $row['subcategory_name'] ?>
																</option>
																<?php
															}
														}
														?>
													</select>
												</div>
											</div>

										</div>
										<div class="form-group row">
											<label for="example-text-input" class="col-xl-3 col-form-label">SELECT
												ZONE <span class='text-danger'>*</span></label>
											<div class="col-xl-3">
												<select id="zone" class="form-control"
													onchange="DependantDropDown('zone', 'region','ajaxpage/get_data_ajax.php', 'isset_dependent_zone')"
													name='zone' required>
													<?php
													$retval = $sfa_ent->fetch_data($conn, "cnf_mst_zone ", "*", "transaction_status='1'");
													if ($retval != 0) {
														foreach ($retval as $row) {
															?>
															<option value='<?php echo $row['pk_cnf_zone_id'] ?>' <?php echo ($row['pk_cnf_zone_id'] == $v['zone_id']) ? "selected" : ""; ?>>
																<?php echo $row['zone_name'] ?>
															</option>
															<?php
														}
													}
													?>
												</select>
											</div>
											<label for="example-text-input" class="col-xl-3 col-form-label">SELECT
												REGION <span class='text-danger'>*</span></label>
											<div class="col-xl-3">
												<div id="statediv">
													<select id="region" class="form-control" name='region' required>
														<?php
														$zonesData = $sfa_ent->fetch_data($conn, "cnf_mst_region", "*", "transaction_status='1' AND fk_cnf_zone_id='$v[zone_id]'");
														if ($zonesData != 0) {
															foreach ($zonesData as $row) {
																?>
																<option value='<?php echo $row['pk_cnf_region_id'] ?>' <?php echo ($row['pk_cnf_region_id'] == $v['region_id']) ? "selected" : ""; ?>>
																	<?php echo $row['region_name'] ?>
																</option>
																<?php
															}
														}
														?>
													</select>
												</div>
											</div>

										</div>
										<div class="form-group row">
											<label for="example-text-input" class="col-xl-3 col-form-label">ENTER ENTITY
												CODE <span class='text-danger'>*</span></label>
											<div class="col-xl-3">
												<input type="text" id="entity_code" name="entity_code"
													class="form-control" autocomplete="off" required
													value='<?php echo $v["pk_sfa_ent_entity_id"]; ?>' readonly>
											</div>
											<label for="example-text-input" class="col-xl-3 col-form-label">ENTER ENTITY
												NAME <span class='text-danger'>*</span></label>
											<div class="col-xl-3">
												<input type="text" id="entity_name" name="entity_name"
													class="form-control" autocomplete="off" required
													value='<?php echo $v["entity_name"] ?>'>
											</div>
										</div>
										<div class="form-group row">
											<label for="example-text-input" class="col-xl-3 col-form-label">ENTER
												ADDRESS</label>
											<div class="col-xl-9">
												<textarea class="form-control" name="address" id=""
													rows="3"><?php echo $v['entity_address']; ?></textarea>
											</div>
										</div>
										<div class="form-group row">
											<label for="example-text-input" class="col-xl-3 col-form-label">SELECT
												COUNTRY </label>
											<div class="col-xl-3">
												<select id="country" class="form-control"
													onchange="DependantDropDown('country', 'state','ajaxpage/get_data_ajax.php', 'isset_dependent_country')"
													name='country'>
													<option value="">Select Country</option>
													<?php
													$country = $sfa_ent->fetch_data($conn, "utm_add_country", "*", "transaction_status='1'");
													if ($country != 0) {
														foreach ($country as $row) {
															?>
															<option value='<?php echo $row['pk_utm_country_id'] ?>' <?php echo ($row['pk_utm_country_id'] == $v['country_id']) ? "selected" : ""; ?>>
																<?php echo $row['country_name'] ?>
															</option>
															<?php
														}
													}
													?>
												</select>
											</div>
											<label for="example-text-input" class="col-xl-3 col-form-label">SELECT
												STATE </label>
											<div class="col-xl-3">
												<div id="statediv">
													<select id="state" class="form-control" name="state"
														onchange="DependantDropDown('state', 'district','ajaxpage/get_data_ajax.php', 'isset_dependent_state_for_district')">
														<option value=''>-select State</option>
														<?php

														$stateData = $sfa_ent->fetch_data($conn, "utm_add_state", "*", "fk_utm_country_id='$v[country_id]' AND transaction_status='1'");
														if ($stateData != 0) {
															foreach ($stateData as $row) {
																if ($row['pk_utm_state_id'] == $v['state_id']) {
																	echo "<option value='$row[pk_utm_state_id]' selected>$row[state_name]</option>";
																} else {

																	echo "<option value='$row[pk_utm_state_id]'>$row[state_name]</option>";
																}
															}
														}

														?>
													</select>
												</div>
											</div>

										</div>
										<div class="form-group row">
											<label for="example-text-input" class="col-xl-3 col-form-label">SELECT
												DISTRICT </label>
											<div class="col-xl-3">
												<select id="district" class="form-control" name='district'>
													<?php
													$districtData = $sfa_ent->fetch_data($conn, "utm_add_city", "*", "fk_utm_state_id='$v[state_id]' AND transaction_status='1'");
													echo "<option value=''>Select District</option>";
													if ($districtData != 0) {
														foreach ($districtData as $row) {
															if ($row['pk_utm_city_id'] == $v['city_id']) {

																echo "<option value='$row[pk_utm_city_id]' selected >$row[city_name]</option>";
															} else {

																echo "<option value='$row[pk_utm_city_id]'>$row[city_name]</option>";
															}
														}
													}
													?>
												</select>
											</div>
											<label for="example-text-input" class="col-xl-3 col-form-label">ENTER
												PINCODE</label>
											<div class="col-xl-3">
												<input type="text" name="pincode" class="form-control" id="pincode"
													maxlength="8" onkeyup="inputWithNumber('pincode')"
													value="<?php echo $v['add_pincode']; ?>">
											</div>
										</div>
										<div class="form-group row">
											<label for="example-text-input" class="col-xl-3 col-form-label">ENTER LAND
												MARK</label>
											<div class="col-xl-9">
												<textarea class="form-control" name="land_mark" id=""
													rows="3"><?php echo $v['add_landmark'] ?></textarea>
											</div>
										</div>
										<div class="form-group row">
											<label for="example-text-input" class="col-xl-3 col-form-label">ENTER
												PRIMARY MOBILE NO</label>
											<div class="col-xl-3"><input type="text" id="phone" name="contact1"
													class="form-control" autocomplete="off" maxlength="10"
													minlength="10" onkeyup="inputWithNumber('phone')"
													value='<?php echo $v['contact_no1']; ?>'>
											</div>
											<label for="example-text-input" class="col-xl-3 col-form-label">ENTER
												ALTERNATE NO</label>
											<div class="col-xl-3">
												<input type="text" id="altno" name="contact2" class="form-control"
													autocomplete="off" maxlength="10" minlength="10"
													onkeyup="inputWithNumber('altno')"
													value='<?php echo $v['contact_no1'] ?>'>
											</div>
										</div>
										<div class="form-group row">
											<label for="example-text-input" class="col-xl-3 col-form-label">ENTER
												WEBSITE</label>
											<div class="col-xl-3"><input type="text" id="website" class="form-control"
													name='website' autocomplete="off"
													value="<?php echo $v['website_url'] ?>">
											</div>
											<label for="example-text-input" class="col-xl-3 col-form-label">ENTER
												EMAIL</label>
											<div class="col-xl-3"><input type="email" id="email" name="email"
													class="form-control" autocomplete="off"
													value='<?php echo $v['ent_email'] ?>'>
											</div>
										</div>
										<div class="form-group row">
											<label for="example-text-input" class="col-xl-3 col-form-label">ENTER PAN
												NO</label>
											<div class="col-xl-3">
												<input type="text" id="pan_no" name="pan_no" class="form-control"
													autocomplete="off" value="<?php echo $v['pan_no'] ?>">
											</div>
											<label for="example-text-input" class="col-xl-3 col-form-label">ENTER GST
												NO</label>
											<div class="col-xl-3">
												<input type="text" id="gst_no" name="gst_no" class="form-control"
													autocomplete="off" value="<?php echo $v['gstn_no'] ?>">
											</div>
										</div>
										<div class="form-group row">
											<label for="example-text-input" class="col-xl-3 col-form-label">ENTER TAN
												NO</label>
											<div class="col-xl-3">
												<input type="text" id="tan_no" name="tan_no" class="form-control"
													autocomplete="off" value="<?php echo $v['tan_no'] ?>">
											</div>
											<label for="example-text-input" class="col-xl-3 col-form-label">UPLOAD
												LOGO</label>
											<div class="col-xl-3">
												<input type="file" id="logo" name="logo" class="form-control"
													autocomplete="off">
												<?php if ($v['entity_logo']) { ?>
													<a href="../upload/documents/<?php echo $v['pk_sfa_ent_entity_id']; ?>/<?php echo $v['entity_logo'] ?>"
														target="_blank" class="text-danger text-right d-block">see
														previously uploaded</a>
												<?php } ?>
											</div>
										</div>
										<div class="form-group row">
											<label for="example-text-input" class="col-xl-3 col-form-label">UPLOAD
												PAN</label>
											<div class="col-xl-3">
												<input type="file" id="doc_pan" name="doc_pan" class="form-control"
													autocomplete="off">
												<?php
												for ($i = 0; $i < count($entityData); $i++) {
													if ($entityData[$i]['document_type'] == 'PAN') { ?>
														<a href="../upload/documents/<?php echo $v['pk_sfa_ent_entity_id']; ?>/<?php echo $entityData[$i]['document_file'] ?>"
															target="_blank" class="text-danger text-right d-block">see
															previously uploaded</a>
													<?php }
												} ?>
											</div>
											<label for="example-text-input" class="col-xl-3 col-form-label">UPLOAD TAN
												REGISTRATION</label>
											<div class="col-xl-3">
												<input type="file" id="doc_tan" name="doc_tan" class="form-control"
													autocomplete="off">
												<?php
												for ($i = 0; $i < count($entityData); $i++) {
													if ($entityData[$i]['document_type'] == 'TAN') { ?>
														<a href="../upload/documents/<?php echo $v['pk_sfa_ent_entity_id']; ?>/<?php echo $entityData[$i]['document_file'] ?>"
															target="_blank" class="text-danger text-right d-block">see
															previously uploaded</a>
													<?php }
												} ?>
											</div>
										</div>
										<div class="form-group row">
											<label for="example-text-input" class="col-xl-3 col-form-label">UPLOAD
												GSTN</label>
											<div class="col-xl-3">
												<input type="file" id="doc_gst" name="doc_gst" class="form-control"
													autocomplete="off">
												<?php
												for ($i = 0; $i < count($entityData); $i++) {
													if ($entityData[$i]['document_type'] == 'GST') { ?>
														<a href="../upload/documents/<?php echo $v['pk_sfa_ent_entity_id']; ?>/<?php echo $entityData[$i]['document_file'] ?>"
															target="_blank" class="text-danger text-right d-block">see
															previously uploaded</a>
													<?php }
												} ?>
											</div>
											<label for="example-text-input" class="col-xl-3 col-form-label">REGISTRATION
												DOCUMENT</label>
											<div class="col-xl-3">
												<input type="file" id="doc_registration" name="doc_registration"
													class="form-control" autocomplete="off">
												<?php
												for ($i = 0; $i < count($entityData); $i++) {
													if ($entityData[$i]['document_type'] == 'Registration') { ?>
														<a href="../upload/documents/<?php echo $v['pk_sfa_ent_entity_id']; ?>/<?php echo $entityData[$i]['document_file'] ?>"
															target="_blank" class="text-danger text-right d-block">see
															previously uploaded</a>
													<?php }
												} ?>
											</div>
										</div>
										<div class="form-group row">
											<label for="example-text-input" class="col-xl-3 col-form-label">OTHER
												DOCUMET 1</label>
											<div class="col-xl-3">
												<input type="text" id="other_docu1" name="other_docu1"
													class="form-control" autocomplete="off" <?php
													for ($i = 0; $i < count($entityData); $i++) {
														if ($entityData[$i]['document_type'] == 'Other Document1') {
															$doc_name = $entityData[$i]['document_name'];
															echo "value='$doc_name'";
														}
													} ?>>
											</div>
											<label for="example-text-input" class="col-xl-3 col-form-label">UPLOAD
												DOCUMENT</label>
											<div class="col-xl-3">
												<input type="file" id="doc_other_docu1" name="doc_other_docu1"
													class="form-control" autocomplete="off">
												<?php
												for ($i = 0; $i < count($entityData); $i++) {
													if ($entityData[$i]['document_type'] == 'Other Document1') { ?>
														<a href="../upload/documents/<?php echo $v['pk_sfa_ent_entity_id']; ?>/<?php echo $entityData[$i]['document_file'] ?>"
															target="_blank" class="text-danger text-right d-block">see
															previously uploaded</a>
													<?php }
												} ?>
											</div>
										</div>
										<div class="form-group row">
											<label for="example-text-input" class="col-xl-3 col-form-label">OTHER
												DOCUMET 2</label>
											<div class="col-xl-3">
												<input type="text" id="other_doc2" name="other_doc2"
													class="form-control" autocomplete="off" <?php
													for ($i = 0; $i < count($entityData); $i++) {
														if ($entityData[$i]['document_type'] == 'Other Document 2') {
															$doc_name = $entityData[$i]['document_name'];
															echo "value='$doc_name'";
														}
													}
													?>>
											</div>
											<label for="example-text-input" class="col-xl-3 col-form-label">UPLOAD
												DOCUMENT</label>
											<div class="col-xl-3">
												<input type="file" id="doc_other_doc2" name="other_doc2"
													class="form-control" autocomplete="off">
												<?php
												for ($i = 0; $i < count($entityData); $i++) {
													if ($entityData[$i]['document_type'] == 'Other Document 2') { ?>
														<a href="../upload/documents/<?php echo $v['pk_sfa_ent_entity_id']; ?>/<?php echo $entityData[$i]['document_file'] ?>"
															target="_blank" class="text-danger text-right d-block">see
															previously uploaded</a>
													<?php }
												} ?>
											</div>
										</div>

										<div class="form-group row">
											<div class="col-sm-12" style='margin-top:16px;'>
												<div class="table-responsive">
													<table id="example1"
														class="table table-bordered table-striped table-hover display table_design">
														<thead>
															<tr>
																<th colspan='8'>Add Bank Details</th>
															</tr>
															<tr class="info">
																<th style='min-width:189px;'>Account Holder Name<span
																		style="color:#FF0000">*</span></th>
																<th>Account<i class='invisible'>_</i>No<span
																		style="color:#FF0000">*</span></th>
																<th>Account<i class='invisible'>_</i>Type<span
																		style="color:#FF0000">*</span></th>
																<th>Bank<i class='invisible'>_</i>Name<span
																		style="color:#FF0000">*</span></th>
																<th>Branch<i class='invisible'>_</i>Name<span
																		style="color:#FF0000">*</span></th>
																<th>IFSC<i class='invisible'>_</i>Code<span
																		style="color:#FF0000">*</span></th>
																<th style='min-width: 100px;'>Swift</th>
																<th width="8%">Action</th>
															</tr>
														</thead>
														<tbody>

															<tr>
																<td>
																	<input type="text" class="form-control "
																		name="account_holder_name"
																		id="account_holder_name">
																</td>
																<td>
																	<input type="text" class="form-control "
																		name="account_no" id="account_no">
																</td>
																<td>
																	<select
																		class="form-select form-select-lg form-control"
																		name="" id="account_type">
																		<option value=''>--Select--</option>
																		<option value='saving'>Saving</option>
																		<option value='current'>Current</option>
																	</select>
																</td>
																<td>
																	<input type="text" class="form-control "
																		id="bank_name">
																</td>
																<td>
																	<input type="text" class="form-control "
																		id="branch_name">
																</td>
																<td>
																	<input type="text" class="form-control "
																		id="ifsc_code">
																</td>
																<td>
																	<input type="text" class="form-control " id="swift">
																</td>

																<td width="8%">
																	<a href='javascript:void(0)'
																		onClick="addBankDetailsInUpdate('<?php echo $_GET['ent_id'] ?>')"
																		class="btn btn-info btn-sm"
																		title="Add Stock">Add</a>
																</td>
															</tr>
														</tbody>
													</table>
												</div>
											</div>

											<div class="col-sm-12" style='margin-top:6px;' id='datadiv'></div>
										</div>



										<div class="form-group row">
											<div class="col-sm-12" style='margin-top:16px;'>
												<div class="table-responsive">
													<table id="example1"
														class="table table-bordered table-striped table-hover display table_design">
														<thead>
															<tr>
																<th colspan="8">Add Contact Details</th>
															</tr>
															<tr class="info">
																<th>Person<i class='invisible'>_</i>Name<span
																		style="color:#FF0000">*</span></th>
																<th>Designation</th>
																<th>Contact<i class='invisible'>_</i>No1<span
																		class='text-danger'>*</span></th>
																<th>Contact<i class='invisible'>_</i>No2</th>
																<th>Landline</th>
																<th>Email ID<span class='text-danger'>*</span></th>
																<th>Remark</th>
																<th width="8%">Action</th>
															</tr>
														</thead>
														<tbody>

															<tr>
																<td>
																	<input type="text" class="form-control"
																		id="person_name">
																</td>
																<td>
																	<input type="text" class="form-control "
																		id="designation">
																</td>
																<td>
																	<input type="text" class="form-control "
																		id="contact_no"
																		onkeyup="inputWithNumber('contact_no')"
																		minlength='10' maxlength='10'>
																</td>
																<td>
																	<input type="text" class="form-control "
																		id="contact_no2"
																		onkeyup="inputWithNumber('contact_no2')"
																		minlength='10' maxlength='10'>
																</td>
																<td>
																	<input type="text" class="form-control "
																		id="landline"
																		onkeyup="inputWithNumber('landline')"
																		minlength='12' maxlength='12'>
																</td>
																<td>
																	<input type="email" class="form-control"
																		id="email_id">
																</td>
																<td>
																	<input type="text" class="form-control "
																		id="remark">
																</td>

																<td width="8%">
																	<a href='javascript:void(0)'
																		onClick="addContactDetailsUpdate('<?php echo $_GET['ent_id']; ?>')"
																		class="btn btn-info btn-sm"
																		title="Add Stock">Add</a>
																</td>
															</tr>
														</tbody>
													</table>
												</div>
											</div>
											<div class="col-sm-12" style='margin-top:6px;' id='resultData'></div>
										</div>

										<div class='d-flex justify-content-center align-items-center'>
											<button type="submit" class='btn btn-success' id='btn_box'>SUBMIT</button>
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