<?php

declare(strict_types=1);

namespace App\Application\Commands;

final class ForgotPasswordCommand
{
    public function __construct(
        public readonly string $email,
    ) {
    }
}
