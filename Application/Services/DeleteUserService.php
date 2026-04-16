<?php

declare(strict_types=1);

namespace App\Application\Services;

use App\Application\Commands\DeleteUserCommand;
use App\Application\Ports\Out\UserRepositoryPort;
use App\Domain\ValueObjects\UserId;

final class DeleteUserService
{
    public function __construct(
        private readonly UserRepositoryPort $users,
    ) {
    }

    public function execute(DeleteUserCommand $command): void
    {
        $this->users->delete(UserId::fromInt($command->id));
    }
}
