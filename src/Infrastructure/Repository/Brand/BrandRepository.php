<?php 

namespace Src\Infrastructure\Repository\Brand;

use Src\Infrastructure\PDO\PDOManager;
use Src\Entity\Brand\Brand;

final readonly class BrandRepository extends PDOManager implements BrandRepositoryInterface {
    public function find(int $id): ?Brand
    {
        $query = <<<FIND_BRAND
                        SELECT 
                        *
                        FROM
                        Brands B
                        WHERE
                            B.id = :id
                    FIND_BRAND;
        //Mantener Alineado el  'FIND_BRAND'
            $parameters = [
                "id" => $id
            ];

            $result = $this->execute($query, $parameters);

            return $this->toBrand($result[0] ?? null);
    }

    /** @return Brand[] */
    public function search(): array
    {
        $query = <<<SEARCH_BRAND
                        SELECT
                            *
                        FROM
                        Brands B
                        WHERE
                            B.deleted = 0
                    SEARCH_BRAND;
                //Revisar que los Nombres Coincidan con los de la BDD
        
        $results = $this->execute($query);

        $brands = [];
        foreach($results as $result) {
            $brands[] = $this->toBrand($result);
        }
        
        return $brands;
    }

    public function update(Brand $brand): void
    {
        $query = <<<UPDATE_BRAND
                    UPDATE
                        Brands
                    SET
                        name = :name,
                        deleted = :deleted
                    WHERE
                        id = :id
                    UPDATE_BRAND;
        
        $parameters = [
            "name" => $brand->name(),
            "deleted" => $brand->isDeleted(),
            "id" => $brand->id()
        ];
        $this->execute($query, $parameters);
    }


    public function insert(Brand $brand): void
    {
        $query = "INSERT INTO brands (name, deleted) VALUES (:name, :deleted) ";
        
        $parameters = [
            "name" => $brand->name(),
            "deleted" => $brand->isDeleted()
        ];
        $this->execute($query, $parameters);
    }

// Convierte Primitivos en 'Brand'
    private function toBrand(?array $primitive): ?Brand {
        if ($primitive === null) {
            return null;
        }

        return new Brand(
            $primitive["id"],
            $primitive["name"],
            $primitive["deleted"]
        );
    }
}