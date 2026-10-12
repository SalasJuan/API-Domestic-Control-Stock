<?php 

namespace Src\Infrastructure\Repository\Category;

use Src\Infrastructure\PDO\PDOManager;
use Src\Entity\Category\Category;

final readonly class CategoryRepository extends PDOManager implements CategoryRepositoryInterface {
    public function find(int $id): ?Category
    {
        $query = <<<FIND_CATEGORY
                        SELECT 
                        *
                        FROM
                        Categories C
                        WHERE
                            C.id = :id
                    FIND_CATEGORY;
    // Query en Multiples Lineas
        //Mantener Alineado el  'FIND_CATEGORY'
            $parameters = [
                "id" => $id
            ];

            $result = $this->execute($query, $parameters);

            return $this->toCategory($result[0] ?? null);
    }

    /** @return Category[] */
    public function search(): array
    {
        $query = <<<SEARCH_CATEGORY
                        SELECT
                            *
                        FROM
                        Categories C
                        WHERE
                            C.deleted = 0
                        SEARCH_CATEGORY;
                        //Revisar que los Nombres Coincidan con los de la BDD
        
        $results = $this->execute($query);

        $categories = [];
        foreach($results as $result) {
            $categories[] = $this->toCategory($result);
        }
        
        return $categories;
    }

    public function update(Category $category): void
    {
        $query = <<<UPDATE_CATEGORY
                    UPDATE
                        Categories
                    SET
                        name = :name,
                        description = :description,
                        deleted = :deleted
                    WHERE
                        id = :id
                    UPDATE_CATEGORY;
        
        $parameters = [
            "name" => $category->name(),
            "description" => $category->description(),
            "deleted" => $category->isDeleted(),
            "id" => $category->id()
        ];
        $this->execute($query, $parameters);
    }


    public function insert(Category $category): void
    {
        $query = "INSERT INTO categories (name, description, deleted) VALUES (:name, :description, :deleted) ";
        
        $parameters = [
            "name" => $category->name(),
            "description" => $category->description(),
            "deleted" => $category->isDeleted()
        ];
        $this->execute($query, $parameters);
    }

// Convierte Primitivos en 'Category'
    private function toCategory(?array $primitive): ?Category {
        if ($primitive === null) {
            return null;
        }

        return new Category(
            $primitive["id"],
            $primitive["name"],
            $primitive["description"],
            $primitive["deleted"]
        );
    }
}