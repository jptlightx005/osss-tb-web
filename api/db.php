<?php
    date_default_timezone_set("Asia/Taipei");
	$url = parse_url(getenv("CLEARDB_DATABASE_URL"));

	$server = $url["host"];
	$username = $url["user"];
	$password = $url["pass"];
	$db = substr($url["path"], 1);

	$conn = new mysqli($server, $username, $password, $db);
	
	// $conn = new mysqli("localhost", "root", "", "osss_db");    
 
	if(mysqli_connect_errno()){
		printf("Connection failed: %s", mysqli_connect_error());
		exit();
	}
?>