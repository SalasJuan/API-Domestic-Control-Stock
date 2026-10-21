<?php

namespace Src\Entity\Purchase\Exception;

use Src\Utils\Exception\InvalidDomainValueException;

final class InvalidPurchaseStoreException extends InvalidDomainValueException
{
    public function __construct()
    {
        parent::__construct("Nombre de Tienda no puede ser Vacio");
    }
}