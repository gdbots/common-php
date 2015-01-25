<?php

namespace Gdbots\Tests\Common;

use Gdbots\Common\Util\DateUtils;

class DateUtilsTest extends \PHPUnit_Framework_TestCase
{
    public function testISO8601WithMicroseconds()
    {
        $expected = '2012-12-14T20:24:01.123456+00:00';
        $date = \DateTime::createFromFormat(DateUtils::ISO8601, $expected);
        $actual = $date->format(DateUtils::ISO8601);
        $this->assertSame($expected, $actual);
    }
}
