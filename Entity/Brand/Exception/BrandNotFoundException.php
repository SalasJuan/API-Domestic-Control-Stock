<?php

namespace Src\Entity\Purchase\Exception;

use Src\Utils\Exception\ResourceNotFoundException;

final class BrandNotFoundException extends ResourceNotFoundException
{
    public function __construct(int $id)
    {
        parent::__construct(
            "No se encontro la Marca correspondiente. Id: ".$id
        );
    }
}