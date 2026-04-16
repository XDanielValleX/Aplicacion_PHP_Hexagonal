<?php

declare(strict_types=1);

/**
 * Minimal PSR-4-ish autoloader so the project can run even if Composer
 * is not installed yet. If you later run `composer install`, prefer
 * requiring vendor/autoload.php instead.
 */

spl_autoload_register(function (string $class): void {
    $prefixes = [
        'App\\Common\\' => __DIR__ . '/../Common/',
        'App\\Domain\\' => __DIR__ . '/../Domain/',
        'App\\Application\\' => __DIR__ . '/../Application/',
        'App\\Infrastructure\\' => __DIR__ . '/../Infrastructure/',
    ];

    foreach ($prefixes as $prefix => $baseDir) {
        if (!str_starts_with($class, $prefix)) {
            continue;
        }

        $relativeClass = substr($class, strlen($prefix));
        $file = $baseDir . str_replace('\\', '/', $relativeClass) . '.php';

        if (is_file($file)) {
            require $file;
        }

        return;
    }
});
