<?php
function startsWith($haystack, $needle)
{
     $length = strlen($needle);
     return (substr($haystack, 0, $length) === $needle);
}

class Router {
	private $fullpath;
	private $path;
	public $page;

	function __construct() {
		$this->fullpath = $_SERVER['REQUEST_URI'];
		$this->path = explode("?", $this->fullpath)[0];
		$this->matchPath();
	}

	function matchPath() {
		$parts = explode("/",$this->path);
		switch ($parts[1]) {
			case "kaart":
			case "c":
			case "card":
				$this->page = "card";
				$GLOBALS['ROUTER_code'] = $parts[2];
				break;

			case "admin":
				$this->page = "admin";
				$GLOBALS['ROUTER_code'] = $parts[2];
				break;

			case "create":
				$this->page = "create";
				$GLOBALS['ROUTER_code'] = $parts[2];
				break;

			case "create_spotify":
				$this->page = "create_spotify";
				$GLOBALS['ROUTER_code'] = $parts[2];
				break;

			case "new":
				if (isset($parts[2])) {
					$this->page = "new_overview";
					$GLOBALS['ROUTER_code'] = $parts[2];
				} else {
					$this->page = "new";
				}
				break;

			case "info":
				$this->page = "info";
				break;

			case "examples":
				$this->page = "examples";
				break;

			default:
			case "home":
				$this->page = "home";
				break;
		}
	}

	function pageFile() {
		return "pages/" . $this->page . ".php";
	}

	function pageBodyFile() {
		return "pages/body/" . $this->page . ".php";
	}

	function pageCodeFile() {
		return "pages/code/" . $this->page . ".php";
	}

	function useDbConnection() {
		return in_array($this->page, array("create_spotify", "create", "admin", "card", "examples", "new", "new_overview"));
	}
}
?>