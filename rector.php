<?php

declare(strict_types=1);

use Rector\Config\RectorConfig;
use Rector\Set\ValueObject\SetList;
use Fsylum\Rector\ValueObject\SetList as FsylumSetList;

return static function (RectorConfig $rectorConfig): void {
    // 1. Ustawienia ścieżek
    // Skanowanie głównego folderu oraz katalogu 'library'.
    $rectorConfig->paths([
        __DIR__, // Główny folder projektu
        __DIR__ . '/library', 
        __DIR__ . '/rector.php',
    ]);

    // 2. Wykluczenie katalogów
    // Wykluczamy katalog vendor.
    $rectorConfig->skip([
        __DIR__ . '/vendor/*',
    ]);

    // 3. Ustawienia poziomu PHP (zgodne z PHP 8.4)
    $rectorConfig->phpVersion(80400); 

    // 4. Importowanie reguł modernizacji
    $rectorConfig->sets([
        // Modernizacja ogólna i usuwanie przestarzałego kodu
        SetList::CODE_QUALITY,
        SetList::DEAD_CODE,
        SetList::CODING_STYLE,
        SetList::EARLY_RETURN,
        SetList::PRIVATIZATION,
        
        // Zestaw reguł specyficzny dla WordPressa
        FsylumSetList::WORDPRESS_STRICT,
    ]);

    // 5. Konfiguracja cache (opcjonalne, ale zalecane)
    $rectorConfig->cacheDirectory(__DIR__ . '/var/cache/rector');
};