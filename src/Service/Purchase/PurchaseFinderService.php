<?php 

namespace Src\Service\Purchase;

use Src\Entity\Purchase\Purchase;
use Src\Infrastructure\Repository\Purchase\PurchaseRepository;
use Src\Entity\Purchase\Exception\PurchaseNotFoundException;

final readonly class PurchaseFinderService {

    private PurchaseRepository $repository;

    public function __construct() {
        $this->repository = new PurchaseRepository();
    }

    public function find(int $id): Purchase 
    {   
        $purchase = $this->repository->find($id);

        if ($purchase === null) {
            throw new PurchaseNotFoundException($id);
        }

        return $purchase;
    }
}