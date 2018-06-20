<?php

namespace Wearesho\ReCaptcha\V3;

/**
 * Class Config
 * @package Wearesho\ReCaptcha\V3
 */
class Config implements ConfigInterface
{
    /** @var string */
    protected $secret;

    public function __construct(string $secret)
    {
        $this->secret = $secret;
    }

    public function getSecret(): string
    {
        return $this->secret;
    }
}
