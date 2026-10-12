<?php

namespace Src\Service\PurchaseDetail;

use Src\Entity\PurchaseDetail\PurchaseDetail;
use Src\Entity\PurchaseDetail\Exception\PurchaseDetailNotFoundException;
use Src\Infrastructure\Repository\PurchaseDetail\PurchaseDetailRepository;

final readonly class PurchaseDetailUpdaterService
{
    private PurchaseDetailRepository $repository;

    public function __construct()
    {
        $this->repository = new PurchaseDetailRepository();
    }

    public function update(int $product_id, int $quantity, string $unit_price, int $id): PurchaseDetail
    {
        $purchaseDetail = $this->repository->find($id);

        if ($purchaseDetail === null) {
            throw new PurchaseDetailNotFoundException($id);
        }

        $purchaseDetail->modify(
            $product_id,
            $quantity,
            $unit_price
        );

        $this->repository->update($purchaseDetail);

        return $purchaseDetail;
    }
}