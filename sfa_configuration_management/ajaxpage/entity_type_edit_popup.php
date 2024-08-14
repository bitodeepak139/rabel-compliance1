<?php
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}
require_once "../../classfile/initialize.php";
require_once "../../classfile/sfa_configuration_management.php";
$id = $_POST['id'];
$entityData = $sfa_query->fetch_data($conn,"sfa_cnf_mst_entity_type","*","id='$id'");
$entityRow = $entityData[0];
?>
<input type="hidden" id='htypeid' name="htypeid" value="<?php echo $entityRow['pk_sfa_cnf_entitytype_id'] ?>">
<input type="hidden" id='htypename' name="htypename" value="<?php echo $entityRow['type_name'] ?>">
<div class="modal-body">
  <div class="form-group row">
    <label for="example-text-input" class="col-sm-4 col-form-label">TypeID<span class="text-danger">*</span></label>
    <div class="col-sm-8">
      <input type="text" id="typeid" class="form-control" value="<?php echo $entityRow['pk_sfa_cnf_entitytype_id'] ?>" autocomplete="off">
    </div>
  </div>
  <div class="form-group row">
    <label for="example-text-input" class="col-sm-4 col-form-label">Entity Type<span
        class="text-danger">*</span></label>
    <div class="col-sm-8">
      <input type="text" id="typename" class="form-control" value="<?php echo $entityRow['type_name'] ?>" autocomplete="off">
    </div>
  </div>

</div>
<div class="modal-footer"> <a href="javascript:void(0)" class="btn btn-primary"
    onClick="edit('<?php echo $id ?>')">Update</a>
  <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
</div>