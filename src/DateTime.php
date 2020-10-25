<?php

/**
 * @author       Yakiv Khorunzhyi
 * @copyright    2020
 * @license      MIT
 */

declare(strict_types=1);

namespace Library;

class DateTime implements \Library\IDateTime
{
    public const DEFAULT_FORMAT = 'Y-m-d H:i:s';

    public const SECONDS_PER_MINUTE = 60;
    public const SECONDS_PER_HOUR   = 3600;
    public const SECONDS_PER_DAY    = 86400;
    public const SECONDS_PER_WEEK   = 604800;

    /** @var \DateTimeZone */
    private $timeZone;

    ////////////////////////////////////////////////////////////////

    public function __construct()
    {
        $this->timeZone = new \DateTimeZone('UTC');
    }

    ////////////////////////////////////////////////////////////////

    public function setTimeZone(string $timeZone): self
    {
        $this->timeZone = new \DateTimeZone($timeZone);
    }

    ////////////////////////////////////////////////////////////////

    public function getAsString(string $format = self::DEFAULT_FORMAT): string
    {
        return $this->create()->format($format);
    }

    public function getTimestamp(): int
    {
        return $this->create()->getTimestamp();
    }

    ////////////////////////////////////////////////////////////////

    public function create($value = null, string $format = self::DEFAULT_FORMAT): \DateTime
    {
        switch (true) {
            case is_null($value):
                return new \DateTime('now', $this->timeZone);
            case is_string($value):
                return $this->getDateTimeFromString($value, $format);
            case is_integer($value):
                return $this->getDateTimeFromTimestamp($value);
            default:
                throw new \LogicException('Unsupported type: ' . gettype($value) . '. Used string or int.');
        }
    }

    ////////////////////////////////////////////////////////////////

    public function format(
        $value,
        string $formatTo = self::DEFAULT_FORMAT,
        string $formatFrom = self::DEFAULT_FORMAT
    ): string {
        switch (true) {
            case $value instanceof \DateTime:
                return $value->format($formatTo);
            case is_string($value):
                return $this->getDateTimeFromString($value, $formatFrom)->format($formatTo);
            case is_integer($value):
                return $this->getDateTimeFromTimestamp($value)->format($formatTo);
            default:
                throw new \LogicException(
                    'Unsupported type: ' . gettype($value) . '. Used \DateTime, string or int.'
                );
        }
    }

    ////////////////////////////////////////////////////////////////

    public function addSeconds(\DateTime $dateTime, int $seconds): self
    {
        $dateTime->add(new \DateInterval("PT{$seconds}S"));

        return $this;
    }

    ////////////////////////////////////////////////////////////////

    private function getDateTimeFromString(string $value, string $format): \DateTime
    {
        $dateTime = \DateTime::createFromFormat($format, $value);

        if ($dateTime === false) {
            throw new \LogicException(
                "Unable to create \DateTime object from given format: {$format}"
            );
        }

        return $dateTime;
    }

    private function getDateTimeFromTimestamp(int $timestamp): \DateTime
    {
        $dateTime = $this->create();
        $dateTime->setTimestamp($timestamp);

        return $dateTime;
    }

    ////////////////////////////////////////////////////////////////
}
