<?php

declare(strict_types=1);

namespace Medas\RamseyUuidBridge;

use Medas\Core\{
    Attributes\Service,
    Interfaces\ObjectToArrayHandler,
    Interfaces\Uuid as UuidInterface,
    Interfaces\UuidProvider as UuidProviderInterface
};
use Ramsey\Uuid\{Uuid as RamseyUuid, UuidFactory};

#[Service]
class UuidProvider implements UuidProviderInterface, ObjectToArrayHandler
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

    public function toArray(object $value): array
    {
        /** @var Uuid $value */
        return [$value->toBytes()];
    }

    public function toObject(array $value): object
    {
        return $this->fromBytes($value[0]);
    }
}
