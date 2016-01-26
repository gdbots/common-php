<?php

namespace Gdbots\Tests\Common;

use Gdbots\Common\Util\DateUtils;

class DateUtilsTest extends \PHPUnit_Framework_TestCase
{
    public function testUtcZuluWithMicroseconds()
    {
        $expected = '2012-12-14T20:24:01.123456Z';
        $date = \DateTime::createFromFormat(DateUtils::ISO8601_ZULU, $expected);
        $actual = $date->format(DateUtils::ISO8601_ZULU);
        $this->assertSame($expected, $actual);
    }

    public function testISO8601WithMicroseconds()
    {
        $expected = '2012-12-14T20:24:01.123456+00:00';
        $date = \DateTime::createFromFormat(DateUtils::ISO8601, $expected);
        $actual = $date->format(DateUtils::ISO8601);
        $this->assertSame($expected, $actual);
    }

    public function testIsValidISO8601Date()
    {
        $this->assertTrue(DateUtils::isValidISO8601Date('2012-12-14T20:24:01.123456+00:00'));
        $this->assertTrue(DateUtils::isValidISO8601Date('2012-12-14T20:24:01+00:00'));
        $this->assertTrue(DateUtils::isValidISO8601Date('2012-12-14T20:24:01.123456Z'));
        $this->assertTrue(DateUtils::isValidISO8601Date('2012-12-14T20:24:01Z'));

        $this->assertFalse(DateUtils::isValidISO8601Date('2012-12-14T20:24:01.123456+00:00AA'));
        $this->assertFalse(DateUtils::isValidISO8601Date('2012-12-14T20:24:0100:00'));
        $this->assertFalse(DateUtils::isValidISO8601Date('2012-12-14T20:24:01.123456'));
    }
}
