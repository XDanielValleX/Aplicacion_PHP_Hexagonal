<?php

declare(strict_types=1);

namespace App\Infrastructure\Adapters\Persistence\MySQL\Mapper;

use App\Domain\Models\MenuRestauranteModel;
use App\Domain\ValueObjects\MenuRestauranteId;
use App\Infrastructure\Adapters\Persistence\MySQL\Dto\MenuRestaurantePersistenceDto;
use App\Infrastructure\Adapters\Persistence\MySQL\Entity\MenuRestauranteEntity;

final class MenuRestaurantePersistenceMapper
{
    /**
     * @param array{
     *   id:mixed,
     *   nombre_plato:mixed,
     *   restaurante:mixed,
     *   precio:mixed,
     *   cantidad:mixed,
     *   duracion:mixed,
     *   descripcion:mixed,
     *   cliente:mixed,
     *   mesero:mixed,
     *   mesa:mixed,
     *   comentarios:mixed,
     *   evaluacion:mixed,
     *   created_at:mixed,
     *   updated_at:mixed
     * } $row
     */
    public static function toEntity(array $row): MenuRestauranteEntity
    {
        return new MenuRestauranteEntity(
            (int) $row['id'],
            (string) $row['nombre_plato'],
            (string) $row['restaurante'],
            (string) $row['precio'],
            (int) $row['cantidad'],
            (int) $row['duracion'],
            (string) $row['descripcion'],
            (string) $row['cliente'],
            (string) $row['mesero'],
            (string) $row['mesa'],
            (string) $row['comentarios'],
            (int) $row['evaluacion'],
            (string) $row['created_at'],
            (string) $row['updated_at'],
        );
    }

    public static function toModel(MenuRestauranteEntity $entity): MenuRestauranteModel
    {
        return new MenuRestauranteModel(
            MenuRestauranteId::fromInt($entity->id),
            $entity->nombrePlato,
            $entity->restaurante,
            $entity->precio,
            $entity->cantidad,
            $entity->duracion,
            $entity->descripcion,
            $entity->cliente,
            $entity->mesero,
            $entity->mesa,
            $entity->comentarios,
            $entity->evaluacion,
        );
    }

    public static function toDto(MenuRestauranteModel $menu): MenuRestaurantePersistenceDto
    {
        return new MenuRestaurantePersistenceDto(
            $menu->nombrePlato(),
            $menu->restaurante(),
            $menu->precio(),
            $menu->cantidad(),
            $menu->duracion(),
            $menu->descripcion(),
            $menu->cliente(),
            $menu->mesero(),
            $menu->mesa(),
            $menu->comentarios(),
            $menu->evaluacion(),
        );
    }
}
