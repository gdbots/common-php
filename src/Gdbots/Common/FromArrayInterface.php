<?php

namespace Gdbots\Common;

/**
 * An object that can be restore from an array
 */
interface FromArrayInterface
{
    /**
     * Returns a new object from the provided array.  The array
     * should be data returned from toArray or at least match
     * that signature.
     *
     * @param array $data
     * @return self
     */
    public static function fromArray(array $data = array());
}
