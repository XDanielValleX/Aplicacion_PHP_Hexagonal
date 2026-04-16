<?php

declare(strict_types=1);

namespace App\Application\Services\Dto\Commands;

final class ForgotPasswordCommand
{
    public function __construct(
        public readonly string $email,
    ) {
    }
}
