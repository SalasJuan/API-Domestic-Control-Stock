<?php 

namespace Src\Entity\Product;

final class Product {
    public function __construct(
        private readonly ?int $id,
        private string $name,
        private string $brand_id,
        private string $category_id,
        private int $minimum_stock,
        private bool $deleted
        ){}

    public static function create(string $name, string $brand_id, string $category_id, int $minimum_stock): self
    {
        return new self(null, $name, $brand_id, $category_id, $minimum_stock, false);
        // 'Self' indica Instancia de el mismo Objeto (Product)
    }

//Modify es un setter para todos los Atributos 
//Funcion Utilizada por 'UPDATE'
    public function modify(string $name, string $brand_id, string $category_id, int $minimum_stock): void
    {
        $this->name = $name;
        $this->brand_id = $brand_id;
        $this->category_id = $category_id;
        $this->minimum_stock = $minimum_stock;
    }

    public function id(): ?int
    {
        return $this->id;
    }
    
    public function name(): string
    {
        return $this->name;
    }
    public function brand_id(): string
    {
        return $this->brand_id;
    }
    public function category_id(): string
    {
        return $this->category_id;
    }
    public function minimum_stock(): int
    {
        return $this->minimum_stock;
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