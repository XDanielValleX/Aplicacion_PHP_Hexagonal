<?php

declare(strict_types=1);

namespace App\Application\Services\Dto\Commands;

final class UpdateUserCommand
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
}
