<?php 

namespace Src\Service\Category;

use Src\Entity\Category\Category;
use Src\Infrastructure\Repository\Category\CategoryRepository;

final readonly class CategoryCreatorService {
    private CategoryRepository $repository;

    public function __construct() {
        $this->repository = new CategoryRepository();
    }

    public function create(string $name, string $description): void
    {
    //Utiliza el Create de Entity, luego Insert (Sql) de Repository
        $category = Category::create($name, $description);
        //var_dump($category);
        $this->repository->insert($category);
    }
}