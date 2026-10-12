<?php 

namespace Src\Entity\Product\Exception;

use Src\Utils\Exception\ResourceNotFoundException;

final class ProductNotFoundException extends ResourceNotFoundException 
{
    public function __construct(int $id) 
    {
        parent::__construct(
            "No se encontro el Producto correspondiente. Id: ".$id
        );
    }
}