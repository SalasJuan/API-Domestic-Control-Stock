<?php 

namespace Src\Service\Product;

use Src\Entity\Product\Product;
use Src\Infrastructure\Repository\Product\ProductRepository;

final readonly class ProductCreatorService {
    private ProductRepository $repository;

    public function __construct() {
        $this->repository = new ProductRepository();
    }

    public function create(string $name, string $brand_id, string $category_id, int $minimum_stock): void
    {
    //Utiliza el Create de Entity, luego Insert (Sql) de Repository
        $product = Product::create($name, $brand_id, $category_id, $minimum_stock);
        //var_dump($product);
        $this->repository->insert($product);
    }
}