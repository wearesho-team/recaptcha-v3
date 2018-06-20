<?php

namespace Wearesho\ReCaptcha\V3\Tests;

use Horat1us\Environment\MissingEnvironmentException;
use PHPUnit\Framework\TestCase;
use Wearesho\ReCaptcha;

/**
 * Class EnvironmentConfigTest
 * @package Wearesho\ReCaptcha\V3\Tests
 */
class EnvironmentConfigTest extends TestCase
{
    /** @var ReCaptcha\V3\EnvironmentConfig */
    protected $config;

    protected function setUp(): void
    {
        parent::setUp();
        $this->config = new ReCaptcha\V3\EnvironmentConfig();
    }

    public function testGetSecret(): void
    {
        putenv('RECAPTCHA_SECRET=123');
        $this->assertEquals(123, $this->config->getSecret());
        putenv('RECAPTCHA_SECRET');
        $this->expectException(MissingEnvironmentException::class);
        $this->config->getSecret();
    }
}
