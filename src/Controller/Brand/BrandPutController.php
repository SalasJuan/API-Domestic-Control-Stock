<?php 

use Src\Utils\ControllerUtils;
use Src\Service\Brand\BrandUpdaterService;

final readonly class BrandPutController {
    private BrandUpdaterService $service;

    public function __construct() {
        $this->service = new BrandUpdaterService();
    }

    public function start(int $id): void
    {
        $name = ControllerUtils::getPost("name");

        $this->service->update($name, $id);
    }
}