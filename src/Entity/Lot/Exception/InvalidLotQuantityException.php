<?php

namespace Src\Entity\Lot\Exception;

use Src\Utils\Exception\InvalidDomainValueException;

final class InvalidLotQuantityException extends InvalidDomainValueException
{
    public function __construct(int $quantity)
    {
        parent::__construct(
            "La cantidad del lote debe ser mayor a 0. Recibido: {$quantity}"
        );
    }
}