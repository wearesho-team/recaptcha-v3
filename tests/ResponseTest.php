<?php

namespace Wearesho\ReCaptcha\V3\Tests;

use PHPUnit\Framework\TestCase;
use Wearesho\ReCaptcha;

/**
 * Class ResponseTest
 * @package Wearesho\ReCaptcha\V3\Tests
 */
class ResponseTest extends TestCase
{
    const SCORE = 0.6;
    const ACTION = 'login';
    const TIMESTAMP = 190000;
    const HOSTNAME = 'wearesho.com';
    const ERROR_CODE = 'error-code';

    /** @var ReCaptcha\V3\Response */
    protected $response;

    protected function setUp(): void
    {
        parent::setUp();
        $this->response = new ReCaptcha\V3\Response(
            static::SCORE,
            static::ACTION,
            (new \DateTime())->setTimestamp(static::TIMESTAMP),
            static::HOSTNAME
        );
    }

    public function testGetScore(): void
    {
        $this->assertEquals(
            static::SCORE,
            $this->response->getScore()
        );
    }

    public function getGetAction(): void
    {
        $this->assertEquals(
            static::ACTION,
            $this->response->getAction()
        );
    }

    public function testGetDateTime(): void
    {
        $this->assertEquals(
            static::TIMESTAMP,
            $this->response->getDateTime()->getTimestamp()
        );
    }

    public function testGetHostName(): void
    {
        $this->assertEquals(
            static::HOSTNAME,
            $this->response->getHostname()
        );
    }
}
