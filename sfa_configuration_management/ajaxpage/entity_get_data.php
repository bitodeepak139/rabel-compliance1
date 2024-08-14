<?php
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}
require_once "../../classfile/initialize.php";
require_once "../../classfile/sfa_configuration_management.php";
$retval = $sfa_query->fetch_data($conn,"sfa_cnf_mst_entity_type","*","1");
if ($retval != 0) {
	?>

	<div class="box">
		<!-- /.box-header -->
		<div class="box-body">
			<table id="regservice" class="table table-bordered table-hover display nowrap margin-top-10 table-responsive">
				<thead>
					<tr>
						<th width='8%'>Sr.<i class='invisible'>_</i>No</th>
						<th>TypeID</th>
						<th>Type Status</th>
						<th width='10%'>Status</th>
						<th width='6%'>Action</th>
					</tr>
				</thead>
				<tbody>
					<?php
					$slno = 1;
					$passname = "sfa_cnf_mst_entity_type-" . "transaction_status";
					foreach ($retval as $row) {
						$id = $row['id'];
						$type_id = $row['pk_sfa_cnf_entitytype_id'];
						$type_name = $row['type_name'];
						$status = $row['transaction_status'];
						$stypeid = "id-" . $id;
						?>
						<tr>
							<td>
								<?php echo $slno ?>
							</td>
							<td>
								<?php echo $type_id ?>
							</td>
							<td>
								<?php echo $type_name ?>
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
	echo '<p>No Module Added Yet.!</p>'; ?>