<?php
// MINIWIKI v0.1.

include_once("config.inc.php");
session_start();

// ----------------------------------------------------------------------------------------------------
// $HOME    : Absolute path (e.g., "http://www.nodebox.net/blog")
// $PATH    : Relative path (e.g., "/blog").
// $website : site name (e.g., "NodeBox blog")
// $page    : page name (e.g., "articles/graph.html")
// $content : page HTML
// $message : server feedback when something went wrong.
// $script  : server JavaScript code to execute.

$HOME    = "http://" . $_SERVER["SERVER_NAME"] . $_SERVER["PHP_SELF"];
$HOME    = substr($HOME, 0, -strlen($_SERVER["PATH_INFO"]));
$HOME    = substr($HOME, 0, -strlen(basename($_SERVER["SCRIPT_NAME"])));
$PATH    = utf8_decode($_SERVER["PHP_SELF"]);
$page    = urldecode(substr($_SERVER["PATH_INFO"], 1));
$content = "";
$message = "";
$script  = "";

// ----------------------------------------------------------------------------------------------------

function pages() {
	// Returns an array of all existing pages. 
	// Use htmlentities() to escape < " & in page names.
	$a = array();
	foreach (glob("data/*.txt") as $f) {
		array_push($a, urldecode(substr(basename($f), 0, -strlen(".txt"))));
	}
	return $a;
}

function normalize($page) {
	// Returns lowercase pagename with trailing slashes removed.
	return strtolower(rtrim($page, "/"));
}

function path($page) {
	// Returns the page file path.
	return "data/".urlencode($page).".txt";
}

function content($page) {
	// Returns list($page, $content) with the contents of the given page.
	// The page name may have been decoded from Unicode to ASCII.
	$path = path($page);
	if (!file_exists($path) && file_exists(path(utf8_decode($page)))) {
		$page = utf8_decode($page);
		$path = path($page);
	}
	return array($page, (file_exists($path))? substr(file_get_contents($path), 3) : "");
}

function template($page) {
	// Returns the name of the template for the given page.
	// For example: template "software.inc.php" is used for page "software/nodebox/".
	if (!isset($_SESSION["templates"])) {
		function _f1($t) { return substr(basename($t), 0, -8); }
		function _f2($t) { return $t != "admin" && $t != "error" && $t != "login"; }
		$_SESSION["templates"] = array_map("_f1", glob("templates/*.inc.php"));
		$_SESSION["templates"] = array_filter($_SESSION["templates"], "_f2");
	}
	foreach($_SESSION["templates"] as $template) {
		if (substr($page, 0, strlen($template)) === $template) return $template;
	}
	return "page";
}

// ----------------------------------------------------------------------------------------------------
// REDIRECTION

header("Content-type:text/html; charset=UTF-8");

if ($page == "") {
	// Homepage defaults to data/index.html.txt (if it exists).
	foreach(array("index.html", "index", "home", "Home") as $default) {
		if (file_exists(path($default))) {
			$page = $default; break;
		}
	}
}
if ($page != "admin") {
	list($page, $content) = content(normalize($page));
	if ($content) {
		// Page template with contents from /data file.
		include("templates/".template($page).".inc.php");
	} else {
		include("templates/page-error.inc.php");
	}
} else {
	$page = "";
	if (isset($_POST["username"])) {
		// Username and password for the admin account are set in config.inc.php.
		$_SESSION["username"] = $_POST["username"];
		$_SESSION["password"] = $_POST["password"];
	}
	if ($_SESSION["username"] != $username || $_SESSION["password"] != $password) {
		include("templates/admin-login.inc.php"); exit();
	}
	if (isset($_GET["save"])) {
		// Saves TinyMCE contents as a file in /data.
		// Allowed page names: alphanumeric + dash + slash + .html
		$page = normalize(stripslashes($_POST["page"]));
		$page = utf8_decode($page);
		$content = stripslashes($_POST["content"]);
		if (preg_match('/^([a-zA-Z0-9-\/]+)(\.html)?$/', $page)) {
			$f = fopen(path($page), "w");
			fwrite($f, pack("CCC", 0xef,0xbb,0xbf)); # UTF-8 BOM.
			fwrite($f, $content);
			fclose($f);
		} else {
			$message = "Page name can only have ascii characters, numbers, slash (/), dash (-) and .html";
			$script = "on_rename();";
		}
	}
	if (isset($_GET["edit"])) {
		// Edit contents of the given page in TinyMCE.
		list($page, $content) = content(normalize(stripslashes($_GET["edit"])));
	}
	if (isset($_GET["delete"])) {
		// Removes the given page.
		list($page, $content) = content(normalize(stripslashes($_GET["delete"])));
		if (file_exists(path($page))) {
			unlink(path($page));
		}
		$page = "";
		$content = "";
	}
	include("templates/admin.inc.php");
}