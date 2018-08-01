<?php

include 'vendor/autoload.php'

use Speakap\SDK as SpeakapSDK;

$signedRequest = new SpeakapSDK\SignedRequest('bla', 'bla');

if (!$validator->validateSignature($_POST)) {
    die('Invalid signature');
}
