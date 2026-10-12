<?php

namespace Src\Utils\Exception;

final class ValidationException extends ApiException
{
    public function __construct(
        string $message = 'Los datos enviados no cumplen las reglas de validación.'
    ) {
        parent::__construct($message, 422);
    }
}