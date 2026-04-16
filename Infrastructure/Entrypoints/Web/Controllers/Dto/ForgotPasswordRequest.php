<?php

declare(strict_types=1);

namespace App\Infrastructure\Entrypoints\Web\Controllers\Dto;

final class ForgotPasswordRequest
{
    public function __construct(
        public readonly string $email,
    ) {
    }

    /**
     * @param array<string, mixed> $data
     */
    public static function fromArray(array $data): self
    {
        return new self(
            (string) ($data['email'] ?? ''),
        );
    }
}
