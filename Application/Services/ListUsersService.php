<?php

declare(strict_types=1);

namespace App\Application\Services;

use App\Application\Ports\Out\UserRepositoryPort;
use App\Domain\Models\UserModel;

final class ListUsersService
{
    public function __construct(
        private readonly UserRepositoryPort $users,
    ) {
    }

    /**
     * @return UserModel[]
     */
    public function execute(): array
    {
        return $this->users->listAll();
    }
}
