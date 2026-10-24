<?php

namespace Src\Entity\Purchase\Exception;

use Src\Utils\Exception\InvalidDomainValueException;

final class InvalidPurchaseTotalException extends InvalidDomainValueException
{
    public function __construct()
    {
        parent::__construct("El total debe ser un importe no negativo con hasta dos decimales");
    }
}