<?php

declare(strict_types=1);

namespace App\Application\Services;

use App\Application\Commands\UpdateMenuRestauranteCommand;
use App\Application\Ports\Out\MenuRestauranteRepositoryPort;
use App\Domain\Exceptions\DomainException;
use App\Domain\Models\MenuRestauranteModel;
use App\Domain\ValueObjects\MenuRestauranteId;

final class UpdateMenuRestauranteService
{
    public function __construct(
        private readonly MenuRestauranteRepositoryPort $menus,
    ) {
    }

    public function execute(UpdateMenuRestauranteCommand $command): MenuRestauranteModel
    {
        $id = MenuRestauranteId::fromInt($command->id);
        $existing = $this->menus->findById($id);
        if ($existing === null) {
            throw new DomainException('Registro no encontrado.');
        }

        $updated = $existing->update(
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

        return $this->menus->update($updated);
    }
}
