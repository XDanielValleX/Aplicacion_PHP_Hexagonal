<?php

declare(strict_types=1);

namespace App\Domain\ValueObjects;

use App\Domain\Exceptions\InvalidPasswordException;

final class UserPassword
{
    private function __construct(
        private readonly string $hash,
    ) {
    }

    public static function fromPlainText(string $plain): self
    {
        if ($plain === '') {
            throw InvalidPasswordException::becauseValueIsEmpty();
        }

        // bcrypt only uses the first 72 bytes
        if (strlen($plain) < 8) {
            throw InvalidPasswordException::becauseLengthIsTooShort(8);
        }

        if (strlen($plain) > 72) {
            throw InvalidPasswordException::becauseValueIsTooLong(72);
        }

        $hash = password_hash($plain, PASSWORD_BCRYPT);
        if ($hash === false) {
            throw InvalidPasswordException::becauseHashCouldNotBeGenerated();
        }

        return new self($hash);
    }

    public static function fromHash(string $hash): self
    {
        $hash = trim($hash);
        if ($hash === '') {
            throw InvalidPasswordException::becauseHashIsInvalid();
        }

        return new self($hash);
    }

    public function verifyPlain(string $plain): bool
    {
        return password_verify($plain, $this->hash);
    }

    public function hash(): string
    {
        return $this->hash;
    }

    public function equals(self $other): bool
    {
        return hash_equals($this->hash, $other->hash);
    }
}
