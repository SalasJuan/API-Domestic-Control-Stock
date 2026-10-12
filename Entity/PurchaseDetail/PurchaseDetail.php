<?php 

namespace Src\Entity\PurchaseDetail;

final class PurchaseDetail {
    public function __construct(
        private readonly ?int $id,
        private ?int $purchase_id,
        private int $product_id,
        private int $quantity,
        private string $unit_price,
        private string $subtotal,
        private bool $deleted
        ){}
//SubTotal es un Atributo Calculado el User no Modifica Directamente

    public static function create(int $product_id, int $quantity, string $unit_price): self 
    {
        $subtotal = bcmul((string) $quantity, $unit_price,2);
        return new self(null, null, $product_id, $quantity, $unit_price, $subtotal, false);
    }

    public function modify(int $product_id, int $quantity, string $unit_price): void
    {
        $this->product_id = $product_id;
        $this->quantity = $quantity;
        $this->unit_price = $unit_price;
        $this->subtotal = bcmul((string) $quantity, $unit_price,2);
        //Recalcular SubTotal en cada Modify
    }

    public function assignPurchase(int $purchase_id): void
    {
        if ($purchase_id <= 0) {
        throw new \InvalidArgumentException(
            "El ID de la compra debe ser mayor a 0."
        );
        }
        
    $this->purchase_id = $purchase_id;
    }

    public function id(): ?int
    {
        return $this->id;
    }

    public function purchase_id(): ?int
    {
        return $this->purchase_id;
    }

    public function product_id(): int
    {
        return $this->product_id;
    }

    public function quantity(): int
    {
        return $this->quantity;
    }

    public function unit_price(): string
    {
        return $this->unit_price;
    }
    
    public function subtotal(): string
    {
        return $this->subtotal;
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

// Quita el Estado 'DELETED'
    public function restore(): void
    {
        $this->deleted = false;
    }

}