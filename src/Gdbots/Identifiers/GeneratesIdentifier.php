<?php

namespace Gdbots\Identifiers;

interface GeneratesIdentifier
{
    /**
     * @return Identifier
     */
    public static function generate();
}
