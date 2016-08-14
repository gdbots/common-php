<?php

namespace Gdbots\Identifiers;

/**
 * @deprecated Use "Gdbots\Pbj\WellKnown\GeneratesIdentifier" from "gdbots/pbj" 1.1.x or later instead.
 */
interface GeneratesIdentifier
{
    /**
     * @return static
     */
    public static function generate();
}
