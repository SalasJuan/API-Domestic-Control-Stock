<?php

namespace Src\Service\PurchaseDetail;

use Src\Entity\PurchaseDetail\PurchaseDetail;
use Src\Entity\PurchaseDetail\Exception\PurchaseDetailNotFoundException;
use Src\Infrastructure\Repository\PurchaseDetail\PurchaseDetailRepository;

final readonly class PurchaseDetailRestoreService
{
    private PurchaseDetailRepository $repository;

    public function __construct()
    {
        $this->repository = new PurchaseDetailRepository();
    }

    public function restore(int $id): PurchaseDetail
    {
        $purchaseDetail = $this->repository->findDeleted($id);

        if ($purchaseDetail === null) {
            throw new PurchaseDetailNotFoundException($id);
        }

        $purchaseDetail->restore();

        $this->repository->update($purchaseDetail);

        return $purchaseDetail;
    }
}