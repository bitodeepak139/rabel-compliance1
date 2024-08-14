<?php
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}
require_once "../../classfile/initialize.php";
require_once "../../classfile/sfa_entity_management.php";

$entityID = $_POST['id'];

?>
<!-- edit(id, formId, url, isset_var) -->
<form id='update_ContactEntity' method="post">
    <div class="modal-body">
        <div class="form-group row">
            <label for="example-text-input" class="col-sm-3 col-form-label">Name <span
                    class='text-danger'>*</span></label>
            <div class="col-sm-9">
                <input type="text" name="name" class="form-control" autocomplete="off">
            </div>
        </div>
        <div class="form-group row">
            <label for="example-text-input" class="col-sm-3 col-form-label">Designation</label>
            <div class="col-sm-9">
                <input type="text" name="designation" class="form-control" autocomplete="off">
            </div>
        </div>
        <div class="form-group row">
            <label for="example-text-input" class="col-sm-3 col-form-label">Contact No<span
                    class='text-danger'>*</span></label>
            <div class="col-sm-9">
                <input type="text" name="contact_no" class="form-control" autocomplete="off">
            </div>
        </div>
        <div class="form-group row">
            <label for="example-text-input" class="col-sm-3 col-form-label">Contact No2</label>
            <div class="col-sm-9">
                <input type="text" name="contact_no2" class="form-control" autocomplete="off">
            </div>
        </div>
        <div class="form-group row">
            <label for="example-text-input" class="col-sm-3 col-form-label">Landline</label>
            <div class="col-sm-9">
                <input type="text" name="landline" class="form-control" autocomplete="off">
            </div>
        </div>
        <div class="form-group row">
            <label for="example-text-input" class="col-sm-3 col-form-label">Email<span
                    class='text-danger'>*</span></label>
            <div class="col-sm-9">
                <input type="email" name="email_id" class="form-control" autocomplete="off">
            </div>
        </div>
        <div class="form-group row">
            <label for="example-text-input" class="col-sm-3 col-form-label">Remark</label>
            <div class="col-sm-9">
                <textarea name="contact_remark" id="" class="form-control"></textarea>
            </div>
        </div>
        <input type="hidden" name="entityID" value='<?php echo $entityID; ?>'>
    </div>
</form>
<div class="modal-footer">
    <a href="javascript:void(0)" class="btn btn-primary"
        onclick="adddataSearchContact('update_ContactEntity','ajaxpage/addDataAjax.php', 'isset_addContactDetailsContactSearch', event)">Update</a>
    <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
</div>
<script>
    $(function () {
        $(".datepicker").datepicker({
            dateFormat: 'dd-mm-yy',
            changeMonth: true,
            changeYear: true,
        });
    });
</script>