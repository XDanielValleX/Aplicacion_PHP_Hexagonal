<?php

declare(strict_types=1);

namespace App\Domain\ValueObjects;

use App\Domain\Exceptions\InvalidEmailException;

final class UserEmail
{
    private function __construct(
        private readonly string $value,
    ) {
    }

    public static function fromString(string $value): self
    {
        $value = strtolower(trim($value));

        if ($value === '') {
            throw InvalidEmailException::becauseValueIsEmpty();
        }

        if (!filter_var($value, FILTER_VALIDATE_EMAIL)) {
            throw InvalidEmailException::becauseFormatIsInvalid($value);
        }

        if (strlen($value) > 190) {
            throw InvalidEmailException::becauseValueIsTooLong(190);
        }

        return new self($value);
    }

    public function value(): string
    {
        return $this->value;
    }

    public function equals(self $other): bool
    {
        return $this->value === $other->value;
    }

    public function __toString(): string
    {
        return $this->value;
    }
}
