<?php

declare(strict_types=1);

namespace App\Application\Services;

use App\Application\Ports\In\DeleteMenuRestauranteUseCase;
use App\Application\Ports\Out\MenuRestauranteRepositoryPort;
use App\Application\Services\Dto\Commands\DeleteMenuRestauranteCommand;
use App\Application\Services\Mappers\MenuRestauranteApplicationMapper;
use App\Domain\Exceptions\DomainException;

final class DeleteMenuRestauranteService implements DeleteMenuRestauranteUseCase
{
    public function __construct(
        private readonly MenuRestauranteRepositoryPort $menus,
    ) {
    }

    public function execute(DeleteMenuRestauranteCommand $command): void
    {
        $menuId = MenuRestauranteApplicationMapper::fromDeleteCommandToMenuId($command);

        $existing = $this->menus->findById($menuId);
        if ($existing === null) {
            throw new DomainException('Registro no encontrado.');
        }

        $this->menus->delete($menuId);
    }
}
