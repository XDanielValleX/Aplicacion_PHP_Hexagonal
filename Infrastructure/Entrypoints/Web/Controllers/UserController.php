<?php

declare(strict_types=1);

namespace App\Infrastructure\Entrypoints\Web\Controllers;

use App\Application\Services\CreateUserService;
use App\Application\Services\DeleteUserService;
use App\Application\Services\GetUserByIdService;
use App\Application\Services\ListUsersService;
use App\Application\Services\UpdateUserService;
use App\Domain\Exceptions\DomainException;
use App\Domain\ValueObjects\UserId;
use App\Infrastructure\Entrypoints\Web\Controllers\Dto\CreateUserRequest;
use App\Infrastructure\Entrypoints\Web\Controllers\Dto\UpdateUserRequest;
use App\Infrastructure\Entrypoints\Web\Controllers\Mapper\UserWebMapper;
use App\Infrastructure\Entrypoints\Web\Presentation\Flash;
use App\Infrastructure\Entrypoints\Web\Presentation\View;

final class UserController
{
    public function __construct(
        private readonly View $view,
        private readonly UserWebMapper $mapper,
        private readonly CreateUserService $createUser,
        private readonly ListUsersService $listUsers,
        private readonly GetUserByIdService $getUserById,
        private readonly UpdateUserService $updateUser,
        private readonly DeleteUserService $deleteUser,
    ) {
    }

    public function index(): void
    {
        $users = $this->listUsers->execute();
        $responses = $this->mapper->toResponseList($users);

        $this->view->render('users/list', [
            'users' => $responses,
        ]);
    }

    public function create(): void
    {
        $this->view->render('users/create');
    }

    public function store(CreateUserRequest $request): void
    {
        try {
            $this->createUser->execute($this->mapper->toCreateCommand($request));
            Flash::success('Usuario creado correctamente.');
            $this->view->redirect('users.index');
        } catch (DomainException $e) {
            Flash::error($e->getMessage());
            $this->view->redirect('users.create');
        }
    }

    public function show(int $id): void
    {
        try {
            $user = $this->getUserById->execute(UserId::fromInt($id));
            $this->view->render('users/show', [
                'user' => $this->mapper->toResponse($user),
            ]);
        } catch (DomainException $e) {
            Flash::error($e->getMessage());
            $this->view->redirect('users.index');
        }
    }

    public function edit(int $id): void
    {
        try {
            $user = $this->getUserById->execute(UserId::fromInt($id));
            $this->view->render('users/edit', [
                'user' => $this->mapper->toResponse($user),
            ]);
        } catch (DomainException $e) {
            Flash::error($e->getMessage());
            $this->view->redirect('users.index');
        }
    }

    public function update(UpdateUserRequest $request): void
    {
        try {
            $this->updateUser->execute($this->mapper->toUpdateCommand($request));
            Flash::success('Usuario actualizado correctamente.');
            $this->view->redirect('users.index');
        } catch (DomainException $e) {
            Flash::error($e->getMessage());
            $this->view->redirect('users.edit', ['id' => $request->id]);
        }
    }

    public function destroy(int $id): void
    {
        try {
            $this->deleteUser->execute($this->mapper->toDeleteCommand($id));
            Flash::success('Usuario eliminado.');
        } catch (DomainException $e) {
            Flash::error($e->getMessage());
        }

        $this->view->redirect('users.index');
    }
}
