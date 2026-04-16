<?php

declare(strict_types=1);

namespace App\Application\Services;

use App\Application\Commands\DeleteMenuRestauranteCommand;
use App\Application\Ports\Out\MenuRestauranteRepositoryPort;
use App\Domain\ValueObjects\MenuRestauranteId;

final class DeleteMenuRestauranteService
{
    public function __construct(
        private readonly MenuRestauranteRepositoryPort $menus,
    ) {
    }

    public function execute(DeleteMenuRestauranteCommand $command): void
    {
        $this->menus->delete(MenuRestauranteId::fromInt($command->id));
    }
}
