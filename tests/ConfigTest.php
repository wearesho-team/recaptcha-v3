<?php

namespace Wearesho\ReCaptcha\V3\Tests;

use PHPUnit\Framework\TestCase;
use Wearesho\ReCaptcha;

/**
 * Class ConfigTest
 * @package Wearesho\ReCaptcha\V3\Tests
 */
class ConfigTest extends TestCase
{
    const SECRET = 'testSecret';

    /** @var ReCaptcha\V3\Config */
    protected $config;

    protected function setUp(): void
    {
        parent::setUp();
        $this->config = new ReCaptcha\V3\Config(static::SECRET);
    }

    public function testGetSecret(): void
    {
        $this->assertEquals(
            static::SECRET,
            $this->config->getSecret()
        );
    }
}
