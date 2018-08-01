<?php

error_reporting(E_ALL);

ini_set("display_error",1);

require __DIR__ . 'vendor/autoload.php'
exit;

use Speakap\SDK as SpeakapSDK;

$signedRequest = new SpeakapSDK\SignedRequest('bla', 'bla');

echo 'bla';

if (!$validator->validateSignature($_POST)) {
    die('Invalid signature');
}
