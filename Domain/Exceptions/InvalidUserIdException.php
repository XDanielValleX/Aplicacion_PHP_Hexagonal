<?php

declare(strict_types=1);

namespace App\Domain\Exceptions;

final class InvalidUserIdException extends DomainException
{
    public static function becauseValueIsInvalid(int $value): self
    {
        return new self('Id de usuario inválido.');
    }
}
