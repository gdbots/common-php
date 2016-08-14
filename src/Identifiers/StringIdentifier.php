<?php

namespace Gdbots\Identifiers;

use Gdbots\Common\Util\StringUtils;

/**
 * @deprecated Use "Gdbots\Pbj\WellKnown\StringIdentifier" from "gdbots/pbj" 1.1.x or later instead.
 */
abstract class StringIdentifier implements Identifier, \JsonSerializable
{
    /** @var string */
    protected $string;

    /**
     * @param string $string
     * @throws \InvalidArgumentException
     */
    protected function __construct($string)
    {
        @trigger_error(sprintf('"%s" is deprecated.  Use "Gdbots\Pbj\WellKnown\StringIdentifier" from "gdbots/pbj" 1.1.x or later instead.', __CLASS__), E_USER_DEPRECATED);

        if (!is_string($string)) {
            throw new \InvalidArgumentException(
                sprintf('String expected but got [%s].', StringUtils::varToString($string))
            );
        }

        $this->string = trim((string) $string);

        if (empty($this->string)) {
            throw new \InvalidArgumentException('String cannot be empty.');
        }
    }

    /**
     * {@inheritdoc}
     * @return static
     */
    public static function fromString($string)
    {
        return new static($string);
    }

    /**
     * {@inheritdoc}
     */
    public function toString()
    {
        return $this->string;
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
