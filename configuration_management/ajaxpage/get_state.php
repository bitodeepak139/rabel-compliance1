<?php 
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}
require_once "../../classfile/initialize.php";
require_once "../../classfile/configuration_management.php";
$id=$_POST['id'];
$retval=$org_query->get_state_select($conn,$id);
?>

<select id="state" name="state" class="form-control" onchange="getcity(this.value)">
  <option value="">Select State</option>
  <?php
	foreach($retval as $grow){
	$state_id=$grow['pk_utm_state_id']; $state_name=$grow['state_name'];
	?>
  <option value="<?php echo $state_id ?>"><?php echo $state_name ?></option>
  <?php } ?>
</select>
