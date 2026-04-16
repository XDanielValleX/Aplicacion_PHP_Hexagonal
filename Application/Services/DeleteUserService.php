<?php

declare(strict_types=1);

namespace App\Application\Services;

use App\Application\Ports\In\DeleteUserUseCase;
use App\Application\Ports\Out\UserRepositoryPort;
use App\Application\Services\Dto\Commands\DeleteUserCommand;
use App\Application\Services\Mappers\UserApplicationMapper;
use App\Domain\Exceptions\UserNotFoundException;

final class DeleteUserService implements DeleteUserUseCase
{
    public function __construct(
        private readonly UserRepositoryPort $users,
    ) {
    }

    public function execute(DeleteUserCommand $command): void
    {
        $userId = UserApplicationMapper::fromDeleteCommandToUserId($command);

        $existingUser = $this->users->findById($userId);
        if ($existingUser === null) {
            throw UserNotFoundException::becauseIdWasNotFound();
        }

        $this->users->delete($userId);
    }
}
