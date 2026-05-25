<?php

declare(strict_types=1);

namespace App\Domain\Models;

use App\Domain\Enums\UserStatus;
use App\Domain\ValueObjects\UserEmail;
use App\Domain\ValueObjects\UserId;
use App\Domain\ValueObjects\UserName;
use App\Domain\ValueObjects\UserPassword;
use App\Domain\ValueObjects\UserRoleId;

final class UserModel
{
    public function __construct(
        private readonly ?UserId $id,
        private readonly UserName $name,
        private readonly UserEmail $email,
        private readonly UserPassword $password,
        private readonly UserRoleId $roleId,
        private readonly UserStatus $status,
    ) {
    }

    public function id(): ?UserId
    {
        return $this->id;
    }

    public function name(): UserName
    {
        return $this->name;
    }

    public function email(): UserEmail
    {
        return $this->email;
    }

    public function password(): UserPassword
    {
        return $this->password;
    }

    public function roleId(): UserRoleId
    {
        return $this->roleId;
    }

    public function status(): UserStatus
    {
        return $this->status;
    }

    public function withId(UserId $id): self
    {
        return new self($id, $this->name, $this->email, $this->password, $this->roleId, $this->status);
    }

    public function updateProfile(
        UserName $name,
        UserEmail $email,
        UserRoleId $roleId,
        UserStatus $status,
        ?UserPassword $password = null,
    ): self {
        return new self(
            $this->id,
            $name,
            $email,
            $password ?? $this->password,
            $roleId,
            $status,
        );
    }
}
