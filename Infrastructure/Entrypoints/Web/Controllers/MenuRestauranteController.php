<?php

declare(strict_types=1);

namespace App\Infrastructure\Entrypoints\Web\Controllers;

use App\Application\Services\CreateMenuRestauranteService;
use App\Application\Services\DeleteMenuRestauranteService;
use App\Application\Services\GetMenuRestauranteByIdService;
use App\Application\Services\ListMenuRestaurantesService;
use App\Application\Services\UpdateMenuRestauranteService;
use App\Domain\Exceptions\DomainException;
use App\Domain\ValueObjects\MenuRestauranteId;
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
        private readonly CreateMenuRestauranteService $create,
        private readonly ListMenuRestaurantesService $list,
        private readonly GetMenuRestauranteByIdService $getById,
        private readonly UpdateMenuRestauranteService $update,
        private readonly DeleteMenuRestauranteService $delete,
    ) {
    }

    public function index(): void
    {
        $items = $this->list->execute();
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
            $item = $this->getById->execute(MenuRestauranteId::fromInt($id));
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
            $item = $this->getById->execute(MenuRestauranteId::fromInt($id));
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
