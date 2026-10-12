<?php 

namespace Src\Service\Product;

use Src\Entity\Product\Product;
use Src\Infrastructure\Repository\Product\ProductRepository;

final readonly class ProductUpdaterService {
    private ProductRepository $repository;
    private ProductFinderService $finder;

    public function __construct() {
        $this->repository = new ProductRepository();
        $this->finder = new ProductFinderService();
    }

    public function update(string $name, string $brand_id, string $category_id, int $minimum_stock, int $id): void
    {
        $product = $this->finder->find($id);

        $product->modify($name, $brand_id, $category_id, $minimum_stock);

        $this->repository->update($product);
    }
}