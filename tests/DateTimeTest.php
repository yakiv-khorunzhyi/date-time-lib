<?php

declare(strict_types=1);

namespace Test;

class DateTimeTest extends \PHPUnit\Framework\TestCase
{
    private const SUNDAY    = '2020-12-13';
    private const MONDAY    = '2020-12-14';
    private const TUESDAY   = '2020-12-15';
    private const WEDNESDAY = '2020-12-16';
    private const THURSDAY  = '2020-12-17';
    private const FRIDAY    = '2020-12-18';
    private const SATURDAY  = '2020-12-19';

    /** @var \Library\DateTime\Facade */
    private static $facade;

    ////////////////////////////////////////////////////////////////

    public static function setUpBeforeClass(): void
    {
        self::$facade = new \Library\DateTime\Facade();
    }

    ////////////////////////////////////////////////////////////////

    public function testDefaultFormat(): void
    {
        $dateTime = self::$facade->create();
        $dateTime = \DateTime::createFromFormat('Y-m-d H:i:s', $dateTime->toString());

        self::assertInstanceOf(\DateTime::class, $dateTime);
    }

    ////////////////////////////////////////////////////////////////

    public function testMethodsIs(): void
    {
        $dateTimeFail = self::$facade->createFromString(self::SUNDAY, 'Y-m-d');
        self::assertEquals(false, $dateTimeFail->isFriday());

        $dateTimeSunday = self::$facade->createFromString(self::SUNDAY, 'Y-m-d');
        self::assertEquals(true, $dateTimeSunday->isSunday());

        $dateTimeMonday = self::$facade->createFromString(self::MONDAY, 'Y-m-d');
        self::assertEquals(true, $dateTimeMonday->isMonday());

        $dateTimeTuesday = self::$facade->createFromString(self::TUESDAY, 'Y-m-d');
        self::assertEquals(true, $dateTimeTuesday->isTuesday());

        $dateTimeWednesday = self::$facade->createFromString(self::WEDNESDAY, 'Y-m-d');
        self::assertEquals(true, $dateTimeWednesday->isWednesday());

        $dateTimeThursday = self::$facade->createFromString(self::THURSDAY, 'Y-m-d');
        self::assertEquals(true, $dateTimeThursday->isThursday());

        $dateTimeFriday = self::$facade->createFromString(self::FRIDAY, 'Y-m-d');
        self::assertEquals(true, $dateTimeFriday->isFriday());

        $dateTimeSaturday = self::$facade->createFromString(self::SATURDAY, 'Y-m-d');
        self::assertEquals(true, $dateTimeSaturday->isSaturday());

        $dateTimeSaturday = self::$facade->createFromString(self::SATURDAY, 'Y-m-d');
        self::assertEquals(true, $dateTimeSaturday->isSaturday());

        $dateTimeToday = self::$facade->create();
        self::assertEquals(true, $dateTimeToday->isToday());

        $dateTimeFuture = self::$facade->createFromTimestamp(time() + 10);
        self::assertEquals(true, $dateTimeFuture->isFuture());

        $dateTimePast = self::$facade->createFromTimestamp(time() - 10);
        self::assertEquals(true, $dateTimePast->isPast());
    }

    ////////////////////////////////////////////////////////////////

    public function testModify(string $stringDateTime = '2020-10-10 10:10:10'): void
    {
        $dateTime = self::$facade->createFromString($stringDateTime, 'Y-m-d H:i:s');

        // seconds
        self::assertEquals(
            '2020-10-10 10:10:20',
            $dateTime->addSeconds(10)->toString()
        );
        self::assertEquals(
            $stringDateTime,
            $dateTime->subtractSeconds(10)->toString()
        );

        // minutes
        self::assertEquals(
            '2020-10-10 10:20:10',
            $dateTime->addMinutes(10)->toString()
        );
        self::assertEquals(
            $stringDateTime,
            $dateTime->subtractMinutes(10)->toString()
        );

        // hours
        self::assertEquals(
            '2020-10-10 20:10:10',
            $dateTime->addHours(10)->toString()
        );
        self::assertEquals(
            $stringDateTime,
            $dateTime->subtractHours(10)->toString()
        );

        // months
        self::assertEquals(
            '2020-11-10 10:10:10',
            $dateTime->addMonths(1)->toString()
        );
        self::assertEquals(
            $stringDateTime,
            $dateTime->subtractMonths(1)->toString()
        );

        // years
        self::assertEquals(
            '2021-10-10 10:10:10',
            $dateTime->addYears(1)->toString()
        );
        self::assertEquals(
            $stringDateTime,
            $dateTime->subtractYears(1)->toString()
        );
    }

    ////////////////////////////////////////////////////////////////

    public function testTimeZone(): void
    {
        $dateTime = self::$facade->create();

        self::assertInstanceOf(\DateTimeZone::class, $dateTime->getTimeZone());
        self::assertInstanceOf(\Library\DateTimeInterface::class, $dateTime->setTimeZone('UTC'));
        self::assertIsInt($dateTime->getOffset());
        self::assertEquals('+00:00', $dateTime->getStringOffset());
    }

    ////////////////////////////////////////////////////////////////

    public function testMethodsTo(): void
    {
        $dateTime = self::$facade->createFromString('2020-10-10', 'Y-m-d');

        self::assertEquals('10.10.2020', $dateTime->toString('d.m.Y'));
        self::assertIsInt($dateTime->toTimestamp());
        self::assertIsString((string)$dateTime);
    }

    public function testMoreThan(): void
    {
        $dateTimePast = self::$facade->createFromString('2020-10-10', 'Y-m-d');
        $dateTimeNow  = self::$facade->create();

        self::assertEquals(true, $dateTimeNow->moreThan($dateTimePast));
        self::assertEquals(false, $dateTimePast->moreThan($dateTimeNow));
    }

    public function testDifference(): void
    {
        $dateTime1        = self::$facade->createFromString('2020-10-10 10:10:10');
        $dateTime2        = self::$facade->createFromString('2021-11-11 20:20:20');
        $dateTimeInterval = $dateTime1->difference($dateTime2);

        self::assertInstanceOf(\Library\DateTime\Interval::class, $dateTimeInterval);
        self::assertEquals(1, $dateTimeInterval->getYears());
        self::assertEquals(1, $dateTimeInterval->getMonths());
        self::assertEquals(1, $dateTimeInterval->getDays());
        self::assertEquals(10, $dateTimeInterval->getHours());
        self::assertEquals(10, $dateTimeInterval->getMinutes());
        self::assertEquals(10, $dateTimeInterval->getSeconds());
        self::assertEquals(0, $dateTimeInterval->getMicroseconds());
        self::assertEquals(397, $dateTimeInterval->getDifferenceInDays());
        self::assertIsInt($dateTimeInterval->getTimestampDifference());
    }

    ////////////////////////////////////////////////////////////////
}
