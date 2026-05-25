<?php

declare(strict_types=1);

namespace App\Domain\Exceptions;

final class UserNotFoundException extends DomainException
{
    public static function becauseIdWasNotFound(): self
    {
        return new self('Usuario no encontrado.');
    }
}
