<?php

use Src\Utils\ControllerUtils;
use Src\Service\Product\ProductCreatorService;

final readonly class ProductPostController {
    private ProductCreatorService $service;

    public function __construct() {
        $this->service = new ProductCreatorService();
    }

    public function start(): void
    { 
        $name = ControllerUtils::getPost("name");
        $brand_id = ControllerUtils::getPost("brand_id");
        $category_id = ControllerUtils::getPost("category_id");
        $minimum_stock = ControllerUtils::getPost("minimum_stock");

        $this->service->create($name, $brand_id, $category_id, $minimum_stock);
    }
}