<?php
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}
require_once "../../classfile/initialize.php";
require_once "../../classfile/configuration_management.php";
$id = $_POST['id'];
$row = $org_query->get_org_viewpopup($conn, $id);
$country_name = $row['country_name'];
$state_name = $row['state_name'];
$city_name = $row['city_name'];
$name = $row['organization_name'];
$logo = $row['organization_logo'];
$address = $row['organization_address'];
$contact = $row['primary_contact_no'];
$altno = $row['secondary_contact_no'];
$email = $row['email'];
$website = $row['website_url'];
?>

<div class="modal-body">
  <div class="row">
    <div class="col-sm-9">

      <div class="row">
        <label for="example-text-input" class="col-sm-4 col-form-label">Organization Name</label>
        <div class="col-sm-8"><?php echo $name ?></div>
      </div>
      <div class="row">
        <label for="example-text-input" class="col-sm-4 col-form-label">Organization Address</label>
        <div class="col-sm-8"><?php echo $address ?> <?php echo $city_name ?> <?php echo $state_name ?> <?php echo $country_name ?></div>
      </div>
      <div class="row">
        <label for="example-text-input" class="col-sm-4 col-form-label">Contact No</label>
        <div class="col-sm-8"><?php echo $contact ?></div>
      </div>
      <div class="row">
        <label for="example-text-input" class="col-sm-4 col-form-label">Alternate No.</label>
        <div class="col-sm-8"><?php echo $altno ?></div>
      </div>
      <div class="row">
        <label for="example-text-input" class="col-sm-4 col-form-label">Email</label>
        <div class="col-sm-8"><?php echo $email ?></div>
      </div>
      <div class="row">
        <label for="example-text-input" class="col-sm-4 col-form-label">Website</label>
        <div class="col-sm-8"><?php echo $website ?></div>
      </div>
    </div>
    <div class="col-sm-3"><img src="../upload/logo/<?php echo $logo ?>" width="100%"></div>
  </div>


</div>
<div class="modal-footer">
  <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
</div>