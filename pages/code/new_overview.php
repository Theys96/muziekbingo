<?php
$code = $GLOBALS['ROUTER_code'];
$check = checkAdminCode($code, $Db);
if ($check !== true) {
	header("location: /new");
	exit();
}
$info = getCodeInfoFromAdmin($code, $Db);
?>
