<?php

declare(strict_types=1);

namespace App\Application\Services;

use App\Application\Commands\UpdateUserCommand;
use App\Application\Ports\Out\UserRepositoryPort;
use App\Domain\Enums\UserStatus;
use App\Domain\Exceptions\UserAlreadyExistsException;
use App\Domain\Exceptions\UserNotFoundException;
use App\Domain\Models\UserModel;
use App\Domain\ValueObjects\UserEmail;
use App\Domain\ValueObjects\UserId;
use App\Domain\ValueObjects\UserName;
use App\Domain\ValueObjects\UserPassword;
use App\Domain\ValueObjects\UserRoleId;

final class UpdateUserService
{
    public function __construct(
        private readonly UserRepositoryPort $users,
    ) {
    }

    public function execute(UpdateUserCommand $command): UserModel
    {
        $id = UserId::fromInt($command->id);

        $existing = $this->users->findById($id);
        if ($existing === null) {
            throw new UserNotFoundException('Usuario no encontrado.');
        }

        $email = UserEmail::fromString($command->email);

        $existingByEmail = $this->users->findByEmail($email);
        if ($existingByEmail !== null && $existingByEmail->id() !== null && !$existingByEmail->id()->equals($id)) {
            throw new UserAlreadyExistsException('El email ya está registrado.');
        }

        $password = null;
        if ($command->password !== null && trim($command->password) !== '') {
            $password = UserPassword::fromPlainText($command->password);
        }

        $updated = $existing->updateProfile(
            UserName::fromString($command->name),
            $email,
            UserRoleId::fromInt($command->roleId),
            UserStatus::fromString($command->status),
            $password,
        );

        return $this->users->update($updated);
    }
}
