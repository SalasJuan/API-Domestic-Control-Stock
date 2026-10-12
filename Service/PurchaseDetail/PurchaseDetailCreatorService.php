<?php

namespace Src\Service\PurchaseDetail;

use Src\Entity\PurchaseDetail\PurchaseDetail;
use Src\Infrastructure\Repository\PurchaseDetail\PurchaseDetailRepository;

final readonly class PurchaseDetailCreatorService
{
    private PurchaseDetailRepository $repository;

    public function __construct() {
        $this->repository = new PurchaseDetailRepository();
    }

    public function create(PurchaseDetail $purchaseDetail): int
    {
        return $this->repository->insert($purchaseDetail);
    }
}