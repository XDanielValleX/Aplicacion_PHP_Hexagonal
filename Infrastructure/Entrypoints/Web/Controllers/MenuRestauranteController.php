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
use App\Domain\Exceptions\DomainException;
use App\Infrastructure\Entrypoints\Web\Controllers\Dto\CreateMenuRestauranteRequest;
use App\Infrastructure\Entrypoints\Web\Controllers\Dto\UpdateMenuRestauranteRequest;
use App\Infrastructure\Entrypoints\Web\Controllers\Mapper\MenuRestauranteWebMapper;
use App\Infrastructure\Entrypoints\Web\Presentation\Flash;
use App\Infrastructure\Entrypoints\Web\Presentation\View;

final class MenuRestauranteController
{
    public function __construct(
        private readonly View $view,
        private readonly MenuRestauranteWebMapper $mapper,
        private readonly CreateMenuRestauranteUseCase $create,
        private readonly GetAllMenuRestaurantesUseCase $list,
        private readonly GetMenuRestauranteByIdUseCase $getById,
        private readonly UpdateMenuRestauranteUseCase $update,
        private readonly DeleteMenuRestauranteUseCase $delete,
    ) {
    }

    public function index(): void
    {
        $items = $this->list->execute(new GetAllMenuRestaurantesQuery());
        $responses = $this->mapper->toResponseList($items);

        $this->view->render('menus/list', [
            'items' => $responses,
        ]);
    }

    public function create(): void
    {
        $this->view->render('menus/create');
    }

    public function store(CreateMenuRestauranteRequest $request): void
    {
        try {
            $this->create->execute($this->mapper->toCreateCommand($request));
            Flash::success('Registro creado correctamente.');
            $this->view->redirect('menus.index');
        } catch (DomainException $e) {
            Flash::error($e->getMessage());
            $this->view->redirect('menus.create');
        }
    }

    public function show(int $id): void
    {
        try {
            $item = $this->getById->execute(new GetMenuRestauranteByIdQuery($id));
            $this->view->render('menus/show', [
                'item' => $this->mapper->toResponse($item),
            ]);
        } catch (DomainException $e) {
            Flash::error($e->getMessage());
            $this->view->redirect('menus.index');
        }
    }

    public function edit(int $id): void
    {
        try {
            $item = $this->getById->execute(new GetMenuRestauranteByIdQuery($id));
            $this->view->render('menus/edit', [
                'item' => $this->mapper->toResponse($item),
            ]);
        } catch (DomainException $e) {
            Flash::error($e->getMessage());
            $this->view->redirect('menus.index');
        }
    }

    public function update(UpdateMenuRestauranteRequest $request): void
    {
        try {
            $this->update->execute($this->mapper->toUpdateCommand($request));
            Flash::success('Registro actualizado correctamente.');
            $this->view->redirect('menus.index');
        } catch (DomainException $e) {
            Flash::error($e->getMessage());
            $this->view->redirect('menus.edit', ['id' => $request->id]);
        }
    }

    public function destroy(int $id): void
    {
        try {
            $this->delete->execute($this->mapper->toDeleteCommand($id));
            Flash::success('Registro eliminado.');
        } catch (DomainException $e) {
            Flash::error($e->getMessage());
        }

        $this->view->redirect('menus.index');
    }
}
