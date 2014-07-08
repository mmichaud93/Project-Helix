<?php
function db_connect(){
	$dbhost = "localhost"; $dbuser = "root"; $dbpw = ""; $db = "helix_inventory";
	$mysqli = new mysqli($dbhost,$dbuser,$dbpw,$db);
	if ($mysqli->connect_errno) {
		echo "Failed to connect to MySQL: (" . $mysqli->connect_errno . ") " . $mysqli->connect_error;
		error_log( "Failed to connect to MySQL: (" . $mysqli->connect_errno . ") " . $mysqli->connect_error);
		exit(false); // will need to be more graceful in the future
		//return(false);
	}
	return($mysqli);
}

?>