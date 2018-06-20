<?php

namespace Wearesho\ReCaptcha\V3;

/**
 * Interface ExceptionInterface
 * @package Wearesho\ReCaptcha\V3
 */
interface ExceptionInterface extends \Throwable
{
    public function getResponse(): Response;
}
