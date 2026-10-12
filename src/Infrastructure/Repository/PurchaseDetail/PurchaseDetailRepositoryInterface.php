<?php 

namespace Src\Infrastructure\Repository\PurchaseDetail;

use Src\Entity\PurchaseDetail\PurchaseDetail;

interface PurchaseDetailRepositoryInterface {

    public function find(int $id): ?PurchaseDetail;

    /** @return PurchaseDetail[] */
    public function search(): array;

    public function insert(PurchaseDetail $purchaseDetail): int;

    public function update(PurchaseDetail $purchaseDetail): void;

    public function searchByPurchase(int $purchase_id): array;

    public function findDeleted(int $id): ?PurchaseDetail;
}