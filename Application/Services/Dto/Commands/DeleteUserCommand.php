<?php

declare(strict_types=1);

namespace App\Application\Services\Dto\Commands;

final class DeleteUserCommand
{
    public function __construct(
        public readonly int $id,
    ) {
    }

    public function getId(): int
    {
        return $this->id;
    }
}
