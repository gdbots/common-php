<?php

namespace Gdbots\Common\Util;

final class DateUtils
{
    /**
     * This format differs from php's builtin @see \DateTime::ISO8601
     * in that is uses "P" instead of "O" to ensure a colon in the
     * gmt offset.
     *
     * @const string
     */
    const ISO8601 = 'Y-m-d\TH:i:s.uP';

    /**
     * October 15, 1582 UTC
     * @const int
     */
    const MIN_UTC_TIME = -12219292800;

    /**
     * Private constructor. This class is not meant to be instantiated.
     */
    private function __construct() {}

    /**
     * Returns true if it's a valid timestamp.
     *
     * @param string $timestamp
     * @param bool $allowNegative
     * @return bool
     */
    public static function isValidTimestamp($timestamp, $allowNegative = false)
    {
        $timestamp = (string) $timestamp;

        if ($allowNegative) {
            return ((string) (int) $timestamp === $timestamp)
                && ($timestamp <= PHP_INT_MAX)
                && ($timestamp >= self::MIN_UTC_TIME);
        }

        return ((string) (int) $timestamp === $timestamp)
            && ($timestamp <= PHP_INT_MAX)
            && ($timestamp >= 0);
    }

    /**
     * Returns true if the provided string is a valid ISO8601
     * formatted date-time.
     *
     * @param string $string
     * @return bool
     */
    public static function isValidISO8601Date($string)
    {
        if (\DateTime::createFromFormat(DateUtils::ISO8601, $string)) {
            return true;
        }

        if (\DateTime::createFromFormat(\DateTime::ISO8601, $string)) {
            return true;
        }

        return false;
    }
}
