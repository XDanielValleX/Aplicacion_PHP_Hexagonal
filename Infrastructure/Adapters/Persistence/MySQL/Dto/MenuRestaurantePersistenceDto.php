<?php

declare(strict_types=1);

namespace App\Infrastructure\Adapters\Persistence\MySQL\Dto;

final class MenuRestaurantePersistenceDto
{
    public function __construct(
        public readonly string $nombrePlato,
        public readonly string $restaurante,
        public readonly string $precio,
        public readonly int $cantidad,
        public readonly int $duracion,
        public readonly string $descripcion,
        public readonly string $cliente,
        public readonly string $mesero,
        public readonly string $mesa,
        public readonly string $comentarios,
        public readonly int $evaluacion,
    ) {
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
    public function toRow(): array
    {
        return [
            'nombre_plato' => $this->nombrePlato,
            'restaurante' => $this->restaurante,
            'precio' => $this->precio,
            'cantidad' => $this->cantidad,
            'duracion' => $this->duracion,
            'descripcion' => $this->descripcion,
            'cliente' => $this->cliente,
            'mesero' => $this->mesero,
            'mesa' => $this->mesa,
            'comentarios' => $this->comentarios,
            'evaluacion' => $this->evaluacion,
        ];
    }
}
