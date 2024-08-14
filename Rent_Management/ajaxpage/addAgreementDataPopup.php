<?php
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}
require_once "../../classfile/initialize.php";
require_once "../../classfile/rent_management.php";
$id = $_POST['id'];
$fetchData = $rent_query->fetch_data($conn, "sfa_ent_mst_entity as a left join sfa_cnf_mst_entity_type as b on a.fk_sfa_cnf_entitytype_id = b.pk_sfa_cnf_entitytype_id left join cpl_rent_master as c on a.pk_sfa_ent_entity_id=c.fk_sfa_ent_entity_id left join cnf_mst_zone as d on a.zone_id=d.pk_cnf_zone_id left join utm_add_state as e on a.state_id=e.pk_utm_state_id left join utm_add_city as f on a.city_id=f.pk_utm_city_id left join usm_add_users as g on c.verified_by=g.pk_usm_user_id", "a.*,b.type_name,c.*,d.zone_name,e.state_name,f.city_name,g.user_name", "a.pk_sfa_ent_entity_id='$id'");

?>

<div class="modal-body">
    <form method="post" id='updateRentDetails'>
        <input type="hidden" id="entity_id" value="<?php echo $id ?>" />
        <input type="hidden" name="rent_id" value="<?php echo $fetchData[0]['pk_cpl_rent_id'] ?>" />
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
        <h6 style='text-decoration:underline;font-size:14px;font-weight:bolder;'>Rent Master Data</h6>
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
        <div class='form-group row mb-0'>
            <label for='verification_reamark' class='col-sm-3 col-form-label'>Verification Date</label>
            <div class='col-sm-3'>
                <p class='mb-0'><?= $fetchData[0]['verification_date'] ?></p>
            </div>
            <label for='verification_reamark' class='col-sm-3 col-form-label'>Verification Time</label>
            <div class='col-sm-3'>
                <p class='mb-0'><?= $fetchData[0]['verification_time'] ?></p>
            </div>
            <label for='verification_reamark' class='col-sm-3 col-form-label'>Verified By</label>
            <div class='col-sm-3'>
                <p class='mb-0'><?= $fetchData[0]['user_name'] ?></p>
            </div>
            <label for='verification_reamark' class='col-sm-3 col-form-label'>Verified Remark</label>
            <div class='col-sm-3'>
                <p class='mb-0'><?= $fetchData[0]['verification_remark'] ?></p>
            </div>
        </div>
        <?php
        if ($fetchData[0]['verification_status'] == 1) {
            echo "<div class='alert alert-success'>Rent Details Verified</div>";
        } else if ($fetchData[0]['verification_status'] == -1) {
            echo "<div class='alert alert-danger'>Rent Details Rejected</div>";
        }
        ?>
    </form>
    <form id="addAgreementDataForm" method="post" enctype="multipart/form-data">
        <input type="hidden" name="rent_id" value="<?php echo $fetchData[0]['pk_cpl_rent_id'] ?>" />
        <input type="hidden" name="id" value="<?php echo $id ?>">
        <section>
            <h6 style='font-size:14px; font-weight:bolder; text-decoration:underline;'>Add Agreement Details</h6>
            <div class="form-group mb-1 row">
                <label for="example-text-input" class="col-sm-3 col-form-label">Select Agreement Type</label>
                <div class="col-sm-3">
                    <select name="agreement_type" class="form-control" id="agreement_type">
                        <option value="">Select</option>
                        <?php
                        $fetchRentType = $rent_query->fetch_data($conn, "cpl_compliance_type", "*", "transaction_status='1' and compliance_type='Rent' AND renewal_type='Renewal'");
                        if ($fetchRentType != 0) {
                            foreach ($fetchRentType as $row) {
                                echo "<option value='$row[pk_cpl_compliancetype_id]'>$row[compliance_name]</option>";
                            }
                        }
                        ?>
                    </select>
                </div>

                <label for="example-text-input" class="col-sm-3 col-form-label">Agreement Date</label>
                <div class="col-sm-3">
                    <input type="date" id="agreement_date" name="agreement_date" class="form-control" autocomplete="off">
                </div>
            </div>
            <div class="form-group mb-1 row">
                <label for="example-text-input" class="col-sm-3 col-form-label">Agreement Expiry Date</label>
                <div class="col-sm-3">
                    <input type="date" id="agreement_expiry_date" name="agreement_expiry_date" class="form-control" autocomplete="off">
                </div>

                <label for="example-text-input" class="col-sm-3 col-form-label">Agreement Expenses</label>
                <div class="col-sm-3">
                    <input type="number" id="agreement_amount" name="agreement_amount" class="form-control" autocomplete="off">
                </div>
            </div>
            <div class="form-group mb-1 row">
                <label for="example-text-input" class="col-sm-3 col-form-label">Agreement Document</label>
                <div class="col-sm-3">
                    <input type="file" id="agreement_document" name="agreement_document" class="form-control" autocomplete="off">
                </div>
                <label for="example-text-input" class="col-sm-3 col-form-label">No of LandLords</label>
                <div class="col-sm-3">
                    <input type="number" id="no_of_landlords" name="no_of_landlords" value='1' class="form-control" autocomplete="off" readonly>
                </div>
            </div>
            <div class="form-group mb-1 row">
                <label for="example-text-input" class="col-sm-3 col-form-label">Enter Remark</label>
                <div class="col-sm-9">
                    <textarea class="form-control" name="agreement_remark"></textarea>
                </div>

            </div>

            <!-- add landlord table and append the tr -->
            <button type='button' class='btn btn-link ml-5 mr-5' id="addLandlordBtn">Add Landlord</button>

            <div class="form-group mb-1 row " id="LandlordTable" style="margin-top:10px;">
                <div class="col-12">
                    <table class="table table-bordered">
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
                                <th>Action</th>
                            </tr>
                        </thead>
                        <tbody id="landlord_table_body">
                            <!-- append the tr here -->
                            <tr>
                                <td>1</td>
                                <td><input type="text" name="landlord_name[]" class="form-control" autocomplete="off"></td>
                                <td><input type="text" name="landlord_address[]" class="form-control" autocomplete="off"></td>
                                <td>
                                    <select name="landlord_country[]" id="landlord_country_1" onchange="DependantDropDown('landlord_country_1', 'landlord_state_1','ajaxpage/get_data_ajax.php', 'isset_dependent_country')" class="form-control js-example-basic-single">
                                        <option value="">-Select-</option>
                                        <?php
                                        $fetch_state = $rent_query->fetch_data($conn, "utm_add_country", "*", "transaction_status='1' order by country_name asc");
                                        if ($fetch_state != 0) {
                                            foreach ($fetch_state as $row_state) {
                                                if ($row_state['country_name'] != 'India') {
                                                    echo "<option value='$row_state[pk_utm_country_id]'>$row_state[country_name]</option>";
                                                } else {
                                                    echo "<option value='$row_state[pk_utm_country_id]' selected>$row_state[country_name]</option>";
                                                }
                                            }
                                        }
                                        ?>
                                    </select>
                                </td>
                                <td>
                                    <select name="landlord_state[]" id="landlord_state_1" onchange="DependantDropDown('landlord_state_1', 'landlord_city_1','ajaxpage/get_data_ajax.php', 'isset_dependent_state')" class="form-control js-example-basic-single">
                                        <option value="">-Select-</option>
                                        <?php
                                        $fetch_state = $rent_query->fetch_data($conn, "utm_add_state", "*", "transaction_status='1'");
                                        if ($fetch_state != 0) {
                                            foreach ($fetch_state as $row_state) {
                                                echo "<option value='$row_state[pk_utm_state_id]'>$row_state[state_name]</option>";
                                            }
                                        }
                                        ?>
                                    </select>
                                </td>
                                <td>
                                    <select name="landlord_city[]" id="landlord_city_1" class="form-control js-example-basic-single">
                                        <option value="">-Select-</option>
                                    </select>
                                </td>
                                <td><input type="number" name="landlord_mobile[]" class="form-control" autocomplete="off"></td>
                                <td><input type="text" name="landlord_email[]" class="form-control" autocomplete="off"></td>
                                <td><input type="number" name="landlord_percentage[]" class="form-control landlord_percentage" oninput="landlordPercentage(this.value)" autocomplete="off"></td>
                                <td><button type="button" class="btn btn-danger"><i class='fa fa-trash'></i></button></td>
                            </tr>
                        </tbody>
                    </table>
                </div>
            </div>


            <div class="form-group mb-1 row">
                <div class="col-12">
                    <a href="javascript:void(0)" class="btn btn-primary" onClick="editAgreeMent('<?= $id ?>','addAgreementDataForm','ajaxpage/addAgreementData.php','isset_add_agreement_data')">Add Agreement</a>
                </div>
            </div>

            <hr>
            <h4>All Agreements</h4>
            <hr>
            <div class="form-group mb-1 row">
                <div class="col-12" id="all_agreement_container">

                </div>
            </div>
        </section>
    </form>
    <form id="getAllAgreement" method="post" onsubmit="getDataForm('ajaxpage/get_data_ajax.php','isset_all_agreement','getAllAgreement', '#all_agreement_container', event)">
        <input type="hidden" name="id" value="<?= $id ?>">
    </form>
</div>

<div class="modal-footer">
    <button type="button" class="btn btn-default" data-dismiss="modal" onClick="getDataForm('ajaxpage/get_data_ajax.php','isset_add_agreement_details','AddAgreementDetails','#datadiv',event)">Close</button>
</div>
<script>
    $("#addLandlordBtn").click(function() {
        const LandlordTable = document.getElementById("LandlordTable");
        LandlordTable.classList.remove("d-none");
        $("#no_of_landlords").val(`${$('#landlord_table_body').find('tr').length + 1}`);
        $("#landlord_table_body").append(`
        <tr>
            <td>${$('#landlord_table_body').find('tr').length + 1}</td>
            <td><input type="text" name="landlord_name[]" class="form-control" autocomplete="off"></td>
            <td><input type="text" name="landlord_address[]" class="form-control" autocomplete="off"></td>
            <td>
                <select name="landlord_country[]" id="landlord_country_${$('#landlord_table_body').find('tr').length + 1}" onchange="DependantDropDown('landlord_country_${$('#landlord_table_body').find('tr').length + 1}', 'landlord_state_${$('#landlord_table_body').find('tr').length + 1}','ajaxpage/get_data_ajax.php', 'isset_dependent_country')" class="form-control js-example-basic-single">
                    <option value="">-Select-</option>
                    <?php
                    $fetch_state = $rent_query->fetch_data($conn, "utm_add_country", "*", "transaction_status='1' order by country_name asc");
                    if ($fetch_state != 0) {
                        foreach ($fetch_state as $row_state) {
                            if ($row_state['country_name'] != 'India') {
                                echo "<option value='$row_state[pk_utm_country_id]'>$row_state[country_name]</option>";
                            } else {
                                echo "<option value='$row_state[pk_utm_country_id]' selected>$row_state[country_name]</option>";
                            }
                        }
                    }
                    ?>
                </select>
            </td>
            <td>
                <select name="landlord_state[]" id="landlord_state_${$('#landlord_table_body').find('tr').length + 1}" onchange="DependantDropDown('landlord_state_${$('#landlord_table_body').find('tr').length + 1}', 'landlord_city_${$('#landlord_table_body').find('tr').length + 1}','ajaxpage/get_data_ajax.php', 'isset_dependent_state')" class="form-control js-example-basic-single">
                    <option value="">-Select-</option>
                    <?php
                    $fetch_state = $rent_query->fetch_data($conn, "utm_add_state", "*", "transaction_status='1' order by state_name asc");
                    if ($fetch_state != 0) {
                        foreach ($fetch_state as $row_state) {
                            echo "<option value='$row_state[pk_utm_state_id]'>$row_state[state_name]</option>";
                        }
                    }
                    ?>
                </select>
            </td>
            <td>
                <select name="landlord_city[]" id="landlord_city_${$('#landlord_table_body').find('tr').length + 1}" class="form-control js-example-basic-single">
                    <option value="">-Select-</option>
                </select>
            </td>
            <td><input type="number" name="landlord_mobile[]" class="form-control" autocomplete="off"></td>
            <td><input type="text" name="landlord_email[]" class="form-control" autocomplete="off"></td>
            <td><input type="number" name="landlord_percentage[]" class="form-control landlord_percentage" oninput="landlordPercentage(this.value)" autocomplete="off"></td>
            <td><button type="button" class="btn btn-danger"><i class='fa fa-trash'></i></button></td>
        </tr>
    `);
    });

    $("#landlord_table_body").on('click', 'tr td button', function() {
        $(this).closest('tr').remove();
        $("#no_of_landlords").val(`${$('#landlord_table_body').find('tr').length}`);
        $('#landlord_table_body').find('tr').each(function(index) {
            $(this).find('td').eq(0).text(index + 1);
        });
    });

    function landlordPercentage(element) {
        let total_percentage = 0;
        $('.landlord_percentage').each(function() {
            total_percentage += parseInt($(this).val());
        });
        if (total_percentage > 100) {
            $(element).val('');
            alert('Total Percentage should not exceed 100');
        }
    }

    // getDataForm('ajaxpage/get_data_ajax.php', 'isset_all_agreement', 'getAllAgreement', '#all_agreement_container', event);
    $('#getAllAgreement').submit();
    // console.log($('#getAllAgreement'));
    // const d = document.getElementById('addAgreementDataForm');
    // console.log(d);
    // console.log('hello');

    // $(document).ready(function() {});


    function editAgreeMent(id, formId, url, isset_var) {
        var str = 1;
        if (str == 1) {
            $("#loading").show();
            let form_id = document.getElementById(formId);
            var formData = new FormData(form_id);
            formData.append("id", id);
            formData.append(isset_var, "1");
            $.ajax({
                type: "POST",
                url: url,
                data: formData,
                cache: false,
                contentType: false,
                processData: false,
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
                            $("#loading").hide();
                        } else if (status == "true") {
                            console.log(response);
                            let getUrl = response[2];
                            let getIsset = response[3];
                            let targetDiv = response[4];
                            if (getUrl != "#" && getIsset != "#" && targetDiv != "#") {
                                getdata(getUrl, getIsset, targetDiv);
                            }
                            let formId = response[5];
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
                            $("#loading").hide();
                            $("#addAgreementDataForm")[0].reset();
                            $("#LandlordTable").html(`<div class="col-12">
                    <table class="table table-bordered">
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
                                <th>Action</th>
                            </tr>
                        </thead>
                        <tbody id="landlord_table_body">
                            <!-- append the tr here -->
                            <tr>
                                <td>1</td>
                                <td><input type="text" name="landlord_name[]" class="form-control" autocomplete="off"></td>
                                <td><input type="text" name="landlord_address[]" class="form-control" autocomplete="off"></td>
                                <td>
                                    <select name="landlord_country[]" id="landlord_country_1" onchange="DependantDropDown('landlord_country_1', 'landlord_state_1','ajaxpage/get_data_ajax.php', 'isset_dependent_country')" class="form-control js-example-basic-single">
                                        <option value="">-Select-</option>
                                        <?php
                                        $fetch_state = $rent_query->fetch_data($conn, "utm_add_country", "*", "transaction_status='1' order by country_name asc");
                                        if ($fetch_state != 0) {
                                            foreach ($fetch_state as $row_state) {
                                                if ($row_state['country_name'] != 'India') {
                                                    echo "<option value='$row_state[pk_utm_country_id]'>$row_state[country_name]</option>";
                                                } else {
                                                    echo "<option value='$row_state[pk_utm_country_id]' selected>$row_state[country_name]</option>";
                                                }
                                            }
                                        }
                                        ?>
                                    </select>
                                </td>
                                <td>
                                    <select name="landlord_state[]" id="landlord_state_1" onchange="DependantDropDown('landlord_state_1', 'landlord_city_1','ajaxpage/get_data_ajax.php', 'isset_dependent_state')" class="form-control js-example-basic-single">
                                        <option value="">-Select-</option>
                                        <?php
                                        $fetch_state = $rent_query->fetch_data($conn, "utm_add_state", "*", "transaction_status='1'");
                                        if ($fetch_state != 0) {
                                            foreach ($fetch_state as $row_state) {
                                                echo "<option value='$row_state[pk_utm_state_id]'>$row_state[state_name]</option>";
                                            }
                                        }
                                        ?>
                                    </select>
                                </td>
                                <td>
                                    <select name="landlord_city[]" id="landlord_city_1" class="form-control js-example-basic-single">
                                        <option value="">-Select-</option>
                                    </select>
                                </td>
                                <td><input type="number" name="landlord_mobile[]" class="form-control" autocomplete="off"></td>
                                <td><input type="text" name="landlord_email[]" class="form-control" autocomplete="off"></td>
                                <td><input type="number" name="landlord_percentage[]" class="form-control landlord_percentage" oninput="landlordPercentage(this.value)" autocomplete="off"></td>
                                <td><button type="button" class="btn btn-danger"><i class='fa fa-trash'></i></button></td>
                            </tr>
                        </tbody>
                    </table>
                </div>`);
                        }
                    } else {
                        $.toast({
                            heading: "Error",
                            text: "Task Incomplete",
                            position: "top-right",
                            loaderBg: "#652322",
                            icon: "error",
                            hideAfter: 3500,
                        });
                        $("#loading").hide();
                    }
                },
            });
        }
    }
</script>