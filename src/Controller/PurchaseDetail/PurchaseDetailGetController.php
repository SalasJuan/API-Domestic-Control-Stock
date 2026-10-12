<?php 

use Src\Service\PurchaseDetail\PurchaseDetailFinderService;

final readonly class PurchaseDetailGetController {

    private PurchaseDetailFinderService $service;

    public function __construct() {
        $this->service = new PurchaseDetailFinderService();
    }

    public function start(int $id): void
    {
        $purchaseDetail = $this->service->find($id);
        echo json_encode([
            "purchase_id" => $purchaseDetail->purchase_id(),
            "product_id" => $purchaseDetail->product_id(),
            "quantity" => $purchaseDetail->quantity(),
            "unit_price" => $purchaseDetail->unit_price(),
            "subtotal" => $purchaseDetail->subtotal(),
        //  "deleted" => $purchaseDetail->isDeleted()
        ]);
    }
}