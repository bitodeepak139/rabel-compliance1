<?php
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}
require_once "../../classfile/initialize.php";
require_once "../../classfile/configuration_management.php";
$id=$_POST['id'];
$row=$org_query->get_org_editpopup($conn,$id);
$country_id=$row['fk_utm_country_id']; $state=$row['fk_utm_state_id']; $city=$row['fk_utm_city_id'];
$name = $row['organization_name']; $logo = $row['organization_logo']; $address = $row['organization_address']; $contact = $row['primary_contact_no'];
$altno = $row['secondary_contact_no']; $email = $row['email']; $website = $row['website_url'];
?>

<input type="hidden" id="hname" value="<?php echo $name ?>" />
<input type="hidden" id="hfile" value="<?php echo $logo ?>" />
<div class="modal-body">
<div class="form-group row">
    <label for="example-text-input" class="col-sm-3 col-form-label">Organization Name<span class="text-danger">*</span></label>
    <div class="col-sm-8">
      <input type="text" id="ucntname" class="form-control" value="<?php echo $name ?>" autocomplete="off">
    </div>
  </div>
  <div class="form-group row">
          <label for="example-text-input" class="col-sm-3 col-form-label">Organization Logo</label>
          <div class="col-sm-3">
            <input type="file" id="ufile" class="form-control">
          </div>
          <label for="example-text-input" class="col-sm-6 col-form-label">(Image Only, Max 100kb)</label>
        </div>
        <div class="form-group row">
          <label for="example-text-input" class="col-sm-3 col-form-label">Select Country</label>
          <div class="col-sm-3">
            <select id="ucountry" class="form-control" onchange="getstate1(this.value)">
              <option value="">Select Country</option>
              <?php $retval=$org_query->get_country_select($conn);
              foreach($retval as $crow){
              $cntid=$crow['pk_utm_country_id']; $country_name=$crow['country_name'];
               ?>
               <option value="<?php echo $cntid ?>" <?php if($country_id==$cntid) echo "selected='selected'"; ?>><?php echo $country_name ?></option>
               <?php } ?>
            </select>
          </div>
          <label for="example-text-input" class="col-sm-2 col-form-label">Select State</label>
          <div class="col-sm-4"><div id="ustatediv">
            <select id="ustate" class="form-control">
              <option value="">Select State</option>
              <?php $stretval=$org_query->get_state_select($conn,$country_id);
              foreach($stretval as $srow){
                $state_id=$srow['pk_utm_state_id']; $state_name=$srow['state_name'];
               ?>
               <option value="<?php echo $state_id ?>" <?php if($state==$state_id) echo "selected='selected'"; ?>><?php echo $state_name ?></option>
               <?php } ?>            
            </select>
            </div>
          </div>
        </div>
        <div class="form-group row">
        <label for="example-text-input" class="col-sm-3 col-form-label">Select City</label>
          <div class="col-sm-3"><div id="ucitydiv">
            <select id="ucity" class="form-control">
              <option value="">Select City</option> 
              <?php $ctretval=$org_query->get_city_select($conn,$state);
              foreach($ctretval as $grow){
                $city_id=$grow['pk_utm_city_id']; $city_name=$grow['city_name'];
               ?>
               <option value="<?php echo $city_id ?>" <?php if($city==$city_id) echo "selected='selected'"; ?>><?php echo $city_name ?></option>
               <?php } ?>              
            </select>
            </div>
          </div>
          <label for="example-text-input" class="col-sm-2 col-form-label">Address</label>
          <div class="col-sm-4">
            <textarea id="uaddress" rows="1" class="form-control"><?php echo $address ?></textarea>
          </div>          
        </div>
        <div class="form-group row">
        <label for="example-text-input" class="col-sm-3 col-form-label">Contact No.<span class="text-danger">*</span></label>
          <div class="col-sm-3"><input type="text" id="uphone" class="form-control" value="<?php echo $contact ?>" autocomplete="off" maxlength="10">
          </div>
          <label for="example-text-input" class="col-sm-2 col-form-label">Alternate No.</label>
          <div class="col-sm-4"><input type="text" id="ualtno" class="form-control" value="<?php echo $altno ?>" autocomplete="off" maxlength="12">
          </div>          
        </div>
        <div class="form-group row">
        <label for="example-text-input" class="col-sm-3 col-form-label">Email</label>
          <div class="col-sm-3"><input type="text" id="uemail" class="form-control" value="<?php echo $email ?>" autocomplete="off">
          </div>
          <label for="example-text-input" class="col-sm-2 col-form-label">Website</label>
          <div class="col-sm-4"><input type="text" id="uwebsite" class="form-control" value="<?php echo $website ?>" autocomplete="off">
          </div>          
        </div>
  
  
</div>
<div class="modal-footer"> <a href="javascript:void(0)" class="btn btn-primary" onClick="edit('<?php echo $id ?>')">Update</a>
  <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
</div>
