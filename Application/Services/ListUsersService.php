<?php

declare(strict_types=1);

namespace App\Application\Services;

use App\Application\Ports\In\GetAllUsersUseCase;
use App\Application\Ports\Out\UserRepositoryPort;
use App\Application\Services\Dto\Queries\GetAllUsersQuery;
use App\Domain\Models\UserModel;

final class ListUsersService implements GetAllUsersUseCase
{
    public function __construct(
        private readonly UserRepositoryPort $users,
    ) {
    }

    /**
     * @return UserModel[]
     */
    public function execute(GetAllUsersQuery $query): array
    {
        return $this->users->listAll();
    }
}
