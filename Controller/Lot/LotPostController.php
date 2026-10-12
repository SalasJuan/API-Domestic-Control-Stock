<?php

use Src\Utils\ControllerUtils;
use Src\Service\Lot\LotCreatorService;

final readonly class LotPostController {
    private LotCreatorService $service;

    public function __construct() {
        $this->service = new LotCreatorService();
    }

    public function start(): void
    { 
        $purchase_detail_id = ControllerUtils::getPost("purchase_detail_id");
        $product_id = ControllerUtils::getPost("product_id");
        $quantity = ControllerUtils::getPost("quantity");
        $purchase_date = new DateTimeImmutable(ControllerUtils::getPost("purchase_date"));
        $expiration_date = new DateTimeImmutable(ControllerUtils::getPost("expiration_date"));

        $this->service->create($purchase_detail_id, $product_id, $quantity, $purchase_date, $expiration_date);
    }
}