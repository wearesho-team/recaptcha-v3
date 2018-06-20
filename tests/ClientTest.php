<?php

namespace Wearesho\ReCaptcha\V3\Tests;

use PHPUnit\Framework\TestCase;
use GuzzleHttp;
use Wearesho\ReCaptcha;

/**
 * Class ClientTest
 * @package Wearesho\ReCaptcha\V3\Tests
 */
class ClientTest extends TestCase
{
    const SECRET = 'secret';

    /** @var ReCaptcha\V3\Config */
    protected $config;

    /** @var ReCaptcha\V3\Client */
    protected $client;

    /** @var GuzzleHttp\Handler\MockHandler */
    protected $mock;

    /** @var array */
    protected $container;

    protected function setUp(): void
    {
        parent::setUp();
        $this->config = new ReCaptcha\V3\Config(static::SECRET);

        $this->container = [];
        $this->mock = new GuzzleHttp\Handler\MockHandler();
        $history = GuzzleHttp\Middleware::history($this->container);

        $stack = new GuzzleHttp\HandlerStack($this->mock);
        $stack->push($history);

        $this->client = new ReCaptcha\V3\Client($this->config, new GuzzleHttp\Client([
            'handler' => $stack,
        ]));
    }

    public function testSendingParams(): void
    {
        $this->mock->append(
            new GuzzleHttp\Psr7\Response(200, [], json_encode([
                'success' => true,
                'score' => 1,
                'action' => 'test',
                'challenge_ts' => date('c'),
                'hostname' => 'wearesho.com',
            ]))
        );

        $this->client->verify('response', '127.0.0.1');

        /** @var GuzzleHttp\Psr7\Request $request */
        $request = $this->container[0]['request'];

        $this->assertEquals(ReCaptcha\V3\Client::REQUEST_URL, (string)$request->getUri());
        $this->assertEquals(
            'secret=secret&response=response&remoteip=127.0.0.1',
            (string)$request->getBody()
        );
    }

    public function testParsing(): void
    {
        $this->mock->append(
            new GuzzleHttp\Psr7\Response(200, [], json_encode([
                'success' => $success = true,
                'score' => $score = 0.82,
                'action' => $action = 'test',
                'challenge_ts' => $date = date('c'),
                'hostname' => $hostname = 'wearesho.com',
            ]))
        );

        $response = $this->client->verify('response', '127.0.0.1');
        $this->assertEquals(
            $success,
            $response->isSuccess()
        );
        $this->assertEquals(
            $score,
            $response->getScore()
        );
        $this->assertEquals(
            $action,
            $response->getAction()
        );
        $this->assertEquals(
            $date,
            $response->getDateTime()->format('c')
        );
        $this->assertEquals(
            $hostname,
            $response->getHostname()
        );
    }

    /**
     * @expectedException \Exception
     * @expectedExceptionMessage Error decoding Google response: Syntax error
     */
    public function testInvalidJson(): void
    {
        $this->mock->append(new GuzzleHttp\Psr7\Response(200, [], '{invalidJson'));

        $this->client->verify('response', '127.0.0.1');
    }

    /**
     * @expectedException \Exception
     * @expectedExceptionMessage Missing required response attribute: score
     */
    public function testMissingJsonFields()
    {
        $this->mock->append(new GuzzleHttp\Psr7\Response(200, [], json_encode([
            'success' => true,
        ])));

        $this->client->verify('response', '127.0.0.1');
    }

    /**
     * @expectedException \Wearesho\ReCaptcha\V3\Exception
     * @expectedExceptionMessage The request is invalid or malformed
     */
    public function testGeneratingException(): void
    {
        $this->mock->append(
            new GuzzleHttp\Psr7\Response(200, [], json_encode([
                'success' => $success = false,
                'score' => $score = 0.82,
                'action' => $action = 'test',
                'challenge_ts' => $date = date('c'),
                'hostname' => $hostname = 'wearesho.com',
                'error_codes' => [
                    ReCaptcha\V3\Exception::BAD_REQUEST,
                ],
            ]))
        );

        $this->client->verify('response', '127.0.0.1');
    }
}
