<?php

declare(strict_types=1);

namespace Library;

interface DateTimeInterface
{
    public const MONDAY    = 1;
    public const TUESDAY   = 2;
    public const WEDNESDAY = 3;
    public const THURSDAY  = 4;
    public const FRIDAY    = 5;
    public const SATURDAY  = 6;
    public const SUNDAY    = 7;

    ////////////////////////////////////////////////////////////////

    public function __construct(\DateTime $dateTime, string $format);

    ////////////////////////////////////////////////////////////////

    public function isSunday(): bool;

    public function isMonday(): bool;

    public function isTuesday(): bool;

    public function isWednesday(): bool;

    public function isThursday(): bool;

    public function isFriday(): bool;

    public function isSaturday(): bool;

    public function isToday(): bool;

    public function isFuture(): bool;

    public function isPast(): bool;

    ////////////////////////////////////////////////////////////////

    public function setTimeZone(string $timeZoneName): \Library\DateTimeInterface;

    public function getTimeZone(): \DateTimeZone;

    public function getOffset(): int;

    public function getStringOffset(): string;

    ////////////////////////////////////////////////////////////////

    public function moreThan(\Library\DateTimeInterface $dateTime): bool;

    public function difference(\Library\DateTimeInterface $dateTime, $absolute = false): \Library\DateTime\Interval;

    ////////////////////////////////////////////////////////////////

    public function addSeconds(int $seconds): \Library\DateTimeInterface;

    public function subtractSeconds(int $seconds): \Library\DateTimeInterface;

    public function addMinutes(int $minutes): \Library\DateTimeInterface;

    public function subtractMinutes(int $minutes): \Library\DateTimeInterface;

    public function addHours(int $hours): \Library\DateTimeInterface;

    public function subtractHours(int $hours): \Library\DateTimeInterface;

    public function addMonths(int $months): \Library\DateTimeInterface;

    public function subtractMonths(int $months): \Library\DateTimeInterface;

    public function addYears(int $years): \Library\DateTimeInterface;

    public function subtractYears(int $years): \Library\DateTimeInterface;

    ////////////////////////////////////////////////////////////////

    public function toTimestamp(): int;

    public function toString(string $format = null): string;

    ////////////////////////////////////////////////////////////////

    public function getInstance(): \DateTime;

    ////////////////////////////////////////////////////////////////
}
