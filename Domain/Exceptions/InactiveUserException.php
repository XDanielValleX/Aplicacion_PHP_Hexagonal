<?php

declare(strict_types=1);

namespace App\Domain\Exceptions;

final class InactiveUserException extends DomainException
{
    public static function becauseUserIsInactive(): self
    {
        return new self('El usuario está inactivo.');
    }
}
