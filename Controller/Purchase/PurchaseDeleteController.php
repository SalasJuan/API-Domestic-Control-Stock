<?php 

use Src\Service\Purchase\PurchaseDeleterService;

final readonly class PurchaseDeleteController {
    private PurchaseDeleterService $service;

    public function __construct() {
        $this->service = new PurchaseDeleterService();
    }

    public function start(int $id): void
    {
        $this->service->delete($id);
    }
}