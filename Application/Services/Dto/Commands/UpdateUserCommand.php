<?php

declare(strict_types=1);

namespace App\Application\Services\Dto\Commands;

final class UpdateUserCommand
{
    private int $id;
    private string $name;
    private string $email;
    private ?string $password;
    private int $roleId;
    private string $status;

    public function __construct(int $id, string $name, string $email, ?string $password, int $roleId, string $status)
    {
        $this->id = $id;
        $this->name = trim($name);
        $this->email = trim($email);
        $this->password = $password;
        $this->roleId = $roleId;
        $this->status = trim($status);
    }

    public function getId(): int
    {
        return $this->id;
    }

    public function getName(): string
    {
        return $this->name;
    }

    public function getEmail(): string
    {
        return $this->email;
    }

    public function getPassword(): ?string
    {
        return $this->password;
    }

    public function getRoleId(): int
    {
        return $this->roleId;
    }

    public function getStatus(): string
    {
        return $this->status;
    }
}
