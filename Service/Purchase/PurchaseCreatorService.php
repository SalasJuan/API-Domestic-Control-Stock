<?php 

namespace Src\Service\Purchase;
use DateTimeImmutable;
use Src\Entity\Purchase\Purchase;
use Src\Infrastructure\Repository\Purchase\PurchaseRepository;

final readonly class PurchaseCreatorService {
    private PurchaseRepository $repository;

    public function __construct() {
        $this->repository = new PurchaseRepository();
    }

    public function create(DateTimeImmutable $date, string $store, string $total): int
    {
    //Utiliza el Create de Entity, luego Insert (Sql) de Repository
        $purchase = Purchase::create($date, $store, $total);
        return $this->repository->insert($purchase);
    }
}