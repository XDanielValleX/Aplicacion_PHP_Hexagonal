<?php

declare(strict_types=1);

namespace App\Infrastructure\Adapters\Persistence\MySQL\Repository;

use App\Application\Ports\Out\UserRepositoryPort;
use App\Domain\Exceptions\DomainException;
use App\Domain\Models\UserModel;
use App\Domain\ValueObjects\UserEmail;
use App\Domain\ValueObjects\UserId;
use App\Infrastructure\Adapters\Persistence\MySQL\Mapper\UserPersistenceMapper;
use PDO;

final class UserRepositoryMySQL implements UserRepositoryPort
{
    public function __construct(
        private readonly PDO $pdo,
    ) {
    }

    public function save(UserModel $user): UserModel
    {
        $dto = UserPersistenceMapper::toDto($user);

        $stmt = $this->pdo->prepare(
            'INSERT INTO users (name, email, password_hash, role_id, status, created_at, updated_at)
             VALUES (:name, :email, :password_hash, :role_id, :status, NOW(), NOW())'
        );

        $stmt->execute($dto->toRow());

        $id = (int) $this->pdo->lastInsertId();
        $created = $this->findById(UserId::fromInt($id));
        if ($created === null) {
            throw new DomainException('No se pudo crear el usuario.');
        }

        return $created;
    }

    public function findById(UserId $id): ?UserModel
    {
        $stmt = $this->pdo->prepare('SELECT * FROM users WHERE id = :id LIMIT 1');
        $stmt->execute(['id' => $id->value()]);
        $row = $stmt->fetch();

        if (!is_array($row)) {
            return null;
        }

        $entity = UserPersistenceMapper::toEntity($row);

        return UserPersistenceMapper::toModel($entity);
    }

    public function findByEmail(UserEmail $email): ?UserModel
    {
        $stmt = $this->pdo->prepare('SELECT * FROM users WHERE email = :email LIMIT 1');
        $stmt->execute(['email' => $email->value()]);
        $row = $stmt->fetch();

        if (!is_array($row)) {
            return null;
        }

        $entity = UserPersistenceMapper::toEntity($row);

        return UserPersistenceMapper::toModel($entity);
    }

    public function listAll(): array
    {
        $stmt = $this->pdo->query('SELECT * FROM users ORDER BY id DESC');
        $rows = $stmt->fetchAll();

        $users = [];
        foreach ($rows as $row) {
            if (is_array($row)) {
                $users[] = UserPersistenceMapper::toModel(UserPersistenceMapper::toEntity($row));
            }
        }

        return $users;
    }

    public function update(UserModel $user): UserModel
    {
        $id = $user->id();
        if ($id === null) {
            throw new DomainException('No se puede actualizar un usuario sin id.');
        }

        $dto = UserPersistenceMapper::toDto($user);
        $row = $dto->toRow();
        $row['id'] = $id->value();

        $stmt = $this->pdo->prepare(
            'UPDATE users
                SET name = :name,
                    email = :email,
                    password_hash = :password_hash,
                    role_id = :role_id,
                    status = :status,
                    updated_at = NOW()
              WHERE id = :id'
        );

        $stmt->execute($row);

        $updated = $this->findById($id);
        if ($updated === null) {
            throw new DomainException('No se pudo actualizar el usuario.');
        }

        return $updated;
    }

    public function delete(UserId $id): void
    {
        $stmt = $this->pdo->prepare('DELETE FROM users WHERE id = :id');
        $stmt->execute(['id' => $id->value()]);
    }
}
