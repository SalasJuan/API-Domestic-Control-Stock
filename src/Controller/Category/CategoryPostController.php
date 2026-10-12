<?php

use Src\Utils\ControllerUtils;
use Src\Service\Category\CategoryCreatorService;

final readonly class CategoryPostController {
    private CategoryCreatorService $service;

    public function __construct() {
        $this->service = new CategoryCreatorService();
    }

    public function start(): void
    { 
        $name = ControllerUtils::getPost("name");
        $description = ControllerUtils::getPost("description");

        $this->service->create($name, $description);
    }
}