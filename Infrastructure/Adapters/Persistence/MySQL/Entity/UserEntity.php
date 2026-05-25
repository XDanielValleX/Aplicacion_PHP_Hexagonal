<?php

declare(strict_types=1);

namespace App\Infrastructure\Adapters\Persistence\MySQL\Entity;

final class UserEntity
{
    public function __construct(
        public readonly int $id,
        public readonly string $name,
        public readonly string $email,
        public readonly string $passwordHash,
        public readonly int $roleId,
        public readonly string $status,
        public readonly string $createdAt,
        public readonly string $updatedAt,
    ) {
    }
}
