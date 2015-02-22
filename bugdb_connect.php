<?php
	if(!isset($_SESSION)) { session_start(); }

	// Connects to the XE service (i.e. database) on the "localhost" machine
	$db = "(DESCRIPTION=(ADDRESS=(PROTOCOL=TCP)(HOST=amogridxp01-scan.us.oracle.com)(PORT=1523))(CONNECT_DATA=(SERVER=DEDICATED)(SERVICE_NAME=bugap_adx.us.oracle.com)))";
	global $conn;

	// Fetch user/pass from $_SESSION
	if (isset($_SESSION['authorization-user'])) {
		$user = $_SESSION['authorization-user'];
		//echo "bugdb_connection.php: Found user in _SESSION - $user <br>";
		header ("Cache-Control:no-cache");
	}
	if (isset($_SESSION['authorization-pass'])) {
		$pass = $_SESSION['authorization-pass'];
		//echo "bugdb_connection.php: Found pass in _SESSION - $pass <br>";
		header ("Cache-Control:no-cache");
	}

//	if ($user && $pass) {
		$conn = oci_connect($user, $pass, $db) or die("Error occured while connecting to DB");
//	} else {
//		header( "Location:login.php");
//	}
			
	if (!$conn) {
		$e = oci_error();
		trigger_error(htmlentities($e['message'], ENT_QUOTES), E_USER_ERROR);
		
		if(isset($_SESSION['redirect_url'])) {$redirectURL = $_SESSION['redirect_url'];} else {$redirectURL = '/dashboard/main.pphp';}
		
		//header( "Location:login.php");
		header("Location:$redirectURL");
	} else {
		//echo "DB Connection successful! <br/>";
	}
?>