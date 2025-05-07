<?php

declare(strict_types=1);

namespace Medas\RamseyUuidBridge;

use Medas\Core\Interfaces\Uuid as MedasUuidInterface;
use Ramsey\Uuid\UuidInterface;

class Uuid implements MedasUuidInterface
{
    public function __construct(
        private readonly UuidInterface $uuid,
    )
    {
    }

    public function __toString(): string
    {
        return $this->uuid->toString();
    }

    public function toBytes(): string
    {
        return $this->uuid->getBytes();
    }
}
