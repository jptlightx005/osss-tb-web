<?php
include('db.php');
include('global.php');

$json = jsonResponse(0, "No request");

if(isset($_REQUEST['action'])){
	$action = $_REQUEST["action"];
	$json = jsonResponse(0, "Invalid request: $action");
	if($action == "login"){
		$json = loginAdmin($_REQUEST);
	}
}

$conn->close();

/* Output header */
header('Content-type: application/json');
echo json_encode($json);

/*page functions*/
function loginAdmin($admin){
	if($admin['usrn'] == "admin" && $admin['pssw'] == "pass"){

		return jsonResponse(1, "Successfully logged in");
	}else{
		return jsonResponse(0, "Invalid username or password!");
	}
}
?>