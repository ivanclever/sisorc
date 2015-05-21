<?php
$digest = $_SESSION['Auth_user']['Digest'];
if ($digest != md5($_SERVER['REMOTE_ADDR'])) {
	echo "<script>window.location='login.php';</script>";
	break;
}
?>