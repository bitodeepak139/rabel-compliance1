<?php if (session_status() === PHP_SESSION_NONE) {
    session_start();
}
require_once "../../classfile/initialize.php";
require_once "../../classfile/user.php";
?>

<div class="modal-body">
  <div class="row">
    <div class="col-12">
      <form method="post" enctype="multipart/form-data" id="myform">
        <div class="form-group row">
          <label for="example-text-input" class="col-sm-3 col-form-label">Select Module<span
              class="text-danger">*</span></label>
          <div class="col-sm-9">
            <?php $retval = $user_query->fetch_data($conn, "usm_add_modules", "*", "`transaction_status`='1'");
            ?>
            <select id="module" class="form-control"
              onchange="DependantDropDown('module','sub-module','ajaxpage/ajax.php','isset_dependent_sub_module','sub_module_status_present','pgseqno')">
              <option value="">Select Module</option>
              <?php
              foreach ($retval as $row) {
                $mdid = $row['pk_usm_module_id'];
                $module_name = $row['module_name'];
                ?>
                <option value="<?php echo $mdid ?>">
                  <?php echo $module_name ?>
                </option>
              <?php } ?>
            </select>
          </div>
        </div>
        <div id='sub_module_status_present' style="display:none;">
          <div class="form-group row">
            <label for="example-text-input" class="col-sm-3 col-form-label">Select Sub Module<span
                class="text-danger">*</span></label>
            <div class="col-sm-9">
              <select id="sub-module" class="form-control"
                onchange="getseqno(this.value,'isset_get_sub_module_seq','#pgseqno')">
                <option value="">Select Sub Module</option>
              </select>
            </div>
          </div>
        </div>
        <div class="form-group row">
          <label for="example-text-input" class="col-sm-3 col-form-label">Page Name<span
              class="text-danger">*</span></label>
          <div class="col-sm-9">
            <input type="text" id="cntname" class="form-control" value="" autocomplete="off">
          </div>
        </div>
        <div class="form-group row">
          <label for="example-text-input" class="col-sm-3 col-form-label">Page Url<span
              class="text-danger">*</span></label>
          <div class="col-sm-9">
            <input type="text" id="pgurl" class="form-control" value="" autocomplete="off">
          </div>
        </div>
        <div class="form-group row">
          <label for="example-text-input" class="col-sm-3 col-form-label">Sequence No<span
              class="text-danger">*</span></label>
          <div class="col-sm-9">
            <input type="number" id="pgseqno" class="form-control" value="" autocomplete="off">
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