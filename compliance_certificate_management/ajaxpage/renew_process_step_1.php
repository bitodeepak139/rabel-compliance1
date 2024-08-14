<?php if (session_status() === PHP_SESSION_NONE) {
    session_start();
}
require_once "../../classfile/initialize.php";
require_once "../../classfile/compliance_certificate_management.php";

$id = $_POST['id'];
$result = $ccm_query->fetch_data($conn, 'cpl_compliance_master', '*', "pk_cpl_compliance_id='$id'");

$compliance = $ccm_query->fetch_data($conn, "cpl_compliance_master as a left join usm_add_users as b on a.ins_by = b.pk_usm_user_id left join cpl_compliance_type as c on a.fk_cpl_compliancetype_id = c.pk_cpl_compliancetype_id left join sfa_ent_mst_entity as d on a.fk_sfa_ent_entity_id=d.pk_sfa_ent_entity_id left join usm_add_users as e on a.verified_by=e.pk_usm_user_id left join cnf_mst_zone as f on d.zone_id=f.pk_cnf_zone_id left join sfa_cnf_mst_entity_type as g on d.fk_sfa_cnf_entitytype_id=g.pk_sfa_cnf_entitytype_id", "a.*,b.user_name,c.compliance_name,d.entity_name,e.user_name as user_verified_by,f.zone_name,g.type_name", "a.pk_cpl_compliance_id='$id'");
// $ccm_query->debug($result);
// $ccm_query->debug($compliance);
$cc = $compliance[0];
?>

<div class="modal-body" style='max-height:400px;overflow-y:auto;'>
    <div class="row">
        <div class="col-12">
            <form method="post" enctype="multipart/form-data" id="addRenewalComplianceCertificateStep1">
                <!-- hiddent fields -->
                <input type="hidden" name="entity_type_id" value="<?php echo $cc['fk_sfa_ent_entity_id']; ?>">
                <input type="hidden" name="compliance_type_id" value="<?php echo $cc['fk_cpl_compliancetype_id'] ?>">
                <input type="hidden" name="pk_compliance" value="<?php echo $cc['pk_cpl_compliance_id'] ?>">
                <!-- hiddent fields -->
                <div class="form-group row">

                    <!-- <label for="" class="example-text-input" class='col-md-3 col-form-label'>Establishment Name</label> -->
                </div>
                <div class="form-group row">
                    <label for="example-text-input" class="col-md-3 col-form-label">Establishment Name</label>
                    <div class="col-md-3">
                        <p>
                            <?php echo $cc['entity_name']; ?>
                        </p>
                    </div>
                    <label for="example-text-input" class="col-md-3 col-form-label">Establishment Type</label>
                    <div class="col-md-3">
                        <p>
                            <?php echo $cc['type_name']; ?>
                        </p>
                    </div>
                    <label for="example-text-input" class="col-md-3 col-form-label">Certificate Type</label>
                    <div class="col-md-3">
                        <p>
                            <?php echo $cc['compliance_name']; ?>
                        </p>
                    </div>
                    <label for="example-text-input" class="col-md-3 col-form-label">Certificate No</label>
                    <div class="col-md-3">
                        <input type="hidden" name="certificate_no" value="<?= $cc['certificate_no'] ?>">
                        <p>
                            <?php echo $cc['certificate_no']; ?>
                        </p>
                    </div>
                    <label for="example-text-input" class="col-md-3 col-form-label">CERTIFICATE RENEWAL DUE DATE</label>
                    <div class="col-md-3">
                        <p>
                            <?php echo $cc['renew_due_date_l1']; ?>
                        </p>
                    </div>
                    <label for="example-text-input" class="col-md-3 col-form-label">CERTIFICATE EXPIRY DATE</label>
                    <div class="col-md-3">
                        <p>
                            <?php echo $cc['expiry_date']; ?>
                        </p>
                    </div>
                    <label for="example-text-input" class="col-md-3 col-form-label">ALLOTTED BUDGET FOR RENEWAL</label>
                    <div class="col-md-3">
                        <p>
                            <?php echo $cc['next_year_budget']; ?>
                        </p>
                    </div>
                    <label for="example-text-input" class="col-md-3 col-form-label">APPLICATION DATE<span
                            class='text-danger'>*</span></label>
                    <div class="col-md-3">
                        <input type="date" name='application_date' id='application_date' class="form-control datepicker"
                            min="<?php echo date('d-m-Y', strtotime($cc['expiry_date'])); ?>" autocomplete="off">
                    </div>

                </div>
                <div class="form-group row">
                    <label for="example-text-input" class="col-md-3 col-form-label">APPLICATION REFERENCE NO <span
                            class='text-danger'>*</span></label>
                    <div class="col-md-3">
                        <input type="text" name='application_reference_no' class="form-control" autocomplete="off">
                    </div>
                    <label for="example-text-input" class="col-md-3 col-form-label">APPLICATION FORM UPLOAD <span
                            class='text-danger'>*</span></label>
                    <div class="col-md-3">
                        <input type="file" name="application_form" class="form-control" id="">
                    </div>
                </div>
                <div class="form-group row">
                    <label for="example-text-input" class="col-md-3 col-form-label">APPLICATION BY <span
                            class='text-danger'>*</span></label>
                    <div class="col-md-3">
                        <input type="text" name="application_by" id="" class='form-control'>
                    </div>
                    <label for="example-text-input" class="col-md-3 col-form-label">CERTIFICATION ORGANIZATION <span
                            class='text-danger'>*</span></label>
                    <div class="col-md-3">
                        <select class="form-select form-control form-select-lg" name="certificate_organization" id="">
                            <option value="">-Select-</option>
                            <?php
$fetch_org = $ccm_query->fetch_data($conn, "sfa_ent_mst_entity", "*", "fk_sfa_cnf_entitytype_id='ORG'");
if ($fetch_org != 0) {
    foreach ($fetch_org as $row_org) {
        echo "<option value='$row_org[pk_sfa_ent_entity_id]'>$row_org[entity_name] ($row_org[pk_sfa_ent_entity_id])</option>";
    }
}
?>
                        </select>
                    </div>
                </div>
                <div class="form-group row">
                    <label for="example-text-input" class="col-md-3 col-form-label">VENDOR COMPANY</label>
                    <div class="col-md-3">
                        <select class="form-select form-control form-select-lg" name="certificate_vendor" id="">
                            <option value="">-Select-</option>
                            <?php
$fetch_vendor = $ccm_query->fetch_data($conn, "sfa_ent_mst_entity", "*", "fk_sfa_cnf_entitytype_id='SUP' Order by `entity_name` ASC");
if ($fetch_vendor != 0) {
    foreach ($fetch_vendor as $row_vendor) {
        echo "<option value='$row_vendor[pk_sfa_ent_entity_id]'>$row_vendor[entity_name] ($row_vendor[pk_sfa_ent_entity_id])</option>";
    }
}
// $ccm_query->debug($fetch_vendor);
?>
                        </select>
                    </div>
                    <label for="example-text-input" class="col-md-3 col-form-label">CONSULTANT NAME</label>
                    <div class="col-md-3">
                        <input type="text" name="consultant_name" id="" class='form-control'>
                    </div>
                </div>
                <div class="form-group row">
                    <label for="example-text-input" class="col-md-3 col-form-label">CONSULTANT MOBILE NO
                    </label>
                    <div class="col-md-3">
                        <input type="text" name="consultant_mobile" id="consultant_mobile" class='form-control'
                            onkeyup="inputWithNumber('consultant_mobile')">
                    </div>
                    <label for="example-text-input" class="col-md-3 col-form-label">CERTIFICATE FEE DEPOSITED <span
                            class='text-danger'>*</span></label>
                    <div class="col-md-3">
                        <input type="text" name="fee_deposited" id="fee_deposited" class='form-control'
                            onkeyup="inputWithNumber('fee_deposited'),calculateTotalAmount('fee_deposited','conveyance_fee')">
                    </div>
                </div>
                <div class="form-group row">
                    <label for="example-text-input" class="col-md-3 col-form-label">CONVEYANCE FEE<span
                            class='text-danger'>*</span></label>
                    <div class="col-md-3">
                        <input type="text" name="conveyance_fee" id="conveyance_fee" class='form-control'
                            onkeyup="inputWithNumber('conveyance_fee'),calculateTotalAmount('fee_deposited','conveyance_fee')">
                    </div>
                    <label for="example-text-input" class="col-md-3 col-form-label">TOTAL AMOUNT</label>
                    <div class="col-md-3">
                        <input type="text" name="total_amount" id="total_amount" class='form-control' readonly>
                    </div>
                </div>
                <div class="form-group row">
                    <label for="example-text-input" class="col-md-3 col-form-label">ESTIMATE DATE FOR
                        CONFIRMATION</label>
                    <div class="col-md-3">
                        <input type="date" name='estimate_date'
                            min="<?php echo date('d-m-Y', strtotime($cc['expiry_date'])); ?>"
                            class="form-control datepicker" autocomplete="off" onkeyup="keyborordEvent(event)">
                    </div>
                    <label for="example-text-input" class="col-md-3 col-form-label">Licence Nominee</label>
                    <div class="col-md-3">
                        <input type="text" name="licence_nominee" id="licence_nominee" class='form-control'>
                    </div>
                   
                </div>
                <div class="form-group row">
                <label for="example-text-input" class="col-md-3 col-form-label">Enter Details</label>
                    <div class="col-md-9">
                        <textarea id="category_details" rows="2" class="form-control" name='remark'></textarea>
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
        onClick="adddata('addRenewalComplianceCertificateStep1','ajaxpage/addDataajax.php','isset_addRenewalComplianceCertificateStep1')">Submit</a>
    <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
</div>