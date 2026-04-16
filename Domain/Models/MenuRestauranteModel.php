<?php

declare(strict_types=1);

namespace App\Domain\Models;

use App\Domain\Exceptions\DomainException;
use App\Domain\ValueObjects\MenuRestauranteId;

final class MenuRestauranteModel
{
    public function __construct(
        private ?MenuRestauranteId $id,
        private string $nombrePlato,
        private string $restaurante,
        private string $precio,
        private int $cantidad,
        private int $duracion,
        private string $descripcion,
        private string $cliente,
        private string $mesero,
        private string $mesa,
        private string $comentarios,
        private int $evaluacion,
    ) {
        $this->nombrePlato = trim($this->nombrePlato);
        $this->restaurante = trim($this->restaurante);
        $this->precio = self::normalizePrecio($this->precio);
        $this->descripcion = trim($this->descripcion);
        $this->cliente = trim($this->cliente);
        $this->mesero = trim($this->mesero);
        $this->mesa = trim($this->mesa);
        $this->comentarios = trim($this->comentarios);

        // Basic invariants
        $this->assertNonEmpty($this->nombrePlato, 'nombrePlato', 120);
        $this->assertNonEmpty($this->restaurante, 'restaurante', 120);
        $this->assertNonEmpty($this->cliente, 'cliente', 120);
        $this->assertNonEmpty($this->mesero, 'mesero', 120);
        $this->assertNonEmpty($this->mesa, 'mesa', 50);

        if ($this->cantidad < 1) {
            throw new DomainException('cantidad inválida.');
        }

        if ($this->duracion < 0) {
            throw new DomainException('duracion inválida.');
        }

        if ($this->evaluacion < 1 || $this->evaluacion > 5) {
            throw new DomainException('evaluacion debe estar entre 1 y 5.');
        }
    }

    public function id(): ?MenuRestauranteId
    {
        return $this->id;
    }

    public function nombrePlato(): string
    {
        return $this->nombrePlato;
    }

    public function restaurante(): string
    {
        return $this->restaurante;
    }

    /** Decimal string like 10.50 */
    public function precio(): string
    {
        return $this->precio;
    }

    public function cantidad(): int
    {
        return $this->cantidad;
    }

    public function duracion(): int
    {
        return $this->duracion;
    }

    public function descripcion(): string
    {
        return $this->descripcion;
    }

    public function cliente(): string
    {
        return $this->cliente;
    }

    public function mesero(): string
    {
        return $this->mesero;
    }

    public function mesa(): string
    {
        return $this->mesa;
    }

    public function comentarios(): string
    {
        return $this->comentarios;
    }

    public function evaluacion(): int
    {
        return $this->evaluacion;
    }

    public function withId(MenuRestauranteId $id): self
    {
        return new self(
            $id,
            $this->nombrePlato,
            $this->restaurante,
            $this->precio,
            $this->cantidad,
            $this->duracion,
            $this->descripcion,
            $this->cliente,
            $this->mesero,
            $this->mesa,
            $this->comentarios,
            $this->evaluacion,
        );
    }

    public function update(
        string $nombrePlato,
        string $restaurante,
        string $precio,
        int $cantidad,
        int $duracion,
        string $descripcion,
        string $cliente,
        string $mesero,
        string $mesa,
        string $comentarios,
        int $evaluacion,
    ): self {
        return new self(
            $this->id,
            trim($nombrePlato),
            trim($restaurante),
            self::normalizePrecio($precio),
            $cantidad,
            $duracion,
            trim($descripcion),
            trim($cliente),
            trim($mesero),
            trim($mesa),
            trim($comentarios),
            $evaluacion,
        );
    }

    private function assertNonEmpty(string $value, string $field, int $maxLen): void
    {
        $value = trim($value);

        if ($value === '') {
            throw new DomainException($field . ' es obligatorio.');
        }

        if (mb_strlen($value) > $maxLen) {
            throw new DomainException($field . ' es demasiado largo.');
        }
    }

    private static function normalizePrecio(string $precio): string
    {
        $precio = str_replace(',', '.', trim($precio));

        if ($precio === '' || !preg_match('/^\d+(?:\.\d{1,2})?$/', $precio)) {
            throw new DomainException('precio inválido.');
        }

        $normalized = number_format((float) $precio, 2, '.', '');
        if ((float) $normalized <= 0) {
            throw new DomainException('precio debe ser mayor a 0.');
        }

        return $normalized;
    }
}
