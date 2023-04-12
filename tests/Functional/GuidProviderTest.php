<?php

declare(strict_types=1);

namespace Medas\RamseyUuidBridgeTest\Functional;

use Medas\Core\Interfaces\Guid;
use Medas\RamseyUuidBridge\GuidProvider;
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
