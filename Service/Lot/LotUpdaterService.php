<?php 

namespace Src\Service\Lot;

use Src\Entity\Lot\Lot;
use Src\Infrastructure\Repository\Lot\LotRepository;
use DateTimeImmutable;

final readonly class LotUpdaterService {
    private LotRepository $repository;
    private LotFinderService $finder;

    public function __construct() {
        $this->repository = new LotRepository();
        $this->finder = new LotFinderService();
    }

    public function update(int $purchase_detail_id, int $product_id, int $quantity, DateTimeImmutable $purchase_date, DateTimeImmutable $expiration_date, int $id): void
    {
        $lot = $this->finder->find($id);

        $lot->modify($purchase_detail_id, $product_id, $quantity, $purchase_date, $expiration_date);

        $this->repository->update($lot);
    }
}