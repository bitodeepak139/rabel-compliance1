<?php
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}
include("simple_php_captcha.php");
$_SESSION['captcha'] = simple_php_captcha();
?>
<img src="<?php echo $_SESSION['captcha']['image_src'] ?>" height="42px" width="150px">
<a href="javascript:void(0)" onClick="getcapcha()" id="<?php echo $sltid; ?>" title="Refresh"><i class="fa  fa-refresh"></i></a>
<input type="hidden" name="hcpt" id="hcpt" value="<?php echo $_SESSION['captcha']['code'] ?>">