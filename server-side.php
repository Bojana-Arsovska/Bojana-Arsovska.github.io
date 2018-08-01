<?php

error_reporting(E_ALL);

ini_set("display_errors", 1);

require 'vendor/autoload.php';

use Speakap\SDK as SpeakapSDK;

$signedRequest = new \Speakap\SDK\SignedRequest('29018071e8000714', '04fd15176c3175cec8d9a41c35752e5efacf236d4e84885c6e5f2e4bca060127');
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

$accessToken = '29018071e8000714_04fd15176c3175cec8d9a41c35752e5efacf236d4e84885c6e5f2e4bca060127'/;

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

$user = json_decode($response);

echo "<p>Hello {$user->fullName}!</p>";
