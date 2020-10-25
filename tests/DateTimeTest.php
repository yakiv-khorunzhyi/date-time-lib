<?php

/**
 * @author       Yakiv Khorunzhyi
 * @copyright    2020
 * @license      MIT
 */

declare(strict_types=1);

namespace Test;

class DateTimeTest extends \PHPUnit\Framework\TestCase
{
    /** @var \Library\DateTime */
    private static $libDateTime;

    ////////////////////////////////////////////////////////////////

    public static function setUpBeforeClass(): void
    {
        self::$libDateTime = new \Library\DateTime();
    }

    ////////////////////////////////////////////////////////////////

    public function testCreate(): void
    {
        self::assertInstanceOf(\DateTime::class, self::$libDateTime->create());

        self::assertInstanceOf(
            \DateTime::class,
            self::$libDateTime->create('2020-10-10', 'Y-m-d')
        );

        self::assertInstanceOf(
            \DateTime::class,
            self::$libDateTime->create(time())
        );
    }

    public function testGet(): void
    {
        self::assertIsInt(self::$libDateTime->getTimestamp());

        $dateTime = new \DateTime('now', new \DateTimeZone('UTC'));
        self::assertEquals(
            $dateTime->format('Y-m-d'),
            self::$libDateTime->getAsString('Y-m-d')
        );
    }

    public function testFormat(): void
    {
        self::assertEquals(
            date('Y-m-d'),
            self::$libDateTime->format(
                new \DateTime('now', new \DateTimeZone('UTC')),
                'Y-m-d'
            )
        );

        self::assertEquals(
            date('Y-m-d'),
            self::$libDateTime->format(date('Y-m-d'), 'Y-m-d', 'Y-m-d')
        );

        self::assertEquals(
            date('Y-m-d'),
            self::$libDateTime->format(time(), 'Y-m-d')
        );
    }

    public function testModifyDateTime(): void
    {
        $dateTime  = new \DateTime('now', new \DateTimeZone('UTC'));
        $timestamp = $dateTime->getTimestamp();

        self::$libDateTime->addSeconds($dateTime, 25 * \Library\DateTime::SECONDS_PER_MINUTE);

        self::assertEquals(
            $timestamp + (25 * 60),
            $dateTime->getTimestamp()
        );
    }

    ////////////////////////////////////////////////////////////////
}
