<?php 

namespace Src\Service\Purchase;

use Src\Entity\Purchase\Purchase;
use Src\Infrastructure\Repository\Purchase\PurchaseRepository;
use DateTimeImmutable;

final readonly class PurchaseUpdaterService {
    private PurchaseRepository $repository;
    private PurchaseFinderService $finder;

    public function __construct() {
        $this->repository = new PurchaseRepository();
        $this->finder = new PurchaseFinderService();
    }

    public function update(DateTimeImmutable $date, string $store, string $total, int $id): void
    {
        $purchase = $this->finder->find($id);

        $purchase->modify($date, $store, $total);

        $this->repository->update($purchase);
    }
}