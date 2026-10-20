<?php

namespace Src\Entity\PurchaseDetail\Exception;

use Src\Utils\Exception\InvalidDomainValueException;


final class InvalidPurchaseDetailProductIdException extends InvalidDomainValueException
{
    public function __construct(int $product_id)
    {
        parent::__construct(
            "La id del Producto debe Ser Valido. Ingresado: {$product_id}"
        );
    }
}