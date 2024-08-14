<?php
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}
require_once "../../classfile/initialize.php";
require_once "../../classfile/user.php";
$id = $_POST['id'];
$row = $user_query->get_module_editpopup($conn, $id);
$module_url = $row['module_url'];
$module_name = $row['module_name'];
$module_seq = $row['module_seq'];
$sub_module_status = $row['sub_module_status'];
?>

<input type="hidden" name="hname" id="hname" value="<?php echo $module_name ?>" />
<input type="hidden" name="hcode" id="hcode" value="<?php echo $module_url ?>" />
<input type="hidden" name="hseq" id="hseq" value="<?php echo $module_seq ?>" />
<div class="modal-body">
  <div class="form-group row">
    <label for="example-text-input" class="col-sm-4 col-form-label">Module Name<span
        class="text-danger">*</span></label>
    <div class="col-sm-8">
      <input type="text" id="ucntname" class="form-control" value="<?php echo $module_name ?>" autocomplete="off">
    </div>
  </div>
  <div class="form-group row">
    <label for="example-text-input" class="col-sm-4 col-form-label">Sub Module Status<span
        class="text-danger">*</span></label>
    <div class="col-sm-8">
      <select id="sub_module_status" class="form-control">
        <?php
        if ($sub_module_status == 1) {
          echo "<option value='0' >No</option>
              <option value='1' selected >Yes</option>";
        } else {
          echo "<option value='0' selected>No</option>
          <option value='1'  >Yes</option>";
        }
        ?>
      </select>
    </div>
  </div>
  <div class="form-group row">
    <label for="example-text-input" class="col-sm-4 col-form-label">Module Url<span class="text-danger">*</span></label>
    <div class="col-sm-8">
      <input type="text" id="ucntcode" class="form-control" value="<?php echo $module_url ?>" autocomplete="off">
    </div>
  </div>
  <div class="form-group row">
    <label for="example-text-input" class="col-sm-4 col-form-label">Module Sequence<span
        class="text-danger">*</span></label>
    <div class="col-sm-8">
      <input type="text" id="module_seq" class="form-control" value="<?php echo $module_seq ?>" autocomplete="off">
    </div>
  </div>

</div>
<div class="modal-footer"> <a href="javascript:void(0)" class="btn btn-primary"
    onClick="edit('<?php echo $id ?>')">Update</a>
  <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
</div>