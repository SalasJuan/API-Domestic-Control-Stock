<?php 

use Src\Service\Product\ProductsSearcherStockAlertService;

final readonly class ProductsGetStockAlertController {
    private ProductsSearcherStockAlertService $service;

    public function __construct() {
        $this->service = new ProductsSearcherStockAlertService();
    }

    public function start(): void
    {
        $products = $this->service->searchStockAlert();
        echo json_encode($this->toResponse($products));
    }

    private function toResponse(array $products): array
    {
        $responses = [];

        foreach ($products as $product) {
            $responses[] = [
                "id" => (int) $product["id"],
                "name" => $product["name"],
                "minimum_stock" => (int) $product["minimum_stock"],
                "available_stock" => (int) $product["available_stock"],
                "stock_status" => $product["stock_status"]
            ];
        }
        return $responses;
    }
}