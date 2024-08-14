<?php if (session_status() === PHP_SESSION_NONE) {
    session_start();
}
require_once "../../classfile/initialize.php";
require_once "../../classfile/sfa_configuration_management.php"; ?>

<div class="modal-body">
    <div class="row">
        <div class="col-12">
            <form method="post" enctype="multipart/form-data" id="addEntityCategoryForm">
                <div class="form-group row">
                    <label for="example-text-input" class="col-sm-3 col-form-label">Select Entity<span
                            class='text-danger'>*</span></label>

                    <div class='col-sm-9'>
                        <select id="country" class="form-control" name='entity_type'>
                            <option value="">Select Entity</option>
                            <?php
                            $retval = $sfa_query->fetch_data($conn, "sfa_cnf_mst_entity_type", "*", "transaction_status='1'");
                            foreach ($retval as $row) {
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
                        <input type="text" name="category_name" id="" class='form-control'>
                    </div>
                </div>
                <div class="form-group row">
                    <label for="example-text-input" class="col-sm-3 col-form-label">Category Details</label>
                    <div class="col-sm-9">
                        <textarea id="category_details" rows="2" class="form-control" name='category_details'></textarea>
                    </div>
                </div>
            </form>
        </div>
        <!-- /.col -->
    </div>
    <!-- /.row -->
</div>
<!-- adddata(formId, url, isset_var) -->
<div class="modal-footer"> <a href="javascript:void(0)" class="btn btn-primary" onClick="adddata('addEntityCategoryForm','ajaxpage/addDataAjax.php','isset_add_entity_category')">Submit</a>
    <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
</div>