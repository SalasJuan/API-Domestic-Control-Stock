<?php 

use Src\Service\Lot\LotsSearcherExpiredService;

final readonly class LotsGetExpiredController {
    private LotsSearcherExpiredService $service;

    public function __construct() {
        $this->service = new LotsSearcherExpiredService();
    }

    public function start(): void
    {
        $lots = $this->service->searchExpired();
        echo json_encode($this->toResponse($lots));
    }

    private function toResponse(array $lots): array 
    {
        $responses = [];
        
        foreach($lots as $lot) {
            $responses[] = [
                "id" => $lot->id(),
                "purchase_detail_id" => $lot->purchase_detail_id(),
                "product_id" => $lot->product_id(),
                "quantity" => $lot->quantity(),
                "purchase_date" => $lot->purchase_date()->format('Y-m-d'),
                "expiration_date" => $lot->expiration_date()->format('Y-m-d'),
                //"deleted" => $lot->isDeleted()
            ];
        }
        return $responses;
    }
}