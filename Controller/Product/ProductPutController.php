<?php 

use Src\Utils\ControllerUtils;
use Src\Service\Product\ProductUpdaterService;

final readonly class ProductPutController {
    private ProductUpdaterService $service;

    public function __construct() {
        $this->service = new ProductUpdaterService();
    }

    public function start(int $id): void
    {
        $name = ControllerUtils::getPost("name");
        $brand_id = ControllerUtils::getPost("brand_id");
        $category_id = ControllerUtils::getPost("category_id");
        $minimum_stock = ControllerUtils::getPost("minimum_stock");

        $this->service->update($name, $brand_id, $category_id, $minimum_stock, $id);
    }
}