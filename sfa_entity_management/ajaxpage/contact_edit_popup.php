<?php
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}
require_once "../../classfile/initialize.php";
require_once "../../classfile/sfa_entity_management.php";

$stringMix = $_POST['id'];
$data1 = explode('-',$stringMix);
$id = $data1[0];
$data = $data1[1];
$selected_id = '';
if($data == 'All'){
    $selected_id = "#check1";
}
$sn = 2;
for($column="A"; $column != "AA"; $column++){
    if($data == $column){
        $selected_id = '#check'.$sn;
    }
    $sn++;
}


$contactDetails = $sfa_ent->fetch_data($conn, "sfa_ent_mst_contact_master as a INNER JOIN sfa_ent_mst_entity as b ON a.fk_sfa_ent_entity_id=b.pk_sfa_ent_entity_id", "a.*,b.entity_name", "pk_sfa_ent_contact_id='$id'");

$row = $contactDetails[0];
$name = $row['contact_name'];
$designation = $row['designation'];
$mobile1 = $row['mobile1'];
$mobile2 = $row['mobile2'];
$landline = $row['landline'];
$email = $row['email'];
$contact_dob = $row['contact_dob'];
$contact_dom = $row['contact_dom'];
$contact_remark = $row['contact_remark'];
$org = $row['entity_name'];
?>
<!-- edit(id, formId, url, isset_var) -->
<form id='update_ContactEntity'  method="post">
<div class="modal-body">
    <div class="form-group row">
        <label for="example-text-input" class="col-sm-3 col-form-label">Name <span class='text-danger'>*</span></label>
        <div class="col-sm-3">
            <input type="text" name="name" class="form-control" value="<?php echo $name ?>" autocomplete="off">
        </div>
        <label for="example-text-input" class="col-sm-3 col-form-label">Designation</label>
        <div class="col-sm-3">
            <input type="text" name="designation" class="form-control" value="<?php echo $designation ?>"
                autocomplete="off">
        </div>
    </div>
    <input type="hidden" name="selected_letter" value='<?php echo $data; ?>'>
    <input type="hidden" name="selected_id" value='<?php echo $selected_id; ?>'>
    <div class="form-group row">
        <label for="example-text-input" class="col-sm-3 col-form-label">Organisation</label>
        <div class="col-sm-3">
            <p>
                <?php echo $org; ?>
            </p>
        </div>
        <label for="example-text-input" class="col-sm-3 col-form-label">Mobile No<span class='text-danger'>*</span></label>
        <div class="col-sm-3">
            <input type="text" name="mobile1" class="form-control" value="<?php echo $mobile1; ?>" autocomplete="off">
        </div>
    </div>
    <div class="form-group row">
        <label for="example-text-input" class="col-sm-3 col-form-label">Alternate No</label>
        <div class="col-sm-3">
            <input type="text" name="mobile2" class="form-control" value="<?php echo $mobile2; ?>" autocomplete="off">
        </div>
        <label for="example-text-input" class="col-sm-3 col-form-label">Landline</label>
        <div class="col-sm-3">
            <input type="text" name="landline" class="form-control" value="<?php echo $landline; ?>" autocomplete="off">
        </div>
    </div>
    <div class="form-group row">
        <label for="example-text-input" class="col-sm-3 col-form-label">Email ID<span class='text-danger'>*</span></label>
        <div class="col-sm-3">
            <input type="text" name="email" class="form-control" value="<?php echo $email; ?>" autocomplete="off">
        </div>
        <label for="example-text-input" class="col-sm-3 col-form-label">DOB</label>
        <div class="col-sm-3">
            <input type="text" name="contact_dob" class="form-control datepicker" value="<?php echo $contact_dob ?>"
                autocomplete="off">
        </div>
    </div>
    <div class="form-group row">
        <label for="example-text-input" class="col-sm-3 col-form-label">DOM</label>
        <div class="col-sm-9">
            <input type="text" name="contact_dom" class="form-control datepicker" value="<?php echo $contact_dom ?>"
                autocomplete="off">
        </div>
    </div>
    <div class="form-group row">
        <label for="example-text-input" class="col-sm-3 col-form-label">Remark</label>
        <div class="col-sm-9">
            <textarea class="form-control" name="contact_remark" id=""
                rows="3"><?php echo $contact_remark; ?></textarea>
        </div>
    </div>
</div>
</form>
<div class="modal-footer">
    <a href="javascript:void(0)" class="btn btn-primary" onclick="ContactEdit('<?php echo $id ?>','update_ContactEntity','ajaxpage/updateajax.php','isset_update_ContactEntity')">Update</a>
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