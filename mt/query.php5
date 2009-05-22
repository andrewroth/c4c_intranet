<?php
/**
 * By: Adam Kerr
 * Effectively this page takes API requests sent as 
 * HTML POST or GET requests, and answers them using
 * the API
 */
ini_set("display_errors", 1);
define("LIB_PATH", "/var/www/campus/dev.intranet.campusforchrist.org/mt-libs/");

session_start();

require_once(LIB_PATH . "bb_api.php");
$api = new MT_API($_SESSION['cas']['guid']);
 
/* Takes the result of an API request and handles it */
function querify($result)
{
	print(json_encode($result));
}

if(isset($_REQUEST))
{	
	$func = $_REQUEST['call'];
	
	$result = $api->$func($_REQUEST);
	
	querify($result);
}
?>