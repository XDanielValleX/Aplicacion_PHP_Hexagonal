<?php

declare(strict_types=1);

namespace App\Application\Commands;

final class UpdateMenuRestauranteCommand
{
    public function __construct(
        public readonly int $id,
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
}
