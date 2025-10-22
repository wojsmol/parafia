<?php

declare(strict_types=1);

use Rector\Config\RectorConfig;
use Rector\Set\ValueObject\SetList;

return static function (RectorConfig $rectorConfig): void {
    // Określamy ścieżki do plików, które mają być analizowane i refaktoryzowane
    $rectorConfig->paths([
        __DIR__,
    ]);

    // Wykluczamy katalogi
    $rectorConfig->skip([
        __DIR__ . '/vendor',
        __DIR__ . '/rector.php',
    ]);

    // Ustawiamy docelową wersję PHP, do której ma migrować Rector.
    // Docelowa wersja PHP to 8.4 (80400).
    $rectorConfig->phpVersion(80400);

    // Importujemy zestawy reguł od PHP 5.3 do 8.4, aby zapewnić kompletną migrację.
    $rectorConfig->sets([
        // MODERNIZACJA KROK PO KROKU (od PHP 5.3 do 8.4)
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
        SetList::PHP_84, // Docelowa wersja

        // AGRESYWNA MODERNIZACJA I ULEPSZANIE KODU
        SetList::CODE_QUALITY,
        SetList::TYPE_DECLARATION,
        SetList::EARLY_RETURN,
        SetList::DEAD_CODE,         // Usuwa nieużywany kod
        SetList::PRIVATIZATION,     // Dodaje private/readonly i promuje w konstruktorach
    ]);
};
