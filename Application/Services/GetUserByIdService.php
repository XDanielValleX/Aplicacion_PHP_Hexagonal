<?php

declare(strict_types=1);

namespace App\Application\Services;

use App\Application\Ports\Out\UserRepositoryPort;
use App\Domain\Exceptions\UserNotFoundException;
use App\Domain\Models\UserModel;
use App\Domain\ValueObjects\UserId;

final class GetUserByIdService
{
    public function __construct(
        private readonly UserRepositoryPort $users,
    ) {
    }

    public function execute(UserId $id): UserModel
    {
        $user = $this->users->findById($id);
        if ($user === null) {
            throw new UserNotFoundException('Usuario no encontrado.');
        }

        return $user;
    }
}
