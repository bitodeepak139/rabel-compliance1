<?php if (session_status() === PHP_SESSION_NONE) {
    session_start();
}
require_once "../../classfile/initialize.php";
require_once "../../classfile/user.php";
?>
<div class="modal-body">
    <div class="row">
        <div class="col-12">
            <form method="post" enctype="multipart/form-data" id="myform" >
                <div class="form-group row">
                    <label for="example-text-input" class="col-sm-3 col-form-label">Select Module<span
                            class="text-danger">*</span></label>
                    <div class="col-sm-9">
                        <select id="module" class="form-control" onchange="getseqno(this.value,'isset_get_seq','#smseqno')">
                            <option value="">Select Module</option>
                            <?php $retval = $user_query->fetch_data($conn,"usm_add_modules","*","`sub_module_status`=1 AND `transaction_status`='1'");
                            foreach ($retval as $row) {
                                $mdid = $row['pk_usm_module_id'];
                                $module_name = $row['module_name'];
                                ?>
                                <option value="<?php echo $mdid ?>">
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
                        <input type="text" id="smname" class="form-control" value="" autocomplete="off">
                    </div>
                </div>
                <div class="form-group row">
                    <label for="example-text-input" class="col-sm-3 col-form-label">Sub Module Url<span
                            class="text-danger">*</span></label>
                    <div class="col-sm-9">
                        <input type="text" id="smurl" class="form-control" value="" autocomplete="off">
                    </div>
                </div>
                <div class="form-group row">
                    <label for="example-text-input" class="col-sm-3 col-form-label">Sequence No<span
                            class="text-danger">*</span></label>
                    <div class="col-sm-9">
                        <input type="text" id="smseqno" class="form-control" value="" autocomplete="off"
                            onkeypress='return (event.charCode !=8 && event.charCode ==0 || (event.charCode >= 48 && event.charCode <= 57))'>
                    </div>
                </div>
            </form>
        </div>
        <!-- /.col -->
    </div>
    <!-- /.row -->
</div>
<div class="modal-footer"> <a href="javascript:void(0)" class="btn btn-primary" onClick="adddata()">Submit</a>
    <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
</div>