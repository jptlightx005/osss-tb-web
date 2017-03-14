<?php
function send_mail($email,$subject,$msg) {
	$api_key=getenv("MAILGUN_API_KEY");
	$domain = getenv("MAILGUN_DOMAIN");
	$ch = curl_init();
	curl_setopt($ch, CURLOPT_HTTPAUTH, CURLAUTH_BASIC);
	curl_setopt($ch, CURLOPT_USERPWD, 'api:'.$api_key);
	curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
	curl_setopt($ch, CURLOPT_CUSTOMREQUEST, 'POST');
	curl_setopt($ch, CURLOPT_URL, 'https://api.mailgun.net/v2/'.$domain.'/messages');
	curl_setopt($ch, CURLOPT_POSTFIELDS, array(
	'from' => "no-reply <no-reply@$domain.com>",
	'to' => $email,
	'subject' => $subject,
	'html' => $msg
	));
	$result = curl_exec($ch);
	curl_close($ch);
	return $result;
}

if(isset($_POST["action"])){
	echo "testing: {$_POST["action"]}<br>";
	# Instantiate the client.
	$mgClient = new Mailgun();
	

	# Make the call to the client.
	$result = send_mail($_POST["email"], 'Hello', 'Testing some Mailgun awesomness!');
	
	echo "testing:<br>";
	if($result){
		print_r($result);
	}
}
?>

<form method="post">
<label>Enter email: </label>
<input type="email" name="email" required />
<button type="submit" name="action" value="submit_email">Submit</button>
</form>