<?php if (session_status() === PHP_SESSION_NONE) {
    session_start();
}
require_once "../../classfile/initialize.php";
require_once "../../classfile/configuration_management.php"; ?>

<div class="modal-body">
  <div class="row">
    <div class="col-12">
      <form method="post" enctype="multipart/form-data" id="addRegionForm">
        <div class="form-group row">
          <label for="example-text-input" class="col-sm-3 col-form-label">Select Country<span
              class='text-danger'>*</span></label>
          <div class='col-sm-9'>
            <select id="country" class="form-control" name='country' onchange="DependantDropDown('country','zones','ajaxpage/get_zones.php','isset_country_for_zone')">
              <option value="">Select Country</option>
              <?php $retval = $org_query->get_country_select($conn);
              foreach ($retval as $row) {
                $id = $row['pk_utm_country_id'];
                $country_name = $row['country_name'];
                ?>
                <option value="<?php echo $id ?>">
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
              <option value="">Select Zone</option>
            </select>
          </div>

        </div>
        <div class="form-group row">
          <label for="example-text-input" class="col-sm-3 col-form-label">Enter Region Name<span
              class='text-danger'>*</span></label>
          <div class="col-sm-9">
            <input type="text" name="region_name" id="" class='form-control'>
          </div>
        </div>
        <div class="form-group row">
          <label for="example-text-input" class="col-sm-3 col-form-label">Region Details</label>
          <div class="col-sm-9">
            <textarea id="address" rows="2" class="form-control" name='region_details'></textarea>
          </div>
        </div>
      </form>
    </div>
    <!-- /.col -->
  </div>
  <!-- /.row -->
</div>
<div class="modal-footer"> <a href="javascript:void(0)" class="btn btn-primary" onClick="adddata()">Submit</a>
  <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
</div>