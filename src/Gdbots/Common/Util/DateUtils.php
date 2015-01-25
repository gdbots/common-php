<?php

namespace Gdbots\Common\Util;

class DateUtils
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
}
