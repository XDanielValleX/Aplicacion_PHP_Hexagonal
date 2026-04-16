<?php

declare(strict_types=1);

namespace App\Application\Services;

use App\Application\Ports\Out\MenuRestauranteRepositoryPort;
use App\Domain\Models\MenuRestauranteModel;

final class ListMenuRestaurantesService
{
    public function __construct(
        private readonly MenuRestauranteRepositoryPort $menus,
    ) {
    }

    /**
     * @return MenuRestauranteModel[]
     */
    public function execute(): array
    {
        return $this->menus->listAll();
    }
}
