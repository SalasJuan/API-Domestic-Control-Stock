<?php 

namespace Src\Infrastructure\Repository\Lot;

use Src\Infrastructure\PDO\PDOManager;
use Src\Entity\Lot\Lot;
use DateTimeImmutable;

final readonly class LotRepository extends PDOManager implements LotRepositoryInterface {
    public function find(int $id): ?Lot
    {
        $query = <<<FIND_LOT
                        SELECT 
                        *
                        FROM
                        Lots L
                        WHERE
                            L.id = :id
                        AND
                        L.deleted = 0
                    FIND_LOT;
    // Query en Multiples Lineas
        //Mantener Alineado el  'FIND_LOT'
            $parameters = [
                "id" => $id
            ];

            $result = $this->execute($query, $parameters);

            return $this->toLot($result[0] ?? null);
    }

    /** @return Lot[] */
    public function search(): array
    {
        $query = <<<SEARCH_LOT
                        SELECT
                            *
                        FROM
                        Lots L
                        WHERE
                        L.deleted = 0
                    SEARCH_LOT;
                        //Revisar que los Nombres Coincidan con los de la BDD
        
        $results = $this->execute($query);

        $lots = [];
        foreach($results as $result) {
            $lots[] = $this->toLot($result);
        }
        
        return $lots;
    }

    public function update(Lot $lot): void
    {
        $query = <<<UPDATE_LOT
                    UPDATE
                        Lots
                    SET
                        purchase_detail_id = :purchase_detail_id,
                        product_id = :product_id,
                        quantity = :quantity,
                        purchase_date = :purchase_date,
                        expiration_date = :expiration_date,
                        deleted = :deleted
                    WHERE
                        id = :id
                    UPDATE_LOT;
        
        $parameters = [
            "purchase_detail_id" => $lot->purchase_detail_id(),
            "product_id" => $lot->product_id(),
            "quantity" => $lot->quantity(),
            "purchase_date" => $lot->purchase_date()->format('Y-m-d'),
            "expiration_date" => $lot->expiration_date()->format('Y-m-d'),
            "deleted" => $lot->isDeleted(),
            "id" => $lot->id()
        ];
        $this->execute($query, $parameters);
    }

    public function findByPurchaseDetail(int $purchase_detail_id): ?Lot
    {
        $query = <<<FIND_LOT_BY_PURCHASE_DETAIL
                        SELECT
                            *
                        FROM
                            Lots L
                        WHERE
                            L.purchase_detail_id = :purchase_detail_id
                        AND
                            L.deleted = 0
                    FIND_LOT_BY_PURCHASE_DETAIL;

        $parameters = [
            "purchase_detail_id" => $purchase_detail_id
        ];

        $result = $this->execute($query, $parameters);

        return $this->toLot($result[0] ?? null);
    }



    public function findDeletedByPurchaseDetail(int $purchase_detail_id): ?Lot
    {
        $query = <<<FIND_DELETED_LOT_BY_PURCHASE_DETAIL
                        SELECT
                            *
                        FROM
                            Lots L
                        WHERE
                            L.purchase_detail_id = :purchase_detail_id
                        AND
                            L.deleted = 1
                    FIND_DELETED_LOT_BY_PURCHASE_DETAIL;

        $parameters = [
            "purchase_detail_id" => $purchase_detail_id
        ];

        $result = $this->execute($query, $parameters);

        return $this->toLot($result[0] ?? null);
    }

    public function insert(Lot $lot): void
    {
        $query = "INSERT INTO Lots (purchase_detail_id, product_id, quantity, purchase_date, expiration_date, deleted) VALUES (:purchase_detail_id, :product_id, :quantity, :purchase_date, :expiration_date, :deleted) ";
        
        $parameters = [
            "purchase_detail_id" => $lot->purchase_detail_id(),
            "product_id" => $lot->product_id(),
            "quantity" => $lot->quantity(),
            "purchase_date" => $lot->purchase_date()->format('Y-m-d'),
            "expiration_date" => $lot->expiration_date()->format('Y-m-d'),
            "deleted" => $lot->isDeleted(),
        ];
        $this->execute($query, $parameters);
    }

// Colocar PurchaseDetailId en 2da Columna de la BDD
    private function toLot(?array $primitive): ?Lot {
        if ($primitive === null) {
            return null;
        }

        return new Lot(
            $primitive["id"],
            $primitive["purchase_detail_id"],
            $primitive["product_id"],
            $primitive["quantity"],
            new DateTimeImmutable($primitive["purchase_date"]),
            new DateTimeImmutable($primitive["expiration_date"]),
            $primitive["deleted"]
        );
    }
}