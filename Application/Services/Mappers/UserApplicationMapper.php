<?php

declare(strict_types=1);

namespace App\Application\Services\Mappers;

use App\Application\Services\Dto\Commands\CreateUserCommand;
use App\Application\Services\Dto\Commands\DeleteUserCommand;
use App\Application\Services\Dto\Commands\UpdateUserCommand;
use App\Application\Services\Dto\Queries\GetUserByIdQuery;
use App\Domain\Enums\UserStatus;
use App\Domain\Models\UserModel;
use App\Domain\ValueObjects\UserEmail;
use App\Domain\ValueObjects\UserId;
use App\Domain\ValueObjects\UserName;
use App\Domain\ValueObjects\UserPassword;
use App\Domain\ValueObjects\UserRoleId;

final class UserApplicationMapper
{
    public static function fromCreateCommandToModel(CreateUserCommand $command, UserEmail $email): UserModel
    {
        return new UserModel(
            null,
            UserName::fromString($command->name),
            $email,
            UserPassword::fromPlainText($command->password),
            UserRoleId::fromInt($command->roleId),
            UserStatus::ACTIVE,
        );
    }

    public static function fromUpdateCommandToModel(
        UpdateUserCommand $command,
        UserEmail $email,
        UserPassword $password,
    ): UserModel {
        return new UserModel(
            UserId::fromInt($command->id),
            UserName::fromString($command->name),
            $email,
            $password,
            UserRoleId::fromInt($command->roleId),
            UserStatus::fromString($command->status),
        );
    }

    public static function fromGetUserByIdQueryToUserId(GetUserByIdQuery $query): UserId
    {
        return UserId::fromInt($query->getId());
    }

    public static function fromDeleteCommandToUserId(DeleteUserCommand $command): UserId
    {
        return UserId::fromInt($command->id);
    }
}
