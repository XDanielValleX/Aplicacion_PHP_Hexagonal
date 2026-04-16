<?php

declare(strict_types=1);

namespace App\Infrastructure\Entrypoints\Web\Controllers;

use App\Application\Ports\In\CreateUserUseCase;
use App\Application\Ports\In\DeleteUserUseCase;
use App\Application\Ports\In\GetAllUsersUseCase;
use App\Application\Ports\In\GetUserByIdUseCase;
use App\Application\Ports\In\UpdateUserUseCase;
use App\Application\Services\Dto\Queries\GetAllUsersQuery;
use App\Application\Services\Dto\Queries\GetUserByIdQuery;
use App\Infrastructure\Entrypoints\Web\Controllers\Dto\CreateUserRequest;
use App\Infrastructure\Entrypoints\Web\Controllers\Dto\UpdateUserRequest;
use App\Infrastructure\Entrypoints\Web\Controllers\Dto\UserResponse;
use App\Infrastructure\Entrypoints\Web\Controllers\Mapper\UserWebMapper;

final class UserController
{
    public function __construct(
        private readonly UserWebMapper $mapper,
        private readonly CreateUserUseCase $createUser,
        private readonly GetAllUsersUseCase $listUsers,
        private readonly GetUserByIdUseCase $getUserById,
        private readonly UpdateUserUseCase $updateUser,
        private readonly DeleteUserUseCase $deleteUser,
    ) {
    }

    /**
     * @return UserResponse[]
     */
    public function index(): array
    {
        $users = $this->listUsers->execute(new GetAllUsersQuery());

        return $this->mapper->toResponseList($users);
    }

    public function store(CreateUserRequest $request): void
    {
        $this->createUser->execute($this->mapper->toCreateCommand($request));
    }

    public function show(int $id): UserResponse
    {
        $user = $this->getUserById->execute(new GetUserByIdQuery($id));

        return $this->mapper->toResponse($user);
    }

    public function edit(int $id): UserResponse
    {
        $user = $this->getUserById->execute(new GetUserByIdQuery($id));

        return $this->mapper->toResponse($user);
    }

    public function update(UpdateUserRequest $request): void
    {
        $this->updateUser->execute($this->mapper->toUpdateCommand($request));
    }

    public function destroy(int $id): void
    {
        $this->deleteUser->execute($this->mapper->toDeleteCommand($id));
    }
}
