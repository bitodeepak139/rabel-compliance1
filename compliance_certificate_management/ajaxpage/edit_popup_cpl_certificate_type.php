<?php if (session_status() === PHP_SESSION_NONE) {
    session_start();
}
require_once "../../classfile/initialize.php";
require_once "../../classfile/compliance_certificate_management.php";

$id = $_POST['id'];
$result = $ccm_query->fetch_data($conn, 'cpl_compliance_type', '*', "pk_cpl_compliancetype_id='$id'");
$complianceEdit = $result[0];
?>

<div class="modal-body">
    <div class="row">
        <div class="col-12">
            <form method="post" enctype="multipart/form-data" id="updateComplianceCertificateType">
                <!-- hiddent fields -->
                <input type="hidden" name="hcompliance_name" value='<?php echo $complianceEdit['compliance_name'] ?>'>
                <!-- hiddent fields -->
                <div class="form-group row">
                    <label for="example-text-input" class="col-md-3 col-form-label">ENTER COMPLIANCE NAME <span
                            class='text-danger'>*</span></label>
                    <div class="col-md-3">
                        <input type="text" name="compliance_name" id="" class='form-control'
                            value='<?php echo $complianceEdit['compliance_name'] ?>'>
                    </div>
                    <label for="example-text-input" class="col-md-3 col-form-label">SELECT COMPLIANCE TYPE<span class='text-danger'>*</span></label>
                    <div class="col-md-3">
                        <select class="form-select form-control form-select-lg" name="compliance_type" id="">
                            <option value="">Select Compliance Type</option>
                            <?php if ($complianceEdit['compliance_type'] == 'Compliance') {
                                echo '<option value="Compliance" selected>Compliance</option>';
                                echo '<option value="Rent">Rent</option>';
                            } else if($complianceEdit['compliance_type'] == 'Rent') {
                                echo '<option value="Compliance">Compliance</option>';
                                echo '<option value="Rent" selected>Rent</option>';
                            } ?>
                        </select>
                    </div>
                   
                </div>
                <div class="form-group row">
                <label for="example-text-input" class="col-md-3 col-form-label">SELECT TYPE OF RENEWAL <span
                            class='text-danger'>*</span></label>
                    <div class="col-md-3">
                        <select class="form-select form-control form-select-lg" name="renewal_type" id="">
                            <option value="">Select Renewal Type</option>
                            <?php if ($complianceEdit['renewal_type'] == 'One Time') {
                                echo '<option value="One Time" selected>One Time</option>';
                                echo '<option value="Renewal">Renewal</option>';
                            } else {
                                echo '<option value="One Time">One Time</option>';
                                echo '<option value="Renewal" selected>Renewal</option>';
                            } ?>
                        </select>
                    </div>
                    <label for="example-text-input" class="col-md-3 col-form-label">L1 Alert Day <span
                            class='text-danger'>*</span></label>
                    <div class="col-md-3">
                        <input type="text" name="l1_alert_day" id="" class='form-control' value='<?php echo $complianceEdit['L1Day'] ?>'>
                    </div>
                    
                </div>
                <div class="form-group row">
                <label for="example-text-input" class="col-md-3 col-form-label">L2 Alert Day <span
                            class='text-danger'>*</span></label>
                    <div class="col-md-3">
                        <input type="text" name="l2_alert_day" id="" class='form-control' value='<?php echo $complianceEdit['L2Day'] ?>'>
                    </div>
                    <label for="example-text-input" class="col-md-3 col-form-label">L3 Alert Day <span
                            class='text-danger'>*</span></label>
                    <div class="col-md-3">
                        <input type="text" name="l3_alert_day" id="" class='form-control' value='<?php echo $complianceEdit['L3Day'] ?>'>
                    </div>
                   
                </div>

                <div class="form-group row">
                <label for="example-text-input" class="col-md-3 col-form-label">L4 Alert Day <span
                            class='text-danger'>*</span></label>
                    <div class="col-md-3">
                        <input type="text" name="l4_alert_day" id="" class='form-control' value='<?php echo $complianceEdit['L4Day'] ?>'>
                    </div>
                    <label for="example-text-input" class="col-sm-3 col-form-label">Enter Details</label>
                    <div class="col-sm-3">
                        <textarea id="category_details" rows="2" class="form-control"
                            name='compliance_details'><?php echo $complianceEdit['compliance_details'] ?></textarea>
                    </div>
                </div>
            </form>
        </div>
        <!-- /.col -->
    </div>
    <!-- /.row -->
</div>
<!-- adddata(formId, url, isset_var) -->
<div class="modal-footer"> <a href="javascript:void(0)" class="btn btn-primary"
        onClick="edit('<?php echo $id ?>','updateComplianceCertificateType','ajaxpage/updateajax.php','isset_update_compliance_certificate_type')">Submit</a>
    <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
</div>