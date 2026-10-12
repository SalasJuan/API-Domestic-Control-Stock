<?php 

namespace Src\Service\Brand;

use Src\Entity\Brand\Brand;
use Src\Infrastructure\Repository\Brand\BrandRepository;

final readonly class BrandUpdaterService {
    private BrandRepository $repository;
    private BrandFinderService $finder;

    public function __construct() {
        $this->repository = new BrandRepository();
        $this->finder = new BrandFinderService();
    }

    public function update(string $name, int $id): void
    {
        $brand = $this->finder->find($id);

        $brand->modify($name);

        $this->repository->update($brand);
    }
}