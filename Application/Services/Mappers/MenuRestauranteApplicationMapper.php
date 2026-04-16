<?php

declare(strict_types=1);

namespace App\Application\Services\Mappers;

use App\Application\Services\Dto\Commands\CreateMenuRestauranteCommand;
use App\Application\Services\Dto\Commands\DeleteMenuRestauranteCommand;
use App\Application\Services\Dto\Commands\UpdateMenuRestauranteCommand;
use App\Application\Services\Dto\Queries\GetMenuRestauranteByIdQuery;
use App\Domain\Models\MenuRestauranteModel;
use App\Domain\ValueObjects\MenuRestauranteId;

final class MenuRestauranteApplicationMapper
{
    public static function fromCreateCommandToModel(CreateMenuRestauranteCommand $command): MenuRestauranteModel
    {
        return new MenuRestauranteModel(
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
    }

    public static function fromUpdateCommandToMenuId(UpdateMenuRestauranteCommand $command): MenuRestauranteId
    {
        return MenuRestauranteId::fromInt($command->id);
    }

    public static function fromUpdateCommandToUpdatedModel(UpdateMenuRestauranteCommand $command, MenuRestauranteModel $existing): MenuRestauranteModel
    {
        return $existing->update(
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
    }

    public static function fromGetMenuRestauranteByIdQueryToMenuId(GetMenuRestauranteByIdQuery $query): MenuRestauranteId
    {
        return MenuRestauranteId::fromInt($query->getId());
    }

    public static function fromDeleteCommandToMenuId(DeleteMenuRestauranteCommand $command): MenuRestauranteId
    {
        return MenuRestauranteId::fromInt($command->id);
    }
}
