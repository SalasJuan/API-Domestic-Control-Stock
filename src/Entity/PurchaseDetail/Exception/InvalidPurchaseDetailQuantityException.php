<?php

namespace Src\Entity\PurchaseDetail\Exception;

use Src\Utils\Exception\InvalidDomainValueException;

final class InvalidPurchaseDetailQuantityException extends InvalidDomainValueException
{
    public function __construct(int $quantity)
    {
        parent::__construct(
            "La cantidad del detalle debe ser mayor a 0. Ingresado: {$quantity}"
        );
    }
}