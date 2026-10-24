<?php

namespace Src\Entity\Product\Exception;

use Src\Utils\Exception\InvalidDomainValueException;

final class InvalidProductMinimumStockException extends InvalidDomainValueException
{
    public function __construct()
    {
        parent::__construct("El stock Minimo no puede ser Negativo");
    }
}