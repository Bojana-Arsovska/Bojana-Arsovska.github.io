<?php

error_reporting(E_ALL);

ini_set("display_errors", 1);

require 'vendor/autoload.php';

$signedRequest = new \Speakap\SDK\SignedRequest('29018071e8000714', '04fd15176c3175cec8d9a41c35752e5efacf236d4e84885c6e5f2e4bca060127');

echo 'Bla';

if (!$validator->validateSignature($_POST)) {
    die('Invalid signature');
}
