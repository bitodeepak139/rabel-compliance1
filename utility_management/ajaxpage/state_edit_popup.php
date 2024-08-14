<?php
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}
require_once "../../classfile/initialize.php";
require_once "../../classfile/utility.php";
$id=$_POST['id'];
$row=$utility_query->get_state_editpopup($conn,$id);
$country_id=$row['fk_utm_country_id']; $state_name=$row['state_name'];
?>

<input type="hidden" name="hname" id="hname" value="<?php echo $state_name ?>" />
<div class="modal-body">
  <div class="form-group row">
    <label for="example-text-input" class="col-sm-4 col-form-label">Select Country<span class="text-danger">*</span></label>
    <div class="col-sm-8">
    <select id="ucountry" class="form-control">
              <?php $retval=$utility_query->get_country_select($conn);
              foreach($retval as $row){
              $cntid=$row['pk_utm_country_id']; $country_name=$row['country_name'];
               ?>
               <option value="<?php echo $cntid ?>" <?php if($country_id==$cntid) echo "selected='selected'"; ?>><?php echo $country_name ?></option>
               <?php } ?>
            </select>
    </div>
  </div>
  <div class="form-group row">
    <label for="example-text-input" class="col-sm-4 col-form-label">State Name<span class="text-danger">*</span></label>
    <div class="col-sm-8">
      <input type="text" id="ucntname" class="form-control" value="<?php echo $state_name ?>" autocomplete="off">
    </div>
  </div>
  
</div>
<div class="modal-footer"> <a href="javascript:void(0)" class="btn btn-primary" onClick="edit('<?php echo $id ?>')">Update</a>
  <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
</div>
