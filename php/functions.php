<?php
function runQuery($db, $q) {
	$query = $db->query($q);
	if (!$query) {
		trigger_error("Something went wrong running query:\n" . $q, E_USER_ERROR);
	}
	return $query;
}

function checkCode($code, $db) {
	$code = strtoupper($db->real_escape_string($code));

	$query1 = runQuery($db, "SELECT id FROM `codes` WHERE '".$code."'=UPPER(code)");
	if ($query1->num_rows > 0) {
		$row = $query1->fetch_assoc();
		$query2 = runQuery($db, "SELECT * FROM `lijst` WHERE code=".$row['id']);
		if ($query2->num_rows > 0) {
			return true;
		} else {
			$err = "Playlist has not been created yet.";
		}
	} else {
		$err = "Code does not exist.";
	}
	return $err;
}

function countList($code, $db) {
	$code = strtoupper($db->real_escape_string($code));

	$count = runQuery($db, "SELECT count(lijst.id) AS count FROM lijst LEFT JOIN codes ON lijst.code=codes.id WHERE UPPER(codes.code)='".$code."'");

	if ($count && $count->num_rows > 0) {
		$x = $count->fetch_assoc();
		return $x['count'];
	}

	trigger_error("Something went wrong counting songs in list.", E_USER_WARNING);
	return 0;
}

function checkAdminCode($code, $db) {
	$code = strtoupper($db->real_escape_string($code));

	$query = runQuery($db, "SELECT id FROM `codes` WHERE '".$code."'=UPPER(admin)");
	if ($query->num_rows > 0) {
		return true;
	} else {
		$err = "Code does not exist.";
	}
	return $err;
}

function checkAdminCodeExists($code, $db) {
	$code = strtoupper($db->real_escape_string($code));
	$query = runQuery($db, "SELECT id FROM `codes` WHERE '".$code."'=UPPER(admin)");
	if ($query->num_rows > 0) {
		return true;
	}
	return false;
}

function getCodeInfoFromAdmin($code, $db) {
	$code = strtoupper($db->real_escape_string($code));

	$query1 = runQuery($db, "SELECT id, UPPER(code) AS code, UPPER(admin) AS admin FROM `codes` WHERE '".$code."'=UPPER(admin)");
	if ($query1->num_rows > 0) {
		$row = $query1->fetch_assoc();
		$row['created'] = false;
		$query2 = runQuery($db, "SELECT * FROM `lijst` WHERE code=".intval($row['id']));
		if ($query2->num_rows > 0) {
			$row['created'] = true;
		}
		return $row;
	}
	return false;
}

function getPlaylistFromCode($code, $db) {
	$code = strtoupper($db->real_escape_string($code));

	$query = runQuery($db, "SELECT song, artist FROM `lijst` WHERE code=(SELECT id FROM codes WHERE UPPER(code)='" . $code . "') ORDER BY id");
	$list = array();
	while ( ($row = $query->fetch_assoc()) != false) {
		$list[] = array($row['song'], $row['artist']);
	}
	return $list;
}

function emptyPlaylist($code, $db) {
	$code = strtoupper($db->real_escape_string($code));

	$query1 = runQuery($db, "SELECT id FROM `codes` WHERE '".$code."'=UPPER(admin)");
	if ($query1->num_rows > 0) {
		$row = $query1->fetch_assoc();
		$query2 = runQuery($db, "DELETE FROM `lijst` WHERE code=".$row['id']);
	} else {
		$err = "Code does not exist.";
	}
	return $err;
}

function getCard($code, $db) {
	$code = strtoupper($db->real_escape_string($code));

	$kaart = array();
	$query = runQuery($db, "SELECT lijst.* FROM lijst LEFT JOIN codes ON lijst.code=codes.id WHERE UPPER(codes.code)='".$code."' ORDER BY rand() ASC LIMIT 25");
	
	while ($row = $query->fetch_assoc()) {
		$kaart[] = array($row['song'], $row['artist']);
	}
	return $kaart;
}

function getExamples($db, $lang) {
	$l = $lang == 'nl' ? 'nl' : 'en';
	$q = "SELECT examples.code,examples.description_".$l." AS description,examples.spotify FROM `examples` LEFT JOIN codes ON UPPER(examples.code) = UPPER(codes.code) ORDER BY examples.code ASC";
	$query = runQuery($db, $q);

	$examples = array();
	while ($row = $query->fetch_assoc()) {
		$examples[] = array('code' => $row['code'], 'description' => $row['description'], 'link' => $row['spotify']);
	}
	return $examples;
}

function generateCode($length = 6) {
	$chars = '0123456789ABCDEFGHIJKLMNOPQRSTUVWXYZ';
    $nchars = strlen($chars);
    $string = '';
    for($i = 0; $i < $length; $i++) {
        $rchar = $chars[mt_rand(0, $nchars - 1)];
        $string .= $rchar;
    }
    return $string;
}

function checkNewCode($db, $code, $freelen) {

	if (!ctype_alnum($code)) {
		return "invalid-alnum";
	}
	$state = "valid";

	$len = strlen($code);
	if ( !( $freelen ? ($len <= 6 && $len > 0) : ($len == 6) ) ) {
		return "invalid-length";
	}

	$code = strtoupper($db->real_escape_string($code));
	$query = runQuery($db, "SELECT id FROM codes WHERE upper(code)='".$code."'");
	if ($query->num_rows > 0) {
		$state = "taken";
	}

	return $state;
}

// Note: $code is assumed to be checked for validity and existence
function createNewCode($db, $code) {
	$code = strtoupper($db->real_escape_string($code));
	do {
		$admin_code = generateCode(12);
	} while (checkAdminCodeExists($admin_code, $db));
	$query = runQuery($db, "INSERT INTO codes (code, admin) VALUES ('".$code."', '".$admin_code."')");
	return $admin_code;
}

?>