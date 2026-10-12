<?php 

use Src\Service\Lot\LotFinderService;

final readonly class LotGetController {

    private LotFinderService $service;

    public function __construct() {
        $this->service = new LotFinderService();
    }

    public function start(int $id): void
    {
        $lot = $this->service->find($id);
        echo json_encode([
            "id" => $lot->id(),
            "purchase_detail_id" => $lot->purchase_detail_id(),
            "product_id" => $lot->product_id(),
            "quantity" => $lot->quantity(),
            "purchase_date" => $lot->purchase_date()->format('Y-m-d'),
            "expiration_date" => $lot->expiration_date()->format('Y-m-d'),
            //"deleted" => $lot->isDeleted()
        ]);
    }
}