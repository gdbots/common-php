<?php

namespace Gdbots\Identifiers;

use Ramsey\Uuid\Uuid;
use Ramsey\Uuid\UuidInterface;

/**
 * @deprecated Use "Gdbots\Pbj\WellKnown\UuidIdentifier" from "gdbots/pbj" 1.1.x or later instead.
 */
class UuidIdentifier implements Identifier, GeneratesIdentifier, \JsonSerializable
{
    /** @var UuidInterface */
    protected $uuid;

    /**
     * @param UuidInterface $uuid
     */
    protected function __construct(UuidInterface $uuid)
    {
        @trigger_error(sprintf('"%s" is deprecated.  Use "Gdbots\Pbj\WellKnown\[Time]UuidIdentifier" from "gdbots/pbj" 1.1.x or later instead.', __CLASS__), E_USER_DEPRECATED);
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
    public static function fromString($string)
    {
        return new static(Uuid::fromString($string));
    }

    /**
     * {@inheritdoc}
     */
    public function toString()
    {
        return $this->uuid->toString();
    }

    /**
     * {@inheritdoc}
     */
    public function __toString()
    {
        return $this->toString();
    }

    /**
     * {@inheritdoc}
     */
    public function jsonSerialize()
    {
        return $this->toString();
    }

    /**
     * {@inheritdoc}
     */
    public function equals(Identifier $other)
    {
        return $this == $other;
    }
}
