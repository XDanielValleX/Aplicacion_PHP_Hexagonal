<?php

declare(strict_types=1);

namespace App\Domain\Exceptions;

final class UserAlreadyExistsException extends DomainException
{
    public static function becauseEmailAlreadyExists(): self
    {
        return new self('Ya existe un usuario con ese email.');
    }
}
