<?php 

namespace Src\Service\Product;

use Src\Infrastructure\Repository\Product\ProductRepository;

final readonly class ProductDeleterService {
    private ProductRepository $repository;
    private ProductFinderService $finder;

    public function __construct() {
        $this->repository = new ProductRepository();
        $this->finder = new ProductFinderService();
    }

    public function delete(int $id): void
    {
        $product = $this->finder->find($id);

        $product->delete();
        //Utiliza el Borrado Logico de la Entidad
        $this->repository->update($product);
    } 
}