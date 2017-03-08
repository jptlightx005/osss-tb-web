<?php
    date_default_timezone_set("Asia/Taipei");
    $conn = new mysqli("localhost", "root", "", "osss_db");    

	if(mysqli_connect_errno()){
		printf("Connection failed: %s", mysqli_connect_error());
		exit();
	}
?>