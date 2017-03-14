<?php
require __DIR__ . "/vendor/autoload.php";
use Mailgun\Mailgun;

echo "Try print: " . __DIR__ . "/vendor/autoload.php";

if(isset($_POST["action"])){

	# Instantiate the client.
	$mgClient = new Mailgun(getenv("MAILGUN_API_KEY"));
	$domain = getenv("MAILGUN_DOMAIN");

	# Make the call to the client.
	$result = $mgClient->sendMessage($domain, array(
	    'from'    => 'osss-tb@mailgun.com',
	    'to'      => $_POST["email"],
	    'subject' => 'Hello',
	    'text'    => 'Testing some Mailgun awesomness!'
	));
}
?>

<form method="post">
<label>Enter email: </label>
<input type="email" name="email" required />
<button type="submit" name="action" value="submit_email">Submit</button>
</form>