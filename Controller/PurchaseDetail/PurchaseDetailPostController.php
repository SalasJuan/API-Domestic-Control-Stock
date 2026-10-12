<?php
use Src\Utils\ControllerUtils;
use Src\Service\PurchaseDetail\PurchaseDetailCreatorService;

final readonly class PurchaseDetailPostController {
    private PurchaseDetailCreatorService $service;

    public function __construct() {
        $this->service = new PurchaseDetailCreatorService();
    }

    public function start(): void
    { 
        $purchase_id = ControllerUtils::getPost("purchase_id");
        $product_id = ControllerUtils::getPost("product_id");
        $quantity = ControllerUtils::getPost("quantity");
        $unit_price = ControllerUtils::getPost("unit_price");
        $this->service->create($purchase_id, $product_id, $quantity, $unit_price);
    }
}