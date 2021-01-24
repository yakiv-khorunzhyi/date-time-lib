<?php

declare(strict_types=1);

namespace Library;

class DateTime implements \Library\DateTimeInterface
{
    /** @var string */
    private $format;

    /** @var \DateTime */
    private $dateTime;

    ////////////////////////////////////////////////////////////////

    public function __construct(\DateTime $dateTime, string $format)
    {
        $this->format   = $format;
        $this->dateTime = $dateTime;
    }

    ////////////////////////////////////////////////////////////////

    public function isSunday(): bool
    {
        return (int)$this->dateTime->format('N') === self::SUNDAY;
    }

    public function isMonday(): bool
    {
        return (int)$this->dateTime->format('N') === self::MONDAY;
    }

    public function isTuesday(): bool
    {
        return (int)$this->dateTime->format('N') === self::TUESDAY;
    }

    public function isWednesday(): bool
    {
        return (int)$this->dateTime->format('N') === self::WEDNESDAY;
    }

    public function isThursday(): bool
    {
        return (int)$this->dateTime->format('N') === self::THURSDAY;
    }

    public function isFriday(): bool
    {
        return (int)$this->dateTime->format('N') === self::FRIDAY;
    }

    public function isSaturday(): bool
    {
        return (int)$this->dateTime->format('N') === self::SATURDAY;
    }

    public function isToday(): bool
    {
        return $this->dateTime->format('Y-m-d') === $this->now()->format('Y-m-d');
    }

    public function isFuture(): bool
    {
        return $this->dateTime->getTimestamp() > time();
    }

    public function isPast(): bool
    {
        return $this->dateTime->getTimestamp() < time();
    }

    ////////////////////////////////////////////////////////////////

    public function setTimeZone(string $timeZoneName): \Library\DateTimeInterface
    {
        $this->dateTime->setTimezone(new \DateTimeZone($timeZoneName));

        return $this;
    }

    public function getTimeZone(): \DateTimeZone
    {
        return $this->dateTime->getTimezone();
    }

    public function getOffset(): int
    {
        return $this->dateTime->getOffset();
    }

    public function getStringOffset(): string
    {
        return \Library\DateTime\TimeZone::getList()[$this->dateTime->getTimezone()->getName()];
    }

    ////////////////////////////////////////////////////////////////

    public function moreThan(\Library\DateTimeInterface $dateTime): bool
    {
        return $this->dateTime->getTimestamp() > $dateTime->toTimestamp();
    }

    public function difference(\Library\DateTimeInterface $dateTime, $absolute = false): \Library\DateTime\Interval
    {
        $dateInterval = $this->dateTime->diff($dateTime->getInstance());

        if ($dateInterval === false) {
            throw new \LogicException('Unable to retrieve difference.');
        }

        return new \Library\DateTime\Interval(
            $dateInterval,
            $this->dateTime->getTimestamp() - $dateTime->toTimestamp()
        );
    }

    ////////////////////////////////////////////////////////////////

    public function addSeconds(int $seconds): \Library\DateTimeInterface
    {
        $dateTime = $this->dateTime->modify("+{$seconds} seconds");
        $this->validateModify($dateTime);

        return $this;
    }

    public function subtractSeconds(int $seconds): \Library\DateTimeInterface
    {
        $dateTime = $this->dateTime->modify("-{$seconds} seconds");
        $this->validateModify($dateTime);

        return $this;
    }

    public function addMinutes(int $minutes): \Library\DateTimeInterface
    {
        $dateTime = $this->dateTime->modify("+{$minutes} minutes");
        $this->validateModify($dateTime);

        return $this;
    }

    public function subtractMinutes(int $minutes): \Library\DateTimeInterface
    {
        $dateTime = $this->dateTime->modify("-{$minutes} minutes");
        $this->validateModify($dateTime);

        return $this;
    }

    public function addHours(int $hours): \Library\DateTimeInterface
    {
        $dateTime = $this->dateTime->modify("+{$hours} hours");
        $this->validateModify($dateTime);

        return $this;
    }

    public function subtractHours(int $hours): \Library\DateTimeInterface
    {
        $dateTime = $this->dateTime->modify("-{$hours} hours");
        $this->validateModify($dateTime);

        return $this;
    }

    public function addMonths(int $months): \Library\DateTimeInterface
    {
        $dateTime = $this->dateTime->modify("+{$months} months");
        $this->validateModify($dateTime);

        return $this;
    }

    public function subtractMonths(int $months): \Library\DateTimeInterface
    {
        $dateTime = $this->dateTime->modify("-{$months} months");
        $this->validateModify($dateTime);

        return $this;
    }

    public function addYears(int $years): \Library\DateTimeInterface
    {
        $dateTime = $this->dateTime->modify("+{$years} years");
        $this->validateModify($dateTime);

        return $this;
    }

    public function subtractYears(int $years): \Library\DateTimeInterface
    {
        $dateTime = $this->dateTime->modify("-{$years} years");
        $this->validateModify($dateTime);

        return $this;
    }

    ////////////////////////////////////////////////////////////////

    public function toTimestamp(): int
    {
        return $this->dateTime->getTimestamp();
    }

    public function toString(string $format = null): string
    {
        return $this->dateTime->format($format ?? $this->format);
    }

    ////////////////////////////////////////////////////////////////

    public function getInstance(): \DateTime
    {
        return $this->dateTime;
    }

    ////////////////////////////////////////////////////////////////

    public function __toString(): string
    {
        return $this->toString();
    }

    ////////////////////////////////////////////////////////////////

    private function now(): \DateTime
    {
        return new \DateTime('now', $this->getTimeZone());
    }

    private function validateModify($dateTime): void
    {
        if ($dateTime === false) {
            $dateTimeClassName = \Library\DateTime::class;
            throw new \LogicException("Unable to modify {$dateTimeClassName} object.");
        }
    }

    ////////////////////////////////////////////////////////////////
}
