<?php

declare(strict_types=1);

namespace Medas\RamseyUuidBridgeTest\Functional;

use Medas\RamseyUuidBridge\GuidProvider;
use Medas\ServiceManager\Interfaces\Guid;
use PHPUnit\Framework\TestCase;

class GuidProviderTest extends TestCase
{
    public function testProvider(): void
    {
        $guid = service(GuidProvider::class)->create();
        self::assertInstanceOf(Guid::class, $guid);
    }

    public function testFromBytes(): void
    {
        $guid = service(GuidProvider::class)->create();

        $bytes = $guid->toBytes();
        self::assertInstanceOf(Guid::class, service(GuidProvider::class)->fromBytes($bytes));
    }
}
