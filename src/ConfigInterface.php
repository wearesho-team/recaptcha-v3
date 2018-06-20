<?php

namespace Wearesho\ReCaptcha\V3;

/**
 * Interface ConfigInterface
 * @package Wearesho\ReCaptcha\V3
 */
interface ConfigInterface
{
    public function getSecret(): string;
}
