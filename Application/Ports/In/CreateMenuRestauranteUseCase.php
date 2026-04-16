<?php

declare(strict_types=1);

namespace App\Application\Ports\In;

use App\Application\Services\Dto\Commands\CreateMenuRestauranteCommand;
use App\Domain\Models\MenuRestauranteModel;

interface CreateMenuRestauranteUseCase
{
    public function execute(CreateMenuRestauranteCommand $command): MenuRestauranteModel;
}
