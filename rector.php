<?php

declare(strict_types=1);

use Rector\Config\RectorConfig;
use Rector\Core\ValueObject\PhpVersion;
use Rector\Renaming\Rector\FuncCall\RenameFunctionRector;
use Rector\CodingStyle\Rector\FuncCall\FullyQualifiedStrictTypesRector;
use Rector\Set\ValueObject\SetList;

return static function (RectorConfig $rectorConfig): void {
    // 1️⃣ Skany folderów
    $rectorConfig->paths([
        __DIR__ . '/library',
        __DIR__ . '/functions.php',
        __DIR__ . '/index.php',
        __DIR__ . '/template-parts',
        __DIR__ . '/assets', // opcjonalnie, jeśli są php
    ]);

    // 2️⃣ Wykluczenia
    $rectorConfig->skip([
        __DIR__ . '/vendor',
        __DIR__ . '/node_modules',
        __DIR__ . '/tests',
    ]);

    // 3️⃣ Docelowa wersja PHP
    $rectorConfig->phpVersion(PhpVersion::PHP_84);

    // 4️⃣ Używamy standardowych zestawów
    $rectorConfig->sets([
        SetList::PHP_74,
        SetList::PHP_80,
        SetList::CODE_QUALITY,
        SetList::DEAD_CODE,
        SetList::TYPE_DECLARATION,
    ]);

    // 5️⃣ Namespacing bibliotek
    $rectorConfig->autoloadPaths([
        __DIR__ . '/library',
    ]);

    // 6️⃣ Globalne funkcje WP: doda \ do każdej wywoływanej w namespace
    $rectorConfig->rule(FullyQualifiedStrictTypesRector::class);
	);
};
