<?php

declare(strict_types=1);

namespace Medas\RamseyUuidBridge;

use Medas\ServiceManager\Attributes\Service;
use Medas\ServiceManager\Values\Interfaces\{Guid as GuidInterface, GuidProvider as GuidProviderInterface};
use Ramsey\Uuid\Uuid;

#[Service]
class GuidProvider implements GuidProviderInterface
{
    public function create(): GuidInterface
    {
        return new Guid(Uuid::uuid7());
    }
}
