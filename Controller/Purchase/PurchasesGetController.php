<?php 

use Src\Service\Purchase\PurchasesSearcherService;

final readonly class PurchasesGetController {
    private PurchasesSearcherService $service;

    public function __construct() {
        $this->service = new PurchasesSearcherService();
    }

    public function start(): void
    {
        $purchases = $this->service->search();
        echo json_encode($this->toResponse($purchases));
    }

    private function toResponse(array $purchases): array 
    {
        $responses = [];
        
        foreach($purchases as $purchase) {
            $responses[] = [
                "id" => $purchase->id(),
                "date" => $purchase->date()->format('Y-m-d'),
                "store" => $purchase->store(),
                "total" => $purchase->total(),
                //"deleted" => $purchase->isDeleted()
            ];
        }
        return $responses;
    }
}