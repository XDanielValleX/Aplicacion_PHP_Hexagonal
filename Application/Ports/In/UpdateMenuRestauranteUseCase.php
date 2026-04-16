<?php

declare(strict_types=1);

namespace App\Application\Ports\In;

use App\Application\Services\Dto\Commands\UpdateMenuRestauranteCommand;
use App\Domain\Models\MenuRestauranteModel;

interface UpdateMenuRestauranteUseCase
{
    public function execute(UpdateMenuRestauranteCommand $command): MenuRestauranteModel;
}
