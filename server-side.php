<?php

error_reporting(E_ALL);

ini_set("display_errors", 1);

require 'vendor/autoload.php';

//use Speakap\SDK as SpeakapSDK;

$signedRequest = new \Speakap\SDK\SignedRequest('29018071e8000714', '04fd15176c3175cec8d9a41c35752e5efacf236d4e84885c6e5f2e4bca060127');

echo 'Bla';

if (!$signedRequest->validateSignature($_POST)) {
    die('Invalid signature');
}

echo <<<HTML
<html>
    <head>
        <title>Hello World</title>
        <script type="text/javascript">
            var Speakap = { appId: "/* App ID */", signedRequest: "$encSignedReq" };
        </script>
        <script type="text/javascript" src="js/jquery.min.js"></script>
        <script type="text/javascript" src="js/speakap.js"></script>
    </head>

    <body>
        <p>Hello Speakap user!</p>
    </body>
</html>
HTML;
