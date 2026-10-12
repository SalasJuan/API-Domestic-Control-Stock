<?php

use Src\Service\Handler\PurchaseDetailUpdaterHandler;
use Src\Utils\ControllerUtils;

final readonly class PurchaseDetailPutController
{
    private PurchaseDetailUpdaterHandler $handler;

    public function __construct()
    {
        $this->handler = new PurchaseDetailUpdaterHandler();
    }

    public function start(int $id): void
    {
        $product_id = (int) ControllerUtils::getPost("product_id");
        $quantity = (int) ControllerUtils::getPost("quantity");
        $unit_price = ControllerUtils::getPost("unit_price");

        $this->handler->update(
            $id,
            $product_id,
            $quantity,
            $unit_price
        );
    }
}