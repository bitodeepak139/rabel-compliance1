<?php
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}
require_once "../../classfile/initialize.php";
require_once "../../classfile/rent_management.php";
$id = $_POST['id'];
$fetchData = $rent_query->fetch_data($conn, "sfa_ent_mst_entity as a left join sfa_cnf_mst_entity_type as b on a.fk_sfa_cnf_entitytype_id = b.pk_sfa_cnf_entitytype_id left join cpl_rent_master as c on a.pk_sfa_ent_entity_id=c.fk_sfa_ent_entity_id left join cnf_mst_zone as d on a.zone_id=d.pk_cnf_zone_id left join utm_add_state as e on a.state_id=e.pk_utm_state_id left join utm_add_city as f on a.city_id=f.pk_utm_city_id", "a.*,b.type_name,c.*,d.zone_name,e.state_name,f.city_name", "a.pk_sfa_ent_entity_id='$id'");

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
        <hr>
        <h4>Rent Master Data</h4>
        <hr>
        <div class="form-group row">
            <label for="example-text-input" class="col-sm-3 col-form-label">Kitchen Area (in sqrt)<span class="text-danger">*</span></label>
            <div class="col-sm-3">
                <input type="number" id="kitchen_area" name='kitchen_area' class="form-control"  autocomplete="off">
            </div>

            <label for="rent_expiry_date" class="col-sm-3 col-form-label">Rent Expiry Date</label>
            <div class="col-sm-3">
                <input type="date" id="rent_expiry_date" name='rent_expiry_date' class="form-control"  autocomplete="off">
            </div>
        </div>

        <div class="form-group row">
            <label for="example-text-input" class="col-sm-3 col-form-label">Kitchen Security Deposit<span class="text-danger">*</span></label>
            <div class="col-sm-9">
                <input type="number" id="kitchen_rent_security_deposit" name='kitchen_rent_security_deposit' class="form-control"  autocomplete="off">
            </div>

            
        </div>

        <div class="form-group row">
            <label for="example-text-input" class="col-sm-3 col-form-label">Notice Period Days<span class="text-danger">*</span></label>
            <div class="col-sm-3">
                <input type="number" id="notice_period" name='notice_period' class="form-control"  autocomplete="off">
            </div>

            <label for="lockinPeriod" class="col-sm-3 col-form-label">Lock-in Period Expiry Date</label>
            <div class="col-sm-3">
                <input type="date" id="lockinPeriod" name='lockinPeriod' class="form-control" autocomplete="off">
            </div>
        </div>
        <div class="form-group row">
            <label for="example-text-input" class="col-sm-3 col-form-label">Monthly Rent<span class="text-danger">*</span></label>
            <div class="col-sm-3">
                <input type="number" id="monthly_rent" name='monthly_rent' class="form-control" autocomplete="off">
            </div>

            <label for="staffRoomApplicable" class="col-sm-3 col-form-label">Staff Room Applicable</label>
            <div class="col-sm-3">
                <select name="staffRoomApplicable" class="form-control" id="staffRoomApplicable" onchange="staffRoom()">
                    <option value="">Select</option>
                    <option value="1" >Yes</option>
                    <option value="0" >No</option>
                </select>
            </div>
        </div>
        <div class="form-group row d-none" id="staff_room_input_fields">
            <label for="staff_room_expiry_date" class="col-sm-3 col-form-label">Staff Room Expiry Date</label>
            <div class="col-sm-3">
                <input type="date" id="staff_room_expiry_date" name='staff_room_expiry_date' class="form-control"  autocomplete="off">
            </div>

            <label for="staff_room_rent_amount" class="col-sm-3 col-form-label">Staff Room Rent Amount</label>
            <div class="col-sm-3">
                <input type="number" id="staff_room_rent_amount" name='staff_room_rent_amount' class="form-control"  autocomplete="off">
            </div>

            <label for="staff_room_security_deposit" class="col-sm-3 col-form-label mt-4">Staff Room Security Deposit</label>
            <div class="col-sm-9 mt-4">
                <input type="number" id="staff_room_security_deposit" name='staff_room_security_deposit' class="form-control"  autocomplete="off">
            </div>
        </div>


        <div class="form-group row ">
            <div class="col-12">
                <a href="javascript:void(0)" class="btn btn-primary" onClick="edit('<?= $id ?>','updateRentDetails','ajaxpage/updateRentDetails.php','isset_update_rent_details')">Add</a>
            </div>
        </div>
    </form>

</div>

<div class="modal-footer">
    <button type="button" class="btn btn-default" data-dismiss="modal" onClick="editpopup('<?php echo $id ?>','mymodal1','editdiv','ajaxpage/edit_rent_details.php')">Close</button>
</div>
<script>
    function staffRoom() {
        const staffRoomApplicable = document.getElementById("staffRoomApplicable");
        const staff_room_input_fields = document.getElementById(
            "staff_room_input_fields"
        );
        if (staffRoomApplicable.value == 1) {
            $('#agreement_type').html(`
        <option value="">Select</option>
<?php
$fetchRentType = $rent_query->fetch_data($conn, "cpl_compliance_type", "*", "transaction_status='1' and compliance_type='Rent'");
if ($fetchRentType != 0) {
    foreach ($fetchRentType as $row) {
        echo "<option value='$row[pk_cpl_compliancetype_id]'>$row[compliance_name]</option>";
    }
}
?>
    `);
            staff_room_input_fields.classList.remove("d-none");
            staff_room_input_fields.classList.add("d-flex");
        } else {
            $('#agreement_type').html(`
    <option value="">Select</option>
    <?php
    $fetchRentType = $rent_query->fetch_data($conn, "cpl_compliance_type", "*", "transaction_status='1' and compliance_type='Rent'");
    if ($fetchRentType != 0) {
        foreach ($fetchRentType as $row) {
            if ($row['compliance_name'] != 'Staff Room Rent') {
                echo "<option value='$row[pk_cpl_compliancetype_id]'>$row[compliance_name]</option>";
            }
        }
    }
    ?>
    `);
            staff_room_input_fields.classList.remove("d-flex");
            staff_room_input_fields.classList.add("d-none");
        }
    }

    $("#addNewAgreementBtn").click(function() {
        const rent_id = '<?php echo $fetchData[0]['pk_cpl_rent_id']; ?>';
        if (rent_id != '') {
            $("#AgreementSection").toggleClass("d-none");
            getdata('ajaxpage/get_data_ajax.php', 'isset_all_agreement', '#all_agreement_container')
        } else {
            // alert();
            $.toast({
                heading: "Error",
                text: 'Please Update Rent Master Data First',
                position: "top-right",
                loaderBg: "#ff6849",
                icon: "error",
                hideAfter: 3500,
            });
        }
    });

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
                            echo "<option value='$row_state[pk_utm_country_id]'>$row_state[country_name]</option>";
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
            alert('Total Percentage should not exceed 100');
            $(element).val('');
        }
    }
</script>