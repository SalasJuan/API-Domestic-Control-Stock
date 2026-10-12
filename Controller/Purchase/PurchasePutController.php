<?php 

use Src\Utils\ControllerUtils;
use Src\Service\Purchase\PurchaseUpdaterService;

final readonly class PurchasePutController {
    private PurchaseUpdaterService $service;

    public function __construct() {
        $this->service = new PurchaseUpdaterService();
    }

    public function start(int $id): void
    {
        $date = new DateTimeImmutable(ControllerUtils::getPost("date"));
        $store = ControllerUtils::getPost("store");
        $total = ControllerUtils::getPost("total");

        $this->service->update($date, $store, $total, $id);
    }
}