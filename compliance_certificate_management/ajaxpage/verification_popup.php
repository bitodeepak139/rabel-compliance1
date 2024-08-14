<?php if (session_status() === PHP_SESSION_NONE) {
    session_start();
}
require_once "../../classfile/initialize.php";
require_once "../../classfile/compliance_certificate_management.php";?>

<div class="modal-body">
  <div class="row">
  <?php $data = $ccm_query->fetch_data($conn, "cpl_compliance_master as a left join usm_add_users as b on a.verified_by = b.pk_usm_user_id left join cpl_compliance_type as c on a.fk_cpl_compliancetype_id = c.pk_cpl_compliancetype_id left join sfa_ent_mst_entity as d on a.fk_sfa_ent_entity_id=d.pk_sfa_ent_entity_id", "a.*,b.user_name,c.compliance_name,d.entity_name", "pk_cpl_compliance_id='$_POST[id]'");
if ($data != 0) {
    $data = $data[0];

    ?>
    <div class="col-6">
        <p>Verified By - <?=$data['user_name']?></p>
        <p>Verification Date - <?=$data['verification_date']?></p>
    </div>
    <div class="col-6">
        <p>Remark - <?=$data['verification_remark']?></p>
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
