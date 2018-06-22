<?php

namespace Wearesho\ReCaptcha\V3;

/**
 * Class Response
 * @package Wearesho\ReCaptcha\V3
 */
class Response
{
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
        float $score,
        string $action,
        \DateTime $dateTime,
        string $hostname
    ) {
        $this->score = $score;
        $this->action = $action;
        $this->dateTime = $dateTime;
        $this->hostname = $hostname;
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
}
