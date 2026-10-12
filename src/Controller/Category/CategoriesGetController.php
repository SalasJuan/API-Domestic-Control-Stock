<?php 

use Src\Service\Category\CategoriesSearcherService;

final readonly class CategoriesGetController {
    private CategoriesSearcherService $service;

    public function __construct() {
        $this->service = new CategoriesSearcherService();
    }

    public function start(): void
    {
    // Revision de Funcionamiento de Controller
    //       echo "Hello from CategoriesGetController";
    //            die;
        $products = $this->service->search();
        echo json_encode($this->toResponse($products));
    }

    private function toResponse(array $products): array 
    {
        $responses = [];
        
        foreach($products as $product) {
            $responses[] = [
                "id" => $product->id(),
                "name" => $product->name(),
                "description" => $product->description(),
                //"deleted" => $product->isDeleted()
            ];
        }
        return $responses;
    }
}