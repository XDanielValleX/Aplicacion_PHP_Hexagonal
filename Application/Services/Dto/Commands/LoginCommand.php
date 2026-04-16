<?php

declare(strict_types=1);

namespace App\Application\Services\Dto\Commands;

final class LoginCommand
{
    public function __construct(
        public readonly string $email,
        public readonly string $password,
    ) {
    }
}
