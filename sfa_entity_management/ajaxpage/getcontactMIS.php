<?php
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}
require_once "../../classfile/initialize.php";
require_once "../../classfile/sfa_entity_management.php";

$data = $_POST['data'];
if ($data == 'All') {
    $condition = '1';
} else {
    $condition = " a.contact_name LIKE '$data%'";
}
// $sfa_ent->debug($condition);

$contactDetails = $sfa_ent->fetch_data($conn, "sfa_ent_mst_contact_master as a INNER JOIN sfa_ent_mst_entity as b ON a.fk_sfa_ent_entity_id=b.pk_sfa_ent_entity_id", "a.*,b.entity_name", $condition);
// $sfa_ent->debug($contactDetails);
if ($contactDetails != 0) {
    ?>
    <div class="table-responsive" style='overflow-x:auto;'>
        <table id="example1" class="table table-bordered table-striped table-hover display table_design">
            <thead>
                <tr class="info">
                    <th class="text-nowrap" >S.No</th>
                    <th class="text-nowrap"  style='min-width:189px;'>Name</th>
                    <th class="text-nowrap" >Organization<i class='invisible'>_</i>Name</th>
                    <th class="text-nowrap" >Mobile<i class='invisible'>_</i>No</th>
                    <th class="text-nowrap" >Alternate<i class='invisible'>_</i>No</th>
                    <th class="text-nowrap" >E-mail ID</th>
                    <th class="text-nowrap" >DOB</th>
                    <th class="text-nowrap" >DOM</th>
                    <th class="text-nowrap"  style='min-width: 100px;'>Status</th>
                    <th class="text-nowrap"  width="8%">Action</th>
                </tr>
            </thead>
            <tbody>
                <?php
                $sno = 1;
                foreach ($contactDetails as $row) {
                    $id = $row["pk_sfa_ent_contact_id"];
                    $status = $row['transaction_status'];
                    ?>
                    <tr id='tr_count_<?php echo $id ?>'>
                        <td class='text-nowrap'>
                            <?php echo $sno; ?>
                        </td>
                        <td class='text-nowrap'>
                            <?php echo $row['contact_name']; ?>
                        </td>
                        <td class='text-nowrap'>
                            <?php echo $row['entity_name']; ?>
                        </td>
                        <td class='text-nowrap'>
                            <?php echo $row['mobile1']; ?>
                        </td>
                        <td class='text-nowrap'>
                            <?php echo $row['mobile2']; ?>
                        </td>
                        <td class='text-nowrap'>
                            <?php echo $row['email']; ?>
                        </td>
                        <td class='text-nowrap'>
                            <?php echo $row['contact_dob'] ?>
                        </td>
                        <td class='text-nowrap'>
                            <?php echo $row['contact_dom'] ?>
                        </td>
                        <?php
                            if ($status == '1')
                            echo '<td class="text-nowrap"> <span class="label-success label label-default">Active</span></td>';
                            else
                            echo '<td class="text-nowrap"> <span class="label-default label label-danger">Block</span></td>';
                        ?>
                        <td class='text-nowrap'>
                            <a href="javascript:void(0)" class="btn btn-warning btn-xs" onclick="editpopup('<?php echo $id.'-'.$data; ?>','ajaxpage/contact_edit_popup.php')" title="Edit Details">E</a>
                            <a href="javascript:void(0)" class="btn btn-success btn-xs" onClick="viewpopup('<?php echo $id ?>')" id="view<?php echo $id ?>" title="View Details">V</a>
                        </td>
                    </tr>
                <?php $sno++; } ?>
            </tbody>
        </table>
    </div>
    <?php
}else{
    echo "<div class='border p-2 fs-3'> No Record Found</div>";
}

?>