<?php

namespace Src\Entity\Product\Exception;

use Src\Utils\Exception\InvalidDomainValueException;

final class InvalidProductCategoryIdException extends InvalidDomainValueException
{
    public function __construct()
    {
        parent::__construct("Category ID no puede ser Negativo");
    }
}