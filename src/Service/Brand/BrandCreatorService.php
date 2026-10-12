<?php 

namespace Src\Service\Brand;

use Src\Entity\Brand\Brand;
use Src\Infrastructure\Repository\Brand\BrandRepository;

final readonly class BrandCreatorService {
    private BrandRepository $repository;

    public function __construct() {
        $this->repository = new BrandRepository();
    }

    public function create(string $name): void
    {
    //Utiliza el Create de Entity, luego Insert (Sql) de Repository
        $brand = Brand::create($name);
        //var_dump($brand);
        $this->repository->insert($brand);
    }
}