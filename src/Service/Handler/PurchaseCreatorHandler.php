<?php

namespace Src\Service\Handler;

use DateTimeImmutable;

use Throwable;
use Src\Utils\Exception\ValidationException;

use Src\Entity\PurchaseDetail\PurchaseDetail;

use Src\Infrastructure\PDO\PDOManager;

use Src\Service\Purchase\PurchaseCreatorService;
use Src\Service\PurchaseDetail\PurchaseDetailCreatorService;
use Src\Service\Lot\LotCreatorService;

final class PurchaseCreatorHandler
{
    private PurchaseCreatorService $purchaseCreatorService;

    private PurchaseDetailCreatorService $purchaseDetailCreatorService;

    private LotCreatorService $lotCreatorService;

    private PDOManager $transactionManager;

    public function __construct()
    {
        $this->purchaseCreatorService =
            new PurchaseCreatorService();

        $this->purchaseDetailCreatorService =
            new PurchaseDetailCreatorService();

        $this->lotCreatorService =
            new LotCreatorService();

        $this->transactionManager =
            new PDOManager();
    }

    public function create(DateTimeImmutable $date, string $store, array $details): int 
    {
        $this->validateDetails($details);

        // Primero creamos los PurchaseDetail en memoria.
        // Todavía no tienen purchase_id porque la Purchase
        // todavía no existe.
        // Cada PurchaseDetail calcula su propio subtotal.

        $purchaseDetails = [];

        $total = "0.00";

        foreach ($details as $detail) {

            $purchaseDetail = PurchaseDetail::create(
                $detail["product_id"],
                $detail["quantity"],
                (string) $detail["unit_price"]
            );

            $purchaseDetails[] = $purchaseDetail;

            // El Handler NO calcula el subtotal.
            // Utiliza el subtotal calculado por PurchaseDetail.
            $total = bcadd(
                $total,
                $purchaseDetail->subtotal(),
                2
            );
        }

        try {
        // BEGIN TRANSACTION

            $this->transactionManager->beginTransaction();

        // Crear Purchase

            $purchaseId =
                $this->purchaseCreatorService->create(
                    $date,
                    $store,
                    $total
                );

        // Asignar Purchase a cada Detail y Persistirlos

            foreach ($purchaseDetails as $index => $purchaseDetail) {

                //Ahora que conocemos el ID de Purchase
                // podemos asociarlo al PurchaseDetail

                $purchaseDetail->assignPurchase(
                    $purchaseId
                );

                //Persistir PurchaseDetail

                $purchaseDetailId =
                    $this->purchaseDetailCreatorService->create(
                        $purchaseDetail
                    );

                //Actualmente un Lot <- Viene de un Detail

                $detail = $details[$index];

                $this->lotCreatorService->create(
                    $purchaseDetailId,
                    $purchaseDetail->product_id(),
                    $purchaseDetail->quantity(),
                    $date,
                    new DateTimeImmutable(
                        $detail["expiration_date"]
                    )
                );
            }

        //---------------------------//
        //-Todo Salio Correctamente-//
        //--------------------------//
            $this->transactionManager->commit();

            return $purchaseId;

        } catch (Throwable $exception) {
        // Algo fallo

        //---------------------------//
            //-----Purchase-----//
            //-PurchaseDetails-//
            //------Lots------//
        //----Debe Deshacerse------//


            if ($this->transactionManager->inTransaction()) {
                $this->transactionManager->rollBack();
            }
            throw $exception;
        }
    }

    private function validateDetails(array $details): void
    {
        if (count($details) === 0) {
            throw new ValidationException("La compra debe contener al menos un detalle.");
        }

    foreach ($details as $detail) {
        if (!is_array($detail)) {
            throw new ValidationException('Cada detalle de compra debe ser un objeto.');
        }

        //-----------Validacion------------//
        //----- Estructura del Detail -----//
        //---------------------------------//

        if (!isset(
                $detail['product_id'],
                $detail['quantity'],
                $detail['unit_price'],
                $detail['expiration_date']
            )
        ) {
            throw new ValidationException('El detalle de compra está incompleto.');
        }

        //-----------Validacion-----------//
        //--------Formato (Datos)--------//
        //-------------------------------//

        if (
            filter_var(
                $detail['product_id'],
                FILTER_VALIDATE_INT
            ) === false
            || filter_var(
                $detail['quantity'],
                FILTER_VALIDATE_INT
            ) === false
            || !is_string($detail['expiration_date'])
            || trim($detail['expiration_date']) === ''
            || !is_scalar($detail['unit_price'])
        ) {
            throw new ValidationException(
                'Los datos del detalle de compra tienen un formato inválido.'
            );
        }
        }
    }
}