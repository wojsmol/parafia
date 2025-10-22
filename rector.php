<?php

declare(strict_types=1);

use Rector\Config\RectorConfig;
use Rector\Set\ValueObject\SetList;
use Rector\Set\ValueObject\LevelSetList; // Nowy import

// usunięto use Fsylum\Rector\ValueObject\SetList; - omijamy niestabilny autoloader

return static function (RectorConfig $rectorConfig): void {
    // 1. Ustawienia ścieżek
    $rectorConfig->paths([
        __DIR__, // Główny folder projektu
        __DIR__ . '/library', 
        __DIR__ . '/rector.php',
    ]);

    // 2. Wykluczenie katalogów
    $rectorConfig->skip([
        __DIR__ . '/vendor/*',
    ]);

    // Włącz importowanie nazw
    $rectorConfig->importNames(true);

    // 3. Ustawienia poziomu PHP (8.4)
    $rectorConfig->phpVersion(80400); 

    // 4. Importowanie reguł modernizacji ogólnej
    $rectorConfig->sets([
        // Najwyższy dostępny poziom modernizacji PHP
        LevelSetList::UP_TO_PHP_84, 

        // Modernizacja ogólna i usuwanie przestarzałego kodu
        SetList::CODE_QUALITY,
        SetList::DEAD_CODE,
        SetList::CODING_STYLE,
        SetList::EARLY_RETURN,
        SetList::PRIVATIZATION,
    ]);
    
    // 5. JAWNY IMPORT REGUL WORDPRESSA
    // Używamy jawnej ścieżki do pliku konfiguracyjnego dla zestawu reguł WP 6.8
    // Ta ścieżka została zweryfikowana jako poprawna.
    $rectorConfig->import(__DIR__ . '/vendor/fsylum/rector-wordpress/config/sets/level/up-to-wp-6.8.php');


    // 6. Konfiguracja cache
    $rectorConfig->cacheDirectory(__DIR__ . '/var/cache/rector');
};
