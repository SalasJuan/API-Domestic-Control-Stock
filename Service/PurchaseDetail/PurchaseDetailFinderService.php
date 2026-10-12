<?php 

namespace Src\Service\PurchaseDetail;

use Src\Entity\PurchaseDetail\PurchaseDetail;
use Src\Infrastructure\Repository\PurchaseDetail\PurchaseDetailRepository;
use Src\Entity\PurchaseDetail\Exception\PurchaseDetailNotFoundException;

final readonly class PurchaseDetailFinderService {

    private PurchaseDetailRepository $repository;

    public function __construct() {
        $this->repository = new PurchaseDetailRepository();
    }

    public function find(int $id): PurchaseDetail 
    {   
        $purchaseDetail = $this->repository->find($id);

        if ($purchaseDetail === null) {
            throw new PurchaseDetailNotFoundException($id);
        }

        return $purchaseDetail;
    }
}