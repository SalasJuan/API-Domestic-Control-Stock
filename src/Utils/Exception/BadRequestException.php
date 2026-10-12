<?php

namespace Src\Utils\Exception;

final class BadRequestException extends ApiException
{
    public function __construct(
        string $message = 'La solicitud no es válida.'
    ) {
        parent::__construct($message, 400);
    }
}