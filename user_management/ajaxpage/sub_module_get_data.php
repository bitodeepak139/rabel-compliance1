<?php
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}
require_once "../../classfile/initialize.php";
require_once "../../classfile/user.php";
$retval = $user_query->fetch_data($conn , "usm_mst_submodule a left join usm_add_modules as b on b.pk_usm_module_id=a.fk_usm_module_id","a.*,b.module_name","`submodule_status`='1'");
// fetch_data($conn, "usm_add_pages a left join usm_add_modules as b on b.pk_usm_module_id=a.fk_usm_module_id left join usm_mst_submodule as c on 	c.pk_usm_submodule_id=a.fk_usm_sub_module_id", "a.*,b.module_name,c.submodule_name", "1");

if ($retval != 0) {
    ?>
    <div class="box">
        <!-- /.box-header -->
        <div class="box-body">
            <table id="regservice" class="table table-bordered table-hover display nowrap margin-top-10 table-responsive">
                <thead>
                    <tr>
                        <th width='8%'>Sr. No</th>
                        <th>Module Name</th>
                        <th>Sub Module Code</th>
                        <th>Sub Module Name</th>
                        <th>Page Url</th>
                        <th>Seq No.</th>
                        <th width='10%'>Status</th>
                        <th width='6%'>Action</th>
                    </tr>
                </thead>
                <tbody>
                    <?php
                    $slno = 1;
                    $passname = "usm_mst_submodule-" . "submodule_status";
                    foreach ($retval as $row) {
                        $id = $row['id'];
                        $module_name = $row['module_name'];
                        $submodule_code = $row['pk_usm_submodule_id'];
                        $submodule_name = $row['submodule_name'];
                        $sm_sequence = $row['sm_seq'];
                        $dashboard_url = $row['dashboard_url'];
                        $status = $row['submodule_status'];
                        $stypeid = "id-" . $id;
                        // $page_name = $row['page_name'];
                        // $page_actual = $row['page_actual'];
                        ?>
                        <tr>
                            <td>
                                <?php echo $slno ?>
                            </td>
                            <td>
                                <?php echo $module_name ?>
                            </td>
                            <td>
                                <?php echo $submodule_code?>
                            </td>
                            <td>
                                <?php echo $submodule_name ?>
                            </td>
                            <td>
                                <?php echo $dashboard_url ?>
                            </td>
                            <td>
                                <?php echo $sm_sequence ?>
                            </td>
                            <?php
                            if ($status == '1')
                                echo '<td> <span class="label-success label label-default">Active</span></td>';
                            else
                                echo '<td> <span class="label-default label label-danger">Block</span></td>';
                            ?>
                            <td><a href='javascript:void(0)' class='btn btn-danger btn-xs' id='blk<?php echo $stypeid; ?>'
                                    onClick="block('<?php echo $stypeid; ?>','<?php echo $passname; ?>','6')" <?php if ($status == 0) { ?> style="display:none" <?php } ?> title="Block Record">B</a>
                                <a href='javascript:void(0)' class='btn btn-info btn-xs' id='act<?php echo $stypeid; ?>'
                                    onclick="actived('<?php echo $stypeid; ?>','<?php echo $passname; ?>','6')" <?php if ($status == 1) { ?> style="display:none" <?php } ?> title="Active Record">A</a>
                                <a href="javascript:void(0)" class="btn btn-warning btn-xs"
                                    onClick="editpopup('<?php echo $id ?>')" id="edt<?php echo $id ?>"
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
    echo '<p>No Sub Module Added Yet.!</p>'; ?>