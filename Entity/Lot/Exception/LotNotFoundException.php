<?php

namespace Src\Entity\Purchase\Exception;

use Src\Utils\Exception\ResourceNotFoundException;

final class LotNotFoundException extends ResourceNotFoundException
{
    public function __construct(int $id)
    {
        parent::__construct(
            "No se encontro el Lote correspondiente. Id: ".$id
        );
    }
}