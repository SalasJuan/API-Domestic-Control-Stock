<?php 

use Src\Service\Handler\PurchaseDetailDeleterHandler;

final readonly class PurchaseDetailDeleteController {
    private PurchaseDetailDeleterHandler $handler;

    public function __construct() {
        $this->handler = new PurchaseDetailDeleterHandler();
    }

    public function start(int $id): void 
    { 
        $this->handler->delete($id);
    }
}