<?php 

namespace Src\Service\Lot;

use Src\Entity\Lot\Lot;
use Src\Infrastructure\Repository\Lot\LotRepository;

final readonly class LotsSearcherService {
    private LotRepository $repository;

    public function __construct() {
        $this->repository = new LotRepository();
    }

    /** @return Lot[] */
    public function search(): array
    {
        return $this->repository->search();
    }
}