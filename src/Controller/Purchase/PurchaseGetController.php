<?php 

use Src\Service\Purchase\PurchaseFinderService;

final readonly class PurchaseGetController {

    private PurchaseFinderService $service;

    public function __construct() {
        $this->service = new PurchaseFinderService();
    }

    public function start(int $id): void
    {
        $purchase = $this->service->find($id);
        echo json_encode([
            "id" => $purchase->id(),
            "date" => $purchase->date()->format('Y-m-d'),
            "store" => $purchase->store(),
            "total" => $purchase->total(),
        //  "deleted" => $product->isDeleted()
        ]);
    }
}