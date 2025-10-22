<?php

declare(strict_types=1);

use Rector\Config\RectorConfig;
use Rector\Set\ValueObject\SetList;

return static function (RectorConfig $rectorConfig): void {
    // Foldery do skanowania
    $rectorConfig->paths([
        __DIR__,               // główny katalog szablonu
        __DIR__ . '/library',  // katalog z kodem PHP
    ]);

    // Wykluczenia folderów nieistotnych
    $rectorConfig->skip([
        __DIR__ . '/vendor',
        __DIR__ . '/node_modules',
        __DIR__ . '/assets',
        __DIR__ . '/tests',
    ]);

    // Zestawy reguł do modernizacji od PHP 5.3 do 8.4
    $rectorConfig->sets([
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
    ]);

    // Ułatwienia dla kodu WordPress
    $rectorConfig->importNames();       // automatyczny use
    $rectorConfig->importShortClasses(); // krótkie nazwy klas
};
