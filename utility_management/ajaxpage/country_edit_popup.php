<?php
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}
require_once "../../classfile/initialize.php";
require_once "../../classfile/utility.php";
$id=$_POST['id'];
$row=$utility_query->get_country_editpopup($conn,$id);
$country_code=$row['country_code']; $country_name=$row['country_name'];
?>

<input type="hidden" name="hname" id="hname" value="<?php echo $country_name ?>" />
<input type="hidden" name="hcode" id="hcode" value="<?php echo $country_code ?>" />
<div class="modal-body">
  <div class="form-group row">
    <label for="example-text-input" class="col-sm-4 col-form-label">Country Code<span class="text-danger">*</span></label>
    <div class="col-sm-8">
      <input type="text" id="ucntcode" class="form-control" value="<?php echo $country_code ?>" autocomplete="off">
    </div>
  </div>
  <div class="form-group row">
    <label for="example-text-input" class="col-sm-4 col-form-label">Country Name<span class="text-danger">*</span></label>
    <div class="col-sm-8">
      <input type="text" id="ucntname" class="form-control" value="<?php echo $country_name ?>" autocomplete="off">
    </div>
  </div>
  
</div>
<div class="modal-footer"> <a href="javascript:void(0)" class="btn btn-primary" onClick="edit('<?php echo $id ?>')">Update</a>
  <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
</div>
