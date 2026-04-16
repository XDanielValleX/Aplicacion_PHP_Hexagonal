<?php

declare(strict_types=1);

namespace App\Application\Services;

use App\Application\Commands\CreateUserCommand;
use App\Application\Ports\Out\UserRepositoryPort;
use App\Domain\Enums\UserStatus;
use App\Domain\Exceptions\UserAlreadyExistsException;
use App\Domain\Models\UserModel;
use App\Domain\ValueObjects\UserEmail;
use App\Domain\ValueObjects\UserName;
use App\Domain\ValueObjects\UserPassword;
use App\Domain\ValueObjects\UserRoleId;

final class CreateUserService
{
    public function __construct(
        private readonly UserRepositoryPort $users,
    ) {
    }

    public function execute(CreateUserCommand $command): UserModel
    {
        $email = UserEmail::fromString($command->email);

        if ($this->users->findByEmail($email) !== null) {
            throw new UserAlreadyExistsException('El email ya está registrado.');
        }

        $user = new UserModel(
            null,
            UserName::fromString($command->name),
            $email,
            UserPassword::fromPlainText($command->password),
            UserRoleId::fromInt($command->roleId),
            UserStatus::ACTIVE,
        );

        return $this->users->save($user);
    }
}
