<?php 

use Src\Service\PurchaseDetail\PurchaseDetailsSearcherService;

final readonly class PurchaseDetailsGetController {
    private PurchaseDetailsSearcherService $service;

    public function __construct() {
        $this->service = new PurchaseDetailsSearcherService();
    }

    public function start(): void
    {
        $purchaseDetails = $this->service->search();
        echo json_encode($this->toResponse($purchaseDetails));
    }

    private function toResponse(array $purchaseDetails): array 
    {
        $responses = [];
        
        foreach($purchaseDetails as $purchaseDetail) {
            $responses[] = [
                "id" => $purchaseDetail->id(),
                "purchase_id" => $purchaseDetail->purchase_id(),
                "product_id" => $purchaseDetail->product_id(),
                "quantity" => $purchaseDetail->quantity(),
                "unit_price" => $purchaseDetail->unit_price(),
                "subtotal" => $purchaseDetail->subtotal(),
                //"deleted" => $purchaseDetail->isDeleted()
            ];
        }
        return $responses;
    }
}