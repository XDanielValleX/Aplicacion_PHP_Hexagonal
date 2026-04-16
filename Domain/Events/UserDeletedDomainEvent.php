<?php

declare(strict_types=1);

namespace App\Domain\Events;

use App\Domain\ValueObjects\UserId;

final class UserDeletedDomainEvent extends DomainEvent
{
    public function __construct(
        private readonly UserId $userId,
    ) {
        parent::__construct('user.deleted');
    }

    public function userId(): UserId
    {
        return $this->userId;
    }

    public function payload(): array
    {
        return [
            'id' => $this->userId->value(),
        ];
    }
}
