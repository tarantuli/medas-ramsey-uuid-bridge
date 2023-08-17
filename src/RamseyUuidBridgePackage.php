<?php

declare(strict_types=1);

namespace Medas\RamseyUuidBridge;

use Medas\Core\AsSingleton;
use Medas\ServiceManager\BasePackage;

class RamseyUuidBridgePackage extends BasePackage
{
    use AsSingleton;

    public function dependencies(): array
    {
        return [];
    }

    public function sourceDirectory(): string
    {
        return __DIR__;
    }
}
