<?php

namespace Src\Service\Handler;

use RuntimeException;
use Throwable;

use Src\Infrastructure\PDO\PDOManager;

use Src\Service\Purchase\PurchaseFinderService;
use Src\Service\PurchaseDetail\PurchaseDetailRestoreService;

use Src\Infrastructure\Repository\Purchase\PurchaseRepository;
use Src\Infrastructure\Repository\PurchaseDetail\PurchaseDetailRepository;
use Src\Infrastructure\Repository\Lot\LotRepository;

final class PurchaseDetailRestoreHandler
{
    private PurchaseDetailRestoreService $purchaseDetailRestoreService;

    private PurchaseFinderService $purchaseFinderService;

    private PurchaseDetailRepository $purchaseDetailRepository;

    private PurchaseRepository $purchaseRepository;

    private LotRepository $lotRepository;

    private PDOManager $transactionManager;

    public function __construct()
    {
        $this->purchaseDetailRestoreService = new PurchaseDetailRestoreService();

        $this->purchaseFinderService = new PurchaseFinderService();

        $this->purchaseDetailRepository = new PurchaseDetailRepository();

        $this->purchaseRepository = new PurchaseRepository();

        $this->lotRepository = new LotRepository();

        $this->transactionManager = new PDOManager();
    }

    public function restore(int $id): void
    {
        try {

        //1. Iniciar transacción
            $this->transactionManager->beginTransaction();

        //2. Restaurar PurchaseDetail
            $purchaseDetail = $this->purchaseDetailRestoreService->restore($id);

        //3. Obtener la Purchase asociada
            $purchaseId = $purchaseDetail->purchase_id();

            if ($purchaseId === null) {
                throw new RuntimeException(
                    "El PurchaseDetail no tiene una Purchase asociada."
                );
            }

        //4. Buscar el Lot Eliminado y Restaurarlo
            $lot = $this->lotRepository ->findDeletedByPurchaseDetail($id);
            if ($lot === null) {
                throw new RuntimeException(
                    "El PurchaseDetail no tiene un Lot eliminado asociado."
                );
            }

            $lot->restore(); $this->lotRepository ->update($lot);

        //5. Buscar Purchase del PurchaseDetail
            $purchase = $this->purchaseFinderService->find($purchaseId);

        //6. Obtener todos los detalles activos
            $purchaseDetails =
                $this->purchaseDetailRepository
                    ->searchByPurchase($purchaseId);

        //7. Recalcular total
            $total = "0.00";

            foreach ($purchaseDetails as $detail) {

                $total = bcadd(
                    $total,
                    $detail->subtotal(),
                    2
                );
            }

        //8. Actualizar total de Purchase
            $purchase->updateTotal($total);

            $this->purchaseRepository
                ->update($purchase);

        //9. Confirmar transacción
            $this->transactionManager->commit();

        } catch (Throwable $exception) {

            if ($this->transactionManager->inTransaction()) {
                $this->transactionManager->rollBack();
            }

            throw $exception;
        }
    }
}