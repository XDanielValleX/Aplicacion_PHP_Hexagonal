<?php

declare(strict_types=1);

namespace App\Application\Services;

use App\Application\Ports\In\GetAllMenuRestaurantesUseCase;
use App\Application\Ports\Out\MenuRestauranteRepositoryPort;
use App\Application\Services\Dto\Queries\GetAllMenuRestaurantesQuery;
use App\Domain\Models\MenuRestauranteModel;

final class ListMenuRestaurantesService implements GetAllMenuRestaurantesUseCase
{
    public function __construct(
        private readonly MenuRestauranteRepositoryPort $menus,
    ) {
    }

    /**
     * @return MenuRestauranteModel[]
     */
    public function execute(GetAllMenuRestaurantesQuery $query): array
    {
        return $this->menus->listAll();
    }
}
