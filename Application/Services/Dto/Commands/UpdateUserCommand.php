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

    public function getId(): int { return $this->id; }
    public function getName(): string { return $this->name; }
    public function getEmail(): string { return $this->email; }
    public function getPassword(): ?string { return $this->password; }
    public function getRoleId(): int { return $this->roleId; }
    public function getStatus(): string { return $this->status; }
}
