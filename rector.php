<?php

declare(strict_types=1);

use Rector\Config\RectorConfig;
use Rector\Set\ValueObject\SetList;
use Rector\PHPUnit\Set\PHPUnitSetList;

return static function (RectorConfig $config): void {
    // 🔍 Skany folderów z kodem PHP
    $config->paths([
        __DIR__,
        __DIR__ . '/library',
    ]);

    // 🚫 Ignoruj katalogi bez kodu
    $config->skip([
        __DIR__ . '/vendor',
        __DIR__ . '/node_modules',
        __DIR__ . '/assets',
        __DIR__ . '/tests',
        __DIR__ . '/backup',
    ]);

    // 📜 Ustawienia PHP od wersji 5.3 do 8.4
    $config->phpVersion(80400);

    // ⚙️ Zestawy modernizacji
    $config->sets([
        SetList::PHP_53,
        SetList::PHP_54,
        SetList::PHP_55,
        SetList::PHP_56,
        SetList::PHP_70,
        SetList::PHP_71,
        SetList::PHP_72,
        SetList::PHP_73,
        SetList::PHP_74,
        SetList::PHP_80,
        SetList::PHP_81,
        SetList::PHP_82,
        SetList::PHP_83,
        SetList::PHP_84,
        SetList::CODE_QUALITY,
        SetList::DEAD_CODE,
        SetList::TYPE_DECLARATION,
        PHPUnitSetList::PHPUNIT_100,
    ]);

    // ✅ Automatyczne importy i typowanie
    $config->importNames();
    $config->importShortClasses(false);
};
