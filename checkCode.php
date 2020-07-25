<?php
require 'php/config.php';
require 'php/functions.php';
require 'php/exceptions.class.php';

if (!isset($_POST['code'])) {
	http_response_code(400);
	exit();
}

$code = $_POST['code'];
$freelen = $_POST['freelen'] == 'true' ? true : false;

$Error  = new ExceptionHandler($DeployType == "beta");
$Db = new Mysqli($MySQL_host, $MySQL_username, $MySQL_password, $MySQL_database);
if ($Db->connect_errno) {
	trigger_error("Database connection failed", E_USER_ERROR);
}

echo checkNewCode($Db, $code, $freelen);

if ($DeployType == "prod" && $Error->hasErrors()) {
  $Error->reportToDb($Db);
}
?>