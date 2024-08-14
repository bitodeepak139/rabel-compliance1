<?php
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}
require_once "../../classfile/initialize.php";
require_once "../../classfile/rent_management.php";
$rentid = $_POST['id'];

$id = $rent_query->fetch_data($conn, "cpl_rent_master_hst", "fk_sfa_ent_entity_id", "pk_cpl_renthst_id='$rentid'")[0]['fk_sfa_ent_entity_id'];

$fetchData = $rent_query->fetch_data($conn, "sfa_ent_mst_entity as a left join sfa_cnf_mst_entity_type as b on a.fk_sfa_cnf_entitytype_id = b.pk_sfa_cnf_entitytype_id inner join cpl_rent_master_hst as c on a.pk_sfa_ent_entity_id=c.fk_sfa_ent_entity_id left join cnf_mst_zone as d on a.zone_id=d.pk_cnf_zone_id left join utm_add_state as e on a.state_id=e.pk_utm_state_id left join utm_add_city as f on a.city_id=f.pk_utm_city_id left join usm_add_users as g on c.verified_by=g.pk_usm_user_id", "a.*,b.type_name,c.*,d.zone_name,e.state_name,f.city_name,g.user_name", "c.pk_cpl_renthst_id='$rentid'");
?>

<div class="modal-body">
    <form method="post" id='updateRentDetails'>
        <input type="hidden" id="entity_id" value="<?php echo $id ?>" />
        <input type="hidden" name="renthst_id" value="<?php echo $fetchData[0]['pk_cpl_renthst_id'] ?>" />
        <div class="row mb-0">
            <label for="example-text-input" class="col-sm-3 col-form-label">Establishment ID</label>
            <div class="col-sm-3">
                <p class="mb-0"><?php echo $fetchData[0]['pk_sfa_ent_entity_id'] ?></p>
            </div>

            <label for="example-text-input" class="col-sm-3 col-form-label">Establishment Type</label>
            <div class="col-sm-3">
                <p class="mb-0"><?php echo $fetchData[0]['type_name'] ?></p>
                <!-- <input type="text" id="entity_id" class="form-control" value="" autocomplete="off" readonly> -->
            </div>
        </div>
        <div class="row mb-0">
            <label for="example-text-input" class="col-sm-3 col-form-label">Establishment Name</label>
            <div class="col-sm-9">
                <p class="mb-0"><?php echo $fetchData[0]['entity_name'] ?></p>
                <!-- <input type="text" id="entity_id" class="form-control" value="" autocomplete="off" readonly> -->
            </div>
        </div>
        <div class="row mb-0">
            <label for="example-text-input" class="col-sm-3 col-form-label">Establishment Address</label>
            <div class="col-sm-9">
                <p class="mb-0"><?php echo $fetchData[0]['entity_address'] ?></p>
                <!-- <textarea class='form-control' readonly></textarea> -->
            </div>
        </div>
        <div class="row mb-0">
            <label for="example-text-input" class="col-sm-3 col-form-label">Zone</label>
            <div class="col-sm-3">
                <p class="mb-0"><?php echo $fetchData[0]['zone_name'] ?></p>
                <!-- <input type="text" id="entity_id" class="form-control" value="" autocomplete="off" readonly> -->
            </div>
            <label for="example-text-input" class="col-sm-3 col-form-label">State</label>
            <div class="col-sm-3">
                <p class="mb-0"><?php echo $fetchData[0]['state_name'] ?></p>
                <!-- <input type="text" id="entity_id" class="form-control" value="" autocomplete="off" readonly> -->
            </div>
        </div>
        <div class="row mb-0">
            <label for="example-text-input" class="col-sm-3 col-form-label">City</label>
            <div class="col-sm-3">
                <p class="mb-0"><?php echo $fetchData[0]['city_name'] ?></p>
                <!-- <input type="text" id="entity_id" class="form-control" value="" autocomplete="off" readonly> -->
            </div>
            <label for="example-text-input" class="col-sm-3 col-form-label">Pincode</label>
            <div class="col-sm-3">
                <p class="mb-0"><?php echo $fetchData[0]['add_pincode'] ?></p>
                <!-- <input type="text" id="entity_id" class="form-control" value="" autocomplete="off" readonly> -->
            </div>
        </div>

        <hr>
        <h4>All Agreements</h4>
        <hr>
        <div class="form-group mb-1 row">
            <div class="col-12" id="all_agreement_container">

            </div>
        </div>

        <hr>
        <h4>Rent Master Data</h4>
        <hr>
        <div class="form-group row  mb-0">
            <label for="example-text-input" class="col-sm-3 col-form-label">Kitchen Area (in sqrt)<span class="text-danger">*</span></label>
            <div class="col-sm-3">
                <p class="mb-0"><?php echo $fetchData[0]['area_sqft'] ?></p>
            </div>

            <label for="rent_expiry_date" class="col-sm-3 col-form-label">Rent Expiry Date</label>
            <div class="col-sm-3">
                <p class="mb-0"><?php echo $fetchData[0]['rent_expiry_date'] ?></p>
            </div>
        </div>

        <div class="form-group row  mb-0">
            <label for="example-text-input" class="col-sm-3 col-form-label">Kitchen Security Deposit<span class="text-danger">*</span></label>
            <div class="col-sm-9">
                <p class="mb-0"><?php echo $fetchData[0]['kitchen_rent_security_deposit'] ?></p>
            </div>
           
            
        </div>

        <div class="form-group row  mb-0">
            <label for="example-text-input" class="col-sm-3 col-form-label">Notice Period Days<span class="text-danger">*</span></label>
            <div class="col-sm-3">
                <p class="mb-0"><?php echo $fetchData[0]['notice_period'] ?></p>
            </div>

            <label for="lockinPeriod" class="col-sm-3 col-form-label">Lock in Period</label>
            <div class="col-sm-3">
                <p class="mb-0"><?php echo $fetchData[0]['lockin_date'] ?></p>
            </div>
        </div>
        <div class="form-group row  mb-0">
            <label for="example-text-input" class="col-sm-3 col-form-label">Monthly Rent<span class="text-danger">*</span></label>
            <div class="col-sm-3">
                <p class="mb-0"><?php echo $fetchData[0]['monthly_rent'] ?></p>
            </div>
            <label for="staffRoomApplicable" class="col-sm-3 col-form-label">Staff Room Applicable</label>
            <div class="col-sm-3">
                <p class="mb-0"><?php echo ($fetchData[0]['staff_room_applicable'] == 1) ? 'Yes' : 'No' ?></p>
            </div>
        </div>
        <div class="form-group row  mb-0 <?= ($fetchData[0]['staff_room_applicable'] == 1) ? "d-flex" : "d-none"; ?>" id="staff_room_input_fields">
            <label for="staff_room_expiry_date" class="col-sm-3 col-form-label">Staff Room Expiry Date</label>
            <div class="col-sm-3">
                <p class="mb-0"><?php echo $fetchData[0]['staffroom_expiry_date'] ?></p>
            </div>

            <label for="staff_room_rent_amount" class="col-sm-3 col-form-label">Staff Room Rent Amount</label>
            <div class="col-sm-3">
                <p class="mb-0"><?php echo $fetchData[0]['staff_room_rent'] ?></p>
            </div>

            <label for="staff_room_security_deposit" class="col-sm-3 col-form-label mt-0">Staff Room Security Deposit</label>
            <div class="col-sm-9 mt-0">
                <p class="mb-0"><?php echo $fetchData[0]['staff_room_security_deposit'] ?></p>
            </div>
        </div>
        <?php if ($fetchData[0]['verification_status'] == 0) { ?>
            <div class="form-group row mt-2">
                <label for="verification_reamark" class="col-sm-3 col-form-label">Verification Remark</label>
                <div class="col-sm-9">
                    <textarea class="form-control" name="verification_reamark" id="verification_reamark" autocomplete="off"></textarea>
                </div>
            </div>

            <div class="form-group row  mb-0 ">
                <div class="col-12 mx-auto d-flex justify-content-end">
                    <button type='button' class="btn-sm btn-success" onclick="AccepetRejectStatus('verify','<?= $rentid ?>','<?php echo $id ?>')">Accept</button>
                    <button type='button' class="ml-2 btn-sm btn-danger" onclick="AccepetRejectStatus('reject','<?= $rentid ?>','<?php echo $id ?>')">Reject</button>
                </div>
            </div>
        <?php } else {
            echo "
            <div class='form-group row'>
                <label for='verification_reamark' class='col-sm-3 col-form-label'>Verification Date</label>
                <div class='col-sm-3'>
                    <p class='mb-0'>" . $fetchData[0]['verification_date'] . "</p>
                </div>
                <label for='verification_reamark' class='col-sm-3 col-form-label'>Verification Time</label>
                <div class='col-sm-3'>
                    <p class='mb-0'>" . $fetchData[0]['verification_time'] . "</p>
                </div>
                <label for='verification_reamark' class='col-sm-3 col-form-label'>Verified By</label>
                <div class='col-sm-3'>
                    <p class='mb-0'>" . $fetchData[0]['user_name'] . "</p>
                </div>
                <label for='verification_reamark' class='col-sm-3 col-form-label'>Verified Remark</label>
                <div class='col-sm-3'>
                    <p class='mb-0'>" . $fetchData[0]['verification_remark'] . "</p>
                </div>
            </div>";
            if ($fetchData[0]['verification_status'] == 1) {
                echo "<div class='alert alert-success mt-3'>Rent Details Verified</div>";
            } else if ($fetchData[0]['verification_status'] == -1) {
                echo "<div class='alert alert-danger mt-3'>Rent Details Rejected</div>";
            }
        }  ?>

    </form>
    <form id="getAllAgreement" method="post" onsubmit="getDataForm('ajaxpage/get_data_ajax.php','isset_all_agreement','getAllAgreement', '#all_agreement_container', event)">
        <input type="hidden" name="id" value="<?= $id ?>">
    </form>
</div>

<!-- <div class="modal-footer">
    <button type="button" class="btn btn-default" data-dismiss="modal" onClick="editpopup('<?php echo $id ?>','mymodal1','editdiv','ajaxpage/edit_rent_details.php')">Close</button>
</div> -->
<script>
    function AccepetRejectStatus(submissionType, renthst_id, kitchen_id) {
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
                    renthst_id: renthst_id,
                    remark: remark,
                    submissionType: submissionType,
                    isset_acceptRejectRentDetail: 1,
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
                                $(formId).submit();
                            }
                            $.toast({
                                heading: "Success",
                                text: msg,
                                position: "top-right",
                                loaderBg: "#2DB81D",
                                icon: "success",
                                hideAfter: 3500,
                            });

                            $("#mymodal1").modal("hide");
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

    $('#getAllAgreement').submit();

    function isJsonString(str) {
        try {
            JSON.parse(str);
        } catch (e) {
            return false;
        }
        return true;
    }
</script>