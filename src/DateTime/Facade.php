<?php

declare(strict_types=1);

namespace Library\DateTime;

class Facade
{
    /** @var string */
    private $timeZoneName;

    /** @var \Library\DateTime\Factory */
    private $factory;

    /** @var \Library\DateTime\Format */
    private $formatter;

    ////////////////////////////////////////////////////////////////

    public function __construct(
        string $format = \Library\DateTime\Format::DATE_TIME_DASH,
        ?string $timeZoneName = null
    ) {
        $this->timeZoneName = $timeZoneName ?? date_default_timezone_get();
        $this->factory      = new \Library\DateTime\Factory($this->timeZoneName, $format);
        $this->formatter    = new \Library\DateTime\Format($this->factory, $format);
    }

    ////////////////////////////////////////////////////////////////

    /**
     * @param string|null $format       example: \Library\DateTime\Format::DATE_TIME_DASH
     * @param string|null $timeZoneName example: \Library\DateTime\TimeZone::UTC
     *
     * @return string
     */
    public function now(?string $format = null, ?string $timeZoneName = null): string
    {
        return $this->factory->create($timeZoneName)
                             ->toString($format);
    }

    /**
     * @param string|null $timeZoneName example: \Library\DateTime\TimeZone::UTC
     *
     * @return int
     */
    public function nowTimestamp(?string $timeZoneName = null): int
    {
        return $this->factory->create($timeZoneName)
                             ->toTimestamp();
    }

    ////////////////////////////////////////////////////////////////

    public function getTimeZoneName(): string
    {
        return $this->timeZoneName;
    }

    /**
     * @return string[] example: ['UTC' => '+00:00', ...]
     */
    public function getAllTimeZones(): array
    {
        return \Library\DateTime\TimeZone::getList();
    }

    /**
     * @param string|null $timeZoneName example: \Library\DateTime\TimeZone::UTC
     *
     * @return string example: '+00:00'
     */
    public function getTimeZoneOffset(?string $timeZoneName = null): string
    {
        $timeZoneName = $timeZoneName ?? $this->timeZoneName;
        $timeZoneList = \Library\DateTime\TimeZone::getList();

        if (!isset($timeZoneList[$timeZoneName])) {
            throw new \OutOfRangeException("TimeZone {$timeZoneName} not found.");
        }

        return $timeZoneList[$timeZoneName];
    }

    ////////////////////////////////////////////////////////////////

    public function create(?string $timeZoneName = null): \Library\DateTimeInterface
    {
        return $this->factory->create($timeZoneName);
    }

    public function createFromDate(
        int $year,
        int $month,
        int $day,
        ?string $timeZoneName = null
    ): \Library\DateTimeInterface {
        return $this->factory->createFromDate($year, $month, $day, $timeZoneName);
    }

    /**
     * @param string      $time         example: '2020-10-10 12:12:12'
     * @param string|null $format       example: \Library\DateTime\Format::DATE_TIME_DASH
     * @param string|null $timeZoneName example: \Library\DateTime\TimeZone::UTC
     *
     * @return \Library\DateTimeInterface
     */
    public function createFromString(
        string $time,
        string $format = null,
        ?string $timeZoneName = null
    ): \Library\DateTimeInterface {
        return $this->factory->createFromString($time, $format, $timeZoneName);
    }

    /**
     * @param int         $timestamp
     * @param string|null $timeZoneName example: \Library\DateTime\TimeZone::UTC
     *
     * @return \Library\DateTimeInterface
     */
    public function createFromTimestamp(int $timestamp, ?string $timeZoneName = null): \Library\DateTimeInterface
    {
        return $this->factory->createFromTimestamp($timestamp, $timeZoneName);
    }

    public function createFromJson(string $json, ?string $format = null)
    {
        return $this->factory->createFromJson($json, $format);
    }

    ////////////////////////////////////////////////////////////////

    /**
     * @param \DateTime   $dateTime
     * @param string|null $format example: \Library\DateTime\Format::DATE_TIME_DASH
     *
     * @return string
     */
    public function formatDateTime(\DateTime $dateTime, ?string $format = null): string
    {
        return $dateTime->format($format);
    }

    /**
     * @param string      $time       example: '2020-10-10 12:12:12'
     * @param string|null $formatTo   example: \Library\DateTime\Format::DATE_TIME_SLASH
     * @param string|null $formatFrom example: \Library\DateTime\Format::DATE_TIME_DASH
     *
     * @return string
     */
    public function formatString(string $time, ?string $formatTo = null, ?string $formatFrom = null): string
    {
        return $this->createFromString($time, $formatFrom)
                    ->toString($formatTo);
    }

    /**
     * If the format is NULL then the default format will be used.
     *
     * @param int         $timestamp
     * @param string|null $format example: \Library\DateTime\Format::DATE_TIME_SLASH
     *
     * @return string
     */
    public function formatTimestamp(int $timestamp, string $format = null): string
    {
        return $this->createFromTimestamp($timestamp)
                    ->toString($format);
    }

    ////////////////////////////////////////////////////////////////

    /**
     * If the format is NULL then the default format will be used.
     *
     * @param string      $time   example: '2020-10-10 12:12:12'
     * @param string|null $format example: \Library\DateTime\Format::DATE_TIME_SLASH
     *
     * @return bool
     */
    public function isValidFormat(string $time, string $format = null): bool
    {
        try {
            $this->factory->createFromString($time, $format, null);
        } catch (\LogicException $e) {
            return false;
        }

        return true;
    }

    ////////////////////////////////////////////////////////////////

    public function convertToJson(\Library\DateTimeInterface $dateTime): string
    {
        return json_encode([
            'date_time' => $dateTime->toString(\Library\DateTime\Format::DATE_TIME_DASH),
            'time_zone' => $dateTime->getTimeZone()->getName(),
        ]);
    }

    ////////////////////////////////////////////////////////////////
}
