<?php
$code = strtoupper($ROUTER_code);

if (checkAdminCode($code, $Db) !== true) {
	header("location: /?refer=" . $code);
	return;
}

if (isset($_POST['empty'])) {
	emptyPlaylist($code, $Db);
}

$code_info = getCodeInfoFromAdmin($code, $Db);

if ($code_info['created'] == true) {
	$code_playlist = getPlaylistFromCode($code_info['code'], $Db);
}

$TITLE = txtval('admin') . " - " . $code_info['code'];
?>
