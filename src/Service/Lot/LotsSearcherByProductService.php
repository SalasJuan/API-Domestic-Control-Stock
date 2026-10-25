<?php

namespace Src\Service\Lot;

use Src\Entity\Lot\Lot;
use Src\Entity\Lot\Exception\LotNotFoundException;
use Src\Infrastructure\Repository\Lot\LotRepository;

final readonly class LotsSearcherByProductService
{
    private LotRepository $repository;

    public function __construct()
    {
        $this->repository = new LotRepository();
    }

    /** @return Lot[] */
    public function searchByProduct(int $product_id): array
    {
        return $this->repository->searchByProduct($product_id);
    }
}