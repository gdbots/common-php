<?php

namespace Gdbots\Identifiers;

use Gdbots\Common\Util\StringUtils;

abstract class StringIdentifier implements Identifier, \JsonSerializable
{
    /** @var string */
    private $string;

    /**
     * @param string $string
     * @throws \InvalidArgumentException
     */
    public function __construct($string)
    {
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
     */
    final public static function fromString($string)
    {
        return new static($string);
    }

    /**
     * {@inheritdoc}
     */
    final public function toString()
    {
        return $this->string;
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
