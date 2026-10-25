<?php 

namespace Src\Infrastructure\Repository\Product;

use Src\Entity\Product\Product;

interface ProductRepositoryInterface {

    public function find(int $id): ?Product;

    /** @return Product[] */
    public function search(): array;

    public function insert(Product $product): void;

    public function update(Product $product): void;

    /** @return <int, array{ id, name, minimum_stock, available_stock, stock_status}> **/
    public function searchStockAlert(): array;
}