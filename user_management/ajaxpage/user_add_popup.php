<?php if (session_status() === PHP_SESSION_NONE) {
    session_start();
}
require_once "../../classfile/initialize.php";
require_once "../../classfile/user.php"; ?>

<div class="modal-body">
  <div class="row">
    <div class="col-12">
      <form method="post" enctype="multipart/form-data" id="myform">
        <div class="form-group row">
          <label for="example-text-input" class="col-sm-3 col-form-label">Select Type of User<span
              class="text-danger">*</span></label>
          <div class="col-sm-9">
            <select id='type_of_user' class="form-control">
              <option value="">Select the Type of User</option>
              <?php $retval = $user_query->fetch_data($conn, "usm_level", "*", "1");
              foreach ($retval as $drow) { ?>
                <option value="<?php echo $drow['level'] ?>">
                  <?php echo $drow['level'] ?>
                </option>
              <?php } ?>
            </select>
          </div>
        </div>
        <div class="form-group row">
          <label for="example-text-input" class="col-sm-3 col-form-label">User Name<span
              class="text-danger">*</span></label>
          <div class="col-sm-9">
            <input type="text" id="cntname" class="form-control" value="" autocomplete="off">
          </div>
        </div>
        <div class="form-group row">
          <label for="example-text-input" class="col-sm-3 col-form-label">User Image</label>
          <div class="col-sm-3">
            <input type="file" id="file" class="form-control">
          </div>
          <label for="example-text-input" class="col-sm-6 col-form-label">(Image Only, Max 200kb)</label>
        </div>
        <div class="form-group row">
          <label for="example-text-input" class="col-sm-3 col-form-label">Contact No.<span
              class="text-danger">*</span></label>
          <div class="col-sm-3"><input type="text" id="phone" class="form-control" value="" autocomplete="off"
              maxlength="10">
          </div>
          <label for="example-text-input" class="col-sm-2 col-form-label">Alternate No.</label>
          <div class="col-sm-4"><input type="text" id="altno" class="form-control" value="" autocomplete="off"
              maxlength="12">
          </div>
        </div>
        <div class="form-group row">
          <label for="example-text-input" class="col-sm-3 col-form-label">Email<span
              class="text-danger">*</span></label>
          <div class="col-sm-3"><input type="text" id="email" class="form-control" value="" autocomplete="off">
          </div>
          <label for="example-text-input" class="col-sm-2 col-form-label">Password<span
              class="text-danger">*</span></label>
          <div class="col-sm-4"><input type="text" id="pass" class="form-control" value="" autocomplete="off">
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