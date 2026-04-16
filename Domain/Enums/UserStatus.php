<?php

declare(strict_types=1);

namespace App\Domain\Enums;

use App\Domain\Exceptions\DomainException;

enum UserStatus: string
{
    case ACTIVE = 'ACTIVE';
    case INACTIVE = 'INACTIVE';

    public static function fromString(string $value): self
    {
        $value = strtoupper(trim($value));

        return match ($value) {
            'ACTIVE' => self::ACTIVE,
            'INACTIVE' => self::INACTIVE,
            default => throw new DomainException('Estado de usuario inválido.'),
        };
    }

    /**
     * @return list<string>
     */
    public static function values(): array
    {
        return array_map(static fn (self $s): string => $s->value, self::cases());
    }

    public static function isValid(string $value): bool
    {
        try {
            self::fromString($value);
            return true;
        } catch (\Throwable) {
            return false;
        }
    }

    public static function ensureIsValid(string $value): void
    {
        self::fromString($value);
    }
}
