<?php ?>

<div class="modal-body">
  <div class="row">
    <div class="col-12">
      <form method="post" enctype="multipart/form-data" id="myform">
        <div class="form-group row">
          <label for="example-text-input" class="col-sm-4 col-form-label">Module Name<span
              class="text-danger">*</span></label>
          <div class="col-sm-8">
            <input type="text" name="cntname" id="cntname" class="form-control" value="" autocomplete="off">
          </div>
        </div>
        <div class="form-group row">
          <label for="example-text-input" class="col-sm-4 col-form-label">Sub Module Status<span
              class="text-danger">*</span></label>
          <div class="col-sm-8">
            <select id="sub_module_status" class="form-control">
              <option value="0">No</option>
              <option value='1'>Yes</option>
            </select>
          </div>
        </div>
        <div class="form-group row">
          <label for="example-text-input" class="col-sm-4 col-form-label">Module Url<span
              class="text-danger">*</span></label>
          <div class="col-sm-8">
            <input type="text" name="mdurl" id="mdurl" class="form-control" value="" autocomplete="off">
          </div>
        </div>
        <!-- <div class="form-group row">
          <label for="example-text-input" class="col-sm-4 col-form-label">Module Sequence<span
              class="text-danger">*</span></label>
          <div class="col-sm-8">
            <input type="text" name="mdseq" id="mdseq" maxlength="2" class="form-control" value="" autocomplete="off"
              onkeyup="inputWithNumber('mdseq')">
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