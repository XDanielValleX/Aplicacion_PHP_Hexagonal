<?php

declare(strict_types=1);

namespace App\Domain\Events;

use App\Domain\Models\UserModel;

final class UserCreatedDomainEvent extends DomainEvent
{
    public function __construct(
        private readonly UserModel $user,
    ) {
        parent::__construct('user.created');
    }

    public function user(): UserModel
    {
        return $this->user;
    }

    public function payload(): array
    {
        return [
            'id' => $this->user->id()?->value(),
            'name' => $this->user->name()->value(),
            'email' => $this->user->email()->value(),
            'roleId' => $this->user->roleId()->value(),
            'status' => $this->user->status()->value,
        ];
    }
}
