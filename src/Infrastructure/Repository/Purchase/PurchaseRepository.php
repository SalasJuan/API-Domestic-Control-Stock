<?php 

namespace Src\Infrastructure\Repository\Purchase;

use Src\Infrastructure\PDO\PDOManager;
use Src\Entity\Purchase\Purchase;
use DateTimeImmutable;

final readonly class PurchaseRepository extends PDOManager implements PurchaseRepositoryInterface {
    public function find(int $id): ?Purchase
    {
        $query = <<<FIND_PURCHASE
                        SELECT 
                        *
                        FROM
                        Purchases P
                        WHERE
                            P.id = :id
                        AND
                        P.deleted = 0
                    FIND_PURCHASE;
    // Query en Multiples Lineas
        //Mantener Alineado el  'FIND_PRODUCT'
            $parameters = [
                "id" => $id
            ];

            $result = $this->execute($query, $parameters);

            return $this->toPurchase($result[0] ?? null);
    }

    /** @return Purchase[] */
    public function search(): array
    {
        $query = <<<SEARCH_PURCHASE
                        SELECT
                            *
                        FROM
                        Purchases P
                        WHERE
                        P.deleted = 0
                    SEARCH_PURCHASE;
                        //Revisar que los Nombres Coincidan con los de la BDD
        
        $results = $this->execute($query);

        $purchases = [];
        foreach($results as $result) {
            $purchases[] = $this->toPurchase($result);
        }
        
        return $purchases;
    }

    public function update(Purchase $purchase): void
    {
        $query = <<<UPDATE_PURCHASE
                    UPDATE
                        Purchases
                    SET
                        date = :date,
                        store = :store,
                        total = :total,
                        deleted = :deleted
                    WHERE
                        id = :id
                    UPDATE_PURCHASE;
        
        $parameters = [
            "date" => $purchase->date()->format('Y-m-d'),
            "store" => $purchase->store(),
            "total" => $purchase->total(),
            "deleted" => $purchase->isDeleted(),
            "id" => $purchase->id()
        ];
        $this->execute($query, $parameters);
    }


    public function insert(Purchase $purchase): int
    {
        $query = "INSERT INTO Purchases (date, store, total, deleted) VALUES (:date, :store, :total, :deleted) ";
        
        $parameters = [
            "date" => $purchase->date()->format('Y-m-d'),
            "store" => $purchase->store(),
            "total" => $purchase->total(),
            "deleted" => $purchase->isDeleted()
        ];
        $this->execute($query, $parameters);
        
        return (int) $this->lastInsertId();
    }

// Convierte Primitivos en 'Purchase'
    private function toPurchase(?array $primitive): ?Purchase {
        if ($primitive === null) {
            return null;
        }

        return new Purchase(
            $primitive["id"],
            new DateTimeImmutable($primitive["date"]),
            $primitive["store"],
            $primitive["total"],
            $primitive["deleted"]
        );
    }
}