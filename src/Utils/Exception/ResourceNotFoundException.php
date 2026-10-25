<?php

namespace Src\Utils\Exception;

abstract class ResourceNotFoundException extends ApiException
{
    public function __construct(string $message)
    {
        parent::__construct($message, 404);
    }
}