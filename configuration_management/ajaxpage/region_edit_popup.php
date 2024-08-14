<?php
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}
require_once "../../classfile/initialize.php";
require_once "../../classfile/configuration_management.php";
$id = $_POST['id'];
$RegionData = $org_query->fetch_data($conn, "cnf_mst_region as a INNER JOIN cnf_mst_zone as b on a.fk_cnf_zone_id=b.pk_cnf_zone_id INNER JOIN utm_add_country as c ON c.pk_utm_country_id = a.country_id", "a.*,b.zone_name,c.country_name", "a.Id='$id'");
$row = $RegionData[0];
$country_id = $row['country_id'];
$zone_id = $row['fk_cnf_zone_id'];
$region_name = $row['region_name'];
$region_details = $row['region_details'];

?>

<div class="modal-body">
  <div class="row">
    <div class="col-12">
      <form method="post" enctype="multipart/form-data" id="updateRegionForm">
        <!-- Hidden Fields -->
        <input type="hidden" name="hcountry" value="<?php echo $country_id ?>">
        <input type="hidden" name="hzoneId" value="<?php echo $zone_id ?>">
        <input type="hidden" name="hregionName" value="<?php echo $region_name ?>">
        <!-- Hidden Fields -->
        <div class="form-group row">
          <label for="example-text-input" class="col-sm-3 col-form-label">Select Country<span
              class='text-danger'>*</span></label>
          <div class='col-sm-9'>
            <select id="country" class="form-control" name='country'
              onchange="DependantDropDown('country','zones','ajaxpage/get_zones.php','isset_country_for_zone')">
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
          <label for="example-text-input" class="col-sm-3 col-form-label">Select Zone<span
              class='text-danger'>*</span></label>
          <div class='col-sm-9'>
            <select id="zones" class="form-control" name='zone_id'>
              <?php
              $result = $org_query->fetch_data($conn, "cnf_mst_zone", "*", "country_id='$country_id'");
              foreach ($result as $zone) {
                if ($zone['pk_cnf_zone_id'] == $zone_id)
                  echo "<option value='$zone[pk_cnf_zone_id]' selected>$zone[zone_name]</option>";
                else
                  echo "<option value='$zone[pk_cnf_zone_id]'>$zone[zone_name]</option>";
              }
              ?>

            </select>
          </div>

        </div>
        <div class="form-group row">
          <label for="example-text-input" class="col-sm-3 col-form-label">Enter Region Name<span
              class='text-danger'>*</span></label>
          <div class="col-sm-9">
            <input type="text" name="region_name" id="" class='form-control' value='<?php echo $region_name ?>'>
          </div>
        </div>
        <div class="form-group row">
          <label for="example-text-input" class="col-sm-3 col-form-label">Region Details</label>
          <div class="col-sm-9">
            <textarea id="address" rows="2" class="form-control" name='region_details'>
              <?php echo $region_details ?>
            </textarea>
          </div>
        </div>
      </form>
    </div>
    <!-- /.col -->
  </div>
  <!-- /.row -->
</div>
<div class="modal-footer"> <a href="javascript:void(0)" class="btn btn-primary"
    onClick="edit('<?php echo $id ?>')">Update</a>
  <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
</div>