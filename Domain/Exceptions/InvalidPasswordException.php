<?php

declare(strict_types=1);

namespace App\Domain\Exceptions;

final class InvalidPasswordException extends DomainException
{
    public static function becauseValueIsEmpty(): self
    {
        return new self('La contraseña es obligatoria.');
    }

    public static function becauseLengthIsTooShort(int $min): self
    {
        return new self('La contraseña debe tener al menos ' . $min . ' caracteres.');
    }

    public static function becauseValueIsTooLong(int $max): self
    {
        return new self('La contraseña es demasiado larga (máx. ' . $max . ' caracteres).');
    }

    public static function becauseHashCouldNotBeGenerated(): self
    {
        return new self('No se pudo generar el hash de la contraseña.');
    }

    public static function becauseHashIsInvalid(): self
    {
        return new self('Hash de contraseña inválido.');
    }
}
