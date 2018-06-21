<?php

use Wearesho\ReCaptcha;

$response = $_POST['g-recaptcha-response'];
$ip = $_SERVER['REMOTE_ADDR'] ?? null;

$config = new ReCaptcha\V3\Config($secret = "...");
$client = new ReCaptcha\V3\Client($config);

try {
    $response = $client->verify($response, $ip);
} catch (ReCaptcha\V3\Exception $e) {
    $response = $e->getResponse();
    // do something if token is not valid
}

$response->getScore(); // score from 0 to 1
