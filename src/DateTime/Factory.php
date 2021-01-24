<?php

declare(strict_types=1);

namespace Library\DateTime;

class Factory
{
    /** @var string */
    private $timeZoneName;

    /** @var string */
    private $format;

    ////////////////////////////////////////////////////////////////

    public function __construct(string $timeZoneName, string $format)
    {
        $this->timeZoneName = $timeZoneName;
        $this->format       = $format;
    }

    ////////////////////////////////////////////////////////////////

    public function create(?string $timeZoneName = null): \Library\DateTimeInterface
    {
        return new \Library\DateTime(
            $this->createDateTime($timeZoneName),
            $this->format
        );
    }

    public function createFromDate(
        int $year,
        int $month,
        int $day,
        ?string $timeZoneName = null
    ): \Library\DateTimeInterface {
        $dateTime = $this->createDateTime($timeZoneName)
                         ->setDate($year, $month, $day);

        return $this->createCustomDateTime($dateTime, $this->format);
    }

    public function createFromString(
        string $time,
        ?string $format = null,
        ?string $timeZoneName = null
    ): \Library\DateTimeInterface {
        $dateTime = \DateTime::createFromFormat(
            $format ?? $this->format,
            $time,
            new \DateTimeZone($timeZoneName ?? $this->timeZoneName)
        );

        if ($dateTime === false) {
            $dateTimeClassName = \Library\DateTime::class;
            throw new \LogicException("Unable to create {$dateTimeClassName} object from given format: {$format}.");
        }

        return $this->createCustomDateTime($dateTime, $this->format);
    }

    public function createFromTimestamp(int $timestamp, ?string $timeZoneName = null): \Library\DateTimeInterface
    {
        $dateTime = $this->createDateTime($timeZoneName)
                         ->setTimestamp($timestamp);

        return $this->createCustomDateTime($dateTime, $this->format);
    }

    public function createFromJson(string $json, ?string $format = null): \Library\DateTimeInterface
    {
        $data   = json_decode($json, true);
        $format = $format ?? $this->format;

        if (is_null($data)) {
            throw new \RuntimeException('Unable to decode json.');
        }

        $dateTime = \DateTime::createFromFormat(
            $format,
            $data['date_time'],
            new \DateTimeZone($data['time_zone'])
        );

        if ($dateTime === false) {
            throw new \LogicException("Unable to create object from given json: {$json} and format: {$format}.");
        }

        return $this->createCustomDateTime($dateTime, $this->format);
    }

    ////////////////////////////////////////////////////////////////

    private function createDateTime(?string $timeZoneName): \DateTime
    {
        return new \DateTime(
            'now',
            new \DateTimeZone($timeZoneName ?? $this->timeZoneName)
        );
    }

    private function createCustomDateTime(\DateTime $dateTime, string $format): \Library\DateTimeInterface
    {
        return new \Library\DateTime($dateTime, $format);
    }

    ////////////////////////////////////////////////////////////////
}
