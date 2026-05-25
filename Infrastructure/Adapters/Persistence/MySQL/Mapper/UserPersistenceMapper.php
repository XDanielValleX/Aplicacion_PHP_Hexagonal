<?php

declare(strict_types=1);

namespace App\Infrastructure\Adapters\Persistence\MySQL\Mapper;

use App\Domain\Enums\UserStatus;
use App\Domain\Models\UserModel;
use App\Domain\ValueObjects\UserEmail;
use App\Domain\ValueObjects\UserId;
use App\Domain\ValueObjects\UserName;
use App\Domain\ValueObjects\UserPassword;
use App\Domain\ValueObjects\UserRoleId;
use App\Infrastructure\Adapters\Persistence\MySQL\Dto\UserPersistenceDto;
use App\Infrastructure\Adapters\Persistence\MySQL\Entity\UserEntity;

final class UserPersistenceMapper
{
    /**
     * @param array{
     *   id:mixed,
     *   name:mixed,
     *   email:mixed,
     *   password_hash:mixed,
     *   role_id:mixed,
     *   status:mixed,
     *   created_at:mixed,
     *   updated_at:mixed
     * } $row
     */
    public static function toEntity(array $row): UserEntity
    {
        return new UserEntity(
            (int) $row['id'],
            (string) $row['name'],
            (string) $row['email'],
            (string) $row['password_hash'],
            (int) $row['role_id'],
            (string) $row['status'],
            (string) $row['created_at'],
            (string) $row['updated_at'],
        );
    }

    public static function toModel(UserEntity $entity): UserModel
    {
        return new UserModel(
            UserId::fromInt($entity->id),
            UserName::fromString($entity->name),
            UserEmail::fromString($entity->email),
            UserPassword::fromHash($entity->passwordHash),
            UserRoleId::fromInt($entity->roleId),
            UserStatus::fromString($entity->status),
        );
    }

    public static function toDto(UserModel $user): UserPersistenceDto
    {
        return new UserPersistenceDto(
            $user->name()->value(),
            $user->email()->value(),
            $user->password()->hash(),
            $user->roleId()->value(),
            $user->status()->value,
        );
    }
}
