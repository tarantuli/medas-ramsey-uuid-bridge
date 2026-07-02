<?php

declare(strict_types=1);

namespace Medas\RamseyUuidBridge;

use Medas\Core\{Attributes\ObjectToArrayHandler, Interfaces\Uuid as MedasUuidInterface};
use Ramsey\Uuid\UuidInterface;

#[ObjectToArrayHandler(UuidProvider::class)]
readonly class Uuid implements MedasUuidInterface
{
    public function __construct(
        private UuidInterface $uuid,
    )
    {
    }

    public function __toString(): string
    {
        return $this->uuid->toString();
    }

    public function jsonSerialize(): string
    {
        return $this->uuid->toString();
    }

    public function toBytes(): string
    {
        return $this->uuid->getBytes();
    }
}
