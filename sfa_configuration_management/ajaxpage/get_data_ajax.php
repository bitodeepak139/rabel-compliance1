<?php
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}
require_once "../../classfile/initialize.php";
require_once "../../classfile/sfa_configuration_management.php";

if (isset($_POST["isset_get_org_type"])) {
    $retval = $sfa_query->fetch_data($conn, "sfa_cnf_mst_organization_type a", "a.*,a.type_name as org_name", "1");
    if ($retval != 0) {
        ?>
        <div class="box">
            <!-- /.box-header -->
            <div class="box-body">
                <table id="regservice" class="table table-bordered table-hover display nowrap margin-top-10 table-responsive">
                    <thead>
                        <tr>
                            <th width='8%'>Sr.<i class='invisible'>_</i>No</th>
                            <th>ID</th>
                            <th>Organization Name</th>
                            <th width='10%'>Status</th>
                            <th width='6%'>Action</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php
                        $slno = 1;
                        $passname = "sfa_cnf_mst_organization_type-" . "transaction_status";
                        foreach ($retval as $row) {
                            $id = $row['id'];
                            $org_id = $row['pk_sfa_cnf_custype_id'];
                            $org_name = $row['org_name'];
                            $status = $row['transaction_status'];
                            $stypeid = "id-" . $id;
                            ?>
                            <tr>
                                <td>
                                    <?php echo $slno ?>
                                </td>
                                <td>
                                    <?php echo $org_id ?>
                                </td>
                                <td>
                                    <?php echo $org_name ?>
                                </td>
                                <?php
                                if ($status == '1')
                                    echo '<td> <span class="label-success label label-default">Active</span></td>';
                                else
                                    echo '<td> <span class="label-default label label-danger">Block</span></td>';
                                ?>
                                <td><a href='javascript:void(0)' class='btn btn-danger btn-xs' id='blk<?php echo $stypeid; ?>'
                                        onClick="block('<?php echo $stypeid; ?>','<?php echo $passname; ?>','3')" <?php if ($status == 0) { ?> style="display:none" <?php } ?> title="Block Record">B</a>
                                    <a href='javascript:void(0)' class='btn btn-info btn-xs' id='act<?php echo $stypeid; ?>'
                                        onclick="actived('<?php echo $stypeid; ?>','<?php echo $passname; ?>','3')" <?php if ($status == 1) { ?> style="display:none" <?php } ?> title="Active Record">A</a>
                                    <a href="javascript:void(0)" class="btn btn-warning btn-xs"
                                        onClick="editpopup('<?php echo $id ?>','ajaxpage/org_type_edit_popup.php')" id="edt<?php echo $id ?>"
                                        title="Edit Details">E</a>
                                </td>
                            </tr>
                            <?php $slno++;
                        } ?>
                    </tbody>
                </table>
            </div>
            <!-- /.box-body -->
        </div>
        <!-- /.box -->
    <?php } else
        echo '<p>No Module Added Yet.!</p>';
}



if(isset($_POST['isset_get_entity_category'])){
    $retval = $sfa_query->fetch_data($conn, "sfa_cnf_mst_entity_category a LEFT JOIN sfa_cnf_mst_entity_type as b ON a.fk_sfa_cnf_entitytype_id = b.pk_sfa_cnf_entitytype_id", "a.*,b.type_name", "1");
    if ($retval != 0) {
        ?>
        <div class="box">
            <!-- /.box-header -->
            <div class="box-body">
                <table id="regservice" class="table table-bordered table-hover display nowrap margin-top-10 table-responsive">
                    <thead>
                        <tr>
                            <th width='8%'>Sr.<i class='invisible'>_</i>No</th>
                            <th>Entity Type</th>
                            <th>Category Name</th>
                            <th>Category Details</th>
                            <th width='10%'>Status</th>
                            <th width='6%'>Action</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php
                        $slno = 1;
                        $passname = "sfa_cnf_mst_entity_category-" . "transaction_status";
                        foreach ($retval as $row) {
                            $id = $row['id'];
                            $entity_name = $row['type_name'];
                            $category_name = $row['category_name'];
                            $category_details = $row['category_details'];
                            $status = $row['transaction_status'];
                            $stypeid = "id-" . $id;
                            ?>
                            <tr>
                                <td>
                                    <?php echo $slno ?>
                                </td>
                                <td>
                                    <?php echo $entity_name ?>
                                </td>
                                <td>
                                    <?php echo $category_name ?>
                                </td>
                                <td>
                                    <?php echo $category_details ?>
                                </td>
                                <?php
                                if ($status == '1')
                                    echo '<td> <span class="label-success label label-default">Active</span></td>';
                                else
                                    echo '<td> <span class="label-default label label-danger">Block</span></td>';
                                ?>
                                <td><a href='javascript:void(0)' class='btn btn-danger btn-xs' id='blk<?php echo $stypeid; ?>'
                                        onClick="block('<?php echo $stypeid; ?>','<?php echo $passname; ?>','4')" <?php if ($status == 0) { ?> style="display:none" <?php } ?> title="Block Record">B</a>
                                    <a href='javascript:void(0)' class='btn btn-info btn-xs' id='act<?php echo $stypeid; ?>'
                                        onclick="actived('<?php echo $stypeid; ?>','<?php echo $passname; ?>','4')" <?php if ($status == 1) { ?> style="display:none" <?php } ?> title="Active Record">A</a>
                                    <a href="javascript:void(0)" class="btn btn-warning btn-xs"
                                        onClick="editpopup('<?php echo $id ?>','ajaxpage/entity_category_edit_popup.php')" id="edt<?php echo $id ?>"
                                        title="Edit Details">E</a>
                                </td>
                            </tr>
                            <?php $slno++;
                        } ?>
                    </tbody>
                </table>
            </div>
            <!-- /.box-body -->
        </div>
        <!-- /.box -->
    <?php } else
        echo '<p>No Module Added Yet.!</p>';
}


if(isset($_POST['isset_get_entity_sub_category'])){
    $retval = $sfa_query->fetch_data($conn, "sfa_cnf_mst_entity_subcategory a LEFT JOIN sfa_cnf_mst_entity_type as b ON a.fk_sfa_cnf_entitytype_id = b.pk_sfa_cnf_entitytype_id LEFT JOIN sfa_cnf_mst_entity_category as c ON a.fk_sfa_cnf_entcategory_id = c.pk_sfa_cnf_entcategory_id", "a.*,b.type_name,c.category_name", "1");
    if ($retval != 0) {
        ?>
        <div class="box">
            <!-- /.box-header -->
            <div class="box-body">
                <table id="regservice" class="table table-bordered table-hover display nowrap margin-top-10 table-responsive">
                    <thead>
                        <tr>
                            <th width='8%'>Sr.<i class='invisible'>_</i>No</th>
                            <th>Entity Type</th>
                            <th>Category Name</th>
                            <th>Sub Category Name</th>
                            <th>Details</th>
                            <th width='10%'>Status</th>
                            <th width='6%'>Action</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php
                        $slno = 1;
                        $passname = "sfa_cnf_mst_entity_subcategory-" . "transaction_status";
                        foreach ($retval as $row) {
                            $id = $row['id'];
                            $entity_name = $row['type_name'];
                            $category_name = $row['category_name'];
                            $subcategory_name = $row['subcategory_name'];
                            $subcategory_details = $row['subcategory_details'];
                            $status = $row['transaction_status'];
                            $stypeid = "id-" . $id;
                            ?>
                            <tr>
                                <td>
                                    <?php echo $slno ?>
                                </td>
                                <td>
                                    <?php echo $entity_name ?>
                                </td>
                                <td>
                                    <?php echo $category_name ?>
                                </td>
                                <td>
                                    <?php echo $subcategory_name ?>
                                </td>
                                <td>
                                    <?php echo $subcategory_details ?>
                                </td>
                                <?php
                                if ($status == '1')
                                    echo '<td> <span class="label-success label label-default">Active</span></td>';
                                else
                                    echo '<td> <span class="label-default label label-danger">Block</span></td>';
                                ?>
                                <td><a href='javascript:void(0)' class='btn btn-danger btn-xs' id='blk<?php echo $stypeid; ?>'
                                        onClick="block('<?php echo $stypeid; ?>','<?php echo $passname; ?>','5')" <?php if ($status == 0) { ?> style="display:none" <?php } ?> title="Block Record">B</a>
                                    <a href='javascript:void(0)' class='btn btn-info btn-xs' id='act<?php echo $stypeid; ?>'
                                        onclick="actived('<?php echo $stypeid; ?>','<?php echo $passname; ?>','5')" <?php if ($status == 1) { ?> style="display:none" <?php } ?> title="Active Record">A</a>
                                    <a href="javascript:void(0)" class="btn btn-warning btn-xs"
                                        onClick="editpopup('<?php echo $id ?>','ajaxpage/entity_sub_category_edit_popup.php')" id="edt<?php echo $id ?>"
                                        title="Edit Details">E</a>
                                </td>
                            </tr>
                            <?php $slno++;
                        } ?>
                    </tbody>
                </table>
            </div>
            <!-- /.box-body -->
        </div>
        <!-- /.box -->
    <?php } else
        echo '<p>No Module Added Yet.!</p>';
}

?>