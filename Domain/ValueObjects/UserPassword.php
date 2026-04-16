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
            throw new InvalidPasswordException('La contraseña es obligatoria.');
        }

        // bcrypt only uses the first 72 bytes
        if (strlen($plain) < 8) {
            throw new InvalidPasswordException('La contraseña debe tener al menos 8 caracteres.');
        }

        if (strlen($plain) > 72) {
            throw new InvalidPasswordException('La contraseña es demasiado larga.');
        }

        $hash = password_hash($plain, PASSWORD_BCRYPT);
        if ($hash === false) {
            throw new InvalidPasswordException('No se pudo generar el hash de la contraseña.');
        }

        return new self($hash);
    }

    public static function fromHash(string $hash): self
    {
        $hash = trim($hash);
        if ($hash === '') {
            throw new InvalidPasswordException('Hash de contraseña inválido.');
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
}
