<?php

namespace Wearesho\ReCaptcha\V3\Tests;

use PHPUnit\Framework\TestCase;
use Wearesho\ReCaptcha;

/**
 * Class ExceptionTest
 * @package Wearesho\ReCaptcha\V3\Tests
 */
class ExceptionTest extends TestCase
{
    /** @var ReCaptcha\V3\Exception
     */
    protected $exception;

    public function setUp(): void
    {
        parent::setUp();
        $this->exception = new ReCaptcha\V3\Exception([
            ReCaptcha\V3\Exception::INVALID_INPUT_RESPONSE,
            ReCaptcha\V3\Exception::MISSING_INPUT_RESPONSE,
            ReCaptcha\V3\Exception::INVALID_INPUT_SECRET,
            ReCaptcha\V3\Exception::MISSING_INPUT_SECRET,
            ReCaptcha\V3\Exception::BAD_REQUEST,
            'some-not-documented',
        ]);
    }

    public function testGetMessage(): void
    {
        $this->assertEquals(
            'The response parameter is invalid or malformed, The response parameter is missing, The secret parameter is invalid or malformed, The secret parameter is missing, The request is invalid or malformed, some-not-documented', // phpcs:ignore
            $this->exception->getMessage()
        );
    }

    public function testGetErrors(): void
    {
        $this->assertArraySubset(
            [
                ReCaptcha\V3\Exception::INVALID_INPUT_RESPONSE,
                ReCaptcha\V3\Exception::MISSING_INPUT_RESPONSE,
                ReCaptcha\V3\Exception::INVALID_INPUT_SECRET,
                ReCaptcha\V3\Exception::MISSING_INPUT_SECRET,
                ReCaptcha\V3\Exception::BAD_REQUEST,
                'some-not-documented',
            ],
            $this->exception->getErrors()
        );
    }
}
