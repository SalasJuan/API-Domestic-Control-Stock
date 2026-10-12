<?php 

namespace Src\Service\Purchase;

use Src\Infrastructure\Repository\Purchase\PurchaseRepository;

final readonly class PurchaseDeleterService {
    private PurchaseRepository $repository;
    private PurchaseFinderService $finder;

    public function __construct() {
        $this->repository = new PurchaseRepository();
        $this->finder = new PurchaseFinderService();
    }

    public function delete(int $id): void
    {
        $product = $this->finder->find($id);

        $product->delete();
        //Utiliza el Borrado Logico de la Entidad
        $this->repository->update($product);
    } 
}