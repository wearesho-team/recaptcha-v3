<?php

namespace Wearesho\ReCaptcha\V3;

use Horat1us\Environment;

/**
 * Class EnvironmentConfig
 * @package Wearesho\ReCaptcha\V3
 */
class EnvironmentConfig extends Environment\Config implements ConfigInterface
{
    public function __construct(string $keyPrefix = 'RECAPTCHA_')
    {
        parent::__construct($keyPrefix);
    }

    public function getSecret(): string
    {
        return $this->getEnv('SECRET');
    }
}
