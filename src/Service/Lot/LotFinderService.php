<?php 

namespace Src\Service\Lot;

use Src\Entity\Lot\Lot;
use Src\Infrastructure\Repository\Lot\LotRepository;
use Src\Entity\Lot\Exception\LotNotFoundException;

final readonly class LotFinderService {

    private LotRepository $repository;

    public function __construct() {
        $this->repository = new LotRepository();
    }

    public function find(int $id): Lot 
    {   
        $lot = $this->repository->find($id);

        if ($lot === null) {
            throw new LotNotFoundException($id);
        }

        return $lot;
    }
}