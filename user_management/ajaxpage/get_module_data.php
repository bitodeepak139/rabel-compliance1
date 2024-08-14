<?php
if (session_status() === PHP_SESSION_NONE) {
	session_start();
}
require_once "../../classfile/initialize.php";
require_once "../../classfile/user.php";
$userId = $_POST['id'];
$retval = $user_query->get_module($conn, $userId);
if ($retval != 0) {
?>
	<table id="regservice1" class="table table-bordered table-hover display nowrap margin-top-10 table-responsive">
		<?php
		$mdsno = 1;
		foreach ($retval as $row) {
			$module_id = $row['pk_usm_module_id'];
			$module_name = $row['module_name'];
		?>
			<tr style='background:#576CBC;'>
				<th width='10%'>Module</th>
				<th colspan='2'>
					<?php echo $module_name; ?>
				</th>
			</tr>
			<?php
			$all_submodule = $user_query->fetch_data($conn, "usm_mst_submodule", "pk_usm_submodule_id,submodule_name,submodule_details,submodule_status", "`fk_usm_module_id`='$module_id' AND `submodule_status` = '1' order by `sm_seq` ASC");

			if ($all_submodule != 0) {
				foreach ($all_submodule as $singleSubModule) {
					$subModuleId = $singleSubModule['pk_usm_submodule_id'];
					// $user_query->debug($singleSubModule);
					echo "<tr style='background:#8d9bd1;'>
					<th>Sub Module</th>
					<th colspan='2'>
						$singleSubModule[submodule_name]
					</th>
				</tr>
				<tr style='background:#00E7FF;'>
					<th>Sno</th>
					<th colspan='2'>Pages</th>
				</tr>";
					$getAllPages = $user_query->fetch_data($conn, "usm_add_pages", "pk_usm_page_id,page_name,page_sequence", "`fk_usm_module_id`='$module_id' AND `fk_usm_sub_module_id`='$subModuleId' AND  `transaction_status`='1' order by page_sequence ASC");
					if ($getAllPages != 0) {
						$pgsno = 1;
						foreach ($getAllPages as $singlePage) {
							$pageId = $singlePage['pk_usm_page_id'];
							$getPageRight = $user_query->fetch_data(
								$conn,
								"usm_page_rights",
								"transaction_status",
								"`fk_usm_module_id`='$module_id' AND 
								`fk_usm_sub_module_id`='$subModuleId' AND `fk_usm_page_id`='$pageId' AND `fk_usm_user_id`='$userId'"
							);
							$rightStatus = 0;
							if ($getPageRight != 0) {
								$rightStatus = $getPageRight[0]['transaction_status'];
								$checkedstatus = '';
								if ($rightStatus) {
									$checkedstatus = 'checked';
								}
							}else{
								$checkedstatus = '';
							}

			?>
							<tr>
								<td><?php echo $pgsno ?></td>
								<td><?php echo $singlePage["page_name"] ?></td>
								<td>
									<input type='checkbox' id='ch<?php echo $pgsno ?>' name='ch<?php echo $pgsno ?>' value='' class='storingch' <?php echo $checkedstatus ?> onchange="updateRight('<?php echo $module_id ?>','<?php echo $pageId ?>','<?php echo $userId ?>','<?php echo $rightStatus ?>','<?php echo $subModuleId ?>')">
								</td>
							</tr>
						<?php
							$pgsno++;
						}
					} else {
						echo "<tr>
					<td colspan='3' style='text-align:center;'>Pages are Not Added yet!!!</td>
				</tr>";
					}
				}
			} else {
				echo "<tr style='background:#8d9bd1;'>
						<th>Sub Module</th>
						<th colspan='2'>No</th>
					</tr>
					<tr style='background:#00E7FF;'>
						<th>Sno</th>
						<th colspan='2'>Pages</th>
					</tr>";
				$getAllPages = $user_query->fetch_data($conn, "usm_add_pages", "pk_usm_page_id,page_name,page_sequence", "`fk_usm_module_id`='$module_id' AND `transaction_status`='1' order by page_sequence ASC");
				if ($getAllPages != 0) {
					$pgsno = 1;
					foreach ($getAllPages as $singlePage) {
						$pageId = $singlePage['pk_usm_page_id'];
						$getPageRight = $user_query->fetch_data(
							$conn,
							"usm_page_rights",
							"transaction_status",
							"`fk_usm_module_id`='$module_id' AND `fk_usm_page_id`='$pageId' AND `fk_usm_user_id`='$userId'"
						);
						$rightStatus = 0;
						if ($getPageRight != 0) {
							$rightStatus = $getPageRight[0]['transaction_status'];
							$checkedstatus = '';
							if ($rightStatus) {
								$checkedstatus = 'checked';
							}
						}else{
							$checkedstatus = '';
						}

						?>
						<tr>
							<td>
								<?php echo $pgsno ?>
							</td>
							<td>
								<?php echo $singlePage["page_name"] ?>
							</td>
							<td>
								<input type='checkbox' id='ch<?php echo $pgsno ?>' name='ch<?php echo $pgsno ?>' value='' class='storingch' <?php echo $checkedstatus ?> onchange="updateRight('<?php echo $module_id ?>','<?php echo $pageId ?>','<?php echo $userId ?>','<?php echo $rightStatus ?>')">
							</td>
						</tr>
			<?php
						$pgsno++;
					}
				} else {
					echo "<tr>
					<td colspan='3' style='text-align:center;'>Pages are Not Added yet!!!</td>
				</tr>";
				}
			}
			?>

		<?php $mdsno++;
		} ?>
	</table>
<?php } else
	echo '<p>No Module Found.!</p>'; ?>