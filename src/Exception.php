<?php

namespace Wearesho\ReCaptcha\V3;

use Throwable;

/**
 * Class Exception
 * @package Wearesho\ReCaptcha\V3
 */
class Exception extends \Exception implements ExceptionInterface
{
    const MISSING_INPUT_SECRET = 'missing-input-secret';
    const INVALID_INPUT_SECRET = 'invalid-input-secret';
    const MISSING_INPUT_RESPONSE = 'missing-input-response';
    const INVALID_INPUT_RESPONSE = 'invalid-input-response';
    const BAD_REQUEST = 'bad-request';

    /** @var Response */
    protected $response;

    public function __construct(Response $response, int $code = 0, Throwable $previous = null)
    {
        $message = implode(
            ', ',
            array_map([$this, 'getMessageByCode',], $response->getErrors())
        );
        parent::__construct($message, $code, $previous);
        $this->response = $response;
    }

    public function getResponse(): Response
    {
        return $this->response;
    }

    public function getMessageByCode(string $code): string
    {
        switch ($code) {
            case static::MISSING_INPUT_SECRET:
                return 'The secret parameter is missing';
            case static::INVALID_INPUT_SECRET:
                return 'The secret parameter is invalid or malformed';
            case static::MISSING_INPUT_RESPONSE:
                return 'The response parameter is missing';
            case static::INVALID_INPUT_RESPONSE:
                return 'The response parameter is invalid or malformed';
            case static::BAD_REQUEST:
                return 'The request is invalid or malformed';
        }
        return $code;
    }
}
