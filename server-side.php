<?php

error_reporting(E_ALL);

ini_set("display_error",1);

require __DIR__ . 'vendor/autoload.php'

use Speakap\SDK as SpeakapSDK;

$signedRequest = new SpeakapSDK\SignedRequest('28fd61b50f000204', '9081caf1649b2911f74fd0f158ca260f8d619fea8fcb4e41686f1b2511bb6a9a');

echo 'bla';

if (!$signedRequest->validateSignature($_POST)) {
    die('Invalid signature');
}
