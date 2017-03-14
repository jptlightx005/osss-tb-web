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
	'from' => "no-reply <no-reply@osss-tb.herokuapp.com>",
	'to' => $email,
	'subject' => $subject,
	'html' => $msg
	));
	$result = curl_exec($ch);
	curl_close($ch);
	return $result;
}

if(isset($_POST["action"])){
	$email=$_POST["email"];
	$result = send_mail($_POST["email"], 'Account activation', "Click the link to activate account https://osss-tb.herokuapp.com/activate.php?id=$email");
	if($result){
		echo "Sent email to <u>$email</u>";
	}
}
?>

<form method="post">
<label>Enter email: </label>
<input type="email" name="email" required />
<button type="submit" name="action" value="submit_email">Submit</button>
</form>