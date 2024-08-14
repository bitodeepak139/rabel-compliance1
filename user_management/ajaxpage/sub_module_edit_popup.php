<?php
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}
require_once "../../classfile/initialize.php";
require_once "../../classfile/user.php";
$id = $_POST['id'];
// $row = $user_query->get_page_editpopup($conn, $id);
$row = $user_query->fetch_data($conn, "usm_mst_submodule", "*", "`id`='$id'");
$module_id = $row[0]['fk_usm_module_id']; $sub_module_name = $row[0]['submodule_name']; $seqno = $row[0]['sm_seq']; $dashboard_url = $row[0]['dashboard_url'];
?>


<div class="modal-body">
    <div class="form-group row">
        <label for="example-text-input" class="col-sm-3 col-form-label">Select Module<span
                class="text-danger">*</span></label>
        <div class="col-sm-9">
            <select id="umodule" class="form-control" >
                <?php $retval = $user_query->fetch_data($conn,"usm_add_modules","*","`sub_module_status`='1' AND `transaction_status`='1'");
                foreach ($retval as $row) {
                    $mdid = $row['pk_usm_module_id'];
                    $module_name = $row['module_name'];
                    ?>
                    <option value="<?php echo $mdid ?>" <?php if ($module_id == $mdid)
                           echo "selected='selected'"; ?>>
                        <?php echo $module_name ?>
                    </option>
                <?php } ?>
            </select>
        </div>
    </div>
    <div class="form-group row">
        <label for="example-text-input" class="col-sm-3 col-form-label">Sub Module Name<span
                class="text-danger">*</span></label>
        <div class="col-sm-9">
            <input type="text" id="ucntname" class="form-control" value="<?php echo $sub_module_name ?>"
                autocomplete="off">
        </div>
    </div>
    <div class="form-group row">
        <label for="example-text-input" class="col-sm-3 col-form-label">Sub Module Url<span
                class="text-danger">*</span></label>
        <div class="col-sm-9">
            <input type="text" id="upgurl" class="form-control" value="<?php echo $dashboard_url ?>" autocomplete="off">
        </div>
    </div>
    <div class="form-group row">
        <label for="example-text-input" class="col-sm-3 col-form-label">Sequence No<span
                class="text-danger">*</span></label>
        <div class="col-sm-9">
            <input type="text" id="smseqno" class="form-control" value="<?php echo $seqno ?>" autocomplete="off"
                onkeypress='return (event.charCode !=8 && event.charCode ==0 || (event.charCode >= 48 && event.charCode <= 57))'>
        </div>
    </div>

</div>
<div class="modal-footer"> <a href="javascript:void(0)" class="btn btn-primary"
        onClick="edit('<?php echo $id ?>')">Update</a>
    <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
</div>