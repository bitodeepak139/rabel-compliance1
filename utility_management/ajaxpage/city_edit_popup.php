<?php
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}
require_once "../../classfile/initialize.php";
require_once "../../classfile/utility.php";
$id=$_POST['id'];
$row=$utility_query->get_city_editpopup($conn,$id);
$country_id=$row['fk_utm_country_id']; $state_id=$row['fk_utm_state_id']; $city_name=$row['city_name'];
?>

<input type="hidden" name="hname" id="hname" value="<?php echo $city_name ?>" />
<div class="modal-body">
  <div class="form-group row">
    <label for="example-text-input" class="col-sm-4 col-form-label">Select State<span class="text-danger">*</span></label>
    <div class="col-sm-8">
    <select id="ustate" class="form-control">
              <?php $retval=$utility_query->get_state_select($conn,$country_id);
              foreach($retval as $row){
              $cntid=$row['pk_utm_state_id']; $state_name=$row['state_name'];
               ?>
               <option value="<?php echo $cntid ?>" <?php if($state_id==$cntid) echo "selected='selected'"; ?>><?php echo $state_name ?></option>
               <?php } ?>
            </select>
    </div>
  </div>
  <div class="form-group row">
    <label for="example-text-input" class="col-sm-4 col-form-label">City Name<span class="text-danger">*</span></label>
    <div class="col-sm-8">
      <input type="text" id="ucntname" class="form-control" value="<?php echo $city_name ?>" autocomplete="off">
    </div>
  </div>
  
</div>
<div class="modal-footer"> <a href="javascript:void(0)" class="btn btn-primary" onClick="edit('<?php echo $id ?>')">Update</a>
  <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
</div>
