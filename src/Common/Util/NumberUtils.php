<?php

namespace Gdbots\Common\Util;

final class NumberUtils
{
    /**
     * Private constructor. This class is not meant to be instantiated.
     */
    private function __construct()
    {
    }

    /**
     * Returns an integer within a boundary.
     *
     * @param int $number
     * @param int $min
     * @param int $max
     *
     * @return int
     */
    public static function bound($number, $min = 0, $max = PHP_INT_MAX)
    {
        $number = (int)$number;
        $min = (int)$min;
        $max = (int)$max;

        return min(max($number, $min), $max);
    }
}
