<?php

declare(strict_types=1);

namespace App\Application\Services;

use App\Application\Ports\Out\MenuRestauranteRepositoryPort;
use App\Domain\Exceptions\DomainException;
use App\Domain\Models\MenuRestauranteModel;
use App\Domain\ValueObjects\MenuRestauranteId;

final class GetMenuRestauranteByIdService
{
    public function __construct(
        private readonly MenuRestauranteRepositoryPort $menus,
    ) {
    }

    public function execute(MenuRestauranteId $id): MenuRestauranteModel
    {
        $menu = $this->menus->findById($id);
        if ($menu === null) {
            throw new DomainException('Registro no encontrado.');
        }

        return $menu;
    }
}
