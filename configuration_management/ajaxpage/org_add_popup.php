<?php if (session_status() === PHP_SESSION_NONE) {
    session_start();
}
require_once "../../classfile/initialize.php";
require_once "../../classfile/configuration_management.php"; ?>

<div class="modal-body">
  <div class="row">
    <div class="col-12">
      <form method="post" enctype="multipart/form-data" id="myform">
      <div class="form-group row">
          <label for="example-text-input" class="col-sm-3 col-form-label">Organization Name<span class="text-danger">*</span></label>
          <div class="col-sm-9">
            <input type="text" id="cntname" class="form-control" value="" autocomplete="off">
          </div>
        </div>
        <div class="form-group row">
          <label for="example-text-input" class="col-sm-3 col-form-label">Organization Logo<span class="text-danger">*</span></label>
          <div class="col-sm-3">
            <input type="file" id="file" class="form-control">
          </div>
          <label for="example-text-input" class="col-sm-6 col-form-label">(Image Only, Max 100kb)</label>
        </div>
        <div class="form-group row">
          <label for="example-text-input" class="col-sm-3 col-form-label">Select Country</label>
          <div class="col-sm-3">
            <select id="country" class="form-control" onchange="getstate(this.value)">
              <option value="">Select Country</option>
              <?php $retval=$org_query->get_country_select($conn);
              foreach($retval as $row){
              $id=$row['pk_utm_country_id']; $country_name=$row['country_name'];
               ?>
               <option value="<?php echo $id ?>"><?php echo $country_name ?></option>
               <?php } ?>
            </select>
          </div>
          <label for="example-text-input" class="col-sm-2 col-form-label">Select State</label>
          <div class="col-sm-4"><div id="statediv">
            <select id="state" class="form-control">
              <option value="">Select State</option>              
            </select>
            </div>
          </div>
        </div>
        <div class="form-group row">
        <label for="example-text-input" class="col-sm-3 col-form-label">Select City</label>
          <div class="col-sm-3"><div id="citydiv">
            <select id="city" class="form-control">
              <option value="">Select City</option>              
            </select>
            </div>
          </div>
          <label for="example-text-input" class="col-sm-2 col-form-label">Address</label>
          <div class="col-sm-4">
            <textarea id="address" rows="1" class="form-control"></textarea>
          </div>          
        </div>
        <div class="form-group row">
        <label for="example-text-input" class="col-sm-3 col-form-label">Contact No.<span class="text-danger">*</span></label>
          <div class="col-sm-3"><input type="text" id="phone" class="form-control" value="" autocomplete="off" maxlength="10">
          </div>
          <label for="example-text-input" class="col-sm-2 col-form-label">Alternate No.</label>
          <div class="col-sm-4"><input type="text" id="altno" class="form-control" value="" autocomplete="off" maxlength="12">
          </div>          
        </div>
        <div class="form-group row">
        <label for="example-text-input" class="col-sm-3 col-form-label">Email</label>
          <div class="col-sm-3"><input type="text" id="email" class="form-control" value="" autocomplete="off">
          </div>
          <label for="example-text-input" class="col-sm-2 col-form-label">Website</label>
          <div class="col-sm-4"><input type="text" id="website" class="form-control" value="" autocomplete="off">
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