<?php

declare(strict_types=1);

namespace Library\DateTime;

class Interval
{
    public const MICROSECONDS_PER_SECOND = 1000000;
    public const SECONDS_PER_MINUTE      = 60;
    public const SECONDS_PER_HOUR        = 3600;
    public const SECONDS_PER_DAY         = 86400;
    public const SECONDS_PER_WEEK        = 604800;

    ////////////////////////////////////////////////////////////////

    /** @var \DateInterval */
    private $dateInterval;

    /** @var int */
    private $timestamp;

    ////////////////////////////////////////////////////////////////

    public function __construct(\DateInterval $dateInterval, int $timestamp)
    {
        if ($timestamp < 0) {
            $timestamp *= -1;
        }

        $this->timestamp    = $timestamp;
        $this->dateInterval = $dateInterval;
    }

    ////////////////////////////////////////////////////////////////

    public function getMicroseconds(): float
    {
        return $this->dateInterval->f;
    }

    public function getSeconds(): int
    {
        return $this->dateInterval->s;
    }

    public function getMinutes(): int
    {
        return $this->dateInterval->i;
    }

    public function getHours(): int
    {
        return $this->dateInterval->h;
    }

    public function getDays(): int
    {
        return $this->dateInterval->d;
    }

    public function getMonths(): int
    {
        return $this->dateInterval->m;
    }

    public function getYears(): int
    {
        return $this->dateInterval->y;
    }

    ////////////////////////////////////////////////////////////////

    public function isNegative(): bool
    {
        return $this->dateInterval->invert === 1;
    }

    public function getDifferenceInDays(): int
    {
        return $this->dateInterval->days;
    }

    public function getTimestampDifference(): int
    {
        return $this->timestamp;
    }

    public function getDateInterval(): \DateInterval
    {
        return $this->dateInterval;
    }

    public function toString(string $format): string
    {
        return $this->dateInterval->format($format);
    }

    ////////////////////////////////////////////////////////////////
}
