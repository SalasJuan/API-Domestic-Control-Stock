<?php

namespace Src\Entity\PurchaseDetail\Exception;

use Src\Utils\Exception\InvalidDomainValueException;


final class InvalidPurchaseDetailPurchaseIdException extends InvalidDomainValueException
{
    public function __construct(int $purchase_id)
    {
        parent::__construct(
            "La id de la Compra debe Ser Valido. Ingresado: {$purchase_id}"
        );
    }
}