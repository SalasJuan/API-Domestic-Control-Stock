<?php

namespace Src\Service\Handler;

use Throwable;
use RunTimeException;

use Src\Infrastructure\PDO\PDOManager;

use Src\Service\Purchase\PurchaseFinderService;
use Src\Service\PurchaseDetail\PurchaseDetailUpdaterService;

use Src\Infrastructure\Repository\Purchase\PurchaseRepository;
use Src\Infrastructure\Repository\PurchaseDetail\PurchaseDetailRepository;
use Src\Infrastructure\Repository\Lot\LotRepository;

final class PurchaseDetailUpdaterHandler
{
    private PDOManager $transactionManager;

    private PurchaseDetailUpdaterService $purchaseDetailUpdaterService;
    private PurchaseFinderService $purchaseFinderService;

    private PurchaseDetailRepository $purchaseDetailRepository;
    private PurchaseRepository $purchaseRepository;
    private LotRepository $lotRepository;


    public function __construct()
    {
        $this->purchaseDetailUpdaterService = new PurchaseDetailUpdaterService();

        $this->purchaseFinderService = new PurchaseFinderService();

        $this->purchaseDetailRepository = new PurchaseDetailRepository();

        $this->purchaseRepository = new PurchaseRepository();

        $this->lotRepository =  new LotRepository();

        $this->transactionManager = new PDOManager();
    }

    public function update(
        int $id,
        int $product_id,
        int $quantity,
        string $unit_price
    ): void {
        try {
            $this->transactionManager->beginTransaction();

        //1. Actualizar PurchaseDetail
            /*
            * El Service:
            * - busca el detalle
            * - ejecuta modify()
            * - recalcula subtotal
            * - persiste el detalle
            */
            $purchaseDetail =
                $this->purchaseDetailUpdaterService->update(
                    $product_id,
                    $quantity,
                    $unit_price,
                    $id
                );

        //2. Obtener la Purchase asociada
            $purchaseId = $purchaseDetail->purchase_id();

            if ($purchaseId === null) {
                throw new \RuntimeException(
                    "El PurchaseDetail no tiene una Purchase asociada."
                );
            }

            $purchase = $this->purchaseFinderService->find($purchaseId);

        //3. Buscar Lot asociado 
            $lot = $this->lotRepository ->findByPurchaseDetail($id);

            if ($lot === null){
                throw new RuntimeException( "El PurchaseDetail no tiene un Lot asociado." );
            }

        //4.  Sincronizar Product y Quantity de Lot
            $lot->updateProduct($product_id);
            $lot->updateQuantity($quantity);
            $this->lotRepository->update($lot);

        //5. Obtener todos los Details[]-> de la PurchaseAsociada
            $purchaseDetails =
                $this->purchaseDetailRepository->searchByPurchase($purchaseId);

        //6. Recalcular el total
            $total = "0.00";

            foreach ($purchaseDetails as $detail) {
                $total = bcadd(
                    $total,
                    $detail->subtotal(),
                    2
                );
            }

            $purchase->updateTotal($total);

        //7. Persistir Purchase
            $this->purchaseRepository->update($purchase);

        //8. Commitear la transaccion
            $this->transactionManager->commit();

        } catch (Throwable $exception) {

            if ($this->transactionManager->inTransaction()) {
                $this->transactionManager->rollBack();
            }

            throw $exception;
        }
    }
}