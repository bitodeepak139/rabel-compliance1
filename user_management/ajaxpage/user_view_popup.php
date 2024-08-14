<?php
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}
require_once "../../classfile/initialize.php";
require_once "../../classfile/user.php";
$id = $_POST['id'];
$row = $user_query->get_user_editpopup($conn, $id);
$name = $row['user_name'];
$logo = $row['user_image'];
$contact = $row['primary_contact_no'];
$altno = $row['secondary_contact_no'];
$email = $row['user_email'];
$pass = $row['user_password'];
$design = $row['desig_name'];
?>

<div class="modal-body">
  <div class="row">
    <div class="col-sm-9">

      <div class="row">
        <label for="example-text-input" class="col-sm-4 col-form-label">User Name</label>
        <div class="col-sm-8"><?php echo $name ?></div>
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
      <label for="example-text-input" class="col-sm-4 col-form-label">Password</label>
        <div class="col-sm-8"><?php echo $pass ?></div>
        <label for="example-text-input" class="col-sm-4 col-form-label">Designation</label>
        <div class="col-sm-8"><?php echo $design ?></div>
      </div>
    </div>
    <div class="col-sm-3"><?php if($logo!=''){ ?><img src="../upload/user/<?php echo $logo ?>" height="120px"> <?php } ?></div>
  </div>


</div>
<div class="modal-footer">
  <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
</div>