<?php 

namespace Src\Service\Lot;

use Src\Entity\Lot\Lot;
use Src\Infrastructure\Repository\Lot\LotRepository;

final readonly class LotsSearcherExpiringSoonService {
    private LotRepository $repository;

    public function __construct() {
        $this->repository = new LotRepository();
    }

    /** @return Lot[] */
    public function searchExpiringSoon(): array
    {
        return $this->repository->searchExpiringSoon();
    }
}