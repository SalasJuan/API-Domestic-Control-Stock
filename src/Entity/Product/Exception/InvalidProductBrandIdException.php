<?php

namespace Src\Entity\Product\Exception;

use Src\Utils\Exception\InvalidDomainValueException;

final class InvalidProductBrandIdException extends InvalidDomainValueException
{
    public function __construct()
    {
        parent::__construct("Brand ID no puede ser Negativo");
    }
}