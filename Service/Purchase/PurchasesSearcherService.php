<?php 

namespace Src\Service\Purchase;

use Src\Entity\Purchase\Purchase;
use Src\Infrastructure\Repository\Purchase\PurchaseRepository;

final readonly class PurchasesSearcherService {
    private PurchaseRepository $repository;

    public function __construct() {
        $this->repository = new PurchaseRepository();
    }

    /** @return Purchase[] */
    public function search(): array
    {
        return $this->repository->search();
    }
}