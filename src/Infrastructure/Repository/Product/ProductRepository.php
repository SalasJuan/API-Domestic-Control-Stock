<?php 

namespace Src\Infrastructure\Repository\Product;

use Src\Infrastructure\PDO\PDOManager;
use Src\Entity\Product\Product;

final readonly class ProductRepository extends PDOManager implements ProductRepositoryInterface {
    public function find(int $id): ?Product
    {
        $query = <<<FIND_PRODUCT
                        SELECT 
                        *
                        FROM
                        Products P
                        WHERE
                            P.id = :id
                        AND
                        P.deleted = 0
                    FIND_PRODUCT;
    // Query en Multiples Lineas
        //Mantener Alineado el  'FIND_PRODUCT'
            $parameters = [
                "id" => $id
            ];

            $result = $this->execute($query, $parameters);

            return $this->toProduct($result[0] ?? null);
    }

    /** @return Product[] */
    public function search(): array
    {
        $query = <<<SEARCH_PRODUCT
                        SELECT
                            *
                        FROM
                        Products P
                        WHERE
                        P.deleted = 0
                        SEARCH_PRODUCT;
                        //Revisar que los Nombres Coincidan con los de la BDD
        
        $results = $this->execute($query);

        $products = [];
        foreach($results as $result) {
            $products[] = $this->toProduct($result);
        }
        
        return $products;
    }

    public function update(Product $product): void
    {
        $query = <<<UPDATE_PRODUCT
                    UPDATE
                        Products
                    SET
                        name = :name,
                        brand_id = :brand_id,
                        category_id = :category_id,
                        minimum_stock = :minimum_stock,
                        deleted = :deleted
                    WHERE
                        id = :id
                    UPDATE_PRODUCT;
        
        $parameters = [
            "name" => $product->name(),
            "brand_id" => $product->brand_id(),
            "category_id" => $product->category_id(),
            "minimum_stock" => $product->minimum_stock(),
            "deleted" => $product->isDeleted(),
            "id" => $product->id()
        ];
        $this->execute($query, $parameters);
    }


    public function insert(Product $product): void
    {
        $query = "INSERT INTO Products (name, brand_id, category_id, minimum_stock, deleted) VALUES (:name, :brand_id, :category_id, :minimum_stock, :deleted) ";
        
        $parameters = [
            "name" => $product->name(),
            "brand_id" => $product->brand_id(),
            "category_id" => $product->category_id(),
            "minimum_stock" => $product->minimum_stock(),
            "deleted" => $product->isDeleted()
        ];
        $this->execute($query, $parameters);
    }

// Convierte Primitivos en 'Product'
    private function toProduct(?array $primitive): ?Product {
        if ($primitive === null) {
            return null;
        }

        return new Product(
            $primitive["id"],
            $primitive["name"],
            $primitive["brand_id"],
            $primitive["category_id"],
            $primitive["minimum_stock"],
            $primitive["deleted"]
        );
    }
}