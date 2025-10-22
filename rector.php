<?php

declare(strict_types=1);

use Rector\Config\RectorConfig;
use Rector\Set\ValueObject\SetList;

return static function (RectorConfig $rectorConfig): void {
    // Ścieżka ustawiona na __DIR__ (katalog główny repozytorium).
    $rectorConfig->paths([
        __DIR__,
    ]);

    // Wykluczamy katalogi
    $rectorConfig->skip([
        __DIR__ . '/vendor',
        __DIR__ . '/rector.php',
    ]);

    // Ustawiamy docelową wersję PHP
    $rectorConfig->phpVersion(80400); // PHP 8.4

    // Importujemy zestawy reguł
    $rectorConfig->sets([
        // Najważniejsze zestawy do migracji na PHP 8.4
        SetList::PHP_84,
        SetList::PHP_83,
        SetList::PHP_82,
        SetList::PHP_81,
        SetList::PHP_80,

        // Agresywne zestawy modernizujące (sprawdzone i stabilne z obecną wersją Rectora):
        SetList::CODE_QUALITY,
        SetList::TYPE_DECLARATION,   // Dodaje typy zwracane i właściwości
        SetList::EARLY_RETURN,
        SetList::DEAD_CODE,         // Usuwa nieużywany kod i zmienne
        SetList::PRIVATIZATION,     // Dodaje private/readonly, promuje właściwości
    ]);
};
