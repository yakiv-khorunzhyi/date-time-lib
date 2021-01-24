<?php

declare(strict_types=1);

namespace Test;

class FacadeTest extends \PHPUnit\Framework\TestCase
{
    /** @var \Library\DateTime\Facade */
    private static $facade;

    private static $dateTimeInterface = \Library\DateTimeInterface::class;

    ////////////////////////////////////////////////////////////////

    public static function setUpBeforeClass(): void
    {
        self::$facade = new \Library\DateTime\Facade();
    }

    ////////////////////////////////////////////////////////////////

    public function testFactory(): void
    {
        $dateTimeNow = self::$facade->create();

        self::assertInstanceOf(self::$dateTimeInterface, $dateTimeNow);
        self::assertEquals(
            date(\Library\DateTime\Format::SHORT_DATE_TIME_DASH),
            $dateTimeNow->toString(\Library\DateTime\Format::SHORT_DATE_TIME_DASH)
        );

        $dateTimeFromString = self::$facade->createFromString('2020-10-10', 'Y-m-d');

        self::assertInstanceOf(self::$dateTimeInterface, $dateTimeFromString);
        self::assertEquals(
            '2020-10-10',
            $dateTimeFromString->toString(\Library\DateTime\Format::DATE_DASH)
        );

        $dateTimeFromTimestamp = self::$facade->createFromTimestamp(time());

        self::assertInstanceOf(self::$dateTimeInterface, $dateTimeFromTimestamp);
        self::assertEquals(
            date(\Library\DateTime\Format::SHORT_DATE_TIME_DASH),
            $dateTimeFromTimestamp->toString(\Library\DateTime\Format::SHORT_DATE_TIME_DASH)
        );

        $dateTimeFromDate = self::$facade->createFromDate(2020, 10, 10);
        self::assertInstanceOf(self::$dateTimeInterface, $dateTimeFromDate);
        self::assertEquals(
            '2020-10-10',
            $dateTimeFromDate->toString(\Library\DateTime\Format::DATE_DASH)
        );
    }

    public function testMethodsNow(): void
    {
        self::assertIsInt(self::$facade->nowTimestamp());

        $dateTime = new \DateTime('now', new \DateTimeZone('UTC'));
        self::assertEquals(
            $dateTime->format('Y-m-d'),
            self::$facade->now('Y-m-d')
        );
    }

    public function testFormat(): void
    {
        self::assertEquals(
            date('Y-m-d'),
            self::$facade->formatDateTime(
                new \DateTime('now', new \DateTimeZone('UTC')),
                'Y-m-d'
            )
        );

        self::assertEquals(
            date('Y-m-d'),
            self::$facade->formatString(date('Y-m-d'), 'Y-m-d', 'Y-m-d')
        );

        self::assertEquals(
            date('Y-m-d'),
            self::$facade->formatTimestamp(time(), 'Y-m-d')
        );
    }

    public function testValidationFormat(): void
    {
        $true  = self::$facade->isValidFormat('2020-10-10', 'Y-m-d');
        $false = self::$facade->isValidFormat('2020-10-10 H:i:s', 'Y-m-d');

        self::assertEquals(true, $true);
        self::assertEquals(false, $false);
    }

    ////////////////////////////////////////////////////////////////
}
