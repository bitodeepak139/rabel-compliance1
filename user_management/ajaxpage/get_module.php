<?php
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}
require_once "../../classfile/initialize.php";
require_once "../../classfile/user.php";
$id = $_POST['id'];
$retval = $user_query->get_select_module($conn, $id);
?>

<select id="module" name="module" class="form-control" onchange="getpage(this.value)">
  <option value="">Select Module</option>
  <?php
  foreach ($retval as $grow) {
    $module_id = $grow['pk_usm_module_id'];
    $module_name = $grow['module_name'];
    ?>
    <option value="<?php echo $module_id ?>">
      <?php echo $module_name ?>
    </option>
  <?php } ?>
</select>