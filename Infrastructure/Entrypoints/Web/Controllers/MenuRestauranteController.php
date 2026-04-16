<?php

declare(strict_types=1);

namespace App\Infrastructure\Entrypoints\Web\Controllers;

use App\Application\Ports\In\CreateMenuRestauranteUseCase;
use App\Application\Ports\In\DeleteMenuRestauranteUseCase;
use App\Application\Ports\In\GetAllMenuRestaurantesUseCase;
use App\Application\Ports\In\GetMenuRestauranteByIdUseCase;
use App\Application\Ports\In\UpdateMenuRestauranteUseCase;
use App\Application\Services\Dto\Queries\GetAllMenuRestaurantesQuery;
use App\Application\Services\Dto\Queries\GetMenuRestauranteByIdQuery;
use App\Infrastructure\Entrypoints\Web\Controllers\Dto\CreateMenuRestauranteRequest;
use App\Infrastructure\Entrypoints\Web\Controllers\Dto\MenuRestauranteResponse;
use App\Infrastructure\Entrypoints\Web\Controllers\Dto\UpdateMenuRestauranteRequest;
use App\Infrastructure\Entrypoints\Web\Controllers\Mapper\MenuRestauranteWebMapper;

final class MenuRestauranteController
{
    public function __construct(
        private readonly MenuRestauranteWebMapper $mapper,
        private readonly CreateMenuRestauranteUseCase $create,
        private readonly GetAllMenuRestaurantesUseCase $list,
        private readonly GetMenuRestauranteByIdUseCase $getById,
        private readonly UpdateMenuRestauranteUseCase $update,
        private readonly DeleteMenuRestauranteUseCase $delete,
    ) {
    }

    /**
     * @return MenuRestauranteResponse[]
     */
    public function index(): array
    {
        $items = $this->list->execute(new GetAllMenuRestaurantesQuery());

        return $this->mapper->toResponseList($items);
    }

    public function store(CreateMenuRestauranteRequest $request): void
    {
        $this->create->execute($this->mapper->toCreateCommand($request));
    }

    public function show(int $id): MenuRestauranteResponse
    {
        $item = $this->getById->execute(new GetMenuRestauranteByIdQuery($id));

        return $this->mapper->toResponse($item);
    }

    public function edit(int $id): MenuRestauranteResponse
    {
        $item = $this->getById->execute(new GetMenuRestauranteByIdQuery($id));

        return $this->mapper->toResponse($item);
    }

    public function update(UpdateMenuRestauranteRequest $request): void
    {
        $this->update->execute($this->mapper->toUpdateCommand($request));
    }

    public function destroy(int $id): void
    {
        $this->delete->execute($this->mapper->toDeleteCommand($id));
    }
}
