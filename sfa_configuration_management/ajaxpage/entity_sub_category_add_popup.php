<?php if (session_status() === PHP_SESSION_NONE) {
    session_start();
}
require_once "../../classfile/initialize.php";
require_once "../../classfile/sfa_configuration_management.php"; ?>

<div class="modal-body">
    <div class="row">
        <div class="col-12">
            <form method="post" enctype="multipart/form-data" id="addEntitySubCategoryForm">
                <div class="form-group row">
                    <label for="example-text-input" class="col-sm-3 col-form-label">Select Entity Type<span
                            class='text-danger'>*</span></label>
                    <div class='col-sm-9'>
                        <select id="entity" class="form-control" name='entity_id'
                            onchange="DependantDropDown('entity','category','ajaxpage/get_category.php','isset_get_category_dropdown')">
                            <option value="">Select Entity</option>
                            <?php 
                            $retval = $sfa_query->fetch_data($conn,"sfa_cnf_mst_entity_type","*","1");
                            foreach ($retval as $row) {
                                $id = $row['pk_sfa_cnf_entitytype_id'];
                                $type_name = $row['type_name'];
                                ?>
                                <option value="<?php echo $id ?>">
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
                            <option value="">Select Category</option>
                        </select>
                    </div>

                </div>
                <div class="form-group row">
                    <label for="example-text-input" class="col-sm-3 col-form-label">Enter Sub Category<span
                            class='text-danger'>*</span></label>
                    <div class="col-sm-9">
                        <input type="text" name="sub_category_name" id="" class='form-control'>
                    </div>
                </div>
                <div class="form-group row">
                    <label for="example-text-input" class="col-sm-3 col-form-label">Sub Category Details</label>
                    <div class="col-sm-9">
                        <textarea id="address" rows="2" class="form-control" name='sub_category_details'></textarea>
                    </div>
                </div>
            </form>
        </div>
        <!-- /.col -->
    </div>
    <!-- /.row -->
</div>
<div class="modal-footer"> <a href="javascript:void(0)" class="btn btn-primary" onClick="adddata('addEntitySubCategoryForm','ajaxpage/addDataAjax.php','isset_add_entity_sub_category')">Submit</a>
    <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
</div>