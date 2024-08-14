<?php
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}
require_once "../../classfile/initialize.php";
require_once "../../classfile/rent_management.php";
$id = $_POST['id'];
$agreeMentData = $rent_query->fetch_data($conn, "cpl_rent_agreement_hst as a left join cpl_compliance_type as b on a.fk_cpl_compliancetype_id=b.pk_cpl_compliancetype_id left join sfa_ent_mst_entity as c on a.fk_sfa_ent_entity_id=c.pk_sfa_ent_entity_id left join sfa_cnf_mst_entity_type as d on c.fk_sfa_cnf_entitytype_id=d.pk_sfa_cnf_entitytype_id", "a.*,b.compliance_name,c.entity_name,d.type_name", "a.pk_cpl_renthstagreement_id='$id' and c.transaction_status=1 ");

?>

<div class="modal-body">
    <div class="row">
        <div class="col-sm-9">
            <div class="row">
                <label for="example-text-input" class="col-sm-4 col-form-label">Agreement Date</label>
                <div class="col-sm-8"><?php echo $agreeMentData[0]['agreement_date'] ?></div>
            </div>
            <div class="row">
                <label for="example-text-input" class="col-sm-4 col-form-label">Agreement Type</label>
                <div class="col-sm-8"><?php echo $agreeMentData[0]['compliance_name'] ?></div>
            </div>
            <div class="row">
                <label for="example-text-input" class="col-sm-4 col-form-label">Agreement Expiry Date</label>
                <div class="col-sm-8"><?php echo $agreeMentData[0]['agreement_expiry_date'] ?></div>
            </div>
            <div class="row">
                <label for="EstablishmentID" class="col-sm-4 col-form-label">Establishment ID</label>
                <div class="col-sm-8"><?php echo $agreeMentData[0]['fk_sfa_ent_entity_id'] ?></div>
            </div>
            <div class="row">
                <label for="EstablishmentID" class="col-sm-4 col-form-label">Establishment Name</label>
                <div class="col-sm-8"><?php echo $agreeMentData[0]['entity_name'] ?></div>
            </div>
            <div class="row">
                <label for="EstablishmentID" class="col-sm-4 col-form-label">Establishment Type</label>
                <div class="col-sm-8"><?php echo $agreeMentData[0]['type_name'] ?></div>
            </div>
            <div class="row">
                <label for="EstablishmentID" class="col-sm-4 col-form-label">Agreement File</label>
                <div class="col-sm-8"><a href="../upload/agreements/<?= $agreeMentData[0]['agreement_file'] ?>" target="_blank" class="btn btn-link text-danger">Download</a></div>
            </div>
            <div class="row">
                <label for="example-text-input" class="col-sm-4 col-form-label">Agreement Expenses</label>
                <div class="col-sm-8"><?php echo $agreeMentData[0]['agreement_amount'] ?></div>
            </div>
            <div class="row">
                <label for="example-text-input" class="col-sm-4 col-form-label">Agreement Remark</label>
                <div class="col-sm-8"><?php echo $agreeMentData[0]['agreement_remark'] ?></div>
            </div>
        </div>
    </div>
    <hr style='margin-bottom:5px;'>
    <h5 class="text-dark" style='margin:0px;'>Landlords Details</h5>
    <hr style='margin-top:5px;'>
    <div class="form-group row">
        <div class="col-12">
            <table class="table table-bordered table-responsive">
                <thead>
                    <tr>
                        <th>S. No.</th>
                        <th>Landlord Name</th>
                        <th>Landlord Address</th>
                        <th>Country</th>
                        <th>State</th>
                        <th>City</th>
                        <th>Mobile No</th>
                        <th>Email ID</th>
                        <th>Percentage</th>
                    </tr>
                </thead>
                <tbody>
                    <?php
                    $slno = 1;
                    $landlordData = $rent_query->fetch_data($conn, "cpl_rent_landlords_hst as a left join utm_add_country as b on a.country_id=b.pk_utm_country_id left join utm_add_state as e on a.state_id=e.pk_utm_state_id left join utm_add_city as f on a.city_id=f.pk_utm_city_id", "a.*,b.country_name,e.state_name,f.city_name", "a.fk_cpl_rentagreement_id='$id' and a.transaction_status=1");
                    foreach ($landlordData as $row) {
                        $name = $row['landlord_name'];
                        $address = $row['landlord_address'];
                        $country = $row['country_name'];
                        $state = $row['state_name'];
                        $city = $row['city_name'];
                        $mobile = $row['mobile_no'];
                        $email = $row['email_id'];
                        $percentage = $row['agreement_percentage'];
                    ?>
                        <tr>
                            <td>
                                <?php echo $slno ?>
                            </td>
                            <td>
                                <?php echo $name ?>
                            </td>
                            <td>
                                <?php echo $address ?>
                            </td>
                            <td>
                                <?php echo $country ?>
                            </td>
                            <td>
                                <?php echo $state ?>
                            </td>
                            <td>
                                <?php echo $city ?>
                            </td>
                            <td>
                                <?php echo $mobile ?>
                            </td>
                            <td>
                                <?php echo $email ?>
                            </td>
                            <td>
                                <?php echo $percentage ?>
                            </td>
                        </tr>
                    <?php
                        $slno++;
                    }
                    ?>
                </tbody>
            </table>
        </div>

    </div>
    <div class="modal-footer">
        <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
    </div>
</div>