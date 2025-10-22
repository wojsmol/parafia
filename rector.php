<?php

declare(strict_types=1);

use Rector\Config\RectorConfig;
use Rector\Set\ValueObject\SetList;
use Rector\Renaming\Rector\FuncCall\RenameFunctionRector;
use Rector\Transform\Rector\Function_\FunctionToMethodRector;
use Rector\Transform\ValueObject\FunctionToMethod;

return static function (RectorConfig $rectorConfig): void {
    // 1️⃣ Zestawy standardowe PHP
    $rectorConfig->sets([
        SetList::PHP_84,
    ]);

    // 2️⃣ Ścieżki do skanowania
    $rectorConfig->paths([
        __DIR__,               // główny folder szablonu
        __DIR__ . '/library',  // library
    ]);

    // 3️⃣ Ignorowanie katalogów nie zawierających PHP
    $rectorConfig->skip([
        __DIR__ . '/vendor',
        __DIR__ . '/node_modules',
        __DIR__ . '/assets',
        __DIR__ . '/tests',
    ]);

    // 4️⃣ Dodanie backslash dla globalnych funkcji WP
    $rectorConfig->ruleWithConfiguration(RenameFunctionRector::class, [
        'wp_*' => '\\wp_*',
    ]);

    // 5️⃣ Przerabianie funkcji w library na klasy
    $rectorConfig->ruleWithConfiguration(FunctionToMethodRector::class, [
        new FunctionToMethod('library', 'Parafia\\Library'),
        // Można dodać kolejne foldery jeśli będą funkcje do konwersji
    ]);
};
