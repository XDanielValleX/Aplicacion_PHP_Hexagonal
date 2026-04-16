<?php

declare(strict_types=1);

namespace App\Application\Commands;

final class DeleteUserCommand
{
    public function __construct(
        public readonly int $id,
    ) {
    }
}
