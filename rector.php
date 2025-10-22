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

    // Importujemy najbardziej agresywne zestawy reguł od PHP 5.3 do 8.4, aby wymusić maksymalną modernizację.
    $rectorConfig->sets([
        // MODERNIZACJA KROK PO KROKU
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

        // AGRESYWNE ZESTAWY JAKOŚCI KODU I TYPOWANIA
        SetList::CODE_QUALITY,
        SetList::TYPE_DECLARATION,
        SetList::TYPE_DECLARATION_STRICT,
        SetList::EARLY_RETURN,
        SetList::DEAD_CODE,
        SetList::PRIVATIZATION,
        SetList::CODING_STYLE,
        SetList::CONTROVERSIAL,
        SetList::STRICT_BOOLEANS,
    ]);
};

