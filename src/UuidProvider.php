<?php

declare(strict_types=1);

namespace Medas\RamseyUuidBridge;

use Medas\Core\{
    Attributes\Service,
    Interfaces\Uuid as UuidInterface,
    Interfaces\UuidProvider as UuidProviderInterface
};
use Ramsey\Uuid\{Uuid as RamseyUuid, UuidFactory};

#[Service]
class UuidProvider implements UuidProviderInterface
{
    public function create(): UuidInterface
    {
        return new Uuid(RamseyUuid::uuid7());
    }

    public function fromBytes(string $bytes): UuidInterface
    {
        return new Uuid((new UuidFactory())->fromBytes($bytes));
    }

    public function fromString(string $string): UuidInterface
    {
        return new Uuid(RamseyUuid::fromString($string));
    }
}
