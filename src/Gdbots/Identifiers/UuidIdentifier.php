<?php

namespace Gdbots\Identifiers;

use Rhumsaa\Uuid\Uuid;

class UuidIdentifier implements Identifier, GeneratesIdentifier, \JsonSerializable
{
    /** @var Uuid */
    private $uuid;

    /**
     * @param Uuid $uuid
     */
    protected function __construct(Uuid $uuid)
    {
        $this->uuid = $uuid;
    }

    /**
     * {@inheritdoc}
     */
    public static function generate()
    {
        return new static(Uuid::uuid4());
    }

    /**
     * {@inheritdoc}
     */
    final public static function fromString($string)
    {
        return new static(Uuid::fromString($string));
    }

    /**
     * {@inheritdoc}
     */
    final public function toString()
    {
        return $this->uuid->toString();
    }

    /**
     * {@inheritdoc}
     */
    final public function __toString()
    {
        return $this->toString();
    }

    /**
     * {@inheritdoc}
     */
    final public function jsonSerialize()
    {
        return $this->toString();
    }

    /**
     * {@inheritdoc}
     */
    final public function equals(Identifier $other)
    {
        return $this->toString() === $other->toString();
    }
}
