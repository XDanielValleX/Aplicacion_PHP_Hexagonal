<?php

declare(strict_types=1);

namespace App\Infrastructure\Entrypoints\Web\Presentation;

final class Flash
{
    private const KEY_MESSAGES = '_flash';
    private const KEY_OLD = '_flash_old';
    private const KEY_ERRORS = '_flash_errors';

    public static function success(string $message): void
    {
        self::addMessage('success', $message);
    }

    public static function error(string $message): void
    {
        self::addMessage('error', $message);
    }

    /**
     * @param array<string, mixed> $old
     */
    public static function setOld(array $old): void
    {
        $_SESSION[self::KEY_OLD] = $old;
    }

    /**
     * @return array<string, mixed>
     */
    public static function consumeOld(): array
    {
        $old = $_SESSION[self::KEY_OLD] ?? [];
        unset($_SESSION[self::KEY_OLD]);

        return is_array($old) ? $old : [];
    }

    /**
     * @param array<string, string> $errors
     */
    public static function setErrors(array $errors): void
    {
        $_SESSION[self::KEY_ERRORS] = $errors;
    }

    /**
     * @return array<string, string>
     */
    public static function consumeErrors(): array
    {
        $errors = $_SESSION[self::KEY_ERRORS] ?? [];
        unset($_SESSION[self::KEY_ERRORS]);

        return is_array($errors) ? $errors : [];
    }

    /** @return array<int, array{type: string, message: string}> */
    public static function consume(): array
    {
        $messages = $_SESSION[self::KEY_MESSAGES] ?? [];
        unset($_SESSION[self::KEY_MESSAGES]);

        return is_array($messages) ? $messages : [];
    }

    private static function addMessage(string $type, string $message): void
    {
        if (!isset($_SESSION[self::KEY_MESSAGES]) || !is_array($_SESSION[self::KEY_MESSAGES])) {
            $_SESSION[self::KEY_MESSAGES] = [];
        }

        $_SESSION[self::KEY_MESSAGES][] = [
            'type' => $type,
            'message' => $message,
        ];
    }
}
