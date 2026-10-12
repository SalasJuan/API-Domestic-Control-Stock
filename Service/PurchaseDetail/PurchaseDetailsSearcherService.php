<?php 

namespace Src\Service\PurchaseDetail;

use Src\Entity\PurchaseDetail\PurchaseDetail;
use Src\Infrastructure\Repository\PurchaseDetail\PurchaseDetailRepository;

final readonly class PurchaseDetailsSearcherService {
    private PurchaseDetailRepository $repository;

    public function __construct() {
        $this->repository = new PurchaseDetailRepository();
    }

    /** @return PurchaseDetail[] */
    public function search(): array
    {
        return $this->repository->search();
    }
}