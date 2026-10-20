<?php

namespace Src\Entity\Lot\Exception;

use Src\Utils\Exception\InvalidDomainValueException;

final class InvalidLotExpirationDateException extends InvalidDomainValueException
{
    public function __construct()
    {
        parent::__construct(
            'No se pueden registrar lotes vencidos ni con vencimiento anterior a la fecha de compra.'
        );
    }
}