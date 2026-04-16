<?php

declare(strict_types=1);

namespace App\Domain\ValueObjects;

use App\Domain\Exceptions\DomainException;

final class UserRoleId
{
    private function __construct(
        private readonly int $value,
    ) {
    }

    public static function fromInt(int $value): self
    {
        if ($value <= 0) {
            throw new DomainException('Rol inválido.');
        }

        return new self($value);
    }

    public function value(): int
    {
        return $this->value;
    }
}
