<?php

namespace Gdbots\Tests\Identifiers;

use Gdbots\Identifiers\TimeUuidIdentifier;
use Rhumsaa\Uuid\Uuid;

class TimeUuidIdentifierTest extends \PHPUnit_Framework_TestCase
{
    public function testGenerate()
    {
        $id = TimeUuidIdentifier::generate();
        $this->assertTrue(Uuid::isValid($id));

        $uuid = Uuid::fromString($id->toString());
        $this->assertTrue($uuid->getVersion() == 1);
    }

    public function testFromString()
    {
        $id = TimeUuidIdentifier::fromString(Uuid::NAMESPACE_DNS);
        $this->assertSame($id->toString(), Uuid::NAMESPACE_DNS);
    }

    public function testEquals()
    {
        $id = TimeUuidIdentifier::fromString(Uuid::NAMESPACE_DNS);
        $id2 = TimeUuidIdentifier::fromString(Uuid::NAMESPACE_DNS);
        $id3 = TimeUuidIdentifier::fromString(Uuid::NAMESPACE_OID);
        $this->assertTrue($id->equals($id2));
        $this->assertFalse($id->equals($id3));
    }
}
