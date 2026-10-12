<?php 

use Src\Service\Product\ProductsSearcherService;

final readonly class ProductsGetController {
    private ProductsSearcherService $service;

    public function __construct() {
        $this->service = new ProductsSearcherService();
    }

    public function start(): void
    {
        $products = $this->service->search();
        echo json_encode($this->toResponse($products));
    }

    private function toResponse(array $products): array 
    {
        $responses = [];
        
        foreach($products as $product) {
            $responses[] = [
                "id" => $product->id(),
                "name" => $product->name(),
                "brand_id" => $product->brand_id(),
                "category_id" => $product->category_id(),
                "minimum_stock" => $product->minimum_stock(),
                //"deleted" => $product->isDeleted()
            ];
        }
        return $responses;
    }
}