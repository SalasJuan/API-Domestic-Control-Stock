<?php

namespace Src\Entity\Purchase\Exception;

use Src\Utils\Exception\ResourceNotFoundException;

final class PurchaseNotFoundException extends ResourceNotFoundException
{
    public function __construct(int $id)
    {
        parent::__construct(
            "Purchase con ID {$id} no encontrado."
        );
    }
}