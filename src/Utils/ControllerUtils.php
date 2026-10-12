<?php 

declare(strict_types = 1);

namespace Src\Utils;

use Exception;
use Src\Utils\Exception\BadRequestException;

final readonly class ControllerUtils {
    public static function getPost(string $name, bool $required = true, mixed $default = null): mixed 
    {
        $postData = self::getPostData();
        
        $value = $postData[$name] ?? null;

        if ($required && $value === null) {
            throw new BadRequestException(sprintf("Parameter %s not found", $name));
        } 

        return $value ?? $default;
    }

    private static function getPostData(): array
    {
        $json = file_get_contents('php://input');
        
        if (empty($json)) {
            return [];
        }
        
        $postData = json_decode($json, true);

        if ( json_last_error() !== JSON_ERROR_NONE || !is_array($postData)) 
            {
            throw new BadRequestException(
                'El cuerpo de la solicitud debe contener un JSON válido.'
            );
        }

        return $postData;
    }
}
