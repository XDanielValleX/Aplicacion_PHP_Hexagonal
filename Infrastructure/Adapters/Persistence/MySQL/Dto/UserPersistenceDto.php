<?php

declare(strict_types=1);

namespace App\Infrastructure\Adapters\Persistence\MySQL\Dto;

final class UserPersistenceDto
{
    public function __construct(
        public readonly string $name,
        public readonly string $email,
        public readonly string $passwordHash,
        public readonly int $roleId,
        public readonly string $status,
    ) {
    }

    /**
     * @return array{name:string,email:string,password_hash:string,role_id:int,status:string}
     */
    public function toRow(): array
    {
        return [
            'name' => $this->name,
            'email' => $this->email,
            'password_hash' => $this->passwordHash,
            'role_id' => $this->roleId,
            'status' => $this->status,
        ];
    }
}
