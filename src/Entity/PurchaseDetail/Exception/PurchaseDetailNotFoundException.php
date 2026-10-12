<?php

namespace Src\Entity\PurchaseDetail\Exception;

use Src\Utils\Exception\ResourceNotFoundException;

final class PurchaseDetailNotFoundException extends ResourceNotFoundException
{
    public function __construct(int $id)
    {
        parent::__construct(
            "PurchaseDetail con ID {$id} no encontrado."
        );
    }
}