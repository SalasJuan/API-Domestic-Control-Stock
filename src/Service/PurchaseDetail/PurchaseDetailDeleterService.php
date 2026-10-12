<?php 

namespace Src\Service\PurchaseDetail;

use Src\Entity\PurchaseDetail\PurchaseDetail;
use Src\Infrastructure\Repository\PurchaseDetail\PurchaseDetailRepository;

final readonly class PurchaseDetailDeleterService {
    private PurchaseDetailRepository $repository;
    private PurchaseDetailFinderService $finder;

    public function __construct() {
        $this->repository = new PurchaseDetailRepository();
        $this->finder = new PurchaseDetailFinderService();
    }

    public function delete(int $id): PurchaseDetail
    {
        $purchaseDetail = $this->finder->find($id);

        $purchaseDetail->delete();
        //Utiliza el Borrado Logico de la Entidad
        $this->repository->update($purchaseDetail);
        
        return $purchaseDetail;
    } 
}