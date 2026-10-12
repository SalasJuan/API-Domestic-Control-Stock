<?php 

namespace Src\Service\Brand;

use Src\Infrastructure\Repository\Brand\BrandRepository;

final readonly class BrandDeleterService {
    private BrandRepository $repository;
    private BrandFinderService $finder;

    public function __construct() {
        $this->repository = new BrandRepository();
        $this->finder = new BrandFinderService();
    }

    public function delete(int $id): void
    {
        $brand = $this->finder->find($id);

        $brand->delete();
        //Utiliza el Borrado Logico de la Entidad
        $this->repository->update($brand);
    } 
}