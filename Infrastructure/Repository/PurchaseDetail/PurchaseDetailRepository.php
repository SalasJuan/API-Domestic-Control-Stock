<?php 

namespace Src\Infrastructure\Repository\PurchaseDetail;

use Src\Infrastructure\PDO\PDOManager;
use Src\Entity\PurchaseDetail\PurchaseDetail;


final readonly class PurchaseDetailRepository extends PDOManager implements PurchaseDetailRepositoryInterface {
    public function find(int $id): ?PurchaseDetail
    {
        $query = <<<FIND_PURCHASE_DETAIL
                        SELECT 
                        *
                        FROM
                        Purchase_Details PD
                        WHERE
                            PD.id = :id
                        AND
                        PD.deleted = 0
                    FIND_PURCHASE_DETAIL;
        //Mantener Alineado 
            $parameters = [
                "id" => $id
            ];

            $result = $this->execute($query, $parameters);

            return $this->toPurchaseDetail($result[0] ?? null);
    }

    /** @return PurchaseDetail[] */
    public function search(): array
    {
        $query = <<<SEARCH_PURCHASE_DETAILS
                        SELECT
                        *
                        FROM
                        Purchase_Details PD
                        WHERE
                        PD.deleted = 0
                    SEARCH_PURCHASE_DETAILS;
                        //Revisar que los Nombres Coincidan con los de la BDD
        
        $results = $this->execute($query);

        $purchaseDetails = [];
        foreach($results as $result) {
            $purchaseDetails[] = $this->toPurchaseDetail($result);
        }
        
        return $purchaseDetails;
    }

    public function update(PurchaseDetail $purchaseDetail): void
    {
        $query = <<<UPDATE_PURCHASE_DETAIL
                    UPDATE
                        Purchase_Details
                    SET
                        purchase_id = :purchase_id,
                        product_id = :product_id,
                        quantity = :quantity,
                        subtotal = :subtotal,
                        unit_price = :unit_price,
                        deleted = :deleted
                    WHERE
                        id = :id
                    UPDATE_PURCHASE_DETAIL;
        
        $parameters = [
            "purchase_id" => $purchaseDetail->purchase_id(),
            "product_id" => $purchaseDetail->product_id(),
            "quantity" => $purchaseDetail->quantity(),
            "subtotal" => $purchaseDetail->subtotal(),
            "unit_price" => $purchaseDetail->unit_price(),
            "deleted" => $purchaseDetail->isDeleted(),
            "id" => $purchaseDetail->id()
        ];
        $this->execute($query, $parameters);
    }

    public function searchByPurchase(int $purchase_id): array
    {
        $query = <<<SEARCH_PURCHASE_DETAILS
                        SELECT
                        *
                        FROM
                            Purchase_Details PD
                        WHERE
                            PD.purchase_id = :purchase_id
                        AND
                            PD.deleted = 0
                    SEARCH_PURCHASE_DETAILS;

        $parameters = [
            "purchase_id" => $purchase_id
        ];

        $results = $this->execute($query, $parameters);

        $purchaseDetails = [];

        foreach ($results as $result) {
            $purchaseDetails[] = $this->toPurchaseDetail($result);
        }

        return $purchaseDetails;
    }

    public function findDeleted(int $id): ?PurchaseDetail
    {
        $query = <<<FIND_DELETED_PURCHASE_DETAIL
                        SELECT
                            *
                        FROM
                            Purchase_Details PD
                        WHERE
                            PD.id = :id
                        AND
                            PD.deleted = 1
                    FIND_DELETED_PURCHASE_DETAIL;

        $parameters = [
            "id" => $id
        ];

        $result = $this->execute($query, $parameters);

        return $this->toPurchaseDetail($result[0] ?? null);
    }

    public function insert(PurchaseDetail $purchaseDetail): int
    {
        $query = "INSERT INTO Purchase_Details (purchase_id, product_id, quantity, unit_price, subtotal, deleted) VALUES (:purchase_id, :product_id, :quantity, :unit_price, :subtotal, :deleted) ";
        
        $parameters = [
            "purchase_id" => $purchaseDetail->purchase_id(),
            "product_id" => $purchaseDetail->product_id(),
            "quantity" => $purchaseDetail->quantity(),
            "unit_price" => $purchaseDetail->unit_price(),
            "subtotal" => $purchaseDetail->subtotal(),
            "deleted" => $purchaseDetail->isDeleted()
        ];
        $this->execute($query, $parameters);
        
        return (int) $this->lastInsertId();
    }

// Convierte Primitivos en 'PurchaseDetail'
    private function toPurchaseDetail(?array $primitive): ?PurchaseDetail {
        if ($primitive === null) {
            return null;
        }

        return new PurchaseDetail(
            $primitive["id"],
            $primitive["purchase_id"],
            $primitive["product_id"],
            $primitive["quantity"],
            $primitive["unit_price"],
            $primitive["subtotal"],
            $primitive["deleted"]
        );
    }
}