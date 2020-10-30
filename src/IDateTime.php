<?php

/**
 * @author       Yakiv Khorunzhyi
 * @copyright    2020
 * @license      MIT
 */

declare(strict_types=1);

namespace Lib;

interface IDateTime
{
    ////////////////////////////////////////////////////////////////

    public function getAsString(string $format = self::DEFAULT_FORMAT): string;

    public function getTimestamp(): int;

    ////////////////////////////////////////////////////////////////

    /**
     * Param $format only needed if $dateTime is string.
     *
     * @param string|int|null $value
     * @param string          $format
     *
     * @return \DateTime
     * @throws \LogicException
     */
    public function create($value = null, string $format = self::DEFAULT_FORMAT): \DateTime;

    ////////////////////////////////////////////////////////////////

    /**
     * Param $formatFrom only needed if $dateTime is string.
     *
     * @param \DateTime|string|int $value
     * @param string               $formatTo
     * @param string               $formatFrom
     *
     * @return string
     * @throws \LogicException
     */
    public function format(
        $value,
        string $formatTo = self::DEFAULT_FORMAT,
        string $formatFrom = self::DEFAULT_FORMAT
    ): string;

    ////////////////////////////////////////////////////////////////

    /**
     * @param \DateTime $dateTime
     * @param int       $seconds
     *
     * @return $this
     */
    public function addSeconds(\DateTime $dateTime, int $seconds);

    ////////////////////////////////////////////////////////////////
}
