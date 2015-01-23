<?php

namespace Gdbots\Common;

/**
 * Value object for microtime with methods to convert to and from integers.
 *
 * @link http://php.net/manual/en/function.microtime.php
 */
final class Microtime implements \JsonSerializable
{
    /**
     * The microtime is stored as a 16 digit string.
     *
     * @var string
     */
    private $bigInt;

    /** @var int */
    private $sec;

    /** @var int */
    private $usec;

    /**
     */
    private function __construct()
    {
        /*
        $this->microtime = $microtime ?: microtime();
        list($usec, $sec) = explode(' ', $this->microtime);
        $this->sec = (int) $sec;
        $this->usec = (float) $usec;
        */
    }

    /**
     * Create a new object from the result of a gettimeofday call that
     * is NOT returned as a float.
     *
     * @link http://php.net/manual/en/function.gettimeofday.php
     *
     * @param array $tod
     * @return self
     */
    public static function fromTimeOfDay(array $tod)
    {
        $sec = $tod['sec'];
        $str = $sec . str_pad($tod['usec'], 6, '0', STR_PAD_LEFT);

        $m = new self();
        $m->sec = (int) substr($str, 0, 10);
        $m->usec = (int) substr($str, -6);
        $m->bigInt = $m->sec . $m->usec;
        return $m;
    }

    /**
     * Create a new object from the string version of the integer.
     *
     * Total digits would be unix timestamp (10) + (3-6) microtime digits.
     * Lack of precision on digits will be automatically padded with zeroes.
     *
     * @param string|int $str
     * @return self
     * @throws \InvalidArgumentException
     */
    public static function fromString($str)
    {
        $integer = (int) $str;
        $len = strlen($integer);
        if ($len < 13 || $len > 16) {
            throw new \InvalidArgumentException(
                sprintf(
                    'Input [%d] must be between 13 and 16 digits, [%d] given.',
                    $integer,
                    $len
                )
            );
        }

        if ($len < 16) {
            $integer = str_pad($integer, 16, '0');
        }

        $m = new self();
        $m->sec = (int) substr($integer, 0, 10);
        $m->usec = (int) substr($integer, -6);
        $m->bigInt = (string) $integer;
        return $m;
    }

    /**
     * @return string
     */
    public function toString()
    {
        return $this->bigInt;
    }

    /**
     * @return string
     */
    public function jsonSerialize()
    {
        return $this->toString();
    }

    /**
     * @return string
     */
    public function __toString()
    {
        return $this->toString();
    }

    /**
     * @return int
     */
    public function getSeconds()
    {
        return $this->sec;
    }

    /**
     * @return int
     */
    public function getMicroSeconds()
    {
        return $this->usec;
    }

    /**
     * @return \DateTime
     */
    public function toDateTime()
    {
        return new \DateTime('@' . $this->sec);
    }
}
