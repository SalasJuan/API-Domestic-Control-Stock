<?php 

namespace Src\Service\Lot;
use DateTimeImmutable;
use Src\Entity\Lot\Lot;
use Src\Infrastructure\Repository\Lot\LotRepository;

final readonly class LotCreatorService {
    private LotRepository $repository;

    public function __construct() {
        $this->repository = new LotRepository();
    }

    public function create(int $purchase_detail_id, int $product_id, int $quantity, DateTimeImmutable $purchase_date, DateTimeImmutable $expiration_date): void
    {
    //Utiliza el Create de Entity, luego Insert (Sql) de Repository
        $lot = Lot::create($purchase_detail_id, $product_id, $quantity, $purchase_date, $expiration_date);
        $this->repository->insert($lot);
    }
}