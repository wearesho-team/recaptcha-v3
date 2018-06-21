# reCAPTCHA v3 PHP Server Library
[![Latest Stable Version](https://poser.pugx.org/wearesho-team/recaptcha-v3/v/stable)](https://packagist.org/packages/wearesho-team/recaptcha-v3)
[![Total Downloads](https://poser.pugx.org/wearesho-team/recaptcha-v3/downloads)](https://packagist.org/packages/wearesho-team/recaptcha-v3)
[![Build Status](https://travis-ci.org/wearesho-team/recaptcha-v3.svg?branch=master)](https://travis-ci.org/wearesho-team/recaptcha-v3)
[![codecov](https://codecov.io/gh/wearesho-team/recaptcha-v3/branch/master/graph/badge.svg)](https://codecov.io/gh/wearesho-team/recaptcha-v3)
[![License](https://poser.pugx.org/wearesho-team/recaptcha-v3/license)](https://packagist.org/packages/wearesho-team/recaptcha-v3)

Simple server check implementation for [reCAPTCHA v3](https://developers.google.com/recaptcha/docs/v3)

*Note: This is a Beta version of reCAPTCHA which is still undergoing final testing before its official release. The API, documentation, and policy are subject to change in the future.*

## Installation
```bash
composer require wearesho-team/recaptcha-v3
```

## Usage
See [example.php](./example.php) for details

```php
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

```

## Contributors
- [Alexander <horat1us> Letnikow](mailto:reclamme@gmail.com)

## License
[MIT](./LICENSE)
