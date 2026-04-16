<?php

declare(strict_types=1);

namespace App\Application\Services;

use App\Application\Ports\In\UpdateMenuRestauranteUseCase;
use App\Application\Ports\Out\MenuRestauranteRepositoryPort;
use App\Application\Services\Dto\Commands\UpdateMenuRestauranteCommand;
use App\Application\Services\Mappers\MenuRestauranteApplicationMapper;
use App\Domain\Exceptions\DomainException;
use App\Domain\Models\MenuRestauranteModel;

final class UpdateMenuRestauranteService implements UpdateMenuRestauranteUseCase
{
    public function __construct(
        private readonly MenuRestauranteRepositoryPort $menus,
    ) {
    }

    public function execute(UpdateMenuRestauranteCommand $command): MenuRestauranteModel
    {
        $id = MenuRestauranteApplicationMapper::fromUpdateCommandToMenuId($command);

        $existing = $this->menus->findById($id);
        if ($existing === null) {
            throw new DomainException('Registro no encontrado.');
        }

        $updated = MenuRestauranteApplicationMapper::fromUpdateCommandToUpdatedModel($command, $existing);

        return $this->menus->update($updated);
    }
}
