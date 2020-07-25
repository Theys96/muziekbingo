<?php
if ($ROUTER_code != '') {
	$code = strtoupper($ROUTER_code);
	if (checkAdminCode($code, $Db) !== true) {
		header("location: /?refer=" . $code);
		return;
	}
	$code_info = getCodeInfoFromAdmin($code, $Db);
	header("location: ".$API_loc."&state=".$code."-".$code_info['code']);
}
?>
