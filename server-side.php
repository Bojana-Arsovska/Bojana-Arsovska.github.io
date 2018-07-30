 <?php

/* Assume signed request has been properly validated */

$signedParams = $signedRequest->getSignedParameters($_POST);

$baseUrl = 'https://api.speakap.io/networks/' . $signedParams['networkEID'];

$accessToken = YjNmN2VkMWQ5Y2MxZGI2MzZhZTgzNWQzM2RkOTY2YWZhZTdhODM2NDBhYzA2Nzk3NGQ0MzZmYTI4Y2M5N2E3Ng;

$ch = curl_init("$baseUrl/users/{$signedParams['userEID']}/");

curl_setopt_array($ch, array(
    CURLOPT_HEADER => false,
    CURLOPT_POST => true,
    CURLOPT_POSTFIELDS => http_build_query(array(
        'grant_type' => 'authorization_code',
        'code' => '/* Authorization Code */',
        'redirect_uri' => 'https://yourdomain.com/app/folder/helloworld_sso.php',
        'client_id' => '/* App ID */',
        'client_secret' => '/* Secret */'
    )),
    CURLOPT_RETURNTRANSFER => true
));

$response = curl_exec($ch);
curl_close($ch);

$user = json_decode($response);

echo "<p>Hello {$user->fullName}!</p>";
