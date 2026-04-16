<?php

declare(strict_types=1);

namespace App\Application\Services;

use App\Application\Ports\In\CreateUserUseCase;
use App\Application\Ports\Out\UserRepositoryPort;
use App\Application\Services\Dto\Commands\CreateUserCommand;
use App\Application\Services\Mappers\UserApplicationMapper;
use App\Domain\Exceptions\UserAlreadyExistsException;
use App\Domain\Models\UserModel;
use App\Domain\ValueObjects\UserEmail;

final class CreateUserService implements CreateUserUseCase
{
    public function __construct(
        private readonly UserRepositoryPort $users,
    ) {
    }

    public function execute(CreateUserCommand $command): UserModel
    {
        $email = UserEmail::fromString($command->email);

        if ($this->users->findByEmail($email) !== null) {
            throw UserAlreadyExistsException::becauseEmailAlreadyExists();
        }

        $user = UserApplicationMapper::fromCreateCommandToModel($command, $email);

        return $this->users->save($user);
    }
}
