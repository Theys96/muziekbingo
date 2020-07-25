<?php
$code = strtoupper($ROUTER_code);

if (checkAdminCode($code, $Db) !== true) {
	header("location: /?refer=" . $code);
	return;
}

$code_info = getCodeInfoFromAdmin($code, $Db);
$imported = false;

// Import from spotify
if (isset($_POST['list'])) {
	$list = json_decode($_POST['list']);
	$newsongs = array();
	foreach ($list as $song)  {
		$newsongs[] = array(
			$Db->real_escape_string($song[0]), 
			$Db->real_escape_string(implode(', ', $song[1]))
		);
	}
	$imported = true;
}
// Saved by user
elseif (isset($_POST['title']) && isset($_POST['artist'])) {
	$newsongs = array();
	$num = min(count($_POST['title']), count($_POST['artist']));
	for ($i = 0; $i < $num; $i++) {
		$newsongs[] = array(
			$Db->real_escape_string( $_POST['title'][$i] ),
			$Db->real_escape_string( $_POST['artist'][$i] )
		);
	}
}

// Update playlisting
if (isset($newsongs)) {
	if ($Db->query("DELETE FROM lijst WHERE code=" . $code_info['id']) != false) {
		$q = "INSERT INTO lijst (code, song, artist) VALUES ";
		foreach($newsongs as $song) {
			$set = "(" . $code_info['id'] . ", '" . $song[0] . "', '" . $song[1] . "')";
			$query = $Db->query($q . $set);
			if ($query == false) {
				trigger_error("Something went wrong inserting a playlist:\n" . $q . $set, E_USER_ERROR);
			}
		}
	} else {
		trigger_error("Something went wrong inserting a playlist (deleting the old songs)\n", E_USER_ERROR);
	}
	
	$code_info = getCodeInfoFromAdmin($code, $Db);
}


// Retrieve latest data
$code_playlist = array();
if ($code_info['created'] == true) {
	$code_playlist = getPlaylistFromCode($code_info['code'], $Db);
}

$TITLE = txtval('admin') . " - " . $code_info['code'];
?>
