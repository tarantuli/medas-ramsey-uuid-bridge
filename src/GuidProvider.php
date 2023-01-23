<?php

declare(strict_types=1);

namespace Medas\RamseyUuidBridge;

use Medas\ServiceManager\Attributes\Service;
use Medas\ServiceManager\Values\Interfaces\{Guid as GuidInterface, GuidProvider as GuidProviderInterface};
use Ramsey\Uuid\Uuid;
use Ramsey\Uuid\UuidFactory;

#[Service]
class GuidProvider implements GuidProviderInterface
{
    public function create(): GuidInterface
    {
        return new Guid(Uuid::uuid7());
    }

    public function fromBytes(string $bytes): GuidInterface
    {
        return new Guid((new UuidFactory())->fromBytes($bytes));
    }
}
