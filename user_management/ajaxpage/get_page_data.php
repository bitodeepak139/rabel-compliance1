<?php
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}
require_once "../../classfile/initialize.php";
require_once "../../classfile/user.php";
$id = $_POST['id']; $moduleid = $_POST['moduleid'];
$retval = $user_query->get_page($conn,$id,$moduleid);
if ($retval != 0) {
?>

	<table id="regservice1" class="table table-bordered table-hover display nowrap margin-top-10 table-responsive">
		<thead>
			<tr>
				<th width='8%'>Sr. No</th>
				<th>Page Name</th>
				<th width='2%'><input type="checkbox" id="allch" name="allch" class="from-control"></th>
			</tr>
		</thead>
		<tbody>
			<?php
			$slno = 1;
			foreach ($retval as $row) {
				$id = $row['id']; $module_id = $row['pk_usm_page_id'];
				$page_name = $row['page_name'];
				$status = $row['transaction_status'];
			?>
				<tr>
					<td><?php echo $slno ?></td>
					<td><?php echo $page_name ?></td>
					<td><input type="checkbox" id="ch<?php echo $slno ?>" name="ch<?php echo $slno ?>" value="<?php echo $module_id ?>" class="storingch" <?php if ($status == 1) echo "checked='checked'" ?>></td>
				</tr>
			<?php $slno++;} ?>
			
		</tbody>
	</table>
	<input type="hidden" name="total" id="total" value="<?php echo $slno-1; ?>">
	<div class="form-group row">
                  <label for="example-text-input" class="col-sm-2 col-form-label"></label>
                  <div class="col-sm-10">
                    <a href="javascript:void(0)" onClick="adddata()" class="btn btn-success btn-lg">Submit</a>
                  </div>
                </div>
<?php } else echo '<p>No Page Found.!</p>'; ?>