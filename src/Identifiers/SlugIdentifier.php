<?php

namespace Gdbots\Identifiers;

use Gdbots\Common\Util\SlugUtils;
use Gdbots\Common\Util\StringUtils;

/**
 * @deprecated Use "Gdbots\Pbj\WellKnown\SlugIdentifier" from "gdbots/pbj" 1.1.x or later instead.
 */
abstract class SlugIdentifier implements Identifier, \JsonSerializable
{
    /** @var string */
    protected $slug;

    /**
     * @param string $slug
     *
     * @throws \InvalidArgumentException
     */
    protected function __construct($slug)
    {
        @trigger_error(sprintf('"%s" is deprecated.  Use "Gdbots\Pbj\WellKnown\SlugIdentifier" from "gdbots/pbj" 1.1.x or later instead.', __CLASS__), E_USER_DEPRECATED);

        if (!is_string($slug)) {
            throw new \InvalidArgumentException(
                sprintf('String expected but got [%s].', StringUtils::varToString($slug))
            );
        }

        if (!SlugUtils::isValid($slug)) {
            throw new \InvalidArgumentException(
                sprintf('The value [%s] is not a valid slug.', $slug)
            );
        }

        $this->slug = $slug;
    }

    /**
     * @param string $string
     *
     * @return static
     */
    public static function create($string)
    {
        return new static(SlugUtils::create($string));
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
        return $this->slug;
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
