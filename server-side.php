<?php

error_reporting(E_ALL);

ini_set("display_error",1);

require __DIR__ . 'vendor/autoload.php'

use Speakap\SDK as SpeakapSDK;

$signedRequest = new SpeakapSDK\SignedRequest('29018071e8000714', '04fd15176c3175cec8d9a41c35752e5efacf236d4e84885c6e5f2e4bca060127');

echo 'bla';

if (!$signedRequest->validateSignature($_POST)) {
    die('Invalid signature');
}

echo 'something'
