<?php 

namespace Src\Infrastructure\Repository\Lot;

use Src\Entity\Lot\Lot;

interface LotRepositoryInterface {

    public function find(int $id): ?Lot;

    /** @return Lot[] */
    public function search(): array;

    public function insert(Lot $lot): void;

    public function update(Lot $lot): void;

    public function findByPurchaseDetail(int $purchase_detail_id): ?Lot;

    public function findDeletedByPurchaseDetail(int $purchase_detail_id): ?Lot;
}