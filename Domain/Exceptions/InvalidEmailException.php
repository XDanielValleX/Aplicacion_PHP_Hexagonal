<?php

declare(strict_types=1);

namespace App\Domain\Exceptions;

final class InvalidEmailException extends DomainException
{
    public static function becauseValueIsEmpty(): self
    {
        return new self('El email del usuario no puede estar vacío.');
    }

    public static function becauseFormatIsInvalid(string $email): self
    {
        return new self('El formato del email es inválido.');
    }

    public static function becauseValueIsTooLong(int $max): self
    {
        return new self('El email es demasiado largo (máx. ' . $max . ' caracteres).');
    }
}
