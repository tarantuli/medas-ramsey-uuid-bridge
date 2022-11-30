<?php

declare(strict_types=1);

namespace Medas\RamseyUuidBridgeTest\Functional;

use Medas\RamseyUuidBridge\GuidProvider;
use Medas\ServiceManager\Values\Interfaces\Guid;
use PHPUnit\Framework\TestCase;

class GuidProviderTest extends TestCase
{
    public function testProvider(): void
    {
        $guid = service(GuidProvider::class)->create();

        self::assertInstanceOf(Guid::class, $guid);
    }
}
