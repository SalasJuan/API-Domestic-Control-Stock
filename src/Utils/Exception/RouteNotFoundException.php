<?php

namespace Src\Utils\Exception;

final class RouteNotFoundException extends ApiException
{
    public function __construct(
        string $message = 'La ruta solicitada no existe.'
    ) {
        parent::__construct($message, 404);
    }
}