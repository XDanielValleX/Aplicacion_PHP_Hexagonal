<?php

declare(strict_types=1);

namespace App\Application\Services;

use App\Application\Ports\In\CreateMenuRestauranteUseCase;
use App\Application\Ports\Out\MenuRestauranteRepositoryPort;
use App\Application\Services\Dto\Commands\CreateMenuRestauranteCommand;
use App\Application\Services\Mappers\MenuRestauranteApplicationMapper;
use App\Domain\Models\MenuRestauranteModel;

final class CreateMenuRestauranteService implements CreateMenuRestauranteUseCase
{
    public function __construct(
        private readonly MenuRestauranteRepositoryPort $menus,
    ) {
    }

    public function execute(CreateMenuRestauranteCommand $command): MenuRestauranteModel
    {
        $menu = MenuRestauranteApplicationMapper::fromCreateCommandToModel($command);

        return $this->menus->save($menu);
    }
}
