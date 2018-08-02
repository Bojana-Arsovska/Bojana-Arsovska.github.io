<?php

error_reporting(E_ALL);

ini_set("display_errors", 1);

require 'vendor/autoload.php';

use Speakap\SDK as SpeakapSDK;

$signedRequest = new \Speakap\SDK\SignedRequest('29068821bb00005c', '4da9392b8b5bf816d2a6d4feccce071c60a7e31b9dcfb3ac34a644779a30e29b');
//
// echo 'Bla';
//
// if (!$signedRequest->validateSignature($_POST)) {
//     die('Invalid signature');
// }
//
// $encSignedReq = $signedRequest->getSignedRequest($_POST);
//
// echo <<<HTML
// <html>
//     <head>
//         <title>Hello World</title>
//         <script type="text/javascript">
//             var Speakap = { appId: "29018071e8000714", signedRequest: "$encSignedReq" };
//         </script>
//         <script type="text/javascript" src="js/jquery.min.js"></script>
//         <script type="text/javascript" src="js/speakap.js"></script>
//     </head>
//
//     <body>
//       <script type="text/javascript">
//       Speakap.doHandshake.then(function() {
//         Speakap.getLoggedInUser().then(function(loggedInUser) {
//             Speakap.ajax('/users/' + loggedInUser.EID + '/').done(function(user) {
//               document.write('<p>Hello ' + user.fullName + '!</p>');
//             });
//           });
//         });
//       </script>
//   </body>
// </html>
// HTML;


$signedParams = $signedRequest->getSignedParameters($_POST);

$baseUrl = 'https://api.test.speakap.nl/networks/' . $signedParams['networkEID'];

$accessToken = /* App ID */ '29068821bb00005c_4da9392b8b5bf816d2a6d4feccce071c60a7e31b9dcfb3ac34a644779a30e29b' /* Secret */;

$ch = curl_init("$baseUrl/users/{$signedParams['userEID']}/");

curl_setopt_array($ch, array(
    CURLOPT_HEADER => false,
    CURLOPT_RETURNTRANSFER => true,
    CURLOPT_HTTPHEADER => array(
        'Accept: application/vnd.speakap.api-v1.4+json',
        'Authorization: Bearer ' . $accessToken
    )
));

$response = curl_exec($ch);
curl_close($ch);
//var_dump($response);
$user = json_decode($response);

echo "<p>Hello {$user->fullName}!</p>";
// ID: 2902858cc6000a00
// secret: 83355b5649dfb16063ebf05e9e692d358e7973df0eeb0365401ea412b70b2e99
