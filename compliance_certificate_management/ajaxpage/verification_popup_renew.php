<?php if (session_status() === PHP_SESSION_NONE) {
    session_start();
}
require_once "../../classfile/initialize.php";
require_once "../../classfile/compliance_certificate_management.php";?>

<div class="modal-body">
  <div class="row">
  <?php $data =  $ccm_query->fetch_data($conn,"cpl_compliance_renewal_step2 as a left join cpl_compliance_renewal_attempts as b on a.fk_cpl_complianceattempt_id=b.pk_cpl_complianceattempt_id left join sfa_ent_mst_entity as c on a.fk_sfa_ent_entity_id=c.pk_sfa_ent_entity_id left join cpl_compliance_type as d on b.fk_cpl_compliancetype_id=d.pk_cpl_compliancetype_id left join usm_add_users as e on a.ins_by=e.pk_usm_user_id","a.*,b.application_by,c.entity_name,d.compliance_name,e.user_name","a.id='$_POST[id]' and a.verification_status='1'");
if ($data != 0) {
    $data = $data[0];

    ?>
    <div class="col-6">
        <p>Verified By - <?=$data['user_name']?></p>
        <p>Verification Date - <?=$data['verification_date']?></p>
    </div>
    <div class="col-6">
        <p>Remark - <?=$data['verification_cause']?></p>
    </div>
    <?php
} else {
    echo "No Data Found";
}
?>
    <!-- /.col -->
  </div>
  <!-- /.row -->
</div>
<div class="modal-footer">
  <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
</div>
