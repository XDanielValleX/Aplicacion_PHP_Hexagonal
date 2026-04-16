<?php

declare(strict_types=1);

namespace App\Infrastructure\Entrypoints\Web\Controllers\Dto;

final class UpdateUserRequest
{
    public function __construct(
        public readonly int $id,
        public readonly string $name,
        public readonly string $email,
        public readonly ?string $password,
        public readonly int $roleId,
        public readonly string $status,
    ) {
    }

    /**
     * @param array<string, mixed> $data
     */
    public static function fromArray(array $data): self
    {
        $password = isset($data['password']) ? (string) $data['password'] : null;

        return new self(
            (int) ($data['id'] ?? 0),
            (string) ($data['name'] ?? ''),
            (string) ($data['email'] ?? ''),
            $password,
            (int) ($data['role_id'] ?? 1),
            (string) ($data['status'] ?? 'ACTIVE'),
        );
    }
}
