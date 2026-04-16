<?php

declare(strict_types=1);

namespace App\Application\Services\Dto\Commands;

final class CreateUserCommand
{
    private string $name;
    private string $email;
    private string $password;
    private int $roleId;

    public function __construct(string $name, string $email, string $password, int $roleId = 1)
    {
        $this->name = trim($name);
        $this->email = trim($email);
        $this->password = $password;
        $this->roleId = $roleId;
    }

    public function getName(): string
    {
        return $this->name;
    }

    public function getEmail(): string
    {
        return $this->email;
    }

    public function getPassword(): string
    {
        return $this->password;
    }

    public function getRoleId(): int
    {
        return $this->roleId;
    }
}
