<?php

use Src\Utils\ControllerUtils;
use Src\Service\Handler\PurchaseCreatorHandler;

final readonly class PurchasePostController
{
    private PurchaseCreatorHandler $handler;

    public function __construct()
    {
        $this->handler = new PurchaseCreatorHandler();
    }

    public function start(): void
    {
        $date = new DateTimeImmutable(
            ControllerUtils::getPost("date")
        );

        $store = ControllerUtils::getPost("store");

        $details = ControllerUtils::getPost("details");

        $this->handler->create(
            $date,
            $store,
            $details
        );
    }
}