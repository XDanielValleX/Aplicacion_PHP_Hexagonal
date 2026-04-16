<?php

declare(strict_types=1);

namespace App\Infrastructure\Adapters\Persistence\MySQL\Repository;

use App\Application\Ports\Out\MenuRestauranteRepositoryPort;
use App\Domain\Exceptions\DomainException;
use App\Domain\Models\MenuRestauranteModel;
use App\Domain\ValueObjects\MenuRestauranteId;
use App\Infrastructure\Adapters\Persistence\MySQL\Mapper\MenuRestaurantePersistenceMapper;
use PDO;

final class MenuRestauranteRepositoryMySQL implements MenuRestauranteRepositoryPort
{
    public function __construct(
        private readonly PDO $pdo,
    ) {
    }

    public function save(MenuRestauranteModel $menu): MenuRestauranteModel
    {
        $dto = MenuRestaurantePersistenceMapper::toDto($menu);

        $stmt = $this->pdo->prepare(
            'INSERT INTO menu_restaurante (
                nombre_plato, restaurante, precio, cantidad, duracion, descripcion,
                cliente, mesero, mesa, comentarios, evaluacion, created_at, updated_at
            ) VALUES (
                :nombre_plato, :restaurante, :precio, :cantidad, :duracion, :descripcion,
                :cliente, :mesero, :mesa, :comentarios, :evaluacion, NOW(), NOW()
            )'
        );

        $stmt->execute($dto->toRow());

        $id = (int) $this->pdo->lastInsertId();
        $created = $this->findById(MenuRestauranteId::fromInt($id));
        if ($created === null) {
            throw new DomainException('No se pudo crear el registro.');
        }

        return $created;
    }

    public function findById(MenuRestauranteId $id): ?MenuRestauranteModel
    {
        $stmt = $this->pdo->prepare('SELECT * FROM menu_restaurante WHERE id = :id LIMIT 1');
        $stmt->execute(['id' => $id->value()]);
        $row = $stmt->fetch();

        if (!is_array($row)) {
            return null;
        }

        $entity = MenuRestaurantePersistenceMapper::toEntity($row);

        return MenuRestaurantePersistenceMapper::toModel($entity);
    }

    public function listAll(): array
    {
        $stmt = $this->pdo->query('SELECT * FROM menu_restaurante ORDER BY id DESC');
        $rows = $stmt->fetchAll();

        $items = [];
        foreach ($rows as $row) {
            if (is_array($row)) {
                $items[] = MenuRestaurantePersistenceMapper::toModel(MenuRestaurantePersistenceMapper::toEntity($row));
            }
        }

        return $items;
    }

    public function update(MenuRestauranteModel $menu): MenuRestauranteModel
    {
        $id = $menu->id();
        if ($id === null) {
            throw new DomainException('No se puede actualizar sin id.');
        }

        $dto = MenuRestaurantePersistenceMapper::toDto($menu);
        $row = $dto->toRow();
        $row['id'] = $id->value();

        $stmt = $this->pdo->prepare(
            'UPDATE menu_restaurante
                SET nombre_plato = :nombre_plato,
                    restaurante = :restaurante,
                    precio = :precio,
                    cantidad = :cantidad,
                    duracion = :duracion,
                    descripcion = :descripcion,
                    cliente = :cliente,
                    mesero = :mesero,
                    mesa = :mesa,
                    comentarios = :comentarios,
                    evaluacion = :evaluacion,
                    updated_at = NOW()
              WHERE id = :id'
        );

        $stmt->execute($row);

        $updated = $this->findById($id);
        if ($updated === null) {
            throw new DomainException('No se pudo actualizar el registro.');
        }

        return $updated;
    }

    public function delete(MenuRestauranteId $id): void
    {
        $stmt = $this->pdo->prepare('DELETE FROM menu_restaurante WHERE id = :id');
        $stmt->execute(['id' => $id->value()]);
    }
}
