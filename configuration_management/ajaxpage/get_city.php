<?php 
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}
require_once "../../classfile/initialize.php";
require_once "../../classfile/configuration_management.php";
$id=$_POST['id'];
$retval=$org_query->get_city_select($conn,$id);
?>

<select id="city" name="city" class="form-control">
  <option value="">Select City</option>
  <?php
	foreach($retval as $grow){
	$city_id=$grow['pk_utm_city_id']; $city_name=$grow['city_name'];
	?>
  <option value="<?php echo $city_id ?>"><?php echo $city_name ?></option>
  <?php } ?>
</select>
