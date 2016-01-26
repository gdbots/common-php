<?php

namespace Gdbots\Identifiers;

use Ramsey\Uuid\Uuid;
use Ramsey\Uuid\UuidInterface;

class UuidIdentifier implements Identifier, GeneratesIdentifier, \JsonSerializable
{
    /** @var UuidInterface */
    private $uuid;

    /**
     * @param UuidInterface $uuid
     */
    protected function __construct(UuidInterface $uuid)
    {
        $this->uuid = $uuid;
    }

    /**
     * {@inheritdoc}
     * @return static
     */
    public static function generate()
    {
        return new static(Uuid::uuid4());
    }

    /**
     * {@inheritdoc}
     * @return static
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
        return $this == $other;
    }
}
