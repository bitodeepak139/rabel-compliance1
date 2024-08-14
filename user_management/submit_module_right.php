<?php
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}
if (isset($_POST['submit'])) {
	echo $user = $_POST['user']; echo $total = $_POST['total'];
	if ($user != '') {
		$ins_by = $_SESSION['user_id']; $ins_date = date('d-m-Y'); $ins_time = date('h:i:s A');	$status = 1; $status1 = 0; $device = 'Web';

		//$conn->beginTransaction();
		try {
			for($i=1; $i<=$total; $i++){
				if(isset($_POST["ch<?php echo $i ?>"])) $status=1; else $status=0; echo $i.'<br>';
				echo $moduleid=$_POST["ch<?php echo $i ?>"];
			  }
			//$rowcount=$user_query->check_module_url_name($conn,$name,'name');
			//$result=$user_query->insert_module_data($conn,$url,$name,$status,$ins_by,$ins_date,$entry_type,$ins_device,$ip);

		//$db->commit();
?>
			<script>
				$(document).ready(function() {
					getmudule('<?php echo $user ?>');
					$.toast({
						heading: 'Success',
						text: "Right Defined Successfully.!",
						position: 'top-right',
						loaderBg: '#2DB81D',
						icon: 'success',
						hideAfter: 3500
					});
				});
				
			</script>
		<?php } catch (PDOException $e) {
			//$db->rollBack();  ?>
			<script>
				$(document).ready(function() {
					getmudule('<?php echo $user ?>');
					$.toast({
						heading: 'Error',
						text: 'data not added due to some system error.!',
						position: 'top-right',
						loaderBg: '#ff6849',
						icon: 'error',
						hideAfter: 3500
					});
				});				
			</script>
		<?php }
	} else { ?>
		<script>
			$(document).ready(function() {
				getmudule('<?php echo $user ?>');
				$.toast({
					heading: 'Error',
					text: 'Select User First',
					position: 'top-right',
					loaderBg: '#ff6849',
					icon: 'error',
					hideAfter: 3500
				});
			});			
		</script>
<?php } } ?>