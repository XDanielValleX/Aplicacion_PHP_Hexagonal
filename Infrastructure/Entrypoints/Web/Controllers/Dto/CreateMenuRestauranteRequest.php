<?php

declare(strict_types=1);

namespace App\Infrastructure\Entrypoints\Web\Controllers\Dto;

final class CreateMenuRestauranteRequest
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
     * @param array<string, mixed> $data
     */
    public static function fromArray(array $data): self
    {
        return new self(
            (string) ($data['nombrePlato'] ?? ''),
            (string) ($data['restaurante'] ?? ''),
            (string) ($data['precio'] ?? ''),
            (int) ($data['cantidad'] ?? 0),
            (int) ($data['duracion'] ?? 0),
            (string) ($data['descripcion'] ?? ''),
            (string) ($data['cliente'] ?? ''),
            (string) ($data['mesero'] ?? ''),
            (string) ($data['mesa'] ?? ''),
            (string) ($data['comentarios'] ?? ''),
            (int) ($data['evaluacion'] ?? 1),
        );
    }
}
