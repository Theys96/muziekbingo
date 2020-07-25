<?php
$code = $ROUTER_code;
$TITLE = $code;

/* Code validity check */
if (checkCode($code, $Db) !== true) {
	header("location: /?refer=" . $code);
	return;
}

/* Reset cookies on request for new card */
if (isset($_GET['new'])) {
	setcookie("bingokaart", NULL, NULL);
	setcookie("bingocode", NULL, NULL);
	setcookie("bingocells", NULL, NULL);
	header('location: /c/'.$code);
	return;
}

/* Load card */
if (isset($_COOKIE['bingokaart']) && $code == $_COOKIE['bingocode']) {
	$kaart = json_decode($_COOKIE['bingokaart'], false);
} else {
	/* Generate new card */
	$kaart = getCard($code, $Db);
	setcookie("bingokaart", json_encode($kaart), time()+60*60*24);
	setcookie("bingocode", $code, time()+60*60*24);
	setcookie("bingocells", NULL, NULL);
}

// Count
$num = countList($code, $Db);
?>

