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
$user_level = $row['user_level'];
$contact = $row['primary_contact_no'];
$altno = $row['secondary_contact_no'];
$email = $row['user_email'];
$pass = $row['user_password'];
$design = $row['designation'];
?>

<input type="hidden" id="hname" value="<?php echo $name ?>" />
<input type="hidden" id="hphone" value="<?php echo $contact ?>" />
<input type="hidden" id="hemail" value="<?php echo $email ?>" />
<input type="hidden" id="hfile" value="<?php echo $logo ?>" />
<div class="modal-body">
  <div class="form-group row">
    <label for="example-text-input" class="col-sm-3 col-form-label">Select Type of User<span
        class="text-danger">*</span></label>
    <div class="col-sm-9">
      <select id='utype_of_user' class="form-control">
        <option value="">Select the Type of User</option>
        <?php $retval = $user_query->fetch_data($conn, "usm_level", "*", "1");
        foreach ($retval as $drow) { ?>
          <option value="<?php echo $drow['level'] ?>" <?php if ($user_level == $drow['level'])
               echo "selected"; ?>>
            <?php echo $drow['level'] ?>
          </option>
        <?php } ?>
      </select>
    </div>
  </div>
  <div class="form-group row">
    <label for="example-text-input" class="col-sm-3 col-form-label">User Name<span class="text-danger">*</span></label>
    <div class="col-sm-9">
      <input type="text" id="ucntname" class="form-control" value="<?php echo $name ?>" autocomplete="off">
    </div>
  </div>
  <div class="form-group row">
    <label for="example-text-input" class="col-sm-3 col-form-label">User Image</label>
    <div class="col-sm-3">
      <input type="file" id="ufile" class="form-control">
    </div>
    <label for="example-text-input" class="col-sm-6 col-form-label">(Image Only, Max 200kb)</label>
  </div>
  <div class="form-group row">
    <label for="example-text-input" class="col-sm-3 col-form-label">Contact No.<span
        class="text-danger">*</span></label>
    <div class="col-sm-3"><input type="text" id="uphone" class="form-control" value="<?php echo $contact ?>"
        autocomplete="off" maxlength="10">
    </div>
    <label for="example-text-input" class="col-sm-2 col-form-label">Alternate No.</label>
    <div class="col-sm-4"><input type="text" id="ualtno" class="form-control" value="<?php echo $altno ?>"
        autocomplete="off" maxlength="12">
    </div>
  </div>
  <div class="form-group row">
    <label for="example-text-input" class="col-sm-3 col-form-label">Email<span class="text-danger">*</span></label>
    <div class="col-sm-3"><input type="text" id="uemail" class="form-control" value="<?php echo $email ?>"
        autocomplete="off">
    </div>
    <label for="example-text-input" class="col-sm-2 col-form-label">Password<span class="text-danger">*</span></label>
    <div class="col-sm-4"><input type="text" id="upass" class="form-control" value="<?php echo $pass ?>"
        autocomplete="off">
    </div>
  </div>
  <div class="form-group row">
    <label for="example-text-input" class="col-sm-3 col-form-label">Designation</label>
    <div class="col-sm-9">
      <select id="udesign" class="form-control">
        <option value="">Select Designation</option>
        <?php $retval = $user_query->select_designation_data($conn);
        foreach ($retval as $drow) { ?>
          <option value="<?php echo $drow['pk_cnf_designation_id'] ?>" <?php if ($design == $drow['pk_cnf_designation_id'])
               echo "selected='selected'"; ?>>
            <?php echo $drow['name'] ?>
          </option>
        <?php } ?>
      </select>
    </div>
  </div>


</div>
<div class="modal-footer"> <a href="javascript:void(0)" class="btn btn-primary"
    onClick="edit('<?php echo $id ?>')">Update</a>
  <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
</div>