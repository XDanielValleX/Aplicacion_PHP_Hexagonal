<?php

declare(strict_types=1);

namespace App\Infrastructure\Entrypoints\Web\Controllers\Mapper;

use App\Application\Services\Dto\Commands\CreateUserCommand;
use App\Application\Services\Dto\Commands\DeleteUserCommand;
use App\Application\Services\Dto\Commands\UpdateUserCommand;
use App\Domain\Models\UserModel;
use App\Infrastructure\Entrypoints\Web\Controllers\Dto\CreateUserRequest;
use App\Infrastructure\Entrypoints\Web\Controllers\Dto\UpdateUserRequest;
use App\Infrastructure\Entrypoints\Web\Controllers\Dto\UserResponse;

final class UserWebMapper
{
    public function toCreateCommand(CreateUserRequest $request): CreateUserCommand
    {
        return new CreateUserCommand(
            $request->name,
            $request->email,
            $request->password,
            $request->roleId,
        );
    }

    public function toUpdateCommand(UpdateUserRequest $request): UpdateUserCommand
    {
        return new UpdateUserCommand(
            $request->id,
            $request->name,
            $request->email,
            $request->password,
            $request->roleId,
            $request->status,
        );
    }

    public function toDeleteCommand(int $id): DeleteUserCommand
    {
        return new DeleteUserCommand($id);
    }

    public function toResponse(UserModel $user): UserResponse
    {
        $id = $user->id();

        return new UserResponse(
            $id?->value() ?? 0,
            $user->name()->value(),
            $user->email()->value(),
            $user->roleId()->value(),
            $user->status()->value,
        );
    }

    /**
     * @param UserModel[] $users
     * @return UserResponse[]
     */
    public function toResponseList(array $users): array
    {
        return array_map(fn (UserModel $u): UserResponse => $this->toResponse($u), $users);
    }
}
