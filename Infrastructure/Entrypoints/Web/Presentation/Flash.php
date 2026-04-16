<?php

declare(strict_types=1);

namespace App\Infrastructure\Entrypoints\Web\Presentation;

final class Flash
{
    private const KEY = '_flash';

    public static function success(string $message): void
    {
        self::add('success', $message);
    }

    public static function error(string $message): void
    {
        self::add('error', $message);
    }

    /** @return array<int, array{type: string, message: string}> */
    public static function consume(): array
    {
        $messages = $_SESSION[self::KEY] ?? [];
        unset($_SESSION[self::KEY]);

        return is_array($messages) ? $messages : [];
    }

    private static function add(string $type, string $message): void
    {
        if (!isset($_SESSION[self::KEY]) || !is_array($_SESSION[self::KEY])) {
            $_SESSION[self::KEY] = [];
        }

        $_SESSION[self::KEY][] = [
            'type' => $type,
            'message' => $message,
        ];
    }
}
