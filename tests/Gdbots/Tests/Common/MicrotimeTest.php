<?php

namespace Gdbots\Tests\Common;

use Gdbots\Common\Microtime;

class MicrotimeTest extends \PHPUnit_Framework_TestCase
{
    public function testFromTimeOfDay()
    {
        $i = 20;
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
        $i = 20;
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
        $usec = str_replace('0.', '', $usec);
        $date = new \DateTime('@' . $sec);
        $m = Microtime::fromString($sec . $usec);
        $this->assertSame($date->format('U'), $m->toDateTime()->format('U'));
    }
}
