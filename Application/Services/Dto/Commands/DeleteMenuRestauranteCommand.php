<?php

declare(strict_types=1);

namespace App\Application\Services\Dto\Commands;

final class DeleteMenuRestauranteCommand
{
    public function __construct(
        public readonly int $id,
    ) {
    }
}
