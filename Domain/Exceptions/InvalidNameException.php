<?php

declare(strict_types=1);

namespace App\Domain\Exceptions;

final class InvalidNameException extends DomainException
{
    public static function becauseValueIsEmpty(): self
    {
        return new self('El nombre es obligatorio.');
    }

    public static function becauseLengthIsTooShort(int $min): self
    {
        return new self('El nombre debe tener al menos ' . $min . ' caracteres.');
    }

    public static function becauseValueIsTooLong(int $max): self
    {
        return new self('El nombre es demasiado largo (máx. ' . $max . ' caracteres).');
    }
}
