<?php

declare(strict_types=1);

namespace Medas\RamseyUuidBridge;

use Medas\ServiceManager\Values\Interfaces\Guid as GuidInterface;
use Ramsey\Uuid\UuidInterface;

class Guid implements GuidInterface
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
}
