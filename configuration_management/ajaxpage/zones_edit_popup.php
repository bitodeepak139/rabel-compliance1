<?php
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}
require_once "../../classfile/initialize.php";
require_once "../../classfile/configuration_management.php";
$id = $_POST['id'];
$zoneData = $org_query->fetch_data($conn, "cnf_mst_zone as a INNER JOIN utm_add_country as b ON a.country_id = b.pk_utm_country_id", "a.*,b.country_name", "a.Id='$id'");
$row = $zoneData[0];
$country_id = $row['country_id'];
$zone_name = $row['zone_name'];
$zone_details = $row['zone_details'];
?>
<div class="modal-body">
  <form method="post" enctype="multipart/form-data" id="UpdateZoneForm">

  <input type="hidden" name="hcountryID" value='<?php echo $country_id; ?>'>
  <input type="hidden" name="hzonename" value='<?php echo $zone_name; ?>'>

    <div class="form-group row">
      <label for="example-text-input" class="col-sm-3 col-form-label">Select Country<span
          class='text-danger'>*</span></label>
      <div class='col-sm-9'>
        <select id="country" class="form-control" name='country'>
          <option value="">Select Country</option>
          <?php $retval = $org_query->get_country_select($conn);
          foreach ($retval as $row) {
            $cid = $row['pk_utm_country_id'];
            $country_name = $row['country_name'];
            ?>
            <option value="<?php echo $cid ?>" <?php if ($cid == $country_id)
                 echo "selected" ?>>
              <?php echo $country_name ?>
            </option>
          <?php } ?>
        </select>
      </div>

    </div>
    <div class="form-group row">
      <label for="example-text-input" class="col-sm-3 col-form-label">Enter Zone Name<span
          class='text-danger'>*</span></label>
      <div class="col-sm-9">
        <input type="text" name="zone_name" value="<?php echo $zone_name ?>" class='form-control'>
      </div>
    </div>
    <div class="form-group row">
      <label for="example-text-input" class="col-sm-3 col-form-label">Department Details</label>
      <div class="col-sm-9">
        <textarea id="address" rows="2" class="form-control" name='department_details'><?php echo $zone_details; ?></textarea>
      </div>
    </div>
  </form>



</div>
<div class="modal-footer"> <a href="javascript:void(0)" class="btn btn-primary"
    onClick="edit('<?php echo $id ?>')">Update</a>
  <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
</div>