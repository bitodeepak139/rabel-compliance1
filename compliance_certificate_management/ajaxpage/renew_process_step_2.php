<?php if (session_status() === PHP_SESSION_NONE) {
    session_start();
}
require_once "../../classfile/initialize.php";
require_once "../../classfile/compliance_certificate_management.php";

$id = $_POST['id'];
$master_id = $_POST['master_id'];
$renewal_data = $ccm_query->fetch_data($conn, "cpl_compliance_renewal_attempts as a LEFT JOIN sfa_ent_mst_entity as b  on a.certification_organization=b.pk_sfa_ent_entity_id LEFT JOIN sfa_ent_mst_entity as c on a.certification_vendor=c.pk_sfa_ent_entity_id", "a.*,b.entity_name,c.entity_name as vendor", "a.pk_cpl_complianceattempt_id='$id'");
// $ccm_query->debug($renewal_data);
if ($renewal_data != 0) {
    $rd = $renewal_data[0];
}
?>
<div class="modal-body">
    <div class="row">
        <div class="col-12">
            <form method="post" enctype="multipart/form-data" id="add_compliance_renewal_certificate_step_2">
                <!-- Hidden fields -->
                <input type="hidden" name="compliance_renewal_id" value='<?php echo $rd["pk_cpl_complianceattempt_id"] ?>'>
                <input type="hidden" name="compliance_type_id" value='<?php echo $rd["fk_cpl_compliancetype_id"] ?>'>
                <input type="hidden" name='compliance_masterid' value="<?php echo $master_id; ?>">
                <input type="hidden" name='kitchen_id' value="<?php echo $rd['fk_sfa_ent_entity_id']; ?>">
                <!-- Hidden fields -->
                <div class="form-group row">
                    <label for="example-text-input" class="col-md-3 col-form-label">SELECT ACTION</label>
                    <div class="col-md-3">
                        <select class="form-select form-control form-select-lg" name="renewal_status"
                            id="renewal_status" onchange="renewal_status_form('renewal_status')">
                            <option value="">-Select-</option>
                            <option value="rejected">Rejected</option>
                            <option value="confirmed">Confirmed</option>
                        </select>
                    </div>
                </div>
                <div id="rejected_field" style='display:none;'>
                    <div class="form-group row">
                        <label for="example-text-input" class="col-md-3 col-form-label">Rejected Date<span
                                class='text-danger'>*</span></label>
                        <div class="col-md-3">
                            <input type="date" name="rejected_date" id="rejected_date" class='form-control'>
                        </div>
                        <label for="example-text-input" class="col-md-2 col-form-label">Rejection Remark<span
                                class='text-danger'>*</span></label>
                        <div class="col-md-4">
                            <textarea name="rejection_remark" class='form-control'></textarea>
                        </div>
                    </div>
                </div>
                <div id="confirmed_fields" style='display:none;'>
                    <div class="form-group row">
                        <label for="example-text-input" class="col-md-3 col-form-label">Certificate Date<span
                                class='text-danger'>*</span></label>
                        <div class="col-md-3">
                            <input type="date" name="certificate_date" id="certificate_date"
                                class='form-control'>
                        </div>
                        <label for="example-text-input" class="col-md-3 col-form-label">CERTIFICATE ORGANIZATION</label>
                        <div class="col-md-3">
                            <p>
                                <?php echo $rd['entity_name'] ?>
                            </p>
                        </div>
                    </div>
                    <div class="form-group row">
                        <label for="example-text-input" class="col-md-3 col-form-label">CERTIFICATION VENDOR</label>
                        <div class="col-md-3">
                            <p>
                                <?php echo $rd['vendor'] ?>
                            </p>
                        </div>
                        <label for="example-text-input" class="col-md-3 col-form-label">CONSULT BY NAME</label>
                        <div class="col-md-3">
                            <p>
                                <?php echo $rd['consultant_name'] ?>
                            </p>
                        </div>
                    </div>
                    <div class="form-group row">
                        <label for="example-text-input" class="col-md-3 col-form-label">CONSULT PER MOBILE NO</label>
                        <div class="col-md-3">
                            <p>
                                <?php echo $rd['consultant_mobile_no'] ?>
                            </p>
                        </div>
                        <label for="example-text-input" class="col-md-3 col-form-label">CERTIFICATE NO <span class='text-danger'>*</span></label>
                        <div class="col-md-3">
                            <input type="text" name="certificate_no" class="form-control" id="certificate_no">
                        </div>
                    </div>
                    <div class="form-group row">
                        <label for="example-text-input" class="col-md-3 col-form-label">CERTIFICATE EXPIRY  <span class='text-danger'>*</span></label>
                        <div class="col-md-3">
                            <input type="date" name='expiry_date' class="form-control " autocomplete="off">
                        </div>
                        <label for="example-text-input" class="col-md-3 col-form-label">UPLOAD CERTIFICATE <span class='text-danger'>*</span></label>
                        <div class="col-md-3">
                            <input type="file" name='ceritificate_upload' class="form-control" autocomplete="off">
                        </div>
                    </div>
                    <div class="form-group row">
                        <label for="certificate_fee_deposited" class="col-md-3 col-form-label">CERTIFICATE FEE DEPOSITED</label>
                        <div class="col-md-3">
                            <input type="text" name="certificate_fee_deposited" id="certificate_fee_deposited" class='form-control' value="<?= $rd['certification_cost'] ?>" readonly>
                        </div>
                        <label for="example-text-input" class="col-md-3 col-form-label">CONVEYANCE FEE</label>
                        <div class="col-md-3">
                            <input type="text" name="conveyance_fee" id="conveyance_fee" class='form-control' value="<?= $rd['convinience_fee'] ?>" readonly>
                        </div>
                    </div>
                    <div class="form-group row">
                        <label for="example-text-input" class="col-md-3 col-form-label">NEXT YEAR RENEWAL BUDGET <span class='text-danger'>*</span></label>
                        <div class="col-md-3">
                            <input type="text" name="renewal_budget" id="renewal_budget" class='form-control' value="<?php $total_renewal_budget = $rd['certification_cost'] + $rd['convinience_fee']; echo $total_renewal_budget;  ?>">
                        </div>
                        <label for="example-text-input" class="col-md-3 col-form-label">ENTER REMARK <span class='text-danger'>*</span></label>
                        <div class="col-md-3">
                            <textarea id="category_details" rows="2" class="form-control" name='remark'></textarea>
                        </div>
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
        onClick="adddata('add_compliance_renewal_certificate_step_2','ajaxpage/addDataajax.php','isset_addRenewalComplianceCertificateStep2')">Submit</a>
    <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
</div>
<script>
    $(function () {
        // console.log($('.datepicker'));
        $(".datepicker").datepicker({
            dateFormat: 'dd-mm-yy',
            changeMonth: true,
            changeYear: true,
        });
    });
</script>