<?php

declare(strict_types=1);

namespace App\Infrastructure\Persistence\MySQL;

use App\Domain\Models\MenuRestauranteModel;
use App\Domain\ValueObjects\MenuRestauranteId;

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
     *   evaluacion:mixed
     * } $row
     */
    public static function toModel(array $row): MenuRestauranteModel
    {
        return new MenuRestauranteModel(
            MenuRestauranteId::fromInt((int) $row['id']),
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
        );
    }

    /**
     * @return array{
     *   nombre_plato:string,
     *   restaurante:string,
     *   precio:string,
     *   cantidad:int,
     *   duracion:int,
     *   descripcion:string,
     *   cliente:string,
     *   mesero:string,
     *   mesa:string,
     *   comentarios:string,
     *   evaluacion:int
     * }
     */
    public static function toRow(MenuRestauranteModel $menu): array
    {
        return [
            'nombre_plato' => $menu->nombrePlato(),
            'restaurante' => $menu->restaurante(),
            'precio' => $menu->precio(),
            'cantidad' => $menu->cantidad(),
            'duracion' => $menu->duracion(),
            'descripcion' => $menu->descripcion(),
            'cliente' => $menu->cliente(),
            'mesero' => $menu->mesero(),
            'mesa' => $menu->mesa(),
            'comentarios' => $menu->comentarios(),
            'evaluacion' => $menu->evaluacion(),
        ];
    }
}
