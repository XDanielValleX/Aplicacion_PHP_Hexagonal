<?php

declare(strict_types=1);

namespace App\Application\Ports\In;

use App\Application\Services\Dto\Commands\DeleteMenuRestauranteCommand;

interface DeleteMenuRestauranteUseCase
{
    public function execute(DeleteMenuRestauranteCommand $command): void;
}
