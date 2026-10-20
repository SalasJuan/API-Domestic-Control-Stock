<?php

namespace Src\Entity\PurchaseDetail\Exception;

use Src\Utils\Exception\InvalidDomainValueException;

final class InvalidPurchaseDetailUnitPriceException extends InvalidDomainValueException
{
    public function __construct()
    {
        parent::__construct(
            'El precio unitario debe ser un numero decimal valido y no negativo.'
        );
    }
}