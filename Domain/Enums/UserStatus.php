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
}
