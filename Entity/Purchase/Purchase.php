<?php 

namespace Src\Entity\Purchase;
use DateTimeImmutable;

final class Purchase {

    public function __construct(
        private readonly ?int $id,
        private DateTimeImmutable $date,
        private string $store,
        private string $total,
        private bool $deleted
        ){}

    public static function create(DateTimeImmutable $date, string $store, string $total): self
    {
        return new self(null, $date, $store, $total, false);
        // 'Self' indica Instancia de el mismo Objeto (Purchase)
    }

    public function modify(DateTimeImmutable $date, string $store, string $total): void
    {
        $this->date = $date;
        $this->store = $store;
        $this->total = $total;
    }

    public function updateTotal(string $total): void
    {
        $this->total = $total;
    }
    
    public function id(): ?int
    {
        return $this->id;
    }

    public function date(): DateTimeImmutable
    {
        return $this->date;
    }

    public function store(): string
    {
        return $this->store;
    }

    public function total(): string
    {
        return $this->total;
    }
    
// Consulta Estado 'DELETED'
    public function isDeleted(): int
    {
        return $this->deleted ? 1 : 0;
    }

// Cambia a Estado 'DELETED'
    public function delete(): void
    {
        $this->deleted = true;
    }
}