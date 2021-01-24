<?php

declare(strict_types=1);

namespace Library\DateTime;

class Format
{
    public const SHORT_TIME = 'H:i';
    public const TIME       = 'H:i:s';

    public const DATE_DASH            = 'Y-m-d';
    public const SHORT_DATE_TIME_DASH = 'Y-m-d H:i';
    public const DATE_TIME_DASH       = 'Y-m-d H:i:s';

    public const DATE_DOT            = 'd.m.Y';
    public const SHORT_DATE_TIME_DOT = 'd.m.Y H:i';
    public const DATE_TIME_DOT       = 'd.m.Y H:i:s';

    public const DATE_SLASH            = 'd/m/Y';
    public const SHORT_DATE_TIME_SLASH = 'd/m/Y H:i';
    public const DATE_TIME_SLASH       = 'd/m/Y H:i:s';

    public const ISO_8601_UTC = 'Y-m-d\TH:i:s\Z';

    ////////////////////////////////////////////////////////////////

    /** @var \Library\DateTime\Factory */
    private $factory;

    /** @var string */
    private $format;

    ////////////////////////////////////////////////////////////////

    public function __construct(\Library\DateTime\Factory $factory, string $format)
    {
        $this->factory = $factory;
        $this->format  = $format;
    }

    ////////////////////////////////////////////////////////////////

    public function formatDateTime(\DateTime $dateTime, ?string $format = null): string
    {
        return $dateTime->format($format ?? $this->format);
    }

    public function formatString(string $time, ?string $formatTo = null, ?string $formatFrom = null): string
    {
        return $this->factory->createFromString($time, $formatFrom ?? $this->format)
                             ->format($formatTo ?? $this->format);
    }

    public function formatTimestamp(int $timestamp, ?string $format = null): string
    {
        return $this->factory->createFromTimestamp($timestamp)
                             ->format($format ?? $this->format);
    }

    ////////////////////////////////////////////////////////////////
}
