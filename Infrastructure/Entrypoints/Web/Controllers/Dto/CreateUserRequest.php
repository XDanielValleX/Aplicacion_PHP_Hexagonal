<?php

declare(strict_types=1);

namespace App\Infrastructure\Entrypoints\Web\Controllers\Dto;

final class CreateUserRequest
{
    public function __construct(
        public readonly string $name,
        public readonly string $email,
        public readonly string $password,
        public readonly int $roleId,
    ) {
    }

    /**
     * @param array<string, mixed> $data
     */
    public static function fromArray(array $data): self
    {
        return new self(
            (string) ($data['name'] ?? ''),
            (string) ($data['email'] ?? ''),
            (string) ($data['password'] ?? ''),
            (int) ($data['role_id'] ?? 1),
        );
    }
}
