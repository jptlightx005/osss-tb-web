<?php
    date_default_timezone_set("Asia/Taipei");
    $conn = new mysqli("us-cdbr-iron-east-03.cleardb.net", "b9e27527065c19", "3540d53c", "heroku_91a85da334dee22");    

	if(mysqli_connect_errno()){
		printf("Connection failed: %s", mysqli_connect_error());
		exit();
	}
?>