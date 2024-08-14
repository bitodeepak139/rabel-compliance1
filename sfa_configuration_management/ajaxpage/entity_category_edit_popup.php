<?php
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}
require_once "../../classfile/initialize.php";
require_once "../../classfile/sfa_configuration_management.php";
$id = $_POST['id'];
$entityCategory = $sfa_query->fetch_data($conn, "sfa_cnf_mst_entity_category a LEFT JOIN sfa_cnf_mst_entity_type as b ON a.fk_sfa_cnf_entitytype_id = b.pk_sfa_cnf_entitytype_id", "a.*,b.type_name", "a.id='$id'");
$entityCategory = $entityCategory[0];
?>
<div class="modal-body">
    <form method="post" enctype="multipart/form-data" id="updateEntityCategoryForm">
        <input type="hidden" name="hentity_type" value='<?php echo $entityCategory['fk_sfa_cnf_entitytype_id'] ?>'>
        <input type="hidden" name="hcategory_name" value="<?php echo $entityCategory['category_name'] ?>">
        <input type="hidden" name="hcategory_details" value="<?php echo $entityCategory['category_details'] ?>">
        <div class="form-group row">
            <label for="example-text-input" class="col-sm-3 col-form-label">Select Entity<span
                    class='text-danger'>*</span></label>

            <div class='col-sm-9'>
                <select id="country" class="form-control" name='entity_type'>
                    <option value="">Select Entity</option>
                    <?php
                    $retval = $sfa_query->fetch_data($conn, "sfa_cnf_mst_entity_type", "*", "transaction_status='1'");
                    foreach ($retval as $row) {
                        if ($entityCategory['fk_sfa_cnf_entitytype_id'] == $row["pk_sfa_cnf_entitytype_id"])
                            echo " <option value='$row[pk_sfa_cnf_entitytype_id]' selected>$row[type_name]</option>";
                        else
                            echo " <option value='$row[pk_sfa_cnf_entitytype_id]'>$row[type_name]</option>";
                    }
                    ?>

                </select>
            </div>
        </div>
        <div class="form-group row">
            <label for="example-text-input" class="col-sm-3 col-form-label">Enter Category Name<span
                    class='text-danger'>*</span></label>
            <div class="col-sm-9">
                <input type="text" name="category_name" id="" value="<?php echo $entityCategory['category_name'] ?>"
                    class='form-control'>
            </div>
        </div>
        <div class="form-group row">
            <label for="example-text-input" class="col-sm-3 col-form-label">Category Details</label>
            <div class="col-sm-9">
                <textarea id="category_details" rows="2" class="form-control"
                    name='category_details'><?php echo $entityCategory['category_details'] ?></textarea>
            </div>
        </div>
    </form>
</div>
<div class="modal-footer"> <a href="javascript:void(0)" class="btn btn-primary"
        onClick="edit('<?php echo $id ?>','updateEntityCategoryForm','ajaxpage/updateajax.php','isset_update_entity_category')">Update</a>
    <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
</div>