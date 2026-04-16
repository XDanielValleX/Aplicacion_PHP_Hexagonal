<?php

declare(strict_types=1);

namespace App\Application\Ports\In;

use App\Application\Services\Dto\Queries\GetAllMenuRestaurantesQuery;
use App\Domain\Models\MenuRestauranteModel;

interface GetAllMenuRestaurantesUseCase
{
    /**
     * @return MenuRestauranteModel[]
     */
    public function execute(GetAllMenuRestaurantesQuery $query): array;
}
