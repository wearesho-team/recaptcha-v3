<?php

namespace Wearesho\ReCaptcha\V3;

use Throwable;

/**
 * Class Exception
 * @package Wearesho\ReCaptcha\V3
 */
class Exception extends \Exception
{
    public const MISSING_INPUT_SECRET = 'missing-input-secret';
    public const INVALID_INPUT_SECRET = 'invalid-input-secret';
    public const MISSING_INPUT_RESPONSE = 'missing-input-response';
    public const INVALID_INPUT_RESPONSE = 'invalid-input-response';
    public const BAD_REQUEST = 'bad-request';

    /** @var array */
    protected $errors;

    public function __construct(array $errors, int $code = 0, Throwable $previous = null)
    {
        $message = implode(
            ', ',
            array_map([$this, 'getMessageByCode',], $errors)
        );
        parent::__construct($message, $code, $previous);
        $this->errors = $errors;
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

    public function getErrors(): array
    {
        return $this->errors;
    }
}
