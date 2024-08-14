<?php
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}
require_once "../../classfile/initialize.php";
require_once "../../classfile/configuration_management.php";
$retval = $org_query->fetch_data($conn, "cnf_mst_zone as a INNER JOIN utm_add_country as b ON a.country_id = b.pk_utm_country_id", "a.*,b.country_name", "1");
if ($retval != 0) {
	?>

	<div class="box">
		<!-- /.box-header -->
		<div class="box-body">
			<table id="regservice" class="table table-bordered table-hover display nowrap margin-top-10 table-responsive">
				<thead>
					<tr>
						<th width='8%'>Sr. No</th>
						<th>Country</th>
						<th>Zone Name</th>
						<th>Details</th>
						<th width='10%'>Status</th>
						<th width='9%'>Action</th>
					</tr>
				</thead>
				<tbody>
					<?php
					$slno = 1;
					$passname = "cnf_mst_zone-" . "transaction_status";
					foreach ($retval as $row) {
						$id = $row['Id'];
						$country_name = $row['country_name'];
						$zone_name = $row['zone_name'];
						$details = $row['zone_details'];
						$status = $row['transaction_status'];
						$stypeid = "id-".$id;
						?>
						<tr>
							<td>
								<?php echo $slno ?>
							</td>
							<td>
								<?php echo $country_name ?>
							</td>
							<td>
								<?php echo $zone_name ?>
							</td>
							<td>
								<?php echo $details ?>
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
	echo '<p>No Department Added Yet.!</p>'; ?>