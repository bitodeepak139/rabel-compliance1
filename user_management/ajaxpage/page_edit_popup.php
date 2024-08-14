<?php
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}
require_once "../../classfile/initialize.php";
require_once "../../classfile/user.php";
$id = $_POST['id'];
$row = $user_query->get_page_editpopup($conn, $id);
// $user_query->debug($row);
$module_id = $row['fk_usm_module_id'];
$submodule_id = $row['fk_usm_sub_module_id'];
$page_name = $row['page_name'];
$seqno = $row['page_sequence'];
$page_actual = $row['page_actual'];
?>


<div class="modal-body">
  <div class="form-group row">
    <!-- hidden fields -->
    <input type="hidden" name="hmodule_id" id='hmodule_id' value='<?php echo $module_id ?>'>
    <input type="hidden" name="hsubmodule_id" id='hsubmodule_id' value='<?php echo $submodule_id ?>'>
    <input type="hidden" name="hpage_name" id='hpage_name' value='<?php echo $page_name ?>'>
    <input type="hidden" name="hpage_url" id='hpage_url' value='<?php echo $page_actual ?>'>
    <input type="hidden" name="hpage_seqno" id='hpage_seqno' value='<?php echo $seqno ?>'>
    <label for="example-text-input" class="col-sm-3 col-form-label">Select Module<span
        class="text-danger">*</span></label>
    <div class="col-sm-9">
      <select id="module" class="form-control"
        onchange="DependantDropDown('module','sub-module','ajaxpage/ajax.php','isset_dependent_sub_module','upsub_module_status_present','gseqno')">
        <?php $retval = $user_query->fetch_data($conn, "usm_add_modules", "*", "`transaction_status`='1'");
        foreach ($retval as $row) {
          $mdid = $row['pk_usm_module_id'];
          $module_name = $row['module_name'];
          ?>
          <option value="<?php echo $mdid ?>" <?php if ($module_id == $mdid)
               echo "selected='selected'"; ?>>
            <?php echo $module_name ?>
          </option>
        <?php } ?>
      </select>
    </div>
  </div>
  <div id='upsub_module_status_present' <?php if ($submodule_id != '')
    echo "style='display:block;'";
  else
    echo "style='display:none;'"; ?>>
    <div class="form-group row">
      <label for="example-text-input" class="col-sm-3 col-form-label">Select Sub Module<span
          class="text-danger">*</span></label>
      <div class="col-sm-9">
        <select id="sub-module" class="form-control">
          <?php $subModule = $user_query->fetch_data($conn, 'usm_mst_submodule', '*', "`fk_usm_module_id`='$module_id'");
          foreach ($subModule as $singleSubModule) {
            $smid = $singleSubModule['pk_usm_submodule_id'];
            $submodule_name = $singleSubModule['submodule_name'];
            ?>
            <option value="<?php echo $smid ?>" <?php if ($submodule_id == $smid)
                 echo "selected='selected'"; ?>>
              <?php echo $submodule_name ?>
            </option>
          <?php } ?>
        </select>
      </div>
    </div>
  </div>
  <div class="form-group row">
    <label for="example-text-input" class="col-sm-3 col-form-label">Page Name<span class="text-danger">*</span></label>
    <div class="col-sm-9">
      <input type="text" id="ucntname" class="form-control" value="<?php echo $page_name ?>" autocomplete="off">
    </div>
  </div>
  <div class="form-group row">
    <label for="example-text-input" class="col-sm-3 col-form-label">Page Url<span class="text-danger">*</span></label>
    <div class="col-sm-9">
      <input type="text" id="upgurl" class="form-control" value="<?php echo $page_actual ?>" autocomplete="off">
    </div>
  </div>
  <div class="form-group row">
    <label for="example-text-input" class="col-sm-3 col-form-label">Sequence No<span
        class="text-danger">*</span></label>
    <div class="col-sm-9">
      <?php //if() ?>
      <input type="number" id="upgseqno" class="form-control" value="<?php echo $seqno ?>" autocomplete="off">
    </div>
  </div>

</div>
<div class="modal-footer"> <a href="javascript:void(0)" class="btn btn-primary"
    onClick="edit('<?php echo $id ?>')">Update</a>
  <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
</div>