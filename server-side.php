<?php

require __DIR__ . '/vendor/autoload.php';

use GuzzleHttp\Client;
use GuzzleHttp\Exception\RequestException;

error_reporting(E_ALL);
ini_set('display_errors', 1);

function getConfiguration($name)
{
    $environments = array(
        'dogfood' => array(
            'EID' => '08e1e1eadc000e6c',
            'api' => 'https://api.test.speakap.nl',
            'authenticator' => 'https://authenticator.test.speakap.nl/oauth/v2/token',
            'networkUrl' => 'https://ts.test.speakap.nl/'// <--
        ),
        'dcme' => array(
            'EID' => '0000000000000001',
            'api' => 'http://api.dev.speakap.nl',
            'authenticator' => 'http://authenticator.dev.speakap.nl/oauth/v2/token',
            'networkUrl' => 'https://ts.test.speakap.nl/'// <--
        )
    );

    $env = strpos($_SERVER['HTTP_HOST'], 'dev') === false ? 'dogfood' : 'dcme';

    return $environments[$env][$name];
}
var_dump('i exited fuction No. 1');
function getAccessToken($authorizationCode)
{

    $authenticatorUrl = getConfiguration('authenticator');
    $networkUrl = getConfiguration('networkUrl');

    $client = new Client();
    $body = array(
        'client_id' => '2902858cc6000a00',// <--
        'client_secret' => 'f1cc9b8a064a00b623839e18940d288eeb40aac936946603563ebd2c27d21286',
        'code' => $authorizationCode,
        'grant_type' => 'authorization_code',
        'redirect_uri' => "https://tutorial.hosting.speakap.io/experimental/bojana/server-side.php"
    );

    try {
        $response = $client->post($authenticatorUrl, array('form_params' => $body));
    } catch (RequestException $e) {
        echo "<pre>$e</pre>";
    }

    $json = json_decode($response->getBody(true));
    if ($json === null) {
        die('Could not decode JSON response from authenticator!');
    }

    return $json->access_token;
}
var_dump('i accesed the token');

function handleExternalRequest()
{
    if (isset($_GET['code'])) {
        $accessToken = getAccessToken($_GET['code']);

        $client = new Client(array(
          'base_uri' => getConfiguration('api')));
        $response = json_decode($client->get(
            '/networks/' . getConfiguration('EID') . '/?embed=userProfile',
            array(
              'headers' => array('Authorization' => 'Bearer ' . $accessToken))
        )->getBody());

        $fullName = htmlentities($response->_embedded->userProfile->fullName);
        $avatar = $response->_embedded->userProfile->avatarThumbnailUrl;

        echo "<p>Hello, $fullName</p> <img src='$avatar'>";
    } else {

        $baseUrl = getConfiguration('networkUrl');
        $authUrl = '/auth?client_id=2902858cc6000a00' .
                       '&redirect_uri=https://tutorial.hosting.speakap.io/experimental/bojana/server-side.php'.
                       '&scope=profile.basic.read&state=123456';
        echo '<p>Hello world, I don\'t know who you are.</p>' .
             '<p><a href="' . htmlspecialchars($baseUrl . $authUrl) . '">Authenticate with Speakap</a></p>';

        var_dump($baseUrl);
        var_dump($authUrl);

        if (isset($_GET['error'])) {
            echo '<p style="color: red">I got an authentication error: ' . $_GET['error'] . '</p>';
            if (isset($_GET['error_description'])) {
                echo '<p style="color: red">' . $_GET['error_description'] . '</p>';
            }
        }
    }
}


function handleIframeRequest()
{ // <--
    $signedRequest = new \Speakap\SDK\SignedRequest('290691917f000c38', 'f1cc9b8a064a00b623839e18940d288eeb40aac936946603563ebd2c27d21286');

    if (!$speakapSignedRequest->validateSignature($_POST)) {
        die('I\'m sorry, but the request seems invalid. Please try again!' .
            'Note that this application can only be started from within Speakap.');
    }

    echo '<p>Hello world, I\'m ' . $_POST['userEID'] . '</p>';
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    handleIframeRequest();
} else {
    handleExternalRequest();
}
