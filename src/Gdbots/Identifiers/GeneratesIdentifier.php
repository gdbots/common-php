<?php

namespace Gdbots\Identifiers;

interface GeneratesIdentifier
{
    /**
     * @return static
     */
    public static function generate();
}
