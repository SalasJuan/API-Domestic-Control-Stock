<?php 

namespace Src\Infrastructure\Repository\Purchase;

use Src\Entity\Purchase\Purchase;

interface PurchaseRepositoryInterface {

    public function find(int $id): ?Purchase;

    /** @return Purchase[] */
    public function search(): array;

    public function insert(Purchase $purchase): int;

    public function update(Purchase $purchase): void;

}