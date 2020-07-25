<?php

class ExceptionHandler {
	private $warnings;
	private $errors;
	private $fatal;

	public $doDisplayErrors;

	function __construct($displayErrors) {
		$this->warnings = array(); $this->errors = array(); $this->fatal = array();
		$this->doDisplayErrors = $displayErrors;

		set_error_handler(array($this,"errorHandler"));
	}

	function warning($message) {
		$this->warnings[] = explode("\n", $message);
	}

	function error($message) {
		$this->errors[] = explode("\n", $message);
	}

	function fatal($message) {
		$this->fatal[] = explode("\n", $message);
		$this->print();
		die();
	}

	function hasErrors() {
		return count($this->warnings) + count($this->errors) + count($this->fatal) > 0;
	}

	function print() {
		if (!$this->doDisplayErrors) {
			return;
		}

		function printMsg($lines, $type) {
			$i = 0;
			$empt = str_repeat(" ", strlen($type));
			foreach ($lines as $line) {
				echo ($i == 0 ? "[".$type."] " : $empt."   ") . $line . "\n";
				$i++;
			}
		}

		if ($this->hasErrors()) {
			echo "<center><h2>ERROR REPORT</h2></center>\n";
			echo "<xmp>\n";
			foreach ($this->fatal as $fat) { printMsg($fat, "FATAL"); }
			foreach ($this->errors as $err) { printMsg($err, "ERR  "); }
			foreach ($this->warnings as $warn) { printMsg($warn, "WARN "); }
			echo "</xmp>\n";
		}
	}

	function reportToDb($con) {

		function logMsg($lines, $type, $con, $remote_addr, $http_user_agent) {
			$message = $con->real_escape_string(implode("\n", $lines));
			$q = "INSERT INTO exceptions (remote_addr, http_user_agent,	type, message) VALUES ('".$remote_addr."', '".$http_user_agent."', '".$type."', '".$message."')";
			$con->query($q);
		}

		$remote_addr = $con->real_escape_string($_SERVER['REMOTE_ADDR']);
		$http_user_agent = $con->real_escape_string($_SERVER['HTTP_USER_AGENT']);

		foreach ($this->fatal as $fat) { logMsg($fat, "FATAL", $con, $remote_addr, $http_user_agent); }
		foreach ($this->errors as $err) { logMsg($err, "ERR", $con, $remote_addr, $http_user_agent); }
		foreach ($this->warnings as $warn) { logMsg($warn, "WARN", $con, $remote_addr, $http_user_agent); }
	}

	function errorHandler($errno, $errstr, $errfile, $errline)  {
		$str = $errstr . "\n\t(".$errfile.":".$errline.")";
		switch ($errno) {
			case 1:
				$this->fatal($str);
				break;
			case 2:
				$this->error($str);
				break;
			default:
				$this->warning($str);
				break;
		}
	}
}
?>