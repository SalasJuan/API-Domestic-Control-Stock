<?php

namespace Src\Entity\Purchase\Exception;

use DateTimeImmutable;
use Src\Utils\Exception\InvalidDomainValueException;

final class InvalidPurchaseDateException extends InvalidDomainValueException
{
    public function __construct(DateTimeImmutable $today, DateTimeImmutable $date)
    {
        parent::__construct(
            "La Fecha de compra no puede ser futura. " .
            "Fecha actual: {$today->format('Y-m-d')}. " .
            "Fecha recibida: {$date->format('Y-m-d')}.");
    }
}