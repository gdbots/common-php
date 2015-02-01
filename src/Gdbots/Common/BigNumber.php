<?php

namespace Gdbots\Common;

final class BigNumber extends \Moontoast\Math\BigNumber implements \JsonSerializable
{
    /**
     * @return string
     */
    public function jsonSerialize()
    {
        return (string) $this->getValue();
    }
}
