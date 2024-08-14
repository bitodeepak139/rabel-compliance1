<?php
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}
require_once "../../classfile/initialize.php";
require_once "../../classfile/compliance_certificate_management.php";
?>

<div class="table-responsive">
    <table id="example1" class="table table-bordered table-striped table-hover display table_design">
        <thead>
            <tr class="info">
                <th>S.No</th>
                <th>Compliance Name</th>
                <th>Last Date Update</th>
                <th>Select If Applicable</th>
                <th>L1 User</th>
                <th>L2 User</th>
                <th>L3 User</th>
                <th>L4 User</th>
                <th width="8%">Action</th>
            </tr>
        </thead>
        <tbody>
            <?php
            $result = $ccm_query->fetch_data($conn, "cpl_compliance_type", "*", "transaction_status='1' and compliance_type='Compliance'");
            if ($result != 0) {
                $sno = 1;
                foreach ($result as $row) {
                    ?>
                    <tr>
                        <td>
                            <?php echo $sno; ?>
                        </td>
                        <td>
                            <?php echo $row['compliance_name'] ?>
                        </td>
                        <?php
                        $checked = '';
                        $last_updated = '';
                        $fetch_data1 = $ccm_query->fetch_data($conn, 'cpl_establishment_compliance', '*', "fk_sfa_ent_entity_id='$_POST[entityId]' AND fk_cpl_compliancetype_id=$row[pk_cpl_compliancetype_id]");
                        if ($fetch_data1 != 0) {
                            $checkStatus = $fetch_data1[0]['compliance_applicable'];
                            $last_updated = $fetch_data1[0]['ins_date_time'];
                            if ($checkStatus == 'Yes') {
                                $checked = 'checked';
                            }
                        }
                        ?>
                        <td>
                            <?php echo $last_updated; ?>
                        </td>
                        <td>
                            <div class="checkboxes">
                                <label class="flipBox" aria-label="Checkbox 1">
                                    <input type="checkbox" class='checkboxClass3d'
                                        id="Checked-<?php echo $row['compliance_name'] ?>" <?php echo $checked; ?> />
                                    <div class="flipBox_boxOuter">
                                        <div class="flipBox_box">
                                            <div></div>
                                            <div></div>
                                            <div></div>
                                            <div></div>
                                            <div></div>
                                            <div></div>
                                        </div>
                                    </div>
                                    <div class="flipBox_shadow"></div>
                                </label>
                            </div>
                        </td>
                        <td>
                            <select class="multiselect-ui form-control" id="UserL1-<?php echo $row['compliance_name'] ?>"
                                name="UserL1-<?php echo $row['compliance_name'] ?>[]" multiple="multiple" <?= ($row['renewal_type'] == "One Time") ? "disabled":""; ?>>
                                <?php
                                $result_userl1 = $ccm_query->fetch_data($conn, "usm_add_users", "*", "transaction_status='1' AND user_level='L1'");
                                if ($result_userl1 != 0) {
                                    foreach ($result_userl1 as $row1) {
                                        $fetch_data_map_user1 = $ccm_query->fetch_data($conn, "cpl_establishment_compliance_users", "*", "fk_sfa_ent_entity_id='$_POST[entityId]' AND fk_cpl_compliancetype_id='$row[pk_cpl_compliancetype_id]' AND empId='$row1[pk_usm_user_id]'");
                                        if ($fetch_data_map_user1 != 0) {

                                            echo "<option value='$row1[pk_usm_user_id]' selected>$row1[user_name] ($row1[user_level])</option>";
                                        } else {
                                            echo "<option value='$row1[pk_usm_user_id]'>$row1[user_name] ($row1[user_level])</option>";
                                        }

                                    }
                                }
                                ?>
                            </select>
                        </td>
                        <td>
                            <select class="multiselect-ui form-control" id="UserL2-<?php echo $row['compliance_name'] ?>"
                                name="UserL2-<?php echo $row['compliance_name'] ?>[]" multiple="multiple" <?= ($row['renewal_type'] == "One Time") ? "disabled":""; ?> >
                                <?php
                                $result_userl2 = $ccm_query->fetch_data($conn, "usm_add_users", "*", "transaction_status='1' AND user_level='L2'");
                                if ($result_userl2 != 0) {
                                    foreach ($result_userl2 as $row2) {
                                        $fetch_data_map_user2 = $ccm_query->fetch_data($conn, "cpl_establishment_compliance_users", "*", "fk_sfa_ent_entity_id='$_POST[entityId]' AND fk_cpl_compliancetype_id='$row[pk_cpl_compliancetype_id]' AND empId='$row2[pk_usm_user_id]'");
                                        if ($fetch_data_map_user2 != 0) {
                                            echo "<option value='$row2[pk_usm_user_id]' selected>$row2[user_name] ($row2[user_level])</option>";
                                        } else {
                                            echo "<option value='$row2[pk_usm_user_id]'>$row2[user_name] ($row2[user_level])</option>";
                                        }

                                    }
                                }
                                ?>


                            </select>
                        </td>
                        <td>
                            <select class="multiselect-ui form-control" id="UserL3-<?php echo $row['compliance_name'] ?>"
                                name="UserL3-<?php echo $row['compliance_name'] ?>[]" multiple="multiple" <?= ($row['renewal_type'] == "One Time") ? "disabled":""; ?> >

                                <?php
                                $result_userl3 = $ccm_query->fetch_data($conn, "usm_add_users", "*", "transaction_status='1' AND user_level='L3'");

                                if ($result_userl3 != 0) {
                                    foreach ($result_userl3 as $row3) {
                                        $fetch_data_map_user1 = $ccm_query->fetch_data($conn, "cpl_establishment_compliance_users", "*", "fk_sfa_ent_entity_id='$_POST[entityId]' AND fk_cpl_compliancetype_id='$row[pk_cpl_compliancetype_id]' AND empId='$row3[pk_usm_user_id]'");
                                        if ($fetch_data_map_user1 != 0) {

                                            echo "<option value='$row3[pk_usm_user_id]' selected>$row3[user_name] ($row3[user_level])</option>";
                                        } else {
                                            echo "<option value='$row3[pk_usm_user_id]'>$row3[user_name] ($row3[user_level])</option>";
                                        }

                                    }
                                }
                                ?>

                            </select>
                        </td>
                        <td>
                            <select class="multiselect-ui form-control" id="UserL4-<?php echo $row['compliance_name'] ?>"
                                name="UserL4-<?php echo $row['compliance_name'] ?>[]" multiple="multiple" <?= ($row['renewal_type'] == "One Time") ? "disabled":""; ?> >
                                <?php
                                $result_userl4 = $ccm_query->fetch_data($conn, "usm_add_users", "*", "transaction_status='1' AND user_level='L4'");

                                if ($result_userl4 != 0) {
                                    foreach ($result_userl4 as $row4) {
                                        $fetch_data_map_user1 = $ccm_query->fetch_data($conn, "cpl_establishment_compliance_users", "*", "fk_sfa_ent_entity_id='$_POST[entityId]' AND fk_cpl_compliancetype_id='$row[pk_cpl_compliancetype_id]' AND empId='$row4[pk_usm_user_id]'");
                                        if ($fetch_data_map_user1 != 0) {

                                            echo "<option value='$row4[pk_usm_user_id]' selected>$row4[user_name] ($row4[user_level])</option>";
                                        } else {
                                            echo "<option value='$row4[pk_usm_user_id]'>$row4[user_name] ($row4[user_level])</option>";
                                        }

                                    }
                                }
                                ?>

                            </select>
                        </td>
                        <td><button class="btn btn-primary"
                                onClick="add_mapestablishment_certi('<?php echo $row['compliance_name'] ?>','<?php echo $row['pk_cpl_compliancetype_id'] ?>','<?php echo $_POST['entityId'] ?>')">Submit</button>
                        </td>
                    </tr>
                    <?php
                    $sno++;
                }
            } ?>
        </tbody>
    </table>
</div>