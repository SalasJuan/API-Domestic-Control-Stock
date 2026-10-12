<?php 

use Src\Service\Product\ProductFinderService;

final readonly class ProductGetController {

    private ProductFinderService $service;

    public function __construct() {
        $this->service = new ProductFinderService();
    }

    public function start(int $id): void
    {
        $product = $this->service->find($id);
        echo json_encode([
            "id" => $product->id(),
            "name" => $product->name(),
            "brand_id" => $product->brand_id(),
            "category_id" => $product->category_id(),
            "minimum_stock" => $product->minimum_stock(),
        //  "deleted" => $product->isDeleted()
        ]);
    }
}