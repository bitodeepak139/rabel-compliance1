<?php if (session_status() === PHP_SESSION_NONE) {
    session_start();
}
require_once "../../classfile/initialize.php";
require_once "../../classfile/compliance_certificate_management.php";

$id = $_POST['id'];

// fetch Compliance Certificate Data
$result = $ccm_query->fetch_data($conn, "cpl_compliance_master as a left join usm_add_users as b on a.ins_by = b.pk_usm_user_id left join cpl_compliance_type as c on a.fk_cpl_compliancetype_id = c.pk_cpl_compliancetype_id left join sfa_ent_mst_entity as d on a.fk_sfa_ent_entity_id=d.pk_sfa_ent_entity_id left join usm_add_users as e on a.verified_by=e.pk_usm_user_id left join cnf_mst_zone as f on d.zone_id=f.pk_cnf_zone_id", "a.*,b.user_name,c.compliance_name,d.entity_name,d.fk_sfa_cnf_entitytype_id,e.user_name as user_verified_by,f.zone_name", "a.pk_cpl_compliance_id='$id' and a.transaction_status='1'");

$e = $result[0];
?>

<div class="modal-body">
    <div class="row">
        <div class="col-12">
        <form method="post" enctype="multipart/form-data" id="updateComplianceDetails">
                                    <div class="form-group row">
                                        <label for="example-text-input" class="col-md-3 col-form-label">SELECT
                                            ESTABLISHMENT TYPE <span class='text-danger'>*</span></label>
                                        <div class="col-md-3">
                                            <select name="establishmentType"
                                                onchange="DependantDropDown('entityType', 'entity_name','ajaxpage/get_data_ajax.php', 'isset_dependent_entityType')"
                                                id="entityType" class="form-control js-example-basic-single" disabled>
                                                <option selected="selected" value="">Select Entity</option>
                                                <?php $fetch_data = $ccm_query->fetch_data($conn, "sfa_cnf_mst_entity_type", "*", "transaction_status='1'");
if ($fetch_data != 0) {
    foreach ($fetch_data as $row) {
        if ($row['pk_sfa_cnf_entitytype_id'] == $e['fk_sfa_cnf_entitytype_id']) {
            echo "<option value='$row[pk_sfa_cnf_entitytype_id]' selected>$row[type_name]</option>";
        } else {
            echo "<option value='$row[pk_sfa_cnf_entitytype_id]'>$row[type_name]</option>";
        }

    }
}
?>
                                            </select>
                                        </div>
                                        <label for="example-text-input" class="col-md-3 col-form-label">SELECT
                                            ESTABLISHMENT <span class='text-danger'>*</span></label>
                                        <div class="col-md-3">
                                            <select name="establishment" id="entity_name"
                                                onchange="DependantDropDown('entity_name', 'certificate_type','ajaxpage/get_data_ajax.php', 'isset_dependent_certificate_type')"
                                                class="form-control js-example-basic-single" disabled>
                                                <?php
if ($_SESSION['user_id'] == 'USM-U1') {
    $entityData = $ccm_query->fetch_data($conn, "sfa_ent_mst_entity", "*", "fk_sfa_cnf_entitytype_id='KIT' and transaction_status='1'");
} else {
    // get the level of user
    $userLevel = $ccm_query->fetch_data($conn, "usm_add_users", "user_level", "pk_usm_user_id='$_SESSION[user_id]'");

    $condition = "pk_sfa_ent_entity_id IN (SELECT kitchen_id FROM cpl_define_kitchen_rights WHERE ";
    if ($userLevel[0]['user_level'] == 'L1') {
        $condition .= "l1_user='$_SESSION[user_id]' AND transaction_status='1')";
    }
    if ($userLevel[0]['user_level'] == 'L2') {
        $condition .= "l2_user='$_SESSION[user_id]' AND transaction_status='1')";
    }
    if ($userLevel[0]['user_level'] == 'L3') {
        $condition .= "l3_user='$_SESSION[user_id]' AND transaction_status='1')";
    }
    if ($userLevel[0]['user_level'] == 'L4') {
        $condition .= "l4_user='$_SESSION[user_id]' AND transaction_status='1')";
    }

    $entityData = $ccm_query->fetch_data($conn, "sfa_ent_mst_entity", "*", $condition);
}

echo "<option value=''>Select Entity</option>";
if ($entityData != 0) {
    foreach ($entityData as $row) {
        if ($row['pk_sfa_ent_entity_id'] == $e['fk_sfa_ent_entity_id']) {
            echo "<option value='$row[pk_sfa_ent_entity_id]' selected>$row[entity_name]</option>";
        } else {
            echo "<option value='$row[pk_sfa_ent_entity_id]-$row[entity_name]'>$row[entity_name] ($row[pk_sfa_ent_entity_id])</option>";
        }
    }
} else {
    echo "<option value=''>No Entity Added in this Entity Type</option>";
}
?>
                                            </select>

                                        </div>
                                    </div>
                                    <div class="form-group row">
                                        <label for="example-text-input" class="col-md-3 col-form-label">SELECT
                                            CERTIFICATE
                                            <span class='text-danger'>*</span></label>
                                        <div class="col-md-3">
                                            <select class="form-select form-control form-select-lg js-example-basic-single"
                                                name="certificate_type" id="certificate_type">
                                                <?php
$certificateType = $ccm_query->fetch_data($conn, "cpl_establishment_compliance as a left join cpl_compliance_type as b on a.fk_cpl_compliancetype_id=b.pk_cpl_compliancetype_id", "a.*,b.compliance_name", "a.fk_sfa_ent_entity_id='$e[fk_sfa_ent_entity_id]' and a.transaction_status='1' and b.compliance_type='Compliance'");
if ($certificateType != 0) {
    foreach ($certificateType as $row1) {
        if ($row1['fk_cpl_compliancetype_id'] == $e['fk_cpl_compliancetype_id']) {
            echo "<option value='$row1[fk_cpl_compliancetype_id]' selected>$row1[compliance_name]</option>";
        } else {
            echo "<option value='$row1[fk_cpl_compliancetype_id]'>$row1[compliance_name]</option>";
        }
    }
}
?>
                                            </select>
                                        </div>
                                        <label for="example-text-input" class="col-md-3 col-form-label">CERTIFICATE DATE
                                            <span class='text-danger'>*</span></label>
                                        <div class="col-md-3">
                                            <input type="text" name="certificate_date" class='form-control datepicker'
                                                autocomplete='off' value="<?=$e['certification_date']?>">
                                        </div>
                                    </div>
                                    <div class="form-group row">

                                        <label for="example-text-input" class="col-md-3 col-form-label">CERTIFICATE
                                            ORGANIZATION
                                            <span class='text-danger'>*</span></label>
                                        <div class="col-md-3">
                                            <select class="form-select form-control form-select-lg js-example-basic-single"
                                                name="certificate_organization" id="">
                                                <option value="">-Select-</option>
                                                <?php
$fetch_org = $ccm_query->fetch_data($conn, "sfa_ent_mst_entity", "*", "fk_sfa_cnf_entitytype_id='ORG'");
if ($fetch_org != 0) {
    foreach ($fetch_org as $row_org) {
        if ($row_org['pk_sfa_ent_entity_id'] == $e['certification_organization']) {
            echo "<option value='$row_org[pk_sfa_ent_entity_id]' selected>$row_org[entity_name] ($row_org[pk_sfa_ent_entity_id])</option>";
        } else {
            echo "<option value='$row_org[pk_sfa_ent_entity_id]'>$row_org[entity_name] ($row_org[pk_sfa_ent_entity_id])</option>";
        }
    }
}
?>
                                            </select>
                                        </div>

                                        <label for="example-text-input" class="col-md-3 col-form-label">CERTIFICATE
                                            VENDOR <span class='text-danger'>*</span></label>
                                        <div class="col-md-3">
                                            <select class="form-select form-control form-select-lg js-example-basic-single"
                                                name="certificate_vendor" id="">
                                                <option value="">-Select-</option>
                                                <?php
$fetch_vendor = $ccm_query->fetch_data($conn, "sfa_ent_mst_entity", "*", "fk_sfa_cnf_entitytype_id='SUP' Order by `entity_name` ASC");
if ($fetch_vendor != 0) {
    foreach ($fetch_vendor as $row_vendor) {
        if ($row_vendor['pk_sfa_ent_entity_id'] == $e['certification_vendor']) {
            echo "<option value='$row_vendor[pk_sfa_ent_entity_id]' selected>$row_vendor[entity_name] ($row_vendor[pk_sfa_ent_entity_id])</option>";
        } else {
            echo "<option value='$row_vendor[pk_sfa_ent_entity_id]'>$row_vendor[entity_name] ($row_vendor[pk_sfa_ent_entity_id])</option>";
        }
    }
}
?>
                                            </select>
                                        </div>
                                    </div>
                                    <div class="form-group row">
                                        <label for="example-text-input" class="col-md-3 col-form-label">CONSULT BY
                                            NAME</label>
                                        <div class="col-md-3">
                                            <input type="text" name="consult_name" class='form-control'
                                                autocomplete='off' value="<?=$e['constant_name']?>">
                                        </div>
                                        <label for="example-text-input" class="col-md-3 col-form-label">CONSULT BY
                                            MOBILE</label>
                                        <div class="col-md-3">
                                            <input type="text" name="consult_mobile" id="consult_mobile"
                                                class='form-control' autocomplete='off'
                                                onkeyup="inputWithNumber('consult_mobile')" value="<?=$e['consutant_mobile_no']?>">
                                        </div>
                                    </div>
                                    <div class="form-group row">
                                        <label for="example-text-input" class="col-md-3 col-form-label">CERTIFICATE
                                            NO <span class='text-danger'>*</span></label>
                                        <div class="col-md-3">
                                            <input type="text" name="certificate_no" class='form-control'
                                                autocomplete='off' value="<?=$e['certificate_no']?>">
                                        </div>
                                        <label for="example-text-input" class="col-md-3 col-form-label">CERTIFICATE
                                            EXPIRY DATE
                                            <span class='text-danger'>*</span></label>
                                        <div class="col-md-3">
                                            <input type="text" name="certificate_expire_date"
                                                class='form-control datepicker' autocomplete='off' value="<?=$e['expiry_date']?>">
                                        </div>
                                    </div>

                                    <div class="form-group row">
                                        <label for="licensceNominee" class="col-md-3 col-form-label">Licence Nominee<span class='text-danger'>*</span></label>
                                        <div class="col-md-9">
                                            <input type="text" name="licenceNominee" class='form-control'
                                                autocomplete='off' value="<?=$e['licence_nominee']?>">
                                        </div>
                                    </div>

                                    <div class="form-group row">
                                        <label for="example-text-input" class="col-md-3 col-form-label">UPLOAD
                                            CERTIFICATE <a href="../upload/certificate/<?=$e['certificate_file']?>" target='_blank' class='text-danger'>(View)</a> <span class='text-danger'>*</span></label>
                                        <div class="col-md-3">
                                            <input type="file" name="ceritificate_upload" class='form-control'>
                                        </div>
                                        <label for="example-text-input" class="col-md-3 col-form-label">NEXT YEAR
                                            RENEWAL BUDGET <span class='text-danger'>*</span></label>
                                        <div class="col-md-3">
                                            <input type="text" name="renewal_budget" id='renewal_budget' value="<?=$e['next_year_budget']?>"
                                                class='form-control' autocomplete='off'
                                                onkeyup="inputWithNumber('renewal_budget')">
                                        </div>
                                    </div>

                                    <div class="form-group row">
                                        <label for="example-text-input" class="col-sm-3 col-form-label">Enter
                                            Details</label>
                                        <div class="col-sm-9">
                                            <textarea id="certificate_remark" rows="2" class="form-control"
                                                name='compliance_details'><?=$e['certificate_remark']?></textarea>
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
        onClick="edit('<?php echo $id ?>','updateComplianceDetails','ajaxpage/updateajax.php','isset_update_compliance_details')">Submit</a>
    <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
</div>
<script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>
<script>
$(document).ready(function () {
  $(".js-example-basic-single").select2();
});
$(function () {
            $(".datepicker").datepicker({
                dateFormat: 'dd-mm-yy',
                changeMonth: true,
                changeYear: true,
            });
        });
</script>
