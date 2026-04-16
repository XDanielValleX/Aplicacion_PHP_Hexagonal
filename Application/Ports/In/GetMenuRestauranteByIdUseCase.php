<?php

declare(strict_types=1);

namespace App\Application\Ports\In;

use App\Application\Services\Dto\Queries\GetMenuRestauranteByIdQuery;
use App\Domain\Models\MenuRestauranteModel;

interface GetMenuRestauranteByIdUseCase
{
    public function execute(GetMenuRestauranteByIdQuery $query): MenuRestauranteModel;
}
