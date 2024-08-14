<?php
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}
require_once "../../classfile/initialize.php";
require_once "../../classfile/sfa_configuration_management.php";
$id = $_POST['id'];
$orgData = $sfa_query->fetch_data($conn, "sfa_cnf_mst_organization_type", "*", "id='$id'");
$orgRow = $orgData[0];
?>
<div class="modal-body">
    <form method="post" id='updateOrgType'>
        <input type="hidden" id='htypeid' name="horgid" value="<?php echo $orgRow['pk_sfa_cnf_custype_id'] ?>">
        <input type="hidden" id='htypename' name="horgname" value="<?php echo $orgRow['type_name'] ?>">

        <div class="form-group row">
            <label for="example-text-input" class="col-sm-4 col-form-label">ID<span class="text-danger">*</span></label>
            <div class="col-sm-8">
                <input type="text" id="orgid" name="orgid" class="form-control"
                    value="<?php echo $orgRow['pk_sfa_cnf_custype_id'] ?>" autocomplete="off">
            </div>
        </div>
        <div class="form-group row">
            <label for="example-text-input" class="col-sm-4 col-form-label">Organization Type<span
                    class="text-danger">*</span></label>
            <div class="col-sm-8">
                <input type="text" id="typename" class="form-control" name='orgname' value="<?php echo $orgRow['type_name'] ?>"
                    autocomplete="off">
            </div>
        </div>
    </form>
</div>
<div class="modal-footer"> <a href="javascript:void(0)" class="btn btn-primary"
        onClick="edit('<?php echo $id ?>','updateOrgType','ajaxpage/updateajax.php','isset_update_org_type')">Update</a>
    <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
</div>