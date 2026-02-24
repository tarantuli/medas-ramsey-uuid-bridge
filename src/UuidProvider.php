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
    private UuidFactory $factory;

    public function __construct()
    {
        $this->factory = new UuidFactory();
    }

    public function create(): UuidInterface
    {
        return new Uuid(RamseyUuid::uuid7());
    }

    public function fromBytes(string $bytes): UuidInterface
    {
        try {
            return new Uuid($this->factory->fromBytes($bytes));
        }
        catch (\Throwable $e) {
            throw new Exceptions\InvalidBytesGiven($bytes, $e);
        }
    }

    public function fromString(string $string): UuidInterface
    {
        try {
            return new Uuid(RamseyUuid::fromString($string));
        }
        catch (\Throwable $e) {
            throw new Exceptions\InvalidStringGiven($string, $e);
        }
    }
}
