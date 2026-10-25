<?php

namespace Src\Utils\Exception;

final class ControllerNotFoundException extends ApiException
{
    public function __construct(string $controller)
    {
        parent::__construct(
            "No se pudo resolver el controlador configurado: {$controller}",
            500
        );
    }
}