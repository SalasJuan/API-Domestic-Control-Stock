<?php 

namespace Src\Entity\Lot;
use DateTimeImmutable;

final class Lot {

    public function __construct(
        private readonly ?int $id,
        private int $purchase_detail_id,
        private int $product_id,
        private int $quantity,
        private DateTimeImmutable $purchase_date,
        private DateTimeImmutable $expiration_date,
        private bool $deleted
        ){}

    public static function create(int $purchase_detail_id, int $product_id, int $quantity, DateTimeImmutable $purchase_date, DateTimeImmutable $expiration_date): self
    {
        return new self(null, $purchase_detail_id, $product_id, $quantity, $purchase_date, $expiration_date, false);
    }

    public function modify(int $purchase_detail_id, int $product_id, int $quantity, DateTimeImmutable $purchase_date, DateTimeImmutable $expiration_date): void
    {
        $this->purchase_detail_id = $purchase_detail_id;
        $this->product_id = $product_id;
        $this->quantity = $quantity;
        $this->purchase_date = $purchase_date;
        $this->expiration_date = $expiration_date;
    }
    
    public function id(): ?int
    {
        return $this->id;
    }

    public function purchase_detail_id(): int
    {
        return $this->purchase_detail_id;
    }

    public function product_id(): int
    {
        return $this->product_id;
    }
          
    public function quantity(): int
    {
        return $this->quantity;
    }
                
    public function purchase_date(): DateTimeImmutable
    {
        return $this->purchase_date;
    }
            
    public function expiration_date(): DateTimeImmutable
    {
        return $this->expiration_date;
    }

    public function updateQuantity(int $quantity): void
    {
        $this->quantity = $quantity;
    }
    public function updateProduct(int $product_id): void
    {
        $this->product_id = $product_id;
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

    public function restore(): void
    {
        $this->deleted = false;
    }
}