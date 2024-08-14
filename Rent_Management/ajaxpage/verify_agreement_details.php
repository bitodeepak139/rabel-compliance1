<?php
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}
require_once "../../classfile/initialize.php";
require_once "../../classfile/rent_management.php";
$id = $_POST['id'];
$agreeMentData = $rent_query->fetch_data($conn, "cpl_rent_agreement_hst as a left join cpl_compliance_type as b on a.fk_cpl_compliancetype_id=b.pk_cpl_compliancetype_id left join sfa_ent_mst_entity as c on a.fk_sfa_ent_entity_id=c.pk_sfa_ent_entity_id left join sfa_cnf_mst_entity_type as d on c.fk_sfa_cnf_entitytype_id=d.pk_sfa_cnf_entitytype_id left join usm_add_users as g on a.verified_by=g.pk_usm_user_id", "a.*,b.compliance_name,c.entity_name,d.type_name,g.user_name", "a.pk_cpl_renthstagreement_id='$id' and c.transaction_status=1 ");
?>

<div class="modal-body">
    <form method="post" id='updateRentDetails'>
        <input type="hidden" id="entity_id" value="<?php echo $id ?>" />
        <input type="hidden" name="renthst_id" value="<?php echo $fetchData[0]['pk_cpl_renthst_id'] ?>" />
        <div class="row">
            <div class="col-sm-7">
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
            <div class="col-sm-5">
                <?php if ($agreeMentData[0]['verification_status'] == 0) { ?>
                    <div class="form-group row mt-2">
                        <label for="verification_reamark" class="col-sm-12 col-form-label">Verification Remark</label>
                        <div class="col-sm-12">
                            <textarea class="form-control" name="verification_reamark" id="verification_reamark" autocomplete="off"></textarea>
                        </div>
                    </div>

                    <div class="form-group row  mb-0 ">
                        <div class="col-12 mx-auto d-flex justify-content-end">
                            <button type='button' class="btn-sm btn-success" onclick="AccepetRejectStatus('verify','<?= $id ?>','<?php echo $agreeMentData[0]['fk_sfa_ent_entity_id'] ?>')">Accept</button>
                            <button type='button' class="ml-2 btn-sm btn-danger" onclick="AccepetRejectStatus('reject','<?= $id ?>','<?php echo $agreeMentData[0]['fk_sfa_ent_entity_id'] ?>')">Reject</button>
                        </div>
                    </div>
                <?php } else {
                    echo "
                     <div class='form-group row'>
                         <label for='verification_reamark' class='col-sm-5 col-form-label'>Verification Date</label>
                         <div class='col-sm-7'>
                             <p class='mb-0'>" . $agreeMentData[0]['verification_date'] . "</p>
                         </div>
                         <label for='verification_reamark' class='col-sm-5 col-form-label'>Verification Time</label>
                         <div class='col-sm-7'>
                             <p class='mb-0'>" . $agreeMentData[0]['verification_time'] . "</p>
                         </div>
                         <label for='verification_reamark' class='col-sm-5 col-form-label'>Verified By</label>
                         <div class='col-sm-7'>
                             <p class='mb-0'>" . $agreeMentData[0]['user_name'] . "</p>
                         </div>
                         <label for='verification_reamark' class='col-sm-5 col-form-label'>Verified Remark</label>
                         <div class='col-sm-7'>
                             <p class='mb-0'>" . $agreeMentData[0]['verification_remark'] . "</p>
                         </div>
                     </div>";
                    
                } ?>
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
    </form>
</div>
<script>
    function AccepetRejectStatus(submissionType, agreementhst_id, kitchen_id) {
        // let button = document.getElementById(id);
        let remark = document.getElementById("verification_reamark").value;
        if (submissionType == "reject" && remark == "") {
            $.toast({
                heading: "Error",
                text: "Please Enter Remark Of Rejection",
                position: "top-right",
                loaderBg: "#ff6849",
                icon: "error",
                hideAfter: 3500,
            });
        } else {
            $.ajax({
                type: "POST",
                url: "ajaxpage/updateajax.php",
                data: {
                    kitchen_id: kitchen_id,
                    agreementhst_id: agreementhst_id,
                    remark: remark,
                    submissionType: submissionType,
                    isset_acceptRejectAgreementDetails: 1,
                },
                success: function(data) {
                    console.log(data);
                    if (isJsonString(data)) {
                        let response = JSON.parse(data);
                        let status = response[0];
                        let msg = response[1];
                        if (status == "false") {
                            $.toast({
                                heading: "Error",
                                text: msg,
                                position: "top-right",
                                loaderBg: "#ff6849",
                                icon: "error",
                                hideAfter: 3500,
                            });
                        } else if (status == "true") {
                            let formId = response[2];
                            if (formId != "") {
                                viewpopup(agreementhst_id, 'ajaxpage/verify_agreement_details.php');
                                $(formId).submit();
                                $("#verifyAgreementDetails").submit();
                            }
                            $.toast({
                                heading: "Success",
                                text: msg,
                                position: "top-right",
                                loaderBg: "#2DB81D",
                                icon: "success",
                                hideAfter: 3500,
                            });

                            // $("#mymodal1").modal("hide");
                            // setTimeout(() => {
                            //     window.location.reload();
                            // }, 1500);
                        }
                    }
                },
            });
        }

        // if()
    }

    function isJsonString(str) {
        try {
            JSON.parse(str);
        } catch (e) {
            return false;
        }
        return true;
    }
</script>