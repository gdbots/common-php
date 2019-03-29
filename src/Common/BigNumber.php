<?php

namespace Gdbots\Common;

/**
 * @deprecated Use "Gdbots\Pbj\WellKnown\BigNumber" from "gdbots/pbj" 1.1.x or later instead.
 */
class BigNumber extends \Moontoast\Math\BigNumber implements \JsonSerializable
{
    /**
     * BigNumber constructor.
     *
     * @param mixed $number
     * @param null  $scale
     */
    public function __construct($number, $scale = null)
    {
        @trigger_error(sprintf('"%s" is deprecated.  Use "Gdbots\Pbj\WellKnown\BigNumber" from "gdbots/pbj" 1.1.x or later instead.', __CLASS__), E_USER_DEPRECATED);
        parent::__construct($number, $scale);
    }

    /**
     * @return string
     */
    public function jsonSerialize()
    {
        return (string)$this->getValue();
    }
}
