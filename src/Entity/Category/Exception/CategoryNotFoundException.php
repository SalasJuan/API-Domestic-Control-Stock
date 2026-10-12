<?php

namespace Src\Entity\Purchase\Exception;

use Src\Utils\Exception\ResourceNotFoundException;

final class CategoryNotFoundException extends ResourceNotFoundException
{
    public function __construct(int $id)
    {
        parent::__construct(
            "No se encontro la Categoría correspondiente. Id: ".$id
        );
    }
}