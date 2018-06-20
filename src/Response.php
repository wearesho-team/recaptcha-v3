<?php

namespace Wearesho\ReCaptcha\V3;

/**
 * Class Response
 * @package Wearesho\ReCaptcha\V3
 */
class Response
{
    /** @var bool */
    protected $success;

    /** @var float */
    protected $score;

    /** @var string */
    protected $action;

    /** @var \DateTime */
    protected $dateTime;

    /** @var string */
    protected $hostname;

    /** @var array */
    protected $errors = [];

    public function __construct(
        bool $success,
        float $score,
        string $action,
        \DateTime $dateTime,
        string $hostname,
        array $errors
    ) {
        $this->success = $success;
        $this->score = $score;
        $this->action = $action;
        $this->dateTime = $dateTime;
        $this->hostname = $hostname;
        $this->errors = $errors;
    }

    public function isSuccess(): bool
    {
        return $this->success;
    }

    public function getScore(): float
    {
        return $this->score;
    }

    public function getAction(): string
    {
        return $this->action;
    }

    public function getDateTime(): \DateTime
    {
        return $this->dateTime;
    }

    public function getHostname(): string
    {
        return $this->hostname;
    }

    public function getErrors(): array
    {
        return $this->errors;
    }
}
