<?php

namespace Gdbots\Common\Util;

class DateUtils
{
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
                && ($timestamp >= ~PHP_INT_MAX);
        }

        return ((string) (int) $timestamp === $timestamp)
            && ($timestamp <= PHP_INT_MAX)
            && ($timestamp >= 0);
    }
}
