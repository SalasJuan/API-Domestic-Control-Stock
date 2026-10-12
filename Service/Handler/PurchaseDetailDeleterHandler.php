<?php

namespace Src\Service\Handler;

use RuntimeException;
use Throwable;

use Src\Infrastructure\PDO\PDOManager;

use Src\Service\Purchase\PurchaseFinderService;
use Src\Service\PurchaseDetail\PurchaseDetailDeleterService;

use Src\Infrastructure\Repository\Purchase\PurchaseRepository;
use Src\Infrastructure\Repository\PurchaseDetail\PurchaseDetailRepository;
use Src\Infrastructure\Repository\Lot\LotRepository;

final class PurchaseDetailDeleterHandler
{
    private PDOManager $transactionManager;

    private PurchaseDetailDeleterService $purchaseDetailDeleterService;
    private PurchaseFinderService $purchaseFinderService;

    private PurchaseDetailRepository $purchaseDetailRepository;
    private PurchaseRepository $purchaseRepository;
    private LotRepository $lotRepository;

    public function __construct()
    {
        $this->purchaseDetailDeleterService = new PurchaseDetailDeleterService();

        $this->purchaseFinderService = new PurchaseFinderService();

        $this->purchaseDetailRepository = new PurchaseDetailRepository();

        $this->purchaseRepository = new PurchaseRepository();

        $this->lotRepository =  new LotRepository();

        $this->transactionManager = new PDOManager();
    }

    public function delete(int $id): void
    {
        try {

            $this->transactionManager->beginTransaction();

        //1. Borrar lógicamente el PurchaseDetail
            $purchaseDetail =$this->purchaseDetailDeleterService->delete($id);

            $lot = $this->lotRepository->findByPurchaseDetail($id);
            if ($lot === null) {
                throw new RuntimeException(
                    "El PurchaseDetail no tiene un Lot asociado."
                );
            }

            $lot->delete();

            $this->lotRepository->update($lot);

        //2. Obtener la Purchase asociada
            $purchaseId = $purchaseDetail->purchase_id();

            if ($purchaseId === null) {
                throw new RuntimeException(
                    "El PurchaseDetail no tiene una Purchase asociada."
                );
            }

            $purchase = $this->purchaseFinderService->find($purchaseId);

            
        //3. Obtener los detalles activos
            $purchaseDetails =
            $this->purchaseDetailRepository->searchByPurchase($purchaseId);
            // searchByPurchase() excluye: deleted = 1

        //4. Recalcular el total
            $total = "0.00";

            foreach ($purchaseDetails as $detail) {

                $total = bcadd(
                    $total,
                    $detail->subtotal(),
                    2
                );
            }

        //5. Actualizar el total de Purchase
            $purchase->updateTotal($total);

            $this->purchaseRepository->update($purchase);

        //6. Commitear transaccion
            $this->transactionManager->commit();

        } catch (Throwable $exception) {

            if ($this->transactionManager->inTransaction()) {
                $this->transactionManager->rollBack();
            }

            throw $exception;
        }
    }
}