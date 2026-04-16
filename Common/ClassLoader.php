<?php

declare(strict_types=1);

namespace App\Common;

final class ClassLoader
{
    public static function register(string $projectRoot): void
    {
        $vendorAutoload = $projectRoot . '/vendor/autoload.php';
        if (is_file($vendorAutoload)) {
            require_once $vendorAutoload;
        }

        // Always register the fallback autoloader so the project works even
        // when Composer is not installed or the autoload map is not updated.
        $bootstrapAutoload = $projectRoot . '/bootstrap/autoload.php';
        if (is_file($bootstrapAutoload)) {
            require_once $bootstrapAutoload;
        }
    }
}
