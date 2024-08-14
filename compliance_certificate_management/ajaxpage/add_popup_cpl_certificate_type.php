<?php if (session_status() === PHP_SESSION_NONE) {
    session_start();
}
require_once "../../classfile/initialize.php";
require_once "../../classfile/compliance_certificate_management.php";?>

<div class="modal-body">
    <div class="row">
        <div class="col-12">
            <form method="post" enctype="multipart/form-data" id="addComplianceCertificateType">
                <div class="form-group row">
                    <label for="example-text-input" class="col-md-3 col-form-label">ENTER COMPLIANCE NAME <span
                            class='text-danger'>*</span></label>
                    <div class="col-md-3">
                        <input type="text" name="compliance_name" id="" class='form-control'>
                    </div>
                    <label for="example-text-input" class="col-md-3 col-form-label">SELECT COMPLIANCE TYPE<span class='text-danger'>*</span></label>
                    <div class="col-md-3">
                        <select class="form-select form-control form-select-lg" name="compliance_type" id="">
                            <option value="">Select Compliance Type</option>
                            <option value="Compliance">Compliance</option>
                            <option value="Rent">Rent</option>
                        </select>
                    </div>
                
                </div>
                <div class="form-group row">
                <label for="example-text-input" class="col-md-3 col-form-label">SELECT TYPE OF RENEWAL <span
                            class='text-danger'>*</span></label>
                    <div class="col-md-3">
                        <select class="form-select form-control form-select-lg" name="renewal_type" id="">
                            <option value="">Select Renewal Type</option>
                            <option value="One Time">One Time</option>
                            <option value="Renewal">Renewal</option>
                        </select>
                    </div>
                    <label for="example-text-input" class="col-md-3 col-form-label">L1 Alert Day <span
                            class='text-danger'>*</span></label>
                    <div class="col-md-3">
                        <input type="number" name="l1_alert_day" id="" class='form-control'>
                    </div>
                  
                </div>
                <div class="form-group row">
                <label for="example-text-input" class="col-md-3 col-form-label">L2 Alert Day <span
                            class='text-danger'>*</span></label>
                    <div class="col-md-3">
                        <input type="number" name="l2_alert_day" id="" class='form-control'>
                    </div>
                    <label for="example-text-input" class="col-md-3 col-form-label">L3 Alert Day <span
                            class='text-danger'>*</span></label>
                    <div class="col-md-3">
                        <input type="number" name="l3_alert_day" id="" class='form-control'>
                    </div>
                   
                </div>

                <div class="form-group row">
                <label for="example-text-input" class="col-md-3 col-form-label">L4 Alert Day <span
                            class='text-danger'>*</span></label>
                    <div class="col-md-3">
                        <input type="number" name="l4_alert_day" id="" class='form-control'>
                    </div>
                    <label for="example-text-input" class="col-sm-3 col-form-label">Enter Details</label>
                    <div class="col-sm-3">
                        <textarea id="category_details" rows="2" class="form-control"
                            name='compliance_details'></textarea>
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
        onClick="adddata('addComplianceCertificateType','ajaxpage/addDataajax.php','isset_add_compliance_certificate_type')">Submit</a>
    <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
</div>
