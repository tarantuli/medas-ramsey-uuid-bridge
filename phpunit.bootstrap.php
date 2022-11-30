<?php

declare(strict_types=1);

use Medas\RamseyUuidBridge\RamseyUuidBridgePackage;
use Medas\ServiceManager\ServiceManager;

chdir(__DIR__);

ServiceManager::get()
    ->addPackage(RamseyUuidBridgePackage::instance());
