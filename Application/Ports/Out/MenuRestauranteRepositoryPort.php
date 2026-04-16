<?php

declare(strict_types=1);

namespace App\Application\Ports\Out;

use App\Domain\Models\MenuRestauranteModel;
use App\Domain\ValueObjects\MenuRestauranteId;

interface MenuRestauranteRepositoryPort
{
    public function save(MenuRestauranteModel $menu): MenuRestauranteModel;

    public function findById(MenuRestauranteId $id): ?MenuRestauranteModel;

    /**
     * @return MenuRestauranteModel[]
     */
    public function listAll(): array;

    public function update(MenuRestauranteModel $menu): MenuRestauranteModel;

    public function delete(MenuRestauranteId $id): void;
}
