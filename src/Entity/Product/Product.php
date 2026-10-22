<?php 

namespace Src\Entity\Product;

use Src\Entity\Product\Exception\InvalidProductNameException;
use Src\Entity\Product\Exception\InvalidProductBrandIdException;
use Src\Entity\Product\Exception\InvalidProductCategoryIdException;
use Src\Entity\Product\Exception\InvalidProductMinimumStockException;

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
        self::validateName($name);
        self::validateBrandId($brand_id);
        self::validateCategoryId($category_id);
        self::validateMinimumStock($minimum_stock);

        return new self(null, trim($name), $brand_id, $category_id, $minimum_stock, false);
        // 'Self' indica Instancia de el mismo Objeto (Product)
    }

    public function modify(string $name, string $brand_id, string $category_id, int $minimum_stock): void
    {
        self::validateName($name);
        self::validateBrandId($brand_id);
        self::validateCategoryId($category_id);
        self::validateMinimumStock($minimum_stock);

        $this->name = trim($name);
        $this->brand_id = $brand_id;
        $this->category_id = $category_id;
        $this->minimum_stock = $minimum_stock;
    }


    private static function validateName($name)
    {
        if (trim($name) === '') {
            throw new InvalidProductNameException();
        }  
    }
    private static function validateBrandId(int $brand_id): void
    {  
        if ($brand_id <= 0) {
            throw new InvalidProductBrandIdException();
        }
    }
    private static function validateCategoryId(int $category_id): void
    {  
        if ($category_id <= 0) {
            throw new InvalidProductCategoryIdException();
        }
    }
    private static function validateMinimumStock(int $minimum_stock): void
    {  
        if ($minimum_stock < 0) {
            throw new InvalidProductMinimumStockException();
        }
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