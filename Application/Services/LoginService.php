<?php

declare(strict_types=1);

namespace App\Application\Services;

use App\Application\Ports\In\LoginUseCase;
use App\Application\Ports\Out\UserRepositoryPort;
use App\Application\Services\Dto\Commands\LoginCommand;
use App\Domain\Enums\UserStatus;
use App\Domain\Exceptions\InactiveUserException;
use App\Domain\Exceptions\InvalidCredentialsException;
use App\Domain\Models\UserModel;
use App\Domain\ValueObjects\UserEmail;

final class LoginService implements LoginUseCase
{
    public function __construct(
        private readonly UserRepositoryPort $users,
    ) {
    }

    public function execute(LoginCommand $command): UserModel
    {
        $email = UserEmail::fromString($command->email);
        $user = $this->users->findByEmail($email);

        // Same message for both cases (avoid user enumeration)
        if ($user === null || !$user->password()->verifyPlain($command->password)) {
            throw new InvalidCredentialsException('Credenciales inválidas.');
        }

        if ($user->status() !== UserStatus::ACTIVE) {
            throw new InactiveUserException('El usuario está inactivo.');
        }

        return $user;
    }
}
