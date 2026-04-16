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
            UserName::fromString($command->getName()),
            $email,
            UserPassword::fromPlainText($command->getPassword()),
            UserRoleId::fromInt($command->getRoleId()),
            UserStatus::ACTIVE,
        );
    }

    public static function fromUpdateCommandToModel(
        UpdateUserCommand $command,
        UserEmail $email,
        UserPassword $password,
    ): UserModel {
        return new UserModel(
            UserId::fromInt($command->getId()),
            UserName::fromString($command->getName()),
            $email,
            $password,
            UserRoleId::fromInt($command->getRoleId()),
            UserStatus::fromString($command->getStatus()),
        );
    }

    public static function fromGetUserByIdQueryToUserId(GetUserByIdQuery $query): UserId
    {
        return UserId::fromInt($query->getId());
    }

    public static function fromDeleteCommandToUserId(DeleteUserCommand $command): UserId
    {
        return UserId::fromInt($command->getId());
    }
}
