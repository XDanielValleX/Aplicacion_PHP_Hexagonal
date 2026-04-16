<?php

declare(strict_types=1);

namespace App\Domain\Exceptions;

final class InvalidCredentialsException extends DomainException
{
    public static function becauseCredentialsAreInvalid(): self
    {
        return new self('Credenciales inválidas.');
    }
}
