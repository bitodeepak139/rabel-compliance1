<?php
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}
require_once "../../classfile/initialize.php";
require_once "../../classfile/sfa_entity_management.php";
$id = $_POST['id'];

$contactDetails = $sfa_ent->fetch_data($conn, "sfa_ent_mst_contact_master as a INNER JOIN sfa_ent_mst_entity as b ON a.fk_sfa_ent_entity_id=b.pk_sfa_ent_entity_id", "a.*,b.entity_name", "pk_sfa_ent_contact_id='$id'");

$row = $contactDetails[0];
$name = $row['contact_name'];
$designation = $row['designation'];
$mobile1 = $row['mobile1'];
$mobile2 = $row['mobile2'];
$landline = $row['landline'];
$email = $row['email'];
$contact_dob = $row['contact_dob'];
$contact_dom = $row['contact_dom'];
$contact_remark = $row['contact_remark'];
$org = $row['entity_name'];

?>

<div class="modal-body">
  <div class="row">
    <div class="col-sm-12">
      <div class="row">
        <label for="example-text-input" class="col-sm-2 col-form-label">Name</label>
        <div class="col-sm-4"><?php  echo $name ?></div>
        <label for="example-text-input" class="col-sm-2 col-form-label">Designation</label>
        <div class="col-sm-4"><?php echo $designation ?></div>
      </div>      
      <div class="row">
        <label for="example-text-input" class="col-sm-2 col-form-label">Organization</label>
        <div class="col-sm-4"><?php echo $org; ?></div>
        <label for="example-text-input" class="col-sm-2 col-form-label">Mobile No</label>
        <div class="col-sm-4"><?php echo $mobile1 ?></div>
      </div>      
      <div class="row">
        <label for="example-text-input" class="col-sm-2 col-form-label">Alternate No</label>
        <div class="col-sm-4"><?php echo $mobile2 ?></div>
        <label for="example-text-input" class="col-sm-2 col-form-label">Landline No</label>
        <div class="col-sm-4"><?php echo $landline ?></div>
      </div>      
      <div class="row">
        <label for="example-text-input" class="col-sm-2 col-form-label">Email ID</label>
        <div class="col-sm-4"><?php echo $email ?></div>
        <label for="example-text-input" class="col-sm-2 col-form-label">DOB</label>
        <div class="col-sm-4"><?php echo $contact_dob ?></div>
      </div>      
      <div class="row">
        <label for="example-text-input" class="col-sm-2 col-form-label">DOM</label>
        <div class="col-sm-10"><?php echo $contact_dom ?></div>
      </div>      
      <div class="row">
        <label for="example-text-input" class="col-sm-2 col-form-label">Remark</label>
        <div class="col-sm-10"><?php echo $contact_remark ?></div>
      </div>      
    </div>
  </div>


</div>
<div class="modal-footer ">
  <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
</div>