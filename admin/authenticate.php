<?php
include('../api/db.php');
include('../api/global.php');

$validated = false;
if(isset($_SERVER['PHP_AUTH_USER']) && isset($_SERVER['PHP_AUTH_PW'])){
    $fields = array('action' => 'login',
                    'usrn' => $_SERVER['PHP_AUTH_USER'],
                    'pssw' => $_SERVER['PHP_AUTH_PW']);

    $url = urlToApi('/api/auth.php');
    $obj = jsonFromRequest($fields, $url);

    $validated = $obj['response'] == 1;
}

if (!$validated) {
    header('WWW-Authenticate: Basic realm="Log in to proceed"');
    header('HTTP/1.0 401 Unauthorized');
    die ("Not authorized");
}
?>