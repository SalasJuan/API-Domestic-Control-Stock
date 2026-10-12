<?php 

namespace Src\Service\Lot;

use Src\Infrastructure\Repository\Lot\LotRepository;

final readonly class LotDeleterService {
    private LotRepository $repository;
    private LotFinderService $finder;

    public function __construct() {
        $this->repository = new LotRepository();
        $this->finder = new LotFinderService();
    }

    public function delete(int $id): void
    {
        $lot = $this->finder->find($id);

        $lot->delete();
        //Utiliza el Borrado Logico de la Entidad
        $this->repository->update($lot);
    } 
}