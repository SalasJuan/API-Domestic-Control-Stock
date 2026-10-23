<?php

namespace Src\Entity\Product\Exception;

use Src\Utils\Exception\InvalidDomainValueException;

final class InvalidProductNameException extends InvalidDomainValueException
{
    public function __construct()
    {
        parent::__construct("Nombre del Producto no puede ser Vacio");
    }
}