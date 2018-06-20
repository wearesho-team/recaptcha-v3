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
    /** @var ReCaptcha\V3\Exception */
    protected $exception;

    /** @var ReCaptcha\V3\Response */
    protected $response;

    protected function setUp(): void
    {
        parent::setUp();
        $this->response = new ReCaptcha\V3\Response(
            false,
            0.5,
            'test',
            new \DateTime,
            'wearesho.com',
            [
                ReCaptcha\V3\Exception::INVALID_INPUT_RESPONSE,
                ReCaptcha\V3\Exception::MISSING_INPUT_RESPONSE,
                ReCaptcha\V3\Exception::INVALID_INPUT_SECRET,
                ReCaptcha\V3\Exception::MISSING_INPUT_SECRET,
                ReCaptcha\V3\Exception::BAD_REQUEST,
            ]
        );
        $this->exception = new ReCaptcha\V3\Exception($this->response);
    }

    public function testGetMessage(): void
    {
        $this->assertEquals(
            'The response parameter is invalid or malformed, The response parameter is missing, The secret parameter is invalid or malformed, The secret parameter is missing, The request is invalid or malformed', // phpcs:ignore
            $this->exception->getMessage()
        );
    }

    public function testGetResponse(): void
    {
        $this->assertEquals(
            $this->response,
            $this->exception->getResponse()
        );
    }
}
