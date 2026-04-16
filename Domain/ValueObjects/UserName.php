<?php

declare(strict_types=1);

namespace App\Domain\ValueObjects;

use App\Domain\Exceptions\InvalidNameException;

final class UserName
{
    private function __construct(
        private readonly string $value,
    ) {
    }

    public static function fromString(string $value): self
    {
        $value = trim($value);

        if ($value === '') {
            throw new InvalidNameException('El nombre es obligatorio.');
        }

        if (mb_strlen($value) > 120) {
            throw new InvalidNameException('El nombre es demasiado largo.');
        }

        return new self($value);
    }

    public function value(): string
    {
        return $this->value;
    }
}
