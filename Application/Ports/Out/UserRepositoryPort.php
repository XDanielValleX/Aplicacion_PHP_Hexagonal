<?php

declare(strict_types=1);

namespace App\Application\Ports\Out;

use App\Domain\Models\UserModel;
use App\Domain\ValueObjects\UserEmail;
use App\Domain\ValueObjects\UserId;

interface UserRepositoryPort
{
    public function save(UserModel $user): UserModel;

    public function findById(UserId $id): ?UserModel;

    public function findByEmail(UserEmail $email): ?UserModel;

    /**
     * @return UserModel[]
     */
    public function listAll(): array;

    public function update(UserModel $user): UserModel;

    public function delete(UserId $id): void;
}
