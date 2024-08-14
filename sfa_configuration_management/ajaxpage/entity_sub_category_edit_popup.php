<?php
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}
require_once "../../classfile/initialize.php";
require_once "../../classfile/sfa_configuration_management.php";
$id = $_POST['id'];
$retval = $sfa_query->fetch_data($conn, "sfa_cnf_mst_entity_subcategory a LEFT JOIN sfa_cnf_mst_entity_type as b ON a.fk_sfa_cnf_entitytype_id = b.pk_sfa_cnf_entitytype_id LEFT JOIN sfa_cnf_mst_entity_category as c ON a.fk_sfa_cnf_entcategory_id = c.pk_sfa_cnf_entcategory_id", "a.*,b.type_name,c.category_name", "a.id='$id'");
$entity_id = $retval[0]['fk_sfa_cnf_entitytype_id'];
$category_id = $retval[0]['fk_sfa_cnf_entcategory_id'];
$subcategory_name = $retval[0]['subcategory_name'];
$subcategory_details = $retval[0]['subcategory_details'];

?>
<div class="modal-body">
    <form method="post" enctype="multipart/form-data" id="updateEntitySubCategoryForm">
        <input type="hidden" name="hentity_id" value="<?php echo $entity_id ?>">
        <input type="hidden" name="hcategory_id" value="<?php echo $category_id ?>">
        <input type="hidden" name="hsubcategory_name" value="<?php echo $subcategory_name ?>">
        <div class="form-group row">
            <label for="example-text-input" class="col-sm-3 col-form-label">Select Entity Type<span
                    class='text-danger'>*</span></label>
            <div class='col-sm-9'>
                <select id="entity" class="form-control" name='entity_id'
                    onchange="DependantDropDown('entity','category','ajaxpage/get_category.php','isset_get_category_dropdown')">
                    <option value="">Select Entity</option>
                    <?php
                    $retval = $sfa_query->fetch_data($conn, "sfa_cnf_mst_entity_type", "*", "1");
                    foreach ($retval as $row) {
                        $eid = $row['pk_sfa_cnf_entitytype_id'];
                        $type_name = $row['type_name'];
                        ?>
                        <option value="<?php echo $eid ?>" <?php if ($eid == $entity_id)
                               echo "selected" ?>>
                            <?php echo $type_name ?>
                        </option>
                    <?php } ?>
                </select>
            </div>

        </div>
        <div class="form-group row">
            <label for="example-text-input" class="col-sm-3 col-form-label">Select Category<span
                    class='text-danger'>*</span></label>
            <div class='col-sm-9'>
                <select id="category" class="form-control" name='category_id'>
                    <?php $retval = $sfa_query->fetch_data($conn, "sfa_cnf_mst_entity_category", "*", "fk_sfa_cnf_entitytype_id='$entity_id'");
                    foreach ($retval as $row) {
                        if ($row["pk_sfa_cnf_entcategory_id"] == $category_id)
                            echo "<option value='$row[pk_sfa_cnf_entcategory_id]' selected>$row[category_name]</option>";
                        else
                            echo "<option value='$row[pk_sfa_cnf_entcategory_id]'>$row[category_name]</option>";
                    }
                    ?>
                </select>
            </div>

        </div>
        <div class="form-group row">
            <label for="example-text-input" class="col-sm-3 col-form-label">Enter Sub Category<span
                    class='text-danger'>*</span></label>
            <div class="col-sm-9">
                <input type="text" name="sub_category_name" id="" value="<?php echo $subcategory_name ?>" class='form-control'>
            </div>
        </div>
        <div class="form-group row">
            <label for="example-text-input" class="col-sm-3 col-form-label">Sub Category Details</label>
            <div class="col-sm-9">
                <textarea id="address" rows="2" class="form-control" name='sub_category_details'><?php echo $subcategory_details ?></textarea>
            </div>
        </div>
    </form>
</div>
<div class="modal-footer"> <a href="javascript:void(0)" class="btn btn-primary"
        onClick="edit('<?php echo $id ?>','updateEntitySubCategoryForm','ajaxpage/updateajax.php','isset_update_entity_sub_category')">Update</a>
    <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
</div>