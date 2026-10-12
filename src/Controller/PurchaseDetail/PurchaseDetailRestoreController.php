<?php

use Src\Service\Handler\PurchaseDetailRestoreHandler;

final readonly class PurchaseDetailRestoreController
{
    private PurchaseDetailRestoreHandler $handler;

    public function __construct()
    {
        $this->handler = new PurchaseDetailRestoreHandler();
    }

    public function start(int $id): void
    {
        $this->handler->restore($id);
    }
}