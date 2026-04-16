<?php

declare(strict_types=1);

namespace App\Application\Services;

use App\Application\Ports\In\GetUserByIdUseCase;
use App\Application\Ports\Out\UserRepositoryPort;
use App\Application\Services\Dto\Queries\GetUserByIdQuery;
use App\Application\Services\Mappers\UserApplicationMapper;
use App\Domain\Exceptions\UserNotFoundException;
use App\Domain\Models\UserModel;

final class GetUserByIdService implements GetUserByIdUseCase
{
    public function __construct(
        private readonly UserRepositoryPort $users,
    ) {
    }

    public function execute(GetUserByIdQuery $query): UserModel
    {
        $userId = UserApplicationMapper::fromGetUserByIdQueryToUserId($query);

        $user = $this->users->findById($userId);
        if ($user === null) {
            throw UserNotFoundException::becauseIdWasNotFound();
        }

        return $user;
    }
}
