<?php

declare(strict_types=1);

use Rector\Config\RectorConfig;
use Rector\Set\ValueObject\SetList;

return static function (RectorConfig $rectorConfig): void {
    // Określamy ścieżki do plików, które mają być analizowane i refaktoryzowane
    // Ścieżka ustawiona na __DIR__ (katalog główny repozytorium).
    $rectorConfig->paths([
        __DIR__,
    ]);

    // Wykluczamy katalogi
    $rectorConfig->skip([
        __DIR__ . '/vendor',
        __DIR__ . '/rector.php',
    ]);

    // Ustawiamy docelową wersję PHP, do której ma migrować Rector
    $rectorConfig->phpVersion(80400); // PHP 8.4

    // Importujemy zestawy reguł
    $rectorConfig->sets([
        // Zestawy reguł do migracji na PHP 8.4 (najważniejsze)
        SetList::PHP_84,
        SetList::PHP_83,
        SetList::PHP_82,
        SetList::PHP_81,
        SetList::PHP_80,

        // Zestawy reguł modernizujących kod
        SetList::CODE_QUALITY,
        SetList::TYPE_DECLARATION,
        SetList::EARLY_RETURN,
    ]);
};
