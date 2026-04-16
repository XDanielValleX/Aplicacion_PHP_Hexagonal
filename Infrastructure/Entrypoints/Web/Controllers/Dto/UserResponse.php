<?php

declare(strict_types=1);

namespace App\Infrastructure\Entrypoints\Web\Controllers\Dto;

final class UserResponse
{
    public function __construct(
        public readonly int $id,
        public readonly string $name,
        public readonly string $email,
        public readonly int $roleId,
        public readonly string $status,
    ) {
    }
}
