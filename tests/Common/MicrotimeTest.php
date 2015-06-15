<?php

namespace Gdbots\Tests\Common;

use Gdbots\Common\Microtime;

/**
 * Some of the tests run many iterations to ensure that different values
 * returned from microtime() and gettimeofday() calls cover more possibilites.
 */
class MicrotimeTest extends \PHPUnit_Framework_TestCase
{
    protected $testCount = 2500;

    public function testFromTimeOfDay()
    {
        $i = $this->testCount;
        do {
            $tod = gettimeofday();
            $sec = $tod['sec'];
            $usec = $tod['usec'];
            $str = $sec . str_pad($tod['usec'], 6, '0', STR_PAD_LEFT);
            $m = Microtime::fromTimeOfDay($tod);

            $this->assertSame($sec, $m->getSeconds());
            $this->assertSame($sec, (int) $m->toDateTime()->format('U'));
            $this->assertSame($usec, $m->getMicroSeconds());
            $this->assertSame($str, $m->toString());
            --$i;
        } while ($i > 0);
    }

    public function testFromString()
    {
        $i = $this->testCount;
        do {
            $tod = gettimeofday();
            $sec = $tod['sec'];
            $usec = $tod['usec'];
            $str = $sec . str_pad($tod['usec'], 6, '0', STR_PAD_LEFT);
            $m = Microtime::fromString($str);

            $this->assertSame($sec, $m->getSeconds());
            $this->assertSame($sec, (int) $m->toDateTime()->format('U'));
            $this->assertSame($usec, $m->getMicroSeconds());
            $this->assertSame($str, $m->toString());
            --$i;
        } while ($i > 0);
    }

    /**
     * verifies that the microsecond precision is properly padded with
     * zeroes when a full 6 digits are not provided.  padding is done on
     * the right side.  e.g. 123 becomes 123000,
     */
    public function testFromStringPrecision()
    {
        $sec = time();
        $i = 6;
        do {
            $usec = str_repeat('1', $i);
            $usecFixed = (int) str_pad($usec, 6, '0');
            $str = $sec . $usecFixed;

            $m = Microtime::fromString($sec . $usec);
            $this->assertSame($sec, $m->getSeconds());
            $this->assertSame($sec, (int) $m->toDateTime()->format('U'));
            $this->assertSame($usecFixed, $m->getMicroSeconds());
            $this->assertSame($str, $m->toString());
            --$i;
        } while ($i > 2);
    }

    public function testToDateTime()
    {
        $microtime = microtime(true);
        list($sec, $usec) = explode('.', $microtime);
        $usec = str_pad($usec, 6, '0');
        $date = new \DateTime(date('Y-m-d H:i:s.' . $usec, $sec));
        $m = Microtime::fromString($sec . $usec);
        $this->assertSame($date->format('Y-m-d H:i:s.u'), $m->toDateTime()->format('Y-m-d H:i:s.u'));
    }

    /**
     * Funky test as float values get rounded when you clip digits and recreate
     * them so what we're doing is verifying the float that is regenerated
     * from the object results in the same 16 digit integer.
     */
    public function testToFloat()
    {
        $i = $this->testCount;
        do {
            $microtime = microtime(true);
            $m = Microtime::fromFloat($microtime);
            $f1 = substr(str_pad(str_replace('.', '', $microtime), 16, '0'), 0, 16);
            $f2 = substr(str_pad(str_replace('.', '', $m->toFloat()), 16, '0'), 0, 16);
            $this->assertSame($f1, $f2);
            --$i;
        } while ($i > 0);
    }
}
