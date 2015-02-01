<?php

namespace Gdbots\Identifiers;

use Rhumsaa\Uuid\Uuid;

class TimeUuidIdentifier extends UuidIdentifier
{
    /**
     * @param Uuid $uuid
     * @throws \InvalidArgumentException
     */
    protected function __construct(Uuid $uuid)
    {
        parent::__construct($uuid);
        $version = $uuid->getVersion();
        if ($version !== 1) {
            throw new \InvalidArgumentException(
                sprintf('A time based (version 1) uuid is required.  Version provided [%s].', $version)
            );
        }
    }

    /**
     * {@inheritdoc}
     */
    public static function generate()
    {
        return new static(Uuid::uuid1());
    }
}