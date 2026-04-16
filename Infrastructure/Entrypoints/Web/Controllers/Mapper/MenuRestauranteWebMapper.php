<?php

declare(strict_types=1);

namespace App\Infrastructure\Entrypoints\Web\Controllers\Mapper;

use App\Application\Services\Dto\Commands\CreateMenuRestauranteCommand;
use App\Application\Services\Dto\Commands\DeleteMenuRestauranteCommand;
use App\Application\Services\Dto\Commands\UpdateMenuRestauranteCommand;
use App\Domain\Models\MenuRestauranteModel;
use App\Infrastructure\Entrypoints\Web\Controllers\Dto\CreateMenuRestauranteRequest;
use App\Infrastructure\Entrypoints\Web\Controllers\Dto\MenuRestauranteResponse;
use App\Infrastructure\Entrypoints\Web\Controllers\Dto\UpdateMenuRestauranteRequest;

final class MenuRestauranteWebMapper
{
    public function toCreateCommand(CreateMenuRestauranteRequest $request): CreateMenuRestauranteCommand
    {
        return new CreateMenuRestauranteCommand(
            $request->nombrePlato,
            $request->restaurante,
            $request->precio,
            $request->cantidad,
            $request->duracion,
            $request->descripcion,
            $request->cliente,
            $request->mesero,
            $request->mesa,
            $request->comentarios,
            $request->evaluacion,
        );
    }

    public function toUpdateCommand(UpdateMenuRestauranteRequest $request): UpdateMenuRestauranteCommand
    {
        return new UpdateMenuRestauranteCommand(
            $request->id,
            $request->nombrePlato,
            $request->restaurante,
            $request->precio,
            $request->cantidad,
            $request->duracion,
            $request->descripcion,
            $request->cliente,
            $request->mesero,
            $request->mesa,
            $request->comentarios,
            $request->evaluacion,
        );
    }

    public function toDeleteCommand(int $id): DeleteMenuRestauranteCommand
    {
        return new DeleteMenuRestauranteCommand($id);
    }

    public function toResponse(MenuRestauranteModel $menu): MenuRestauranteResponse
    {
        $id = $menu->id();

        return new MenuRestauranteResponse(
            $id?->value() ?? 0,
            $menu->nombrePlato(),
            $menu->restaurante(),
            $menu->precio(),
            $menu->cantidad(),
            $menu->duracion(),
            $menu->descripcion(),
            $menu->cliente(),
            $menu->mesero(),
            $menu->mesa(),
            $menu->comentarios(),
            $menu->evaluacion(),
        );
    }

    /**
     * @param MenuRestauranteModel[] $items
     * @return MenuRestauranteResponse[]
     */
    public function toResponseList(array $items): array
    {
        return array_map(fn (MenuRestauranteModel $m): MenuRestauranteResponse => $this->toResponse($m), $items);
    }
}
