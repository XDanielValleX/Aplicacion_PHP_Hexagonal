<?php

declare(strict_types=1);

namespace App\Application\Services;

use App\Application\Ports\In\UpdateUserUseCase;
use App\Application\Ports\Out\UserRepositoryPort;
use App\Application\Services\Dto\Commands\UpdateUserCommand;
use App\Application\Services\Mappers\UserApplicationMapper;
use App\Domain\Exceptions\UserAlreadyExistsException;
use App\Domain\Exceptions\UserNotFoundException;
use App\Domain\Models\UserModel;
use App\Domain\ValueObjects\UserEmail;
use App\Domain\ValueObjects\UserId;
use App\Domain\ValueObjects\UserPassword;

final class UpdateUserService implements UpdateUserUseCase
{
    public function __construct(
        private readonly UserRepositoryPort $users,
    ) {
    }

    public function execute(UpdateUserCommand $command): UserModel
    {
        $userId = UserId::fromInt($command->getId());

        $currentUser = $this->users->findById($userId);
        if ($currentUser === null) {
            throw UserNotFoundException::becauseIdWasNotFound();
        }

        $newEmail = UserEmail::fromString($command->getEmail());

        $userWithSameEmail = $this->users->findByEmail($newEmail);
        if ($userWithSameEmail !== null && $userWithSameEmail->id() !== null && !$userWithSameEmail->id()->equals($userId)) {
            throw UserAlreadyExistsException::becauseEmailAlreadyExists();
        }

        $passwordValue = $command->getPassword();
        $password = ($passwordValue !== null && trim($passwordValue) !== '')
            ? UserPassword::fromPlainText($passwordValue)
            : $currentUser->password();

        $userToUpdate = UserApplicationMapper::fromUpdateCommandToModel($command, $newEmail, $password);

        return $this->users->update($userToUpdate);
    }
}
