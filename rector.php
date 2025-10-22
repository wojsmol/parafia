<?php

declare(strict_types=1);

use Rector\Config\RectorConfig;
use Rector\Set\ValueObject\SetList;
use Rector\Core\ValueObject\LevelSetList;
use Rector\Autodiscovery\Rector\Namespace_\AddNamespaceByDirectoryRector;
use Rector\Autodiscovery\ValueObject\NamespaceByDirectory;

return static function (RectorConfig $rectorConfig): void {

    // paths to scan
    $rectorConfig->paths([
        __DIR__ . '/library',
        __DIR__,
    ]);

    // skip WP core templates / vendor / tests
    $rectorConfig->skip([
        __DIR__ . '/vendor',
        __DIR__ . '/node_modules',
        __DIR__ . '/assets',
        __DIR__ . '/tests',
        __DIR__ . '/functions.php',
        __DIR__ . '/header.php',
        __DIR__ . '/footer.php',
        __DIR__ . '/index.php',
    ]);

    // rector sets
    $rectorConfig->sets([
        LevelSetList::UP_TO_PHP_84,   // PHP 8.4 migration
        SetList::CODE_QUALITY,
        SetList::CODING_STYLE,
        SetList::DEAD_CODE,
    ]);

    // add namespace
    $rectorConfig->ruleWithConfiguration(AddNamespaceByDirectoryRector::class, [
        new NamespaceByDirectory('Parafia', __DIR__ . '/library'),
        new NamespaceByDirectory('Parafia', __DIR__), // main folder, except skipped files
    ]);
};
