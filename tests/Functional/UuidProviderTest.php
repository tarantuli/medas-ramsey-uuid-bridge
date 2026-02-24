<?php

declare(strict_types=1);

namespace Medas\RamseyUuidBridgeTest\Functional;

use Medas\Core\Interfaces\Uuid;
use Medas\RamseyUuidBridge\UuidProvider;
use PHPUnit\Framework\TestCase;

class UuidProviderTest extends TestCase
{
    public function testProvider(): void
    {
        $uuid = service(UuidProvider::class)->create();

        self::assertInstanceOf(Uuid::class, $uuid);
    }

    public function testFromBytes(): void
    {
        $uuid = service(UuidProvider::class)->create();
        $bytes = $uuid->toBytes();

        self::assertInstanceOf(Uuid::class, service(UuidProvider::class)->fromBytes($bytes));
    }

    public function testFromString(): void
    {
        $uuid = service(UuidProvider::class)->create();
        $string = (string) $uuid;
        self::assertSame($string, (string) service(UuidProvider::class)->fromString($string));
    }
}
