<?php

declare(strict_types=1);

namespace App\Application\Services;

use App\Application\Ports\In\GetMenuRestauranteByIdUseCase;
use App\Application\Ports\Out\MenuRestauranteRepositoryPort;
use App\Application\Services\Dto\Queries\GetMenuRestauranteByIdQuery;
use App\Application\Services\Mappers\MenuRestauranteApplicationMapper;
use App\Domain\Exceptions\DomainException;
use App\Domain\Models\MenuRestauranteModel;

final class GetMenuRestauranteByIdService implements GetMenuRestauranteByIdUseCase
{
    public function __construct(
        private readonly MenuRestauranteRepositoryPort $menus,
    ) {
    }

    public function execute(GetMenuRestauranteByIdQuery $query): MenuRestauranteModel
    {
        $id = MenuRestauranteApplicationMapper::fromGetMenuRestauranteByIdQueryToMenuId($query);

        $menu = $this->menus->findById($id);
        if ($menu === null) {
            throw new DomainException('Registro no encontrado.');
        }

        return $menu;
    }
}
