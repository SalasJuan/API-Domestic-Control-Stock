<?php 

use Src\Service\Lot\LotDeleterService;

final readonly class LotDeleteController {
    private LotDeleterService $service;

    public function __construct() {
        $this->service = new LotDeleterService();
    }

    public function start(int $id): void
    {
        $this->service->delete($id);
    }
}