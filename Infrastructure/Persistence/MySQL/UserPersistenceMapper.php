<?php

declare(strict_types=1);

namespace App\Infrastructure\Persistence\MySQL;

use App\Domain\Enums\UserStatus;
use App\Domain\Models\UserModel;
use App\Domain\ValueObjects\UserEmail;
use App\Domain\ValueObjects\UserId;
use App\Domain\ValueObjects\UserName;
use App\Domain\ValueObjects\UserPassword;
use App\Domain\ValueObjects\UserRoleId;

final class UserPersistenceMapper
{
    /**
     * @param array{id:mixed,name:mixed,email:mixed,password_hash:mixed,role_id:mixed,status:mixed} $row
     */
    public static function toModel(array $row): UserModel
    {
        return new UserModel(
            UserId::fromInt((int) $row['id']),
            UserName::fromString((string) $row['name']),
            UserEmail::fromString((string) $row['email']),
            UserPassword::fromHash((string) $row['password_hash']),
            UserRoleId::fromInt((int) $row['role_id']),
            UserStatus::fromString((string) $row['status']),
        );
    }

    /**
     * @return array{name:string,email:string,password_hash:string,role_id:int,status:string}
     */
    public static function toRow(UserModel $user): array
    {
        return [
            'name' => $user->name()->value(),
            'email' => $user->email()->value(),
            'password_hash' => $user->password()->hash(),
            'role_id' => $user->roleId()->value(),
            'status' => $user->status()->value,
        ];
    }
}
