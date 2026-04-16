<?php

declare(strict_types=1);

namespace App\Application\Services;

use App\Application\Commands\CreateMenuRestauranteCommand;
use App\Application\Ports\Out\MenuRestauranteRepositoryPort;
use App\Domain\Models\MenuRestauranteModel;

final class CreateMenuRestauranteService
{
    public function __construct(
        private readonly MenuRestauranteRepositoryPort $menus,
    ) {
    }

    public function execute(CreateMenuRestauranteCommand $command): MenuRestauranteModel
    {
        $menu = new MenuRestauranteModel(
            null,
            $command->nombrePlato,
            $command->restaurante,
            $command->precio,
            $command->cantidad,
            $command->duracion,
            $command->descripcion,
            $command->cliente,
            $command->mesero,
            $command->mesa,
            $command->comentarios,
            $command->evaluacion,
        );

        return $this->menus->save($menu);
    }
}
