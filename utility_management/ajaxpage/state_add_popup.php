<?php if (session_status() === PHP_SESSION_NONE) {
    session_start();
}
require_once "../../classfile/initialize.php";
require_once "../../classfile/utility.php"; ?>

<div class="modal-body">
  <div class="row">
    <div class="col-12">
      <form method="post" enctype="multipart/form-data" id="myform">
        <div class="form-group row">
          <label for="example-text-input" class="col-sm-4 col-form-label">Select Country<span class="text-danger">*</span></label>
          <div class="col-sm-8">
            <select id="country" class="form-control">
              <option value="">Select Country</option>
              <?php $retval=$utility_query->get_country_select($conn);
              foreach($retval as $row){
              $id=$row['pk_utm_country_id']; $country_name=$row['country_name'];
               ?>
               <option value="<?php echo $id ?>"><?php echo $country_name ?></option>
               <?php } ?>
            </select>
          </div>
        </div>
        <div class="form-group row">
          <label for="example-text-input" class="col-sm-4 col-form-label">State Name<span class="text-danger">*</span></label>
          <div class="col-sm-8">
            <input type="text" name="cntname" id="cntname" class="form-control" value="" autocomplete="off">
          </div>
        </div>
        <!-- <div class="form-group row">
                  <label for="example-text-input" class="col-sm-2 col-form-label"></label>
                  <div class="col-sm-3">
                    <a href="javascript:void(0)" onClick="adddata()" class="btn btn-success btn-lg">Submit</a>
                  </div>
                </div> -->
      </form>
    </div>
    <!-- /.col -->
  </div>
  <!-- /.row -->
</div>
<div class="modal-footer"> <a href="javascript:void(0)" class="btn btn-primary" onClick="adddata()">Submit</a>
  <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
</div>