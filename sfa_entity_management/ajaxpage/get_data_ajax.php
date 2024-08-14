<?php
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}
require_once "../../classfile/initialize.php";
require_once "../../classfile/sfa_entity_management.php";

if (isset($_POST['isset_bank_details_temp'])) {
    $sid = session_id();
    $result = $sfa_ent->fetch_data($conn, "sfa_ent_hst_entity_bank_accounts_temp", "*", "fk_sfa_ent_session_id='$sid'");
    if ($result != 0) {
        ?>
        <div class="table-responsive">
            <table id="example1" class="table table-bordered table-striped table-hover display table_design">
                <thead>
                    <tr class="info">
                        <th style='min-width:189px;'>Account Holder Name<span style="color:#FF0000">*</span></th>
                        <th>Account<i class='invisible'>_</i>No<span style="color:#FF0000">*</span></th>
                        <th>Account<i class='invisible'>_</i>Type<span style="color:#FF0000">*</span></th>
                        <th>Bank<i class='invisible'>_</i>Name<span style="color:#FF0000">*</span></th>
                        <th>Branch<i class='invisible'>_</i>Name<span style="color:#FF0000">*</span></th>
                        <th>IFSC<i class='invisible'>_</i>Code<span style="color:#FF0000">*</span></th>
                        <th style='min-width: 100px;'>Swift</th>
                        <th width="8%">Action</th>
                    </tr>
                </thead>
                <tbody>
                    <?php
                    foreach ($result as $row) {
                        $id = $row["pk_sfa_ent_bankaccount_id"];
                        ?>
                        <tr id='tr_count_<?php echo $id ?>'>
                            <td>
                                <?php echo $row['holder_name']; ?>
                            </td>
                            <td>
                                <?php echo $row['account_no']; ?>
                            </td>
                            <td>
                                <?php echo $row['account_type']; ?>
                            </td>
                            <td>
                                <?php echo $row['bank_name']; ?>
                            </td>
                            <td>
                                <?php echo $row['branch_name']; ?>
                            </td>
                            <td>
                                <?php echo $row['ifsc_code']; ?>
                            </td>
                            <td>
                                <?php echo $row['swift_code']; ?>
                            </td>
                            <!-- deleteData(['database_table_name', 'database_col_id', 'tr_id']) -->
                            <td width="8%">
                                <a href='javascript:void(0)'
                                    onClick="deleteData(['sfa_ent_hst_entity_bank_accounts_temp','<?php echo $id; ?>','isset_delete_bank_account_temp'])"
                                    class="btn btn-danger btn-sm" title="Add Stock">Delete</a>
                            </td>
                        </tr>
                    <?php } ?>
                </tbody>
            </table>
        </div>
    <?php }
}


if (isset($_POST['isset_contact_details_temp'])) {
    $sid = session_id();
    $result = $sfa_ent->fetch_data($conn, "sfa_ent_hst_contact_temp", "*", "fk_sfa_ent_entity_id='$sid'");
    if ($result != 0) {
        ?>
        <div class="table-responsive">
            <table id="example1" class="table table-bordered table-striped table-hover display table_design">
                <thead>
                    <tr class="info">
                        <th style='min-width:189px;'>Person Name<span style="color:#FF0000">*</span></th>
                        <th>Designation</th>
                        <th>Contact<i class='invisible'>_</i>No</th>
                        <th>Contact<i class='invisible'>_</i>No2</th>
                        <th>Landline</th>
                        <th>Email</th>
                        <th style='min-width: 100px;'>Remark</th>
                        <th width="8%">Action</th>
                    </tr>
                </thead>
                <tbody>
                    <?php
                    foreach ($result as $row) {
                        $id = $row["pk_sfa_ent_contact_id"];
                        ?>
                        <tr id='tr_count_<?php echo $id ?>'>
                            <td>
                                <?php echo $row['contact_name']; ?>
                            </td>
                            <td>
                                <?php echo $row['designation']; ?>
                            </td>
                            <td>
                                <?php echo $row['mobile1']; ?>
                            </td>
                            <td>
                                <?php echo $row['mobile2']; ?>
                            </td>
                            <td>
                                <?php echo $row['landline']; ?>
                            </td>
                            <td>
                                <?php echo $row['email']; ?>
                            </td>
                            <td>
                                <?php echo $row['contact_remark']; ?>
                            </td>
                            <!-- deleteData(['database_table_name', 'database_col_id', 'tr_id']) -->
                            <td width="8%">
                                <a href='javascript:void(0)'
                                    onClick="deleteData(['sfa_ent_hst_contact_temp','<?php echo $id; ?>','isset_delete_contact_temp'])"
                                    class="btn btn-danger btn-sm" title="Delete Contact">Delete</a>
                            </td>
                        </tr>
                    <?php } ?>
                </tbody>
            </table>
        </div>
    <?php }
}


if (isset($_POST['isset_dependent_category'])) {
    $category_id = $_POST['selected_id'];
    $sub_category = $sfa_query->fetch_data($conn, "sfa_cnf_mst_entity_subcategory a LEFT JOIN sfa_cnf_mst_entity_type as b ON a.fk_sfa_cnf_entitytype_id = b.pk_sfa_cnf_entitytype_id LEFT JOIN sfa_cnf_mst_entity_category as c ON a.fk_sfa_cnf_entcategory_id = c.pk_sfa_cnf_entcategory_id", "a.*,b.type_name,c.category_name", "a.transaction_status='1' AND a.fk_sfa_cnf_entcategory_id='$category_id'");
    if ($sub_category != 0) {
        echo "<option value=''>--Sub Category--</option>";
        foreach ($sub_category as $row) {
            echo "<option value='$row[pk_sfa_cnf_entsubcategory_id]'>$row[subcategory_name]</option>";
        }
    }
}


if (isset($_POST['isset_dependent_zone'])) {
    $zone_id = $_POST['selected_id'];
    $zonesData = $sfa_ent->fetch_data($conn, "cnf_mst_region", "*", "transaction_status='1' AND fk_cnf_zone_id='$zone_id'");
    echo "<option value=''>Select Region</option>";
    if ($zonesData != 0) {
        foreach ($zonesData as $row) {
            echo "<option value='$row[pk_cnf_region_id]'>$row[region_name]</option>";
        }
    } else {
        echo "<option value=''>No Region Added to This Zone</option>";
    }
}


if (isset($_POST["isset_dependent_country"])) {
    $country_id = $_POST["selected_id"];
    $stateData = $sfa_ent->fetch_data($conn, "utm_add_state", "*", "fk_utm_country_id='$country_id' AND transaction_status='1'");
    echo "<option value=''>Select State</option>";
    if ($stateData != 0) {
        foreach ($stateData as $row) {
            echo "<option value='$row[pk_utm_state_id]'>$row[state_name]</option>";
        }
    } else
        echo "<option value=''>No State Add in this Country</option>";
}


if (isset($_POST["isset_dependent_state_for_district"])) {
    $state_id = $_POST["selected_id"];
    $districtData = $sfa_ent->fetch_data($conn, "utm_add_city", "*", "fk_utm_state_id='$state_id' AND transaction_status='1'");
    echo "<option value=''>Select District</option>";
    if ($districtData != 0) {
        foreach ($districtData as $row) {
            echo "<option value='$row[pk_utm_city_id]'>$row[city_name]</option>";
        }
    } else {
        echo "<option value=''>No District Add in this State</option>";
    }
}



if (isset($_POST["isset_EntityMIS"])) {
    $date_form = trim($_POST['date_form']);
    $date_to = trim($_POST['date_to']);
    $establishmentType = trim($_POST['establishmentType']);
    $state = trim($_POST['state']);
    $district = trim($_POST['district']);
    $zone = trim($_POST['zone']);
    $region = trim($_POST['region']);

    ?>
    <div class="box-body ">
        <div class="table-responsive" style='overflow-x:scroll;'>
            <table class="table table-bordered table-hover m-0" id='regservice'>
                <thead>
                    <tr style=''>
                        <th class="text-center text-nowrap" scope='col'>S.No</th>
                        <th class="text-center text-nowrap" scope='col'>Date</th>
                        <th class="text-center text-nowrap" scope='col'>Entity Code</th>
                        <th class="text-center text-nowrap" scope='col'>Entity Name</th>
                        <th class="text-center text-nowrap" scope='col'>Type</th>
                        <th class="text-center text-nowrap" scope='col'>Zone</th>
                        <th class="text-center text-nowrap" scope='col'>State</th>
                        <th class="text-center text-nowrap" scope='col'>City</th>
                        <th class="text-center text-nowrap" scope='col'>Mobile No</th>
                        <th class="text-center text-nowrap" scope='col'>Login Password</th>
                        <th class="text-center text-nowrap" scope='col'>Status</th>
                        <th class="text-center text-nowrap" scope='col'>Action</th>
                    </tr>
                </thead>
                <tbody>
                    <?php
                    $sno = 1;
                    $condition = '1';
                    if ($zone != '') {
                        $condition .= " AND a.`zone_id`='$zone'";
                    }
                    if ($establishmentType != '') {
                        $condition .= " AND a.`fk_sfa_cnf_entitytype_id`='$establishmentType'";
                    }

                    if ($date_form != '') {
                        $condition .= " AND str_to_date(a.`ins_date`,'%d/%m/%Y') >= str_to_date('$date_form','%d/%m/%Y')";
                    }

                    if ($date_to != '') {
                        $condition .= " AND str_to_date(a.`ins_date`,'%d/%m/%Y') <= str_to_date('$date_to','%d/%m/%Y')";
                    }

                    if ($region != '') {
                        $condition .= " AND a.`region_id`='$region'";
                    }
                    if ($state != '') {
                        $condition .= " AND a.`state_id`='$state'";
                    }
                    if ($district != '') {
                        $condition .= " AND a.`city_id`='$district'";
                    }

                    $entityData = $sfa_ent->fetch_data($conn, "sfa_ent_mst_entity as a LEFT JOIN sfa_cnf_mst_entity_type AS b ON a.fk_sfa_cnf_entitytype_id=b.pk_sfa_cnf_entitytype_id LEFT JOIN cnf_mst_zone AS c ON a.zone_id = c.pk_cnf_zone_id LEFT JOIN utm_add_state AS d ON a.state_id=d.pk_utm_state_id LEFT JOIN utm_add_city AS e ON a.city_id=e.pk_utm_city_id", "a.*,b.type_name,c.zone_name,d.state_name,e.city_name", $condition);
                    // $sfa_ent->debug($entityData);
                
                    if ($entityData != 0) {
                        $passname = "sfa_ent_mst_entity-" . "transaction_status";
                        foreach ($entityData as $row) {
                            $id = $row['id'];
                            $status = $row['transaction_status'];
                            $stypeid = "id-" . $id;
                            ?>
                            <tr style=''>
                                <td class='text-nowrap'>
                                    <?php echo $sno ?>
                                </td>
                                <td class='text-nowrap'>
                                    <?php echo $row['ins_date'] ?>
                                </td>
                                <td class='text-nowrap'>
                                    <?php echo $row['pk_sfa_ent_entity_id'] ?>
                                </td>
                                <td class='text-nowrap'>
                                    <?php echo $row['entity_name'] ?>
                                </td>
                                <td class='text-nowrap'>
                                    <?php echo $row['type_name'] ?>
                                </td>
                                <td class='text-nowrap'>
                                    <?php echo $row['zone_name'] ?>
                                </td>
                                <td class='text-nowrap'>
                                    <?php echo $row['state_name'] ?>
                                </td>
                                <td class='text-nowrap'>
                                    <?php echo $row['city_name'] ?>
                                </td>
                                <td class='text-nowrap'>
                                    <?php echo $row['contact_no1'] ?>
                                </td>
                                <td class='text-nowrap'>
                                    <?php echo $row['login_password'] ?>
                                </td>
                                <?php
                                if ($status == '1')
                                    echo '<td> <span class="label-success label label-default">Active</span></td>';
                                else
                                    echo '<td> <span class="label-default label label-danger">Block</span></td>';
                                ?>
                                <td class='text-nowrap'>
                                    <a href='javascript:void(0)' class='btn btn-danger btn-xs' id='blk<?php echo $stypeid; ?>'
                                        onClick="block('<?php echo $stypeid; ?>','<?php echo $passname; ?>','10')" <?php if ($status == 0) { ?> style="display:none" <?php } ?> title="Block Record">B</a>
                                    <a href='javascript:void(0)' class='btn btn-info btn-xs' id='act<?php echo $stypeid; ?>'
                                        onclick="actived('<?php echo $stypeid; ?>','<?php echo $passname; ?>','10')" <?php if ($status == 1) { ?> style="display:none" <?php } ?> title="Active Record">A</a>
                                    <a href="sfa_ent_frm_update_entity.php?pg=VlZSTkxWQTROQT09&md=VlZOTkxVMDA=&ent_id=<?php echo $row['pk_sfa_ent_entity_id']; ?>"
                                        class="btn btn-warning btn-xs" title="Edit Details">E</a>
                                    <a href="sfa_ent_rep_full_view.php?pg=VlZSTkxWQTROQT09&md=VlZOTkxVMDA=&ent_id=<?php echo $row['pk_sfa_ent_entity_id']; ?>" target="_blank" class="btn btn-success btn-xs"
                                        onClick="viewpopup('<?php echo $id ?>')" id="view<?php echo $id ?>"
                                        title="View Details">V</a>
                                </td>
                            </tr>
                            <?php
                            $sno++;
                        }
                    }


                    ?>
                </tbody>
            </table>
        </div>
    </div>

    <?php
}


if(isset($_POST['isset_individual_bulk_update'])){
    $establishmentType = trim($_POST['establishmentType']);
    $state = trim($_POST['state']);
    $district = trim($_POST['district']);
    $zone = trim($_POST['zone']);
    $region = trim($_POST['region']);
    $response_arr = array();

    ?>
    <div class="box-body ">
        <div class="table-responsive" style='overflow-x:scroll;'>
            <table class="table table-bordered table-hover m-0" id='regservice'>
                <thead>
                    <tr style=''>
                        <th class="text-nowrap" scope='col'>S.No</th>
                        <th class="text-nowrap" scope='col'>Entity Code</th>
                        <th class="text-nowrap" scope='col'>Entity Name</th>
                        <th class="text-nowrap" scope='col'>Address</th>
                        <th class="text-nowrap" scope='col'>State</th>
                        <th class="text-nowrap" scope='col'>City</th>
                        <th class="text-nowrap" scope='col'>Zone</th>
                        <th class="text-nowrap" scope='col'>Region</th>
                        <th class="text-nowrap" scope='col'>GST No</th>
                        <th class="text-nowrap" scope='col'>Email ID</th>
                        <th class="text-nowrap" scope='col'>Mobile</th>
                        <th class="text-nowrap" scope='col'>Action</th>
                    </tr>
                </thead>
                <tbody>
                    <?php
                    $sno = 1;
                    $condition = '1';
                    if ($zone != '') {
                        $condition .= " AND a.`zone_id`='$zone'";
                    }
                    if ($establishmentType != '') {
                        $condition .= " AND a.`fk_sfa_cnf_entitytype_id`='$establishmentType'";
                    }


                    if ($region != '') {
                        $condition .= " AND a.`region_id`='$region'";
                    }
                    if ($state != '') {
                        $condition .= " AND a.`state_id`='$state'";
                    }
                    if ($district != '') {
                        $condition .= " AND a.`city_id`='$district'";
                    }

                    $entityData = $sfa_ent->fetch_data($conn, "sfa_ent_mst_entity as a LEFT JOIN sfa_cnf_mst_entity_type AS b ON a.fk_sfa_cnf_entitytype_id=b.pk_sfa_cnf_entitytype_id LEFT JOIN cnf_mst_zone AS c ON a.zone_id = c.pk_cnf_zone_id LEFT JOIN utm_add_state AS d ON a.state_id=d.pk_utm_state_id LEFT JOIN utm_add_city AS e ON a.city_id=e.pk_utm_city_id", "a.*,b.type_name,c.zone_name,d.state_name,e.city_name", $condition);
                    // $sfa_ent->debug($entityData);
                    
                
                    if ($entityData != 0) {
                        $passname = "sfa_ent_mst_entity-" . "transaction_status";
                        foreach ($entityData as $row) {
                            $id = $row['id'];
                            $status = $row['transaction_status'];
                            $stypeid = "id-" . $id;
                            ?>
                            <tr id='tr_div_<?php echo $id ?>'>
                                <td class='text-nowrap'>
                                    <?php echo $sno ?>
                                </td>
                                <td class='text-nowrap'>
                                    <?php echo $row['pk_sfa_ent_entity_id'] ?>
                                </td>
                                <td class='text-nowrap'>
                                    <?php echo $row['entity_name'] ?>
                                </td>
                                <td class='text-nowrap'>
                                    <?php echo $row['zone_name'] ?>
                                </td>
                                <td class='text-nowrap' style='width:100px;'>
                                    <select id="state<?php echo $id; ?>" class="form-control" style='width:100px;' name="state" onchange="DependantDropDown('state<?php echo $id; ?>', 'district<?php echo $id; ?>','ajaxpage/get_data_ajax.php', 'isset_dependent_state_for_district')">
                                    <?php
                                        $stateData = $sfa_ent->fetch_data($conn, "utm_add_state", "*", "fk_utm_country_id='$row[country_id]' AND transaction_status='1'");
											if ($stateData != 0) {
												foreach ($stateData as $row1) {
													if ($row1['pk_utm_state_id'] == $row['state_id']) {
													    echo "<option value='$row1[pk_utm_state_id]' selected>$row1[state_name]</option>";
													} else {
                                                        echo "<option value='$row1[pk_utm_state_id]'>$row1[state_name]</option>";
													}
												}
											}
                                    ?>
									</select>
                                </td>
                                <td class='text-nowrap'>
                                        <select id="district<?php echo $id; ?>" style='width:100px;' class="form-control" name='district'>
													<?php
													$districtData = $sfa_ent->fetch_data($conn, "utm_add_city", "*", "fk_utm_state_id='$row[state_id]' AND transaction_status='1'");
													echo "<option value=''>Select District</option>";
													if ($districtData != 0) {
														foreach ($districtData as $row2) {
															if ($row2['pk_utm_city_id'] == $row['city_id']) {
																echo "<option value='$row2[pk_utm_city_id]' selected >$row2[city_name]</option>";
															} else {
																echo "<option value='$row2[pk_utm_city_id]'>$row2[city_name]</option>";
															}
														}
													}
													?>
												</select>
                                </td>
                                <td class='text-nowrap'>
                                    <select id="zone<?php echo $id; ?>" class="form-control" style='width:100px;'
													onchange="DependantDropDown('zone<?php echo $id; ?>', 'region<?php echo $id; ?>','ajaxpage/get_data_ajax.php', 'isset_dependent_zone')"
													name='zone' required>
													<?php
													$retval = $sfa_ent->fetch_data($conn, "cnf_mst_zone ", "*", "transaction_status='1'");
													if ($retval != 0) {
														foreach ($retval as $zoneData) {
															?>
															<option value='<?php echo $zoneData['pk_cnf_zone_id'] ?>' <?php echo ($zoneData['pk_cnf_zone_id'] == $row['zone_id']) ? "selected" : ""; ?>>
																<?php echo $zoneData['zone_name'] ?>
															</option>
															<?php
														}
													}
													?>
												</select>
                                </td>
                                <td class='text-nowrap'>
                                                <select id="region<?php echo $id; ?>" class="form-control" name='region' style='width:100px;'>
														<?php
														$zonesData = $sfa_ent->fetch_data($conn, "cnf_mst_region", "*", "transaction_status='1' AND fk_cnf_zone_id='$row[zone_id]'");
														if ($zonesData != 0) {
															foreach ($zonesData as $regionData) {
																?>
																<option value='<?php echo $regionData['pk_cnf_region_id'] ?>' <?php echo ($regionData['pk_cnf_region_id'] == $row['region_id']) ? "selected" : ""; ?>>
																	<?php echo $regionData['region_name'] ?>
																</option>
																<?php
															}
														}
														?>
													</select>
                                </td>
                                <td class="text-nowrap">
                                    <input type="text"
                                        class="form-control" name="gst_no" id="gst_no<?php echo $id; ?>" aria-describedby="helpId" placeholder="" value="<?php echo $row['gstn_no']; ?>">
                                </td>
                                <td class="text-nowrap">
                                    <input type="text"
                                        class="form-control" name="email" id="email<?php echo $id; ?>" aria-describedby="helpId" placeholder="" value="<?php echo $row['ent_email']; ?>">
                                </td>
                                <td class="text-nowrap">
                                    <input type="text"
                                        class="form-control" name="mobile" id="mobile<?php echo $id; ?>" aria-describedby="helpId" placeholder="" value="<?php echo $row['contact_no1'] ?>">
                                </td>

                                
                                <td class='text-nowrap'>
                                    <a href="javascript:void(0)" class="btn btn-info" title="Edit Details" onclick='individual_bulk_Update("<?php echo $id ?>","tr_div_<?php echo $id ?>")'>UPDATE</a>
                                </td>
                            </tr>
                            <?php
                            $sno++;
                        }
                    }


                    ?>
                </tbody>
            </table>
        </div>
    </div>

    <?php    
    
}


if (isset($_POST['isset_var'])) {
    if ($_POST['isset_var'] == 'isset_bank_details_update') {
        $entityID = trim($_POST['id']);
        $result = $sfa_ent->fetch_data($conn, "sfa_ent_tns_entity_bank_accounts", "*", "fk_sfa_ent_entity_id='$entityID'");
        if ($result != 0) {
            ?>
            <div class="table-responsive" style="overflow-x: auto;">
                <table id="example1" class="table table-bordered table-striped table-hover display table_design">
                    <thead>
                        <tr class="info">
                            <th style='min-width:189px;'>Account Holder Name<span style="color:#FF0000">*</span></th>
                            <th>Account<i class='invisible'>_</i>No<span style="color:#FF0000">*</span></th>
                            <th>Account<i class='invisible'>_</i>Type<span style="color:#FF0000">*</span></th>
                            <th>Bank<i class='invisible'>_</i>Name<span style="color:#FF0000">*</span></th>
                            <th>Branch<i class='invisible'>_</i>Name<span style="color:#FF0000">*</span></th>
                            <th>IFSC<i class='invisible'>_</i>Code<span style="color:#FF0000">*</span></th>
                            <th style='min-width: 100px;'>Swift</th>
                            <th width="8%">Action</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php
                        foreach ($result as $row) {
                            $id = $row["pk_sfa_ent_bankaccount_id"];
                            ?>
                            <tr id='tr_count_<?php echo $id ?>'>
                                <td>
                                    <input type="text" name='holder_name_<?php echo $id; ?>' id="holder_name_<?php echo $id; ?>"
                                        class="form-control" value="<?php echo $row['holder_name']; ?>">
                                </td>
                                <td>
                                    <input type="text" name="account_no_<?php echo $id ?>" id="account_no_<?php echo $id ?>"
                                        class="form-control" value='<?php echo $row['account_no']; ?>'>
                                </td>
                                <td>
                                    <select class="form-select form-select-lg form-control" name="account_type_<?php echo $id ?>"
                                        id="account_type_<?php echo $id ?>">
                                        <option value=''>--Select--</option>
                                        <option value='saving' <?php echo ($row['account_type'] == 'saving') ? "selected" : ""; ?>>Saving
                                        </option>
                                        <option value='current' <?php echo ($row['account_type'] == 'current') ? "selected" : ""; ?>>
                                            Current
                                        </option>
                                    </select>
                                </td>
                                <td>
                                    <input type="text" name="bank_name_<?php echo $id ?>" id="bank_name_<?php echo $id ?>"
                                        class="form-control" value="<?php echo $row['bank_name']; ?>">
                                </td>
                                <td>
                                    <input type="text" name="branch_name_<?php echo $id ?>" id="branch_name_<?php echo $id ?>"
                                        class="form-control" value="<?php echo $row['branch_name']; ?>">
                                </td>
                                <td>
                                    <input type="text" name="ifsc_code_<?php echo $id ?>" id="ifsc_code_<?php echo $id ?>"
                                        class="form-control" value="<?php echo $row['ifsc_code']; ?>">

                                </td>
                                <td>
                                    <input type="text" name="swift_code_<?php echo $id ?>" id="swift_code_<?php echo $id ?>"
                                        class="form-control" value="<?php echo $row['swift_code']; ?>">
                                </td>
                                <!-- deleteData(['database_table_name', 'database_col_id', 'tr_id']) -->
                                <td>
                                    <a href="javascript:void(0)"
                                        onClick="updateBankDetails('<?php echo $id; ?>','<?php echo $entityID; ?>')"
                                        class="btn btn-info btn-xs" title="Edit Details">E</a>
                                    <a href='javascript:void(0)'
                                        onClick="deleteData(['sfa_ent_tns_entity_bank_accounts','<?php echo $id; ?>','isset_delete_bank_account_update'])"
                                        class='btn btn-danger btn-xs' title="Active Record">D</a>
                                </td>
                            </tr>
                        <?php } ?>
                    </tbody>
                </table>
            </div>
        <?php }
    }

    if ($_POST['isset_var'] == 'isset_contact_details_update') {
            $entityID = trim($_POST['id']);
            $result = $sfa_ent->fetch_data($conn, "sfa_ent_mst_contact_master", "*", "fk_sfa_ent_entity_id='$entityID'");
            if ($result != 0) {
                ?>
                <div class="table-responsive" style="overflow-x:auto;">
                    <table id="example1" class="table table-bordered table-striped table-hover display table_design">
                        <thead>
                            <tr class="info">
                                <th style='min-width:189px;'>Person Name<span style="color:#FF0000">*</span></th>
                                <th style='min-width:160px;'>Designation</th>
                                <th style='min-width:160px;'>Contact<i class='invisible'>_</i>No</th>
                                <th style='min-width:160px;'>Contact<i class='invisible'>_</i>No2</th>
                                <th style='min-width:160px;'>Landline</th>
                                <th style='min-width:250px;'>Email</th>
                                <th style='min-width:160px;'>Remark</th>
                                <th width="8%">Action</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php
                            foreach ($result as $row) {
                                $id = $row["pk_sfa_ent_contact_id"];
                                ?>
                                <tr id='tr_count_<?php echo $id ?>'>
                                    <td class='text-nowrap'>
                                        <input type="text" name="person_name_<?php echo $id; ?>" id="person_name_<?php echo $id; ?>"
                                            value="<?php echo $row['contact_name']; ?>" class='form-control'>
                                    </td>
                                    <td class='text-nowrap'>
                                        <input type="text" name="person<?php echo $id; ?>" id="designation_<?php echo $id; ?>"
                                            value="<?php echo $row['designation']; ?>" class='form-control'>
                                    </td>
                                    <td class='text-nowrap'>
                                        <input type="text" name="person<?php echo $id; ?>" id="mobile1_<?php echo $id; ?>"
                                            value="<?php echo $row['mobile1']; ?>" class='form-control'>
                                    </td>
                                    <td class='text-nowrap'>
                                        <input type="text" name="person<?php echo $id; ?>" id="mobile2_<?php echo $id; ?>"
                                            value="<?php echo $row['mobile2']; ?>" class='form-control'>
                                    </td>
                                    <td class='text-nowrap'>
                                        <input type="text" name="person<?php echo $id; ?>" id="landline_<?php echo $id; ?>"
                                            value="<?php echo $row['landline']; ?>" class='form-control'>
                                    </td>
                                    <td class='text-nowrap'>
                                        <input type="text" name="person<?php echo $id; ?>" id="email_<?php echo $id; ?>"
                                            value="<?php echo $row['email']; ?>" class='form-control'>
                                    </td>
                                    <td class='text-nowrap'>
                                        <input type="text" name="person<?php echo $id; ?>" id="remark_<?php echo $id; ?>"
                                            value="<?php echo $row['contact_remark']; ?>" class='form-control'>
                                    </td>
                                    <!-- deleteData(['database_table_name', 'database_col_id', 'tr_id']) -->
                                    <td class='text-nowrap'>
                                        <a href="javascript:void(0)"
                                            onClick="updateContactDetailsEnt('<?php echo $id; ?>','<?php echo $entityID; ?>')"
                                            class="btn btn-info btn-xs" title="Edit Details">E</a>
                                        <a href='javascript:void(0)'
                                            onClick="deleteData(['sfa_ent_mst_contact_master','<?php echo $id; ?>','isset_delete_contact_entity_update'])"
                                            class='btn btn-danger btn-xs' title="Active Record">D</a>
                                    </td>
                                </tr>
                            <?php } ?>
                        </tbody>
                    </table>
                </div>
            <?php }
        
    }


    if ($_POST['isset_var'] == 'isset_bank_details_full_report') {
        $entityID = trim($_POST['id']);
        $result = $sfa_ent->fetch_data($conn, "sfa_ent_tns_entity_bank_accounts", "*", "fk_sfa_ent_entity_id='$entityID'");
        if ($result != 0) {
            ?>
            <div class="table-responsive" style="overflow-x: auto;">
                <table id="example1" class="table table-bordered table-striped table-hover display table_design">
                    <thead>
                        <tr class="info">
                            <th style='min-width:189px;'>Account Holder Name<span style="color:#FF0000">*</span></th>
                            <th>Account<i class='invisible'>_</i>No<span style="color:#FF0000">*</span></th>
                            <th>Account<i class='invisible'>_</i>Type<span style="color:#FF0000">*</span></th>
                            <th>Bank<i class='invisible'>_</i>Name<span style="color:#FF0000">*</span></th>
                            <th>Branch<i class='invisible'>_</i>Name<span style="color:#FF0000">*</span></th>
                            <th>IFSC<i class='invisible'>_</i>Code<span style="color:#FF0000">*</span></th>
                            <th style='min-width: 100px;'>Swift</th>
                            <th width="8%">Action</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php
                        foreach ($result as $row) {
                            $id = $row["pk_sfa_ent_bankaccount_id"];
                            ?>
                            <tr id='tr_count_<?php echo $id ?>'>
                                <td>
                                    <?php echo $row['holder_name']; ?>
                                </td>
                                <td>
                                    <?php echo $row['account_no']; ?>
                                </td>
                                <td>
                                    <?php echo $row['account_type']; ?>
                                </td>
                                <td>
                                    <?php echo $row['bank_name']; ?>
                                </td>
                                <td>
                                    <?php echo $row['branch_name']; ?>
                                </td>
                                <td>
                                    <?php echo $row['ifsc_code']; ?>

                                </td>
                                <td>
                                    <?php echo $row['swift_code']; ?>
                                </td>
                                <td>
                                    <?php 
                                    if($row['transaction_status'] == 1){
                                        echo "<span class='badge bg-success'>Active</span>";
                                    }else{
                                        echo "<span class='badge bg-badge'>Blocked</span>";
                                    }
                                    ?>
                                </td>
                            </tr>
                        <?php } ?>
                    </tbody>
                </table>
            </div>
        <?php }
    }

    if ($_POST['isset_var'] == 'isset_contact_details_full_report') {
            $entityID = trim($_POST['id']);
            $result = $sfa_ent->fetch_data($conn, "sfa_ent_mst_contact_master", "*", "fk_sfa_ent_entity_id='$entityID'");
            if ($result != 0) {
                ?>
                <div class="table-responsive" style="overflow-x:auto;">
                    <table id="example1" class="table table-bordered table-striped table-hover display table_design">
                        <thead>
                            <tr class="info">
                                <th style='min-width:189px;'>Person Name<span style="color:#FF0000">*</span></th>
                                <th>Designation</th>
                                <th>Contact<i class='invisible'>_</i>No</th>
                                <th>Contact<i class='invisible'>_</i>No2</th>
                                <th>Landline</th>
                                <th>Email</th>
                                <th>Remark</th>
                                <th width="8%">Action</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php
                            foreach ($result as $row) {
                                $id = $row["pk_sfa_ent_contact_id"];
                                ?>
                                <tr id='tr_count_<?php echo $id ?>'>
                                    <td class='text-nowrap'>
                                        <?php echo $row['contact_name']; ?>
                                    </td>
                                    <td class='text-nowrap'>
                                        <?php echo $row['designation']; ?>
                                    </td>
                                    <td class='text-nowrap'>
                                        <?php echo $row['mobile1']; ?>
                                    </td>
                                    <td class='text-nowrap'>
                                        <?php echo $row['mobile2']; ?>
                                    </td>
                                    <td class='text-nowrap'>
                                        <?php echo $row['landline']; ?>
                                    </td>
                                    <td class='text-nowrap'>
                                        <?php echo $row['email']; ?>
                                    </td>
                                    <td class='text-nowrap'>
                                        <?php echo $row['contact_remark']; ?>
                                    </td>
                                    <!-- deleteData(['database_table_name', 'database_col_id', 'tr_id']) -->
                                    <td class='text-nowrap'>
                                    <?php 
                                    if($row['transaction_status'] == 1){
                                        echo "<span class='badge bg-success'>Active</span>";
                                    }else{
                                        echo "<span class='badge bg-badge'>Blocked</span>";
                                    }
                                    ?>
                                    </td>
                                </tr>
                            <?php } ?>
                        </tbody>
                    </table>
                </div>
            <?php 
            }
        
    }

}


if(isset($_POST['isset_searchContact'])){
    $response_arr = array();
    if(isset($_POST['search_for'])){
        // $sfa_ent->debug($_POST);
        $text = $_POST['enterText'];
        $mobile = $_POST['mobile'];
        $table_Selected = "sfa_ent_mst_entity";
        $selected_column = "*";
        $condition = "1";
        if($_POST['search_for'] == 'contact'){
            if($text != ''){
                $table_Selected = "sfa_ent_mst_entity as a RIGHT JOIN sfa_ent_mst_contact_master as b ON a.pk_sfa_ent_entity_id=b.fk_sfa_ent_entity_id";
                $selected_column = "a.*,b.*";
                $condition = "b.contact_name LIKE '%$text%'";
            }
            if($mobile != ''){
                $table_Selected = "sfa_ent_mst_entity as a RIGHT JOIN sfa_ent_mst_contact_master as b ON a.pk_sfa_ent_entity_id=b.fk_sfa_ent_entity_id";
                $selected_column = "a.*,b.*";
                $condition = "b.mobile1 LIKE '%$mobile%' OR b.mobile2 LIKE '%$mobile%'";
            }
            if($text != '' && $mobile != ''){
                $table_Selected = "sfa_ent_mst_entity as a RIGHT JOIN sfa_ent_mst_contact_master as b ON a.pk_sfa_ent_entity_id=b.fk_sfa_ent_entity_id";
                $selected_column = "a.*,b.*";
                $condition = "b.contact_name LIKE '%$text%' OR b.mobile1 LIKE '%$mobile%' OR b.mobile2 LIKE '%$mobile%'";
            }
        }
        
        if($_POST['search_for'] == 'entity'){
            if($text != ''){
                $table_Selected = "sfa_ent_mst_entity";
                $selected_column = "*";
                $condition = "entity_name LIKE '%$text%'";
            }
            if($mobile != ''){
                $table_Selected = "sfa_ent_mst_entity";
                $selected_column = "*";
                $condition = "contact_no1 LIKE '%$mobile%' OR contact_no2 LIKE '%$mobile%'";
            }
            if($text !='' && $mobile !='' ){
                $table_Selected = "sfa_ent_mst_entity";
                $selected_column = "*";
                $condition = "entity_name LIKE '%$text%' OR contact_no1 LIKE '%$mobile%' OR contact_no2 LIKE '%$mobile%'";
            }
        }
        
        // $sfa_ent->debug($condition);
        $entityData = $sfa_ent->fetch_data($conn, $table_Selected,$selected_column, $condition);
        // $sfa_ent->debug($entityData);
        if($entityData != 0){
    ?>
    <div class="table-responsive" style="overflow-x: auto;">
        <table class="table table-striped table-hover table-borderless align-middle table_design_search_contact table-sm">
            <thead>
                <tr>
                    <th>S.No</th>
                    <th style='min-width:600px;'>Organization Name & Address </th>
                    <th></th>
                </tr>
            </thead>
            <tbody class="table-group-divider">
                <?php $sno = 1; foreach ($entityData as $v) {?>
                <tr>
                    <td scope="row" style='vertical-align:middle;'><?php echo $sno; ?></td>
                    <td class='p-0' style='vertical-align:middle;'>
                        <table style="width:100%;" class="table_search_inner">
                            <tr>
                                <td><b style='font-size:16px; font-weight:800;'><?php echo $v['entity_name'] ?></b></td>
                            </tr>
                            <tr>
                                <td><?php echo $v['entity_address'] ?></td>
                            </tr>
                            <tr>
                                <td><?php echo $v['contact_no1'] ?></td>
                            </tr>
                            <tr>
                                <td><?php echo $v['contact_no2'] ?></td>
                            </tr>
                            <tr>
                                <td><?php echo $v['ent_email'] ?></td>
                            </tr>
                            <tr>
                                <td>
                                    <a href="sfa_ent_frm_update_entity.php?pg=VlZSTkxWQTROQT09&md=VlZOTkxVMDA=&ent_id=<?php echo $v['pk_sfa_ent_entity_id']; ?>" target='_blank'><button class="btn btn-primary m-2">Edit</button></a>
                                    <button class="btn btn-primary" onclick="editpopup('<?php echo $v['pk_sfa_ent_entity_id'] ?>','ajaxpage/contact_search_edit_popup.php')">Add Contact</button>
                                </td>
                            </tr>
                        </table>
                    </td>
                    <td class='p-0'>
                        <div class="table-responsive">
                            <table id="example1" class="table table-bordered table-striped table-hoverdisplay table_design m-0">
                                <?php 
                                
                                $contactDetails = $sfa_ent->fetch_data($conn, "sfa_ent_mst_contact_master", "*", "fk_sfa_ent_entity_id='$v[pk_sfa_ent_entity_id]'");
                                // $sfa_ent->debug($contactDetails);
                                if ($contactDetails != 0) {
?>
<thead>
                                    <tr class="info">
                                        <th>Person<i class='invisible'>_</i>Name</th>
                                        <th>Designation</th>
                                        <th>Contact<i class='invisible'>_</i>No</th>
                                        <th>Contact<i class='invisible'>_</i>No2</th>
                                        <th>Landline</th>
                                        <th>Email</th>
                                        <th>Remark</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php 
                                    foreach ($contactDetails as $cv) {
                                        echo "<tr>
                                        <td>
                                            $cv[contact_name]
                                        </td>
                                        <td>
                                            $cv[designation]
                                        </td>
                                        <td>
                                            $cv[mobile1]
                                        </td>
                                        <td>
                                            $cv[mobile2]
                                        </td>
                                        <td>
                                            $cv[landline]
                                        </td>
                                        <td>
                                            $cv[email]
                                        </td>    
                                        <td class='text-nowrap'>
                                            $cv[contact_remark]
                                        </td>    
                                    </tr>";
                                    }
                                    ?>                  
                                    
                                </tbody>
<?php 
                                }else{
?>
<tbody>                  
                                    <tr>
                                        <td colspan='6' class='text-left'>
                                            No Record Found
                                        </td>
                                    </tr>
                                </tbody>
<?php 
                                }

                                ?>
                                
                            </table>
                        </div>
                    </td>
                </tr>
                <?php $sno++; } ?>
            </tbody>
        </table>
    </div>
    <?php
    
        }else{
            echo "<h6 class='text-danger p-4'>No Data Available!!!</h6>";
        }
    }else{
        array_push($response_arr,'false','Search For Required',"#");
        echo json_encode($response_arr);
    }
}




?>