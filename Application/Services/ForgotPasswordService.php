<?php

declare(strict_types=1);

namespace App\Application\Services;

use App\Application\Commands\ForgotPasswordCommand;
use App\Application\Ports\Out\UserRepositoryPort;
use App\Domain\Models\UserModel;
use App\Domain\ValueObjects\UserEmail;
use App\Domain\ValueObjects\UserPassword;

final class ForgotPasswordService
{
    public function __construct(
        private readonly UserRepositoryPort $users,
    ) {
    }

    /**
     * @return array{user: UserModel, tempPassword: string}|null
     */
    public function execute(ForgotPasswordCommand $command): ?array
    {
        $email = UserEmail::fromString($command->email);
        $user = $this->users->findByEmail($email);

        if ($user === null) {
            return null;
        }

        $tempPassword = bin2hex(random_bytes(5));

        $updated = $user->updateProfile(
            $user->name(),
            $user->email(),
            $user->roleId(),
            $user->status(),
            UserPassword::fromPlainText($tempPassword),
        );

        $saved = $this->users->update($updated);

        return [
            'user' => $saved,
            'tempPassword' => $tempPassword,
        ];
    }
}
