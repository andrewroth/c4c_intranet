<?php

ini_set("display_errors", 1);

define("LIB_PATH", "/var/www/campus/dev.intranet.campusforchrist.org/mt-libs/");
define("SITE_PATH", "http://dev.intranet.campusforchrist.org/mt/");

//Require Authentication
require_once(LIB_PATH . "cas-auth.php");

session_start();

if(!isset($_SESSION['cas']['ticket']))
{
	$return = CASUser::login($_REQUEST['ticket']);
	$_SESSION['cas'] = $return;
	header('Location: ' . $_ENV['SCRIPT_NAME']);
}

if(isset($_REQUEST['logout']))
{
	CASUser::logout();
}

?>
<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01//EN" "http://www.w3.org/TR/html4/strict.dtd">
<html>

<head>
	<link rel="Shortcut Icon" href="http://campusforchrist.org/images/favicon.ico" />
	<title>Movement Tracker</title>
	<style type="text/css">
		@import "style.css";
	</style>
	<script type="text/javascript" src="scripts/jquery-1.2.6.min.js"></script>
	<script type="text/javascript" src="scripts/jquery-ui-1.6rc2.min.js"></script>
	<script type="text/javascript" src="scripts/libs.js"></script>
	<script type="text/javascript" src="scripts/script.js"></script>
</head>
<body>
	<div id="header">
		<?php print("Welcome: " . $_SESSION['cas']['firstname'] . ' ' . $_SESSION['cas']['lastname']); ?>
		<div class="nav">
			<a href="?logout">Logout</a>
		</div>
		<!-- <img src="images/logo.png" class="logo" /> -->
	</div>

	<div id="background">
		<div id="content">
		</div>
		<div id="footer">
			&nbsp;
		</div>
	</div>
</body>
</head>